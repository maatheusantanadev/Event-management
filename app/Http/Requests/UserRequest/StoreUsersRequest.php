<?php

namespace App\Http\Requests\UserRequest;

use Illuminate\Foundation\Http\FormRequest;

class StoreUsersRequest extends FormRequest
{
    

    public function authorize()
    {
        return true; 
    }

   
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'required|string|max:15', 
            'cpf_cnpj' => 'required|string|max:14',
            'role' => 'required|string|in:admin,produtor,cliente', 
        ];
    }

  
}