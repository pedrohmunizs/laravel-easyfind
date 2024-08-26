<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Imagem extends Model
{
    use HasFactory;

    protected $table = 'imagens';

    public function estabelecimento()
    {
        return $this->belongsTo(Estabelecimento::class,'fk_estabelecimento', 'id');
    }

    public function produto()
    {
        return $this->belongsTo(Produto::class,'fk_produto', 'id');
    }
}
