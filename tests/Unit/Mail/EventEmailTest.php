<?php

namespace Tests\Unit\Mail;

use Tests\TestCase;
use App\Mail\EventEmail;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Queue;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;

class EventEmailTest extends TestCase
{
    public function test_event_email_builds_correctly()
    {
        $event = (object)[
            'title' => 'Show de Talentos 2025',
            'description' => 'Um evento incrível para toda a família!',
            'date' => now()->addDays(10),
        ];

        $mailable = new EventEmail($event);
        $mailable->build();

        $this->assertEquals('Novo Evento Criado: ' . $event->title, $mailable->subject);
        $this->assertEquals('emails.event_created', $mailable->view);
        $this->assertEquals('emails.event_created_plain', $mailable->textView);

        $this->assertEquals($event, $mailable->event);
    }
}
