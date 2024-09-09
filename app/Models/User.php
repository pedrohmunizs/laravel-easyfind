<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements CanResetPassword
{
    use HasFactory, Notifiable;
    
    protected $table = 'users';
    public $timestamps = false;

    protected $fillable = [
        'email',
        'nome'
    ];

    public function comerciante()
    {
        return $this->hasOne(Comerciante::class, 'fk_usuario', 'id');
    }

    public function consumidor()
    {
        return $this->hasOne(Consumidor::class, 'fk_usuario', 'id');
    }
}
