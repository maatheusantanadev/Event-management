<?php

namespace App\Http\Requests\LotRequest;

use Illuminate\Foundation\Http\FormRequest;

class StoreLotsRequest extends FormRequest
{
  
    public function authorize()
    {
        return true;
    }

   
    public function rules()
    {
        return [
            'sector_id' => 'required|exists:sectors,id',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0', 
            'quantity' => 'required|integer|min:1', 
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date', 
        ];
    }
}