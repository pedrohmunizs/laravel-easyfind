<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Users extends Model
{
    use HasFactory;
    
    protected $table = 'users';
    public $timestamps = false;

    protected $fillable = [
        'email',
        'password',
        'type'
    ];
}
