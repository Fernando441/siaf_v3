@extends('layouts.app')

@section('title')
    Ver Cliente
@endsection
@section('content')
<!--begin::Card-->
<div class="row">
    <div class="col-lg-12">
        <!--begin::Card-->
        <div class="card card-custom gutter-b">
            <div class="card-header">
                <h3 class="card-title">Ver Cliente</h3>
            </div>
            <!--begin::Form-->
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
                                        <p>{{ $cliente->rfc }}</p>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <label>Razon Social</label>
                                    <div class="input-group">
                                        <p>{{ $cliente->razon_social }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-6">
                                    <label>Alias</label>
                                    <div class="input-group">
                                        <p>{{ $cliente->alias }}</p>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <label>Calle y Número</label>
                                    <div class="input-group">
                                        <p>{{ $cliente->calle_numero }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-6">
                                    <label>Colonia</label>
                                    <div class="input-group">
                                        <p>{{ $cliente->colonia }}</p>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <label>Codigo Postal</label>
                                    <div class="input-group">
                                        <p>{{ $cliente->codigo_postal }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-6">
                                    <label>Municipio</label>
                                     @foreach($municipios as $municipio)
                                        @if($cliente->id_municipio == $municipio->id_municipio)
                                            <p>{{ $municipio->municipio_nombre }}</p>
                                        @endif
                                    @endforeach
                                </div>
                                <div class="col-lg-6">
                                    <label>Estado</label>
                                    @foreach($estados as $estado)
                                        @if($cliente->id_estado == $estado->id_estado)
                                            <p>{{ $estado->estado_nombre }}</p>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-lg-6">
                                    <label>Cédula fiscal</label>
                                    <div class="input-group">
                                        <p>{{ $cliente->cedula_fiscal }}</p>
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
                                </tr>
                                </thead>
                                <tbody id='tbodyDocumentos'>
                                    @foreach($documentos as $documento)
                                        <tr id="trDocumento{{ $documento->id }}">
                                            <td><a href="{{ route('archivo.documentoCliente', ['id'=>$documento->id]) }}" class="link-primary" target="_blank"> {{ $documento->clienteTipoDocumento->tipo }} </a></td>
                                            <td>{{ $documento->clienteTipoDocumento->tipo }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!--end::tabs-->

                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-lg-6">
                            <a href="{{ route('cliente.catalogoCliente') }}"  class="btn btn-secondary"><i class="la la-arrow-left"></i>Regresar</a>
                        </div>
                    </div>
                </div>

            <!--end::Form-->
        </div>
        <!--end::Card-->
    </div>
</div>
<!--end::Card-->


@endsection
