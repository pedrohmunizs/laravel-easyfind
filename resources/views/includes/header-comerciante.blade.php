<header class="navbar navbar-expand-lg navbar-dark fixed-top d-flex flex-row-reverse" style="background-color: #222222; width: 100%;">
    <nav class="px-5 py-1">
        <a class="navbar-brand m-0 d-flex flex-rown gap-2 align-items-center" href="#" id="logo">
            <p class="m-0 fs-13 fc-primary">{{auth()->user()->comerciante->nome}}</p>
            <i class="bi bi-chevron-down fs-13"></i>
        </a>
    </nav>
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
                <a class="nav-link text-white d-flex flex-row align-items-center gap-2 br-8" href="#">
                    <i class="bi bi-shop"></i>
                    <p class="m-0 fs-13">Lojas</p>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white d-flex flex-row align-items-center gap-2 br-8" href="#">
                    <i class="bi bi-door-open"></i>
                    <p class="m-0 fs-13">Sair</p>
                </a>
            </li>
        </ul>
    </div>
</div>
