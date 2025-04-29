<?php

namespace App\Http\Requests\PaymentRequest;

use Illuminate\Foundation\Http\FormRequest;

class StorePaymentsRequest extends FormRequest
{
 
    public function authorize()
    {
        return true; 
    }

    
    public function rules()
    {
        return [
            'ticket_id' => 'required|exists:tickets,id',
            'transaction_id' => 'required|uuid|unique:payments,transaction_id',
            'discount_coupon_id' => 'nullable|exists:discount_coupons,id',
            'amount' => 'required|numeric|min:1',
        ];
    }
}