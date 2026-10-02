@extends('layouts.app')
@push('scripts')
	<script src="{{ asset('js/licitaciones/EditarLicitacion.js') }}"></script>
    {{-- <script src="{{ asset('js/licitaciones/ValidacionFechas.js') }}"></script> --}}
@endpush
@section('title')
    Editar concurso
@endsection
@section('content')

<style type="text/css">
    .oculto{
        display: none;
    }
    .op_select{
box-shadow: 0px 7px 5px -2px rgba(174,251,117,0.74);
-webkit-box-shadow: 0px 7px 5px -2px rgba(174,251,117,0.74);
-moz-box-shadow: 0px 7px 5px -2px rgba(174,251,117,0.74);  
    }
</style>




<!--begin::Card-->
<div class="row">
    <div class="col-lg-12">
        <!--begin::Card-->
        <div class="card card-custom gutter-b">
            <div class="card-header">
                <h3 class="card-title">Editar concurso</h3>

                <div class="card-toolbar">
                    @if (in_array(114, $permiso_array))
                        <a href="{{ route('licitacion.ver',$info->id)}}" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon" title="Ver concurso" data-theme="dark" data-toggle="tooltip" data-placement="top">
                            <i class="flaticon-eye"></i>
                        </a>   {{-- VER licitacion --}}
                    @endif

                    @if (in_array(116, $permiso_array))
                        <a href="{{ route('licitacion.editarlicitacion',$info->id) }}" class="btn btn-sm  btn-hover-icon-success btn-icon op_select" title="Editar concurso" data-theme="dark" data-toggle="tooltip" data-placement="top">
                            <i class="flaticon-edit"></i>
                        </a>   {{-- Editar licitacion --}}
                    @endif

                    @if (in_array(133, $permiso_array))
                        @if($info->acto_fallo == null || $info->acto_fallo == "")
                        @else
                            <a href="{{ route('licitacion.agregar',$info->id) }}" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon" title="Crear contrato" data-theme="dark" data-toggle="tooltip" data-placement="top">
                                <i class="flaticon-file-1"></i>
                            </a>  {{-- Agregar contrato --}}
                        @endif
                    @endif

                    @if (in_array(134, $permiso_array))
                        <a href="{{ route('proposicioneconomica.crearproposicioneconomica', [$info->id,1,$info->tipo_contrato]) }}" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon" title="Crear propuesta económica" data-theme="dark" data-toggle="tooltip" data-placement="top">
                            <i class="flaticon-presentation-1"></i>
                        </a>   {{-- Propuesta economica --}}
                    @endif

                    @if (in_array(135, $permiso_array))
                        <a href="{{ route('propuestatecnica.crearpropuestatecnica',$info->id) }}" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon" title="Crear propuesta" data-theme="dark" data-toggle="tooltip" data-placement="top">
                            <i class="flaticon2-website"></i>  
                        </a>   {{-- Propuesta Tecnica --}}
                    @endif

                    @if (in_array(143, $permiso_array))
                        <a href="{{ route('licitacion.informacionfinanzas',$info->id) }}" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon" title="Información de las fianzas y seguros" data-theme="dark" data-toggle="tooltip" data-placement="top">
                                <i class="flaticon-notepad"></i>
                        </a>   {{-- Finanzas --}}
                    @endif

                    @if (in_array(135, $permiso_array))
                        <a href="{{ route('reqconcurso.listadoreqconsursos',$info->id) }}" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon" title="Requisiciones" data-theme="dark" data-toggle="tooltip" data-placement="top">
                                <i class="flaticon2-delivery-truck"></i>
                        </a>
                     @endif


                    <a href="{{ route('licitacion.listadolicitaciones') }}" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon" data-toggle="tooltip" data-theme="dark" title="Salir" ><i class="flaticon2-reply "></i></a>
                </div>

            </div>
            <!--begin::Form-->
            <form action="{{ route('licitacion.modificarlicitacion') }}" method="post" id="submit_editlicitacion_uno" enctype="multipart/form-data">
                <input type="hidden" name="id" value="{{ $info->id }}">
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
                        <div class="tab-pane fade show active mt-10" id="kt_tab_pane_1" role="tabpanel" aria-labelledby="kt_tab_pane_2">

                            <div class="row form-group">
                                <div class="col-lg-6">
                                    <label>Publicación del concurso</label>
                                    <select class="form-control" name="publicacion_licitacion" id="publicacion_licitacion">
                                        <option value="">Selecciona una opción</option>
                                        @foreach($publicacion as $ub)
                                            <option value="{{ $ub->id }}" @selected($info->publicacion_licitacion == $ub->id) >{{ $ub->publicacion_licitacion }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-6">
                                    <div class="row">
                                        <div class="col-lg-8">
                                            <label>Prioridad</label>
                                            <div class="radio-inline">

                                                @foreach($licitacion_prioridad as $prioridad)
                                                    <label class="radio">
                                                        <input type="radio" name="prioridad" value="{{ $prioridad->id }}" @checked($prioridad->id == $info->id_licitacion_prioridad) required/>
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
                                                    <input type="radio" {{($info->sector == 0) ? 'checked' : ''}} name="sector" value="0"/>
                                                    <span></span>
                                                    Publico
                                                </label>
                                                <label class="radio">
                                                    <input type="radio" {{($info->sector == 1) ? 'checked' : ''}} name="sector" value="1"/>
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
                                        <option value="">Selecciona un opción</option>
                                        @foreach($cliente as $ub)
                                            <option value="{{ $ub->id_cliente}}" @selected($ub->id_cliente == $info->cliente) >
                                                {{ strtoupper($ub->razon_social)}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-6">
                                    <label>Titulo del servicio</label>
                                    <input type="text" class="form-control specialCharts" name="titulo_servicio" id="titulo_servicio" value="{{ strtoupper($info->titulo_servicio) }}" required onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-lg-6">
                                    <label>Tipo de contratación</label>
                                    <select class="form-control" name="tipo_contratacion" id="tipo_contratacion" required>
                                        <option value="">Selecciona una opción</option>
                                        @foreach($tipo_contratacion as $tp)
                                            <option value="{{ $tp->id }}" @selected($info->contratacion == $tp->id) >{{ strtoupper($tp->tipo_contratacion) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-6">
                                    <label>No. Concurso</label>
                                    <input type="text" class="form-control" name="no_licitacion" id="no_licitacion" required value="{{ strtoupper($info->no_licitacion) }}" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                </div>
                            </div>

                                <div class="row form-group">
                                    <div class="col-lg-6">
                                        <label>Fecha de acto de fallo</label>
                                        @if($info->acto_fallo_info != null || $info->acto_fallo_info != "")
                                            <input type="text" id="acto_fallo_info" name="acto_fallo_info" class="form-control" value="{{ date('d/m/Y', strtotime($info->acto_fallo_info))}}" readonly>
                                        @else
                                            <input type="text" id="acto_fallo_info" name="acto_fallo_info" class="form-control"  readonly>
                                        @endif
                                    </div>
                                </div>

                            <div class="row form-group">
                                <div class="col-lg-6">
                                    <label for="fecha_compra_bases">Fecha de compra de bases </label>
                                    @if($info->fecha_compra_bases != null || $info->fecha_compra_bases != "")
                                        <input type="text" id="fecha_compra_bases" name="fecha_compra_bases" class="form-control" value="{{ date('d/m/Y', strtotime($info->fecha_compra_bases))}}" readonly>
                                    @else
                                        <input type="text" id="fecha_compra_bases" name="fecha_compra_bases" class="form-control"  readonly>
                                    @endif
                                </div>


                                <div class="col-lg-6">
                                    <label>¿Aplica la fecha de visita?</label>
                                    <div class="radio-inline">
                                        <label class="radio">
                                            <input type="radio" checked name="fecha_visita_aplica" {{($info->fecha_visita_aplica == 0) ? 'checked' : ''}} id="ftp_uno" value="0" />
                                            <span></span>
                                            Si
                                        </label>
                                        <label class="radio">
                                            <input type="radio" name="fecha_visita_aplica" {{($info->fecha_visita_aplica == 1) ? 'checked' : ''}} id="ftp_dos" value="1" />
                                            <span></span>
                                            No
                                        </label>
                                    </div>
                                    <input type="hidden" name="op_fecha" id="op_fecha" value="{{ $info->fecha_visita_aplica }}">
                                </div>

                            </div>

                            <div class="row form-group">

                                <div class="col-lg-6 {{($info->fecha_visita_aplica == 1) ? 'oculto' : ''}} mt-4" id="div_fecha_visita">
                                    <label>Fecha de visita</label>
                                    @if($info->fecha_visita != null || $info->fecha_visita != "")
                                        <input type="datetime-local" class="form-control" name="fecha_visita" id="fecha_visita"  value="{{$info->fecha_visita }}"/>
                                    @else
                                        <input type="datetime-local" class="form-control" name="fecha_visita" id="fecha_visita"  value=""/>
                                    @endif
                                </div>
                                <div class="col-lg-6">
                                    <label for="fecha_solicitud"> Fecha y Hora de envío de preguntas</label>
                                    <input type="datetime-local" id="fecha_preguntas" name="fecha_preguntas" class="form-control"
                                            value="{{ $info->fecha_preguntas }}">
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-lg-6">
                                    <label>Fecha y hora de Junta de aclaración de bases de concurso</label>
                                    @if($info->junta_aclaraciones != null || $info->junta_aclaraciones != "")
                                        <input type="datetime-local" class="form-control" name="junta_aclaraciones" id="junta_aclaraciones" value="{{ $info->junta_aclaraciones }}" required/>
                                    @else
                                        <input type="datetime-local" class="form-control" name="junta_aclaraciones" id="junta_aclaraciones" value="" required/>
                                    @endif
                                </div>


                                <div class="col-lg-6">
                                    <label for="fecha_entrega_propuestas"> Fecha y hora de entrega de propuestas </label>
                                    @if($info->fecha_entrega_propuestas != null || $info->fecha_entrega_propuestas != "")
                                        <input type="datetime-local" id="fecha_entrega_propuestas" name="fecha_entrega_propuestas" class="form-control" value="{{ $info->fecha_entrega_propuestas }}">
                                    @else
                                        <input type="datetime-local" id="fecha_entrega_propuestas" name="fecha_entrega_propuestas" class="form-control" value="">
                                    @endif
                                </div>

{{--                                 <div class="col-lg-6">
                                    <label>Fecha de firma de contrato</label>
                                    @if($info->firma_entrega != null || $info->firma_entrega != "")
                                        <input type="text" class="form-control" name="firma_entrega" id="firma_entrega" value="{{ date('d/m/Y', strtotime($info->firma_entrega))}}"/>
                                    @else
                                        <input type="text" class="form-control" name="firma_entrega" id="firma_entrega" value=""/>
                                    @endif
                                </div> --}}
{{--                                 <div class="col-lg-6">
                                    <label>Nombre de empresa o participación conjunta</label>
                                    <input type="text" class="form-control" name="participacion_conjunta" id="participacion_conjunta" value="{{ $info->participacion_conjunta }}" />
                                </div> --}}
{{--                                 <div class="col-lg-6">
                                    <label>Monto ofertado</label>
                                    <input type="text" class="form-control" name="monto_ofertado" id="monto_ofertado" required value="{{ $info->monto_ofertado }}"/>
                                </div> --}}
                            </div>



                                <div class="row form-group">
                                
                                    <div class="col-lg-6">
                                        <label> Fecha de apertura de oferta técnica</label>
                                        @if($info->fecha_apertura_tecnica != null || $info->fecha_apertura_tecnica != "")
                                            <input type="text" class="form-control" name="fecha_apertura_tecnica" id="fecha_apertura_tecnica" readonly  value="{{ date('d/m/Y', strtotime($info->fecha_apertura_tecnica))}}" />
                                        @else
                                            <input type="text" class="form-control" name="fecha_apertura_tecnica" id="fecha_apertura_tecnica" readonly  value="" />
                                        @endif
                                    </div>

                                    <div class="col-lg-6">
                                        <label> Fecha de apertura de oferta económica</label>
                                        @if($info->fecha_apertura_economica != null || $info->fecha_apertura_economica != "")
                                            <input type="text" class="form-control" name="fecha_apertura_economica" id="fecha_apertura_economica" readonly  value="{{ date('d/m/Y', strtotime($info->fecha_apertura_economica))}}" />
                                        @else
                                            <input type="text" class="form-control" name="fecha_apertura_economica" id="fecha_apertura_economica" readonly  value="" />
                                        @endif
                                    </div>

                                </div>



                                <div class="row form-group">

                                    <div class="col-lg-6">
                                        <label>Fecha de presentación de propuesta</label>
                                        @if($info->apertura_proposiciones != null || $info->apertura_proposiciones != "")
                                            <input type="text" class="form-control" name="apertura_proposiciones" id="apertura_proposiciones" readonly  value="{{ date('d/m/Y', strtotime($info->apertura_proposiciones))}}" required />
                                        @else
                                            <input type="text" class="form-control" name="apertura_proposiciones" id="apertura_proposiciones" readonly  value=""  required/>
                                        @endif
                                    </div>

                                    <div class="col-lg-6">
                                        <label>¿Aplica la fecha de subasta?</label>
                                        <div class="radio-inline">
                                            <label class="radio">
                                                <input type="radio" checked name="fecha_subasta_aplica" {{($info->fecha_subasta_aplica == 0) ? 'checked' : ''}} id="fsp_uno" value="0" />
                                                <span></span>
                                                Si
                                            </label>
                                            <label class="radio">
                                                <input type="radio" name="fecha_subasta_aplica" {{($info->fecha_subasta_aplica == 1) ? 'checked' : ''}} id="fsp_dos" value="1" />
                                                <span></span>
                                                No
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-lg-6  {{($info->fecha_subasta_aplica == 1) ? 'oculto' : ''}}" id="fecha_subasta_div">
                                        <label>Fecha de subasta</label>
                                        @if($info->fecha_subasta != null || $info->fecha_subasta != "")
                                            <input type="text" class="form-control" name="fecha_subasta" id="fecha_subasta" readonly  value="{{ date('d/m/Y', strtotime($info->fecha_subasta))}}" />
                                        @else
                                            <input type="text" class="form-control" name="fecha_subasta" id="fecha_subasta" readonly  value="" />
                                        @endif


                                            <input type="hidden" name="op_fecha_subasta" id="op_fecha_subasta" value="{{ $info->fecha_subasta_aplica }}">
                                    </div>
                                </div>



{{--                             <div class="row form-group">
                                <div class="col-lg-6">
                                    <label>Monto adjudicado</label>
                                    <input type="text" class="form-control" name="monto_ganado" id="monto_ganado" value="{{ $info->monto_ganado }}" />
                                </div>
                                <div class="col-lg-6">
                                    <label>Número de fianza para garantizar oferta</label>
                                    <input type="number" class="form-control" name="porcentaje_efectividad" id="porcentaje_efectividad" value="{{ $info->porcentaje_efectividad }}"/>
                                </div>
                            </div> --}}

{{--                             <div class="row form-group">
                                <div class="col-lg-6">
                                    <label>Monto de la fianza</label>
                                    <input type="text" class="form-control" name="monto_fianza" id="monto_fianza" value="{{ $info->monto_fianza }}" />
                                </div>
                                <div class="col-lg-6">
                                    <label>Fecha de la fianza</label>
                                    @if($info->fecha_fianza != null || $info->fecha_fianza != "")
                                        <input type="text" class="form-control" readonly name="fecha_fianza" id="fecha_fianza" value="{{ date('d/m/Y', strtotime($info->fecha_fianza))}}"/>
                                    @else
                                        <input type="text" class="form-control" readonly name="fecha_fianza" id="fecha_fianza" value=""/>
                                    @endif
                                </div>
                            </div>
 --}}
                            <div class="row form-group">
{{--                                 <div class="col-lg-6">
                                    <label>Monto de fianza liberada</label>
                                    <input type="text" class="form-control" name="monto_fianza_liberada" id="monto_fianza_liberada" value="{{ $info->monto_fianza_liberada }}"/>
                                </div> --}}

                                <div class="col-lg-6">
                                    <label>Fecha de inicio de vigencia de los servicios</label>
                                    @if($info->fecha_entrega != null || $info->fecha_entrega!="")
                                        <input type="text" class="form-control" name="fecha_entrega" id="fecha_entrega" readonly value="{{ date('d/m/Y', strtotime($info->fecha_entrega))}}"/>
                                    @else
                                        <input type="text" class="form-control" name="fecha_entrega" id="fecha_entrega" readonly value=""/>
                                    @endif
                                </div>

                                    <div class="col-lg-6">
                                        <label>Fecha final de vigencia de los servicios</label>
                                        @if($info->fecha_final_servicios != null || $info->fecha_final_servicios!="")
                                            <input type="text" class="form-control" name="fecha_final_servicios" id="fecha_final_servicios" readonly value="{{ date('d/m/Y', strtotime($info->fecha_final_servicios))}}"/>
                                        @else
                                            <input type="text" class="form-control" name="fecha_final_servicios" id="fecha_final_servicios" readonly value=""/>
                                        @endif


                                    </div>

                            </div>

                            <div class="row form-group">
                                    <div class="col-lg-6">
                                        <label>¿Aplica la fecha de repreguntas?</label>
                                        <div class="radio-inline">
                                            <label class="radio">
                                                <input type="radio" checked name="fecha_repreguntas_aplica" {{($info->fecha_repreguntas_aplica == 0) ? 'checked' : ''}} id="frp_uno" value="0" />
                                                <span></span>
                                                Si
                                            </label>
                                            <label class="radio">
                                                <input type="radio" name="fecha_repreguntas_aplica" {{($info->fecha_repreguntas_aplica == 1) ? 'checked' : ''}} id="frp_dos" value="1" />
                                                <span></span>
                                                No
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-lg-6  {{($info->fecha_repreguntas_aplica == 1) ? 'oculto' : ''}}" id="fecha_repreguntas_div">
                                        <label>Fecha de repreguntas</label>
                                        @if($info->fecha_repreguntas != null || $info->fecha_repreguntas != "")
                                            <input type="text" class="form-control" name="fecha_repreguntas" id="fecha_repreguntas" readonly  value="{{ date('d/m/Y', strtotime($info->fecha_repreguntas))}}" />
                                        @else
                                            <input type="text" class="form-control" name="fecha_repreguntas" id="fecha_repreguntas" readonly  value="" />
                                        @endif


                                            <input type="hidden" name="op_fecha_repreguntas" id="op_fecha_repreguntas" value="{{ $info->fecha_repreguntas_aplica }}">
                                    </div>
                            </div>

                            <div class="row form-group">

                                <div class="col-lg-6">
                                    <label>Número de vehículos</label>
                                    <input type="number" class="form-control" name="numero_vehiculos" value="{{ $info->numero_vehiculos }}" id="numero_vehiculos"/>
                                </div>

                                <div class="col-lg-6">
                                    <label>Tipo de partida</label>
                                    <div class="radio-inline">
                                        <label class="radio">
                                            <input type="radio" {{($info->tipo_partida == 0) ? 'checked' : ''}} name="tipo_partida" value="0"/>
                                            <span></span>
                                            Partida única
                                        </label>
                                        <label class="radio">
                                            <input type="radio" {{($info->tipo_partida == 1) ? 'checked' : ''}} name="tipo_partida" value="1"/>
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
                                            <input type="radio"  {{($info->tipo_contrato == 0) ? 'checked' : ''}} name="tipo_contrato" value="0"/>
                                            <span></span>
                                            Contrato abierto
                                        </label>
                                        <label class="radio">
                                            <input type="radio" {{($info->tipo_contrato == 1) ? 'checked' : ''}} name="tipo_contrato" value="1"/>
                                            <span></span>
                                            Contrato cerrado
                                        </label>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <label>Modalidad</label>
                                    <div class="radio-inline">
                                        <label class="radio">
                                            <input type="radio"  {{($info->modalidad == 0) ? 'checked' : ''}} name="modalidad" value="0"/>
                                            <span></span>
                                            Electrónica
                                        </label>
                                        <label class="radio">
                                            <input type="radio" {{($info->modalidad == 1) ? 'checked' : ''}} name="modalidad" value="1"/>
                                            <span></span>
                                            Presencial
                                        </label>
                                    </div>
                                </div>

                            </div>

                            <div class="row form-group">
                                <div class="col-lg-12">
                                    <label>Observaciones</label>
                                    <textarea class="form-control specialCharts" name="observaciones" id="observaciones" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">{{ $info->observaciones }}</textarea>
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
                                                                        <input type="radio" checked id="cp_con" name="ganado" value="0"/>
                                                                        <span></span>
                                                                        Concursando
                                                                    </label>
                                                                    <label class="radio">
                                                                        <input type="radio" name="ganado" id="cp_uno" value="1"/>
                                                                        <span></span>
                                                                        No
                                                                    </label>
                                                                    <label class="radio">
                                                                        <input type="radio" name="ganado" id="cp_dos" value="2"/>
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
                                                        @if($info->acto_fallo != null  || $info->acto_fallo != "")
                                                            <input type="text" class="form-control" name="acto_fallo" id="acto_fallo" readonly  value="{{ date('d/m/Y', strtotime($info->acto_fallo))}}"/>
                                                        @else
                                                            <input type="text" class="form-control" name="acto_fallo" id="acto_fallo" readonly  value=""/>
                                                        @endif
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
                                                                    <label>El sistema les enviara una alerta a las siguientes personas para notificar que el concurso fue ganado.</label>

                                                                    <div class="row">
                                                                        <div class="col-lg-4">
                                                                            
                                                                        </div>
                                                                        <div class="col-lg-8"> 
                                                                            <div class="row">
                                                                                @foreach($users as $us)
                                                                                    <div class="col-lg-4">
                                                                                        <div class="row">
                                                                                            <div class="col-lg-12 text-center">
                                                                                                @if($us->avatar == "" || $us->avatar == null)
                                                                                                <img src="/img/no_disponible.png" width="80"  style="border-radius:19%">
                                                                                                @else
                                                                                                    <img src="{{ route('archivo.documentoAvatar', [$us->avatar]) }}" width="140"  style="border-radius:19%">
                                                                                                @endif
                                                                                            </div>
                                                                                            
                                                                                        </div>
                                                                                        <div class="row">
                                                                                            <div class="col-lg-12 text-center">
                                                                                                <label>{{ $us->name }}</label>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                @endforeach
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
                        <div class="tab-pane fade mt-5" id="kt_tab_pane_2" role="tabpanel" aria-labelledby="kt_tab_pane_2">

                            <table class="table table-hover mb-6 table-responsive-sm" id="tblDocumentos">
                                <thead>
                                <tr>
                                    <th scope="col">Documento</th>
                                    <th scope="col">Tipo de Documento</th>
                                    <th scope="col">Opción</th>
                                </tr>
                                </thead>
                                <tbody id='tbodyDocumentos'>
                                    @foreach($documentos as $documento)
                                    <tr id="trDocumento{{ $documento->id }}">
                                        <td><a href="{{ route('archivo.documentoLicitacion', ['id'=>$documento->id]) }}" class="link-primary" target="_blank"> {{ $documento->tipoDocumentosLicitaciones->documento_licitacion }} </a></td>
                                        <td>{{ $documento->tipoDocumentosLicitaciones->documento_licitacion }}</td>
                                        <td>
                                            <a href='#' class='btn btn-sm btn-clean btn-hover-icon-success btn-icon hrefEliminar' data-id='{{ $documento->id }}' data-documento='{{ $documento->documento }}'  data-toggle='tooltip' data-theme='dark' title='Eliminar'>
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
                        <div class="col-lg-12">
                            <button type="button"  id="btnGuardarLicitacion" class="btn btn-success"><i class="la la-plus"></i>Guardar</button>
                            <a href="{{ route('licitacion.listadolicitaciones') }}"  class="btn btn-secondary"><i class="la la-arrow-left"></i>Regresar</a>
                            <input type="hidden" id="licitacionEliminarPath" value="{{ route('licitacion.eliminardocumentacion') }}">
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
