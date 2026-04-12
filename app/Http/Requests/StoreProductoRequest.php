<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductoRequest extends FormRequest
{
    public function authorize()
    {
        return true; // la seguridad está en Policies
    }

    public function rules()
    {
        return [
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'precio' => 'required|numeric|min:1',
            'existencia' => 'required|integer|min:0',
           'usuario_id' => 'required|exists:usuarios,id'
        ];
    }
}