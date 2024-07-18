@extends('layouts.main')
@section('title', 'Cadastro usuário')

@section('content')
@include('includes.header')
<form id="form_comerciante" action="/comerciantes" method="POST" class="needs-validation" novalidate>
    @csrf
    <div class="col-md-12 d-flex flex-column mt-5 px-5">
        <h3 class="m-0">Cadastrar Comerciante</h3>
        <div class="d-flex flex-row gap-2">
            <p class="fc-primary">Home</p>
            <i class="bi bi-chevron-right fc-gray"></i>
            <p class="fc-primary">Tipo de usuário</p>
            <i class="bi bi-chevron-right fc-gray"></i>
            <p class="fc-gray">Cadastrar comerciante</p>
        </div>
        <div class="d-flex flex-row gap-2 align-items-start">
            <div class="bg-white container-default d-flex flex-column p-4 gap-2">
                <h5>Informações Gerais</h5>
                <div class="d-flex flex-column">
                    <label class="label-default" for="nome">Nome Completo</label>
                    <input type="text" name="comerciante[nome]" class="form-control px-3 py-2 input-default w-100" required>
                    <div class="invalid-feedback">Adicione seu nome completo.</div>
                </div>
                <div class="d-flex flex-row gap-4">
                    <div class="d-flex flex-column">
                        <label class="label-default" for="cpf">CPF</label>
                        <input type="text" id="cpf" name="comerciante[cpf]" class="form-control px-3 py-2 input-default w-100" placeholder="000.000.000-00" required>
                        <div class="invalid-feedback">Adicione seu CPF.</div>
                    </div>
                    <div class="d-flex flex-column">
                        <label class="label-default" for="cnpj">CNPJ</label>
                        <input type="text" id="cnpj" name="comerciante[cnpj]" class="form-control px-3 py-2 input-default w-100" placeholder="00.000.000/0000-00" required>
                        <div class="invalid-feedback">Adicione seu CNPJ.</div>
                    </div>
                </div>
                <div class="d-flex flex-row gap-4">
                    <div class="d-flex flex-column">
                        <label class="label-default" for="razao_social">Razão social</label>
                        <input type="text" name="comerciante[razao_social]" class="form-control px-3 py-2 input-default w-100" required>
                        <div class="invalid-feedback">Adicione sua razão social.</div>
                    </div>
                    <div class="d-flex flex-column">
                        <label class="label-default" for="telefone">Telefone</label>
                        <input type="text" id="telefone" name="comerciante[telefone]" class="form-control px-3 py-2 input-default w-100" placeholder="(00) 00000-0000" required>
                        <div class="invalid-feedback">Adicione seu telefone.</div>
                    </div>
                </div>
            </div>
            <div class="bg-white container-default d-flex flex-column p-4 gap-2">
                <h5>Endereço</h5>
                <div class="d-flex flex-column gap-2">
                    <div class="d-flex flex-row gap-3">
                        <div class="d-flex flex-column w-25">
                            <label class="label-default" for="cep">CEP</label>
                            <input type="text" name="endereco[cep]" class="input-default w-100 px-3 py-2" id="cep" required>
                            <div class="invalid-feedback">Por favor, adicione o CEP.</div>
                        </div>
                        <div class="d-flex flex-column w-75">
                            <label class="label-default" for="logradouro">Logradouro</label>
                            <input type="text" name="endereco[logradouro]" class="input-default w-100 px-3 py-2" id="logradouro" required>
                            <div class="invalid-feedback">Por favor, adicione o logradouro.</div>
                        </div>
                    </div>
                    <div class="d-flex flex-row gap-3">
                        <div class="d-flex flex-column">
                            <label class="label-default" for="numero">Número</label>
                            <input type="text" name="endereco[numero]" class="input-default w-100 px-3 py-2" required>
                            <div class="invalid-feedback">Por favor, adicione o número.</div>
                        </div>
                        <div class="d-flex flex-column">
                            <label class="label-default" for="bairro">Bairro</label>
                            <input type="text" name="endereco[bairro]" class="input-default w-100 px-3 py-2" id="bairro" required>
                            <div class="invalid-feedback">Por favor, adicione o bairro.</div>
                        </div>
                    </div>
                    <div class="d-flex flex-row gap-3">
                        <div class="d-flex flex-column">
                            <label class="label-default">Cidade</label>
                            <input type="text" id="cidade" name="endereco[cidade]" class="input-default w-100 px-3 py-2" required>
                            <div class="invalid-feedback">Por favor, adicione a cidade.</div>
                        </div>
                        <div class="d-flex flex-column">
                            <label class="label-default">Estado</label>
                            <input type="text" name="endereco[estado]" class="input-default w-100 px-3 py-2" id="estado" required>
                            <div class="invalid-feedback">Por favor, adicione o estado.</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-white container-default d-flex flex-column p-4 gap-2">
                <h5>Informações Usuário</h5>
                <div class="d-flex flex-column">
                    <label class="label-default" for="email">Email</label>
                    <input type="text" name="usuario[email]" class="form-control px-3 py-2 input-default w-100" required>
                    <div class="invalid-feedback">Adicione seu email.</div>
                </div>
                <div class="d-flex flex-column">
                    <label class="label-default" for="senha">Senha</label>
                    <input type="password" id="password" name="usuario[password]" class="form-control px-3 py-2 input-default w-100" required>
                    <div class="invalid-feedback">Adicione uma senha.</div>
                </div>
                <div class="d-flex flex-column">
                    <label class="label-default">Confirme a senha</label>
                    <input type="password" id="confirm" class="form-control px-3 py-2 input-default w-100" required>
                    <div class="invalid-feedback">Confirme sua senha.</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12 d-flex flex-row-reverse bg-white p-3 gap-3 position-fixed bottom-0 mt-4">
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
    $(document).ready(function() {
        $('#cpf').mask('000.000.000-00');
        $('#telefone').mask('(00) 00000-0000');
        $('#cep').mask('00000-000');
        $('#cnpj').mask('00.000.000/0000-00');
    });

    $('#cep').on('input', function() {
        let cep = $(this).val().replace(/\D/g, '');
        if (cep.length === 8) {
            $.ajax({
                url: `https://viacep.com.br/ws/${cep}/json/`,
                method: 'GET',
                success: function(data) {
                    if (!data.erro) {
                        $('#logradouro').val(data.logradouro);
                        $('#bairro').val(data.bairro);
                        $('#cidade').val(data.localidade);
                        $('#estado').val(data.uf);
                    } else {
                        toastr.error('CEP não encontrado');
                    }
                },
                error: function() {
                    toastr.error('Erro ao consultar o CEP');
                }
            });
        }
    });

    (function() {
        'use strict';

        window.addEventListener('load', function() {
            var form = document.getElementById('form_comerciante');

            form.addEventListener('submit', function(event) {
                var password = document.getElementById('password').value;
                var confirmPassword = document.getElementById('confirm').value;

                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                    toastr.error('Por favor, preencha todos os campos obrigatórios.', 'Erro de Validação');
                } else if (password !== confirmPassword) {
                    event.preventDefault();
                    event.stopPropagation();
                    toastr.error('As senhas não coincidem.', 'Erro de Validação');
                    return;
                } else {
                    event.preventDefault();
                    var formData = $(form).serialize();
                    $.ajax({
                        url: form.action,
                        type: 'POST',
                        data: formData,
                        success: function(response) {
                            toastr.success('Usuário cadastrado com sucesso!', 'Sucesso');
                            setTimeout(function() {
                                window.location.href = '/usuarios/login';
                            }, 3000);
                        },
                        error: function(xhr, status, error) {
                            if (xhr.status == 409) {
                                toastr.error(xhr.responseJSON.error);
                            } else if (xhr.status == 400) {
                                toastr.error(xhr.responseJSON.error);
                            } else {
                                toastr.error('Erro ao realizar o cadastro!', 'Erro');
                            }
                        }
                    });
                }

                form.classList.add('was-validated');
            }, false);
        }, false);
    })();
</script>
@endsection