<?php

namespace App\Http\Controllers;

use App\Models\Carrinho;
use App\Services\CarrinhoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CarrinhoController extends Controller
{
    protected $service = null;

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
        
        $carrinho = $this->service->store($data, $consumidor->id);

        return $carrinho;
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
        return $this->service->update($carrinho, $quantidade);
    }
}
