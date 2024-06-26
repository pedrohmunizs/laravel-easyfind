<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User;

class Comerciante extends Model
{
    use HasFactory;
    
    protected $table = 'comerciantes';
    public $timestamps = false;

    protected $fillable = [
        'nome',
        'razao_social',
        'cnpj',
        'telefone',
        'cpf'
    ];

    public function endereco()
    {
        return $this->belongsTo(Endereco::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
