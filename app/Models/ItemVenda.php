<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemVenda extends Model
{
    use HasFactory;

    protected $table = 'itens_venda';

    protected $fillable = [
        'fk_produto',
        'quantidade'
    ];

    public function pedido()
    {
        return $this->belongsTo(Pedido::class, 'fk_pedido', 'id');
    }

    public function produto()
    {
        return $this->belongsTo(Produto::class, 'fk_produto', 'id');
    }

    public function consumidor()
    {
        return $this->belongsTo(Consumidor::class, 'fk_consumidor', 'id');
    }

    public $timestamps = false;
}
