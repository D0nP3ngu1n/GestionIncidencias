<?php

namespace App\Http\Controllers;

use App\Http\Requests\CrearComentarioRequest;
use App\Models\Comentario;
use App\Models\Incidencia;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use LogicException;
use PDOException;

class ComentarioController extends Controller
{

    /**
     * Devuelve la vista para crear un comentario
     *
     * @return mixed Devuelve una vista de una comentario concreta
     */
    public function create(Incidencia $incidencia)
    {
        return view('comentarios.create', ['incidencia' => $incidencia]);
    }

    public function store(CrearComentarioRequest $request, Incidencia $incidencia)
    {

        try {
            //empiezo una transaccion por si al intentar crear el comentario falla algo poder volver atras
            DB::beginTransaction();

            //relleno los campos del comentario con lo que viene por el request
            $comentario = new Comentario();
            $comentario->texto = $request->texto;
            //la fecha actual
            $comentario->fechaHora = Carbon::now();
            $comentario->incidencia_id = $incidencia->id;
            //el usuario logeado actualmente
            $comentario->users_id = auth()->user()->id;

            $comentario->save();
            DB::commit();
            //si se crea correctamente redirigo a la pagina de la incidencia con un mensaje de succes
            return redirect()->route('incidencias.show', ['incidencia' => $incidencia])->with('success', 'Comentario creado');
        } catch (PDOException $e) {
            DB::rollBack();
            return redirect()->route('incidencias.show', ['incidencia' => $incidencia])->with('error', 'Error al crear el comentario ' . $e->getMessage());
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->route('incidencias.show', ['incidencia' => $incidencia])->with('error', 'Error al crear el comentario ' . $e->getMessage());
        }
    }

    /**
     * Elimina un Comentario
     *
     * @param Comentario $Comentario objeto Comentario
     *
     * @return mixed Elimina una incidencia concreta
     */
    public function destroy(Comentario $comentario)
{
    $incidencia = DB::table('incidencias')->where('id', $comentario->incidencia_id)->first();

    try {
        $comentario->delete();
    } catch (PDOException $e) {
        return redirect()->route('incidencias.index')->with('error', 'Error de base de datos al borrar el comentario '.$e->getMessage());
    } catch (LogicException $e) {
        return redirect()->route('incidencias.index')->with('error', 'Error general al borrar el comentario '.$e->getMessage());
    }

    return redirect()->route('incidencias.show', ['incidencia' => $incidencia->id])->with('success', 'Comentario creado');
}

}
