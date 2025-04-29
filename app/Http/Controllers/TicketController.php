<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Http\Requests\TicketRequest\StoreTicketsRequest;
use App\Http\Requests\TicketRequest\UpdateTicketsRequest;
use Illuminate\Http\Request;
use App\Jobs\ProcessPaymentJob;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Exception;
use Illuminate\Support\Facades\Log;

class TicketController extends Controller
{
    // Mostra todos os tickets disponíveis
    public function index()
    {
        try {
            if (!auth()->user()->can('gerenciar eventos')) {
                return response()->json(['error' => 'Acesso negado'], 403);
            }

            $tickets = Ticket::all();
            return response()->json($tickets, 200);
        } catch (Exception $e) {
            Log::error('Erro ao listar tickets: ' . $e->getMessage());
            return response()->json(['error' => 'Erro ao listar tickets'], 500);
        }
    }

    // Cria um ticket
    public function store(StoreTicketsRequest $request)
    {
        try {
            $validated = $request->validated();

            $ticket = Ticket::create([
                'user_id' => $validated['user_id'],
                'lot_id' => $validated['lot_id'],
                'status' => $validated['status'],
                'qr_code' => $validated['qr_code'],
            ]);

            ProcessPaymentJob::dispatch($ticket->id)->onQueue('payments');

            return response()->json($ticket, 201);
        } catch (ValidationException $e) {
            return response()->json(['error' => 'Dados inválidos', 'details' => $e->errors()], 422);
        } catch (Exception $e) {
            Log::error('Erro ao criar ticket: ' . $e->getMessage());
            return response()->json(['error' => 'Erro ao criar ticket'], 500);
        }
    }

    // Mostra um ticket específico
    public function show(Ticket $ticket)
    {
        try {
            return response()->json($ticket, 200);
        } catch (ModelNotFoundException $e) {
            Log::error('Ticket não encontrado: ' . $e->getMessage());
            return response()->json(['error' => 'Ticket não encontrado'], 404);
        } catch (Exception $e) {
            Log::error('Erro ao mostrar ticket: ' . $e->getMessage());
            return response()->json(['error' => 'Erro ao mostrar ticket'], 500);
        }
    }

    // Atualiza um ticket
    public function update(UpdateTicketsRequest $request, Ticket $ticket)
    {
        try {
            if (!auth()->user()->can('gerenciar eventos')) {
                return response()->json(['error' => 'Acesso negado'], 403);
            }

            $validated = $request->validated();
            $ticket->update($validated);

            return response()->json($ticket, 200);
        } catch (ValidationException $e) {
            return response()->json(['error' => 'Dados inválidos', 'details' => $e->errors()], 422);
        } catch (ModelNotFoundException $e) {
            Log::error('Ticket não encontrado para atualização: ' . $e->getMessage());
            return response()->json(['error' => 'Ticket não encontrado'], 404);
        } catch (Exception $e) {
            Log::error('Erro ao atualizar ticket: ' . $e->getMessage());
            return response()->json(['error' => 'Erro ao atualizar ticket'], 500);
        }
    }

    // Excluindo o ticket
    public function destroy(Ticket $ticket)
    {
        try {
            if (!auth()->user()->can('gerenciar eventos')) {
                return response()->json(['error' => 'Acesso negado'], 403);
            }
            
            $ticket->delete();

            return response()->json(['message' => 'Ingresso deletado com sucesso.'], 200);
        } catch (ModelNotFoundException $e) {
            Log::error('Ticket não encontrado para exclusão: ' . $e->getMessage());
            return response()->json(['error' => 'Ticket não encontrado'], 404);
        } catch (Exception $e) {
            Log::error('Erro ao excluir ticket: ' . $e->getMessage());
            return response()->json(['error' => 'Erro ao excluir ticket'], 500);
        }
    }
}
    