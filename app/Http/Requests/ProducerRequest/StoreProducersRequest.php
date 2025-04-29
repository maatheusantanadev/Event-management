<?php

namespace App\Http\Requests\ProducerRequest;

use Illuminate\Foundation\Http\FormRequest;

class StoreProducersRequest extends FormRequest
{
  
    public function authorize()
    {
        return true; 
    }


    public function rules()
    {
        return [
            'user_id' => 'required|exists:users,id', 
            'company_name' => 'required|string|max:255',
            'cnpj' => 'required|string|unique:producers,cnpj|max:18',
        ];
    }
}