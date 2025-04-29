<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\UserRequest\StoreUsersRequest;
use App\Http\Requests\UserRequest\UpdateUsersRequest;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    // Retorna todos os usuários
    public function index()
    {
        try {
            if (!auth()->user()->can('gerenciar usuarios')) {
                return response()->json(['error' => 'Acesso negado'], 403);
            }

            $users = User::all();
            return response()->json($users, 200);
        } catch (\Exception $e) {
            Log::error('Erro ao listar usuários: ' . $e->getMessage());
            return response()->json(['error' => 'Erro ao listar usuários'], 500);
        }
    }

    // Criando o usuário com os dados validados
    public function store(StoreUsersRequest $request)
    {
        try {
            if (!auth()->user()->can('gerenciar usuarios')) {
                return response()->json(['error' => 'Acesso negado'], 403);
            }

            $validated = $request->validated();
            
            // Checa se já existe um usuário com o mesmo e-mail ou CPF/CNPJ
            if (User::where('email', $validated['email'])->exists()) {
                return response()->json(['error' => 'E-mail já cadastrado'], 400);
            }

            if (User::where('cpf_cnpj', $validated['cpf_cnpj'])->exists()) {
                return response()->json(['error' => 'CPF/CNPJ já cadastrado'], 400);
            }

            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => bcrypt($validated['password']),
                'phone' => $validated['phone'],
                'cpf_cnpj' => $validated['cpf_cnpj'],
                'role' => $validated['role'],
            ]);

            $user->assignRole($validated['role']);

            return response()->json($user, 201);
        } catch (ValidationException $e) {
            return response()->json(['error' => 'Dados inválidos', 'message' => $e->errors()], 422);
        } catch (\Exception $e) {
            Log::error('Erro ao criar usuário: ' . $e->getMessage());
            return response()->json(['error' => 'Erro ao criar usuário'], 500);
        }
    }

    // Retorna o usuário especificado
    public function show(User $user)
    {
        try {
            if (!auth()->user()->can('gerenciar usuarios')) {
                return response()->json(['error' => 'Acesso negado'], 403);
            }

            return response()->json($user, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Usuário não encontrado'], 404);
        } catch (\Exception $e) {
            Log::error('Erro ao obter usuário: ' . $e->getMessage());
            return response()->json(['error' => 'Erro ao obter usuário'], 500);
        }
    }

    // Atualizando os dados do usuário
    public function update(UpdateUsersRequest $request, User $user)
    {
        try {
            if (!auth()->user()->can('gerenciar usuarios')) {
                return response()->json(['error' => 'Acesso negado'], 403);
            }

            $validated = $request->validated();

            // Checa se já existe outro usuário com o mesmo e-mail ou CPF/CNPJ
            if (User::where('email', $validated['email'])->where('id', '!=', $user->id)->exists()) {
                return response()->json(['error' => 'E-mail já cadastrado'], 400);
            }

            if (User::where('cpf_cnpj', $validated['cpf_cnpj'])->where('id', '!=', $user->id)->exists()) {
                return response()->json(['error' => 'CPF/CNPJ já cadastrado'], 400);
            }

            $user->update($validated);

            return response()->json($user, 200);
        } catch (ValidationException $e) {
            return response()->json(['error' => 'Dados inválidos', 'message' => $e->errors()], 422);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Usuário não encontrado'], 404);
        } catch (\Exception $e) {
            Log::error('Erro ao atualizar usuário: ' . $e->getMessage());
            return response()->json(['error' => 'Erro ao atualizar usuário'], 500);
        }
    }

    // Excluindo o usuário
    public function destroy(User $user)
    {
        try {
            if (!auth()->user()->can('gerenciar usuarios')) {
                return response()->json(['error' => 'Acesso negado'], 403);
            }

            $user->delete();

            return response()->json(['message' => 'Usuário deletado com sucesso.'], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Usuário não encontrado'], 404);
        } catch (\Exception $e) {
            Log::error('Erro ao deletar usuário: ' . $e->getMessage());
            return response()->json(['error' => 'Erro ao deletar usuário'], 500);
        }
    }
}










