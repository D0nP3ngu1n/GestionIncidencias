<?php

namespace App\Exports;

use App\Models\Incidencia;
use Illuminate\Support\Collection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class IncidenciaExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */

    protected $incidencias;

    public function __construct($incidencias = null)
    {
        $this->incidencias = $incidencias;
    }

    //Si recibe una incidencia, la devuelve
    //Sino, extrae los datos del array data, del json y devuelve la coleccion de incidencias filtradas recibidas 
    public function collection()
    {
        //dd($this->incidencias);

        if ($this->incidencias instanceof Incidencia) {
            return collect([$this->incidencias]);
        } else {
            $this->incidencias = $this->incidencias->data;  //array de las incidencias filtradas
            return collect($this->incidencias);
        }
    }

    //Cabecera para las exportaciones json y excel
    public function headings(): array
    {
        return [
            'ID Incidencia',
            'Tipo',
            'ID Subtipo',
            'Fecha de creacion',
            'Fecha de cierre',
            'Descripcion',
            'Estado',
            'Url Adjunto',
            'ID Creador',
            'ID Responsable',
            'Duracion',
            'ID Equipo',
            'Prioridad'

        ];
    }
}
