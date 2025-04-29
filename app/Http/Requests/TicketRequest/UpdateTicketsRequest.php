<?php

namespace App\Http\Requests\TicketRequest;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTicketsRequest extends FormRequest
{
  
    public function authorize()
    {
        return true; 
    }


    public function rules()
    {
        return [
            'status' => 'nullable|in:pendente,pago,cancelado',
        ];
    }
}