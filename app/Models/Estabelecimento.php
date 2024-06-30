<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estabelecimento extends Model
{
    use HasFactory;

    protected $table = 'estabelecimentos';

    protected $fillable = [
        'nome',
        'segmento',
        'telefone',
        'email',
        'url_instagram',
        'url_facebook',
    ];

    public function imagem()
    {
        return $this->hasOne(Imagem::class, 'fk_estabelecimento', 'id');
    }
}
