<?php

namespace App\Exports;

use App\Models\Incidencia;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class EstadisticasEstadoExport implements FromView
{
    public function view(): View
    {
        $estadisticas = Incidencia::select('tipo', DB::raw('COUNT(*) as total'))
        ->groupBy('tipo')
        ->get();

        return view('exports.estadisticas', ['estadisticas' => $estadisticas]);
    }
}
