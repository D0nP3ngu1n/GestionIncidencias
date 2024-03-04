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

        return view('dashboard.index', ['incidencias' => $incidencias]);
    }
}
