<?php

namespace App\Http\Requests\PaymentRequest;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePaymentsRequest extends FormRequest
{

    public function authorize()
    {
        return true; 
    }

    
    public function rules()
    {
        return [
            'transaction_id' => 'nullable|uuid|unique:payments,transaction_id',
            'discount_coupon_id' => 'nullable|integer|exists:discount_coupons,id',
            'amount' => 'nullable|numeric|min:1',
            'status' => 'nullable|in:pendente,confirmado,falha',
        ];
    }
}