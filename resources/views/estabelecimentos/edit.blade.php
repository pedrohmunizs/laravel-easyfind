@extends('layouts.main')
@section('title', 'Editar estabelecimento')

@section('content')
@include('includes.header')
<form id="form_estabelecimento" action="/estabelecimentos/{{ $estabelecimento->id }}" method="POST" class="needs-validation" novalidate enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="col-md-12 d-flex flex-column gap-2 mt-5 px-5">
        <h3 class="m-0">Estabelecimentos</h3>
        <div class="d-flex flex-row gap-2">
            <p class="fc-primary">Estabelecimentos</p>
            <i class="bi bi-chevron-right fc-gray"></i>
            <p class="fc-gray">Editar estabelecimento</p>
        </div>
        <div class="d-flex flex-column gap-3">
            <div class="d-flex flex-row align-items-start justify-content-between">
                <div class="bg-white container-default d-flex flex-column p-4 gap-2">
                    <h5>Dados da loja</h5>
                    <div class="d-flex flex-row gap-3 justify-content-between">
                        <div class="d-flex flex-column gap-2">
                            <div class="d-flex flex-column">
                                <label class="label-default" for="nome">Nome</label>
                                <input type="text" name="estabelecimento[nome]" class="form-control input-default w-100 px-3 py-2" value="{{ $estabelecimento->nome }}" required>
                                <div class="invalid-feedback">Por favor, adicione o nome da loja.</div>
                            </div>
                            <div class="d-flex flex-column">
                                <label class="label-default" for="segmento">Segmento</label>
                                @php
                                    $segmentos = [
                                        "Eletrônicos",
                                        "Informática",
                                        "Mercado",
                                        "Produtos naturais",
                                        "Artigos esportivos",
                                        "Vestuário",
                                        "Decoração",
                                        "Livraria"
                                    ];
                                @endphp
                                <select name="estabelecimento[segmento]" id="segmento" class="form-control input-default w-100 px-3 py-2" required>
                                    <option value=""></option>
                                    @foreach($segmentos as $segmento)
                                        <option value="{{$segmento}}" {{ $segmento == $estabelecimento->segmento ? 'selected' : '' }}>{{$segmento}}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">Por favor, selecione o segmento da loja.</div>
                            </div>
                            <div class="d-flex flex-column">
                                <label class="label-default" for="telefone">Número de contato</label>
                                <input type="text" id="telefone" name="estabelecimento[telefone]" class="form-control input-default w-100 px-3 py-2" placeholder="(00) 00000-0000" value="{{ $estabelecimento->telefone }}" required>
                                <div class="invalid-feedback">Por favor, adicione o número de contato.</div>
                            </div>
                        </div>
                        <div class="d-flex flex-column gap-2">
                            <div class="d-flex flex-column">
                                <label class="label-default" for="email">Email de contato</label>
                                <input type="email" name="estabelecimento[email]" class="form-control input-default w-100 px-3 py-2" value="{{ $estabelecimento->email }}" required>
                                <div class="invalid-feedback">Por favor, adicione o email de contato.</div>
                            </div>
                            <div class="d-flex flex-column">
                                <label class="label-default" for="instagram">Link do Instagram</label>
                                <input type="text" name="estabelecimento[url_instagram]" class="input-default w-100 px-3 py-2" value="{{ $estabelecimento->url_instagram }}">
                            </div>
                            <div class="d-flex flex-column">
                                <label class="label-default" for="facebook">Link do Facebook</label>
                                <input type="text" name="estabelecimento[url_facebook]" class="input-default w-100 px-3 py-2" value="{{ $estabelecimento->url_facebook }}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-white container-default d-flex flex-column p-4 gap-2 ">
                    <h5>Endereço</h5>
                    <div class="d-flex flex-column gap-2">
                        <div class="d-flex flex-row gap-3">
                            <div class="d-flex flex-column w-25">
                                <label class="label-default" for="cep">CEP</label>
                                <input type="text" name="endereco[cep]" class="form-control input-default w-100 px-3 py-2" id="cep" value="{{ $estabelecimento->endereco->cep }}" required>
                                <div class="invalid-feedback">Por favor, adicione o CEP.</div>
                            </div>
                            <div class="d-flex flex-column w-75">
                                <label class="label-default" for="logradouro">Logradouro</label>
                                <input type="text" name="endereco[logradouro]" class="form-control input-default w-100 px-3 py-2" id="logradouro" value="{{ $estabelecimento->endereco->logradouro }}" required>
                                <div class="invalid-feedback">Por favor, adicione o logradouro.</div>
                            </div>
                        </div>
                        <div class="d-flex flex-row gap-3">
                            <div class="d-flex flex-column">
                                <label class="label-default" for="numero">Número</label>
                                <input type="text" name="endereco[numero]" class="form-control input-default w-100 px-3 py-2" value="{{ $estabelecimento->endereco->numero }}" required>
                                <div class="invalid-feedback">Por favor, adicione o número.</div>
                            </div>
                            <div class="d-flex flex-column">
                                <label class="label-default" for="bairro">Bairro</label>
                                <input type="text" name="endereco[bairro]" class="form-control input-default w-100 px-3 py-2" id="bairro" value="{{ $estabelecimento->endereco->bairro }}" required>
                                <div class="invalid-feedback">Por favor, adicione o bairro.</div>
                            </div>
                        </div>
                        <div class="d-flex flex-row gap-3">
                            <div class="d-flex flex-column">
                                <label class="label-default">Cidade</label>
                                <input type="text" name="endereco[cidade]" class="form-control input-default w-100 px-3 py-2" id="cidade" required>
                                <div class="invalid-feedback">Por favor, adicione a cidade.</div>
                            </div>
                            <div class="d-flex flex-column">
                                <label class="label-default">Estado</label>
                                <input type="text" name="endereco[estado]" class="form-control input-default w-100 px-3 py-2" id="estado" required>
                                <div class="invalid-feedback">Por favor, adicione o estado.</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex flex-row gap-2 align-items-start justify-content-between">
                <div class="bg-white container-default d-flex flex-column p-4 gap-2 col-md-9">
                    <h4>Horário de atendimento</h4>
                    @php
                        $days = ['Domingo', 'Segunda-feira', 'Terça-feira', 'Quarta-feira', 'Quinta-feira', 'Sexta-feira', 'Sábado'];
                    @endphp

                    @foreach($days as $day)

                        @php
                            $currentDayData = $estabelecimento->agendas->firstWhere('dia', $day);
                        @endphp

                        <x-day :day="$day" :data="$currentDayData ? ['horario_inicio' => $currentDayData->horario_inicio, 'horario_fim' => $currentDayData->horario_fim] : null" />
                    @endforeach
                </div>
                <div class="bg-white container-default d-flex flex-column p-4 gap-2">
                    <h4>Imagem da loja</h4>
                    <div class="form-group d-flex justify-content-center">
                        @if($estabelecimento->imagem)                        
                            <input type="file" class="form-control-file none" id="image" name="image">
                            <div class="mt-3">
                                <img id="imagePreview" src="/img/estabelecimentos/{{ $estabelecimento->imagem->nome_referencia }}" alt="Prévia da imagem" />
                            </div>
                        @else
                            <input type="file" class="form-control-file none" id="image" name="image">
                            <div class="mt-3">
                                <img id="imagePreview" src="https://via.placeholder.com/150" alt="Prévia da imagem" />
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12 d-flex flex-row-reverse bg-white p-3 gap-3 mt-3 bottom-0">
        <div class="d-flex flex-row gap-2">
            <a href="/estabelecimentos" class="btn-default small a-button px-3 py-2 btn-cancel d-flex flex-row gap-2"><i class="bi bi-x-lg"></i>
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
        $('#telefone').mask('(00) 00000-0000');
        $('#cep').mask('00000-000');

        $('#form_estabelecimento').on('submit', function (e) {
            e.preventDefault();

            var formData = new FormData(this);

            $.ajax({
                type: 'POST',
                url: $(this).attr('action'),
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    toastr.success(response.message, 'Sucesso');
                    setTimeout(function() {
                        window.location.href = '/estabelecimentos';
                    }, 3000);
                },
                error: function (xhr, status, error) {
                    if (xhr.status == 409) {
                        toastr.error(xhr.responseJSON.message);
                    } else if (xhr.status == 400) {
                        toastr.error(xhr.responseJSON.message);
                    } else {
                        toastr.error('Erro ao realizar o cadastro do estabelecimento!', 'Erro');
                    }
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