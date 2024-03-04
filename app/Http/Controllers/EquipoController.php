<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CrearEquipoRequest;
use App\Models\Aula;
use App\Models\Equipo;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDOException;

class EquipoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $equipos = Equipo::all();
        return view('equipos.index', ['equipos' => $equipos]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tipos = ['altavoces','impresora','monitor','pantalla interactiva','portátil de aula','portátil Consejería','proyector'];
        $aulas = Aula::all();
        return view('equipos.create',['aulas' => $aulas,'tipos' => $tipos]);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        try {
            //empiezo una transaccion por si al intentar crear el comentario falla algo poder volver atras
            DB::beginTransaction();

            $equipo = new Equipo();
            $equipo->tipo_equipo = $request->tipo_equipo;
            $equipo->fecha_adquisicion = $request->fecha_adquisicion;
            $equipo->etiqueta = $request->etiqueta;
            $equipo->marca = $request->marca;
            $equipo->descripcion = $request->descripcion;
            $equipo->baja = $request->baja;
            $equipo->aula_num = $request->aula_num;
            $equipo->puesto = $request->puesto;


            $equipo->save();
            DB::commit();
            //si se crea correctamente redirigo a la pagina de la incidencia con un mensaje de succes
            return redirect()->route('equipos.index')->with('success', 'equipo creado');
        } catch (PDOException $e) {
            DB::rollBack();
            return redirect()->route('equipos.index')->with('error', 'Error al crear el equipo ' . $e->getMessage());
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->route('equipos.show', ['equipo' => $equipo])->with('error', 'Error al crear el comentario ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Equipo $equipo)
    {
        return view('equipos.show',$equipo);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request,Equipo $equipo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Equipo $equipo)
    {
        try {
            $equipo->delete();

        } catch (PDOException $e) {
            return redirect()->route('equipos.index')->with('error', 'Error de base de datos al borrar el equipo ' . $e->getMessage());
        } catch (Exception $e) {
            return redirect()->route('equipos.index')->with('error', 'Error al borrar el equipo ' . $e->getMessage());
        }
        return redirect()->route('equipos.index')->with('success', 'Equipo borrado');

    }
}
