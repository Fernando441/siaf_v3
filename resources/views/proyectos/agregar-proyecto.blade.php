@extends('layouts.app')
@section('title')
    Seguimiento de contrato
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
	.oculto{display: none;}
    .op_select{
box-shadow: 0px 7px 5px -2px rgba(174,251,117,0.74);
-webkit-box-shadow: 0px 7px 5px -2px rgba(174,251,117,0.74);
-moz-box-shadow: 0px 7px 5px -2px rgba(174,251,117,0.74);  
    }

</style>
    <input type='hidden' id='PenalziacionProyecto' value='{{ $cadenaPenalizacion }}'>
    <input type="hidden" id="eliminarDocumentoPath" value="{{ route('proyecto.eliminarDocumento') }}">
	<div class="row">
		<div class="col-md-12">
			<div class="card card-custom gutter-b">
			    <div class="card-header">
			        <h3 class="card-title">Seguimiento de contrato</h3>
			        <div class="card-toolbar">

                    @if (in_array(114, $permiso_array))
                        <a href="{{ route('licitacion.ver',$info_licitacion->id)}}" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon" title="Ver concurso" data-theme="dark" data-toggle="tooltip" data-placement="top">
                            <i class="flaticon-eye"></i>
                        </a>   {{-- VER licitacion --}}
                    @endif

                    @if (in_array(116, $permiso_array))
                        <a href="{{ route('licitacion.editarlicitacion',$info_licitacion->id) }}" class="btn btn-sm  btn-hover-icon-success btn-icon" title="Editar concurso" data-theme="dark" data-toggle="tooltip" data-placement="top">
                            <i class="flaticon-edit"></i>
                        </a>   {{-- Editar licitacion --}}
                    @endif

                    @if (in_array(133, $permiso_array))
                        @if($info_licitacion->acto_fallo == null || $info_licitacion->acto_fallo == ""){
                        @else
                            <a href="{{ route('licitacion.agregar',$info_licitacion->id) }}" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon op_select" title="Crear contrato" data-theme="dark" data-toggle="tooltip" data-placement="top">
                                <i class="flaticon-file-1"></i>
                            </a>  {{-- Agregar contrato --}}
                        @endif
                    @endif

                    @if (in_array(134, $permiso_array))
                        <a href="{{ route('proposicioneconomica.crearproposicioneconomica', [$info_licitacion->id,1,$info_licitacion->tipo_contrato]) }}" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon" title="Crear propuesta económica" data-theme="dark" data-toggle="tooltip" data-placement="top">
                            <i class="flaticon-presentation-1"></i>
                        </a>   {{-- Propuesta economica --}}
                    @endif

                    @if (in_array(135, $permiso_array))
                        <a href="{{ route('propuestatecnica.crearpropuestatecnica',$info_licitacion->id) }}" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon" title="Crear propuesta" data-theme="dark" data-toggle="tooltip" data-placement="top">
                            <i class="flaticon2-website"></i>  
                        </a>   {{-- Propuesta Tecnica --}}
                    @endif

                    @if (in_array(143, $permiso_array))
                        <a href="{{ route('licitacion.informacionfinanzas',$info_licitacion->id) }}" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon" title="Información de las fianzas y seguros" data-theme="dark" data-toggle="tooltip" data-placement="top">
                                <i class="flaticon-notepad"></i>
                        </a>   {{-- Finanzas --}}
                    @endif

                    <a href="{{ route('licitacion.listadolicitaciones') }}" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon" data-toggle="tooltip" data-theme="dark" title="Salir" ><i class="flaticon2-reply "></i></a>


                        <a href="{{ route('licitacion.agregarnuevo',[$info_licitacion->id,2]) }}" class="btn btn-light-primary font-weight-bolder mr-3 ml-3">
                            <i class="la la-plus"></i>Registrar Convenios
                        </a>
			        </div>
			    </div>
                <form action="{{ route('proyecto.guardarproyectocomplemento') }}" method="post" class="form" id="submit_contrato_edit" enctype="multipart/form-data">
                    <input type='hidden' id='tipoArchivo' value='{{ $cadenaTipoDocumento }}'>
                    <input type='hidden' id='pagoAvance' value='{{ $cadenaavance }}'>
                    @csrf
                    <div class="card-body">

                        <!--begin::tabs-->
                        <ul class="nav nav-tabs nav-tabs-line">
                            @foreach($inf_pro as $pro)
                                <li class="nav-item">
                                    <a class="nav-link {{($pro->contrato_complemento == 1) ? 'active' : ''}}" data-toggle="tab" href="#kt_tab_pane_{{ $pro->no_folio }}">Folio - {{ $pro->no_folio }}</a>
                                </li>
                            @endforeach
                        </ul>

                        <div class="tab-content mt-5" id="myTabContent">
                            @foreach($inf_pro as $pro)
                                <div class="tab-pane fade show {{($pro->contrato_complemento == 1) ? 'active' : ''}} mt-10" id="kt_tab_pane_{{ $pro->no_folio }}" role="tabpanel" aria-labelledby="kt_tab_pane_{{ $pro->no_folio }}">

                                   <ul class="nav nav-tabs nav-tabs-line">
                                        <li class="nav-item">
                                            <a class="nav-link active" data-toggle="tab" href="#kt_tab_info_{{ $pro->no_folio }}">Información de contrato</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#kt_tab_doc_{{ $pro->no_folio }}">Documentos</a>
                                        </li>
                                    </ul>

                                    <div class="tab-content mt-5" id="myTabContentinfo">
                                        <div class="tab-pane fade show active mt-10" id="kt_tab_info_{{ $pro->no_folio }}" role="tabpanel" aria-labelledby="kt_tab_info_{{ $pro->no_folio }}">
                                            <div class="row form-group mt-2">
                                                <div class="col-lg-6">
                                                    <label>Folio del concurso</label>
                                                    <p>{{ $info_licitacion->folio }}</p>
                                                    <input type="hidden" name="licitacion" value="{{ $info_licitacion->id }}">
                                                    <input type="hidden" name="id_proyecto[]" value="{{ $pro->id }}">
                                                </div>

                                                <div class="col-lg-6">
                                                    <label>Cliente</label>
                                                    <p>{{ $info_licitacion->razon_social }}</p>
                                                    <input type="hidden" name="id_cliente" value="{{ $info_licitacion->cliente }}">
                                                </div>
                                            </div>
                                       
                                            <div class="row form-group">
                                                <div class="col-lg-6">
                                                    <label>No. Concurso</label>
                                                    <p>{{ $info_licitacion->no_licitacion }}</p>
                                                </div>

                                                <div class="col-lg-6">
                                                    <label>Título del servicio</label>
                                                    <p>{{ $info_licitacion->titulo_servicio }}</p>
                                                    <input type="hidden" name="titulo_servicio" value="{{ $info_licitacion->titulo_servicio }}">
                                                </div>
                                            </div>

                                            <div class="row form-group">
                                                <div class="col-lg-6">
                                                    <label>Tipo de contratación</label>
                                                    <p>{{ $info_licitacion->tipo_contratacion }}</p>
                                                    <input type="hidden" name="id_contratacion" value="{{ $info_licitacion->contratacion }}">
                                                </div>

                                                <div class="col-lg-6">
                                                    <label>Prioridad</label>
                                                    @if($info_licitacion->id_licitacion_prioridad == 1)
                                                        <p><span class="label font-weight-bold label-outline-danger label-inline" >Alta</span></p>
                                                    @endif
                                                    @if($info_licitacion->id_licitacion_prioridad == 2)
                                                        <p><span class="label font-weight-bold label-outline-warning label-inline" >Media</span></p>
                                                    @endif
                                                    @if($info_licitacion->id_licitacion_prioridad == 3)
                                                        <p><span class="label font-weight-bold label-outline-primary label-inline" >Baja</span></p>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="row form-group">

                                            </div>

                                            <div class="row form-group">
                                                <div class="col-lg-6">
                                                    <label>Id contrato</label>
                                                    <input type="text" class="form-control id_contrato" name="id_contrato[]" id="id_contrato" value="{{ $pro->id_contrato }}" required onkeyup="javascript:this.value=this.value.toUpperCase();"/>
                                                </div>
                                                <div class="col-lg-6">
                                                    <label>No. Contrato</label>
                                                    <input type="text" class="form-control no_contrato" value="{{ $pro->no_contrato }}" id="no_contrato" name="no_contrato[]"  onkeyup="javascript:this.value=this.value.toUpperCase();"/>
                                                </div>
                                            </div>

                                            @if($pro->convenio_op == 1)
                                               <input type="hidden" name="convenio_op" value="1">
                                               <input type="hidden" name="no_convenio" value="">
                                               <input type="hidden" name="modificacion_id" value="">
                                                    <div class="col-lg-6 oculto">
                                                        <label>Modificaciones al contrato original</label>
                                                        <select class="form-control" name="modificacion_id[]" id="modificacion_id">
                                                            <option value="">Selecciona una opción</option>
                                                           @foreach($convenio as $ub)
                                                                <option value="{{ $ub->id}}" {{($ub->id == $pro->modificacion_id) ? 'selected' : ''}}>
                                                                    {{ strtoupper($ub->nombre_modificacion)}}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                            @else
{{--                                                 @php
                                                    $seg_num = $count_inf_contrato + 1;
                                                @endphp --}}
                                                <input type="hidden"  name="convenio_op" value="2">
                                                <div class="row form-group">
                                                    <div class="col-lg-6">
                                                        <label>No. Convenio</label>
                                                        <input type="text" class="form-control" name="no_convenios" value="{{ $pro->no_convenio }}" disabled>
                                                        <input type="hidden" class="form-control" name="no_convenio" value="{{ $pro->no_convenio }}">
                                                    </div>
                      
                                                    <div class="col-lg-6">
                                                        <label>Modificaciones al contrato original</label>
                                                        <select class="form-control" name="modificacion_id[]" id="modificacion_id">
                                                            <option value="">Selecciona una opción</option>
                                                           @foreach($convenio as $ub)
                                                                <option value="{{ $ub->id}}" {{($ub->id == $pro->modificacion_id) ? 'selected' : ''}}>
                                                                    {{ strtoupper($ub->nombre_modificacion)}}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            @endif

                                            <div class="row form-group">
                                                @if($pro->convenio_op == 1)
                                                    <div class="col-lg-6">
                                                        <label>Administrador de contrato</label>
                                                        <select class="form-control id_emisor" name="id_emisor[]" required>
                                                            <option value="">Selecciona una opción</option>
                                                            @foreach($emisores as $ub)
                                                                <option value="{{ $ub->id }} {{($ub->razon_social == "Jet Van Car Rental, S.A. de C.V.") ? 'selected' : ''}}" {{($ub->id == $pro->id_emisor) ? 'selected' : ''}}>
                                                                    {{ $ub->razon_social }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                @else
                                                    <div class="col-lg-6 oculto">
                                                        <label>Administrador de contrato</label>
                                                        <select class="form-control id_emisor" name="id_emisor[]" required>
                                                            <option value="">Selecciona una opción</option>
                                                            @foreach($emisores as $ub)
                                                                <option value="{{ $ub->id }} {{($ub->razon_social == "Jet Van Car Rental, S.A. de C.V.") ? 'selected' : ''}}" {{($ub->id == $pro->id_emisor) ? 'selected' : ''}}>
                                                                    {{ $ub->razon_social }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                @endif
                                                <div class="col-lg-6">
                                                    @if($pro->convenio_op == 1)
                                                        <label>Fecha inicio de vigencia</label>
                                                    @else
                                                        <label>Vigencia inicial del convenio</label>
                                                    @endif
                                                    <input type="text" class="form-control fecha_vigencia" name="fecha_inicio_vigencia[]" value="{{ date('d/m/Y', strtotime($pro->firma_inicio_vigencia))}}"/>
                                                </div>
                                            </div>

                                            <div class="row form-group">
                                                <div class="col-lg-6">
                                                    @if($pro->convenio_op == 1)
                                                        <label>Fecha final de vigencia</label>
                                                    @else
                                                        <label>Vigencia final del convenio</label>
                                                    @endif
                                                    
                                                    
                                                    <input type="text" class="form-control fecha_final_vigencia" name="fecha_final_vigencia[]" value=" {{ date('d/m/Y', strtotime($pro->firma_final_vigencia))}}" />
                                                </div>

                                                @if($pro->convenio_op == 1)
                                                    <div class="col-lg-6">
                                                        <label>Fecha de firma de contrato</label>
                                                        @if($pro->firma_contrato != null || $pro->firma_contrato!= "")
                                                            <input type="text" class="form-control" name="firma_contrato" readonly id="firma_contrato" value=" {{ date('d/m/Y', strtotime($pro->firma_contrato))}}"/>
                                                        @else
                                                            <input type="text" class="form-control" name="firma_contrato" readonly id="firma_contrato" value=""/>
                                                        @endif
                                                        
                                                    </div>
                                                @else
                                                    <div class="col-lg-6 oculto">
                                                        <label>Fecha de firma de contrato</label>
                                                        @if($pro->firma_contrato != null || $pro->firma_contrato!= "")
                                                            <input type="text" class="form-control" name="firma_contrato" readonly id="firma_contrato" value=" {{ date('d/m/Y', strtotime($pro->firma_contrato))}}"/>
                                                        @else
                                                            <input type="text" class="form-control" name="firma_contrato" readonly id="firma_contrato" value=""/>
                                                        @endif
                                                        
                                                    </div>
                                                @endif
                                            </div>    

                                            @if($pro->convenio_op == 1)
                                            <div class="row form-group">
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label>Tipo de contrato</label>
                                                        <div class="radio-inline">
                                                            {{-- @if($pro->contrato_op == '0') --}}
                                                                <label class="radio">
                                                                    <input type="radio" name="contrato_op{{ $pro->id }}" {{($pro->contrato_op == '0') ? 'checked' : ''}} class="tp1" data-id="{{ $pro->id }}" value="0"/>
                                                                    <span></span>
                                                                    Contrato Abierto
                                                                </label>
                                                                <label class="radio">
                                                                    <input type="radio" name="contrato_op{{ $pro->id }}" {{($pro->contrato_op == '1') ? 'checked' : ''}} class="tp2" data-id="{{ $pro->id }}" value="1"/>
                                                                    <span></span>
                                                                    Contrato Cerrado
                                                                </label>
                                                            {{-- @endif   --}}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> 
                                            @else
                                            <div class="row form-group oculto">
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label>Tipo de contrato</label>
                                                        <div class="radio-inline">
                                                            {{-- @if($pro->contrato_op == '0') --}}
                                                                <label class="radio">
                                                                    <input type="radio" name="contrato_op{{ $pro->id }}" {{($pro->contrato_op == '0') ? 'checked' : ''}} class="tp1" data-id="{{ $pro->id }}" value="0"/>
                                                                    <span></span>
                                                                    Contrato Abierto
                                                                </label>
                                                                <label class="radio">
                                                                    <input type="radio" name="contrato_op{{ $pro->id }}" {{($pro->contrato_op == '1') ? 'checked' : ''}} class="tp2" data-id="{{ $pro->id }}" value="1"/>
                                                                    <span></span>
                                                                    Contrato Cerrado
                                                                </label>
                                                            {{-- @endif   --}}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>                                         
                                            @endif

                                            @if($pro->convenio_op == 1)
                                            <div class="form-group row">
                                                <div class="col-lg-6 abierto_{{ $pro->id }} {{($pro->contrato_op == '1') ? 'oculto' : ''}}">
                                                    <label>Monto mínimo</label>
                                                    <input type="text" class="form-control presuuesto_minimo" name="presuuesto_minimo[]" value="{{ $pro->presupuesto_minimo }}" />
                                                </div>

                                                <div class="col-lg-6 {{($pro->contrato_op == '0') ? 'oculto' : ''}} cerrado_{{ $pro->id }}">
                                                    <label>Monto del contrato</label>
                                                    <input type="text" class="form-control importe_general" name="importe_general[]" value="{{ $pro->importe_general }}"/>
                                                </div>
                                                <div class="col-lg-6 abierto_{{ $pro->id }} {{($pro->contrato_op == '1') ? 'oculto' : ''}}">
                                                    <label>Monto máximo</label>
                                                    <input type="text" class="form-control presuuesto_maximo" name="presuuesto_maximo[]" value="{{ $pro->presupuesto_maximo }}" placeholder="Presupuesto máximo"/>
                                                </div>

                                                    @php

                                                        if($pro->contrato_op == '1')
                                                        {
                                                            $total = $pro->importe_general;
                                                        }else{
                                                            $total = $pro->presupuesto_maximo;
                                                        }

                                                        $iva = 0.16 * $total;

                                                    @endphp

                                                <div class="col-lg-6 ambos">
                                                    <label>Iva</label>
                                                    <input type="text" class="form-control" readonly value="{{ number_format($iva,2,'.',',') }}" name="iva[]"/>
                                                </div>
                                            </div>

                                            @else
                                                <div class="row form-group">

                                                <div class="col-lg-6 oculto">
                                                    <label>Monto máximo</label>
                                                    <input type="text" class="form-control presuuesto_maximo" name="presuuesto_maximo[]" value="{{ $pro->presupuesto_maximo }}" placeholder="Presupuesto máximo"/>
                                                </div>
                                                <div class="col-lg-6 oculto">
                                                    <label>Monto mínimo</label>
                                                    <input type="text" class="form-control presuuesto_minimo" name="presuuesto_minimo[]" value="{{ $pro->presupuesto_minimo }}" />
                                                </div>


                                                <div class="col-lg-6  cerrado_{{ $pro->id }}">
                                                    <label>Importe del convenio</label>
                                                    <input type="text" class="form-control importe_general" name="importe_general[]" value="{{ $pro->importe_general }}"/>
                                                </div>


                                                    @php

                                                        if($pro->contrato_op == '1')
                                                        {
                                                            $total = $pro->importe_general;
                                                        }else{
                                                            $total = $pro->presupuesto_maximo;
                                                        }

                                                        $iva = 0.16 * $total;

                                                    @endphp

                                                <div class="col-lg-6 ambos">
                                                    <label>Iva</label>
                                                    <input type="text" class="form-control" readonly value="{{ number_format($iva,2,'.',',') }}" name="iva[]"/>
                                                </div>
                                                </div>

                                            @endif

                                            @if($pro->convenio_op == 1)
                                                <div class="form-group row">
                                                    <div class="col-lg-6">
                                                        <label>Administrador del contrato por parte del cliente</label>
                                                        <input type="text" class="form-control specialCharts" name="contacto_administrativo[]" value="{{ $pro->nombre_administrativo }}" id="contacto_administrativo" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <label>Teléfonos del contacto administrativo del cliente</label>
                                                        <input type="number" class="form-control" name="telefono_administrativo[]" value="{{ $pro->telefono_administrativo }}"  id="telefono_administrativo" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <div class="col-lg-6">
                                                        <label>Correo electrónico del contacto administrativo del cliente</label>
                                                        <input type="text" class="form-control" name="correo_administrativo[]" value="{{ $pro->correo_administrativo }}"  id="corre_administrativo" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="form-group row oculto">
                                                    <div class="col-lg-6">
                                                        <label>Administrador del contrato por parte del cliente</label>
                                                        <input type="text" class="form-control specialCharts" name="contacto_administrativo[]" value="{{ $pro->nombre_administrativo }}" id="contacto_administrativo" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <label>Teléfonos del contacto administrativo del cliente</label>
                                                        <input type="number" class="form-control" name="telefono_administrativo[]" value="{{ $pro->telefono_administrativo }}"  id="telefono_administrativo" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                                    </div>
                                                </div>

                                                <div class="form-group row oculto">
                                                    <div class="col-lg-6">
                                                        <label>Correo electrónico del contacto administrativo del cliente</label>
                                                        <input type="text" class="form-control specialCharts" name="correo_administrativo[]" value="{{ $pro->correo_administrativo }}"  id="corre_administrativo" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                                    </div>
                                                </div>
                                            @endif

                                    <div class="row form-group">
                                        <div class="col-lg-12">
                                            <label>Observaciones</label>
                                            <textarea class="form-control specialCharts" name="observaciones[]"  id="observaciones" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">{{ $pro->observaciones }}</textarea>
                                        </div>
                                    </div>

                                        </div>
                                    {{-- Informacion contrato --}}
                                        <div class="tab-pane fade show mt-10" id="kt_tab_doc_{{ $pro->no_folio }}" role="tabpanel" aria-labelledby="kt_tab_doc_{{ $pro->no_folio }}">
                                            <table class="table table-hover mb-6 table-responsive-sm" id="tbodyDoc_{{ $pro->id }}">
                                                <thead>
                                                <tr>
                                                    <th scope="col">Documento</th>
                                                    <th scope="col">Tipo de Documento</th>
                                                    <th scope="col">Opción</th>
                                                </tr>
                                                </thead>
                                                <tbody id="tbodyDoc_{{ $pro->id }}">
                                                    @foreach($documentos as $documento)
                                                        @if($documento->id_proyecto == $pro->id)
                                                        <tr id="trDocumento{{ $documento->id }}_{{ $pro->id }}">
                                                            <td><a href="{{ route('archivo.documentoProyecto', ['id'=>$documento->id]) }}" class="link-primary" target="_blank"> {{ $documento->documento }} </a></td>
                                                            <td>{{ $documento->proyectoTipoDocumento->tipo }}</td>
                                                            <td>
                                                                <a href='#' class='btn btn-sm btn-clean btn-hover-icon-success btn-icon hrefEliminar' data-id='{{ $documento->id }}' data-documento='{{ $documento->documento }}'  data-proyecto="{{ $pro->id }}" data-toggle='tooltip' data-theme='dark' title='Eliminar'>
                                                                    <i class='flaticon-delete'></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                        @endif
                                                    @endforeach
                                                </tbody>
                                            </table>

                                            <div class="row form-group">
                                                <div class="col-lg-12">
                                                    <a href="#" class="btn btn-icon btn-outline-success btn-circle btn-sm mr-2 hrefAgregarOtro" data-id="{{ $pro->id }}" data-toggle="tooltip" data-theme="dark" title="Agregar archivo">
                                                        <i class="flaticon2-plus"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    {{-- Documentacion --}}
                                    </div>

                                </div>
                            @endforeach
                        </div>
                        <!--end::tabs-->
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-lg-6"> 
                                <button type="button"  id="btnEditarcontrato" class="btn btn-success"><i class="la la-plus"></i>Guardar</button>
                                <a href="{{ route('licitacion.listadolicitaciones' ) }}"  class="btn btn-secondary"><i class="la la-arrow-left"></i>Regresar</a>
                            </div>
                        </div>
                    </div>
                </form>
			</div>
		</div>
	</div>

@endsection
