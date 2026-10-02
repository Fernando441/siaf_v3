<?php

    use Illuminate\Support\Facades\Route;
    use Illuminate\Support\Facades\Http;

    // Listado De unidades
    Route::get('/listado', [App\Http\Controllers\Solicitud\SolicitudController::class, 'listado'])->name('solicitud.listado')->middleware('permission:unidad-list');
    Route::get('/nuevo', [App\Http\Controllers\Solicitud\SolicitudController::class, 'nuevo'])->name('solicitud.nuevo')->middleware('permission:unidad-list');
    Route::post('/guardar', [App\Http\Controllers\Solicitud\SolicitudController::class, 'guardar'])->name('solicitud.guardar')->middleware('permission:unidad-list');;
    Route::post('/datos-listado', [App\Http\Controllers\Solicitud\SolicitudController::class, 'datosListado'])->name('solicitud.datosListado')->middleware('permission:unidad-list');
    Route::get('/ver/{id}', [App\Http\Controllers\Solicitud\SolicitudController::class, 'ver'])->name('solicitud.ver')->middleware('permission:unidad-list');
    Route::post('/unidad-datos', [App\Http\Controllers\Solicitud\SolicitudController::class, 'unidadDatos'])->name('solicitud.unidadDatos')->middleware('permission:unidad-list');
    Route::get('/listado-validacion', [App\Http\Controllers\Solicitud\SolicitudController::class, 'listadoValidacion'])->name('solicitud.listadoValidacion')->middleware('permission:unidad-list');
    Route::get('/validacion/{id}', [App\Http\Controllers\Solicitud\SolicitudController::class, 'validacion'])->name('solicitud.validacion')->middleware('permission:unidad-list');
    Route::post('/guardar-validacion', [App\Http\Controllers\Solicitud\SolicitudController::class, 'guardarValidacion'])->name('solicitud.guardarValidacion')->middleware('permission:unidad-list');
    Route::get('/listado-proveedor', [App\Http\Controllers\Solicitud\SolicitudController::class, 'listadoProveedor'])->name('solicitud.listadoProveedor')->middleware('permission:unidad-list');
    Route::get('/programar-actividad/{id}', [App\Http\Controllers\Solicitud\SolicitudController::class, 'programarActividad'])->name('solicitud.programarActividad')->middleware('permission:unidad-list');
    Route::post('/datos-listado-proveedor', [App\Http\Controllers\Solicitud\SolicitudController::class, 'datosListadoProveedor'])->name('solicitud.datosListadoProveedor')->middleware('permission:unidad-list');
    Route::post('/unidad-datos-solicitud', [App\Http\Controllers\Solicitud\SolicitudController::class, 'unidadDatosSolicitud'])->name('solicitud.unidadDatosSolicitud')->middleware('permission:unidad-list');
    Route::post('/programar-actividad-detalle', [App\Http\Controllers\Solicitud\SolicitudController::class, 'guardarDetalle'])->name('solicitud.guardarDetalle')->middleware('permission:unidad-list');
    Route::get('/detalle-actividad/{id}', [App\Http\Controllers\Solicitud\SolicitudController::class, 'detalleActividad'])->name('solicitud.detalleActividad')->middleware('permission:unidad-list');
    Route::post('/guardar-actividad', [App\Http\Controllers\Solicitud\SolicitudController::class, 'guardarActividad'])->name('solicitud.guardarActividad')->middleware('permission:unidad-list');
    Route::get('/editar-detalle-actividad/{id}', [App\Http\Controllers\Solicitud\SolicitudController::class, 'EditarDetalleActividad'])->name('solicitud.EditarDetalleActividad')->middleware('permission:unidad-list');
    Route::get('/check-actividad/{id}', [App\Http\Controllers\Solicitud\SolicitudController::class, 'checkActividad'])->name('solicitud.checkActividad')->middleware('permission:unidad-list');
    Route::get('/validacion-actividad/{id}', [App\Http\Controllers\Solicitud\SolicitudController::class, 'validacionActividad'])->name('solicitud.validacionActividad')->middleware('permission:unidad-list');
    Route::post('/guardar-validacion-actividad', [App\Http\Controllers\Solicitud\SolicitudController::class, 'guardarValidacionActividad'])->name('solicitud.guardarValidacionActividad')->middleware('permission:unidad-list');
    Route::post('/validacion-archivo', [App\Http\Controllers\Solicitud\SolicitudController::class, 'validacionArchivo'])->name('solicitud.validacionArchivo')->middleware('permission:unidad-list');
    Route::delete('/validacion-archivo-eliminar', [App\Http\Controllers\Solicitud\SolicitudController::class, 'validacionArchivoEliminar'])->name('solicitud.validacionArchivoEliminar')->middleware('permission:unidad-list');
    Route::get('/validacion-archivo-listar/{id}', [App\Http\Controllers\Solicitud\SolicitudController::class, 'validacionArchivoListar'])->name('solicitud.validacionArchivoListar')->middleware('permission:unidad-list');
    Route::get('/validacion-archivo-ver/{id}', [App\Http\Controllers\Solicitud\SolicitudController::class, 'validacionArchivoVer'])->name('solicitud.validacionArchivoVer')->middleware('permission:unidad-list');