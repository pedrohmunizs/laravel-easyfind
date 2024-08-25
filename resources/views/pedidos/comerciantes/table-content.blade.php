@if(count($pedidos) > 0)
    @foreach($pedidos as $pedido)
        <tr>
            <td><h6 class="m-0">#{{$pedido->id}}</h6></td>
            <td>
                <div class="d-flex flex-column">
                    <p class="m-0">{{$pedido->itensVenda[0]->consumidor->user->nome}}</p>
                    <p class="m-0 fs-14 fc-gray">{{$pedido->itensVenda[0]->consumidor->user->email}}</p>
                </div>
            </td>
            <td>R$ {{ number_format($pedido->transacao->valor, 2, ',', '.') }}</td>
            <td>
                @if($pedido->is_pagamento_online)
                    <p class="m-0">Pagamento no site</p>
                @else
                    <p class="m-0">Pagamento na loja</p>
                @endif
            </td>

            <td>
                @if($pedido->status->value == App\Enums\StatusPedido::Pendente->value)
                    <p class="m-0 bgc-blue fc-light-blue py-1 px-3 w-fit-content rounded-pill"> {{$pedido->status->name}} </p>
                @elseif($pedido->status->value == App\Enums\StatusPedido::EmPreparo->value)
                    <p class="m-0 bgc-orange fc-orange py-1 px-3 w-fit-content rounded-pill"> Em Preparo </p>
                @elseif($pedido->status->value == App\Enums\StatusPedido::AguardandoRetirada->value)
                    <p class="m-0 bgc-gray fc-black py-1 px-3 w-fit-content rounded-pill"> Aguardando Retirada </p>
                @elseif($pedido->status->value == App\Enums\StatusPedido::Finalizado->value)
                    <p class="m-0 bgc-green fc-green py-1 px-3 w-fit-content rounded-pill"> {{$pedido->status->name}} </p>
                @else
                    <p class="m-0 bgc-red fc-red py-1 px-3 w-fit-content rounded-pill"> {{$pedido->status->name}} </p>
                @endif
            </td>
            <td>
                <a href="/pedidos/{{$estabelecimento}}/show/{{ $pedido->id }}" class="btn-clean" title="Editar produto"><i class="bi bi-eye fs-20 btn-color-default hover-default"></i></a>
            </td>
        </tr>
    @endforeach
@else
    <div class="d-flex flex-column px-3 pt-2">
        <h6 class="m-0">Sem pedidos</h6>
    </div>
@endif