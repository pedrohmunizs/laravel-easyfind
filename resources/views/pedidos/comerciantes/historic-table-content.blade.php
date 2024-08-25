@if(count($pedidos) > 0)
    @foreach($pedidos as $pedido)
        <tr>
            <td><h6 class="m-0">#{{$pedido->id}}</h6></td>
            <td>{{$pedido->created_at->format('d/m/Y')}}</td>
            <td><p class="m-0 cpf">{{$pedido->itensVenda[0]->consumidor->cpf}}</p></td>
            <td>
                @if($pedido->is_pagamento_online)
                    <p class="m-0">Pagamento no site</p>
                @else
                    <p class="m-0">Pagamento na loja</p>
                @endif
            </td>
            <td>R$ {{ number_format($pedido->transacao->valor, 2, ',', '.') }}</td>
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