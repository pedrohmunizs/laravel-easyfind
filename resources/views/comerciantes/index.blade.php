@extends('layouts.main')

@section('title', 'Lojas')

@section('content')
@include('includes.header')
<div class="main-content w-100" style="margin-top: 53px;">
    <div class="col-md-12 pt-5 px-9">
        <div class="d-flex flex-column gap-2 mb-5">
            <h3>Lojas</h3>
            <div class="d-flex flex-row justify-content-between">
                <div class="col-md-5">
                    <input type="text" class="form-control" placeholder="Buscar estabelecimento" id="search" value="">
                </div>
                <button type="button" class="btn-default py-2 px-3 small" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    <i class="bi bi-plus-lg"></i>
                    Cadastrar loja
                </button>
            </div>
        </div>
        <div class="d-flex flex-row flex-wrap justify-content-between" id="card"></div>
        @include('estabelecimentos.create')
    </div>
</div>
@endsection
@section('script')
<script>


    $(document).ready(function() {
        load();
        
        function load(){
            var search = $('#search').val();
            $.ajax({
                url: `/estabelecimentos/load?search=${search}`,
                type: 'GET',
                success: function(response) {
                    $('#card').html(null)
                    $('#card').html(response);
                },
                error: function(xhr, status, error) {
                    alert('Erro ao carregar lojas.');
                }
            });
        }

        $("#search").on('keyup', function() {
            load();
        });
    });

    let currentStep = 1;
    const totalSteps = 4;

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

        const progressBar = document.querySelector('.progress-bar');
        progressBar.style.width = (step / totalSteps) * 100 + '%';
    }

    function validateStep(step) {
        const stepElement = document.getElementById('step' + step);
        const inputs = stepElement.querySelectorAll('input[required], textarea[required], select[required]');
        let isValid = true;

        inputs.forEach(input => {
            if (!input.value.trim()) {
                input.classList.add('is-invalid');
                isValid = false;
            } else {
                input.classList.remove('is-invalid');
            }
        });

        if (!isValid) {
            toastr.error('Por favor, preencha todos os campos obrigatórios.', 'Erro de Validação');
        }
        return isValid;
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

    document.getElementById('imagePreview').addEventListener('click', function() {
        document.getElementById('image').click();
    });

    document.getElementById('image').addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const imagePreview = document.getElementById('imagePreview');
                imagePreview.src = e.target.result;
                imagePreview.style.display = 'block';
            }
            reader.readAsDataURL(file);
        }
    });

    $('#exampleModal').on('hidden.bs.modal', function () {
        resetForm();
    });

    function resetForm() {
        document.getElementById('form_estabelecimento').reset();
        currentStep = 1;
        showStep(currentStep);
        
        const inputs = document.querySelectorAll('#form_estabelecimento input, #form_estabelecimento select, #form_estabelecimento textarea');
        inputs.forEach(input => {
            input.classList.remove('is-invalid');
        });

        document.getElementById('imagePreview').src = 'https://via.placeholder.com/150';
    }

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

    function toggleTimeInputs(day) {
        const checkbox = document.getElementById('day-' + day);
        const timeInputs = document.querySelectorAll('.' + day);
        const label = document.getElementById('label-' + day);

        timeInputs.forEach(input => {
            input.disabled = !checkbox.checked;
        });

        if (checkbox.checked) {
            label.textContent = 'Aberto';
        } else {
            label.textContent = 'Fechado';
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const days = ['Domingo', 'Segunda-feira', 'Terça-feira', 'Quarta-feira', 'Quinta-feira', 'Sexta-feira', 'Sábado'];

        days.forEach(day => {
            toggleTimeInputs(day);
        });
    });

    $('#form_estabelecimento').on('submit', function(e) {
        e.preventDefault();

        if (validateStep(currentStep)) {
            var formData = new FormData(this);
            $.ajax({
                url: this.action,
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    toastr.success('Cadastro realizado com sucesso!', 'Sucesso');
                    $('#exampleModal').modal('hide');
                    setTimeout(function() {
                        // window.location.href = '/';
                    }, 3000);
                },
                error: function(xhr, status, error) {
                    if (xhr.status == 409) {
                        toastr.error(xhr.responseJSON.message);
                    } else if (xhr.status == 400) {
                        toastr.error(xhr.responseJSON.message);
                    } else {
                        toastr.error('Erro ao realizar o cadastro!', 'Erro');
                    }
                }
            });
        }
    });
</script>
@endsection