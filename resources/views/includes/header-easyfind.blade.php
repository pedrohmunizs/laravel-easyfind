<header class="col-md-12 d-flex flex-column bg-black w-100 px-5 py-2">
    <div class="d-flex flex-row align-items-center justify-content-between">
        <a class="navbar-brand" href="/">
            <img src="/img/logo.png" alt="" style="height: 40px; width: auto;">
        </a>
        <div class="input-group" style="width: 700px;">
            <div class="d-flex flex-row w-100">
                <i class="bi bi-search px-3 pr-0 py-2 fs-14 bg-white container-default border-end-0" style="border-top-right-radius: 0px; border-bottom-right-radius: 0px;"></i>
                <div class="" style="width: 100%;">
                    <input type="text" class="input-default px-3 py-2 w-100 fs-14 input-search" placeholder="Buscar produto" id="search_produto">
                </div>
            </div>
        </div>
        <div class="d-flex flex-row gap-5 align-items-center">
            @auth
                <a href="/carrinhos"><i class="bi bi-cart3 text-white h5"></i></a>
                <a class="navbar-brand m-0 d-flex flex-row gap-2 align-items-center" href="#" id="logo">
                    <p class="m-0 fs-13 text-white">{{ auth()->user()->nome }}</p>
                    <i class="bi bi-chevron-down fs-13 text-white"></i>
                </a>
            @endauth
            @guest
                <a href="{{ route('usuarios.create') }}" class="a-button bgc-primary px-3 py-2 fit-content br-8">
                    <p class="m-0 fs-13">Cria sua conta</p>
                </a>
                <a href="{{ route('login') }}" class="a-button bgc-primary px-3 py-2 fit-content br-8">
                    <p class="m-0 fs-13">Entrar</p>
                </a>
            @endguest
        </div>
    </div>
    <div class="col-md-12 d-flex flex-row justify-content-center gap-5">
        <div class="d-flex flex-column col-md-2">
            <a class="navbar-brand m-0 d-flex flex-row gap-2 align-items-center px-3" href="#" id="utensilios">
                <i class="bi bi-cup fc-primary"></i>
                <p class="m-0 fs-14 text-white">Utensílios</p>
                <i class="bi bi-chevron-down fs-13 text-white"></i>
            </a>
            <div class="dropdown-menu bg-black" id="menuUtensilios" style="margin-top: 35px;">
                <ul class="list-group list-group-flush nav">
                    <li class="nav-item">
                        <a class="nav-link text-white br-8 tag" href="#" id="104">
                            <p class="m-0 fs-13">Talheres</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white br-8 tag" href="#" id="105">
                            <p class="m-0 fs-13">Copos</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white br-8 tag" href="#" id="106">
                            <p class="m-0 fs-13">Panelas</p>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="d-flex flex-column col-md-2">
            <a class="navbar-brand m-0 d-flex flex-row gap-2 align-items-center px-3" href="#" id="roupas">
                <i class="bi bi-backpack2 fc-primary"></i>
                <p class="m-0 fs-14 text-white">Roupas</p>
                <i class="bi bi-chevron-down fs-13 text-white"></i>
            </a>
            <div class="dropdown-menu bg-black" id="menuRoupas" style="margin-top: 35px;">
                <ul class="list-group list-group-flush nav">
                    <li class="nav-item">
                        <a class="nav-link text-white br-8 tag" href="#" id="103">
                            <p class="m-0 fs-13">Camisas</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white br-8 tag" href="#" id="102">
                            <p class="m-0 fs-13">Tênis</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white br-8 tag" href="#" id="102">
                            <p class="m-0 fs-13">Meias</p>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="d-flex flex-column col-md-2">
            <a class="navbar-brand m-0 d-flex flex-row gap-2 align-items-center px-3" href="#" id="eletronicos">
                <i class="bi bi-cpu fc-primary"></i>
                <p class="m-0 fs-14 text-white">Eletrônicos</p>
                <i class="bi bi-chevron-down fs-13 text-white"></i>
            </a>
            <div class="dropdown-menu bg-black" id="menuEletronicos" style="margin-top: 35px;">
                <ul class="list-group list-group-flush nav">
                    <li class="nav-item">
                        <a class="nav-link text-white br-8 tag" href="#" id="107">
                            <p class="m-0 fs-13">Carregadores</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white br-8 tag" href="#" id="108">
                            <p class="m-0 fs-13">Fones</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white br-8 tag" href="#" id="96">
                            <p class="m-0 fs-13">Smartphones</p>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</header>
@auth
    <div class="card card-options bg-black" id="optionsCard">
        <div class="p-2">
            <ul class="list-group list-group-flush nav">
                <a href=""></a>
                <li class="nav-item">
                    <a class="nav-link text-white d-flex flex-row align-items-center gap-2 br-8" href="{{ route('consumidores.edit', [ 'id' => auth()->user()->id ]) }}">
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
@endauth