@extends('layouts.main')

@section('content')
<div class="col-md-12 d-flex flex-column justify-content-center align-items-center" style="height: 100vh;">
    <div class="d-flex flex-column align-items-center gap-3">
        <img src="/img/404.png" alt="" style="height: 500px; width: fit-content">
        <button onclick="window.history.back()" class="btn-default btn-large">Voltar</button>
    </div>
</div>

@endsection