<?php

namespace App\Exports;

use App\Models\Incidencia;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class ListaAdminExport implements FromView
{
    public function view(): View
    {
        $incidencias = Incidencia::whereNotNull('responsable_id')
        ->orderBy('responsable_id')
        ->get();
        return view('exports.listaAdmin', ['incidencias' => $incidencias]);
    }
    /**
     * @return \Illuminate\Support\Collection
     */
}
