<?php

namespace App\Services;

use App\Enums\StatusPedido;
use App\Models\Pedido;
use Exception;

class PedidoService
{
    protected $itemService;
    protected $transacaoService;

    public function __construct(ItemVendaService $itemVendaService, TransacaoService $transacaoService) {
        $this->itemService = $itemVendaService;
        $this->transacaoService = $transacaoService;
    }

    public function store($request)
    {
        $data = $request['pedido'];

        try{
            $pedido = new Pedido();
            $pedido->fill($data);
            $pedido->status = StatusPedido::Pendente;

            $pedido->save();

        }catch(Exception $e){
            throw $e;
        }

        $itemVenda = $this->itemService->store($request, $pedido->id);

        $this->transacaoService->store($itemVenda, $pedido->id);

        return response()->json(['message' => 'Pedido realizado com sucesso!'], 201);
    }

    public function changeStatus($id, $status)
    {
        try{
            $pedido = Pedido::find($id);
            $pedido->status = $status;
            $pedido->save();
    
            return response()->json(['message' => 'Status do pedido atualizado com sucesso!'], 201);

        }catch(Exception $e){
            throw $e;
        }
    }
}