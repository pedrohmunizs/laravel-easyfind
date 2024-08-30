<?php

namespace App\Services;

use App\Models\Comerciante;
use Exception;

class ComercianteService
{
    protected $userService;
    protected $enderecoService;
    protected $cepService;
    
    public function __construct(UserService $userService, EnderecoService $enderecoService, CepAbertoService $cepAbertoService) {
        $this->userService = $userService;
        $this->enderecoService = $enderecoService;
        $this->cepService = $cepAbertoService;
    }

    public function store($request)
    {
        try{
            $usuario = $request['usuario'];
            $usuario['type'] = "comerciante";
            $user = $this->userService->store($usuario);

            $enderecoData = $request['endereco'];
            $enderecoData['cep'] = str_replace('-', '', $enderecoData['cep']);
            $cepData = $this->cepService->getCep($enderecoData['cep']);
            $endereco = $this->enderecoService->store($enderecoData, $cepData);
            
            $data = $request['comerciante'];

            $data['cpf'] = str_replace(['.', '-'], '', $data['cpf']);
            $data['cnpj'] = str_replace(['.', '/', '-'], '', $data['cnpj']);
            $data['telefone'] = str_replace(['(', ')', '-', ' '], '', $data['telefone']);

            $comerciante = new Comerciante();
            $comerciante->fill($data);
            $comerciante->fk_usuario =  $user->id;
            $comerciante->fk_endereco =  $endereco->id;

            $comerciante->save();
            
            return $comerciante;

        }catch(Exception $e){
            if (isset($endereco)) {
                $this->enderecoService->destroy($endereco->id);
            }

            if(isset($user)){
                $this->userService->destroy($user->id);
            }

            throw new Exception("Erro ao criar o usuário: " . $e->getMessage());
        }
    }

    public function update($id, $data)
    {
        $comerciante = Comerciante::find($id);

        $usuario = $data['usuario'];
        $user = $this->userService->store($usuario, $comerciante->user->id);

        $enderecoData = $data['endereco'];
        $enderecoData['cep'] = str_replace('-', '', $enderecoData['cep']);
        $cepData = $this->cepService->getCep($enderecoData['cep']);
        $endereco = $this->enderecoService->store($enderecoData, $cepData, $comerciante->fk_endereco);

        $dataComerciante = $data['comerciante'];

        $dataComerciante['cpf'] = str_replace(['.', '-'], '', $dataComerciante['cpf']);
        $dataComerciante['cnpj'] = str_replace(['.', '/', '-'], '', $dataComerciante['cnpj']);
        $dataComerciante['telefone'] = str_replace(['(', ')', '-', ' '], '', $dataComerciante['telefone']);

        $comerciante->fill($dataComerciante);
        $comerciante->fk_usuario =  $user->id;
        $comerciante->fk_endereco =  $endereco->id;

        $comerciante->save();

        return $comerciante;
    }
}