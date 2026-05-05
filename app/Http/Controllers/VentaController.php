<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\Venta;
use App\Models\Producto;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Mail;
use App\Mail\VentaValidadaVendedor;
use App\Mail\VentaValidadaComprador;



class VentaController extends Controller
{
    use AuthorizesRequests; // 🔥 ESTA LÍNEA FALTABA
    // 💰 GUARDAR VENTA
public function store(Request $request)
{
    $this->authorize('create', Venta::class); // 🔥

    $request->validate([
        'producto_id' => 'required|exists:productos,id',
        'ticket' => 'required|image'
    ]);

    $path = $request->file('ticket')->store('tickets', 'local');

    $producto = Producto::find($request->producto_id);

    Venta::create([
        'producto_id' => $request->producto_id,
        'cliente_id' => Auth::id(),
        'vendedor_id' => $producto->usuario_id,
        'fecha' => now(),
        'total' => 0,
        'ticket' => $path
    ]);

    return back();
}   

    // 🔐 VER TICKET (PROTEGIDO)
public function verTicket(Venta $venta)
{
    $this->authorize('view', $venta); // 🔥

    return response()->file(storage_path('app/' . $venta->ticket));
}


public function validar(Venta $venta)
{
    $this->authorize('update', $venta); // 🔐 solo gerente

    // (opcional) puedes agregar campo "estado"
    // $venta->estado = 'validada';
    // $venta->save();

    // 📧 enviar correo al vendedor
    Mail::to($venta->vendedor->correo)
        ->send(new VentaValidadaVendedor($venta));

    // 📧 enviar correo al comprador
    Mail::to($venta->cliente->correo)
        ->send(new VentaValidadaComprador($venta));

    return back()->with('success', 'Venta validada y correos enviados');
}

}