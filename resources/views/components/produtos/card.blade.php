@if(count($produtos)>0)
    @foreach($produtos as $produto)
        <a href="/produtos/{{$produto->id}}/show" class="a-default">
            <div class="d-flex flex-column bg-white container-default p-3 gap-3">
                @if($produto->imagens)
                    @php
                        $imagens = json_decode($produto->imagens, true);
                    @endphp
                    @if(!empty($imagens))
                        <img src="/img/produtos/{{ $imagens[0]['nome_referencia'] }}" class="container-default" alt="" style="height: 144px; width: 144px;">
                    @else
                        <img src="/img/default.jpg" class="container-default" alt="" style="height: 144px; width: 144px;">
                    @endif
                @endif
                <div class="d-flex flex-column gap-2">
                    <div class="d-flex flex-column gap-0">
                        <p class="m-0 fc-black">{{$produto->nome}}</p>
                        <p class="m-0 fs-14 fc-black"><small>{{$produto->secao->descricao}}</small></p>
                    </div>
                    @if($produto->is_promocao_ativa)
                        <p class="m-0 h5 fc-black">R$ {{number_format($produto->preco_oferta, 2, ',', '.')}}</p>
                    @else
                        <p class="m-0 h5 fc-black">R$ {{number_format($produto->preco, 2, ',', '.')}}</p>
                    @endif
                </div>
            </div>
        </a>
    @endforeach
@else
    <div class="d-flex flex-column">
        <h6 class="m-0">Sem produtos</h6>
    </div>
@endif