<?php

namespace App\Http\Controllers;

use App\Exports\IncidenciaExport;
use App\Exports\IndenciasIndexExport;
use App\Http\Requests\CrearIncidenciaRequest;
use App\Http\Requests\EditarIncidenciaRequest;
use App\Mail\IncidenciaDeleteMail;
use App\Mail\IncidenciaMail;
use App\Mail\IncidenciaUpdateMail;
use App\Models\Aula;
use App\Models\Departamento;
use App\Models\Equipo;
use Illuminate\Http\Request;
use App\Models\Incidencia;
use App\Models\IncidenciaSubtipo;
use App\Models\User;
use Barryvdh\DomPDF\PDF;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
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
        $usuarios = User::all();
        $aulas = Aula::all();

        //saco el usuario logeado actualmente
        $user = auth()->user();

        //reviso que tipo de rol tiene y dependiendo de su rol solo le dejo ver sus incidencias o las de todos
        if ($user->hasRole('Profesor')) {
            $incidencias = Incidencia::where('creador_id', $user->id)->paginate(10); // 10 registros por página
        } else {
            $incidencias = Incidencia::paginate(10); // 10 registros por página
        }
        // $incidencias = Incidencia::paginate(10); // 10 registros por página

        return view('incidencias.index', ['incidencias' => $incidencias, 'aulas' => $aulas, 'usuarios' => $usuarios]);
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

        //saco el id del usuario logeado actualmente
        $user = auth()->user();

        if ($user->hasRole('Profesor')) {
            $query->where('creador_id', $user->id);
        } else {
            $query->where('creador_id', $user->id);
        }

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

        if ($request->has('aula') && $request->filled('aula')) {
            $incidencias = Incidencia::join('equipos', 'equipos.id', '=', 'incidencias.equipo_id')
                ->join('aulas', 'aulas.num', '=', 'equipos.aula_num')
                ->where('aulas.num', $request->aula);
            //where('aula', '=', $request->input('aula'));
        }



        if ($request->has('desde') && $request->has('hasta') && $request->filled('desde') && $request->filled('hasta')) {
            $desde = date($request->input('desde'));
            $hasta = date($request->input('hasta'));

            $query->whereBetween('fecha_creacion', [$desde, $hasta])->get();
        }


        $usuarios = User::all();
        $aulas = Aula::all();

        $incidencias = $query->paginate(10);

        return view('incidencias.index', ['incidencias' => $incidencias, 'aulas' => $aulas, 'usuarios' => $usuarios]);
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
        $aulas = Aula::all();
        $departamentos = Departamento::all();
        $equipos = Equipo::all();
        return view('incidencias.create', ['aulas' => $aulas, 'departamentos' => $departamentos, 'equipos' => $equipos]);
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
            //Recojo el usuario para pasar a las funciones del mail
            $usuario = User::where('id', $incidencia->creador_id)->first();
            //Recojo la incidencia antes de borrarla para pasarla al mail
            $incidenciaEliminada = $incidencia;
            $incidencia->delete();
            /*Con el usuario recogido anteriormente, en el to le indico donde envia el email,
            y en el send le mando el email configurado, pasando la vista y el usuario creador
            */
            Mail::to($usuario->email)->send(new IncidenciaDeleteMail($incidenciaEliminada, $usuario));
        } catch (PDOException $e) {
            return redirect()->route('incidencias.index')->with('error', 'Error al borrar la incidencia ' . $e->getMessage());
        }
        return redirect()->route('incidencias.index')->with('success', 'Incidencia borrada');
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

            if ($request->has('estado') && $request->filled('estado')) {
                $incidencia->estado = $request->estado;
            }
            if ($incidencia->estado == "cerrada") {
                $incidencia->fecha_cierre = Carbon::now();
            }
            if ($request->has('prioridad') && $request->filled('prioridad')) {
                $incidencia->prioridad = $request->prioridad;
            }

            if ($request->has('responsable') && $request->filled('responsable')) {
                $incidencia->responsable_id  = $request->responsable;
            }


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
            //Recojo el usuario para pasar a las funciones del mail
            $usuario = User::where('id', $incidencia->creador_id)->first();
            /*Con el usuario recogido anteriormente, en el to le indico donde envia el email,
            y en el send le mando el email configurado, pasando la vista y el usuario creador
            */
            Mail::to($usuario->email)->send(new IncidenciaUpdateMail($incidencia, $usuario));
            DB::commit();

            //si se crea correctamente redirigo a la pagina de la incidencia con un mensaje de succes
            return redirect()->route('incidencias.show', ['incidencia' => $incidencia])->with('success', 'Incidencia editada');
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
    public function store(CrearIncidenciaRequest $request)
    {
        try {
            //empiezo una transaccion por si al intentar crear la incidencia falla algo poder volver atras
            DB::beginTransaction();
            $incidencia = new Incidencia();

            $incidencia->tipo = $request->tipo;
            $incidencia->descripcion = $request->descripcion;
            $incidencia->estado = "abierta";
            $incidencia->fecha_creacion = Carbon::now();


            //si el usuario logueado no tiene email asociado, se le asocia el que introduzca en el formulario
            $usuario = User::where('id', auth()->user()->id)->first();

            if ($usuario->email == null) {
                $usuario->email = $request->correo_asociado;
                $usuario->save();
            }


            //si el usuario logueado no tiene departamento asociado, se le asocia el que introduzca en el formulario
            if ($usuario->departamento_id == null) {
                $usuario->departamento_id = $request->departamento;
                $usuario->save();
            }



            //el campo Creador id viene dado por el usuario actualmente logeado
            $incidencia->creador_id = auth()->user()->id;


            //si el request recibe un subtipo, buscamos el subtipo en la tabla subtipos y añadimos el id a la incidencia
            if ($request->has('subtipo') && $request->filled('subtipo')) {
                $subtipo = $request->subtipo;
                $sub_final = IncidenciaSubtipo::where('subtipo_nombre', $subtipo)->first()->id;
                $incidencia->subtipo_id = $sub_final;
            }

            //si el reuest recibe un sub-subtipo, buscamos el subtipo con los dos datos
            if ($request->has('sub-subtipo') && $request->filled('sub-subtipo')) {
                $subtipo = $request->subtipo;
                $sub_subtipo = $request->sub_subtipo;
                $sub_final = IncidenciaSubtipo::where('subtipo_nombre', $subtipo)->where('sub_subtipo', $sub_subtipo)->first()->id;
            }

            //si el request recibe el numero de etiqueta, buscamos el equipo segun la etiqueta que nos llega y lo añadimos el id a la incidencia
            if ($request->has('numero_etiqueta') && $request->filled('numero_etiqueta') && $request->numero_etiqueta != 'null') {
                $equipo_etiqueta = $request->numero_etiqueta;
                $equipo = Equipo::where('etiqueta', $equipo_etiqueta)->firstOrFail()->id;
                $incidencia->equipo_id = $equipo;
            }

            if ($request->hasFile('adjunto')) {
                //guardo el fichero y cojo su ruta para guardarla en la URL de la incidencia
                $url = 'assets/ficheros/' . $request->fichero->store('', 'ficheros');
                $incidencia->adjunto_url = $url;
            }

            $incidencia->save();
            /*Con el usuario recogido anteriormente, en el to le indico donde envia el email,
            y en el send le mando el email configurado, pasando la vista y el usuario
            */
            Mail::to($usuario->email)->send(new IncidenciaMail($incidencia, $usuario));
            DB::commit();
            return redirect()->route('incidencias.show', ['incidencia' => $incidencia])->with('success', 'Incidencia creada');
        } catch (Exception $ex) {
            DB::rollBack();
            // si no se completa la creacion borro el fichero que venia en el formulario de edicion
            Storage::disk('ficheros')->delete(substr($incidencia->adjunto_url, 16));


            return redirect()->route('incidencias.index')->with('error', 'Error al crear la incidencia. Detalles: ' . $ex->getMessage());
        } catch (PDOException $e) {
            DB::rollBack();
            // si no se completa la creacion borro el fichero que venia en el formulario de edicion
            Storage::disk('ficheros')->delete(substr($incidencia->adjunto_url, 16));
            return redirect()->route('incidencias.index')->with('error', 'Error al crear la incidencia. Detalles: ' . $e->getMessage());
        }
    }
}
