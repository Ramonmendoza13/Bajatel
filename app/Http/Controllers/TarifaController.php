<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Tarifa;
use App\Models\User;

class TarifaController extends Controller
{
    public function mostrarFormularioCrearTarifa()
    {
        $user = Auth::user();
        if ($user->rol !== 'admin') {
            return redirect()->route('zonaprivada')->with('error', 'No tienes permisos para acceder a esta página');
        }
        return view('privada.admins.crearTarifa');
    }

    public function crearTarifa(Request $request)
    {
        $tarifa = new Tarifa();
        $tarifa->tipo = $request->tipo;
        $tarifa->descripcion = $request->descripcion;
        $tarifa->velocidad = $request->velocidad;
        $tarifa->minutos = $request->minutos;
        $tarifa->gb = $request->gigas;
        $tarifa->precio = $request->precio;
        $tarifa->save();
        return redirect()->route('zonaprivada')->with('success', 'Tarifa creada correctamente');
    }

    public function eliminarTarifa($id)
    {
        $tarifa = Tarifa::find($id);
        $tarifa->delete();
        return redirect()->route('zonaprivada')->with('success', "Tarifa {$tarifa->id} eliminada correctamente");
    }

    public function mostrarFormularioEditarTarifa($id)
    {
        $user = Auth::user();
        if ($user->rol !== 'admin') {
            return redirect()->route('zonaprivada')->with('success', 'No tienes permisos para acceder a esta página');
        }
        $tarifa = Tarifa::find($id);
        return view('privada.admins.editarTarfia', compact('tarifa'));
    }

    public function editarTarifa(Request $request, $id)
    {
        $tarifa = Tarifa::find($id);
        $tarifa->descripcion = $request->descripcion;
        $tarifa->velocidad = $request->velocidad;
        $tarifa->minutos = $request->minutos;
        $tarifa->gb = $request->gigas;
        $tarifa->precio = $request->precio;
        $tarifa->save();
        return redirect()->route('zonaprivada')->with('success', "Tarifa {$tarifa->id} editada correctamente");
    }

    public function mostrarFormularioContratarTarifa()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión para contratar una tarifa');
        }
        $tarifas = Tarifa::all();
        return view('privada.usuarios.contratarTarifa', compact('tarifas'));
    }

    public function contratarTarifa(Request $request)
    {
        // Mostrar todos los datos recibidos del formulario
        //dd($request->all());

        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión para contratar una tarifa');
        }
        
        $userId = Auth::id(); 
        $user = User::find($userId);
        $user->tarifa = $request->json_tarifa;
        $user->save();

        return redirect()->route('zonaprivada')->with('success','');



        //PRUEBAS VISUALIZAR JSON ANTES DE ENVIAR
        //$jsonTarifa = json_decode($request->json_tarifa);
        //devolver vista pruebas 
        //return view('testJson', compact('jsonTarifa'));
    }
}
