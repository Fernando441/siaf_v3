@extends('layouts.app')
@push('scripts')
	<script src="{{ asset('js/siniestros/EditarSiniestro.js') }}"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}" />

@endpush
@section('title')
    Ver siniestro
@endsection
@section('content')
<style>
    .btn-parpadear {
    animation: parpadeo 0.9s ease-in-out infinite;
}

@keyframes parpadeo {
    0%, 100% {
        opacity: 1;
    }
    50% {
        opacity: 0.3;
    }
}
</style>

<!--begin::Card-->
<div class="row">
    <div class="col-lg-12">
        <!--begin::Card-->
        <div class="card card-custom gutter-b">
            <div class="card-header">
                <h3 class="card-title">Ver siniestro</h3>
            </div>
            <!--begin::Form-->
            <input type="hidden" id="documentoEliminarPath" value="{{ route('siniestro.deletehdievidencia') }}">
            
                {{-- <input type='hidden' id='url_municipios' value='{{ route('cliente.obtenermunicipios') }}'> --}}

                <input type="hidden" name="id" id="id_siniestro" value="{{ $id_siniestro }}">
                <input type="hidden" name="siniestros_agencia_id" value="2">
                <div class="card-body">
                    <!--begin::tabs-->
                    <ul class="nav nav-tabs nav-tabs-line">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#kt_tab_pane_1">Información del siniestro</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#kt_tab_pane_2">Archivos</a>
                        </li>
                    </ul>
                    <div class="tab-content mt-5" id="myTabContent">
                        <div class="tab-pane fade show active mt-10" id="kt_tab_pane_1" role="tabpanel" aria-labelledby="kt_tab_pane_2">
                            <div class="form-group row">
                                <div class="col-lg-6">
                                    <label>Reporte Cabina</label>
                                    <div class="input-group">
                                        <p>{{ $siniestro_hdi->reporte_cabina }}</p>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <label>Deducible $ @if($siniestro_hdi->op_deducible == 1) <a href="#" id="deducible_icon"> <i class="flaticon-exclamation menu-icon" style="color:orange;"></i></a> @endif</label>
                                    <div class="input-group">
                                        <p>${{ $siniestro_hdi->deducible }}</p>
                                    </div>
                                </div>

                            </div>
                            {{-- Historial  --}}
                            <div class="form-group row oculto" id="deducible_historial_div">
                                <input type="hidden" id="iput_deducible" value="0">
                                <div class="card card-custom">
                                    <div class="card-header">
                                        <div class="card-title">
                                            <span class="card-icon">
                                                <i class="flaticon2-file text-primary"></i>
                                            </span>
                                            <h3 class="card-label">Historial de deducible</h3>
                                        </div>
                                    </div>
                                    <div class="card-body">

                                        <table class="table table-hover table-checkable" id="kdatatable_historial_deducible">
                                            <thead>
                                            <tr>
                                                <th>Deducible</th>
                                                <th>Persona que modifico</th>
                                                <th>Fecha y hora de modificacion</th>
                                            </tr>
                                            </thead>

                                            <tbody>
                                                @foreach($historial_deducibles as $unid)
                                                    <tr>
                                                        <td>${{ $unid->deducible }}</td>
                                                        <td>{{ $unid->userCreated->name }}</td>
                                                        <td>{{ $unid->created_at}}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>

                                        </table>
                                        <input type="hidden" id="datatable_i18n" value="{{ asset('/js/datatables/i18n/es-mx.json') }}">
                                    </div>
                                </div>                                
                            </div>

                            {{-- END Historial --}}
                            <div class="form-group row">
                                <div class="col-lg-6">
                                    <label>Número Siniestro</label>
                                    <div class="input-group">
                                        <p>{{ $siniestro_hdi->numero_siniestro }}</p>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <label>Fecha Ocurrido</label>
                                    <div class="input-group">
                                        <p>{{ $siniestro_hdi->fecha_ocurrido }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-4">
                                    <label>Año Ocurrido</label>
                                    <div class="input-group">
                                        <p>{{ $siniestro_hdi->year_ocurrido }}</p>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <label>Número de Póliza</label>
                                    <div class="input-group">
                                        <p>{{ $siniestro_hdi->numero_poliza }}</p>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <label>Estatus de póliza</label>
                                    <div class="input-group">
                                        <p>{{ $siniestro_hdi->estatus_poliza }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-4">
                                    <label>Inciso</label>
                                    <div class="input-group">
                                        <p>{{ $siniestro_hdi->proyecto }}</p>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <label>Proyecto</label>
                                    <div class="input-group">
                                        <p>{{ $siniestro_hdi->modelo }}</p>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <label>Inicio de Vigencia</label>
                                    <div class="input-group">
                                        <p>{{ $siniestro_hdi->inicio_vigencia }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-lg-4">
                                    <label>Termino Vigencia</label>
                                    <div class="input-group">
                                        <p>{{ $siniestro_hdi->termino_vigencia }}</p>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <label>Estado</label>
                                    <div class="input-group">
                                        <p>{{ $siniestro_hdi->estado }}</p>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <label>Ciudad</label>
                                    <div class="input-group">
                                        <p>{{ $siniestro_hdi->ciudad }}</p>
                                    </div>
                                </div> 
                            </div>

                            <div class="row form-group">
                                <div class="col-lg-4">
                                    <label>Conductor</label>
                                    <div class="input-group">
                                        <p>{{ $siniestro_hdi->conductor }}</p>
                                    </div>
                                </div>  
                                <div class="col-lg-4">
                                    <label>Teléfono Reporta</label>
                                    <div class="input-group">
                                        <p>{{ $siniestro_hdi->telefono }}</p>
                                    </div>
                                </div> 
                                <div class="col-lg-4">
                                    <label>Vehículo</label>
                                    <div class="input-group">
                                        <p>{{ $siniestro_hdi->vehiculo }}</p>
                                    </div>
                                </div>       
                            </div>

                            <div class="row form-group">
                                <div class="col-lg-4">
                                    <label>Año</label>
                                    <div class="input-group">
                                        <p>{{ $siniestro_hdi->year }}</p>
                                    </div>
                                </div> 
                                <div class="col-lg-4">
                                    <label>Serie</label>
                                    <div class="input-group">
                                        <p>{{ $siniestro_hdi->serie }}</p>
                                    </div>
                                </div> 
                                <div class="col-lg-4">
                                    <label>Placa</label>
                                    <div class="input-group">
                                        <p>{{ $siniestro_hdi->placa }}</p>
                                    </div>
                                </div> 
                            </div>

                            <div class="row form-group">
                                <div class="col-lg-4">
                                    <label>Causa de Siniestro</label>
                                    <div class="input-group">
                                        <p>{{ $siniestro_hdi->causa_siniestro }}</p>
                                    </div>
                                </div> 
                                <div class="col-lg-4">
                                    <label>Hora Reporte</label>
                                    <div class="input-group">
                                        <p>{{ $siniestro_hdi->hora_reporte }}</p>
                                    </div>
                                </div> 
                                <div class="col-lg-4">
                                    <label> Responsable</label>
                                    <div class="input-group">
                                        <p>{{ $siniestro_hdi->responsable }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-lg-4">
                                    <label> Evento en Cabina</label>
                                    <div class="input-group">
                                        <p>{{ $siniestro_hdi->evento_cabina }}</p>
                                    </div>
                                </div> 
                                <div class="col-lg-4">
                                    <label>Tipo de siniestro</label>
                                    <div class="input-group">
                                        <p>{{ $siniestro_hdi->tipo_siniestro }}</p>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <label>Estatus de siniestro</label>
                                    <div class="input-group">
                                        <p>{{ $siniestro_hdi->estatus_siniestro }}</p>
                                    </div>
                                </div> 
                            </div>

                            <div class="row form-group">
                                <div class="col-lg-4">
                                    <label>Con o Sin Costo</label>
                                    <div class="input-group">
                                        <p>{{ $siniestro_hdi->con_costo }}</p>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <label>Equipo Pesado</label>
                                    <div class="input-group">
                                        <p>{{ $siniestro_hdi->equipo_pesado }}</p>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <label>Estimación (Reserva) DM</label>
                                    <div class="input-group">
                                        <p>${{ $siniestro_hdi->estimacion_reserva_dm }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-lg-4">
                                    <label>Estimación (Reserva) RT</label>
                                    <div class="input-group">
                                        <p>${{ $siniestro_hdi->estimacion_reserva_rt }}</p>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <label>Estimación (Reserva) GM</label>
                                    <div class="input-group">
                                        <p>${{ $siniestro_hdi->estimacion_reserva_gm }}</p>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <label>Estimación (Reserva) RC</label>
                                    <div class="input-group">
                                        <p>${{ $siniestro_hdi->estimacion_reserva_rc }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-lg-4">
                                    <label>Reserva. Otras Coberturas</label>
                                    <div class="input-group">
                                        <p>${{ $siniestro_hdi->reserva_otras }}</p>
                                    </div>
                                </div>  
                                <div class="col-lg-4">
                                    <label>Reserva Vigente</label>
                                    <div class="input-group">
                                        <p>${{ $siniestro_hdi->reserva_vigente }}</p>
                                    </div>
                                </div>
                               <div class="col-lg-4">
                                    <label>Reserva Anterior</label>
                                    <div class="input-group">
                                        <p>${{ $siniestro_hdi->reserva_anterior }}</p>
                                    </div>
                                </div>                                
                            </div>

                            <div class="row form-group">
                               <div class="col-lg-4">
                                    <label>Avance</label>
                                    <div class="input-group">
                                        <p>${{ $siniestro_hdi->avance }}</p>
                                    </div>
                                </div> 
                               <div class="col-lg-4">
                                    <label>Ingresos o Recuperaciones</label>
                                    <div class="input-group">
                                        <p>${{ $siniestro_hdi->ingresos_recuperaciones }}</p>
                                    </div>
                                </div> 
                               <div class="col-lg-4">
                                    <label>Pagos Realizados por HDI</label>
                                    <div class="input-group">
                                        <p>${{ $siniestro_hdi->pagos_realizados_dhi }}</p>
                                    </div>
                                </div> 
                            </div>

                            <div class="row form-group">
                               <div class="col-lg-4">
                                    <label>Salvamento</label>
                                    <div class="input-group">
                                        <p>${{ $siniestro_hdi->salvamento }}</p>
                                    </div>
                                </div>
                               <div class="col-lg-4">
                                    <label>Total Ocurrido</label>
                                    <div class="input-group">
                                        <p>${{ $siniestro_hdi->total_ocurrido }}</p>
                                    </div>
                                </div> 
                               <div class="col-lg-4">
                                    <label>Neto Ocurrido</label>
                                    <div class="input-group">
                                        <p>${{ $siniestro_hdi->neto_ocurrido }}</p>
                                    </div>
                                </div> 
                            </div>

                            <div class="row form-group">
                                <div class="col-lg-4">
                                    <label>Contratante</label>
                                    <div class="input-group">
                                        <p>{{ $siniestro_hdi->contratante }}</p>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <label>Cobertura</label>
                                    <div class="input-group">
                                        <p>{{ $siniestro_hdi->cobertura }}</p>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <label>Legal</label>
                                    <div class="input-group">
                                        <p>{{ $siniestro_hdi->legal }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-lg-4">
                                    <label>Taller</label>
                                    <div class="input-group">
                                        <p>{{ $siniestro_hdi->taller }}</p>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <label>Perdida Total</label>
                                    <div class="input-group">
                                        <p>{{ $siniestro_hdi->perdida_total }}</p>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <label>Robo Localizado</label>
                                    <div class="input-group">
                                        <p>{{ $siniestro_hdi->robo_localizado }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-lg-4">
                                    <label>PT Indemnizada</label>
                                    <div class="input-group">
                                        <p>{{ $siniestro_hdi->pt_indemnizada }}</p>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <label>Primas no devengadas devueltas</label>
                                    <div class="input-group">
                                        <p>{{ $siniestro_hdi->primas_no_denegadas }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-lg-12">
                                    <label>Comentarios</label>
                                    <p>{{ $siniestro_hdi->comentarios }}</p>
                                </div>
                            </div>

                        </div>
                        <div class="tab-pane fade mt-10" id="kt_tab_pane_2" role="tabpanel" aria-labelledby="kt_tab_pane_2">
                            <table class="table table-hover mb-6 table-responsive-sm" id="tblDocumentos">
                                <thead>
                                <tr>
                                    <th scope="col">Documento</th>
                                    <th scope="col">Tipo de Documento</th>
                                </tr>
                                </thead>
                                <tbody id='tbodyDocumentos'>
                                    @foreach($evidencia_siniestro as $documento)
                                        <tr id="trDocumento{{ $documento->id }}">
                                            <td><a href="{{ route('archivo.evidenciahdi', ['id'=>$documento->id]) }}" class="link-primary" target="_blank"> {{ $documento->SiniestroTipoDocumento->nombre_documento }} </a></td>
                                            <td>{{ $documento->SiniestroTipoDocumento->nombre_documento }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div>
                    </div>
                    <!--end::tabs-->

                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-lg-6">
                            <a href="{{ route('siniestro.catalogohdi') }}"  class="btn btn-secondary"><i class="la la-arrow-left"></i>Regresar</a>
                        </div>
                    </div>
                </div>
            <!--end::Form-->
        </div>
        <!--end::Card-->
    </div>
</div>
<!--end::Card-->
@endsection