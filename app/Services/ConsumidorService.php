<?php

namespace App\Services;

use App\Models\Consumidor;
use Exception;

class ConsumidorService
{
    protected $userService = null;

    public function __construct(UserService $userService) {
        $this->userService = $userService;
    }

    public function store($request)
    {
        try{
            $usuario = $request['user'];
            $usuario['type'] = 'consumidor';
            $user = $this->userService->store($usuario);
            
            $consumidor = new Consumidor();

            $data = $request['consumidor'];
            $data['cpf'] = str_replace(['.', '-'], '', $data['cpf']);
            $data['telefone'] = str_replace(['(', ')', '-', ' '], '', $data['telefone']);

            $consumidor->fill($data);
            $consumidor->fk_usuario = $user->id;
            $consumidor->save();
            
            return response()->json(['success' => 'Usuário cadastrado com sucesso!'], 201);
        }catch(Exception $e){
            throw $e;
        }
    }
}