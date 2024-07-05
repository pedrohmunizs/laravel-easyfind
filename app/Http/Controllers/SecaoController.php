<?php

namespace App\Http\Controllers;

use App\Models\Estabelecimento;
use App\Services\SecaoService;
use Illuminate\Http\Request;

class SecaoController extends Controller
{
    protected $service = null;
    
    public function __construct( SecaoService $secaoService) {
        $this->service = $secaoService;
    }

    public function index($id)
    {
        $estabelecimento = Estabelecimento::where('id', $id)->first();

        $secoes = $estabelecimento->secoes;

        foreach($secoes as $secao){
            dd($secao->produtos);
        }

        return view('secoes.index',[
            'estabelecimento' => $estabelecimento,
            'secoes' => $secoes
        ]);
    }

    public function create($id)
    {
        $estabelecimento = Estabelecimento::where('id', $id)->first();
        return view('secoes.create',[
            'estabelecimento' => $estabelecimento
        ]);
    }

    public function store(Request $request)
    {
        $secao = $request['secao'];
        $secao = $this->service->store($secao);
        
        return $secao;
    }
}
