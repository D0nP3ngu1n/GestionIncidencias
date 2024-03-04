<?php

namespace App\Exports;

use App\Models\Incidencia;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ListaAdminExport implements FromView, ShouldAutoSize
{
    /**
     * Método para generar la vista de exportación de las incidencias asignadas a un administrador.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function view(): View
    {
        $incidencias = Incidencia::whereNotNull('responsable_id')
            ->orderBy('responsable_id')
            ->get();
        return view('exports.listaAdmin', ['incidencias' => $incidencias]);
    }
}