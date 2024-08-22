<a href="/estabelecimentos/{{ $estabelecimento->id }}/show" class="a-default">
    <div class="d-flex flex-column bg-white container-default p-3 gap-3">
        <div class="d-flex flex-column align-items-center gap-2">
            @if($estabelecimento->imagem)
                <img src="/img/estabelecimentos/{{ $estabelecimento->imagem['nome_referencia'] }}" alt="" style="height: 80px; width: 80px;">
            @else
                <img src="/img/default.jpg" class="container-default" alt="" style="height: 80px; width: 80px;">
            @endif
            <h6 class="fc-black">{{$estabelecimento->nome}}</h6>
        </div>
        <div class="d-flex flex-row gap-2">
            @foreach($estabelecimento->produtos_filtrados as $produto)
                @php
                    $imagens = json_decode($produto->imagens, true);
                @endphp
                @if(!empty($imagens))
                    <img src="/img/produtos/{{ $imagens[0]['nome_referencia'] }}" class="container-default" alt="" style="height: 70px; width: 70px;">
                @else
                    <img src="/img/default.jpg" class="container-default" alt="" style="height: 70px; width: 70px;">
                @endif
            @endforeach
        </div>
    </div>
</a>