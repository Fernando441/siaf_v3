@extends('layouts.app')
@push('scripts')
    <script src="{{ asset('js/siniestros/EditarSiniestro.js') }}"></script>
@endpush
@section('title')
    Agregar registro
@endsection
@section('content')

    <!--begin::Card-->
    <div class="row">
        <div class="col-lg-12">
            <!--begin::Card-->
            <div class="card card-custom gutter-b">
                <div class="card-header">
                    <h3 class="card-title">Agregar registro</h3>
                </div>
                
                <!--begin::Form-->
                <form class="form" action="{{ route('siniestro.guardardina') }}" method="post" id="frmCliente" enctype="multipart/form-data">
                    @csrf   

                    <input type='hidden' id='tipoArchivo' value='{{ $cadenaTipoDocumento }}'>
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
                                            <input type="text" name="no_siniestro" id="no_siniestro" class="form-control specialCharts" required onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <label>Deducible $</label>
                                        <div class="input-group">
                                            <input type="number" name="deducible" id="deducible" class="form-control specialCharts" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <label>Recuperacion aplicada $</label>
                                        <div class="input-group">
                                            <input type="number" name="recuperacion_aplicada" id="recuperacion_aplicada" class="form-control specialCharts"  onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-lg-4">
                                        <label>No. Serie</label>
                                        <div class="input-group">
                                            <input type="text" name="serie" id="serie" class="form-control specialCharts" required onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <label>Contratante</label>
                                        <div class="input-group">
                                            <input type="text" name="contratante" id="contratante" class="form-control specialCharts" required onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <label>Proyecto poliza</label>
                                        <div class="input-group">
                                            <input type="text" name="proyecto_poliza" id="proyecto_poliza" class="form-control specialCharts" required onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-lg-4">
                                        <label>Nombre del proyecto</label>
                                        <div class="input-group">
                                            <input type="text" name="nombre_proyecto" id="nombre_proyecto" class="form-control specialCharts" required onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <label>Inicio</label>
                                        <div class="input-group">
                                            <input type="date" name="inicio" id="inicio" class="form-control specialCharts" required onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <label>Fin</label>
                                        <div class="input-group">
                                            <input type="date" name="fin" id="fin" class="form-control specialCharts" required onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-lg-4">
                                        <label>Moneda</label>
                                        <div class="input-group">
                                            <input type="text" name="moneda" id="moneda" class="form-control specialCharts"  onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <label>Poliza</label>
                                        <div class="input-group">
                                            <input type="text" name="poliza" id="poliza" class="form-control specialCharts" required onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <label>Fecha ocurrencia</label>
                                        <div class="input-group">
                                            <input type="date" name="fecha_ocurrencia" id="fecha_ocurrencia" class="form-control specialCharts" required onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                        </div>
                                    </div>
                                    {{-- div deducible --}}
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-4">
                                        <label>Tipo siniestro inicial</label>
                                        <div class="input-group">
                                            <input type="text" name="tipo_siniestro_inicial" id="tipo_siniestro_inicial" class="form-control specialCharts" required onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                        </div>
                                    </div>
                                    {{-- recuperacion aplicada --}}
                                    <div class="col-lg-4">
                                        <label>Nombre agente</label>
                                        <div class="input-group">
                                            <input type="text" name="nombre_agente" id="nombre_agente" class="form-control specialCharts"  onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <label>Modelo</label>
                                        <div class="input-group">
                                            <input type="text" name="modelo" id="modelo" class="form-control specialCharts"  onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
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
