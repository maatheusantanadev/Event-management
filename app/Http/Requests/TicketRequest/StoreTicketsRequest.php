<?php

namespace App\Http\Requests\TicketRequest;

use Illuminate\Foundation\Http\FormRequest;

class StoreTicketsRequest extends FormRequest
{
 
    public function authorize()
    {
        return true; 
    }

    public function rules()
    {
        return [
            'user_id' => 'required|exists:users,id',
            'lot_id' => 'required|exists:lots,id',
            'status' => 'required|in:pendente,pago,cancelado',
            'qr_code' => 'required|uuid|unique:tickets',
        ];
    }
}