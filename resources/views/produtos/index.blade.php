@extends('layouts.main')

@section('title', 'Lojas')

@section('content')
@include('includes.header-comerciante')
@include('includes.menu', ['estabelecimento' => $estabelecimento])
    <div class="col-md-10 offset-md-2 px-4 py-5 d-flex flex-column gap-2">
        <h3 class="m-0">Produtos</h3>
        <div class="d-flex flex-row gap-2">
            <p class="fc-primary">Produtos</p>
            <i class="bi bi-chevron-right fc-gray"></i>
            <p class="fc-gray">Lista de produtos</p>
        </div>
        <div class="d-flex flex-row justify-content-between">
            <div class="col-md-5">
                <input type="text" class="input-default px-3 py-2 w-100" placeholder="Buscar produto" id="search" value="">
            </div>
            <div class="d-flex flex-row gap-3">
                <button class="btn-default py-2 px-3 small" id="filtro" >Filtro</button>
                <a href="/produtos/{{$estabelecimento->id}}/create" class="btn-default small a-button px-3 py-2"><i class="bi bi-plus-lg"></i>Cadastrar Produto</a>
            </div>
        </div>
        <div class="d-none flex-column flex-wrap bg-white p-3 gap-3 border border-2 br-8" id="card-filter">
            <h4 class="m-0">Filtro</h4>
            <div class="d-flex flex-row justify-content-between">
                <div class="d-flex flex-column">
                    <label class="fs-13" for="nome">Status</label>
                    <select name="filter[status]" class="px-3 py-2 input-default">
                        <option value="1">Ativado</option>
                        <option value="0">Desativado</option>
                    </select>
                </div>
                <div class="d-flex flex-column">
                    <label class="fs-13" for="nome">Código SKU</label>
                    <input type="text" name="comerciante[nome]" class=" px-3 py-2 input-default">
                </div>
                <div class="d-flex flex-column">
                    <label class="fs-13" for="nome">Preço minimo</label>
                    <input type="text" name="comerciante[nome]" id="preco-min" class="px-3 py-2 input-default">
                </div>
                <div class="d-flex flex-column">
                    <label class="fs-13" for="nome">Preço maximo</label>
                    <input type="text" name="comerciante[nome]" id="preco-max" class="px-3 py-2 input-default">
                </div>
                <div class="d-flex flex-column">
                    <label class="fs-13" for="nome">Desde</label>
                    <input type="date" name="comerciante[nome]" class="px-3 py-2 input-default">
                </div>
                <div class="d-flex flex-column">
                    <label class="fs-13" for="nome">Até</label>
                    <input type="date" name="comerciante[nome]" class="px-3 py-2 input-default">
                </div>
            </div>
            <div class="d-flex flex-row-reverse gap-3">
                <button class="btn-default py-2 px-3 small" >Aplicar</button>
                <button class="btn-default py-2 px-3 small" >Limpar filtro</button>
            </div>
        </div>
    </div>
@endsection
@section('script')
<script>
    $(document).ready(function(){
        $('#preco-max').mask('000,000,000.00', {reverse: true});
        $('#preco-min').mask('000,000,000.00', {reverse: true});

        $('#filtro').on('click', function(){
            if($("#card-filter").hasClass('d-none')){
                $("#card-filter").removeClass('d-none')
                $("#card-filter").addClass('d-flex')
            }else{
                $("#card-filter").removeClass('d-flex')
                $("#card-filter").addClass('d-none')
            }
        })
    });
</script>
@endsection