@extends('layouts.main')

@section('title', 'Pedidos')

@section('content')
@include('includes.header-easyfind')

<div class="col-md-12 px-5 py-5 d-flex flex-column gap-2">
    <h3 class="m-0">Pedidos</h3>
    <div class="d-flex flex-row gap-2">
        <p class="fc-gray">Seus pedidos</p>
    </div>
    <div class="d-flex flex-wrap gap-5" id="pedidos"></div>
</div>
@endsection
@section('script')
<script>
    $(document).ready(function(){
        load();
    });

    function load()
    {
        $.ajax({
            url: `/pedidos/load`,
            type: 'GET',
            success: function(response) {
                $('#pedidos').html(response);
            },
            error: function(xhr, status, error) {
                console.error(error);
                alert('Erro ao carregar o evento.');
            }
        });
    }
</script>
@endsection