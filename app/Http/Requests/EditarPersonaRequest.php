<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ActualizarPersonaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Reglas de validacion a la hora de crear una incidencia
     * @param none no recibe nada
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nombrePersona' => 'required|max:25',
            'apellido1' => 'required|max:25',
            'apellido2' => 'required|max:25',
            'nombreDepartamento' => 'required|max:45',
            'tipoIncidencia' => 'required|in:Equipos,Cuentas,Wifi,Internet,Software',
            'subtipoIncidencia' => 'required|in:PC,Altavoces,Monitor,Proyector,Pantalla interactiva,
            Portatil, Impresoras, Educantabria, Google Classroom, Dominio, Yedra, IesMiguelHerrero,
             WIECAN, Instalacion, Actualizacion',
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
            'nombrePersona.required' => 'El campo nombre es obligatorio.',
            'nombrePersona.max' => 'El campo nombre debe tener menos de 25 caracteres.',
            'apellido1.required' => 'El campo apellido1 es obligatorio.',
            'apellido2.required' => 'El campo apellido2 es obligatorio.',
            'nombreDepartamento.required' => 'El campo departamento es obligatorio.',
            'nombreDepartamento.max' => 'El campo departamento debe tener menos de 45 caracteres.',
            'tipoIncidencia.required' => 'El campo tipo de incidencia es obligatorio.',
            'tipoIncidencia.in' => 'Las posibles opciones de tipo de incidencia son:
             Equipos,Cuentas,Wifi,Internet,Software.',
            'subtipoIncidencia.required' => 'El campo subtipo de incidencia es obligatorio.',
            'subtipoIncidencia.in' => 'Las posibles opciones de subtipo de incidencia son: PC,
            Altavoces,Monitor,Proyector,Pantalla interactiva,Portatil, Impresoras, Educantabria,
            Google Classroom, Dominio, Yedra, IesMiguelHerrero, WIECAN, Instalacion, Actualizacion.',
            'descripcion.max' => 'El campo descripcion debe tener menos de 256 caracteres.',
            'fichero.mimes' => 'El formato del fichero debe ser csv, jpg, rtf o pdf',
        ];
    }
}
