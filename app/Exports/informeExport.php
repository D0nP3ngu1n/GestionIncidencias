<?php

namespace App\Exports;

use App\Models\Incidencia;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class InformeExport implements FromView, ShouldAutoSize
{
    /**
     * Método para generar la vista de exportación de incidencias resueltas.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function view(): View
    {
        $incidencias = Incidencia::where('estado', 'resuelta')
            ->whereNotNull('responsable_id')
            ->orderBy('responsable_id')
            ->get();

        return view('exports.resueltas', ['incidencias' => $incidencias]);
    }
}