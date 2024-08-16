<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\Estabelecimento;
use App\Services\AgendaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AgendaController extends Controller
{
    protected $service = null;

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

        return view('agendas.index', [
            'estabelecimento' => $estabelecimento,
            'agendas' => $agendas
        ]);
    }

    public function update(Request $request, $idEstabelecimento)
    {
        $agendas = $request['agenda'];

        $update = $this->service->update($agendas, $idEstabelecimento);
        
        return $update;
    }
}
