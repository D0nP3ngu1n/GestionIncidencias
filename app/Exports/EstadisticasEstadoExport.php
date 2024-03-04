<?php

namespace App\Exports;

use App\Models\Incidencia;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class EstadisticasEstadoExport implements FromView, ShouldAutoSize
{
    /**
     * Método para generar la vista de exportación de las estadisticas segun el estado.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function view(): View
    {
        $estadisticas = Incidencia::select('tipo', DB::raw('COUNT(*) as total'))
            ->groupBy('tipo')
            ->get();

        return view('exports.estadisticas', ['estadisticas' => $estadisticas]);
    }
}