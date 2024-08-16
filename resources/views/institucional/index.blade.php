@extends('layouts.main')

@section('title', 'Home')

@section('content')
@include('includes.header')
<div class="col-md-12 px-7 py-5 d-flex flex-column gap-4">
    <div class="d-flex flex-row gap-5">
        <img src="/img/institucional/home-1.png" alt="" style="height:500px">
        <div class="d-flex flex-column gap-4 justify-content-center">
            <h6>Aquilo que você precisa perto de você</h6>
            <p class="col-md-8">
                Nosso propósito é conectar comerciantes e consumidores, simplificando a busca por produtos e fortalecendo o mercado local  impulsionando o empreendedorismo
            </p>
            <button class="btn-default px-4 py-1" id="scrollButton">Saiba mais</button>
        </div>
    </div>
    <div class="d-flex flex-row" id="saiba">
        <div class="d-flex flex-column">
            <img src="/img/institucional/home-2.png" alt="" style="height:450px; width:450px">
            <p class="col-md-7">
                Nós da Easy Find, acreditamos que cada compra é uma oportunidade de apoiar negócios locais e construir uma comunidade mais forte. Nossa plataforma não apenas conecta comerciantes e consumidores, mas também cria um ecossistema onde todos prosperam.
            </p>
        </div>
        <div class="d-flex flex-column">
            <p class="col-md-9">
                Nós mostramos o que você precisa. Temos um compromisso com a sua experiencia de compra
            </p>
            <img src="/img/institucional/home-3.png" alt="" style="height:500px">
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    $('#scrollButton').click(function() {
            $('html, body').animate({
                scrollTop: $('#saiba').offset().top
            }, 800);
        });
</script>
@endsection