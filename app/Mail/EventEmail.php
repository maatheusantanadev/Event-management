<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use MailerSend\LaravelDriver\MailerSendTrait;

class EventEmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels, MailerSendTrait;

    public $event;

    /**
     * Cria uma nova instância do e-mail com o evento.
     */
    public function __construct($event)
    {
        $this->event = $event;
    }

    /**
     * Constrói o e-mail.
     */
    public function build()
    {
        return $this->subject('Novo Evento Criado: ' . $this->event->title)
            ->view('emails.event_created') // HTML
            ->text('emails.event_created_plain'); // Texto simples
    }
}