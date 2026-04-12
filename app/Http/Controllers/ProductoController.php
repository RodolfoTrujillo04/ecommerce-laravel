<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Categoria;


class ProductoController extends Controller
{
    public function index(){
        $productos = Producto::with('categorias')->get();
        return view('cliente.productos', compact('productos'));
    }

    public function store(Request $request){

        // Crear producto
        $producto = Producto::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'precio' => $request->precio,
            'existencia' => $request->existencia,
            'usuario_id' => 1 // temporal (luego auth)
        ]);

        // Crear o buscar categoría
        $categoria = Categoria::firstOrCreate([
            'nombre' => $request->categoria
        ]);

        // Relación
        $producto->categorias()->attach($categoria->id);

        return redirect()->route('productos.index');
    }
}
