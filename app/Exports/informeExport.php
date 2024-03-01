<?php

namespace App\Exports;

use App\Models\Incidencia;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\FromView;

class InformeExport implements FromView
{
    public function view(): View
    {
        $incidencias = Incidencia::where('estado', 'resuelta')
            ->whereNotNull('responsable_id')
            ->orderBy('responsable_id')
            ->get();

        return view('exports.resueltas', ['incidencias' => $incidencias]);
    }
}
