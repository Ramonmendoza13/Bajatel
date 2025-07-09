@extends('plantilla')

@section('title', 'Bajatel - Crear Tarifa')

@section('content')
<h1 class="mb-4 text-primary">Crear Tarifa</h1>
<div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">
        <form action="{{ route('tarifas.crear') }}" method="post" class="card shadow p-4 bg-light">
            @csrf

            <div class="mb-3">
                <label for="tipo" class="form-label">Tipo de tarifa</label>
                <select id="tipo" name="tipo" class="form-select">
                    <option value="fibra">Fibra</option>
                    <option value="llamadas">Minutos</option>
                    <option value="gb">GB</option>
                    <option value="tv">TV</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción</label>
                <textarea id="descripcion" name="descripcion" class="form-control" rows="2" required></textarea>
            </div>

            <div class="mb-3 fibra">
                <label for="velocidad" class="form-label">Velocidad</label>
                <input type="number" id="velocidad" name="velocidad" class="form-control">
            </div>

            <div class="mb-3 minutos">
                <label for="minutos" class="form-label">Minutos</label>
                <input type="number" id="minutos" name="minutos" class="form-control" >
            </div>

            <div class="mb-3 gb">
                <label for="gigas" class="form-label">Gigas</label>
                <input type="number" id="gigas" name="gigas" class="form-control" >
            </div>

            <div class="mb-3">
                <label for="precio" class="form-label">Precio</label>
                <input type="number" id="precio" name="precio" class="form-control" required>
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="fas fa-plus me-2"></i>Crear Tarifa
                </button>
            </div>
        </form>
    </div>
</div>
@endsection