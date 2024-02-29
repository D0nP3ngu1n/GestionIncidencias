<?php

namespace App\Exports;

use App\Models\Incidencia;
use Maatwebsite\Excel\Concerns\FromCollection;

class IncidenciasResueltasPorAdminExport implements FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        // Obtener incidencias resueltas con información del administrador
        return Incidencia::where('estado', 'resuelta')
            ->with('responsable')
            ->get()
            ->groupBy('responsable.nombre_completo');
    }

    public function headings(): array
    {
        // Encabezados para el archivo Excel
        return [
            'Administrador',
            'ID Incidencia',
            'Descripción',
            // ... otros campos que desees incluir
        ];
    }
}