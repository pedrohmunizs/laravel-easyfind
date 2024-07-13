@foreach($secoes as $secao)
    <tr>
        <td>{{$secao->descricao}}</td>
        <td>{{$secao->total_produto}}</td>
        <td>
            <a href="{{ $secao->id }}/edit" class="btn-clean" title="Editar seção"><i class="bi bi-pencil fs-20 btn-color-default hover-default"></i></a>
            @if($secao->total_produto == 0)
                <button type="button" id="{{ $secao->id }}" class="btn-clean delete" title="Excluir seção"><i class="bi bi-trash fs-20 btn-color-default"></i></button>
            @endif
        </td>
    </tr>
@endforeach