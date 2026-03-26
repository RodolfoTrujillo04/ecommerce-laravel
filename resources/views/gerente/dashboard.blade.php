<h1>Dashboard Gerente</h1>

<h3>Bienvenido, {{ auth()->user()->name }}</h3>

<p>Herramientas de administración</p>

<a href="/usuarios">Administrar usuarios</a>

<form method="POST" action="/logout">
    @csrf
    <button>Cerrar sesión</button>
</form>