<?php

namespace App\Services;

use Resend\Laravel\Facades\Resend;
use Illuminate\Support\Facades\Log;
use Exception;
use Illuminate\Support\Str;

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
                'id' => $this->generateResendId(), // Generate unique UUID for Resend
                'from' => $from,
                'to' => [$to],
                'subject' => $subject,
                'html' => $htmlContent,
            ];

            // Add attachments if any - Resend expects specific format
            if (!empty($attachments)) {
                $validAttachments = [];
                Log::info("Processing attachments in sendEmail", [
                    'attachments_count' => count($attachments),
                    'attachment_types' => array_column($attachments, 'type')
                ]);
                
                foreach ($attachments as $attachment) {
                    try {
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
                        
                        Log::info("Attachment validated successfully", [
                            'filename' => $attachment['filename'],
                            'type' => $attachment['type'] ?? 'application/octet-stream',
                            'content_length' => strlen($content)
                        ]);
                    } catch (Exception $e) {
                        Log::error("Error processing attachment in sendEmail", [
                            'attachment' => $attachment,
                            'error' => $e->getMessage()
                        ]);
                    }
                }
                
                if (!empty($validAttachments)) {
                    $params['attachments'] = $validAttachments;
                    Log::info("Attachments added to email params", [
                        'valid_attachments_count' => count($validAttachments)
                    ]);
                } else {
                    Log::warning("No valid attachments found after processing");
                }
            } else {
                Log::info("No attachments to process in sendEmail");
            }

            Log::info('Sending email via Resend API', [
                'to' => $to,
                'subject' => $subject,
                'attachments_count' => count($params['attachments'] ?? []),
                'params' => array_merge($params, ['html' => '[HTML_CONTENT_OMITTED]'])
            ]);

            // Test if Resend facade is working
            if (!class_exists('Resend\Laravel\Facades\Resend')) {
                throw new Exception('Resend facade not found. Package may not be installed correctly.');
            }
            
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
            
            // Check if it's a UUID validation error and retry
            if (strpos($errorMessage, 'must be a valid UUID') !== false && $retryCount < 3) {
                Log::warning('UUID validation error, retrying with new UUID...', [
                    'to' => $to,
                    'retry_count' => $retryCount + 1
                ]);
                
                // Retry the email (will generate new UUID)
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
                'id' => $this->generateResendId(), // Generate unique UUID for Resend
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
                if ($campaign->attachments && is_array($campaign->attachments)) {
                    Log::info("Processing attachments for campaign {$campaign->id}", [
                        'attachments_count' => count($campaign->attachments),
                        'attachments' => $campaign->attachments
                    ]);
                    
                    foreach ($campaign->attachments as $attachment) {
                        try {
                            // Validate attachment structure
                            if (!isset($attachment['path']) || !isset($attachment['name'])) {
                                Log::warning("Invalid attachment structure", $attachment);
                                continue;
                            }
                            
                            $filePath = storage_path('app/public/' . $attachment['path']);
                            Log::info("Processing attachment file", [
                                'file_path' => $filePath,
                                'attachment_data' => $attachment
                            ]);
                            
                            if (file_exists($filePath)) {
                                $fileContent = file_get_contents($filePath);
                                if ($fileContent !== false) {
                                    $attachments[] = [
                                        'filename' => $attachment['name'],
                                        'content' => base64_encode($fileContent),
                                        'type' => $attachment['type'] ?? mime_content_type($filePath),
                                    ];
                                    
                                    Log::info("Attachment prepared successfully", [
                                        'filename' => $attachment['name'],
                                        'size' => strlen($fileContent),
                                        'type' => $attachment['type'] ?? mime_content_type($filePath)
                                    ]);
                                } else {
                                    Log::error("Failed to read file content", ['file_path' => $filePath]);
                                }
                            } else {
                                Log::error("Attachment file not found", [
                                    'file_path' => $filePath,
                                    'attachment' => $attachment
                                ]);
                            }
                        } catch (Exception $e) {
                            Log::error("Error processing attachment", [
                                'attachment' => $attachment,
                                'error' => $e->getMessage()
                            ]);
                        }
                    }
                } else {
                    Log::info("No attachments to process for campaign {$campaign->id}");
                }

                // Send email with unique ID for each recipient
                Log::info("Sending email to recipient", [
                    'email' => $recipient->email,
                    'attachments_count' => count($attachments),
                    'has_attachments' => !empty($attachments)
                ]);
                
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

    /**
     * Generate a valid UUID for Resend API
     */
    private function generateResendId()
    {
        return Str::uuid()->toString();
    }

    /**
     * Validate UUID format
     */
    private function isValidUuid($uuid)
    {
        return Str::isUuid($uuid);
    }
}
