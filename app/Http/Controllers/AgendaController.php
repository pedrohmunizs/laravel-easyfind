<?php

namespace App\Http\Controllers;

use App\Enums\StatusPedido;
use App\Models\Agenda;
use App\Models\Estabelecimento;
use App\Models\Pedido;
use App\Services\AgendaService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AgendaController extends Controller
{
    protected $service;

    public function __construct(AgendaService $agendaService) {
        $this->service = $agendaService;
    }

    public function index($idEstabelecimento)
    {
        if (Gate::denies('comerciante')) {
            abort(404);
        }

        $estabelecimento = Estabelecimento::where('id', $idEstabelecimento)->first();
        $agendas = Agenda::where('fk_estabelecimento', $idEstabelecimento)->get();

        $pedidos = Pedido::whereHas('itensVenda.produto.secao.estabelecimento', function ($query) use ($idEstabelecimento) {
            $query->where('estabelecimentos.id', $idEstabelecimento);
        })
            ->whereNotIn('status', [StatusPedido::Cancelado->value, StatusPedido::Finalizado->value])
            ->get();

        return view('agendas.index', [
            'estabelecimento' => $estabelecimento,
            'agendas' => $agendas,
            'pedidos' => count($pedidos)
        ]);
    }

    public function update(Request $request, $idEstabelecimento)
    {
        $agendas = $request['agenda'];

        try{
            $this->service->update($agendas, $idEstabelecimento);
            return response()->json(['message' => 'Agenda editada com sucesso!'], 201);
        }catch(Exception $e){
            return response()->json(['message' => 'Erro ao editar agenda'], 500);
        }
    }
}
