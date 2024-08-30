<?php

namespace App\Http\Controllers;

use App\Models\Carrinho;
use App\Services\CarrinhoService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CarrinhoController extends Controller
{
    protected $service;

    public function __construct(CarrinhoService $carrinhoSerivce) {
        $this->service = $carrinhoSerivce;
    }

    public function index()
    {
        if (Gate::denies('consumidor')) {
            abort(404);
        }

        $consumidor = auth()->user()->consumidor;
        $carrinhos = Carrinho::where('fk_consumidor', $consumidor->id)->get();

        return view('carrinhos.index', [
            'carrinhos' => $carrinhos
        ]);
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        $consumidor = $user->consumidor;

        $data = $request['carrinho'];

        $existe = Carrinho::where('fk_produto', $data['fk_produto'])->where('fk_consumidor', $consumidor->id)->first();

        if($existe){
            $quantidade = ($existe->quantidade + $data['quantidade']);
            $carrinho = $this->service->update($existe, $quantidade);
            return $carrinho;
        }

        try{
            $this->service->store($data, $consumidor->id);
            return response()->json(['message' => 'Produto adicionado ao carrinho!'], 201);
        }catch(Exception $e){
            return response()->json(['message' => 'Erro ao adicionar produto ao carrinho!'], 500);
        }
    }

    public function load()
    {
        $consumidor = auth()->user()->consumidor;

        $carrinhos = Carrinho::where('fk_consumidor', $consumidor->id)->get();

        $cards = view('components.carrinhos.card', [
            'carrinhos' => $carrinhos
        ])->render();
            
        return $cards;
    }

    public function update($id, Request $request)
    {
        $carrinho = Carrinho::find($id);
        $quantidade = null; 

        if($request['action'] == 'add'){
            $quantidade = $carrinho->quantidade + 1;
        }else{
            $quantidade = $carrinho->quantidade - 1;
        }

        if(!$quantidade){
            return $this->service->destroy($carrinho);
        }

        try{
            $this->service->update($carrinho, $quantidade);
            return response()->json(['message' => 'Quantidade atualizado com sucesso!'], 201);
        }catch(Exception $e){
            return response()->json(['message' => 'Erro ao atualizar quantidade do produto no carrinho!'], 500);
        }
    }
}
