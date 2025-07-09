@extends('plantilla')

@section('title', 'Bajatel - Tu compañía de telecomunicaciones')

@section('content')
    <!-- Hero Section -->
    <section class="hero-section bg-primary text-white py-5 mb-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="display-4 fw-bold mb-4">Conectamos tu mundo digital</h1>
                    <p class="lead mb-4">Disfruta de la mejor conexión a internet con velocidades ultrarrápidas y atención personalizada. Bajatel, tu compañía de confianza.</p>
                    <div class="d-flex gap-3">
                        <a href="{{ url('/tarifas/contratar') }}" class="btn btn-light btn-lg">Contratar</a>
                        <!-- <a href="{{ url('/contacto') }}" class="btn btn-outline-light btn-lg">Contactar</a> -->
                    </div>
                </div>
                <div class="col-lg-6 text-center">
                    <div class="hero-image">
                        <i class="fas fa-wifi display-1 text-light opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Características principales -->
    <section class="features-section py-5 mb-5">
        <div class="container">
            <div class="row text-center mb-5">
                <div class="col-12">
                    <h2 class="display-5 fw-bold mb-3">¿Por qué elegir Bajatel?</h2>
                    <p class="lead text-muted">Ofrecemos las mejores soluciones de telecomunicaciones para tu hogar y empresa</p>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            <div class="feature-icon bg-primary bg-gradient text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                                <i class="fas fa-tachometer-alt fa-lg"></i>
                            </div>
                            <h5 class="card-title fw-bold">Velocidad Garantizada</h5>
                            <p class="card-text text-muted">Disfruta de velocidades de hasta 1Gbps con conexión estable y sin interrupciones.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            <div class="feature-icon bg-success bg-gradient text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                                <i class="fas fa-headset fa-lg"></i>
                            </div>
                            <h5 class="card-title fw-bold">Atención 24/7</h5>
                            <p class="card-text text-muted">Soporte técnico disponible las 24 horas del día, los 7 días de la semana.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            <div class="feature-icon bg-warning bg-gradient text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                                <i class="fas fa-euro-sign fa-lg"></i>
                            </div>
                            <h5 class="card-title fw-bold">Precios Competitivos</h5>
                            <p class="card-text text-muted">Las mejores tarifas del mercado sin costes ocultos ni sorpresas en la factura.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    
    <!-- Call to Action -->
    <section class="cta-section py-5 mb-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <h2 class="display-5 fw-bold mb-4">¿Listo para cambiar tu conexión?</h2>
                    <p class="lead mb-4">Únete a miles de clientes satisfechos que ya disfrutan de la mejor conexión con Bajatel</p>
                    <div class="d-flex gap-3 justify-content-center flex-wrap">
                         <!-- <a href="{{ url('/contacto') }}" class="btn btn-primary btn-lg">Solicitar Información</a>-->
                        <a href="tel:+34900123456" class="btn btn-outline-primary btn-lg">
                            <i class="fas fa-phone me-2"></i>Llamar Ahora
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Estadísticas -->
    <section class="stats-section py-5 bg-dark text-white">
        <div class="container">
            <div class="row text-center">
                <div class="col-md-3 col-6 mb-4">
                    <div class="stat-item">
                        <div class="display-4 fw-bold text-primary mb-2">50,000+</div>
                        <p class="mb-0">Clientes Satisfechos</p>
                    </div>
                </div>
                <div class="col-md-3 col-6 mb-4">
                    <div class="stat-item">
                        <div class="display-4 fw-bold text-primary mb-2">99.9%</div>
                        <p class="mb-0">Tiempo de Actividad</p>
                    </div>
                </div>
                <div class="col-md-3 col-6 mb-4">
                    <div class="stat-item">
                        <div class="display-4 fw-bold text-primary mb-2">24/7</div>
                        <p class="mb-0">Soporte Técnico</p>
                    </div>
                </div>
                <div class="col-md-3 col-6 mb-4">
                    <div class="stat-item">
                        <div class="display-4 fw-bold text-primary mb-2">15</div>
                        <p class="mb-0">Años de Experiencia</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Font Awesome para iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endsection