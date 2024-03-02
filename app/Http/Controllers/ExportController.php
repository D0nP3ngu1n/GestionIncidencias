<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Incidencia;
use Illuminate\Http\Request;
use App\Exports\informeExport;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\IncidenciaExport;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function index()
    {
        $incidencias = Incidencia::all();
        return view('exports.index', ['incidencias' => $incidencias]);
    }

    public function export(Request $request)
    {
        $incidencias = json_decode($request->input('incidencias'));

        // Realizar la exportación de las incidencias filtradas
        return Excel::download(new IncidenciaExport($incidencias), 'incidencias.xlsx');
    }

    public function exportpdf(Request $request)
    {
        /*$data = json_decode($request->input('incidencias'));

        // Obtener los datos de las incidencias
        $incidencias = collect($data->data);

        // Cargar la vista con los datos de las incidencias
        $pdf = Pdf::loadView('exports.pdf', ['incidencias' => $incidencias]);
        return $pdf->download('incidencias.pdf');*/

        $data = json_decode($request->input('incidencias'));

        // Obtener los datos de las incidencias
        $incidencias = collect($data->data);

        // Cargar la relación "creador" para cada incidencia
        foreach ($incidencias as $incidencia) {
            $incidencia->creador = User::find($incidencia->creador_id);
        }

        // Cargar la vista con los datos de las incidencias
        $pdf = Pdf::loadView('exports.pdf', ['incidencias' => $incidencias]);
        return $pdf->download('incidencias.pdf');
    }

    public function exportcsv(Request $request)
    {
        $incidencias = json_decode($request->input('incidencias'));

        return Excel::download(new IncidenciaExport($incidencias), 'incidencias.csv', \Maatwebsite\Excel\Excel::CSV);
    }



    public function show(Incidencia $incidencia)
    {
        return view('exports.show', ['incidencia' => $incidencia]);
    }

    public function exportInc(Incidencia $incidencia)
    {
        return Excel::download(new IncidenciaExport($incidencia), 'incidencia_' . $incidencia->id . '.xlsx');
    }

    public function exportpdfInc(Incidencia $incidencia)
    {
        //return Excel::download(new IncidenciaExport($incidencia), 'incidencia_' . $incidencia->id . '.pdf', \Maatwebsite\Excel\Excel::DOMPDF);

        $pdf = PDF::loadView('exports.showpdf', ['incidencia' => $incidencia]);
        return $pdf->download('incidencia_' . $incidencia->id . '.pdf');
    }

    public function exportcsvInc(Incidencia $incidencia)
    {
        return Excel::download(new IncidenciaExport($incidencia), 'incidencia_' . $incidencia->id . '.csv', \Maatwebsite\Excel\Excel::CSV);
    }

}