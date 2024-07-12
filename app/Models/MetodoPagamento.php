<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MetodoPagamento extends Model
{
    use HasFactory;

    protected $table = 'metodos_pagamento';

    public function bandeirasMetodos()
    {
        return $this->hasMany(BandeiraMetodo::class, 'fk_metodo_pagamento', 'id');
    }

    public $timestamps = false;
}
