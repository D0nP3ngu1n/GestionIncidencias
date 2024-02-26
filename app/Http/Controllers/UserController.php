<?php

namespace App\Http\Controllers;

use App\Http\Requests\CrearUserRequest;
use App\Http\Requests\EditarUserRequest;
use App\Models\Departamento;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use PDOException;

class UserController extends Controller
{
    /**
     * Devuelve la vista de todas los usuarios
     *
     * @return mixed Devuelve una vista con todos los usuarios
     */
    public function index()
    {
        $usuarios = User::paginate(6); // 10 registros por página
        return view('usuarios.index', ['usuarios' => $usuarios]);
    }

    /**
     * Devuelve la vista en para crear un usuario
     *
     * @return mixed Devuelve la vista para crear una incidencia
     */
    public function create()
    {
        $departamentos = Departamento::all();
        return view('usuarios.create', ['departamentos' => $departamentos]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CrearUserRequest $request)
    {
        try {
            //empiezo una transaccion por si al intentar crear al usuario falla algo poder volver atras
            DB::beginTransaction();
            $usuario = new User();
            $usuario->nombreCompleto = $request->nombreCompleto;
            $usuario->email = $request->email;
            $usuario->password = Hash::make($request->password);
            if ($usuario->departamento_id = null) {
                $usuario->departamento_id = $request->departamento_id;
            } else {
                $usuario->departamento_id = null;
            }
            $usuario->save();
            DB::commit();
            //si se crea correctamente redirigo a la pagina del usuario con un mensaje de success
            return redirect()->route('usuarios.show', ['usuario' => $usuario])->with('Success', 'usuario creado');
        } catch (PDOException $e) {
            DB::rollBack();

            return redirect()->route('usuarios.index')->with('Error', 'Error al crear el usuario. Detalles: ' . $e->getMessage());
        }
    }

    /**
     * Devuelve la vista en detalle para crear incidencia
     * @param User $usuario objeto User
     * @return mixed Devuelve la vista en detalle de una incidencia
     */
    public function show(User $usuario)
    {
        return view('usuarios.show', ['usuario' => $usuario]);
    }

    /**
     * Devuelve la vista para editar un usuario
     *
     * @return mixed Devuelve la vista para crear una incidencia
     */
    public function edit(User $usuario)
    {
        $departamentos = Departamento::all();
        $departamentoUsuario = Departamento::where('id', $usuario->departamento_id);
        return view('usuarios.edit', ['departamentos' => $departamentos, 'usuario' => $usuario, 'departamentoUsuario' => $departamentoUsuario]);
    }

    /**
     * Recoge los datos de un Request personalizado y modificar el objeto de tipo usuario que se el introduce por parametros
     * @param User $usuario objeto usuario para editar
     * @param EditarUserRequest $request Request personalizado para editar al usuario
     * @return mixed Devuelve la vista en detalle del usuario editado si es correcto o devuelve la vista de todos los usuarios con un error si ha fallado la edicion
     */
    public function update(EditarUserRequest $request, User $usuario)
    {
        try {
            //empiezo una transaccion por si al intentar crear al usuario falla algo poder volver atras
            DB::beginTransaction();
            $usuario->nombreCompleto = $request->nombreCompleto;
            $usuario->email = $request->email;
            $usuario->password = Hash::make($request->password);
            if ($usuario->departamento_id != null) {
                $usuario->departamento_id = $request->departamento_id;
            } else {
                $usuario->departamento_id = null;
            }
            $usuario->save();
            DB::commit();
            //si se crea correctamente redirigo a la pagina del usuario con un mensaje de success
            return redirect()->route('usuarios.show', ['usuario' => $usuario])->with('Success', 'usuario actualizado');
        } catch (PDOException $e) {
            DB::rollBack();

            return redirect()->route('usuarios.index')->with('Error', 'Error al actualizar el usuario. Detalles: ' . $e->getMessage());
        }
    }

    /**
     * Elimina un usuario
     *
     * @param User $usuario objeto User
     * @return mixed Elimina un usuario concreto
     */
    public function destroy(User $usuario)
    {
        try {
            $usuario->delete();
        } catch (PDOException $e) {

            return redirect()->route('usuarios.index', ['Error' => "Error al borrar el usuario " . $e->getMessage()]);
        }
        return redirect()->route('usuarios.index', ['Success' => "usuario borrado"]);
    }
}