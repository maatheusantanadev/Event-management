<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    
    protected $fillable = [
        'producer_id',
        'title',
        'description',
        'date',
        'location',
        'banner_url',
    ];

    
    // Relacionamento: Um evento pertence a um produtor.
    public function producer()
    {
        return $this->belongsTo(Producer::class);
    }
}