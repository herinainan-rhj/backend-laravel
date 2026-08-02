<?php

namespace App\Mail;

use App\Models\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactMail extends Mailable
{
    use Queueable, SerializesModels;

    public $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }


    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Nouveau message client',
        );
    }


    public function content(): Content
    {
        return new Content(
            view: 'emails.contact',
        );
    }


    public function attachments(): array
    {
        return [];
    }
}
