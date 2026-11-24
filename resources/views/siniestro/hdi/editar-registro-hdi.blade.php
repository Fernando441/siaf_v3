@extends('layouts.app')
@push('scripts')
	<script src="{{ asset('js/siniestros/EditarSiniestro.js') }}"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}" />

@endpush
@section('title')
    Editar siniestro
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
                <h3 class="card-title">Editar siniestro</h3>
            </div>
            <!--begin::Form-->
            <input type="hidden" id="documentoEliminarPath" value="{{ route('siniestro.deletehdievidencia') }}">
            
            <form class="form" action="{{ route('siniestro.editsiniestrohdi') }}" method="post" id="frmCliente" enctype="multipart/form-data">
                @csrf
                {{-- <input type='hidden' id='url_municipios' value='{{ route('cliente.obtenermunicipios') }}'> --}}
                <input type='hidden' id='tipoArchivo' value='{{ $cadenaTipoDocumento }}'>
                <input type="hidden" name="id" id="id_siniestro" value="{{ $id_siniestro }}">
                <input type="hidden" name="siniestros_agencia_id" value="3">
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
                                        <input type="number" name="reporte_cabina" value="{{ $siniestro_hdi->reporte_cabina }}" id="reporte_cabina" class="form-control specialCharts" required onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <label>Deducible $ @if($siniestro_hdi->op_deducible == 1) <a href="#" id="deducible_icon"> <i class="flaticon-exclamation menu-icon" style="color:orange;"></i></a> @endif</label>
                                    <div class="input-group">
                                        <input type="number" name="deducible" value="{{ $siniestro_hdi->deducible }}" id="deducible" class="form-control specialCharts" required/>
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
                                        <input type="text" name="numero_siniestro" value="{{ $siniestro_hdi->numero_siniestro }}" id="proyecto" class="form-control specialCharts" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <label>Fecha Ocurrido</label>
                                    <div class="input-group">
                                        <input type="date" name="fecha_ocurrido" value="{{ $siniestro_hdi->fecha_ocurrido }}" id="fecha_ocurrido"  class="form-control specialCharts" required />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-4">
                                    <label>Año Ocurrido</label>
                                    <div class="input-group">
                                        <input type="date" name="year_ocurrido" value="{{ $siniestro_hdi->year_ocurrido }}" id="year_ocurrido" class="form-control specialCharts" required />
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <label>Número de Póliza</label>
                                    <div class="input-group">
                                        <input type="number" name="numero_poliza" value="{{ $siniestro_hdi->numero_poliza }}" id="numero_poliza"  class="form-control specialCharts"/>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <label>Estatus de póliza</label>
                                    <div class="input-group">
                                        <input type="text" name="estatus_poliza" value="{{ $siniestro_hdi->estatus_poliza }}" id="estatus_poliza"  class="form-control specialCharts"  onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-4">
                                    <label>Inciso</label>
                                    <div class="input-group">
                                        <input type="text" name="proyecto" value="{{ $siniestro_hdi->proyecto }}" id="proyecto" class="form-control specialCharts" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <label>Proyecto</label>
                                    <div class="input-group">
                                        <input type="text" name="modelo" value="{{ $siniestro_hdi->modelo }}" id="modelo"  class="form-control specialCharts"  onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <label>Inicio de Vigencia</label>
                                    <div class="input-group">
                                        <input type="date" name="inicio_vigencia" value="{{ $siniestro_hdi->inicio_vigencia }}" id="inicio_vigencia"  class="form-control specialCharts"/>
                                    </div>
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-lg-4">
                                    <label>Termino Vigencia</label>
                                    <div class="input-group">
                                        <input type="date" name="termino_vigencia" value="{{ $siniestro_hdi->termino_vigencia }}" id="termino_vigencia"  class="form-control specialCharts"/>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <label>Estado</label>
                                    <div class="input-group">
                                        <input type="text" name="estado" value="{{ $siniestro_hdi->estado }}" id="estado"  class="form-control specialCharts" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <label>Ciudad</label>
                                    <div class="input-group">
                                        <input type="text" name="ciudad" value="{{ $siniestro_hdi->ciudad }}" id="ciudad"  class="form-control specialCharts" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                    </div>
                                </div> 
                            </div>

                            <div class="row form-group">
                                <div class="col-lg-4">
                                    <label>Conductor</label>
                                    <div class="input-group">
                                        <input type="text" name="conductor" value="{{ $siniestro_hdi->conductor }}" id="conductor"  class="form-control specialCharts" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                    </div>
                                </div>  
                                <div class="col-lg-4">
                                    <label>Teléfono Reporta</label>
                                    <div class="input-group">
                                        <input type="number" name="telefono" value="{{ $siniestro_hdi->telefono }}" id="telefono"  class="form-control specialCharts"/>
                                    </div>
                                </div> 
                                <div class="col-lg-4">
                                    <label>Vehículo</label>
                                    <div class="input-group">
                                        <input type="text" name="vehiculo" value="{{ $siniestro_hdi->vehiculo }}" id="vehiculo"  class="form-control specialCharts" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                    </div>
                                </div>       
                            </div>

                            <div class="row form-group">
                                <div class="col-lg-4">
                                    <label>Año</label>
                                    <div class="input-group">
                                        <input type="number" name="year" value="{{ $siniestro_hdi->year }}" id="year"  class="form-control specialCharts"/>
                                    </div>
                                </div> 
                                <div class="col-lg-4">
                                    <label>Serie</label>
                                    <div class="input-group">
                                        <input type="text" name="serie" value="{{ $siniestro_hdi->serie }}" id="serie" class="form-control specialCharts"/>
                                    </div>
                                </div> 
                                <div class="col-lg-4">
                                    <label>Placa</label>
                                    <div class="input-group">
                                        <input type="text" name="placa" value="{{ $siniestro_hdi->placa }}" id="placa"  class="form-control specialCharts" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                    </div>
                                </div> 
                            </div>

                            <div class="row form-group">
                                <div class="col-lg-4">
                                    <label>Causa de Siniestro</label>
                                    <div class="input-group">
                                        <input type="text" name="causa_siniestro" value="{{ $siniestro_hdi->causa_siniestro }}" id="causa_siniestro"  class="form-control specialCharts" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                    </div>
                                </div> 
                                <div class="col-lg-4">
                                    <label>Hora Reporte</label>
                                    <div class="input-group">
                                        <input type="time" name="hora_reporte" value="{{ $siniestro_hdi->hora_reporte }}" id="hora_reporte"  class="form-control specialCharts" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                    </div>
                                </div> 
                                <div class="col-lg-4">
                                    <label> Responsable</label>
                                    <div class="input-group">
                                        <input type="text" name="responsable" value="{{ $siniestro_hdi->responsable }}" id="responsable"  class="form-control specialCharts" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                    </div>
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-lg-4">
                                    <label> Evento en Cabina</label>
                                    <div class="input-group">
                                        <input type="text" name="evento_cabina" value="{{ $siniestro_hdi->evento_cabina }}" id="evento_cabina"  class="form-control specialCharts" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                    </div>
                                </div> 
                                <div class="col-lg-4">
                                    <label>Tipo de siniestro</label>
                                    <div class="input-group">
                                        <input type="text" name="tipo_siniestro" value="{{ $siniestro_hdi->tipo_siniestro }}" id="tipo_siniestro"  class="form-control specialCharts" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <label>Estatus de siniestro</label>
                                    <div class="input-group">
                                        <input type="text" name="estatus_siniestro" value="{{ $siniestro_hdi->estatus_siniestro }}" id="estatus_siniestro"  class="form-control specialCharts" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                    </div>
                                </div> 
                            </div>

                            <div class="row form-group">
                                <div class="col-lg-4">
                                    <label>Con o Sin Costo</label>
                                    <div class="input-group">
                                        <input type="text" name="con_costo" value="{{ $siniestro_hdi->con_costo }}" id="con_costo"  class="form-control specialCharts" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <label>Equipo Pesado</label>
                                    <div class="input-group">
                                        <input type="text" name="equipo_pesado" value="{{ $siniestro_hdi->equipo_pesado }}" id="equipo_pesado"  class="form-control specialCharts" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <label>Estimación (Reserva) DM</label>
                                    <div class="input-group">
                                        <input type="number" name="estimacion_reserva_dm" value="{{ $siniestro_hdi->estimacion_reserva_dm }}" id="estimacion_reserva_dm"  class="form-control specialCharts" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                    </div>
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-lg-4">
                                    <label>Estimación (Reserva) RT</label>
                                    <div class="input-group">
                                        <input type="number" name="estimacion_reserva_rt" value="{{ $siniestro_hdi->estimacion_reserva_rt }}" id="estimacion_reserva_rt"  class="form-control specialCharts" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <label>Estimación (Reserva) GM</label>
                                    <div class="input-group">
                                        <input type="number" name="estimacion_reserva_gm" value="{{ $siniestro_hdi->estimacion_reserva_gm }}" id="estimacion_reserva_gm"  class="form-control specialCharts" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <label>Estimación (Reserva) RC</label>
                                    <div class="input-group">
                                        <input type="number" name="estimacion_reserva_rc" value="{{ $siniestro_hdi->estimacion_reserva_rc }}" id="estimacion_reserva_rc"  class="form-control specialCharts" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                    </div>
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-lg-4">
                                    <label>Reserva. Otras Coberturas</label>
                                    <div class="input-group">
                                        <input type="number" name="reserva_otras" value="{{ $siniestro_hdi->reserva_otras }}" id="reserva_otras"  class="form-control specialCharts" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                    </div>
                                </div>  
                                <div class="col-lg-4">
                                    <label>Reserva Vigente</label>
                                    <div class="input-group">
                                        <input type="number" name="reserva_vigente" value="{{ $siniestro_hdi->reserva_vigente }}" id="reserva_vigente"  class="form-control specialCharts" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                    </div>
                                </div>
                               <div class="col-lg-4">
                                    <label>Reserva Anterior</label>
                                    <div class="input-group">
                                        <input type="number" name="reserva_anterior" value="{{ $siniestro_hdi->reserva_anterior }}" id="reserva_anterior"  class="form-control specialCharts" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                    </div>
                                </div>                                
                            </div>

                            <div class="row form-group">
                               <div class="col-lg-4">
                                    <label>Avance</label>
                                    <div class="input-group">
                                        <input type="number" name="avance" value="{{ $siniestro_hdi->avance }}" id="avance"  class="form-control specialCharts" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                    </div>
                                </div> 
                               <div class="col-lg-4">
                                    <label>Ingresos o Recuperaciones</label>
                                    <div class="input-group">
                                        <input type="number" name="ingresos_recuperaciones" value="{{ $siniestro_hdi->ingresos_recuperaciones }}" id="ingresos_recuperaciones"  class="form-control specialCharts" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                    </div>
                                </div> 
                               <div class="col-lg-4">
                                    <label>Pagos Realizados por HDI</label>
                                    <div class="input-group">
                                        <input type="number" name="pagos_realizados_dhi" value="{{ $siniestro_hdi->pagos_realizados_dhi }}" id="pagos_realizados_dhi"  class="form-control specialCharts" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                    </div>
                                </div> 
                            </div>

                            <div class="row form-group">
                               <div class="col-lg-4">
                                    <label>Salvamento</label>
                                    <div class="input-group">
                                        <input type="number" name="salvamento" value="{{ $siniestro_hdi->salvamento }}" id="salvamento"  class="form-control specialCharts" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                    </div>
                                </div>
                               <div class="col-lg-4">
                                    <label>Total Ocurrido</label>
                                    <div class="input-group">
                                        <input type="number" name="total_ocurrido" value="{{ $siniestro_hdi->total_ocurrido }}" id="total_ocurrido"  class="form-control specialCharts" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                    </div>
                                </div> 
                               <div class="col-lg-4">
                                    <label>Neto Ocurrido</label>
                                    <div class="input-group">
                                        <input type="number" name="neto_ocurrido" value="{{ $siniestro_hdi->neto_ocurrido }}" id="neto_ocurrido"  class="form-control specialCharts" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                    </div>
                                </div> 
                            </div>

                            <div class="row form-group">
                                <div class="col-lg-4">
                                    <label>Contratante</label>
                                    <div class="input-group">
                                        <input type="text" name="contratante" value="{{ $siniestro_hdi->contratante }}" id="contratante"  class="form-control specialCharts" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <label>Cobertura</label>
                                    <div class="input-group">
                                        <input type="text" name="cobertura" value="{{ $siniestro_hdi->cobertura }}" id="cobertura"  class="form-control specialCharts" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <label>Legal</label>
                                    <div class="input-group">
                                        <input type="text" name="legal" value="{{ $siniestro_hdi->legal }}" id="legal"  class="form-control specialCharts" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                    </div>
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-lg-4">
                                    <label>Taller</label>
                                    <div class="input-group">
                                        <input type="text" name="taller" value="{{ $siniestro_hdi->taller }}" id="taller"  class="form-control specialCharts" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <label>Perdida Total</label>
                                    <div class="input-group">
                                        <input type="text" name="perdida_total" value="{{ $siniestro_hdi->perdida_total }}" id="perdida_total"  class="form-control specialCharts" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <label>Robo Localizado</label>
                                    <div class="input-group">
                                        <input type="text" name="robo_localizado" value="{{ $siniestro_hdi->robo_localizado }}" id="robo_localizado"  class="form-control specialCharts" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                    </div>
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-lg-4">
                                    <label>PT Indemnizada</label>
                                    <div class="input-group">
                                        <input type="text" name="pt_indemnizada" value="{{ $siniestro_hdi->pt_indemnizada }}" id="pt_indemnizada"  class="form-control specialCharts" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <label>Primas no devengadas devueltas</label>
                                    <div class="input-group">
                                        <input type="text" name="primas_no_denegadas" value="{{ $siniestro_hdi->primas_no_denegadas }}" id="primas_no_denegadas"  class="form-control specialCharts" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                    </div>
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-lg-12">
                                    <label>Comentarios</label>
                                    <textarea class="form-control specialCharts" name="comentarios" id="comentarios"
                                            onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">{{ $siniestro_hdi->comentarios }}</textarea>
                                </div>
                            </div>

                        </div>
                        <div class="tab-pane fade mt-10" id="kt_tab_pane_2" role="tabpanel" aria-labelledby="kt_tab_pane_2">
                            <table class="table table-hover mb-6 table-responsive-sm" id="tblDocumentos">
                                <thead>
                                <tr>
                                    <th scope="col">Documento</th>
                                    <th scope="col">Tipo de Documento</th>
                                    <th scope="col">Opción</th>
                                </tr>
                                </thead>
                                <tbody id='tbodyDocumentos'>
                                    @foreach($evidencia_siniestro as $documento)
                                        <tr id="trDocumento{{ $documento->id }}">
                                            <td><a href="{{ route('archivo.evidenciahdi', ['id'=>$documento->id]) }}" class="link-primary" target="_blank"> {{ $documento->SiniestroTipoDocumento->nombre_documento }} </a></td>
                                            <td>{{ $documento->SiniestroTipoDocumento->nombre_documento }}</td>
                                            <td>
                                                <a href='#' class='btn btn-sm btn-clean btn-hover-icon-success btn-icon hrefEliminarDocumento' data-id='{{ $documento->id }}' data-documento='{{ $documento->SiniestroTipoDocumento->nombre_documento }}'  data-toggle='tooltip' data-theme='dark' title='Eliminar'>
                                                    <i class='flaticon-delete'></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <div class="row form-group">
                                <div class="col-lg-12">
                                    <a href="#" class="btn btn-icon btn-outline-success btn-circle btn-sm mr-2 hrefAgregarOtro" data-toggle="tooltip" data-theme="dark" title="Agregar archivo">
                                        <i class="flaticon2-plus"></i>
                                    </a>
                                </div>
                            </div>

                        </div>
                    </div>
                    <!--end::tabs-->

                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-lg-6">
                            <button type="button"  id="btnGuardar" class="btn btn-success"><i class="la la-plus"></i>Guardar</button>
                            <a href="{{ route('siniestro.catalogohdi') }}"  class="btn btn-secondary"><i class="la la-arrow-left"></i>Regresar</a>
                        </div>
                    </div>
                </div>
            </form>
            <!--end::Form-->
        </div>
        <!--end::Card-->
    </div>
</div>
<!--end::Card-->
@endsection