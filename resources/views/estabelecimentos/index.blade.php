@extends('layouts.main')

@section('title', 'Estabelecimentos')

@section('content')
@include('includes.header-comerciante')
<div class="main-content w-100">
    <div class="col-md-12 pt-5 px-9">
        <div class="d-flex flex-column gap-2 mb-5">
            <h3>Estabelecimentos</h3>
            <div class="d-flex flex-row justify-content-between">
                <div class="col-md-5">
                    <input type="text" class="form-control" placeholder="Buscar estabelecimento" id="search" value="">
                </div>
                <a href="{{ route('estabelecimentos.create') }}" class="a-button bgc-primary px-3 py-2 fit-content br-8 d-flex flex-row gap-2">
                    <i class="bi bi-plus-lg"></i>
                    <p class="m-0">Cadastrar Estabelecimento</p>
                </a>
            </div>
        </div>
        <div class="d-flex flex-row flex-wrap justify-content-between" id="card"></div>
    </div>
</div>
@endsection
@section('script')
<script>
    $(document).ready(function() {
        load();

        $("#search").on('keyup', function() {
            load();
        });

        $(document).on('click', '.btnGerenciarEstabelecimento', function(e) {
            e.preventDefault();
            var idEstabelecimento = $(this).data('id-estabelecimento');
            console.log('ID Estabelecimento:', idEstabelecimento);
            if (idEstabelecimento) {
                sessionStorage.removeItem('idEstabelecimento');
                sessionStorage.setItem('idEstabelecimento', idEstabelecimento);
                window.location.href = `/produtos/${idEstabelecimento}`;
            }
        });
    });

    function load() {
        var search = $('#search').val();
        $.ajax({
            url: `/estabelecimentos/load?search=${search}`,
            type: 'GET',
            success: function(response) {
                $('#card').html(null)
                $('#card').html(response);
            },
            error: function(xhr, status, error) {
                alert('Erro ao carregar estabelecimentos.');
            }
        });
    }
</script>
@endsection