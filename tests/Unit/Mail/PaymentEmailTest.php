<?php

namespace Tests\Unit\Mail;

use Tests\TestCase;
use App\Mail\PaymentEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class PaymentEmailTest extends TestCase
{
    public function test_payment_email_builds_correctly()
    {
        $payment = (object)[
            'transaction_id' => 'fake-tx-uuid',
            'amount' => 150.00,
            'user_id' => 1,
            'status' => 'confirmado',
            'barcode' => '1234567890',
        ];

        $mailable = new PaymentEmail($payment);
        $mailable->build();

        // Verificando o assunto do e-mail
        $this->assertEquals('Pagamento Confirmado: ' . $payment->transaction_id, $mailable->subject);

        // Verificando a view HTML e texto simples
        $this->assertEquals('emails.payment_confirmed', $mailable->view);
        $this->assertEquals('emails.payment_confirmed_plain', $mailable->textView);

        // Verificando se o pagamento foi passado corretamente
        $this->assertEquals($payment, $mailable->payment);
    }

    public function test_payment_email_renders_correctly()
    {
        $payment = (object)[
            'transaction_id' => 'fake-tx-uuid',
            'amount' => 150.00,
            'user_id' => 1,
            'status' => 'confirmado',
            'barcode' => '1234567890',
        ];

        $mailable = new PaymentEmail($payment);

        // Renderizando o conteúdo HTML do e-mail
        $renderedHtml = $mailable->render();

        $this->assertStringContainsString('Pagamento Confirmado', $renderedHtml);
        $this->assertStringContainsString($payment->transaction_id, $renderedHtml);
        $this->assertStringContainsString((string)$payment->amount, $renderedHtml);
    }
}