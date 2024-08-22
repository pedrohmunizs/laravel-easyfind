<aside class="d-flex flex-column vh-100 gradiente py-0 px-3">
    <div class="d-flex flex-row align-items-center mt-3 gap-2">
        @php
            $imagens = $estabelecimento->imagem;
        @endphp
        @if(isset($imagens))
            <div class="bg-light rounded-circle">
                <img src="/img/estabelecimentos/{{$estabelecimento->imagem->nome_referencia}}" style="height: 72px; width: 72px;" class="rounded-circle">
            </div>
        @else
            <img src="/img/default.jpg" class="rounded-circle" style="height: 72px; width: 72px;">
        @endif
        <h6 class="m-0">{{ $estabelecimento->nome }}</h6>
    </div>
    <div class="d-flex flex-column mt-3">
        <h6 class="m-0 fs-14">{{count($produtos)}} produtos</h6>
    </div>
    <ul class="nav flex-column mt-3 gap-2">
        <li class="nav-item">
            <h6 class="m-0 py-2">Categorias</h6>
            <li class="d-flex flex-column">
                <div class="nav-item">
                    <a class="a-default py-1 d-flex flex-row align-items-center gap-2 br-8 d-flex flex-row justify-between secao" href="#" id="">
                        <h6 class="m-0 fs-13 fc-gray">Todos produtos</h6>
                    </a>
                </div>
                @foreach($estabelecimento->secoes as $secao)
                    <div class="nav-item">
                        <a class="a-default py-1 d-flex flex-row align-items-center gap-2 br-8 d-flex flex-row justify-between secao" href="#" id="{{ $secao->id }}">
                            <h6 class="m-0 fs-13 fc-gray">{{ $secao->descricao }}</h6>
                        </a>
                    </div>
                @endforeach
            </li>
        </li>
        <li class="nav-item">
            <a class="a-default py-2 d-flex flex-row align-items-center gap-2 br-8 d-flex flex-row justify-between fc-black" href="#submenu1" data-bs-toggle="collapse" aria-expanded="false">
                <div class="d-flex flex-row align-items-center gap-2 w-100">
                    <i class="bi bi-clock fc-black"></i>
                    <h6 class="m-0 fc-black fs-13">Horário de funcionamento</h6>
                </div>
                <i class="bi bi-chevron-down fc-black fs-13"></i>
            </a>
            <div class="collapse py-2 ms-3" id="submenu1">
                <ul class="nav flex-column ms-3">
                    @foreach($estabelecimento->agendas as $dia)
                        <div class="d-flex flex-row justify-content-between">
                            <h6 class="fs-10 m-0 fc-gray">{{ $dia->dia }}</h6>
                            @php
                                $abre = \Carbon\Carbon::createFromFormat('H:i:s', $dia->horario_inicio)->format('H:i');
                                $fecha = \Carbon\Carbon::createFromFormat('H:i:s', $dia->horario_fim)->format('H:i');
                            @endphp
                            <h6 class="fs-10 fc-gray">{{$abre}}-{{$fecha}}</h6>
                        </div>
                    @endforeach
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="a-default py-2 d-flex flex-row align-items-center gap-2 br-8 d-flex flex-row justify-between fc-black" href="#submenu2" data-bs-toggle="collapse" aria-expanded="false">
                <div class="d-flex flex-row align-items-center gap-2 w-100">
                    <i class="bi bi-credit-card fc-black"></i>
                    <h6 class="m-0 fc-black fs-13">Métodos aceitos</h6>
                </div>
                <i class="bi bi-chevron-down fc-black fs-13"></i>
            </a>
            <div class="collapse py-2 ms-3" id="submenu2">
                <ul class="nav flex-column ms-3">
                    @php
                        $metodosAceito = $estabelecimento->metodosPagamentosAceito;
                    @endphp
                    <div class="d-flex flex-column gap-2">
                        @foreach($metodos as $metodo)
                            <div class="d-flex flex-column">
                                <h6 class="fs-10 m-0 fc-gray" for="nome">{{$metodo->descricao}}</h6>
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
                </ul>
            </div>
        </li>
        @if(array_filter($avaliacoes->toArray()))
            <li class="nav-item">
                <h6 class="m-0 py-2 mb-2">Notas dos clientes</h6>
                @php

                    $notas = range(1, 5);
                    $frequencies = array_count_values($avaliacoes->toArray());
                    $total = count($avaliacoes);
        
                    $percentages = [];
        
                    foreach ($notas as $nota) {
                        $count = $frequencies[$nota] ?? 0;
                        $percentages[$nota] = ($count / $total) * 100;
                    }
        
                    $media = array_sum($avaliacoes->toArray())/$total;
                @endphp
                <li class="nav-item d-flex flex-column gap-2">
                    <div class="d-flex flex-row align-items-center gap-2">
                        <div class="d-flex flex-row gap-1">
                            <p class="m-0">{{number_format($media, 1, ',', '.')}}</p>
                            <i style="color: gold;" class="bi bi-star-fill"></i>
                        </div>
                        <h6 class="m-0 fs-14">{{$vendas}} vendas</h6>
                    </div>
                    @foreach ($percentages as $value => $percentage)
                        <div class="progress d-flex flex-row" style="height: .75rem;">
                            <div class="progress-bar" role="progressbar" style="width: {{$percentage}}%" aria-valuemin="0" aria-valuemax="100"></div>
                            <p class="fs-10">{{$value}}</p>
                        </div>
                    @endforeach
                </li>
            </li>
        @endif
    </ul>
</aside>
