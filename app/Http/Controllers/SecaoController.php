<?php

namespace App\Http\Controllers;

use App\Models\Estabelecimento;
use App\Models\Produto;
use App\Models\Secao;
use App\Services\SecaoService;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class SecaoController extends Controller
{
    protected $service = null;
    
    public function __construct( SecaoService $secaoService) {
        $this->service = $secaoService;
    }

    public function index($idEstabelecimento)
    {
        $estabelecimento = Estabelecimento::find($idEstabelecimento);

        $secoes = $estabelecimento->secoes;

        foreach($secoes as $secao){
            $secao->total_produto =count($secao->produtos);
        }

        return view('secoes.index',[
            'estabelecimento' => $estabelecimento,
            'secoes' => $secoes
        ]);
    }

    public function load($idEstabelecimento, Request $request)
    {
        $search = $request['search'];
        $estabelecimento = Estabelecimento::find($idEstabelecimento);
        $secoes = Secao::where('fk_estabelecimento', $estabelecimento->id);

        if(!empty($search)){
            $secoes->where('descricao', 'LIKE', '%'. $search .'%');
        }

        $page = $request['page'];
        $per_page = $request['per_page'];

        $secoes = $secoes->paginate($per_page, ['*'], 'page', $page);

        foreach($secoes as $secao){
            $secao->total_produto =count($secao->produtos);
        }

        $tableContent = view('secoes.table-content', [
            'secoes' => $secoes
        ])->render();

        $pagination = $secoes->links('pagination::bootstrap-5')->render();

        return response()->json([
            'tableContent' => $tableContent,
            'pagination' => $pagination
        ]);
    }

    public function create($idEstabelecimento)
    {
        $estabelecimento = Estabelecimento::find($idEstabelecimento);
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

    public function destroy($id)
    {
        $secao = $this->service->destroy($id);

        return $secao;
    }

    public function edit($id)
    {
        $secao = Secao::find($id);
        $estabelecimento = Estabelecimento::find($secao->fk_estabelecimento);
        $produtos = Produto::where('fk_secao', $id)->get();

        return view('secoes.edit', [
            'estabelecimento' => $estabelecimento,
            'produtos' => $produtos,
            'secao' => $secao
        ]);
    }

    public function update($id, Request $request)
    {
        $secao = $this->service->update($id, $request['secao.descricao']);

        return $secao;
    }
}
