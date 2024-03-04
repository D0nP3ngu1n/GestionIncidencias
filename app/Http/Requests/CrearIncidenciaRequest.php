<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CrearIncidenciaRequest extends FormRequest
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
            'nombre' => 'required|max:50',
            'departamento' => 'required|max:45',
            'tipo' => 'required|in:EQUIPOS,CUENTAS,WIFI,INTERNET,SOFTWARE',
            'descripcion' => 'required|max:256',
            'adjunto' => 'mimes:jpg,pdf,csv,rtf,doc,docx',
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
            'departamento.required' => 'El campo departamento es obligatorio.',
            'departamento.max' => 'El campo departamento debe tener menos de 45 caracteres.',
            'tipo.required' => 'El campo tipo de incidencia es obligatorio.',
            'tipo.in' => 'Las posibles opciones de tipo de incidencia son:
             Equipos,Cuentas,Wifi,Internet,Software.',
            'descripcion.max' => 'El campo descripcion debe tener menos de 256 caracteres.',
            'adjunto.mimes' => 'El formato del fichero debe ser csv, jpg, rtf, pdf, doc y docx',
        ];
    }
}
