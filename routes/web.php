<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Tablero\TableroController;

use Illuminate\Support\Facades\Http;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', function () {
//    return view('welcome');
//});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');


//Tablero de control
// Route::controller(TableroController::class)->group(function () {
//     Route::get('/tablero', 'show')->name('tablero.show');
//     Route::get('/tablero/guardar', 'store')->name('tablero.store');

//     Route::get('/tablero/{licitacion}', 'vernotconcurso')->name('tablero.vernotconcurso');
// });

Route::get('/tablero', [App\Http\Controllers\Tablero\TableroController::class, 'show'])->name('tablero.show');

Route::get('/tablero/{licitacion?}', [App\Http\Controllers\Tablero\TableroController::class, 'vernotconcurso'])->name('tablero.vernotconcurso');

Route::post('/pendiente', [App\Http\Controllers\Tablero\TableroController::class, 'guardarpendiente'])->name('taller.guardarpendiente');

Route::get('/pendiente/{id}', [App\Http\Controllers\Tablero\TableroController::class, 'verpendiente'])->name('taller.verpendiente');

Route::post('/pendiente-finalizado', [App\Http\Controllers\Tablero\TableroController::class, 'pendientefinalizado'])->name('taller.pendientefinalizado');

Route::post('/pendiente-evidencia', [App\Http\Controllers\Tablero\TableroController::class, 'pendienteevidencia'])->name('taller.pendienteevidencia');

require __DIR__.'/auth.php';
