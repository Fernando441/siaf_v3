<?php
	use Illuminate\Support\Facades\Route;
	use Illuminate\Support\Facades\Http;



	// Listado de Unidades (Direccion comercial)  *Solo consulta
		Route::get('/inventario-comercial', [App\Http\Controllers\Licitacion\LicitacionController::class, 'inventariounidad'])->name('comercialinv.inventariocomercial');
		Route::post('/unidad-datatable-comercial', [App\Http\Controllers\Licitacion\LicitacionController::class, 'unidaddatatablecomercial'])->name('comercialinv.unidaddatatablecomercial');
		Route::get('/ver-info/{unidad}', [App\Http\Controllers\Licitacion\LicitacionController::class, 'verUnidad'])->name('comercialinv.verinfounod');