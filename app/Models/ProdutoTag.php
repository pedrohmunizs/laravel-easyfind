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

    public function produto()
    {
        return $this->belongsTo(Produto::class, 'fk_produto', 'id');
    }

    public function tag()
    {
        return $this->belongsTo(Tag::class, 'fk_tag', 'id');
    }
    
    public $timestamps = false;
}
