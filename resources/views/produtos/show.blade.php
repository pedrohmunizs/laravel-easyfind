@extends('layouts.main')

@section('title', 'EasyFind')

@section('content')
@include('includes.header-easyfind')
<div class="d-flex flex-column align-items-center col-md-12 gap-5 py-5">
    <div class="d-flex flex-column col-md-9 bg-white container-default">
        <div class="d-flex flex-row">
            <div class="d-flex flex-column col-md-6 py-4 px-5">
                <div class="w-fit-content">
                    @if($produto->imagens)
                        @php
                            $imagens = json_decode($produto->imagens, true);
                        @endphp
                        @if(!empty($imagens))
                            <img id="mainImage" src="/img/produtos/{{ $imagens[0]['nome_referencia'] }}" class="img-fluid main-img" style="height: 350px; width: 350px;">
                        @else
                            <img id="mainImage" src="/img/default.jpg" class="container-default img-fluid main-img" style="height: 350px; width: 350px;">
                        @endif
                    @endif
                </div>
                <div>
                    <div class="d-flex flex-row w-fit-content">
                        @if(count($imagens) > 0)
                            @foreach($imagens as $imagem)
                                <img src="/img/produtos/{{ $imagem['nome_referencia'] }}" alt="Thumbnail 1" class="img-thumbnail thumbnail-img" onclick="changeMainImage(this)">
                            @endforeach
                        @else
                            <img src="/img/default.jpg" alt="Thumbnail 1" class="img-thumbnail thumbnail-img" onclick="changeMainImage(this)">
                        @endif
                    </div>
                </div>
                <div class="d-flex flex-column mt-3">
                    <h6>Descrição</h6>
                    <p>{{$produto->descricao}}</p>
                </div>
            </div>
            <div class="d-flex flex-column mt-5 gap-5">
                <div class="d-flex flex-column gap-2">
                    @if($avaliacoes)
                        @php
                            $existe = json_decode($avaliacoes, true);
                        @endphp
                        @if(!empty($existe))
                            @php
                                $notas = array_column($avaliacoes->toArray(), 'qtd_estrela');
                                $media = array_sum($notas)/count($avaliacoes);
                                $estrelasCheias = floor($media);
                                $meiaEstrela = $media - $estrelasCheias >= 0.5 ? 1 : 0;
                                $estrelasVazias = 5 - $estrelasCheias - $meiaEstrela;
                            @endphp
                            <div class="d-flex flex-column">
                                <h4 class="m-0">{{$produto->nome}}</h4>
                                <div class="d-flex flex-row gap-2">
                                    <p>{{number_format($media, 1, ',', '.')}}</p>
                                    <p style="color: gold;">
                                        @for ($i = 0; $i < $estrelasCheias; $i++)
                                            <i class="bi bi-star-fill"></i>
                                        @endfor
                                        
                                        @if ($meiaEstrela)
                                            <i class="bi bi-star-half"></i>
                                        @endif
                                        
                                        @for ($i = 0; $i < $estrelasVazias; $i++)
                                            <i class="bi bi-star"></i>
                                        @endfor
                                    </p>
                                </div>
                            </div>
                        @endif
                    @endif
                    @if($produto->is_promocao_ativa)
                        <div class="d-flex flex-column">
                            <p class="text-decoration-line-through m-0 text-secondary"><small>R$ {{ number_format($produto->preco, 2, ',', '.') }}</small></p>
                            <h4>R$ {{number_format($produto->preco_oferta, 2, ',', '.')}}</h4>
                        </div>
                    @else
                        <h4>R$ {{number_format($produto->preco, 2, ',', '.')}}</h4>
                    @endif
                    <div class="d-flex flex-row align-items-center">
                        <p class="m-0">Quantidade</p>
                        <p class="p-2 m-0" id="quantidade">1</p>
                        <div class="d-flex flex-row gap-1">
                            <button class="btn-default px-1 br-8" id="sub_qtd"><i class="bi bi-dash-lg"></i></button>
                            <button class="btn-default px-1 br-8" id="add_qtd"><i class="bi bi-plus-lg"></i></button>
                        </div>
                    </div>
                    <div class="d-flex flex-column gap-2">
                        <a href="#" class="a-button btn-default w-100 py-2 d-flex justify-content-center" id="comprarBtn">Comprar</a>
                        <button class="btn-default btn-large" id="add_carrinho">Adicionar ao carrinho</button>
                    </div>
                </div>
                <div class="d-flex flex-column gap-2">
                    <div class="d-flex flex-row align-items-center gap-3">
                        @php
                            $imagens = $produto->secao->estabelecimento->imagem;
                        @endphp
                        @if(isset($imagens))
                            <img src="/img/estabelecimentos/{{$produto->secao->estabelecimento->imagem->nome_referencia}}" style="height: 100px; width: 100px;" class="rounded-circle">
                        @else
                            <img src="/img/default.jpg" class="rounded-circle" style="height: 100px; width: 100px;">
                        @endif
                        <h6 class="m-0">{{$produto->secao->estabelecimento->nome}}</h6>
                    </div>
                    <div class="d-flex flex-column">
                        @if($avaliacoesEstabelecimento)
                            
                            @if(!empty($avaliacoesEstabelecimento))
                                @php
                                    $notas = array_column($avaliacoesEstabelecimento, 'qtd_estrela');
                                    $media = array_sum($notas)/count($avaliacoesEstabelecimento);
                                @endphp
                                <div class="d-flex flex-row gap-1">
                                    <p class="m-0">{{number_format($media, 1, ',', '.')}}</p>
                                    <i style="color: gold;" class="bi bi-star-fill"></i>
                                </div>
                            @endif
                        @endif
                        <div class="d-flex flex-row gap-2">
                            <p>Vendas: {{$totalVendidosEstabelecimento}}</p>
                            <p>Total produtos: {{$totalProdutos}}</p>
                        </div>
                        <div>
                            <a href="/estabelecimentos/{{ $produto->secao->estabelecimento->id }}/show" class="a-default fc-blue">Ver produtos do estabelecimento</a>
                        </div>
                    </div>
                    <div class="d-flex flex-column">
                        <button class="btn-clean w-fit-content d-flex flex-row gap-2 align-items-center mb-3" id="metodos">
                            <h6 class="m-0">Métodos de pagamento</h6>
                            <i class="bi bi-chevron-down"></i>
                        </button>
                        <div class="d-none flex-column gap-3" id="bandeiras">
                            @php
                                $metodosAceito = $produto->secao->estabelecimento->metodosPagamentosAceito;
                            @endphp
                            @foreach($metodos as $metodo)
                                <div class="d-flex flex-column">
                                    <label class="label-default" for="nome">{{$metodo->descricao}}</label>
                                    <div class="d-flex flex-row gap-3">
                                        @foreach($metodosAceito as $aceito)
                                            @if($metodo->id == $aceito->bandeiraMetodo->metodoPagamento->id)
                                                <div>
                                                    <img src="/img/bandeiras/{{$aceito->bandeiraMetodo->bandeiraPagamento->imagem}}" style="width: 30px;">
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr class="mx-5">
        <div class="d-flex flex-column px-5 py-3">
            <div class="d-flex flex-column align-items-end gap-4">
                <div class="d-flex flex-row justify-content-between col-md-12">
                    <div class="d-flex flex-column">
                        <label class="label-default" for="nome">Adicione uma nota</label>
                        <div id="starRating" class="star-rating">
                            <span data-value="1">&#9733;</span>
                            <span data-value="2">&#9733;</span>
                            <span data-value="3">&#9733;</span>
                            <span data-value="4">&#9733;</span>
                            <span data-value="5">&#9733;</span>
                        </div>
                    </div>
                    <div class="d-flex flex-column col-md-6">
                        <label class="label-default" for="nome">Adicione um comentário</label>
                        <textarea name="" id="comentario" class="px-3 py-2 input-default w-100" maxlength="255"></textarea>
                    </div>
                </div>
                @auth
                    <button class="btn-default px-3 py-2" id="publish">Publicar</button>
                @endauth
                @guest
                    <button class="btn-default px-3 py-2" id="publish" disabled>Publicar</button>
                @endguest
            </div>
            <div class="col-md-12 d-flex flex-row">
                <div class="col-md-6 d-flex flex-column gap-4">
                    @foreach($avaliacoes as $avaliacao)
                        <div class="d-flex flex-column">
                            @php
                                $estrelas = $avaliacao->qtd_estrela;
                                $estrelasCheias = floor($estrelas);
                                $estrelasVazias = 5 - $estrelasCheias;
                            @endphp
                            <div class="d-flex flex-column">
                                <p class="m-0" style="color: gold;">
                                    @for ($i = 0; $i < $estrelasCheias; $i++)
                                        <i class="bi bi-star-fill"></i>
                                    @endfor

                                    @for ($i = 0; $i < $estrelasVazias; $i++)
                                        <i class="bi bi-star"></i>
                                    @endfor
                                </p>
                                <p><small>{{$avaliacao->consumidor->nome}}</small></p>
                            </div>
                            <p>{{$avaliacao->comentario}}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    let qtd = 1;

    document.addEventListener('DOMContentLoaded', (event) => {
        const stars = document.querySelectorAll('#starRating span');
        
        stars.forEach(star => {
            star.addEventListener('mouseover', function() {
                resetStars();
                fillStars(this.dataset.value);
            });

            star.addEventListener('mouseout', resetStars);

            star.addEventListener('click', function() {
                const rating = this.dataset.value;
                document.getElementById('starRating').dataset.rating = rating;
            });
        });

        function resetStars() {
            const rating = document.getElementById('starRating').dataset.rating;
            stars.forEach(star => {
                star.classList.remove('filled');
                if (star.dataset.value <= rating) {
                    star.classList.add('filled');
                }
            });
        }

        function fillStars(rating) {
            stars.forEach(star => {
                if (star.dataset.value <= rating) {
                    star.classList.add('filled');
                }
            });
        }
    });

    function changeMainImage(imgElement) {
        const mainImage = document.getElementById('mainImage');
        mainImage.src = imgElement.src;
    }

    document.getElementById('publish').addEventListener('click', function(){
        let comentario = document.getElementById('comentario').value;
        let nota = document.getElementById('starRating').dataset.rating;

        let avaliacao = {
            qtd_estrela : nota,
            comentario : comentario,
            fk_produto : "{{$produto -> id}}"
        };

        $.ajax({
            url: '/avaliacoes',
            type: 'POST',
            data: {
                avaliacao : avaliacao,
                _token: "{{ csrf_token() }}",
            },
            success: function(response) {
                toastr.success(response.message, 'Sucesso');
            },
            error: function(xhr, status, error) {
                if(xhr.status == 409){
                    toastr.error(xhr.responseJSON.message);
                }else if(xhr.status == 400){
                    toastr.error(xhr.responseJSON.message);                        
                }else{
                    toastr.error('Erro ao publicar avaliação!', 'Erro');
                }
            }
        });
    })

    document.getElementById('metodos').addEventListener('click', function() {

        var content = document.getElementById('bandeiras');
        if (content.classList.contains('d-none')) {
            content.classList.remove('d-none');
            content.classList.add('d-flex');
        } else {
            content.classList.add('d-none');
            content.classList.remove('d-flex');
        }
    });

    document.getElementById('add_qtd').addEventListener('click', function(){
        document.getElementById('quantidade').textContent = ++qtd
        updateComprarLink();
    });

    document.getElementById('sub_qtd').addEventListener('click', function(){
        if(qtd>1){
            document.getElementById('quantidade').textContent = --qtd
            updateComprarLink();
        }
    });

    document.getElementById('add_carrinho').addEventListener('click', function(){
        let carrinho = {
            'quantidade' : document.getElementById('quantidade').textContent, 
            'fk_produto' : "{{$produto->id}}"
        }

        $.ajax({
            url: '/carrinhos',
            type: 'POST',
            data: {
                carrinho : carrinho,
                _token: "{{ csrf_token() }}",
            },
            success: function(response) {
                toastr.success('Produto adicionado ao carrinho!', 'Sucesso');
            },
            error: function(xhr, status, error) {
                if(xhr.status == 409){
                    toastr.error(xhr.responseJSON.message);
                }else if(xhr.status == 400){
                    toastr.error(xhr.responseJSON.message);
                }else{
                    toastr.error('Erro ao adicionar produto ao carrinho!', 'Erro');
                }
            }
        });
    })

    $(document).ready(function(){
        updateComprarLink()
    })

    function updateComprarLink(){
        let idProduto = "{{$produto->id}}";
        let quantidade = document.getElementById('quantidade').textContent;
        document.getElementById('comprarBtn').href = `/pedidos/create?idProduto=${idProduto}&quantidade=${quantidade}`;
    }

    $('#search_produto').on('keydown', function(){
        if (event.key === "Enter" || event.keyCode === 13) {
            let search = $('#search_produto').val();
            window.location.href = `/produtos/pesquisa?origem=home&search=${search}`;
        }
    })

</script>
@endsection