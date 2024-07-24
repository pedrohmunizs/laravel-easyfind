@foreach($pedidos as $pedido)
    <div class="d-flex flex-column gap-2 bg-white container-default px-3 py-3 w-fit-content">
        @foreach($itensVenda as $item)
            @if($pedido->id == $item->fk_pedido)
                <div class="d-flex flex-row align-items-center justify-content-between">
                    <div class="d-flex flex-row gap-3">
                        <img src="/img/estabelecimentos/{{$item->produto->secao->estabelecimento->imagem->nome_referencia}}" alt="" style="height: 35px; width: 35px;">
                        <div class="d-flex flex-column">
                            <h6 class="m-0">{{$item->produto->secao->estabelecimento->nome}}</h6>
                            <p class="m-0 fs-14">{{$item->produto->secao->estabelecimento->endereco->logradouro}}, N° {{$item->produto->secao->estabelecimento->endereco->numero}}</p>
                        </div>
                    </div>
                    <p class="m-0">{{$pedido->status}}</p>
                </div>
                @break
            @endif
        @endforeach
        <div class="d-flex flex-row gap-4">
            <div class="d-flex flex-column gap-3">
                <div class="d-flex flex-column">
                    <label for="" class="label-default">Data do pedido</label>
                    <p class="m-0">{{ $pedido->created_at->format('d/m/Y - H:i') }}</p>
                </div>
                <div class="d-flex flex-column">
                    <label for="" class="label-default">Modo de compra</label>
                    @if($pedido->is_pagamento_online)
                        <p class="m-0">Pagamento no site</p>
                    @else
                        <p class="m-0">Pagamento no loja</p>
                    @endif
                </div>
            </div>
            <div class="d-flex flex-column gap-3">
                <div class="d-flex flex-column">
                    <label for="" class="label-default">Método de pagamento</label>
                    <p class="m-0">{{ $pedido->metodoPagamento->metodoPagamento->descricao }}</p>
                </div>
                <div class="d-flex flex-column">
                    <label for="" class="label-default">Bandeira do pagamento</label>
                    <p class="m-0">{{ $pedido->metodoPagamento->bandeiraPagamento->nome }}</p>
                </div>
            </div>
        </div>
        <div class="d-flex flex-row mt-1 justify-content-between align-items-center">
            <h6 class="m-0">Valor total: R$ {{ number_format($pedido->transacao->valor, 2, ',', '.') }}</h6>
            <a href="" class="a-button btn-default px-3 py-1">Ver pedido</a>
        </div>
    </div>
@endforeach