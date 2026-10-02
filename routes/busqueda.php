<?php  
	use Illuminate\Support\Facades\Route;
	use Illuminate\Support\Facades\Http;

    Route::get('/index', [App\Http\Controllers\Busqueda\BusquedaController::class, 'index'])->name('busqueda.index');
    Route::post('/busqueda', [App\Http\Controllers\Busqueda\BusquedaController::class, 'busqueda'])->name('busqueda.busqueda');
    Route::post('/excel', [App\Http\Controllers\Busqueda\BusquedaController::class, 'excel'])->name('busqueda.excel');


    Route::get('/busqueda-seguros', [App\Http\Controllers\Busqueda\BusquedaController::class, 'busqseguros'])->name('busqueda.busqseguros');
    Route::post('/busqueda-aseguramiento', [App\Http\Controllers\Busqueda\BusquedaController::class, 'busquedaaseguramiento'])->name('busqueda.busquedaaseguramiento');
    Route::post('/excel', [App\Http\Controllers\Busqueda\BusquedaController::class, 'excelseguros'])->name('busqueda.excelseguros');
