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
    protected $userService = null;
    protected $enderecoService = null;
    
    public function __construct(UserService $userService, EnderecoService $enderecoService) {
        $this->userService = $userService;
        $this->enderecoService = $enderecoService;
    }

    public function store($request)
    {
        try{
            $usuario = $request['usuario'];
            $usuario['type'] = "comerciante";
            $user = $this->userService->store($usuario);

            $endereco = $this->enderecoService->store($request['endereco']);
            
            $comerciante = new Comerciante();
            $comerciante->fill($request['comerciante']);
            $comerciante->fk_usuario =  $user->id;
            $comerciante->fk_endereco =  $endereco->id;
            $comerciante->ultimo_acesso = now();
            
            if ($comerciante->save()) {                
                return response()->json($comerciante, 201);
            } else {
                return response()->json(['error' => 'Erro ao salvar comerciante.'], 500);
            }
        }catch(Exception $e){
            throw $e;
        }
    }
}