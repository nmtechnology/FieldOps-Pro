<?php

namespace App\Mail;

use App\Models\VisitorLog;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class VisitorFailedVerification extends Mailable
{
    use Queueable, SerializesModels;

    public $visitor;
    public $attempts;

    /**
     * Create a new message instance.
     */
    public function __construct(VisitorLog $visitor, int $attempts)
    {
        $this->visitor = $visitor;
        $this->attempts = $attempts;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '❌ Failed Verification Attempt - ' . ($this->visitor->city ?? $this->visitor->country ?? 'Unknown Location'),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.visitor-failed-verification',
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
