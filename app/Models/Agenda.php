<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    use HasFactory;

    protected $table = 'agendas';

    protected $fillable = [
        'dia',
        'horario_inicio',
        'horario_fim'
    ];

    public function estabelecimento()
    {
        return $this->belongsTo(Estabelecimento::class,'fk_estabelecimento', 'id');
    }
    
    public $timestamps = false;
}
