<h1>Crear Usuario</h1>

<form method="POST" action="/usuarios">
    @csrf

    <input type="text" name="name" placeholder="Nombre">
    <input type="email" name="email" placeholder="Correo">
    <input type="password" name="password" placeholder="Contraseña">

    <select name="rol">
        <option value="cliente">Cliente</option>
        <option value="empleado">Empleado</option>
        <option value="gerente">Gerente</option>
    </select>

    <button>Guardar</button>
</form>