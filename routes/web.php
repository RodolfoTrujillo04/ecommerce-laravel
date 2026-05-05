<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\VentaController;
use App\Models\Venta;
use App\Models\User;
use App\Models\Producto;
use App\Models\Categoria;


Route::get('/verificar-codigo', function () {
    return view('auth.verificar-codigo');
});

Route::post('/verificar-codigo', [AuthController::class, 'verificarCodigo']);

Route::get('/', fn() => view('welcome'));

Route::get('/cliente', fn() => view('cliente.dashboard'))->middleware('auth');
Route::get('/empleado', fn() => view('empleado.dashboard'))->middleware('auth');
Route::get('/gerente', function () {

    $ventas = Venta::with(['producto','cliente','vendedor'])->get();

    return view('gerente.dashboard', compact('ventas'));

})->middleware('auth');
Route::resource('usuarios', UserController::class)->middleware('auth');
Route::get('/register', [AuthController::class, 'showRegister']);
Route::post('/register', [AuthController::class, 'register']);


Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout']);

Route::get('/cliente/productos', [ProductoController::class, 'index'])->name('productos.index');
Route::post('/cliente/productos', [ProductoController::class, 'store'])->name('productos.store');

Route::post('/ventas', [VentaController::class, 'store'])->middleware('auth');

Route::get('/ticket/{venta}', [VentaController::class, 'verTicket'])
    ->middleware('auth')
    ->name('ventas.ticket');

Route::post('/ventas/{venta}/validar', [VentaController::class, 'validar'])
    ->middleware('auth')
    ->name('ventas.validar');


Route::get('/gerente', function () {

    // 🔹 totales
    $totalUsuarios = User::count();
    $totalVendedores = User::where('rol', 'empleado')->count();
    $totalClientes = User::where('rol', 'cliente')->count();

    // 🔹 productos con categorías
    $productos = Producto::with('categorias', 'ventas')->get();

    // 🔹 producto más vendido
    $productoMasVendido = Producto::withCount('ventas')
        ->orderByDesc('ventas_count')
        ->first();

    // 🔹 categorías con productos
    $categorias = Categoria::with('productos')->get();

    // 🔹 comprador más frecuente (simple)
    $compradorFrecuente = User::withCount('ventasCliente')
        ->orderByDesc('ventas_cliente_count')
        ->first();

    // 🔹 ventas (ya lo tenías)
    $ventas = Venta::with(['producto','cliente','vendedor'])->get();

    return view('gerente.dashboard', compact(
        'totalUsuarios',
        'totalVendedores',
        'totalClientes',
        'productos',
        'productoMasVendido',
        'categorias',
        'compradorFrecuente',
        'ventas'
    ));

})->middleware('auth');    