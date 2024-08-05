@extends('layouts.main')

@section('title', 'EasyFind')

@section('content')
@include('includes.header')
<form id="form_pedido" action="/pedidos" method="POST">
    @csrf
    <div class="col-md-12 px-5 py-5 d-flex flex-column gap-2">
        <h3 class="m-0">Pedido</h3>
        <div class="d-flex flex-row justify-content-between">
            <div class="d-flex flex-column col-md-7 bg-white container-default px-4 py-3">
                <h6>Momento do pagamento</h6>
                <div class="d-flex flex-column gap-2 mt-3 momento">
                    <div class="d-flex flex-row gap-2">
                        <input type="checkbox" name="pedido[is_pagamento_online]" value="1" disabled>
                        <label for="" class="label-default">Pagar aqui e retire na loja</label>
                    </div>
                    <div class="d-flex flex-row gap-2">
                        <input type="checkbox" name="pedido[is_pagamento_online]" value="0">
                        <label for="" class="label-default">Realizar o pagamento na loja</label>
                    </div>
                    <button type="button" class="btn-default px-3 py-1 fs-14" id="momento">Continuar</button>
                </div>
                <hr>
                <h6>Selecione o método pagamento</h6>
                <div class="d-none flex-column metodos gap-2">
                    <div class="d-flex flex-column">
                        <label for="label-default">Método de pagamento</label>
                        <select name="" id="select_metodo" class="px-3 py-2 input-default">
                            <option value="">Selecione</option>
                            @foreach($metodos as $metodoPagamento)
                                <option value="{{$metodoPagamento->id}}">{{$metodoPagamento->descricao}}</option>
                            @endforeach
                        </select>
                    </div>
                    @foreach($metodos as $metodo)
                        <div class="d-none flex-row gap-3 bandeiras" id="{{$metodo->id}}">
                            @foreach($aceitos as $aceito)
                                @if($aceito->bandeiraMetodo->fk_metodo_pagamento == $metodo->id)
                                    <div class="d-flex flex-row align-items-center gap-2">
                                        <input type="checkbox" name="pedido[fk_metodo_aceito]" value="{{$aceito->bandeiraMetodo->id}}">
                                        <div>
                                            <img src="/img/bandeiras/{{$aceito->bandeiraMetodo->bandeiraPagamento->imagem}}" alt="" style="width: 44px;">
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @endforeach
                    <button type="button" class="btn-default px-3 py-1 fs-14 mt-1" id="metodo">Continuar</button>
                </div>
                <hr>
                <h6>Finalizar</h6>
                <div class="d-none flex-row align-items-center finalizar gap-3">
                    @php
                        $preco = 0;
                    @endphp
                    @foreach($produtos as $produto)
                        @if($produto->is_promocao_ativa)
                            @php
                                $preco += $produto->preco_oferta * $produto->quantidade;
                            @endphp
                        @else
                            @php
                                $preco += $produto->preco * $produto->quantidade;
                            @endphp
                        @endif
                    @endforeach
                    <h5 class="m-0">Total do pedido: R$ {{ number_format($preco, 2, ',', '.') }}</h5>
                    @foreach($produtos as $produto)
                        <input type="hidden" value="{{ $produto->id }}" name="itemVenda[{{ $loop->index }}][fk_produto]">
                        <input type="hidden" value="{{ $produto->quantidade }}" name="itemVenda[{{ $loop->index }}][quantidade]">
                    @endforeach
                    <input type="hidden" value="{{ $origem }}" name="pedido[origem]">
                    <button type="submit" class="btn-default px-3 py-1 fs-14 mt-1" id="finalizar">Finalizar</button>
                </div>
            </div>
            <div class="d-flex flex-column col-md-4">
                <div class="d-flex flex-column bg-white container-default px-4 py-3 gap-2">
                    <h3>Resumo do pedido</h3>
                    @php
                        $preco = 0;
                    @endphp
                    @foreach($produtos as $produto)
                        <div class="d-flex flex-row">
                            <img src="/img/produtos/{{$produto->imagens[0]['nome_referencia']}}" alt="" style="height: 50px; width:50px">
                            <div class="d-flex flex-column">
                                <p class="m-0">{{$produto->nome}}</p>
                                @if($produto->is_promocao_ativa)
                                    @php
                                        $preco += $produto->preco_oferta * $produto->quantidade;
                                    @endphp
                                    <h6 class="m-0">R$ {{ number_format($produto->preco_oferta, 2, ',', '.') }}</h6>
                                @else
                                    @php
                                        $preco += $produto->preco * $produto->quantidade;
                                    @endphp
                                    <h6 class="m-0">R$ {{ number_format($produto->preco, 2, ',', '.') }}</h6>
                                @endif
                            </div>
                            <div class="d-flex align-items-center ms-3">
                                <p class="m-0">Unidades: {{$produto->quantidade}}</p>
                            </div>
                        </div>
                    @endforeach
                    <h6 class="m-0">Total do pedido: R$ {{ number_format($preco, 2, ',', '.') }}</h6>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@section('script')
<script>
    document.querySelectorAll('.momento input[type="checkbox"]').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            if (this.checked) {
                document.querySelectorAll('.momento input[type="checkbox"]').forEach(otherCheckbox => {
                    if (otherCheckbox !== this) {
                        otherCheckbox.checked = false;
                    }
                });
            }
        });
    });

    document.querySelectorAll('.bandeiras input[type="checkbox"]').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            if (this.checked) {
                document.querySelectorAll('.bandeiras input[type="checkbox"]').forEach(otherCheckbox => {
                    if (otherCheckbox !== this) {
                        otherCheckbox.checked = false;
                    }
                });
            }
        });
    });

    document.getElementById('momento').addEventListener('click', function() {
        const checkboxes = document.querySelectorAll('.momento input[type="checkbox"]');
        let isSelected = false;
        checkboxes.forEach(checkbox => {
            if (checkbox.checked) {
                isSelected = true;
            }
        });

        if (isSelected) {
            const metodos = document.getElementsByClassName('metodos');
            Array.from(metodos).forEach(metodo => {
                metodo.classList.remove('d-none');
                metodo.classList.add('d-flex');
            });
        } else {
            toastr.error("Selecione em que momento será feito o pagamento!");
        }
    });

    document.getElementById('metodo').addEventListener('click', function() {
        const checkboxes = document.querySelectorAll('.bandeiras input[type="checkbox"]');
        let isSelected = false;
        checkboxes.forEach(checkbox => {
            if (checkbox.checked) {
                isSelected = true;
            }
        });

        if (isSelected) {
            const finalizar = document.getElementsByClassName('finalizar');
            Array.from(finalizar).forEach(f => {
                f.classList.remove('d-none');
                f.classList.add('d-flex');
            });
        } else {
            toastr.error("Selecione uma bandeira!");
        }
    });

    document.getElementById('select_metodo').addEventListener('change', function() {
        const bandeiras = document.getElementsByClassName('bandeiras');

        Array.from(bandeiras).forEach(bandeira => {
            bandeira.classList.remove('d-flex');
            bandeira.classList.add('d-none');
        });

        let div = document.getElementById(this.value);

        div.classList.remove('d-none');
        div.classList.add('d-flex');
    });

    document.getElementById('form_pedido').addEventListener('submit', function(e) {
        e.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            success: function(response) {
                toastr.success('Sucesso ao realizar pedido!', 'Sucesso');
                setTimeout(function() {
                    window.location.href = '/pedidos';
                }, 3000);
            },
            error: function(xhr, status, error) {
                toastr.error('Erro ao realizar pedido!', 'Erro');
            }
        });
    });
</script>
@endsection
