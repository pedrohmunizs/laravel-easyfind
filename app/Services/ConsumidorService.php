<?php

namespace App\Services;

use App\Models\Consumidor;
use Exception;

class ConsumidorService
{
    protected $userService;

    public function __construct(UserService $userService) {
        $this->userService = $userService;
    }

    public function store($request)
    {
        try{
            $usuario = $request['user'];
            $usuario['type'] = 'consumidor';
            $user = $this->userService->store($usuario);
            
            $data = $request['consumidor'];
            $data['cpf'] = str_replace(['.', '-'], '', $data['cpf']);
            $data['telefone'] = str_replace(['(', ')', '-', ' '], '', $data['telefone']);

            try{
                $consumidor = new Consumidor();
                
                $consumidor->fill($data);
                $consumidor->fk_usuario = $user->id;

                $consumidor->save();

            }catch(Exception $e){
                throw $e;
            }

            return response()->json(['message' => 'Usuário cadastrado com sucesso!'], 201);

        }catch(Exception $e){
            throw $e;
        }
    }
}