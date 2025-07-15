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
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('tarifas.contratar') }}" method="POST">
        <div class="row">
            <div class="col-lg-8">
                <div class="row">
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
                    @csrf
                    <!-- Mostra las opciones de fibra -->
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

                    <div id="lineas-moviles">
                        <H2>MOVIL <button type="button" class="añadir-linea btn btn-primary mt-2">Añadir linea movil</button>
                        </H2>
                        @include('tarifas.linea-movil', ['index' => 0])
                    </div>
                    <!-- Botones para añadir o eliminar linea movil-->

                    <!-- Mostra las opciones de TV -->

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

                    <!-- El botón submit solo en el resumen -->
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
                </div>
            </div>
        </div>
    </form>
</div>
<script>
    var urlLineaMovilPartial = "{{ route('linea-movil.partial') }}";
</script>
@endsection