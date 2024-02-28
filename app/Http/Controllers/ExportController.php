<?php

namespace App\Http\Controllers;

use App\Models\Incidencia;
use Illuminate\Http\Request;
use App\Exports\IncidenciaExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class ExportController extends Controller
{
    /**
     * Vista del listado de incidencias a exportar
     * @return mixed Devuelve la vista del listado de incidencias a exportar
     */
    public function index()
    {
        $incidencias = Incidencia::all();
        return view('exports.index', ['incidencias' => $incidencias]);
    }

    /**
     * Exporta el listado de incidencias a excel
     * @return mixed Realiza la exportacion a excel
     */
    public function export()
    {
        return Excel::download(new IncidenciaExport, 'incidencias.xlsx');
    }

    /**
     * Exporta el listado de incidencias a pdf -> showpdf(show sin botones para la exportacion a pdf)
     * @return mixed Realiza la exportacion a pdf
     */
    public function exportpdf()
    {
        $pdf = Pdf::loadView('exports.pdf', ['incidencias' => Incidencia::all()]);
        return $pdf->download('incidencias.pdf');
    }

    /**
     * Exporta el listado de incidencias a csv
     * @return mixed Realiza la exportacion a csv
     */
    public function exportcsv()
    {
        return Excel::download(new IncidenciaExport, 'incidencias.csv', \Maatwebsite\Excel\Excel::CSV);
    }

    /**
     * Vista de la incidencia a exportar
     * @param Incidencia $incidencia objeto Incidencia
     * @return mixed Devuelve la vista de la incidencia a exportar
     */
    public function show(Incidencia $incidencia)
    {
        return view('exports.show', ['incidencia' => $incidencia]);
    }

    /**
     * Exporta el listado de incidencias a excel
     * @param Incidencia $incidencia objeto Incidencia
     * @return mixed Realiza la exportacion a excel de la incidencia
     */
    public function exportInc(Incidencia $incidencia)
    {
        return Excel::download(new IncidenciaExport($incidencia), 'incidencia_' . $incidencia->id . '.xlsx');
    }

    /**
     * Exporta el listado de incidencias a pdf -> showpdf(show sin botones para la exportacion a pdf)
     * @param Incidencia $incidencia objeto Incidencia
     * @return mixed Realiza la exportacion a pdf de la incidencia
     */
    public function exportpdfInc(Incidencia $incidencia)
    {
        $pdf = Pdf::loadView('exports.showpdf', ['incidencia' => $incidencia]);
        return $pdf->download('incidencia_' . $incidencia->id . '.pdf');
    }

    /**
     * Exporta el listado de incidencias a csv
     * @param Incidencia $incidencia objeto Incidencia
     * @return mixed realiza la exportacion a csv de la incidencia
     */
    public function exportcsvInc(Incidencia $incidencia)
    {
        return Excel::download(new IncidenciaExport($incidencia), 'incidencia_' . $incidencia->id . '.csv', \Maatwebsite\Excel\Excel::CSV);
    }
}
