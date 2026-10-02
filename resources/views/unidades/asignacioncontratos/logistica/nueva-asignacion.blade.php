@extends('layouts.app')
@push('scripts')
	<script src="{{ asset('js/unidades/AgregarAsignacion.js') }}"></script>
@endpush
@section('title')
    Agregar asignación
@endsection
@section('content')
<style type="text/css">
    .oculto{
        display: none;
    }
</style>
    <!--begin::Card-->
    <div class="row">
        <div class="col-lg-12">
            <!--begin::Card-->
            <div class="card card-custom gutter-b">
                <div class="card-header">
                    <h3 class="card-title">Agregar asignación</h3>
                </div>
                
                <!--begin::Form-->
                <form class="form" action="{{ route('asignarunidad.addasignacionlog') }}" method="post" id="frmCliente" enctype="multipart/form-data">
                    @csrf   
                    <input type='hidden' id='url_municipios' value='{{ route('cliente.obtenermunicipios') }}'>
                    <input type='hidden' id='tipoArchivo' value='{{ $cadenaTipoDocumento }}'>
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
                            <div class="tab-pane fade show active mt-10" id="kt_tab_pane_1" role="tabpanel" aria-labelledby="kt_tab_pane_1">
                                <div class="form-group row">

                                    <div class="col-lg-4">
                                        <label>Asignación</label>
                                        <div class="radio-inline">
                                            <label class="radio">
                                                <input type="radio" checked name="tipo_asignacion" value="0" id="tp1"/>
                                                <span></span>
                                                Contrato
                                            </label>
                                            <label class="radio">
                                                <input type="radio" name="tipo_asignacion" value="1" id="tp2"/>
                                                <span></span>
                                                Patio
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-lg-8" id="div_proyecto">
                                        <label>Proyecto</label>
                                        <select class="form-control" id="id_proyecto" name="id_proyecto"  required >
                                            <option value="">Selecciona una opción</option>
                                            @foreach($proyecto as $estado)
                                                <option value="{{ $estado->id }}" >Titulo servicio: {{ $estado->titulo_servicio }} - No. Contrato: {{ $estado->no_contrato }} - No. convenio: {{ $estado->no_convenio }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-lg-8 oculto" id="div_patio">
                                        <label>Patio</label>
                                        <select class="form-control" id="id_patio" name="id_patio"  required >
                                            <option value="">Selecciona una opción</option>
                                            @foreach($ubicacion as $estado)
                                                <option value="{{ $estado->id }}" >{{ $estado->ubicacion }} - {{ $estado->codigo }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-6">
                                        <label>Nombre de la asignación</label>
                                        <div class="input-group">
                                            <input type="text" name="nombre_asignacion" id="nombre_asignacion"  class="form-control specialCharts" required onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <label>Dirección</label>
                                        <div class="input-group">
                                            <input type="text" name="direccion" id="direccion"  class="form-control specialCharts"  onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-6">
                                        <label>Subdirección</label>
                                        <div class="input-group">
                                            <input type="text" name="subdireccion" id="subdireccion"  class="form-control specialCharts"  onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <label>Coordinación</label>
                                        <div class="input-group">
                                            <input type="text" name="coordinacion" id="coordinacion" class="form-control specialCharts"  onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-4">
                                        <label>Area</label>
                                        <div class="input-group">
                                            <input type="text" name="area" id="area"  class="form-control specialCharts"  onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <label>Partida</label>
                                        <div class="input-group">
                                            <input type="text" name="partida" id="partida"  class="form-control specialCharts"  onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <label>Población</label>
                                        <div class="input-group">
                                            <input type="text" name="poblacion" id="poblacion"  class="form-control specialCharts"  onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-5">
                                        <label>Estado</label>
                                        <select class="form-control" id="id_estado" name="id_estado"  required >
                                            <option value="">Selecciona una opción</option>
                                            @foreach($estados as $estado)
                                                <option value="{{ $estado->id_estado }}" >{{ $estado->estado_nombre }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-5">
                                        <label>Municipio y/o Alcaldía.</label>
                                        <select class="form-control" id="id_municipio" name="id_municipio"  required>
                                            <option></option>
{{--                                             <option value="">Selecciona una opción</option>
                                            @foreach($municipios as $municipio)
                                                <option value="{{ $municipio->id_municipio }}" >{{ $municipio->municipio_nombre }}</option>
                                            @endforeach --}}
                                        </select>
                                    </div>
                                    <div class="col-lg-2">
                                        <label>CP</label>
                                        <div class="input-group">
                                            <input type="text" name="cp" id="cp" class="form-control specialCharts"  onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-lg-6">
                                        <label>Calle</label>
                                        <div class="input-group">
                                            <input type="text" name="calle" id="calle"  class="form-control specialCharts"  onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <label>Contacto</label>
                                        <div class="input-group">
                                            <input type="text" name="contacto" id="contacto"  class="form-control"  onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label>Observaciones</label>
                                    <textarea class="form-control specialCharts" name="observaciones" id="observaciones"
                                        onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"></textarea>
                                </div>
                            </div>
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
