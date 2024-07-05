<?php

namespace App\Http\Controllers;

use App\Models\Estabelecimento;
use App\Models\Tag;
use App\Services\ProdutoService;
use Illuminate\Http\Request;

class ProdutoController extends Controller
{

    protected $service = null;

    public function __construct(ProdutoService $service) {
        $this->service = $service;
    }

    public function index($idEstabelecimento)
    {
        $estabelecimento = Estabelecimento::where('id', $idEstabelecimento)->first();

        return view('produtos.index',[
            'estabelecimento' => $estabelecimento
        ]);
    }

    public function create($idEstabelecimento)
    {
        $estabelecimento = Estabelecimento::where('id', $idEstabelecimento)->first();
        return view('produtos.create',[
            'estabelecimento' => $estabelecimento,
            'secoes' => $estabelecimento->secoes,
            'tags' => Tag::all()
        ]);
    }

    public function store(Request $request)
    {
        $produto = $request['produto']; 

        if(!isset($produto['is_promocao_ativa'])){
            $produto['is_promocao_ativa'] = false;
        }else{
            $produto['is_promocao_ativa'] = true;
        }
        
        $produto = $this->service->store($produto, $request['produto_tag']);

        return $produto;
    }
}
