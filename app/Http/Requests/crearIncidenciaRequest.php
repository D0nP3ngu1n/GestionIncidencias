<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class crearIncidenciaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'especie' => 'required|min:3',
            'peso' => 'required',
            'altura' => 'required',
            'fechaNacimiento' => 'required',
            'imagen' => 'required|image|mimes:jpeg,png,jpg,svg',
        ];
    }

    public function messages(): array
    {
        return [
            'especie.required' => 'El campo especie es obligatorio.',
            'especie.min' => 'El campo especie debe tener al menos 3 caracteres.',
            'peso.required' => 'El campo peso es obligatorio.',
            'altura.required' => 'El campo altura es obligatorio.',
            'fechaNacimiento.required' => 'El campo fecha de nacimiento es obligatorio.',
            'imagen.required' => 'El campo imagen es obligatorio.',
            'imagen.mimes' => 'El formato de la imagen debe ser jpeg, png, jpg o svg.',
        ];
    }
}
