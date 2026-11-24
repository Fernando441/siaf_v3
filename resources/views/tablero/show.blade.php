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
	</style>

	@if (Session::has('permisos'))
		@if (in_array("109", Session::get('permisos')))
			<div class="row">
				@if(Auth::user()->tipo_usuario_id != 1 && Auth::user()->tipo_usuario_id != 2)
					<div class="card-body">
						<input type="hidden" id="datatable_i18n" value="{{ asset('/js/datatables/i18n/es-mx.json') }}">
					</div>
				@endif
			</div>
		@endif
	@endif

	<!-- ESTADISTICAS -->
	<div class="row dashboard-stats">

		<!-- TOTAL DE CLIENTES -->
		<div class="col-xl-3 col-lg-6 col-md-6">
			<div class="stat-card stat-blue">
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
		</div>

		<!-- EQUIPOS CONCURSOS -->
		<div class="col-xl-3 col-lg-6 col-md-6">
			<div class="stat-card stat-cyan">
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
		</div>

		<!-- TOTAL DE REQUISICIONES -->
		<div class="col-xl-3 col-lg-6 col-md-6">
			<div class="stat-card stat-gold">
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
		</div>

		<!-- TOTAL DE PARQUE VAHICULAR -->
		<div class="col-xl-3 col-lg-6 col-md-6">
			<div class="stat-card stat-red">
				<div class="stat-content">
					<div class="stat-value">
						VARIABLE$
					</div>
					<div class="stat-label">
						TOTAL PARQUE VEHICULAR
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
	<div class="" id="div_grafica_tablero">
		<div class="col-lg-12">
			<div class="card">
				<div class="card-header">
					<h3 class="card-title">
						PRESENCIA DE JETVAN NACIONALMENTE
						<img src="https://flagcdn.com/w40/mx.png" alt="México" style="width: 25px; vertical-align: middle;">
					</h3>
				</div>
				<div class="card-body">
					<div class="row">
						<!-- graficaRegistrosEstados -->
						<div class="col-lg-12 col-md-12 mb-4">
							<div id="regions_div" style="width: 100%; height: 500px;"></div>
							<script>
								var totalclientesestado = @json($total_clientes_estados);
							</script>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	{{-- FIN PANEL --}}
	<div class="row">
		<div class="col-lg-6">
			<div class="card">
				<div class="card-body">
					<div class="row">
						<div class="col-lg-6">
							<span class="tittle-graficas">Concursos / Prioridad</span>

						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="col-lg-6">
			<div class="card">
				<div class="card-body">
					<div class="row">
						<div class="col-lg-6">
							<span class="tittle-graficas">Concursos / Contrato</span>
						</div>
					</div>

				</div>
			</div>

		</div>

	</div>


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
			//Claendario


			<div class="card mt-2">

				<div class="card card-custom">
					<div class="card-header">
						<div class="card-title">

							<h3 class="card-label">Prioridad</h3>
						</div>

					</div>

					<div class="card-body">
						<div>
							<span>Alta = {{ count($pendiente_pri_alta) }}</span><br>
							<span>Media = {{ count($pendiente_pri_media) }}</span><br>
							<span>Baja = {{ count($pendiente_pri_baja) }}</span>
						</div>
					</div>
				</div>
			</div>

			<div class="card mt-2">

				<div class="card card-custom">
					<div class="card-header">
						<div class="card-title">
							<h3 class="card-label">Estatus</h3>
						</div>

					</div>

					<div class="card-body">
						<div>
							<span>Pendientes = {{ count($pendiente_no_finalizado) }}</span><br>
							<span>Finalizadas = {{ count($pendiente_finalizado) }}</span><br>
						</div>

						<div>
							<canvas id="grafica_pendiente" style="width: 100px;"></canvas>
							<input type="hidden" id="pendiente_no" value="{{ count($pendiente_no_finalizado) }}">
							<input type="hidden" id="pendiente_si" value="{{ count($pendiente_finalizado) }}">
						</div>

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