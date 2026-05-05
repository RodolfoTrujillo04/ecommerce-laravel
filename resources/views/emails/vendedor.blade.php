<h2>Venta Validada</h2>

<p>Se ha validado una venta de tu producto:</p>

<p><strong>Producto:</strong> {{ $venta->producto->nombre }}</p>

<p><strong>Comprador:</strong> {{ $venta->cliente->nombre }} {{ $venta->cliente->apellidos }}</p>

<p><strong>Correo comprador:</strong> {{ $venta->cliente->correo }}</p>