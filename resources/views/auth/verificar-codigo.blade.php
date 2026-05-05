<h2>Verificación 2FA</h2>

<form method="POST" action="/verificar-codigo">
    @csrf

    <input type="text" name="codigo" placeholder="Ingresa el código"><br><br>

    <button>Verificar</button>
</form>

@if(session('error'))
    <p style="color:red">{{ session('error') }}</p>
@endif