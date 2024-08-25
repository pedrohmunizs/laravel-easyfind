@if(count($metodos) > 0)
    @foreach($metodos as $metodo)
        <tr>
            <td>{{$metodo->bandeiraMetodo->bandeiraPagamento->nome}}</td>
            <td>{{$metodo->bandeiraMetodo->metodoPagamento->descricao}}</td>
            <td>
                <button type="button" id="{{ $metodo->id }}" class="btn-clean delete"><i class="bi bi-trash fs-20 btn-color-default"></i></button>
            </td>
        </tr>
    @endforeach
@else
    <div class="d-flex flex-column px-3 pt-2">
        <h6 class="m-0">Sem métodos cadastrados</h6>
    </div>
@endif