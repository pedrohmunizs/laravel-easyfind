@if(count($estabelecimentos) > 0)
    @foreach($estabelecimentos as $estabelecimento)
        <div class="d-flex flex-column mb-3 bg-white br-8">
            @if($estabelecimento->imagem)
                <img src="/img/estabelecimentos/{{ $estabelecimento->imagem->nome_referencia }}" style="width: 270px; height:170px;" class="brt-8" alt="{{ $estabelecimento->nome }}">
            @else
                <img src="img/default.jpg" alt="Sem imagem cadastrada" style="width: 270px; height:170px;" class="brt-8">
            @endif
            <div class="bgc-primary p-3 bg-black brb-8" style="width: 270px;">
                <div class="d-flex flex-row justify-content-between">
                    <p class="text-white fs-13 m-0">{{$estabelecimento->nome}}</p>
                    <a href="/estabelecimentos/{{$estabelecimento->id}}/edit" class="a-default fit-content border-0 fc-primary h6 m-0"><i class="bi bi-gear-fill"></i></a>
                </div>
                <p class="fc-primary fs-13">{{$estabelecimento->segmento}}</p>
                <hr class="bg-white">
                <div class="d-flex flex-row justify-content-between">
                    <div class="d-flex flex-column align-items-center">
                        <p class="fs-13 text-white">Pedidos pendentes</p>
                        <p class="fs-13 text-white">{{$estabelecimento->pedidos}}</p>
                    </div>
                    <div class="d-flex flex-column align-items-center">
                        <p class="fs-13 text-white">Produtos ativos</p>
                        <p class="fs-13 text-white">{{$estabelecimento->total_produtos}}</p>
                    </div>
                </div>
                <a href="javascript:void(0)" class="btn-default btn-large a-button btnGerenciarEstabelecimento" id="btnGerenciar" data-id-estabelecimento="{{$estabelecimento->id}}">Gerenciar</a>
            </div>
        </div>
    @endforeach
@else
    <div class="d-flex flex-column">
        <h6 class="m-0">Sem estabelecimento cadastrado</h6>
    </div>
@endif