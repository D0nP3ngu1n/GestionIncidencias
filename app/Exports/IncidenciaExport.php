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
        public function collection()
        {
            return Incidencia::all();
        }
}
