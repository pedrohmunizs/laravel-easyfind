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
        <p class="fc-primary">Indicar E-mail</p>
        <i class="bi bi-chevron-right fc-gray"></i>
        <p class="fc-gray">Nova senha</p>
    </div>
    <form id="form_password" action="/reset-password" method="POST" class="needs-validation" novalidate>
        @csrf
        <div class="col-md-4 d-flex flex-column bg-white container-default p-3 gap-3">
            <div class="d-flex flex-column gap-1">
                <div class="d-flex flex-column w-100">
                    <label class="label-default" for="email">Email</label>
                    <input type="email" name="email" value="{{ $email }}" class="form-control px-3 py-2 input-default w-100" readonly>
                </div>
                <div class="d-flex flex-column">
                    <label class="label-default" for="password">Nova senha</label>
                    <input type="password" id="password" name="password" class="form-control px-3 py-2 input-default w-100" required>
                </div>
                <div class="d-flex flex-column">
                    <label class="label-default">Confirme a senha</label>
                    <input type="password" id="confirm" name="password_confirmation" class="form-control px-3 py-2 input-default w-100" required>
                </div>
            </div>
            <div class="d-flex flex-row justify-content-center">
                <input type="hidden" value="{{ $token }}" name="token">
                <button type="submit" class="btn-default btn-large small d-flex flex-row gap-2"><p class="m-0">Salvar</p></button>
            </div>
        </div>
    </form>
</div>
@endsection
@section('script')
<script>
    $('#form_password').on('submit', function(e) {
        e.preventDefault();

        var password = document.getElementById('password').value;
        var confirmPassword = document.getElementById('confirm').value;
        var form = document.getElementById('form_password');
        
        if (form.checkValidity() === false) {
            e.preventDefault();
            e.stopPropagation();
            toastr.error('Por favor, preencha todos os campos obrigatórios.', 'Erro de Validação');
        } else if(password.length < 8 || confirmPassword.length < 8){
            e.preventDefault();
            e.stopPropagation();
            toastr.error('A senha deve ter no mínimo 8 caracteres.', 'Senha pequena');
            return;
        } else if (password !== confirmPassword) {
            e.preventDefault();
            e.stopPropagation();
            toastr.error('As senhas não coincidem.', 'Erro de Validação');
            return;
        } else {
            var formData = $(this).serialize();
            $.ajax({
                url: $(this).attr('action'),
                type: 'PATCH',
                data: formData,
                success: function(response) {
                    toastr.success(response.message, 'Sucesso');
                    setTimeout(function() {
                         window.location.href = `/usuarios/login`;
                    }, 3000);
                },
                error: function(xhr, status, error) {
                    if(xhr.status == 400){
                        toastr.error(xhr.responseJSON.message);                        
                    }else{
                        toastr.error('Erro ao redefinir senha, solicite outro link.', 'Erro');
                    }
                }
            });
        }
    });
</script>
@endsection