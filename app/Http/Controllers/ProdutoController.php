<?php

namespace App\Http\Controllers;

use App\Models\Avaliacao;
use App\Models\Estabelecimento;
use App\Models\MetodoPagamento;
use App\Models\Produto;
use App\Models\Secao;
use App\Models\Tag;
use App\Services\ProdutoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    public function load($idEstabelecimento, Request $request)
    {
        $filter = $request['filter'];
        $search = $request['search'];
        list($column, $direction) = explode(',', $request['order']);

        $estabelecimento = Estabelecimento::where('id', $idEstabelecimento)->first();
        $produtosQuery = Produto::whereIn('fk_secao', $estabelecimento->secoes->pluck('id'))->orderBy($column, $direction);

        if(isset($filter)){

            if (isset($filter['status'])) {
                $produtosQuery->status($filter['status']);
            }
            
            if (isset($filter['preco_min'])) {

                $filter['preco_min'] = str_replace(".", "", $filter['preco_min']);
                $filter['preco_min'] = str_replace(',', '.', $filter['preco_min']);
                $filter['preco_min'] = number_format((float) $filter['preco_min'], 2, '.', '');

                if((float)$filter['preco_min'] > 0){
                    $produtosQuery->priceRange($filter['preco_min'], null);
                }
            }
            
            if (isset($filter['preco_max'])) {

                $filter['preco_max'] = str_replace(".", "", $filter['preco_max']);
                $filter['preco_max'] = str_replace(',', '.', $filter['preco_max']);
                $filter['preco_max'] = number_format((float) $filter['preco_max'], 2, '.', '');

                if((float)$filter['preco_max'] > 0){
                    $produtosQuery->priceRange(null, $filter['preco_max']);
                }
            }
            
            if (isset($filter['data_min'])) {
                $produtosQuery->dateRange($filter['data_min'], null);
            }
            
            if (isset($filter['data_max'])) {
                $produtosQuery->dateRange(null, $filter['data_max']);
            }
        }

        if(isset($search)){
            $produtosQuery->where('nome','LIKE', "%".$search."%");
        }
    
        $page = $request['page'];
        $perPage = $request['per_page'];
    
        $paginatedItems = $produtosQuery->paginate($perPage, ['*'], 'page', $page);

        $tableContent = view('produtos.table-content', [
            'produtos' => $paginatedItems
        ])->render();

        $pagination = $paginatedItems->links('pagination::bootstrap-5')->render();
    
        return response()->json([
            'tableContent' => $tableContent,
            'pagination' => $pagination
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

    public function destroy($id)
    {
        $produto = Produto::where('id', $id)->first();
        $produto->is_ativo = false;
        $produto->save();
        return $produto;
    }

    public function active($id)
    {
        $produto = Produto::where('id', $id)->first();
        $produto->is_ativo = true;
        $produto->save();
        return $produto;
    }

    public function show($id)
    {
        $produto = Produto::find($id);
        $metodos = MetodoPagamento::all();
        $avaliacoes = $produto->avaliacoes;

        $secoes = Secao::where('fk_estabelecimento', $produto->secao->estabelecimento->id)->pluck('id'); 
        $produtos = Produto::whereIn('fk_secao', $secoes)->get();
        
        $avaliacoesEstabelecimento = Avaliacao::whereIn('fk_produto', $produtos->pluck('id'))->get()->toArray();
        $totalEstabelecimento = $produtos->sum('qtd_vendas');

        return view('produtos.show',[
            'produto' => $produto,
            'metodos' => $metodos,
            'avaliacoes' => $avaliacoes,
            'avaliacoesEstabelecimento' => $avaliacoesEstabelecimento,
            'totalVendidosEstabelecimento' => $totalEstabelecimento,
            'totalProdutos' => count($produtos->where('is_ativo', true))
        ]);
    }

    public function search(Request $request)
    {
        $origem = $request['origem'];
        $tags = Tag::all();
        $metodos = MetodoPagamento::all();
        $produtos = Produto::where('is_ativo', true)->get();

        if($origem){
            $produtos = $this->loadSearch($request);
        }

        return view('produtos.search',[
            'tags' => $tags,
            'metodos' => $metodos,
            'produtos' => $produtos
        ]);
    }

    public function loadSearch(Request $request)
    {
        $filter = $request['filter'];
        $search = $request['search'];

        $produtos = Produto::where('produtos.is_ativo', true);

        if(isset($request['origem'])){
            $filter = json_decode(urldecode($filter), true);
        }

        if(isset($filter)){

            if (isset($filter['promocao'])) {
                $produtos->where('is_promocao_ativa',($filter['promocao']));
            }

            if (isset($filter['metodo'])) {

                $produtos->join('secoes', 'produtos.fk_secao', '=', 'secoes.id')
                ->join('estabelecimentos', 'secoes.fk_estabelecimento', '=', 'estabelecimentos.id')
                ->join('metodos_pagamento_aceitos', 'metodos_pagamento_aceitos.fk_estabelecimento', '=', 'estabelecimentos.id')
                ->join('bandeiras_metodos', 'metodos_pagamento_aceitos.fk_metodo_pagamento', '=', 'bandeiras_metodos.id')
                ->join('metodos_pagamento', 'bandeiras_metodos.fk_metodo_pagamento', '=', 'metodos_pagamento.id')
                ->where('metodos_pagamento.id',($filter['metodo']))
                ->select('produtos.*')
                ->groupBy('produtos.id');
            }

            if (isset($filter['tag'])) {

                $produtos->join('produtos_tags', 'produtos.id', '=', 'produtos_tags.fk_produto')
                     ->join('tags', 'produtos_tags.fk_tag', '=', 'tags.id')
                     ->where('tags.id', $filter['tag'])
                     ->select('produtos.*')
                     ->groupBy('produtos.id');
            }
            
            if (isset($filter['preco_min'])) {

                $filter['preco_min'] = str_replace(".", "", $filter['preco_min']);
                $filter['preco_min'] = str_replace(',', '.', $filter['preco_min']);
                $filter['preco_min'] = number_format((float) $filter['preco_min'], 2, '.', '');

                if((float)$filter['preco_min'] > 0){
                    $produtos->priceRange($filter['preco_min'], null);
                }
            }
            
            if (isset($filter['preco_max'])) {

                $filter['preco_max'] = str_replace(".", "", $filter['preco_max']);
                $filter['preco_max'] = str_replace(',', '.', $filter['preco_max']);
                $filter['preco_max'] = number_format((float) $filter['preco_max'], 2, '.', '');

                if((float)$filter['preco_max'] > 0){
                    $produtos->priceRange(null, $filter['preco_max']);
                }
            }

            if(isset($filter['segmento'])){

                $produtos->join('secoes', 'produtos.fk_secao', '=', 'secoes.id')
                ->join('estabelecimentos', 'secoes.fk_estabelecimento', '=', 'estabelecimentos.id')
                ->where('estabelecimentos.segmento', $filter['segmento'])
                ->select('produtos.*')
                ->groupBy('produtos.id');
            }
        }

        if(isset($search)){
            $produtos->where('nome','LIKE', "%".$search."%");
        }

        if(isset($request['origem'])){
            return $produtos->get();
        }

        $produtos = view('components.produtos.card', [
            'produtos' => $produtos->get()
        ])->render();

        return response()->json([
            'produtos' => $produtos
        ]);
    }
}
