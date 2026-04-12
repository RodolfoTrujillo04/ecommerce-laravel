<?php

namespace Database\Seeders;

use App\Models\Producto;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $usuario = User::first();

        Producto::create([
            'nombre' => 'Laptop',
            'descripcion' => 'Gaming',
            'precio' => 15000,
            'existencia' => 5,
            'usuario_id' => $usuario->id
        ]);
    }
}