@extends('layouts.main')

@section('title', 'Seções')

@section('content')
@include('includes.header-comerciante')
@include('includes.menu', ['estabelecimento' => $estabelecimento])
<div class="col-md-10 offset-md-2 px-4 py-5 d-flex flex-column gap-2">
    <h3 class="m-0">Seções</h3>
    <div class="d-flex flex-row gap-2">
        <p class="fc-primary">Produtos</p>
        <i class="bi bi-chevron-right fc-gray"></i>
        <p class="fc-gray">Lista de seções</p>
    </div>
    <div class="d-flex flex-row justify-content-between">
        <div class="col-md-5">
            <input type="text" class="input-default px-3 py-2 w-100" placeholder="Buscar produto" id="search" value="">
        </div>
        <div class="d-flex flex-row gap-3">
            <button class="btn-default py-2 px-3 small" id="filtro" >Filtro</button>
            <a href="/secoes/{{$estabelecimento->id}}/create" class="btn-default small a-button px-3 py-2"><i class="bi bi-plus-lg"></i>Cadastrar Produto</a>
        </div>
    </div>
</div>
@endsection