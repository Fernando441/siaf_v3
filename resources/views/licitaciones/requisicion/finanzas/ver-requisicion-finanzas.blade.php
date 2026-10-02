@extends('layouts.app')
@section('title')
    Detalle de la requisición
@endsection
@push('scripts')

@endpush
@section('content')

<input type="hidden" id="documentoEliminarPath" value="{{ route('requisiciones.eliminarpartida') }}">
<div class="row">
    <div class="col-lg-12">
        <!--begin::Card-->
        <div class="card card-custom gutter-b">
            <div class="card-header">
                <h3 class="card-title">Detalle de la requisición</h3>
            </div>
            <!--begin::Form-->
            <input type='hidden' id='tipovehiculo' value='{{ $cadenatipovehiculo }}'>
                <div class="card-body">

                        <input type="hidden" name="idRequisicion" value="{{ $requisicion->id }}">
                        <!--begin::tabs-->
                        <ul class="nav nav-tabs nav-tabs-line">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#kt_tab_pane_1">Datos generales</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#kt_tab_pane_2">Partidas</a>
                            </li>
                        </ul>
                        <div class="tab-content mt-5" id="myTabContent">
                            <div class="tab-pane fade show active mt-10" id="kt_tab_pane_1" role="tabpanel" aria-labelledby="kt_tab_pane_2">

                                    <div class="row form-group">
                                        <div class="col-lg-6">
                                            <label>Folio</label>
                                            <p>{{ $requisicion->folio}}</p>
                                        </div>
                                        <div class="col-lg-6">
                                            <label>Solicitante</label>
                                            <p>{{ $requisicion->usersolicitante->name}}</p>
                                        </div>
                                    </div>

                                    <div class="row form-group">
                                        <div class="col-lg-6">
                                            <label>Area</label>
                                            <p>{{ $requisicion->areaPersonal->nombre_area }}</p>
                                        </div>
                                        <div class="col-lg-6">
                                            <label>Fecha de Solicitud</label>
                                            <p>{{  $requisicion->fecha_solicitud }}</p>
                                        </div>
                                    </div>

                            </div>
                            <div class="tab-pane fade mt-10" id="kt_tab_pane_2" role="tabpanel" aria-labelledby="kt_tab_pane_3">

                                <table class="table table-hover mb-6 table-responsive-sm" id="tblDocumentos">
                                    <thead>
                                    <tr>
                                        <th>Descripción</th>
                                        <th>Cantidad</th>
                                        <th>Observaciones</th>
                                    </tr>
                                    </thead>
                                    <tbody id='tbodyDocumentos'>
                                        @foreach($partidas as $documento)
                                            <tr id="trDocumento{{ $documento->id }}">
                                                <td>{{ $documento->segmento->segmentoTipoVehiculo->tipo_vehiculo }}, {{ $documento->segmento->segmentoNoCilindro->no_cilindro }} cilindros, {{ $documento->segmento->segmentoTransmision->transmision }}, {{ $documento->segmento->segmentoMotor->motor }}</td>
                                                <td>{{ $documento->cantidad }}</td>
                                                <td>{{ $documento->observaciones }}</td>
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
                            <a href="{{ route('finanzas.catalogorequisicion') }}"  class="btn btn-secondary">Cancelar</a>
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
