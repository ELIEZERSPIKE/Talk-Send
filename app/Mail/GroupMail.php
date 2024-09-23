<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;

class GroupMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $group; // Variable pour stocker le groupe
    protected $password; // Variable pour stocker le mot de passe

    /**
     * Create a new message instance.
     *
     * @param $group
     * @param $password
     */
    public function __construct($group)
    {
        $this->group = $group; 
       
    }

    /**
     * Get the message envelope.
     */
    public function build()
    {
        return $this->from('accounts@unetah.net', 'Message de Eliezer')
                    ->subject('Invitation à rejoindre un groupe')
                    ->view('mails.invitation')
                    ->with([
                        'groupName' => $this->group->name,
                     
                    ]);
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mails.invitation',
            with: [
                'groupName' => $this->group->name,
                
            ],
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
