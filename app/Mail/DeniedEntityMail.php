<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DeniedEntityMail extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $reason;

    /**
     * Create a new message instance.
     *
     * @param mixed $entity  The entity being denied (for example, a Company model)
     * @param string $reason The final composed reason for denial
     */
    public function __construct($name, $reason)
    {
        $this->name = $name;
        $this->reason = $reason;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): \Illuminate\Mail\Mailables\Envelope
    {
        return new \Illuminate\Mail\Mailables\Envelope(
            subject: 'Registration Denied - TEL-A'
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): \Illuminate\Mail\Mailables\Content
    {
        return new \Illuminate\Mail\Mailables\Content(
            view: 'mail.denied'
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
