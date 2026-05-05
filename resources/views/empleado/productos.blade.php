<h2>Productos</h2>

<form method="POST" action="{{ route('productos.store') }}" enctype="multipart/form-data">
    @csrf

    <input type="text" name="nombre" placeholder="Nombre"><br>
    <input type="text" name="descripcion"><br>
    <input type="number" name="precio"><br>
    <input type="number" name="existencia"><br>

    <!-- 🔥 MULTI IMAGEN -->
    <input type="file" name="fotos[]" multiple><br><br>

    <button>Guardar</button>
</form>

<hr>

<h3>Lista de productos</h3>

@foreach($productos as $producto)
    <div style="margin-bottom:20px; border:1px solid #ccc; padding:10px;">
        
        <p>
            {{ $producto->nombre }} - ${{ $producto->precio }}  
            (Categorías: 
            @foreach($producto->categorias as $cat)
                {{ $cat->nombre }}
            @endforeach
            )
        </p>

        <!-- 🖼️ IMÁGENES -->
        @foreach($producto->fotos ?? [] as $foto)
            <img src="{{ asset('storage/'.$foto) }}" width="100">
        @endforeach

        <hr>

        <!-- 🧾 FORMULARIO DE COMPRA -->
        <form method="POST" action="/ventas" enctype="multipart/form-data">
            @csrf

            <input type="hidden" name="producto_id" value="{{ $producto->id }}">

            <label>Subir ticket:</label><br>
            <input type="file" name="ticket"><br><br>

            <button>Comprar</button>
        </form>

    </div>
@endforeach