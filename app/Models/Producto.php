<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Producto extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'descripcion',
        'precio',
        'existencia',
        'usuario_id'
    ];

    // 🔗 RELACIONES

    public function usuario(){
        return $this->belongsTo(User::class);
    }

    public function categorias(){
        return $this->belongsToMany(Categoria::class);
    }

    public function ventas(){
        return $this->hasMany(Venta::class);
    }
}