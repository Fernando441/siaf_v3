@extends('layouts.app')
@push('scripts')
      <script src="{{ asset('js/sistemas/AgregarInventarioSistemas.js') }}"></script>
@endpush
@section('title')
    Agregar equipo
@endsection
@section('content')
<style>
    .switch input:empty ~ span
    {
        background-color: #bababa;
    }

    .oculto{
        display:none;
    }
</style>

    <!--begin::Card-->
    <div class="row">
        <div class="col-lg-12">
            <!--begin::Card-->
            <div class="card card-custom gutter-b">
                <div class="card-header">
                    <h3 class="card-title">Agregar equipo</h3>
                </div>
                
                <!--begin::Form-->
                <form class="form" action="{{ route('sistemas.guardarRegistro') }}" method="post" id="frmSistemas" enctype="multipart/form-data">
                    @csrf   
                    <input type='hidden' id='tipoArchivo' value='{{ $cadenaTipoDocumento }}'>
                    <div class="card-body">
                        <!--begin::tabs-->
                        <ul class="nav nav-tabs nav-tabs-line">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#kt_tab_pane_1">Información del equipo</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#kt_tab_pane_2">Evidencias</a>
                            </li>
                        </ul>
                        <div class="tab-content mt-5" id="myTabContent">
                            <div class="tab-pane fade show active mt-10" id="kt_tab_pane_1" role="tabpanel" aria-labelledby="kt_tab_pane_1">
                                <div class="form-group row">
                                    <div class="col-lg-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <h3 class="card-title">
                                                    Tipo de equipo
                                                </h3>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    @foreach($tipo_equipo as $tipo)
                                                        <div class="col-lg-4">
                                                            
                                                            <div class="radio-inline">
                                                                <label class="radio">
                                                                    <input type="radio" checked id="radio" name="tipo_equipo_id" value="{{ $tipo->id }}" />
                                                                    <span></span>
                                                                    {{ $tipo->tipo_equipo }}
                                                                </label>
                                                            </div>
                                                            
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-lg-6">
                                        <label>Requisicion compra</label>
                                        <select class="form-control" id="requisicion_compras_id" name="requisicion_compras_id"   >
                                            <option value="">Selecciona una opción</option>
                                            @foreach($req_compras as $estado)
                                                <option value="{{ $estado->id }}" >{{ $estado->titulo_requisicion }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <div class="col-lg-6">
                                        <label>No. Serie</label>
                                        <div class="input-group">
                                            <input type="text" name="no_serie" id="no_serie"  class="form-control specialCharts" required onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <label>Marca</label>
                                        <div class="input-group">
                                            <input type="text" name="marca" id="marca"  class="form-control specialCharts" required onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-6">
                                        <label>Modelo</label>
                                        <div class="input-group">
                                            <input type="text" name="modelo" id="modelo"  class="form-control specialCharts" required onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <label>Fecha ingreso</label>
                                        <div class="input-group">
                                            <input type="datetime-local" name="fecha_ingreso" id="fecha_ingreso" class="form-control specialCharts"  onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-lg-12">
                                        <label>Descripcion</label>
                                        <div class="input-group">
                                            <textarea class="form-control specialCharts" name="descripcion" id="descripcion"
                                            onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"></textarea>
                                        </div>
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
                                <a href="{{ route('sistemas.catalogoinventario') }}"  class="btn btn-secondary"><i class="la la-arrow-left"></i>Regresar</a>
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
