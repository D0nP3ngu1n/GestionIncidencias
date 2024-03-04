<?php

namespace App\Http\Controllers;

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
     * Devuelve la vista de todos los equipos
     *
     * @return mixed Devuelve una vista con todos  los equipos
     */
    public function index()
    {
        $equipos = Equipo::paginate(10);
        return view('equipos.index', ['equipos' => $equipos]);
    }
    /**
     * Devuelve la vista de detalle de un equipo
     *
     * @return mixed Devuelve la vista de detalle de un equipo
     */
    public function show(Equipo $equipo)
    {
        return view('equipos.show', ['equipo' => $equipo]);
    }


    /**
     * Devuelve la vista de crear de un equipo
     *
     * @return mixed Devuelve la vista de crear de un equipo
     */
    public function create()
    {
        //cogo todas las aulas para pasarselas a la vista de crear
        $aulas = Aula::all();
        $tipos = ['altavoces', 'impresora', 'monitor', 'pantalla interactiva', 'portátil de aula', 'portátil Consejería', 'proyector'];
        return view('equipos.create', ['aulas' => $aulas, 'tipos' => $tipos]);
    }
    public function store(CrearEquipoRequest $request)
    {
        try {
            //empiezo una transaccion por si al intentar crear el equipo falla algo poder volver atras
            DB::beginTransaction();

            $equipo = new Equipo();

            //si el request recibe el tipo vacio, da fallo
            if ($request->has('tipo_equipo') && $request->filled('tipo_equipo') && $request->tipo_equipo != '') {
                $equipo->tipo_equipo = $request->tipo_equipo;
            }
            //si el request recibe el aula_num vacio, da fallo
            if ($request->has('aula_num') && $request->filled('aula_num') && $request->aula_num != '') {
                $equipo->aula_num = $request->aula_num;
            }

            $equipo->fecha_adquisicion = $request->fecha_adquisicion;
            $equipo->etiqueta = $request->etiqueta;
            $equipo->marca = $request->marca;
            $equipo->modelo = $request->modelo;
            $equipo->puesto = $request->puesto;
            $equipo->descripcion = $request->descripcion;

            $equipo->save();
            DB::commit();
            return redirect()->route('equipos.show', ['equipo' => $equipo])->with('success', 'Equipo creado');
        } catch (PDOException $e) {

            DB::rollBack();
            return redirect()->route('equipos.index')->with('error', 'Error de base de datos al crear el Equipo. Detalles: ' . $e->getMessage());
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->route('equipos.index')->with('error', 'Error al crear el Equipo. Detalles: ' . $e->getMessage());
        }
    }

    public function edit(Equipo $equipo)
    {

        //cogo todas las aulas para pasarselas a la vista de crear
        $aulas = Aula::all();
        $tipos = ['altavoces', 'impresora', 'monitor', 'pantalla interactiva', 'portátil de aula', 'portátil Consejería', 'proyector'];

        return view('equipos.edit', ['equipo' => $equipo, 'aulas' => $aulas, 'tipos' => $tipos]);
    }

    public function update(Equipo $equipo,CrearEquipoRequest $request)
    {
        try {
            //empiezo una transaccion por si al intentar editar el equipo falla algo poder volver atras
            DB::beginTransaction();

            //si el request recibe el tipo vacio, da fallo
            if ($request->has('tipo_equipo') && $request->filled('tipo_equipo') && $request->tipo_equipo != '') {
                $equipo->tipo_equipo = $request->tipo_equipo;
            }
            //si el request recibe el aula_num vacio, da fallo
            if ($request->has('aula_num') && $request->filled('aula_num') && $request->aula_num != '') {
                $equipo->aula_num = $request->aula_num;
            }

            $equipo->fecha_adquisicion = $request->fecha_adquisicion;
            $equipo->etiqueta = $request->etiqueta;
            $equipo->marca = $request->marca;
            $equipo->modelo = $request->modelo;
            $equipo->puesto = $request->puesto;
            $equipo->descripcion = $request->descripcion;

            $equipo->save();
            DB::commit();
            return redirect()->route('equipos.show', ['equipo' => $equipo])->with('success', 'Equipo editado');
        } catch (PDOException $e) {

            DB::rollBack();
            return redirect()->route('equipos.index')->with('error', 'Error de base de datos al editar el Equipo. Detalles: ' . $e->getMessage());
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->route('equipos.index')->with('error', 'Error al editar el Equipo. Detalles: ' . $e->getMessage());
        }
    }

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
