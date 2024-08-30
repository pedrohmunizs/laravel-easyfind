<?php

namespace App\Http\Controllers;

use App\Models\Consumidor;
use App\Models\User;
use App\Services\ConsumidorService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

class ConsumidorController extends Controller
{
    protected $service;

    public function __construct(ConsumidorService $consumidorService) {
        $this->service = $consumidorService;
    }

    public function create()
    {
        return view('consumidores.create');
    }

    public function store(Request $request)
    {
        $email = Validator::make($request->all(), [
            'user.email' => 'required|email',
        ]);

        if ($email->fails()) {
            return response()->json(['message' => "Esse e-mail não é válido!"], 400);
        }

        $cpf = Validator::make($request->all(), [
            'consumidor.cpf' => 'required|cpf',
        ]);
    
        if ($cpf->fails()) {
            return response()->json(['message' => "Esse CPF não é válido!"], 400);
        }

        $existeCpf = Consumidor::where('cpf', $request['consumidor.cpf'])->first();

        if($existeCpf){
            return response()->json(['message' => "Esse CPF já está em uso!"], 409);
        }

        $existeEmail = User::where('email', $request['user.email'])->first();
            
        if($existeEmail){
            return response()->json(['message' => "Esse email já está em uso!"], 409);
        }

        try{
            $this->service->store($request);
            return response()->json(['message' => 'Usuário criado com sucesso!'], 201);
        }catch(Exception $e){
            return response()->json(['message' => 'Erro ao criar usuário'], 500);
        }
    }

    public function edit($id)
    {
        if (Gate::denies('comerciante')) {
            abort(404);
        }

        $usuario = User::find($id);

        return view('consumidores.edit', [
            'usuario' => $usuario
        ]);
    }

    public function update($id, Request $request)
    {
        $consumidor = Consumidor::find($id);

        if(!$consumidor){
            return response()->json(['message' => "Usuário não existente!"], 400);
        }

        $email = Validator::make($request->all(), [
            'user.email' => 'required|email',
        ]);

        if ($email->fails()) {
            return response()->json(['message' => "Esse e-mail não é válido!"], 400);
        }

        $cpf = Validator::make($request->all(), [
            'consumidor.cpf' => 'required|cpf',
        ]);
    
        if ($cpf->fails()) {
            return response()->json(['message' => "Esse CPF não é válido!"], 400);
        }

        try{
            $this->service->update($id, $request);
            return response()->json(['message' => 'Usuário editado com sucesso!'], 201);
        }catch(Exception $e){
            return response()->json(['message' => 'Erro ao editar usuário'], 500);
        }
    }
}
