<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class crearUserRequest extends FormRequest
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
            'nombreCompleto' => 'required',
            'email' => 'required|email|ends_with:@educantabria.es',
            'password' => 'required|min:8|max:15',
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
            'nombreCompleto.required' => 'El campo nombre es obligatorio.',
            'email.ends_with' => 'El campo email debe acabar con @educantabria.es.',
            'email.required' => 'El campo email es obligatorio.',
            'password.required' => 'El campo contraseña es obligatorio.',
            'password.min' => 'El campo contraseña debe de tener al menos 8 caracteres',
            'password.max' => 'El campo contraseña debe tener menos de 15 caracteres.',
        ];
    }
}
