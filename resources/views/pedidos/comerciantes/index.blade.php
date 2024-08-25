@extends('layouts.main')

@section('title', 'Pedidos')

@section('content')
@include('includes.header')
@include('includes.menu', ['estabelecimento' => $estabelecimento])
<div class="col-md-10 offset-md-2 px-4 py-5 d-flex flex-column gap-2">
    <h3 class="m-0">Pedidos</h3>
    <div class="d-flex flex-row gap-2">
        <p class="fc-primary">Pedidos</p>
    </div>
    <div class="d-flex flex-row justify-content-between">
        <div class="d-flex flex-row bg-white p-1 container-default date">
            <button class="btn-cancel border-0 px-3 py-1 date_filter" id="0">Todos</button>
            <button class="btn-cancel border-0 px-3 py-1 date_filter" id="30">30 dias</button>
            <button class="btn-cancel border-0 px-3 py-1 date_filter" id="7">7 dias</button>
            <button class="btn-default px-3 py-1 date_filter" id="1">24 horas</button>
        </div>
        <div class="d-flex flex-row gap-4">
            <select name="produto[is_ativo]" id="order" class="px-3 py-2 input-default w-100">
                <option value="DESC"><p class="m-0">Mais recentes</p></option>
                <option value="ASC"><p class="m-0">Mais antigo</p></option>
            </select>
            <button class="btn-default py-2 px-3 small d-flex flex-row gap-2 container-default bg-white fc-gray" id="filtro"><i class="bi bi-funnel fc-gray"></i>
                <p class="m-0">Filtro</p>
            </button>
        </div>
    </div>
    <div class="d-flex flex-row-reverse">
        <div class="d-none flex-column flex-wrap bg-white p-3 gap-3 border border-2 br-8 w-fit-content right-0" id="card-filter">
            <h4 class="m-0">Filtro</h4>
            <form action="form_filter" id="form_filter">
                <div class="d-flex flex-row gap-3">
                    <div class="d-flex flex-column">
                        <label class="fs-13" for="nome">Status</label>
                        <select name="filter[status]" class="px-3 py-2 input-default">
                            <option value="">Indiferente</option>
                            @foreach(App\Enums\StatusPedido::cases() as $status)
                                @if($status->value != 'cancelado' && $status->value != 'finalizado')
                                    <option value="{{ $status->value }}">{{ $status->name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="d-flex flex-column">
                        <label class="fs-13" for="nome">Modo de  compra</label>
                        <select name="filter[is_pagamento_online]" class="px-3 py-2 input-default">
                            <option value="">Indiferente</option>
                            <option value="1">Pagamento no site</option>
                            <option value="0">Pagamento na loja</option>
                        </select>
                    </div>
                </div>
            </form>
            <div class="d-flex flex-row-reverse gap-3">
                <button class="btn-default py-2 px-3 small" id="apply-filter">Aplicar</button>
                <button class="btn-default py-2 px-3 small" id="clear-filter">Limpar filtro</button>
            </div>
        </div>
    </div>
    <div class="d-flex flex-column">
        <div class="table-container mt-3 shadow-sm">
            <table class="table">
                <thead class="table-dark">
                    <tr>
                        <th scope="col"><h6 class="m-0">Id</h6></th>
                        <th scope="col"><h6 class="m-0">Consumidor</h6></th>
                        <th scope="col"><h6 class="m-0">Valor</h6></th>
                        <th scope="col"><h6 class="m-0">Modo compra</h6></th>
                        <th scope="col"><h6 class="m-0">Status</h6></th>
                        <th scope="col"><h6 class="m-0">Ação</h6></th>
                    </tr>
                </thead>
                <tbody id="table-content"></tbody>
            </table>
            <div class="pagination px-4"></div>
        </div>
    </div>

</div>
@endsection
@section('script')
<script>
    let range = 1;
    let order = "DESC"

    $(document).ready(function(){
        load()
    })

    function load (){
        let formData = $('#form_filter').serialize();

        $.ajax({
            url: `/pedidos/{{$estabelecimento->id}}/load?page=${page}&range=${range}&order=${order}&${formData}`,
            type: 'GET',
            success: function(response) {
                $('#table-content').html(response.tableContent);
                $('.pagination').html(response.pagination);
            },
            error: function(xhr, status, error) {
                toastr.error('Erro ao carregar os pedidos!', 'Erro');
            }
        });
    }


    $(".date_filter").on('click', function(){
        let buttons = document.getElementsByClassName('date_filter');

        Array.from(buttons).forEach(button => {
            button.classList.remove('btn-default');
            button.classList.add('btn-cancel');
            button.classList.add('border-0');
        });
        this.classList.add('btn-default')
        this.classList.remove('btn-cancel');
        this.classList.remove('border-0');
        range = this.id;

        load();
    })

    document.getElementById('order').addEventListener('change', function(){
        order = this.value;
        load()
    });

    $('#filtro').on('click', function() {
        if ($("#card-filter").hasClass('d-none')) {
            $("#card-filter").removeClass('d-none')
            $("#card-filter").addClass('d-flex')
        } else {
            $("#card-filter").removeClass('d-flex')
            $("#card-filter").addClass('d-none')
        }
    })

    $('#apply-filter').on('click', function() {
        load();
    });

    $('#clear-filter').on('click', function() {
        $('#form_filter')[0].reset();
        load();
    });
</script>
@endsection