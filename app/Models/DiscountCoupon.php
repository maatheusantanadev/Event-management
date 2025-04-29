<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class DiscountCoupon extends Model
{
    use HasFactory;

    /**
     * Os atributos que podem ser atribuídos em massa.
     */
    protected $fillable = [
        'code',
        'discount',
        'max_uses',
        'used_count',
        'expires_at',
    ];

    /**
     * Define que "expires_at" será tratado como um campo de data.
     */
    protected $dates = ['expires_at'];

    /**
     * Verifica se o cupom ainda é válido.
     */
    public function isValid(): bool
    {
        return ($this->max_uses === null || $this->used_count < $this->max_uses) &&
               ($this->expires_at === null || $this->expires_at->isFuture());
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'discount_coupon_id');
    }
}
