<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

class Sector extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'name',
        'capacity',
    ];

    
    // Relacionamento: Um setor pertence a um evento.
   
    public function event()
    {
        return $this->belongsTo(Event::class);
    }


    

    public function activeLot(): HasOne
    {
        return $this->hasOne(\App\Models\Lot::class)
            ->where('quantity', '>', 0)
            ->whereDate('end_date', '>=', Carbon::today())
            ->orderBy('start_date', 'asc'); // ou 'id', se preferir por ordem de criação
    }
}
