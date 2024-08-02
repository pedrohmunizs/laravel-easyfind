@extends('layouts.main')

@section('title', 'Criar seção')

@section('content')
@include('includes.header')
@include('includes.menu', ['estabelecimento' => $estabelecimento])
<form id="form_secao" action="/secoes" method="POST">
    @csrf
    <div class="col-md-10 offset-md-2 px-4 py-5 d-flex flex-column gap-2">
        <h3 class="m-0">Seções</h3>
        <div class="d-flex flex-row gap-2">
            <p class="fc-primary">Produtos</p>
            <i class="bi bi-chevron-right fc-gray"></i>
            <a href="/secoes/{{$estabelecimento->id}}" class="a-default">
                <p class="fc-primary">Seções</p>
            </a>
            <i class="bi bi-chevron-right fc-gray"></i>
            <p class="fc-gray">Cadastrar seção</p>
        </div>
        <div class="bg-white container-default p-3 gap-3 w-fit-content">
            <h5>Cadastrar seção</h5>
            <div class="d-flex flex-column">
                <label class="label-default" for="nome">Nome da seção</label>
                <input type="text" name="secao[descricao]" class=" px-3 py-2 input-default w-100">
                <input type="text" name="secao[fk_estabelecimento]" class="d-none" value="{{$estabelecimento->id}}">
            </div>
        </div>
    </div>
    <div class="col-md-12 d-flex flex-row-reverse bg-white p-3 gap-3 position-fixed bottom-0">
        <div class="d-flex flex-row gap-2">
            <a href="/produtos/{{$estabelecimento->id}}" class="btn-default small a-button px-3 py-2 btn-cancel d-flex flex-row gap-2" ><i class="bi bi-x-lg"></i><p class="m-0">Cancelar</p></a>
            <button type="submit" class="btn-default py-2 px-3 small d-flex flex-row gap-2" ><i class="bi bi-floppy"></i><p class="m-0">Salvar</p></button>
        </div>
    </div>
</form>
@endsection
@section('script')
<script>
    $('#form_secao').on('submit', function(e) {
        e.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            success: function(response) {
                toastr.success(response.message, 'Sucesso');
                setTimeout(function() {
                     window.location.href = `/secoes/{{$estabelecimento->id}}`;
                }, 3000);
            },
            error: function(xhr, status, error) {
                if(xhr.status == 409){
                    toastr.error(xhr.responseJSON.message);
                }else if(xhr.status == 400){
                    toastr.error(xhr.responseJSON.message);                        
                }else{
                    toastr.error('Erro ao cadastrar seção!', 'Erro');
                }
            }
        });
    });
</script>
@endsection