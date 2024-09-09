@extends('layouts.main')
@section('title', 'Redefinir senha')

@section('content')
@include('includes.header')

<div class="col-md-12 d-flex flex-column mt-5 px-5">
<h3 class="m-0">Redefinir senha</h3>
    <div class="d-flex flex-row gap-2">
        <p class="fc-primary">Home</p>
        <i class="bi bi-chevron-right fc-gray"></i>
        <p class="fc-primary">Login</p>
        <i class="bi bi-chevron-right fc-gray"></i>
        <p class="fc-gray">Indicar E-mail</p>
    </div>
    <form action="/forgot-password" method="POST">
        @csrf
        <div class="col-md-4 d-flex flex-column bg-white container-default p-3 gap-3">
            <h6 class="fs-13 m-0">Insira o endereço de e-mail associado à sua conta EasyFind.</h6>
            <div class="d-flex flex-column w-100">
                <label class="label-default" for="email">Email</label>
                @error('email')
                    <div class="alert-danger py-1 px-2 br-8 mb-2">
                        <p class="m-0 fs-13">E-mail não cadastrado!</p>
                    </div>
                @enderror
                @if (session('status'))
                    <div class="alert-success py-1 px-2 br-8 mb-2">
                        <p class="m-0 fs-13">E-mail enviado com sucesso!</p>
                    </div>
                @endif
                <input type="email" name="email" class="form-control px-3 py-2 input-default w-100" required>
            </div>
            <div class="d-flex flex-row justify-content-center">
                <button type="submit" class="btn-default btn-large small d-flex flex-row gap-2"><p class="m-0">Continuar</p></button>
            </div>
        </div>
    </form>
</div>
@endsection