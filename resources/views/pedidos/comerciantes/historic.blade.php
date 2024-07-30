@extends('layouts.main')

@section('title', 'Histórico de pedidos')

@section('content')
@include('includes.header')
@include('includes.menu', ['estabelecimento' => $estabelecimento])
<div class="col-md-10 offset-md-2 px-4 py-5 d-flex flex-column gap-2">
    <h3 class="m-0">Histórico de pedidos</h3>
    <div class="d-flex flex-row gap-2">
        <p class="fc-primary">Histórico</p>
    </div>
    <div class="d-flex flex-row justify-content-between">
        <div class="d-flex flex-row gap-2">
            <div>
                <select id="per_page" class="bg-white py-2 px-3 border-0 br-8 fs-14">
                    <option value="10"><p class="m-0">10</p></option>
                    <option value="25"><p class="m-0">25</p></option>
                    <option value="50"><p class="m-0">50</p></option>
                </select>
            </div>
            <div>
                <select id="order" class="bg-white py-2 px-3 border-0 br-8 fs-14">
                    <option value="DESC"><p class="m-0">Do mais novo</p></option>
                    <option value="ASC"><p class="m-0">Do mais antigo</p></option>
                </select>
            </div>
        </div>
        <button class="btn-default py-2 px-3 small d-flex flex-row gap-2 container-default bg-white fc-gray" id="filtro"><i class="bi bi-funnel fc-gray"></i>
            <p class="m-0">Filtro</p>
        </button>
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
                                @if($status->value == 'cancelado' || $status->value == 'finalizado')
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
                    <div class="d-flex flex-column">
                        <label class="fs-13" for="nome">Desde</label>
                        <input type="date" name="filter[data_min]" class="px-3 py-2 input-default">
                    </div>
                    <div class="d-flex flex-column">
                        <label class="fs-13" for="nome">Até</label>
                        <input type="date" name="filter[data_max]" class="px-3 py-2 input-default">
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
        <div class="table-container mt-2 shadow-sm">
            <table class="table">
                <thead class="table-dark">
                    <tr>
                        <th scope="col"><h6 class="m-0">Id</h6></th>
                        <th scope="col"><h6 class="m-0">Data do pedido</h6></th>
                        <th scope="col"><h6 class="m-0">CPF do cliente</h6></th>
                        <th scope="col"><h6 class="m-0">Modo compra</h6></th>
                        <th scope="col"><h6 class="m-0">Valor</h6></th>
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
    let per_page = 10;
    let order = $('#order').val();

    $(document).ready(function(){
        load();
    })

    function load (){
        let formData = $('#form_filter').serialize();
        
        $.ajax({
            url: `/pedidos/{{$estabelecimento->id}}/historico/load?${formData}&page=${page}&per_page=${per_page}&order=${order}`,
            type: 'GET',
            success: function(response) {
                $('#table-content').html(response.tableContent);
                $('.pagination').html(response.pagination);
                $('.cpf').mask('000.000.000-00');
            },
            error: function(xhr, status, error) {
                console.error(error);
                alert('Erro ao carregar o histórico de pedidos');
            }
        });
    }
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
        page = 1;
        load();
    });

    $('#clear-filter').on('click', function() {
        $('#form_filter')[0].reset();
        load();
    });

    $('#order').on('change', function(){
        order = this.value
        load()
    })

</script>
@endsection