<?php

namespace App\Jobs;

use App\Mail\CampaignEmail;
use App\Models\EmailCampaign;
use App\Models\EmailCampaignRecipient;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Exception;

class SendCampaignEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $campaign;
    public $timeout = 3600; // 1 hour timeout
    public $tries = 3;

    /**
     * Create a new job instance.
     */
    public function __construct(EmailCampaign $campaign)
    {
        $this->campaign = $campaign;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            // Update campaign status
            $this->campaign->update(['status' => 'sending']);

            $recipients = $this->campaign->recipients()
                                       ->where('status', 'pending')
                                       ->with('user')
                                       ->get();

            $sentCount = 0;
            $failedCount = 0;

            foreach ($recipients as $recipient) {
                try {
                    // Skip if user is not approved
                    if (!$recipient->user->is_approve) {
                        $recipient->markAsFailed('User account not approved');
                        $failedCount++;
                        continue;
                    }

                    // Send the email
                    Mail::to($recipient->user->email)
                        ->send(new CampaignEmail($this->campaign, $recipient->user));

                    // Mark as sent
                    $recipient->markAsSent();
                    $sentCount++;

                    // Add small delay to prevent overwhelming the mail server
                    usleep(100000); // 0.1 second delay

                } catch (Exception $e) {
                    Log::error("Failed to send campaign email to user {$recipient->user->id}: " . $e->getMessage());
                    
                    $recipient->markAsFailed($e->getMessage());
                    $failedCount++;
                }
            }

            // Update campaign final status and counts
            $this->campaign->update([
                'status' => 'sent',
                'sent_at' => now(),
                'sent_count' => $sentCount,
                'failed_count' => $failedCount,
            ]);

            Log::info("Campaign {$this->campaign->id} completed. Sent: {$sentCount}, Failed: {$failedCount}");

        } catch (Exception $e) {
            Log::error("Campaign {$this->campaign->id} failed: " . $e->getMessage());
            
            // Mark campaign as failed
            $this->campaign->update([
                'status' => 'failed',
            ]);

            throw $e;
        }
    }

    /**
     * Handle a job failure.
     */
    public function failed(Exception $exception): void
    {
        Log::error("Campaign email job failed for campaign {$this->campaign->id}: " . $exception->getMessage());
        
        $this->campaign->update([
            'status' => 'failed',
        ]);
    }

    /**
     * Get the tags that should be assigned to the job.
     */
    public function tags(): array
    {
        return ['email-campaign', 'campaign:' . $this->campaign->id];
    }
}