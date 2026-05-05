<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // 👇 IMPORTANTE: tu tabla personalizada
    protected $table = 'usuarios';

    protected $fillable = [
        'nombre',
        'apellidos',
        'correo',
        'clave',
        'rol',
    ];

    protected $hidden = [
        'clave',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
        ];
    }

    // 🔗 RELACIONES

    public function productos(){
        return $this->hasMany(Producto::class);
    }

    public function ventasCliente(){
        return $this->hasMany(Venta::class, 'cliente_id');
    }

    public function ventasVendedor(){
        return $this->hasMany(Venta::class, 'vendedor_id');
    }

    public function getAuthPassword()
{
    return $this->clave;
}

public function ventasComoVendedor()
{
    return $this->hasMany(Venta::class, 'vendedor_id');
}

// 🔥 ESTA ES LA IMPORTANTE (hasManyThrough)
public function ventasDeProductos()
{
    return $this->hasManyThrough(
        Venta::class,
        Producto::class,
        'usuario_id', // FK en productos
        'producto_id', // FK en ventas
        'id', // PK usuario
        'id'  // PK producto
    );
}
}