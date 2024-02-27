<?php

namespace App\Http\Controllers;

use App\Exports\IncidenciaExport;
use App\Exports\IndenciasIndexExport;
use App\Http\Requests\CrearIncidenciaRequest;
use App\Http\Requests\EditarIncidenciaRequest;
use App\Models\Equipo;
use Illuminate\Http\Request;
use App\Models\Incidencia;
use App\Models\IncidenciaSubtipo;
use App\Models\Perfil;
use App\Models\Persona;
use App\Models\User;
use Barryvdh\DomPDF\PDF;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use PDOException;

class IncidenciaController extends Controller
{

    /**
     * Devuelve la vista de todas las incidencias
     *
     * @return mixed Devuelve una vista con todas las incidencias
     */
    public function index()
    {
        //$incidencias = Incidencia::all();

        // Obtener todas las incidencias paginadas
        $incidencias = Incidencia::paginate(10); // 10 registros por página
        return view('incidencias.index', ['incidencias' => $incidencias]);
    }

    /**
     * Exportar excel de todas las incidencias
     *
     * @return mixed Devuelve un excel con todas las incidencias
     */


    /**
     * Metodo para filtrar las las incidencias
     * @param Request $request
     * @return mixed Devuelve una vista con todas las incidencias
     */
    public function filtrar(Request $request)
    {

        $query = Incidencia::query();

        // Filtrar por cada parámetro recibido
        if ($request->has('descripcion') && $request->filled('descripcion')) {
            $query->where('descripcion', 'like', '%' . $request->input('descripcion') . '%');
        }

        if ($request->has('tipo') && $request->filled('tipo')) {
            $query->where('tipo', 'like', '%' . $request->input('tipo') . '%');
        }

        if ($request->has('estado') && $request->filled('estado')) {
            $query->where('estado', 'like', '%' . $request->input('estado') . '%');
        }

        if ($request->has('creador') && $request->filled('creador')) {
            $query->join('users', 'incidencias.creador_id', '=', 'users.id')
                ->where('users.nombre_completo', 'LIKE', '%' . $request->input('creador') . '%');
        }

        if ($request->has('prioridad') && $request->filled('prioridad')) {
            $query->where('prioridad', 'like', '%' . $request->input('prioridad') . '%');
        }



        if ($request->has('desde') && $request->has('hasta') && $request->filled('desde') && $request->filled('hasta')) {
            $desde = date($request->input('desde'));
            $hasta = date($request->input('hasta'));

            $query->whereBetween('fecha_creacion', [$desde, $hasta])->get();
        }




        $incidencias = $query->paginate(10);

        return view('incidencias.index', ['incidencias' => $incidencias]);
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
        $usuarios = User::all();
        return view('incidencias.edit', ['incidencia' => $incidencia, 'usuarios' => $usuarios]);
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
            $incidencia->descripcion = $request->descripcion;

            $incidencia->estado = $request->estado;
            $incidencia->save();
            DB::commit();
            return redirect()->route('incidencias.show', ['incidencia' => $incidencia])->with('Success', 'Incidencia editada');
            $incidencia->estado = $request->prioridad;


            //como el creado y el responsable solo pueden ser modificados por el profesor pero si por el administrador,
            // tengo que meter 2 if para controlarlo
            if ($request->nombre)
                $nombre = $request->nombre;
            $perfil1 = User::where('email', $nombre)->firstOrFail()->id;
            $incidencia->creador_id = $perfil1;

            if ($request->responsable)
                $incidencia->responsable_id  = $request->responsable;




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


            //si se crea correctamente redirigo a la pagina de la incidencia con un mensaje de succes

        } catch (PDOException $e) {
            DB::rollBack();
            // si no se completa la creacion borro el fichero que venia en el formulario de edicion
            Storage::disk('ficheros')->delete(substr($incidencia->adjunto_url, 16));

            return redirect()->route('incidencias.index')->with('error', 'Error al editar la incidencia. Detalles: ' . $e->getMessage());
        }
    }

    /**
     * Recoge los datos de un Request personalizado y crea una Incidencia
     * @param crearIncidenciaRequest $request Request personalizado para crear la incidencia
     * @return mixed Devuelve la vista en detalle de la incidencia creada si es correcto o devuelve la vista de de todas las incidencias con un error si ha fallado la creacion
     * */
    /*public function store(CrearIncidenciaRequest $request)
    {
        try {
            //empiezo una transaccion por si al intentar crear la incidencia falla algo poder volver atras
            DB::beginTransaction();

            $incidencia = new Incidencia();

            $incidencia->tipo = $request->tipo;
            $incidencia->descripcion = $request->descripcion;
            $incidencia->estado = $request->estado;
            $incidencia->fecha_creacion = Carbon::now();

            //saco el perfil que tenga que ese correo, para sacar despues la id de la persona y todos sus datos
            $email = $request->correo_asociado;
            $perfil = User::where('email', $email)->firstOrFail()->id;
            $incidencia->creador_id = $perfil;

            //saco el subtipo que tenga el nombre de subtipo y de sub_subtipo que corresponda si existen,
            //hay que comprobar si subtipo existe pues el campo puede ser nulo

            $subtipo = $request->subtipo;
            $sub_subtipo = $request->sub_subtipo;
            $sub_final = IncidenciaSubtipo::where('subtipo_nombre', $subtipo)->where('sub_subtipo', $sub_subtipo)->first()->id;
            $incidencia->subtipo_id = $sub_final;


            //saco el id del equipo segun la etiqueta que proporciona el formulario
            //hay que comprobar si numero_etiqueta existe porque el campo puede ser nulo

            $equipo_etiqueta = $request->numero_etiqueta;
            $equipo = Equipo::where('etiqueta', $equipo_etiqueta)->firstOrFail()->id;
            $incidencia->equipo_id = $equipo;


            //si en el crear me viene un fichero adjunto elimino el anterior y subo el nuevo ademas de guardar su URL
            if ($request->hasFile('adjunto')) {
                //guardo el fichero y cojo su ruta para guardarla en la URL de la incidencia
                $url = 'assets/ficheros/' . $request->fichero->store('', 'ficheros');
                $incidencia->adjunto_url = $url;
            }

            $incidencia->estado = "abierta";

            $incidencia->save();
            DB::commit();
            //si se crea correctamente redirigo a la pagina de la incidencia con un mensaje de succes
            return redirect()->route('incidencias.show', ['incidencia' => $incidencia])->with('success', 'Incidencia creada');
        } catch (PDOException $e) {
            DB::rollBack();
            // si no se completa la creacion borro el fichero que venia en el formulario de edicion
            Storage::disk('ficheros')->delete(substr($incidencia->adjunto_url, 16));

            return redirect()->route('incidencias.index')->with('error', 'Error al crear la incidencia. Detalles: ' . $e->getMessage());
        }
    }*/
    public function store(CrearIncidenciaRequest $request)
    {
        try {
            DB::beginTransaction();
            $incidencia = new Incidencia();

            $incidencia->tipo = $request->tipo;
            $incidencia->descripcion = $request->descripcion;
            $incidencia->estado = "abierta";
            $incidencia->fecha_creacion = Carbon::now();


            $email = $request->correo_asociado;

            $incidencia->creador_id = $request->creador_id;

            $incidencia->save();
            DB::commit();

            return view('incidencias.index')->with('error', 'he llegado');
        } catch (PDOException $e) {
            DB::rollBack();
            // si no se completa la creacion borro el fichero que venia en el formulario de edicion
            Storage::disk('ficheros')->delete(substr($incidencia->adjunto_url, 16));

            return redirect()->route('incidencias.index')->with('error', 'Error al crear la incidencia. Detalles: ' . $e->getMessage());
        }
    }
}