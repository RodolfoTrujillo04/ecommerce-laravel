

<h2>Productos</h2>

<form method="POST" action="{{ route('productos.store') }}">
    @csrf

    <input type="text" name="nombre" placeholder="Nombre producto"><br>
    <input type="text" name="descripcion" placeholder="Descripción"><br>
    <input type="number" name="precio" placeholder="Precio"><br>
    <input type="number" name="existencia" placeholder="Stock"><br>
    <input type="text" name="categoria" placeholder="Categoría"><br><br>

    <button type="submit">Guardar Producto</button>
</form>

<hr>

<h3>Lista de productos</h3>

@foreach($productos as $producto)
    <p>
        {{ $producto->nombre }} - ${{ $producto->precio }}  
        (Categorías: 
        @foreach($producto->categorias as $cat)
            {{ $cat->nombre }}
        @endforeach
        )
    </p>
@endforeach

