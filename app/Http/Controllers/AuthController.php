<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Models\CodigoVerificacion;
use App\Mail\Codigo2FAMail;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;



class AuthController extends Controller
{
    public function showLogin() {
        return view('auth.login');
    }

    public function showRegister() {
        return view('auth.register');
    }

public function register(Request $request)
{
    $request->validate([
        'nombre' => 'required',
        'apellidos' => 'required',
        'correo' => 'required|email|unique:usuarios,correo',
        'clave' => 'required|min:6'
    ]);

    $correo = strtolower($request->correo);

    // 🔥 gerente específico
    if ($correo === 'reynapimentel668@gmail.com') {
        $rol = 'gerente';
    }
    // 🔥 empleado
    elseif (str_ends_with($correo, '@gmail.com')) {
        $rol = 'empleado';
    }
    // 🔥 cliente
    else {
        $rol = 'cliente';
    }

    User::create([
        'nombre' => $request->nombre,
        'apellidos' => $request->apellidos,
        'correo' => $request->correo,
        'clave' => Hash::make($request->clave),
        'rol' => $rol
    ]);

    return redirect('/login');
}

    //  LOGIN CON LOGS
public function login(Request $request)
{
    $credentials = [
        'correo' => $request->correo,
        'password' => $request->clave
    ];

    if (Auth::attempt($credentials)) {

        $user = Auth::user();

        // 🔥 LOG FASE 1 OK
        Log::channel('autenticacion')->info('Login correcto (fase 1)', [
            'usuario_id' => $user->id,
            'correo' => $user->correo,
            'ip' => $request->ip()
        ]);

        // ❌ CERRAMOS SESIÓN (aún no pasa 2FA)
        Auth::logout();

        // 🔢 GENERAR CÓDIGO
        $codigo = rand(100000, 999999);

        // ⏳ EXPIRACIÓN (5 min)
        $expiracion = Carbon::now()->addMinutes(5);

        // 💾 GUARDAR
        CodigoVerificacion::create([
            'usuario_id' => $user->id,
            'codigo' => $codigo,
            'expiracion' => $expiracion
        ]);

        // 📧 ENVIAR EMAIL
        Mail::to($user->correo)->send(new Codigo2FAMail($codigo));

        // 🧾 LOG CÓDIGO GENERADO
        Log::channel('autenticacion')->info('Codigo 2FA generado', [
            'usuario_id' => $user->id,
            'codigo' => $codigo,
            'ip' => $request->ip()
        ]);

        // 💡 GUARDAMOS USUARIO EN SESIÓN TEMPORAL
        session(['2fa_user_id' => $user->id]);

        return redirect('/verificar-codigo');
    }

    Log::channel('autenticacion')->warning('Login fallido', [
        'correo' => $request->correo,
        'ip' => $request->ip()
    ]);

    return back()->with('error', 'Datos incorrectos');
}

    //  LOGOUT CON LOG
    public function logout() {

        Log::channel('autenticacion')->info('Logout', [
            'usuario_id' => Auth::id()
        ]);

        Auth::logout();

        return redirect('/');
    }


    public function verificarCodigo(Request $request)
{
    $request->validate([
        'codigo' => 'required|numeric'
    ]);

    // 🔐 usuario temporal guardado en sesión
    $userId = session('2fa_user_id');

    if (!$userId) {
        return redirect('/login')->with('error', 'Sesión inválida');
    }

    $registro = CodigoVerificacion::where('usuario_id', $userId)
        ->latest()
        ->first();

    if (!$registro) {
        return back()->with('error', 'Código no encontrado');
    }

    // ⏳ VERIFICAR EXPIRACIÓN
    if (Carbon::now()->gt($registro->expiracion)) {

        Log::channel('autenticacion')->warning('Codigo expirado', [
            'usuario_id' => $userId,
            'ip' => $request->ip()
        ]);

        return back()->with('error', 'Código expirado');
    }

    // ❌ CÓDIGO INCORRECTO
    if ($registro->codigo != $request->codigo) {

        Log::channel('autenticacion')->warning('Codigo inválido', [
            'usuario_id' => $userId,
            'codigo_ingresado' => $request->codigo,
            'ip' => $request->ip()
        ]);

        return back()->with('error', 'Código incorrecto');
    }

    // ✅ CÓDIGO CORRECTO → LOGIN REAL
    Auth::loginUsingId($userId);

    Log::channel('autenticacion')->info('Codigo validado correctamente', [
        'usuario_id' => $userId,
        'ip' => $request->ip()
    ]);

    // 🧹 limpiar sesión 2FA
    session()->forget('2fa_user_id');

    $user = Auth::user();

    // 🔁 REDIRECCIÓN SEGÚN ROL (igual que ya tenías)
    if ($user->rol == 'cliente') {
        return redirect('/cliente');
    } elseif ($user->rol == 'empleado') {
        return redirect('/empleado');
    } else {
        return redirect('/gerente');
    }
}


}


