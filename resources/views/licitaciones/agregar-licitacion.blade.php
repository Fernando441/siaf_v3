@extends('layouts.app')
@section('title')
    Agregar concurso
@endsection
@push('scripts')
    <script src="{{ asset('js/licitaciones/CrearLicitacion.js') }}"></script>
    <script src="{{ asset('js/licitaciones/ValidacionFechas.js') }}"></script>
@endpush
@section('content')
    <style type="text/css">
        .oculto {
            display: none;
        }
    </style>
    <!--begin::Card-->
    <div class="row">
        <div class="col-lg-12">
            <!--begin::Card-->
            <div class="card card-custom gutter-b">
                <div class="card-header">
                    <h3 class="card-title">Agregar concurso</h3>
                </div>
                <!--begin::Form-->
                <form action="{{ route('licitacion.guardarlicitacion') }}" method="post" id="submit_licitacion"
                    enctype="multipart/form-data">
                    <input type='hidden' id='tipoArchivo' value='{{ $cadenaTipoDocumento }}'>
                    @csrf
                    <div class="card-body">


                        <!--begin::tabs-->
                        <ul class="nav nav-tabs nav-tabs-line">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#kt_tab_pane_1">Información basica</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#kt_tab_pane_2">Documentos</a>
                            </li>
                        </ul>
                        <div class="tab-content mt-5" id="myTabContent">
                            <div class="tab-pane fade show active mt-10" id="kt_tab_pane_1" role="tabpanel"
                                aria-labelledby="kt_tab_pane_2">

                                <div class="row form-group">
                                    <div class="col-lg-6">
                                        <label>Publicación del concurso</label>
                                        <select class="form-control" name="publicacion_licitacion"
                                            id="publicacion_licitacion">
                                            <option value="">Selecciona una opción</option>
                                            @foreach ($publicacion as $ub)
                                                <option value="{{ $ub->id }}">{{ $ub->publicacion_licitacion }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="row">
                                            <div class="col-lg-8">
                                                <label>Prioridad</label>
                                                <div class="radio-inline">

                                                    @foreach ($licitacion_prioridad as $prioridad)
                                                        <label class="radio">
                                                            <input type="radio" name="prioridad"
                                                                value="{{ $prioridad->id }}" required />
                                                            <span></span>
                                                            {{ $prioridad->prioridad }}
                                                        </label>
                                                    @endforeach
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <label>Sector</label>
                                                <div class="radio-inline">
                                                    <label class="radio">
                                                        <input type="radio" checked name="sector" value="0" />
                                                        <span></span>
                                                        Publico
                                                    </label>
                                                    <label class="radio">
                                                        <input type="radio" name="sector" value="1" />
                                                        <span></span>
                                                        Privado
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col-lg-6">
                                        <label>Cliente</label>
                                        <select class="form-control" name="cliente" id="cliente_id" required>
                                            <option value="">Selecciona un opcioón</option>
                                            @foreach ($cliente as $cli)
                                                <option value="{{ $cli->id_cliente }}">{{ $cli->razon_social }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-6">
                                        <label>Titulo del servicio</label>
                                        <input type="text" class="form-control specialCharts" name="titulo_servicio"
                                            id="titulo_servicio" required
                                            onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()" />
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col-lg-6">
                                        <label>Tipo de contratación</label>
                                        <select class="form-control" name="tipo_contratacion" id="tipo_contratacion"
                                            required>
                                            <option value="">Selecciona una opción</option>
                                            @foreach ($tipo_contratacion as $tp)
                                                <option value="{{ $tp->id }}">{{ $tp->tipo_contratacion }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-6">
                                        <label>No. Concurso</label>
                                        <input type="text" class="form-control" name="no_licitacion" id="no_licitacion"
                                            required
                                            onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()" />
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col-lg-6">
                                        <label>Fecha de acto de fallo</label>
                                        <input type="text" class="form-control"  name="acto_fallo_info" id="acto_fallo_info" />
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col-lg-6">
                                        <label for="fecha_compra_bases">Fecha de compra de bases </label>
                                        <input type="text" id="fecha_compra_bases" name="fecha_compra_bases" readonly class="form-control"
                                            value="">
                                    </div>

                                    <div class="col-lg-6">
                                        <label>¿Aplica la fecha de visita?</label>
                                        <div class="radio-inline">
                                            <label class="radio">
                                                <input type="radio" checked name="fecha_visita_aplica" id="ftp_uno" value="0" />
                                                <span></span>
                                                Si
                                            </label>
                                            <label class="radio">
                                                <input type="radio" name="fecha_visita_aplica" id="ftp_dos" value="1" />
                                                <span></span>
                                                No
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row form-group" id="div_fecha_visita"> 
                                    <div class="col-lg-6">
                                        <label>Fecha y hora de visita</label>
                                        <input type="datetime-local" class="form-control" name="fecha_visita" 
                                            id="fecha_visita"  />
                                        <input type="hidden" name="op_fecha" id="op_fecha" value="1">
                                    </div>

                                    <div class="col-lg-6">
                                        <label for="fecha_solicitud"> Fecha y Hora de envío de preguntas</label>
                                        <input type="datetime-local" id="fecha_preguntas" name="fecha_preguntas" class="form-control"
                                            value="">
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col-lg-6">
                                        <label>Fecha y hora de Junta de aclaración de bases de concurso</label>
                                        <input type="datetime-local" class="form-control" name="junta_aclaraciones"
                                            id="junta_aclaraciones" required />
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="fecha_entrega_propuestas"> Fecha y hora de entrega de propuestas </label>
                                        <input type="datetime-local" id="fecha_entrega_propuestas" name="fecha_entrega_propuestas" class="form-control"
                                            value="">
                                    </div>
                                </div>


                                <div class="row form-group">
                                    <div class="col-lg-6">
                                        <label> Fecha de apertura de oferta técnica</label>
                                        <input type="text" class="form-control" name="fecha_apertura_tecnica"
                                            id="fecha_apertura_tecnica" readonly />
                                    </div>
                                    <div class="col-lg-6">
                                        <label> Fecha de apertura de oferta económica</label>
                                        <input type="text" class="form-control" readonly name="fecha_apertura_economica"
                                            id="fecha_apertura_economica" readonly/>
                                    </div>

                                </div>


                                <div class="row form-group">
                                    <div class="col-lg-6">
                                        <label> Fecha de presentación de propuesta</label>
                                        <input type="text" class="form-control" readonly name="apertura_proposiciones"
                                            id="apertura_proposiciones" readonly/>
                                    </div>
                                    <div class="col-lg-6">
                                        <label>¿Aplica la fecha de subasta?</label>
                                        <div class="radio-inline">
                                            <label class="radio">
                                                <input type="radio" checked name="fecha_subasta_aplica" id="fsp_uno" value="0" />
                                                <span></span>
                                                Si
                                            </label>
                                            <label class="radio">
                                                <input type="radio" name="fecha_subasta_aplica" id="fsp_dos" value="1" />
                                                <span></span>
                                                No
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 mt-3" id="fecha_subasta_div">
                                        <label>Fecha de subasta</label>
                                        <input type="text" class="form-control" readonly name="fecha_subasta"
                                            id="fecha_subasta" readonly/>
                                            <input type="hidden" name="op_fecha_subasta" id="op_fecha_subasta" value="1">
                                    </div>


                                </div>

                                <div class="row form-group">
{{--                                     <div class="col-lg-6">
                                        <label>Fecha de firma de contrato</label>
                                        <input type="text" class="form-control" name="firma_entrega" readonly
                                            id="firma_entrega" />
                                    </div>
 --}}                                    {{-- 						    	<div class="col-lg-6">
							    		<label>Monto ofertado</label>
							    		<input type="text" class="form-control" name="monto_ofertado" id="monto_ofertado" required/>
							    	</div> --}}
                                    {{-- 							    	<div class="col-lg-6">
							    		<label>Nombre de empresa o participación conjunta</label>
							    		<input type="text" class="form-control" name="participacion_conjunta" id="participacion_conjunta"/>
							    	</div> --}}

                                </div>

                                {{-- 						        <div class="row form-group">
							    	<div class="col-lg-6">
							    		<label>Monto adjudicado</label>
										<input type="text" class="form-control" name="monto_ganado" id="monto_ganado"/>
							    	</div>
							    	<div class="col-lg-6">
							    		<label>Número de fianza para garantizar oferta</label>
										<input type="number" class="form-control" name="porcentaje_efectividad" id="porcentaje_efectividad"/>
							    	</div>
						        </div> --}}

                                {{-- 						        <div class="row form-group">
							    	<div class="col-lg-6">
							    		<label>Monto de la fianza</label>
							    		<input type="text" class="form-control" name="monto_fianza" id="monto_fianza"/>
							    	</div>
							    	<div class="col-lg-6">
							    		<label>Fecha de la fianza</label>
							    		<input type="text" class="form-control" readonly name="fecha_fianza" id="fecha_fianza"/>
							    	</div>
						        </div> --}}

                                <div class="row form-group">
                                    {{-- 							    	<div class="col-lg-6">
							    		<label>Monto de fianza liberada</label>
										<input type="text" class="form-control" name="monto_fianza_liberada" id="monto_fianza_liberada"/>
							    	</div> --}}

                                    <div class="col-lg-6">
                                        <label>Fecha de inicio de vigencia de los servicios</label>
                                        <input type="text" class="form-control" name="fecha_entrega"
                                            id="fecha_entrega" readonly />
                                    </div>

                                    <div class="col-lg-6">
                                        <label>Fecha final de vigencia de los servicios</label>
                                        <input type="text" class="form-control" name="fecha_final_servicios"
                                            id="fecha_final_servicios" readonly />
                                    </div>


                                </div>

                                <div class="row form-group">
                                    <div class="col-lg-6">
                                        <label>¿Aplica la fecha de repreguntas ?</label>
                                        <div class="radio-inline">
                                            <label class="radio">
                                                <input type="radio" checked name="fecha_repreguntas_aplica" id="frp_uno" value="0" />
                                                <span></span>
                                                Si
                                            </label>
                                            <label class="radio">
                                                <input type="radio" name="fecha_repreguntas_aplica" id="frp_dos" value="1" />
                                                <span></span>
                                                No
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 mt-3" id="fecha_repreguntas_div">
                                        <label>Fecha de repreguntas </label>
                                        <input type="text" class="form-control" readonly name="fecha_repreguntas"
                                            id="fecha_repreguntas" readonly/>
                                            <input type="hidden" name="op_fecha_repreguntas" id="op_fecha_repreguntas" value="1">
                                    </div>


                                </div>



                                <div class="row form-group">

                                    <div class="col-lg-6">
                                        <label>Número de vehículos</label>
                                        <input type="number" class="form-control" name="numero_vehiculos"
                                            id="numero_vehiculos" />
                                    </div>

                                    <div class="col-lg-6">
                                        <label>Tipo de partida</label>
                                        <div class="radio-inline">
                                            <label class="radio">
                                                <input type="radio" checked name="tipo_partida" value="0" />
                                                <span></span>
                                                Partida única
                                            </label>
                                            <label class="radio">
                                                <input type="radio" name="tipo_partida" value="1" />
                                                <span></span>
                                                Varias partidas
                                            </label>
                                        </div>
                                    </div>
                                </div>


                                <div class="row form-group">
                                    <div class="col-lg-6">
                                        <label>Tipo de contrato</label>
                                        <div class="radio-inline">
                                            <label class="radio">
                                                <input type="radio" checked name="tipo_contrato" value="0" />
                                                <span></span>
                                                Contrato abierto
                                            </label>
                                            <label class="radio">
                                                <input type="radio" name="tipo_contrato" value="1" />
                                                <span></span>
                                                Contrato cerrado
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <label> Modalidad de presentación de propuestas</label>
                                        <div class="radio-inline">
                                            <label class="radio">
                                                <input type="radio" checked name="modalidad" value="0" />
                                                <span></span>
                                                Electrónica
                                            </label>
                                            <label class="radio">
                                                <input type="radio" name="modalidad" value="1" />
                                                <span></span>
                                                Presencial
                                            </label>
                                        </div>
                                    </div>

                                </div>


                                <div class="row form-group">
                                    {{-- 							    	<div class="col-lg-6">
							    		<label>Fecha de cierre</label>
							    		<input type="text" class="form-control" name="fecha_cierre" id="fecha_cierre" readonly/>
							    	</div> --}}
                                    <div class="col-lg-12">
                                        <label>Observaciones</label>
                                        <textarea class="form-control specialCharts" name="observaciones" id="observaciones"
                                            onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"></textarea>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="card card-custom gutter-b">
                                            <div class="card-header">
                                                <div class="card-title">
                                                    <h3 class="card-label">
                                                        Detalle del concurso
                                                    </h3>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <div class="row">
                                                            <div class="col-lg-1"></div>
                                                            <div class="col-lg-10">
                                                                <label>¿Concurso ganado?</label>
                                                                <div class="radio-inline">
                                                                    <label class="radio">
                                                                        <input type="radio" checked id="cp_con"
                                                                            name="ganado" value="0" />
                                                                        <span></span>
                                                                        Concursando
                                                                    </label>
                                                                    <label class="radio">
                                                                        <input type="radio" name="ganado"
                                                                            id="cp_uno" value="1" />
                                                                        <span></span>
                                                                        No
                                                                    </label>
                                                                    <label class="radio">
                                                                        <input type="radio" name="ganado"
                                                                            id="cp_dos" value="2" />
                                                                        <span></span>
                                                                        Si
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-1"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <label>Fecha de acto de fallo (Notificación)</label>
                                                        <input type="text" class="form-control" readonly
                                                            name="acto_fallo" id="acto_fallo" />
                                                    </div>
                                                </div>

                                                <div class="row oculto div_perdido mt-2">
                                                    <div class="col-lg-12">
                                                        <label>Motivo por el cual no se gano el concurso</label>
                                                        <textarea class="form-control" name="concurso_noganado" id="concurso_noganado"></textarea>
                                                    </div>
                                                </div>

                                                <div class="row oculto div_ganado mt-2">
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="card card-custom gutter-b">
                                                                <div class="card-header">
                                                                    <div class="card-title">
                                                                        <h3 class="card-label">
                                                                            Alerta del sistema
                                                                            <small></small>
                                                                        </h3>
                                                                    </div>
                                                                </div>
                                                                <div class="card-body">
                                                                    <label>El sistema les enviara una alerta a las
                                                                        siguientes personas para notificar que el concurso
                                                                        fue ganado.</label>

                                                                    <div class="row">
                                                                        <div class="col-lg-4">

                                                                        </div>
                                                                        <div class="col-lg-8">
                                                                            <div class="row">
                                                                                @isset($users)
                                                                                    @foreach ($users as $us)
                                                                                        <div class="col-lg-4">
                                                                                            <div class="row">
                                                                                                <div
                                                                                                    class="col-lg-12 text-center">
                                                                                                    @if ($us->avatar == '' || $us->avatar == null)
                                                                                                        <div class="symbol symbol-60 symbol-circle symbol-xl-90"
                                                                                                            width="140"
                                                                                                            style="border-radius:19%">
                                                                                                            <!-- First letter of name  -->
                                                                                                            <span
                                                                                                                class="symbol-label font-size-h3 font-weight-boldest">{{ $us->name[0] }}</span>
                                                                                                        </div>
                                                                                                    @else
                                                                                                        <div class="symbol symbol-60 symbol-circle symbol-xl-90"
                                                                                                            width="140"
                                                                                                            style="border-radius:19%">
                                                                                                            <img src="{{ route('archivo.documentoAvatar', [$us->avatar]) }}"
                                                                                                                width="140">
                                                                                                        </div>
                                                                                                    @endif
                                                                                                </div>

                                                                                            </div>
                                                                                            <div class="row">
                                                                                                <div
                                                                                                    class="col-lg-12 text-center">
                                                                                                    <label><b>{{ $us->name }}</b></label>
                                                                                                    <br>
                                                                                                    <label>{{ $us->name_role }}</label>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    @endforeach
                                                                                @endisset
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>
                            <div class="tab-pane fade mt-10" id="kt_tab_pane_2" role="tabpanel"
                                aria-labelledby="kt_tab_pane_2">

                                <div class="row form-group">


                                    <div class="col-lg-12" id="tblArchivos">
                                        <table class='table table-bordered table-hover' id='tblDocumentos'>
                                            <thead>
                                                <tr>
                                                    <th>Adjuntar Documento</th>
                                                    <th>Tipo de Documento</th>
                                                    <th>Opción</th>
                                                </tr>
                                            </thead>
                                            <tbody id='tbodyDocumentos'>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col-lg-12">
                                        <a href="#"
                                            class="btn btn-icon btn-outline-success btn-circle btn-sm mr-2 hrefAgregarOtro"
                                            data-toggle="tooltip" data-theme="dark" title="Agregar archivo">
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
                            <div class="col-lg-12">
                                <button type="button" id="btnGuardarLicitacion"
                                    class="btn btn-success"><i class="la la-plus"></i>Guardar</button>
                                <a href="{{ route('licitacion.listadolicitaciones') }}"
                                    class="btn btn-secondary"><i class="la la-arrow-left"></i>Regresar</a>
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
