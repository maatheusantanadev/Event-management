<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    
    protected $fillable = [
        'user_id',
        'lot_id',
        'status',
        'qr_code',
    ];

    
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    
    public function lot()
    {
        return $this->belongsTo(\App\Models\Lot::class);
    }
}
