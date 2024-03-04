<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CrearEquipoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Reglas de validacion a la hora de crear un equipo
     * @param none no recibe nada
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'tipo_equipo' => 'required|in:altavoces,impresora,monitor,pantalla interactiva,portátil de aula,portátil Consejería,proyector',
            'fecha_adquisicion' => 'required',
            'etiqueta' => 'required|max:8',
            'marca' => 'required|max:20',
            'modelo' => 'required|max:45',
            'aula_num' => 'required',
            'puesto' => 'required',
            'descripcion' => 'required|max:256',
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
             'tipo_equipo.required' => 'El campo tipo es obligatorio.',
             'descripcion.required' => 'El campo descripcion es obligatorio.',
             'tipo_equipo.in' => 'Las posibles opciones de tipo de incidencia son:
             altavoces,impresora,monitor,pantalla interactiva,portátil de aula,portátil Consejería,proyector.',
             'descripcion.max' => 'El campo descripcion debe tener menos de 256 caracteres.',
             'puesto.required' => 'El campo puesto es obligatorio.',
             'aula_num.required' => 'El campo aula es obligatorio.',
             'marca.required' => 'El campo marca es obligatorio.',
             'modelo.required' => 'El campo modelo es obligatorio.',
             'etiqueta.required' => 'El campo etiqueta es obligatorio.',
             'fecha_adquisicion.required' => 'El campo fecha es obligatorio.',

         ];
     }
}
