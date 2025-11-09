<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class WeeklyVisitorReport extends Mailable
{
    use Queueable, SerializesModels;

    public $stats;
    public $visitors;

    /**
     * Create a new message instance.
     */
    public function __construct(array $stats, $visitors)
    {
        $this->stats = $stats;
        $this->visitors = $visitors;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '📊 Weekly Visitor Report - ' . $this->stats['period_start'] . ' to ' . $this->stats['period_end'],
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.weekly-visitor-report',
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
