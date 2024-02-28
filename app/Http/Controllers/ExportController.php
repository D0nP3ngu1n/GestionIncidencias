<?php

namespace App\Http\Controllers;

use App\Models\Incidencia;
use Illuminate\Http\Request;
use App\Exports\IncidenciaExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class ExportController extends Controller
{
    public function index(){
        $incidencias = Incidencia::all();
        return view('exports.index', ['incidencias' => $incidencias]);
    }

    public function export()
    {
        return Excel::download(new IncidenciaExport, 'incidencias.xlsx');
    }

    public function exportpdf()
    {
        $pdf = Pdf::loadView('exports.index', ['incidencias' => Incidencia::all()]);
        //return Excel::download(new IncidenciaExport, 'incidencias.pdf', \Maatwebsite\Excel\Excel::DOMPDF);
        return $pdf->download('incidencias.pdf');
    }

    public function exportcsv(){
        return Excel::download(new IncidenciaExport, 'incidencias.csv', \Maatwebsite\Excel\Excel::CSV);
    }



    public function show(Incidencia $incidencia)
    {
        return view('exports.show', ['incidencia' => $incidencia]);
    }

    public function exportInc(Incidencia $incidencia)
    {
        return Excel::download(new IncidenciaExport($incidencia), 'incidencia_' . $incidencia->id . '.xlsx');
    }

    public function exportpdfInc(Incidencia $incidencia){
        $pdf = Pdf::loadView('exports.showpdf', ['incidencia' => $incidencia]);
        return $pdf->download('incidencia_' . $incidencia->id . '.pdf');

        //return Excel::download(new IncidenciaExport($incidencia), 'incidencia_' . $incidencia->id . '.pdf', \Maatwebsite\Excel\Excel::DOMPDF);
    }

    public function exportcsvInc(Incidencia $incidencia){
        return Excel::download(new IncidenciaExport($incidencia), 'incidencia_' . $incidencia->id . '.csv', \Maatwebsite\Excel\Excel::CSV);
    }


}
