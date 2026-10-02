<?php  
	use Illuminate\Support\Facades\Route;
	use Illuminate\Support\Facades\Http;

	// Listado De unidades
	Route::get('/catalogo-Unidad', [App\Http\Controllers\Unidad\SeminuevosController::class, 'catalogounidad'])->name('seminuevos.catalogo_vehi')->middleware('permission:unidad-list');
	Route::post('/unidad-datatable', [App\Http\Controllers\Unidad\SeminuevosController::class, 'unidaddatatable'])->name('seminuevos.unidaddatatable')->middleware('permission:unidad-list');
	Route::get('/ver-unidad/{unidad}', [App\Http\Controllers\Unidad\SeminuevosController::class, 'verUnidad'])->name('seminuevos.verunidad');
	Route::get('/venta-documento-pdf/{unidad}', [App\Http\Controllers\Unidad\SeminuevosController::class, 'ventaDocumentoPDF'])->name('seminuevos.ventaDocumentoPDF')->middleware('permission:unidad-list');
	Route::get('/catalogo-unidad-venta', [App\Http\Controllers\Unidad\SeminuevosController::class, 'catalogoUnidadVenta'])->name('seminuevos.catalogoUnidadVenta')->middleware('permission:unidad-venta');
	Route::post('/unidad-venta-datatable', [App\Http\Controllers\Unidad\SeminuevosController::class, 'unidadVentaDatatable'])->name('seminuevos.unidadVenta')->middleware('permission:unidad-venta');
	Route::get('/venta-ver-unidad/{unidad}', [App\Http\Controllers\Unidad\SeminuevosController::class, 'ventaFinalVer'])->name('seminuevos.VentaVerUnidadFinal');
	Route::get('/venta-final/{unidad}', [App\Http\Controllers\Unidad\SeminuevosController::class, 'ventaFinal'])->name('seminuevos.ventaFinal')->middleware('permission:unidad-venta');
    Route::post('/venta-final-guardar', [App\Http\Controllers\Unidad\SeminuevosController::class, 'ventaFinalGuardar'])->name('seminuevos.ventaFinalGuardar')->middleware('permission:unidad-venta');
    Route::post('/venta-final-cancelar', [App\Http\Controllers\Unidad\SeminuevosController::class, 'ventaFinalCancelar'])->name('seminuevos.ventaFinalCancelar')->middleware('permission:unidad-venta');
	Route::post('/venta-final-eliminar-documento', [App\Http\Controllers\Unidad\SeminuevosController::class, 'eliminarDocumento'])->name('seminuevos.eliminarDocumento');
	Route::post('/venta-apartar', [App\Http\Controllers\Unidad\SeminuevosController::class, 'apartar'])->name('seminuevos.apartar');
	Route::get('/catalogo-unidad-venta-apartado', [App\Http\Controllers\Unidad\SeminuevosController::class, 'catalogoUnidadVentaApartado'])->name('seminuevos.catalogoUnidadVentaApartado')->middleware('permission:unidad-venta');
	Route::get('/catalogo-unidad-apartado-editar/{unidad}', [App\Http\Controllers\Unidad\SeminuevosController::class, 'apartadoEditar'])->name('seminuevos.catalogoApartadoEditar')->middleware('permission:unidad-venta');
	Route::post('/catalogo-unidad-apartado-guardar', [App\Http\Controllers\Unidad\SeminuevosController::class, 'apartadoGuardar'])->name('seminuevos.catalogoApartadoGuardar')->middleware('permission:unidad-venta');
	Route::post('/catalogo-unidad-apartado-facturacion-guardar', [App\Http\Controllers\Unidad\SeminuevosController::class, 'apartadoFacturacionGuardar'])->name('seminuevos.catalogoApartadoFacturacionGuardar')->middleware('permission:unidad-venta');