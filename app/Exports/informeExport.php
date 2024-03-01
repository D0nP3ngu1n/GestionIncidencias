<?php

namespace App\Exports;

use App\Models\Incidencia;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;

class informeExport implements FromQuery
{

    public function query()
    {
        // Construye tu consulta aquí
        return Incidencia::query()->where('estado', 'resuelta')
        ->groupBy('responsable_id');
    }

    /**
     * @return \Illuminate\Support\Collection
     */

}
