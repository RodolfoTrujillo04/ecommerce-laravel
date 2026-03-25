<h2>Login</h2>

@if(session('error'))
    <p style="color:red;">
        {{ session('error') }}
    </p>
@endif

<form method="POST" action="/login">
    @csrf
    <input type="email" name="email" placeholder="Correo"><br><br>
    <input type="password" name="password" placeholder="Contraseña"><br><br>
    <button>Entrar</button>
</form>