<?php

namespace App\Http\Controllers;

use App\Models\Producer;
use App\Http\Requests\ProducerRequest\StoreProducersRequest;
use App\Http\Requests\ProducerRequest\UpdateProducersRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Exception;
use Illuminate\Support\Facades\Log;

class ProducerController extends Controller
{
    // Mostra todos os produtores disponíveis
    public function index()
    {
        try {
            if (!auth()->user()->can('gerenciar usuarios')) {
                return response()->json(['error' => 'Acesso negado'], 403);
            }

            $producers = Producer::all();
            return response()->json($producers, 200);
        } catch (Exception $e) {
            Log::error('Erro ao listar produtores: ' . $e->getMessage());
            return response()->json(['error' => 'Erro ao listar produtores'], 500);
        }
    }

    // Cria um produtor
    public function store(StoreProducersRequest $request)
    {
        try {
            if (!auth()->user()->can('gerenciar usuarios')) {
                return response()->json(['error' => 'Acesso negado'], 403);
            }

            $validated = $request->validated();

            $producer = Producer::create([
                'user_id' => $validated['user_id'],
                'company_name' => $validated['company_name'],
                'cnpj' => $validated['cnpj'],
            ]);

            return response()->json($producer, 201);
        } catch (ValidationException $e) {
            return response()->json(['error' => 'Dados inválidos', 'details' => $e->errors()], 422);
        } catch (Exception $e) {
            Log::error('Erro ao criar produtor: ' . $e->getMessage());
            return response()->json(['error' => 'Erro ao criar produtor'], 500);
        }
    }

    // Mostra um produtor específico
    public function show(Producer $producer)
    {
        try {
            if (!auth()->user()->can('gerenciar usuarios')) {
                return response()->json(['error' => 'Acesso negado'], 403);
            }

            return response()->json($producer, 200);
        } catch (ModelNotFoundException $e) {
            Log::error('Produtor não encontrado: ' . $e->getMessage());
            return response()->json(['error' => 'Produtor não encontrado'], 404);
        } catch (Exception $e) {
            Log::error('Erro ao mostrar produtor: ' . $e->getMessage());
            return response()->json(['error' => 'Erro ao mostrar produtor'], 500);
        }
    }

    // Atualiza um produtor específico
    public function update(UpdateProducersRequest $request, Producer $producer)
    {
        try {
            if (!auth()->user()->can('gerenciar usuarios')) {
                return response()->json(['error' => 'Acesso negado'], 403);
            }

            $validated = $request->validated();
            $producer->update($validated);

            return response()->json($producer, 200);
        } catch (ValidationException $e) {
            return response()->json(['error' => 'Dados inválidos', 'details' => $e->errors()], 422);
        } catch (ModelNotFoundException $e) {
            Log::error('Produtor não encontrado para atualização: ' . $e->getMessage());
            return response()->json(['error' => 'Produtor não encontrado'], 404);
        } catch (Exception $e) {
            Log::error('Erro ao atualizar produtor: ' . $e->getMessage());
            return response()->json(['error' => 'Erro ao atualizar produtor'], 500);
        }
    }

    // Excluindo o produtor
    public function destroy(Producer $producer)
    {
        try {
            if (!auth()->user()->can('gerenciar usuarios')) {
                return response()->json(['error' => 'Acesso negado'], 403);
            }

            $producer->delete();

            return response()->json(['message' => 'Produtor deletado com sucesso.'], 200);
        } catch (ModelNotFoundException $e) {
            Log::error('Produtor não encontrado para exclusão: ' . $e->getMessage());
            return response()->json(['error' => 'Produtor não encontrado'], 404);
        } catch (Exception $e) {
            Log::error('Erro ao excluir produtor: ' . $e->getMessage());
            return response()->json(['error' => 'Erro ao excluir produtor'], 500);
        }
    }
}
