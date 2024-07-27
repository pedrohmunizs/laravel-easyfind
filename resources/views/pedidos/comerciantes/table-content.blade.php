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
            @if($pedido->status->value == $statusEnum::Pendente->value)
                <p class="m-0 bgc-blue fc-light-blue py-1 px-3 w-fit-content rounded-pill"> {{$pedido->status}} </p>
            @elseif($pedido->status->value == $statusEnum::EmPreparo->value)
                <p class="m-0 bgc-blue fc-light-blue py-1 px-3 w-fit-content rounded-pill"> {{$pedido->status}} </p>
            @elseif($pedido->status->value == $statusEnum::AguardandoRetirada->value)
                <p class="m-0 bgc-blue fc-light-blue py-1 px-3 w-fit-content rounded-pill"> {{$pedido->status}} </p>
            @elseif($pedido->status->value == $statusEnum::Finalizado->value)
                <p class="m-0 bgc-blue fc-light-blue py-1 px-3 w-fit-content rounded-pill"> {{$pedido->status}} </p>
            @else
                <p class="m-0 bgc-blue fc-light-blue py-1 px-3 w-fit-content rounded-pill"> {{$pedido->status}} </p>
            @endif
        </td>
        <td>
            <a href="{{ $pedido->id }}/edit" class="btn-clean" title="Editar produto"><i class="bi bi-eye fs-20 btn-color-default hover-default"></i></a>
        </td>
    </tr>
@endforeach