<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CrearComentarioRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Reglas de validacion a la hora de crear un comentario
     * @param none no recibe nada
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'texto' => 'required|max:250',
            'fechaHora' => 'required|date_format:Y-m-d H:i:s',
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
            'texto.required' => 'El campo texto es obligatorio.',
            'texto.max' => 'El campo texto debe tener menos de 250 caracteres.',
            'fechaHora.required' => 'El campo fecha y hora es obligatorio.',
            'fechaHora.date_format' => 'El formato de fecha y hora proporcionado es inválido. (ejemplo: YYYY-MM-DD HH:MM:SS).',
        ];
    }
}
