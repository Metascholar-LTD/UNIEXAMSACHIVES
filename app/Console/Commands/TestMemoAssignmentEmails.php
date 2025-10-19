<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Mail\MemoAssignmentNotification;
use App\Mail\MemoAssignmentConfirmation;
use App\Models\EmailCampaign;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class TestMemoAssignmentEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:memo-assignment-emails {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test memo assignment email notifications';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        
        // Find a user with the provided email
        $user = User::where('email', $email)->first();
        
        if (!$user) {
            $this->error("User with email {$email} not found.");
            return 1;
        }

        // Find a sample memo (or create a mock one)
        $memo = EmailCampaign::where('memo_status', '!=', null)->first();
        
        if (!$memo) {
            $this->error("No memos found in the system. Please create a memo first.");
            return 1;
        }

        // Find another user to act as assigner
        $assigner = User::where('id', '!=', $user->id)->first();
        
        if (!$assigner) {
            $this->error("No other users found to act as assigner.");
            return 1;
        }

        $this->info("Testing memo assignment emails...");
        $this->info("Assignee: {$user->first_name} {$user->last_name} ({$user->email})");
        $this->info("Assigner: {$assigner->first_name} {$assigner->last_name} ({$assigner->email})");
        $this->info("Memo: {$memo->subject}");

        try {
            // Test assignment notification email
            $this->info("Sending assignment notification email...");
            Mail::to($user->email)->send(new MemoAssignmentNotification(
                $memo,
                $user,
                $assigner,
                "This is a test assignment message. Please review the memo and take necessary action."
            ));

            // Test confirmation email
            $this->info("Sending assignment confirmation email...");
            Mail::to($assigner->email)->send(new MemoAssignmentConfirmation(
                $memo,
                $user,
                $assigner,
                "This is a test assignment message. Please review the memo and take necessary action."
            ));

            $this->info("✅ Both emails sent successfully!");
            $this->info("Check the email inboxes for the test emails.");

        } catch (\Exception $e) {
            $this->error("❌ Failed to send emails: " . $e->getMessage());
            return 1;
        }

        return 0;
    }
}
