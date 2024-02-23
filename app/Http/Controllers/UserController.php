<?php

namespace App\Http\Controllers;

use App\Http\Requests\crearUserRequest;
use App\Models\Departamento;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
    public function store(crearUserRequest $request)
    {
        try {
            //empiezo una transaccion por si al intentar crear la incidencia falla algo poder volver atras
            DB::beginTransaction();
            $usuario = new User();
            $usuario->nombreCompleto = $request->nombreCompleto;
            $usuario->email = $request->email;
            $usuario->password = $request->password;
            if ($usuario->departamento_id = null) {
                $usuario->departamento_id = $request->departamento_id;
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
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
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
    public function destroy(string $id)
    {
        //
    }
}
