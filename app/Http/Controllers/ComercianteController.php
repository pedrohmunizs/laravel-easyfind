<?php

namespace App\Http\Controllers;

use App\Models\Comerciante;
use App\Models\User;
use App\Services\ComercianteService;
use App\Services\EnderecoService;
use App\Services\UserService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ComercianteController extends Controller
{
    protected $comercianteService = null;
    protected $userService = null;
    protected $enderecoService = null;
    
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
        try{
            $cpf = Validator::make($request->all(), [
                'comerciante.cpf' => 'required|cpf',
            ]);
        
            if ($cpf->fails()) {
                return response()->json(['error' => "Esse CPF não é válido!"], 400);
            }

            $cnpj = Validator::make($request->all(), [
                'comerciante.cnpj' => 'required|cnpj',
            ]);
        
            if ($cnpj->fails()) {
                return response()->json(['error' => "Esse CNPJ não é válido!"], 400);
            }

            $existeEmail = User::where("email", $request['usuario.email'])->first();
            
            if($existeEmail){
                return response()->json(['error' => "Esse email já está em uso!"], 409);
            }

            $existeCnpj = Comerciante::where("cnpj", $request['comerciante.cnpj'])->first();
            
            if($existeCnpj){
                return response()->json(['error' => "Esse CNPJ já foi cadastrado!"], 409);
            }

            $existeCpf = Comerciante::where("cpf", $request['comerciante.cpf'])->first();

            if($existeCpf){
                return response()->json(['error' => "Esse CPF já foi cadastrado!"], 409);
            }

            $comerciante = $this->comercianteService->store($request);
            return $comerciante;
        }catch(Exception $e){
            if ($e->getCode() == 409) {
                return response()->json(['error' => $e->getMessage()], 409);
            }
        }
    }

    public function management()
    {
        return view('comerciantes.management');
    }


    public function login(Request $request)
    {
        return view('users.index');
    }

    public function login1(Request $request)
    {
        $credentials = $request->only('email', 'password');
        
        if (Auth::attempt($credentials)) {
            $user = auth()->user();

            if ($user) {
                $user->load('comerciante');
                return redirect()->route('estabelecimentos.index');
            } else {
                return response()->json([
                    'message' => 'User not found after authentication.',
                ], 404);
            }
        } else {
            return response()->json([
                'message' => 'Login failed. Invalid credentials.',
            ], 401);
        }
    }
}
