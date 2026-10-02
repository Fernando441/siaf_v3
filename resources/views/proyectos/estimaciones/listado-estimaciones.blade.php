@extends('layouts.app')
@section('title')
    Estimaciones
@endsection
@push('scripts')
	<script src="{{ asset('js/contratos/Estimaciones.js') }}"></script>
	<meta name="csrf-token" content="{{ csrf_token() }}" />
@endpush
@section('content')

    <div class="d-flex flex-row">

    <!--begin::List-->
    <div class="flex-row-fluid">
        <div class="d-flex flex-column flex-grow-1">

            <!--begin::Row-->
            <div class="row">
                <div class="col-xl-12">

                <!--begin::Card-->
                    <div class="card card-custom">
                        <div class="card-header">
                            <div class="card-title">
                      <span class="card-icon">
                        <i class="flaticon2-file text-primary"></i>
                      </span>
                                <h3 class="card-label">Inventario de estimaciones</h3>
                            </div>
                            <div class="card-toolbar">

                                <a href="#" class="btn btn-light-primary font-weight-bolder mr-3 ml-3" data-toggle="modal" data-target="#kt_modal_1">
                                    <i class="la la-plus"></i>Nuevo
                                </a>

                                <!--begin::Button-->
                                <a href="{{ route('proyecto.listadoproyectos') }}" class="btn btn-light-primary font-weight-bolder mr-3 ml-3">
                                    <i class="la la-arrow-left"></i>Regresar
                                </a>
                                <!--end::Button-->

                            </div>
                        </div>
                        <div class="card-body">
                            <!--begin: Datatable-->
                            <table class="table table-hover table-checkable" id="kdatatable_estimaciones">
                                <thead>
                                <tr>
                                  <th>Folio</th>
                                  <th>Cliente</th>
                                  <th>Periodo inicial</th>
                                  <th>Periodo final</th>
                                  <th>Importe</th>
                                  <th>Estatus</th>
                                  <th class="text-center">Opciones</th>
                                </tr>
                                </thead>

                                <tbody>
                                  @foreach($estimaciones as $unid)
                                    <tr>
                                      <td>{{ $unid->no_folio }}</td>
                                      <td>{{ $unid->cliente->razon_social }}</td>
                                      <td>{{ date('d/m/Y ' , strtotime( $unid->periodo_inicial)) }}</td>
                                      <td>{{ date('d/m/Y ' , strtotime( $unid->periodo_final)) }}</td>
                                      <td>
                                          @if($unid->seguimiento_estimaciones == 0)
                                            <span class="font-weight-bold">*El importe sera visible al enviar a finanzas</span>
                                          @else
                                            <span class="label font-weight-bold label-outline-success label-outline label-inline">${{ number_format($unid->importe_estimacion,2,'.',',') }}</span>
                                          @endif
                                      </td>
                                      <td>
                                          @if($unid->seguimiento_estimaciones == 0)
                                            En proceso
                                          @endif
                                          @if($unid->seguimiento_estimaciones == 1)
                                            Enviada a finanzas
                                          @endif
                                          @if($unid->seguimiento_estimaciones == 2)
                                            Finalizada
                                          @endif
                                      </td>
                                      <td class="text-center">
                                        <button rel-path="/proyecto/ver-estimacionpro-pdf/{{$unid->id}}"  class="btn btn-sm btn-clean btn-hover-icon-success btn-icon modal-pdf" title="Ver PDF" data-theme="dark"  data-toggle="tooltip" data-placement="top">
                                                <i class="far fa-file-pdf"></i>
                                        </button>

                                        <a href="{{ route('estimaciones.descargarExcel', [$licitacion, $unid->id]) }}" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon" data-toggle="tooltip" data-theme="dark" title="Descargar Excel"><i class="far fa-file-excel"></i></a>

                                        <a href="{{ route('estimaciones.verestimacion', [$licitacion, $unid->id ]) }}"  class="btn btn-sm btn-clean btn-hover-icon-success btn-icon " data-toggle="tooltip" data-theme="dark" title="Ver estimación" ><i class="flaticon-eye"></i></a>

                                        @if($unid->estatus_envio == 0)
                                          <a href="{{ route('estimaciones.detalleestimacion', [$licitacion, $unid->id ]) }}"  class="btn btn-sm btn-clean btn-hover-icon-success btn-icon " data-toggle="tooltip" data-theme="dark" title="Editar estimación" ><i class="flaticon-edit"></i></a>
                                        @endif

                                        @if($unid->estatus_envio == 0)
                                          <button class="btn btn-sm btn-clean btn-hover-icon-success btn-icon send-finanzas" data-id="{{ $unid->id }}" data-nombre="{{ $unid->no_folio }}" data-toggle="tooltip" data-theme="dark" title="Enviar a finanzas" ><i class="flaticon2-delivery-truck"></i></button>
                                        @endif
                                      </td>
                                    </tr>
                                  @endforeach
                                </tbody>

                                <tfoot>
                                <tr>
                                  <th>Folio</th>
                                  <th>Cliente</th>
                                  <th>Periodo inicial</th>
                                  <th>Periodo final</th>
                                  <th>Importe</th>
                                  <th>Estatus</th>
                                  <th class="text-center">Opciones</th>
                                </tr>
                                </tfoot>

                            </table>
                            <!--end: Datatable-->

                            <input type="hidden" id="datatable_i18n" value="{{ asset('/js/datatables/i18n/es-mx.json') }}">

                        </div>
                    </div>
                    <!--end::Card-->
                    <!--end::Card-->
                </div>

            </div>
            <!--end::Row-->
        </div>
    </div>
    <!--end::List-->
</div>



  <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" id="kt_modal_1">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title">Agregar estimación</h5>

                  <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                      <span class="svg-icon svg-icon-2x"></span>
                  </div>
              </div>
                <form action="{{ route('estimaciones.guardarestimacion') }}" method="post" id="submit_estimacion">
                @csrf
              <div class="modal-body">
              		<input type="hidden" name="licitacion_id" value="{{ $licitacion }}">
                  <div class="row form-group">
                    <div class="col-lg-12 mt-2">
                    	<label>Periodo inicial</label>
                      	<input type="date" class="form-control" name="periodo_inicial" id="periodo_inicial" required  />
                    </div>

                    <div class="col-lg-12 mt-2">
                      <label>Periodo final</label>
                      <input type="date" class="form-control" name="periodo_final" id="periodo_final" required />
                    </div>

                  </div>
                
              </div>

              <div class="modal-footer">
                <button type="button" class="btn btn btn-secondary font-weight-bold" data-dismiss="modal">Cancelar</button>
                <button type="button"  id="btnGuardar" class="btn btn-success"><i class="la la-plus"></i>Guardar</button>
              </div>
              </form>
          </div>
      </div>
  </div>



    <form method="post" id="send_finanzas_form" action="{{ route('estimaciones.estimacionafinanzas') }}"
        enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="id" id="id_estimacion" value="">
        <input type="hidden" name="licitacion" value="{{ $licitacion }}">
    </form>

    <div class="modal fade" id="exampleModalSizeSm" tabindex="-1" role="dialog" aria-labelledby="exampleModalSizeSm"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Estimación</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <div id="modal-body" class="modal-body">
                    
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn btn-secondary font-weight-bold" data-dismiss="modal"><i
                            class="la la-times"></i>Cerrar</button>
                     
                </div>
            </div>
        </div>
    </div>
    


{{--   <form method="post" id="fuente_act_form" action="{{ route('fuenteproyecto.activarfuente') }}" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="id" id="id_act_fuente" value="">
  </form> --}}




{{-- 
<div class="row">
	<div class="col-lg-12">
		<div class="card card-custom gutter-b">
			<div class="card-header">
				<div class="card-title">
					<h3 class="card-label">
						Estimaciones
					</h3>
				</div>
			        <div class="card-toolbar">
							<a href="{{ route('proyecto.listadoproyectos' ) }}" class="btn btn-light-primary font-weight-bolder mr-3 ml-3">
                                <i class="la la-arrow-left"></i>Regresar
                        	</a>

			        </div>

			</div>
			<div class="card-body">


				<div class="card card-custom gutter-b">
					<div class="card-header">
						<div class="card-title">
							<h3 class="card-label">
								Información General
								<small>Periodo 01 al 31 de Marzo 2023</small>
							</h3>
						</div>
					</div>
					<div class="card-body">
                        <div class="row form-group mt-2">
                            <div class="col-lg-2">
                                <label>ID sistema</label>
                                <p>1074</p>
                            </div>

                            <div class="col-lg-4">
                                <label>Dependencia</label>
                                <p>DESARROLLO INTEGRAL DE LA FAMILIA TLANEPANTLA DE BAZ</p>
                            </div>

                            <div class="col-lg-4">
                                <label>RFC</label>
                                <p>SMD9702126A6</p>
                            </div>
                        </div>

                        <div class="row form-group mt-2">
                            <div class="col-lg-4">
                                <label>NO. Contrato</label>
                                <p></p>
                            </div>

                            <div class="col-lg-4">
                                <label>Inicio de vigencia</label>
                                <p></p>
                            </div>

                            <div class="col-lg-4">
                                <label>Fin de vigencia</label>
                                <p></p>
                            </div>
                        </div>
					</div>
				</div>




				<table class="table table-hover mb-6 table-responsive-sm kdatatable_unidades_proyectos" >
				    <thead>
				        <tr>
				            <th>Unidad</th>
				            <th>No. Serie</th>
				            <th>Placa</th>
				            <th>Año</th>
				            <th>Fecha de asignación</th>
				            <th>Tipo asignación</th>
				            <th>Cliente</th>
				        </tr>
				    </thead>
				    <tbody id="tbodyDoc_">
				        @foreach($unidad_movimiento as $unid)
				                <tr>
				                    <td>{{ $unid->nombre_marca }} / {{ $unid->nombre_modelo }}</td>
				                    <td>{{ $unid->no_serie }}</td>
				                    <td>{{ $unid->placa }}</td>
				                    <td>{{ $unid->unidad_year }}</td>
				                    <td>{{ $unid->fecha_asignacion }}</td>
				                    <td>{{ $unid->tipo_asignacion }}</td>
				                    <td>{{ $unid->name }}</td>

				                </tr>
				            <input type="hidden" id="datatable_i18n" value="{{ asset('/js/datatables/i18n/es-mx.json') }}">
				        @endforeach
				    </tbody>
				</table>

			</div>
		</div>
	</div>
</div>
 --}}


@endsection