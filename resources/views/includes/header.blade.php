<header class="col-md-12 d-flex flex-column bg-black w-100">
    <nav class="px-5 py-2 d-flex flex-row justify-content-between w-100 align-items-center">
        <a class="navbar-brand" href="/">
                @if(auth()->user()->consumidor)
                    <img src="/img/logo.png" alt="" style="height: 40px; width: auto;">
                @else
                    <img src="" alt="" style="height: 40px; width: auto;">
                @endif
            </a>
        <div class="d-flex flex-row gap-5 align-items-center">
            @auth
                @if(auth()->user()->consumidor)
                    <a href="/carrinhos"><i class="bi bi-cart3 text-white h5"></i></a>
                @endif
                <a class="navbar-brand m-0 d-flex flex-row gap-2 align-items-center" href="#" id="logo">
                    <p class="m-0 fs-13 text-white">{{ auth()->user()->nome }}</p>
                    <i class="bi bi-chevron-down fs-13 text-white"></i>
                </a>
            @endauth
            @guest
                <a href="{{ route('usuarios.create') }}" class="a-button bgc-primary px-3 py-2 fit-content br-8"><p class="m-0 fs-13">Cria sua conta</p></a>
                <a href="{{ route('login') }}" class="a-button bgc-primary px-3 py-2 fit-content br-8"><p class="m-0 fs-13">Entrar</p></a>
            @endguest
        </div>
    </nav>
</header>
@if(auth()->user()->consumidor)
    <div class="card card-options bg-black" id="optionsCard">
        <div class="p-2">
            <ul class="list-group list-group-flush nav">
                <a href=""></a>
                <li class="nav-item">
                    <a class="nav-link text-white d-flex flex-row align-items-center gap-2 br-8" href="#">
                        <i class="bi bi-file-earmark-text"></i>
                        <p class="m-0 fs-13">Dados cadastrais</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white d-flex flex-row align-items-center gap-2 br-8" href="{{ route('pedidos.index') }}">
                        <i class="bi bi-file-earmark-text"></i>
                        <p class="m-0 fs-13">Pedidos</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white d-flex flex-row align-items-center gap-2 br-8" href="{{route('usuarios.logout')}}">
                        <i class="bi bi-door-open"></i>
                        <p class="m-0 fs-13">Sair</p>
                    </a>
                </li>
            </ul>
        </div>
    </div>
@else
    <div class="card card-options bg-black" id="optionsCard">
        <div class="p-2">
            <ul class="list-group list-group-flush nav">
                <a href=""></a>
                <li class="nav-item">
                    <a class="nav-link text-white d-flex flex-row align-items-center gap-2 br-8" href="#">
                        <i class="bi bi-file-earmark-text"></i>
                        <p class="m-0 fs-13">Dados cadastrais</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white d-flex flex-row align-items-center gap-2 br-8" href="/estabelecimentos">
                        <i class="bi bi-shop"></i>
                        <p class="m-0 fs-13">Lojas</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white d-flex flex-row align-items-center gap-2 br-8" href="{{route('usuarios.logout')}}">
                        <i class="bi bi-door-open"></i>
                        <p class="m-0 fs-13">Sair</p>
                    </a>
                </li>
            </ul>
        </div>
    </div>
@endif