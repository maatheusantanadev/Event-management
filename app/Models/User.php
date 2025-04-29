<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, HasFactory, HasRoles;
 

    protected $table = 'users';

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'cpf_cnpj',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function producers(): HasMany
    {
        return $this->hasMany(\App\Models\Producer::class);
    }
}