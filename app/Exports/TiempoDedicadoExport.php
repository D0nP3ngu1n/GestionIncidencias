<?php

namespace App\Exports;

use App\Models\Incidencia;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class TiempoDedicadoExport implements FromView
{
    public function view(): View
    {
        $estadisticas = Incidencia::where('estado', 'resuelta')
        ->get();
        return view('exports.tiempoDedicado', ['estadisticas' => $estadisticas]);
    }
    /**
     * @return \Illuminate\Support\Collection
     */
}
