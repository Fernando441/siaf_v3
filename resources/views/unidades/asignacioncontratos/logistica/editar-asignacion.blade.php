@extends('layouts.app')
@push('scripts')
	<script src="{{ asset('js/cliente/EditarCliente.js') }}"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
@endpush
@section('title')
    Editar asignación
@endsection
@section('content')
<!--begin::Card-->

<style type="text/css">
    .oculto{display: none;}
</style>

<div class="row">
    <div class="col-lg-12">
        <!--begin::Card-->
        <div class="card card-custom gutter-b">
            <div class="card-header">
                <h3 class="card-title">Editar asignación</h3>
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
                            <a class="nav-link active" data-toggle="tab" href="#kt_tab_pane_1">Información de la asignación</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#kt_tab_pane_2">Archivos</a>
                        </li>
                    </ul>
                    <div class="tab-content mt-5" id="myTabContent">
                        <div class="tab-pane fade show active mt-10" id="kt_tab_pane_1" role="tabpanel" aria-labelledby="kt_tab_pane_2">

                                <div class="form-group row">

                                    <div class="col-lg-4">
                                        <label>Asignación</label>
                                        <div class="radio-inline">
                                            <label class="radio">
                                                <input type="radio" {{($asignacionLogistica->tipo_asignacion == '0') ? 'checked' : ''}} name="tipo_asignacion" value="0" id="tp1"/>
                                                <span></span>
                                                Proyecto
                                            </label>
                                            <label class="radio">
                                                <input type="radio" {{($asignacionLogistica->tipo_asignacion == '1') ? 'checked' : ''}} name="tipo_asignacion" value="1" id="tp2"/>
                                                <span></span>
                                                Patio
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-lg-8 {{($asignacionLogistica->tipo_asignacion == '1') ? 'oculto' : ''}}" id="div_proyecto">
                                        <label>Contrato</label>
                                        <select class="form-control" id="id_proyecto" name="id_proyecto"  >
                                            <option value="">Selecciona una opción</option>

                                            @foreach($proyecto as $estado)
                                                <option value="{{ $estado->id }}" @selected($asignacionLogistica->id_proyectos == $estado->id) >Titulo servicio: {{ $estado->titulo_servicio }} - No. Contrato: {{ $estado->no_contrato }} - No. convenio: {{ $estado->no_convenio }}</option>
                                            @endforeach

                                        </select>
                                    </div>

                                    <div class="col-lg-8 {{($asignacionLogistica->tipo_asignacion == '0') ? 'oculto' : ''}}" id="div_patio">
                                        <label>Patio</label>
                                        <select class="form-control" id="id_patio" name="id_patio"  >
                                            <option value="">Selecciona una opción</option>

                                            @foreach($ubicacion as $estado)
                                                <option value="{{ $estado->id }}" @selected($asignacionLogistica->id_patio == $estado->id) >{{ $estado->ubicacion }} - {{ $estado->codigo }}</option>
                                            @endforeach

                                        </select>
                                    </div>

                                </div>

                                <div class="form-group row">
                                    <div class="col-lg-6">
                                        <label>Nombre de la asignación</label>
                                        <div class="input-group">
                                            <input type="text" name="nombre_asignacion" id="nombre_asignacion" value="{{ $asignacionLogistica->nombre_asignacion }}"  class="form-control specialCharts" required onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <label>Dirección</label>
                                        <div class="input-group">
                                            <input type="text" name="direccion" id="direccion" value="{{ $asignacionLogistica->direccion }}"  class="form-control specialCharts"  onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-6">
                                        <label>Subdirección</label>
                                        <div class="input-group">
                                            <input type="text" name="subdireccion" id="subdireccion" value="{{ $asignacionLogistica->sub_direccion }}"  class="form-control specialCharts"  onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <label>Coordinación</label>
                                        <div class="input-group">
                                            <input type="text" name="coordinacion" id="coordinacion" value="{{ $asignacionLogistica->coordinacion }}" class="form-control specialCharts"  onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-4">
                                        <label>Area</label>
                                        <div class="input-group">
                                            <input type="text" name="area" id="area" value="{{ $asignacionLogistica->area }}"  class="form-control specialCharts"  onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <label>Partida</label>
                                        <div class="input-group">
                                            <input type="text" name="partida" id="partida" value="{{ $asignacionLogistica->partida }}"  class="form-control specialCharts"  onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <label>Población</label>
                                        <div class="input-group">
                                            <input type="text" name="poblacion" id="poblacion" value="{{ $asignacionLogistica->poblacion }}"  class="form-control specialCharts"  onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-5">
                                        <label>Estado</label>
                                        <select class="form-control" id="id_estado" name="id_estado"  required >
                                            <option value="">Selecciona una opción</option>
                                            @foreach($estados as $estado)
                                                <option value="{{ $estado->id_estado }}" @selected($asignacionLogistica->id_estado == $estado->id_estado) >{{ $estado->estado_nombre }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-5">
                                        <label>Municipio y/o Alcaldía.</label>
                                        <select class="form-control" id="id_municipio" name="id_municipio"  required  >
                                            <option value="">Selecciona una opción</option>
                                            @foreach($municipios as $municipio)
                                                <option value="{{ $municipio->id_municipio }}" @selected($asignacionLogistica->id_municipio == $municipio->id_municipio) >{{ $municipio->municipio_nombre }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-2">
                                        <label>CP</label>
                                        <div class="input-group">
                                            <input type="text" name="cp" id="cp" value="{{ $asignacionLogistica->cp }}" class="form-control specialCharts"  onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-lg-6">
                                        <label>Calle</label>
                                        <div class="input-group">
                                            <input type="text" name="calle" id="calle" value="{{ $asignacionLogistica->calle }}"  class="form-control specialCharts"  onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <label>Contacto</label>
                                        <div class="input-group">
                                            <input type="text" name="contacto" id="contacto" value="{{ $asignacionLogistica->contacto }}"  class="form-control"  onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label>Observaciones</label>
                                    <textarea class="form-control specialCharts" name="observaciones" id="observaciones"
                                        onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">{{ $asignacionLogistica->observaciones }}</textarea>
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
                                    @foreach($doc_asignacion as $documento)
                                        <tr id="trDocumento{{ $documento->id }}">
                                            <td>
                                                <a href="{{ route('archivo.documentoasignacionlog', ['id'=>$documento->id]) }}" class="link-primary" target="_blank"> {{ $documento->asignacionTipoDocumento->nombre_documento }} </a>
                                            </td>
                                            <td>{{ $documento->asignacionTipoDocumento->nombre_documento }}</td>
                                            <td>
                                                <a href='#' class='btn btn-sm btn-clean btn-hover-icon-success btn-icon hrefEliminarDocumento' data-id='{{ $documento->id }}' data-documento='{{ $documento->asignacionTipoDocumento->nombre_documento }}'  data-toggle='tooltip' data-theme='dark' title='Eliminar'>
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
