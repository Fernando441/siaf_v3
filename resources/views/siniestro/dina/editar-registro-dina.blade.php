@extends('layouts.app')
@push('scripts')
    <script src="{{ asset('js/siniestros/EditarSiniestro.js') }}"></script>
@endpush
@section('title')
    Editar registro
@endsection
@section('content')

    <!--begin::Card-->
    <div class="row">
        <div class="col-lg-12">
            <!--begin::Card-->
            <div class="card card-custom gutter-b">
                <div class="card-header">
                    <h3 class="card-title">Editar registro</h3>
                </div>
                
                <input type="hidden" id="documentoEliminarPath" value="{{ route('siniestro.deletesicurezzaevidencia') }}">
                <!--begin::Form-->
                <form class="form" action="{{ route('siniestro.editsiniestrodina') }}" method="post" id="frmCliente" enctype="multipart/form-data">
                    @csrf   

                    <input type='hidden' id='tipoArchivo' value='{{ $cadenaTipoDocumento }}'>
                    <input type="hidden" name="id" id="id_siniestro" value="{{ $id_siniestro }}">
                    <input type="hidden" name="siniestros_agencia_id" value="1">
                    <div class="card-body">
                        <!--begin::tabs-->
                        <ul class="nav nav-tabs nav-tabs-line">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#kt_tab_pane_1">Información del siniestro</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#kt_tab_pane_2">Archivos</a>
                            </li>
                        </ul>
                        <div class="tab-content mt-5" id="myTabContent">
                            <div class="tab-pane fade show active mt-10" id="kt_tab_pane_1" role="tabpanel" aria-labelledby="kt_tab_pane_1">
                                <div class="form-group row">
                                    <div class="col-lg-6">
                                        <label>No. Siniestro</label>
                                        <div class="input-group">
                                            <input type="text" name="no_siniestro" value="{{ $siniestro_dina->no_siniestro }}" id="no_siniestro" class="form-control specialCharts" required onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <label>Deducible $ @if($siniestro_dina->op_deducible == 1) <a href="#" id="deducible_icon"> <i class="flaticon-exclamation menu-icon" style="color:orange;"></i></a> @endif</label>
                                        <div class="input-group">
                                            <input type="number" name="deducible" value="{{ $siniestro_dina->deducible }}" id="deducible" class="form-control specialCharts" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <label>Recuperacion aplicada $ @if($siniestro_dina->op_recuperacion_aplicada == 1) <a href="#" id="deducible_icon"> <i class="flaticon-exclamation menu-icon" style="color:orange;"></i></a> @endif</label>
                                        <div class="input-group">
                                            <input type="number" name="recuperacion_aplicada" value="{{ $siniestro_dina->recuperacion_aplicada }}" id="recuperacion_aplicada" class="form-control specialCharts"  onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                        </div>
                                    </div>
                                </div>
                            {{-- Historial  --}}
                            <div class="form-group row oculto" id="deducible_historial_div">
                                <input type="hidden" id="iput_deducible" value="0">
                                <div class="card card-custom">
                                    <div class="card-header">
                                        <div class="card-title">
                                            <span class="card-icon">
                                                <i class="flaticon2-file text-primary"></i>
                                            </span>
                                            <h3 class="card-label">Historial de deducible</h3>
                                        </div>
                                    </div>
                                    <div class="card-body">

                                        <table class="table table-hover table-checkable" id="kdatatable_historial_deducible">
                                            <thead>
                                            <tr>
                                                <th>Deducible</th>
                                                <th>Persona que modifico</th>
                                                <th>Fecha y hora de modificacion</th>
                                            </tr>
                                            </thead>

                                            <tbody>
                                                @foreach($historial_deducibles as $unid)
                                                    <tr>
                                                        <td>${{ $unid->deducible }}</td>
                                                        <td>{{ $unid->userCreated->name }}</td>
                                                        <td>{{ $unid->created_at}}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>

                                            <tfoot>
                                            <tr>
                                                <th>Deducible</th>
                                                <th>Persona que modifico</th>
                                                <th>Fecha y hora de modificacion</th>
                                            </tr>
                                            </tfoot>

                                        </table>
                                        <input type="hidden" id="datatable_i18n" value="{{ asset('/js/datatables/i18n/es-mx.json') }}">
                                    </div>
                                </div>                                
                            </div>


                            <div class="form-group row oculto" id="raplicada_historial_div">
                                <input type="hidden" id="iput_raplicada" value="0">
                                <div class="card card-custom">
                                    <div class="card-header">
                                        <div class="card-title">
                                            <span class="card-icon">
                                                <i class="flaticon2-file text-primary"></i>
                                            </span>
                                            <h3 class="card-label">Historial de recuperacion aplicada</h3>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-hover table-checkable" id="kdatatable_historial_raplicada">
                                            <thead>
                                            <tr>
                                                <th>Recuperacion aplicada</th>
                                                <th>Persona que modifico</th>
                                                <th>Fecha y hora de modificacion</th>
                                            </tr>
                                            </thead>

                                            <tbody>
                                                @foreach($historial_raplicada as $unid)
                                                    <tr>
                                                        <td>${{ $unid->recuperacion_aplicada }}</td>
                                                        <td>{{ $unid->userCreated->name }}</td>
                                                        <td>{{ $unid->created_at}}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>

                                            <tfoot>
                                            <tr>
                                                <th>Deducible</th>
                                                <th>Persona que modifico</th>
                                                <th>Fecha y hora de modificacion</th>
                                            </tr>
                                            </tfoot>

                                        </table>
                                        <input type="hidden" id="datatable_i18n" value="{{ asset('/js/datatables/i18n/es-mx.json') }}">

                                    </div>
                                </div>                                
                            </div>
                            {{-- END Historial --}}
                                <div class="form-group row">
                                    <div class="col-lg-4">
                                        <label>No. Serie</label>
                                        <div class="input-group">
                                            <input type="text" name="serie" value="{{ $siniestro_dina->serie }}" id="serie" class="form-control specialCharts" required onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <label>Contratante</label>
                                        <div class="input-group">
                                            <input type="text" name="contratante" value="{{ $siniestro_dina->contratante }}" id="contratante" class="form-control specialCharts" required onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <label>Proyecto poliza</label>
                                        <div class="input-group">
                                            <input type="text" name="proyecto_poliza" value="{{ $siniestro_dina->proyecto_poliza }}" id="proyecto_poliza" class="form-control specialCharts" required onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-lg-4">
                                        <label>Nombre del proyecto</label>
                                        <div class="input-group">
                                            <input type="text" name="nombre_proyecto" value="{{ $siniestro_dina->nombre_proyecto }}" id="nombre_proyecto" class="form-control specialCharts" required onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <label>Inicio</label>
                                        <div class="input-group">
                                            <input type="date" name="inicio" value="{{ $siniestro_dina->inicio }}" id="inicio" class="form-control specialCharts" required onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <label>Fin</label>
                                        <div class="input-group">
                                            <input type="date" name="fin" value="{{ $siniestro_dina->fin }}" id="fin" class="form-control specialCharts" required onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-lg-4">
                                        <label>Moneda</label>
                                        <div class="input-group">
                                            <input type="text" name="moneda" value="{{ $siniestro_dina->moneda }}" id="moneda" class="form-control specialCharts"  onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <label>Poliza</label>
                                        <div class="input-group">
                                            <input type="text" name="poliza" value="{{ $siniestro_dina->poliza }}" id="poliza" class="form-control specialCharts" required onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <label>Fecha ocurrencia</label>
                                        <div class="input-group">
                                            <input type="date" name="fecha_ocurrencia" value="{{ $siniestro_dina->fecha_ocurrencia }}" id="fecha_ocurrencia" class="form-control specialCharts" required onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                        </div>
                                    </div>
                                    {{-- div deducible --}}
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-4">
                                        <label>Tipo siniestro inicial</label>
                                        <div class="input-group">
                                            <input type="text" name="tipo_siniestro_inicial" value="{{ $siniestro_dina->tipo_siniestro_inicial }}" id="tipo_siniestro_inicial" class="form-control specialCharts" required onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                        </div>
                                    </div>
                                    {{-- recuperacion aplicada --}}
                                    <div class="col-lg-4">
                                        <label>Nombre agente</label>
                                        <div class="input-group">
                                            <input type="text" name="nombre_agente" value="{{ $siniestro_dina->nombre_agente }}" id="nombre_agente" class="form-control specialCharts"  onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <label>Modelo</label>
                                        <div class="input-group">
                                            <input type="text" name="modelo" value="{{ $siniestro_dina->modelo }}" id="modelo" class="form-control specialCharts"  onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade mt-10" id="kt_tab_pane_2" role="tabpanel" aria-labelledby="kt_tab_pane_2">
                                <div class="row form-group">
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
                                                @foreach($evidencia_siniestro as $documento)
                                                    <tr id="trDocumento{{ $documento->id }}">
                                                        <td><a href="{{ route('archivo.evidenciadina', ['id'=>$documento->id]) }}" class="link-primary" target="_blank"> {{ $documento->SiniestroTipoDocumento->nombre_documento }} </a></td>
                                                        <td>{{ $documento->documento }}</td>
                                                        <td>
                                                            <a href='#' class='btn btn-sm btn-clean btn-hover-icon-success btn-icon hrefEliminarDocumento' data-id='{{ $documento->id }}' data-documento='{{ $documento->SiniestroTipoDocumento->nombre_documento }}'  data-toggle='tooltip' data-theme='dark' title='Eliminar'>
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
                                <a href="{{ route('siniestro.catalogodina') }}"  class="btn btn-secondary"><i class="la la-arrow-left"></i>Regresar</a>
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
