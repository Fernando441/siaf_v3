@extends('layouts.app')
@push('scripts')
	<script src="{{ asset('js/siniestros/EditarSiniestro.js') }}"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}" />

@endpush
@section('title')
    Editar siniestro
@endsection
@section('content')
<style>
    .btn-parpadear {
    animation: parpadeo 0.9s ease-in-out infinite;
}

@keyframes parpadeo {
    0%, 100% {
        opacity: 1;
    }
    50% {
        opacity: 0.3;
    }
}
</style>

<!--begin::Card-->
<div class="row">
    <div class="col-lg-12">
        <!--begin::Card-->
        <div class="card card-custom gutter-b">
            <div class="card-header">
                <h3 class="card-title">Editar siniestro</h3>
            </div>
            <!--begin::Form-->
            
            <form class="form" action="{{ route('siniestro.addsiniestrosic') }}" method="post" id="frmCliente" enctype="multipart/form-data">
                @csrf
                <input type='hidden' id='tipoArchivo' value='{{ $cadenaTipoDocumento }}'>
                <input type="hidden" name="siniestros_agencia_id" value="2">
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
                        <div class="tab-pane fade show active mt-10" id="kt_tab_pane_1" role="tabpanel" aria-labelledby="kt_tab_pane_2">
                            <div class="form-group row">
                                <div class="col-lg-6">
                                    <label>Siniestro completo</label>
                                    <div class="input-group">
                                        <input type="number" name="siniestro_completo" value="" id="siniestro_completo" class="form-control specialCharts" required onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <label>Deducible $</label>
                                    <div class="input-group">
                                        <input type="number" name="deducibles" value="" id="deducibles" class="form-control specialCharts" required/>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <label>Recuperacion Aplicada $</label>
                                    <div class="input-group">
                                        <input type="number" name="recuperacion_aplicada" value="" id="recuperacion_aplicada" class="form-control specialCharts" required/>
                                    </div>
                                </div>
                            </div>


                            <div class="form-group row">
                                <div class="col-lg-6">
                                    <label>Proyecto</label>
                                    <div class="input-group">
                                        <input type="text" name="proyecto" value="" id="proyecto" class="form-control specialCharts"  onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <label>Serie</label>
                                    <div class="input-group">
                                        <input type="text" name="serie" value="" id="serie"  class="form-control specialCharts" required onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-4">
                                    <label>Fecha ocurrencia</label>
                                    <div class="input-group">
                                        <input type="date" name="fecha_ocurrencia" value="" id="fecha_ocurrencia" class="form-control specialCharts" required onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <label>Causa / Enfermedad 2</label>
                                    <div class="input-group">
                                        <input type="text" name="causa_enfermedad" value="" id="causa_enfermedad"  class="form-control specialCharts"  onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <label>Nombre Agente</label>
                                    <div class="input-group">
                                        <input type="text" name="nombre_agente" value="" id="nombre_agente"  class="form-control specialCharts"  onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-4">
                                    <label>Asegurado</label>
                                    <div class="input-group">
                                        <input type="text" name="asegurado" value="" id="asegurado" class="form-control specialCharts"  onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <label>Modelo</label>
                                    <div class="input-group">
                                        <input type="text" name="modelo" value="" id="modelo"  class="form-control specialCharts"  onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <label>Descripción Auto</label>
                                    <div class="input-group">
                                        <input type="text" name="descripcion_auto" value="" id="descripcion_auto"  class="form-control specialCharts"  onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
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
                                    <th scope="col">Opción</th>
                                </tr>
                                </thead>
                                <tbody id='tbodyDocumentos'>

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
                            <a href="{{ route('siniestro.catalogosicurezza') }}"  class="btn btn-secondary"><i class="la la-arrow-left"></i>Regresar</a>
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