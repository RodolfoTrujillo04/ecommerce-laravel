<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Venta;

class VentaPolicy
{
    /**
     * Ver lista de ventas
     */
    public function viewAny(User $user): bool
    {
        // Admin y gerente pueden ver todo
        return in_array($user->rol, ['administrador', 'gerente']);
    }

    /**
     * Ver una venta específica
     */
    public function view(User $user, Venta $venta): bool
    {
        return $user->id === $venta->cliente_id 
            || $user->id === $venta->vendedor_id
            || $user->rol === 'administrador';
    }

    /**
     * Crear venta
     */
    public function create(User $user): bool
    {
        return $user->rol === 'cliente';
    }

    /**
     * Actualizar venta
     */
    public function update(User $user, Venta $venta): bool
    {
        // Solo admin o el vendedor
        return $user->rol === 'administrador' 
            || $user->id === $venta->vendedor_id;
    }

    /**
     * Eliminar venta
     */
    public function delete(User $user, Venta $venta): bool
    {
        return $user->rol === 'administrador';
    }

    public function restore(User $user, Venta $venta): bool
    {
        return false;
    }

    public function forceDelete(User $user, Venta $venta): bool
    {
        return false;
    }
}