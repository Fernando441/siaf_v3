<?php  
	use Illuminate\Support\Facades\Route;
	use Illuminate\Support\Facades\Http;

    //Listado de inventarios
    	Route::get('/catalogo-inventario', [App\Http\Controllers\Sistemas\InventarioComputoController::class, 'catalogoinventario'])->name('sistemas.catalogoinventario');
    	 Route::get('/agregar-registro', [App\Http\Controllers\Sistemas\InventarioComputoController::class, 'agregarRegistro'])->name('sistemas.agregarRegistro');
    	 Route::post('/guardar-registro', [App\Http\Controllers\Sistemas\InventarioComputoController::class, 'guardarRegistro'])->name('sistemas.guardarRegistro');
    	 Route::get('/editar-registro/{id}', [App\Http\Controllers\Sistemas\InventarioComputoController::class, 'editarRegistro'])->name('sistemas.editarRegistro');
    	 Route::post('/eliminar-evidencia', [App\Http\Controllers\Sistemas\InventarioComputoController::class, 'eliminarevidencia'])->name('sistemas.eliminarevidencia');
    	 Route::post('/update-registro', [App\Http\Controllers\Sistemas\InventarioComputoController::class, 'updateRegistro'])->name('sistemas.updateRegistro');
    	 Route::get('/ver-registro/{id}', [App\Http\Controllers\Sistemas\InventarioComputoController::class, 'verRegistro'])->name('sistemas.verRegistro');