<nav class="col-md-2 sidebar vh-100 position-fixed px-3 py-1">
    <ul class="nav flex-column">
        <li class="nav-item mb-4">
            <div class="d-flex flex-row align-items-center gap-3">
                <img src="/img/estabelecimentos/{{ $estabelecimento->imagem->nome_referencia }}" class="rounded-circle" alt="" style="height: 43px;">
                <p class="m-0 fs-13">{{$estabelecimento->nome}}</p>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link text-white d-flex flex-row align-items-center gap-2 br-8 d-flex flex-row justify-between" href="#submenu1" data-bs-toggle="collapse" aria-expanded="false">
                <div class="d-flex flex-row align-items-center gap-2 w-100">
                    <i class="bi bi-bag"></i>
                    <p class="m-0 fs-13">Produto</p>
                </div>
                <i class="bi bi-chevron-down fs-13"></i>
            </a>
            <div class="collapse" id="submenu1">
                <ul class="nav flex-column ms-3">
                    <li class="nav-item">
                        <a class="nav-link text-white br-8" href="{{ route('produtos.index', ['idEstabelecimento' => $estabelecimento->id]) }}">
                            <p class="m-0 fs-13">Lista de produtos</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white br-8" href="{{ route('secoes.index', ['idEstabelecimento' => $estabelecimento->id]) }}">
                            <p class="m-0 fs-13">Seções</p>
                        </a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link text-white d-flex flex-row align-items-center gap-2 br-8" href="#">
                <i class="bi bi-cart3"></i>
                <p class="m-0 fs-13">Pedidos</p>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-white d-flex flex-row align-items-center gap-2 br-8" href="#">
                <i class="bi bi-people"></i>
                <p class="m-0 fs-13">Histórico de vendas</p>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-white d-flex flex-row align-items-center gap-2 br-8" href="#">
                <i class="bi bi-clock-history"></i>
                <p class="m-0 fs-13">Horário de atendimento</p>
            </a>
        </li>
    </ul>
</nav>
