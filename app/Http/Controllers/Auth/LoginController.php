<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;


class LoginController extends Controller
{

    // Realizar el inicio de sesión autenticada
    public function login(Request $request)
    {
        // Validar los datos del formulario
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Se verifica email/password (true si ok)
        if (Auth::attempt($credentials)) {
            //Si ok--> se regenera sesión (se anota que está autenticado en la sesión).
            $request->session()->regenerate();
            //Redireccionamos a la página principal de la zona autenticada
            return redirect()->intended(route('zonaprivada'));
        }

        // Si la autenticación falla, volver al formulario con un error
        return back()->withErrors([
            'email' => 'El email o la contraseña no son válidos.',
        ])->onlyInput('email');
    }

    // Cerrar sesión autenticada
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect(route('index'));
    }

    public function registro(Request $request)
    {
        // Validar los datos con mensajes personalizados en español
        $request->validate([
            'name' => 'required|string|max:255',
            'dni' => [
                'required',
                'string',
                'max:20',
                'unique:users,dni',
                'regex:/^[0-9]{8}[A-Za-z]$/',
            ],
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'name.required' => 'El nombre es obligatorio.',
            'name.max' => 'El nombre no puede tener más de 255 caracteres.',
            'dni.required' => 'El DNI es obligatorio.',
            'dni.unique' => 'El DNI ya está registrado.',
            'dni.regex' => 'El DNI debe tener 8 números y 1 letra (ejemplo: 12345678A).',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'El correo electrónico no es válido.',
            'email.unique' => 'El correo electrónico ya está registrado.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
        ]);

        // Crear el usuario
        $user = new User();
        $user->name = $request->name;
        $user->dni = $request->dni;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->email_verified_at = \Carbon\Carbon::now();
        $user->rol = 'usuario';
        $user->tarifa = null;
        $user->save();

        // Redirigir con mensaje de éxito
        return redirect('/login')->with('errors', 'Usuario registrado correctamente. Ahora puedes iniciar sesión.');
    }
}
