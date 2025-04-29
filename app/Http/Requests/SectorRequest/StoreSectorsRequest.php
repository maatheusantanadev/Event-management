<?php

namespace App\Http\Requests\SectorRequest;

use Illuminate\Foundation\Http\FormRequest;

class StoreSectorsRequest extends FormRequest
{
   
    public function authorize()
    {
        return true; 
    }

   
    public function rules()
    {
        return [
            'event_id'=> 'required|exists:events,id',
            'name'=>'required|string|max:255',
            'capacity'=>'required|integer'
        ];
    }
}