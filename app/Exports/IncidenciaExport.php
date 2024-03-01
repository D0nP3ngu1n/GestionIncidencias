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
