<?php

namespace App\Mail;

use App\Models\EmailCampaign;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class CampaignEmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $campaign;
    public $user;

    /**
     * Create a new message instance.
     */
    public function __construct(EmailCampaign $campaign, User $user)
    {
        $this->campaign = $campaign;
        $this->user = $user;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->campaign->subject,
            from: config('mail.from.address', 'cug@academicdigital.space'),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'mails.campaign',
            with: [
                'title' => $this->campaign->subject,
                'message' => $this->campaign->message,
                'user' => $this->user,
                'campaign' => $this->campaign,
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        $attachments = [];

        if ($this->campaign->attachments) {
            foreach ($this->campaign->attachments as $attachment) {
                $filePath = storage_path('app/public/' . $attachment['path']);
                
                if (file_exists($filePath)) {
                    $attachments[] = Attachment::fromPath($filePath)
                                               ->as($attachment['name'])
                                               ->withMime($attachment['type']);
                }
            }
        }

        return $attachments;
    }

    /**
     * Get the tags for the message.
     */
    public function tags(): array
    {
        return ['campaign', 'campaign-' . $this->campaign->id];
    }

    /**
     * Set the priority of the message.
     */
    public function priority(): int
    {
        return 3; // Normal priority
    }
}