<?php

namespace App\Services;

use Resend\Laravel\Facades\Resend;
use Illuminate\Support\Facades\Log;
use Exception;

class ResendMailService
{
    protected $apiKey;
    protected $domain;

    public function __construct()
    {
        // API key is automatically handled by Resend facade
        // Domain is used for logging purposes only
        $this->domain = config('services.resend.domain', 'academicdigital.space');
    }

    /**
     * Send a simple email using Resend with retry logic for rate limits
     */
    public function sendEmail($to, $subject, $htmlContent, $from = null, $attachments = [], $retryCount = 0)
    {
        try {
            $from = $from ?: config('mail.from.address');
            
            // Validate from address format for Resend
            if (!str_contains($from, '@')) {
                throw new Exception("Invalid from address: {$from}");
            }
            
            $params = [
                'from' => $from,
                'to' => [$to],
                'subject' => $subject,
                'html' => $htmlContent,
            ];

            // Add attachments if any - Resend expects specific format
            if (!empty($attachments)) {
                $validAttachments = [];
                foreach ($attachments as $attachment) {
                    // Validate attachment structure
                    if (!isset($attachment['filename']) || !isset($attachment['content'])) {
                        Log::warning('Invalid attachment structure', $attachment);
                        continue;
                    }
                    
                    // Ensure content is base64 encoded
                    $content = $attachment['content'];
                    if (!base64_decode($content, true)) {
                        // If not base64, encode it
                        $content = base64_encode($content);
                    }
                    
                    $validAttachments[] = [
                        'filename' => $attachment['filename'],
                        'content' => $content,
                        'type' => $attachment['type'] ?? 'application/octet-stream',
                    ];
                }
                
                if (!empty($validAttachments)) {
                    $params['attachments'] = $validAttachments;
                }
            }

            Log::info('Sending email via Resend API', [
                'to' => $to,
                'subject' => $subject,
                'attachments_count' => count($params['attachments'] ?? []),
                'params' => array_merge($params, ['html' => '[HTML_CONTENT_OMITTED]'])
            ]);

            $response = Resend::emails()->create($params);
            
            Log::info('Email sent successfully via Resend', [
                'to' => $to,
                'subject' => $subject,
                'response_id' => $response->id ?? null,
                'attachments_count' => count($attachments),
                'response' => $response
            ]);

            return [
                'success' => true,
                'message_id' => $response->id ?? null,
                'response' => $response
            ];

        } catch (Exception $e) {
            $errorMessage = $e->getMessage();
            
            // Check if it's a rate limit error and retry
            if (strpos($errorMessage, '450 Too many requests') !== false && $retryCount < 3) {
                Log::warning('Rate limit hit, retrying in 1 second...', [
                    'to' => $to,
                    'retry_count' => $retryCount + 1
                ]);
                
                // Wait 1 second before retry
                sleep(1);
                
                // Retry the email
                return $this->sendEmail($to, $subject, $htmlContent, $from, $attachments, $retryCount + 1);
            }
            
            Log::error('Failed to send email via Resend', [
                'to' => $to,
                'subject' => $subject,
                'error' => $errorMessage,
                'trace' => $e->getTraceAsString(),
                'attachments_count' => count($attachments),
                'retry_count' => $retryCount
            ]);

            return [
                'success' => false,
                'error' => $errorMessage
            ];
        }
    }

    /**
     * Send email using Resend template
     */
    public function sendTemplateEmail($to, $templateId, $templateData, $from = null)
    {
        try {
            $from = $from ?: config('mail.from.address');
            
            $params = [
                'from' => $from,
                'to' => [$to],
                'template' => $templateId,
                'data' => $templateData,
            ];

            $response = Resend::emails()->create($params);
            
            Log::info('Template email sent successfully via Resend', [
                'to' => $to,
                'template_id' => $templateId,
                'response_id' => $response->id ?? null
            ]);

            return [
                'success' => true,
                'message_id' => $response->id ?? null,
                'response' => $response
            ];

        } catch (Exception $e) {
            Log::error('Failed to send template email via Resend', [
                'to' => $to,
                'template_id' => $templateId,
                'error' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Send bulk emails
     */
    public function sendBulkEmails($recipients, $subject, $htmlContent, $from = null)
    {
        $results = [];
        
        foreach ($recipients as $recipient) {
            $result = $this->sendEmail($recipient, $subject, $htmlContent, $from);
            $results[] = [
                'recipient' => $recipient,
                'result' => $result
            ];
            
            // Smart rate limiting for Resend (2 requests per second)
            $requestCount++;
            $elapsedTime = microtime(true) - $startTime;
            $expectedTime = $requestCount * 0.5; // 0.5 seconds per request
            
            if ($elapsedTime < $expectedTime) {
                $sleepTime = ($expectedTime - $elapsedTime) * 1000000; // Convert to microseconds
                usleep((int)$sleepTime);
            }
            
            // Ensure minimum delay between requests
            usleep(500000); // 0.5 second minimum
        }

        return $results;
    }

    /**
     * Send campaign emails with better error handling and rate limiting
     */
    public function sendCampaignEmails($campaign, $recipients, $from = null)
    {
        $results = [];
        $from = $from ?: config('mail.from.address');
        $requestCount = 0;
        $startTime = microtime(true);
        
        $totalRecipients = count($recipients);
        Log::info("Starting campaign email send to {$totalRecipients} recipients");
        
        foreach ($recipients as $index => $recipient) {
            try {
                Log::info("Processing recipient " . ($index + 1) . "/{$totalRecipients}: {$recipient->email}");
                
                // Generate HTML content for each recipient
                $htmlContent = view('mails.campaign', [
                    'campaign' => $campaign,
                    'user' => $recipient,
                    'subject' => $campaign->subject,
                    'message' => $campaign->message,
                ])->render();

                // Prepare attachments for Resend API
                $attachments = [];
                if ($campaign->attachments) {
                    foreach ($campaign->attachments as $attachment) {
                        $filePath = storage_path('app/public/' . $attachment['path']);
                        if (file_exists($filePath)) {
                            $fileContent = file_get_contents($filePath);
                            $attachments[] = [
                                'filename' => $attachment['name'],
                                'content' => base64_encode($fileContent),
                                'type' => $attachment['type'] ?? mime_content_type($filePath),
                                'disposition' => 'attachment',
                            ];
                        } else {
                            Log::warning("Attachment file not found: {$filePath}");
                        }
                    }
                }

                // Send email
                $result = $this->sendEmail(
                    $recipient->email,
                    $campaign->subject,
                    $htmlContent,
                    $from,
                    $attachments
                );

                $results[] = [
                    'recipient' => $recipient,
                    'result' => $result,
                    'email' => $recipient->email,
                    'user_id' => $recipient->id
                ];

                // Smart rate limiting for Resend (2 requests per second)
                $requestCount++;
                $elapsedTime = microtime(true) - $startTime;
                $expectedTime = $requestCount * 0.5; // 0.5 seconds per request
                
                if ($elapsedTime < $expectedTime) {
                    $sleepTime = ($expectedTime - $elapsedTime) * 1000000; // Convert to microseconds
                    usleep((int)$sleepTime);
                }
                
                // Ensure minimum delay between requests
                usleep(500000); // 0.5 second minimum

            } catch (Exception $e) {
                $results[] = [
                    'recipient' => $recipient,
                    'result' => [
                        'success' => false,
                        'error' => $e->getMessage()
                    ],
                    'email' => $recipient->email,
                    'user_id' => $recipient->id
                ];

                Log::error("Failed to send campaign email to user {$recipient->id}", [
                    'campaign_id' => $campaign->id,
                    'error' => $e->getMessage()
                ]);
            }
        }

        return $results;
    }

    /**
     * Verify email address (simplified for restricted API keys)
     */
    public function verifyEmail($email)
    {
        try {
            // For restricted API keys, we'll just validate the email format
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return [
                    'success' => true,
                    'verified' => true,
                    'message' => 'Email format is valid'
                ];
            } else {
                return [
                    'success' => false,
                    'verified' => false,
                    'error' => 'Invalid email format'
                ];
            }
        } catch (Exception $e) {
            return [
                'success' => false,
                'verified' => false,
                'error' => $e->getMessage()
            ];
        }
    }
}
