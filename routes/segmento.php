<?php  
	use Illuminate\Support\Facades\Route;
	use Illuminate\Support\Facades\Http;
	
	// Listado de segmentos
		Route::get('/catalogo-segmentos', [App\Http\Controllers\Segmento\SegmentosController::class, 'listadosegmentos'])->name('segmento.catalogosegmentos');
		Route::post('/segmentos-datatable', [App\Http\Controllers\Segmento\SegmentosController::class, 'segmentodatatable'])->name('segmento.segmentodatatable');
		Route::get('/crear-segmento', [App\Http\Controllers\Segmento\SegmentosController::class, 'crearsegmento'])->name('segmento.crearsegmento');
		Route::post('/guardar-segmento', [App\Http\Controllers\Segmento\SegmentosController::class, 'guardarsegmento'])->name('segmento.guardarsegmento');
		Route::get('/editar-segmento/{segmento}', [App\Http\Controllers\Segmento\SegmentosController::class, 'editarsegmento'])->name('segmento.editarsegmento');
		Route::post('/modificar-segmento', [App\Http\Controllers\Segmento\SegmentosController::class, 'modificarsegmento'])->name('segmento.modificarsegmento');
		Route::post('/desactivar-segmento', [App\Http\Controllers\Segmento\SegmentosController::class, 'desactivarsegmento'])->name('segmento.desactivarsegmento');
		Route::get('/catalogo-segmentos-inactivos', [App\Http\Controllers\Segmento\SegmentosController::class, 'catalogosegmentosinactivos'])->name('segmento.catalogosegmentosinactivos');
		Route::post('/activar-segmento', [App\Http\Controllers\Segmento\SegmentosController::class, 'activarsegmento'])->name('segmento.activarsegmento');

	// Listado de tipo de vehiculos
		Route::get('/catalogo-tipovehiculos', [App\Http\Controllers\Segmento\TipoVehiculoController::class, 'listadotipovehiculos'])->name('tipovehiculo.catalotipovehiculo');
		Route::post('/tipovehiculos-datatable', [App\Http\Controllers\Segmento\TipoVehiculoController::class, 'tipovehiculodatatable'])->name('tipovehiculo.tipovehiculodatatable');
		Route::post('/guardar-tipovehiculo', [App\Http\Controllers\Segmento\TipoVehiculoController::class, 'guardartipovehiculo'])->name('tipovehiculo.guardartipovehiculo');
		Route::post('/editar-tipovehiculo', [App\Http\Controllers\Segmento\TipoVehiculoController::class, 'editartipovehiculo'])->name('tipovehiculo.editartipovehiculo');
		Route::post('/desactivar-tipovehiculo', [App\Http\Controllers\Segmento\TipoVehiculoController::class, 'desactivartipovehiculo'])->name('tipovehiculo.desactivartipovehiculo');
		Route::get('/catalogo-tiposvehiculos-inactivos', [App\Http\Controllers\Segmento\TipoVehiculoController::class, 'catalogotipovehiculoinactivos'])->name('tipovehiculo.catalogotipovehiculoinactivos');
		Route::post('/activar-tipovehiculo', [App\Http\Controllers\Segmento\TipoVehiculoController::class, 'activartipovehiculo'])->name('tipovehiculo.activartipovehiculo');

	// Listado de puertas
		Route::get('/catalogo-puertas', [App\Http\Controllers\Segmento\PuertaController::class, 'listadopuertas'])->name('puerta.catalopuertas');
		Route::post('/tipovehiculo-datatable', [App\Http\Controllers\Segmento\PuertaController::class, 'puertasdatatable'])->name('puerta.puertasdatatable');
		Route::post('/guardar-puertas', [App\Http\Controllers\Segmento\PuertaController::class, 'guardarpuertas'])->name('puerta.guardarpuertas');
		Route::post('/editar-puerta', [App\Http\Controllers\Segmento\PuertaController::class, 'editarpuerta'])->name('puerta.editarpuerta');
		Route::post('/desactivar-puerta', [App\Http\Controllers\Segmento\PuertaController::class, 'desactivarpuerta'])->name('puerta.desactivarpuerta');
		Route::get('/catalogo-puertas-inactivos', [App\Http\Controllers\Segmento\PuertaController::class, 'catalogopuertainactivos'])->name('puerta.catalogopuertainactivos');
		Route::post('/activar-puerta', [App\Http\Controllers\Segmento\PuertaController::class, 'activarpuerta'])->name('puerta.activarpuerta');

	// Listado de carroceria
		Route::get('/catalogo-carroceria', [App\Http\Controllers\Segmento\CarroceriaController::class, 'listadocarroceria'])->name('carroceria.catalogocarroceria');
		Route::post('/carroceria-datatable', [App\Http\Controllers\Segmento\CarroceriaController::class, 'carroceriadatatable'])->name('carroceria.carroceriadatatable');
		Route::post('/guardar-carroceria', [App\Http\Controllers\Segmento\CarroceriaController::class, 'guardarcarroceria'])->name('carroceria.guardarcarroceria');
		Route::post('/editar-carroceria', [App\Http\Controllers\Segmento\CarroceriaController::class, 'editarcarroceria'])->name('carroceria.editarcarroceria');
		Route::post('/desactivar-carroceria', [App\Http\Controllers\Segmento\CarroceriaController::class, 'desactivarcarroceria'])->name('carroceria.desactivarcarroceria');
		Route::get('/catalogo-carrocerias-inactivas', [App\Http\Controllers\Segmento\CarroceriaController::class, 'catalogocarroceriainactivas'])->name('carroceria.catalogocarroceriainactivos');
		Route::post('/activar-carroceria', [App\Http\Controllers\Segmento\CarroceriaController::class, 'activarcarroceria'])->name('carroceria.activarcarroceria');

	// Listado de No.Cilindros
		Route::get('/catalogo-no-cilindros', [App\Http\Controllers\Segmento\NoCilindrosController::class, 'listadonocilindros'])->name('nocilindros.catalogonocilindros');
		Route::post('/nocilindros-datatable', [App\Http\Controllers\Segmento\NoCilindrosController::class, 'nocilindrosdatatable'])->name('nocilindros.nocilindrosdatatable');
		Route::post('/guardar-no-cilindros', [App\Http\Controllers\Segmento\NoCilindrosController::class, 'guardarnocilindro'])->name('nocilindros.guardarnocilindro');
		Route::post('/editar-no-cilindro', [App\Http\Controllers\Segmento\NoCilindrosController::class, 'editarnocilindro'])->name('nocilindros.editarnocilindro');
		Route::post('/desactivar-no-cilindro', [App\Http\Controllers\Segmento\NoCilindrosController::class, 'desactivarnocilindro'])->name('nocilindros.desactivarnocilindro');
		Route::get('/catalogo-nocilindro-inactivas', [App\Http\Controllers\Segmento\NoCilindrosController::class, 'catalogonocilindroinactivas'])->name('nocilindros.catalogonocilindroinactivos');
		Route::post('/activar-no-cilindro', [App\Http\Controllers\Segmento\NoCilindrosController::class, 'activarnocilindro'])->name('nocilindros.activarnocilindro');

	// Listado de Cilindros
		Route::get('/catalogo-cilindros', [App\Http\Controllers\Segmento\CilindrosController::class, 'listadocilindros'])->name('cilindros.catalogocilindros');
		Route::post('/cilindros-datatable', [App\Http\Controllers\Segmento\CilindrosController::class, 'cilindrosdatatable'])->name('cilindros.cilindrosdatatable');
		Route::post('/guardar-cilindro', [App\Http\Controllers\Segmento\CilindrosController::class, 'guardarcilindro'])->name('cilindros.guardarcilindro');
		Route::post('/editar-cilindro', [App\Http\Controllers\Segmento\CilindrosController::class, 'editarcilindro'])->name('cilindros.editarcilindro');
		Route::post('/desactivar-cilindro', [App\Http\Controllers\Segmento\CilindrosController::class, 'desactivarcilindro'])->name('cilindros.desactivarcilindro');
		Route::get('/catalogo-cilindro-inactivos', [App\Http\Controllers\Segmento\CilindrosController::class, 'catalogocilindroinactivos'])->name('cilindros.catalogocilindroinactivos');
		Route::post('/activar-cilindro', [App\Http\Controllers\Segmento\CilindrosController::class, 'activarcilindro'])->name('cilindros.activarcilindro');

	// Listado de Pasajeros
		Route::get('/catalogo-pasajeros', [App\Http\Controllers\Segmento\PasajerosController::class, 'listadopasajeros'])->name('pasajero.catalogopasajeros');
		Route::post('/pasajeros-datatable', [App\Http\Controllers\Segmento\PasajerosController::class, 'pasajerodatatable'])->name('pasajero.pasajerodatatable');
		Route::post('/guardar-pasajeros', [App\Http\Controllers\Segmento\PasajerosController::class, 'guardarpasajero'])->name('pasajero.guardarpasajero');
		Route::post('/editar-pasajeros', [App\Http\Controllers\Segmento\PasajerosController::class, 'editarpasajero'])->name('pasajero.editarpasajero');
		Route::post('/desactivar-pasajero', [App\Http\Controllers\Segmento\PasajerosController::class, 'desactivarpasajero'])->name('pasajero.desactivarpasajero');
		Route::get('/catalogo-pasajeros-inactivos', [App\Http\Controllers\Segmento\PasajerosController::class, 'catalogopasajeroinactivos'])->name('pasajero.catalogopasajeroinactivos');
		Route::post('/activar-pasajero', [App\Http\Controllers\Segmento\PasajerosController::class, 'activarpasajero'])->name('pasajero.activarpasajero');

	// Listado de Motor
		Route::get('/catalogo-motor', [App\Http\Controllers\Segmento\MotorController::class, 'listadomotor'])->name('motor.catalogomotor');
		Route::post('/motor-datatable', [App\Http\Controllers\Segmento\MotorController::class, 'motordatatable'])->name('motor.motordatatable');
		Route::post('/guardar-motor', [App\Http\Controllers\Segmento\MotorController::class, 'guardarmotor'])->name('motor.guardarmotor');
		Route::post('/editar-motor', [App\Http\Controllers\Segmento\MotorController::class, 'editarmotor'])->name('motor.editarmotor');
		Route::post('/desactivar-motor', [App\Http\Controllers\Segmento\MotorController::class, 'desactivarmotor'])->name('motor.desactivarmotor');
		Route::get('/catalogo-motores-inactivos', [App\Http\Controllers\Segmento\MotorController::class, 'catalogomotorinactivos'])->name('motor.catalogomotorinactivos');
		Route::post('/activar-motor', [App\Http\Controllers\Segmento\MotorController::class, 'activarmotor'])->name('motor.activarmotor');

	// Listado de Llanta de refaccion
		Route::get('/catalogo-llanta-refaccion', [App\Http\Controllers\Segmento\LlantaRefaccionController::class, 'listadollantarefaccion'])->name('llantar.catalogollantarefaccion');
		Route::post('/llantarefaccion-datatable', [App\Http\Controllers\Segmento\LlantaRefaccionController::class, 'llantarefacciondatatable'])->name('llantar.llantarefacciondatatable');
		Route::post('/guardar-llanta', [App\Http\Controllers\Segmento\LlantaRefaccionController::class, 'guardarllantarefaccion'])->name('llantar.guardarllantarefaccion');
		Route::post('/editar-llanta-refaccion', [App\Http\Controllers\Segmento\LlantaRefaccionController::class, 'editarllantarefaccion'])->name('llantar.editarllantarefaccion');
		Route::post('/desactivar-llanta-refaccion', [App\Http\Controllers\Segmento\LlantaRefaccionController::class, 'desactivarllanta'])->name('llantar.desactivarllanta');
		Route::get('/catalogo-llantasrefaccion-inactivos', [App\Http\Controllers\Segmento\LlantaRefaccionController::class, 'catalogollantasinactivos'])->name('llantar.catalogollantasinactivos');
		Route::post('/activar-llanta-refaccion', [App\Http\Controllers\Segmento\LlantaRefaccionController::class, 'activarllanta'])->name('llantar.activarllanta');

	// Listado de Espejos laterales
		Route::get('/catalogo-espejos-laterales', [App\Http\Controllers\Segmento\EspejosLateralesController::class, 'listadoespejoslaterales'])->name('espejosl.catalogoespejoslaterales');
		Route::post('/espejoslaterales-datatable', [App\Http\Controllers\Segmento\EspejosLateralesController::class, 'espejoslateralesdatatable'])->name('espejosl.espejoslateralesdatatable');
		Route::post('/guardar-espejos-laterales', [App\Http\Controllers\Segmento\EspejosLateralesController::class, 'guardarespejoslaterales'])->name('espejosl.guardarespejoslaterales');
		Route::post('/editar-espejos-laterales', [App\Http\Controllers\Segmento\EspejosLateralesController::class, 'editarespejoslaterales'])->name('espejosl.editarespejoslaterales');
		Route::post('/desactivar-espejos-laterales', [App\Http\Controllers\Segmento\EspejosLateralesController::class, 'desactivarespejos'])->name('espejosl.desactivarespejos');
		Route::get('/catalogo-espejoslaterales-inactivos', [App\Http\Controllers\Segmento\EspejosLateralesController::class, 'catalogoespejosinactivos'])->name('espejosl.catalogoespejosinactivos');
		Route::post('/activar-espejos-laterales', [App\Http\Controllers\Segmento\EspejosLateralesController::class, 'activarespejos'])->name('espejosl.activarespejos');

	// Listado de Accesorios
		Route::get('/catalogo-accesorios', [App\Http\Controllers\Segmento\AccesoriosController::class, 'listadoaccesorios'])->name('accesorios.catalogoaccesorios');
		Route::post('/accesorios-datatable', [App\Http\Controllers\Segmento\AccesoriosController::class, 'accesoriosdatatable'])->name('accesorios.accesoriosdatatable');
		Route::post('/guardar-accesorio', [App\Http\Controllers\Segmento\AccesoriosController::class, 'guardaraccesorio'])->name('accesorios.guardaraccesorio');
		Route::post('/editar-accesorio', [App\Http\Controllers\Segmento\AccesoriosController::class, 'editaraccesorio'])->name('accesorios.editaraccesorio');
		Route::post('/desactivar-accesorio', [App\Http\Controllers\Segmento\AccesoriosController::class, 'desactivaraccesorios'])->name('accesorios.desactivaraccesorios');
		Route::get('/catalogo-accesorios-inactivos', [App\Http\Controllers\Segmento\AccesoriosController::class, 'catalogoaccesoriosinactivos'])->name('accesorios.catalogoaccesoriosinactivos');
		Route::post('/activar-accesorio', [App\Http\Controllers\Segmento\AccesoriosController::class, 'activaraccesorios'])->name('accesorios.activaraccesorios');

	// Listado de Potencia
		Route::get('/catalogo-potencia', [App\Http\Controllers\Segmento\PotenciaController::class, 'listadopotencia'])->name('potencia.catalogopotencia');
		Route::post('/potencia-datatable', [App\Http\Controllers\Segmento\PotenciaController::class, 'potenciadatatable'])->name('potencia.potenciadatatable');
		Route::post('/guardar-potencia', [App\Http\Controllers\Segmento\PotenciaController::class, 'guardarpotencia'])->name('potencia.guardarpotencia');
		Route::post('/editar-potencia', [App\Http\Controllers\Segmento\PotenciaController::class, 'editarpotencia'])->name('potencia.editarpotencia');
		Route::post('/desactivar-potencia', [App\Http\Controllers\Segmento\PotenciaController::class, 'desactivarpotencia'])->name('potencia.desactivarpotencia');
		Route::get('/catalogo-potencia-inactivos', [App\Http\Controllers\Segmento\PotenciaController::class, 'catalogopotenciainactivos'])->name('potencia.catalogopotenciainactivos');
		Route::post('/activar-potencia', [App\Http\Controllers\Segmento\PotenciaController::class, 'activarpotencia'])->name('potencia.activarpotencia');

	// Listado de Transmisión
		Route::get('/catalogo-transmision', [App\Http\Controllers\Segmento\TransmisionController::class, 'listadotransmision'])->name('transmision.catalogotransmision');
		Route::post('/transmision-datatable', [App\Http\Controllers\Segmento\TransmisionController::class, 'transmisiondatatable'])->name('transmision.transmisiondatatable');
		Route::post('/guardar-transmision', [App\Http\Controllers\Segmento\TransmisionController::class, 'guardartransmision'])->name('transmision.guardartransmision');
		Route::post('/editar-transmision', [App\Http\Controllers\Segmento\TransmisionController::class, 'editartransmision'])->name('transmision.editartransmision');
		Route::post('/desactivar-transmision', [App\Http\Controllers\Segmento\TransmisionController::class, 'desactivartransmision'])->name('transmision.desactivartransmision');
		Route::get('/catalogo-transmision-inactivos', [App\Http\Controllers\Segmento\TransmisionController::class, 'catalogotransmisioninactivos'])->name('transmision.catalogotransmisioninactivos');
		Route::post('/activar-transmision', [App\Http\Controllers\Segmento\TransmisionController::class, 'activartransmision'])->name('transmision.activartransmision');

	// Listado de Radio
		Route::get('/catalogo-radio', [App\Http\Controllers\Segmento\RadioController::class, 'listadoradio'])->name('radio.catalogoradio');
		Route::post('/radio-datatable', [App\Http\Controllers\Segmento\RadioController::class, 'radiodatatable'])->name('radio.radiodatatable');
		Route::post('/guardar-radio', [App\Http\Controllers\Segmento\RadioController::class, 'guardarradio'])->name('radio.guardarradio');
		Route::post('/editar-radio', [App\Http\Controllers\Segmento\RadioController::class, 'editarradio'])->name('radio.editarradio');
		Route::post('/desactivar-radio', [App\Http\Controllers\Segmento\RadioController::class, 'desactivarradio'])->name('radio.desactivarradio');
		Route::get('/catalogo-radio-inactivos', [App\Http\Controllers\Segmento\RadioController::class, 'catalogoradioinactivos'])->name('radio.catalogoradioinactivos');
		Route::post('/activar-radio', [App\Http\Controllers\Segmento\RadioController::class, 'activarradio'])->name('radio.activarradio');

	// Listado de Dirección
		Route::get('/catalogo-direccion', [App\Http\Controllers\Segmento\DireccionController::class, 'listadodireccion'])->name('direccion.catalogodireccion');
		Route::post('/direccion-datatable', [App\Http\Controllers\Segmento\DireccionController::class, 'direcciondatatable'])->name('direccion.direcciondatatable');
		Route::post('/guardar-direccion', [App\Http\Controllers\Segmento\DireccionController::class, 'guardardireccion'])->name('direccion.guardardireccion');
		Route::post('/editar-direccion', [App\Http\Controllers\Segmento\DireccionController::class, 'editardireccion'])->name('direccion.editardireccion');
		Route::post('/desactivar-direccion', [App\Http\Controllers\Segmento\DireccionController::class, 'desactivardireccion'])->name('direccion.desactivardireccion');
		Route::get('/catalogo-direccion-inactivos', [App\Http\Controllers\Segmento\DireccionController::class, 'catalogodireccioninactivos'])->name('direccion.catalogodireccioninactivos');
		Route::post('/activar-direccion', [App\Http\Controllers\Segmento\DireccionController::class, 'activardireccion'])->name('direccion.activardireccion');

	// Listado de Blindaje
		Route::get('/catalogo-blindaje', [App\Http\Controllers\Segmento\BlindajeController::class, 'listadoblindaje'])->name('blindaje.catalogoblindaje');
		Route::post('/blindaje-datatable', [App\Http\Controllers\Segmento\BlindajeController::class, 'blindajedatatable'])->name('blindaje.blindajedatatable');
		Route::post('/guardar-blindaje', [App\Http\Controllers\Segmento\BlindajeController::class, 'guardarblindaje'])->name('blindaje.guardarblindaje');
		Route::post('/editar-blindaje', [App\Http\Controllers\Segmento\BlindajeController::class, 'editarblindaje'])->name('blindaje.editarblindaje');
		Route::post('/desactivar-blindaje', [App\Http\Controllers\Segmento\BlindajeController::class, 'desactivarblindaje'])->name('blindaje.desactivarblindaje');
		Route::get('/catalogo-blindajes-inactivos', [App\Http\Controllers\Segmento\BlindajeController::class, 'catalogoblindajeinactivos'])->name('blindaje.catalogoblindajeinactivos');
		Route::post('/activar-blindaje', [App\Http\Controllers\Segmento\BlindajeController::class, 'activarblindaje'])->name('blindaje.activarblindaje');

	// Listado de Capacidad
		Route::get('/catalogo-capacidad', [App\Http\Controllers\Segmento\CapacidadController::class, 'listadocapacidad'])->name('capacidad.catalogocapacidad');
		Route::post('/capacidad-datatable', [App\Http\Controllers\Segmento\CapacidadController::class, 'capacidaddatatable'])->name('capacidad.capacidaddatatable');
		Route::post('/guardar-capacidad', [App\Http\Controllers\Segmento\CapacidadController::class, 'guardarcapacidad'])->name('capacidad.guardarcapacidad');
		Route::post('/editar-capacidad', [App\Http\Controllers\Segmento\CapacidadController::class, 'editarcapacidad'])->name('capacidad.editarcapacidad');
		Route::post('/desactivar-capacidad', [App\Http\Controllers\Segmento\CapacidadController::class, 'desactivarcapacidad'])->name('capacidad.desactivarcapacidad');
		Route::get('/catalogo-capacidad-inactiva', [App\Http\Controllers\Segmento\CapacidadController::class, 'catalogocapacidadinactivos'])->name('capacidad.catalogocapacidadinactivos');
		Route::post('/activar-capacidad', [App\Http\Controllers\Segmento\CapacidadController::class, 'activarcapacidad'])->name('capacidad.activarcapacidad');

	// Listado de GPS
		Route::get('/catalogo-gps', [App\Http\Controllers\Segmento\GpsController::class, 'listadogps'])->name('gps.catalogogps');
		Route::post('/capacidad-gps', [App\Http\Controllers\Segmento\GpsController::class, 'gpsdatatable'])->name('gps.gpsdatatable');
		Route::post('/guardar-gps', [App\Http\Controllers\Segmento\GpsController::class, 'guardargps'])->name('gps.guardargps');
		Route::post('/editar-gps', [App\Http\Controllers\Segmento\GpsController::class, 'editargps'])->name('gps.editargps');
		Route::post('/desactivar-gps', [App\Http\Controllers\Segmento\GpsController::class, 'desactivargps'])->name('gps.desactivargps');
		Route::get('/catalogo-gps-inactivo', [App\Http\Controllers\Segmento\GpsController::class, 'catalogogpsinactivos'])->name('gps.catalogogpsinactivos');
		Route::post('/activar-gps', [App\Http\Controllers\Segmento\GpsController::class, 'activargps'])->name('gps.activargps');

	// Listado de En Inventario JetVan
		Route::get('/catalogo-eninventario', [App\Http\Controllers\Segmento\EnInventarioController::class, 'listadoeninventario'])->name('inventario.catalogoeninventario');
		Route::post('/capacidad-eninventario', [App\Http\Controllers\Segmento\EnInventarioController::class, 'inventariodatatable'])->name('inventario.inventariodatatable');
		Route::post('/guardar-eninventario', [App\Http\Controllers\Segmento\EnInventarioController::class, 'guardarinventario'])->name('inventario.guardarinventario');
		Route::post('/editar-eninventario', [App\Http\Controllers\Segmento\EnInventarioController::class, 'editarinventario'])->name('inventario.editarinventario');
		Route::post('/desactivar-eninventario', [App\Http\Controllers\Segmento\EnInventarioController::class, 'desactivarinventario'])->name('inventario.desactivarinventario');
		Route::get('/catalogo-eninventario-inactivo', [App\Http\Controllers\Segmento\EnInventarioController::class, 'catalogoinventarioinactivos'])->name('inventario.catalogoinventarioinactivos');
		Route::post('/activar-eninventario', [App\Http\Controllers\Segmento\EnInventarioController::class, 'activarinventario'])->name('inventario.activarinventario');