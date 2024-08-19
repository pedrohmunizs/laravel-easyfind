<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Endereco extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'enderecos';

    protected $fillable = [
        'cep',
        'logradouro',
        'bairro',
        'numero'
    ];

    public function estabelecimento()
    {
        return $this->hasOne(Estabelecimento::class, "fk_endereco", 'id');
    }

    public function comerciante()
    {
        return $this->hasOne(Comerciante::class, "fk_endereco", 'id');
    }

    public $timestamps = false;
}
