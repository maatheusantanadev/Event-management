<?php

namespace App\Http\Requests\EventRequest;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEventsRequest extends FormRequest
{
 
    public function authorize()
    {
        return true; 
    }

  
    public function rules()
    {
        return [
            'producer_id' => 'nullable|exists:producers,id', 
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:1000',
            'date' => 'nullable|date',
            'location' => 'nullable|string|max:255',
            'banner_url' => 'nullable|url|max:500',
        ];
    }
}
