@extends('layouts.main')

@section('title', 'Seções')

@section('content')
@include('includes.header')
@include('includes.menu', ['estabelecimento' => $estabelecimento])
<div class="col-md-10 offset-md-2 px-4 py-5 d-flex flex-column gap-2">
    <h3 class="m-0">Seções</h3>
    <div class="d-flex flex-row gap-2">
        <p class="fc-primary">Produtos</p>
        <i class="bi bi-chevron-right fc-gray"></i>
        <a class="a-default" href="{{ route('secoes.index', ['idEstabelecimento' => $estabelecimento->id]) }}">
            <p class="fc-primary">Seções</p>
        </a>
        <i class="bi bi-chevron-right fc-gray"></i>
        <p class="fc-gray">Editar secão</p>
    </div>
    <form id="form_secao" action="/secoes" method="PUT">
        @csrf
        <div class="d-flex flex-column bg-white container-default p-3 w-fit-content">
            <h5>Cadastrar seção</h5>
            <div class="d-flex flex-column">
                <label class="label-default" for="nome">Nome da seção</label>
                <input type="text" name="secao[descricao]" class=" px-3 py-2 input-default w-100" value="{{$secao->descricao}}">
            </div>
            <div class="d-flex flex-row-reverse mt-3">
                <button type="submit" class="btn-default py-2 px-3 small d-flex flex-row gap-2" ><i class="bi bi-floppy"></i><p class="m-0">Salvar</p></button>
            </div>
        </div>
    </form>

    <div class="d-flex flex-column bg-white container-default mt-3">
        <div class="d-flex flex-column py-4 px-3">
            <h5 class="m-0">Produtos associados</h5>
        </div>
        @if(count($produtos)> 0)
            <div class="table-container shadow-sm border-0">
                <table class="table">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col"><h6 class="m-0">Produto</h6></th>
                            <th scope="col"><h6 class="m-0">SKU</h6></th>
                            <th scope="col"><h6 class="m-0">Preço</h6></th>
                            <th scope="col"><h6 class="m-0">Adicionado</h6></th>
                            <th scope="col"><h6 class="m-0">Status</h6></th>
                        </tr>
                    </thead>
                    <tbody id="table-content">
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
                                <td>R$ {{number_format($produto->preco, 2, ',', '.')}}</td>
                                <td>{{$produto->created_at->format('d/m/Y')}}</td>
                                <td>
                                    {!! $produto->is_ativo ? '<div class="py-1 px2 rounded-pill fc-green d-flex justify-content-center" style="background-color: #E7F4EE;"><p class="m-0">Ativado</p></div>' : '<div class="py-1 px2 rounded-pill fc-red d-flex justify-content-center" style="background-color: #FDF1E8;"><p class="m-0" >Desativado</p></div>' !!}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="pagination px-4"></div>
            </div>
        @else
            <div class="d-flex flex-column py-4 px-3">
                <p class="m-0">Nenhuma produto associado a  essa seção</p>
            </div>
        @endif
    </div>
</div>
@endsection
@section('script')
<script>
    $('#form_secao').on('submit', function(e) {
        e.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
            url: `/secoes/{{$secao->id}}`,
            type: 'PUT',
            data: formData,
            success: function(response) {
                toastr.success('Seção editada com sucesso!', 'Sucesso');
                setTimeout(function() {
                     window.location.href = `/secoes/{{$estabelecimento->id}}`;
                }, 3000);
            },
            error: function(xhr, status, error) {
                if(xhr.status == 409){
                    toastr.error(xhr.responseJSON.error);
                }else if(xhr.status == 400){
                    toastr.error(xhr.responseJSON.error);                        
                }else{
                    toastr.error('Erro ao editar seção!', 'Erro');
                }
            }
        });
    });
</script>
@endsection