<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Requests\UserRequest\StoreUsersRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AuthController extends Controller
{
    
    // Cadastro de Usuário (Signup) 
    public function signup(StoreUsersRequest $request)
    {
        $data = $request->validated();
        $data['password'] = bcrypt($data['password']);
    
        // Garante que o papel não venha do cliente, força ser "cliente"
        $data['role'] = 'cliente';
    
        $user = User::create($data);
    
        // Atribui o papel "cliente"
        $user->assignRole('cliente');
    
        return response()->json(['user' => $user], 201);
    }
    
    
     // Login do Usuário
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'cpf_cnpj' => 'required|string',
            'password' => 'required|string'
        ]);

        $user = User::where('cpf_cnpj', $credentials['cpf_cnpj'])->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return response()->json(['message' => 'Credenciais inválidas'], 401);
        }

        // Gera o token JWT
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json(['token' => $token, 'user' => $user], 200);
    }


}

