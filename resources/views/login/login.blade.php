@extends('plantilla')

@section('title', 'Bajatel - Login')

@section('content')

@auth
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-body text-center">
                        <h1 class="card-title text-primary mb-4">Ya has iniciado sesión</h1>
                        <a href="{{ route('zonaprivada') }}" class="btn btn-primary btn-lg">Ir a zona privada</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endauth

@guest
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-4">
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white text-center">
                    <h2 class="mb-0">Iniciar Sesión</h2>
                </div>
                <div class="card-body p-4">
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <h5 class="alert-heading">Errores:</h5>
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <!-- Formulario de inicio de sesión -->
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label">Correo Electrónico:</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" placeholder="ejemplo@correo.com" required>
                        </div>
                        
                        <div class="mb-4">
                            <label for="password" class="form-label">Contraseña:</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Ingresa tu contraseña" required>
                        </div>
                        
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">Iniciar Sesión</button>
                        </div>
                    </form>
                    <!-- Enlace para registrarse -->
                    <div class="mt-3 text-center">
                        <a href="{{ url('/registro') }}" class="text-decoration-underline">¿No tienes cuenta? Regístrate aquí</a>
                    </div>
                    <!-- Zona de cuentas de prueba -->
                    <div class="mt-4">
                        <div class="alert alert-info">
                            <h5 class="mb-2"><i class="fas fa-user me-1"></i> Cuentas de prueba</h5>
                            <ul class="mb-1">
                                <li><b>Admin:</b> RMC1@email.RMC / <span class="text-monospace">RMC1</span></li>
                                <li><b>Usuario:</b> RMC2@email.RMC / <span class="text-monospace">RMC2</span></li>
                                <li><b>Usuario:</b> RMC3@email.RMC / <span class="text-monospace">RMC3</span></li>
                                <li><b>Usuario:</b> RMC4@email.RMC / <span class="text-monospace">RMC4</span></li>
                                <li><b>Usuario:</b> RMC5@email.RMC / <span class="text-monospace">RMC5</span></li>
                            </ul>
                            <small class="text-muted">Puedes usar estas cuentas para probar la web.</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endguest

@endsection