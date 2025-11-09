<?php

namespace App\Mail;

use App\Models\VisitorLog;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class VisitorVerified extends Mailable
{
    use Queueable, SerializesModels;

    public $visitor;

    /**
     * Create a new message instance.
     */
    public function __construct(VisitorLog $visitor)
    {
        $this->visitor = $visitor;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '✅ New Verified Visitor - ' . ($this->visitor->city ?? $this->visitor->country ?? 'Unknown Location'),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.visitor-verified',
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
