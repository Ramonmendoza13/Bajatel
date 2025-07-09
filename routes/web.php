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

//Ruta a el login
Route::get('/login', function () {
    return view('login.login');
})->name('login');

Route::post('/login', [LoginController::class, 'login'])->name('login');

//Ruta a la zona privada (simplemente accediendo a /zonaprivada vía GET)
Route::get('/zonaprivada', [zonaprivadaController::class, 'mostrarTarifa'])->middleware('auth')->name('zonaprivada');

//Ruta para cerrar sesión
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

//Ruta para crear una tarifa (solo para admins)
Route::get('/tarifas/crear', [TarifaController::class, 'mostrarFormularioCrearTarifa'])->middleware('auth')->name('tarifas.crear');

//Ruta para crear una tarifa (solo para admins)
Route::post('/tarifas/crear', [TarifaController::class, 'crearTarifa'])->middleware('auth')->name('tarifas.crear');

//Ruta eliminar una tarifa (solo para admins)
Route::get('/tarifas/eliminar/{id}', [TarifaController::class, 'eliminarTarifa'])->middleware('auth')->name('tarifas.eliminar');

//Ruta para editar una tarifa (solo para admins)
Route::get('/tarifas/editar/{id}', [TarifaController::class, 'mostrarFormularioEditarTarifa'])->middleware('auth')->name('tarifas.editar');

//Ruta para editar una tarifa (solo para admins)
Route::put('/tarifas/editar/{id}', [TarifaController::class, 'editarTarifa'])->middleware('auth')->name('tarifas.editar');

//Ruta para contratar una tarifa personalizada(solo para usuarios registrados)
Route::get('/tarifas/contratar', [TarifaController::class, 'mostrarFormularioContratarTarifa'])->middleware('auth')->name('tarifas.contratar');

//Ruta para contratar una tarifa personalizada (solo para usuarios registrados)
Route::post('/tarifas/contratar', [TarifaController::class, 'contratarTarifa'])->middleware('auth')->name('tarifas.contratar');
