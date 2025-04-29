<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lot extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'sector_id',
        'name',
        'price',
        'quantity',
        'start_date',
        'end_date',
    ];


    /**
     * Get the sector that owns the lot.
     */
    public function sector()
    {
        return $this->belongsTo(\App\Models\Sector::class);
    }
}
