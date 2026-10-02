@extends('layouts.app')
@push('scripts')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <script src="{{ asset('js/taller/CargarEvidenciasMantenimiento.js') }}" type="text/javascript"></script>
@endpush
@section('title')
    Evidencias del mantenimiento
@endsection
@section('content')

    <!--begin::Card-->
    <div class="row">
        <div class="col-lg-12">
            <!--begin::Card-->
            <div class="card card-custom gutter-b">
                <div class="card-header">
                    <h3 class="card-title">Evidencias del mantenimiento</h3>
                        <div class="card-toolbar">
                            <h4>Total: ${{ $solicitud->importe_total }}</h4>
                        </div>
                </div>
                
                <!--begin::Form-->
                <input type="hidden" id="documentoEliminarPath" value="{{ route('mantenimientosfin.deletepagomantenimiento') }}">
                
                <form class="form" action="{{ route('mantenimientosfin.pagomantenimiento') }}" method="post" id="frmCliente" enctype="multipart/form-data">
                    @csrf  
                    <input type="hidden" name="id_solicitud" value="{{ $id }}"> 
                    {{-- <input type='hidden' id='url_municipios' value='{{ route('cliente.obtenermunicipios') }}'> --}}
                    {{-- <input type='hidden' id='tipoArchivo' value='{{ $cadenaTipoDocumento }}'> --}}
                    <div class="card-body">
                        <!--begin::tabs-->
                        <ul class="nav nav-tabs nav-tabs-line">
                            {{-- <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#kt_tab_pane_1">Información del Cliente</a>
                            </li> --}}
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#kt_tab_pane_2">Evidencias</a>
                            </li>
                        </ul>
                        <div class="tab-content mt-5" id="myTabContent">

                            <div class="tab-pane  mt-10 active" id="kt_tab_pane_2" role="tabpanel" aria-labelledby="kt_tab_pane_2">

                                <div class="row form-group" >
                                    <div class="col-lg-12" id="tblArchivos">
                                        <table class='table table-bordered table-hover' id='tblDocumentos'>
                                            <thead>
                                            <tr>
                                                <th>Adjuntar Documento</th>
                                                <th>Tipo de Documento</th>
                                                <th>Importe</th>
                                                <th>Comentarios</th>
                                                <th>Opción</th>
                                            </tr>
                                            </thead>

                                            <tbody id='tbodyDocumentos'>
                                                @foreach($pago_finanzas as $documento)
                                                    <tr id="trDocumento{{ $documento->id }}">
                                                        <td>
                                                            <a href="{{ route('archivo.documentoMantenimientoFin', ['id'=>$documento->id]) }}" class="link-primary" target="_blank"> {{ $documento->tipo_documento }} </a>
                                                        </td>
                                                        <td>{{ $documento->tipo_documento }}</td>
                                                        <td>{{ $documento->importe }}</td>
                                                        <td>{{ $documento->observaciones }}</td>
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
                                <a href="{{ route('mantenimientosfin.listadomantenimientfinanzas') }}"  class="btn btn-secondary"><i class="la la-arrow-left"></i>Regresar</a>
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
