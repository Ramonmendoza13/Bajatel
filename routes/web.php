<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\zonaprivadaController;
use App\Http\Controllers\TarifaController;


//Ruta a la zona pública (simplemente accediendo a / vía GET)
Route::get('/', function () {
    return view('index');
})->name('index');

// Login
Route::get('/login', function () {
    return view('login.login');
})->name('login');
Route::post('/login', [LoginController::class, 'login']); // sin nombre

//Ruta a la zona privada (simplemente accediendo a /zonaprivada vía GET)
Route::get('/zonaprivada', [zonaprivadaController::class, 'mostrarTarifa'])->middleware('auth')->name('zonaprivada');

//Ruta para cerrar sesión
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

// Crear tarifa
Route::get('/tarifas/crear', [TarifaController::class, 'mostrarFormularioCrearTarifa'])->middleware('auth')->name('tarifas.crear');
Route::post('/tarifas/crear', [TarifaController::class, 'crearTarifa'])->middleware('auth'); // sin nombre

// Eliminar tarifa
Route::get('/tarifas/eliminar/{id}', [TarifaController::class, 'eliminarTarifa'])->middleware('auth')->name('tarifas.eliminar');

// Editar tarifa
Route::get('/tarifas/editar/{id}', [TarifaController::class, 'mostrarFormularioEditarTarifa'])->middleware('auth')->name('tarifas.editar');
Route::put('/tarifas/editar/{id}', [TarifaController::class, 'editarTarifa'])->middleware('auth'); // sin nombre

// Contratar tarifa
Route::get('/tarifas/contratar', [TarifaController::class, 'mostrarFormularioContratarTarifa'])->middleware('auth')->name('tarifas.contratar');
Route::post('/tarifas/contratar', [TarifaController::class, 'contratarTarifa'])->middleware('auth'); // sin nombre

// Cancelar tarida usuario
Route::get('/zonaprivada/cancelar', [TarifaController::class, 'cancelarTarifa'])->middleware('auth')->name('cancelarTarifa');
