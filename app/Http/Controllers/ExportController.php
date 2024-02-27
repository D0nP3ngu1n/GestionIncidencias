<?php

namespace App\Http\Controllers;

use App\Models\Incidencia;
use Illuminate\Http\Request;
use App\Exports\IncidenciaExport;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function export()
    {
        return Excel::download(new IncidenciaExport, 'incidencias.xlsx');
    }

    public function index(){
        $incidencias = Incidencia::all();
        return view('exports.index', ['incidencias' => $incidencias]);
    }

    public function exportpdf(){
        return Excel::download(new IncidenciaExport, 'incidencias.pdf', \Maatwebsite\Excel\Excel::DOMPDF);
    }
}
