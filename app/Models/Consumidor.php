<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consumidor extends Model
{
    use HasFactory;

    protected $table = 'consumidores';

    protected $fillable = [
        'cpf',
        'telefone',
        'genero',
        'data_nascimento'
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'fk_usuario', 'id');
    }

    public function avaliacoes()
    {
        return $this->hasMany(Avaliacao::class, 'fk_consumidor', 'id');
    }

    public function carrinhos()
    {
        return $this->hasMany(Carrinho::class, 'fk_consumidor', 'id');
    }
}
