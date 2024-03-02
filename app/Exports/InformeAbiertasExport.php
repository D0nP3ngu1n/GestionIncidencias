<?php

namespace App\Exports;

use App\Models\Incidencia;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\FromView;

class InformeAbiertasExport implements FromView
{
    /**
     * Método para generar la vista de exportación de las incidencias abiertas.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function view(): View
    {
        $incidencias = Incidencia::where('estado', 'abierta')
            ->whereNotNull('creador_id')
            ->orderBy('creador_id')->get();
        return view('exports.resueltas', ['incidencias' => $incidencias]);
    }
}