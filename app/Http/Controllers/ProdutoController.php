<?php

namespace App\Http\Controllers;

use App\Enums\StatusPedido;
use App\Models\Avaliacao;
use App\Models\Carrinho;
use App\Models\Estabelecimento;
use App\Models\ItemVenda;
use App\Models\MetodoPagamento;
use App\Models\Pedido;
use App\Models\Produto;
use App\Models\ProdutoTag;
use App\Models\Secao;
use App\Models\Tag;
use App\Services\CarrinhoService;
use App\Services\ImagemService;
use App\Services\ProdutoService;
use App\Services\ProdutoTagService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class ProdutoController extends Controller
{

    protected $service;
    protected $carrinhoService;
    protected $imagemService;
    protected $produtoTagService;

    public function __construct(ProdutoService $service, CarrinhoService $carrinhoService, ImagemService $imagemService, ProdutoTagService $produtoTagService) {
        $this->service = $service;
        $this->carrinhoService = $carrinhoService;
        $this->imagemService = $imagemService;
        $this->produtoTagService = $produtoTagService;
    }

    public function index($idEstabelecimento)
    {
        if (Gate::denies('comerciante')) {
            abort(404);
        }

        $estabelecimento = Estabelecimento::find($idEstabelecimento);
        $secoes = $estabelecimento->secoes;

        return view('produtos.index',[
            'estabelecimento' => $estabelecimento,
            'secoes' => $secoes
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

            if (isset($filter['promocao'])) {
                $produtosQuery->promocao($filter['promocao']);
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

            if(isset($filter['secao'])){
                $produtosQuery->whereHas('secao', function ($query) use ($filter) {
                    $query->where('id', $filter['secao']);
                });
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
        if (Gate::denies('comerciante')) {
            abort(404);
        }

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
        
        $produto['preco'] = trim(substr($produto['preco'], 2));
        $produto['preco'] = str_replace(".", "", $produto['preco']);
        $produto['preco'] = str_replace(',', '.', $produto['preco']);
        $produto['preco'] = number_format((float) $produto['preco'], 2, '.', '');

        $produto['preco_oferta'] = trim(substr($produto['preco_oferta'], 2));
        $produto['preco_oferta'] = str_replace(".", "", $produto['preco_oferta']);
        $produto['preco_oferta'] = str_replace(',', '.', $produto['preco_oferta']);
        $produto['preco_oferta'] = number_format((float) $produto['preco_oferta'], 2, '.', '');
        
        $produto = $this->service->store($produto, $request['produto_tag']);

        return $produto;
    }

    public function edit($id)
    {
        if (Gate::denies('comerciante')) {
            abort(404);
        }

        $produto = Produto::find($id);
        $estabelecimento = Estabelecimento::find($produto->secao->estabelecimento->id);

        return view('produtos.edit', [
            'estabelecimento' => $estabelecimento,
            'produto' => $produto,
            'secoes' => $estabelecimento->secoes,
            'tags' => Tag::all()
        ]);
    }

    public function update($id, Request $request)
    {
        $produto = $request['produto']; 

        if(!isset($produto['is_promocao_ativa'])){
            $produto['is_promocao_ativa'] = false;
        }else{
            $produto['is_promocao_ativa'] = true;
        }

        $produto['preco'] = trim(substr($produto['preco'], 2));
        $produto['preco'] = str_replace(".", "", $produto['preco']);
        $produto['preco'] = str_replace(',', '.', $produto['preco']);
        $produto['preco'] = number_format((float) $produto['preco'], 2, '.', '');

        $produto['preco_oferta'] = trim(substr($produto['preco_oferta'], 2));
        $produto['preco_oferta'] = str_replace(".", "", $produto['preco_oferta']);
        $produto['preco_oferta'] = str_replace(',', '.', $produto['preco_oferta']);
        $produto['preco_oferta'] = number_format((float) $produto['preco_oferta'], 2, '.', '');
        
        $produto = $this->service->update($id, $produto, $request['produto_tag']);

        return $produto;
    }

    public function destroy($id)
    {
        $produto = Produto::find($id);

        $pedidos = ItemVenda::where('fk_produto', $id)->first();

        if(!$pedidos){

            $carrinhos = Carrinho::where('fk_produto', $id)->get();

            if($carrinhos){
                foreach($carrinhos as $carrinho){
                    $this->carrinhoService->destroy($carrinho);
                }
            }

            $tags = ProdutoTag::where("fk_produto", $id)->get();

            if($tags){
                foreach($tags as $tag){
                    $this->produtoTagService->destroy($tag->id);
                }
            }

            if(isset($produto->imagens)){
                foreach($produto->imagens as $imagem){
                    $this->imagemService->destroyAll($produto->id);
                }
            }

            $produto = $this->service->destroy($id);
            return $produto;
        }

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
        
        $vendas = Pedido::join('bandeiras_metodos', 'bandeiras_metodos.id', '=', 'pedidos.fk_metodo_aceito')
            ->join('metodos_pagamento_aceitos', 'metodos_pagamento_aceitos.fk_metodo_pagamento', '=', 'bandeiras_metodos.id')
            ->join('estabelecimentos', 'metodos_pagamento_aceitos.fk_estabelecimento', '=', 'estabelecimentos.id')
            ->where('estabelecimentos.id', $produto->secao->estabelecimento->id)
            ->whereNotIn('pedidos.status', [StatusPedido::Finalizado->value])
            ->select('pedidos.*')
            ->groupBy('pedidos.id')
            ->get();

        return view('produtos.show',[
            'produto' => $produto,
            'metodos' => $metodos,
            'avaliacoes' => $avaliacoes,
            'avaliacoesEstabelecimento' => $avaliacoesEstabelecimento,
            'totalVendidosEstabelecimento' => count($vendas),
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
        $localizacao = json_decode(urldecode($request['localizacao']), true);

        if($localizacao){   
            $latitudeUser = $localizacao['latitude'];
            $longitudeUser = $localizacao['longitude'];
        }

        $produtos = Produto::where('produtos.is_ativo', true);

        if(isset($request['origem'])){
            $filter = json_decode(urldecode($filter), true);
        }

        if(isset($filter)){

            if (isset($filter['promocao'])) {
                $produtos->promocao($filter['promocao']);
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

        $produtos = $produtos->get();

        if (isset($filter['distancia'])) {
            $distanciaMax = $filter['distancia'];
    
            $produtos = $produtos->filter(function ($produto) use ($latitudeUser, $longitudeUser, $distanciaMax) {
                $endereco = $produto->secao->estabelecimento->endereco;
                $latitudeProduto = $endereco->latitude;
                $longitudeProduto = $endereco->longitude;
    
                $distancia = $this->haversineGreatCircleDistance($latitudeUser, $longitudeUser, $latitudeProduto, $longitudeProduto);
    
                return $distancia <= $distanciaMax;
            })->values();
        }

        if(isset($request['origem'])){
            return $produtos;
        }

        $produtos = view('components.produtos.card', [
            'produtos' => $produtos
        ])->render();

        return response()->json([
            'produtos' => $produtos
        ]);
    }

    private function haversineGreatCircleDistance($latitudeUser, $longitudeUser, $latitudeProduto, $longitudeProduto, $earthRadius = 6371)
    {

        $latUser = deg2rad($latitudeUser);
        $lonUser = deg2rad($longitudeUser);
        $latProduto = deg2rad($latitudeProduto);
        $lonProduto = deg2rad($longitudeProduto);

        $latDelta = $latProduto - $latUser;
        $lonDelta = $lonProduto - $lonUser;

        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) + cos($latUser) * cos($latProduto) * pow(sin($lonDelta / 2), 2)));
        return $angle * $earthRadius;
    }

}
