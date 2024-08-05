@extends('layouts.main')

@section('title', 'Carrinho')

@section('content')
@include('includes.header')
<div class="col-md-12 px-5 py-5 d-flex flex-column gap-2">
    <h3 class="m-0">Carrinho</h3>
    <div class="d-flex flex-row gap-2">
        <p class="fc-gray">Seu carrinho</p>
    </div>
    <div class="d-flex flex-column gap-2 mb-2">
        <div class="d-flex flex-column bg-white container-default gap-2 col-md-5 py-2" id="list"></div>
    </div>
</div>
@endsection
@section('script')
<script>
    function carrinhos(){

        $.ajax({
            url: `/carrinhos/load`,
            type: 'GET',
            success: function(response) {
                $('#list').html(response);
            }
        });
    }

    $(document).ready(function(){
        carrinhos();
    })

    function changeQtd(id, action){

        $.ajax({
            url: `/carrinhos/${id}?action=${action}`,
            type: 'PATCH',
            data: {
                _token: "{{ csrf_token() }}",
            },
            success: function(response) {
                carrinhos();
            }
        });
    }

    $(document).on('click', '#add_carrinho', function(){
        let id = this.dataset.value;
        let action = 'add';
        changeQtd(id, action);
    })

    $(document).on('click', '#sub_carrinho', function(){
        let id = this.dataset.value;
        let action = 'sub';
        changeQtd(id, action);
    })
</script>
@endsection