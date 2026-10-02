@extends('layouts.app')
@push('scripts')
	<script src="{{ asset('js/cliente/EditarCliente.js') }}"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
@endpush
@section('title')
    Ver asignación
@endsection
@section('content')
<!--begin::Card-->
<div class="row">
    <div class="col-lg-12">
        <!--begin::Card-->
        <div class="card card-custom gutter-b">
            <div class="card-header">
                <h3 class="card-title">Ver asignación</h3>
            </div>
            <!--begin::Form-->
            <input type="hidden" id="documentoEliminarPath" value="{{ route('asignarunidad.deleteasignacionlog') }}">
            
            <form class="form" action="{{ route('asignarunidad.editasignacionlog') }}" method="post" id="frmCliente" enctype="multipart/form-data">
                @csrf
                <input type='hidden' id='url_municipios' value='{{ route('cliente.obtenermunicipios') }}'>
                <input type='hidden' id='tipoArchivo' value='{{ $cadenaTipoDocumento }}'>
                <input type="hidden" name="id_asignacion" id="id_asignacion" value="{{ $asignacionLogistica->id }}">
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
                                        <label>Nombre de la asignación</label>
                                        <div class="input-group">
                                            <p>{{ $asignacionLogistica->nombre_asignacion }}</p>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <label>Dirección</label>
                                        <div class="input-group">
                                            <p>{{ $asignacionLogistica->direccion }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-6">
                                        <label>Subdirección</label>
                                        <div class="input-group">
                                            <p>{{ $asignacionLogistica->sub_direccion }}</p>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <label>Coordinación</label>
                                        <div class="input-group">
                                            <p>{{ $asignacionLogistica->coordinacion }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-4">
                                        <label>Area</label>
                                        <div class="input-group">
                                            <p>{{ $asignacionLogistica->area }}</p>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <label>Partida</label>
                                        <div class="input-group">
                                            <p>{{ $asignacionLogistica->partida }}</p>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <label>Población</label>
                                        <div class="input-group">
                                            <p>{{ $asignacionLogistica->poblacion }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-5">
                                        <label>Estado</label>
                                        @foreach($estados as $estado)
                                            @if($asignacionLogistica->id_estado == $estado->id_estado)
                                                <p>{{ $estado->estado_nombre }}</p>
                                            @endif
                                        @endforeach
                                    </div>
                                    <div class="col-lg-5">
                                        <label>Municipio y/o Alcaldía.</label>
                                         @foreach($municipios as $municipio)
                                            @if($asignacionLogistica->id_municipio == $municipio->id_municipio)
                                                <p>{{ $municipio->municipio_nombre }}</p>
                                            @endif
                                        @endforeach
                                    </div>
                                    <div class="col-lg-2">
                                        <label>CP</label>
                                        <div class="input-group">
                                            <p>{{ $asignacionLogistica->cp }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-lg-6">
                                        <label>Calle</label>
                                        <div class="input-group">
                                            <p>{{ $asignacionLogistica->calle }}</p>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <label>Contacto</label>
                                        <div class="input-group">
                                            <p>{{ $asignacionLogistica->contacto }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label>Observaciones</label>
                                    <p>{{ $asignacionLogistica->observaciones }}</p>
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
                                    @foreach($doc_asignacion as $documento)
                                        <tr id="trDocumento{{ $documento->id }}">
                                            <td>
                                                <a href="{{ route('archivo.documentoasignacionlog', ['id'=>$documento->id]) }}" class="link-primary" target="_blank"> {{ $documento->asignacionTipoDocumento->nombre_documento }} </a>
                                            </td>
                                            <td>{{ $documento->asignacionTipoDocumento->nombre_documento }}</td>

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
                            <a href="{{ route('asignarunidad.asignacioncontratos') }}"  class="btn btn-secondary"><i class="la la-arrow-left"></i>Regresar</a>
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
