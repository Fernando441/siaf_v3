@extends('layouts.app')
@section('title')
    Editar seguimiento de contrato
@endsection
@push('scripts')
	<script src="{{ asset('js/contratos/EditarContrato.js') }}"></script>
	<meta name="csrf-token" content="{{ csrf_token() }}" />
@endpush
@section('content')
@php
	$cliente_array = array();
	foreach($cliente as $ub){
		$cliente_array[] = $ub->id;
	}
	$count_array = count($cliente_array);
@endphp

	<style type="text/css">
		.oculto{
			display: none;
		}
	</style>
	<input type="hidden" id="datatable_i18n" value="{{ asset('/js/datatables/i18n/es-mx.json') }}">
    <input type='hidden' id='tipoArchivo' value='{{ $cadenaTipoDocumento }}'>
    <input type='hidden' id='pagoAvance' value='{{ $cadenaavance }}'>
    <input type='hidden' id='PenalziacionProyecto' value='{{ $cadenaPenalizacion }}'>
    <input type="hidden" id="eliminarDocumentoPath" value="{{ route('proyecto.eliminarDocumento') }}">
    <input type="hidden" id="avanceEliminarPath" value="{{ route('proyecto.eliminarpago') }}">
    <input type="hidden" id="deductivaEliminarPath" value="{{ route('proyecto.eliminardeductiva') }}">
	<div class="row">
		<div class="col-md-12">
			<div class="card card-custom gutter-b">
			    <div class="card-header">
			        <h3 class="card-title">Editar seguimiento de contrato</h3>
			        <div class="card-toolbar">
			        </div>
			    </div>

				<form action="{{ route('proyecto.editarproyectouno') }}" method="post" id="submit_contrato_edit" enctype="multipart/form-data">
				@csrf
				    <div class="card-body" id="card-body">

                        <ul class="nav nav-tabs nav-tabs-line">
                            @foreach($inf_pro as $pro)
                                <li class="nav-item">
                                    <a class="nav-link {{($pro->contrato_complemento == 1) ? 'active' : ''}}" data-toggle="tab" href="#kt_tab_pane_{{ $pro->no_folio }}">Contrato - {{ $pro->no_folio }}</a>
                                </li>
                            @endforeach
                        </ul>

                        <div class="tab-content mt-5" id="myTabContent">
                        	@foreach($inf_pro as $pro)
	                        	<div class="tab-pane fade show {{($pro->contrato_complemento == 1) ? 'active' : ''}} mt-10" id="kt_tab_pane_{{ $pro->no_folio }}" role="tabpanel" aria-labelledby="kt_tab_pane_{{ $pro->no_folio }}">
			                        <ul class="nav nav-tabs nav-tabs-line">
			                            <li class="nav-item">
			                                <a class="nav-link active" data-toggle="tab" href="#kt_tab_info_{{ $pro->no_folio }}">Información Contrato</a>
			                            </li>
			                            <li class="nav-item">
			                                <a class="nav-link" data-toggle="tab" href="#kt_tab_doc_{{ $pro->no_folio }}">Documentos</a>
			                            </li>
			                            <li class="nav-item">
			                                <a class="nav-link" data-toggle="tab" href="#kt_tab_avance_{{ $pro->no_folio }}">Avance Financiero</a>
			                            </li>
			                            <li class="nav-item">
			                                <a class="nav-link" data-toggle="tab" href="#kt_tab_deductiva_{{ $pro->no_folio }}">Deductivas de Pago</a>
			                            </li>
			                            <li class="nav-item">
			                                <a class="nav-link" data-toggle="tab" href="#kt_tab_unidades_{{ $pro->no_folio }}">Unidades</a>
			                            </li>
{{-- 			                            <li class="nav-item">
			                                <a class="nav-link" data-toggle="tab" href="#kt_tab_clientes_{{ $pro->no_folio }}">Clientes</a>
			                            </li> --}}

			                        </ul>
			                        <div class="tab-content mt-5" id="myTabContentinfo">
			                            <div class="tab-pane fade active show mt-10" id="kt_tab_info_{{ $pro->no_folio }}" role="tabpanel" aria-labelledby="kt_tab_info_{{ $pro->no_folio }}">
			                            	@include('proyectos.editar-proyecto-auno')
			                            </div>

			                            <div class="tab-pane fade show mt-10" id="kt_tab_doc_{{ $pro->no_folio }}" role="tabpanel" aria-labelledby="kt_tab_doc_{{ $pro->no_folio }}">
			                            	@include('proyectos.editar-proyecto-ctres')
			                            </div>
			                            <div class="tab-pane fade show mt-10" id="kt_tab_avance_{{ $pro->no_folio }}" role="tabpanel" aria-labelledby="kt_tab_avance_{{ $pro->no_folio }}">
			                                @include('proyectos.editar-proyecto-bdos')
			                            </div>
			                            <div class="tab-pane fade show mt-10" id="kt_tab_deductiva_{{ $pro->no_folio }}" role="tabpanel" aria-labelledby="kt_tab_deductiva_{{ $pro->no_folio }}">
			                            	@include('proyectos.editar-proyecto-dcuatro')
			                            </div>
			                            <div class="tab-pane fade show mt-10" id="kt_tab_unidades_{{ $pro->no_folio }}" role="tabpanel" aria-labelledby="kt_tab_unidades_{{ $pro->no_folio }}">
			                            	@include('proyectos.editar-proyecto-ecinco')
			                            </div>
{{-- 			                            <div class="tab-pane fade show mt-10" id="kt_tab_clientes_{{ $pro->no_contrato }}" role="tabpanel" aria-labelledby="kt_tab_clientes_{{ $pro->no_contrato }}">
			                            	@include('proyectos.editar-proyecto-fseis')
			                            </div> --}}
			                        </div>
			                    </div>
                        	@endforeach
                        </div>


				    </div>

                    <div class="card-footer">
                        <div class="row">
                            <div class="col-lg-6">
                                <button type="button"  id="btnEditarcontrato" class="btn btn-success"><i class="la la-plus"></i>Guardar</button>
                                <a href="{{ route('proyecto.listadoproyectos') }}"  class="btn btn-secondary"><i class="la la-arrow-left"></i>Regresar</a>
                            </div>

                        </div>
                    </div>
                </form>

			</div>
		</div>
	</div>

@endsection
