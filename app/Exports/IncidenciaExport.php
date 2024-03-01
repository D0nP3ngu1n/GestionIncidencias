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

    /*protected $data;

    public function __construct($data = null)
    {
        $this->data = $data;
    }

    public function collection()
    {
        if ($this->data instanceof Incidencia) {
            return collect([$this->data]);
        } else {
            return Incidencia::all();
        }
    }*/

    protected $incidencias;

    public function __construct($incidencias = null)
    {
        $this->incidencias = $incidencias;
    }

    public function collection()
    {
        if ($this->incidencias instanceof Incidencia) {
            return collect([$this->incidencias]);
        } elseif (is_array($this->incidencias) && count($this->incidencias) > 0) {
            // Si $this->incidencias es un array y contiene datos, simplemente lo devolvemos
            return collect($this->incidencias);
        } else {
            // Si no hay datos proporcionados, retornamos todas las incidencias
            return Incidencia::all();
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
