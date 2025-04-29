<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class PagguePaymentService
{
    public function gerarPagamento(array $dados)
    {
        try {
            \Log::info('Enviando dados para pagamento Paggue:', $dados);

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . config('services.paggue.access_token'),
                'X-Company-ID' => config('services.paggue.company_id'),
                'Content-Type' => 'application/json',
            ])->post('https://ms.paggue.io/v1/payments', $dados);

            \Log::info('Resposta da Paggue:', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            if ($response->failed()) {
                throw new \Exception('Erro ao gerar pagamento: ' . $response->body());
            }

            return $response->json();
        } catch (\Exception $e) {
            \Log::error('Erro ao gerar pagamento na Paggue', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            throw $e;
        }
    }
}