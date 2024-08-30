<?php

namespace App\Http\Controllers;

use App\Enums\SegmentoEstabelecimento;
use App\Enums\StatusPedido;
use App\Models\Avaliacao;
use App\Models\Estabelecimento;
use App\Models\MetodoPagamento;
use App\Models\Pedido;
use App\Models\Produto;
use App\Models\Secao;
use App\Services\EstabelecimentoService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class EstabelecimentoController extends Controller
{
    protected $estabelecimentoService = null;

    public function __construct(EstabelecimentoService $estabelecimentoService)
    {
        $this->estabelecimentoService = $estabelecimentoService;
    }

    public function index()
    {
        if (Gate::denies('comerciante')) {
            abort(404);
        }

        return view('estabelecimentos.index');
    }

    public function create()
    {
        if (Gate::denies('comerciante')) {
            abort(404);
        }

        return view('estabelecimentos.create');
    }

    public function store(Request $request)
    {
        $existeEmail = Estabelecimento::where('email', $request['estabelecimento.email'])->first();

        if ($existeEmail) {
            return response()->json(['message' => 'Esse email já está em uso!'], 409);
        }

        $existeTelefone = Estabelecimento::where('telefone', $request['estabelecimento.telefone'])->first();

        if ($existeTelefone) {
            return response()->json(['message' => 'Esse telefone já está em uso!'], 409);
        }

        try{
            $this->estabelecimentoService->store($request);
            return response()->json(['message' => 'Estabelecimento cadastrado com sucesso!'], 201);
        }catch(Exception $e){
            return response()->json(['message' => 'Erro ao criar estabelecimento'], 500);
        }
    }

    public function load(Request $request)
    {
        $search = $request->input('search');

        $user = auth()->user();
        $comerciante = $user->comerciante;

        $estabelecimentos = Estabelecimento::query()
            ->when($search, function ($query, $search) use ($comerciante) {
                return $query->where('fk_comerciante', $comerciante->id)->where('is_ativo', true)->where('nome', 'LIKE', "%{$search}%");
            })
            ->unless($search, function ($query) use ($comerciante) {
                return $query->where('fk_comerciante', $comerciante->id)->where('is_ativo', true);
            })->get();

        foreach ($estabelecimentos as $estabelecimento) {

            if ($estabelecimento->secoes) {
                foreach ($estabelecimento->secoes as $secao) {
                    $produtos = $secao->produtos()->where('is_ativo', 1)->get();
                    $estabelecimento->total_produtos += count($produtos);
                }
            }

            $idEstabelecimento = $estabelecimento->id;
            $pedidos = Pedido::whereHas('itensVenda.produto.secao.estabelecimento', function ($query) use ($idEstabelecimento) {
                $query->where('estabelecimentos.id', $idEstabelecimento);
            })
                ->whereNotIn('status', [StatusPedido::Cancelado->value, StatusPedido::Finalizado->value])
                ->get();

            foreach (SegmentoEstabelecimento::cases() as $case) {
                if ($case->value == $estabelecimento->segmento) {
                    $estabelecimento->segmento = $case->name;
                    break;
                }
            }
            $estabelecimento->pedidos = count($pedidos);
        }

        return view('components.estabelecimentos.card', [
            'estabelecimentos' => $estabelecimentos
        ]);
    }

    public function edit($id)
    {
        if (Gate::denies('comerciante')) {
            abort(404);
        }

        $estabelecimento = Estabelecimento::find($id);

        return view('estabelecimentos.edit', [
            'estabelecimento' => $estabelecimento
        ]);
    }

    public function update($id, Request $request)
    {
        $estabelecimento = Estabelecimento::find($id);

        if(!$estabelecimento){
            return response()->json(['message' => 'Estabelecimento não existe!'], 409);
        }

        try{
            $this->estabelecimentoService->update($id, $request);
            return response()->json(['message' => 'Estabelecimento editado com sucesso!'], 201);
        }catch(Exception $e){
            return response()->json(['message' => 'Erro ao editar estabelecimento'], 500);
        }
    }

    public function search()
    {
        if(auth()->user()){
            if (Gate::denies('consumidor')) {
                abort(404);
            }
        }
        $metodos = MetodoPagamento::all();
        $estabelecimentos = Estabelecimento::where('is_ativo', true)->get();

        foreach($estabelecimentos as $estabelecimento){
            $produtosEstabelecimento = [];
            $count = 0;
            foreach($estabelecimento->secoes as $secao){
                foreach($secao->produtos->where('is_ativo', true) as $produto){
                    if ($count < 3) {
                        array_push($produtosEstabelecimento, $produto);
                        $count++;
                    } else {
                        break ;
                    }
                }
            }

            $secoes = Secao::where('fk_estabelecimento', $estabelecimento->id)->pluck('id');
            $produtos = Produto::whereIn('fk_secao', $secoes)->get();
            $avaliacoesEstabelecimento = Avaliacao::whereIn('fk_produto', $produtos->pluck('id'))->get()->toArray();

            $idEstabelecimento = $estabelecimento->id;
            $vendas = Pedido::whereHas('itensVenda.produto.secao.estabelecimento', function ($query) use ($idEstabelecimento) {
                $query->where('estabelecimentos.id', $idEstabelecimento);
            })
                ->where('status', StatusPedido::Finalizado->value)
                ->get();

            $estabelecimento->avaliacoes = $avaliacoesEstabelecimento;
            $estabelecimento->vendas = count($vendas);
            $estabelecimento->produtos_filtrados = $produtosEstabelecimento;
        }

        return view('estabelecimentos.search',[
            'estabelecimentos' => $estabelecimentos,
            'metodos' => $metodos
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

        $estabelecimentos = Estabelecimento::where('is_ativo', true);

        if(isset($search)){
            $estabelecimentos = $estabelecimentos->where('nome', 'LIKE', '%'.$search.'%');
        }

        if(isset($filter)){
            if(isset($filter['segmento'])){
                $estabelecimentos = $estabelecimentos->where('segmento', $filter['segmento']);
            }

            if(isset($filter['metodo'])){
                $metodoId = $filter['metodo'];
                $estabelecimentos = Estabelecimento::whereHas('metodosPagamentosAceito.bandeiraMetodo.metodoPagamento', function ($estabelecimento) use ($metodoId) {
                    $estabelecimento->where('id', $metodoId);
                });
            }
        }

        $estabelecimentos = $estabelecimentos->get();
        
        if(isset($filter['distancia'])){

            $distanciaMax = $filter['distancia'];

            $estabelecimentos = $estabelecimentos->filter(function ($estabelecimento) use ($latitudeUser, $longitudeUser, $distanciaMax) {
                $endereco = $estabelecimento->endereco;
                $latitudeProduto = $endereco->latitude;
                $longitudeProduto = $endereco->longitude;
    
                $distancia = $this->haversineGreatCircleDistance($latitudeUser, $longitudeUser, $latitudeProduto, $longitudeProduto);
    
                return $distancia <= $distanciaMax;
            })->values();
        }

        foreach($estabelecimentos as $estabelecimento){
            $produtosEstabelecimento = [];
            $count = 0;
            foreach($estabelecimento->secoes as $secao){
                foreach($secao->produtos->where('is_ativo', true) as $produto){
                    if ($count < 3) {
                        array_push($produtosEstabelecimento, $produto);
                        $count++;
                    } else {
                        break ;
                    }
                }
            }

            $estabelecimento->produtos_filtrados = $produtosEstabelecimento;
        }

        $estabelecimentos = view('components.estabelecimentos.card-search', [
            'estabelecimentos' => $estabelecimentos
        ])->render();

        return response()->json([
            'estabelecimentos' => $estabelecimentos
        ]);
    }

    public function show($id)
    {
        $estabelecimento = Estabelecimento::find($id);
        $metodos = MetodoPagamento::all();
        $secoes = $estabelecimento->secoes->pluck('id');
        $produtos = Produto::whereIn('fk_secao', $secoes)->where('is_ativo', true)->get();
            
        $avaliacoes = Avaliacao::whereIn('fk_produto', $produtos->pluck('id'))->pluck('qtd_estrela');

        $idEstabelecimento = $estabelecimento->id;
        $vendas = Pedido::whereHas('itensVenda.produto.secao.estabelecimento', function ($query) use ($idEstabelecimento) {
                $query->where('estabelecimentos.id', $idEstabelecimento);
        })
            ->where('status', StatusPedido::Finalizado->value)
            ->with(['itensVenda' => function($query) {
                $query->select('itens_venda.*')
                    ->groupBy('itens_venda.id');
            }])->get();

        return view('estabelecimentos.show', [
            'estabelecimento' => $estabelecimento,
            'produtos' => $produtos,
            'vendas' => count($vendas),
            'avaliacoes' => $avaliacoes,
            'metodos' => $metodos
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
