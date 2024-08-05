@if(count($carrinhos)>0)
    @php
        $carrinhos = $carrinhos->sortBy(function($carrinho) {
            return $carrinho->produto->secao->estabelecimento->id;
        });
        $previousEstabelecimentoId = null;
        $totalCarrinho = 0;
    @endphp
    @foreach($carrinhos as $index => $carrinho)
        @php
            $currentEstabelecimentoId = $carrinho->produto->secao->estabelecimento->id;
            $nextCarrinho = $carrinhos->get($index + 1);
            $nextEstabelecimentoId = $nextCarrinho ? $nextCarrinho->produto->secao->estabelecimento->id : null;
            $precoItem = $carrinho->produto->is_promocao_ativa ? $carrinho->produto->preco_oferta : $carrinho->produto->preco;
            $totalCarrinho += $precoItem * $carrinho->quantidade;
        @endphp
        <div class="d-flex flex-row col-md-12 justify-content-between px-3">
            <div class="d-flex flex-row align-items-center col-md-10 justify-content-between">
                <div class="d-flex flex-row align-items-center gap-2">
                    @if($carrinho->produto->imagens)
                        @php
                            $imagens = json_decode($carrinho->produto->imagens, true);
                        @endphp
                        @if(!empty($imagens))
                            <img src="/img/produtos/{{ $imagens[0]['nome_referencia'] }}" style="height: 75px; width: 75px;">
                        @else
                            <img src="/img/default.jpg" style="height: 144px; width: 144px;">
                        @endif
                    @endif
                    <div class="d-flex flex-column">
                        <p class="m-0">{{$carrinho->produto->nome}}</p>
                        <p class="fs-14 m-0">Quantidade: {{$carrinho->quantidade}}</p>
                    </div>
                </div>
                @if($carrinho->produto->is_promocao_ativa)
                    <div class="d-flex flex-column">
                        <p class="text-decoration-line-through m-0 text-secondary"><small>R$ {{ number_format($carrinho->produto->preco, 2, ',', '.') }}</small></p>
                        <h6 class="m-0">R$ {{number_format($carrinho->produto->preco_oferta, 2, ',', '.')}}</h6>
                    </div>
                @else
                    <h6 class="m-0">R$ {{number_format($carrinho->produto->preco, 2, ',', '.')}}</h6>
                @endif
            </div>
            <div class="d-flex flex-row gap-1 align-items-center">
                <button class="btn-default px-1 br-8" id="sub_carrinho" data-value="{{$carrinho->id}}"><i class="bi bi-dash"></i></button>
                <button class="btn-default px-1 br-8" id="add_carrinho" data-value="{{$carrinho->id}}"><i class="bi bi-plus"></i></button>
            </div>
        </div>
        @if($nextEstabelecimentoId !== $currentEstabelecimentoId)
            <div class="d-flex flex-row justify-content-between align-items-center px-3 my-3">
                <h6 class="m-0">Total: R$ {{ number_format($totalCarrinho, 2, ',', '.') }}</h6>
                <a href="/pedidos/create?origem=carrinho&estabelecimento={{ $carrinho->produto->secao->estabelecimento->id }}" class="a-button btn-default btn-large">Finalizar Pedido</a>
            </div>
            @php
                $totalCarrinho = 0;
            @endphp
        @endif
        @php
            $previousEstabelecimentoId = $currentEstabelecimentoId;
        @endphp
    @endforeach
@else
    <div class="d-flex flex-column px-3 pb-1">
        <h6 class="m-0">Carrinho vazio</h6>
    </div>
@endif