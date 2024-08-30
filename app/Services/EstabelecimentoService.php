<?php

namespace App\Services;

use App\Models\Estabelecimento;
use App\Services\EnderecoService;
use Exception;

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

            $estabelecimento = new Estabelecimento();
            $estabelecimento->fill($data);
            $estabelecimento->is_ativo = true;
            $estabelecimento->fk_endereco = $endereco->id;
            $estabelecimento->fk_comerciante = auth()->user()->comerciante->id;

            $estabelecimento->save();
            
            if($request['agenda']){
                $agenda = $this->agendaService->store($request['agenda'], $estabelecimento->id);
            }
            
            if($request->hasFile('image') && $request->file('image')->isValid()){
                $this->imagemService->storeEstabelecimento($request->file('image'), $estabelecimento->id);
            }

            return $estabelecimento;

        }catch(Exception $e){

            if (isset($endereco)) {
                $this->enderecoService->destroy($endereco->id);
            }

            if(isset($agenda)){
                $this->agendaService->destroy($estabelecimento->id);
            }

            if(isset($estabelecimento)){
                $this->destroy($estabelecimento->id);
            }

            throw new Exception("Erro ao criar o estabelecimento: " . $e->getMessage());
        }
    }

    public function update($id, $data)
    {
        $estabelecimento = Estabelecimento::find($id);

        $endereco = $data['endereco'];
        $endereco['cep'] = str_replace('-', '', $endereco['cep']);
        $cepData = $this->cepService->getCep($endereco['cep']);
        $endereco = $this->enderecoService->store($endereco, $cepData, $estabelecimento->fk_endereco);

        $dataEstabelecimento = $data['estabelecimento'];
        $dataEstabelecimento['telefone'] = str_replace(['(', ')', '-', ' '], '', $dataEstabelecimento['telefone']);

        $estabelecimento->fill($dataEstabelecimento);
        $estabelecimento->is_ativo = true;
        $estabelecimento->fk_endereco = $endereco->id;
        $estabelecimento->fk_comerciante = auth()->user()->comerciante->id;

        $estabelecimento->save();

        if($data['agenda']){
            $this->agendaService->update($data['agenda'], $estabelecimento->id);
        }

        if($data->hasFile('image') && $data->file('image')->isValid()){
            $this->imagemService->storeEstabelecimento($data->file('image'), $estabelecimento->id);
        }

        return $estabelecimento;
    }

    private function destroy($id)
    {
        $estabelecimento = Estabelecimento::find($id);
        $estabelecimento->delete();
    }
}