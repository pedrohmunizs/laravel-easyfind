@extends('layouts.main')
@section('title', 'Cadastro')

@section('content')

    <form action="{{ route('comerciante.login1') }}" method="POST">
        @csrf
        <input type="text" name="email">
        <input type="password" name="password">
        <button type="submit">Login</button>
    </form>
@endsectio