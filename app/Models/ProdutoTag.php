<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdutoTag extends Model
{
    use HasFactory;

    protected $table = 'produtos_tags';

    protected $fillable = [
        'fk_tag',
        'fk_produto',
    ];
    
    public $timestamps = false;
}
