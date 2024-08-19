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
    protected $enderecoService;
    protected $agendaService;
    protected $imagemService;
    protected $cepService;
    
    public function __construct( EnderecoService $enderecoService, AgendaService $agendaService, ImagemService $imagemService, CepAbertoService $cepAbertoService) {
        $this->enderecoService = $enderecoService;
        $this->agendaService = $agendaService;
        $this->imagemService = $imagemService;
        $this->cepService = $cepAbertoService;
    }

    public function store($request)
    {
        try{
            $data = $request['endereco'];
            $data['cep'] = str_replace('-', '', $data['cep']);

            $cepData = $this->cepService->getCep($data['cep']);

            $endereco = $this->enderecoService->store($data, $cepData);

            $data = $request['estabelecimento'];
            $data['telefone'] = str_replace(['(', ')', '-', ' '], '', $data['telefone']);

            try{
                $estabelecimento = new Estabelecimento();
                $estabelecimento->fill($data);
                $estabelecimento->is_ativo = true;
                $estabelecimento->fk_endereco = $endereco->id;
                $estabelecimento->fk_comerciante = auth()->user()->comerciante->id;

                $estabelecimento->save();

            }catch(Exception $e){
                throw $e;
            }
            
            if($request['agenda']){
                $this->agendaService->store($request['agenda'], $estabelecimento->id);
            }
            
            if($request->hasFile('image') && $request->file('image')->isValid()){
                $this->imagemService->storeEstabelecimento($request->file('image'), $estabelecimento->id);
            }

            return response()->json(['message' => 'Estabelecimento cadastrado com sucesso!'], 201);

        }catch(Exception $e){
            throw $e;
        }
    }

    public function update($id, $data)
    {
        try{
            $estabelecimento = Estabelecimento::find($id);

            if(!$estabelecimento){
                return response()->json(['message' => 'Estabelecimento não existe!'], 409);
            }

            $endereco = $data['endereco'];
            $endereco['cep'] = str_replace('-', '', $endereco['cep']);

            $cepData = $this->cepService->getCep($endereco['cep']);

            $endereco = $this->enderecoService->update($estabelecimento->fk_endereco, $endereco, $cepData);

            $dataEstabelecimento = $data['estabelecimento'];
            $dataEstabelecimento['telefone'] = str_replace(['(', ')', '-', ' '], '', $dataEstabelecimento['telefone']);

            try{
                $estabelecimento->fill($dataEstabelecimento);
                $estabelecimento->is_ativo = true;
                $estabelecimento->fk_endereco = $endereco->id;
                $estabelecimento->fk_comerciante = auth()->user()->comerciante->id;

                $estabelecimento->save();

            }catch(Exception $e){
                throw $e;
            }

            if($data['agenda']){
                $this->agendaService->update($data['agenda'], $estabelecimento->id);
            }

            if($data->hasFile('image') && $data->file('image')->isValid()){
                $this->imagemService->storeEstabelecimento($data->file('image'), $estabelecimento->id);
            }

            return response()->json(['message' => 'Estabelecimento editado com sucesso!'], 201);

        }catch(Exception $e){
            throw $e;
        }
    }
}