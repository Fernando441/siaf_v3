@extends('layouts.app')
@push('scripts')
      <script src="{{ asset('js/sistemas/EditarInventarioSistemas.js') }}"></script>
@endpush
@section('title')
    Ver equipo
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
                    <h3 class="card-title">Ver equipo</h3>
                </div>
                

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
                                                                    <input type="radio" disabled @checked($inventario->tipo_equipo_id == $tipo->id) id="radio" name="tipo_equipo_id" value="{{ $tipo->id }}" />
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
                                        @foreach($req_compras as $ub)
                                            @if($inventario->requisicion_compras_id == $ub->id)
                                                <p>{{ $ub->titulo_requisicion }}</p>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <div class="col-lg-6">
                                        <label>No. Serie</label>
                                        <div class="input-group">
                                            <p>{{ $inventario->no_serie }}</p>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <label>Marca</label>
                                        <div class="input-group">
                                            <p>{{ $inventario->marca }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-6">
                                        <label>Modelo</label>
                                        <div class="input-group">
                                            <p>{{ $inventario->modelo }}</p>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <label>Fecha ingreso</label>
                                        <div class="input-group">
                                            <p>{{ $inventario->fecha_ingreso }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-lg-12">
                                        <label>Descripcion</label>
                                        <div class="input-group">
                                            <p>{{ $inventario->descripcion }}</p>
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
                                    </tr>
                                    </thead>
                                    <tbody id='tbodyDocumentos'>
                                        @foreach($evidencia as $documento)
                                            <tr id="trDocumento{{ $documento->id }}">
                                                <td><a href="{{ route('archivo.documentoInventarioEquipo', ['id'=>$documento->id]) }}" class="link-primary" target="_blank"> {{ $documento->inventarioEquipoComputoTipoevidencia->tipo_evidencia }} </a></td>
                                                <td>{{ $documento->inventarioEquipoComputoTipoevidencia->tipo_evidencia }}</td>

                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>


                            </div>

                        </div>
                        <!--end::tabs-->

                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-lg-6">
                                <a href="{{ route('sistemas.catalogoinventario') }}"  class="btn btn-secondary"><i class="la la-arrow-left"></i>Regresar</a>
                            </div>
                        </div>
                    </div>
                <!--end::Form-->
            </div>
            <!--end::Card-->
        </div>
    </div>
    <!--end::Card-->

@endsection
