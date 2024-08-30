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

            $consumidor = new Consumidor();

            $consumidor->fill($data);
            $consumidor->fk_usuario = $user->id;

            $consumidor->save();

            return $consumidor;

        }catch(Exception $e){
            if(isset($user)){
                $this->userService->destroy($user->id);
            }

            throw new Exception("Erro ao criar o usuário: " . $e->getMessage());
        }
    }

    public function update($id, $request)
    {
        $consumidor = Consumidor::where('fk_usuario', $id)->first();

        $usuario = $this->userService->store($request['user'], $consumidor->user->id);

        $data = $request['consumidor'];
        $data['cpf'] = str_replace(['.', '-'], '', $data['cpf']);
        $data['telefone'] = str_replace(['(', ')', '-', ' '], '', $data['telefone']);

        $consumidor->fill($data);
        $consumidor->fk_usuario = $usuario->id;

        $consumidor->save();

        return $consumidor;
    }
}