@foreach($metodos as $metodo)
    <tr>
        <td>{{$metodo->bandeiraMetodo->bandeiraPagamento->nome}}</td>
        <td>{{$metodo->bandeiraMetodo->metodoPagamento->descricao}}</td>
        <td>
            <button type="button" id="{{ $metodo->id }}" class="btn-clean"><i class="bi bi-trash fs-20 btn-color-default"></i></button>
        </td>
    </tr>
@endforeach