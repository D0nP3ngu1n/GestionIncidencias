<?php

namespace App\Exports;

use App\Models\Incidencia;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class IncidenciaExport implements FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */
    protected $incidencia;

    public function __construct(Incidencia $incidencia = null)
    {
        $this->incidencia = $incidencia;
    }

    public function collection()
    {
        if ($this->incidencia) {
            return collect([$this->incidencia]);
        } else {
            return Incidencia::all();
        }
    }
}
