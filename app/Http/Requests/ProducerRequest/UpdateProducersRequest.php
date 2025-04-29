<?php

namespace App\Http\Requests\ProducerRequest;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProducersRequest extends FormRequest
{

    public function authorize()
    {
        return true; 
    }

    
    public function rules()
    {
        return [
            'user_id' => 'nullable|exists:users,id', 
            'company_name' => 'nullable|string|max:255',
        ];
    }
}