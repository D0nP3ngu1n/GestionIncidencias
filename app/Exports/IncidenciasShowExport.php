<?php

namespace App\Exports;

use App\Models\Incidencia;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class IncidenciasShowExport implements FromView
{
    protected $incidencia;

    public function __construct(Incidencia $incidencia)
    {
        $this->incidencia = $incidencia;
    }

    public function view(): View
    {
        return view('exports.show', [
            'incidencia' => $this->incidencia
        ]);
    }
}
