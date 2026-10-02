@extends('layouts.app')
@section('title')
    Vender Unidad
@endsection
@push('scripts')
    <script src="{{ asset('js/unidades/seminuevos/VenderUnidadFinal.js') }}"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
@endpush

@section('content')
<style type="text/css">
    .oculto{
        display: none;
    }
</style>
 {{-- V E N T A    U N I D A D --}}
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-custom gutter-b">
                <div class="card-header">
                    <h3 class="card-title">Vender Unidad</h3>
                </div>

                <form class="form" action="{{ route('seminuevos.ventaFinalGuardar') }}" method="post" id="vender_unidad" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="unidad_id" value="{{ $unidad->id }}">
                    <input type="hidden" name="opcion_guardar" id="opcion_guardar"  value="">
                    <input type="hidden" name="eliminarDocumentoPath" id="eliminarDocumentoPath"  value="{{ route('seminuevos.eliminarDocumento') }}">
                    <div class="card-body">
                        <ul class="nav nav-tabs nav-tabs-line">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#kt_tab_pane_1">Información de la Unidad</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#kt_tab_pane_2">Archivos</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#kt_tab_pane_3">Pedido de Unidades</a>
                            </li>
                        </ul>
                        <div class="tab-content mt-5" id="myTabContent">
                            <div class="tab-pane fade show active mt-10" id="kt_tab_pane_1" role="tabpanel" aria-labelledby="kt_tab_pane_1">
                                @include('unidades.seminuevos.vender-informacion-basica-final')
                            </div>
                            <div class="tab-pane fade mt-10" id="kt_tab_pane_2" role="tabpanel" aria-labelledby="kt_tab_pane_2">

                                <div class="row form-group" >
                                    <div class="col-lg-12" id="tblArchivos">

                                        {{-- seminuevosDocumentos --}}

                                        @isset($seminuevosDocumentos)
                                            
                                        
                                        <table class="table table-hover mb-6 table-responsive-sm" id="tblDocumentosCargados">
                                            <thead>
                                            <tr>
                                                <th scope="col">Documento</th>
                                                <th scope="col">Tipo de Documento</th>
                                                <th scope="col">Opción</th>
                                            </tr>
                                            </thead>
                                            <tbody id='tbodyDocumentosCargados'>
                                                @foreach($seminuevosDocumentos as $documento)
                                                    <tr id="trDocumentoCargados{{ $documento->id }}">
                                                        <td><a href="{{ route('archivo.seminuevosDocumento', ['id'=>$documento->id]) }}" class="link-primary" target="_blank"> {{ $documento->documento }} </a></td>
                                                        <td>{{ $documento->descripcion }}</td>
                                                        <td>
                                                            <a href='#' class='btn btn-sm btn-clean btn-hover-icon-success btn-icon hrefEliminarDocumentosCargados' data-id='{{ $documento->id }}' data-documento='{{ $documento->documento }}'  data-toggle='tooltip' data-theme='dark' title='Eliminar'>
                                                                <i class='flaticon-delete'></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        @endisset

                                        <table class='table table-bordered table-hover' id='tblDocumentos'>
                                            <thead>
                                            <tr>
                                                <th>Adjuntar Documento</th>
                                                <th>Descripción del Documento</th>
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

                            <div class="tab-pane fade mt-10" id="kt_tab_pane_3" role="tabpanel" aria-labelledby="kt_tab_pane_3">
                                <input type="hidden" name="pedido_id_seminuevos_apartado" id="pedido_id_seminuevos_apartado" value="{{ $seminuevosApartado->id ?? '' }}">

                                @if(!isset($seminuevosApartado) || !$seminuevosApartado)
                                    <div class="alert alert-light" role="alert">
                                        La unidad no tiene un apartado relacionado. Para capturar pedido, primero debe estar en apartado.
                                    </div>
                                @endif

                                <div class="form-group row fv-plugins-icon-container">
                                    <div class="col-lg-6">
                                        <label>Fecha</label>
                                        <div class="input-group">
                                            <input type="text" name="pedido_fecha" id="pedido_fecha" class="form-control specialCharts" placeholder="dd/mm/aa" value="{{ isset($apartadoFacturacion) && $apartadoFacturacion->fecha ? \Carbon\Carbon::parse($apartadoFacturacion->fecha)->format('d/m/Y') : '' }}">
                                        </div>
                                    <div class="fv-plugins-message-container"></div></div>

                                    <div class="col-lg-6">
                                        <label>Nombre del Asesor</label>
                                        <div class="input-group">
                                            <input type="text" name="pedido_nombre_asesor" id="pedido_nombre_asesor" class="form-control specialCharts" value="{{ $apartadoFacturacion->nombre_asesor ?? '' }}" onkeyup="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
                                        </div>
                                    <div class="fv-plugins-message-container"></div></div>
                                </div>

                                <div class="form-group row fv-plugins-icon-container">
                                    <div class="col-lg-6">
                                        <label>Nombre del Cliente</label>
                                        <div class="input-group">
                                            <input type="text" name="pedido_nombre_cliente" id="pedido_nombre_cliente" class="form-control specialCharts" value="{{ $apartadoFacturacion->nombre_cliente ?? '' }}" onkeyup="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
                                        </div>
                                    <div class="fv-plugins-message-container"></div></div>

                                    <div class="col-lg-6">
                                        <label>RFC</label>
                                        <div class="input-group">
                                            <input type="text" name="pedido_rfc" id="pedido_rfc" class="form-control specialCharts" value="{{ $apartadoFacturacion->rfc ?? '' }}" onkeyup="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
                                        </div>
                                    <div class="fv-plugins-message-container"></div></div>
                                </div>

                                <div class="form-group row fv-plugins-icon-container">
                                    <div class="col-lg-6">
                                        <label>Correo Electrónico</label>
                                        <div class="input-group">
                                            <input type="email" name="pedido_correo_electronico" id="pedido_correo_electronico" class="form-control specialCharts" value="{{ $apartadoFacturacion->correo_electronico ?? '' }}">
                                        </div>
                                    <div class="fv-plugins-message-container"></div></div>

                                    <div class="col-lg-6">
                                        <label>Número de Teléfono</label>
                                        <div class="input-group">
                                            <input type="text" name="pedido_numero_telefono" id="pedido_numero_telefono" class="form-control specialCharts" maxlength="20" value="{{ $apartadoFacturacion->numero_telefono ?? '' }}" onkeyup="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
                                        </div>
                                    <div class="fv-plugins-message-container"></div></div>
                                </div>

                                <div class="form-group row fv-plugins-icon-container">
                                    <div class="col-lg-12">
                                        <label>Dirección Completa</label>
                                        <div class="input-group">
                                            <input type="text" name="pedido_direccion_completa" id="pedido_direccion_completa" class="form-control specialCharts" value="{{ $apartadoFacturacion->direccion_completa ?? '' }}" onkeyup="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
                                        </div>
                                    <div class="fv-plugins-message-container"></div></div>
                                </div>

                                <div class="form-group row fv-plugins-icon-container">
                                    <div class="col-lg-6">
                                        <label>Forma de pago</label>
                                        <div class="input-group">
                                            <input type="text" name="pedido_forma_pago" id="pedido_forma_pago" class="form-control specialCharts" value="{{ $apartadoFacturacion->forma_pago ?? '' }}" onkeyup="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
                                        </div>
                                    <div class="fv-plugins-message-container"></div></div>

                                    <div class="col-lg-6">
                                        <label>Uso de CFDI</label>
                                        <div class="input-group">
                                            <input type="text" name="pedido_uso_cfdi" id="pedido_uso_cfdi" class="form-control specialCharts" value="{{ $apartadoFacturacion->uso_cfdi ?? '' }}" onkeyup="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
                                        </div>
                                    <div class="fv-plugins-message-container"></div></div>
                                </div>

                                <div class="form-group row fv-plugins-icon-container">
                                    <div class="col-lg-6">
                                        <label>Unidad de medida</label>
                                        <div class="input-group">
                                            <input type="text" name="pedido_unidad_medida" id="pedido_unidad_medida" class="form-control specialCharts" value="{{ $apartadoFacturacion->unidad_medida ?? '' }}" onkeyup="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
                                        </div>
                                    <div class="fv-plugins-message-container"></div></div>

                                    <div class="col-lg-6">
                                        <label>Clave del producto</label>
                                        <div class="input-group">
                                            <input type="text" name="pedido_clave_producto" id="pedido_clave_producto" class="form-control specialCharts" value="{{ $apartadoFacturacion->clave_producto ?? '' }}" onkeyup="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
                                        </div>
                                    <div class="fv-plugins-message-container"></div></div>
                                </div>

                                <div class="form-group row fv-plugins-icon-container">
                                    <div class="col-lg-6">
                                        <label>Importe a facturar</label>
                                        <div class="input-group">
                                            <input type="number" name="pedido_importe_facturar" id="pedido_importe_facturar" class="form-control specialCharts" min="0" step="0.01" value="{{ $apartadoFacturacion->importe_facturar ?? '' }}">
                                        </div>
                                    <div class="fv-plugins-message-container"></div></div>
                                </div>
                            </div>
                        </div>



                        
                        <div class="alert alert-light" role="alert">
                            Al dar clic sobre el botón Vender Unidad, la unidad cambiará a estatus vendida.
                        </div>
                        <div class="card-footer px-0" style="padding-bottom: 0px;">
                            <div class="row">
                                <div class="col-lg-6">
                                    <button type="button"  id="btnVender" class="btn btn-success"><i class="la la-money"></i>Vender Unidad</button>
                                    <button type="button"  id="btnGuardar" class="btn btn-primary"><i class="la la-plus"></i>Guardar y Continuar</button>
                                    <a href="{{ route('seminuevos.catalogoUnidadVenta') }}"  class="btn btn-secondary"><i class="la la-arrow-left"></i>Regresar</a>
                                </div>

                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>


 {{-- V E N D E R    U N I D A D --}}



@endsection
