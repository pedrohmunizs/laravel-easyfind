<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Avaliacao extends Model
{
    protected $table = 'avaliacoes';

    protected $fillable = [
        'qtd_estrela',
        'comentario',
        'fk_produto'
    ];

    public function produto()
    {
        return $this->belongsTo(Produto::class, 'fk_produto', 'id');
    }

    public function consumidor()
    {
        return $this->belongsTo(Consumidor::class, 'fk_consumidor', 'id');
    }
}
