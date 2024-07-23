@extends('layouts.main')

@section('title', 'Produtos')

@section('content')
@include('includes.header-comerciante')
@include('includes.menu', ['estabelecimento' => $estabelecimento])
    <div class="col-md-10 offset-md-2 px-4 py-5 d-flex flex-column gap-2">
        <h3 class="m-0">Produtos</h3>
        <div class="d-flex flex-row gap-2">
            <p class="fc-primary">Produtos</p>
            <i class="bi bi-chevron-right fc-gray"></i>
            <p class="fc-gray">Lista de produtos</p>
        </div>
        <div class="d-flex flex-row justify-content-between">
            <div class="input-group mb-3" style="width: 50%;">
                <i class="bi bi-search px-3 pr-0 py-2 fs-14 bg-white container-default border-end-0"></i>
                <div class="" style="width: 80%;">
                    <input type="text" class="input-default px-3 py-2 w-100 fs-14 input-search" placeholder="Buscar produto" id="search" value="">
                </div>
            </div>
            <div class="d-flex flex-row gap-3">
                <button class="btn-default py-2 px-3 small d-flex flex-row gap-2 container-default bg-white" id="filtro"><i class="bi bi-filter"></i><p class="m-0">Filtro</p></button>
                <a href="/produtos/{{$estabelecimento->id}}/create" class="btn-default small a-button px-3 py-2 d-flex flex-row gap-1 container-primary"><i class="bi bi-plus-lg"></i><p class="m-0">Cadastrar Produto</p></a>
            </div>
        </div>
        <div class="d-flex flex-row gap-2">
            <select name="" id="per_page" class="bg-white py-1 px-3 border-0 br-8">
                <option value="10">10</option>
                <option value="20">20</option>
                <option value="50">50</option>
            </select>
            <select name="" id="order_page" class="bg-white py-1 px-3 border-0 br-8 fs-14">
                <option value="created_at,ASC">Do mais antigo</option>
                <option value="created_at,DESC">Do mais novo</option>
                <option value="preco,DESC">Do mais caro</option>
                <option value="preco,ASC">Do mais barato</option>
            </select>
        </div>
        <div class="d-none flex-column flex-wrap bg-white p-3 gap-3 border border-2 br-8" id="card-filter">
            <h4 class="m-0">Filtro</h4>
            <form action="form_filter" id="form_filter">
                <div class="d-flex flex-row justify-content-between">
                    <div class="d-flex flex-column">
                        <label class="fs-13" for="nome">Status</label>
                        <select name="filter[status]" class="px-3 py-2 input-default">
                            <option value="1">Ativado</option>
                            <option value="0">Desativado</option>
                            <option value="">Indiferente</option>
                        </select>
                    </div>
                    <div class="d-flex flex-column">
                        <label class="fs-13" for="nome">Preço mínimo</label>
                        <input type="text" name="filter[preco_min]" id="preco-min" class="px-3 py-2 input-default">
                    </div>
                    <div class="d-flex flex-column">
                        <label class="fs-13" for="nome">Preço máximo</label>
                        <input type="text" name="filter[preco_max]" id="preco-max" class="px-3 py-2 input-default">
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
                <button class="btn-default py-2 px-3 small" id="apply-filter" >Aplicar</button>
                <button class="btn-default py-2 px-3 small" id="clear-filter" >Limpar filtro</button>
            </div>
        </div>
        <div class="table-container mt-3 shadow-sm">
            <table class="table">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">Produto</th>
                        <th scope="col">SKU</th>
                        <th scope="col">Seção</th>
                        <th scope="col">Preço</th>
                        <th scope="col">Status</th>
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
    let per_page = 10;

    function formatCurrency(value) {
        let cleanedValue = value.replace(/\D/g, '');

        if (cleanedValue === '') return '';

        let numericValue = parseInt(cleanedValue) / 100;

        let formattedValue = numericValue.toLocaleString('pt-BR', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });

        return formattedValue;
    }

    function applyCurrencyFormatting(inputElement, initialValue = '0') {
        inputElement.value = formatCurrency(initialValue);

        inputElement.addEventListener('input', function(event) {
            let input = event.target;
            input.value = formatCurrency(input.value);
        });
    }

    applyCurrencyFormatting(document.getElementById('preco-min'), '0');
    applyCurrencyFormatting(document.getElementById('preco-max'), '0');

    $(document).ready(function(){
        
        load();

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
            $('#search').val("");
            load();
        });

        $('#clear-filter').on('click', function() {
            resetFilter();
        });

        function resetFilter() {
            $('#form_filter')[0].reset();
            applyCurrencyFormatting(document.getElementById('preco-min'), '0');
            applyCurrencyFormatting(document.getElementById('preco-max'), '0');
            page = 1;
            load();
        }

        $("#search").on('keyup', function() {
            resetFilter();
            load();
        });

        $("#order_page").on('change', function(){
            load();
        })

    });
    function load(){
        let formData = $('#form_filter').serialize();
        let search = $('#search').val();
        let order = $('#order_page').val();

        $.ajax({
            url: `/produtos/{{$estabelecimento->id}}/load?page=${page}&per_page=${per_page}&${formData}&search=${search}&order=${order}`,
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
                toastr.success('Produto desativado com sucesso!', 'Sucesso');
                setTimeout(function() {
                     window.location.reload();
                }, 3000);
            },
            error: function(xhr, status, error) {
                toastr.error('Erro ao desativar produto!', 'Erro');
            }
        });
    })

    $(document).on('click', '.active', function(){
        let id = this.id;

        $.ajax({
            url: `${id}`,
            type: 'PATCH',
            data: {
                "_token": "{{ csrf_token() }}",
            },
            success: function(response) {
                toastr.success('Produto ativado com sucesso!', 'Sucesso');
                setTimeout(function() {
                     window.location.reload();
                }, 3000);
            },
            error: function(xhr, status, error) {
                toastr.error('Erro ao ativar produto!', 'Erro');
            }
        });
    })
</script>
@endsection