<div class="d-flex flex-row bg-white container-default px-5 py-3 gap-4">
    @if($oferta->imagens)
        @php
            $imagens = json_decode($oferta->imagens, true);
        @endphp
        @if(!empty($imagens))
            <img src="/img/produtos/{{ $imagens[0]['nome_referencia'] }}" class="container-default" alt="" style="height: 250px; width: 250px;">
        @else
            <img src="/img/default.jpg" class="container-default" alt="" style="height: 250px; width: 250px;">
        @endif
    @else
        <img src="/img/default.jpg" class="container-default" alt="" style="height: 250px; width: 250px;">
    @endif
    <div class="d-flex flex-column justify-content-center gap-2">
        <div class="d-flex flex-column">
            <h4 class="m-0">{{$oferta->nome}}</h4>
            <p class="text-decoration-line-through m-0 text-secondary"><small>R$ {{ number_format($oferta->preco, 2, ',', '.') }}</small></p>
            <h4 class="m-0">R$ {{ number_format($oferta->preco_oferta, 2, ',', '.') }}</h4>
        </div>
        <a href="#" class="a-default bgc-primary text-dark px-5 py-2 w-fit-content br-8">Comprar</a>
    </div>
</div>