@extends('plantilla')

@section('title', 'Bajatel - Contratar Tarifa')

@section('content')

<div class="container py-4">
    <h2 class="mb-4 text-primary">Personaliza tu tarifa</h2>

    @php //Obtener las tarifas ordenadas por precio de menor a mayor
    $tarifasFibra = $tarifas->where('tipo', 'fibra')->sortBy('precio');
    $tarifasGb = $tarifas->where('tipo', 'gb')->sortBy('precio');
    $tarifasLlamadas = $tarifas->where('tipo', 'llamadas')->sortBy('precio');
    $tarifasTv = $tarifas->where('tipo', 'tv')->sortBy('precio');
    @endphp
    <form id="form-contratar-tarifa" action="{{ route('tarifas.contratar') }}" method="post" class="mb-4">
        @csrf
        <div id="errores-tarifa" style="display:none;" class="alert alert-danger"></div>
        <div class="row">
            <div class="col-lg-8">
                <!-- Apartado de dirección -->
                <div class="mb-3">
                    <div class="card border-info mb-3 shadow-sm">
                        <div class="card-header bg-info text-white">Dirección de instalación</div>
                        <div class="card-body">
                            <div class="row g-2">
                                <div class="col-md-6">
                                    <label for="ciudad" class="form-label">Ciudad</label>
                                    <input type="text" class="form-control" id="ciudad" name="ciudad" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="cp" class="form-label">Código Postal</label>
                                    <input type="text" class="form-control" id="cp" name="cp" required>
                                </div>
                                <div class="col-md-8">
                                    <label for="calle" class="form-label">Calle</label>
                                    <input type="text" class="form-control" id="calle" name="calle" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="numero" class="form-label">Número</label>
                                    <input type="text" class="form-control" id="numero" name="numero" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="card border-primary mb-3 shadow-sm">
                        <div class="card-header bg-primary text-white">Tarifas de Fibra</div>
                        <div class="card-body">
                            @if($tarifasFibra->count() > 0)
                            <div class="row">
                                @foreach($tarifasFibra as $tarifa)
                                <div class="col-md-6">
                                    <div class="tarifa-opcion" data-tipo="fibra">
                                        <div class="form-check mb-0">
                                            <input type="radio" name="tarifa_fibra"
                                                value="{{ $tarifa->id }}"
                                                data-id="{{ $tarifa->id }}"
                                                data-velocidad="{{ $tarifa->velocidad }}"
                                                data-descripcion="{{ $tarifa->descripcion }}"
                                                data-precio="{{ $tarifa->precio }}"
                                                data-tipo="{{ $tarifa->tipo }}" id="fibra_{{ $tarifa->id }}" required>
                                            <label for="fibra_{{ $tarifa->id }}">
                                                {{ $tarifa->velocidad }}Mbs - {{ $tarifa->descripcion }} - <span class="precio">{{ $tarifa->precio }} €/mes</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                <div class="col-md-6">
                                    <div class="tarifa-opcion" data-tipo="fibra">
                                        <div class="form-check mb-0">
                                            <input type="radio" name="tarifa_fibra" value="0" data-tipo="sin_fibra" id="fibra_sin" required>
                                            <label for="fibra_sin">Sin fibra</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="card border-success mb-3 shadow-sm">
                        <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                            <span>Líneas Móviles</span>
                            <button type="button" id="anadirLinea" class="btn btn-outline-light btn-sm">
                                <i class="bi bi-plus-circle"></i> Añadir línea
                            </button>
                        </div>
                        <div class="card-body bg-light" id="moviles-container"></div>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="card border-warning mb-3 shadow-sm">
                        <div class="card-header bg-warning text-dark">Tarifas de Televisión</div>
                        <div class="card-body">
                            @if($tarifasTv->count() > 0)
                            <div class="row">
                                @foreach($tarifasTv as $tarifa)
                                <div class="col-md-6">
                                    <div class="tarifa-opcion" data-tipo="tv">
                                        <div class="form-check mb-0">
                                            <input type="radio" name="tarifa_tv"
                                                value="{{ $tarifa->id }}"
                                                data-id="{{ $tarifa->id }}"
                                                data-descripcion="{{ $tarifa->descripcion }}"
                                                data-precio="{{ $tarifa->precio }}"
                                                data-tipo="{{ $tarifa->tipo }}" id="tv_{{ $tarifa->id }}" required>
                                            <label for="tv_{{ $tarifa->id }}">
                                                {{ $tarifa->descripcion }} - <span class="precio">{{ $tarifa->precio }} €/mes</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                <div class="col-md-6">
                                    <div class="tarifa-opcion" data-tipo="tv">
                                        <div class="form-check mb-0">
                                            <input type="radio" name="tarifa_tv" value="0" data-tipo="sin_tv" id="tv_sin" required>
                                            <label for="tv_sin">Sin TV</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="p-3 border rounded bg-light">
                    <h5 class="text-secondary">Resumen de la Tarifa</h5>
                    <ul class="list-group mb-3">
                        <li class="list-group-item" id="resumen-fibra"></li>
                        <li class="list-group-item" id="resumen-moviles"></li>
                        <li class="list-group-item" id="resumen-tv"></li>
                    </ul>
                    <div class="alert alert-primary text-center" id="precio-total">
                        Precio Total: <span id="total-precio"></span> €/mes
                    </div>
                    <button type="submit" class="btn btn-success btn-lg w-100 mt-2">Contratar Tarifa</button>
                    <input type="hidden" name="json_tarifa" id="json_tarifa">
                </div>
            </div>
        </div>
    </form>

    <!-- Plantilla oculta para clonar líneas móviles -->
    <div id="plantilla-linea-movil" style="display:none;">
        <div class="card border-success mb-2 shadow-sm linea-movil">
            <div class="card-body bg-light">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="fw-bold">Línea móvil <span class="num-linea"></span></span>
                    <button type="button" class="btn btn-sm btn-danger eliminar-linea"><i class="bi bi-trash"></i></button>
                </div>
                <!-- Apartado de portabilidad o número nuevo -->
                <div class="mb-2">
                    <label class="form-label">¿Quieres conservar tu número?</label>
                    <div class="form-check form-check-inline">
                        <input type="radio" name="conservar_numero_linea_plantilla" class="form-check-input conservar-numero" id="conservar_si_plantilla" value="si">
                        <label class="form-check-label" for="conservar_si_plantilla">Sí</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="radio" name="conservar_numero_linea_plantilla" class="form-check-input conservar-numero" id="conservar_no_plantilla" value="no" checked>
                        <label class="form-check-label" for="conservar_no_plantilla">No, generar número nuevo</label>
                    </div>
                    <div class="mt-2" id="campo-numero-antiguo-plantilla" style="display:none;">
                        <label for="numero_antiguo_plantilla" class="form-label">Número antiguo</label>
                        <input type="text" class="form-control" name="numero_antiguo_linea_plantilla" id="numero_antiguo_plantilla" placeholder="Introduce tu número actual">
                    </div>
                </div>
                @if($tarifasGb->count() > 0)
                <div class="mb-2">
                    <span class="fw-semibold">Datos:</span>
                    @foreach($tarifasGb as $tarifa)
                    <div class="tarifa-opcion d-inline-block me-2 mb-2" data-tipo="gb">
                        <div class="form-check mb-0">
                            <input type="radio" name="tarifa_gb_plantilla"
                                value="{{ $tarifa->id }}"
                                data-id="{{ $tarifa->id }}"
                                data-gb="{{ $tarifa->gb }}"
                                data-descripcion="{{ $tarifa->descripcion }}"
                                data-precio="{{ $tarifa->precio }}"
                                data-tipo="{{ $tarifa->tipo }}" id="gb_plantilla_{{ $tarifa->id }}">
                            <label for="gb_plantilla_{{ $tarifa->id }}">
                                {{ $tarifa->gb }} GB - {{ $tarifa->descripcion }} - <span class="precio">{{ $tarifa->precio }} €/mes</span>
                            </label>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
                @if($tarifasLlamadas->count() > 0)
                <div class="mb-2">
                    <span class="fw-semibold">Llamadas:</span>
                    @foreach($tarifasLlamadas as $tarifa)
                    <div class="tarifa-opcion d-inline-block me-2 mb-2" data-tipo="llamadas">
                        <div class="form-check mb-0">
                            <input type="radio" name="tarifa_llamadas_plantilla"
                                value="{{ $tarifa->id }}"
                                data-id="{{ $tarifa->id }}"
                                data-minutos="{{ $tarifa->minutos }}"
                                data-descripcion="{{ $tarifa->descripcion }}"
                                data-precio="{{ $tarifa->precio }}"
                                data-tipo="{{ $tarifa->tipo }}" id="llamadas_plantilla_{{ $tarifa->id }}">
                            <label for="llamadas_plantilla_{{ $tarifa->id }}">
                                @if ($tarifa->minutos < 0)
                                    Minutos Ilimitados - {{ $tarifa->descripcion }} - <span class="precio">{{ $tarifa->precio }} €/mes</span>
                                    @else
                                    {{ $tarifa->minutos }} Minutos {{ $tarifa->descripcion }} - <span class="precio">{{ $tarifa->precio }} €/mes</span>
                                    @endif
                            </label>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection