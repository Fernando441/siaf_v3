<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<!--begin::Head-->
<head>
    <title>@yield('title') | {{ config('app.name', 'Sistema Integral de Administración y Finanzas') }}</title>
    <meta charset="utf-8" />
    <meta name="description" content="SIAF Sistema Integral de Administración y Finanzas" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    {{-- <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests"> --}}

    <link rel="shortcut icon" href="{{ asset('theme/assets/media/logos/favicon.ico') }}" />
    <!--begin::Fonts-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
    <!--end::Fonts-->

    <!--begin::Page Vendor Stylesheets-->
    <link href="{{ asset('theme/assets/plugins/custom/fullcalendar/fullcalendar.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('theme/assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
    <!--end::Page Vendor Stylesheets-->

    <!--begin::Global Stylesheets Bundle(used by all pages)-->
    <link href="{{ asset('theme/assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('theme/assets/plugins/custom/prismjs/prismjs.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('theme/assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
    <!--end::Global Stylesheets Bundle-->

    <!--begin::Layout Themes(used by all pages)-->
    <link href="{{ asset('theme/assets/css/themes/layout/header/base/light.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('theme/assets/css/themes/layout/header/menu/light.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('theme/assets/css/themes/layout/brand/light.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('theme/assets/css/themes/layout/aside/light.css') }}" rel="stylesheet" type="text/css" />
    <!--end::Layout Themes-->

    <!--begin::Custom Theme(used by all pages)-->
    <link href="{{ asset('css/principal.css') }}" rel="stylesheet" type="text/css" />
    <!--end::Custom Theme-->

    @stack('styles')
</head>

<!--end::Head-->

<!--begin::Body-->
<body id="kt_body" class="header-fixed header-mobile-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading" style="background: #f8f7fa">
@php $routeName = Route::currentRouteName(); @endphp
@php $route =     request()->route()->uri; @endphp
<script>
    console.log("{{ $routeName }}");
    console.log("{{ $route }}");
</script>
<input type="hidden" name="routeName" id="routeName" value="{{ $routeName }}">
<input type="hidden" name="routeUrl" id="routeUrl" value="{{ $route }}">
<input type="hidden" id="notificacion_index" value="{{ route('notificacion.index') }}">
<input type="hidden" id="notificacion_total" value="{{ route('notificacion.total') }}">
<input type="hidden" id="tabler_vernotconcurso" value="{{ route('tablero.vernotconcurso') }}">
<!--begin::Main-->
<!--begin::Header Mobile-->
<div id="kt_header_mobile" class="header-mobile align-items-center header-mobile-fixed">
    <!--begin::Logo-->
    <a href="{{ route('tablero.show') }}">
        <img alt="Logo" class="h-55px brand-logo" src="{{ asset('theme/assets/media/logos/LogoJetVan-sin-fondo.png') }}" />
    </a>
    <!--end::Logo-->
    <!--begin::Toolbar-->
    <div class="d-flex align-items-center">
        <!--begin::Aside Mobile Toggle-->
        <button class="btn p-0 burger-icon burger-icon-left" id="kt_aside_mobile_toggle">
            <span></span>
        </button>
        <!--end::Aside Mobile Toggle-->
        <!--begin::Topbar Mobile Toggle-->
        <button class="btn btn-hover-text-primary p-0 ml-2" id="kt_header_mobile_topbar_toggle">
					<span class="svg-icon svg-icon-xl">
						<!--begin::Svg Icon | path:assets/media/svg/icons/General/User.svg-->
						<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
							<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
								<polygon points="0 0 24 0 24 24 0 24" />
								<path d="M12,11 C9.790861,11 8,9.209139 8,7 C8,4.790861 9.790861,3 12,3 C14.209139,3 16,4.790861 16,7 C16,9.209139 14.209139,11 12,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
								<path d="M3.00065168,20.1992055 C3.38825852,15.4265159 7.26191235,13 11.9833413,13 C16.7712164,13 20.7048837,15.2931929 20.9979143,20.2 C21.0095879,20.3954741 20.9979143,21 20.2466999,21 C16.541124,21 11.0347247,21 3.72750223,21 C3.47671215,21 2.97953825,20.45918 3.00065168,20.1992055 Z" fill="#000000" fill-rule="nonzero" />
							</g>
						</svg>
                        <!--end::Svg Icon-->
					</span>
        </button>
        <!--end::Topbar Mobile Toggle-->
    </div>
    <!--end::Toolbar-->
</div>
<!--end::Header Mobile-->
<div class="d-flex flex-column flex-root">
    <!--begin::Page-->
    <div class="d-flex flex-row flex-column-fluid page">
        <!--begin::Aside-->
        <div class="aside aside-left aside-fixed d-flex flex-column flex-row-auto" id="kt_aside" >
            <!--begin::Brand-->
            <div class="brand flex-column-auto" id="kt_brand" style="height: 85px; background-color: {{ Session::get('menu_color') }} !important" >
                <!--begin::Logo-->
                <a href="{{ route('tablero.show') }}" class="brand-logo">
                    <img alt="Logo" class="brand-logo" src="{{ asset('theme/assets/media/logos/jetvan.png') }}" width="150px" height="34px" />
                </a>
                <!--end::Logo-->
                <!--begin::Toggle-->
                <button class="brand-toggle btn btn-sm px-0" id="kt_aside_toggle">
							<span class="svg-icon svg-icon svg-icon-xl">
								<!--begin::Svg Icon | path:assets/media/svg/icons/Navigation/Angle-double-left.svg-->
								<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
									<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
										<polygon points="0 0 24 0 24 24 0 24" />
										<path d="M5.29288961,6.70710318 C4.90236532,6.31657888 4.90236532,5.68341391 5.29288961,5.29288961 C5.68341391,4.90236532 6.31657888,4.90236532 6.70710318,5.29288961 L12.7071032,11.2928896 C13.0856821,11.6714686 13.0989277,12.281055 12.7371505,12.675721 L7.23715054,18.675721 C6.86395813,19.08284 6.23139076,19.1103429 5.82427177,18.7371505 C5.41715278,18.3639581 5.38964985,17.7313908 5.76284226,17.3242718 L10.6158586,12.0300721 L5.29288961,6.70710318 Z" fill="#000000" fill-rule="nonzero" transform="translate(8.999997, 11.999999) scale(-1, 1) translate(-8.999997, -11.999999)" />
										<path d="M10.7071009,15.7071068 C10.3165766,16.0976311 9.68341162,16.0976311 9.29288733,15.7071068 C8.90236304,15.3165825 8.90236304,14.6834175 9.29288733,14.2928932 L15.2928873,8.29289322 C15.6714663,7.91431428 16.2810527,7.90106866 16.6757187,8.26284586 L22.6757187,13.7628459 C23.0828377,14.1360383 23.1103407,14.7686056 22.7371482,15.1757246 C22.3639558,15.5828436 21.7313885,15.6103465 21.3242695,15.2371541 L16.0300699,10.3841378 L10.7071009,15.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" transform="translate(15.999997, 11.999999) scale(-1, 1) rotate(-270.000000) translate(-15.999997, -11.999999)" />
									</g>
								</svg>
                                <!--end::Svg Icon-->
							</span>
                </button>
                <!--end::Toolbar-->
            </div>
            <!--end::Brand-->
            <!--begin::Aside Menu-->
            <div class="aside-menu-wrapper flex-column-fluid" id="kt_aside_menu_wrapper">
                <!--begin::Menu Container-->
                <div id="kt_aside_menu" class="aside-menu my-4" data-menu-vertical="1" data-menu-scroll="1" data-menu-dropdown-timeout="500">
                    <!--begin::Menu Nav-->
                    <ul class="menu-nav">
                    {{-- si es cliente --}}
                    @if(Auth::user()->tipo_usuario_id == 1)
                        {{-- MANTENIMIENTO CLIENTES  --}}
                        <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover" id="menuMantenimientoClientes">
                            <a href="javascript:;" class="menu-link menu-toggle">
                                <i class="flaticon-user-settings menu-icon"></i>
                                <span class="menu-text">MI MANTENIMIENTO</span>
                                <i class="menu-arrow"></i>
                            </a>
                            <div class="menu-submenu">
                                <i class="menu-arrow"></i>
                                <ul class="menu-subnav">
                                    {{-- TALLER --}}
                                        <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover" id="menuTallerClientes">
                                            <a href="javascript:;" class="menu-link menu-toggle">
                                                <i class="flaticon-truck menu-icon"></i>
                                                <span class="menu-text">Taller</span>
                                                <i class="menu-arrow"></i>
                                            </a>
                                            <div class="menu-submenu">
                                                <i class="menu-arrow"></i>
                                                <ul class="menu-subnav">
                                                        <li class="menu-item" aria-haspopup="true" id="menuSolicitarMantenimientoClientes">
                                                            <a href="{{ route('taller.clientes.solicitaratencion') }}" class="menu-link">
                                                                <i class="menu-bullet menu-bullet-dot">
                                                                    <span></span>
                                                                </i>
                                                                <span class="menu-text">Solicitar mantenimiento</span>
                                                            </a>
                                                        </li>
                                                        {{-- Listado de Mantenimientos --}}
                                                        <li class="menu-item" aria-haspopup="true" id="menuListadoMantenimientosClientes">
                                                            <a href="{{ route('taller.clientes.vermantenimientos') }}" class="menu-link">
                                                                <i class="menu-bullet menu-bullet-dot">
                                                                    <span></span>
                                                                </i>
                                                                <span class="menu-text">Listado de mantenimientos</span>
                                                            </a>
                                                        </li>
                                                </ul>
                                            </div>
                                        </li>
                                </ul>
                            </div>
                        </li>
                    @elseif(Auth::user()->tipo_usuario_id == 2)
                        {{-- TALLER  --}}
                        <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover" id="menuMantenimientoClientes">
                            <a href="javascript:;" class="menu-link menu-toggle">
                                <i class="fas fa-warehouse menu-icon"></i>
                                <span class="menu-text">MI TALLER</span>
                                <i class="menu-arrow"></i>
                            </a>
                            <div class="menu-submenu">
                                <i class="menu-arrow"></i>
                                <ul class="menu-subnav">
                                    {{-- TALLER --}}
                                        <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover" id="menuTallerClientes">
                                            <a href="javascript:;" class="menu-link menu-toggle">
                                                <i class="flaticon-truck menu-icon"></i>
                                                <span class="menu-text">Mantenimiento</span>
                                                <i class="menu-arrow"></i>
                                            </a>
                                            <div class="menu-submenu">
                                                <i class="menu-arrow"></i>
                                                <ul class="menu-subnav">
                                                        <li class="menu-item" aria-haspopup="true" id="menuListadoMantenimientosClientes">
                                                            <a href="{{ route('tllmodulo.listadosolmanttl') }}" class="menu-link">
                                                                <i class="menu-bullet menu-bullet-dot">
                                                                    <span></span>
                                                                </i>
                                                                <span class="menu-text">Listado de mantenimientos</span>
                                                            </a>
                                                        </li>
                                                </ul>
                                            </div>
                                        </li>
                                </ul>
                            </div>
                        </li>
                    @else
                        

                        @if (in_array("367", Session::get('permisos')) )
                        <li id="menuSolicitudesGPS" class="menu-item menu-item-active" aria-haspopup="true">
                            <a href="{{ route('solicitud.listadoProveedor') }}" class="menu-link">
                                <i class="flaticon-list menu-icon"></i>
                                <span class="menu-text">Solicitudes GPS</span>
                            </a>
                        </li>
                        @else
                        <li id="menuHome" class="menu-item menu-item-active" aria-haspopup="true">
                            <a href="{{ route('tablero.show') }}" class="menu-link">
                                <i class="flaticon-pie-chart-1 menu-icon"></i>
                                <span class="menu-text">Tablero</span>
                            </a>
                        </li>
                        @endif


                        @if (in_array("1", Session::get('permisos')) || in_array("2", Session::get('permisos')) || in_array("5", Session::get('permisos')) || in_array("6", Session::get('permisos')) )
                                <li class="menu-section">
                                    <h4 class="menu-text">SISTEMA</h4>
                                    <i class="menu-icon ki ki-bold-more-hor icon-md"></i>
                                </li>
                            <li id="menuAdministracion" class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
                                <a href="javascript:;" class="menu-link menu-toggle">
                                    <i class="flaticon2-user-1 menu-icon"></i>
                                    <span class="menu-text">Administración del Sistema</span>
                                    <i class="menu-arrow"></i>
                                </a>
                                <div class="menu-submenu">
                                    <i class="menu-arrow"></i>
                                    <ul class="menu-subnav">

                                        {{-- USUARIOS --}}
                                        @if (in_array("5", Session::get('permisos')) || in_array("6", Session::get('permisos')) )  
                                            <li id="menuUsuarios" class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
                                                <a href="javascript:;" class="menu-link menu-toggle">
                                                    <i class="flaticon-users-1 menu-icon"></i>
                                                    <span class="menu-text">Usuarios</span>
                                                    <i class="menu-arrow"></i>
                                                </a>
                                                <div class="menu-submenu">
                                                    <i class="menu-arrow"></i>
                                                    <ul class="menu-subnav">
                                                        @if (in_array("5", Session::get('permisos')))
                                                            <li id="menuListadoUsuarios" class="menu-item" aria-haspopup="true">
                                                                <a href="{{ route('user.catalogousuarios') }}" class="menu-link">
                                                                    <i class="menu-bullet menu-bullet-dot">
                                                                        <span></span>
                                                                    </i>
                                                                    <span class="menu-text">Listado de Usuarios</span>

                                                                </a>
                                                            </li>
                                                        @endif
                                                    </ul>
                                                </div>
                                            </li>
                                        @endif
                                        {{-- ROLES --}}
                                        @if (in_array("1", Session::get('permisos')) || in_array("2", Session::get('permisos')) )
                                            <li id="menuRoles" class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
                                                <a href="javascript:;" class="menu-link menu-toggle">
                                                    <i class="flaticon-security menu-icon"></i>
                                                    <span class="menu-text">Roles</span>
                                                    <i class="menu-arrow"></i>
                                                </a>
                                                <div class="menu-submenu">
                                                    <i class="menu-arrow"></i>
                                                    <ul class="menu-subnav">
                                                        @if (in_array("1", Session::get('permisos')))
                                                            <li id="menuListadoRoles" class="menu-item" aria-haspopup="true">
                                                                <a href="{{ route('rol.catalogoroles') }}" class="menu-link">
                                                                    <i class="menu-bullet menu-bullet-dot">
                                                                        <span></span>
                                                                    </i>
                                                                    <span class="menu-text">Listado de Roles</span>
                                                                </a>
                                                            </li>
                                                        @endif
                                                    </ul>
                                                </div>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            </li>
                        @endif
        {{-- END ADMINISTRACIÓN DEL SISTEMA --}}

                        @if (Session::get('role_id') !== 17)
                        <li class="menu-section">
                            <h4 class="menu-text">DIRECCIONES</h4>
                            <i class="menu-icon ki ki-bold-more-hor icon-md"></i>
                        </li>
                        @endif
        {{-- GERENCIA DE COMERCIO --}}
                    @if (in_array("33", Session::get('permisos')) || in_array("34", Session::get('permisos')) || in_array("61", Session::get('permisos')) || in_array("62", Session::get('permisos')) || in_array("122", Session::get('permisos')) || in_array("114", Session::get('permisos')) || in_array("115", Session::get('permisos')) || in_array("118", Session::get('permisos')) || in_array("119", Session::get('permisos')) || in_array("123", Session::get('permisos')) )
                        <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover" id="menuGerenciaComercial">
                            <a href="javascript:;" class="menu-link menu-toggle">
                                <i class="flaticon-notepad menu-icon"></i>
                                <span class="menu-text">Dirección Comercial</span>
                                <i class="menu-arrow"></i>
                            </a>
                            <div class="menu-submenu">
                                <i class="menu-arrow"></i>
                                <ul class="menu-subnav">
                                    {{-- CLIENTES --}}
                                    @if (in_array("33", Session::get('permisos')) || in_array("34", Session::get('permisos')) ) 
                                        <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover" id="menuCatalogoClientes">
                                            <a href="javascript:;" class="menu-link menu-toggle">
                                                <i class="flaticon-profile menu-icon"></i>
                                                <span class="menu-text">Catálogo de clientes</span>
                                                <i class="menu-arrow"></i>
                                            </a>
                                            <div class="menu-submenu">
                                                <i class="menu-arrow"></i>
                                                <ul class="menu-subnav">
                                                    <li class="menu-item menu-item-parent" aria-haspopup="true">
                                                        <span class="menu-link">
                                                            <span class="menu-text">Catálogo de clientes</span>
                                                        </span>
                                                    </li>
                                                    @if (in_array("33", Session::get('permisos'))) 
                                                        <li class="menu-item" aria-haspopup="true" id="menuListadoClientes">
                                                            <a href="{{ route('cliente.catalogoCliente') }}" class="menu-link">
                                                                <i class="menu-bullet menu-bullet-dot">
                                                                    <span></span>
                                                                </i>
                                                                <span class="menu-text">Listado de clientes</span>
                                                            </a>
                                                        </li>
                                                    @endif
                                                </ul>
                                            </div>
                                        </li>
                                    @endif
                                    {{-- LICITACIONES --}}
                                    @if (in_array("114", Session::get('permisos')) || in_array("115", Session::get('permisos')))
                                        <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover" id="menuLicitaciones">
                                            <a href="javascript:;" class="menu-link menu-toggle">
                                                <i class="flaticon-folder-1 menu-icon"></i>
                                                <span class="menu-text">Concursos</span>
                                                <i class="menu-arrow"></i>
                                            </a>
                                            <div class="menu-submenu">
                                                <i class="menu-arrow"></i>
                                                <ul class="menu-subnav">
                                                    <li class="menu-item menu-item-parent" aria-haspopup="true">
                                                        <span class="menu-link">
                                                            <span class="menu-text">Concursos</span>
                                                        </span>
                                                    </li>
                                                    @if (in_array("114", Session::get('permisos')))
                                                        <li class="menu-item" aria-haspopup="true" id="menuControlLicitaciones">
                                                            <a href="{{ route('licitacion.listadolicitaciones') }}" class="menu-link">
                                                                <i class="menu-bullet menu-bullet-dot">
                                                                    <span></span>
                                                                </i>
                                                                <span class="menu-text">Listado de concursos</span>
                                                            </a>
                                                        </li>
                                                    @endif
                                                </ul>
                                            </div>
                                        </li>
                                    @endif
                                    {{-- Requisiciones --}}
                                    @if (in_array("118", Session::get('permisos')) || in_array("119", Session::get('permisos')))
                                        <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover" id="menuRequisiciones">
                                            <a href="javascript:;" class="menu-link menu-toggle">
                                                <i class="flaticon-folder-1 menu-icon"></i>
                                                <span class="menu-text">Requisiciones</span>
                                                <i class="menu-arrow"></i>
                                            </a>
                                            <div class="menu-submenu">
                                                <i class="menu-arrow"></i>
                                                <ul class="menu-subnav">
                                                    <li class="menu-item menu-item-parent" aria-haspopup="true">
                                                        <span class="menu-link">
                                                            <span class="menu-text">Requisiciones</span>
                                                        </span>
                                                    </li>
                                                    @if (in_array("118", Session::get('permisos')))
                                                        <li class="menu-item" aria-haspopup="true" id="menuListadoRequisicionesContrato">
                                                            <a href="{{ route('concurso.requisiciones.catalogorequisicion') }}" class="menu-link">
                                                                <i class="menu-bullet menu-bullet-dot">
                                                                    <span></span>
                                                                </i>
                                                                <span class="menu-text">Listado de requisiciones</span>
                                                            </a>
                                                        </li>

                                                        <li class="menu-item" aria-haspopup="true" id="menuListadoRequisiciones">
                                                            <a href="{{ route('requisiciones.catalogorequisicion') }}" class="menu-link">
                                                                <i class="menu-bullet menu-bullet-dot">
                                                                    <span></span>
                                                                </i>
                                                                <span class="menu-text">Listado de requisiciones sin concurso</span>
                                                            </a>
                                                        </li>
                                                    @endif
                                                </ul>
                                            </div>
                                        </li>
                                    @endif
                                    {{-- Catalogo de segmentos --}}
                                    @if (in_array("61", Session::get('permisos')) || in_array("62", Session::get('permisos')))
                                        <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover" id="menuAdministracionSegmentos">
                                            <a href="javascript:;" class="menu-link menu-toggle">
                                                <i class="flaticon-grid-menu-v2 menu-icon"></i>
                                                <span class="menu-text">Administración de segmentos</span>
                                                <i class="menu-arrow"></i>
                                            </a>
                                            <div class="menu-submenu">
                                                <i class="menu-arrow"></i>
                                                <ul class="menu-subnav">
                                                    <li class="menu-item menu-item-parent" aria-haspopup="true">
                                                        <span class="menu-link">
                                                            <span class="menu-text">Administración de segmentos</span>
                                                        </span>
                                                    </li>
                                                    @if (in_array("61", Session::get('permisos'))) 
                                                        <li class="menu-item" aria-haspopup="true" id="menuListadoSegmentos">
                                                            <a href="{{ route('segmento.catalogosegmentos') }}" class="menu-link">
                                                                <i class="menu-bullet menu-bullet-dot">
                                                                    <span></span>
                                                                </i>
                                                                <span class="menu-text">Listado de segmentos</span>
                                                            </a>
                                                        </li>
                                                    @endif
                                                </ul>
                                            </div>
                                        </li>
                                    @endif
                                    {{-- PARRQUE VEHICULAR SOLO CONSULTA --}}
                                    @if (in_array("122", Session::get('permisos'))) 

                                        <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover" id="menuComercialInventario">
                                            <a href="javascript:;" class="menu-link menu-toggle">
                                                <i class="flaticon-folder-1 menu-icon"></i>
                                                <span class="menu-text">Parque Vehicular</span>
                                                <i class="menu-arrow"></i>
                                            </a>
                                            <div class="menu-submenu">
                                                <i class="menu-arrow"></i>
                                                <ul class="menu-subnav">
                                                    <li class="menu-item menu-item-parent" aria-haspopup="true">
                                                        <span class="menu-link">
                                                            <span class="menu-text">Inventatio Unidades</span>
                                                        </span>
                                                    </li>
                                                    @if (in_array("122", Session::get('permisos')))
                                                        <li class="menu-item" aria-haspopup="true" id="menuListadoVehiculos">
                                                            <a href="{{ route('comercialinv.inventariocomercial') }}" class="menu-link">
                                                                <i class="menu-bullet menu-bullet-dot">
                                                                    <span></span>
                                                                </i>
                                                                <span class="menu-text">Listado de Vehiculos</span>
                                                            </a>
                                                        </li>
                                                    @endif

                                                </ul>
                                            </div>
                                        </li>

                                    @endif

                                    {{-- GESTOR DE DOCUMENTOS --}}
                                    @if (in_array("123", Session::get('permisos')))
                                        <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover" id="menuGestorDocumentos">
                                            <a href="javascript:;" class="menu-link menu-toggle">
                                                <i class="flaticon-tabs menu-icon"></i>
                                                <span class="menu-text">Gestor de documentos</span>
                                                <i class="menu-arrow"></i>
                                            </a>
                                            <div class="menu-submenu">
                                                <i class="menu-arrow"></i>
                                                <ul class="menu-subnav">
                                                    <li class="menu-item menu-item-parent" aria-haspopup="true">
                                                        <span class="menu-link">
                                                            <span class="menu-text">Gestor de documentos</span>
                                                        </span>
                                                    </li>
                                                    @if (in_array("123", Session::get('permisos')))
                                                        <li class="menu-item" aria-haspopup="true" id="menuListadoDocumentos">
                                                            <a href="{{ route('gestordocumentos.catalogodocumento') }}" class="menu-link">
                                                                <i class="menu-bullet menu-bullet-dot">
                                                                    <span></span>
                                                                </i>
                                                                <span class="menu-text">Listado de documentos</span>
                                                            </a>
                                                        </li>
                                                    @endif
                                                </ul>
                                            </div>
                                        </li>
                                    @endif



                                        <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover" id="menuReqCompras">
                                            <a href="javascript:;" class="menu-link menu-toggle">
                                                <i class="flaticon-profile menu-icon"></i>
                                                <span class="menu-text">Requisición compras</span>
                                                <i class="menu-arrow"></i>
                                            </a>
                                            <div class="menu-submenu">
                                                <i class="menu-arrow"></i>
                                                <ul class="menu-subnav">
                                                    <li class="menu-item menu-item-parent" aria-haspopup="true">
                                                        <span class="menu-link">
                                                            <span class="menu-text">Requisición compras</span>
                                                        </span>
                                                    </li>
                                                    {{-- @if (in_array("123", Session::get('permisos'))) --}}
                                                        <li class="menu-item" aria-haspopup="true" id="menuListadoReqCompras">
                                                            <a href="{{ route('reqcompras.reqcompras') }}" class="menu-link">
                                                                <i class="menu-bullet menu-bullet-dot">
                                                                    <span></span>
                                                                </i>
                                                                <span class="menu-text">Listado de requisiciones</span>
                                                            </a>
                                                        </li>
                                                    {{-- @endif --}}

                                                    {{-- @if (in_array("123", Session::get('permisos'))) --}}
                                                        <li class="menu-item" aria-haspopup="true" id="menuListadoRevisionReqCompras">
                                                            <a href="{{ route('reqcompras.reqrevisioncompras') }}" class="menu-link">
                                                                <i class="menu-bullet menu-bullet-dot">
                                                                    <span></span>
                                                                </i>
                                                                <span class="menu-text">Revisión de requisiciones</span>
                                                            </a>
                                                        </li>
                                                    {{-- @endif --}}

                                                </ul>
                                            </div>
                                        </li>

                                </ul>
                            </div>
                        </li>
                    @endif


    {{-- GERENCIA DE ADMINISTRACIÓN DE CONTRATOS --}}
                    @if (in_array("128", Session::get('permisos')))
                        <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover" id="menuGerenciaAdministracionContratos">
                            <a href="javascript:;" class="menu-link menu-toggle">
                                <i class="flaticon2-checking menu-icon"></i>
                                <span class="menu-text">Dirección de Administración de Contratos</span>
                                <i class="menu-arrow"></i>
                            </a>
                            <div class="menu-submenu">
                                <i class="menu-arrow"></i>
                                <ul class="menu-subnav">
                                    {{-- ADMINISTRACION DE CONTRATOS --}}
                                    @if (in_array("128", Session::get('permisos')))
                                        <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover" id="menuAdministracionContratos">
                                            <a href="javascript:;" class="menu-link menu-toggle">
                                                <i class="flaticon-folder menu-icon"></i>
                                                <span class="menu-text">Administración de contratos</span>
                                                <i class="menu-arrow"></i>
                                            </a>
                                            <div class="menu-submenu">
                                                <i class="menu-arrow"></i>
                                                <ul class="menu-subnav">
                                                    <li class="menu-item menu-item-parent" aria-haspopup="true">
                                                        <span class="menu-link">
                                                            <span class="menu-text">Administración de contratos</span>
                                                        </span>
                                                    </li>
                                                    @if (in_array("128", Session::get('permisos')))
                                                        <li class="menu-item" aria-haspopup="true" id="menuListadoContratos">
                                                            <a href="{{ route('proyecto.listadoproyectos') }}" class="menu-link">
                                                                <i class="menu-bullet menu-bullet-dot">
                                                                    <span></span>
                                                                </i>
                                                                <span class="menu-text">Listado de contratos</span>
                                                            </a>
                                                        </li>
                                                        <li class="menu-item" aria-haspopup="true" id="menuListadoSolicitudes">
                                                            <a href="{{ route('solicitud.listado') }}" class="menu-link">
                                                                <i class="menu-bullet menu-bullet-dot">
                                                                    <span></span>
                                                                </i>
                                                                <span class="menu-text">Solicitudes GPS</span>
                                                            </a>
                                                        </li>
                                                        
                                                        <li class="menu-item" aria-haspopup="true" id="menuListadoSolicitudesValidacion">
                                                            <a href="{{ route('solicitud.listadoValidacion') }}" class="menu-link">
                                                                <i class="menu-bullet menu-bullet-dot">
                                                                    <span></span>
                                                                </i>
                                                                <span class="menu-text">Área Responsable de GPS</span>
                                                            </a>
                                                        </li>
                                                    @endif
{{--                                                     <li class="menu-item" aria-haspopup="true">
                                                        <a href="{{ route('proyecto.agregar') }}" class="menu-link">
                                                            <i class="menu-bullet menu-bullet-dot">
                                                                <span></span>
                                                            </i>
                                                            <span class="menu-text">Crear Contrato</span>
                                                        </a>
                                                    </li> --}}
                                                </ul>
                                            </div>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </li>
                    @endif
    {{-- GERENCIA DE OPERACIONES --}}
                    @if ((in_array("9", Session::get('permisos')) || in_array("10", Session::get('permisos')) || in_array("21", Session::get('permisos')) ||in_array("124", Session::get('permisos')) || in_array("125", Session::get('permisos'))) && Session::get('role_id') !== 17)
                        <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover" id="menuGerenciaOperaciones">
                            <a href="javascript:;" class="menu-link menu-toggle">
                                <i class="flaticon2-console menu-icon"></i>
                                <span class="menu-text">Dirección de Operaciones</span>
                                <i class="menu-arrow"></i>
                            </a>
                            <div class="menu-submenu">
                                <i class="menu-arrow"></i>
                                <ul class="menu-subnav">
                                    {{-- PARQUE VEHICULAR --}}
                                    @if (in_array("9", Session::get('permisos')) || in_array("10", Session::get('permisos')) )
                                        <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover" id="menuParqueVehicular">
                                            <a href="javascript:;" class="menu-link menu-toggle">
                                                <i class="flaticon-truck menu-icon"></i>
                                                <span class="menu-text">Parque vehícular</span>
                                                <i class="menu-arrow"></i>
                                            </a>
                                            <div class="menu-submenu">
                                                <i class="menu-arrow"></i>
                                                <ul class="menu-subnav">
                                                    @if (in_array("9", Session::get('permisos')))
                                                        <li class="menu-item" aria-haspopup="true" id="menuInventarioVehiculos">
                                                            <a href="{{ route('unidad.catalogounidad') }}" class="menu-link">
                                                                <i class="menu-bullet menu-bullet-dot">
                                                                    <span></span>
                                                                </i>
                                                                <span class="menu-text">Inventario de Vehículos</span>
                                                            </a>
                                                        </li>
                                                    @endif

                                                    {{-- @if (in_array("366", Session::get('permisos'))) --}}
                                                        <li class="menu-item" aria-haspopup="true" id="menuBusqueda">
                                                            <a href="{{ route('busqueda.index') }}" class="menu-link">
                                                                <i class="menu-bullet menu-bullet-dot">
                                                                    <span></span>
                                                                </i>
                                                                <span class="menu-text">Busquedas</span>
                                                            </a>
                                                        </li>
                                                    {{-- @endif --}}

                                                        <li class="menu-item" aria-haspopup="true" id="menuBusqueda">
                                                            <a href="{{ route('busqueda.busqseguros') }}" class="menu-link">
                                                                <i class="menu-bullet menu-bullet-dot">
                                                                    <span></span>
                                                                </i>
                                                                <span class="menu-text">Busquedas Seguros</span>
                                                            </a>
                                                        </li>


                                                 @if (in_array("9", Session::get('permisos')))
                                                        <li class="menu-item" aria-haspopup="true" id="menuInventarioVehiculos">
                                                            <a href="{{ route('fichatecnica.listadofichatecnica') }}" class="menu-link">
                                                                <i class="menu-bullet menu-bullet-dot">
                                                                    <span></span>
                                                                </i>
                                                                <span class="menu-text">Ficha técnica vehículo</span>
                                                            </a>
                                                        </li>
                                                    @endif
                                                    {{-- @if (in_array("9", Session::get('permisos'))) --}}
                                                        <li class="menu-item" aria-haspopup="true" id="submenu_reportes_tramites">
                                                            <a href="{{ route('tramiteReporte.tramites') }}" class="menu-link">
                                                                <i class="menu-bullet menu-bullet-dot">
                                                                    <span></span>
                                                                </i>
                                                                <span class="menu-text">Reportes Gestoría</span>
                                                            </a>
                                                        </li>
                                                    {{-- @endif --}}


                                                </ul>
                                            </div>
                                        </li>
                                    @endif


                                    @if (in_array("21", Session::get('permisos')))
                                        <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover" id="menuPatios">
                                            <a href="javascript:;" class="menu-link menu-toggle">
                                                <i class="flaticon-truck menu-icon"></i>
                                                <span class="menu-text">Patios</span>
                                                <i class="menu-arrow"></i>
                                            </a>
                                            <div class="menu-submenu">
                                                <i class="menu-arrow"></i>
                                                <ul class="menu-subnav">
                                                    @if (in_array("21", Session::get('permisos')))
                                                        <li class="menu-item" aria-haspopup="true" id="menuListadoPatios">
                                                            <a href="{{ route('ubicacion.catalogoubicaciones') }}" class="menu-link">
                                                                <i class="menu-bullet menu-bullet-dot">
                                                                    <span></span>
                                                                </i>
                                                                <span class="menu-text">Listado de patios</span>
                                                            </a>
                                                        </li>
                                                    @endif
                                                </ul>
                                            </div>
                                        </li>
                                    @endif
                                    {{-- ADMINISTRACION DE OPERACIONES --}}

                                    {{-- listado de solicitudes --}}
                                        <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover" id="menuConttolSol">
                                            <a href="javascript:;" class="menu-link menu-toggle">
                                                <i class="flaticon-grid-menu-v2 menu-icon"></i>
                                                <span class="menu-text">Control de solicitudes</span>
                                                <i class="menu-arrow"></i>
                                            </a>
                                            <div class="menu-submenu">
                                                <i class="menu-arrow"></i>
                                                <ul class="menu-subnav">
                                                    @if (in_array("21", Session::get('permisos')))
                                                        <li class="menu-item" aria-haspopup="true" id="menuListadoControlSolicitudes">
                                                            <a href="{{ route('controlsol.controlsolicitudes') }}" class="menu-link">
                                                                <i class="menu-bullet menu-bullet-dot">
                                                                    <span></span>
                                                                </i>
                                                                <span class="menu-text">Listado de solicitudes</span>
                                                            </a>
                                                        </li>
                                                    @endif
                                                </ul>
                                            </div>
                                        </li>
                                    {{-- listado de solicitudes --}}

                                        <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover" id="menuListadoMovimientos">
                                            <a href="javascript:;" class="menu-link menu-toggle">
                                                <i class="flaticon2-browser-2 menu-icon"></i>
                                                <span class="menu-text">Traslados</span>
                                                <i class="menu-arrow"></i>
                                            </a>
                                            <div class="menu-submenu">
                                                <i class="menu-arrow"></i>
                                                <ul class="menu-subnav">
                                                    @if (in_array("131", Session::get('permisos')))
                                                        <li class="menu-item" aria-haspopup="true" id="menuListadoMovlista">
                                                            <a href="{{ route('movimientoslog.listadomovimientos') }}" class="menu-link">
                                                                <i class="menu-bullet menu-bullet-dot">
                                                                    <span></span>
                                                                </i>
                                                                <span class="menu-text">Listado de traslados</span>
                                                            </a>
                                                        </li>
                                                    @endif

                                                    @if (in_array("131", Session::get('permisos')))
                                                        <li class="menu-item" aria-haspopup="true" id="menuListadoMovlistaTransladistas">
                                                            <a href="{{ route('transladistassol.listadomovimientostransladistas') }}" class="menu-link">
                                                                <i class="menu-bullet menu-bullet-dot">
                                                                    <span></span>
                                                                </i>
                                                                <span class="menu-text">Listado de traslados</span>
                                                            </a>
                                                        </li>
                                                    @endif

                                                    @if (in_array("131", Session::get('permisos')))
                                                        <li class="menu-item" aria-haspopup="true" id="menuListadoMovlistaOperador">
                                                            <a href="{{ route('transladooperador.listadotransladooperador') }}" class="menu-link">
                                                                <i class="menu-bullet menu-bullet-dot">
                                                                    <span></span>
                                                                </i>
                                                                <span class="menu-text">Listado de traslados</span>
                                                            </a>
                                                        </li>
                                                    @endif



                                                </ul>
                                            </div>
                                        </li>


                                        <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover" id="asignacionunidades">
                                            <a href="javascript:;" class="menu-link menu-toggle">
                                                <i class="flaticon2-browser-2 menu-icon"></i>
                                                <span class="menu-text">Asignación de unidades</span>
                                                <i class="menu-arrow"></i>
                                            </a>
                                            <div class="menu-submenu">
                                                <i class="menu-arrow"></i>
                                                <ul class="menu-subnav">
                                                    @if (in_array("131", Session::get('permisos')))
                                                        <li class="menu-item" aria-haspopup="true" id="asignarunid">
                                                            <a href="{{ route('asignarunidad.asignacioncontratos') }}" class="menu-link">
                                                                <i class="menu-bullet menu-bullet-dot">
                                                                    <span></span>
                                                                </i>
                                                                <span class="menu-text">Listado de asignaciones</span>
                                                            </a>
                                                        </li>
                                                    @endif
                                                </ul>
                                            </div>
                                        </li>



                                        <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover" id="unidadessustitutas">
                                            <a href="javascript:;" class="menu-link menu-toggle">
                                                <i class="flaticon2-browser-2 menu-icon"></i>
                                                <span class="menu-text">Unidades sustitutas</span>
                                                <i class="menu-arrow"></i>
                                            </a>
                                            <div class="menu-submenu">
                                                <i class="menu-arrow"></i>
                                                <ul class="menu-subnav">
                                                    {{-- @if (in_array("131", Session::get('permisos'))) --}}
                                                        <li class="menu-item" aria-haspopup="true" id="sustitutasid">
                                                            <a href="{{ route('unidadessustitutas.listadounidadessustitutas') }}" class="menu-link">
                                                                <i class="menu-bullet menu-bullet-dot">
                                                                    <span></span>
                                                                </i>
                                                                <span class="menu-text">Listado de solicitudes</span>
                                                            </a>
                                                        </li>
                                                    {{-- @endif --}}

                                                    {{-- @if (in_array("131", Session::get('permisos'))) --}}
                                                        <li class="menu-item" aria-haspopup="true" id="sustitutasidrevision">
                                                            <a href="{{ route('unidadessustitutas.listadosustitutologistica') }}" class="menu-link">
                                                                <i class="menu-bullet menu-bullet-dot">
                                                                    <span></span>
                                                                </i>
                                                                <span class="menu-text">Revision de solicitudes</span>
                                                            </a>
                                                        </li>
                                                    {{-- @endif --}}


                                                </ul>
                                            </div>
                                        </li>


                                        <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover" id="menuListadoRequisicionesOP">
                                            <a href="javascript:;" class="menu-link menu-toggle">
                                                <i class="flaticon2-browser-2 menu-icon"></i>
                                                <span class="menu-text">Requisiciones</span>
                                                <i class="menu-arrow"></i>
                                            </a>
                                            <div class="menu-submenu">
                                                <i class="menu-arrow"></i>
                                                <ul class="menu-subnav">
                                                    @if (in_array("131", Session::get('permisos')))
                                                        <li class="menu-item" aria-haspopup="true" id="menuListadoRequisicionesOperaciones">
                                                            <a href="{{ route('reqoperaciones.catalogorequisicionoperaciones') }}" class="menu-link">
                                                                <i class="menu-bullet menu-bullet-dot">
                                                                    <span></span>
                                                                </i>
                                                                <span class="menu-text">Listado de requisiciones</span>
                                                            </a>
                                                        </li>
                                                    @endif
                                                </ul>
                                            </div>
                                        </li>


                                    @if (in_array("124", Session::get('permisos')) || in_array("125", Session::get('permisos')))
                                        <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover" id="menuTallerMantenimiento">
                                            <a href="javascript:;" class="menu-link menu-toggle">
                                                <i class="flaticon2-gear menu-icon"></i>
                                                <span class="menu-text">Mantenimiento</span>
                                                <i class="menu-arrow"></i>
                                            </a>
                                            <div class="menu-submenu">
                                                <i class="menu-arrow"></i>
                                                <ul class="menu-subnav">
                                                    @if (in_array("124", Session::get('permisos')))
                                                        <li class="menu-item" aria-haspopup="true" id="menuTallerServiciosSolicitados">
                                                            <a href="{{ route('taller.serviciossolicitados') }}" class="menu-link">
                                                                <i class="menu-bullet menu-bullet-dot">
                                                                    <span></span>
                                                                </i>
                                                                <span class="menu-text">Ejecutivo de cuenta</span>
                                                            </a>
                                                        </li>
                                                    @endif

                                                    @if (in_array("124", Session::get('permisos')))
                                                        <li class="menu-item" aria-haspopup="true" id="menuTallerValidacionMantenimientos">
                                                            <a href="{{ route('taller.Validacionmantenimientos') }}" class="menu-link">
                                                                <i class="menu-bullet menu-bullet-dot">
                                                                    <span></span>
                                                                </i>
                                                                <span class="menu-text">Supervisor del ejecutivo de cuenta</span>
                                                            </a>
                                                        </li>
                                                    @endif


                                                    @if (in_array("124", Session::get('permisos')))
                                                        <li class="menu-item" aria-haspopup="true" id="menuTallerValidacionMantenimientosEjecutivo">
                                                            <a href="{{ route('taller.Validacionmantenimientosejecutivo') }}" class="menu-link">
                                                                <i class="menu-bullet menu-bullet-dot">
                                                                    <span></span>
                                                                </i>
                                                                <span class="menu-text">Ejecutivo de mantenimiento</span>
                                                            </a>
                                                        </li>
                                                    @endif



                                                    @if (in_array("124", Session::get('permisos')))
                                                        <li class="menu-item" aria-haspopup="true" id="menuTallerValidacionMantenimientosEjecutivo">
                                                            <a href="{{ route('taller.responsablemantenimiento') }}" class="menu-link">
                                                                <i class="menu-bullet menu-bullet-dot">
                                                                    <span></span>
                                                                </i>
                                                                <span class="menu-text">Responsable de mantenimiento</span>
                                                            </a>
                                                        </li>
                                                    @endif


                                                    <li class="menu-item" aria-haspopup="true" id="menuTallerCatalogotalleres">
                                                        <a href="{{ route('invtaller.inventariotaller') }}" class="menu-link">
                                                            <i class="menu-bullet menu-bullet-dot">
                                                                <span></span>
                                                            </i>
                                                            <span class="menu-text">Listado de talleres</span>
                                                        </a>
                                                    </li>

{{--                                                         <li class="menu-item" aria-haspopup="true" id="menuTallerAsignarContrato">
                                                            <a href="{{ route('taller.asignarcontrato') }}" class="menu-link">
                                                                <i class="menu-bullet menu-bullet-dot">
                                                                    <span></span>
                                                                </i>
                                                                <span class="menu-text">Asignar contrato a ejecutivo</span>
                                                            </a>
                                                        </li>

                                                        <li class="menu-item" aria-haspopup="true" id="menuTallerAsignartallerUsuario">
                                                            <a href="{{ route('taller.asignartallerusuario') }}" class="menu-link">
                                                                <i class="menu-bullet menu-bullet-dot">
                                                                    <span></span>
                                                                </i>
                                                                <span class="menu-text">Asignar taller a usuario</span>
                                                            </a>
                                                        </li> --}}
                                                </ul>
                                            </div>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </li>
                    @endif
    {{-- GERENCIA DE ADMINISTRACIÓN Y FINANZAS --}}
                    @if ( in_array("131", Session::get('permisos')) || in_array("139", Session::get('permisos')) || in_array("365", Session::get('permisos'))  )
                        <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover" id="menuGerenciaFinanzas">
                            <a href="javascript:;" class="menu-link menu-toggle">
                                <i class="flaticon2-chart menu-icon"></i>
                                <span class="menu-text">Dirección de Administración y Finanzas</span>
                                <i class="menu-arrow"></i>
                            </a>
                            <div class="menu-submenu">
                                <i class="menu-arrow"></i>
                                <ul class="menu-subnav">
                                    {{-- ADMINISTRACION DE OPERACIONES --}}
                                    @if ( in_array("131", Session::get('permisos')) || in_array("132", Session::get('permisos')))
                                        <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover" id="menuRequisicionesFinanzas">
                                            <a href="javascript:;" class="menu-link menu-toggle">
                                                <i class="flaticon2-browser-2 menu-icon"></i>
                                                <span class="menu-text">Requisiciones</span>
                                                <i class="menu-arrow"></i>
                                            </a>
                                            <div class="menu-submenu">
                                                <i class="menu-arrow"></i>
                                                <ul class="menu-subnav">
                                                    @if (in_array("131", Session::get('permisos')))
                                                        <li class="menu-item" aria-haspopup="true" id="menuListadoRequisicionesFinanzas">
                                                            <a href="{{ route('finanzas.catalogorequisicion') }}" class="menu-link">
                                                                <i class="menu-bullet menu-bullet-dot">
                                                                    <span></span>
                                                                </i>
                                                                <span class="menu-text">Listado de requisiciones</span>
                                                            </a>
                                                        </li>
                                                    @endif
                                                </ul>
                                            </div>
                                        </li>
                                        <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover" id="menuCatalogoOrdenCompraFin">
                                            <a href="javascript:;" class="menu-link menu-toggle">
                                                <i class="flaticon2-browser-2 menu-icon"></i>
                                                <span class="menu-text">Orden de compra</span>
                                                <i class="menu-arrow"></i>
                                            </a>
                                            <div class="menu-submenu">
                                                <i class="menu-arrow"></i>
                                                <ul class="menu-subnav">
                                                    @if (in_array("139", Session::get('permisos')))
                                                        <li class="menu-item" aria-haspopup="true" id="menuListadoOrdenCompra">
                                                            <a href="{{ route('ordencompra.catalogoordencompra') }}" class="menu-link">
                                                                <i class="menu-bullet menu-bullet-dot">
                                                                    <span></span>
                                                                </i>
                                                                <span class="menu-text">Listado de ordenes de compra</span>
                                                            </a>
                                                        </li>
                                                    @endif
                                                </ul>
                                            </div>
                                        </li>
                                    @endif

                                    @if (in_array("365", Session::get('permisos')))
                                        <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover" id="menuEstimacionesFinanzas">
                                            <a href="javascript:;" class="menu-link menu-toggle">
                                                <i class="flaticon-truck menu-icon"></i>
                                                <span class="menu-text">Estimaciones</span>
                                                <i class="menu-arrow"></i>
                                            </a>
                                            <div class="menu-submenu">
                                                <i class="menu-arrow"></i>
                                                <ul class="menu-subnav">
                                                    @if (in_array("365", Session::get('permisos')))
                                                        <li class="menu-item" aria-haspopup="true" id="menuListadoEstimacionesFinanzas">
                                                            <a href="{{ route('estimacionesfin.catalogoestimaciones') }}" class="menu-link">
                                                                <i class="menu-bullet menu-bullet-dot">
                                                                    <span></span>
                                                                </i>
                                                                <span class="menu-text">Listado de estimaciones</span>
                                                            </a>
                                                        </li>
                                                    @endif
                                                </ul>
                                            </div>
                                        </li>
                                    @endif

                                        <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover" id="menuTallerMantenimientoFinanzas">
                                            <a href="javascript:;" class="menu-link menu-toggle">
                                                <i class="flaticon2-gear menu-icon"></i>
                                                <span class="menu-text">Mantenimiento</span>
                                                <i class="menu-arrow"></i>
                                            </a>
                                            <div class="menu-submenu">
                                                <i class="menu-arrow"></i>
                                                <ul class="menu-subnav">
                                                        <li class="menu-item" aria-haspopup="true" id="menuTallerServiciosSolicitadosFinanzas">
                                                            <a href="{{ route('mantenimientosfin.listadomantenimientfinanzas') }}" class="menu-link">
                                                                <i class="menu-bullet menu-bullet-dot">
                                                                    <span></span>
                                                                </i>
                                                                <span class="menu-text">Listado de mantenimientos</span>
                                                            </a>
                                                        </li>

                                                </ul>
                                            </div>
                                        </li>


                                        <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover" id="menuFincomprasreq">
                                            <a href="javascript:;" class="menu-link menu-toggle">
                                                <i class="flaticon2-checking  menu-icon"></i>
                                                <span class="menu-text">Requisición compras</span>
                                                <i class="menu-arrow"></i>
                                            </a>
                                            <div class="menu-submenu">
                                                <i class="menu-arrow"></i>
                                                <ul class="menu-subnav">
                                                        <li class="menu-item" aria-haspopup="true" id="menuFinreqcompras">
                                                            <a href="{{ route('finreqcompras.finreqcompras') }}" class="menu-link">
                                                                <i class="menu-bullet menu-bullet-dot">
                                                                    <span></span>
                                                                </i>
                                                                <span class="menu-text">Listado de requisiciones</span>
                                                            </a>
                                                        </li>

                                                </ul>
                                            </div>
                                        </li>



                                </ul>
                            </div>
                        </li>
                    @endif

                    {{-- INIT: DIRECCIÓN DE SEMINUEVOS --}}
                    @if ( in_array("131", Session::get('permisos')) || in_array("139", Session::get('permisos')) || in_array("365", Session::get('permisos'))  )
                        <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover" id="menuDireccionSeminuevos">
                            <a href="javascript:;" class="menu-link menu-toggle">
                                <i class="flaticon2-files-and-folders menu-icon"></i>
                                <span class="menu-text">Dirección de Seminuevos</span>
                                <i class="menu-arrow"></i>
                            </a>
                            <div class="menu-submenu">
                                <i class="menu-arrow"></i>
                                <ul class="menu-subnav">
                                    @if (in_array("9", Session::get('permisos')))
                                    <li class="menu-item" aria-haspopup="true" id="menuDireccionSeminuevos_submenu_inventario_vehiculos">
                                        <a href="{{ route('seminuevos.catalogo_vehi') }}" class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">Inventario de Vehículos</span>
                                        </a>
                                    </li>
                                    @endif

                                    <li class="menu-item" aria-haspopup="true" id="menuDireccionSeminuevos_submenu_vehiculos_venta">
                                        <a href="{{ route('seminuevos.catalogoUnidadVenta') }}" class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">Vehículos en Venta</span>
                                        </a>
                                    </li>
                                    <li class="menu-item" aria-haspopup="true" id="_menuDireccionSeminuevos_partado">
                                        <a href="{{ route('seminuevos.catalogoUnidadVentaApartado') }}" class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">Vehículos Apartados</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    @endif
                    {{-- END: DIRECCIÓN DE SEMINUEVOS --}}
                        
    {{-- CATÁLOGOS --}}     @if (Session::get('role_id') !== 17)
                            <li class="menu-section">
                                <h4 class="menu-text">CATÁLOGOS</h4>
                                <i class="menu-icon ki ki-bold-more-hor icon-md"></i>
                            </li>
                        @endif

                   
                        <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover" id="menu_catalogos">
                            @if (Session::get('role_id') !== 17)
                            <a href="javascript:;" class="menu-link menu-toggle">
                                <i class="flaticon2-folder menu-icon"></i>
                                <span class="menu-text">Catálogos</span>
                                <i class="menu-arrow"></i>
                            </a>
                            @endif
                            <div class="menu-submenu">
                                <i class="menu-arrow"></i>
                                <ul class="menu-subnav">

                                @if (in_array("312", Session::get('permisos')))
                                    <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover" id="sub_menu_adminsistema">
                                        <a href="javascript:;" class="menu-link menu-toggle">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">Administración del sistema</span>
                                            <i class="menu-arrow"></i>
                                        </a>
                                        <div class="menu-submenu">
                                            <i class="menu-arrow"></i>
                                            <ul class="menu-subnav">

                                                {{-- Area Personal --}}
                                                @if (in_array("312", Session::get('permisos')))
                                                    <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover" id="sub_sub_menu_area-personal">
                                                        <a href="javascript:;" class="menu-link menu-toggle">
                                                            <i class="menu-bullet menu-bullet-dot">
                                                                <span></span>
                                                            </i>
                                                            <span class="menu-text">Area Personal</span>
                                                            <i class="menu-arrow"></i>
                                                        </a>
                                                        <div class="menu-submenu">
                                                            <i class="menu-arrow"></i>
                                                            <ul class="menu-subnav">
                                                    
                                                                <li class="menu-item" aria-haspopup="true" id="sub_sub_menu_catalogo-listado-area">
                                                                    <a href="{{ route('area.listadoarea') }}" class="menu-link">
                                                                        <i class="menu-bullet menu-bullet-dot">
                                                                            <span></span>
                                                                        </i>
                                                                        <span class="menu-text">Listado de area personal</span>
                                                                    </a>
                                                                </li>
                                                    
                                                            </ul>
                                                        </div>
                                                    </li>
                                                @endif

                                            </ul>
                                        </div>
                                     </li>
                                @endif
                {{-- END CATALOGOS DE ADMINISTRACION DEL SISTEMA --}}

                                @if (in_array("37", Session::get('permisos')) || in_array("41", Session::get('permisos')) || in_array("162", Session::get('permisos')) || in_array("146", Session::get('permisos')) || in_array("150", Session::get('permisos')) || in_array("154", Session::get('permisos')) || in_array("158", Session::get('permisos')) || in_array("166", Session::get('permisos')) || in_array("170", Session::get('permisos')) || in_array("174", Session::get('permisos')) || in_array("178", Session::get('permisos')) || in_array("182", Session::get('permisos')) || in_array("186", Session::get('permisos')) || in_array("190", Session::get('permisos')) || in_array("194", Session::get('permisos')) || in_array("288", Session::get('permisos')) || in_array("65", Session::get('permisos')) || in_array("69", Session::get('permisos')) || in_array("73", Session::get('permisos')) || in_array("77", Session::get('permisos')) || in_array("81", Session::get('permisos')) || in_array("85", Session::get('permisos')) || in_array("89", Session::get('permisos')) || in_array("93", Session::get('permisos')) || in_array("97", Session::get('permisos')) || in_array("101", Session::get('permisos')) || in_array("105", Session::get('permisos')) || in_array("316", Session::get('permisos')) || in_array("320", Session::get('permisos')) || in_array("324", Session::get('permisos')) || in_array("328", Session::get('permisos')) || in_array("332", Session::get('permisos'))  || in_array("336", Session::get('permisos')))
                                    <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover" id="sub_menu_segmento">
                                        <a href="javascript:;" class="menu-link menu-toggle">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">Dirección comercial</span>
                                            <i class="menu-arrow"></i>
                                        </a>
                                        <div class="menu-submenu">
                                            <i class="menu-arrow"></i>
                                            <ul class="menu-subnav">

                                                @if (in_array("37", Session::get('permisos')))
                                                    <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover" id="sub_sub_menu_estados">
                                                        <a href="javascript:;" class="menu-link menu-toggle">
                                                            <i class="menu-bullet menu-bullet-dot">
                                                                <span></span>
                                                            </i>
                                                            <span class="menu-text">Estados</span>
                                                            <i class="menu-arrow"></i>
                                                        </a>
                                                        <div class="menu-submenu">
                                                            <i class="menu-arrow"></i>
                                                            <ul class="menu-subnav">


                                                                <li class="menu-item" aria-haspopup="true" id="sub_sub_menu_catalogo_estados">
                                                                    <a href="{{ route('cliente.catalogoEstado') }}" class="menu-link">
                                                                        <i class="menu-bullet menu-bullet-dot">
                                                                            <span></span>
                                                                        </i>
                                                                        <span class="menu-text">Listado de Estados</span>
                                                                    </a>
                                                                </li>

                                                            </ul>
                                                        </div>
                                                    </li>
                                                @endif

                                                @if (in_array("41", Session::get('permisos')))
                                                    <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover" id="sub_sub_menu_municipios">
                                                        <a href="javascript:;" class="menu-link menu-toggle">
                                                            <i class="menu-bullet menu-bullet-dot">
                                                                <span></span>
                                                            </i>
                                                            <span class="menu-text">Municipios</span>
                                                            <i class="menu-arrow"></i>
                                                        </a>
                                                        <div class="menu-submenu">
                                                            <i class="menu-arrow"></i>
                                                            <ul class="menu-subnav">

                                                                <li class="menu-item" aria-haspopup="true" id="sub_sub_menu_catalogo_municipios">
                                                                    <a href="{{ route('cliente.catalogoMunicipio') }}" class="menu-link">
                                                                        <i class="menu-bullet menu-bullet-dot">
                                                                            <span></span>
                                                                        </i>
                                                                        <span class="menu-text">Listado de Municipios</span>
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </li>
                                                @endif

                                                @if (in_array("162", Session::get('permisos')))
                                                    <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover" id="sub_sub_menu_documentos">
                                                        <a href="javascript:;" class="menu-link menu-toggle">
                                                            <i class="menu-bullet menu-bullet-dot">
                                                                <span></span>
                                                            </i>
                                                            <span class="menu-text">Documentos del cliente</span>
                                                            <i class="menu-arrow"></i>
                                                        </a>
                                                        <div class="menu-submenu">
                                                            <i class="menu-arrow"></i>
                                                            <ul class="menu-subnav">

                                                                <li class="menu-item" aria-haspopup="true" id="sub_sub_menu_catalogo_documentos">
                                                                    <a href="{{ route('doccliente.catalogoDocumentos') }}" class="menu-link">
                                                                        <i class="menu-bullet menu-bullet-dot">
                                                                            <span></span>
                                                                        </i>
                                                                        <span class="menu-text">Listado de tipo de documentos</span>
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </li>
                                                @endif

                                                @if (in_array("146", Session::get('permisos')))
                                                    <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover" id="sub_sub_menu_listado-proyectos">
                                                            <a href="javascript:;" class="menu-link menu-toggle">
                                                                <i class="menu-bullet menu-bullet-dot">
                                                                    <span></span>
                                                                </i>
                                                                <span class="menu-text">Documentos del concurso</span>
                                                                <i class="menu-arrow"></i>
                                                            </a>
                                                            <div class="menu-submenu">
                                                                <i class="menu-arrow"></i>
                                                                <ul class="menu-subnav">

                                                                    <li class="menu-item" aria-haspopup="true" id="sub_sub_menu_catalogo_proyectos">
                                                                        <a href="{{ route('documentos.listadodocumentos') }}" class="menu-link">
                                                                            <i class="menu-bullet menu-bullet-dot">
                                                                            </i>
                                                                            <span class="menu-text">Listado de Documentos</span>
                                                                        </a>
                                                                    </li>

                                                                </ul>
                                                            </div>
                                                    </li>
                                                @endif

                                                @if (in_array("150", Session::get('permisos')))
                                                    <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover" id="sub_sub_menu_listado-publicacion">
                                                        <a href="javascript:;" class="menu-link menu-toggle">
                                                            <i class="menu-bullet menu-bullet-dot">
                                                                <span></span>
                                                            </i>
                                                            <span class="menu-text">Publicación de Concurso</span>
                                                            <i class="menu-arrow"></i>
                                                        </a>
                                                        <div class="menu-submenu">
                                                            <i class="menu-arrow"></i>
                                                            <ul class="menu-subnav">

                                                                <li class="menu-item" aria-haspopup="true" id="sub_sub_menu_catalogo_publicacion">
                                                                    <a href="{{ route('publicacion.listadopublicacion') }}" class="menu-link">
                                                                        <i class="menu-bullet menu-bullet-dot">
                                                                            <span></span>
                                                                        </i>
                                                                        <span class="menu-text">Listado de Publicación de Concurso</span>
                                                                    </a>
                                                                </li>

                                                            </ul>
                                                        </div>
                                                    </li>
                                                @endif

                                                @if (in_array("154", Session::get('permisos')))
                                                    <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover" id="sub_sub_menu_listado-tiposcontratacion">
                                                        <a href="javascript:;" class="menu-link menu-toggle">
                                                            <i class="menu-bullet menu-bullet-dot">
                                                                <span></span>
                                                            </i>
                                                            <span class="menu-text">Tipos de Contratación</span>
                                                            <i class="menu-arrow"></i>
                                                        </a>
                                                        <div class="menu-submenu">
                                                            <i class="menu-arrow"></i>
                                                            <ul class="menu-subnav">

                                                                <li class="menu-item" aria-haspopup="true" id="sub_sub_menu_catalogo_tiposcontratacion">
                                                                    <a href="{{ route('contratacion.listadotipocontratacion') }}" class="menu-link">
                                                                        <i class="menu-bullet menu-bullet-dot">
                                                                            <span></span>
                                                                        </i>
                                                                        <span class="menu-text">Listado de Tipos de Contratación</span>
                                                                    </a>
                                                                </li>

                                                            </ul>
                                                        </div>
                                                    </li>
                                                @endif

                                                @if (in_array("158", Session::get('permisos')))
                                                    <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover" id="sub_sub_menu_listado-tipodedocumento">
                                                        <a href="javascript:;" class="menu-link menu-toggle">
                                                            <i class="menu-bullet menu-bullet-dot">
                                                                 <span></span>
                                                            </i>
                                                            <span class="menu-text">Tipo de documento del contrato</span>
                                                            <i class="menu-arrow"></i>
                                                        </a>
                                                        <div class="menu-submenu">
                                                            <i class="menu-arrow"></i>
                                                            <ul class="menu-subnav">

                                                                <li class="menu-item" aria-haspopup="true" id="sub_sub_menu_catalogo_tipodedocumento">
                                                                    <a href="{{ route('tipodoc.listadotipodocumento') }}" class="menu-link">
                                                                        <i class="menu-bullet menu-bullet-dot">
                                                                        </i>
                                                                        <span class="menu-text">Listado de Documentos</span>
                                                                    </a>
                                                                </li>

                                                            </ul>
                                                        </div>
                                                    </li>
                                                @endif

                                                @if (in_array("166", Session::get('permisos')))
                                                    <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover" id="sub_sub_menu_listado-emisores">
                                                        <a href="javascript:;" class="menu-link menu-toggle">
                                                            <i class="menu-bullet menu-bullet-dot">
                                                                <span></span>
                                                        </i>
                                                            <span class="menu-text">Administradores de Contratos</span>
                                                            <i class="menu-arrow"></i>
                                                        </a>
                                                        <div class="menu-submenu">
                                                            <i class="menu-arrow"></i>
                                                            <ul class="menu-subnav">

                                                                <li class="menu-item" aria-haspopup="true" id="sub_sub_menu_catalogo_emisores">
                                                                    <a href="{{ route('emisores.listadoemisores') }}" class="menu-link">
                                                                        <i class="menu-bullet menu-bullet-dot">
                                                                            <span></span>
                                                                        </i>
                                                                        <span class="menu-text">Listado de Administradores de Contratos</span>
                                                                    </a>
                                                                </li>

                                                            </ul>
                                                        </div>
                                                    </li>
                                                @endif

                                                {{-- Convenio modificatorio --}}
                                                @if (in_array("170", Session::get('permisos')))
                                                    <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover" id="sub_sub_menu_conveniomodificatorio">
                                                        <a href="javascript:;" class="menu-link menu-toggle">
                                                            <i class="menu-bullet menu-bullet-dot">
                                                                <span></span>
                                                            </i>
                                                            <span class="menu-text">Tipo de convenio modificatorio</span>
                                                            <i class="menu-arrow"></i>
                                                        </a>
                                                        <div class="menu-submenu">
                                                            <i class="menu-arrow"></i>
                                                            <ul class="menu-subnav">
                                        
                                                                <li class="menu-item" aria-haspopup="true" id="sub_sub_menu_catalogo-conveniomodificatorio">
                                                                    <a href="{{ route('conveniom.listadoconveniomodificatorio') }}" class="menu-link">
                                                                        <i class="menu-bullet menu-bullet-dot">
                                                                            <span></span>
                                                                        </i>
                                                                        <span class="menu-text">Listado de convenio modificatorio</span>
                                                                    </a>
                                                                </li>
                                        
                                                            </ul>
                                                        </div>
                                                    </li>
                                                @endif
                                                {{-- Tipo de fianza --}}
                                                @if (in_array("174", Session::get('permisos')))
                                                    <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover" id="sub_sub_menu_tipofianza">
                                                        <a href="javascript:;" class="menu-link menu-toggle">
                                                            <i class="menu-bullet menu-bullet-dot">
                                                                <span></span>
                                                            </i>
                                                            <span class="menu-text">Tipo de fianza</span>
                                                            <i class="menu-arrow"></i>
                                                        </a>
                                                        <div class="menu-submenu">
                                                            <i class="menu-arrow"></i>
                                                            <ul class="menu-subnav">
                                        
                                                                <li class="menu-item" aria-haspopup="true" id="sub_sub_menu_catalogo-tipofianza">
                                                                    <a href="{{ route('tipofianza.listadocatalogoatipodfianza') }}" class="menu-link">
                                                                        <i class="menu-bullet menu-bullet-dot">
                                                                            <span></span>
                                                                        </i>
                                                                        <span class="menu-text">Listado de tipos de fianzas</span>
                                                                    </a>
                                                                </li>
                                        
                                                            </ul>
                                                        </div>
                                                    </li>
                                                @endif

                                                {{-- Grupo y Subgrupo requisiciones --}}
                                                @if (in_array("178", Session::get('permisos')) || in_array("182", Session::get('permisos')) || in_array("186", Session::get('permisos')) || in_array("190", Session::get('permisos')) || in_array("194", Session::get('permisos')))
                                                    <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover" id="sub_sub_menu_requisicion-partidas">
                                                        <a href="javascript:;" class="menu-link menu-toggle">
                                                            <i class="menu-bullet menu-bullet-dot">
                                                                <span></span>
                                                            </i>
                                                            <span class="menu-text">Requisicion Partidas</span>
                                                            <i class="menu-arrow"></i>
                                                        </a>
                                                        <div class="menu-submenu">
                                                            <i class="menu-arrow"></i>
                                                            <ul class="menu-subnav">
                                                                @if (in_array("178", Session::get('permisos')))
                                                                    <li class="menu-item" aria-haspopup="true" id="sub_sub_menu_catalogo-grupo">
                                                                        <a href="{{ route('grupo.listadocatalogogrupo') }}" class="menu-link">
                                                                            <i class="menu-bullet menu-bullet-dot">
                                                                                <span></span>
                                                                            </i>
                                                                            <span class="menu-text">Listado de Equipamiento</span>
                                                                        </a>
                                                                    </li>
                                                                @endif
                                                                @if (in_array("182", Session::get('permisos')))
                                                                    <li class="menu-item" aria-haspopup="true" id="sub_sub_menu_catalogo-tipotransporte">
                                                                        <a href="{{ route('tipotransporte.listadocatalogotipotransporte') }}" class="menu-link">
                                                                            <i class="menu-bullet menu-bullet-dot">
                                                                                <span></span>
                                                                            </i>
                                                                            <span class="menu-text">Listado de tipo de transporte</span>
                                                                        </a>
                                                                    </li>
                                                                @endif
                                                                @if (in_array("186", Session::get('permisos')))
                                                                    <li class="menu-item" aria-haspopup="true" id="sub_sub_menu_catalogo-entidadfederativa">
                                                                        <a href="{{ route('entidadfederativa.listadocatalogoentidadfederativa') }}" class="menu-link">
                                                                            <i class="menu-bullet menu-bullet-dot">
                                                                                <span></span>
                                                                            </i>
                                                                            <span class="menu-text">Listado de entidad federativa</span>
                                                                        </a>
                                                                    </li>
                                                                @endif
                                                                @if (in_array("190", Session::get('permisos')))
                                                                    <li class="menu-item" aria-haspopup="true" id="sub_sub_menu_catalogo-tipoplacas">
                                                                        <a href="{{ route('tipoplacas.listadocatalogotipoplacas') }}" class="menu-link">
                                                                            <i class="menu-bullet menu-bullet-dot">
                                                                                <span></span>
                                                                            </i>
                                                                            <span class="menu-text">Listado de tipo de placas</span>
                                                                        </a>
                                                                    </li>
                                                                @endif
                                                                @if (in_array("194", Session::get('permisos')))
                                                                    <li class="menu-item" aria-haspopup="true" id="sub_sub_menu_catalogo-combustible">
                                                                        <a href="{{ route('combustible.listadocatalogocombustible') }}" class="menu-link">
                                                                            <i class="menu-bullet menu-bullet-dot">
                                                                                <span></span>
                                                                            </i>
                                                                            <span class="menu-text">Listado de tipo de combustible</span>
                                                                        </a>
                                                                    </li>
                                                                @endif
                                                            </ul>
                                                        </div>
                                                    </li>
                                                @endif

                                                {{-- Afianzadora --}}
                                                @if (in_array("288", Session::get('permisos')))
                                                    <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover" id="sub_sub_menu_afianzadora">
                                                        <a href="javascript:;" class="menu-link menu-toggle">
                                                            <i class="menu-bullet menu-bullet-dot">
                                                                <span></span>
                                                            </i>
                                                            <span class="menu-text">Afianzadora</span>
                                                            <i class="menu-arrow"></i>
                                                        </a>
                                                        <div class="menu-submenu">
                                                            <i class="menu-arrow"></i>
                                                            <ul class="menu-subnav">
                                                    
                                                                <li class="menu-item" aria-haspopup="true" id="sub_sub_menu_catalogo-afianzadora">
                                                                    <a href="{{ route('afianzadora.listadocatalogoafianzadora') }}" class="menu-link">
                                                                        <i class="menu-bullet menu-bullet-dot">
                                                                            <span></span>
                                                                        </i>
                                                                        <span class="menu-text">Listado de afianzadoras</span>
                                                                    </a>
                                                                </li>
                                                    
                                                            </ul>
                                                        </div>
                                                    </li>
                                                @endif

{{--                                                 <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
                                                    <a href="javascript:;" class="menu-link menu-toggle">
                                                        <i class="menu-bullet menu-bullet-dot">
                                                            <span></span>
                                                        </i>
                                                        <span class="menu-text">Segmentos</span>
                                                        <i class="menu-arrow"></i>
                                                    </a>
                                                    <div class="menu-submenu">
                                                        <i class="menu-arrow"></i>
                                                        <ul class="menu-subnav">

                                                            <li class="menu-item" aria-haspopup="true">
                                                                <a href="{{ route('segmento.catalogosegmentos') }}" class="menu-link">
                                                                    <i class="menu-bullet menu-bullet-dot">
                                                                        <span></span>
                                                                    </i>
                                                                    <span class="menu-text">Listado de segmentos</span>
                                                                </a>
                                                            </li>

                                                        </ul>
                                                    </div>
                                                </li> --}}
                                            {{-- END Segmentos --}}
                                                @if (in_array("65", Session::get('permisos')))
                                                    <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover" id="sub_sub_menu_tipovehiculos">
                                                        <a href="javascript:;" class="menu-link menu-toggle">
                                                            <i class="menu-bullet menu-bullet-dot">
                                                                <span></span>
                                                            </i>
                                                            <span class="menu-text">Tipos de vehículos</span>
                                                            <i class="menu-arrow"></i>
                                                        </a>
                                                        <div class="menu-submenu">
                                                            <i class="menu-arrow"></i>
                                                            <ul class="menu-subnav">

                                                                <li class="menu-item" aria-haspopup="true" id="sub_sub_menu_catalogo_tipovehiculos">
                                                                    <a href="{{ route('tipovehiculo.catalotipovehiculo') }}" class="menu-link">
                                                                        <i class="menu-bullet menu-bullet-dot">
                                                                            <span></span>
                                                                        </i>
                                                                        <span class="menu-text">Listado de tipos de vehículos</span>
                                                                    </a>
                                                                </li>

                                                            </ul>
                                                        </div>
                                                    </li>
                                                @endif
                                            {{-- END TIPOS DE VEHICULOS --}}
                                                @if (in_array("69", Session::get('permisos')))
                                                    <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover" id="sub_sub_menu_puertas">
                                                        <a href="javascript:;" class="menu-link menu-toggle">
                                                            <i class="menu-bullet menu-bullet-dot">
                                                                <span></span>
                                                            </i>
                                                            <span class="menu-text">Puertas</span>
                                                            <i class="menu-arrow"></i>
                                                        </a>
                                                        <div class="menu-submenu">
                                                            <i class="menu-arrow"></i>
                                                            <ul class="menu-subnav">

                                                                <li class="menu-item" aria-haspopup="true" id="sub_sub_menu_catalogo_puertas">
                                                                    <a href="{{ route('puerta.catalopuertas') }}" class="menu-link">
                                                                        <i class="menu-bullet menu-bullet-dot">
                                                                            <span></span>
                                                                        </i>
                                                                        <span class="menu-text">Listado de puertas</span>
                                                                    </a>
                                                                </li>

                                                            </ul>
                                                        </div>
                                                    </li>
                                                @endif
                                            {{-- END PUERTAS --}}
                                                @if (in_array("73", Session::get('permisos')))
                                                    <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover" id="sub_sub_menu_carroceria">
                                                        <a href="javascript:;" class="menu-link menu-toggle">
                                                            <i class="menu-bullet menu-bullet-dot">
                                                                <span></span>
                                                            </i>
                                                            <span class="menu-text">Carrocería</span>
                                                            <i class="menu-arrow"></i>
                                                        </a>
                                                        <div class="menu-submenu">
                                                            <i class="menu-arrow"></i>
                                                            <ul class="menu-subnav">

                                                                <li class="menu-item" aria-haspopup="true" id="sub_sub_menu_catalogo_carroceria">
                                                                    <a href="{{ route('carroceria.catalogocarroceria') }}" class="menu-link" id="">
                                                                        <i class="menu-bullet menu-bullet-dot">
                                                                            <span></span>
                                                                        </i>
                                                                        <span class="menu-text">Listado de carrocería</span>
                                                                    </a>
                                                                </li>

                                                            </ul>
                                                        </div>
                                                    </li>
                                                @endif
                                            {{-- END parte1 --}}
                                                @if (in_array("77", Session::get('permisos')))
                                                    <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover" id="sub_sub_menu_no-cilindros">
                                                        <a href="javascript:;" class="menu-link menu-toggle">
                                                            <i class="menu-bullet menu-bullet-dot">
                                                                <span></span>
                                                            </i>
                                                            <span class="menu-text">Número de cilindros</span>
                                                            <i class="menu-arrow"></i>
                                                        </a>
                                                        <div class="menu-submenu">
                                                            <i class="menu-arrow"></i>
                                                            <ul class="menu-subnav">

                                                                <li class="menu-item" aria-haspopup="true" id="sub_sub_menu_catalogo_no-cilindros">
                                                                    <a href="{{ route('nocilindros.catalogonocilindros') }}" class="menu-link">
                                                                        <i class="menu-bullet menu-bullet-dot">
                                                                            <span></span>
                                                                        </i>
                                                                        <span class="menu-text">Listado de número de cilindros</span>
                                                                    </a>
                                                                </li>

                                                            </ul>
                                                        </div>
                                                    </li>
                                                @endif

                                            {{-- END NO. CILINDROS --}}
{{--                                                 <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
                                                    <a href="javascript:;" class="menu-link menu-toggle">
                                                        <i class="menu-bullet menu-bullet-dot">
                                                            <span></span>
                                                        </i>
                                                        <span class="menu-text">Cilindros</span>
                                                        <i class="menu-arrow"></i>
                                                    </a>
                                                    <div class="menu-submenu">
                                                        <i class="menu-arrow"></i>
                                                        <ul class="menu-subnav">

                                                            <li class="menu-item" aria-haspopup="true">
                                                                <a href="{{ route('cilindros.catalogocilindros') }}" class="menu-link">
                                                                    <i class="menu-bullet menu-bullet-dot">
                                                                        <span></span>
                                                                    </i>
                                                                    <span class="menu-text">Listado de cilindros</span>
                                                                </a>
                                                            </li>

                                                        </ul>
                                                    </div>
                                                </li> --}}
                                            {{-- END CILINDROS --}}
                                                @if (in_array("81", Session::get('permisos')))
                                                    <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover" id="sub_sub_menu_pasajeros">
                                                        <a href="javascript:;" class="menu-link menu-toggle">
                                                            <i class="menu-bullet menu-bullet-dot">
                                                                <span></span>
                                                            </i>
                                                            <span class="menu-text">Pasajeros</span>
                                                            <i class="menu-arrow"></i>
                                                        </a>
                                                        <div class="menu-submenu">
                                                            <i class="menu-arrow"></i>
                                                            <ul class="menu-subnav">

                                                                <li class="menu-item" aria-haspopup="true" id="sub_sub_menu_catalogo_pasajeros">
                                                                    <a href="{{ route('pasajero.catalogopasajeros') }}" class="menu-link">
                                                                        <i class="menu-bullet menu-bullet-dot">
                                                                            <span></span>
                                                                        </i>
                                                                        <span class="menu-text">Listado de pasajeros</span>
                                                                    </a>
                                                                </li>

                                                            </ul>
                                                        </div>
                                                    </li>
                                                @endif
                                            {{-- END PASAJEROS --}}
                                                @if (in_array("85", Session::get('permisos')))
                                                    <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover" id="sub_sub_menu_motor">
                                                        <a href="javascript:;" class="menu-link menu-toggle">
                                                            <i class="menu-bullet menu-bullet-dot">
                                                                <span></span>
                                                            </i>
                                                            <span class="menu-text">Motor</span>
                                                            <i class="menu-arrow"></i>
                                                        </a>
                                                        <div class="menu-submenu">
                                                            <i class="menu-arrow"></i>
                                                            <ul class="menu-subnav">

                                                                <li class="menu-item" aria-haspopup="true" id="sub_sub_menu_catalogo_motor">
                                                                    <a href="{{ route('motor.catalogomotor') }}" class="menu-link">
                                                                        <i class="menu-bullet menu-bullet-dot">
                                                                            <span></span>
                                                                        </i>
                                                                        <span class="menu-text">Listado de motores</span>
                                                                    </a>
                                                                </li>

                                                            </ul>
                                                        </div>
                                                    </li>
                                                @endif
                                            {{-- END Motor --}}
                                                @if (in_array("89", Session::get('permisos')))
                                                    <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover" id="sub_sub_menu_llanta-refaccion">
                                                        <a href="javascript:;" class="menu-link menu-toggle">
                                                            <i class="menu-bullet menu-bullet-dot">
                                                                <span></span>
                                                            </i>
                                                            <span class="menu-text">Llanta Refacción</span>
                                                            <i class="menu-arrow"></i>
                                                        </a>
                                                        <div class="menu-submenu">
                                                            <i class="menu-arrow"></i>
                                                            <ul class="menu-subnav">

                                                                <li class="menu-item" aria-haspopup="true" id="sub_sub_menu_catalogo_llanta-refaccion">
                                                                    <a href="{{ route('llantar.catalogollantarefaccion') }}" class="menu-link">
                                                                        <i class="menu-bullet menu-bullet-dot">
                                                                            <span></span>
                                                                        </i>
                                                                        <span class="menu-text">Listado de llanta de refacción</span>
                                                                    </a>
                                                                </li>

                                                            </ul>
                                                        </div>
                                                    </li>
                                                @endif
                                            {{-- END Llanta de refaccion --}}
                                                @if (in_array("93", Session::get('permisos')))
                                                    <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover" id="sub_sub_menu_espejos-laterales">
                                                        <a href="javascript:;" class="menu-link menu-toggle">
                                                            <i class="menu-bullet menu-bullet-dot">
                                                                <span></span>
                                                            </i>
                                                            <span class="menu-text">Espejos Laterales</span>
                                                            <i class="menu-arrow"></i>
                                                        </a>
                                                        <div class="menu-submenu">
                                                            <i class="menu-arrow"></i>
                                                            <ul class="menu-subnav">

                                                                <li class="menu-item" aria-haspopup="true" id="sub_sub_menu_catalogo_espejos-laterales">
                                                                    <a href="{{ route('espejosl.catalogoespejoslaterales') }}" class="menu-link">
                                                                        <i class="menu-bullet menu-bullet-dot">
                                                                            <span></span>
                                                                        </i>
                                                                        <span class="menu-text">Listado de espejos laterales</span>
                                                                    </a>
                                                                </li>

                                                            </ul>
                                                        </div>
                                                    </li>
                                                @endif
                                            {{-- END espejos laterales --}}
                                                @if (in_array("97", Session::get('permisos')))
                                                    <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover" id="sub_sub_menu_accesorios">
                                                        <a href="javascript:;" class="menu-link menu-toggle">
                                                            <i class="menu-bullet menu-bullet-dot">
                                                                <span></span>
                                                            </i>
                                                            <span class="menu-text">Accesorios</span>
                                                            <i class="menu-arrow"></i>
                                                        </a>
                                                        <div class="menu-submenu">
                                                            <i class="menu-arrow"></i>
                                                            <ul class="menu-subnav">

                                                                <li class="menu-item" aria-haspopup="true" id="sub_sub_menu_catalogo_accesorios">
                                                                    <a href="{{ route('accesorios.catalogoaccesorios') }}" class="menu-link">
                                                                        <i class="menu-bullet menu-bullet-dot">
                                                                            <span></span>
                                                                        </i>
                                                                        <span class="menu-text">Listado de accesorios</span>
                                                                    </a>
                                                                </li>

                                                            </ul>
                                                        </div>
                                                    </li>
                                                @endif
                                            {{-- END Accesorios --}}
                                                @if (in_array("101", Session::get('permisos')))
                                                    <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover" id="sub_sub_menu_potencia">
                                                        <a href="javascript:;" class="menu-link menu-toggle">
                                                            <i class="menu-bullet menu-bullet-dot">
                                                                <span></span>
                                                            </i>
                                                            <span class="menu-text">Potencia</span>
                                                            <i class="menu-arrow"></i>
                                                        </a>
                                                        <div class="menu-submenu">
                                                            <i class="menu-arrow"></i>
                                                            <ul class="menu-subnav">

                                                                <li class="menu-item" aria-haspopup="true" id="sub_sub_menu_catalogo_potencia">
                                                                    <a href="{{ route('potencia.catalogopotencia') }}" class="menu-link">
                                                                        <i class="menu-bullet menu-bullet-dot">
                                                                            <span></span>
                                                                        </i>
                                                                        <span class="menu-text">Listado de potencia</span>
                                                                    </a>
                                                                </li>

                                                            </ul>
                                                        </div>
                                                    </li>
                                                @endif
                                            {{-- END Potencia --}}
                                                @if (in_array("105", Session::get('permisos')))
                                                    <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover" id="sub_sub_menu_transmision">
                                                        <a href="javascript:;" class="menu-link menu-toggle">
                                                            <i class="menu-bullet menu-bullet-dot">
                                                                <span></span>
                                                            </i>
                                                            <span class="menu-text">Transmisión</span>
                                                            <i class="menu-arrow"></i>
                                                        </a>
                                                        <div class="menu-submenu">
                                                            <i class="menu-arrow"></i>
                                                            <ul class="menu-subnav">

                                                                <li class="menu-item" aria-haspopup="true" id="sub_sub_menu_catalogo_transmision">
                                                                    <a href="{{ route('transmision.catalogotransmision') }}" class="menu-link">
                                                                        <i class="menu-bullet menu-bullet-dot">
                                                                            <span></span>
                                                                        </i>
                                                                        <span class="menu-text">Listado de transmisión</span>
                                                                    </a>
                                                                </li>

                                                            </ul>
                                                        </div>
                                                    </li>
                                                @endif
                                            {{-- END Transmision --}}
                                                @if (in_array("316", Session::get('permisos')))
                                                    <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover" id="sub_sub_menu_radio">
                                                        <a href="javascript:;" class="menu-link menu-toggle">
                                                            <i class="menu-bullet menu-bullet-dot">
                                                                <span></span>
                                                            </i>
                                                            <span class="menu-text">Radio</span>
                                                            <i class="menu-arrow"></i>
                                                        </a>
                                                        <div class="menu-submenu">
                                                            <i class="menu-arrow"></i>
                                                            <ul class="menu-subnav">

                                                                <li class="menu-item" aria-haspopup="true" id="sub_sub_menu_catalogo_radio">
                                                                    <a href="{{ route('radio.catalogoradio') }}" class="menu-link">
                                                                        <i class="menu-bullet menu-bullet-dot">
                                                                            <span></span>
                                                                        </i>
                                                                        <span class="menu-text">Listado de radio</span>
                                                                    </a>
                                                                </li>

                                                            </ul>
                                                        </div>
                                                    </li>
                                                @endif
                                            {{-- END Radio --}}
                                                @if (in_array("320", Session::get('permisos')))
                                                    <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover" id="sub_sub_menu_direccion">
                                                        <a href="javascript:;" class="menu-link menu-toggle">
                                                            <i class="menu-bullet menu-bullet-dot">
                                                                <span></span>
                                                            </i>
                                                            <span class="menu-text">Dirección</span>
                                                            <i class="menu-arrow"></i>
                                                        </a>
                                                        <div class="menu-submenu">
                                                            <i class="menu-arrow"></i>
                                                            <ul class="menu-subnav">

                                                                <li class="menu-item" aria-haspopup="true" id="sub_sub_menu_catalogo_direccion">
                                                                    <a href="{{ route('direccion.catalogodireccion') }}" class="menu-link">
                                                                        <i class="menu-bullet menu-bullet-dot">
                                                                            <span></span>
                                                                        </i>
                                                                        <span class="menu-text">Listado de direccion</span>
                                                                    </a>
                                                                </li>

                                                            </ul>
                                                        </div>
                                                    </li>
                                                @endif
                                            {{-- END Radio --}}
                                                @if (in_array("324", Session::get('permisos')))
                                                    <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover" id="sub_sub_menu_blindaje">
                                                        <a href="javascript:;" class="menu-link menu-toggle">
                                                            <i class="menu-bullet menu-bullet-dot">
                                                                <span></span>
                                                            </i>
                                                            <span class="menu-text">Blindaje</span>
                                                            <i class="menu-arrow"></i>
                                                        </a>
                                                        <div class="menu-submenu">
                                                            <i class="menu-arrow"></i>
                                                            <ul class="menu-subnav">

                                                                <li class="menu-item" aria-haspopup="true" id="sub_sub_menu_catalogo_blindaje">
                                                                    <a href="{{ route('blindaje.catalogoblindaje') }}" class="menu-link">
                                                                        <i class="menu-bullet menu-bullet-dot">
                                                                            <span></span>
                                                                        </i>
                                                                        <span class="menu-text">Listado de blindaje</span>
                                                                    </a>
                                                                </li>

                                                            </ul>
                                                        </div>
                                                    </li>
                                                @endif
                                            {{-- END Blindaje --}}
                                                @if (in_array("328", Session::get('permisos')))
                                                    <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover" id="sub_sub_menu_capacidad">
                                                        <a href="javascript:;" class="menu-link menu-toggle">
                                                            <i class="menu-bullet menu-bullet-dot">
                                                                <span></span>
                                                            </i>
                                                            <span class="menu-text">Capacidad</span>
                                                            <i class="menu-arrow"></i>
                                                        </a>
                                                        <div class="menu-submenu">
                                                            <i class="menu-arrow"></i>
                                                            <ul class="menu-subnav">

                                                                <li class="menu-item" aria-haspopup="true" id="sub_sub_menu_catalogo_capacidad">
                                                                    <a href="{{ route('capacidad.catalogocapacidad') }}" class="menu-link">
                                                                        <i class="menu-bullet menu-bullet-dot">
                                                                            <span></span>
                                                                        </i>
                                                                        <span class="menu-text">Listado de capacidad</span>
                                                                    </a>
                                                                </li>

                                                            </ul>
                                                        </div>
                                                    </li>
                                                @endif
                                            {{-- END Capacidad --}}
                                                @if (in_array("332", Session::get('permisos')))
                                                    <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover" id="sub_sub_menu_gps">
                                                        <a href="javascript:;" class="menu-link menu-toggle">
                                                            <i class="menu-bullet menu-bullet-dot">
                                                                <span></span>
                                                            </i>
                                                            <span class="menu-text">Gps</span>
                                                            <i class="menu-arrow"></i>
                                                        </a>
                                                        <div class="menu-submenu">
                                                            <i class="menu-arrow"></i>
                                                            <ul class="menu-subnav">

                                                                <li class="menu-item" aria-haspopup="true" id="sub_sub_menu_catalogo_gps">
                                                                    <a href="{{ route('gps.catalogogps') }}" class="menu-link">
                                                                        <i class="menu-bullet menu-bullet-dot">
                                                                            <span></span>
                                                                        </i>
                                                                        <span class="menu-text">Listado de gps</span>
                                                                    </a>
                                                                </li>

                                                            </ul>
                                                        </div>
                                                    </li>
                                                @endif
                                            {{-- END GPS --}}
                                                @if (in_array("336", Session::get('permisos')))
                                                    <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover" id="sub_sub_menu_eninventario">
                                                        <a href="javascript:;" class="menu-link menu-toggle">
                                                            <i class="menu-bullet menu-bullet-dot">
                                                                <span></span>
                                                            </i>
                                                            <span class="menu-text">En Inventario</span>
                                                            <i class="menu-arrow"></i>
                                                        </a>
                                                        <div class="menu-submenu">
                                                            <i class="menu-arrow"></i>
                                                            <ul class="menu-subnav">

                                                                <li class="menu-item" aria-haspopup="true" id="sub_sub_menu_catalogo_eninventario">
                                                                    <a href="{{ route('inventario.catalogoeninventario') }}" class="menu-link">
                                                                        <i class="menu-bullet menu-bullet-dot">
                                                                            <span></span>
                                                                        </i>
                                                                        <span class="menu-text">Listado de en inventario</span>
                                                                    </a>
                                                                </li>

                                                            </ul>
                                                        </div>
                                                    </li>
                                                @endif
                                            {{-- END en inventario --}}
                                            </ul>
                                        </div>
                                    </li>
                                @endif
                {{-- END CATALOGOS DE DIRECCION COMERCIAL --}}


                                @if (in_array("198", Session::get('permisos')))
                                    <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover" id="sub_menu_penalizaciones">
                                        <a href="javascript:;" class="menu-link menu-toggle">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">Dirección de administración de contratos</span>
                                            <i class="menu-arrow"></i>
                                        </a>
                                        <div class="menu-submenu">
                                            <i class="menu-arrow"></i>
                                            <ul class="menu-subnav">
                                                @if (in_array("198", Session::get('permisos')))
                                                    <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover" id="sub_sub_menu_penalizacionesydeducciones">
                                                        <a href="javascript:;" class="menu-link menu-toggle">
                                                            <i class="menu-bullet menu-bullet-dot">
                                                                <span></span>
                                                            </i>
                                                            <span class="menu-text">Penalizaciones y deducciones</span>
                                                            <i class="menu-arrow"></i>
                                                        </a>
                                                        <div class="menu-submenu">
                                                            <i class="menu-arrow"></i>
                                                            <ul class="menu-subnav">
                                                    
                                                                <li class="menu-item" aria-haspopup="true" id="sub_sub_menu_catalogo_penalizacionesydeducciones">
                                                                    <a href="{{ route('penalizaciones.listadopenalizaciones') }}" class="menu-link">
                                                                        <i class="menu-bullet menu-bullet-dot">
                                                                            <span></span>
                                                                        </i>
                                                                        <span class="menu-text">Listado de penalizaciones y deducciones</span>
                                                                    </a>
                                                                </li>
                                                    
                                                            </ul>
                                                        </div>
                                                    </li>
                                                @endif
                                            {{-- END penalizaciones y deducciones --}}
                                            </ul>
                                        </div>
                                    </li>
                                @endif
                {{-- END CATALOGOS DE DIRECCION DE ADMINISTRACION DE CONTRATOS --}}


                                    @if (in_array("13", Session::get('permisos')) || in_array("17", Session::get('permisos')) || in_array("45", Session::get('permisos')) || in_array("25", Session::get('permisos')) || in_array("29", Session::get('permisos')) || in_array("49", Session::get('permisos')) || in_array("53", Session::get('permisos')) || in_array("57", Session::get('permisos')) || in_array("208", Session::get('permisos')) || in_array("212", Session::get('permisos')) || in_array("220", Session::get('permisos')) || in_array("228", Session::get('permisos')) || in_array("236", Session::get('permisos')) || in_array("244", Session::get('permisos')) || in_array("252", Session::get('permisos')) || in_array("260", Session::get('permisos')) || in_array("268", Session::get('permisos')) || in_array("276", Session::get('permisos')) || in_array("284", Session::get('permisos')))
                                        <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover" id="sub_menu_unidades">
                                            <a href="javascript:;" class="menu-link menu-toggle">
                                                <i class="menu-bullet menu-bullet-dot">
                                                    <span></span>
                                                </i>
                                                <span class="menu-text">Dirección de operaciones</span>
                                                <i class="menu-arrow"></i>
                                            </a>
                                            <div class="menu-submenu">
                                                <i class="menu-arrow"></i>
                                                <ul class="menu-subnav">
                                                    @if (in_array("13", Session::get('permisos')))
                                                        <li class="menu-item menu-item-parent" aria-haspopup="true">
                                                                    <span class="menu-link">
                                                                        <span class="menu-text">Marcas</span>
                                                                    </span>
                                                        </li>
                                                        <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover" id="sub_sub_menu_marcas">
                                                            <a href="javascript:;" class="menu-link menu-toggle">
                                                                <i class="menu-bullet menu-bullet-dot">
                                                                    <span></span>
                                                                </i>
                                                                <span class="menu-text">Marcas</span>
                                                                <i class="menu-arrow"></i>
                                                            </a>
                                                            <div class="menu-submenu">
                                                                <i class="menu-arrow"></i>
                                                                <ul class="menu-subnav">


                                                                    <li class="menu-item" aria-haspopup="true" id="sub_sub_menu_catalogo_marcas">
                                                                        <a href="{{ route('marcas.catalogomarcas') }}" class="menu-link">
                                                                            <i class="menu-bullet menu-bullet-dot">
                                                                                <span></span>
                                                                            </i>
                                                                            <span class="menu-text">Listado de Marcas</span>
                                                                        </a>
                                                                    </li>

                                                                </ul>
                                                            </div>
                                                        </li>
                                                    @endif
                                                    {{-- End MARCAS --}}
                                                    @if (in_array("17", Session::get('permisos')))
                                                        <li class="menu-item menu-item-parent" aria-haspopup="true">
                                                            <span class="menu-link">
                                                                <span class="menu-text">Catálogo de Modelos</span>
                                                            </span>
                                                        </li>

                                                        <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover" id="sub_sub_menu_modelos">
                                                            <a href="javascript:;" class="menu-link menu-toggle">
                                                                <i class="menu-bullet menu-bullet-dot">
                                                                    <span></span>
                                                                </i>
                                                                <span class="menu-text">Modelos</span>
                                                                <i class="menu-arrow"></i>
                                                            </a>
                                                            <div class="menu-submenu">
                                                                <i class="menu-arrow"></i>
                                                                <ul class="menu-subnav">


                                                                    <li class="menu-item" aria-haspopup="true" id="sub_sub_menu_catalogo_modelos">
                                                                        <a href="{{ route('modelos.catalogomodelos') }}" class="menu-link">
                                                                            <i class="menu-bullet menu-bullet-dot">
                                                                                <span></span>
                                                                            </i>
                                                                            <span class="menu-text">Listado de Modelos</span>
                                                                        </a>
                                                                    </li>

                                                                </ul>
                                                            </div>
                                                        </li>
                                                    @endif
                                                    {{-- END MODELOS --}}
                                                    @if (in_array("45", Session::get('permisos')))
                                                        <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover" id="sub_sub_menu_vehiculo_tipo">
                                                            <a href="javascript:;" class="menu-link menu-toggle">
                                                                <i class="menu-bullet menu-bullet-dot">
                                                                    <span></span>
                                                                </i>
                                                                <span class="menu-text">Tipo de vehículo</span>
                                                                <i class="menu-arrow"></i>
                                                            </a>
                                                            <div class="menu-submenu">
                                                                <i class="menu-arrow"></i>
                                                                <ul class="menu-subnav">

                                                                    <li class="menu-item" aria-haspopup="true" id="sub_sub_menu_catalogo_vehiculo_tipo">
                                                                        <a href="{{ route('vehiculotipo.catalogovehiculotipo') }}" class="menu-link">
                                                                            <i class="menu-bullet menu-bullet-dot">
                                                                                <span></span>
                                                                            </i>
                                                                            <span class="menu-text">Listado de tipos de vehículos</span>
                                                                        </a>
                                                                    </li>

                                                                </ul>
                                                            </div>
                                                        </li>
                                                    @endif
                                                    {{-- END Tipo de vehiculos --}}

                                                    {{-- END UBICACIONES --}}
                                                    @if (in_array("25", Session::get('permisos')))
                                                        <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover" id="sub_sub_menu_estatus">
                                                            <a href="javascript:;" class="menu-link menu-toggle">
                                                                <i class="menu-bullet menu-bullet-dot">
                                                                    <span></span>
                                                                </i>
                                                                <span class="menu-text">Estatus</span>
                                                                <i class="menu-arrow"></i>
                                                            </a>
                                                            <div class="menu-submenu">
                                                                <i class="menu-arrow"></i>
                                                                <ul class="menu-subnav">


                                                                    <li class="menu-item" aria-haspopup="true" id="sub_sub_menu_catalogo_estatus">
                                                                        <a href="{{ route('estatus.catalogoestatus') }}" class="menu-link">
                                                                            <i class="menu-bullet menu-bullet-dot">
                                                                                <span></span>
                                                                            </i>
                                                                            <span class="menu-text">Listado de Estatus</span>
                                                                        </a>
                                                                    </li>

                                                                </ul>
                                                            </div>
                                                        </li>
                                                    @endif
                                                    {{-- END ESTATUS --}}

                                                    @if (in_array("29", Session::get('permisos')))
                                                        <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover" id="sub_sub_menu_aseguradora">
                                                            <a href="javascript:;" class="menu-link menu-toggle">
                                                                <i class="menu-bullet menu-bullet-dot">
                                                                    <span></span>
                                                                </i>
                                                                <span class="menu-text">Aseguradoras</span>
                                                                <i class="menu-arrow"></i>
                                                            </a>
                                                            <div class="menu-submenu">
                                                                <i class="menu-arrow"></i>
                                                                <ul class="menu-subnav">

                                                                    <li class="menu-item" aria-haspopup="true" id="sub_sub_menu_catalogo_aseguradora">
                                                                        <a href="{{ route('aseguradora.catalogoaseguradora') }}" class="menu-link">
                                                                            <i class="menu-bullet menu-bullet-dot">
                                                                                <span></span>
                                                                            </i>
                                                                            <span class="menu-text">Listado de Aseguradoras</span>
                                                                        </a>
                                                                    </li>

                                                                </ul>
                                                            </div>
                                                        </li>
                                                    @endif
                                                    {{-- END ASEGURADORAS --}}

                                                    @if (in_array("49", Session::get('permisos')))
                                                        <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover" id="sub_sub_menu_agencias">
                                                            <a href="javascript:;" class="menu-link menu-toggle">
                                                                <i class="menu-bullet menu-bullet-dot">
                                                                    <span></span>
                                                                </i>
                                                                <span class="menu-text">Agencia de vehículos</span>
                                                                <i class="menu-arrow"></i>
                                                            </a>
                                                            <div class="menu-submenu">
                                                                <i class="menu-arrow"></i>
                                                                <ul class="menu-subnav">

                                                                    <li class="menu-item" aria-haspopup="true" id="sub_sub_menu_catalogo_agencias">
                                                                        <a href="{{ route('agencia.catalogoagencias') }}" class="menu-link">
                                                                            <i class="menu-bullet menu-bullet-dot">
                                                                                <span></span>
                                                                            </i>
                                                                            <span class="menu-text">Listado de Agencias</span>
                                                                        </a>
                                                                    </li>

                                                                </ul>
                                                            </div>
                                                        </li>
                                                    @endif
                                                    {{-- END AGENCIAS --}} 

                                                    @if (in_array("53", Session::get('permisos')))
                                                        <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover" id="sub_sub_menu_tipo-documentos">
                                                            <a href="javascript:;" class="menu-link menu-toggle">
                                                                <i class="menu-bullet menu-bullet-dot">
                                                                    <span></span>
                                                                </i>
                                                                <span class="menu-text">Tipo de documento</span>
                                                                <i class="menu-arrow"></i>
                                                            </a>
                                                            <div class="menu-submenu">
                                                                <i class="menu-arrow"></i>
                                                                <ul class="menu-subnav">

                                                                    <li class="menu-item" aria-haspopup="true" id="sub_sub_menu_catalogo_tipo-documentos">
                                                                        <a href="{{ route('documento.catalogodocumentos') }}" class="menu-link">
                                                                            <i class="menu-bullet menu-bullet-dot">
                                                                                <span></span>
                                                                            </i>
                                                                            <span class="menu-text">Listado de tipo de documentos</span>
                                                                        </a>
                                                                    </li>

                                                                </ul>
                                                            </div>
                                                        </li>
                                                    @endif
                                                    {{-- END Tipo de documento --}}

                                                    @if (in_array("57", Session::get('permisos'))) 
                                                        <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover" id="sub_sub_menu_tipo-asignacion">
                                                            <a href="javascript:;" class="menu-link menu-toggle">
                                                                <i class="menu-bullet menu-bullet-dot">
                                                                    <span></span>
                                                                </i>
                                                                <span class="menu-text">Tipo de asignación</span>
                                                                <i class="menu-arrow"></i>
                                                            </a>
                                                            <div class="menu-submenu">
                                                                <i class="menu-arrow"></i>
                                                                <ul class="menu-subnav">

                                                                    <li class="menu-item" aria-haspopup="true" id="sub_sub_menu_catalogo_tipo-asignacion">
                                                                        <a href="{{ route('tipoasignacion.catalogotipoasignacion') }}" class="menu-link">
                                                                            <i class="menu-bullet menu-bullet-dot">
                                                                                <span></span>
                                                                            </i>
                                                                            <span class="menu-text">Listado de tipo de asignación</span>
                                                                        </a>
                                                                    </li>

                                                                </ul>
                                                            </div>
                                                        </li>
                                                    @endif
                                                    {{-- END Tipo de Asignación --}} 

                                                    {{-- Información del propietario --}}
                                                    @if (in_array("208", Session::get('permisos'))) 
                                                        <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover" id="sub_sub_menu_informacion-propietario">
                                                            <a href="javascript:;" class="menu-link menu-toggle">
                                                                <i class="menu-bullet menu-bullet-dot">
                                                                    <span></span>
                                                                </i>
                                                                <span class="menu-text">Información del propietario</span>
                                                                <i class="menu-arrow"></i>
                                                            </a>
                                                            <div class="menu-submenu">
                                                                <i class="menu-arrow"></i>
                                                                <ul class="menu-subnav">
                                                        
                                                                    <li class="menu-item" aria-haspopup="true" id="sub_sub_menu_catalogo_informacion-propietario">
                                                                        <a href="{{ route('propietario.infopropietario') }}" class="menu-link">
                                                                            <i class="menu-bullet menu-bullet-dot">
                                                                                <span></span>
                                                                            </i>
                                                                            <span class="menu-text">Listado de propietario</span>
                                                                        </a>
                                                                    </li>
                                                        
                                                                </ul>
                                                            </div>
                                                        </li>
                                                    @endif
                                                    {{-- Tramite vehicular  Emplacamiento --}}
                                                    @if (in_array("212", Session::get('permisos'))) 
                                                        <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover" id="sub_sub_menu_informacion-emplacamiento">
                                                            <a href="javascript:;" class="menu-link menu-toggle">
                                                                <i class="menu-bullet menu-bullet-dot">
                                                                    <span></span>
                                                                </i>
                                                                <span class="menu-text">Tramite - Emplacamiento</span>
                                                                <i class="menu-arrow"></i>
                                                            </a>
                                                            <div class="menu-submenu">
                                                                <i class="menu-arrow"></i>
                                                                <ul class="menu-subnav">
                                                        
                                                                    <li class="menu-item" aria-haspopup="true" id="sub_sub_menu_catalogo_informacion-emplacamiento">
                                                                        <a href="{{ route('templacamiento.listadoemplacamiento') }}" class="menu-link">
                                                                            <i class="menu-bullet menu-bullet-dot">
                                                                                <span></span>
                                                                            </i>
                                                                            <span class="menu-text">Listado del tramite</span>
                                                                        </a>
                                                                    </li>
                                                        
                                                                </ul>
                                                            </div>
                                                        </li>
                                                    @endif
                                                    {{-- Tramite vehicular  Tenencia --}}
                                                    @if (in_array("220", Session::get('permisos'))) 
                                                        <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover" id="sub_sub_menu_informacion-tenencia">
                                                            <a href="javascript:;" class="menu-link menu-toggle">
                                                                <i class="menu-bullet menu-bullet-dot">
                                                                    <span></span>
                                                                </i>
                                                                <span class="menu-text">Tramite - Tenencia</span>
                                                                <i class="menu-arrow"></i>
                                                            </a>
                                                            <div class="menu-submenu">
                                                                <i class="menu-arrow"></i>
                                                                <ul class="menu-subnav">
                                                        
                                                                    <li class="menu-item" aria-haspopup="true" id="sub_sub_menu_catalogo_informacion-tenencia">
                                                                        <a href="{{ route('ttenencia.listadotenencia') }}" class="menu-link">
                                                                            <i class="menu-bullet menu-bullet-dot">
                                                                                <span></span>
                                                                            </i>
                                                                            <span class="menu-text">Listado del tramite</span>
                                                                        </a>
                                                                    </li>
                                                        
                                                                </ul>
                                                            </div>
                                                        </li>
                                                    @endif
                                                    {{-- Tramite vehicular  VERIFICACION --}}
                                                    @if (in_array("228", Session::get('permisos'))) 
                                                        <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover" id="sub_sub_menu_informacion-verificacion">
                                                            <a href="javascript:;" class="menu-link menu-toggle">
                                                                <i class="menu-bullet menu-bullet-dot">
                                                                    <span></span>
                                                                </i>
                                                                <span class="menu-text">Tramite - Verificación</span>
                                                                <i class="menu-arrow"></i>
                                                            </a>
                                                            <div class="menu-submenu">
                                                                <i class="menu-arrow"></i>
                                                                <ul class="menu-subnav">
                                                        
                                                                    <li class="menu-item" aria-haspopup="true" id="sub_sub_menu_catalogo_informacion-verificacion">
                                                                        <a href="{{ route('tverificacion.listadoverificacion') }}" class="menu-link">
                                                                            <i class="menu-bullet menu-bullet-dot">
                                                                                <span></span>
                                                                            </i>
                                                                            <span class="menu-text">Listado del tramite</span>
                                                                        </a>
                                                                    </li>
                                                        
                                                                </ul>
                                                            </div>
                                                        </li>
                                                    @endif

                                                    {{-- Tramite vehicular  Reemplacamiento --}}
                                                    @if (in_array("236", Session::get('permisos'))) 
                                                        <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover" id="sub_sub_menu_informacion-reemplacamiento">
                                                            <a href="javascript:;" class="menu-link menu-toggle">
                                                                <i class="menu-bullet menu-bullet-dot">
                                                                    <span></span>
                                                                </i>
                                                                <span class="menu-text">Tramite - Reemplacamiento</span>
                                                                <i class="menu-arrow"></i>
                                                            </a>
                                                            <div class="menu-submenu">
                                                                <i class="menu-arrow"></i>
                                                                <ul class="menu-subnav">
                                                        
                                                                    <li class="menu-item" aria-haspopup="true" id="sub_sub_menu_catalogo_informacion-reemplacamiento">
                                                                        <a href="{{ route('treemplacamiento.listadoreemplacamiento') }}" class="menu-link">
                                                                            <i class="menu-bullet menu-bullet-dot">
                                                                                <span></span>
                                                                            </i>
                                                                            <span class="menu-text">Listado del tramite</span>
                                                                        </a>
                                                                    </li>
                                                        
                                                                </ul>
                                                            </div>
                                                        </li>
                                                    @endif
                                                    {{-- Tramite vehicular  Cambio de propietario --}}
                                                    @if (in_array("244", Session::get('permisos')))
                                                        <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover" id="sub_sub_menu_informacion-cambio-propietario">
                                                            <a href="javascript:;" class="menu-link menu-toggle">
                                                                <i class="menu-bullet menu-bullet-dot">
                                                                    <span></span>
                                                                </i>
                                                                <span class="menu-text">Tramite - Cambio de propietario</span>
                                                                <i class="menu-arrow"></i>
                                                            </a>
                                                            <div class="menu-submenu">
                                                                <i class="menu-arrow"></i>
                                                                <ul class="menu-subnav">
                                                        
                                                                    <li class="menu-item" aria-haspopup="true" id="sub_sub_menu_catalogo_informacion-cambio-propietario">
                                                                        <a href="{{ route('tcambiopro.listadocambiopro') }}" class="menu-link">
                                                                            <i class="menu-bullet menu-bullet-dot">
                                                                                <span></span>
                                                                            </i>
                                                                            <span class="menu-text">Listado del tramite</span>
                                                                        </a>
                                                                    </li>
                                                        
                                                                </ul>
                                                            </div>
                                                        </li>
                                                    @endif

                                                    {{-- Tramite vehicular  Aseguramiento --}}
                                                    @if (in_array("252", Session::get('permisos')))
                                                        <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover" id="sub_sub_menu_informacion-aseguramientoreq">
                                                            <a href="javascript:;" class="menu-link menu-toggle">
                                                                <i class="menu-bullet menu-bullet-dot">
                                                                    <span></span>
                                                                </i>
                                                                <span class="menu-text">Tramite - Aseguramiento</span>
                                                                <i class="menu-arrow"></i>
                                                            </a>
                                                            <div class="menu-submenu">
                                                                <i class="menu-arrow"></i>
                                                                <ul class="menu-subnav">
                                                        
                                                                    <li class="menu-item" aria-haspopup="true" id="sub_sub_menu_catalogo_informacion-aseguramientoreq">
                                                                        <a href="{{ route('tase.listadoaseguramientot') }}" class="menu-link">
                                                                            <i class="menu-bullet menu-bullet-dot">
                                                                                <span></span>
                                                                            </i>
                                                                            <span class="menu-text">Listado del tramite</span>
                                                                        </a>
                                                                    </li>
                                                        
                                                                </ul>
                                                            </div>
                                                        </li>
                                                    @endif

                                                    {{-- Tramite vehicular  Baja de vehículos --}}
                                                    @if (in_array("260", Session::get('permisos')) || in_array("268", Session::get('permisos')) || in_array("276", Session::get('permisos')))
                                                        <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover" id="sub_sub_sub_menu_informacion-baja-venta" >
                                                            <a href="javascript:;" class="menu-link menu-toggle">
                                                                <i class="menu-bullet menu-bullet-dot">
                                                                    <span></span>
                                                                </i>
                                                                <span class="menu-text">Tramite - Baja de vehículos</span>
                                                                <i class="menu-arrow"></i>
                                                            </a>
                                                            <div class="menu-submenu">
                                                                <i class="menu-arrow"></i>
                                                                <ul class="menu-subnav">
                                                                    <li class="menu-item menu-item-parent" aria-haspopup="true"  >
                                                                        <span class="menu-link">
                                                                            <span class="menu-text">Tramite - Baja de vehículos</span>
                                                                        </span>
                                                                    </li>

                                                                    {{-- End Venta --}}
                                                                    @if (in_array("260", Session::get('permisos')))
                                                                        <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover" id="sub_sub_sub_sub_menu_informacion-baja-venta">
                                                                            <a href="javascript:;" class="menu-link menu-toggle">
                                                                                <i class="menu-bullet menu-bullet-dot">
                                                                                    <span></span>
                                                                                </i>
                                                                                <span class="menu-text">Por venta</span>
                                                                                <i class="menu-arrow"></i>
                                                                            </a>
                                                                            <div class="menu-submenu">
                                                                                <i class="menu-arrow"></i>
                                                                                <ul class="menu-subnav">

                                                                                    <li class="menu-item" aria-haspopup="true" id="sub_sub_menu_catalogo_informacion-baja-venta">
                                                                                        <a href="{{ route('bajav.listadobajaventa') }}" class="menu-link">
                                                                                            <i class="menu-bullet menu-bullet-dot">
                                                                                                <span></span>
                                                                                            </i>
                                                                                            <span class="menu-text">Listado del tramite</span>
                                                                                        </a>
                                                                                    </li>
                                                                                </ul>
                                                                            </div>
                                                                        </li>
                                                                    @endif
                                                                    {{-- End Venta --}}
                                                                    @if (in_array("268", Session::get('permisos')))
                                                                        <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover" id="sub_sub_sub_menu_informacion-baja-robo">
                                                                            <a href="javascript:;" class="menu-link menu-toggle">
                                                                                <i class="menu-bullet menu-bullet-dot">
                                                                                    <span></span>
                                                                                </i>
                                                                                <span class="menu-text">Por robo</span>
                                                                                <i class="menu-arrow"></i>
                                                                            </a>
                                                                            <div class="menu-submenu">
                                                                                <i class="menu-arrow"></i>
                                                                                <ul class="menu-subnav">

                                                                                    <li class="menu-item" aria-haspopup="true" id="sub_sub_menu_catalogo_informacion-baja-robo">
                                                                                        <a href="{{ route('bajar.listadobajarobo') }}" class="menu-link">
                                                                                            <i class="menu-bullet menu-bullet-dot">
                                                                                                <span></span>
                                                                                            </i>
                                                                                            <span class="menu-text">Listado del tramite</span>
                                                                                        </a>
                                                                                    </li>
                                                                                </ul>
                                                                            </div>
                                                                        </li>
                                                                    @endif
                                                                    {{-- End Robo --}}

                                                                    @if (in_array("276", Session::get('permisos')))
                                                                        <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover" id="sub_sub_sub_menu_informacion-baja-stro">
                                                                            <a href="javascript:;" class="menu-link menu-toggle">
                                                                                <i class="menu-bullet menu-bullet-dot">
                                                                                    <span></span>
                                                                                </i>
                                                                                <span class="menu-text">Por siniestro</span>
                                                                                <i class="menu-arrow"></i>
                                                                            </a>
                                                                            <div class="menu-submenu">
                                                                                <i class="menu-arrow"></i>
                                                                                <ul class="menu-subnav">

                                                                                    <li class="menu-item" aria-haspopup="true" id="sub_sub_menu_catalogo_informacion-baja-stro">
                                                                                        <a href="{{ route('bajas.listadobajastro') }}" class="menu-link">
                                                                                            <i class="menu-bullet menu-bullet-dot">
                                                                                                <span></span>
                                                                                            </i>
                                                                                            <span class="menu-text">Listado del tramite</span>
                                                                                        </a>
                                                                                    </li>
                                                                                </ul>
                                                                            </div>
                                                                        </li>
                                                                    @endif
                                                                    {{-- End Siniestro --}}

                                                                </ul>
                                                            </div>
                                                        </li>
                                                    @endif


                                                    @if (in_array("352", Session::get('permisos')))
                                                        <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover" id="sub_sub_menu_listado-tipo-solicitud">
                                                            <a href="javascript:;" class="menu-link menu-toggle">
                                                                <i class="menu-bullet menu-bullet-dot">
                                                                    <span></span>
                                                                </i>
                                                                <span class="menu-text">Estatus del siniestro</span>
                                                                <i class="menu-arrow"></i>
                                                            </a>
                                                            <div class="menu-submenu">
                                                                <i class="menu-arrow"></i>
                                                                <ul class="menu-subnav">
                                                
                                                                    <li class="menu-item" aria-haspopup="true" id="sub_sub_menu_catalogo_tipo-solicitud">
                                                                        <a href="{{ route('bajasin.listadoestatusbajastro') }}" class="menu-link">
                                                                            <i class="menu-bullet menu-bullet-dot">
                                                                                <span></span>
                                                                            </i>
                                                                            <span class="menu-text">Listado de estatus</span>
                                                                        </a>
                                                                    </li>
                                                
                                                                </ul>
                                                            </div>
                                                        </li>
                                                    @endif


                                                    @if (in_array("356", Session::get('permisos')))
                                                        <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover" id="sub_sub_menu_informacion-cambio-propietario">
                                                            <a href="javascript:;" class="menu-link menu-toggle">
                                                                <i class="menu-bullet menu-bullet-dot">
                                                                    <span></span>
                                                                </i>
                                                                <span class="menu-text">Tramite - Gps</span>
                                                                <i class="menu-arrow"></i>
                                                            </a>
                                                            <div class="menu-submenu">
                                                                <i class="menu-arrow"></i>
                                                                <ul class="menu-subnav">
                                                        
                                                                    <li class="menu-item" aria-haspopup="true" id="sub_sub_menu_catalogo_informacion-cambio-propietario">
                                                                        <a href="{{ route('trgps.listadoreqgps') }}" class="menu-link">
                                                                            <i class="menu-bullet menu-bullet-dot">
                                                                                <span></span>
                                                                            </i>
                                                                            <span class="menu-text">Listado del tramite</span>
                                                                        </a>
                                                                    </li>
                                                        
                                                                </ul>
                                                            </div>
                                                        </li>
                                                    @endif

                                                    @if (in_array("284", Session::get('permisos')))
                                                        <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover" id="sub_sub_menu_listado-tipo-solicitud">
                                                            <a href="javascript:;" class="menu-link menu-toggle">
                                                                <i class="menu-bullet menu-bullet-dot">
                                                                    <span></span>
                                                                </i>
                                                                <span class="menu-text">Mantenimiento talleres</span>
                                                                <i class="menu-arrow"></i>
                                                            </a>
                                                            <div class="menu-submenu">
                                                                <i class="menu-arrow"></i>
                                                                <ul class="menu-subnav">
                                                
                                                                    <li class="menu-item" aria-haspopup="true" id="sub_sub_menu_catalogo_tipo-solicitud">
                                                                        <a href="{{ route('taller.catalogotiposolicitud') }}" class="menu-link">
                                                                            <i class="menu-bullet menu-bullet-dot">
                                                                                <span></span>
                                                                            </i>
                                                                            <span class="menu-text">Tipo de solicitudes</span>
                                                                        </a>
                                                                    </li>
                                                
                                                                </ul>
                                                            </div>
                                                        </li>
                                                    @endif

                                                    @if (in_array("340", Session::get('permisos')))
                                                        <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover" id="sub_sub_menu_listado-tipo-solicitud">
                                                            <a href="javascript:;" class="menu-link menu-toggle">
                                                                <i class="menu-bullet menu-bullet-dot">
                                                                    <span></span>
                                                                </i>
                                                                <span class="menu-text">Servicios de los talleres</span>
                                                                <i class="menu-arrow"></i>
                                                            </a>
                                                            <div class="menu-submenu">
                                                                <i class="menu-arrow"></i>
                                                                <ul class="menu-subnav">
                                                
                                                                    <li class="menu-item" aria-haspopup="true" id="sub_sub_menu_catalogo_tipo-solicitud">
                                                                        <a href="{{ route('servtaller.serviciostaller') }}" class="menu-link">
                                                                            <i class="menu-bullet menu-bullet-dot">
                                                                                <span></span>
                                                                            </i>
                                                                            <span class="menu-text">Tipo de servicios</span>
                                                                        </a>
                                                                    </li>
                                                
                                                                </ul>
                                                            </div>
                                                        </li>
                                                    @endif

                                                    @if (in_array("348", Session::get('permisos')))
                                                        <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover" id="sub_sub_menu_listado-tipo-solicitud">
                                                            <a href="javascript:;" class="menu-link menu-toggle">
                                                                <i class="menu-bullet menu-bullet-dot">
                                                                    <span></span>
                                                                </i>
                                                                <span class="menu-text">Tipo de documento del talleres</span>
                                                                <i class="menu-arrow"></i>
                                                            </a>
                                                            <div class="menu-submenu">
                                                                <i class="menu-arrow"></i>
                                                                <ul class="menu-subnav">
                                                
                                                                    <li class="menu-item" aria-haspopup="true" id="sub_sub_menu_catalogo_tipo-solicitud">
                                                                        <a href="{{ route('tipdoctaller.tipodocumentotaller') }}" class="menu-link">
                                                                            <i class="menu-bullet menu-bullet-dot">
                                                                                <span></span>
                                                                            </i>
                                                                            <span class="menu-text">Tipo de documento</span>
                                                                        </a>
                                                                    </li>
                                                
                                                                </ul>
                                                            </div>
                                                        </li>
                                                    @endif

                                                    @if (in_array("348", Session::get('permisos')))
                                                        <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover" id="sub_sub_menu_listado-gestor">
                                                            <a href="javascript:;" class="menu-link menu-toggle">
                                                                <i class="menu-bullet menu-bullet-dot">
                                                                    <span></span>
                                                                </i>
                                                                <span class="menu-text">Gestores</span>
                                                                <i class="menu-arrow"></i>
                                                            </a>
                                                            <div class="menu-submenu">
                                                                <i class="menu-arrow"></i>
                                                                <ul class="menu-subnav">
                                                
                                                                    <li class="menu-item" aria-haspopup="true" id="sub_sub_menu_catalogo_gestor">
                                                                        <a href="{{ route('catalogogestor.listadocatalogogestor') }}" class="menu-link">
                                                                            <i class="menu-bullet menu-bullet-dot">
                                                                                <span></span>
                                                                            </i>
                                                                            <span class="menu-text">Gestores</span>
                                                                        </a>
                                                                    </li>
                                                
                                                                </ul>
                                                            </div>
                                                        </li>
                                                    @endif
    
                                                </ul>
                                            </div>
                                        </li>
                                    @endif
                    {{-- END CATALOGOS DE DIRECCION DE OPERACIONES CATALOGOS --}}

                                @if (in_array("292", Session::get('permisos')) || in_array("296", Session::get('permisos')) || in_array("300", Session::get('permisos')) || in_array("304", Session::get('permisos')) || in_array("308", Session::get('permisos'))  )

                                    <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover" id="sub_menu_finanzas">
                                        <a href="javascript:;" class="menu-link menu-toggle">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">Dirección de administración y finanzas</span>
                                            <i class="menu-arrow"></i>
                                        </a>
                                        <div class="menu-submenu">
                                            <i class="menu-arrow"></i>
                                            <ul class="menu-subnav">

                                                @if (in_array("292", Session::get('permisos')))
                                                    <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover" id="sub_sub_menu_documentoscompras">
                                                        <a href="javascript:;" class="menu-link menu-toggle">
                                                            <i class="menu-bullet menu-bullet-dot">
                                                                <span></span>
                                                            </i>
                                                            <span class="menu-text">Documentos de compras</span>
                                                            <i class="menu-arrow"></i>
                                                        </a>
                                                        <div class="menu-submenu">
                                                            <i class="menu-arrow"></i>
                                                            <ul class="menu-subnav">

                                                                <li class="menu-item" aria-haspopup="true" id="sub_sub_menu_catalogo_documentoscompras">
                                                                    <a href="{{ route('doccompras.listadodocumentoscompras') }}" class="menu-link">
                                                                        <i class="menu-bullet menu-bullet-dot">
                                                                        </i>
                                                                        <span class="menu-text">Listado de Documentos</span>
                                                                    </a>
                                                                </li>

                                                            </ul>
                                                        </div>
                                                    </li>
                                                @endif

                                                @if (in_array("296", Session::get('permisos')))
                                                    <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover" id="sub_sub_menu_listado-proveedores">
                                                        <a href="javascript:;" class="menu-link menu-toggle">
                                                            <i class="menu-bullet menu-bullet-dot">
                                                                <span></span>
                                                            </i>
                                                            <span class="menu-text">Proveedores</span>
                                                            <i class="menu-arrow"></i>
                                                        </a>
                                                        <div class="menu-submenu">
                                                            <i class="menu-arrow"></i>
                                                            <ul class="menu-subnav">

                                                                <li class="menu-item" aria-haspopup="true" id="sub_sub_menu_catalogo_proveedores">
                                                                    <a href="{{ route('proveedor.catalogoproveedores') }}" class="menu-link">
                                                                        <i class="menu-bullet menu-bullet-dot">
                                                                            <span></span>
                                                                        </i>
                                                                        <span class="menu-text">Listado de Proveedores</span>
                                                                    </a>
                                                                </li>

                                                                <li class="menu-item" aria-haspopup="true" id="sub_sub_menu_catalogo_proveedores_categoria">
                                                                    <a href="{{ route('ProvCategoria.listado') }}" class="menu-link">
                                                                        <i class="menu-bullet menu-bullet-dot">
                                                                            <span></span>
                                                                        </i>
                                                                        <span class="menu-text">Tipos de Proveedores</span>
                                                                    </a>
                                                                </li>

                                                            </ul>
                                                        </div>
                                                    </li>
                                                @endif

                                                @if (in_array("300", Session::get('permisos')))
                                                    <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover" id="sub_sub_menu_metodospago">
                                                        <a href="javascript:;" class="menu-link menu-toggle">
                                                            <i class="menu-bullet menu-bullet-dot">
                                                                <span></span>
                                                            </i>
                                                            <span class="menu-text">Métodos de pago</span>
                                                            <i class="menu-arrow"></i>
                                                        </a>
                                                        <div class="menu-submenu">
                                                            <i class="menu-arrow"></i>
                                                            <ul class="menu-subnav">
                                                    
                                                                <li class="menu-item" aria-haspopup="true" id="sub_sub_menu_catalogo_metodospago">
                                                                    <a href="{{ route('metodopago.listadometodopago') }}" class="menu-link">
                                                                        <i class="menu-bullet menu-bullet-dot">
                                                                            <span></span>
                                                                        </i>
                                                                        <span class="menu-text">Listado de métodos de pago</span>
                                                                    </a>
                                                                </li>
                                                    
                                                            </ul>
                                                        </div>
                                                    </li>
                                                @endif

                                                {{-- Forma de pago --}}
                                                @if (in_array("304", Session::get('permisos')))
                                                    <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover" id="sub_sub_menu_formaspago">
                                                        <a href="javascript:;" class="menu-link menu-toggle">
                                                            <i class="menu-bullet menu-bullet-dot">
                                                                <span></span>
                                                            </i>
                                                            <span class="menu-text">Forma de pago</span>
                                                            <i class="menu-arrow"></i>
                                                        </a>
                                                        <div class="menu-submenu">
                                                            <i class="menu-arrow"></i>
                                                            <ul class="menu-subnav">
                                                    
                                                                <li class="menu-item" aria-haspopup="true" id="sub_sub_menu_catalogo_formaspago">
                                                                    <a href="{{ route('formapago.listadoformapago') }}" class="menu-link">
                                                                        <i class="menu-bullet menu-bullet-dot">
                                                                            <span></span>
                                                                        </i>
                                                                        <span class="menu-text">Listado de formas de pago</span>
                                                                    </a>
                                                                </li>
                                                    
                                                            </ul>
                                                        </div>
                                                    </li>
                                                @endif
                                               {{-- Uso de CFDI --}}
                                               @if (in_array("308", Session::get('permisos')))
                                                    <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover" id="sub_sub_menu_catalogocfdi">
                                                        <a href="javascript:;" class="menu-link menu-toggle">
                                                            <i class="menu-bullet menu-bullet-dot">
                                                                <span></span>
                                                            </i>
                                                            <span class="menu-text">Uso de CFDI</span>
                                                            <i class="menu-arrow"></i>
                                                        </a>
                                                        <div class="menu-submenu">
                                                            <i class="menu-arrow"></i>
                                                            <ul class="menu-subnav">
                                                    
                                                                <li class="menu-item" aria-haspopup="true" id="sub_sub_menu_catalogo-catalogocfdi">
                                                                    <a href="{{ route('catalogocfdi.listadocatalogocfdi') }}" class="menu-link">
                                                                        <i class="menu-bullet menu-bullet-dot">
                                                                            <span></span>
                                                                        </i>
                                                                        <span class="menu-text">Listado de uso de CFDI</span>
                                                                    </a>
                                                                </li>
                                                    
                                                            </ul>
                                                        </div>
                                                    </li>
                                                @endif

                                            </ul>
                                        </div>
                                    </li>
                                @endif
                {{-- END CATALOGOS DE DIRECCION DE ADMINISTRACION Y FINANZAS --}}

{{-- 
                                    <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover" id="sub_sub_menu_listado-contratos">
                                        <a href="javascript:;" class="menu-link menu-toggle">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">Tipos de Contrato</span>
                                            <i class="menu-arrow"></i>
                                        </a>
                                        <div class="menu-submenu">
                                            <i class="menu-arrow"></i>
                                            <ul class="menu-subnav">

                                                <li class="menu-item" aria-haspopup="true" id="sub_sub_menu_catalogo_contratos">
                                                    <a href="{{ route('tipocontrato.listadotipocontrato') }}" class="menu-link">
                                                        <i class="menu-bullet menu-bullet-dot">
                                                            <span></span>
                                                        </i>
                                                        <span class="menu-text">Listado de Tipos de Contrato</span>
                                                    </a>
                                                </li>

                                            </ul>
                                        </div>
                                    </li> --}}
{{-- 
                                    <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover" id="sub_sub_menu_listado-fuenteproyecto">
                                        <a href="javascript:;" class="menu-link menu-toggle">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">Fuentes de Contrato</span>
                                            <i class="menu-arrow"></i>
                                        </a>
                                        <div class="menu-submenu">
                                            <i class="menu-arrow"></i>
                                            <ul class="menu-subnav">

                                                <li class="menu-item" aria-haspopup="true" id="sub_sub_menu_catalogo_fuenteproyecto">
                                                    <a href="{{ route('fuenteproyecto.listadofuenteproyecto') }}" class="menu-link">
                                                        <i class="menu-bullet menu-bullet-dot">
                                                            <span></span>
                                                        </i>
                                                        <span class="menu-text">Listado de Fuentes de Contrato</span>
                                                    </a>
                                                </li>

                                            </ul>
                                        </div>
                                    </li>
 --}}


{{-- 
                                    <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
                                        <a href="javascript:;" class="menu-link menu-toggle">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">Propuesta económica</span>
                                            <i class="menu-arrow"></i>
                                        </a>
                                        <div class="menu-submenu">
                                            <i class="menu-arrow"></i>
                                            <ul class="menu-subnav">

                                                <li class="menu-item" aria-haspopup="true">
                                                    <a href="{{ route('proposicioneconomica.catalogoproposicioneconomica') }}" class="menu-link">
                                                        <i class="menu-bullet menu-bullet-dot">
                                                            <span></span>
                                                        </i>
                                                        <span class="menu-text">Listado de propuesta económica</span>
                                                    </a>
                                                </li>

                                            </ul>
                                        </div>
                                    </li>

                                    <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
                                        <a href="javascript:;" class="menu-link menu-toggle">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">Propuesta tecnica</span>
                                            <i class="menu-arrow"></i>
                                        </a>
                                        <div class="menu-submenu">
                                            <i class="menu-arrow"></i>
                                            <ul class="menu-subnav">

                                                <li class="menu-item" aria-haspopup="true">
                                                    <a href="" class="menu-link">
                                                        <i class="menu-bullet menu-bullet-dot">
                                                            <span></span>
                                                        </i>
                                                        <span class="menu-text">Listado de propuesta tecnica</span>
                                                    </a>
                                                </li>

                                            </ul>
                                        </div>
                                    </li> --}}





                                    {{-- Propuesta tecnica --}}
{{--                                     <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover" id="sub_sub_menu_propuesta-tecnica">
                                        <a href="javascript:;" class="menu-link menu-toggle">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">Propuesta tecnica</span>
                                            <i class="menu-arrow"></i>
                                        </a>
                                        <div class="menu-submenu">
                                            <i class="menu-arrow"></i>
                                            <ul class="menu-subnav">
                                    
                                                <li class="menu-item" aria-haspopup="true" id="sub_sub_menu_catalogo_proptecleg">
                                                    <a href="{{ route('proptecleg.listadoproptecleg') }}" class="menu-link">
                                                        <i class="menu-bullet menu-bullet-dot">
                                                            <span></span>
                                                        </i>
                                                        <span class="menu-text">Listado de información legal</span>
                                                    </a>
                                                </li>

                                                <li class="menu-item" aria-haspopup="true" id="sub_sub_menu_catalogo_proptecadm">
                                                    <a href="{{ route('proptecadm.listadoproptecadm') }}" class="menu-link">
                                                        <i class="menu-bullet menu-bullet-dot">
                                                            <span></span>
                                                        </i>
                                                        <span class="menu-text">Listado de información administrativa</span>
                                                    </a>
                                                </li>

                                                <li class="menu-item" aria-haspopup="true" id="sub_sub_menu_catalogo-proptecfis">
                                                    <a href="{{ route('proptecfis.listadoproptecfis') }}" class="menu-link">
                                                        <i class="menu-bullet menu-bullet-dot">
                                                            <span></span>
                                                        </i>
                                                        <span class="menu-text">Listado de información fiscal</span>
                                                    </a>
                                                </li>

                                                <li class="menu-item" aria-haspopup="true" id="sub_sub_menu_catalogo-proptecfin">
                                                    <a href="{{ route('proptecfin.listadoproptecfin') }}" class="menu-link">
                                                        <i class="menu-bullet menu-bullet-dot">
                                                            <span></span>
                                                        </i>
                                                        <span class="menu-text">Listado de información financiera</span>
                                                    </a>
                                                </li>
                                    
                                            </ul>
                                        </div>
                                    </li> --}}



 




                                </ul>
                            </div>

                        </li>
                        @endif
                        {{-- Fin de catalogos --}}

                    </ul>
                    <!--end::Menu Nav-->
                </div>
                <!--end::Menu Container-->
            </div>
            <!--end::Aside Menu-->
        </div>
        <!--end::Aside-->
        <!--begin::Wrapper-->
        <div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper">
            <!--begin::Header-->
            <div id="kt_header" class="header header-fixed">
                <!--begin::Container-->
                <div class="container-fluid d-flex align-items-stretch justify-content-between">
                    <!--begin::Header Menu Wrapper-->  
{{-- @foreach (Session::get('permisos') as $product_id)
    {{$product_id}}
@endforeach --}}
                    <div class="header-menu-wrapper header-menu-wrapper-left" id="kt_header_menu_wrapper">
                        <!--begin::Header Menu-->
                        <div id="kt_header_menu" class="header-menu header-menu-mobile header-menu-layout-default">
                            <div class="menu-item menu-item-rel" style="display: grid; place-items: center;">
                                <h3 id="scroll_title" class="text-dark font-weight-bold my-2 ml-2 mr-2" style="display:none;">
                                    @yield('title')
                                </h3>
                            </div>
                        </div>
                        <!--end::Header Menu-->
                    </div>
                    <!--end::Header Menu Wrapper-->
                    <!--begin::Topbar-->
                    <div class="topbar">

                        <!--begin::Notifications-->
                        <div class="dropdown">
                            <!--begin::Toggle-->
                            <div class="topbar-item" data-toggle="dropdown" data-offset="10px,0px">
                                <div class="btn btn-icon btn-clean btn-dropdown btn-lg mr-1 pulse pulse-primary " style="position: relative;" id="m_topbar_notification_icon">
                                    <i class="icon-lg text-dark-50 flaticon2-bell-1" style="color: #669933 !important;"></i>
                                    <span class="" id="bell_badge"></span>
                                </div>
                            </div>
                            <!--end::Toggle-->
                            <!--begin::Dropdown-->
                            <div class="dropdown-menu p-0 m-0 dropdown-menu-right dropdown-menu-anim-up dropdown-menu-lg">
                                <form>
                                    <!--begin::Header-->
                                    <div class="d-flex flex-column pt-12 bgi-size-cover bgi-no-repeat rounded-top" style="background-image: url({{ asset('theme/assets/media/misc/bg-1.jpg') }})">
                                        <!--begin::Title-->
                                        <h4 class="d-flex flex-center rounded-top">
                                            <span class="text-white">Notificaciones</span>
                                            <span class="btn btn-text btn-success btn-sm font-weight-bold btn-font-md ml-2" id="total_notificaciones">0 Nuevos</span>
                                        </h4>
                                        <!--end::Title-->
                                        <!--begin::Tabs-->
                                        <ul class="nav nav-bold nav-tabs nav-tabs-line nav-tabs-line-3x nav-tabs-line-transparent-white nav-tabs-line-active-border-success mt-3 px-8" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link active show" data-toggle="tab" href="#topbar_notifications_notifications">Notificaciones</a>
                                            </li>
                                        </ul>
                                        <!--end::Tabs-->
                                    </div>
                                    <!--end::Header-->
                                    <!--begin::Content-->
                                    <div class="tab-content">
                                        <!--begin::Tabpane-->
                                        <div class="tab-pane active show" id="topbar_notifications_notifications" role="tabpanel">

                                            <!--begin::Nav-->
                                            <div class="navi navi-hover scroll my-4" data-scroll="true" data-height="300" data-mobile-height="200" id="topbar_notifications_items">


                                            </div>
                                            <!--end::Nav-->

                                            <!--begin::Action-->
                                            <div class="d-flex flex-center pt-7">
                                                <a href="{{ route('notificacion.show') }}" class="btn btn-light-primary font-weight-bold text-center">Ver todos</a>
                                            </div>
                                            <!--end::Action-->
                                        </div>
                                        <!--end::Tabpane-->

                                    </div>
                                    <!--end::Content-->
                                </form>
                            </div>
                            <!--end::Dropdown-->
                        </div>

                        @if(Auth::user()->tipo_usuario_id != 1 && Auth::user()->tipo_usuario_id != 2)
                        <!--begin::Messages-->
                        <div class="topbar-item">
                            <div class="btn btn-icon btn-clean btn-dropdown btn-lg mr-1 pulse pulse-primary" id="kt_quick_panel_toggle">
                                <a href="{{ route('chat.index') }}">
                                    <i class="icon-lg text-dark-50 flaticon2-chat-1" style="color: #669933 !important;"></i>
                                </a>
                            </div>
                        </div>
                        <!--end::Messages-->
                        @endif
                        <!--begin::User-->
                        <div class="topbar-item">
                            <div class="btn btn-icon btn-icon-mobile w-auto btn-clean d-flex align-items-center btn-lg px-2" id="kt_quick_user_toggle">
                                <span class="text-dark-50 font-weight-bolder font-size-base d-none d-md-inline mr-3">{{ Auth::user()->name }}</span>
                                <span class="symbol symbol-lg-35 symbol-25 symbol-light-success">
                                @if(Auth::user()->avatar)
                                    <img src="{{ route('archivo.documentoAvatar', Auth::user()->avatar) }}" alt="photo">
                                @else
                                    <span class="symbol-label font-size-h5 font-weight-bold">{{ Auth::user()->name[0] }}</span>
                                @endif
                            </span>
                            </div>
                        </div>
                        <!--end::User-->
                    </div>
                    <!--end::Topbar-->
                </div>
                <!--end::Container-->
            </div>
            <!--end::Header-->
            <!--begin::Content-->
            <div class="content d-flex flex-column flex-column-fluid pb-0" id="kt_content">
                <!--begin::Subheader-->
                <!--end::Subheader-->
                <!--begin::Entry-->
                <div class="d-flex flex-column-fluid pb-5">
                    <!--begin::Container-->
                    <div class="container-fluid">
                        @yield('content')
                    </div>
                    <!--end::Container-->
                </div>
                <!--end::Entry-->
            </div>
            <!--end::Content-->
            <!--begin::Footer-->
            <div class="footer bg-white py-4 d-flex flex-lg-column" id="kt_footer">
                <!--begin::Container-->
                <div class="container-fluid d-flex flex-column flex-md-row align-items-center justify-content-between">
                    <!--begin::Copyright-->
                    <div class="text-dark order-2 order-md-1">
                        <span class="text-muted font-weight-bold mr-2">@php echo date('Y'); @endphp©</span>
                        <a href="#" target="_blank" class="text-dark-75 text-hover-primary">
                        @if(Auth::user()->tipo_usuario_id != 1 && Auth::user()->tipo_usuario_id != 2)
                        SIAF SISTEMA INTEGRAL DE ADMINISTRACIÓN Y FINANZAS
                        @else
                            Jet Van Car Rental, S.A. de C.V.
                        @endif
                        </a>
                    </div>
                    <!--end::Copyright-->
                    <!--begin::Nav-->
                    <div class="nav nav-dark">
                        <a href="#" target="_blank" class="nav-link pl-0 pr-5">Soporte</a>
                    @if(Auth::user()->tipo_usuario_id != 1 && Auth::user()->tipo_usuario_id != 2)
                        <a href="#" target="_blank" class="nav-link pl-0 pr-5">Manual de Ayuda</a>
                    @endif
                    </div>
                    <!--end::Nav-->
                </div>
                <!--end::Container-->
            </div>
            <!--end::Footer-->
        </div>
        <!--end::Wrapper-->
    </div>
    <!--end::Page-->
</div>
<!--end::Main-->
<!-- begin::User Panel-->
<div id="kt_quick_user" class="offcanvas offcanvas-right p-10">
    <!--begin::Header-->
    <div class="offcanvas-header d-flex align-items-center justify-content-between pb-5">
        <h3 class="font-weight-bold m-0">Mi Perfil</h3>
        <a href="#" class="btn btn-xs btn-icon btn-light btn-hover-primary" id="kt_quick_user_close">
            <i class="ki ki-close icon-xs text-muted"></i>
        </a>
    </div>
    <!--end::Header-->
    <!--begin::Content-->
    <div class="offcanvas-content pr-5 mr-n5">
        <!--begin::Header-->
        <div class="d-flex align-items-center mt-5">
            <div class="symbol symbol-100 mr-5">
                <div class="symbol-label" style="@if(Auth::user()->avatar)
                background-image:url('{{route('archivo.documentoAvatar', Auth::user()->avatar)}}');background-size: cover;background-position: center;
                @endif
                ">
                    @if(!Auth::user()->avatar)
                        <span class="font-size-h3 font-weight-boldest text-dark-75">{{ Auth::user()->name[0] }}</span>
                    @endif    
            </div>
                <i class="symbol-badge bg-success"></i>
            </div>
            <div class="d-flex flex-column">
                <a href="{{ route('perfil.informacion') }}" class="font-weight-bold font-size-h5 text-dark-75 text-hover-primary">{{ Auth::user()->name }}</a>
                <div class="navi mt-2">
                    <a href="#" class="navi-item">
								<span class="navi-link p-0 pb-2">
									<span class="navi-icon mr-1">
										<span class="svg-icon svg-icon-lg svg-icon-primary">
											<!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Mail-notification.svg-->
											<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
												<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
													<rect x="0" y="0" width="24" height="24" />
													<path d="M21,12.0829584 C20.6747915,12.0283988 20.3407122,12 20,12 C16.6862915,12 14,14.6862915 14,18 C14,18.3407122 14.0283988,18.6747915 14.0829584,19 L5,19 C3.8954305,19 3,18.1045695 3,17 L3,8 C3,6.8954305 3.8954305,6 5,6 L19,6 C20.1045695,6 21,6.8954305 21,8 L21,12.0829584 Z M18.1444251,7.83964668 L12,11.1481833 L5.85557487,7.83964668 C5.4908718,7.6432681 5.03602525,7.77972206 4.83964668,8.14442513 C4.6432681,8.5091282 4.77972206,8.96397475 5.14442513,9.16035332 L11.6444251,12.6603533 C11.8664074,12.7798822 12.1335926,12.7798822 12.3555749,12.6603533 L18.8555749,9.16035332 C19.2202779,8.96397475 19.3567319,8.5091282 19.1603533,8.14442513 C18.9639747,7.77972206 18.5091282,7.6432681 18.1444251,7.83964668 Z" fill="#000000" />
													<circle fill="#000000" opacity="0.3" cx="19.5" cy="17.5" r="2.5" />
												</g>
											</svg>
                                            <!--end::Svg Icon-->
										</span>
									</span>
									<span title="{{ Auth::user()->email }}" class="navi-text text-muted text-hover-primary" style="display: block; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 150px;">{{ Auth::user()->email }}</span>
								</span>
                    </a>
                    <form method="POST" action="{{ route('logout') }}" id="formLogout">
                        @csrf
                        <a href="javascript:void(0);" onclick="event.preventDefault(); document.getElementById('formLogout').submit();" class="btn btn-sm btn-light-primary font-weight-bolder py-2 px-5">Salir</a>
                    </form>
                </div>
            </div>
        </div>
        <!--end::Header-->
        <!--begin::Separator-->
        <div class="separator separator-dashed mt-8 mb-5"></div>
        <!--end::Separator-->
        <!--begin::Nav-->
        <div class="navi navi-spacer-x-0 p-0">
            <!--begin::Item-->
            <a href="{{ route('perfil.informacion') }}" class="navi-item">
                <div class="navi-link">
                    <div class="symbol symbol-40 bg-light mr-3">
                        <div class="symbol-label">
							<i class="flaticon2-user text-success icon-lg"></i>
                        </div>
                    </div>
                    <div class="navi-text">
                        <div class="font-weight-bold">Mi Perfil</div>
                        <div class="text-muted">Configuración de mi perfil</div>
                    </div>
                </div>
            </a>
            <!--end:Item-->

        </div>
        <!--end::Nav-->
        <!--begin::Separator-->
        <div class="separator separator-dashed my-7"></div>
        <!--end::Separator-->

    </div>
    <!--end::Content-->
</div>
<!-- end::User Panel-->
<script>var HOST_URL = "https://preview.keenthemes.com/metronic/theme/html/tools/preview";</script>
<!--begin::Global Config(global config for global JS scripts)-->
<script>var KTAppSettings = { "breakpoints": { "sm": 576, "md": 768, "lg": 992, "xl": 1200, "xxl": 1400 }, "colors": { "theme": { "base": { "white": "#ffffff", "primary": "#3699FF", "secondary": "#E5EAEE", "success": "#1BC5BD", "info": "#8950FC", "warning": "#FFA800", "danger": "#F64E60", "light": "#E4E6EF", "dark": "#181C32" }, "light": { "white": "#ffffff", "primary": "#E1F0FF", "secondary": "#EBEDF3", "success": "#C9F7F5", "info": "#EEE5FF", "warning": "#FFF4DE", "danger": "#FFE2E5", "light": "#F3F6F9", "dark": "#D6D6E0" }, "inverse": { "white": "#ffffff", "primary": "#ffffff", "secondary": "#3F4254", "success": "#ffffff", "info": "#ffffff", "warning": "#ffffff", "danger": "#ffffff", "light": "#464E5F", "dark": "#ffffff" } }, "gray": { "gray-100": "#F3F6F9", "gray-200": "#EBEDF3", "gray-300": "#E4E6EF", "gray-400": "#D1D3E0", "gray-500": "#B5B5C3", "gray-600": "#7E8299", "gray-700": "#5E6278", "gray-800": "#3F4254", "gray-900": "#181C32" } }, "font-family": "Poppins" };</script>
<!--end::Global Config-->
<!--begin::Global Theme Bundle(used by all pages)-->
<script src="{{ asset('theme/assets/plugins/global/plugins.bundle.js') }}"></script>
<script src="{{ asset('theme/assets/plugins/custom/prismjs/prismjs.bundle.js') }}"></script>
<script src="{{ asset('theme/assets/js/scripts.bundle.js') }}"></script>
<!--end::Global Theme Bundle-->
<!--begin::Page Vendors(used by this page)-->
<script src="{{ asset('vendors/select2/i18n/es.js') }}"></script>
<script src="{{ asset('theme/assets/plugins/custom/fullcalendar/fullcalendar.bundle.js') }}"></script>
<script src="{{ asset('theme/assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
<script src="{{ asset('theme/assets/js/pages/crud/forms/widgets/bootstrap-datepicker.js') }}"></script>
<script src="{{ asset('vendors/bootstrap-datepicker/locale/bootstrap-datepicker.es.min.js') }}"></script>
<script src="{{ asset('vendors/formvalidation/js/locales/es_ES.js') }}"></script>
<script src="{{ asset('vendors/formvalidation/js/validacionComun.js') }}"></script>
<script src="{{ asset('vendors/formvalidation/js/plugins/Transformer.min.js') }}"></script>
<script src="{{ asset('theme/assets/js/pages/features/miscellaneous/sweetalert2.js') }}"></script>
<script src="{{ asset('theme/assets/js/pages/crud/forms/widgets/bootstrap-switch.js') }}"></script>
<!--end::Page Vendors-->
<!--begin::Page Scripts(used by this page)-->
@stack('scripts')
<!--end::Page Scripts-->

<!--begin::Custom Scripts(used by all pages)-->
<script src="{{ asset('js/Principal.js') }}"></script>
<script src="{{ asset('js/notificacion/notificacion.js') }}"></script>
<!--end::Custom Scripts-->

<!--begin::Page Scripts(Para mostrar los mensajes con toastr)-->
<script>

    @if(Session::has('message'))
        toastr.options =
        {
            "closeButton" : true,
            "progressBar" : true
        }
        toastr.success("{{ session('message') }}");
    @endif
    @if(Session::has('success'))
        toastr.options =
        {
            "closeButton" : true,
            "progressBar" : true
        }
        toastr.success("{{ session('success') }}");
    @endif
    @if(Session::has('error'))
        toastr.options =
        {
            "closeButton" : true,
            "progressBar" : true
        }
        toastr.error("{{ session('error') }}");
    @endif
        @if(Session::has('info'))
        toastr.options =
        {
            "closeButton" : true,
            "progressBar" : true
        }
        toastr.info("{{ session('info') }}");
    @endif
    @if(Session::has('warning'))
        toastr.options =
        {
            "closeButton" : true,
            "progressBar" : true
        }
        toastr.warning("{{ session('warning') }}");
    @endif
</script>
<!--end::Page Scripts(Para mostrar los mensajes con toastr)-->
</body>
<!--end::Body-->
</html>
