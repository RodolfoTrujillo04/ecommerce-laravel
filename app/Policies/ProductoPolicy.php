<?php

namespace App\Policies;

use App\Models\Producto;
use App\Models\User;

class ProductoPolicy
{
    /**
     * Ver lista de productos
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Ver un producto
     */
    public function view(User $user, Producto $producto): bool
    {
        return true;
    }

    /**
     * Crear productos
     */
    public function create(User $user): bool
    {
        return in_array($user->rol, ['administrador', 'gerente']);
    }

    /**
     * Actualizar producto
     */
    public function update(User $user, Producto $producto): bool
    {
        return $user->id === $producto->usuario_id 
            || $user->rol === 'administrador';
    }

    /**
     * Eliminar producto
     */
    public function delete(User $user, Producto $producto): bool
    {
        return $user->rol === 'administrador';
    }

    /**
     * Restaurar (opcional)
     */
    public function restore(User $user, Producto $producto): bool
    {
        return false;
    }

    /**
     * Eliminación permanente (opcional)
     */
    public function forceDelete(User $user, Producto $producto): bool
    {
        return false;
    }
}