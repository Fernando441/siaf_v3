@extends('layouts.app')
@push('scripts')
    <script src="{{ asset('js/sistemas/EditResguardo.js') }}"></script>
@endpush
@section('title')
    Editar resguardo
@endsection
@section('content')
    <style>
        .bold_equipo{
            font-weight: 500;  
        }
    </style>
    <!--begin::Card-->
    <div class="row">
        <div class="col-lg-12">
            <!--begin::Card-->
            <div class="card card-custom gutter-b">
                <div class="card-header">
                    <h3 class="card-title">Editar resguardo</h3>
                </div>
                
                <!--begin::Form-->
                <input type="hidden" id="documentoEliminarEquipo" value="{{ route('resguardo.deleteequipo') }}">
                <input type="hidden" id="documentoEliminarArchivo" value="{{ route('resguardo.deletearchivo') }}">

                <form class="form" action="{{ route('resguardo.edtresguardo') }}" method="post" id="frmCliente" enctype="multipart/form-data">
                    @csrf   
                    <input type='hidden' id='tipoArchivo' value='{{ $cadenaTipoDocumento }}'>
                    <input type='hidden' id='tipoEquipos' value='{{ $cadenaEquipos }}'>
                    <input type="hidden" name="id" value="{{ $id_resguardo }}">
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
                            <div class="tab-pane fade show active mt-10" id="kt_tab_pane_1" role="tabpanel" aria-labelledby="kt_tab_pane_1">
                                <div class="form-group row">
                                    <div class="col-lg-6">
                                        <label>Usuario</label>
                                        <select class="form-control" id="id_user" name="id_user"   >
                                            <option value="">Selecciona una opción</option>
                                            @foreach($usuarios as $estado)
                                                <option value="{{ $estado->id }}" @selected($resguardo->user_resguardo == $estado->id)>{{ $estado->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-6">
                                        <label>Fecha asignacion</label>
                                        <div class="input-group">
                                            <input type="datetime-local" value="{{ $resguardo->fecha_asignacion }}" name="fecha_asignacion" id="fecha_asignacion"  class="form-control" required/>
                                        </div>
                                    </div>
                                </div>

                                <div class="row form-group" >
                                    <div class="col-lg-12" id="tblEquipos">
                                        <table class='table table-bordered table-hover' id='tblDocEquipos'>
                                            <thead>
                                            <tr>
                                                <th>Equipo</th>
                                                <th>Opción</th>
                                            </tr>
                                            </thead>
                                            <tbody id='tbodyDocEquipos'>
                                                @foreach($equipos_asignados as $documento)
                                                    <tr id="trDocumento{{ $documento->id }}">
                                                        <td><span class="bold_equipo"> No. folio: </span>{{ $documento->inventarioEquipoComputo->no_folio }} <span class="bold_equipo">No. serie:</span> {{ $documento->inventarioEquipoComputo->no_serie }} <span class="bold_equipo">Marca:</span> {{ $documento->inventarioEquipoComputo->marca }}</td>
                                                        <td>
                                                            <a href='#' class='btn btn-sm btn-clean btn-hover-icon-success btn-icon hrefEliminarEquipo' data-id='{{ $documento->id }}' data-documento='{{ $documento->documento }}'  data-toggle='tooltip' data-theme='dark' title='Eliminar'>
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
                                        <a href="#" class="btn btn-icon btn-outline-success btn-circle btn-sm mr-2 hrefAgregarEquipo" data-toggle="tooltip" data-theme="dark" title="Agregar archivo">
                                            <i class="flaticon2-plus"></i>
                                        </a>
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col-lg-12">
                                        <label>Descripcion</label>
                                        <textarea class="form-control specialCharts" name="descripcion" id="descripcion"
                                            onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">{{ $resguardo->descripcion }}</textarea>
                                    </div>
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
                                                @foreach($documentos_asignados as $documento)
                                                    <tr id="trDocumento{{ $documento->id }}">
                                                        <td><a href="{{ route('archivo.documentoRes', ['id'=>$documento->id]) }}" class="link-primary" target="_blank"> {{ $documento->ResguardoTipoEvidencia->tipo_evidencia }} </a></td>
                                                        <td>{{ $documento->ResguardoTipoEvidencia->tipo_evidencia }}</td>
                                                        <td>
                                                            <a href='#' class='btn btn-sm btn-clean btn-hover-icon-success btn-icon hrefEliminarArchivo' data-id='{{ $documento->id }}' data-documento='{{ $documento->documento }}'  data-toggle='tooltip' data-theme='dark' title='Eliminar'>
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
                                <a href="{{ route('resguardo.catalogoresguardo') }}"  class="btn btn-secondary"><i class="la la-arrow-left"></i>Regresar</a>
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
