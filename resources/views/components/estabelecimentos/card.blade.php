@foreach($estabelecimentos as $estabelecimento)
    <div class="d-flex flex-column mb-3">
        @if($estabelecimento->imagem)
            <img src="img/estabelecimentos/{{ $estabelecimento->imagem->nome_referencia }}" style="width: 270px; height:170px;" class="rounded-top" alt="{{ $estabelecimento->nome }}">
        @else
            <img src="img/default.jpg" alt="Sem imagem cadastrada" style="width: 270px; height:170px;" class="rounded-top">
        @endif
        <div class="bgc-primary p-3 bg-black rounded-bottom" style="width: 270px;">
            <div class="d-flex flex-row justify-content-between">
                <p class="text-white fs-13 m-0">{{$estabelecimento->nome}}</p>
                <button class="fit-content border-0 fc-primary h6 m-0" style="background-color: transparent;"> <i class="bi bi-gear-fill"></i></button>
            </div>
            <p class="fc-primary fs-13">{{$estabelecimento->segmento}}</p>
            <hr class="bg-white">
            <div class="d-flex flex-row justify-content-between">
                <div class="d-flex flex-column align-items-center">
                    <p class="fs-13 text-white">Pedidos pendentes</p>
                    <p class="fs-13 text-white">0</p>
                </div>
                <div class="d-flex flex-column align-items-center">
                    <p class="fs-13 text-white">Produtos ativos</p>
                    <p class="fs-13 text-white">0</p>
                </div>
            </div>
            <button class="btn-default btn-large">Gerenciar</button>
        </div>
    </div>
@endforeach