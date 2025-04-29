<?php

namespace App\Http\Requests\DiscountCouponsRequest;

use Illuminate\Foundation\Http\FormRequest;

class StoreDiscountCouponsRequest extends FormRequest
{
    
    public function authorize()
    {
        return true;
    }

  
    public function rules()
    {
        return [
            'code' => 'required|string|max:255|unique:discount_coupons,code',
            'discount' => 'required|numeric|min:0|max:100', 
            'max_uses' => 'required|integer|min:1',
            'expires_at' => 'required|date|after:today', 
        ];
    }
}