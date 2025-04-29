<?php

namespace App\Http\Controllers;

use App\Models\Sector;
use App\Http\Requests\SectorRequest\StoreSectorsRequest;
use App\Http\Requests\SectorRequest\UpdateSectorsRequest;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Exception;
use Illuminate\Support\Facades\Log;

class SectorController extends Controller
{
    // Mostra todos os setores disponíveis
    public function index()
    {
        try {
            if (!auth()->user()->can('gerenciar eventos')) {
                return response()->json(['error' => 'Acesso negado'], 403);
            }

            $sectors = Sector::all();
            return response()->json($sectors, 200);
        } catch (Exception $e) {
            Log::error('Erro ao listar setores: ' . $e->getMessage());
            return response()->json(['error' => 'Erro ao listar setores'], 500);
        }
    }

    // Cria um setor
    public function store(StoreSectorsRequest $request)
    {
        try {
            if (!auth()->user()->can('gerenciar eventos')) {
                return response()->json(['error' => 'Acesso negado'], 403);
            }

            $validated = $request->validated();

            $sector = Sector::create([
                'event_id' => $validated['event_id'],
                'name' => $validated['name'],
                'capacity' => $validated['capacity'],
            ]);

            return response()->json($sector, 201);
        } catch (ValidationException $e) {
            return response()->json(['error' => 'Dados inválidos', 'details' => $e->errors()], 422);
        } catch (Exception $e) {
            Log::error('Erro ao criar setor: ' . $e->getMessage());
            return response()->json(['error' => 'Erro ao criar setor'], 500);
        }
    }

    // Mostra um setor específico
    public function show(Sector $sector)
    {
        try {
            if (!auth()->user()->can('gerenciar eventos')) {
                return response()->json(['error' => 'Acesso negado'], 403);
            }

            return response()->json($sector, 200);
        } catch (ModelNotFoundException $e) {
            Log::error('Setor não encontrado: ' . $e->getMessage());
            return response()->json(['error' => 'Setor não encontrado'], 404);
        } catch (Exception $e) {
            Log::error('Erro ao mostrar setor: ' . $e->getMessage());
            return response()->json(['error' => 'Erro ao mostrar setor'], 500);
        }
    }

    // Atualiza um setor
    public function update(UpdateSectorsRequest $request, Sector $sector)
    {
        try {
            if (!auth()->user()->can('gerenciar eventos')) {
                return response()->json(['error' => 'Acesso negado'], 403);
            }

            $validated = $request->validated();
            $sector->update($validated);

            return response()->json($sector, 200);
        } catch (ValidationException $e) {
            return response()->json(['error' => 'Dados inválidos', 'details' => $e->errors()], 422);
        } catch (ModelNotFoundException $e) {
            Log::error('Setor não encontrado para atualização: ' . $e->getMessage());
            return response()->json(['error' => 'Setor não encontrado'], 404);
        } catch (Exception $e) {
            Log::error('Erro ao atualizar setor: ' . $e->getMessage());
            return response()->json(['error' => 'Erro ao atualizar setor'], 500);
        }
    }

    // Excluindo o setor
    public function destroy(Sector $sector)
    {
        try {
            if (!auth()->user()->can('gerenciar eventos')) {
                return response()->json(['error' => 'Acesso negado'], 403);
            }

            $sector->delete();

            return response()->json(['message' => 'Setor deletado com sucesso.'], 200);
        } catch (ModelNotFoundException $e) {
            Log::error('Setor não encontrado para exclusão: ' . $e->getMessage());
            return response()->json(['error' => 'Setor não encontrado'], 404);
        } catch (Exception $e) {
            Log::error('Erro ao excluir setor: ' . $e->getMessage());
            return response()->json(['error' => 'Erro ao excluir setor'], 500);
        }
    }
}
