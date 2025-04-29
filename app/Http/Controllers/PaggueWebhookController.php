<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class PaggueWebhookController extends Controller
{
    public function handle(Request $request)
    {
        $payload = $request->getContent();
        $signature = $request->header('X-Paggue-Signature');
        $secret = config('services.paggue.webhook_secret'); 

        // Validar assinatura
        $expectedSignature = hash_hmac('sha256', $payload, $secret);

        if (!hash_equals($expectedSignature, $signature)) {
            Log::warning('Assinatura inválida no webhook da Paggue');
            return response()->json(['message' => 'Assinatura inválida'], 403);
        }

        $data = $request->json()->all();
        Log::info('Webhook recebido da Paggue:', $data);

        // Exemplo: atualizar status do pagamento
        $payment = DB::table('payments')->where('transaction_id', $data['id'])->first();

        if ($payment) {
            DB::table('payments')->where('id', $payment->id)->update([
                'status' => $data['status'], // status vindo da Paggue: 'confirmado', 'recusado', etc.
                'updated_at' => now()
            ]);
        }

        return response()->json(['message' => 'Webhook processado com sucesso']);
    }
}
