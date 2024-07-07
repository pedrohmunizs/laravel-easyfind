<?php

namespace App\Http\Controllers;

use App\Models\Estabelecimento;
use App\Models\Produto;
use App\Models\Tag;
use App\Services\ProdutoService;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

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
        $filter = array_filter($request['filter']);
        $search = $request['search'];

        $estabelecimento = Estabelecimento::where('id', $idEstabelecimento)->first();
        $produtosQuery = Produto::whereIn('fk_secao', $estabelecimento->secoes->pluck('id'))->orderBy('created_at');

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
}
