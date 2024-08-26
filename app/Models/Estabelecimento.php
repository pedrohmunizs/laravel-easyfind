<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estabelecimento extends Model
{
    use HasFactory;

    protected $table = 'estabelecimentos';

    protected $fillable = [
        'nome',
        'segmento',
        'telefone',
        'email',
        'url_instagram',
        'url_facebook',
    ];

    public function imagem()
    {
        return $this->hasOne(Imagem::class, 'fk_estabelecimento', 'id');
    }

    public function agendas()
    {
        return $this->hasMany(Agenda::class, 'fk_estabelecimento', 'id');
    }

    public function secoes()
    {
        return $this->hasMany(Secao::class, 'fk_estabelecimento', 'id');
    }

    public function metodosPagamentosAceito()
    {
        return $this->hasMany(MetodoPagamentoAceito::class, 'fk_estabelecimento', 'id');
    }

    public function endereco()
    {
        return $this->belongsTo(Endereco::class, 'fk_endereco', 'id');
    }
}
