@extends('layouts.app')
@push('scripts')
      <script src="{{ asset('js/sistemas/EditarInventarioSistemas.js') }}"></script>
@endpush
@section('title')
    Editar equipo
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
                    <h3 class="card-title">Editar equipo</h3>
                </div>
                
                <!--begin::Form-->
                <input type="hidden" id="documentoEliminarPath" value="{{ route('sistemas.eliminarevidencia') }}">

                <form class="form" action="{{ route('sistemas.updateRegistro') }}" method="post" id="frmEquipo" enctype="multipart/form-data">
                    @csrf   
                    <input type='hidden' id='tipoArchivo' value='{{ $cadenaTipoDocumento }}'>
                    <input type="hidden" name="id" value="{{ $id_equipo }}">
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
                                                                    <input type="radio" @checked($inventario->tipo_equipo_id == $tipo->id) id="radio" name="tipo_equipo_id" value="{{ $tipo->id }}" />
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
                                            @foreach($req_compras as $ub)
                                                <option value="{{ $ub->id }}" @selected($inventario->requisicion_compras_id == $ub->id) >{{ $ub->titulo_requisicion }}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <div class="col-lg-6">
                                        <label>No. Serie</label>
                                        <div class="input-group">
                                            <input type="text" name="no_serie" id="no_serie" value="{{ $inventario->no_serie }}" class="form-control specialCharts" required onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <label>Marca</label>
                                        <div class="input-group">
                                            <input type="text" name="marca" id="marca" value="{{ $inventario->marca }}" class="form-control specialCharts" required onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-6">
                                        <label>Modelo</label>
                                        <div class="input-group">
                                            <input type="text" name="modelo" id="modelo" value="{{ $inventario->modelo }}" class="form-control specialCharts" required onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <label>Fecha ingreso</label>
                                        <div class="input-group">
                                            <input type="datetime-local" name="fecha_ingreso" value="{{ $inventario->fecha_ingreso }}" id="fecha_ingreso" class="form-control specialCharts"  onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-lg-12">
                                        <label>Descripcion</label>
                                        <div class="input-group">
                                            <textarea class="form-control specialCharts" name="descripcion" id="descripcion"
                                            onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">{{ $inventario->descripcion }}</textarea>
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
                                    @foreach($evidencia as $documento)
                                        <tr id="trDocumento{{ $documento->id }}">
                                            <td><a href="{{ route('archivo.documentoInventarioEquipo', ['id'=>$documento->id]) }}" class="link-primary" target="_blank"> {{ $documento->inventarioEquipoComputoTipoevidencia->tipo_evidencia }} </a></td>
                                            <td>{{ $documento->inventarioEquipoComputoTipoevidencia->tipo_evidencia }}</td>
                                            <td>
                                                <a href='#' class='btn btn-sm btn-clean btn-hover-icon-success btn-icon hrefEliminarDocumento' data-id='{{ $documento->id }}' data-documento='{{ $documento->documento }}'  data-toggle='tooltip' data-theme='dark' title='Eliminar'>
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
