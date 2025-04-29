<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class PaggueAuthService
{
    public function authenticate()
    {
        $response = Http::post(env('PAGGUE_BASE_URL') . '/auth/v1/token', [
            'client_key' => env('PAGGUE_CLIENT_KEY'),
            'client_secret' => env('PAGGUE_CLIENT_SECRET'),
        ]);

        if ($response->failed()) {
            throw new \Exception('Falha ao autenticar com a API da Paggue');
        }

        return $response->json();
    }
}
