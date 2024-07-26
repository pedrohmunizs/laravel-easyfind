@extends('layouts.main')

@section('title', 'EasyFind')

@section('content')
@include('includes.header-easyfind')
<div class="d-flex flex-column px-5 py-5 gap-5">
    <div class="d-flex flex-column gap-5">
        <div class="d-flex flex-row align-items-center justify-content-center gap-2">
            <h6 class="m-0">Encontre o que você está procurando</h6>
            <a href="/produtos/pesquisa" class="a-default fc-blue">Ver mais produtos</a>
        </div>
        <div class="d-flex flex-row justify-content-between">
            @component('components.produtos.card', ['produtos' => $produtos])
            @endcomponent
        </div>
    </div>

    <div class="d-flex flex-column gap-5">
        <div class="d-flex flex-row align-items-center justify-content-center gap-2">
            <h6 class="m-0">Conheça novas lojas</h6>
            <a href="#" class="a-default fc-blue">Ver mais lojas</a>
        </div>
        <div class="d-flex flex-row justify-content-between">
            @foreach($estabelecimentos as $estabelecimento)
                @component('components.estabelecimentos.card-home', ['estabelecimento' => $estabelecimento])
                @endcomponent
            @endforeach
        </div>
    </div>

    <div class="d-flex flex-column gap-5">
        <div class="d-flex flex-row align-items-center justify-content-center gap-2">
            <h6 class="m-0">Explore as principais categorias</h6>
        </div>
        <div class="d-flex flex-row justify-content-between">
            <div style="background-image: url('/img/institucional/categoria-1.png'); width: 414px; height: 342px;" class="d-flex flex-column justify-content-center align-items-center px-5 gap-2">
                <div class="d-flex flex-column gap-2 align-items-center">
                    <h6 class="text-light">Utensilíos do Lar</h6>
                    <p class="text-light m-0 text-center fs-14">Simplifique sua vida diária com nossa seleção de utensílios domésticos essenciais.</p>
                </div>
                <a href="#" class="a-default bgc-primary text-dark px-5 py-2 w-fit-content br-8" id="decoracao">Explorar</a>
            </div>
            <div style="background-image: url('/img/institucional/categoria-2.png'); width: 414px; height: 342px;" class="d-flex flex-column justify-content-center align-items-center px-5 gap-2">
                <div class="d-flex flex-column gap-2 align-items-center">
                    <h6 class="text-light">Roupas</h6>
                    <p class="text-light m-0 text-center fs-14">Explore uma ampla gama de roupas, de itens essenciais do dia a dia.</p>
                </div>
                <a href="#" class="a-default bgc-primary text-dark px-5 py-2 w-fit-content br-8" id="vestuario">Explorar</a>
            </div>
            <div style="background-image: url('/img/institucional/categoria-3.png'); width: 414px; height: 342px;" class="d-flex flex-column justify-content-center align-items-center px-5 gap-2">
                <div class="d-flex flex-column gap-2 align-items-center">
                    <h6 class="text-light">Eletrônicos</h6>
                    <p class="text-light m-0 text-center fs-14">Explore nossa variedade de eletrônicos para atender às suas necessidades digitais.</p>
                </div>
                <a href="#" class="a-default bgc-primary text-dark px-5 py-2 w-fit-content br-8" id="eletronico">Explorar</a>
            </div>
        </div>
    </div>

    <div class="d-flex flex-column gap-5">
        <div class="d-flex flex-row align-items-center justify-content-center gap-2">
            <h6 class="m-0">Ofertas do dia</h6>
            <a href="#" class="a-default fc-blue" id="ofertas">Ver mais produtos em ofertas</a>
        </div>
        <div id="myCarousel" class="carousel slide" data-bs-ride="carousel">
            <ol class="carousel-indicators">
                @foreach($ofertas->chunk(2) as $chunk)
                <li data-bs-target="#myCarousel" data-bs-slide-to="{{ $loop->index }}" class="{{ $loop->first ? 'active' : '' }}"></li>
                @endforeach
            </ol>
            <div class="carousel-inner">
                @foreach($ofertas->chunk(2) as $chunk)
                <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                    <div class="d-flex">
                        @foreach($chunk as $oferta)
                        <div class="w-50 p-3">
                            @component('components.produtos.sale', ['oferta' => $oferta])
                            @endcomponent
                        </div>
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>
            <a class="carousel-control-prev" href="#myCarousel" role="button" data-bs-slide="prev" style="justify-content:start;">
                <i class="bi bi-chevron-left bgc-primary p-3 rounded-circle h6"></i>
            </a>
            <a class="carousel-control-next" href="#myCarousel" role="button" data-bs-slide="next" style="justify-content:end;">
                <i class="bi bi-chevron-right bgc-primary p-3 rounded-circle h6"></i>
            </a>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    $('#search_produto').on('keydown', function(){
        if (event.key === "Enter" || event.keyCode === 13) {
            let search = $('#search_produto').val();
            window.location.href = `/produtos/pesquisa?origem=home&search=${search}`;
        }
    })

    $('#ofertas').on('click', function(){
        let filter = {
            'promocao' : true
        }
        let filterString = JSON.stringify(filter);
        let encodedFilter = encodeURIComponent(filterString);

        window.location.href = `/produtos/pesquisa?origem=home&filter=${encodedFilter}`;
    })

    $('#decoracao').on('click', function(){

        let filter = {
            'segmento' : 'Decoração'
        }
        let filterString = JSON.stringify(filter);
        let encodedFilter = encodeURIComponent(filterString);

        window.location.href = `/produtos/pesquisa?origem=home&filter=${encodedFilter}`;
    })

    $('#vestuario').on('click', function(){

        let filter = {
            'segmento' : 'Vestuário'
        }
        let filterString = JSON.stringify(filter);
        let encodedFilter = encodeURIComponent(filterString);

        window.location.href = `/produtos/pesquisa?origem=home&filter=${encodedFilter}`;
    })

    $('#eletronico').on('click', function(){

        let filter = {
            'segmento' : 'Eletrônicos'
        }
        let filterString = JSON.stringify(filter);
        let encodedFilter = encodeURIComponent(filterString);

        window.location.href = `/produtos/pesquisa?origem=home&filter=${encodedFilter}`;
    })
</script>
@endsection
