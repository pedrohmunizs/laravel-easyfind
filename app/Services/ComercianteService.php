<?php

namespace App\Services;

use App\Models\Comerciante;
use App\Models\User;
use App\Models\Usuario;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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

            try{
                $comerciante = new Comerciante();
                $comerciante->fill($data);
                $comerciante->fk_usuario =  $user->id;
                $comerciante->fk_endereco =  $endereco->id;

                $comerciante->save();

            }catch(Exception $e){
                throw $e;
            }
            
            return response()->json(['message' => 'Usuário cadastrado com sucesso!'], 201);

        }catch(Exception $e){
            throw $e;
        }
    }

    public function update($id, $data)
    {
        try{
            $comerciante = Comerciante::find($id);

            $usuario = $data['usuario'];
            $user = $this->userService->update($comerciante->user->id, $usuario);

            $enderecoData = $data['endereco'];
            $enderecoData['cep'] = str_replace('-', '', $enderecoData['cep']);

            $cepData = $this->cepService->getCep($enderecoData['cep']);

            $endereco = $this->enderecoService->update($comerciante->fk_endereco, $enderecoData, $cepData);

            $dataComerciante = $data['comerciante'];

            $dataComerciante['cpf'] = str_replace(['.', '-'], '', $dataComerciante['cpf']);
            $dataComerciante['cnpj'] = str_replace(['.', '/', '-'], '', $dataComerciante['cnpj']);
            $dataComerciante['telefone'] = str_replace(['(', ')', '-', ' '], '', $dataComerciante['telefone']);

            try{
                $comerciante->fill($dataComerciante);
                $comerciante->fk_usuario =  $user->id;
                $comerciante->fk_endereco =  $endereco->id;

                $comerciante->save();

            }catch(Exception $e){
                throw $e;
            }

            return response()->json(['message' => 'Usuário editado com sucesso!'], 201);

        }catch(Exception $e){
            throw $e;
        }
    }
}