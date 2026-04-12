<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Categoria;
use App\Http\Requests\StoreProductoRequest;
use App\Http\Requests\UpdateProductoRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ProductoController extends Controller
{
use AuthorizesRequests; // 👈 ESTO ARREGLA TODO
public function index(){
        $productos = Producto::with('categorias')->get();
        return view('cliente.productos', compact('productos'));
    }

    
    public function store(StoreProductoRequest $request)
{
    $this->authorize('create', Producto::class);

    Producto::create($request->validated());

    return redirect()->back();
}
public function update(UpdateProductoRequest $request, Producto $producto)
{
    $this->authorize('update', $producto);

    $producto->update($request->validated());

    return redirect()->back();
}
}
