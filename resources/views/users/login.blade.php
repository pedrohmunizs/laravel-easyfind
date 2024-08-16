@extends('layouts.main')
@section('title', 'Cadastro')

@section('content')

<div class="d-flex flex-row col-md-12">
    <div class="d-flex flex-column col-md-6">
        <img src="/img/institucional/login.jpg" alt="" style="height: 100vh;">
    </div>
    <div class="d-flex flex-column col-md-6 align-items-center justify-content-center">

        <div class="d-flex flex-column align-items-center justify-content-centergap-2">
            <img src="/img/logo_sn.png" style="height: 40px; width: fit-content;">
            <div class="d-flex flex-column align-items-center gap-1">
                <h2 class="m-0">Bem vindo a EasyFind</h2>
                <h5 class="m-0">Conectando você ao comércio local</h5>
            </div>
        </div>
        <div class="d-flex flex-column col-md-7 mt-3">
            <form action="/usuarios" method="POST" id="form_login">
                @csrf
                <div class="d-flex flex-column gap-2">
                    <div class="d-flex flex-column">
                        <label class="label-default" for="email">Email</label>
                        <input type="email" name="email" class="form-control px-3 py-2 input-default w-100" placeholder="Insira seu e-mail">
                    </div>
                    <div class="d-flex flex-column">
                        <label class="label-default" for="password">Senha</label>
                        <input type="password" name="password" class="form-control px-3 py-2 input-default w-100" placeholder="Insira a sau senha">
                    </div>
                    <div class="d-flex flex-column align-items-center">
                        <button type="submit" class="mt-4 btn-default btn-large rounded-pill">Entrar</button>
                        <meta name="csrf-token" content="{{ csrf_token() }}">
                    </div>
                </div>
            </form>
        </div>
        <div class="mt-3">
            <h6>Não tem conta ainda? Faça seu cadastro <a href="{{ route('usuarios.create') }}" class="a-default fc-blue">aqui</a></h6>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    document.getElementById('form_login').addEventListener('submit', function(e){
        e.preventDefault();

        var formData = $(this).serialize();

        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: formData,
            success: function (response) {
                window.location.href = response.url;
            },
            error: function (xhr, status, error) {
                if (xhr.status == 401 || xhr.status == 404) {
                    toastr.error(xhr.responseJSON.message);
                } else {
                    toastr.error('Erro ao realizar o login!', 'Erro');
                }
            }
        });
    })
</script>
@endsection