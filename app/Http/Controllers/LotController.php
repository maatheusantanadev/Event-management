<?php

namespace App\Http\Controllers;

use App\Models\Lot;
use App\Http\Requests\LotRequest\StoreLotsRequest;
use App\Http\Requests\LotRequest\UpdateLotsRequest;
use App\Models\Sector;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Exception;
use Illuminate\Support\Facades\Log;

class LotController extends Controller
{
    // Mostra todos os lots disponíveis
    public function index()
    {
        try {
            if (!auth()->user()->can('gerenciar eventos')) {
                return response()->json(['error' => 'Acesso negado'], 403);
            }

            $sectorsWithActiveLots = Sector::with('activeLot')->get();
            $lots = $sectorsWithActiveLots->pluck('activeLot')->filter();

            return response()->json($lots->values(), 200);
        } catch (Exception $e) {
            Log::error('Erro ao listar lotes: ' . $e->getMessage());
            return response()->json(['error' => 'Erro ao listar lotes'], 500);
        }
    }

    // Cria um lot
    public function store(StoreLotsRequest $request)
    {
        try {
            if (!auth()->user()->can('gerenciar eventos')) {
                return response()->json(['error' => 'Acesso negado'], 403);
            }

            $validated = $request->validated();

            $lot = Lot::create([
                'sector_id' => $validated['sector_id'],
                'name' => $validated['name'],
                'price' => $validated['price'],
                'quantity' => $validated['quantity'],
                'start_date' => $validated['start_date'],
                'end_date' => $validated['end_date'],
            ]);

            return response()->json($lot, 201);
        } catch (ValidationException $e) {
            return response()->json(['error' => 'Dados inválidos', 'details' => $e->errors()], 422);
        } catch (Exception $e) {
            Log::error('Erro ao criar lote: ' . $e->getMessage());
            return response()->json(['error' => 'Erro ao criar lote'], 500);
        }
    }

    // Mostra um lot específico
    public function show(Lot $lot)
    {
        try {
            if (!auth()->user()->can('gerenciar eventos')) {
                return response()->json(['error' => 'Acesso negado'], 403);
            }

            return response()->json($lot, 200);
        } catch (ModelNotFoundException $e) {
            Log::error('Lote não encontrado: ' . $e->getMessage());
            return response()->json(['error' => 'Lote não encontrado'], 404);
        } catch (Exception $e) {
            Log::error('Erro ao mostrar lote: ' . $e->getMessage());
            return response()->json(['error' => 'Erro ao mostrar lote'], 500);
        }
    }

    // Atualiza um lot
    public function update(UpdateLotsRequest $request, Lot $lot)
    {
        try {
            if (!auth()->user()->can('gerenciar eventos')) {
                return response()->json(['error' => 'Acesso negado'], 403);
            }

            $validated = $request->validated();
            $lot->update($validated);

            return response()->json($lot, 200);
        } catch (ValidationException $e) {
            return response()->json(['error' => 'Dados inválidos', 'details' => $e->errors()], 422);
        } catch (ModelNotFoundException $e) {
            Log::error('Lote não encontrado para atualização: ' . $e->getMessage());
            return response()->json(['error' => 'Lote não encontrado'], 404);
        } catch (Exception $e) {
            Log::error('Erro ao atualizar lote: ' . $e->getMessage());
            return response()->json(['error' => 'Erro ao atualizar lote'], 500);
        }
    }

    // Excluindo o lot
    public function destroy(Lot $lot)
    {
        try {
            if (!auth()->user()->can('gerenciar eventos')) {
                return response()->json(['error' => 'Acesso negado'], 403);
            }

            $lot->delete();

            return response()->json(['message' => 'Lote deletado com sucesso.'], 200);
        } catch (ModelNotFoundException $e) {
            Log::error('Lote não encontrado para exclusão: ' . $e->getMessage());
            return response()->json(['error' => 'Lote não encontrado'], 404);
        } catch (Exception $e) {
            Log::error('Erro ao excluir lote: ' . $e->getMessage());
            return response()->json(['error' => 'Erro ao excluir lote'], 500);
        }
    }
}
