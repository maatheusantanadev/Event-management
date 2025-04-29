<?php

namespace App\Http\Requests\SectorRequest;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSectorsRequest extends FormRequest
{
  
    public function authorize()
    {
        return true; 
    }

  
    public function rules()
    {
        return [
            'event_id'=> 'nullable|exists:events,id',
            'name'=>'nullable|string|max:255',
            'capacity'=>'nullable|integer'
        ];
    }
}