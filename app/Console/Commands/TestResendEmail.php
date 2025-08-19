<?php

namespace App\Console\Commands;

use App\Services\ResendMailService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Exception;

class TestResendEmail extends Command
{
    protected $signature = 'test:resend-email {email} {--with-attachment}';
    protected $description = 'Test Resend email integration with optional attachment';

    public function handle()
    {
        $email = $this->argument('email');
        $withAttachment = $this->option('with-attachment');

        $this->info("Testing Resend email integration...");
        $this->info("Sending to: {$email}");

        try {
            $resendService = new ResendMailService();
            
            // Prepare test attachments if requested
            $attachments = [];
            if ($withAttachment) {
                // Create a simple test file
                $testContent = "This is a test attachment from University Exams Archive System.\n\nGenerated on: " . now()->toDateTimeString();
                $tempFile = storage_path('app/temp_test_attachment.txt');
                file_put_contents($tempFile, $testContent);
                
                $attachments = [
                    [
                        'filename' => 'test_attachment.txt',
                        'content' => base64_encode($testContent),
                        'type' => 'text/plain',
                        'disposition' => 'attachment',
                    ]
                ];
                
                $this->info("✓ Test attachment prepared");
            }

            // Test email content
            $htmlContent = "
            <html>
                <body style='font-family: Arial, sans-serif; line-height: 1.6; color: #333;'>
                    <div style='max-width: 600px; margin: 0 auto; padding: 20px;'>
                        <h2 style='color: #007bff;'>🧪 Resend Integration Test</h2>
                        <p>Hello!</p>
                        <p>This is a test email from the <strong>University Exams Archive System</strong> to verify that Resend email integration is working correctly.</p>
                        <div style='background-color: #f8f9fa; padding: 15px; border-left: 4px solid #007bff; margin: 20px 0;'>
                            <p><strong>Test Details:</strong></p>
                            <ul>
                                <li>Email Service: Resend API</li>
                                <li>Sent at: " . now()->toDateTimeString() . "</li>
                                <li>Attachment: " . ($withAttachment ? 'Yes ✓' : 'No') . "</li>
                            </ul>
                        </div>
                        <p>If you received this email, the integration is working successfully!</p>
                        <hr style='border: none; border-top: 1px solid #dee2e6; margin: 30px 0;'>
                        <p style='font-size: 14px; color: #6c757d;'>
                            This is an automated test email. Please ignore this message.
                        </p>
                    </div>
                </body>
            </html>";

            // Send the email
            $result = $resendService->sendEmail(
                $email,
                '🧪 Resend Integration Test - ' . now()->format('Y-m-d H:i:s'),
                $htmlContent,
                null,
                $attachments
            );

            // Clean up temp file
            if ($withAttachment && file_exists($tempFile)) {
                unlink($tempFile);
            }

            if ($result['success']) {
                $this->info("✅ Email sent successfully!");
                $this->info("Message ID: " . ($result['message_id'] ?? 'N/A'));
                $this->info("Response: " . json_encode($result['response'], JSON_PRETTY_PRINT));
                
                $this->warn("📧 Please check the recipient's inbox (and spam folder) to confirm delivery.");
                
                if ($withAttachment) {
                    $this->info("📎 Test attachment should be included in the email.");
                }
            } else {
                $this->error("❌ Failed to send email!");
                $this->error("Error: " . $result['error']);
                return 1;
            }

        } catch (Exception $e) {
            $this->error("❌ Exception occurred: " . $e->getMessage());
            Log::error("Test email command failed", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return 1;
        }

        return 0;
    }
}