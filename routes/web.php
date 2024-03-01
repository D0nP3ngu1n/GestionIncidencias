<?php

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

Route::get('exports', [ExportController::class, 'index'])->name('exports.index')->middleware('auth');
Route::get('exports/{incidencia}', [ExportController::class, 'show'])->name('exports.show')->middleware('auth');
Route::post('exports', [ExportController::class, 'export'])->name('exports.export')->middleware('auth');
Route::post('exports/pdf', [ExportController::class, 'exportpdf'])->name('exports.pdf')->middleware('auth');
Route::post('exports/csv', [ExportController::class, 'exportcsv'])->name('exports.csv')->middleware('auth');

Route::post('exports/{incidencia}', [ExportController::class, 'exportInc'])->name('exports.exportInc')->middleware('auth');
Route::post('exports/{incidencia}/pdf', [ExportController::class, 'exportpdfInc'])->name('exports.exportpdfInc')->middleware('auth');
Route::post('exports/{incidencia}/csv', [ExportController::class, 'exportcsvInc'])->name('exports.exportcsvInc')->middleware('auth');



Route::controller(UserController::class)->group(function () {
    Route::get('usuarios', 'index')->name('usuarios.index')->middleware('auth');
    Route::get('usuarios/create', 'create')->name('usuarios.create');
    Route::post('usuarios', 'store')->name('usuarios.store');
    Route::get('usuarios/{usuario}', 'show')->name('usuarios.show');
    Route::get('usuarios/{usuario}/edit', 'edit')->name('usuarios.edit')->middleware('auth');
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
