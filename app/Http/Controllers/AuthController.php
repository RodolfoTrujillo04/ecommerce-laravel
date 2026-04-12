<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function showLogin() {
        return view('auth.login');
    }

    public function showRegister() {
        return view('auth.register');
    }

    public function register(Request $request) {

        $request->validate([
            'nombre' => 'required',
            'apellidos' => 'required',
            'correo' => 'required|email|unique:usuarios,correo',
            'clave' => 'required|min:6'
        ]);

        User::create([
            'nombre' => $request->nombre,
            'apellidos' => $request->apellidos,
            'correo' => $request->correo,
            'clave' => Hash::make($request->clave),
            'rol' => 'cliente'
        ]);

        return redirect('/login');
    }

    //  LOGIN CON LOGS
    public function login(Request $request) {

        $credentials = [
            'correo' => $request->correo,
            'password' => $request->clave
        ];

        if (Auth::attempt($credentials)) {

            $user = Auth::user();

            // ✅ LOG EXITOSO
            Log::channel('autenticacion')->info('Login exitoso', [
                'usuario_id' => $user->id,
                'correo' => $user->correo,
                'ip' => $request->ip()
            ]);

            if ($user->rol == 'cliente') {
                return redirect('/cliente');
            } elseif ($user->rol == 'empleado') {
                return redirect('/empleado');
            } else {
                return redirect('/gerente');
            }
        }

        //  LOG FALLIDO
        Log::channel('autenticacion')->warning('Login fallido', [
            'correo' => $request->correo,
            'ip' => $request->ip()
        ]);

        return back()->with('error', 'Datos incorrectos');
    }

    //  LOGOUT CON LOG
    public function logout() {

        Log::channel('autenticacion')->info('Logout', [
            'usuario_id' => auth()->id()
        ]);

        Auth::logout();

        return redirect('/');
    }
}