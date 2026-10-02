@extends('layouts.app')
@section('title')
    Seguimiento de contrato
@endsection
@push('scripts')
	<script src="{{ asset('js/contratos/CrearContrato.js') }}"></script>
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
-moz-box-s
</style>

	<div class="row">
		<div class="col-md-12">
			<div class="card card-custom gutter-b">
			    <div class="card-header">
			        <h3 class="card-title">

                        @if($count_inf_contrato == 0)
                            Agregar información del contrato
                        @else
                            Agregar información del convenio modificatorio
                        @endif
                    </h3>
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

                    



                        @if($op_new == 1)
                            <a href="{{ route('licitacion.listadolicitaciones') }}" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon" data-toggle="tooltip" data-theme="dark" title="Salir" ><i class="flaticon2-reply "></i></a>
                        @else
                            <a href="{{ route('licitacion.agregar',$info_licitacion->id) }}" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon" data-toggle="tooltip" data-theme="dark" title="Salir" ><i class="flaticon2-reply "></i></a>
                        @endif
			        </div>
			    </div>
                <form action="{{ route('proyecto.guardarproyecto') }}" method="post" class="form" id="submit_contrato" enctype="multipart/form-data">
                    <input type='hidden' id='tipoArchivo' value='{{ $cadenaTipoDocumento }}'>
                    <input type='hidden' id='pagoAvance' value='{{ $cadenaavance }}'>
                    @csrf
                    <div class="card-body">

                        <!--begin::tabs-->
                        <ul class="nav nav-tabs nav-tabs-line">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#kt_tab_pane_1">Información de contrato</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#kt_tab_pane_2">Documentos</a>
                            </li>
                        </ul>
                        <div class="tab-content mt-5" id="myTabContent">
                            <div class="tab-pane fade show active mt-10" id="kt_tab_pane_1" role="tabpanel" aria-labelledby="kt_tab_pane_1">

                                <div class="row form-group mt-2">
                                    <div class="col-lg-6">
                                        <label>Folio de concurso</label>
                                        <p>{{ $info_licitacion->folio }}</p>
                                        <input type="hidden" name="licitacion" value="{{ $info_licitacion->id }}">
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
                            
                                @if($count_inf_contrato == 0)
                                    <div class="row form-group">
                                        <div class="col-lg-6">
                                            <label>Id contrato</label>
                                            <input type="text" class="form-control" name="id_contrato" id="id_contrato" required onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                        </div>
          
                                        <div class="col-lg-6">
                                            <label>No. Contrato</label>
                                            <input type="text" class="form-control" name="no_contrato" id="no_contrato" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                        </div>
                                    </div>
                                   <input type="hidden" name="convenio_op" value="1">
                                   <input type="hidden" name="no_convenio" value="">
                                   <input type="hidden" name="modificacion_id" value="">

                                    <div class="row form-group">
                                        <div class="col-lg-6">
                                            <label>Administrador de contrato</label>
                                            <select class="form-control" name="id_emisor" id="id_emisor" required>
                                                <option value="">Selecciona una opción</option>
                                                @foreach($emisores as $ub)
                                                    <option value="{{ $ub->id }}" {{($ub->razon_social == "Jet Van Car Rental, S.A. de C.V.") ? 'selected' : ''}}>{{ $ub->razon_social }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-lg-6">
                                            <label>Fuente del proyecto</label>
                                            <select class="form-control" name="id_fuenteproyecto" id="id_fuenteproyecto">
                                                <option value="">Selecciona una opción</option>
                                                @foreach($fuente as $ub)
                                                    <option value="{{ $ub->id }}" >{{ $ub->fuente_proyecto }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row form-group">
                                        <div class="col-lg-6">
                                            <label>Fecha inicio de vigencia</label>
                                            <input type="text" class="form-control" name="fecha_inicio_vigencia" id="fecha_vigencia" readonly required />
                                        </div>

                                        <div class="col-lg-6">
                                            <label>Fecha final de vigencia</label>
                                            <input type="text" class="form-control" name="fecha_final_vigencia" id="fecha_final_vigencia" readonly required />
                                        </div>
                                    </div>

                                    <div class="row form-group">

                                        <div class="col-lg-6">
                                            <label>Fecha de firma de contrato</label>
                                            <input type="text" class="form-control" name="firma_contrato" readonly
                                                id="firma_contrato" />
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Tipo de contrato</label>
                                                <div class="radio-inline">
                                                    <label class="radio">
                                                        <input type="radio" name="contrato_op" id="tp1" checked value="0"/>
                                                        <span></span>
                                                        Contrato Abierto
                                                    </label>
                                                    <label class="radio">
                                                        <input type="radio" name="contrato_op" id="tp2" value="1"/>
                                                        <span></span>
                                                        Contrato Cerrado
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">

                                        <div class="col-lg-6 abierto">
                                            <label>Monto mínimo</label>
                                            <input type="text" class="form-control" name="presuuesto_minimo" id="presuuesto_minimo"/>
                                        </div>

                                        <div class="col-lg-6 oculto cerrado">
                                            <label>Monto del contrato</label>
                                            <input type="text" class="form-control" name="importe_general" id="importe_general" onchange="updatepresupuesto(this.value)"/>
                                        </div>
                                        
                                        <div class="col-lg-6 abierto">
                                            <label>Monto máximo</label>
                                            <input type="text" class="form-control" name="presuuesto_maximo" id="presuuesto_maximo" onchange="updatepresupuesto(this.value)"/>
                                        </div>

                                        <div class="col-lg-6 ambos">
                                            <label>Iva</label>
                                            <input type="text" class="form-control" name="iva" id="iva_up" readonly />
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-lg-6">
                                            <label>Administrador del contrato por parte del cliente</label>
                                            <input type="text" class="form-control specialCharts" name="contacto_administrativo"  id="contacto_administrativo" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                        </div>
                                        <div class="col-lg-6">
                                            <label>Teléfonos del contacto administrativo del cliente</label>
                                            <input type="number" class="form-control" name="telefono_administrativo"   id="telefono_administrativo" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                        </div>
                                    </div>
                               
                                    <div class="form-group row">
                                        <div class="col-lg-6">
                                            <label>Correo electrónico del contacto administrativo del cliente</label>
                                            <input type="text" class="form-control specialCharts" name="correo_administrativo"  id="corre_administrativo" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                        </div>
                                    </div>
                                    
                                    <div class="row form-group">
                                        <div class="col-lg-12">
                                            <label>Observaciones</label>
                                            <textarea class="form-control specialCharts" name="observaciones" id="observaciones" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"></textarea>
                                        </div>
                                    </div>

                                @else
                                <input type="hidden" name="contrato_op" value="1">
                                <input type="hidden" name="id_emisor" value="1">
                                    <div class="row form-group">
                                        <div class="col-lg-6">
                                            <label>Id contrato</label>
                                            <input type="text" class="form-control" name="id_contratod" id="id_contratod" required disabled value="{{ $id_li_no->id_contrato }}"/>
                                            <input type="hidden" class="form-control" name="id_contrato" id="id_contrato"  value="{{ $id_li_no->id_contrato }}"/>
                                        </div>
          
                                        <div class="col-lg-6">
                                            <label>No. Contrato</label>
                                            <input type="text" class="form-control" name="no_contratos" id="no_contratos" disabled  value="{{ $id_li_no->no_contrato }}"/>
                                            <input type="hidden" class="form-control" name="no_contrato" id="no_contrato"  value="{{ $id_li_no->no_contrato }}"/>
                                        </div>                                       
                                    </div>

                                    @php
                                        $seg_num = $count_inf_contrato + 1;
                                    @endphp
                                    <input type="hidden"  name="convenio_op" value="2">
                                    <div class="row form-group">
                                        <div class="col-lg-6">
                                            <label>No. Convenio</label>
                                            <input type="text" class="form-control" name="no_convenios" value="CONV-{{ $id_li_no->id_contrato }}-{{ $seg_num }}" disabled>
                                            <input type="hidden" class="form-control" name="no_convenio" value="CONV-{{ $id_li_no->id_contrato }}-{{ $seg_num }}">
                                        </div>
          
                                        <div class="col-lg-6">
                                            <label>Modificaciones al contrato original</label>
                                            <select class="form-control" name="modificacion_id" id="modificacion_id" required>
                                                <option value="">Selecciona una opción</option>
                                                @foreach($convenio as $ub)
                                                   <option value="{{ $ub->id }}" >{{ $ub->nombre_modificacion }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row form-group">
                                        <div class="col-lg-6">
                                            <label>Vigencia inicial del convenio</label>
                                            <input type="text" class="form-control" name="fecha_inicio_vigencia" id="fecha_vigencia" readonly required />
                                        </div>

                                        <div class="col-lg-6">
                                            <label>Vigencia final del convenio</label>
                                            <input type="text" class="form-control" name="fecha_final_vigencia" id="fecha_final_vigencia" readonly required />
                                        </div>
                                    </div>

                                    <div class="form-group row">

                                        <div class="col-lg-6 cerrado">
                                            <label>Importe del convenio</label>
                                            <input type="text" class="form-control" name="importe_general" id="importe_general" onchange="updatepresupuesto(this.value)"/>
                                        </div>
                                        
                                        <div class="col-lg-6 ambos">
                                            <label>Iva</label>
                                            <input type="text" class="form-control" name="iva" id="iva_up" readonly />
                                        </div>
                                    </div>

                                    <div class="row form-group">
                                        <div class="col-lg-12">
                                            <label>Observaciones</label>
                                            <textarea class="form-control" name="observaciones specialCharts" id="observaciones" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"></textarea>
                                        </div>
                                    </div>

                                @endif


        

{{--                                 <div class="form-group row">
                                    <div class="col-lg-6">
                                        <label>Ejecutivo de cuenta de JetVan</label>
                                        <select class="form-control" name="id_responsable" id="id_responsable" required>
                                            <option value="">Selecciona una opción </option>
                                            @foreach($user as $ub)
                                                <option value="{{ $ub->id}}">
                                                    {{ strtoupper($ub->name)}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div> --}}
                            </div>

                    {{-- DOCUMENTOS --}}
                            <div class="tab-pane fade mt-10" id="kt_tab_pane_2" role="tabpanel" aria-labelledby="kt_tab_pane_2">

                                <div class="row form-group" >
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
                                @if($op_new == 1)
                                	<a href="{{ route('licitacion.listadolicitaciones' ) }}"  class="btn btn-secondary"><i class="la la-arrow-left"></i>Regresar</a>
                                @else
                                	<a href="{{ route('licitacion.agregar',$info_licitacion->id) }}"  class="btn btn-secondary"><i class="la la-arrow-left"></i>Regresar</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </form>
			</div>
		</div>
	</div>
@endsection
