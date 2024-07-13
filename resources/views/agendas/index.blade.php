@extends('layouts.main')

@section('title', 'Agenda')

@section('content')
@include('includes.header-comerciante')
@include('includes.menu', ['estabelecimento' => $estabelecimento])
    <div class="col-md-10 offset-md-2 px-4 py-5 d-flex flex-column gap-2">
        <h3 class="m-0">Agenda</h3>
        <div class="d-flex flex-row">
            <p class="fc-primary">Agenda</p>
        </div>
        <div class="d-flex flex-column bg-white p-4 shadow-sm br-8">
            <h4 class="mb-4">Horário de atendimento</h4>
            <form id="form_agenda" action="/agendas" method="POST">
                @csrf
                @php
                    $days = ['Domingo', 'Segunda-feira', 'Terça-feira', 'Quarta-feira', 'Quinta-feira', 'Sexta-feira', 'Sábado'];
                @endphp

                @foreach($days as $day)
                    @php
                        $currentDayData = $agendas->firstWhere('dia', $day);
                    @endphp

                    <x-day :day="$day" :data="$currentDayData ? ['horario_inicio' => $currentDayData->horario_inicio, 'horario_fim' => $currentDayData->horario_fim] : null" />
                @endforeach
                <div class="col-md-12 d-flex flex-row-reverse bg-white">
                    <button type="submit" class="btn-default py-2 px-3 small d-flex flex-row gap-2" ><i class="bi bi-floppy"></i><p class="m-0">Salvar</p></button>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('script')
<script>
    function toggleTimeInputs(day) {
        const checkbox = document.getElementById('day-' + day);
        const timeInputs = document.querySelectorAll('.' + day);
        const label = document.getElementById('label-' + day);

        timeInputs.forEach(input => {
            input.disabled = !checkbox.checked;
        });

        if (checkbox.checked) {
            label.textContent = 'Aberto';
        } else {
            label.textContent = 'Fechado';
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const days = ['Domingo', 'Segunda-feira', 'Terça-feira', 'Quarta-feira', 'Quinta-feira', 'Sexta-feira', 'Sábado'];

        days.forEach(day => {
            toggleTimeInputs(day);
        });
    });

    $('#form_agenda').on('submit', function(e) {
        e.preventDefault();
        let formData = new FormData(this);

        $.ajax({
            url: '{{$estabelecimento->id}}',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                toastr.success('Agenda atualizada com sucesso!', 'Sucesso');
                setTimeout(function() {
                    window.location.reload();
                }, 3000);
            },
            error: function(xhr, status, error) {
                toastr.error('Erro ao atualizar agenda!', 'Erro');
            }
        });
    });
</script>
@endsection