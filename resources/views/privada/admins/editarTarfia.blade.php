@extends('plantilla')

@section('title', 'Bajatel - Editar Tarifa')

@section('content')

<h1 class="mb-4 text-primary">Editar Tarifa {{ $tarifa->id }} ({{ $tarifa->tipo }})</h1>
<form action="{{ route('tarifas.editar', $tarifa->id) }}" method="post">
    @csrf
    @method('PUT')
    @if($tarifa->tipo == 'fibra')
        <div class="mb-3">
            <label for="velocidad" class="form-label">Velocidad (Mbps)</label>
            <input type="number" id="velocidad" name="velocidad" class="form-control" value="{{ $tarifa->velocidad }}">
        </div>
    @elseif($tarifa->tipo == 'gb')
        <div class="mb-3">
            <label for="gigas" class="form-label">Gigas</label>
            <input type="number" id="gigas" name="gigas" class="form-control" value="{{ $tarifa->gb }}">
        </div>
    @elseif($tarifa->tipo == 'llamadas')
        <div class="mb-3">
            <label for="minutos" class="form-label">Minutos(Numero negativo para minutos ilimitados)</label>
            <input type="number" id="minutos" name="minutos" class="form-control" value="{{ $tarifa->minutos }}">
        </div>
    @endif
    <div class="mb-3">
        <label for="descripcion" class="form-label">Descripción</label>
        <textarea id="descripcion" name="descripcion" class="form-control" rows="3">{{ $tarifa->descripcion }}</textarea>
    </div>
    <div class="mb-3">
        <label for="precio" class="form-label">Precio (€)</label>
        <input type="number" id="precio" name="precio" class="form-control" value="{{ $tarifa->precio }}">
    </div>
    <div class="d-grid">
        <button type="submit" class="btn btn-primary btn-lg">
            <i class="fas fa-save me-2"></i>Guardar cambios
        </button>
    </div>
</form>
@endsection