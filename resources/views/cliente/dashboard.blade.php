<h1>Dashboard Cliente</h1>

<h3>Bienvenido, {{ auth()->user()->nombre  }}</h3>

<p>Opciones para clientes xd</p>

<form method="POST" action="/logout">
    @csrf
    <button>Cerrar sesión</button>
</form>