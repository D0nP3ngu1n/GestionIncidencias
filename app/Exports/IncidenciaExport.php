<?php

namespace App\Exports;

use App\Models\Incidencia;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithHeadings;

class IncidenciaExport implements FromCollection,WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    protected $incidencia;

    public function __construct(Incidencia $incidencia = null)
    {
        $this->incidencia = $incidencia;
    }

    public function collection()
    {
        if ($this->incidencia) {
            return collect([$this->incidencia]);
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
