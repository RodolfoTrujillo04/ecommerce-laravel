<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductoController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/', fn() => view('welcome'));

Route::get('/cliente', fn() => view('cliente.dashboard'))->middleware('auth');
Route::get('/empleado', fn() => view('empleado.dashboard'))->middleware('auth');
Route::get('/gerente', fn() => view('gerente.dashboard'))->middleware('auth');
Route::resource('usuarios', UserController::class)->middleware('auth');
Route::get('/register', [AuthController::class, 'showRegister']);
Route::post('/register', [AuthController::class, 'register']);


Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout']);

Route::get('/cliente/productos', [ProductoController::class, 'index'])->name('productos.index');
Route::post('/cliente/productos', [ProductoController::class, 'store'])->name('productos.store');
