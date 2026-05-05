<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Categoria;
use App\Http\Requests\StoreProductoRequest;
use App\Http\Requests\UpdateProductoRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage; // 👈 agrega esto arriba

class ProductoController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $productos = Producto::with('categorias')->get();
        return view('cliente.productos', compact('productos'));
    }

    //  CREAR
    public function store(StoreProductoRequest $request)
    {
        $this->authorize('create', Producto::class);

        $paths = [];

        // 📸 Guardar imágenes
        if ($request->hasFile('fotos')) {
            foreach ($request->file('fotos') as $foto) {
                $path = $foto->store('productos', 'public');
                $paths[] = $path;
            }
        }

        // 📦 Datos del producto
        $data = $request->validated();
        $data['usuario_id'] = Auth::id();
        $data['fotos'] = $paths; // 👈 aquí guardas las rutas

        // 💾 Crear producto
        $producto = Producto::create($data);

        // 📝 LOG
        Log::channel('productos')->info('Producto creado', [
            'id' => $producto->id,
            'usuario_id' => Auth::id()
        ]);

        return redirect()->back();
    }

    //  EDITAR
    public function update(UpdateProductoRequest $request, Producto $producto)
    {
        $this->authorize('update', $producto);

        $producto->update($request->validated());

        // LOG
        Log::channel('productos')->info('Producto actualizado', [
            'id' => $producto->id,
            'usuario_id' => Auth::id()
        ]);

        return redirect()->back();
    }

    //  ELIMINAR (TE FALTABA ESTE MÉTODO)
    public function destroy(Producto $producto)
    {
        $this->authorize('delete', $producto);

        $producto->delete();

        // LOG
        Log::channel('productos')->info('Producto eliminado', [
            'id' => $producto->id,
            'usuario_id' => Auth::id()
        ]);

        return redirect()->back();
    }
}