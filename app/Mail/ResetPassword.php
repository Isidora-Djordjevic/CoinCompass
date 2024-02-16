<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ResetPassword extends Mailable
{
    use Queueable, SerializesModels;

    public $resetLink;
    /**
     * Create a new message instance.
     * @param string $resetLink
     */
    public function __construct($resetLink)
    {
        $this->resetLink = $resetLink;
    }

    public function markdown()
    {
        return 'emails.reset-password';
    }
    
    /**
     * Build the message.
     *
     * @return $this
     */ 
    /**
     * Get the message envelope.
     */

     /**
     * Get the body of the message.
     *
     * @return string
     */
    public function build()
    {
        return $this
            ->view('emails.reset-password')
            ->subject('Resetovanje lozinke');
    }

    protected function getContent()
    {
        return $this->buildMarkdown()['html'] ?? '';
    }

    /**
     * Get the plain text part of the message.
     *
     * @return string
     */
    protected function getPlainText()
    {
        return $this->buildMarkdown()['text'] ?? '';
    }

    /**
     * Get the HTML part of the message.
     *
     * @return string
     */
    protected function getHtml()
    {
        return $this->buildMarkdown()['html'] ?? '';
    }

    /**
     * Get the array representation of the message.
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'subject' => $this->buildView()['subject'],
            'html' => $this->buildView()['html'],
        ];
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Reset Password',
        );
    }

    
    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'view.name',
        );
    }

}
