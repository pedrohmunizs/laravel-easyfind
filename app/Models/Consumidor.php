<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consumidor extends Model
{
    use HasFactory;

    protected $table = 'consumidores';

    protected $fillable = [
        'nome',
        'cpf',
        'telefone',
        'genero',
        'data_nascimento'
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'fk_usuario', 'id');
    }
}
