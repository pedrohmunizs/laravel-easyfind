<?php

namespace App\Http\Controllers;

use App\Models\Comerciante;
use App\Models\User;
use App\Services\ComercianteService;
use App\Services\EnderecoService;
use App\Services\UserService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

class ComercianteController extends Controller
{
    protected $comercianteService;
    protected $userService;
    protected $enderecoService;
    
    public function __construct(UserService $userService, EnderecoService $enderecoService, ComercianteService $comercianteService ) {
        $this->comercianteService = $comercianteService;
        $this->userService = $userService;
        $this->enderecoService = $enderecoService;
    }

    public function create()
    {
        return view('comerciantes.create');
    }

    public function store(Request $request)
    {
        $cpf = Validator::make($request->all(), [
            'comerciante.cpf' => 'required|cpf',
        ]);
    
        if ($cpf->fails()) {
            return response()->json(['message' => "Esse CPF não é válido!"], 400);
        }

        $cnpj = Validator::make($request->all(), [
            'comerciante.cnpj' => 'required|cnpj',
        ]);
    
        if ($cnpj->fails()) {
            return response()->json(['message' => "Esse CNPJ não é válido!"], 400);
        }

        $existeEmail = User::where("email", $request['usuario.email'])->first();
        
        if($existeEmail){
            return response()->json(['message' => "Esse email já está em uso!"], 409);
        }

        $existeCnpj = Comerciante::where("cnpj", $request['comerciante.cnpj'])->first();
        
        if($existeCnpj){
            return response()->json(['message' => "Esse CNPJ já foi cadastrado!"], 409);
        }

        $existeCpf = Comerciante::where("cpf", $request['comerciante.cpf'])->first();

        if($existeCpf){
            return response()->json(['message' => "Esse CPF já foi cadastrado!"], 409);
        }

        try{
            $this->comercianteService->store($request);
            return response()->json(['message' => 'Usuário cadastrado com sucesso!'], 201);
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

        return view ('comerciantes.edit', [
            'usuario' => $usuario
        ]);
    }

    public function update($id, Request $request)
    {
        $comerciante = Comerciante::find($id);

        if(!$comerciante){
            return response()->json(['message' => "Usuário não existente!"], 400);
        }

        $cpf = Validator::make($request->all(), [
            'comerciante.cpf' => 'required|cpf',
        ]);
    
        if ($cpf->fails()) {
            return response()->json(['message' => "Esse CPF não é válido!"], 400);
        }

        $cnpj = Validator::make($request->all(), [
            'comerciante.cnpj' => 'required|cnpj',
        ]);
    
        if ($cnpj->fails()) {
            return response()->json(['message' => "Esse CNPJ não é válido!"], 400);
        }

        $existeEmail = User::where("email", $request['usuario.email'])->whereNot("id", auth()->user()->id)->first();
        
        if($existeEmail){
            return response()->json(['message' => "Esse email já está em uso!"], 409);
        }

        $existeCnpj = Comerciante::where("cnpj", $request['comerciante.cnpj'])->whereNot("id", $id)->first();
        
        if($existeCnpj){
            return response()->json(['message' => "Esse CNPJ já foi cadastrado!"], 409);
        }

        $existeCpf = Comerciante::where("cpf", $request['comerciante.cpf'])->whereNot("id", $id)->first();

        if($existeCpf){
            return response()->json(['message' => "Esse CPF já foi cadastrado!"], 409);
        }

        try{
            $this->comercianteService->update($id, $request);
            return response()->json(['message' => 'Usuário editado com sucesso!'], 201);
        }catch(Exception $e){
            return response()->json(['message' => 'Erro ao editar usuário'], 500);
        }
    }
}
