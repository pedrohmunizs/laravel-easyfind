<?php

namespace App\Http\Controllers;

use App\Enums\StatusPedido;
use App\Models\Estabelecimento;
use App\Models\Pedido;
use App\Models\Produto;
use App\Models\Secao;
use App\Services\SecaoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class SecaoController extends Controller
{
    protected $service;
    
    public function __construct( SecaoService $secaoService) {
        $this->service = $secaoService;
    }

    public function index($idEstabelecimento)
    {
        if (Gate::denies('comerciante')) {
            abort(404);
        }

        $estabelecimento = Estabelecimento::find($idEstabelecimento);

        $secoes = $estabelecimento->secoes;

        foreach($secoes as $secao){
            $secao->total_produto =count($secao->produtos);
        }

        $pedidos = Pedido::whereHas('itensVenda.produto.secao.estabelecimento', function ($query) use ($idEstabelecimento) {
            $query->where('estabelecimentos.id', $idEstabelecimento);
        })
            ->whereNotIn('status', [StatusPedido::Cancelado->value, StatusPedido::Finalizado->value])
            ->get();

        return view('secoes.index',[
            'estabelecimento' => $estabelecimento,
            'secoes' => $secoes,
            'pedidos' => count($pedidos)
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
        if (Gate::denies('comerciante')) {
            abort(404);
        }

        $estabelecimento = Estabelecimento::find($idEstabelecimento);

        $pedidos = Pedido::whereHas('itensVenda.produto.secao.estabelecimento', function ($query) use ($idEstabelecimento) {
            $query->where('estabelecimentos.id', $idEstabelecimento);
        })
            ->whereNotIn('status', [StatusPedido::Cancelado->value, StatusPedido::Finalizado->value])
            ->get();

        return view('secoes.create',[
            'estabelecimento' => $estabelecimento,
            'pedidos' => count($pedidos)
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
        if (Gate::denies('comerciante')) {
            abort(404);
        }

        $secao = Secao::find($id);
        $estabelecimento = Estabelecimento::find($secao->fk_estabelecimento);
        $produtos = Produto::where('fk_secao', $id)->get();

        $idEstabelecimento = $estabelecimento->id;
        $pedidos = Pedido::whereHas('itensVenda.produto.secao.estabelecimento', function ($query) use ($idEstabelecimento) {
            $query->where('estabelecimentos.id', $idEstabelecimento);
        })
            ->whereNotIn('status', [StatusPedido::Cancelado->value, StatusPedido::Finalizado->value])
            ->get();

        return view('secoes.edit', [
            'estabelecimento' => $estabelecimento,
            'produtos' => $produtos,
            'secao' => $secao,
            'pedidos' => count($pedidos)
        ]);
    }

    public function update($id, Request $request)
    {
        $secao = $this->service->update($id, $request['secao.descricao']);

        return $secao;
    }
}
