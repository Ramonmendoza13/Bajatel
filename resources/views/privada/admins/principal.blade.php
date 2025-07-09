@extends('plantilla')

@section('title', 'Bajatel - Panel de Administración')

@section('content')

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
    </div>
@endif

@auth

<!-- Header con información del admin -->
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="display-6 fw-bold text-primary mb-2">
                        <i class="fas fa-user-shield me-2"></i>
                        Panel de Administración
                    </h1>
                    <p class="text-muted mb-0">Bienvenido, {{ $nombre }} (Administrador)</p>
                </div>
                <a href="{{ route('logout') }}" class="btn btn-outline-danger">
                    <i class="fas fa-sign-out-alt me-2"></i>
                    Cerrar sesión
                </a>
            </div>
        </div>
    </div>

    <!-- Sección de Tarifas -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="mb-0">
                            <i class="fas fa-tags me-2"></i>
                            Gestión de Tarifas
                        </h3>
                        <a class="btn btn-light" href="{{ route('tarifas.crear') }}">
                            <i class="fas fa-plus me-2"></i>
                            Añadir Tarifa
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="border-0">ID</th>
                                    <th class="border-0">Tipo</th>
                                    <th class="border-0">Descripción</th>
                                    <th class="border-0">Velocidad</th>
                                    <th class="border-0">Minutos</th>
                                    <th class="border-0">GB</th>
                                    <th class="border-0">Precio</th>
                                    <th class="border-0">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tarifas as $tarifa)
                                <tr>
                                    <td><span class="badge bg-secondary">{{ $tarifa->id }}</span></td>
                                    <td>
                                        <span class="badge bg-primary">
                                            <i class="fas fa-{{ $tarifa->tipo == 'fibra' ? 'wifi' : ($tarifa->tipo == 'gb' ? 'mobile-alt' : ($tarifa->tipo == 'llamadas' ? 'phone' : 'tv')) }} me-1"></i>
                                            {{ ucfirst($tarifa->tipo) }}
                                        </span>
                                    </td>
                                    <td>{{ $tarifa->descripcion }}</td>
                                    <td>
                                        @if($tarifa->velocidad)
                                        <span class="text-success fw-bold">{{ $tarifa->velocidad }} Mbps</span>
                                        @else
                                        <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($tarifa->minutos)
                                        @if($tarifa->minutos == -1)
                                        <span class="badge bg-success">Ilimitadas</span>
                                        @else
                                        <span class="text-info">{{ $tarifa->minutos }} min</span>
                                        @endif
                                        @else
                                        <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($tarifa->gb)
                                        <span class="badge bg-info">{{ $tarifa->gb }} GB</span>
                                        @else
                                        <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="fw-bold text-success">{{ number_format($tarifa->precio, 2) }}€</span>
                                    </td>
                                    <td>
                                        <a href="{{ route('tarifas.editar', $tarifa->id) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-edit me-1"></i>
                                            Editar
                                        </button>
                                        <a href="{{ route('tarifas.eliminar', $tarifa->id) }}" 
                                           class="btn btn-sm btn-outline-danger"
                                           >
                                            <i class="fas fa-trash me-1"></i>
                                            Eliminar
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sección de Usuarios -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-success text-white">
                    <h3 class="mb-0">
                        <i class="fas fa-users me-2"></i>
                        Gestión de Usuarios
                    </h3>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="border-0">ID</th>
                                    <th class="border-0">Nombre</th>
                                    <th class="border-0">DNI</th>
                                    <th class="border-0">Email</th>
                                    <th class="border-0">Servicios Contratados</th>
                                    <th class="border-0">Fecha Contratación</th>
                                    <th class="border-0">Precio Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($usuarios as $usuario)
                                <tr>
                                    <td><span class="badge bg-secondary">{{ $usuario->id }}</span></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2">
                                                <i class="fas fa-user"></i>
                                            </div>
                                            <span class="fw-semibold">{{ $usuario->name }}</span>
                                        </div>
                                    </td>
                                    <td><code>{{ $usuario->dni }}</code></td>
                                    <td>
                                        <a href="mailto:{{ $usuario->email }}" class="text-decoration-none">
                                            <i class="fas fa-envelope me-1 text-muted"></i>
                                            {{ $usuario->email }}
                                        </a>
                                    </td>
                                    <td>
                                        @if($usuario->tarifa)
                                        @php
                                        $tarifa_usuario = is_string($usuario->tarifa) ? json_decode($usuario->tarifa, true) : $usuario->tarifa;
                                        @endphp

                                        <!-- Información de Dirección -->
                                        @if(isset($tarifa_usuario['direccion']['calle']))
                                        <div class="mb-2">
                                            <small class="text-muted">
                                                <i class="fas fa-map-marker-alt me-1"></i>
                                                {{ $tarifa_usuario['direccion']['calle'] }}, {{ $tarifa_usuario['direccion']['numero'] }}
                                            </small>
                                        </div>
                                        @endif

                                        <!-- Servicios contratados -->
                                        <div class="d-flex flex-wrap gap-1">
                                            @if(isset($tarifa_usuario['fibra']))
                                            <span class="badge bg-primary">
                                                <i class="fas fa-wifi me-1"></i>
                                                {{ $tarifa_usuario['fibra']['velocidad'] }} Mbps
                                            </span>
                                            @endif

                                            @if(isset($tarifa_usuario['movil']))
                                            <span class="badge bg-success">
                                                <i class="fas fa-mobile-alt me-1"></i>
                                                {{ count($tarifa_usuario['movil']['lineas']) }} líneas
                                            </span>
                                            @endif

                                            @if(isset($tarifa_usuario['tv']))
                                            <span class="badge bg-warning text-dark">
                                                <i class="fas fa-tv me-1"></i>
                                                {{ ucfirst($tarifa_usuario['tv']['tipo']) }}
                                            </span>
                                            @endif
                                        </div>
                                        @else
                                        <span class="badge bg-light text-muted">Sin servicios</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($usuario->tarifa)
                                        @php
                                        $tarifa_usuario = is_string($usuario->tarifa) ? json_decode($usuario->tarifa, true) : $usuario->tarifa;
                                        @endphp
                                        @if(isset($tarifa_usuario['fecha_contratacion']))
                                        <small class="text-muted">
                                            <i class="fas fa-calendar-alt me-1"></i>
                                            {{ \Carbon\Carbon::parse($tarifa_usuario['fecha_contratacion'])->format('d/m/Y') }}
                                        </small>
                                        @else
                                        <span class="text-muted">-</span>
                                        @endif
                                        @else
                                        <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($usuario->tarifa)
                                        @php
                                        $tarifa_usuario = is_string($usuario->tarifa) ? json_decode($usuario->tarifa, true) : $usuario->tarifa;
                                        @endphp
                                        @if(isset($tarifa_usuario['precio_total']))
                                        <span class="fw-bold text-success fs-6">
                                            {{ number_format($tarifa_usuario['precio_total'], 2) }}€
                                        </span>
                                        <small class="text-muted d-block">/mes</small>
                                        @else
                                        <span class="text-muted">-</span>
                                        @endif
                                        @else
                                        <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endauth

@endsection