@extends('layouts.main')

@section('title', 'Pesquisar')

@section('content')
@include('includes.header-easyfind')
<div class="d-flex flex-column col-md-12 align-items-center pt-5">
    <div class="d-flex flex-column col-md-11">
        <h3 class="m-0 mb-3">Estabelecimentos</h3>
        <div class="d-flex flex-column gap-3">
            <div class="d-flex flex-row justify-content-between">
                <div class="input-group mb-3" style="width: 50%;">
                    <i class="bi bi-search px-3 pr-0 py-2 fs-14 bg-white container-default border-end-0"></i>
                    <div class="" style="width: 80%;">
                        <input type="text" class="input-default px-3 py-2 w-100 fs-14 input-search" placeholder="Buscar estabelecimento" id="search" value="">
                    </div>
                </div>
                <button class="btn-default py-2 px-3 small d-flex flex-row gap-2 container-default bg-white" id="filtro"><i class="bi bi-filter"></i>
                    <p class="m-0">Filtro</p>
                </button>
            </div>
            <div class="d-flex flex-row-reverse">
                <div class="d-none flex-column flex-wrap bg-white p-4 gap-3 border border-2 br-8 w-fit-content right-0" id="card-filter">
                    <h4 class="m-0">Filtro</h4>
                    <form action="form_filter" id="form_filter">
                        <div class="d-flex flex-row gap-4">
                            <div class="d-flex flex-column">
                                <label class="fs-13" for="nome">Segmento da loja</label>
                                <select name="filter[segmento]" class="px-3 py-2 input-default">
                                    <option value="">Indiferente</option>
                                    @foreach(App\Enums\SegmentoEstabelecimento::cases() as $segmento)
                                        <option value="{{ $segmento->value }}">
                                            {{ $segmento->name }}
                                        </option>
                                    @endforeach
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
                                <label for="customRange1" class="fs-13">Distância</label>
                                <input type="range" class="form-range" min="" max="50" id="customRange1" oninput="updateValue(this.value)">
                                <p><span id="rangeValue">25</span>km</p>
                            </div>
                        </div>
                    </form>
                    <div class="d-flex flex-row-reverse gap-3">
                        <button class="btn-default py-2 px-3 small" id="apply-filter">Aplicar</button>
                        <button class="btn-default py-2 px-3 small" id="clear-filter">Limpar filtro</button>
                        <div class="d-flex flex-row gap-2 align-items-baseline">
                            <input class="form-check-input" name="produto[is_promocao_ativa]" type="checkbox" id="defaultCheck1">
                            <label class="label-default" for="defaultCheck1">Habilitar distância</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex flex-wrap gap-4 mt-3" id="estabelecimentos">
            @component('components.estabelecimentos.card-search', ['estabelecimentos' => $estabelecimentos])
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
        $('#defaultCheck1').prop('checked', false);
        $('#customRange1').removeAttr('name');
        updateValue(25)
        load();
    }
    
    $('#defaultCheck1').on('change', function(){
        if($('#customRange1').attr('name')){
            $('#customRange1').removeAttr('name');
        }else{
            $('#customRange1').attr('name', 'filter[distancia]');
        }
    })

    function load()
    {
        let formData = $('#form_filter').serialize();
        let search = $('#search').val();

        let localizacao = {
            latitude : latitude,
            longitude : longitude
        };

        let localizacaoString = JSON.stringify(localizacao);
        let encodedLocalizacao = encodeURIComponent(localizacaoString);

        $.ajax({
            url: `/estabelecimentos/loadSearch?${formData}&search=${search}&localizacao=${encodedLocalizacao}`,
            type: 'GET',
            success: function(response) {
                $('#estabelecimentos').html(response.estabelecimentos);
            },
            error: function(xhr, status, error) {
                toastr.error('Erro ao carregar estabeleciementos!', 'Erro');
            }
        });
    }

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

    $('#filtro').on('click', function() {
        if ($("#card-filter").hasClass('d-none')) {
            $("#card-filter").removeClass('d-none')
            $("#card-filter").addClass('d-flex')
        } else {
            $("#card-filter").removeClass('d-flex')
            $("#card-filter").addClass('d-none')
        }
    })

    $('#search_produto').on('keydown', function(){
        if (event.key === "Enter" || event.keyCode === 13) {
            let search = $('#search_produto').val();
            window.location.href = `/produtos/pesquisa?origem=home&search=${search}`;
        }
    })
</script>
@endsection