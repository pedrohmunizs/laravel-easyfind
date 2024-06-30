@extends('layouts.main')

@section('title', 'Gerenciar')

@section('content')
@include('includes.header')
    <div class="container-fluid main-content" style="margin-top: 71px;">
        <div class="row">
            @include('includes.menu')
            <div class="col-md-10 offset-md-2 p-4">
                <h1>Teste</h1>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    Launch demo modal
                </button>
                @include('estabelecimentos.create')                
            </div>
        </div>
    </div>
@endsection
@section('script')
<script>

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

    document.addEventListener('DOMContentLoaded', function() {
    showStep(currentStep);

    document.getElementById('form_estabelecimento').addEventListener('submit', function(e) {
        e.preventDefault();

        if (validateStep(currentStep)) {
            var formData = $(this).serialize();
            console.log(formData)
            $.ajax({
                url: this.action,
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    toastr.success('Cadastro realizado com sucesso!', 'Sucesso');
                    setTimeout(function() {
                        // window.location.href = '/';
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
    });
    });
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

    document.getElementById('exampleModal').addEventListener('hidden.bs.modal', resetForm);

    function resetForm() {
        document.getElementById('form_estabelecimentos').reset();
        currentStep = 1;
        showStep(currentStep);
        document.getElementById('imagePreview').src = 'https://via.placeholder.com/250';
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

</script>
@endsection
