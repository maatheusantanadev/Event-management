<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_id',
        'transaction_id',
        'amount',
        'status',
        'discount_coupon_id'
    ];

    protected $attributes = [
        'status' => 'pendente',
    ];

    /**
     * Relacionamento com Ticket
     */
    public function ticket()
    {
        return $this->belongsTo(\App\Models\Ticket::class);
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function discountCoupon()
    {
        return $this->belongsTo(\App\Models\DiscountCoupon::class, 'discount_coupon_id');
    }
}
