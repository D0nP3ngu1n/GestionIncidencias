<?php

namespace App\Exports;

use App\Models\Incidencia;
use Illuminate\Support\Collection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class IncidenciaExport implements FromCollection,WithHeadings
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

    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        if ($this->data instanceof Incidencia) {
            return collect([$this->data]);
        } elseif ($this->data instanceof Collection) {
            return $this->data;
        } else {
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
