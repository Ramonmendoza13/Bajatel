@extends('plantilla')

@section('title', 'Bajatel - Nuestras Tarifas')

@section('content')
    <!-- Hero Section -->
    <section class="bg-primary text-white py-5 mb-5">
        <div class="container">
            <div class="row text-center">
                <div class="col-12">
                    <h1 class="display-4 fw-bold mb-3">Nuestras Tarifas</h1>
                    <p class="lead">Elige el plan que mejor se adapte a tus necesidades. Ofrecemos soluciones para todos los hogares y empresas.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Tarifas por tipo -->
    <div class="container">
        @foreach($tarifas as $tipo => $tarifasDelTipo)
            <div class="mb-5">
                <h2 class="text-center mb-4">
                    @switch($tipo)
                        @case('fibra')
                            <i class="fas fa-wifi text-primary me-2"></i>Fibra Óptica
                            @break
                        @case('gb')
                            <i class="fas fa-mobile-alt text-primary me-2"></i>Datos Móviles
                            @break
                        @case('llamadas')
                            <i class="fas fa-phone text-primary me-2"></i>Llamadas
                            @break
                        @case('tv')
                            <i class="fas fa-tv text-primary me-2"></i>Televisión
                            @break
                        @default
                            {{ ucfirst($tipo) }}
                    @endswitch
                </h2>
                
                <div class="row g-4 justify-content-center">
                    @foreach($tarifasDelTipo as $tarifa)
                        <div class="col-lg-4 col-md-6">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-header bg-primary text-white text-center py-3">
                                    <h4 class="mb-0">
                                        @switch($tipo)
                                            @case('fibra')
                                                {{ $tarifa->velocidad }} Mbps
                                                @break
                                            @case('gb')
                                                {{ $tarifa->gb }} GB
                                                @break
                                            @case('llamadas')
                                                @if($tarifa->minutos == -1)
                                                    Ilimitadas
                                                @else
                                                    {{ $tarifa->minutos }} min
                                                @endif
                                                @break
                                            @case('tv')
                                                {{ $tarifa->descripcion }}
                                                @break
                                            @default
                                                {{ $tarifa->descripcion }}
                                        @endswitch
                                    </h4>
                                </div>
                                
                                <div class="card-body text-center p-4">
                                    <div class="price mb-3">
                                        <span class="display-6 fw-bold text-primary">{{ number_format($tarifa->precio, 2) }}€</span>
                                        <span class="text-muted">/mes</span>
                                    </div>
                                    
                                    <p class="card-text text-muted mb-4">{{ $tarifa->descripcion }}</p>
                                    
                                    <div class="features mb-4">
                                        <ul class="list-unstyled">
                                            @switch($tipo)
                                                @case('fibra')
                                                    <li class="mb-2">
                                                        <i class="fas fa-tachometer-alt text-success me-2"></i>
                                                        {{ $tarifa->velocidad }} Mbps simétricos
                                                    </li>
                                                    <li class="mb-2">
                                                        <i class="fas fa-infinity text-success me-2"></i>
                                                        Sin límite de datos
                                                    </li>
                                                    <li class="mb-2">
                                                        <i class="fas fa-tools text-success me-2"></i>
                                                        Instalación gratuita
                                                    </li>
                                                    <li class="mb-2">
                                                        <i class="fas fa-headset text-success me-2"></i>
                                                        Soporte técnico incluido
                                                    </li>
                                                    @break
                                                    
                                                @case('gb')
                                                    <li class="mb-2">
                                                        <i class="fas fa-mobile-alt text-success me-2"></i>
                                                        {{ $tarifa->gb }} GB de datos
                                                    </li>
                                                    <li class="mb-2">
                                                        <i class="fas fa-wifi text-success me-2"></i>
                                                        Navegación 4G/5G
                                                    </li>
                                                    <li class="mb-2">
                                                        <i class="fas fa-globe text-success me-2"></i>
                                                        Sin límite de velocidad
                                                    </li>
                                                    @break
                                                    
                                                @case('llamadas')
                                                    <li class="mb-2">
                                                        <i class="fas fa-phone text-success me-2"></i>
                                                        @if($tarifa->minutos == -1)
                                                            Llamadas ilimitadas
                                                        @else
                                                            {{ $tarifa->minutos }} minutos
                                                        @endif
                                                    </li>
                                                    <li class="mb-2">
                                                        <i class="fas fa-home text-success me-2"></i>
                                                        A fijos nacionales
                                                    </li>
                                                    <li class="mb-2">
                                                        <i class="fas fa-mobile-alt text-success me-2"></i>
                                                        A móviles nacionales
                                                    </li>
                                                    @break
                                                    
                                                @case('tv')
                                                    <li class="mb-2">
                                                        <i class="fas fa-tv text-success me-2"></i>
                                                        Canales en HD
                                                    </li>
                                                    <li class="mb-2">
                                                        <i class="fas fa-film text-success me-2"></i>
                                                        Contenido bajo demanda
                                                    </li>
                                                    <li class="mb-2">
                                                        <i class="fas fa-undo text-success me-2"></i>
                                                        Grabación incluida
                                                    </li>
                                                    @break
                                            @endswitch
                                        </ul>
                                    </div>
                                    
                                    <div class="d-grid">
                                        <a href="{{ route('tarifas.show', $tarifa) }}" class="btn btn-primary">
                                            <i class="fas fa-info-circle me-2"></i>Ver Detalles
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>

    <!-- Call to Action -->
    <section class="bg-light py-5 mt-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <h2 class="fw-bold mb-4">¿Necesitas ayuda para elegir?</h2>
                    <p class="lead mb-4">Nuestro equipo de expertos te ayudará a encontrar la tarifa perfecta para ti</p>
                    <div class="d-flex gap-3 justify-content-center flex-wrap">
                        <a href="{{ url('/contacto') }}" class="btn btn-primary btn-lg">
                            <i class="fas fa-comments me-2"></i>Contactar Asesor
                        </a>
                        <a href="tel:+34900123456" class="btn btn-outline-primary btn-lg">
                            <i class="fas fa-phone me-2"></i>Llamar Ahora
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection 