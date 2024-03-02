<?php

namespace App\Exports;

use App\Models\Incidencia;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class TiempoDedicadoExport implements FromView
{

    /**
     * Método para generar la vista de exportación de las incidencias resueltas y el tiempo que llevaron.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function view(): View
    {
        $estadisticas = Incidencia::where('estado', 'resuelta')
            ->get();
        return view('exports.tiempoDedicado', ['estadisticas' => $estadisticas]);
    }
}