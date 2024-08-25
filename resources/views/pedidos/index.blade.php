@extends('layouts.main')

@section('title', 'Pedidos')

@section('content')
@include('includes.header')

<div class="col-md-12 px-5 py-5 d-flex flex-column gap-2">
    <h3 class="m-0">Pedidos</h3>
    <div class="d-flex flex-row gap-2">
        <p class="fc-gray">Seus pedidos</p>
    </div>
    <div class="d-flex flex-column gap-2 mb-2">
        <label class="label-default">Status</label>
        <select name="" id="status" class="bg-white py-1 px-3 border-0 br-8 w-fit-content">
            <option value="">Indiferente</option>
            <option value="pendente">Pendente</option>
            <option value="em_preparo">Em Preparo</option>
            <option value="aguardando_retirada">Aguardado Retirada</option>
            <option value="cancelado">Cancelado</option>
            <option value="finalizado">Finalizado</option>
        </select>
    </div>
    <div class="d-flex flex-wrap gap-3 col-md-12" id="pedidos"></div>
</div>
@endsection
@section('script')
<script>

    $(document).ready(function(){
        load();
    });

    function load()
    {
        let status = $('#status').val()
        $.ajax({
            url: `/pedidos/load?status=${status}`,
            type: 'GET',
            success: function(response) {
                $('#pedidos').html(response);
            },
            error: function(xhr, status, error) {
                toastr.error('Erro ao carregar o pedidos.');
            }
        });
    }

    $('#status').on('change', function(){
        load();
    })
</script>
@endsection