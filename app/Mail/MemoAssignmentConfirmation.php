<?php

namespace App\Mail;

use App\Models\EmailCampaign;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MemoAssignmentConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $memo;
    public $assignee;
    public $assigner;
    public $assignmentMessage;

    /**
     * Create a new message instance.
     */
    public function __construct(EmailCampaign $memo, User $assignee, User $assigner, $assignmentMessage = null)
    {
        $this->memo = $memo;
        $this->assignee = $assignee;
        $this->assigner = $assigner;
        $this->assignmentMessage = $assignmentMessage;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '✅ Memo Assignment Confirmed: ' . $this->memo->subject,
            from: config('mail.from.address', 'cug@academicdigital.space'),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mails.memo-assignment-confirmation',
            with: [
                'memo' => $this->memo,
                'assignee' => $this->assignee,
                'assigner' => $this->assigner,
                'assignmentMessage' => $this->assignmentMessage,
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
        return [];
    }
}
