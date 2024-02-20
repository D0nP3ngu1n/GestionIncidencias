<?php

namespace App\Http\Controllers;

use App\Http\Requests\crearPersonaRequest;
use App\Models\Persona;
use Illuminate\Http\Request;
use PDOException;

class PersonaController extends Controller
{
    /**
     * Metodo que devuelve la vista listado de las personas que forman el personal del centro
     *
     * @param none Este metodo no requiere de parametro
     * @return mixed devuelve un vista que muestra un listado de todo el personal
     */
    public function index()
    {
        $personal = Persona::all();
        return view('personal.index', ['pesonal' => $personal]);
    }

    /**
     * Metodo que devuelve la vista detalle de un miembro del personal mediante su dni
     *
     * @param string $persona, el dni de la persona que queremos mostrar
     * @return mixed devuelve la vista detalle de la persona seleccionada
     */
    public function show(string $persona)
    {
        $pers = Persona::where('DNI', $persona)->firstOrFail();
        return view('personal.show', ['persona' => $pers]);
    }

    /**
     * Metodo que devuelve la vista de creación de una persona
     *
     * @param none este metodo no requiere recibir parametros
     * @return mixed devuelve la vista de crecion de una persona
     */
    public function create()
    {
        return view('personal.create');
    }

    /**
     * Metodo que guarda en la base de datos un recurso nuevo del modelo persona
     *
     * @param request recibe una clase request en este caso CrearPersonaRequest para realizar las validadciones necesarias
     * @return mixed devuelve una redireccion a la vista detalle de la persona creada o un mensaje si se ha producido un error en la creación
     */
    public function store(crearPersonaRequest $request)
    {
        try {
            $pers = new Persona();
            $pers->dni = $request->dni;
            $pers->nombre = $request->nombre;
            $pers->apellido1 = $request->apellido1;
            $pers->apellido2 = $request->apellido2;
            $pers->direccion = $request->direccion;
            $pers->localidad = $request->localidad;
            $pers->cp = $request->cp;
            $pers->tlf = $request->tlf;
            $pers->activo = $request->activo;
            $pers->departamento_id->$request->departamento;
            $pers->save();
            return redirect()->route('personal.show', ['persona' => $pers->dni]);
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function update(ActualizarPersonaRequest $request, Persona $persona)
    {
        try {
            $persona->nombre = $request->nombre;
            $persona->apellido1 = $request->apellido1;
            $persona->apellido2 = $request->apellido2;
            $persona->direccion = $request->direccion;
            $persona->save();
        } catch (PDOException $ex) {
            return $ex->getMessage();
        }
    }
}
