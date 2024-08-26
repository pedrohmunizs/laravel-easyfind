<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carrinho extends Model
{
    use HasFactory;

    protected $table = 'carrinhos';

    protected $fillable = [
        'quantidade',
        'fk_produto'
    ];

    public function consumidor()
    {
        return $this->belongsTo(Consumidor::class, 'fk_consumidor', 'id');
    }

    public function produto()
    {
        return $this->belongsTo(Produto::class, 'fk_produto', 'id');
    }
}
