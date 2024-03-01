<?php

namespace App\Http\Controllers;

use App\Models\Incidencia;
use Illuminate\Http\Request;

class DashController extends Controller
{
    /**
     * Devuelve la vista del dashboard
     *
     * @return mixed Devuelve una vista ¡¡
     */
    public function index()
    {

        $incidencias = Incidencia::all();


        // $incidencias = Incidencia::paginate(10); // 10 registros por página

        return view('dashboard.index', ['incidencias' => $incidencias]);
    }
}
