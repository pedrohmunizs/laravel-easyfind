<?php

namespace App\Services;

use App\Models\Agenda;
use App\Models\Endereco;
use App\Models\Estabelecimento;
use App\Services\EnderecoService;
use Exception;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class EstabelecimentoService
{
    protected $enderecoService = null;
    protected $agendaService = null;
    protected $imagemService = null;
    
    public function __construct( EnderecoService $enderecoService, AgendaService $agendaService, ImagemService $imagemService) {
        $this->enderecoService = $enderecoService;
        $this->agendaService = $agendaService;
        $this->imagemService = $imagemService;
    }

    public function store($request)
    {
        try{

            $user = auth()->user();
            
            $data = $request['endereco'];
            $data['cep'] = str_replace('-', '', $data['cep']);

            $endereco = $this->enderecoService->store($data);

            $data = $request['estabelecimento'];
            $data['telefone'] = str_replace(['(', ')', '-', ' '], '', $data['telefone']);

            $estabelecimento = new Estabelecimento();
            $estabelecimento->fill($data);
            $estabelecimento->is_ativo = true;
            $estabelecimento->fk_endereco = $endereco->id;
            $estabelecimento->fk_comerciante = $user->comerciante->id;
            if(!$estabelecimento->save()){
                return response()->json(['error' => 'Erro ao salvar estabelecimento.'], 500);
            }
            
            if($request['agenda']){
                $this->agendaService->store($request['agenda'], $estabelecimento->id);
            }
            
            if($request->hasFile('image') && $request->file('image')->isValid()){
                $this->imagemService->storeEstabelecimento($request->file('image'), $estabelecimento->id);
            }

            return response()->json($estabelecimento, 201);

        }catch(Exception $e){
            throw $e;
        }
    }
    
}