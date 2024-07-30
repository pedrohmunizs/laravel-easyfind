@extends('layouts.main')

@section('title', 'Adicionar método de pagamento')

@section('content')
@include('includes.header')
@include('includes.menu', ['estabelecimento' => $estabelecimento])
<form id="form_metodo" action="/metodos" method="POST">
    @csrf
    <div class="col-md-10 offset-md-2 px-4 py-5 d-flex flex-column gap-2">
        <h3 class="m-0">Métodos de pagamento aceitos</h3>
        <div class="d-flex flex-row gap-2">
            <a href="/metodos/{{$estabelecimento->id}}" class="a-default">
                <p class="fc-primary">Métodos de pagamento</p>
            </a>
            <i class="bi bi-chevron-right fc-gray"></i>
            <p class="fc-gray">Cadastrar método</p>
        </div>
        <div class="d-flex flex-column gap-4">
            <div class="d-flex flex-column">
                <label for="label-default">Método de pagamento</label>
                <select name="" id="select_metodo" class="px-3 py-2 input-default">
                    <option value="">Selecione</option>
                    @foreach($metodosPagamento as $metodoPagamento)
                        <option value="{{$metodoPagamento->id}}">{{$metodoPagamento->descricao}}</option>
                    @endforeach
                </select>
            </div>
            <div class="d-flex flex-column gap-5 metodos">
                @foreach($metodosPagamento as $metodoPagamento)
                <div class="d-none flex-column container-default bg-white p-4 w-fit-content gap-3" id="{{$metodoPagamento->id}}">
                    <h5>Bandeiras</h5>
                    <div class="d-flex flex-row flex-wrap  gap-5">
                        @php
                            $count = 0;
                        @endphp
                        @foreach($bandeirasMetodos as $bandeiraMetodo)
                            @if($bandeiraMetodo->fk_metodo_pagamento == $metodoPagamento->id)
                                @if ($count % 3 == 0)
                                    <div class="d-flex flex-column gap-2">
                                @endif
                                <div class="d-flex flex-row align-items-center gap-2 mb-2">
                                        <input class="form-check-input m-0" name="metodo[]" type="checkbox" id="defaultCheck1" value="{{$bandeiraMetodo->id}}">
                                    <div>
                                        <img src="/img/bandeiras/{{$bandeiraMetodo->imagem}}" alt="" style="width: 44px;">
                                    </div>
                                    <input value="{{$estabelecimento->id}}" class="d-none" name="estabelecimento">
                                </div>
                                @php
                                    $count++;
                                @endphp
                                @if ($count % 3 == 0)
                                    </div>
                                @endif
                            @endif
                        @endforeach
                        @if ($count == 0)
                            <p>Todas as bandeiras disponíveis já foram atreladas a esse estabelecimento.</p>
                        @endif
                        @if ($count % 3 != 0)
                            </div>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="col-md-12 d-flex flex-row-reverse bg-white p-3 gap-3 position-fixed bottom-0">
        <div class="d-flex flex-row gap-2">
            <a href="/metodos/{{$estabelecimento->id}}" class="btn-default small a-button px-3 py-2 btn-cancel d-flex flex-row gap-2" ><i class="bi bi-x-lg"></i><p class="m-0">Cancelar</p></a>
            <button type="submit" class="btn-default py-2 px-3 small d-flex flex-row gap-2" ><i class="bi bi-floppy"></i><p class="m-0">Salvar</p></button>
        </div>
    </div>
</form>
@endsection
@section('script')
<script>
    $('#select_metodo').on('change', function(){
        let div = document.getElementById(this.value);
        const metodos = document.querySelector('.metodos');

        for(let child of metodos.children){            

            if(child.id == this.value){
                child.classList.toggle('d-flex')
                child.classList.toggle('d-none')

            }else{
                child.classList.remove('d-flex')
                child.classList.add('d-none')
            }
        }

        const checkboxes = metodos.querySelectorAll('input[type="checkbox"]');
        checkboxes.forEach(checkbox => {
            checkbox.checked = false;
        });
    })

    $('#form_metodo').on('submit', function(e) {
        e.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            success: function(response) {
                toastr.success('Método cadastrado com sucesso!', 'Sucesso');
                setTimeout(function() {
                    window.location.href = `/metodos/{{$estabelecimento->id}}`;
                }, 3000);
            },
            error: function(xhr, status, error) {
                toastr.error('Erro ao cadastrar método!', 'Erro');
            }
        });
    });
</script>
@endsection