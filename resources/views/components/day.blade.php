@props(['day', 'data' => null])

<div class="row align-items-center justify-content-between">
    <div class="col-md-3">
        <p class="mb-0">{{ $day }}</p>
    </div>
    <div class="col-md-2">
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" role="switch" id="day-{{ $day }}" onchange="toggleTimeInputs('{{ $day }}')" name="agenda[{{ $day }}][status]" {{ $data ? 'checked' : '' }}>
            <label class="form-check-label" for="day-{{ $day }}" id="label-{{ $day }}">{{ $data ? 'Aberto' : 'Fechado' }}</label>
        </div>
    </div>
    <div class="col-md-4">
        <div class="d-flex align-items-baseline gap-2">
            <input type="hidden" value="{{ $day }}" name="agenda[{{ $day }}][dia]" class="{{ $day }}">
            <input type="time" class="form-control {{ $day }}" value="{{ $data['horario_inicio'] ?? '00:00' }}" name="agenda[{{ $day }}][horario_inicio]" {{ $data ? '' : 'disabled' }} />
            <p class="mb-0">ATÉ</p>
            <input type="time" class="form-control {{ $day }}" value="{{ $data['horario_fim'] ?? '00:00' }}" name="agenda[{{ $day }}][horario_fim]" {{ $data ? '' : 'disabled' }} />
        </div>
    </div>
</div>
<hr>
