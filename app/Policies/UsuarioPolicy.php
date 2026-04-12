<?php

namespace App\Policies;

use App\Models\User;

class UsuarioPolicy
{
    /**
     * Ver lista de usuarios
     */
    public function viewAny(User $user): bool
    {
        return in_array($user->rol, ['administrador', 'gerente']);
    }

    /**
     * Ver un usuario
     */
    public function view(User $user, User $model): bool
    {
        return true;
    }

    /**
     * Crear usuarios
     */
    public function create(User $user): bool
    {
        return $user->rol === 'administrador';
    }

    /**
     * Actualizar usuario
     */
    public function update(User $user, User $model): bool
    {
        // Admin puede todo
        if ($user->rol === 'administrador') {
            return true;
        }

        // Gerente solo puede editar clientes
        if ($user->rol === 'gerente') {
            return $model->rol === 'cliente';
        }

        return false;
    }

    /**
     * Eliminar usuario
     */
    public function delete(User $user, User $model): bool
    {
        return $user->rol === 'administrador';
    }

    public function restore(User $user, User $model): bool
    {
        return false;
    }

    public function forceDelete(User $user, User $model): bool
    {
        return false;
    }
}