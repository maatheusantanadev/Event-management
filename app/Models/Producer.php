<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producer extends Model
{
    use HasFactory;

    
    protected $fillable = [
        'user_id',
        'company_name',
        'cnpj',
    ];

    
    // Relacionamento: Um produtor pertence a um usuário.
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}