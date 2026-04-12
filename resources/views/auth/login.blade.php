<h2>Login</h2>

<form method="POST" action="/login">
    @csrf

    <input type="email" name="correo" placeholder="Correo"><br><br>
    <input type="password" name="clave" placeholder="Contraseña"><br><br>

    <button>Iniciar sesión</button>
</form>

@if(session('error'))
    <p style="color:red">{{ session('error') }}</p>
@endif