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

    public function avaliacoes()
    {
        return $this->hasMany(Avaliacao::class, 'fk_produto', 'id');
    }

    public function carrinhos()
    {
        return $this->hasMany(Carrinho::class, 'fk_produto', 'id');
    }

    public function itensVenda()
    {
        return $this->hasMany(ItemVenda::class, 'fk_produto', 'id');
    }

    public function produtosTags()
    {
        return $this->hasMany(ProdutoTag::class, 'fk_produto', 'id');
    }

    public function scopeStatus($query, $status)
    {
        if ($status !== null) {
            return $query->where('is_ativo', $status);
        }

        return $query;
    }

    public function scopePriceRange($query, $min, $max)
    {
        if ($min !== null) {
            $query->where('preco', '>=', $min);
        }

        if ($max !== null) {
            $query->where('preco', '<=', $max);
        }

        return $query;
    }

    public function scopeDateRange($query, $from, $to)
    {
        if ($from !== null) {
            $from = \Carbon\Carbon::parse($from)->startOfDay();
            $query->where('created_at', '>=', $from);
        }

        if ($to !== null) {
            $to = \Carbon\Carbon::parse($to)->endOfDay();
            $query->where('created_at', '<=', $to);
        }

        return $query;
    }
}
