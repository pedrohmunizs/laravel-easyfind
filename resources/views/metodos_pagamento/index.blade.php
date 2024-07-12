@extends('layouts.main')

@section('title', 'Métodos do estabelecimento')

@section('content')
@include('includes.header-comerciante')
@include('includes.menu', ['estabelecimento' => $estabelecimento])

@endsection