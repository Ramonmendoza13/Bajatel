<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Mi Aplicación')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="{{ asset('JS/formCrearTarifa.js') }}"></script>
    <script src="{{ asset('JS/formContrataTarifa.js') }}"></script>



</head>

<body>
    <!-- NAVBAR SUPERIOR -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4 shadow">
        <div class="container">
            <a class="navbar-brand fw-bold fs-3" href="{{ url('/') }}">
                <i class="fas fa-wifi me-2"></i>
                Bajatel
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">

                    <li class="nav-item">
                        <a class="nav-link fw-semibold {{ request()->is('tarifas*') ? 'active' : '' }}" href="{{ url('/tarifas/contratar') }}">
                            <i class="fas fa-tags me-1"></i>Crear Tarifa
                        </a>
                    </li>
                    <!-- <li class="nav-item">
                        <a class="nav-link fw-semibold {{ request()->is('contacto*') ? 'active' : '' }}" href="{{ url('/contacto') }}">
                            <i class="fas fa-envelope me-1"></i>Contacto
                        </a>
                    </li>
                     -->
                    
                </ul>

                @auth
                <a class="btn btn-outline-light rounded-pill px-3 fw-semibold" href="{{ url('/zonaprivada') }}">
                    <i class="fas fa-home me-1"></i>Mi Area
                </a>
                @endauth
                @guest
                <div class="navbar-nav">
                    <a class="btn btn-outline-light rounded-pill px-3 fw-semibold" href="{{ url('/login') }}">
                        <i class="fas fa-sign-in-alt me-2"></i>Iniciar Sesión
                    </a>
                </div>
                @endguest

            </div>
        </div>
    </nav>

    <!-- CONTENIDO PRINCIPAL -->
    <main class="container mb-5">
        @yield('content')
    </main>

    <!-- FOOTER -->
    <footer class="bg-dark text-white py-4 mt-auto">
        <p class="text-center mb-0">© {{ date('Y') }} Bajatel. Todos los derechos reservados.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>