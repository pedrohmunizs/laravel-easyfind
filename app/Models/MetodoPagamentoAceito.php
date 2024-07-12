<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MetodoPagamentoAceito extends Model
{
    use HasFactory;

    protected $table = 'metodos_pagamento_aceitos';

    public function estabelecimento()
    {
        return $this->belongsTo(Estabelecimento::class, 'fk_estabelecimento', 'id');
    }

    public function bandeiraMetodo()
    {
        return $this->belongsTo(BandeiraMetodo::class, 'fk_metodo_pagamento', 'id');
    }

    public $timestamps = false;
}
