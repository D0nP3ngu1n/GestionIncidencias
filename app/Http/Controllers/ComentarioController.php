<?php

namespace App\Http\Controllers;

use App\Models\Comentario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use PDOException;

class ComentarioController extends Controller
{
    public function store(CrearComentarioRequest $request){
        //id,texto,fechahora,incidencia_num,personal_id,adjunto_url

        try {
            //empiezo una transaccion por si al intentar crear la incidencia falla algo poder volver atras
            DB::beginTransaction();

            $comentario = new Comentario();

            $comentario->tipo = $request->texto;
            $comentario->subtipo_id = $request->fechahora;
            $comentario->descripcion = $request->incidencia_num;
            $comentario->estado = $request->personal_id;
            //si en el crear me viene un fichero adjunto elimino el anterior y subo el nuevo ademas de guardar su URL
            if ($request->hasFile('adjunto')) {

                //guardo el fichero y cojo su ruta para guardarla en la URL de la incidencia
                $url = 'assets/ficheros/' . $request->fichero->store('', 'ficheros');
                $comentario->adjunto_url = $url;
            }

            $comentario->save();
            DB::commit();
            //si se crea correctamente redirigo a la pagina de la incidencia con un mensaje de succes
            return redirect()->route('incidencias.show', ['incidencia' => $comentario->incidencia_num->incidencia()])->with('Success', 'Comentario creado');
        } catch (PDOException $e) {
            DB::rollBack();
            // si no se completa la creacion borro el fichero que venia en el formulario de edicion
            Storage::disk('imagenes')->delete(substr($comentario->adjunto_url, 16));

            return redirect()->route('incidencias.index')->with('Error', 'Error al crear el comentario. Detalles: ' . $e->getMessage());
        }
    }
}
