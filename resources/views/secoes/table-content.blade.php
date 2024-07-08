@foreach($secoes as $secao)
    <tr>
        <td>{{$secao->descricao}}</td>
        <td>{{$secao->total_produto}}</td>
        <td>
            <a href="{{ $secao->id }}/edit" class="btn-clean"><i class="bi bi-pencil fs-20 btn-color-default"></i></a>
            <button type="button" id="{{ $secao->id }}" class="btn-clean"><i class="bi bi-trash fs-20 btn-color-default"></i></button>
        </td>
    </tr>
@endforeach