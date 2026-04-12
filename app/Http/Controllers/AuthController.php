<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

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

    public function login(Request $request) {

        $credentials = [
            'correo' => $request->correo,
            'password' => $request->clave
        ];

        if (Auth::attempt($credentials)) {

            $user = Auth::user();

            if ($user->rol == 'cliente') {
                return redirect('/cliente');
            } elseif ($user->rol == 'empleado') {
                return redirect('/empleado');
            } else {
                return redirect('/gerente');
            }
        }

        return back()->with('error', 'Datos incorrectos');
    }

    public function logout() {
        Auth::logout();
        return redirect('/');
    }
}