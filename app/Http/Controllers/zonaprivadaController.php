<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Tarifa;
use App\Models\User;

class zonaprivadaController extends Controller
{
    public function mostrarTarifa()
    {
        $user = Auth::user();
        $tarifa_usuario = $user->tarifa;

        $tarifas = Tarifa::all(); //Obtiene todas las tarifas de la base de datos
        $usuarios = User::all(); //Obtiene todos los usuarios de la base de datos
        //Si es admin, muestra la vista de admins, si no, muestra la vista de usuarios
        if ($user->rol === 'admin') {
            return view('privada.admins.principal', ['nombre' => $user->name, 'tarifas' => $tarifas, 'usuarios' => $usuarios]);
        } else {
            return view('privada.usuarios.principal', ['nombre' => $user->name, 'tarifa_usuario' => $tarifa_usuario, 'usuarios' => $usuarios]);
        }
    }


}
