@extends('layouts.app')
@push('scripts')
	<script src="{{ asset('js/cliente/EditarCliente.js') }}"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
@endpush
@section('title')
    Editar cliente
@endsection
@section('content')
<!--begin::Card-->
<div class="row">
    <div class="col-lg-12">
        <!--begin::Card-->
        <div class="card card-custom gutter-b">
            <div class="card-header">
                <h3 class="card-title">Editar cliente</h3>
            </div>
            <!--begin::Form-->
            <input type="hidden" id="documentoEliminarPath" value="{{ route('cliente.eliminardocumentocliente') }}">
            
            <form class="form" action="{{ route('cliente.editarCliente') }}" method="post" id="frmCliente" enctype="multipart/form-data">
                @csrf
                <input type='hidden' id='url_municipios' value='{{ route('cliente.obtenermunicipios') }}'>
                <input type='hidden' id='tipoArchivo' value='{{ $cadenaTipoDocumento }}'>
                <input type="hidden" name="id_cliente" id="id_cliente" value="{{ $cliente->id_cliente }}">
                <div class="card-body">
                    <!--begin::tabs-->
                    <ul class="nav nav-tabs nav-tabs-line">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#kt_tab_pane_1">Información del Cliente</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#kt_tab_pane_2">Archivos</a>
                        </li>
                    </ul>
                    <div class="tab-content mt-5" id="myTabContent">
                        <div class="tab-pane fade show active mt-10" id="kt_tab_pane_1" role="tabpanel" aria-labelledby="kt_tab_pane_2">
                            <div class="form-group row">
                                <div class="col-lg-6">
                                    <label>RFC</label>
                                    <div class="input-group">
                                        <input type="text" name="rfc" id="rfc"  class="form-control specialCharts" value="{{ $cliente->rfc }}" required onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <label>Razon Social</label>
                                    <div class="input-group">
                                        <input type="text" name="razon_social" id="razon_social"  class="form-control specialCharts" value="{{ $cliente->razon_social }}" required onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-6">
                                    <label>Alias</label>
                                    <div class="input-group">
                                        <input type="text" name="alias" id="alias"  class="form-control specialCharts" value="{{ $cliente->alias }}" required onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <label>Calle y Número (Domicilio Fiscal)</label>
                                    <div class="input-group">
                                        <input type="text" name="calle_numero" id="calle_numero" class="form-control specialCharts" value="{{ $cliente->calle_numero }}" required onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-6">
                                    <label>Colonia / Delegación</label>
                                    <div class="input-group">
                                        <input type="text" name="colonia" id="colonia"  class="form-control specialCharts" value="{{ $cliente->colonia }}" required onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <label>Codigo Postal</label>
                                    <div class="input-group">
                                        <input type="text" name="codigo_postal" id="codigo_postal"  class="form-control specialCharts" value="{{ $cliente->codigo_postal }}" required onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-6">
                                    <label>Estado</label>
                                    <select class="form-control" id="id_estado" name="id_estado"  required >
                                        <option value="">Selecciona una opción</option>
                                        @foreach($estados as $estado)
                                            <option value="{{ $estado->id_estado }}" @selected($cliente->id_estado == $estado->id_estado) >{{ $estado->estado_nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-6">
                                    <label>Municipio y/o Alcaldía.</label>
                                    <select class="form-control" id="id_municipio" name="id_municipio"  required  >
                                        <option value="">Selecciona una opción</option>
                                        @foreach($municipios as $municipio)
                                            <option value="{{ $municipio->id_municipio }}" @selected($cliente->id_municipio == $municipio->id_municipio) >{{ $municipio->municipio_nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>

                                <div class="form-group row">
                                    <div class="col-lg-6">
                                        <label>Cédula fiscal</label>
                                        <div class="input-group">
                                            <input type="text" name="cedula_fiscal" id="cedula_fiscal" value="{{ $cliente->cedula_fiscal }}"  class="form-control" required onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                        </div>
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
                                    @foreach($documentos as $documento)
                                        <tr id="trDocumento{{ $documento->id }}">
                                            <td><a href="{{ route('archivo.documentoCliente', ['id'=>$documento->id]) }}" class="link-primary" target="_blank"> {{ $documento->clienteTipoDocumento->tipo }} </a></td>
                                            <td>{{ $documento->clienteTipoDocumento->tipo }}</td>
                                            <td>
                                                <a href='#' class='btn btn-sm btn-clean btn-hover-icon-success btn-icon hrefEliminarDocumento' data-id='{{ $documento->id }}' data-documento='{{ $documento->documento }}'  data-toggle='tooltip' data-theme='dark' title='Eliminar'>
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
                            <a href="{{ route('cliente.catalogoCliente') }}"  class="btn btn-secondary"><i class="la la-arrow-left"></i>Regresar</a>
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
