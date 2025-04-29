<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Http\Requests\EventRequest\StoreEventsRequest;
use App\Http\Requests\EventRequest\UpdateEventsRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\EventEmail;
use App\Models\User;
use App\Jobs\ProcessPaymentJob;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Exception;
use Illuminate\Support\Facades\Log;

class EventController extends Controller
{
    // Mostra todos os eventos disponíveis
    public function index()
    {
        try {
            if (!auth()->user()->can('visualizar eventos')) {
                return response()->json(['error' => 'Acesso negado'], 403);
            }

            $events = Event::all();
            return response()->json($events, 200);
        } catch (Exception $e) {
            Log::error('Erro ao listar eventos: ' . $e->getMessage());
            return response()->json(['error' => 'Erro ao listar eventos'], 500);
        }
    }

    // Cria um novo evento
    public function store(StoreEventsRequest $request)
    {
        try {
            if (!auth()->user()->can('gerenciar eventos')) {
                return response()->json(['error' => 'Acesso negado'], 403);
            }

            $validated = $request->validated();

            $event = Event::create([
                'producer_id' => $validated['producer_id'],
                'title' => $validated['title'],
                'description' => $validated['description'] ?? null,
                'date' => $validated['date'],
                'location' => $validated['location'],
                'banner_url' => $validated['banner_url'] ?? null,
            ]);

            $event->load('producer');
            $adminEmails = User::where('role', 'admin')->pluck('email');
    
            foreach ($adminEmails as $email) {
                Mail::to($email)->queue(new EventEmail($event));
            }

            return response()->json($event, 201);
        } catch (ValidationException $e) {
            return response()->json(['error' => 'Dados inválidos', 'details' => $e->errors()], 422);
        } catch (Exception $e) {
            Log::error('Erro ao criar evento: ' . $e->getMessage());
            return response()->json(['error' => 'Erro ao criar evento'], 500);
        }
    }

    // Mostra um evento específico
    public function show(Event $event)
    {
        try {
            if (!auth()->user()->can('visualizar eventos')) {
                return response()->json(['error' => 'Acesso negado'], 403);
            }

            return response()->json($event, 200);
        } catch (ModelNotFoundException $e) {
            Log::error('Evento não encontrado: ' . $e->getMessage());
            return response()->json(['error' => 'Evento não encontrado'], 404);
        } catch (Exception $e) {
            Log::error('Erro ao mostrar evento: ' . $e->getMessage());
            return response()->json(['error' => 'Erro ao mostrar evento'], 500);
        }
    }

    // Atualiza um evento
    public function update(UpdateEventsRequest $request, Event $event)
    {
        try {
            if (!auth()->user()->can('gerenciar eventos')) {
                return response()->json(['error' => 'Acesso negado'], 403);
            }

            $validated = $request->validated();
            $event->update($validated);

            return response()->json($event, 200);
        } catch (ValidationException $e) {
            return response()->json(['error' => 'Dados inválidos', 'details' => $e->errors()], 422);
        } catch (ModelNotFoundException $e) {
            Log::error('Evento não encontrado para atualização: ' . $e->getMessage());
            return response()->json(['error' => 'Evento não encontrado'], 404);
        } catch (Exception $e) {
            Log::error('Erro ao atualizar evento: ' . $e->getMessage());
            return response()->json(['error' => 'Erro ao atualizar evento'], 500);
        }
    }

    // Excluindo o evento
    public function destroy(Event $event)
    {
        try {
            if (!auth()->user()->can('gerenciar eventos')) {
                return response()->json(['error' => 'Acesso negado'], 403);
            }

            $event->delete();
            return response()->json(['message' => 'Evento deletado com sucesso.'], 200);
        } catch (ModelNotFoundException $e) {
            Log::error('Evento não encontrado para exclusão: ' . $e->getMessage());
            return response()->json(['error' => 'Evento não encontrado'], 404);
        } catch (Exception $e) {
            Log::error('Erro ao excluir evento: ' . $e->getMessage());
            return response()->json(['error' => 'Erro ao excluir evento'], 500);
        }
    }
}
