<h1>Dashboard Gerente</h1>

<h3>Bienvenido, {{ auth()->user()->nombre }}</h3>

<p>Herramientas de administración</p>



<a href="/usuarios">Administrar usuarios</a>

<h2>Estadísticas</h2>

<p><strong>Total usuarios:</strong> {{ $totalUsuarios }}</p>
<p><strong>Total vendedores:</strong> {{ $totalVendedores }}</p>
<p><strong>Total clientes:</strong> {{ $totalClientes }}</p>

<hr>

<h3>Producto más vendido</h3>

@if($productoMasVendido)
    <p>{{ $productoMasVendido->nombre }} ({{ $productoMasVendido->ventas_count }} ventas)</p>
@endif

<hr>

<h3>Productos por categoría</h3>

@foreach($categorias as $categoria)
    <p><strong>{{ $categoria->nombre }}</strong></p>

    <ul>
        @foreach($categoria->productos as $producto)
            <li>{{ $producto->nombre }}</li>
        @endforeach
    </ul>
@endforeach

<hr>

<h3>Comprador más frecuente</h3>

@if($compradorFrecuente)
    <p>{{ $compradorFrecuente->nombre }} ({{ $compradorFrecuente->ventas_cliente_count }} compras)</p>
@endif      

<hr>



<hr>

<h2>Ventas</h2>

@foreach($ventas as $venta)
    <div style="border:1px solid #ccc; padding:10px; margin-bottom:10px;">

        <p><strong>Producto:</strong> {{ $venta->producto->nombre }}</p>

        <p><strong>Cliente:</strong> 
            {{ $venta->cliente->nombre }} ({{ $venta->cliente->correo }})
        </p>

        <p><strong>Vendedor:</strong> 
            {{ $venta->vendedor->nombre }} ({{ $venta->vendedor->correo }})
        </p>

        <!-- 🔐 Ver ticket -->
        <a href="{{ route('ventas.ticket', $venta->id) }}">Ver ticket</a>

        <br><br>

        <!-- 🔥 BOTÓN VALIDAR -->
        <form method="POST" action="{{ route('ventas.validar', $venta->id) }}">
            @csrf
            <button>Validar venta</button>
        </form>

    </div>
@endforeach

<form method="POST" action="/logout">
    @csrf
    <button>Cerrar sesión</button>
</form>