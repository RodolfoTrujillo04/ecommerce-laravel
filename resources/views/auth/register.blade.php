<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<h2>Registro</h2>

<form method="POST" action="/register">
    @csrf
    <input type="text" name="name" placeholder="Nombre"><br><br>
    <input type="email" name="email" placeholder="Correo"><br><br>
    <input type="password" name="password" placeholder="Contraseña"><br><br>
    <button>Registrarse</button>
</form>