@extends('layouts.main')
@section('title', 'Criar evento')

@section('content')
    @include('includes.header')
    <div class="full-screen container-fluid d-flex justify-content-center">
        <div class="d-flex flex-column mt-5 gap-4 align-items-center">
            <div class="d-flex flex-column justify-content-center align-items-center">
                <h4 id="title">Informações do Comerciante</h4>
                <div class="d-flex flex-row gap-1">
                    <div id="c1" class="rounded-circle primary-color" style="height:30px;width:30px;"></div>
                    <div id="c2" class="rounded-circle light-gray" style="height:30px;width:30px;"></div>
                    <div id="c3" class="rounded-circle light-gray" style="height:30px;width:30px;"></div>
                </div>
            </div>
            <form id="form_comerciante" action="/comerciantes" method="POST">
                @csrf
                <div id="step1" class="d-flex flex-column bg-white p-5 gap-3 rounded-3 shadow step">
                    <div class="form-label-column">
                        <label for="nome">Nome</label>
                        <input type="text" name="comerciante[nome]" class="form-control px-3 py-2" required>
                    </div>
                    <div class="d-flex flex-row gap-4">
                        <div class="d-flex flex-column">
                            <label for="cpf">CPF</label>
                            <input type="text" name="comerciante[cpf]" class="form-control px-3 py-2" required>
                        </div>
                        <div class="d-flex flex-column">
                            <label for="cnpj">CNPJ</label>
                            <input type="text" name="comerciante[cnpj]" class="form-control px-3 py-2" required>
                        </div>
                    </div>
                    <div class="form-label-column">
                        <label for="razao_social">Razão social</label>
                        <input type="text" name="comerciante[razao_social]" class="form-control px-3 py-2" required>
                    </div>
                    <div class="form-label-column">
                        <label for="telefone">Telefone</label>
                        <input type="text" name="comerciante[telefone]" class="form-control px-3 py-2" required>
                    </div>
                </div>
                <div id="step2" class="d-none flex-column bg-white p-5 gap-3 rounded-3 shadow step">
                    <div class="form-label-column">
                        <label for="cep">CEP</label>
                        <input type="text" name="endereco[cep]" id="cep" class="form-control px-3 py-2 w-25" required>
                    </div>
                    <div class="form-label-column">
                        <label for="logradouro">Logradouro</label>
                        <input type="text" name="endereco[logradouro]" id="logradouro" class="form-control px-3 py-2" required>
                    </div>
                    <div class="d-flex flex-row gap-4">
                        <div class="d-flex flex-column">
                            <label for="numero">Número</label>
                            <input type="text" name="endereco[numero]" class="form-control px-3 py-2" required>
                        </div>
                        <div class="d-flex flex-column">
                            <label for="bairro">Bairro</label>
                            <input type="text" name="endereco[bairro]" id="bairro" class="form-control px-3 py-2" required>
                        </div>
                    </div>
                    <div class="d-flex flex-row gap-4">
                        <div class="d-flex flex-column">
                            <label for="cidade">Cidade</label>
                            <input type="text" name="endereco[cidade]" id="cidade" class="form-control px-3 py-2" required>
                        </div>
                        <div class="d-flex flex-column">
                            <label for="estado">Estado</label>
                            <input type="text" name="endereco[estado]" id="estado" class="form-control px-3 py-2" required>
                        </div>
                    </div>
                </div>
                <div id="step3" class="d-none flex-column bg-white p-5 gap-3 rounded-3 shadow step">
                    <div class="d-flex flex-column">
                        <label for="email">Email</label>
                        <input type="text" name="usuario[email]" class="form-control px-3 py-2" required>
                    </div>
                    <div class="d-flex flex-column">
                        <label for="senha">Senha</label>
                        <input type="password" name="usuario[password]" class="form-control px-3 py-2" required>
                    </div>
                </div>
                <div class="d-flex flex-row gap-4 justify-content-center mt-4">
                    <button type="button" class="btn-default btn-large" onclick="prevStep()">Voltar</button>
                    <button type="button" class="btn-default btn-large" onclick="nextStep()">Continuar</button>
                    <button type="submit" class="btn-default btn-large" style="display: none;">Finalizar</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
<script>
    let currentStep = 1;
    const totalSteps = 3;

    function showStep(step) {
        const steps = document.querySelectorAll('.step');
        steps.forEach(s => {
            s.classList.remove('d-flex');
            s.classList.add('d-none');
        });
        document.getElementById('step' + step).classList.add('d-flex');
        document.getElementById('step' + step).classList.remove('d-none');
        
        document.querySelector('button[onclick="prevStep()"]').style.display = step > 1 ? 'inline-block' : 'none';
        document.querySelector('button[onclick="nextStep()"]').style.display = step < totalSteps ? 'inline-block' : 'none';
        document.querySelector('button[type="submit"]').style.display = step === totalSteps ? 'inline-block' : 'none';

        if(currentStep == 1){
            document.getElementById('c2').classList.remove('primary-color');
            document.getElementById('c2').classList.add('light-gray');
            $("#title").text("Informações do Comerciante");
        }

        if(currentStep == 2){
            document.getElementById('c3').classList.remove('primary-color');
            document.getElementById('c3').classList.add('light-gray');
            document.getElementById('c2').classList.remove('light-gray');
            document.getElementById('c2').classList.add('primary-color');
            $("#title").text("Endereço do Comerciante");
        }

        if(currentStep == 3){
            document.getElementById('c3').classList.remove('light-gray');
            document.getElementById('c3').classList.add('primary-color');
            $("#title").text("Informações do Comerciante");
        }
    }

    function validateStep(step) {
        const stepElement = document.getElementById('step' + step);
        const inputs = stepElement.querySelectorAll('input[required]');
        for (let input of inputs) {
            if (!input.value.trim()) {
                toastr.error('Por favor, preencha todos os campos.', 'Campo vázio');
                return false;
            }
        }
        return true;
    }

    function nextStep() {
        if (validateStep(currentStep) && currentStep < totalSteps) {
            currentStep++;
            showStep(currentStep);
        }
    }

    function prevStep() {
        if (currentStep > 1) {
            currentStep--;
            showStep(currentStep);
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        showStep(currentStep);
    });

    $(document).ready(function() {
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

        $('#form_comerciante').on('submit', function(e) {
            e.preventDefault();
            var formData = $(this).serialize();
            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: formData,
                success: function(response) {
                    toastr.success('Cadastro realizado com sucesso!', 'Sucesso');
                    setTimeout(function() {
                        // window.location.href = '/';
                    }, 3000);
                },
                error: function(xhr, status, error) {
                    if(xhr.status == 409){
                        toastr.error(xhr.responseJSON.error);
                    }else if(xhr.status == 400){
                        toastr.error(xhr.responseJSON.error);                        
                    }else{
                        toastr.error('Erro ao realizar o cadastro!', 'Erro');
                    }
                }
            });
        });
    });
</script>
@endsection
