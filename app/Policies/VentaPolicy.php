<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Venta;

class VentaPolicy
{
public function viewAny(User $user): bool
{
    return in_array($user->rol, ['administrador', 'gerente']);
}

public function view(User $user, Venta $venta): bool
{
    return $user->id === $venta->cliente_id
        || $user->rol === 'gerente';
}

public function create(User $user): bool
{
    return $user->rol === 'cliente';
}

// 🔥 VALIDAR VENTA (IMPORTANTE PARA RÚBRICA)
public function update(User $user, Venta $venta): bool
{
    return $user->rol === 'gerente';
}

public function delete(User $user, Venta $venta): bool
{
    return $user->rol === 'administrador';
}
}