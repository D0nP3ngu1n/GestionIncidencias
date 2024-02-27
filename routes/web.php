<?php

use App\Http\Controllers\IncidenciaController;
use App\Http\Controllers\UserController;
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

Route::controller(IncidenciaController::class)->group(function () {
    Route::get('incidencias', 'index')->name('incidencias.index');
    Route::get('incidencias/excel', 'exportarExcel')->name('incidencias.excel');
    Route::get('incidencias/csv', 'exportarCSV')->name('incidencias.csv');
    Route::get('incidencias/pdf', 'exportarPDF')->name('incidencias.pdf');
    Route::post('/incidencias/filtrar', 'filtrar')->name('incidencias.filtrar');
    Route::get('incidencias/create', 'create')->name('incidencias.create');
    Route::get('incidencias/{incidencia}', 'show')->name('incidencias.show');
    Route::get('incidencias/{incidencia}/edit', 'edit')->name('incidencias.edit');
    Route::post('incidencias/store', 'store')->name('incidencias.store');
    Route::put('incidencias/{incidencia}', 'update')->name('incidencias.update');
    Route::delete('incidencias/{incidencia}', 'destroy')->name('incidencias.destroy');
});

Route::controller(UserController::class)->group(function () {
    Route::get('usuarios', 'index')->name('usuarios.index');
    Route::get('usuarios/create', 'create')->name('usuarios.create');
    Route::get('usuarios/{usuario}', 'show')->name('usuarios.show');
    Route::get('usuarios/{usuario}/edit', 'edit')->name('usuarios.edit');
    Route::post('usuarios', 'store')->name('usuarios.store');
    Route::put('usuarios/{usuario}', 'update')->name('usuarios.update');
    Route::delete('usuarios/{usuario}', 'destroy')->name('usuarios.destroy');
});

Route::get('/', function () {
    return redirect('/incidencias');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
