<?php

namespace App\Http\Controllers;

use App\Models\Incidencia;
use Illuminate\Http\Request;
use App\Exports\IncidenciaExport;
use Maatwebsite\Excel\Facades\Excel;

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

    public function exportpdf(){
        return Excel::download(new IncidenciaExport, 'incidencias.pdf', \Maatwebsite\Excel\Excel::DOMPDF);
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

    public function exportpdfInc(){
        return Excel::download(new IncidenciaExport, 'incidencias.pdf', \Maatwebsite\Excel\Excel::DOMPDF);
    }

    public function exportcsvInc(){
        return Excel::download(new IncidenciaExport, 'incidencias.csv', \Maatwebsite\Excel\Excel::CSV);
    }


}
