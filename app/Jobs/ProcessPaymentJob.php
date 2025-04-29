<?php

namespace App\Jobs;

use App\Models\Payment;
use App\Services\PagguePaymentService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\PaymentEmail;
use App\Models\User;

class ProcessPaymentJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public int $paymentId) {}

   public function handle(PagguePaymentService $paggue)
    {
        $payment = Payment::find($this->paymentId);

        if (!$payment || $payment->status !== 'pendente') {
            return;
        }

        \Log::info("Processando pagamento ID: {$this->paymentId}");

        $payload = [
            'amount' => (int) round($payment->amount * 100),
            'external_id' => $payment->transaction_id,
            'description' => $payment->description ?? 'Pagamento automático via job Laravel',
            'payer_name' => $payment->payer_name ?? 'Cliente não informado',
            'expires_in' => 3600,
        ];

        $resposta = $paggue->gerarPagamento($payload);

        if (isset($resposta['barcode']) && isset($resposta['payment_url'])) {
            $payment->update([
                'status' => 'confirmado',
                'barcode' => $resposta['barcode'],
                'payment_url' => $resposta['payment_url'],
            ]);

            // Enviar e-mail para o comprador
            $user = $payment->user;
            if ($user && $user->email) {
                Mail::to($user->email)->queue(new PaymentEmail($payment));
            }

            // Enviar e-mail para todos os administradores
            $admins = User::role('admin')->get();
            foreach ($admins as $admin) {
                Mail::to($admin->email)->queue(new PaymentEmail($payment));
            }

        } else {
            $payment->update(['status' => 'falha']);
        }
    }
}