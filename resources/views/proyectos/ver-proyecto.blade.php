@extends('layouts.app')
@section('title')
    Ver seguimiento de contrato
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
{{-- 	<div class="row">
		<div class="col-md-12">
			<div class="card card-custom gutter-b">
			    <div class="card-header">
			        <h3 class="card-title">Ver seguimiento de contrato</h3>
			        <div class="card-toolbar">
			        </div>
			    </div>
			    <div class="card-body">

                        <!--begin::tabs-->
                        <ul class="nav nav-tabs nav-tabs-line">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#kt_tab_pane_1">Información General</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#kt_tab_pane_3">Documentos</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#kt_tab_pane_2">Avance Financiero</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#kt_tab_pane_4">Deductivas de Pago</a>
                            </li>
                        </ul>
                        <div class="tab-content mt-5" id="myTabContent">
                            <div class="tab-pane fade show active mt-10" id="kt_tab_pane_1" role="tabpanel" aria-labelledby="kt_tab_pane_2">
                                
                            </div>
                            <div class="tab-pane fade mt-10" id="kt_tab_pane_3" role="tabpanel" aria-labelledby="kt_tab_pane_3">
                            	@include('proyectos.ver-proyecto-ctres')
                            </div>
                            <div class="tab-pane fade mt-10" id="kt_tab_pane_2" role="tabpanel" aria-labelledby="kt_tab_pane_2">
                            	@include('proyectos.ver-proyecto-bdos')
                            </div>
                            <div class="tab-pane fade mt-10" id="kt_tab_pane_4" role="tabpanel" aria-labelledby="kt_tab_pane_4">
                            	@include('proyectos.ver-proyecto-dcuatro')
                            </div>
                        </div>
                        <!--end::tabs-->
			    </div>
			</div>
		</div>
	</div>
 --}}

    <div class="row">
        <div class="col-md-12">
            <div class="card card-custom gutter-b">
                <div class="card-header">
                    <h3 class="card-title">Ver seguimiento de contrato</h3>
                    <div class="card-toolbar">
                    </div>
                </div>

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
                                            <a class="nav-link" data-toggle="tab" href="#kt_tab_unidad_{{ $pro->no_folio }}">Unidades</a>
                                        </li>

                                    </ul>
                                    <div class="tab-content mt-5" id="myTabContentinfo">
                                        <div class="tab-pane fade active show mt-10" id="kt_tab_info_{{ $pro->no_folio }}" role="tabpanel" aria-labelledby="kt_tab_info_{{ $pro->no_folio }}">
                                            @include('proyectos.ver-proyecto-auno')
                                        </div>

                                        <div class="tab-pane fade show mt-10" id="kt_tab_doc_{{ $pro->no_folio }}" role="tabpanel" aria-labelledby="kt_tab_doc_{{ $pro->no_folio }}">
                                            @include('proyectos.ver-proyecto-ctres')
                                        </div>
                                        <div class="tab-pane fade show mt-10" id="kt_tab_avance_{{ $pro->no_folio }}" role="tabpanel" aria-labelledby="kt_tab_avance_{{ $pro->no_folio }}">
                                            @include('proyectos.ver-proyecto-bdos')
                                        </div>
                                        <div class="tab-pane fade show mt-10" id="kt_tab_deductiva_{{ $pro->no_folio }}" role="tabpanel" aria-labelledby="kt_tab_deductiva_{{ $pro->no_folio }}">
                                            @include('proyectos.ver-proyecto-dcuatro')
                                        </div>
                                        <div class="tab-pane fade show mt-10" id="kt_tab_unidad_{{ $pro->no_folio }}" role="tabpanel" aria-labelledby="kt_tab_unidad_{{ $pro->no_folio }}">
                                            @include('proyectos.ver-proyecto-dcinco')
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    <div class="card-footer px-0" style="padding-bottom: 0px;">
                        <div class="row">
                            <div class="col-lg-6">
                                <a href="{{ route('proyecto.listadoproyectos') }}"  class="btn btn-secondary"><i class="la la-arrow-left"></i>Regresar</a>
                            </div>

                        </div>
                    </div>

                    </div>

            </div>
        </div>
    </div>


@endsection
