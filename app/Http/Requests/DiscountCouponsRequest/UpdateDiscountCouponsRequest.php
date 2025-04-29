<?php

namespace App\Http\Requests\DiscountCouponsRequest;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDiscountCouponsRequest extends FormRequest
{
    
    public function authorize()
    {
        return true;
    }

  
    public function rules()
    {
        return [
            'code' => 'nullable||string|max:255|unique:discount_coupons,code',
            'discount' => 'nullable|numeric|min:0|max:100', 
            'max_uses' => 'nullable|integer|min:1',
            'expires_at' => 'nullable|date|after:today', 
        ];
    }
}