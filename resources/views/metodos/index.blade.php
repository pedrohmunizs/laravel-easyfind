@extends('layouts.main')

@section('title', 'Métodos do estabelecimento')

@section('content')
@include('includes.header')
@include('includes.menu', ['estabelecimento' => $estabelecimento])
<div class="col-md-10 offset-md-2 px-4 py-5 d-flex flex-column gap-2">
    <h3 class="m-0">Métodos de pagamento aceitos</h3>
    <div class="d-flex flex-row gap-2">
        <p class="fc-primary">Métodos de pagamento</p>
    </div>
    <div class="d-flex flex-row-reverse">
        <div class="d-flex flex-row gap-3">
            <button class="btn-default py-2 px-3 small d-flex flex-row gap-2 container-default bg-white" id="filtro"><i class="bi bi-funnel fc-gray"></i><p class="m-0 fc-gray">Filtro</p></button>
            <a href="/metodos/{{$estabelecimento->id}}/create" class="btn-default small a-button px-3 py-2 d-flex flex-row gap-1 container-primary"><i class="bi bi-plus-lg"></i><p class="m-0">Vincular método</p></a>
        </div>
    </div>
    <div>
        <select name="" id="per_page" class="bg-white py-2 px-3 border-0 br-8 fs-14 w-fit-content">
            <option value="10">10</option>
            <option value="20">20</option>
            <option value="50">50</option>
        </select>
        <div class="d-flex flex-row-reverse">
            <div class="d-none flex-column flex-wrap bg-white p-3 gap-3 border border-2 br-8 w-fit-content" id="card-filter">
                <h4 class="m-0">Filtro</h4>
                <form action="form_filter" id="form_filter">
                    <div class="d-flex flex-row gap-3">
                        <div class="d-flex flex-column">
                            <label class="fs-13" for="nome">Método de pagamento</label>
                            <select name="filter[metodo]" class="px-3 py-2 input-default">
                                <option value="">Indiferente</option>
                                @foreach($metodos as $metodo)
                                    <option value="{{$metodo->id}}">{{$metodo->descricao}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="d-flex flex-column">
                            <label class="fs-13" for="nome">Bandeiro do pagamento</label>
                            <select name="filter[bandeira]" class="px-3 py-2 input-default">
                                <option value="">Indiferente</option>
                                @foreach($bandeiras as $bandeira)
                                    <option value="{{$bandeira->id}}">{{$bandeira->nome}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </form>
                <div class="d-flex flex-row-reverse gap-3">
                    <button class="btn-default py-2 px-3 small" id="apply-filter" >Aplicar</button>
                    <button class="btn-default py-2 px-3 small" id="clear-filter" >Limpar filtro</button>
                </div>
            </div>
        </div>
    </div>
    <div class="table-container mt-3 shadow-sm">
        <table class="table">
            <thead class="table-dark">
                <tr>
                    <th scope="col"><h6 class="m-0">Bandeira</h6></th>
                    <th scope="col"><h6 class="m-0">Método</h6></th>
                    <th scope="col"><h6 class="m-0">Ação</h6></th>
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
    $(document).ready(function() {
        load();
    });

    function load(){

        let formData = $('#form_filter').serialize();
        
        $.ajax({
            url: `/metodos/{{$estabelecimento->id}}/load?page=${page}&per_page=${per_page}&${formData}`,
            type: 'GET',
            success: function(response) {
                $('#table-content').html(response.tableContent);
                $('.pagination').html(response.pagination);
            },
            error: function(xhr, status, error) {
                toastr.error('Erro ao carregar os metodos!', 'Erro');
            }
        });
    }

    $('#filtro').on('click', function(){
        if($("#card-filter").hasClass('d-none')){
            $("#card-filter").removeClass('d-none')
            $("#card-filter").addClass('d-flex')
        }else{
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
        page = 1;
        load();
    });

    $(document).on('click', '.delete', function(){
        let id = this.id;

        $.ajax({
            url: `${id}`,
            type: 'DELETE',
            data: {
                "_token": "{{ csrf_token() }}",
            },
            success: function(response) {
                toastr.success('Método excluído com sucesso!', 'Sucesso');
                setTimeout(function() {
                     window.location.reload();
                }, 3000);
            },
            error: function(xhr, status, error) {
                toastr.error('Erro ao excluir método!', 'Erro');
            }
        });
    })

</script>
@endsection