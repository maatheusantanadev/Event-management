<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Http\Requests\PaymentRequest\StorePaymentsRequest;
use App\Http\Requests\PaymentRequest\UpdatePaymentsRequest;
use App\Services\PagguePaymentService;
use App\Jobs\ProcessPaymentJob;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Exception;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    // Seria um construtor para integração com a API da PAGGUE
    protected $paggue;

    public function __construct(PagguePaymentService $paggue)
    {
        $this->paggue = $paggue;
    }

    // Mostra todos pagamentos disponíveis
    public function index()
    {
        try {
            if (!auth()->user()->can('gerenciar eventos')) {
                return response()->json(['error' => 'Acesso negado'], 403);
            }

            $payments = Payment::all();
            return response()->json($payments, 200);
        } catch (Exception $e) {
            Log::error('Erro ao listar pagamentos: ' . $e->getMessage());
            return response()->json(['error' => 'Erro ao listar pagamentos'], 500);
        }
    }

    // Cria um pagamento
    public function store(StorePaymentsRequest $request)
    {
        try {
            $validated = $request->validated();

            $payment = Payment::create([
                'ticket_id' => $validated['ticket_id'],
                'transaction_id' => $validated['transaction_id'],
                'discount_coupon_id' => $validated['discount_coupon_id'] ?? null,
                'amount' => $validated['amount'],
                'status' => 'pendente',
            ]);

            return response()->json([
                'message' => 'Pagamento agendado para processamento.',
                'payment' => $payment,
            ], 200);
        } catch (ValidationException $e) {
            return response()->json(['error' => 'Dados inválidos', 'details' => $e->errors()], 422);
        } catch (Exception $e) {
            Log::error('Erro ao criar pagamento: ' . $e->getMessage());
            return response()->json(['error' => 'Erro ao criar pagamento'], 500);
        }
    }

    // Mostra um pagamento específico
    public function show(Payment $payment)
    {
        try {
            if (!auth()->user()->can('realizar pagamentos')) {
                return response()->json(['error' => 'Acesso negado'], 403);
            }

            return response()->json($payment, 200);
        } catch (ModelNotFoundException $e) {
            Log::error('Pagamento não encontrado: ' . $e->getMessage());
            return response()->json(['error' => 'Pagamento não encontrado'], 404);
        } catch (Exception $e) {
            Log::error('Erro ao mostrar pagamento: ' . $e->getMessage());
            return response()->json(['error' => 'Erro ao mostrar pagamento'], 500);
        }
    }

    // Atualizando um pagamento específico
    public function update(UpdatePaymentsRequest $request, Payment $payment)
    {
        try {
            $validated = $request->validated();
            $payment->update($validated);

            return response()->json($payment, 200);
        } catch (ValidationException $e) {
            return response()->json(['error' => 'Dados inválidos', 'details' => $e->errors()], 422);
        } catch (ModelNotFoundException $e) {
            Log::error('Pagamento não encontrado para atualização: ' . $e->getMessage());
            return response()->json(['error' => 'Pagamento não encontrado'], 404);
        } catch (Exception $e) {
            Log::error('Erro ao atualizar pagamento: ' . $e->getMessage());
            return response()->json(['error' => 'Erro ao atualizar pagamento'], 500);
        }
    }

    // Excluindo o pagamento
    public function destroy(Payment $payment)
    {
        try {
            if (!auth()->user()->can('gerenciar eventos')) {
                return response()->json(['error' => 'Acesso negado'], 403);
            }

            $payment->delete();

            return response()->json(['message' => 'Pagamento deletado com sucesso.'], 200);
        } catch (ModelNotFoundException $e) {
            Log::error('Pagamento não encontrado para exclusão: ' . $e->getMessage());
            return response()->json(['error' => 'Pagamento não encontrado'], 404);
        } catch (Exception $e) {
            Log::error('Erro ao excluir pagamento: ' . $e->getMessage());
            return response()->json(['error' => 'Erro ao excluir pagamento'], 500);
        }
    }
}
