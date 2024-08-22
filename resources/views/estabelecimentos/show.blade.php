@extends('layouts.main')

@section('title', 'Pesquisar')

@section('content')
@include('includes.header-easyfind')
    <div class="d-flex flex-row col-md-12">
        <div class="col-md-2">
            @include('includes.sidebar')
        </div>
        <div class="col-md-10 p-5">
            <h5>Produtos</h5>
            <div class="d-flex flex-row justify-content-between">
                <div class="input-group mb-3" style="width: 50%;">
                    <i class="bi bi-search px-3 pr-0 py-2 fs-14 bg-white container-default border-end-0"></i>
                    <div class="" style="width: 80%;">
                        <input type="text" class="input-default px-3 py-2 w-100 fs-14 input-search" placeholder="Buscar produto" id="search" value="">
                    </div>
                </div>
                <button class="btn-default py-2 px-3 small d-flex flex-row gap-2 container-default bg-white" id="filtro"><i class="bi bi-filter"></i>
                    <p class="m-0">Filtro</p>
                </button>
            </div>
            <div class="d-flex flex-row-reverse">
                <div class="d-none flex-column flex-wrap bg-white p-3 gap-3 border border-2 br-8 w-fit-content right-0" id="card-filter">
                    <h4 class="m-0">Filtro</h4>
                    <form action="form_filter" id="form_filter">
                        <div class="d-flex flex-row gap-3">
                            <div class="d-flex flex-column">
                                <label class="fs-13" for="nome">Categoria</label>
                                <select name="filter[secao]" class="px-3 py-2 input-default">
                                    <option value="">Indiferente</option>
                                    @foreach($estabelecimento->secoes as $secao)
                                        <option value="{{ $secao->id }}">{{ $secao->descricao }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="d-flex flex-column">
                                <label class="fs-13" for="nome">Promoção</label>
                                <select name="filter[promocao]" class="px-3 py-2 input-default">
                                    <option value="">Indiferente</option>
                                    <option value="1">Ativada</option>
                                    <option value="0">Desativada</option>
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
                        </div>
                    </form>
                    <div class="d-flex flex-row-reverse gap-3">
                        <button class="btn-default py-2 px-3 small" id="apply-filter">Aplicar</button>
                        <button class="btn-default py-2 px-3 small" id="clear-filter">Limpar filtro</button>
                    </div>
                </div>
            </div>
            <div class="d-flex flex-wrap gap-4 mt-3" id="produtos">
                @component('components.produtos.card', ['produtos' => $produtos])
                @endcomponent
            </div>
        </div>
    </div>
@endsection

@section('script')
<script>

    $('#filtro').on('click', function() {
        if ($("#card-filter").hasClass('d-none')) {
            $("#card-filter").removeClass('d-none')
            $("#card-filter").addClass('d-flex')
        } else {
            $("#card-filter").removeClass('d-flex')
            $("#card-filter").addClass('d-none')
        }
    })

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

    $('#apply-filter').on('click', function() {
        load();
    });

    $('#clear-filter').on('click', function() {
        resetFilter();
    });

    $("#search").on('keyup', function() {
        resetFilter();
        load();
    });

    function resetFilter() {
        $('#form_filter')[0].reset();
        applyCurrencyFormatting(document.getElementById('preco-min'), '0');
        applyCurrencyFormatting(document.getElementById('preco-max'), '0');
        load();
    }

    function load(filter = null)
    {
        if(!filter){
            filter = $('#form_filter').serialize();
        }

        let search = $('#search').val();
        let estabelecimento = "{{ $estabelecimento->id }}"

        $.ajax({
            url: `/produtos/loadSearch?${filter}&estabelecimento=${estabelecimento}&search=${search}`,
            type: 'GET',
            success: function(response) {
                $('#produtos').html(response.produtos);
            },
            error: function(xhr, status, error) {
                toastr.error('Erro ao carregar produtos!', 'Erro');
            }
        });
    }

    $('#search_produto').on('keydown', function(){
        if (event.key === "Enter" || event.keyCode === 13) {
            let search = $('#search_produto').val();
            window.location.href = `/produtos/pesquisa?origem=home&search=${search}`;
        }
    })

    $('#search').on('keyup', function(){
            load();
    })

    $('.secao').on('click', function(){

        let filter = {
            secao: this.id,
        };

        let param = $.param({ filter: filter });

        load(param);
    })
</script>
@endsection