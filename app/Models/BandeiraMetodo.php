<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BandeiraMetodo extends Model
{
    use HasFactory;

    protected $table = 'bandeiras_metodos';

    public function metodoPagamento()
    {
        return $this->belongsTo(MetodoPagamento::class,'fk_metodo_pagamento', 'id');
    }

    public function bandeiraPagamento()
    {
        return $this->belongsTo(BandeiraPagamento::class,'fk_bandeira_pagamento', 'id');
    }

    public function pedido()
    {
        return $this->hasOne(Pedido::class, 'fk_metodo_aceito', 'id');
    }

    public $timestamps = false;
}
