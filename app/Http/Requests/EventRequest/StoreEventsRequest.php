<?php

namespace App\Http\Requests\EventRequest;

use Illuminate\Foundation\Http\FormRequest;


class StoreEventsRequest extends FormRequest
{
  
    public function authorize()
    {
        return true; 
    }

    public function rules()
    {
        return [
            'producer_id' => 'required|exists:producers,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'date' => 'required|date',
            'location' => 'required|string|max:255',
            'banner_url' => 'nullable|url|max:500', 
        ];
    }
}