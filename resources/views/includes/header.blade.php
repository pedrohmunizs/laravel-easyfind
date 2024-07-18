<header class="navbar navbar-expand-lg navbar-dark" style="background-color: #222222; width: 100%;">
    <nav class="px-5 py-1 d-flex flex-row justify-content-between w-100 align-items-center">
        <a class="navbar-brand" href="/">
            <img src="/img/logo.png" alt="" style="height: 40px; width: auto;">
        </a>
        <div class="d-flex flex-row gap-3">
            <a href="{{ route('usuarios.create') }}" class="a-button bgc-primary px-3 py-2 fit-content br-8"><p class="m-0 fs-13">Cria sua conta</p></a>
            <a href="{{ route('login') }}" class="a-button bgc-primary px-3 py-2 fit-content br-8"><p class="m-0 fs-13">Entrar</p></a>
        </div>
    </nav>
</header>
