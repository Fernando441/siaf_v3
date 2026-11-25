@extends('layouts.app')
@section('title')
	Tablero
@endsection
@push('scripts')
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
	<script src="{{ asset('js/tablero/Notificaciones.js') }}"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.js"></script>
	<script src="{{ asset('js/tablero/GraficasTablero.js') }}"></script>
	<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
	<script src="https://www.gstatic.com/charts/loader.js"></script>
@endpush

@section('content')
	@php
	@endphp

	<style type="text/css">
		.tittle-graficas {
			font-size: 15px;
			font-weight: 700;
		}

		#calendario {
			max-width: 536px;
			background-color: #ffffff;
			text-align: center;
		}

		/*tabla del calendario*/
		#diasc {
			border-collapse:
				separate;
			border-spacing: 4px;
		}

		#diasc th,
		#diasc td {
			font: normal 12pt arial;
			width: 65px;
			height: 25px;
		}

		#diasc th {
			color: #669933;
			background-color: #ffffff
		}

		#diasc td {
			color: #492736;
			background-color: #669933
		}

		/*línea de la fecha actual*/
		#fechaactual {
			font: bold 12pt arial;
			padding: 0.4em
		}

		#fechaactual i {
			cursor: pointer;
		}

		#fechaactual i:hover {
			color: #669933;
			text-decoration: underline;
		}

		/*formulario de busqueda de fechas*/
		#buscafecha {
			background-color: #669933;
			color: #ffffff;
			padding: 5px
		}

		#buscafecha select,
		#buscafecha input {
			background-color: #ffffff;
			color: #000000;
			font: bold 10pt arial;
		}

		#buscafecha [type=text] {
			text-align: center;
		}

		#buscafecha [type=button] {
			cursor: pointer;
		}

		/*cabecera del calendario*/
		#anterior {
			float: left;
			width: 100px;
			font: bold 12pt arial;
			padding: 0.5em 0.1em;
			cursor: pointer;
		}

		#posterior {
			float: right;
			width: 100px;
			font: bold 12pt arial;
			padding: 0.5em 0.1em;
			cursor: pointer;
		}

		#anterior:hover {
			color: #669933;
			text-decoration: underline;
		}

		#posterior:hover {
			color: #669933;
			text-decoration: underline;
		}

		#titulos {
			font: normal 11pt "arial black";
			padding: 0.2em;
		}

		/* CONTENEDOR DEL MENU */
		.menu-graficas-contenedor {
			background: #ffffff;
			padding: 15px;
			border-radius: 10px;
			height: 100%;
			min-height: 350px;
		}

		/* TITULOS */
		.menu-graficas-titulo {
			font-size: 11px;
			font-weight: 700;
			color: #98a2b3;
			letter-spacing: 1px;
			padding: 10px 12px;
			margin-bottom: 8px;
		}

		/* OPCIONES */
		.menu-graficas-link {
			display: flex;
			align-items: center;
			gap: 12px;
			padding: 13px 12px;
			margin-bottom: 5px;
			border-radius: 8px;
			color: #34445b;
			font-size: 14px;
			font-weight: 500;
			text-decoration: none !important;
			transition: all .25s ease;
		}

		/* ICONOS */
		.menu-graficas-link i:first-child {
			color: #000000;
			font-size: 17px;
			width: 22px;
			text-align: center;
		}

		/* FLECHAS */
		.menu-graficas-link .flecha {
			margin-left: auto;
			color: #aab3bf;
			font-size: 11px;
		}

		/* HOVER */
		.menu-graficas-link:hover {
			background: #f2f8ef;
			color: #45952f;
			transform: translateX(3px);
		}

		/* OPCION ACTIVA */
		.menu-graficas-link.activo {
			background: #edf7e9;
			color: #398c2d;
			font-weight: 600;
			border-left: 3px solid #59a532;
		}

		/* SEPARADOR */
		.menu-graficas-separador {
			height: 1px;
			background: #edf0f3;
			margin: 15px 0;
		}

		/* RESPONSIVE */
		@media (max-width: 991px) {
			.menu-graficas-contenedor {
				margin-top: 15px;
				min-height: auto;
			}
		}

		/* OCULTA LAS GRAFICAS */
		.contenido-grafica {
			display: none;
		}

		.contenido-grafica.activo {
			display: block;
		}

		/* Estilo de opción activa */
		.menu-graficas-link.activo {
			background-color: #2c681d;
			color: #ffffff;
		}
	</style>

	<!-- @if (Session::has('permisos'))
																										@if (in_array("109", Session::get('permisos')))
																											<div class="row">
																												@if(Auth::user()->tipo_usuario_id != 1 && Auth::user()->tipo_usuario_id != 2)
																													<div class="card-body">
																														<input type="hidden" id="datatable_i18n" value="{{ asset('/js/datatables/i18n/es-mx.json') }}">
																													</div>
																												@endif
																											</div>
																										@endif
																									@endif -->

	<!-- ESTADISTICAS -->
	<div class="row dashboard-stats">

		<!-- TOTAL DE CLIENTES -->
		<div class="col-xl-3 col-lg-6 col-md-6">
			<a href="{{ route('cliente.catalogoCliente') }}" style="text-decoration: none; color: inherit;">
				<div class="stat-card stat-blue" style="cursor: pointer;">
					<div class="stat-content">
						<div class="stat-value">
							{{$total_clientes}}
						</div>
						<div class="stat-label">
							TOTAL DE CLIENTES
						</div>
					</div>
					<div class="stat-icon">
						<i class="fas fa-laptop"></i>
					</div>
				</div>

			</a>
		</div>

		<!-- EQUIPOS CONCURSOS -->
		<div class="col-xl-3 col-lg-6 col-md-6">
			<a href="{{ route('licitacion.listadolicitaciones') }}" style="text-decoration: none; color: inherit;">
				<div class="stat-card stat-cyan" style="cursor: pointer;">
					<div class="stat-content">
						<div class="stat-value">
							{{$total_licitaciones}}
						</div>
						<div class="stat-label">
							TOTAL DE CONCURSOS
						</div>

					</div>

					<div class="stat-icon">
						<i class="fas fa-check-circle"></i>
					</div>
				</div>
			</a>
		</div>

		<!-- TOTAL DE REQUISICIONES -->
		<div class="col-xl-3 col-lg-6 col-md-6">
			<a href="{{ route('concurso.requisiciones.catalogorequisicion') }}"
				style="text-decoration: none; color: inherit;">
				<div class="stat-card stat-gold" style="cursor: pointer;">
					<div class="stat-content">
						<div class="stat-value">
							{{$total_requisiciones}}
						</div>
						<div class="stat-label">
							TOTAL DE REQUISICIONES
						</div>
					</div>

					<div class="stat-icon">
						<i class="fas fa-clock"></i>
					</div>
				</div>
			</a>
		</div>

		<!-- TOTAL DE PARQUE VAHICULAR -->
		<div class="col-xl-3 col-lg-6 col-md-6">
			<div class="stat-card stat-red">
				<div class="stat-content">
					<div class="stat-value">
						{{$total_segmentos}}
					</div>
					<div class="stat-label">
						TOTAL DE SEGMENTOS
					</div>
				</div>

				<div class="stat-icon">
					<i class="far fa-trash-alt"></i>
				</div>
			</div>
		</div>

	</div>
	<!-- FIN ESTADISTICAS -->

	{{-- PANEL DE GRAFICAS --}}
	<div id="div_grafica_tablero">
		<div class="col-lg-12">
			<div class="card">
				<div class="card-body">
					<div class="row">

						{{-- CONTENEDOR DE GRÁFICAS --}}
						<div class="col-lg-9 col-md-12 mb-4 cont-Graficas">

							{{-- MAPA --}}
							<div id="grafica-mapa" class="contenido-grafica activo">
								<h3 class="card-title mb-3">
									PRESENCIA DE JETVAN NACIONALMENTE
									<img src="https://flagcdn.com/w40/mx.png" alt="México"
										style="width: 25px; vertical-align: middle;">
								</h3>
								<div id="regions_div" style="width: 100%; height: 500px;">
									<script>
										var totalclientesestado = @json($total_clientes_estados);
									</script>
								</div>
							</div>

							{{-- CLIENTES --}}
							<div id="grafica-clientes" class="contenido-grafica">
								<h3 class="card-title mb-3">GRÁFICAS DE CLIENTES</h3>

								<div class="row">
									<div class="col-lg-6 col-md-6 mb-4">
										<!-- graficaTipoPersonas -->
										<canvas id="graficaEquipTipoPersonas"></canvas>
										<input type="hidden" id="fisicas" value="{{ $total_fisicas }}">
										<input type="hidden" id="morales" value="{{ $total_morales }}">
									</div>

									<div class="col-lg-6 col-md-6 mb-4">
										<!-- graficaClientesActivosNoActivos -->
										<canvas id="graficaClientesActivosNoActivos"></canvas>
										<input type="hidden" id="activos" value="{{ $total_clientes_activos }}">
										<input type="hidden" id="noactivos" value="{{ $total_clientes_no_activos }}">
									</div>
								</div>
							</div>

							{{-- CONCURSOS --}}
							<div id="grafica-concursos" class="contenido-grafica">
								<h3 class="card-title mb-3">GRÁFICAS DE CONCURSOS</h3>
								<div class="row">
									<!-- graficaPrioridades -->
									<div class="col-lg-4 col-md-6 col-12 mb-4">
										<canvas id="graficaPrioridades"></canvas>
										<input type="hidden" id="p_alta" value="{{ $total_concursos_alta }}">
										<input type="hidden" id="p_media" value="{{ $total_concursos_media }}">
										<input type="hidden" id="p_baja" value="{{ $total_concursos_baja }}">
									</div>
									<!-- graficaTipodeContratacion -->
									<div class="col-lg-4 col-md-6 col-12 mb-4">
										<canvas id="graficaTipodeContratacion"></canvas>
										@php
											$tipo_contrataciones = $total_tipo_contratacion
												->groupBy(fn($unid) => $unid->tipo_contratacion)
												->map(fn($contra) => $contra->count());
										@endphp
										<script>
											window.tipo_contrataciones = @json($tipo_contrataciones);
										</script>
									</div>
									<!-- graficaPublicacionConcurso -->
									<div class="col-lg-4 col-md-6 col-12 mb-4">
										<canvas id="graficaPublicacionConcurso"></canvas>
										@php
											$tipo_publicaciones = $total_tipo_contratacion
												->groupBy(fn($unid) => $unid->publ)
												->map(fn($contra) => $contra->count());
										@endphp
										<script>
											window.tipo_publicaciones = @json($tipo_publicaciones);
										</script>
									</div>

								</div>
							</div>

							{{-- REQUISICIONES --}}
							<div id="grafica-requisiciones" class="contenido-grafica">
								<h3 class="card-title mb-3">GRÁFICAS DE REQUISICIONES</h3>

								<!-- graficaEstatus -->
								<div class="col-lg-4 col-md-6 mb-4">
									<canvas id="graficaEstatus"></canvas>
									<script>
										window.obtener_estatus = @json($estatus);
									</script>
								</div>
							</div>

							{{-- SEGMENTOS --}}
							<div id="grafica-segmentos" class="contenido-grafica">
								<h3 class="card-title mb-3">GRÁFICAS DE SEGMENTOS</h3>

								<img src="imagenes/segmentos.png" class="img-fluid">
							</div>

						</div>
						{{-- FIN CONTENEDOR DE GRÁFICAS --}}


						{{-- MENU LATERAL --}}
						<div class="col-lg-3 col-md-12 menu-Graficas">

							<div class="menu-graficas-contenedor">

								<div class="menu-graficas-titulo">
									<span>GRÁFICAS</span>
								</div>

								<a href="#" class="menu-graficas-link activo" data-target="grafica-mapa">
									<i class="fas fa-map-marked-alt"></i>
									<span>Mapa</span>
								</a>

								<a href="#" class="menu-graficas-link" data-target="grafica-clientes">
									<i class="fas fa-users"></i>
									<span>Clientes</span>
								</a>

								<a href="#" class="menu-graficas-link" data-target="grafica-concursos">
									<i class="fas fa-building"></i>
									<span>Concursos</span>
								</a>

								<a href="#" class="menu-graficas-link" data-target="grafica-requisiciones">
									<i class="fas fa-file-alt"></i>
									<span>Requisiciones</span>
								</a>

								<a href="#" class="menu-graficas-link" data-target="grafica-segmentos">
									<i class="fas fa-truck"></i>
									<span>Segmentos</span>
								</a>

							</div>

						</div>
						{{-- FIN MENU LATERAL --}}

					</div>
				</div>
			</div>
		</div>
	</div>
	{{-- FIN PANEL DE GRAFICAS --}}


	<div class="row mt-3">
		<div class="col-lg-8">
			<div class="card card-custom">
				<div class="card-header">
					<div class="card-title">
						<span class="card-icon">
							<i class="flaticon2-file text-primary"></i>
						</span>
						<h3 class="card-label">Pendientes</h3>
					</div>
					<div class="card-toolbar">
						<a href="" class="btn btn-light-primary font-weight-bolder mr-3 ml-3" data-toggle="modal"
							data-target="#kt_modal_1"> <i class="la la-plus"></i>Nuevo</a>
					</div>
				</div>

				<div class="card-body">
					<ul class="nav nav-tabs nav-tabs-line">
						<li class="nav-item">
							<a class="nav-link active" data-toggle="tab" href="#kt_tab_pane_1">Pendientes</a>
						</li>
					</ul>
					<div class="tab-content mt-5" id="myTabContent">
						<div class="tab-pane fade show active mt-10" id="kt_tab_pane_1" role="tabpanel"
							aria-labelledby="kt_tab_pane_1">

							<table class="table table-hover table-checkable" id="kdatatable_pendientes">
								<thead>
									<tr>
										<th>Título</th>
										<th>Descripción</th>
										<th>Fecha de inicio</th>
										<th>Fecha final</th>
										<th>Prioridad</th>
										<th>Estatus</th>
										<th class="text-center">Opciones</th>
									</tr>
								</thead>

								<tbody>
									@foreach($pendientes as $unid)
										<tr>
											<td><a href="{{ route('taller.verpendiente', $unid->id) }}">{{ $unid->titulo }}</a>
											</td>
											<td>{{ $unid->descripcion }}</td>
											<td>{{ $unid->fecha_hora_inicio }}</td>
											<td>{{ $unid->fecha_hora_final }}</td>
											<td>
												@if($unid->prioridad == 0)
													<span
														class="label font-weight-bold label-outline-danger label-inline">Alta</span>
												@endif
												@if($unid->prioridad == 1)
													<span
														class="label font-weight-bold label-outline-warning label-inline">Media</span>
												@endif
												@if($unid->prioridad == 2)
													<span
														class="label font-weight-bold label-outline-success label-inline">Baja</span>
												@endif
											</td>
											<td>
												@if($unid->op_finalizado == 0)
													<span
														class="label font-weight-bold label-outline-danger label-inline">Pendiente</span>
												@endif
												@if($unid->op_finalizado == 1)
													<span
														class="label font-weight-bold label-outline-success label-inline">Completado</span>
												@endif
											</td>

											<td class="text-center">
												<a href="{{ route('taller.verpendiente', $unid->id) }}"
													class="btn btn-sm btn-clean btn-hover-icon-success btn-icon"
													data-toggle="tooltip" data-theme="dark" title="Ver Pendiente">
													<i class="flaticon-eye"></i>
												</a>
											</td>
										</tr>
									@endforeach
								</tbody>

								<tfoot>
									<tr>
										<th>Título</th>
										<th>Descripción</th>
										<th>Fecha de inicio</th>
										<th>Fecha final</th>
										<th>Prioridad</th>
										<th>Estatus</th>
										<th class="text-center">Opciones</th>
									</tr>
								</tfoot>
							</table>
						</div>


						<!--begin: Datatable-->

						<!--end: Datatable-->
						<input type="hidden" id="datatable_i18n" value="{{ asset('/js/datatables/i18n/es-mx.json') }}">
					</div>
				</div>
			</div>
		</div>


		<div class="col-lg-4">
			<div class="card">

				<div id="calendario">
					<div id="anterior" onclick="mesantes()"></div>
					<div id="posterior" onclick="mesdespues()"></div>
					<h2 id="titulos"></h2>
					<table id="diasc">
						<tr id="fila0">
							<th></th>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
						</tr>
						<tr id="fila1">
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						<tr id="fila2">
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						<tr id="fila3">
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						<tr id="fila4">
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						<tr id="fila5">
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						<tr id="fila6">
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
					</table>
					<div id="fechaactual"><i onclick="actualizar()">HOY: </i></div>
					<div id="buscafecha">
						<form action="#" name="buscar">
							<p>Buscar ... MES
								<select name="buscames">
									<option value="0">Enero</option>
									<option value="1">Febrero</option>
									<option value="2">Marzo</option>
									<option value="3">Abril</option>
									<option value="4">Mayo</option>
									<option value="5">Junio</option>
									<option value="6">Julio</option>
									<option value="7">Agosto</option>
									<option value="8">Septiembre</option>
									<option value="9">Octubre</option>
									<option value="10">Noviembre</option>
									<option value="11">Diciembre</option>
								</select>
								... AÑO ...
								<input type="text" name="buscaanno" maxlength="4" size="4" />
								...
								<input type="button" value="BUSCAR" onclick="mifecha()" />
							</p>
						</form>
					</div>
				</div>
			</div>

		</div>
	</div>
	{{-- END Direccion Comercial


	{{-- Modal Pendientes --}}
	<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"
		id="kt_modal_1">
		<div class="modal-dialog">
			<div class="modal-content max-w-[600px] top-[10%]">
				<div class="modal-header">
					<h5 class="modal-title">Agregar Pendiente</h5>

					<div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
						aria-label="Close">
						<span class="svg-icon svg-icon-2x"></span>
					</div>
				</div>

				<div class="modal-body">
					<form action="{{ route('taller.guardarpendiente') }}" method="post" id="submit_pendiente">
						@csrf
						<input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
						<div class="row form-group">
							<div class="col-lg-12">
								<label>Prioridad</label>
								<div class="radio-inline">
									<label class="radio">
										<input type="radio" checked name="prioridad" value="0" required />
										<span></span>
										Alta
									</label>

									<label class="radio">
										<input type="radio" name="prioridad" value="1" required />
										<span></span>
										Media
									</label>

									<label class="radio">
										<input type="radio" name="prioridad" value="2" required />
										<span></span>
										Baja
									</label>

								</div>
							</div>
						</div>


						<div class="row form-group">
							<div class="col-lg-12 mt-2">
								<label>Título</label>
								<input type="text" class="form-control" name="titulo" id="titulo" />
							</div>

							<div class="col-lg-12 mt-2">
								<label>Descripción</label>
								<textarea class="form-control specialCharts" name="descripcion" id="descripcion"></textarea>
							</div>

							<div class="col-lg-6 mt-2">
								<label>Fecha y hora de inicio</label>
								<input type="datetime-local" class="form-control" name="fecha_hora_inicio"
									id="fecha_inicio" />
							</div>
							<div class="col-lg-6 mt-2">
								<label>Fecha y hora final</label>
								<input type="datetime-local" class="form-control" name="fecha_hora_final"
									id="fecha_final" />
							</div>

						</div>
					</form>
				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn btn-secondary font-weight-bold" data-dismiss="modal"><i
							class="la la-times"></i>Cancelar</button>
					<button type="button" id="send_pendiente" class="btn btn-success"><i
							class="la la-plus"></i>Guardar</button>
				</div>
			</div>
		</div>
	</div>




@endsection