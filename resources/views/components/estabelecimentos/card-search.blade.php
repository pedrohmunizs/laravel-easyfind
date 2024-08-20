@foreach($estabelecimentos as $estabelecimento)
    <div class="d-flex flex-column bg-white container-default p-3 gap-3">
        <div class="d-flex flex-column align-items-center gap-2">
            @if($estabelecimento->imagem)
                <img src="/img/estabelecimentos/{{ $estabelecimento->imagem['nome_referencia'] }}" alt="" style="height: 80px; width: 80px;">
            @else
                <img src="/img/default.jpg" class="container-default" alt="" style="height: 80px; width: 80px;">
            @endif
            <h4>{{$estabelecimento->nome}}</h6>
            <p class="m-0">{{ $estabelecimento->segmento }}</p>
        </div>
        <div class="d-flex flex-row justify-content-between">
            <p class="m-0">Vendas: {{$estabelecimento->vendas}}</p>
            @if($estabelecimento->avaliacoes)
                @if(!empty($estabelecimento->avaliacoes))
                    @php
                        $notas = array_column($estabelecimento->avaliacoes, 'qtd_estrela');
                        $media = array_sum($notas)/count($estabelecimento->avaliacoes);
                    @endphp
                    <div class="d-flex flex-row gap-1">
                        <p class="m-0">{{number_format($media, 1, ',', '.')}}</p>
                        <i style="color: gold;" class="bi bi-star-fill"></i>
                    </div>
                @endif
            @else
                <div class="d-flex flex-row gap-1">
                    <p class="m-0">0,0</p>
                    <i style="color: gold;" class="bi bi-star-fill"></i>
                </div>
            @endif
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
@endforeach