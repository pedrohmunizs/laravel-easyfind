<?php

namespace App\Http\Controllers;

use App\Models\Estabelecimento;
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
            return response()->json(['error' => 'Esse email já está em uso!'], 409);
        }

        $existeTelefone = Estabelecimento::where('telefone', $request['estabelecimento.telefone'])->first();

        if ($existeTelefone) {
            return response()->json(['error' => 'Esse telefone já está em uso!'], 409);
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
        }

        return view('components.estabelecimentos.card', [
            'estabelecimentos' => $estabelecimentos
        ]);
    }
}
