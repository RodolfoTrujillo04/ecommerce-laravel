<h1>Dashboard Cliente</h1>

<h3>Bienvenido, {{ auth()->user()->name }}</h3>

<p>Opciones para clientes</p>

<form method="POST" action="/logout">
    @csrf
    <button>Cerrar sesión</button>
</form>