<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Aula;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDOException;

class AulaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $aulas = Aula::all();
        return view('aulas.index', ['aulas' => $aulas]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('aulas.create');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $aula = new Aula();
            //empiezo una transaccion por si al intentar editar la incidencia falla algo poder volver atras
            DB::beginTransaction();

            if ($request->has('planta') && $request->filled('planta')) {
                $aula->planta = $request->planta;
            }

            if ($request->has('descripcion') && $request->filled('descripcion')) {
                $aula->descripcion = $request->descripcion;
            }

            if ($request->has('codigo') && $request->filled('codigo')) {
                $aula->codigo = $request->codigo;
            }
            $aula->save();


            DB::commit();
            return redirect()->route('aulas.show', ['aula' => $aula])->with('success', 'aula creada');

        } catch (PDOException $e) {
            DB::rollBack();
            return redirect()->route('aulas.index')->with('error', 'Error de base de datos al editar el aula. Detalles: ' . $e->getMessage());
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->route('aulas.index')->with('error', 'Error al editar el aula. Detalles: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Aula $aula)
    {
        return view('aulas.show', ['aula' => $aula]);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Aula $aula)
    {

        return view('aulas.edit', ['aula' => $aula]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Aula $aula)
    {
        try {
            //empiezo una transaccion por si al intentar editar la incidencia falla algo poder volver atras
            DB::beginTransaction();

            if ($request->has('planta') && $request->filled('planta')) {
                $aula->planta = $request->planta;
            }

            if ($request->has('descripcion') && $request->filled('descripcion')) {
                $aula->descripcion = $request->descripcion;
            }

            if ($request->has('codigo') && $request->filled('codigo')) {
                $aula->codigo = $request->codigo;
            }
            $aula->save();


            DB::commit();
            return redirect()->route('aulas.show', ['aula' => $aula])->with('success', 'aula editada');

        } catch (PDOException $e) {
            DB::rollBack();
            return redirect()->route('aulas.index')->with('error', 'Error de base de datos al editar el aula. Detalles: ' . $e->getMessage());
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->route('aulas.index')->with('error', 'Error al editar el aula. Detalles: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Aula $aula)
    {
        try {

            $aula->delete();
        } catch (PDOException $e) {
            return redirect()->route('aulas.index')->with('error', 'Error de base de datos al borrar la aula ' . $e->getMessage());
        } catch (Exception $e) {
            return redirect()->route('aulas.index')->with('error', 'Error al borrar el aula ' . $e->getMessage());
        }
        return redirect()->route('aulas.index')->with('success', 'Aula borrada');
    }
}
