@foreach($produtos as $produto)
    <tr>
        <td>
            <div class="d-flex flex-row gap-2 align-items-center">
                @if($produto->imagens)
                    @php
                        $imagens = json_decode($produto->imagens, true);
                    @endphp
                    @if(!empty($imagens))
                       <img src="/img/produtos/{{ $imagens[0]['nome_referencia'] }}" alt="" style="height: 44px; width: 44px;">
                    @else
                        <img src="/img/default.jpg" alt="" style="height: 44px; width: 44px;">
                    @endif
                @endif
                <p class="m-0">{{$produto->nome}}</p>
            </div>
        </td>
        <td>{{$produto->codigo_sku}}</td>
        <td>{{$produto->secao->descricao}}</td>
        <td>R$ {{$produto->preco}}</td>
        <td>
            {!! $produto->is_ativo ? '<div class="py-1 px2 rounded-pill fc-green d-flex justify-content-center" style="background-color: #E7F4EE;"><p class="m-0">Ativado</p></div>' : '<div class="py-1 px2 rounded-pill fc-red d-flex justify-content-center" style="background-color: #FDF1E8;"><p class="m-0" >Desativado</p></div>' !!}
        </td>
        <td>
            <a href="{{ $produto->id }}/edit" class="btn-clean" title="Editar produto"><i class="bi bi-pencil fs-20 btn-color-default hover-default"></i></a>
            @if($produto->is_ativo)
                <button type="button" id="{{ $produto->id }}" class="btn-clean delete" title="Desativar produto"><i class="bi bi-trash fs-20 btn-color-default"></i></button>
            @else
                <button type="button" id="{{ $produto->id }}" class="btn-clean active" title="Ativar produto"><i class="bi bi-recycle fs-20 btn-color-default"></i></button>
            @endif
        </td>
    </tr>
@endforeach
