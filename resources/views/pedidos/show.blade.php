@extends('layouts.main')

@section('title', 'Pedido')

@section('content')
@include('includes.header')
<div class="col-md-12 px-4 py-5 d-flex flex-column gap-2">
    <h3 class="m-0">Pedidos</h3>
    <div class="d-flex flex-row gap-2">
        <a href="/pedidos" class="a-default">
            <p class="fc-primary">Seus pedidos</p>
        </a>
        <i class="bi bi-chevron-right fc-gray"></i>
        <p class="fc-gray">Pedido</p>
    </div>
    <div class="d-flex flex-column gap-3">
        <div class="d-flex flex-row col-md-10 gap-3">
            <div class="d-flex flex-column bg-white container-default p-3 col-md-5">
                <div class="d-flex flex-row justify-content-between">
                    <h5>Pedido #{{ $pedido->id }}</h5>
                    <p>{{ $pedido->status }}</p>
                </div>
                <div class="d-flex flex-row align-items-center justify-content-between">
                    <div class="d-flex flex-row align-items-center gap-2">
                        <i class="bi bi-calendar-check icon-pedido px-2 py-1 rounded-circle" style="color: #667085;"></i>
                        <h6 class="m-0">Adicionado</h6>
                    </div>
                    <p class="m-0">{{ $pedido->created_at->format('d/m/Y') }}</p>
                </div>
                <div class="d-flex flex-row align-items-center justify-content-between">
                    <div class="d-flex flex-row align-items-center gap-2">
                        <i class="bi bi-credit-card icon-pedido px-2 py-1 rounded-circle" style="color: #667085;"></i>
                        <h6 class="m-0">Método de pagamento</h6>
                    </div>
                    <p class="m-0">{{ $pedido->metodoPagamento->metodoPagamento->descricao }}</p>
                </div>
                <div class="d-flex flex-row align-items-center justify-content-between">
                    <div class="d-flex flex-row align-items-center gap-2">
                        <i class="bi bi-flag icon-pedido px-2 py-1 rounded-circle" style="color: #667085;"></i>
                        <h6 class="m-0">Bandeira de pagamento</h6>
                    </div>
                    <p class="m-0">{{ $pedido->metodoPagamento->bandeiraPagamento->nome }}</p>
                </div>
                <div class="d-flex flex-row align-items-center justify-content-between">
                    <div class="d-flex flex-row align-items-center gap-2">
                        <i class="bi bi-calendar-check icon-pedido px-2 py-1 rounded-circle" style="color: #667085;"></i>
                        <h6 class="m-0">Moda de compra</h6>
                    </div>
                    @if($pedido->is_pagamento_online)
                        <p class="m-0">Pagamento no site</p>
                    @else
                        <p class="m-0">Pagamento no loja</p>
                    @endif
                </div>
            </div>
            <div class="d-flex flex-column bg-white container-default p-3 col-md-7">
                <h5>Estabelecimento</h5>
                <div class="d-flex flex-column">
                    <div class="d-flex flex-row align-items-center justify-content-between">
                        <div class="d-flex flex-row align-items-center gap-2">
                            <i class="bi bi-shop-window icon-pedido px-2 py-1 rounded-circle" style="color: #667085;"></i>
                            <h6 class="m-0">Nome</h6>
                        </div>
                        <p class="m-0">{{ $pedido->itensVenda[0]->produto->secao->estabelecimento->nome}}</p>
                    </div>
                    <div class="d-flex flex-row align-items-center justify-content-between">
                        <div class="d-flex flex-row align-items-center gap-2">
                            <i class="bi bi-envelope icon-pedido px-2 py-1 rounded-circle" style="color: #667085;"></i>
                            <h6 class="m-0">Email</h6>
                        </div>
                        <p class="m-0">{{ $pedido->itensVenda[0]->produto->secao->estabelecimento->email }}</p>
                    </div>
                    <div class="d-flex flex-row align-items-center justify-content-between">
                        <div class="d-flex flex-row align-items-center gap-2">
                            <i class="bi bi-telephone icon-pedido px-2 py-1 rounded-circle" style="color: #667085;"></i>
                            <h6 class="m-0">Telefone</h6>
                        </div>
                        <p id="telefone" class="m-0">{{ $pedido->itensVenda[0]->produto->secao->estabelecimento->telefone }}</p>
                    </div>
                    <div class="d-flex flex-row align-items-center justify-content-between">
                        <div class="d-flex flex-row align-items-center gap-2">
                            <i class="bi bi-geo-alt icon-pedido px-2 py-1 rounded-circle" style="color: #667085;"></i>
                            <h6 class="m-0">Endereço</h6>
                        </div>
                        <p id="telefone" class="m-0">{{ $pedido->itensVenda[0]->produto->secao->estabelecimento->endereco->logradouro }} N°{{ $pedido->itensVenda[0]->produto->secao->estabelecimento->endereco->numero }}, Bairro {{ $pedido->itensVenda[0]->produto->secao->estabelecimento->endereco->bairro }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex flex-column col-md-12 gap-3">
            <div class="d-flex flex-column col-md-10 bg-white container-default">
                <div class="d-flex flex-row gap-3 px-3 pt-3">
                    <h4 class="m-0">Itens do pedido</h4>
                    <h6 class="m-0 py-1 px-3 rounded-pill fc-green" style="background-color: #E7F4EE;">{{count($pedido->itensVenda)}} Produto(s)</h6>
                </div>
                <div class="table-container shadow-sm" style="border: 0px solid #ced4da;">
                    <table class="table">
                        <thead class="" style="background-color: #F9F9FC;">
                            <tr>
                                <th scope="col"><h6 class="fc-black m-0">Produto</h6></th>
                                <th scope="col"><h6 class="fc-black m-0">SKU</h6></th>
                                <th scope="col"><h6 class="fc-black m-0">Quantidade</h6></th>
                                <th scope="col"><h6 class="fc-black m-0">Preço</h6></th>
                                <th scope="col"><h6 class="fc-black m-0">Total</h6></th>
                            </tr>
                        </thead>
                        <tbody id="table-content">
                            @foreach($pedido->itensVenda as $item)
                                <tr>
                                    <td>
                                        <div class="d-flex flex-row gap-2 align-items-center">
                                            @if($item->produto->imagens)
                                                @php
                                                    $imagens = json_decode($item->produto->imagens, true);
                                                @endphp
                                                @if(!empty($imagens))
                                                <img src="/img/produtos/{{ $imagens[0]['nome_referencia'] }}" alt="" style="height: 44px; width: 44px;">
                                                @else
                                                    <img src="/img/default.jpg" alt="" style="height: 44px; width: 44px;">
                                                @endif
                                            @endif
                                            <div class="d-flex flex-column">
                                                <p class="m-0">{{$item->produto->nome}}</p>
                                                <p class="m-0 fc-gray fs-14">{{$item->produto->secao->descricao}}</p>

                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $item->produto->codigo_sku }}</td>
                                    <td>{{ $item->quantidade }}</td>
                                    <td>R$ {{ number_format($item->valor, 2, ',', '.') }}</td>
                                    <td>R$ {{ number_format(($item->valor * $item->quantidade), 2, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="d-flex flex-row col-md-10 bg-white container-default p-3 align-items-center justify-content-between">
                <h5 class="m-0">Valor total</h5>
                <h6 class="m-0 py-1 px-3 rounded-pill fc-green" style="background-color: #E7F4EE;">R$ {{ number_format($pedido->transacao->valor, 2, ',', '.') }}</h6>
            </div>
        </div>
    </div>

</div>
@endsection

@section('script')
<script>
    $(document).ready(function() {
        $('#telefone').mask('(00) 00000-0000');
    });
</script>
@endsection
