<h1>Lista de Usuarios</h1>

<a href="/usuarios/create">Nuevo Usuario</a>

<table border="1">
<tr>
    <th>Nombre</th>
    <th>Email</th>
    <th>Rol</th>
    <th>Acciones</th>
</tr>

@foreach($users as $user)
<tr>
    <td>{{ $user->name }}</td>
    <td>{{ $user->email }}</td>
    <td>{{ $user->rol }}</td>
    <td>
        <form action="/usuarios/{{ $user->id }}" method="POST">
            @csrf
            @method('DELETE')
            <button>Eliminar</button>
        </form>
    </td>
</tr>
@endforeach

</table>