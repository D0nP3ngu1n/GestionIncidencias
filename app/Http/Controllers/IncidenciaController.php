<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Incidencia;

class IncidenciaController extends Controller
{

    /**
     * Devuelve la vista de todas las incidencias
     *
     * @param none no requiere de un parametro
     * @return mixed Devuelve una vista con todas las incidencias
     */
    public function index()
    {
        $incidencias = Incidencia::all();
        return view('incidencias.index', ['incidencias' => $incidencias]);
    }

     /**
     * Devuelve la vista en detalle de cada incidencia
     *
     * @param Incidencia objeto Incidencia
     * @return mixed Devuelve una vista de una incidencia concreta
     */
    public function show(Incidencia $incidencia)
    {
        return view('incidencias.show', ['incidencia' => $incidencia]);
    }
}
