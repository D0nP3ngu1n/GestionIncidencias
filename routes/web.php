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

Route::resource('incidencias', IncidenciaController::class);

Route::post('incidencias/filtrar', [IncidenciaController::class, 'filtrar'])->name('incidencias.filtrar');

Route::get('exports', [ExportController::class, 'index'])->name('exports.index');
Route::get('exports/{incidencia}', [ExportController::class, 'show'])->name('exports.show');
Route::post('exports', [ExportController::class, 'export'])->name('exports.export');
Route::post('exports/pdf', [ExportController::class, 'exportpdf'])->name('exports.pdf');
Route::post('exports/csv', [ExportController::class, 'exportcsv'])->name('exports.csv');

Route::post('exports/{incidencia}', [ExportController::class, 'exportInc'])->name('exports.exportInc');
Route::post('exports/{incidencia}/pdf', [ExportController::class, 'exportpdfInc'])->name('exports.exportpdfInc');
Route::post('exports/{incidencia}/csv', [ExportController::class, 'exportcsvInc'])->name('exports.exportcsvInc');



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
});

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
