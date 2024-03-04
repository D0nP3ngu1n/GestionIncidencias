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
    /**
     * Muestra todas las incidencias creadas
     *  @param null
     * @return mixed Devuelve una vista de todas las incidencias
     */
    public function index()
    {
        $incidencias = Incidencia::all();
        return view('exports.index', ['incidencias' => $incidencias]);
    }
    
    /**
     * Exportar las incidencias filtradas a excel
     * @param Request $request formulario que trae los datos del filtrado
     * @return mixed Descarga el fichero excel
     * Recibe la variable $incidencias (ya filtradas) del incidencias.index, las convierte en formato json y exporta el excel
     */
    public function export(Request $request)
    {
        $incidencias = json_decode($request->input('incidencias'));

        // Realizar la exportación de las incidencias filtradas
        return Excel::download(new IncidenciaExport($incidencias), 'incidencias.xlsx');
    }

    /**
     * Exportar las incidencias filtradas a pdf
     * @param Request $request formulario que trae los datos del filtrado
     * @return mixed Descarga el fichero pdf
     * Recibe la variable $incidencias (ya filtradas) del incidencias.index, las convierte en formato json, 
     * carga la relacion creador y exporta el pdf
     */
    public function exportpdf(Request $request)
    {
        $data = json_decode($request->input('incidencias'));

        // Obtener los datos de las incidencias
        $incidencias = collect($data->data);    //las incidencias se encuentran dentro del array data cuando se convierte en json

        // Cargar la relación "creador" para cada incidencia
        foreach ($incidencias as $incidencia) {
            $incidencia->creador = User::find($incidencia->creador_id);
        }

        // Cargar la vista con los datos de las incidencias
        $pdf = Pdf::loadView('exports.pdf', ['incidencias' => $incidencias]);
        return $pdf->download('incidencias.pdf');
    }

    /**
     * Exportar las incidencias filtradas a csv
     * @param Request $request formulario que trae los datos del filtrado
     * @return mixed Descarga el fichero csv
     * Recibe la variable $incidencias (ya filtradas) del incidencias.index, las convierte en formato json y exporta el csv
     */
    public function exportcsv(Request $request)
    {
        $incidencias = json_decode($request->input('incidencias'));

        return Excel::download(new IncidenciaExport($incidencias), 'incidencias.csv', \Maatwebsite\Excel\Excel::CSV);
    }

    /**
     * Muestra la incidencias seleccionada
     * @param null
     * @return mixed Devuelve una vista de la incidencia
     */
    public function show(Incidencia $incidencia)
    {
        return view('exports.show', ['incidencia' => $incidencia]);
    }

    /**
     * Exportar la incidencia a excel
     * @param Incidencia $incidencia recibe la incidencia seleccionada
     * @return mixed Descarga el fichero excel
     * Recibe la incidencia y exporta un excel de dicha incidencia
     */
    public function exportInc(Incidencia $incidencia)
    {
        return Excel::download(new IncidenciaExport($incidencia), 'incidencia_' . $incidencia->id . '.xlsx');
    }

    /**
     * Exportar la incidencia a pdf
     * @param Incidencia $incidencia recibe la incidencia seleccionada
     * @return mixed Descarga el fichero pdf
     * Recibe la incidencia y exporta un pdf de dicha incidencia
     */
    public function exportpdfInc(Incidencia $incidencia)
    {
        //return Excel::download(new IncidenciaExport($incidencia), 'incidencia_' . $incidencia->id . '.pdf', \Maatwebsite\Excel\Excel::DOMPDF);

        $pdf = PDF::loadView('exports.showpdf', ['incidencia' => $incidencia]);
        return $pdf->download('incidencia_' . $incidencia->id . '.pdf');
    }

    /**
     * Exportar la incidencia a csv
     * @param Incidencia $incidencia recibe la incidencia seleccionada
     * @return mixed Descarga el fichero csv
     * Recibe la incidencia y exporta un csv de dicha incidencia
     */
    public function exportcsvInc(Incidencia $incidencia)
    {
        return Excel::download(new IncidenciaExport($incidencia), 'incidencia_' . $incidencia->id . '.csv', \Maatwebsite\Excel\Excel::CSV);
    }

}
