<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreVentaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'producto_id' => 'required|exists:productos,id',
        'cliente_id' => 'required|exists:usuarios,id',
        'vendedor_id' => 'required|exists:usuarios,id',
        'fecha' => 'required|date',
        'total' => 'required|numeric|min:1'
        ];
    }
}
