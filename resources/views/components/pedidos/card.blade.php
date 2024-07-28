@foreach($pedidos as $pedido)
    <div class="d-flex flex-column bg-white container-default p-3 col-md-3">
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
                </div>
                @break
            @endif
        @endforeach
        <div class="d-flex flex-row align-items-center justify-content-between">
            <div class="d-flex flex-row align-items-center gap-2">
                <i class="bi bi-calendar-check icon-pedido px-2 py-1 rounded-circle" style="color: #667085;"></i>
                <h6 class="m-0">Data do pedido</h6>
            </div>
            <p class="m-0">{{ $pedido->created_at->format('d/m/Y') }}</p>
        </div>
        <div class="d-flex flex-row mt-1 justify-content-between align-items-center">
            <div class="d-flex flex-row align-items-center gap-2">
                <i class="bi bi-currency-dollar icon-pedido px-2 py-1 rounded-circle" style="color: #667085;"></i>
                <h6 class="m-0">Valor total</h6>
            </div>
            <h6 class="m-0 py-1 px-3 rounded-pill fc-green" style="background-color: #E7F4EE;">R$ {{ number_format($pedido->transacao->valor, 2, ',', '.') }}</h6>
        </div>
        <div class="d-flex flex-row justify-content-between mt-3">
            @if($pedido->status->value == App\Enums\StatusPedido::Pendente->value)
                <p class="m-0 bgc-blue fc-light-blue py-1 px-3 w-fit-content rounded-pill"> {{$pedido->status->name}} </p>
            @elseif($pedido->status->value == App\Enums\StatusPedido::EmPreparo->value)
                <p class="m-0 bgc-orange fc-orange py-1 px-3 w-fit-content rounded-pill"> Em Preparo </p>
            @elseif($pedido->status->value == App\Enums\StatusPedido::AguardandoRetirada->value)
                <p class="fs-14 m-0 bgc-gray fc-black py-1 px-3 w-fit-content rounded-pill"> Aguardando Retirada </p>
            @elseif($pedido->status->value == App\Enums\StatusPedido::Finalizado->value)
                <p class="m-0 bgc-green fc-green py-1 px-3 w-fit-content rounded-pill"> {{$pedido->status->name}} </p>
            @else
                <p class="m-0 bgc-red fc-red py-1 px-3 w-fit-content rounded-pill"> {{$pedido->status->name}} </p>
            @endif
            <a href="/pedidos/{{$pedido->id}}/show" class="a-button btn-default px-3 py-1 fs-14">Pedido</a>
        </div>
    </div>
@endforeach