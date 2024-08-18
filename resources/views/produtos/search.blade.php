@extends('layouts.main')

@section('title', 'Pesquisar')

@section('content')
@include('includes.header-easyfind')
<div class="d-flex flex-column col-md-12 align-items-center pt-5">
    <div class="d-flex flex-column col-md-11">
        <div class="d-flex flex-column gap-3">
            <div class="d-flex flex-row-reverse">
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
                                <label class="fs-13" for="nome">Tags</label>
                                <select name="filter[tag]" class="px-3 py-2 input-default">
                                    <option value="">Indiferente</option>
                                    @foreach($tags as $tag)
                                        <option value="{{ $tag->id }}">{{ $tag->descricao }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="d-flex flex-column">
                                <label class="fs-13" for="nome">Segmento da loja</label>
                                <select name="filter[segmento]" class="px-3 py-2 input-default">
                                    <option value="">Indiferente</option>
                                    <option value="Eletrônicos">Eletrônicos</option>
                                    <option value="Informática">Informática</option>
                                    <option value="Mercado">Mercado</option>
                                    <option value="Produtos naturais">Produtos naturais</option>
                                    <option value="Artigos esportivos">Artigos esportivos</option>
                                    <option value="Vestuário">Vestuário</option>
                                    <option value="Decoração">Decoração</option>
                                    <option value="Livraria">Livraria</option>
                                </select>
                            </div>
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
                            <div class="d-flex flex-column">
                                <label for="customRange1" class="fs-13">Example range</label>
                                <input type="range" class="form-range" name="filter[distancia]" min="" max="50" id="customRange1" oninput="updateValue(this.value)">
                                <p><span id="rangeValue">25</span>km</p>
                            </div>
                        </div>
                    </form>
                    <div class="d-flex flex-row-reverse gap-3">
                        <button class="btn-default py-2 px-3 small" id="apply-filter">Aplicar</button>
                        <button class="btn-default py-2 px-3 small" id="clear-filter">Limpar filtro</button>
                    </div>
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

    let latitude = null;
    let longitude = null;

    function updateValue(val) {
        document.getElementById('rangeValue').textContent = val;
    }

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
        resetFilter();
    });

    function resetFilter() {
        $('#form_filter')[0].reset();
        applyCurrencyFormatting(document.getElementById('preco-min'), '0');
        applyCurrencyFormatting(document.getElementById('preco-max'), '0');
        $('#customRange1').removeAttr('name');
        load();
    }

    function load()
    {
        let formData = $('#form_filter').serialize();
        let search = $('#search_produto').val();

        let localizacao = {
            latitude : latitude,
            longitude : longitude
        };

        let localizacaoString = JSON.stringify(localizacao);
        let encodedLocalizacao = encodeURIComponent(localizacaoString);

        $.ajax({
            url: `/produtos/loadSearch?${formData}&search=${search}&localizacao=${encodedLocalizacao}`,
            type: 'GET',
            success: function(response) {
                $('#produtos').html(response.produtos);
                $('#customRange1').attr('name', 'filter[distancia]');
            },
            error: function(xhr, status, error) {
                toastr.error('Erro ao carregar produtos!', 'Erro');
            }
        });
    }

    $('#search_produto').on('keydown', function(){
        if (event.key === "Enter" || event.keyCode === 13) {
            load();
        }
    })

    $(document).ready(function(){
        getLocation()
    })

    function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition, showError);
        } else {
            toastr.error('Geolocalização não é suportada por este navegador!', 'Erro');
        }
    }

    function showPosition(position) {
        latitude = position.coords.latitude;
        longitude = position.coords.longitude;        
    }

    function showError(error) {
        switch(error.code) {
            case error.PERMISSION_DENIED:
                toastr.error('Usuário negou a solicitação de Geolocalização!', 'Erro');
                break;
            case error.POSITION_UNAVAILABLE:
                toastr.error('Informação de localização não está disponível!', 'Erro');
                break;
            case error.TIMEOUT:
                toastr.error('A solicitação para obter a localização do usuário expirou!', 'Erro');
                break;
            case error.UNKNOWN_ERROR:
                toastr.error('Ocorreu um erro desconhecido!', 'Erro');
                break;
        }
    }

</script>
@endsection