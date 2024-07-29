<?php

namespace App\Models;

use App\Enums\StatusPedido;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;

    protected $table = 'pedidos';

    protected $fillable = [
        'fk_metodo_aceito',
        'is_pagamento_online'
    ];

    protected $casts = [
        'status' => StatusPedido::class,
    ];

    public function itensVenda()
    {
        return $this->hasMany(ItemVenda::class, 'fk_pedido', 'id');
    }

    public function transacao()
    {
        return $this->hasOne(Transacao::class, 'fk_pedido', 'id');
    }

    public function metodoPagamento()
    {
        return $this->belongsTo(BandeiraMetodo::class, 'fk_metodo_aceito', 'id');
    }

    public function scopeDateRange($query, $from, $to)
    {
        if ($from !== null) {
            $from = \Carbon\Carbon::parse($from)->startOfDay();
            $query->where('pedidos.created_at', '>=', $from);
        }

        if ($to !== null) {
            $to = \Carbon\Carbon::parse($to)->endOfDay();
            $query->where('pedidos.created_at', '<=', $to);
        }

        return $query;
    }
}
