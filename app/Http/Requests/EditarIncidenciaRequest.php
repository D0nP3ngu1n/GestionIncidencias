<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditarIncidenciaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Reglas de validacion a la hora de actualizar una incidencia
     * @param none no recibe nada
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nombre' => 'required|max:50',
            'descripcion' => 'max:256',
            'fichero' => 'mimes:jpg,pdf,csv,rtf',
        ];
    }

    /**
     * Mensajes de las reglas de validacion
     * @param none no recibe nada
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */

    public function messages(): array
    {
        return [
            'nombre.required' => 'El campo nombre es obligatorio.',
            'nombre.max' => 'El campo nombre debe tener menos de 25 caracteres.',
            'descripcion.max' => 'El campo descripcion debe tener menos de 256 caracteres.',
            'fichero.mimes' => 'El formato del fichero debe ser csv, jpg, rtf o pdf',
        ];
    }
}
