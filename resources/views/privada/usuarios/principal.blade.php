@extends('plantilla')

@section('title', 'Bajatel - Zona Privada')

@section('content')
@auth
<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <h1 class="mb-4">
                <i class="fas fa-user-circle text-primary me-2"></i>
                Bienvenido <span class="fw-bold">{{ $nombre }}</span>
                <a href="{{ route('logout') }}" class="btn btn-outline-danger">
                    <i class="fas fa-sign-out-alt me-2"></i>
                    Cerrar sesión
                </a>
            </h1>

            <div class="card shadow mb-4">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">
                        <i class="fas fa-file-code me-2"></i>
                        Mis Tarifas
                    </h3>
                </div>
                <div class="card-body">
                    @if($tarifa_usuario)
                    @php
                    $tarifa = is_string($tarifa_usuario) ? json_decode($tarifa_usuario, true) : $tarifa_usuario;
                    @endphp
                    <!-- Información de Dirección -->
                    @if(isset($tarifa['direccion']))
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card bg-light border-0 mb-3">
                                <div class="card-body">
                                    <h5 class="text-primary mb-3">
                                        <i class="fas fa-map-marker-alt me-2"></i>
                                        Dirección de Instalación
                                    </h5>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <strong>Calle:</strong> {{ $tarifa['direccion']['calle'] }}, {{ $tarifa['direccion']['numero'] }}
                                        </div>
                                        <div class="col-md-4">
                                            <strong>Ciudad:</strong> {{ $tarifa['direccion']['ciudad'] }}
                                        </div>
                                        <div class="col-md-4">
                                            <strong>Código Postal:</strong> {{ $tarifa['direccion']['cp'] }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="row g-4">
                        <!-- Fibra -->
                        @if(isset($tarifa['fibra']))
                        <div class="col-md-6 col-lg-4">
                            <div class="card h-100 border-primary shadow-sm">
                                <div class="card-header bg-primary text-white text-center">
                                    <i class="fas fa-wifi fa-2x mb-2"></i>
                                    <h5 class="mb-0">Fibra Óptica</h5>
                                </div>
                                <div class="card-body text-center">
                                    <div class="mb-2">
                                        <span class="display-6 fw-bold text-primary">{{ $tarifa['fibra']['velocidad'] }} Mbps</span>
                                    </div>
                                    <div class="mb-2">
                                        <span class="fs-4 fw-bold text-success">{{ number_format($tarifa['fibra']['precio'], 2) }}€</span>
                                        <span class="text-muted">/mes</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- Móvil -->
                        @if(isset($tarifa['movil']))
                        <div class="col-md-6 col-lg-4">
                            <div class="card h-100 border-success shadow-sm">
                                <div class="card-header bg-success text-white text-center">
                                    <i class="fas fa-mobile-alt fa-2x mb-2"></i>
                                    <h5 class="mb-0">Líneas Móviles</h5>
                                </div>
                                <div class="card-body">
                                    @if(isset($tarifa['movil']['lineas']))
                                    <div class="table-responsive">
                                        <table class="table table-sm align-middle mb-0">
                                            <thead>
                                                <tr>
                                                    <th>Teléfono</th>
                                                    <th>Datos</th>
                                                    <th>Llamadas</th>
                                                    <th>Precio</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($tarifa['movil']['lineas'] as $linea)
                                                <tr>
                                                    <td><i class="fas fa-phone-alt text-primary me-1"></i>{{ $linea['telefono'] }}</td>
                                                    <td><span class="badge bg-info">{{ $linea['gb'] }} GB</span></td>
                                                    <td>
                                                        @if(isset($linea['llamadas']))
                                                        <span class="badge bg-secondary">
                                                            @if($linea['llamadas']['minutos'] == -1)
                                                            Ilimitadas
                                                            @else
                                                            {{ $linea['llamadas']['minutos'] }} min
                                                            @endif
                                                            ({{ $linea['llamadas']['precio'] }}€)
                                                        </span>
                                                        @else
                                                        <span class="text-muted">-</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ number_format($linea['precio'], 2) }}€</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    @else
                                    <div class="mb-2">
                                        <i class="fas fa-phone-alt text-primary me-1"></i>{{ $tarifa['movil']['telefono'] }}
                                    </div>
                                    <div class="mb-2">
                                        <span class="badge bg-info">{{ $tarifa['movil']['gb'] }} GB</span>
                                    </div>
                                    <div class="mb-2">
                                        <span class="fs-5 fw-bold text-success">{{ number_format($tarifa['movil']['precio'], 2) }}€</span>
                                        <span class="text-muted">/mes</span>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- TV -->
                        @if(isset($tarifa['tv']))
                        <div class="col-md-6 col-lg-4">
                            <div class="card h-100 border-warning shadow-sm">
                                <div class="card-header bg-warning text-dark text-center">
                                    <i class="fas fa-tv fa-2x mb-2"></i>
                                    <h5 class="mb-0">Televisión</h5>
                                </div>
                                <div class="card-body text-center">
                                    <div class="mb-2">
                                        <span class="fw-bold">{{ ucfirst($tarifa['tv']['tipo']) }}</span>
                                    </div>
                                    <div class="mb-2">
                                        <span class="fs-4 fw-bold text-success">{{ number_format($tarifa['tv']['precio'], 2) }}€</span>
                                        <span class="text-muted">/mes</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>

                    <!-- Precio Total -->
                    @if(isset($tarifa['precio_total']))
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="alert alert-success text-center display-6 fw-bold py-4 mb-0">
                                <i class="fas fa-euro-sign me-2"></i>
                                Precio Total: {{ number_format($tarifa['precio_total'], 2) }} €/mes
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Información adicional -->
                    @if(isset($tarifa['fecha_contratacion']))
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="alert alert-info">
                                <i class="fas fa-calendar-alt me-2"></i>
                                <strong>Fecha de contratación:</strong> {{ \Carbon\Carbon::parse($tarifa['fecha_contratacion'])->format('d/m/Y') }}
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="d-flex gap-2 justify-content-end mt-3">
                        <button class="btn btn-outline-primary">
                            <i class="fas fa-edit me-1"></i>Editar
                        </button>
                        <button class="btn btn-outline-secondary">
                            <i class="fas fa-times me-1"></i>Cancelar
                        </button>
                    </div>

                    @else
                    <div class="text-center py-5">
                        <i class="fas fa-exclamation-triangle text-warning fa-3x mb-3"></i>
                        <h4 class="text-muted">No tienes tarifas contratadas</h4>
                        <p class="text-muted">Contacta con nosotros para contratar nuestros servicios</p>
                        <a href="{{ url('/contacto') }}" class="btn btn-primary">
                            <i class="fas fa-phone me-2"></i>
                            Contactar
                        </a>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Mostrar JSON tarifa -->
            @if(isset($tarifa_usuario) && is_string($tarifa_usuario))
            <div class="card shadow">
                <div class="card-header bg-secondary text-white">
                    <h3 class="mb-0">
                        <i class="fas fa-code me-2"></i>
                        JSON de la Tarifa
                    </h3>
                </div>
                <div class="card-body">
                    <pre class="bg-light p-3 border rounded" style="font-size:1rem;">{{ json_encode(json_decode($tarifa_usuario, true), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                </div>



            </div>            @endif
        </div>
    </div>
    @endauth
    @endsection