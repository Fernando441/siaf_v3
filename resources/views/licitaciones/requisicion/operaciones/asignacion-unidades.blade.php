@extends('layouts.app')
@section('title')
    Asignacion de unidades
@endsection
@push('scripts')
<script src="{{ asset('js/licitaciones/requisicion/operaciones/ListadoRequisicionesOperaciones.js') }}"></script>
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
                                <h3 class="card-label">Dirección de operaciones</h3>
                            </div>
                            <div class="card-toolbar">

                                <!--begin::Button-->
                                <a href="{{ route('reqoperaciones.catalogorequisicionoperaciones') }}" class="btn btn-light-primary font-weight-bolder mr-3 ml-3">
                                  Regresar</a>
                                <!--end::Button-->

                            </div>
                        </div>
                        <div class="card-body">

                        	<div class="row">
                        		<div class="col-lg-8">

                        		</div>
                        		@if($req->visto_bueno_operaciones == 1)
	                        		<div class="col-lg-4">
										<a href="#" id="vistobueno" class="btn btn-icon btn-danger btn-circle text-center">
										    <i class="flaticon2-checkmark"></i>
										</a>
										<span style="color: gray; font-size: 12px">* Para continuar es necesario dar visto bueno a la requisición</span>
	                        		</div>
	                        	@else
	                        		<div class="col-lg-4">
										<a href="#"  class="btn btn-icon btn-success btn-circle text-center">
										    <i class="flaticon2-checkmark"></i>
										</a>
										<br>
										<span style="color: gray; font-size: 12px">Visto bueno realizado por {{ $req->uservistobueno->name }} con fecha del {{ $req->hora_vistobueno }}</span>
	                        		</div>
	                        	@endif
                        	</div>

                        	<div class="row">
                        		<div class="row">	
                        			<div class="col-lg-12"> 
                        					<h5>Detalle de la requisición</h5>	
                        			</div>
                        		</div>
	                            <table class="table table-hover mb-6 table-responsive-sm" id="tblDocumentos">
	                                <thead>
	                                    <tr>
	                                        <th>Descripción</th>
	                                        <th>Cantidad</th>
	                                        <th>Observaciones</th>
	                                    </tr>
	                                </thead>
	                                <tbody id='tbodyDocumentos'>
	                                    @foreach ($partidas as $partida)
	                                        <tr id="trDocumento{{ $partida->id }}">
	                                            <td>{{ $partida->segmento->segmentoTipoVehiculo->tipo_vehiculo }},
	                                                {{ $partida->segmento->segmentoNoCilindro->no_cilindro }} cilindros,
	                                                {{ $partida->segmento->segmentoTransmision->transmision }},
	                                                {{ $partida->segmento->segmentoMotor->motor }}</td>
	                                            <td>{{ $partida->cantidad }}</td>
	                                            <td>{{ $partida->observaciones }}</td>
	                                            <td>
	                                                
	                                            </td>

	                                        </tr>
	                                    @endforeach
	                                </tbody>
	                            </table>
                        	</div>

	                        <ul class="nav nav-tabs nav-tabs-line">
	                            <li class="nav-item">
	                                <a class="nav-link active" data-toggle="tab" href="#kt_tab_pane_1">Inventario de patios y unidades</a>
	                            </li>
	                            <li class="nav-item">
	                                <a class="nav-link" data-toggle="tab" href="#kt_tab_pane_2">Unidades seleccionadas</a>
	                            </li>
	                        </ul>

	                        <div class="tab-content mt-5" id="myTabContent">
	                        	<div class="tab-pane fade show active mt-10" id="kt_tab_pane_1" role="tabpanel"
                                aria-labelledby="kt_tab_pane_2">
		                            <!--begin: Datatable-->
		                            <table class="table table-hover table-checkable" id="kdatatable_patios">
		                                <thead>
		                                <tr>
		                                  <th>No.</th>
		                                  <th>Ubicación</th>
		                                  <th class="text-center">Opciones</th>
		                                </tr>
		                                </thead>

		                                <tbody>
		                                  @foreach($ubicacion as $unid)
		                                    <tr>
		                                      <td>{{ $unid->id }}</td>
		                                      <td>{{ $unid->ubicacion }}</td>

		                                      <td class="text-center">
		                                        <a href="{{ route('reqoperaciones.unidadesenpatioreq',[$unid->id, $requisicion]) }}" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon activar-ubicacion"  data-toggle="tooltip" data-theme="dark" title="Ver unidades" ><i class="flaticon-eye "></i></a>
		                                      </td>
		                                    </tr>
		                                  @endforeach
		                                </tbody>

		                                <tfoot>
		                                <tr>
		                                  <th>No.</th>
		                                  <th>Ubicación</th>
		                                  <th class="text-center">Opciones</th>
		                                </tr>
		                                </tfoot>

		                            </table>
		                            <!--end: Datatable-->

		                            <input type="hidden" id="datatable_i18n" value="{{ asset('/js/datatables/i18n/es-mx.json') }}">


                               	</div>
                               	<div class="tab-pane fade mt-10" id="kt_tab_pane_2" role="tabpanel"
                                aria-labelledby="kt_tab_pane_2">
                                        <table class="table table-hover table-checkable table-responsive" id="kdatatable_unidades_contratos">
                                            <thead>
                                            <tr>
                                                <th>Folio</th>
                                                <th>Ubicación</th>
                                                <th>Marca</th>
                                                <th>Modelo</th>
                                                <th>Serie</th>
                                                <th>Placa</th>
                                                <th>Año</th>
                                                <th>Segmento</th>
                                                <th>Opción</th>
                                            </tr>
                                            </thead>

                                            <tbody>
                                              @foreach($unidades_req as $unid)
                                                <tr>
                                                  <td>{{ $unid->folio }}</td>
                                                  <td>{{ $unid->ubicacion }}</td>
                                                  <td>{{ $unid->nombre_marca }}</td>
                                                  <td>{{ $unid->nombre_modelo }}</td>
                                                  <td>{{ $unid->no_serie }}</td>
                                                  <td>{{ $unid->placa }}</td>
                                                  <td>{{ $unid->unidad_year }}</td>
                                                  <td>{{ $unid->requisicionPartida->segmento->segmentoTipoVehiculo->tipo_vehiculo  }}, {{ $unid->requisicionPartida->segmento->segmentoTransmision->transmision}}, {{ $unid->requisicionPartida->segmento->segmentoNoCilindro->no_cilindro}} cilindros, {{ $unid->requisicionPartida->segmento->segmentoMotor->motor}}</td>
                                                  <td>
                                                  	@if($req->visto_bueno_operaciones == 1)
                                                  		<button class="btn btn-sm btn-clean btn-hover-icon-success btn-icon eliminar-unidad" data-id="{{ $unid->id }}" data-nombre="{{ $unid->nombre_marca }}" data-toggle="tooltip" data-theme="dark" title="Eliminar unidad de la requisición" ><i class="flaticon-delete "></i>
                                                  	@else
                                                  		
                                                  	@endif
                                                  </td>	
                                                </tr>

                                              @endforeach
                                            </tbody>

                                            <tfoot>
                                            <tr>
                                                <th>Folio</th>
                                                <th>Ubicación</th>
                                                <th>Marca</th>
                                                <th>Modelo</th>
                                                <th>Serie</th>
                                                <th>Placa</th>
                                                <th>Año</th>
                                                <th>Segmento</th>
                                                <th>Opción</th>
                                            </tr>
                                            </tfoot>

                                        </table>
                               	</div>

	                        </div>

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
<form method="post" id="vistobueno_firm" action="{{ route('reqoperaciones.vistobuenooperaciones') }}" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="id" id="id_requisicion" value="{{ $requisicion }}">
</form>


<form method="post" id="unidad_act_form" action="{{ route('reqoperaciones.eliminarunidadrequisicion') }}" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="id" id="id_delete" value="">
    <input type="hidden" name="id_requisicion" id="id_requisicion" value="{{ $requisicion }}">
</form>
@endsection


