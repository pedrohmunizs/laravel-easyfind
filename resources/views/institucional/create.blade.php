@extends('layouts.main')

@section('title', 'Cadastro usuário')

@section('content')
@include('includes.header')
<div class="col-md-12 d-flex flex-column mt-5 px-5">
    <h3 class="m-0">Cadastrar Usuário</h3>
    <div class="d-flex flex-row gap-2">
        <p class="fc-primary">Home</p>
        <i class="bi bi-chevron-right fc-gray"></i>
        <p class="fc-gray">Tipo de usuário</p>
    </div>
    <div class="d-flex flex-column gap-4">
        <div class="d-flex flex-column bg-white p-4 gap-3 container-default w-fit-content">
            <h5>Tipo de usuário</h5>
            <a href="{{ route('consumidores.create') }}" class="a-button bgc-primary btn-large br-8">Sou consumidor</a>
            <a href="{{ route('comerciantes.create') }}" class="a-button bgc-primary btn-large br-8">Sou comerciante</a>
        </div>
    </div>
</div>
@endsection