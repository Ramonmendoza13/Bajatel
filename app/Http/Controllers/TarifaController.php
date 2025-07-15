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

    /*public function mostrarFormularioContratarTarifa()
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

        return redirect()->route('zonaprivada')->with('success', '');



        //PRUEBAS VISUALIZAR JSON ANTES DE ENVIAR
        //$jsonTarifa = json_decode($request->json_tarifa);
        //devolver vista pruebas 
        //return view('testJson', compact('jsonTarifa'));
    }*/

    public function cancelarTarifa(Request $request)
    {
        $user = Auth::user(); //Usario autentificado
        // Si no hay redigirgimos al login
        if (!$user) {
            return redirect()->route('login')->with('error', '');
        }

        $userId = Auth::id(); // Obtener el ID del usuario registrado
        $user = User::find($userId); //Obtener el usuario
        //Borrar la tarifa del usuario
        $user->tarifa = null;
        $user->save();

        return redirect()->route('zonaprivada')->with('success', 'Tarifa cancelada correctamente');
    }

    public function mostrarFormularioContratarTarifa()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión para contratar una tarifa');
        }
        $tarifas = Tarifa::all();
        return view('contratarTarifa', compact('tarifas'));
    }

    public function contratarTarifa(Request $request)
    {


        //validar los datos del formulario
        $request->validate([
            'ciudad' => 'required|string|max:255',
            'cp' => 'required|digits:5',
            'calle' => 'required|string|max:255',
            'numero' => 'required|integer',
        ], [
            'ciudad.required' => 'La ciudad es obligatoria.',
            'cp.required' => 'El código postal es obligatorio.',
            'cp.digits' => 'El código postal debe tener exactamente 5 dígitos.',
            'calle.required' => 'La calle es obligatoria.',
            'numero.required' => 'El número es obligatorio.',
            'numero.integer' => 'El número debe ser un valor numérico.',
        ]);

        // Mostrar todos los datos recibidos del formulario
        //dd($request->all());

        //Crea JSON a travez de los datos del formulario
        $jsonTarifa = [];
        // Dirección
        $jsonTarifa['direccion'] = [
            'ciudad' => $request->input('ciudad'),
            'calle' => $request->input('calle'),
            'numero' => $request->input('numero'),
            'cp' => $request->input('cp'),
        ];
        //Cargar los datos de la tarifa selecionada
        $datosFibra = Tarifa::find($request->tarifa_fibra);
        $precioTotal = 0;

        // Fibra
        if ($request->filled('tarifa_fibra') && $request->tarifa_fibra != '0') {
            if ($datosFibra && $datosFibra->tipo === 'fibra') {
                $jsonTarifa['fibra'] = [
                    'id_tarifa' => $datosFibra->id,
                    'velocidad' => $datosFibra->velocidad,
                    'precio' => (float)$datosFibra->precio,
                ];
                $precioTotal += $datosFibra->precio;
            }
        }
        // Móviles
        $jsonTarifa['movil']['lineas'] = [];
        $lineas = $request->input('lineas', []);
        foreach ($lineas as $linea) {
            $lineaJson = [];

            // Datos de GB
            if (!empty($linea['tarifa_gb'])) {
                $tarifaGb = Tarifa::find($linea['tarifa_gb']);
                if ($tarifaGb && $tarifaGb->tipo === 'gb') {
                    $lineaJson['id_tarifa'] = $tarifaGb->id;
                    $lineaJson['gb'] = $tarifaGb->gb;
                    $lineaJson['precio'] = (float)$tarifaGb->precio;
                }
            }

            // Teléfono (si lo tienes en el form, si no, genera uno)
            $lineaJson['telefono'] = $linea['numero'] ?? (
                (string) (rand(0, 1) ? '6' : '7') . str_pad(strval(rand(0, 99999999)), 8, '0', STR_PAD_LEFT)
            );

            // Llamadas
            if (!empty($linea['tarifa_llamadas'])) {
                $tarifaLlamadas = Tarifa::find($linea['tarifa_llamadas']);
                if ($tarifaLlamadas && $tarifaLlamadas->tipo === 'llamadas') {
                    $lineaJson['llamadas'] = [
                        'id_tarifa' => $tarifaLlamadas->id,
                        'minutos' => $tarifaLlamadas->minutos,
                        'precio' => (float)$tarifaLlamadas->precio,
                    ];
                }
            }

            // Solo añadir si tiene datos o llamadas
            if (isset($lineaJson['id_tarifa']) || isset($lineaJson['llamadas'])) {
                $jsonTarifa['movil']['lineas'][] = $lineaJson;
            }
        }

        $datosTv = Tarifa::find($request->tarifa_tv);
        // Televisión
        if ($request->filled('tarifa_tv') && $request->tarifa_tv != '0') {
            if ($datosTv && $datosTv->tipo === 'tv') {
                $jsonTarifa['tv'] = [
                    'id_tarifa' => $datosTv->id,
                    'tipo' => $datosTv->descripcion,
                    'precio' => (float)$datosTv->precio,
                ];
                $precioTotal += $datosTv->precio;
            }
        }
        // Fecha y precio total
        $jsonTarifa['fecha_contratacion'] = \Carbon\Carbon::now()->toDateString();
        $jsonTarifa['precio_total'] = (float)$precioTotal;

        //PRUEBAS VISUALIZAR JSON ANTES DE ENVIAR
        //$jsonTarifa = json_decode($request->json_tarifa);
        //devolver vista pruebas 

        //return view('testJson', compact('jsonTarifa'));

        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión para contratar una tarifa');
        }

        $userId = Auth::id();
        $user = User::find($userId);
        $user->tarifa = $jsonTarifa;
        $user->save();

        return redirect()->route('zonaprivada')->with('success', '');
    }
}
