<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use Illuminate\Support\Facades\Http;
use App\Services\PagguePaymentService;

class PagguePaymentServiceTest extends TestCase
{
    public function test_gerar_pagamento_sucesso()
    {
        $dados = [
            'amount' => 100.00,
            'payment_method' => 'credit_card',
            'customer' => [
                'name' => 'João da Silva',
                'email' => 'joao@email.com',
            ],
        ];

        $fakeResponse = [
            'id' => 'pagamento123',
            'status' => 'created',
        ];

        Http::fake([
            'https://ms.paggue.io/v1/payments' => Http::response($fakeResponse, 201),
        ]);

        $service = new PagguePaymentService();
        $response = $service->gerarPagamento($dados);

        $this->assertEquals($fakeResponse, $response);
    }

    public function test_gerar_pagamento_falha()
    {
        $dados = [
            'amount' => 100.00,
            'payment_method' => 'credit_card',
            'customer' => [
                'name' => 'João da Silva',
                'email' => 'joao@email.com',
            ],
        ];

        Http::fake([
            'https://ms.paggue.io/v1/payments' => Http::response(['error' => 'Bad Request'], 400),
        ]);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Erro ao gerar pagamento');

        $service = new PagguePaymentService();
        $service->gerarPagamento($dados);
    }
}