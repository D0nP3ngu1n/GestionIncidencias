<?php

namespace App\Http\Controllers;

use App\Http\Requests\CrearIncidenciaRequest;
use App\Http\Requests\EditarIncidenciaRequest;
use App\Models\Equipo;
use Illuminate\Http\Request;
use App\Models\Incidencia;
use App\Models\IncidenciaSubtipo;
use App\Models\Perfil;
use App\Models\Persona;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use PDOException;

class IncidenciaController extends Controller
{

    /**
     * Devuelve la vista de todas las incidencias
     *
     * @return mixed Devuelve una vista con todas las incidencias
     */
    public function index(Request $request)
    {
        // Obtener los datos del formulario de filtro
        $filtro_tipo = $request->input('filtro_tipo');
        $filtro_aula = $request->input('filtro_aula');
        $filtro_estado = $request->input('filtro_estado');
        $filtro_prioridad = $request->input('filtro_prioridad');

        // Aplicar los filtros a tus consultas de incidencias
        $query = Incidencia::query();

        if (!empty($filtro_tipo)) {
            $query->where('tipo', $filtro_tipo);
        }

        if (!empty($filtro_aula)) {
            $query->whereHas('equipo.aula', function ($query) use ($filtro_aula) {
                $query->where('codigo', $filtro_aula);
            });
        }

        if (!empty($filtro_estado)) {
            $query->where('estado', $filtro_estado);
        }

        if (!empty($filtro_prioridad)) {
            $query->where('prioridad', $filtro_prioridad);
        }

        // Obtener las incidencias filtradas
        $incidencias = $query->paginate(5);

        // Retornar la vista con las incidencias filtradas
        return view('incidencias.index', compact('incidencias'));
    }


    /**
     * Devuelve la vista en detalle para crear incidencia
     * @param Incidencia $incidencia objeto Incidencia
     * @return mixed Devuelve la vista para crear una incidencia
     */
    public function show(Incidencia $incidencia)
    {
        return view('incidencias.show', ['incidencia' => $incidencia]);
    }

    /**
     * Devuelve la vista en detalle de cada incidencia
     *
     * @return mixed Devuelve la vista para crear una incidencia
     */
    public function edit(Incidencia $incidencia)
    {
        return view('incidencias.edit', ['incidencia' => $incidencia]);
    }

    /**
     * Devuelve la vista para crear una incidencia
     *
     * @return mixed Devuelve una vista de una incidencia concreta
     */
    public function create()
    {
        return view('incidencias.create');
    }

    /**
     * Elimina una incidencia
     *
     * @param Incidencia $incidencia objeto Incidencia
     * @return mixed Elimina una incidencia concreta
     */
    public function destroy(Incidencia $incidencia)
    {
        try {
            $incidencia->delete();
        } catch (PDOException $e) {

            return redirect()->route('incidencias.index', ['Error' => "Error al borrar la incidencia " . $e->getMessage()]);
        }
        return redirect()->route('incidencias.index', ['Success' => "Incidencia borrada"]);
    }

    /**
     * Recoge los datos de un Request personalizado y modificar el objeto de tipo Incidencia que se el introduce por parametros
     * @param Incidencia $incidencia objeto Incidencia para editar
     * @param EditarIncidenciaRequest $request Request personalizado para editar la incidencia
     * @return mixed Devuelve la vista en detalle de la incidencia editada si es correcto o devuelve la vista de de todas las incidencias con un error si ha fallado la edicion
     */
    public function update(Incidencia $incidencia, EditarIncidenciaRequest $request)
    {
        try {
            //empiezo una transaccion por si al intentar editar la incidencia falla algo poder volver atras
            DB::beginTransaction();

            //modifico la incidencia que me pasan por parametros con lo que ha traido el request
            $incidencia->tipo = $request->tipo;
            $incidencia->subtipo_id = $request->subtipo_id;
            $incidencia->descripcion = $request->descripcion;
            $incidencia->estado = "abierta";

            //como el creado y el responsable solo pueden ser modificados por el profesor pero si por el administrador,
            // tengo que meter 2 if para controlarlo
            if ($request->creador_id)
                $incidencia->creador_id = $request->creador_id;

            if ($request->responsable_id)
                $incidencia->responsable_id = $request->responsable_id;

            //si en el edit me viene un fichero adjunto elimino el anterior y subo el nuevo ademas de guardar su URL
            if ($request->hasFile('adjunto')) {

                if ($request->fichero) {
                    //elimino el fichero anterior que tiene la incidencia
                    Storage::disk('ficheros')->delete(substr($incidencia->adjunto_url, 16));
                }

                //guardo el fichero y cojo su ruta para guardarla en la URL de la incidencia
                $url = 'assets/ficheros/' . $request->fichero->store('', 'ficheros');
                $incidencia->adjunto_url = $url;
            }

            $incidencia->save();
            DB::commit();
            //si se crea correctamente redirigo a la pagina de la incidencia con un mensaje de succes
            return redirect()->route('incidencias.show', ['incidencia' => $incidencia])->with('Success', 'Incidencia editada');
        } catch (PDOException $e) {
            DB::rollBack();
            // si no se completa la creacion borro el fichero que venia en el formulario de edicion
            Storage::disk('imagenes')->delete(substr($incidencia->adjunto_url, 16));

            return redirect()->route('incidencias.index')->with('Error', 'Error al editar la incidencia. Detalles: ' . $e->getMessage());
        }
    }

    /**
     * Recoge los datos de un Request personalizado y crea una Incidencia
     * @param crearIncidenciaRequest $request Request personalizado para crear la incidencia
     * @return mixed Devuelve la vista en detalle de la incidencia creada si es correcto o devuelve la vista de de todas las incidencias con un error si ha fallado la creacion
     * */
    public function store(CrearIncidenciaRequest $request)
    {
        try {
            //empiezo una transaccion por si al intentar crear la incidencia falla algo poder volver atras
            DB::beginTransaction();

            $incidencia = new Incidencia();

            $incidencia->tipo = $request->tipo;
            $incidencia->descripcion = $request->descripcion;
            $incidencia->estado = $request->estado;
            $incidencia->fecha_creacion = Carbon::now();
            //saco el subtipo que tenga el nombre de subtipo y de sub_subtipo que corresponda si existen
            $subtipo = $request->subtipo;
            $sub_subtipo = $request->sub_subtipo;
            $sub_final = IncidenciaSubtipo::where('subtipo_nombre', $subtipo)->where('sub_subtipo', $sub_subtipo);
            $incidencia->subtipo_id = $sub_final->id;
            //saco el perfil que tenga que ese correo, para sacar despues la id de la persona y todos sus datos
            $email = $request->correo_asociado;
            $perfil = $this->where('educantabria', $email)->first();
            $incidencia->creador_id = Perfil::where('dominio', $perfil->personal_id)->id;
            //saco el id del equipo segun la etiqueta que proporciona el formulario
            $equipo_etiqueta = $request->numero_etiqueta;
            $equipo = Equipo::where('etiqueta', $equipo_etiqueta)->id;
            $incidencia->equipo_id = $equipo;
            //si en el crear me viene un fichero adjunto elimino el anterior y subo el nuevo ademas de guardar su URL
            if ($request->hasFile('adjunto')) {
                //guardo el fichero y cojo su ruta para guardarla en la URL de la incidencia
                $url = 'assets/ficheros/' . $request->fichero->store('', 'ficheros');
                $incidencia->adjunto_url = $url;
            }

            $incidencia->save();
            DB::commit();
            //si se crea correctamente redirigo a la pagina de la incidencia con un mensaje de succes
            return redirect()->route('incidencias.show', ['incidencia' => $incidencia])->with('Success', 'Incidencia creada');
        } catch (PDOException $e) {
            DB::rollBack();
            // si no se completa la creacion borro el fichero que venia en el formulario de edicion
            Storage::disk('imagenes')->delete(substr($incidencia->adjunto_url, 16));

            return redirect()->route('incidencias.index')->with('Error', 'Error al crear la incidencia. Detalles: ' . $e->getMessage());
        }
    }
}
