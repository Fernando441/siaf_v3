"use strict";
var Principal = (function () {
    var routeName = $("#routeName").val();
    var routeUrl = $("#routeUrl").val();

    var showTititleWhenScroll = function () {
        $(window).scroll(function () {
            if ($(this).scrollTop() > 100) {
                $("#scroll_title").fadeIn();
            } else {
                $("#scroll_title").fadeOut();
            }
        });
    };

    var sidebarToggleActiveMenu = function () {
        //tablero
        if (routeName != "tablero.show") {
            $("#menuHome").removeClass("menu-item-active");
        }

        if (routeUrl.includes('tablero')) {
            $("#menuHome").addClass("menu-item-active menu-item-open");
        }

        //activar menu de Gerencia de Operaciones
        function activeMenuGerenciaOperaciones() {
            $("#menuGerenciaOperaciones").addClass("menu-item-active");
            $("#menuGerenciaOperaciones").addClass("menu-item-open");
        }

        //rutas para el menu de talleres
        if (routeName.includes("taller")) {
            activeMenuGerenciaOperaciones();
            //we addd the active class to the menuUsuarios parent item
            $("#menuTallerMantenimiento").addClass("menu-item-active");
            $("#menuTallerMantenimiento").addClass("menu-item-open");

            switch (routeName) {
                case "taller.solicitaratencion":
                    $("#menuTallerServiciosSolicitados").addClass("menu-item-open");
                    break;
                case "taller.buscarunidad":
                    $("#menuTallerSolicitarAtencion").addClass("menu-item-open");
                    break;
                case "taller.serviciossolicitados":
                    $("#menuTallerServiciosSolicitados").addClass("menu-item-open");
                    break;
                case "taller.asignarcontrato":
                    $("#menuTallerAsignarContrato").addClass("menu-item-open");
                    break;
                case "taller.asignartallerusuario":
                    $("#menuTallerAsignartallerUsuario").addClass("menu-item-open");
                    break;
                case "taller.catalogotalleres":
                    $("#menuTallerCatalogotalleres").addClass("menu-item-open");
                    break;
                case "taller.versolicitud":
                    $("#menuTallerServiciosSolicitados").addClass("menu-item-open");
                    break;
                case "taller.editarsolicitud":
                    $("#menuTallerServiciosSolicitados").addClass("menu-item-open");
                    break;
                case "taller.documentossolicitud":
                    $("#menuTallerServiciosSolicitados").addClass("menu-item-open");
                    break;
                case "taller.solicitaratencion":
                    $("#menuTallerServiciosSolicitados").addClass("menu-item-open");
                    break;
                case "taller.Validacionmantenimientos":
                    $("#menuTallerValidacionMantenimientos").addClass("menu-item-open");
                    break;
                case "taller.versolicitudvalidacion":
                    $("#menuTallerValidacionMantenimientos").addClass("menu-item-open");
                    break;
                case "taller.Validacionmantenimientosejecutivo":
                    $("#menuTallerValidacionMantenimientosEjecutivo").addClass("menu-item-open");
                    break;
                case "taller.versolicitudvalidacionejecutivo":
                    $("#menuTallerValidacionMantenimientosEjecutivo").addClass("menu-item-open");
                    break;
            }
        }




        //activar menu de Administracion
        function activeMenuAdministracion() {
            $("#menuAdministracion").addClass("menu-item-active");
            $("#menuAdministracion").addClass("menu-item-open");
        }

        //rutas para el menu de usuarios
        if (routeName.includes("user")) {
            activeMenuAdministracion();
            //we addd the active class to the menuUsuarios parent item
            $("#menuUsuarios").addClass("menu-item-active");
            $("#menuUsuarios").addClass("menu-item-open");

            switch (routeName) {
                case "user.catalogousuarios":
                    //we add the class 'menu-item-open' to id menuListadoUsuarios
                    $("#menuListadoUsuarios").addClass("menu-item-open");
                    break;
                case "user.agregarusuario":
                    $("#menuListadoUsuarios").addClass("menu-item-open");
                    break;
                case "user.verusuario":
                    $("#menuListadoUsuarios").addClass("menu-item-open");
                    break;
                case "user.usuariosinactivos":
                    $("#menuListadoUsuarios").addClass("menu-item-open");
                    break;
                case "user.editarusuario":
                    $("#menuListadoUsuarios").addClass("menu-item-open");
                    break;
            }
        }

        if (routeName.includes("rol")) {
            activeMenuAdministracion();
            $("#menuRoles").addClass("menu-item-active");
            $("#menuRoles").addClass("menu-item-open");
            switch (routeName) {
                case "rol.catalogoroles":
                    $("#menuListadoRoles").addClass("menu-item-open");
                    break;
                case "rol.modificarrol":
                    $("#menuListadoRoles").addClass("menu-item-open");
                    break;
                case "rol.agregarrol":
                    $("#menuListadoRoles").addClass("menu-item-open");
                    break;
                case "rol.rolesinactivos":
                    $("#menuListadoRoles").addClass("menu-item-open");
                    break;
                case "rol.agregarrol":
                    $("#menuNuevoRol").addClass("menu-item-open");
                    break;
                case "rol.agregarrol2":
                    $("#menuListadoRoles").addClass("menu-item-open");
                    break;
                case "rol.agregarPermisos2":
                    $("#menuListadoRoles").addClass("menu-item-open");
                    break;
                case "rol.modificarrol2":
                    $("#menuListadoRoles").addClass("menu-item-open");
                    break;
            }
        }

        //activar menu de Gerencia Comercial
        function activeMenuGerenciaComercial() {
            $("#menuGerenciaComercial").addClass("menu-item-active");
            $("#menuGerenciaComercial").addClass("menu-item-open");
        }

        //rutas para el menu de clientes
        if (routeName.includes("cliente")) {
            switch (routeName) {
                case "cliente.catalogoCliente":
                    activeMenuGerenciaComercial();
                    $("#menuCatalogoClientes").addClass("menu-item-active");
                    $("#menuCatalogoClientes").addClass("menu-item-open");
                    $("#menuListadoClientes").addClass("menu-item-open");
                    break;
                case "cliente.agregarCliente":
                    activeMenuGerenciaComercial();
                    $("#menuCatalogoClientes").addClass("menu-item-active");
                    $("#menuCatalogoClientes").addClass("menu-item-open");
                    $("#menuListadoClientes").addClass("menu-item-open");
                    break;
                case "cliente.vercliente":
                    activeMenuGerenciaComercial();
                    $("#menuCatalogoClientes").addClass("menu-item-active");
                    $("#menuCatalogoClientes").addClass("menu-item-open");
                    $("#menuListadoClientes").addClass("menu-item-open");
                    break;
                case "cliente.catalogoClientesinactivos":
                    activeMenuGerenciaComercial();
                    $("#menuCatalogoClientes").addClass("menu-item-active");
                    $("#menuCatalogoClientes").addClass("menu-item-open");
                    $("#menuListadoClientes").addClass("menu-item-open");
                    break;
                case "cliente.vistaeditarCliente":
                    activeMenuGerenciaComercial();
                    $("#menuCatalogoClientes").addClass("menu-item-active");
                    $("#menuCatalogoClientes").addClass("menu-item-open");
                    $("#menuListadoClientes").addClass("menu-item-open");
                    break;
            }
        }

        //rutas para el menu de Administracion Segmentos
        if (routeName.includes("segmento")) {
            activeMenuGerenciaComercial();
            $("#menuAdministracionSegmentos").addClass("menu-item-active");
            $("#menuAdministracionSegmentos").addClass("menu-item-open");
            switch (routeName) {
                case "segmento.catalogosegmentos":
                    $("#menuListadoSegmentos").addClass("menu-item-open");
                    break;
                case "segmento.crearsegmento":
                    $("#menuCrearSegmento").addClass("menu-item-open");
                    $("#menuListadoSegmentos").addClass("menu-item-open");
                    break;
                case "segmento.editarsegmento":
                    $("#menuListadoSegmentos").addClass("menu-item-open");
                    break;
                case "segmento.catalogosegmentosinactivos":
                    $("#menuListadoSegmentos").addClass("menu-item-open");
                    break;
            }
        }

        //rutas para el menu de parque vehicular comercial
        if (routeName.includes("comercial")) {
            activeMenuGerenciaComercial();
            $("#menuComercialInventario").addClass("menu-item-active");
            $("#menuComercialInventario").addClass("menu-item-open");
            switch (routeName) {
                case "comercialinv.inventariocomercial":
                    $("#menuListadoVehiculos").addClass("menu-item-open");
                    break;
                case "comercialinv.verinfounod":
                    $("#menuListadoVehiculos").addClass("menu-item-open");
                    break;
            }
        }

        //rutas para el menu de licitaciones
        if (routeName.includes("licitacion")) {
            activeMenuGerenciaComercial();
            $("#menuLicitaciones").addClass("menu-item-active");
            $("#menuLicitaciones").addClass("menu-item-open");
            switch (routeName) {
                case "licitacion.listadolicitaciones":
                    $("#menuControlLicitaciones").addClass("menu-item-open");
                    break;
                case "licitacion.agregarlicitacion":
                    $("#menuControlLicitaciones").addClass("menu-item-open");
                    break;
                case "licitacion.ver":
                    $("#menuControlLicitaciones").addClass("menu-item-open");
                    break;
                case "licitacion.editarlicitacion":
                    $("#menuControlLicitaciones").addClass("menu-item-open");
                    break;
                case "licitacion.agregar":
                    $("#menuControlLicitaciones").addClass("menu-item-open");
                    break;
                case "licitacion.agregarnuevo":
                    $("#menuControlLicitaciones").addClass("menu-item-open");
                    break;
                case "licitacion.catalogolicitacionesinactivas":
                    $("#menuControlLicitaciones").addClass("menu-item-open");
                    break;
                case "licitacion.informacionfinanzas":
                    $("#menuControlLicitaciones").addClass("menu-item-open");
                    break;
            }
        }

        if (routeName.includes("proposicioneconomica.crearproposicioneconomica")) {
            activeMenuGerenciaComercial();
            $("#menuLicitaciones").addClass("menu-item-active");
            $("#menuLicitaciones").addClass("menu-item-open");
            $("#menuControlLicitaciones").addClass("menu-item-open");
        }

        if (routeName.includes("propuestatecnica.crearpropuestatecnica")) {
            activeMenuGerenciaComercial();
            $("#menuLicitaciones").addClass("menu-item-active");
            $("#menuLicitaciones").addClass("menu-item-open");
            $("#menuControlLicitaciones").addClass("menu-item-open");
        }

        if (routeName.includes("propuestatecnica.propuestatecnicadoc")) {
            activeMenuGerenciaComercial();
            $("#menuLicitaciones").addClass("menu-item-active");
            $("#menuLicitaciones").addClass("menu-item-open");
            $("#menuControlLicitaciones").addClass("menu-item-open");
        }

        //rutas para el menu de requisiciones
        if (routeName.includes("requisiciones")) {
            activeMenuGerenciaComercial();
            $("#menuRequisiciones").addClass("menu-item-active");
            $("#menuRequisiciones").addClass("menu-item-open");
            switch (routeName) {
                case "requisiciones.nuevarequisicion":
                    $("#menuNuevaRequisicion").addClass("menu-item-open");
                    $("#menuListadoRequisiciones").addClass("menu-item-open");
                    break;
                case "requisiciones.catalogorequisicion":
                    $("#menuListadoRequisiciones").addClass("menu-item-open");
                    break;
                case "requisiciones.verrequisicion":
                    $("#menuListadoRequisiciones").addClass("menu-item-open");
                    break;
                case "requisiciones.verpartida":
                    $("#menuListadoRequisiciones").addClass("menu-item-open");
                    break;
                case "requisiciones.addinfopartidas":
                    $("#menuListadoRequisiciones").addClass("menu-item-open");
                    break;
                case "requisiciones.infopartida":
                    $("#menuListadoRequisiciones").addClass("menu-item-open");
                    break;
                case "requisiciones.editarrequisicion":
                    $("#menuListadoRequisiciones").addClass("menu-item-open");
                    break;
                case "requisiciones.catalogorequisicioninactivas":
                    $("#menuListadoRequisiciones").addClass("menu-item-open");
                    break;
                case "requisiciones.nuevarequisicion":
                    $("#menuListadoRequisiciones").addClass("menu-item-open");
                    break;
                case "concurso.requisiciones.catalogorequisicion":
                    $("#menuListadoRequisicionesContrato").addClass("menu-item-open");
                    break;
                case "concurso.requisiciones.verrequisicion":
                    $("#menuListadoRequisicionesContrato").addClass("menu-item-open");
                    break;
                case "concurso.requisiciones.verpartida":
                    $("#menuListadoRequisicionesContrato").addClass("menu-item-open");
                    break;
                case "concurso.requisiciones.addinfopartidas":
                    $("#menuListadoRequisicionesContrato").addClass("menu-item-open");
                    break;
                case "concurso.requisiciones.infopartida":
                    $("#menuListadoRequisicionesContrato").addClass("menu-item-open");
                    break;
            }
        }

        //activar menu de Gerencia de Administracion de Contratos
        function activeMenuGerenciaAdministracionContratos() {
            $("#menuGerenciaAdministracionContratos").addClass("menu-item-active");
            $("#menuGerenciaAdministracionContratos").addClass("menu-item-open");
        }

        //ruta para listado de contratos
        if (routeName.includes("proyecto")) {
            activeMenuGerenciaAdministracionContratos();
            $("#menuAdministracionContratos").addClass("menu-item-active");
            $("#menuAdministracionContratos").addClass("menu-item-open");
            switch (routeName) {
                case "proyecto.listadoproyectos":
                    $("#menuListadoContratos").addClass("menu-item-open");
                    break;
                case "proyecto.verproyecto":
                    $("#menuListadoContratos").addClass("menu-item-open");
                    break;
                case "proyecto.editarproyecto":
                    $("#menuListadoContratos").addClass("menu-item-open");
                    break;
                case "proyecto.asignarclientes":
                    $("#menuListadoContratos").addClass("menu-item-open");
                    break;
                case "proyecto.listadoproyectosinactivos":
                    $("#menuListadoContratos").addClass("menu-item-open");
                    break;
                case "solicitud.listado":
                    $("#menuListadoSolicitudes").addClass("menu-item-open");
                    break;
                case "solicitud.ver":
                    $("#menuListadoSolicitudes").addClass("menu-item-open");
                    break;
                    
            }
        }

        if (routeName.includes("estimaciones")) {
            activeMenuGerenciaAdministracionContratos();
            $("#menuAdministracionContratos").addClass("menu-item-active");
            $("#menuAdministracionContratos").addClass("menu-item-open");
            switch (routeName) {

                case "estimaciones.estimaciones":
                    $("#menuListadoContratos").addClass("menu-item-open");
                    break;
                case "estimaciones.verestimacion":
                    $("#menuListadoContratos").addClass("menu-item-open");
                    break;
                case "estimaciones.detalleestimacion":
                    $("#menuListadoContratos").addClass("menu-item-open");
                    break;
                    
            }
        }


        //ruta para menuInventarioVehiculos
        if (routeName.includes("unidad")) {
            activeMenuGerenciaOperaciones();
            switch (routeName) {
                case "unidad.catalogounidad":
                    $("#menuParqueVehicular").addClass("menu-item-active");
                    $("#menuParqueVehicular").addClass("menu-item-open");
                    $("#menuInventarioVehiculos").addClass("menu-item-open");
                    break;
                case "unidad.verunidad":
                    $("#menuParqueVehicular").addClass("menu-item-active");
                    $("#menuParqueVehicular").addClass("menu-item-open");
                    $("#menuInventarioVehiculos").addClass("menu-item-open");
                    break;
                case "unidad.agregarunidad":
                    $("#menuParqueVehicular").addClass("menu-item-active");
                    $("#menuParqueVehicular").addClass("menu-item-open");
                    $("#menuNuevoVehiculo").addClass("menu-item-open");
                    break;
                case "unidad.editarunidad":
                    $("#menuParqueVehicular").addClass("menu-item-active");
                    $("#menuParqueVehicular").addClass("menu-item-open");
                    $("#menuInventarioVehiculos").addClass("menu-item-open");
                    break;
                case "unidad.informacionseguro":
                    $("#menuParqueVehicular").addClass("menu-item-active");
                    $("#menuParqueVehicular").addClass("menu-item-open");
                    $("#menuInventarioVehiculos").addClass("menu-item-open");
                    break;
                case "unidad.informaciongps":
                    $("#menuParqueVehicular").addClass("menu-item-active");
                    $("#menuParqueVehicular").addClass("menu-item-open");
                    $("#menuInventarioVehiculos").addClass("menu-item-open");
                    break;
                case "unidad.tramitesvehiculares":
                    $("#menuParqueVehicular").addClass("menu-item-active");
                    $("#menuParqueVehicular").addClass("menu-item-open");
                    $("#menuInventarioVehiculos").addClass("menu-item-open");
                    break;
                case "traveh.tvemplacamiento":
                    $("#menuParqueVehicular").addClass("menu-item-active");
                    $("#menuParqueVehicular").addClass("menu-item-open");
                    $("#menuInventarioVehiculos").addClass("menu-item-open");
                    break;
                case "unidad.venta":
                    $("#menuParqueVehicular").addClass("menu-item-active");
                    $("#menuParqueVehicular").addClass("menu-item-open");
                    $("#menuInventarioVehiculos").addClass("menu-item-open");
                    break;
            }
        }

        var paths = [
            "unidad.catalogoUnidadVenta",
            "unidad.VentaVerUnidadFinal",
            "unidad.ventaFinal",
        ];
        if (contains(routeName, paths)) {
            console.log('ok1');
            activeMenuGerenciaOperaciones();
            $("#menuParqueVehicular").addClass("menu-item-active");
            $("#menuParqueVehicular").addClass("menu-item-open");
        }

        if (routeUrl.includes("unidad/tramite-vehicular-emplacamiento/{unidad}")) {
            activeMenuGerenciaOperaciones();
            $("#menuParqueVehicular").addClass("menu-item-active");
            $("#menuParqueVehicular").addClass("menu-item-open");
            $("#menuInventarioVehiculos").addClass("menu-item-open");
        }

        var paths = [
            "traveh.vistaveremplacamiento",
            "traveh.tvtenencia",
            "traveh.vistavertenencia",
            "traveh.vistagrdtenencia",
            "traveh.tvverificacion",
            "traveh.vistagrdverificacion",
            "traveh.vistaververificacion",
            "traveh.tvaseguramiento",
            "traveh.vistagrdaseguramiento",
            "traveh.vistaveraseguramiento",
            "traveh.tvbjventa",
            "traveh.vistaverbvventa",
            "traveh.vistaeditbvventa",
            "traveh.tvbjrobo",
            "traveh.vistaverbvrobo",
            "traveh.vistaeditbvrobo",
            "traveh.tvbjsiniestro",
            "traveh.vistagrbvsiniestro",
            "traveh.vistaverbvsiniestro",
            "traveh.tvreemplaca",
            "traveh.vistagrdreemplacamiento",
            "traveh.vistaverreemplacamiento",
            "traveh.tvcambiopro",
            "traveh.vistagrdcambiopro",
            "traveh.vistavercambiopro",
            "unidad.equipamientounidad",
            "unidad.catalogounidaddesinactivas"
        ];
        if (contains(routeName, paths)) {
            activeMenuGerenciaOperaciones();
            $("#menuParqueVehicular").addClass("menu-item-active");
            $("#menuParqueVehicular").addClass("menu-item-open");
            $("#menuInventarioVehiculos").addClass("menu-item-open");
        }

        //ruta para menuAsignacionUnidades
        if (routeName.includes("unidad")) {
            activeMenuGerenciaOperaciones();
            // console.log('ok2');
            switch (routeName) {
                case "asignarunidad.asignacioncontratos":
                    $("#asignacionunidades").addClass("menu-item-active");
                    $("#asignacionunidades").addClass("menu-item-open");
                    $("#asignarunid").addClass("menu-item-open");
                    break;
                case "asignarunidad.unidadescontrato":
                    $("#asignacionunidades").addClass("menu-item-active");
                    $("#asignacionunidades").addClass("menu-item-open");
                    $("#asignarunid").addClass("menu-item-open");
                    break;
                case "asignarunidad.asignarunidadespatio":
                    $("#asignacionunidades").addClass("menu-item-active");
                    $("#asignacionunidades").addClass("menu-item-open");
                    $("#asignarunid").addClass("menu-item-open");
                    break;
            }
        }

        //ruta para menuUnidadesSustitutas
        if (routeName.includes("unidad")) {
            activeMenuGerenciaOperaciones();
            // console.log('ok2');
            switch (routeName) {
                case "unidadessustitutas.listadounidadessustitutas":
                    $("#unidadessustitutas").addClass("menu-item-active");
                    $("#unidadessustitutas").addClass("menu-item-open");
                    $("#sustitutasid").addClass("menu-item-open");
                    break;
                case "unidadessustitutas.crearsolicutud":
                    $("#unidadessustitutas").addClass("menu-item-active");
                    $("#unidadessustitutas").addClass("menu-item-open");
                    $("#sustitutasid").addClass("menu-item-open");
                    break;
                case "unidadessustitutas.busquedaunidadbase":
                    $("#unidadessustitutas").addClass("menu-item-active");
                    $("#unidadessustitutas").addClass("menu-item-open");
                    $("#sustitutasid").addClass("menu-item-open");
                    break;
                case "unidadessustitutas.unidadbase":
                    $("#unidadessustitutas").addClass("menu-item-active");
                    $("#unidadessustitutas").addClass("menu-item-open");
                    $("#sustitutasid").addClass("menu-item-open");
                    break;
                case "unidadessustitutas.editarsolicitudsustitutos":
                    $("#unidadessustitutas").addClass("menu-item-active");
                    $("#unidadessustitutas").addClass("menu-item-open");
                    $("#sustitutasid").addClass("menu-item-open");
                    break;

                case "unidadessustitutas.listadosustitutologistica":
                    $("#unidadessustitutas").addClass("menu-item-active");
                    $("#unidadessustitutas").addClass("menu-item-open");
                    $("#sustitutasidrevision").addClass("menu-item-open");
                    break;
                case "unidadessustitutas.asignarsustituta":
                    $("#unidadessustitutas").addClass("menu-item-active");
                    $("#unidadessustitutas").addClass("menu-item-open");
                    $("#sustitutasidrevision").addClass("menu-item-open");
                    break;
            }
        }


        //ruta para menuControlSolicitudes
        if (routeName.includes("controlsol")) {
            activeMenuGerenciaOperaciones();
            switch (routeName) {
                case "controlsol.controlsolicitudes":
                    $("#menuConttolSol").addClass("menu-item-active");
                    $("#menuConttolSol").addClass("menu-item-open");
                    $("#menuListadoControlSolicitudes").addClass("menu-item-open");
                    break;
                case "controlsol.versolmantenimiento":
                    $("#menuConttolSol").addClass("menu-item-active");
                    $("#menuConttolSol").addClass("menu-item-open");
                    $("#menuListadoControlSolicitudes").addClass("menu-item-open");
                    break;
                case "controlsol.versolsustitutos":
                    $("#menuConttolSol").addClass("menu-item-active");
                    $("#menuConttolSol").addClass("menu-item-open");
                    $("#menuListadoControlSolicitudes").addClass("menu-item-open");
                    break;
                case "controlsol.versolasignacion":
                    $("#menuConttolSol").addClass("menu-item-active");
                    $("#menuConttolSol").addClass("menu-item-open");
                    $("#menuListadoControlSolicitudes").addClass("menu-item-open");
                    break;
                case "controlsol.versoltraslado":
                    $("#menuConttolSol").addClass("menu-item-active");
                    $("#menuConttolSol").addClass("menu-item-open");
                    $("#menuListadoControlSolicitudes").addClass("menu-item-open");
                    break;
                case "controlsol.versolgps":
                    $("#menuConttolSol").addClass("menu-item-active");
                    $("#menuConttolSol").addClass("menu-item-open");
                    $("#menuListadoControlSolicitudes").addClass("menu-item-open");
                    break;

            }
        }


        //ruta para menuAsignacionUnidades
        if (routeName.includes("movimientoslog")) {
            activeMenuGerenciaOperaciones();
            switch (routeName) {
                case "movimientoslog.listadomovimientos":
                    $("#menuListadoMovimientos").addClass("menu-item-active");
                    $("#menuListadoMovimientos").addClass("menu-item-open");
                    $("#menuListadoMovlista").addClass("menu-item-open");
                    break;
                case "movimientoslog.solicitudmovimiento":
                    $("#menuListadoMovimientos").addClass("menu-item-active");
                    $("#menuListadoMovimientos").addClass("menu-item-open");
                    $("#menuListadoMovlista").addClass("menu-item-open");
                    break;
                case "movimientoslog.asignarunidades":
                    $("#menuListadoMovimientos").addClass("menu-item-active");
                    $("#menuListadoMovimientos").addClass("menu-item-open");
                    $("#menuListadoMovlista").addClass("menu-item-open");
                    break;
                case "movimientoslog.editarsolicitud":
                    $("#menuListadoMovimientos").addClass("menu-item-active");
                    $("#menuListadoMovimientos").addClass("menu-item-open");
                    $("#menuListadoMovlista").addClass("menu-item-open");
                    break;
                case "movimientoslog.versolicitud":
                    $("#menuListadoMovimientos").addClass("menu-item-active");
                    $("#menuListadoMovimientos").addClass("menu-item-open");
                    $("#menuListadoMovlista").addClass("menu-item-open");
                    break;
                case "movimientoslog.verinfounidadtraslado":
                    $("#menuListadoMovimientos").addClass("menu-item-active");
                    $("#menuListadoMovimientos").addClass("menu-item-open");
                    $("#menuListadoMovlista").addClass("menu-item-open");
                    break;

            }
        }


        //ruta para menuAsignacionUnidades
        if (routeName.includes("transladistassol")) {
            activeMenuGerenciaOperaciones();
            switch (routeName) {
                case "transladistassol.listadomovimientostransladistas":
                    $("#menuListadoMovimientos").addClass("menu-item-active");
                    $("#menuListadoMovimientos").addClass("menu-item-open");
                    $("#menuListadoMovlistaTransladistas").addClass("menu-item-open");
                    break;
                case "transladistassol.unidadestranslado":
                    $("#menuListadoMovimientos").addClass("menu-item-active");
                    $("#menuListadoMovimientos").addClass("menu-item-open");
                    $("#menuListadoMovlistaTransladistas").addClass("menu-item-open");
                    break;
                case "transladistassol.inventarioentrega":
                    $("#menuListadoMovimientos").addClass("menu-item-active");
                    $("#menuListadoMovimientos").addClass("menu-item-open");
                    $("#menuListadoMovlistaTransladistas").addClass("menu-item-open");
                    break;
                    
                case "transladistassol.versolicitudtransladista":
                    $("#menuListadoMovimientos").addClass("menu-item-active");
                    $("#menuListadoMovimientos").addClass("menu-item-open");
                    $("#menuListadoMovlistaTransladistas").addClass("menu-item-open");
                    break;

            }
        }
        

        //ruta para menuAsignacionUnidades
        if (routeName.includes("transladooperador")) {
            activeMenuGerenciaOperaciones();
            switch (routeName) {
                case "transladooperador.listadotransladooperador":
                    $("#menuListadoMovimientos").addClass("menu-item-active");
                    $("#menuListadoMovimientos").addClass("menu-item-open");
                    $("#menuListadoMovlistaOperador").addClass("menu-item-open");
                    break;
                case "transladooperador.unidadestrasladooper":
                    $("#menuListadoMovimientos").addClass("menu-item-active");
                    $("#menuListadoMovimientos").addClass("menu-item-open");
                    $("#menuListadoMovlistaOperador").addClass("menu-item-open");
                    break;
                case "transladooperador.inventarioentregaoperador":
                    $("#menuListadoMovimientos").addClass("menu-item-active");
                    $("#menuListadoMovimientos").addClass("menu-item-open");
                    $("#menuListadoMovlistaOperador").addClass("menu-item-open");
                    break;

            }
        }



        //ruta para menuInventarioVehiculos
        if (routeName.includes("gestordocumentos")) {
            activeMenuGerenciaComercial();
            $("#menuGestorDocumentos").addClass("menu-item-active");
            $("#menuGestorDocumentos").addClass("menu-item-open");
            switch (routeName) {
                case "gestordocumentos.catalogodocumento":
                    $("#menuListadoDocumentos").addClass("menu-item-active");
                    $("#menuListadoDocumentos").addClass("menu-item-open");
                    break;
            }
        }


        if (routeName.includes("reqcompras")) {
            switch (routeName) {
                case "reqcompras.reqcompras":
                    activeMenuGerenciaComercial();
                    $("#menuReqCompras").addClass("menu-item-active");
                    $("#menuReqCompras").addClass("menu-item-open");
                    $("#menuListadoReqCompras").addClass("menu-item-open");
                    $("#menuListadoReqCompras").addClass("menu-item-open");
                    break;

                case "reqcompras.creaarreqcompras":
                    activeMenuGerenciaComercial();
                    $("#menuReqCompras").addClass("menu-item-active");
                    $("#menuReqCompras").addClass("menu-item-open");
                    $("#menuListadoReqCompras").addClass("menu-item-open");
                    $("#menuListadoReqCompras").addClass("menu-item-open");
                    break;
                case "reqcompras.verreqcompras":
                    activeMenuGerenciaComercial();
                    $("#menuReqCompras").addClass("menu-item-active");
                    $("#menuReqCompras").addClass("menu-item-open");
                    $("#menuListadoReqCompras").addClass("menu-item-open");
                    $("#menuListadoReqCompras").addClass("menu-item-open");
                    break;

                    
                case "reqcompras.editarreqcompras":
                    activeMenuGerenciaComercial();
                    $("#menuReqCompras").addClass("menu-item-active");
                    $("#menuReqCompras").addClass("menu-item-open");
                    $("#menuListadoReqCompras").addClass("menu-item-open");
                    $("#menuListadoReqCompras").addClass("menu-item-open");
                    break;

                case "reqcompras.reqrevisioncompras":
                    activeMenuGerenciaComercial();
                    $("#menuReqCompras").addClass("menu-item-active");
                    $("#menuReqCompras").addClass("menu-item-open");
                    $("#menuListadoRevisionReqCompras").addClass("menu-item-open");
                    $("#menuListadoRevisionReqCompras").addClass("menu-item-open");
                    break;

                case "reqcompras.revisioncomprasver":
                    activeMenuGerenciaComercial();
                    $("#menuReqCompras").addClass("menu-item-active");
                    $("#menuReqCompras").addClass("menu-item-open");
                    $("#menuListadoRevisionReqCompras").addClass("menu-item-open");
                    $("#menuListadoRevisionReqCompras").addClass("menu-item-open");
                    break;                    
            }
        }



        function activeMenuGerenciaFinanzas() {
            $("#menuGerenciaFinanzas").addClass("menu-item-active");
            $("#menuGerenciaFinanzas").addClass("menu-item-open");
        }

        if (routeName.includes("finanzas")) {
            switch (routeName) {
                case "finanzas.catalogorequisicion":
                    activeMenuGerenciaFinanzas();
                    $("#menuRequisicionesFinanzas").addClass("menu-item-active");
                    $("#menuRequisicionesFinanzas").addClass("menu-item-open");
                    $("#menuListadoRequisicionesFinanzas").addClass("menu-item-open");
                    break;
                case "requisiciones.catalogorequisicion":
                    activeMenuGerenciaFinanzas();
                    $("#menuRequisicionesFinanzas").addClass("menu-item-active");
                    $("#menuRequisicionesFinanzas").addClass("menu-item-open");
                    $("#menuListadoRequisicionesFinanzas").addClass("menu-item-open");
                    break;
                case "finanzas.verrequisicion":
                    activeMenuGerenciaFinanzas();
                    $("#menuRequisicionesFinanzas").addClass("menu-item-active");
                    $("#menuRequisicionesFinanzas").addClass("menu-item-open");
                    $("#menuListadoRequisicionesFinanzas").addClass("menu-item-open");
                    break;
                case "finanzas.verpartida":
                    activeMenuGerenciaFinanzas();
                    $("#menuRequisicionesFinanzas").addClass("menu-item-active");
                    $("#menuRequisicionesFinanzas").addClass("menu-item-open");
                    $("#menuListadoRequisicionesFinanzas").addClass("menu-item-open");
                    break;
                case "finanzas.ordencompra":
                    activeMenuGerenciaFinanzas();
                    $("#menuRequisicionesFinanzas").addClass("menu-item-active");
                    $("#menuRequisicionesFinanzas").addClass("menu-item-open");
                    $("#menuListadoRequisicionesFinanzas").addClass("menu-item-open");
                    break;
                case "finanzas.verordenpendiente":
                    activeMenuGerenciaFinanzas();
                    $("#menuRequisicionesFinanzas").addClass("menu-item-active");
                    $("#menuRequisicionesFinanzas").addClass("menu-item-open");
                    $("#menuListadoRequisicionesFinanzas").addClass("menu-item-open");
                    break;
            }
        }

        if (routeName.includes("ordencompra")) {
            switch (routeName) {
                case "ordencompra.catalogoordencompra":
                    activeMenuGerenciaFinanzas();
                    $("#menuCatalogoOrdenCompraFin").addClass("menu-item-active");
                    $("#menuCatalogoOrdenCompraFin").addClass("menu-item-open");
                    $("#menuListadoOrdenCompra").addClass("menu-item-open");
                    break;
                case "ordencompra.verordenpago":
                    activeMenuGerenciaFinanzas();
                    $("#menuCatalogoOrdenCompraFin").addClass("menu-item-active");
                    $("#menuCatalogoOrdenCompraFin").addClass("menu-item-open");
                    $("#menuListadoOrdenCompra").addClass("menu-item-open");
                    break;
            }
        }

        if (routeName.includes("ordenpago")) {
            switch (routeName) {
                case "requisiciones.catalogorequisicion":
                    activeMenuGerenciaFinanzas();
                    $("#menuRequisicionesFinanzas").addClass("menu-item-active");
                    $("#menuRequisicionesFinanzas").addClass("menu-item-open");
                    $("#menuListadoRequisicionesFinanzas").addClass("menu-item-open");
                    break;
            }
        }

        if (routeName.includes("estimacionesfin")) {
            switch (routeName) {
                case "estimacionesfin.catalogoestimaciones":
                    activeMenuGerenciaFinanzas();
                    $("#menuEstimacionesFinanzas").addClass("menu-item-active");
                    $("#menuEstimacionesFinanzas").addClass("menu-item-open");
                    $("#menuListadoEstimacionesFinanzas").addClass("menu-item-open");
                    break;
                case "estimacionesfin.verestimacionfin":
                    activeMenuGerenciaFinanzas();
                    $("#menuEstimacionesFinanzas").addClass("menu-item-active");
                    $("#menuEstimacionesFinanzas").addClass("menu-item-open");
                    $("#menuListadoEstimacionesFinanzas").addClass("menu-item-open");
                    break;
                case "estimacionesfin.evidenciapagoest":
                    activeMenuGerenciaFinanzas();
                    $("#menuEstimacionesFinanzas").addClass("menu-item-active");
                    $("#menuEstimacionesFinanzas").addClass("menu-item-open");
                    $("#menuListadoEstimacionesFinanzas").addClass("menu-item-open");
                    break;
            }
        }


        if (routeName.includes("mantenimientosfin")) {
            switch (routeName) {
                case "mantenimientosfin.listadomantenimientfinanzas":
                    activeMenuGerenciaFinanzas();
                    $("#menuTallerMantenimientoFinanzas").addClass("menu-item-active");
                    $("#menuTallerMantenimientoFinanzas").addClass("menu-item-open");
                    $("#menuTallerServiciosSolicitadosFinanzas").addClass("menu-item-open");
                    break;

                case "mantenimientosfin.versolicitudfinanzas":
                    activeMenuGerenciaFinanzas();
                    $("#menuTallerMantenimientoFinanzas").addClass("menu-item-active");
                    $("#menuTallerMantenimientoFinanzas").addClass("menu-item-open");
                    $("#menuTallerServiciosSolicitadosFinanzas").addClass("menu-item-open");
                    break;
                    
            }
        }


        // if (routeName.includes("finreqcompras")) {
        //     switch (routeName) {
        //         case "finreqcompras.finreqcompras":
        //             activeMenuGerenciaFinanzas();
        //             $("#menuFincomprasreq").addClass("menu-item-active");
        //             $("#menuFincomprasreq").addClass("menu-item-open");
        //             $("#menuFinreqcompras").addClass("menu-item-open");
        //             break;
        //         case "finreqcompras.solicitudcompras":
        //             activeMenuGerenciaFinanzas();
        //             $("#menuFincomprasreq").addClass("menu-item-active");
        //             $("#menuFincomprasreq").addClass("menu-item-open");
        //             $("#menuFinreqcompras").addClass("menu-item-open");
        //             break;

                    
        //     }
        // }



        if (routeName.includes("finreqcompras")) {
            switch (routeName) {
                case "finreqcompras.finreqcompras":
                    activeMenuGerenciaFinanzas();
                    $("#menuFincomprasreq").addClass("menu-item-active");
                    $("#menuFincomprasreq").addClass("menu-item-open");
                    $("#menuFincomprasreq").addClass("menu-item-open");
                    $("#menuFincomprasreq").addClass("menu-item-open");
                    break;

                case "finreqcompras.pagocomprareq":
                    activeMenuGerenciaFinanzas();
                    $("#menuFincomprasreq").addClass("menu-item-active");
                    $("#menuFincomprasreq").addClass("menu-item-open");
                    $("#menuFincomprasreq").addClass("menu-item-open");
                    $("#menuFincomprasreq").addClass("menu-item-open");
                    break;
                 
            }
        }





        if (routeName.includes("taller.clientes.solicitaratencion")) {
            $("#menuTallerMantenimiento").removeClass("menu-item-active");
            $("#menuTallerMantenimiento").removeClass("menu-item-open");

            $("#menuGerenciaOperaciones").removeClass("menu-item-active");
            $("#menuGerenciaOperaciones").removeClass("menu-item-open");

            // active menuMantenimientoClientes
            $("#menuMantenimientoClientes").addClass("menu-item-active");
            $("#menuMantenimientoClientes").addClass("menu-item-open");

            // menuTallerClientes
            $("#menuTallerClientes").addClass("menu-item-active");
            $("#menuTallerClientes").addClass("menu-item-open");

            // menuSolicitarMantenimientoClientes
            $("#menuSolicitarMantenimientoClientes").addClass("menu-item-active");

            // desactivate menuCatalogoClientes
            $("#menuCatalogoClientes").removeClass("menu-item-active");
            $("#menuCatalogoClientes").removeClass("menu-item-open");

            // desactivate menuGerenciaComercial
            $("#menuGerenciaComercial").removeClass("menu-item-active");
            $("#menuGerenciaComercial").removeClass("menu-item-open");

        }

        //ruta para listado de patios
        if (routeUrl.includes("unidad/catalogo-ubicaciones")) {
            activeMenuGerenciaOperaciones();
            $("#menuPatios").addClass("menu-item-active");
            $("#menuPatios").addClass("menu-item-open");
            $("#menuListadoPatios").addClass("menu-item-active");
            $("#menuListadoPatios").addClass("menu-item-open");
        }

        var paths = [
            "ubicacion.verubicacion",
        ];
        if (contains(routeName, paths)) {
            activeMenuGerenciaOperaciones();
            $("#menuPatios").addClass("menu-item-active");
            $("#menuPatios").addClass("menu-item-open");
            $("#menuListadoPatios").addClass("menu-item-active");
            $("#menuListadoPatios").addClass("menu-item-open");
        }

        if (routeUrl.includes("licitacion/listado-requisiciones-operaciones")) {
            activeMenuGerenciaOperaciones();
            $("#menuListadoRequisicionesOP").addClass("menu-item-active menu-item-open");
            $("#menuListadoRequisicionesOperaciones").addClass("menu-item-active menu-item-open");
        }
        if (routeName.includes("reqoperaciones.verrequisicionoperaciones")) {
            activeMenuGerenciaOperaciones();
            $("#menuListadoRequisicionesOP").addClass("menu-item-active menu-item-open");
            $("#menuListadoRequisicionesOperaciones").addClass("menu-item-active menu-item-open");
        }
        if (routeName.includes("reqoperaciones.verpartidaoperaciones")) {
            activeMenuGerenciaOperaciones();
            $("#menuListadoRequisicionesOP").addClass("menu-item-active menu-item-open");
            $("#menuListadoRequisicionesOperaciones").addClass("menu-item-active menu-item-open");
        }
        if (routeName.includes("reqoperaciones.asignacionunidades")) {
            activeMenuGerenciaOperaciones();
            $("#menuListadoRequisicionesOP").addClass("menu-item-active menu-item-open");
            $("#menuListadoRequisicionesOperaciones").addClass("menu-item-active menu-item-open");
        }
        if (routeName.includes("reqoperaciones.unidadesenpatioreq")) {
            activeMenuGerenciaOperaciones();
            $("#menuListadoRequisicionesOP").addClass("menu-item-active menu-item-open");
            $("#menuListadoRequisicionesOperaciones").addClass("menu-item-active menu-item-open");
        }

        //activar menu de Gerencia de Operaciones
        function activeMenuCatalogos() {
            $("#menu_catalogos").addClass("menu-item-active");
            $("#menu_catalogos").addClass("menu-item-open");
        }

        if (routeUrl.includes("unidad/")) {


            if (routeUrl.includes("catalogo-marcas")) {
                activeMenuCatalogos();
                $("#sub_menu_unidades").addClass("menu-item-open");
                $("#sub_sub_menu_marcas").addClass("menu-item-open");
                $("#sub_sub_menu_catalogo_marcas").addClass("menu-item-active menu-item-open");
            }

            if (routeUrl.includes("catalogo-modelos")) {
                activeMenuCatalogos();
                $("#sub_menu_unidades").addClass("menu-item-open");
                $("#sub_sub_menu_modelos").addClass("menu-item-open");
                $("#sub_sub_menu_catalogo_modelos").addClass("menu-item-active menu-item-open");
            }

            if (routeUrl.includes("catalogo-vehiculo-tipo")) {
                activeMenuCatalogos();
                $("#sub_menu_unidades").addClass("menu-item-open");
                $("#sub_sub_menu_vehiculo_tipo").addClass("menu-item-open");
                $("#sub_sub_menu_catalogo_vehiculo_tipo").addClass("menu-item-active menu-item-open");
            }

            if (routeUrl.includes("catalogo-estatus")) {
                activeMenuCatalogos();
                $("#sub_menu_unidades").addClass("menu-item-open");
                $("#sub_sub_menu_estatus").addClass("menu-item-open");
                $("#sub_sub_menu_catalogo_estatus").addClass("menu-item-active menu-item-open");
            }

            if (routeUrl.includes("catalogo-aseguradora")) {
                activeMenuCatalogos();
                $("#sub_menu_unidades").addClass("menu-item-open");
                $("#sub_sub_menu_aseguradora").addClass("menu-item-open");
                $("#sub_sub_menu_catalogo_aseguradora").addClass("menu-item-active menu-item-open");
            }

            if (routeUrl.includes("catalogo-agencias")) {
                activeMenuCatalogos();
                $("#sub_menu_unidades").addClass("menu-item-open");
                $("#sub_sub_menu_agencias").addClass("menu-item-open");
                $("#sub_sub_menu_catalogo_agencias").addClass("menu-item-active menu-item-open");
            }

            if (routeUrl.includes("catalogo-tipo-documentos")) {
                activeMenuCatalogos();
                $("#sub_menu_unidades").addClass("menu-item-open");
                $("#sub_sub_menu_tipo-documentos").addClass("menu-item-open");
                $("#sub_sub_menu_catalogo_tipo-documentos").addClass("menu-item-active menu-item-open");
            }

            if (routeUrl.includes("informacion-propietario")) {
                activeMenuCatalogos();
                $("#sub_menu_unidades").addClass("menu-item-open");
                $("#sub_sub_menu_informacion-propietario").addClass("menu-item-open");
                $("#sub_sub_menu_catalogo_informacion-propietario").addClass("menu-item-active menu-item-open");
            }

            if (routeUrl.includes("informacion-emplacamiento")) {
                activeMenuCatalogos();
                $("#sub_menu_unidades").addClass("menu-item-open");
                $("#sub_sub_menu_informacion-emplacamiento").addClass("menu-item-open");
                $("#sub_sub_menu_catalogo_informacion-emplacamiento").addClass("menu-item-active menu-item-open");
            }

            if (routeUrl.includes("informacion-tenencia")) {
                activeMenuCatalogos();
                $("#sub_menu_unidades").addClass("menu-item-open");
                $("#sub_sub_menu_informacion-tenencia").addClass("menu-item-open");
                $("#sub_sub_menu_catalogo_informacion-tenencia").addClass("menu-item-active menu-item-open");
            }

            if (routeUrl.includes("informacion-verificacion")) {
                activeMenuCatalogos();
                $("#sub_menu_unidades").addClass("menu-item-open");
                $("#sub_sub_menu_informacion-verificacion").addClass("menu-item-open");
                $("#sub_sub_menu_catalogo_informacion-verificacion").addClass("menu-item-active menu-item-open");
            }

            if (routeUrl.includes("informacion-reemplacamiento")) {
                activeMenuCatalogos();
                $("#sub_menu_unidades").addClass("menu-item-open");
                $("#sub_sub_menu_informacion-reemplacamiento").addClass("menu-item-open");
                $("#sub_sub_menu_catalogo_informacion-reemplacamiento").addClass("menu-item-active menu-item-open");
            }

            if (routeUrl.includes("informacion-cambio-propietario")) {
                activeMenuCatalogos();
                $("#sub_menu_unidades").addClass("menu-item-open");
                $("#sub_sub_menu_informacion-cambio-propietario").addClass("menu-item-open");
                $("#sub_sub_menu_catalogo_informacion-cambio-propietario").addClass("menu-item-active menu-item-open");
            }

            if (routeUrl.includes("informacion-aseguramientoreq")) {
                activeMenuCatalogos();
                $("#sub_menu_unidades").addClass("menu-item-open");
                $("#sub_sub_menu_informacion-aseguramientoreq").addClass("menu-item-open");
                $("#sub_sub_menu_catalogo_informacion-aseguramientoreq").addClass("menu-item-active menu-item-open");
            }

            if (routeUrl.includes("informacion-baja-venta")) {
                activeMenuCatalogos();
                $("#sub_menu_unidades").addClass("menu-item-open");
                $("#sub_sub_sub_menu_informacion-baja-venta").addClass("menu-item-open");
                $("#sub_sub_sub_sub_menu_informacion-baja-venta").addClass("menu-item-open");
                $("#sub_sub_menu_catalogo_informacion-baja-venta").addClass("menu-item-active menu-item-open");
            }

            if (routeUrl.includes("informacion-baja-robo")) {
                activeMenuCatalogos();
                $("#sub_menu_unidades").addClass("menu-item-open");
                $("#sub_sub_sub_menu_informacion-baja-venta").addClass("menu-item-open");
                $("#sub_sub_sub_menu_informacion-baja-robo").addClass("menu-item-open");
                $("#sub_sub_menu_catalogo_informacion-baja-robo").addClass("menu-item-active menu-item-open");
            }

            if (routeUrl.includes("informacion-baja-stro")) {
                activeMenuCatalogos();
                $("#sub_menu_unidades").addClass("menu-item-open");
                $("#sub_sub_sub_menu_informacion-baja-venta").addClass("menu-item-open");
                $("#sub_sub_sub_menu_informacion-baja-stro").addClass("menu-item-open");
                $("#sub_sub_menu_catalogo_informacion-baja-stro").addClass("menu-item-active menu-item-open");
            }

            if (routeUrl.includes("listado-catalogo-gestor") || routeUrl.includes("catalogo-catalogogestor-inactivos")) {
                activeMenuCatalogos();
                $("#sub_menu_unidades").addClass("menu-item-open");
                $("#sub_sub_menu_listado-gestor").addClass("menu-item-open");
                $("#sub_sub_menu_catalogo_gestor").addClass("menu-item-open");
                $("#sub_sub_menu_catalogo_gestor").addClass("menu-item-active menu-item-open");
            }

        }

        if (routeUrl.includes("segmento/")) {
            activeMenuCatalogos();
            $("#sub_menu_segmento").addClass("menu-item-open");

            if (routeUrl.includes("catalogo-tipovehiculos")) {
                $("#sub_sub_menu_tipovehiculos").addClass("menu-item-open");
                $("#sub_sub_menu_catalogo_tipovehiculos").addClass("menu-item-active menu-item-open");
            }

            if (routeUrl.includes("catalogo-tiposvehiculos-inactivos")) {
                $("#sub_sub_menu_tipovehiculos").addClass("menu-item-open");
                $("#sub_sub_menu_catalogo_tipovehiculos").addClass("menu-item-active menu-item-open");
            }

            if (routeUrl.includes("catalogo-puertas")) {
                $("#sub_sub_menu_puertas").addClass("menu-item-open");
                $("#sub_sub_menu_catalogo_puertas").addClass("menu-item-active menu-item-open");
            }

            if (routeUrl.includes("catalogo-carroceria")) {
                $("#sub_sub_menu_carroceria").addClass("menu-item-open");
                $("#sub_sub_menu_catalogo_carroceria").addClass("menu-item-active menu-item-open");
            }

            if (routeUrl.includes("catalogo-no-cilindros")) {
                $("#sub_sub_menu_no-cilindros").addClass("menu-item-open");
                $("#sub_sub_menu_catalogo_no-cilindros").addClass("menu-item-active menu-item-open");
            }

            if (routeUrl.includes("catalogo-pasajeros")) {
                $("#sub_sub_menu_pasajeros").addClass("menu-item-open");
                $("#sub_sub_menu_catalogo_pasajeros").addClass("menu-item-active menu-item-open");
            }

            if (routeUrl.includes("catalogo-motor")) {
                $("#sub_sub_menu_motor").addClass("menu-item-open");
                $("#sub_sub_menu_catalogo_motor").addClass("menu-item-active menu-item-open");
            }

            if (routeUrl.includes("catalogo-llanta-refaccion")) {
                $("#sub_sub_menu_llanta-refaccion").addClass("menu-item-open");
                $("#sub_sub_menu_catalogo_llanta-refaccion").addClass("menu-item-active menu-item-open");
            }

            if (routeUrl.includes("catalogo-espejos-laterales")) {
                $("#sub_sub_menu_espejos-laterales").addClass("menu-item-open");
                $("#sub_sub_menu_catalogo_espejos-laterales").addClass("menu-item-active menu-item-open");
            }

            if (routeUrl.includes("catalogo-accesorios")) {
                $("#sub_sub_menu_accesorios").addClass("menu-item-open");
                $("#sub_sub_menu_catalogo_accesorios").addClass("menu-item-active menu-item-open");
            }

            if (routeUrl.includes("catalogo-potencia")) {
                $("#sub_sub_menu_potencia").addClass("menu-item-open");
                $("#sub_sub_menu_catalogo_potencia").addClass("menu-item-active menu-item-open");
            }

            if (routeUrl.includes("catalogo-transmision")) {
                $("#sub_sub_menu_transmision").addClass("menu-item-open");
                $("#sub_sub_menu_catalogo_transmision").addClass("menu-item-active menu-item-open");
            }

            if (routeUrl.includes("catalogo-radio")) {
                $("#sub_sub_menu_radio").addClass("menu-item-open");
                $("#sub_sub_menu_catalogo_radio").addClass("menu-item-active menu-item-open");
            }

            if (routeUrl.includes("catalogo-direccion")) {
                $("#sub_sub_menu_direccion").addClass("menu-item-open");
                $("#sub_sub_menu_catalogo_direccion").addClass("menu-item-active menu-item-open");
            }
            if (routeUrl.includes("catalogo-blindaje")) {
                $("#sub_sub_menu_blindaje").addClass("menu-item-open");
                $("#sub_sub_menu_catalogo_blindaje").addClass("menu-item-active menu-item-open");
            }
            if (routeUrl.includes("catalogo-capacidad")) {
                $("#sub_sub_menu_capacidad").addClass("menu-item-open");
                $("#sub_sub_menu_catalogo_capacidad").addClass("menu-item-active menu-item-open");
            }
            if (routeUrl.includes("catalogo-gps")) {
                $("#sub_sub_menu_gps").addClass("menu-item-open");
                $("#sub_sub_menu_catalogo_gps").addClass("menu-item-active menu-item-open");
            }
            if (routeUrl.includes("catalogo-eninventario")) {
                $("#sub_sub_menu_eninventario").addClass("menu-item-open");
                $("#sub_sub_menu_catalogo_eninventario").addClass("menu-item-active menu-item-open");
            }

        }

        if (routeUrl.includes("cliente/")) {

            if (routeUrl.includes("catalogo-estados")) {
                activeMenuCatalogos();
                $("#sub_menu_segmento").addClass("menu-item-open");
                $("#sub_menu_cliente").addClass("menu-item-open");
                $("#sub_sub_menu_estados").addClass("menu-item-open");
                $("#sub_sub_menu_catalogo_estados").addClass("menu-item-active menu-item-open");
            }

            if (routeUrl.includes("catalogo-municipios")) {
                activeMenuCatalogos();
                $("#sub_menu_segmento").addClass("menu-item-open");
                $("#sub_menu_cliente").addClass("menu-item-open");
                $("#sub_sub_menu_municipios").addClass("menu-item-open");
                $("#sub_sub_menu_catalogo_municipios").addClass("menu-item-active menu-item-open");
            }
            if (routeUrl.includes("catalogo-documentos")) {
                activeMenuCatalogos();
                $("#sub_menu_segmento").addClass("menu-item-open");
                $("#sub_menu_cliente").addClass("menu-item-open");
                $("#sub_sub_menu_documentos").addClass("menu-item-open");
                $("#sub_sub_menu_catalogo_documentos").addClass("menu-item-active menu-item-open");
            }

        }

        if (routeUrl.includes("finanzas/")) {

            if (routeUrl.includes("listado-documentoscompras")) {
                activeMenuCatalogos();
                $("#sub_sub_menu_documentoscompras").addClass("menu-item-open");
                $("#sub_sub_menu_catalogo_documentoscompras").addClass("menu-item-active menu-item-open");
            }
        }

        if (routeUrl.includes("listado-licitacion/")) {

            if (routeUrl.includes("listado-proyectos")) {
                activeMenuCatalogos();
                $("#sub_sub_menu_listado-proyectos").addClass("menu-item-open");
                $("#sub_sub_menu_catalogo_proyectos").addClass("menu-item-active menu-item-open");
            }
        }

        if (routeUrl.includes("proyecto/")) {

            if (routeUrl.includes("listado-tipodedocumento")) {
                activeMenuCatalogos();
                $("#sub_sub_menu_listado-tipodedocumento").addClass("menu-item-open");
                $("#sub_sub_menu_catalogo_tipodedocumento").addClass("menu-item-active menu-item-open");
            }

            if (routeUrl.includes("listado-emisores")) {
                activeMenuCatalogos();
                $("#sub_sub_menu_listado-emisores").addClass("menu-item-open");
                $("#sub_sub_menu_catalogo_emisores").addClass("menu-item-active menu-item-open");
            }

            if (routeUrl.includes("listado-contratos")) {
                activeMenuCatalogos();
                $("#sub_sub_menu_listado-contratos").addClass("menu-item-open");
                $("#sub_sub_menu_catalogo_contratos").addClass("menu-item-active menu-item-open");
            }

            if (routeUrl.includes("listado-fuenteproyecto")) {
                activeMenuCatalogos();
                $("#sub_sub_menu_listado-fuenteproyecto").addClass("menu-item-open");
                $("#sub_sub_menu_catalogo_fuenteproyecto").addClass("menu-item-active menu-item-open");
            }
        }

        if (routeUrl.includes("licitacion/")) {

            if (routeUrl.includes("listado-publicacion")) {
                activeMenuCatalogos();
                $("#sub_sub_menu_listado-publicacion").addClass("menu-item-open");
                $("#sub_sub_menu_catalogo_publicacion").addClass("menu-item-active menu-item-open");
            }

            if (routeUrl.includes("listado-tiposcontratacion")) {
                activeMenuCatalogos();
                $("#sub_sub_menu_listado-tiposcontratacion").addClass("menu-item-open");
                $("#sub_sub_menu_catalogo_tiposcontratacion").addClass("menu-item-active menu-item-open");
            }

        }

        if (routeUrl.includes("unidad/catalogo-proveedores")) {
            activeMenuCatalogos();
            $("#sub_sub_menu_listado-proveedores").addClass("menu-item-open");
            $("#sub_sub_menu_catalogo_proveedores").addClass("menu-item-active menu-item-open");
        }

        if (routeUrl.includes("unidad/")) {
            if (routeUrl.includes("listado-proveedor-categoria") || routeUrl.includes("catalogo-proveedor-categoria-inactivos")) {
                activeMenuCatalogos();
                $("#sub_menu_finanzas").addClass("menu-item-open");
                $("#sub_sub_menu_listado-proveedores").addClass("menu-item-open");
                $("#sub_sub_menu_catalogo_proveedores_categoria").addClass("menu-item-active menu-item-open");
            }
        }

        if (routeUrl.includes("taller/tipo-solicitud")) {
            activeMenuCatalogos();
            $("#sub_sub_menu_listado-tipo-solicitud").addClass("menu-item-open");
            $("#sub_sub_menu_catalogo_tipo-solicitud").addClass("menu-item-active menu-item-open");
        }

        if (routeUrl.includes("proyecto/listado-penalizacionesydeducciones")) {
            activeMenuCatalogos();
            $("#sub_sub_menu_penalizacionesydeducciones").addClass("menu-item-open");
            $("#sub_sub_menu_catalogo_penalizacionesydeducciones").addClass("menu-item-active menu-item-open");
        }

        if (routeUrl.includes("licitacion/listado-metodospago")) {
            activeMenuCatalogos();
            $("#sub_sub_menu_metodospago").addClass("menu-item-open");
            $("#sub_sub_menu_catalogo_metodospago").addClass("menu-item-active menu-item-open");
        }

        if (routeUrl.includes("licitacion/listado-formaspago")) {
            activeMenuCatalogos();
            $("#sub_sub_menu_formaspago").addClass("menu-item-open");
            $("#sub_sub_menu_catalogo_formaspago").addClass("menu-item-active menu-item-open");
        }

        if (routeUrl.includes("-proptecleg")) {
            activeMenuCatalogos();
            $("#sub_sub_menu_propuesta-tecnica").addClass("menu-item-open");
            if (routeUrl.includes("listado-proptecleg")) {
                $("#sub_sub_menu_catalogo_proptecleg").addClass("menu-item-active menu-item-open");
            }
        }

        if (routeUrl.includes("-proptecadm")) {
            activeMenuCatalogos();
            $("#sub_sub_menu_propuesta-tecnica").addClass("menu-item-open");
            if (routeUrl.includes("listado-proptecadm")) {
                $("#sub_sub_menu_catalogo_proptecadm").addClass("menu-item-active menu-item-open");
            }
        }
        
        if (routeUrl.includes("-proptecfis")) {
            activeMenuCatalogos();
            $("#sub_sub_menu_propuesta-tecnica").addClass("menu-item-open");
            if (routeUrl.includes("listado-proptecfis")) {
                $("#sub_sub_menu_catalogo-proptecfis").addClass("menu-item-active menu-item-open");
            }
        }

        if (routeUrl.includes("-proptecfin")) {
            activeMenuCatalogos();
            $("#sub_sub_menu_propuesta-tecnica").addClass("menu-item-open");
            if (routeUrl.includes("listado-proptecfin")) {
                $("#sub_sub_menu_catalogo-proptecfin").addClass("menu-item-active menu-item-open");
            }
        }

        if (routeUrl.includes("licitacion/listado-area")) {
            activeMenuCatalogos();
            $("#sub_sub_menu_area-personal").addClass("menu-item-open");
            $("#sub_sub_menu_catalogo-listado-area").addClass("menu-item-active menu-item-open");
        }

        if (routeUrl.includes("licitacion/listado-catalogocfdi")) {
            activeMenuCatalogos();
            $("#sub_sub_menu_catalogocfdi").addClass("menu-item-open");
            $("#sub_sub_menu_catalogo-catalogocfdi").addClass("menu-item-active menu-item-open");
        }

        if (routeUrl.includes("licitacion/listado-afianzadora")) {
            activeMenuCatalogos();
            $("#sub_sub_menu_afianzadora").addClass("menu-item-open");
            $("#sub_sub_menu_catalogo-afianzadora").addClass("menu-item-active menu-item-open");
        }

        if (routeUrl.includes("licitacion/listado-tipofianza")) {
            activeMenuCatalogos();
            $("#sub_sub_menu_tipofianza").addClass("menu-item-open");
            $("#sub_sub_menu_catalogo-tipofianza").addClass("menu-item-active menu-item-open");
        }

        if (routeUrl.includes("proyecto/listado-conveniomodificatorio")) {
            activeMenuCatalogos();
            $("#sub_sub_menu_conveniomodificatorio").addClass("menu-item-open");
            $("#sub_sub_menu_catalogo-conveniomodificatorio").addClass("menu-item-active menu-item-open");
        }

        if (routeUrl.includes("finanzas/listado-grupo")) {
            activeMenuCatalogos();
            $("#sub_sub_menu_requisicion-partidas").addClass("menu-item-open");
            $("#sub_sub_menu_catalogo-grupo").addClass("menu-item-active menu-item-open");
        }

        if (routeUrl.includes("finanzas/listado-tipotransporte")) {
            activeMenuCatalogos();
            $("#sub_sub_menu_requisicion-partidas").addClass("menu-item-open");
            $("#sub_sub_menu_catalogo-tipotransporte").addClass("menu-item-active menu-item-open");
        }

        if (routeUrl.includes("finanzas/listado-entidadfederativa")) {
            activeMenuCatalogos();
            $("#sub_sub_menu_requisicion-partidas").addClass("menu-item-open");
            $("#sub_sub_menu_catalogo-entidadfederativa").addClass("menu-item-active menu-item-open");
        }

        if (routeUrl.includes("finanzas/listado-tipoplacas")) {
            activeMenuCatalogos();
            $("#sub_sub_menu_requisicion-partidas").addClass("menu-item-open");
            $("#sub_sub_menu_catalogo-tipoplacas").addClass("menu-item-active menu-item-open");
        }

        if (routeUrl.includes("finanzas/listado-combustible")) {
            activeMenuCatalogos();
            $("#sub_sub_menu_requisicion-partidas").addClass("menu-item-open");
            $("#sub_sub_menu_catalogo-combustible").addClass("menu-item-active menu-item-open");
        }

        if (routeUrl.includes("unidad/catalogo-tipo-asignacion")) {
            activeMenuCatalogos();
            $("#sub_menu_unidades").addClass("menu-item-open");
            $("#sub_sub_menu_tipo-asignacion").addClass("menu-item-open");
            $("#sub_sub_menu_catalogo_tipo-asignacion").addClass("menu-item-active menu-item-open");
        }
        if (routeUrl.includes("unidad/catalogo-tipoasignacion-inactivos")) {
            activeMenuCatalogos();
            $("#sub_menu_unidades").addClass("menu-item-open");
            $("#sub_sub_menu_tipo-asignacion").addClass("menu-item-open");
            $("#sub_sub_menu_catalogo_tipo-asignacion").addClass("menu-item-active menu-item-open");
        }


        //ruta para listado de contratos
        if (routeName.includes("solicitud")) {
            activeMenuGerenciaAdministracionContratos();
            $("#menuAdministracionContratos").addClass("menu-item-active");
            $("#menuAdministracionContratos").addClass("menu-item-open");
            switch (routeName) {
                case "solicitud.listado":
                    $("#menuListadoSolicitudes").addClass("menu-item-open");
                    break;
                case "solicitud.listadoValidacion":
                    $("#menuListadoSolicitudesValidacion").addClass("menu-item-open");
                    break;
                case "solicitud.validacion":
                    $("#menuListadoSolicitudesValidacion").addClass("menu-item-open");
                    break;
                case "solicitud.validacionActividad":
                    $("#menuListadoSolicitudesValidacion").addClass("menu-item-open");
                    break;
                case "solicitud.ver":
                    $("#menuListadoSolicitudes").addClass("menu-item-open");
                    break;
                case "solicitud.nuevo":
                    $("#menuListadoSolicitudes").addClass("menu-item-open");
                    break;
                    
            }
        }

        //ruta para listado solicitudes GPS
        if (routeUrl.includes("solicitud/listado-proveedor")) {
            $("#menuSolicitudesGPS").addClass("menu-item-active");
            $("#menuSolicitudesGPS").addClass("menu-item-open");
        }


        //init: vehículos en venta
        var paths = [
            "seminuevos.catalogoUnidadVenta",
            "seminuevos.VentaVerUnidadFinal",
            "seminuevos.ventaFinal",
        ];
        if (contains(routeName, paths)) {
            activeDireccionSeminuevos();
            $("#menuDireccionSeminuevos_submenu_vehiculos_venta").addClass("menu-item-active");
            $("#menuDireccionSeminuevos_submenu_vehiculos_venta").addClass("menu-item-open");
            $("#menuDireccionSeminuevos_submenu_vehiculos_venta").addClass("menu-activo");
        }
        var paths = [
            "seminuevos.catalogo_vehi",
        ];
        if (contains(routeName, paths)) {
            activeDireccionSeminuevos();
            $("#menuDireccionSeminuevos_submenu_inventario_vehiculos").addClass("menu-item-active");
            $("#menuDireccionSeminuevos_submenu_inventario_vehiculos").addClass("menu-item-open");
            $("#menuDireccionSeminuevos_submenu_inventario_vehiculos").addClass("menu-activo");
        }

        var paths = [
            "seminuevos.catalogoUnidadVentaApartado",
            "seminuevos.catalogoApartadoEditar",
        ];
        if (contains(routeName, paths)) {
            activeDireccionSeminuevos();
            $("#_menuDireccionSeminuevos_partado").addClass("menu-item-active");
            $("#_menuDireccionSeminuevos_partado").addClass("menu-item-open");
            $("#_menuDireccionSeminuevos_partado").addClass("menu-activo");
        }
        //end: vehículos en venta

        //activar menu de direccion de seminuevos
        function activeDireccionSeminuevos() {
            $("#menuDireccionSeminuevos").addClass("menu-item-active");
            $("#menuDireccionSeminuevos").addClass("menu-item-open");
            // $("#menuDireccionSeminuevos").addClass("menu-activo");
        }

    };

    function contains(a, b) {
        // array matches
        if (Array.isArray(b)) {
            return b.some(x => a.indexOf(x) > -1);
        }
        // string match
        return a.indexOf(b) > -1;
    }

    return {
        //main function to initiate the module
        init: function () {
            sidebarToggleActiveMenu();
            showTititleWhenScroll();
        },
    };
})();

jQuery(document).ready(function () {
    Principal.init();
	$(".specialCharts").keypress(function(event){
		const charPress = String.fromCharCode(event.which);

		var find    = ["Á", "É", "Í", "Ó", "Ú",'Ä','Î','Ù','Ã','Ø','Â','Ö','Ë','Õ','Ÿ','Ž','Ý','Û','Ï','Å','Ç'];
		var replace = ["A", "E", "I", "O", "U", "A",'I','U','A','0','A','O','E','O','Y','Z','Y','U','I','A','C'];

		for (let i = 0; i < find.length; i++) {
			if (charPress.toUpperCase() === find[i]) {
				event.preventDefault();
				$(this).val($(this).val() + replace[i]);
			}
		}

	});
});
