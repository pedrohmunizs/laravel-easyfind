<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    use HasFactory;

    protected $table = 'produtos';

    protected $fillable = [
        'nome',
        'codigo_sku',
        'preco',
        'preco_oferta',
        'descricao',
        'codigo_barras',
        'is_ativo',
        'is_promocao_ativa',
        'fk_secao',
    ];

    public function imagens()
    {
        return $this->hasMany(Imagem::class, 'fk_produto', 'id');
    }

    public function secao()
    {
        return $this->belongsTo(Secao::class, 'fk_secao');
    }

    public $timestamps = false;
}
