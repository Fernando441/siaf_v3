<?php  
	use Illuminate\Support\Facades\Route;
	use Illuminate\Support\Facades\Http;

    //Listado de clientes
    	Route::get('/catalogo-clientes', [App\Http\Controllers\Cliente\ClienteController::class, 'catalogoCliente'])->name('cliente.catalogoCliente');
    	Route::post('/clientes-datatable', [App\Http\Controllers\Cliente\ClienteController::class, 'clientedatatable'])->name('cliente.clientedatatable');
        Route::post('/guardar-cliente', [App\Http\Controllers\Cliente\ClienteController::class, 'guardarCliente'])->name('cliente.guardarCliente');
        Route::post('/guardar-edicion-cliente', [App\Http\Controllers\Cliente\ClienteController::class, 'editarCliente'])->name('cliente.editarCliente');
        Route::get('/agregar-cliente', [App\Http\Controllers\Cliente\ClienteController::class, 'agregarCliente'])->name('cliente.agregarCliente');
        // Route::get('/eliminar-cliente/{id_cliente}', [App\Http\Controllers\Cliente\ClienteController::class, 'eliminarCliente'])->name('cliente.eliminarCliente');
        Route::get('/editar-cliente/{id_cliente}', [App\Http\Controllers\Cliente\ClienteController::class, 'vistaeditarCliente'])->name('cliente.vistaeditarCliente');
        Route::get('/catalogo-clientes-inactivos', [App\Http\Controllers\Cliente\ClienteController::class, 'catalogoClientesinactivos'])->name('cliente.catalogoClientesinactivos');
        Route::post('/elimianr-cliente', [App\Http\Controllers\Cliente\ClienteController::class, 'eliminarcliente'])->name('cliente.eliminarcliente');
        Route::post('/activar-cliente', [App\Http\Controllers\Cliente\ClienteController::class, 'activarcliente'])->name('cliente.activarcliente');
        Route::get('/ver-cliente/{id}', [App\Http\Controllers\Cliente\ClienteController::class, 'verCliente'])->name('cliente.vercliente');
        Route::post('/eliminar-documento-cliente', [App\Http\Controllers\Cliente\ClienteController::class, 'eliminardocumentocliente'])->name('cliente.eliminardocumentocliente');
        Route::post('/obtener-municipios', [App\Http\Controllers\Cliente\ClienteController::class, 'obtenermunicipios'])->name('cliente.obtenermunicipios');

    //Listado de estados
    	Route::get('/catalogo-estados', [App\Http\Controllers\Cliente\EstadoController::class, 'catalogoEstado'])->name('cliente.catalogoEstado');
    	Route::post('/estados-datatable', [App\Http\Controllers\Cliente\EstadoController::class, 'estadosdatatable'])->name('cliente.estadosdatatable');
    	Route::post('/guardar-estado', [App\Http\Controllers\Cliente\EstadoController::class, 'guardarEstado'])->name('cliente.guardarEstado');
    	 Route::post('/editar-estado', [App\Http\Controllers\Cliente\EstadoController::class, 'editarEstado'])->name('cliente.editarEstado');
    	Route::post('/desactivar-estado', [App\Http\Controllers\Cliente\EstadoController::class, 'eliminarEstado'])->name('cliente.eliminarEstado');
    	Route::get('/catalogo-estados-inactivos', [App\Http\Controllers\Cliente\EstadoController::class, 'catalogoestadosinactivos'])->name('cliente.estadosinactivos');
    	Route::post('/activar-estado', [App\Http\Controllers\Cliente\EstadoController::class, 'activarestado'])->name('cliente.activarestado');

    //Listado de municipios
    	Route::get('/catalogo-municipios', [App\Http\Controllers\Cliente\MunicipioController::class, 'catalogoMunicipio'])->name('cliente.catalogoMunicipio');
    	Route::post('/municipios-datatable', [App\Http\Controllers\Cliente\MunicipioController::class, 'municipiosdatatable'])->name('cliente.municipiosdatatable');
        Route::post('/guardar-municipio', [App\Http\Controllers\Cliente\MunicipioController::class, 'guardarMunicipio'])->name('cliente.guardarMunicipio');
        Route::get('/modificar-municipio/{municipio}', [App\Http\Controllers\Cliente\MunicipioController::class, 'modificarmunicipio'])->name('cliente.modificarmunicipio');
        Route::post('/editar-municipio', [App\Http\Controllers\Cliente\MunicipioController::class, 'editarMunicipio'])->name('cliente.editarMunicipio');
        Route::post('/desactivar-municipio', [App\Http\Controllers\Cliente\MunicipioController::class, 'eliminarMunicipio'])->name('cliente.eliminarMunicipio');
        Route::get('/catalogo-municipios-inactivos', [App\Http\Controllers\Cliente\MunicipioController::class, 'catalogoemunicipiosinactivos'])->name('cliente.municipiosinactivos');
        Route::post('/activar-municipio', [App\Http\Controllers\Cliente\MunicipioController::class, 'activarmunicipio'])->name('cliente.activarmunicipio');

    //Listado de Tipo de Documentos
        Route::get('/catalogo-documentos', [App\Http\Controllers\Cliente\DocumentosClienteController::class, 'catalogoDocumentos'])->name('doccliente.catalogoDocumentos');
        Route::post('/documentos-datatable', [App\Http\Controllers\Cliente\DocumentosClienteController::class, 'municipiosdatatable'])->name('doccliente.municipiosdatatable');
        Route::post('/guardar-tipo-documento', [App\Http\Controllers\Cliente\DocumentosClienteController::class, 'guardartipodocumento'])->name('doccliente.guardartipodocumento');
        Route::post('/editar-tipo-documento', [App\Http\Controllers\Cliente\DocumentosClienteController::class, 'editartipoDocumento'])->name('doccliente.editartipoDocumento');
        Route::post('/desactivar-cliente', [App\Http\Controllers\Cliente\DocumentosClienteController::class, 'eliminartipoDocumento'])->name('doccliente.eliminartipoDocumento');
        Route::get('/catalogo-tipodocumentos-inactivos', [App\Http\Controllers\Cliente\DocumentosClienteController::class, 'catalogoetipodocumentosinactivos'])->name('doccliente.tipodocumentosinactivos');
        Route::post('/activar-tipo-documento', [App\Http\Controllers\Cliente\DocumentosClienteController::class, 'activartipodocumento'])->name('doccliente.activartipodocumento');