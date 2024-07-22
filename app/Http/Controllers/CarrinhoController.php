<?php

namespace App\Http\Controllers;

use App\Models\Carrinho;
use App\Services\CarrinhoService;
use Illuminate\Http\Request;

class CarrinhoController extends Controller
{
    protected $service = null;

    public function __construct(CarrinhoService $carrinhoSerivce) {
        $this->service = $carrinhoSerivce;
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        $consumidor = $user->consumidor;

        $data = $request['carrinho'];

        $existe = Carrinho::where('fk_produto', $data['fk_produto'])->where('fk_consumidor', $consumidor->id)->first();

        if($existe){
            $carrinho = $this->service->update($existe, $data['quantidade']);
            return $carrinho;
        }
        
        $carrinho = $this->service->store($data, $consumidor->id);

        return $carrinho;
    }
}
