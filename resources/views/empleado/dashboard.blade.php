<h1>Dashboard Empleado</h1>

<h3>Bienvenido, {{ auth()->user()->name }}</h3>

<p>Opciones exclusivas para empleados</p>

<form method="POST" action="/logout">
    @csrf
    <button>Cerrar sesión</button>
</form>