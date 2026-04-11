<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Venta extends Model
{
    use HasFactory;

    protected $fillable = [
        'producto_id',
        'vendedor_id',
        'cliente_id',
        'fecha',
        'total'
    ];

    // 🔗 RELACIONES

    public function producto(){
        return $this->belongsTo(Producto::class);
    }

    public function cliente(){
        return $this->belongsTo(User::class, 'cliente_id');
    }

    public function vendedor(){
        return $this->belongsTo(User::class, 'vendedor_id');
    }
}