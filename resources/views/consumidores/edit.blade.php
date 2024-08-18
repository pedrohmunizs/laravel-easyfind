@extends('layouts.main')

@section('title', 'Editar usuário')

@section('content')
@include('includes.header')
<form id="form_consumidor" action="/consumidores/{{ $usuario->id }}" method="POST" class="needs-validation" novalidate>
    @csrf
    @method('PUT')
    <div class="col-md-12 d-flex flex-column mt-5 px-5">
        <h3 class="m-0">Cadastrar Consumidor</h3>
        <div class="d-flex flex-row gap-2">
            <a href="/" class="a-default">
                <p class="fc-primary">Home</p>
            </a>
            <i class="bi bi-chevron-right fc-gray"></i>
            <p class="fc-gray">Editar consumidor</p>
        </div>
        <div class="d-flex flex-row gap-5 align-items-center">
            <div class="bg-white container-default d-flex flex-column p-4 gap-2">
                <h5>Informações Gerais</h5>
                <div class="d-flex flex-column">
                    <label class="label-default" for="nome">Nome Completo</label>
                    <input type="text" name="user[nome]" class="form-control px-3 py-2 input-default w-100" value="{{ $usuario->nome }}" required>
                    <div class="invalid-feedback">Adicione seu nome.</div>
                </div>
                <div class="d-flex flex-row justify-content-between">
                    <div class="d-flex flex-column col-md-7">
                        <label class="label-default" for="cpf">CPF</label>
                        <input type="text" id="cpf" name="consumidor[cpf]" class="form-control px-3 py-2 input-default w-100" placeholder="000.000.000-00" value="{{ $usuario->consumidor->cpf }}" required>
                        <div class="invalid-feedback">Adicione seu CPF.</div>
                    </div>
                    <div class="d-flex flex-column col-md-4">
                        <label class="label-default" for="genero">Gênero</label>
                        <select name="consumidor[genero]" class="form-control px-3 py-2 input-default w-100" required>
                            <option value="Feminino">Feminino</option>
                            <option value="Masculino" {{ $usuario->consumidor->genero == "Masculino" ? 'selected' : '' }} >Masculino</option>
                        </select>
                        <div class="invalid-feedback">Selecione seu gênero.</div>
                    </div>
                </div>
                <div class="d-flex flex-row gap-4 col-md-12">
                    <div class="d-flex flex-column">
                        <label class="label-default" for="data_nascimento">Data de nascimento</label>
                        <input type="date" name="consumidor[data_nascimento]" class="form-control px-3 py-2 input-default" value="{{ $usuario->consumidor->data_nascimento }}" required>
                        <div class="invalid-feedback">Adicione sua data de nascimento.</div>
                    </div>
                    <div class="d-flex flex-column col-md-7">
                        <label class="label-default" for="telefone">Telefone</label>
                        <input type="text" id="telefone" name="consumidor[telefone]" class="form-control px-3 py-2 input-default w-100" placeholder="(00) 00000-0000" value="{{ $usuario->consumidor->telefone }}" required>
                        <div class="invalid-feedback">Adicione seu telefone.</div>
                    </div>
                </div>
                <div class="d-flex flex-column">
                    <label class="label-default" for="email">Email</label>
                    <input type="email" name="user[email]" class="form-control px-3 py-2 input-default w-100" value="{{ $usuario->email }}" required>
                    <div class="invalid-feedback">Adicione o email.</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12 d-flex flex-row-reverse bg-white p-3 gap-3 position-fixed bottom-0">
        <div class="d-flex flex-row gap-2">
            <a href="/" class="btn-default small a-button px-3 py-2 btn-cancel d-flex flex-row gap-2"><i class="bi bi-x-lg"></i>
                <p class="m-0">Cancelar</p>
            </a>
            <button type="submit" class="btn-default py-2 px-3 small d-flex flex-row gap-2"><i class="bi bi-floppy"></i>
                <p class="m-0">Salvar</p>
            </button>
        </div>
    </div>
</form>
@endsection

@section('script')
<script>
    (function() {
        'use strict';

        window.addEventListener('load', function() {
            var form = document.getElementById('form_consumidor');

            form.addEventListener('submit', function(event) {
                
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                    toastr.error('Por favor, preencha todos os campos obrigatórios.', 'Erro de Validação');
                } else {
                    event.preventDefault();
                    var formData = $(form).serialize();

                    $.ajax({
                        url: form.action,
                        type: 'POST',
                        data: formData,
                        success: function(response) {
                            toastr.success(response.message, 'Sucesso');
                            setTimeout(function() {
                                window.location.href = '/';
                            }, 3000);
                        },
                        error: function(xhr, status, error) {
                            if (xhr.status == 409) {
                                toastr.error(xhr.responseJSON.message);
                            } else if (xhr.status == 400) {
                                toastr.error(xhr.responseJSON.message);
                            } else {
                                toastr.error('Erro ao editar usuário!', 'Erro');
                            }
                        }
                    });
                }

                form.classList.add('was-validated');
            }, false);
        }, false);
    })();

    $(document).ready(function(){
        $('#cpf').mask('000.000.000-00');
        $('#telefone').mask('(00) 00000-0000');
    });
</script>
@endsection
