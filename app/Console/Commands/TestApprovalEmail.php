<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Services\ResendMailService;
use Illuminate\Support\Str;

class TestApprovalEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:approval-email {email}';

    /**
     * The console description of the console command.
     *
     * @var string
     */
    protected $description = 'Test the approval email functionality for a specific user email';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        
        $this->line("Testing approval email functionality for: {$email}");
        $this->line("========================================");
        
        // Find user
        $user = User::where('email', $email)->first();
        if (!$user) {
            $this->error("User with email {$email} not found!");
            return 1;
        }
        
        $this->info("User found: {$user->first_name} {$user->last_name}");
        $this->line("Current approval status: " . ($user->is_approve ? 'Approved' : 'Not Approved'));
        $this->line("Password changed: " . ($user->password_changed ? 'Yes' : 'No'));
        
        // Test mail configuration
        $this->line("\nChecking mail configuration...");
        $this->line("MAIL_MAILER: " . env('MAIL_MAILER'));
        $this->line("MAIL_HOST: " . env('MAIL_HOST'));
        $this->line("MAIL_FROM_ADDRESS: " . config('mail.from.address'));
        
        // Generate temporary password for testing
        $temporaryPassword = Str::random(10);
        $this->line("\nGenerated temporary password: {$temporaryPassword}");
        
        // Test email sending
        if (env('MAIL_MAILER') == 'resend') {
            $this->line("\nTesting ResendMailService...");
            
            try {
                $resendService = new ResendMailService();
                
                $htmlContent = view('mails.approval', [
                    'firstname' => $user->first_name,
                    'email' => $user->email,
                    'temporaryPassword' => $temporaryPassword
                ])->render();
                
                $response = $resendService->sendEmail(
                    $user->email,
                    'TEST - Account Successfully Approved - Your Login Credentials',
                    $htmlContent,
                    'cug@academicdigital.space'
                );
                
                if ($response['success']) {
                    $this->info("✅ Test email sent successfully!");
                    $this->line("Message ID: " . ($response['message_id'] ?? 'N/A'));
                } else {
                    $this->error("❌ Failed to send test email");
                    $this->line("Error: " . ($response['error'] ?? 'Unknown error'));
                    $this->line("Full response: " . json_encode($response, JSON_PRETTY_PRINT));
                }
                
            } catch (\Exception $e) {
                $this->error("❌ Exception occurred while testing email:");
                $this->line("Error: " . $e->getMessage());
                $this->line("File: " . $e->getFile() . ":" . $e->getLine());
            }
        } else {
            $this->error("MAIL_MAILER is not set to 'resend'. Current value: " . env('MAIL_MAILER'));
        }
        
        $this->line("\nTest completed!");
        return 0;
    }
}
