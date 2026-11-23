@extends('layouts.app')
@push('scripts')
	<script src="{{ asset('js/siniestros/EditarSiniestro.js') }}"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}" />

@endpush
@section('title')
    Crear siniestro
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
                <h3 class="card-title">Crear siniestro</h3>
            </div>
            <!--begin::Form-->
            
            <form class="form" action="{{ route('siniestro.createhdievidencia') }}" method="post" id="frmCliente" enctype="multipart/form-data">
                @csrf
                {{-- <input type='hidden' id='url_municipios' value='{{ route('cliente.obtenermunicipios') }}'> --}}
                <input type='hidden' id='tipoArchivo' value='{{ $cadenaTipoDocumento }}'>
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
                                        <input type="number" name="reporte_cabina" value="" id="reporte_cabina" class="form-control specialCharts" required onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <label>Deducible</label>
                                    <div class="input-group">
                                        <input type="number" name="deducible" value="" id="deducible" class="form-control specialCharts" required/>
                                    </div>
                                </div>

                            </div>

                            <div class="form-group row">
                                <div class="col-lg-6">
                                    <label>Número Siniestro</label>
                                    <div class="input-group">
                                        <input type="text" name="numero_siniestro" value="" id="proyecto" class="form-control specialCharts" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <label>Fecha Ocurrido</label>
                                    <div class="input-group">
                                        <input type="date" name="fecha_ocurrido" value="" id="fecha_ocurrido"  class="form-control specialCharts" required />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-4">
                                    <label>Año Ocurrido</label>
                                    <div class="input-group">
                                        <input type="date" name="year_ocurrido" value="" id="year_ocurrido" class="form-control specialCharts" required />
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <label>Número de Póliza</label>
                                    <div class="input-group">
                                        <input type="number" name="numero_poliza" value="" id="numero_poliza"  class="form-control specialCharts"/>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <label>Estatus de póliza</label>
                                    <div class="input-group">
                                        <input type="text" name="estatus_poliza" value="" id="estatus_poliza"  class="form-control specialCharts"  onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-4">
                                    <label>Inciso</label>
                                    <div class="input-group">
                                        <input type="text" name="proyecto" value="" id="proyecto" class="form-control specialCharts" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <label>Proyecto</label>
                                    <div class="input-group">
                                        <input type="text" name="modelo" value="" id="modelo"  class="form-control specialCharts"  onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <label>Inicio de Vigencia</label>
                                    <div class="input-group">
                                        <input type="date" name="inicio_vigencia" value="" id="inicio_vigencia"  class="form-control specialCharts"/>
                                    </div>
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-lg-4">
                                    <label>Termino Vigencia</label>
                                    <div class="input-group">
                                        <input type="date" name="termino_vigencia" value="" id="termino_vigencia"  class="form-control specialCharts"/>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <label>Estado</label>
                                    <div class="input-group">
                                        <input type="text" name="estado" value="" id="estado"  class="form-control specialCharts" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <label>Ciudad</label>
                                    <div class="input-group">
                                        <input type="text" name="ciudad" value="" id="ciudad"  class="form-control specialCharts" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                    </div>
                                </div> 
                            </div>

                            <div class="row form-group">
                                <div class="col-lg-4">
                                    <label>Conductor</label>
                                    <div class="input-group">
                                        <input type="text" name="conductor" value="" id="conductor"  class="form-control specialCharts" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                    </div>
                                </div>  
                                <div class="col-lg-4">
                                    <label>Teléfono Reporta</label>
                                    <div class="input-group">
                                        <input type="number" name="telefono" value="" id="telefono"  class="form-control specialCharts"/>
                                    </div>
                                </div> 
                                <div class="col-lg-4">
                                    <label>Vehículo</label>
                                    <div class="input-group">
                                        <input type="text" name="vehiculo" value="" id="vehiculo"  class="form-control specialCharts" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                    </div>
                                </div>       
                            </div>

                            <div class="row form-group">
                                <div class="col-lg-4">
                                    <label>Año</label>
                                    <div class="input-group">
                                        <input type="number" name="year" value="" id="year"  class="form-control specialCharts"/>
                                    </div>
                                </div> 
                                <div class="col-lg-4">
                                    <label>Serie</label>
                                    <div class="input-group">
                                        <input type="text" name="serie" value="" id="serie" class="form-control specialCharts"/>
                                    </div>
                                </div> 
                                <div class="col-lg-4">
                                    <label>Placa</label>
                                    <div class="input-group">
                                        <input type="text" name="placa" value="" id="placa"  class="form-control specialCharts" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                    </div>
                                </div> 
                            </div>

                            <div class="row form-group">
                                <div class="col-lg-4">
                                    <label>Causa de Siniestro</label>
                                    <div class="input-group">
                                        <input type="text" name="causa_siniestro" value="" id="causa_siniestro"  class="form-control specialCharts" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                    </div>
                                </div> 
                                <div class="col-lg-4">
                                    <label>Hora Reporte</label>
                                    <div class="input-group">
                                        <input type="time" name="hora_reporte" value="" id="hora_reporte"  class="form-control specialCharts" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                    </div>
                                </div> 
                                <div class="col-lg-4">
                                    <label> Responsable</label>
                                    <div class="input-group">
                                        <input type="text" name="responsable" value="" id="responsable"  class="form-control specialCharts" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                    </div>
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-lg-4">
                                    <label> Evento en Cabina</label>
                                    <div class="input-group">
                                        <input type="text" name="evento_cabina" value="" id="evento_cabina"  class="form-control specialCharts" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                    </div>
                                </div> 
                                <div class="col-lg-4">
                                    <label>Tipo de siniestro</label>
                                    <div class="input-group">
                                        <input type="text" name="tipo_siniestro" value="" id="tipo_siniestro"  class="form-control specialCharts" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <label>Estatus de siniestro</label>
                                    <div class="input-group">
                                        <input type="text" name="estatus_siniestro" value="" id="estatus_siniestro"  class="form-control specialCharts" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                    </div>
                                </div> 
                            </div>

                            <div class="row form-group">
                                <div class="col-lg-4">
                                    <label>Con o Sin Costo</label>
                                    <div class="input-group">
                                        <input type="text" name="con_costo" value="" id="con_costo"  class="form-control specialCharts" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <label>Equipo Pesado</label>
                                    <div class="input-group">
                                        <input type="text" name="equipo_pesado" value="" id="equipo_pesado"  class="form-control specialCharts" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <label>Estimación (Reserva) DM</label>
                                    <div class="input-group">
                                        <input type="number" name="estimacion_reserva_dm" value="" id="estimacion_reserva_dm"  class="form-control specialCharts" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                    </div>
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-lg-4">
                                    <label>Estimación (Reserva) RT</label>
                                    <div class="input-group">
                                        <input type="number" name="estimacion_reserva_rt" value="" id="estimacion_reserva_rt"  class="form-control specialCharts" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <label>Estimación (Reserva) GM</label>
                                    <div class="input-group">
                                        <input type="number" name="estimacion_reserva_gm" value="" id="estimacion_reserva_gm"  class="form-control specialCharts" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <label>Estimación (Reserva) RC</label>
                                    <div class="input-group">
                                        <input type="number" name="estimacion_reserva_rc" value="" id="estimacion_reserva_rc"  class="form-control specialCharts" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                    </div>
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-lg-4">
                                    <label>Reserva. Otras Coberturas</label>
                                    <div class="input-group">
                                        <input type="number" name="reserva_otras" value="" id="reserva_otras"  class="form-control specialCharts" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                    </div>
                                </div>  
                                <div class="col-lg-4">
                                    <label>Reserva Vigente</label>
                                    <div class="input-group">
                                        <input type="number" name="reserva_vigente" value="" id="reserva_vigente"  class="form-control specialCharts" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                    </div>
                                </div>
                               <div class="col-lg-4">
                                    <label>Reserva Anterior</label>
                                    <div class="input-group">
                                        <input type="number" name="reserva_anterior" value="" id="reserva_anterior"  class="form-control specialCharts" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                    </div>
                                </div>                                
                            </div>

                            <div class="row form-group">
                               <div class="col-lg-4">
                                    <label>Avance</label>
                                    <div class="input-group">
                                        <input type="number" name="avance" value="" id="avance"  class="form-control specialCharts" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                    </div>
                                </div> 
                               <div class="col-lg-4">
                                    <label>Ingresos o Recuperaciones</label>
                                    <div class="input-group">
                                        <input type="number" name="ingresos_recuperaciones" value="" id="ingresos_recuperaciones"  class="form-control specialCharts" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                    </div>
                                </div> 
                               <div class="col-lg-4">
                                    <label>Pagos Realizados por HDI</label>
                                    <div class="input-group">
                                        <input type="number" name="pagos_realizados_dhi" value="" id="pagos_realizados_dhi"  class="form-control specialCharts" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                    </div>
                                </div> 
                            </div>

                            <div class="row form-group">
                               <div class="col-lg-4">
                                    <label>Salvamento</label>
                                    <div class="input-group">
                                        <input type="number" name="salvamento" value="" id="salvamento"  class="form-control specialCharts" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                    </div>
                                </div>
                               <div class="col-lg-4">
                                    <label>Total Ocurrido</label>
                                    <div class="input-group">
                                        <input type="number" name="total_ocurrido" value="" id="total_ocurrido"  class="form-control specialCharts" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                    </div>
                                </div> 
                               <div class="col-lg-4">
                                    <label>Neto Ocurrido</label>
                                    <div class="input-group">
                                        <input type="number" name="neto_ocurrido" value="" id="neto_ocurrido"  class="form-control specialCharts" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                    </div>
                                </div> 
                            </div>

                            <div class="row form-group">
                                <div class="col-lg-4">
                                    <label>Contratante</label>
                                    <div class="input-group">
                                        <input type="text" name="contratante" value="" id="contratante"  class="form-control specialCharts" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <label>Cobertura</label>
                                    <div class="input-group">
                                        <input type="text" name="cobertura" value="" id="cobertura"  class="form-control specialCharts" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <label>Legal</label>
                                    <div class="input-group">
                                        <input type="text" name="legal" value="" id="legal"  class="form-control specialCharts" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                    </div>
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-lg-4">
                                    <label>Taller</label>
                                    <div class="input-group">
                                        <input type="text" name="taller" value="" id="taller"  class="form-control specialCharts" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <label>Perdida Total</label>
                                    <div class="input-group">
                                        <input type="text" name="perdida_total" value="" id="perdida_total"  class="form-control specialCharts" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <label>Robo Localizado</label>
                                    <div class="input-group">
                                        <input type="text" name="robo_localizado" value="" id="robo_localizado"  class="form-control specialCharts" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                    </div>
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-lg-4">
                                    <label>PT Indemnizada</label>
                                    <div class="input-group">
                                        <input type="text" name="pt_indemnizada" value="" id="pt_indemnizada"  class="form-control specialCharts" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <label>Primas no devengadas devueltas</label>
                                    <div class="input-group">
                                        <input type="text" name="primas_no_denegadas" value="" id="primas_no_denegadas"  class="form-control specialCharts" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                    </div>
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-lg-12">
                                    <label>Comentarios</label>
                                    <textarea class="form-control specialCharts" name="comentarios" id="comentarios"
                                            onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"></textarea>
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