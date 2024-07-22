<header class="col-md-12 d-flex flex-column bg-black w-100 px-4 py-3">
    <div class="d-flex flex-row align-items-center justify-content-between">
        <a class="navbar-brand" href="/">
            <img src="/img/logo.png" alt="" style="height: 40px; width: auto;">
        </a>
        <input type="text" class="input-default px-3 py-2 fit-content" style="width: 700px;">
        <div class="d-flex flex-row gap-5 align-items-center">
            @auth
            <a href="#"><i class="bi bi-cart3 text-white h4"></i></a>
            <a class="navbar-brand m-0 d-flex flex-row gap-2 align-items-center" href="#" id="logo">
                <p class="m-0 fs-13 text-white">{{ auth()->user()->consumidor->nome }}</p>
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
        <a class="navbar-brand m-0 d-flex flex-row gap-2 align-items-center" href="#" id="logo">
            <i class="bi bi-cup fc-primary"></i>
            <p class="m-0 fs-14 text-white">Utensílios</p>
            <i class="bi bi-chevron-down fs-13 text-white"></i>
        </a>
        <a class="navbar-brand m-0 d-flex flex-row gap-2 align-items-center" href="#" id="logo">
            <i class="bi bi-backpack2 fc-primary"></i>
            <p class="m-0 fs-14 text-white">Roupas</p>
            <i class="bi bi-chevron-down fs-13 text-white"></i>
        </a>
        <a class="navbar-brand m-0 d-flex flex-row gap-2 align-items-center" href="#" id="logo">
            <i class="bi bi-cpu fc-primary"></i>
            <p class="m-0 fs-14 text-white">Eletrônicos</p>
            <i class="bi bi-chevron-down fs-13 text-white"></i>
        </a>
    </div>
</header>
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
                <a class="nav-link text-white d-flex flex-row align-items-center gap-2 br-8" href="{{route('usuarios.logout')}}">
                    <i class="bi bi-door-open"></i>
                    <p class="m-0 fs-13">Sair</p>
                </a>
            </li>
        </ul>
    </div>
</div>