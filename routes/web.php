<?php

use App\Http\Controllers\ExportController;
use App\Http\Controllers\IncidenciaController;
use App\Http\Controllers\informeController;
use App\Http\Controllers\InformeController as ControllersInformeController;
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

Route::get('exports', [ExportController::class, 'index'])->name('exports.index')->middleware('auth');
Route::get('exports/{incidencia}', [ExportController::class, 'show'])->name('exports.show')->middleware('auth');
Route::post('exports', [ExportController::class, 'export'])->name('exports.export')->middleware('auth');
Route::post('exports/pdf', [ExportController::class, 'exportpdf'])->name('exports.pdf')->middleware('auth');
Route::post('exports/csv', [ExportController::class, 'exportcsv'])->name('exports.csv')->middleware('auth');

Route::post('exports/{incidencia}', [ExportController::class, 'exportInc'])->name('exports.exportInc')->middleware('auth');
Route::post('exports/{incidencia}/pdf', [ExportController::class, 'exportpdfInc'])->name('exports.exportpdfInc')->middleware('auth');
Route::post('exports/{incidencia}/csv', [ExportController::class, 'exportcsvInc'])->name('exports.exportcsvInc')->middleware('auth');

Route::prefix('/exports/informe')->group(function () {
    Route::get('/resueltas-admin', [InformeController::class, 'informeResueltasPorAdmin'])->name('export.informe.resueltas.admin');
    Route::get('/resueltas-admin/pdf', [InformeController::class, 'informeResueltasPorAdminPdf'])->name('export.informe.resueltas.admin.Pdf');
    Route::get('/resueltas-admin/csv', [InformeController::class, 'informeResueltasPorAdminCsv'])->name('export.informe.resueltas.admin.Csv');

    Route::get('/abiertas-usuario', [InformeController::class, 'informeAbiertasPorUsuario'])->name('export.informe.abiertas.usuario');
    Route::get('/abiertas-usuario/csv', [InformeController::class, 'informeAbiertasPorUsuarioCsv'])->name('export.informe.abiertas.usuario.Csv');
    Route::get('/abiertas-usuario/pdf', [InformeController::class, 'informeAbiertasPorUsuarioPdf'])->name('export.informe.abiertas.usuario.Pdf');

    Route::get('/estadisticas-tipos', [InformeController::class, 'informeEstadisticasTipos'])->name('export.informe.estadisticas.tipos');
    Route::get('/estadisticas-tipos/csv', [InformeController::class, 'informeEstadisticasTiposCsv'])->name('export.informe.estadisticas.tipos.Csv');
    Route::get('/estadisticas-tipos/pdf', [InformeController::class, 'informeEstadisticasTiposPdf'])->name('export.informe.estadisticas.tipos.Pdf');

    Route::get('/tiempo-dedicado', [InformeController::class, 'informeTiempoDedicadoPorIncidencia'])->name('export.informe.tiempo.dedicado');
    Route::get('/tiempo-dedicado/csv', [InformeController::class, 'informeTiempoDedicadoPorIncidenciaCsv'])->name('export.informe.tiempo.dedicado.Csv');
    Route::get('/tiempo-dedicado/pdf', [InformeController::class, 'informeTiempoDedicadoPorIncidenciaPdf'])->name('export.informe.tiempo.dedicado.Pdf');

    Route::get('/tiempos-resolucion-tipo', [InformeController::class, 'informeTiemposResolucionPorTipo'])->name('export.informe.tiempos.resolucion.tipo');
    Route::get('/tiempos-resolucion-tipo/csv', [InformeController::class, 'informeTiemposResolucionPorTipoCsv'])->name('export.informe.tiempos.resolucion.tipo.Csv');
    Route::get('/tiempos-resolucion-tipo/pdf', [InformeController::class, 'informeTiemposResolucionPorTipoPdf'])->name('export.informe.tiempos.resolucion.tipo.Pdf');

    Route::get('/tiempo-dedicado-e-incidencias-admin', [InformeController::class, 'informeTiempoDedicadoEIncidenciasPorAdministrador'])->name('export.informe.tiempo.dedicado.e.incidencias.admin');
    Route::get('/tiempo-dedicado-e-incidencias-admin/csv', [InformeController::class, 'informeTiempoDedicadoEIncidenciasPorAdministradorCsv'])->name('export.informe.tiempo.dedicado.e.incidencias.admin.Csv');
    Route::get('/tiempo-dedicado-e-incidencias-admin/pdf', [InformeController::class, 'informeTiempoDedicadoEIncidenciasPorAdministradorPdf'])->name('export.informe.tiempo.dedicado.e.incidencias.admin.Pdf');
});



Route::controller(UserController::class)->group(function () {
    Route::get('usuarios', 'index')->name('usuarios.index');
    Route::get('usuarios/create', 'create')->name('usuarios.create');
    Route::post('usuarios', 'store')->name('usuarios.store');
    Route::get('usuarios/{usuario}', 'show')->name('usuarios.show');
    Route::get('usuarios/{usuario}/edit', 'edit')->name('usuarios.edit');
    Route::put('usuarios/{usuario}', 'update')->name('usuarios.update');
    Route::delete('usuarios/{usuario}', 'destroy')->name('usuarios.destroy');
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
