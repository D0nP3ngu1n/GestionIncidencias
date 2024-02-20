<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CrearPersonaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Reglas de validacion a la hora de crear una persona
     * @param none no recibe nada
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nombrePersona' => 'required|max:25',
            'apellido1' => 'required|max:25',
            'apellido2' => 'max:25',
            'dni' => 'required|regex:/^[0-9]{8}[A-Z]$/',
            'direccion' => 'max:80',
            'localidad' => 'max:25',
            'cp' => 'size:5',
            'tlf' => 'regex:/^[0-9]{9}$/'
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
            'nombrePersona.required' => 'El campo nombre es obligatorio.',
            'nombrePersona.max' => 'El campo nombre debe tener menos de 25 caracteres.',
            'apellido1.required' => 'El campo apellido1 es obligatorio.',
        ];
    }
}
