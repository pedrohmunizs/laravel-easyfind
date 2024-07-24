<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transacao extends Model
{
    use HasFactory;

    protected $table = 'transacoes';

    public function pedido()
    {
        return $this->belongsTo(Pedido::class, 'fk_pedido', 'id');
    }

    public $timestamps = false;
}
