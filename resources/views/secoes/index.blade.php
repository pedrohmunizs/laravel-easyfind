@extends('layouts.main')

@section('title', 'Seções')

@section('content')
@include('includes.header-comerciante')
@include('includes.menu', ['estabelecimento' => $estabelecimento])
<div class="col-md-10 offset-md-2 px-4 py-5 d-flex flex-column gap-2">
    <h3 class="m-0">Seções</h3>
    <div class="d-flex flex-row gap-2">
        <p class="fc-primary">Produtos</p>
        <i class="bi bi-chevron-right fc-gray"></i>
        <p class="fc-gray">Lista de seções</p>
    </div>
    <div class="d-flex flex-row justify-content-between">
        <div class="input-group mb-3" style="width: 50%;">
            <i class="bi bi-search px-3 pr-0 py-2 fs-14 bg-white container-default border-end-0"></i>
            <div class="" style="width: 80%;">
                <input type="text" class="input-default px-3 py-2 w-100 fs-14 input-search" placeholder="Buscar seção" id="search" value="">
            </div>
        </div>
        <div class="d-flex flex-row gap-3">
            <a href="/secoes/{{$estabelecimento->id}}/create" class="btn-default small a-button px-3 py-2 d-flex flex-row gap-2"><i class="bi bi-plus-lg"></i><p class="m-0">Cadastrar Seção</p></a>
        </div>
    </div>
    <div>
        <select name="" id="per_page" class="bg-white py-1 px-3 border-0 br-8">
            <option value="5">5</option>
            <option value="10">10</option>
            <option value="15">15</option>
        </select>
    </div>
    <div class="table-container mt-3 shadow-sm">
        <table class="table">
            <thead class="table-dark">
                <tr>
                    <th scope="col">Nome</th>
                    <th scope="col">Qtd Produtos</th>
                    <th scope="col">Ação</th>
                </tr>
            </thead>
            <tbody id="table-content"></tbody>
        </table>
        <div class="pagination px-4"></div>
    </div>
</div>
@endsection
@section('script')
<script>
    let per_page = 5;
        
    $(document).ready(function(){
        load();    
    });

    function load(){
        let search = $('#search').val();
        $.ajax({
            url: `/secoes/{{$estabelecimento->id}}/load?page=${page}&per_page=${per_page}&search=${search}`,
            type: 'GET',
            success: function(response) {
                $('#table-content').html(response.tableContent);
                $('.pagination').html(response.pagination);
            },
            error: function(xhr, status, error) {
                console.error(error);
                alert('Erro ao carregar o evento.');
            }
        });
    }

    $(document).on('click', '.delete', function(){
        let id = this.id;

        $.ajax({
            url: `${id}`,
            type: 'DELETE',
            data: {
                "_token": "{{ csrf_token() }}",
            },
            success: function(response) {
                toastr.success('Seção excluída com sucesso!', 'Sucesso');
                setTimeout(function() {
                     window.location.reload();
                }, 3000);
            },
            error: function(xhr, status, error) {
                toastr.error('Erro ao excluir seção!', 'Erro');
            }
        });
    })

</script>
@endsection