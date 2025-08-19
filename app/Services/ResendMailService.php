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
        $this->apiKey = config('services.resend.api_key');
        $this->domain = config('services.resend.domain');
    }

    /**
     * Send a simple email using Resend
     */
    public function sendEmail($to, $subject, $htmlContent, $from = null, $attachments = [])
    {
        try {
            $from = $from ?: config('mail.from.address');
            
            $params = [
                'from' => $from,
                'to' => [$to],
                'subject' => $subject,
                'html' => $htmlContent,
            ];

            // Add attachments if any
            if (!empty($attachments)) {
                $params['attachments'] = $attachments;
            }

            $response = Resend::emails()->create($params);
            
            Log::info('Email sent successfully via Resend', [
                'to' => $to,
                'subject' => $subject,
                'response_id' => $response->id ?? null
            ]);

            return [
                'success' => true,
                'message_id' => $response->id ?? null,
                'response' => $response
            ];

        } catch (Exception $e) {
            Log::error('Failed to send email via Resend', [
                'to' => $to,
                'subject' => $subject,
                'error' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'error' => $e->getMessage()
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
            
            // Small delay to prevent rate limiting
            usleep(100000); // 0.1 second
        }

        return $results;
    }

    /**
     * Verify email address
     */
    public function verifyEmail($email)
    {
        try {
            $response = Resend::domains()->verify($this->domain);
            return [
                'success' => true,
                'verified' => true,
                'response' => $response
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'verified' => false,
                'error' => $e->getMessage()
            ];
        }
    }
}
