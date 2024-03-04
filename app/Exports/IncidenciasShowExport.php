<?php

namespace App\Exports;

use App\Models\Incidencia;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class IncidenciasShowExport implements FromView, ShouldAutoSize
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