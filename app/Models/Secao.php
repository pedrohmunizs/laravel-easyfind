<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Secao extends Model
{
    use HasFactory;

    protected $table = 'secoes';

    protected $fillable = [
        'descricao',
        'fk_estabelecimento',
    ];

    public function estabelecimento()
    {
        return $this->belongsTo(Estabelecimento::class,'fk_estabelecimento', 'id');
    }

    public function produtos()
    {
        return $this->hasMany(Produto::class, 'fk_secao');
    }
    
    public $timestamps = false;
}
