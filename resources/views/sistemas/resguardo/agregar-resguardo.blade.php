@extends('layouts.app')
@push('scripts')
      <script src="{{ asset('js/sistemas/AgregarResguardo.js') }}"></script>
@endpush
@section('title')
    Agregar resguardo
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
                    <h3 class="card-title">Agregar resguardo</h3>
                </div>
                
                <!--begin::Form-->
                <form class="form" action="{{ route('sistemas.guardarRegistro') }}" method="post" id="frmResguardo" enctype="multipart/form-data">
                    @csrf   
                    <input type='hidden' id='tipoArchivo' value='{{ $cadenaTipoDocumento }}'>
                    <input type='hidden' id='tipoEquipo' value='{{ $cadenaEquipos }}'>
                    <div class="card-body">
                        <!--begin::tabs-->
                        <ul class="nav nav-tabs nav-tabs-line">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#kt_tab_pane_1">Información del resguardo</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#kt_tab_pane_2">Evidencias</a>
                            </li>
                        </ul>
                        <div class="tab-content mt-5" id="myTabContent">
                            <div class="tab-pane fade show active mt-10" id="kt_tab_pane_1" role="tabpanel" aria-labelledby="kt_tab_pane_1">
                                <div class="form-group row">
                                    <div class="col-lg-6">
                                        <label>Usuario</label>
                                        <select class="form-control" id="user_resguardo" name="user_resguardo"   >
                                            <option value="">Selecciona una opción</option>
                                            @foreach($usuarios as $estado)
                                                <option value="{{ $estado->id }}" >{{ $estado->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-6">
                                        <label>Fecha ingreso</label>
                                        <div class="input-group">
                                            <input type="datetime-local" name="fecha_asignacion" id="fecha_asignacion" class="form-control specialCharts"  onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col-lg-12">
                                        <table class="table table-hover mb-6 table-responsive-sm" id="tblDocumentosF">
                                            <thead>
                                            <tr>
                                                <th scope="col">Equipo</th>
                                                <th scope="col">Opción</th>
                                            </tr>
                                            </thead>
                                            <tbody id='tbodyDocumentosF'>
                                            </tbody>
                                        </table>

                                        <div class="row form-group">
                                            <div class="col-lg-12">
                                                <a href="#" class="btn btn-icon btn-outline-success btn-circle btn-sm mr-2 hrefAgregarEquipos" data-toggle="tooltip" data-theme="dark" title="Agregar archivo">
                                                    <i class="flaticon2-plus"></i>
                                                </a>
                                            </div>
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
