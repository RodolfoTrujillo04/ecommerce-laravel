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
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'rol' => 'cliente'
        ]);

        return redirect('/login');
    }

    public function login(Request $request) {

        $credentials = $request->only('email', 'password');

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