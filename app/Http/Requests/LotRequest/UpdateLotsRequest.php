<?php

namespace App\Http\Requests\LotRequest;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLotsRequest extends FormRequest
{
    public function authorize()
    {
        return true; 
    }

    public function rules()
    {
        return [
            'sector_id' => 'nullable|exists:sectors,id',
            'name' => 'nullable|string|max:255',
            'price' => 'nullable|numeric|min:0',
            'quantity' => 'nullable|integer|min:1',
            'end_date' => 'nullable|date|after:start_date',
        ];
    }
}