@extends('layouts.app')
@push('scripts')
	{{-- <script src="{{ asset('js/cliente/AgregarCliente.js') }}"></script> --}}
    <script src="{{ asset('js/unidades/tramitesvehiculares/EditarAseguramiento.js') }}"></script>
@endpush
@section('title')
    Editar tramite de aseguramiento
@endsection
@section('content')

    <!--begin::Card-->
    <div class="row">
        <div class="col-lg-12">
            <!--begin::Card-->
            <div class="card card-custom gutter-b">
                <div class="card-header">
                    <h3 class="card-title">Editar tramite de aseguramiento</h3>
                </div>
                <input type="hidden" id="documentoEliminarPath" value="{{ route('traveh.eliminardocumentoevaseg') }}">
                <!--begin::Form-->
                <form class="form" action="{{ route('traveh.editinfoevaseguramiento') }}" method="post" id="frmCliente" enctype="multipart/form-data">
                    @csrf   
                    <input type="hidden" name="id_unidad" value="{{ $id_unidad }}">
                    <input type="hidden" name="id_pago" value="{{ $id_pago }}">
                    <input type='hidden' id='tipoArchivo' value='{{ $cadenaTipoDocumento }}'>
                    <div class="card-body">
                        <!--begin::tabs-->
                        <ul class="nav nav-tabs nav-tabs-line">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#kt_tab_pane_1">Información del tramite</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#kt_tab_pane_2">Evidencias</a>
                            </li>
                        </ul>
                        <div class="tab-content mt-5" id="myTabContent">
                            <div class="tab-pane fade show active mt-10" id="kt_tab_pane_1" role="tabpanel" aria-labelledby="kt_tab_pane_1">
                                <div class="form-group row">
                                    <div class="col-lg-6">
                                        <label>Agente</label>
                                        <select class="form-control" id="gestor" name="gestor"  required >
                                            <option value="">Selecciona una opción</option>
                                            @foreach($gestor as $pro)
                                                <option value="{{ $pro->id }}" @selected($tramite_info->unidad_tramite_gestor_id == $pro->id) >{{ $pro->nombre }} - Telefono: {{ $pro->telefono }} - correo: {{ $pro->correo }} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-6">
                                        <label>Propietario</label>
                                        <select class="form-control" id="id_propietario" name="id_propietario"  required >
                                            <option value="">Selecciona una opción</option>
                                            @foreach($info_propietario as $tp)
                                                <option value="{{ $tp->id }}" @selected($tramite_info->unidad_informacion_propietario_id == $tp->id) >{{ strtoupper( $tp->nombre_propietario) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <div class="col-lg-6">
                                        <label>Servicio</label>
                                        <div class="input-group">
                                            <input type="text" name="servicio" id="servicio" value="{{ $tramite_info->servicio }}"  class="form-control" required  onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <label>Estatus</label>
                                        <select class="form-control" id="estatus" name="estatus"  required >
                                            <option value="">Selecciona una opción</option>
                                            @foreach($estatus_aseg as $pro)
                                                <option value="{{ $pro->id }}"  @selected($tramite_info->tramite_estatus == $pro->id) >{{ strtoupper( $pro->nombre_estatus) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <div class="col-lg-8">
                                        <label>Vehículo</label>
                                        <div class="input-group">
                                            <input type="text" name="descripcion" id="descripcion" value="{{ $tramite_info->descripcion }}"  class="form-control" required  onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                        </div>
                                    </div> 
                                    <div class="col-lg-4">
                                        <label>Modelo</label>
                                        <div class="input-group">
                                            <input type="number" name="modelo" id="modelo" value="{{ $tramite_info->modelo }}"  class="form-control" required  onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                        </div>
                                    </div> 
                                </div>

                                <div class="form-group row">
                                    <div class="col-lg-6">
                                        <label>No. Serie</label>
                                        <div class="input-group">
                                            <input type="text" name="serie" id="serie"  value="{{ $tramite_info->serie }}" class="form-control" required  onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                        </div>
                                    </div> 
                                    <div class="col-lg-6">
                                        <label>Uso de la unidad en la poliza - Servicio</label>
                                        <div class="input-group">
                                            <input type="text" name="uso_unidad_poliza" id="uso_unidad_poliza" value="{{ $tramite_info->uso_unidad_poliza }}"  class="form-control" required  onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                        </div>
                                    </div> 
                                </div>
                                {{-- Nuevos campos --}}
                                <div class="row form-group">
                                    <div class="col-lg-4">
                                        <label>Valor factura</label>
                                        <div class="input-group">
                                            <input type="text" name="valor_factura" id="valor_factura" value="{{ $tramite_info->valor_factura }}"  class="form-control" required />
                                        </div>
                                    </div>  

                                    <div class="col-lg-4">
                                        <label>Equipo especial - Fecha de factura</label>
                                        <div class="input-group">
                                            <input type="text" name="fecha_factura_eq_esp" id="fecha_factura_eq_esp" value="{{ date('d/m/Y', strtotime($tramite_info->fecha_factura_eq_esp))}}"  class="form-control"  />
                                        </div>
                                    </div>  

                                    <div class="col-lg-4">
                                        <label>Adaptacion - Fecha de factura</label>
                                        <div class="input-group">
                                            <input type="text" name="fecha_factura_adaptacion" id="fecha_factura_adaptacion" value="{{ date('d/m/Y', strtotime($tramite_info->fecha_factura_adaptacion))}}"  class="form-control" required />
                                        </div>
                                    </div>  
                                </div>
                                {{-- Nuevos campos --}}


                                <div class="row form-group">
                                    <div class="col-lg-4">
                                        <label>Suma asegurada de unidad</label>
                                        <div class="input-group">
                                            <input type="text" name="importe" id="importe" value="{{ $tramite_info->importe }}"  class="form-control" required />
                                        </div>
                                    </div>  

                                    <div class="col-lg-4">
                                        <label>Valor EQ. ESP. - Suma asegurada EQ. ESP.</label>
                                        <div class="input-group">
                                            <input type="text" name="valor_eq_esp" id="valor_eq_esp" value="{{ $tramite_info->valor_eq_esp }}"  class="form-control" required />
                                        </div>
                                    </div>  

                                    <div class="col-lg-4">
                                        <label>Valor adaptacion - Suma asegurada Adapt.</label>
                                        <div class="input-group">
                                            <input type="text" name="valor_adaptacion" id="valor_adaptacion" value="{{ $tramite_info->valor_adaptacion }}"  class="form-control" required />
                                        </div>
                                    </div>  
                                </div>


                                <div class="row form-group">
                                    <div class="col-lg-6">
                                        <label>Nombre del archivo poliza</label>
                                        <div class="input-group">
                                            <input type="text" name="nombre_archivo_poliza" id="nombre_archivo_poliza"  value="{{ $tramite_info->nombre_archivo_poliza }}" class="form-control" required  onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                        </div>
                                    </div> 
                                    <div class="col-lg-6">
                                        <label>Aseguradora</label>
                                        <select class="form-control" id="aseguradora_id" name="aseguradora_id"  required >
                                            <option value="">Selecciona una opción</option>
                                            @foreach($aseguradora as $tp)
                                                <option value="{{ $tp->id }}" @selected($tramite_info->aseguradora_id == $tp->id) >{{ strtoupper( $tp->nombre_aseguradora) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-lg-4">
                                        <label>Poliza</label>
                                        <div class="input-group">
                                            <input type="text" name="no_poliza" id="no_poliza" value="{{ $tramite_info->no_poliza }}"  class="form-control" required  onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <label>Cobertura</label>
                                        <select class="form-control" id="tipo_cobertura_id" name="tipo_cobertura_id"  required >
                                            <option value="">Selecciona una opción</option>
                                            @foreach($tipo_cobertura as $tp)
                                                <option value="{{ $tp->id }}" @selected($tramite_info->tipo_cobertura_id == $tp->id) >{{ strtoupper( $tp->tipo_cobertura) }}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                    <div class="col-lg-4">
                                        <label>Inciso</label>
                                        <div class="input-group">
                                            <input type="text" name="inciso" id="inciso"  class="form-control" value="{{ $tramite_info->inciso }}"  required  onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-lg-6">
                                        <label>Vigencia inicial del seguro </label>
                                        <div class="input-group">
                                            <input type="text" name="fecha_inicial_seguro" id="fecha_pago" value="{{ date('d/m/Y', strtotime($tramite_info->fecha_inicial_seguro))}}" class="form-control" required readonly />
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <label>Vigencia final del seguro </label>
                                        <div class="input-group">
                                            <input type="text" name="fecha_final_seguro" id="fecha_final" value="{{ date('d/m/Y', strtotime($tramite_info->fecha_final_seguro))}}" class="form-control" required readonly />
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <div class="col-lg-4">
                                        <label>Prima neta</label>
                                        <div class="input-group">
                                            <input type="text" name="prima_neta" id="prima_neta" value="{{ $tramite_info->prima_neta }}"  class="form-control" required />
                                        </div>
                                    </div>  

                                    <div class="col-lg-4">
                                        <label>Regargos</label>
                                        <div class="input-group">
                                            <input type="text" name="recargos" id="recargos" value="{{ $tramite_info->recargos }}"  class="form-control" required />
                                        </div>
                                    </div>  

                                    <div class="col-lg-4">
                                        <label>Gastos Exp.</label>
                                        <div class="input-group">
                                            <input type="text" name="gastos_exp" id="gastos_exp" value="{{ $tramite_info->gastos_exp }}"  class="form-control" required />
                                        </div>
                                    </div>
                                </div> 

                                <div class="form-group row">
                                    <div class="col-lg-4">
                                        <label>Sub total</label>
                                        <div class="input-group">
                                            <input type="text" name="sub_total" id="sub_total"  value="{{ $tramite_info->sub_total }}" class="form-control" required />
                                        </div>
                                    </div>  

                                    <div class="col-lg-4">
                                        <label>IVA</label>
                                        <div class="input-group">
                                            <input type="text" name="iva" id="iva"  value="{{ $tramite_info->iva }}" class="form-control" required />
                                        </div>
                                    </div>  

                                    <div class="col-lg-4">
                                        <label>Prima total</label>
                                        <div class="input-group">
                                            <input type="text" name="prima_total" id="prima_total"  value="{{ $tramite_info->prima_total }}" class="form-control" required />
                                        </div>
                                    </div>
                                </div>  
 
                                 <div class="form-group row">
                                    <div class="col-lg-6">
                                        <label>1er recibo</label>
                                        <div class="input-group">
                                            <input type="text" name="primer_recibo" id="primer_recibo" value="{{ $tramite_info->primer_recibo }}" class="form-control" required />
                                        </div>
                                    </div>  

                                    <div class="col-lg-6">
                                        <label>Recibos subsecuentes</label>
                                        <div class="input-group">
                                            <input type="text" name="recibos_sub" id="recibos_sub" value="{{ $tramite_info->recibos_sub }}" class="form-control" required />
                                        </div>
                                    </div>  

                                </div>  

                                <div class="form-group row">
                                    <div class="col-lg-12">
                                        <label for="observaciones">Observaciones</label>
                                        <textarea class="form-control" name="observaciones" id="observaciones" rows="3" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">{{ $tramite_info->observaciones }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade mt-10" id="kt_tab_pane_2" role="tabpanel" aria-labelledby="kt_tab_pane_2">

                                <div class="row form-group" >
                                    <div class="col-lg-12" id="tblArchivos">
                                        <table class="table table-hover mb-6 table-responsive-sm" id="tblDocumentos">
                                            <thead>
                                            <tr>
                                                <th scope="col">Documento</th>
                                                <th scope="col">Tipo de Documento</th>
                                                <th scope="col">Opción</th>
                                            </tr>
                                            </thead>
                                            <tbody id='tbodyDocumentos'>
                                                @foreach($tramite_evidencia as $documento)
                                                    <tr id="trDocumento{{ $documento->id }}">
                                                        <td>
                                                            <a href="{{ route('archivo.documentoPagoAseguramiento', ['id'=>$documento->id]) }}" class="link-primary" target="_blank"> {{ $documento->documento }} </a>
                                                        </td>
                                                        <td>{{ $documento->unidadTramiteAseguramientoEvidencia->nombre_evidencia }}</td>
                                                        <td>
                                                            <a href='#' class='btn btn-sm btn-clean btn-hover-icon-success btn-icon hrefEliminarDocumento' data-id='{{ $documento->id }}' data-documento='{{ $documento->documento }}'  data-toggle='tooltip' data-theme='dark' title='Eliminar'>
                                                                <i class='flaticon-delete'></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
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
                                <a href="{{ route('traveh.tvaseguramiento', $id_unidad) }}"  class="btn btn-secondary"><i class="la la-arrow-left"></i>Regresar</a>
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
