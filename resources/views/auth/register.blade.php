<h2>Registro</h2>

<form method="POST" action="/register">
    @csrf

    <input type="text" name="nombre" placeholder="Nombre"><br><br>
    <input type="text" name="apellidos" placeholder="Apellidos"><br><br>
    <input type="email" name="correo" placeholder="Correo"><br><br>
    <input type="password" name="clave" placeholder="Contraseña"><br><br>

    <button>Registrarse</button>
</form>