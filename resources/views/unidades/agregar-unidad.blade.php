@extends('layouts.app')
@section('title')
    Agregar unidad
@endsection
@push('scripts')
	<script src="{{ asset('js/unidades/CrearUnidad.js') }}"></script>
@endpush
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
                <h3 class="card-title">Agregar unidad</h3>
            </div>
            <!--begin::Form-->
            <form class="form" action="{{ route('unidad.guardarunidad') }}" method="post" id="submit_unidad" enctype="multipart/form-data">
                <input type='hidden' id='tipoArchivo' value='{{ $cadenaTipoDocumento }}'>
                @csrf
                <div class="card-body">


                        <!--begin::tabs-->
                        <ul class="nav nav-tabs nav-tabs-line">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#kt_tab_pane_1">Datos del Vehículo</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#kt_tab_pane_2">Condiciones Físicas del Vehículo</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#kt_tab_pane_5">Asignar Unidad</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#kt_tab_pane_3">Documentos</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#kt_tab_pane_4">Fotografías</a>
                            </li>
                        </ul>
                        <div class="tab-content mt-5" id="myTabContent">
                            <div class="tab-pane fade show active mt-10" id="kt_tab_pane_1" role="tabpanel" aria-labelledby="kt_tab_pane_2">

                                <div class="form-group row">
                                    <div class="col-lg-6">
                                        <label>Marca</label>
                                        <select class="form-control" id="id_marca" name="id_marca" required >
                                            <option value="">Selecciona una opción</option>
                                            @foreach($marcas as $marca)
                                                <option value="{{ $marca->id }}" >{{ $marca->nombre_marca }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-6">
                                        <label>Modelo</label>
                                        <select class="form-control" id="id_modelo" name="id_modelo"  required >
                                            <option value="">Selecciona una opción</option>
                                            @foreach($modelos as $modelo)
                                                <option value="{{ $modelo->id }}" >{{ $modelo->nombre_modelo }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-lg-6">
                                        <label>Tipo de vehículo</label>
                                        <select class="form-control" id="id_tipovehiculo" name="id_tipovehiculo"  required >
                                            <option value="">Selecciona una opción</option>
                                            @foreach($tipovehiculo as $vehiculo)
                                                <option value="{{ $vehiculo->id }}" >{{ $vehiculo->vehiculo_tipo }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-6">
                                        <label>Número de serie</label>
                                        <div class="input-group">
                                            <input type="text" name="no_serie" id="no_serie"  class="form-control" required />
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-lg-6">
                                        <label>No. Factura de compra</label>
                                        <div class="input-group">
                                            <input type="text" name="factura_compra" id="factura_compra" required class="form-control" required />
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <label>Fecha de factura</label>
                                        <div class="input-group">
                                            <input type="text" name="fecha_factura" id="fecha_factura" readonly class="form-control" />
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-lg-6">
                                        <label>Número económico</label>
                                        <div class="input-group">
                                            <input type="number" name="numero_economico" id="numero_economico" class="form-control" />
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <label>Importe iva incluido</label>
                                        <div class="input-group">
                                            <input type="text" name="importe_iva" id="importe_iva"  class="form-control" required />
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-lg-6">
                                        <label>Placa</label>
                                        <div class="input-group">
                                            <input type="text" name="placa" id="placa" disabled class="form-control" />
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <label>Clave vehicular</label>
                                        <div class="input-group">
                                            <input type="text" name="clave_vehicular" id="clave_vehicular"  class="form-control" required />
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-lg-6">
                                        <label>Color</label>
                                        <div class="input-group">
                                            <input type="text" name="color" id="color"  class="form-control" required />
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <label>Año de la unidad</label>
                                        <div class="input-group">
                                            <input type="text" name="unidad_year" id="unidad_year"  readonly class="form-control" required />
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-lg-6">
                                        <label>Número de tarjeta de circulación</label>
                                        <div class="input-group">
                                            <input type="text" name="no_tarjeta_circulacion" disabled id="no_tarjeta_circulacion"  class="form-control" />
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <label>Transmisión</label>
                                        <select class="form-control"  name="transmision" id="transmision" required >
                                            <option value="">Selecciona la Opción</option>
                                            <option value="ESTANDAR">ESTÁNDAR</option>
                                            <option value="AUTOMATICO">AUTOMÁTICO</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                   <div class="col-lg-6">
                                        <label>Estatus</label>
                                        <select class="form-control" id="id_status" name="id_status"  required  >
                                            <option value="">Selecciona una opción</option>
                                            @foreach($estatus as $est)
                                                <option value="{{ $est->id }}" >{{ $est->nombre_status }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-6">
                                        <label>Aseguradora</label>
                                        <select class="form-control" id="id_aseguradora" name="id_aseguradora">
                                            <option value="">Selecciona una opción</option>
                                            @foreach($aseguradoras as $aseg)
                                                <option value="{{ $aseg->id }}" >{{ $aseg->nombre_aseguradora }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-6">
                                        <label>Número de póliza de seguro</label>
                                        <div class="input-group">
                                            <input type="text" name="no_poliza_seguro" id="no_poliza_seguro"  class="form-control" />
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <label>Fecha de vencimiento de la póliza</label>
                                        <div class="input-group">
                                            <input type="text" name="fecha_vencimiento_poliza" id="fecha_vencimiento_poliza" readonly class="form-control" />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-6">
                                        <label>Número de inventario</label>
                                        <div class="input-group">
                                            <input type="text" name="numero_inventario" id="numero_inventario"  class="form-control" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade mt-10" id="kt_tab_pane_2" role="tabpanel" aria-labelledby="kt_tab_pane_2">
                                @include('unidades.agregar-informacion-general')
                            </div>
                            <div class="tab-pane fade mt-10" id="kt_tab_pane_3" role="tabpanel" aria-labelledby="kt_tab_pane_3">

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

                            <div class="tab-pane fade mt-10" id="kt_tab_pane_4" role="tabpanel" aria-labelledby="kt_tab_pane_4">

                                <div class="row form-group" >

                                    <div class="col-lg-12" id="tblArchivosF">
                                        <table class='table table-bordered table-hover' id='tblDocumentosF'>
                                            <thead>
                                            <tr>
                                                <th>Adjuntar Fotografía</th>
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
                                        <a href="#" class="btn btn-icon btn-outline-success btn-circle btn-sm mr-2 hrefAgregarOtroF" data-toggle="tooltip" data-theme="dark" title="Agregar archivo">
                                            <i class="flaticon2-plus"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade mt-10" id="kt_tab_pane_5" role="tabpanel" aria-labelledby="kt_tab_pane_5">
                                <div class="form-group">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Selecciona una opción</label>
                                            <div class="radio-inline">
                                                <label class="radio">
                                                    <input type="radio" name="contrato_op" checked id="tp1"  value="1"/>
                                                    <span></span>
                                                    Asignar a Contrato
                                                </label>
                                                <label class="radio">
                                                    <input type="radio" name="contrato_op" id="tp2"  value="2"/>
                                                    <span></span>
                                                    Asignar a Patio
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col-lg-6 oculto div_patio">
                                        <label>Patio</label>
                                        <select class="form-control" id="id_ubicacion_asignar" name="id_ubicacion_asignar">
                                            <option value="">Selecciona una opción</option>
                                            @foreach($ubicaciones as $cli)
                                                <option value="{{ $cli->id }}" >{{ $cli->ubicacion }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-lg-6 div_contrato">
                                        <label>Contrato</label>
                                        <select class="form-control" id="id_contrato_asignar" name="id_contrato_asignar">
                                            <option value="">Selecciona una opción</option>
                                            @foreach($contratos as $cont)
                                                <option value="{{ $cont->id }}" >Folio: {{ $cont->no_folio }} / Id contrato: {{ $cont->id_contrato }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-lg-6">
                                        <label>Fecha de asignación</label>
                                        <div class="input-group">
                                            <input type="text" name="fecha_asignacion" id="fecha_asignacion"  class="form-control" required />
                                        </div>
                                    </div> 
                                </div>

                                <div class="row form-group">
                                    <div class="col-lg-6">
                                        <label>Tipo de asignación</label>
                                        <select class="form-control" id="id_tipo_asignacion" name="id_tipo_asignacion" required>
                                            <option value="">Selecciona una opción</option>
                                            @foreach($tipoasignacion as $asig)
                                                <option value="{{ $asig->id }}" >{{ $asig->tipo_asignacion }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>


                            </div>

                        </div>
                        <!--end::tabs-->

                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-lg-6">
                            <button type="button"  id="btnGuardarUnidad" class="btn btn-success"><i class="la la-plus"></i>Guardar</button>
                            <a href="{{ route('unidad.catalogounidad') }}"  class="btn btn-secondary"><i class="la la-times"></i>Cancelar</a>
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

<form method="post" id="unidad_delete_form" action="{{ route('unidad.eliminarunidad') }}" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="id" id="id_delete_unidad" value="">
</form>



@endsection
