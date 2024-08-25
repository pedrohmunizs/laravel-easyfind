@extends('layouts.main')

@section('title', 'Estabelecimentos')

@section('content')
@include('includes.header')
<div class="main-content w-100">
    <div class="col-md-12 pt-5 px-5">
        <div class="d-flex flex-column gap-2 mb-3">
            <h3 class="m-0">Estabelecimentos</h3>
            <div class="d-flex flex-row gap-2">
                <p class="fc-primary">Estabelecimentos</p>
            </div>
            <div class="d-flex flex-row justify-content-between">
                <div class="input-group mb-3" style="width: 50%;">
                    <i class="bi bi-search px-3 pr-0 py-2 fs-14 bg-white container-default border-end-0"></i>
                    <div class="" style="width: 80%;">
                        <input type="text" class="input-default px-3 py-2 w-100 fs-14 input-search" placeholder="Buscar estabelecimento" id="search" value="">
                    </div>
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
                toastr.error('Erro ao carregar estabelecimentos.');
            }
        });
    }
</script>
@endsection