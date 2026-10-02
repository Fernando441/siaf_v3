@extends('layouts.app')
@section('title')
    Agregar Conversión
@endsection
@push('scripts')
    <script src="{{ asset('js/licitaciones/conversiones/listado.js') }}"></script>
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
                    <h3 class="card-title">Agregar Conversión</h3>
                </div>
                <!--begin::Form-->
                <form action="{{ route('conversiones.guardarDocumento') }}" method="post" id="frmConversion"
                    enctype="multipart/form-data">
                    <input type='hidden' id='requisicionGrupo' value='@json($requisicionGrupo)'>
                    <input type='hidden' name='requisicion_id' id='requisicion_id' value='{{ $requisicionId }}'>
                    <input type='hidden' id='eliminarDocumentoPath' value='{{ route('conversiones.eliminarDocumento') }}'>
                    @csrf
                    <div class="card-body">
                        @if (! $documentos->isEmpty())
                            
                        
                        <div class="row form-group">
                            <table class="table table-hover mb-6 table-responsive-sm" id="tblDocumentosCargados">
                                <thead>
                                    <tr>
                                        <th scope="col">Documento</th>
                                        <th scope="col">Tipo de Conversión</th>
                                        <th scope="col">Monto</th>
                                        <th scope="col">Fecha</th>
                                        <th scope="col">Opción</th>
                                    </tr>
                                </thead>
                                <tbody id='tbodyDocumentosCargados'>
                                    @foreach($documentos as $documento)
                                    <tr id="trDocumentoCargados{{ $documento->id }}">
                                        <td><a href="{{ route('archivo.requisicionConversion', ['id'=>$documento->id]) }}" class="link-primary" target="_blank"> {{ $documento->documento }} </a></td>
                                        <td>{{ $documento->requisicionGrupo->descripcion }}</td>
                                        <td>$ {{ number_format($documento->monto, 2) }}</td>
                                        <td>{{ \Carbon\Carbon::parse($documento->fecha)->format('d/m/Y')}}</td>
                                        <td>
                                            <a href='#' class='btn btn-sm btn-clean btn-hover-icon-success btn-icon hrefEliminarDocumentosCargados' data-id='{{ $documento->id }}' data-documento='{{ $documento->documento }}'  data-toggle='tooltip' data-theme='dark' title='Eliminar'>
                                                <i class='flaticon-delete'></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                    
                                </tbody>
                            </table>
                        </div>    
                        @endif

                        <div class="row form-group">


                            <div class="col-lg-12" id="tblArchivos">
                                <table class='table table-bordered table-hover' id='tblDocumentos'>
                                    <thead>
                                        <tr>
                                            <th>Adjuntar Documento</th>
                                            <th>Tipo de Conversión</th>
                                            <th>Monto</th>
                                            <th>Fecha</th>
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
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-lg-12">
                                <button type="button" id="btnGuardar"
                                    class="btn btn-success"><i class="la la-plus"></i>Guardar</button>
                                <a href="{{ route('finanzas.catalogorequisicion') }}"
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
