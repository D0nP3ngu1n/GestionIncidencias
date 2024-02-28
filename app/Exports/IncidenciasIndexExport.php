<?php

namespace App\Exports;

use App\Models\Incidencia;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class IncidenciasIndexExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        return view('incidencias.index', [
            'incidencias' => Incidencia::all()
        ]);
    }
}
