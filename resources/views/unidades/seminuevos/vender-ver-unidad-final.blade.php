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
                    <h3 class="card-title">Ver Unidad</h3>
                </div>

                <form class="form" action="{{ route('seminuevos.ventaFinalGuardar') }}" method="post" id="vender_unidad">
                    @csrf
                    <input type="hidden" name="unidad_id" value="{{ $unidad->id }}">
                    <input type="hidden" name="opcion_guardar" id="opcion_guardar"  value="">
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
                                @include('unidades.seminuevos.vender-ver-informacion-basica-final')
                            </div>
                        
                            
                            <div class="tab-pane fade mt-10" id="kt_tab_pane_2" role="tabpanel" aria-labelledby="kt_tab_pane_2">

                                <div class="row form-group" >
                                    <div class="col-lg-12" id="tblArchivos">

                                        @isset($seminuevosDocumentos)
                                            
                                        
                                        <table class="table table-hover mb-6 table-responsive-sm" id="tblDocumentosCargados">
                                            <thead>
                                            <tr>
                                                <th scope="col">Documento</th>
                                                <th scope="col">Tipo de Documento</th>
                                            </tr>
                                            </thead>
                                            <tbody id='tbodyDocumentosCargados'>
                                                @foreach($seminuevosDocumentos as $documento)
                                                    <tr id="trDocumentoCargados{{ $documento->id }}">
                                                        <td><a href="{{ route('archivo.seminuevosDocumento', ['id'=>$documento->id]) }}" class="link-primary" target="_blank"> {{ $documento->documento }} </a></td>
                                                        <td>{{ $documento->descripcion }}</td>
                                                        
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        @endisset
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade mt-10" id="kt_tab_pane_3" role="tabpanel" aria-labelledby="kt_tab_pane_3">
                                @if(!isset($seminuevosApartado) || !$seminuevosApartado)
                                    <div class="alert alert-light" role="alert">
                                        La unidad no tiene un apartado relacionado.
                                    </div>
                                @else
                                    <div class="form-group row fv-plugins-icon-container">
                                        <div class="col-lg-6">
                                            <label>Fechaxx</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control specialCharts" value="{{ isset($apartadoFacturacion) && $apartadoFacturacion->fecha ? \Carbon\Carbon::parse($apartadoFacturacion->fecha)->format('d/m/Y') : '' }}" disabled>
                                            </div>
                                        <div class="fv-plugins-message-container"></div></div>

                                        <div class="col-lg-6">
                                            <label>Nombre del Asesor</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control specialCharts" value="{{ $apartadoFacturacion->nombre_asesor ?? '' }}" disabled>
                                            </div>
                                        <div class="fv-plugins-message-container"></div></div>
                                    </div>

                                    <div class="form-group row fv-plugins-icon-container">
                                        <div class="col-lg-6">
                                            <label>Nombre del Cliente</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control specialCharts" value="{{ $apartadoFacturacion->nombre_cliente ?? '' }}" disabled>
                                            </div>
                                        <div class="fv-plugins-message-container"></div></div>

                                        <div class="col-lg-6">
                                            <label>RFC</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control specialCharts" value="{{ $apartadoFacturacion->rfc ?? '' }}" disabled>
                                            </div>
                                        <div class="fv-plugins-message-container"></div></div>
                                    </div>

                                    <div class="form-group row fv-plugins-icon-container">
                                        <div class="col-lg-6">
                                            <label>Correo Electrónico</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control specialCharts" value="{{ $apartadoFacturacion->correo_electronico ?? '' }}" disabled>
                                            </div>
                                        <div class="fv-plugins-message-container"></div></div>

                                        <div class="col-lg-6">
                                            <label>Número de Teléfono</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control specialCharts" value="{{ $apartadoFacturacion->numero_telefono ?? '' }}" disabled>
                                            </div>
                                        <div class="fv-plugins-message-container"></div></div>
                                    </div>

                                    <div class="form-group row fv-plugins-icon-container">
                                        <div class="col-lg-12">
                                            <label>Dirección Completa</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control specialCharts" value="{{ $apartadoFacturacion->direccion_completa ?? '' }}" disabled>
                                            </div>
                                        <div class="fv-plugins-message-container"></div></div>
                                    </div>

                                    <div class="form-group row fv-plugins-icon-container">
                                        <div class="col-lg-6">
                                            <label>Forma de pago</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control specialCharts" value="{{ $apartadoFacturacion->forma_pago ?? '' }}" disabled>
                                            </div>
                                        <div class="fv-plugins-message-container"></div></div>

                                        <div class="col-lg-6">
                                            <label>Uso de CFDI</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control specialCharts" value="{{ $apartadoFacturacion->uso_cfdi ?? '' }}" disabled>
                                            </div>
                                        <div class="fv-plugins-message-container"></div></div>
                                    </div>

                                    <div class="form-group row fv-plugins-icon-container">
                                        <div class="col-lg-6">
                                            <label>Unidad de medida</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control specialCharts" value="{{ $apartadoFacturacion->unidad_medida ?? '' }}" disabled>
                                            </div>
                                        <div class="fv-plugins-message-container"></div></div>

                                        <div class="col-lg-6">
                                            <label>Clave del producto</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control specialCharts" value="{{ $apartadoFacturacion->clave_producto ?? '' }}" disabled>
                                            </div>
                                        <div class="fv-plugins-message-container"></div></div>
                                    </div>

                                    <div class="form-group row fv-plugins-icon-container">
                                        <div class="col-lg-6">
                                            <label>Importe a facturar</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control specialCharts" value="{{ isset($apartadoFacturacion) && $apartadoFacturacion->importe_facturar !== null ? '$ ' . number_format((float) $apartadoFacturacion->importe_facturar, 2) : '' }}" disabled>
                                            </div>
                                        <div class="fv-plugins-message-container"></div></div>
                                    </div>
                                @endif
                            </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <a href="{{ route('seminuevos.catalogoUnidadVenta') }}"  class="btn btn-secondary"><i class="la la-arrow-left"></i>Regresar</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>


 {{-- V E N D E R    U N I D A D --}}



@endsection
