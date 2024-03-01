<?php

use App\Http\Controllers\ComentarioController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\IncidenciaController;
use App\Http\Controllers\UserController;
use App\Models\Incidencia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::resource('incidencias', IncidenciaController::class)->middleware('auth');

Route::post('incidencias/filtrar', [IncidenciaController::class, 'filtrar'])->name('incidencias.filtrar')->middleware('auth');
Route::get('/descargar/{incidencia}', [IncidenciaController::class, 'descargarArchivo'])->name('descargar.archivo');
/*Parte para los comentarios*/
Route::get('incidencias/{incidencia}/crearComentario',  [ComentarioController::class, 'create'])->name('comentario.create')->middleware('auth');
Route::post('incidencias/{incidencia}',  [ComentarioController::class, 'store'])->name('comentario.store')->middleware('auth');
Route::delete('comentarios/{comentario}/eliminar',  [ComentarioController::class, 'destroy'])->name('comentario.destroy')->middleware('auth','role:Administrador');


//Route::get('exports', [ExportController::class, 'index'])->name('exports.index')->middleware('auth','role:Administrador');
//Route::get('exports/{incidencia}', [ExportController::class, 'show'])->name('exports.show')->middleware('auth','role:Administrador');
Route::post('exports', [ExportController::class, 'export'])->name('exports.export')->middleware('auth','role:Administrador');
Route::post('exports/pdf', [ExportController::class, 'exportpdf'])->name('exports.pdf')->middleware('auth','role:Administrador');
Route::post('exports/csv', [ExportController::class, 'exportcsv'])->name('exports.csv')->middleware('auth','role:Administrador');

Route::post('exports/{incidencia}', [ExportController::class, 'exportInc'])->name('exports.exportInc')->middleware('auth','role:Administrador');
Route::post('exports/{incidencia}/pdf', [ExportController::class, 'exportpdfInc'])->name('exports.exportpdfInc')->middleware('auth','role:Administrador');
Route::post('exports/{incidencia}/csv', [ExportController::class, 'exportcsvInc'])->name('exports.exportcsvInc')->middleware('auth','role:Administrador');

Route::prefix('/exports/informe')->group(function () {
    Route::get('/resueltas-admin', [ExportController::class, 'informeResueltasPorAdmin'])->name('export.informe.resueltas.admin');
    Route::get('/resueltas-admin/pdf', [ExportController::class, 'informeResueltasPorAdminPdf'])->name('export.informe.resueltas.admin.Pdf');
    Route::get('/resueltas-admin/csv', [ExportController::class, 'informeResueltasPorAdminCsv'])->name('export.informe.resueltas.admin.Csv');

    Route::get('/abiertas-usuario', [ExportController::class, 'informeAbiertasPorUsuario'])->name('export.informe.abiertas.usuario');
    Route::get('/abiertas-usuario/csv', [ExportController::class, 'informeAbiertasPorUsuarioCsv'])->name('export.informe.abiertas.usuario.Csv');
    Route::get('/abiertas-usuario/pdf', [ExportController::class, 'informeAbiertasPorUsuarioPdf'])->name('export.informe.abiertas.usuario.Pdf');

    Route::get('/estadisticas-tipos', [ExportController::class, 'informeEstadisticasTipos'])->name('export.informe.estadisticas.tipos');
    Route::get('/estadisticas-tipos/csv', [ExportController::class, 'informeEstadisticasTiposCsv'])->name('export.informe.estadisticas.tipos.Csv');
    Route::get('/estadisticas-tipos/pdf', [ExportController::class, 'informeEstadisticasTiposPdf'])->name('export.informe.estadisticas.tipos.Pdf');

    Route::get('/tiempo-dedicado', [ExportController::class, 'informeTiempoDedicadoPorIncidencia'])->name('export.informe.tiempo.dedicado');
    Route::get('/tiempo-dedicado/csv', [ExportController::class, 'informeTiempoDedicadoPorIncidenciaCsv'])->name('export.informe.tiempo.dedicado.Csv');
    Route::get('/tiempo-dedicado/pdf', [ExportController::class, 'informeTiempoDedicadoPorIncidenciaPdf'])->name('export.informe.tiempo.dedicado.Pdf');

    Route::get('/tiempos-resolucion-tipo', [ExportController::class, 'informeTiemposResolucionPorTipo'])->name('export.informe.tiempos.resolucion.tipo');
    Route::get('/tiempos-resolucion-tipo/csv', [ExportController::class, 'informeTiemposResolucionPorTipoCsv'])->name('export.informe.tiempos.resolucion.tipo.Csv');
    Route::get('/tiempos-resolucion-tipo/pdf', [ExportController::class, 'informeTiemposResolucionPorTipoPdf'])->name('export.informe.tiempos.resolucion.tipo.Pdf');

    Route::get('/tiempo-dedicado-e-incidencias-admin', [ExportController::class, 'informeTiempoDedicadoEIncidenciasPorAdministrador'])->name('export.informe.tiempo.dedicado.e.incidencias.admin');
    Route::get('/tiempo-dedicado-e-incidencias-admin/csv', [ExportController::class, 'informeTiempoDedicadoEIncidenciasPorAdministradorCsv'])->name('export.informe.tiempo.dedicado.e.incidencias.admin.Csv');
    Route::get('/tiempo-dedicado-e-incidencias-admin/pdf', [ExportController::class, 'informeTiempoDedicadoEIncidenciasPorAdministradorPdf'])->name('export.informe.tiempo.dedicado.e.incidencias.admin.Pdf');
});



Route::controller(UserController::class)->group(function () {
    Route::get('usuarios', 'index')->name('usuarios.index')->middleware('auth','role:Administrador');
    Route::get('usuarios/{usuario}', 'show')->name('usuarios.show')->middleware('auth');
    Route::get('usuarios/{usuario}/edit', 'edit')->name('usuarios.edit')->middleware('auth');
    Route::put('usuarios/{usuario}', 'update')->name('usuarios.update')->middleware('auth');
})->middleware('auth');

Route::get('/', function () {
    return redirect('/incidencias');
})->middleware('auth');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/', function () {
        if (auth()->check()) {
            return redirect()->route('incidencias.index');
        }
        return view('auth.login');
    })->name('dashboard');
});



Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
