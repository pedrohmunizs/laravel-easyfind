<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BandeiraPagamento extends Model
{
    use HasFactory;

    protected $table = 'bandeiras_pagamento';

    public function bandeirasMetodos()
    {
        return $this->hasMany(BandeiraMetodo::class, 'fk_bandeira_pagamento', 'id');
    }

    public $timestamps = false;
}
