<?php

namespace App\Http\Controllers;

use App\Enums\StatusPedido;
use App\Models\Estabelecimento;
use App\Models\Pedido;
use App\Services\EstabelecimentoService;
use Illuminate\Http\Request;

class EstabelecimentoController extends Controller
{
    protected $estabelecimentoService = null;

    public function __construct(EstabelecimentoService $estabelecimentoService)
    {
        $this->estabelecimentoService = $estabelecimentoService;
    }

    public function index()
    {
        return view('estabelecimentos.index');
    }

    public function create()
    {
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

        $estabelecimento = $this->estabelecimentoService->store($request);
        return $estabelecimento;
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

            $pedidos = Pedido::join('bandeiras_metodos', 'bandeiras_metodos.id', '=', 'pedidos.fk_metodo_aceito')
                ->join('metodos_pagamento_aceitos', 'metodos_pagamento_aceitos.fk_metodo_pagamento', '=', 'bandeiras_metodos.id')
                ->join('estabelecimentos', 'metodos_pagamento_aceitos.fk_estabelecimento', '=', 'estabelecimentos.id')
                ->where('estabelecimentos.id', $estabelecimento->id)
                ->where('pedidos.status', StatusPedido::Pendente->value)
                ->select('pedidos.*')
                ->groupBy('pedidos.id')
                ->get();

            $estabelecimento->pedidos = count($pedidos);
        }

        return view('components.estabelecimentos.card', [
            'estabelecimentos' => $estabelecimentos
        ]);
    }
}
