@extends('layouts.app')
@section('title')
    Agregar informacion a partidas sin concurso
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
                    <h3 class="card-title">Agregar informacion a partidas sin concurso</h3>
                </div>
                <!--begin::Form-->
                <input type='hidden' id='tipovehiculo' value='{{ $cadenatipovehiculo }}'>
                <div class="card-body">
                    @if ($requisicion->requisicion_estatus_id == 7)
                        <div class="mb-6">
                            <p style="font-size: 14px;"><span style="color:red;font-weight: bold;">Finanzas regreso la
                                    requisición por el motivo: </span>{{ $requisicion->motivo_finanzas }}</p>
                        </div>
                    @endif
                    <input type="hidden" name="idRequisicion" value="{{ $requisicion->id }}">
                    <!--begin::tabs-->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="row form-group">
                                <div class="col-lg-3">
                                    <label>Folio</label>
                                    <p>{{ $requisicion->folio }}</p>
                                </div>
                                <div class="col-lg-3">
                                    <label>Solicitante</label>
                                    <p>{{ $requisicion->usersolicitante->name }}</p>
                                </div>
                                <div class="col-lg-3">
                                    <label>Area</label>
                                    <p>{{ $requisicion->areaPersonal->nombre_area }}</p>
                                </div>
                                <div class="col-lg-3">
                                    <label>Fecha de Solicitud</label>
                                    <p>{{ $requisicion->fecha_solicitud }}</p>
                                </div>
                            </div>
                        </div>
                    </div>


                    <ul class="nav nav-tabs nav-tabs-line">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#kt_tab_pane_2">Partidas</a>
                        </li>
                    </ul>
                    <div class="tab-content mt-5" id="myTabContent">
                        <div class="tab-pane fade mt-10 show active" id="kt_tab_pane_2" role="tabpanel"
                            aria-labelledby="kt_tab_pane_3">

                            <table class="table table-hover mb-6 table-responsive-sm" id="tblDocumentos">
                                <thead>
                                    <tr>
                                        <th>Descripción</th>
                                        <th>Cantidad</th>
                                        <th>Observaciones</th>
                                        <th>Estatus</th>
                                        <th>Opciones</th>
                                    </tr>
                                </thead>
                                <tbody id='tbodyDocumentos'>
                                    @foreach ($partidas as $partida)
                                        <tr id="trDocumento{{ $partida->id }}">
                                            <td>{{ $partida->segmento->segmentoTipoVehiculo->tipo_vehiculo }},
                                                {{ $partida->segmento->segmentoNoCilindro->no_cilindro }} cilindros,
                                                {{ $partida->segmento->segmentoTransmision->transmision }},
                                                {{ $partida->segmento->segmentoMotor->motor }}</td>
                                            <td>{{ $partida->cantidad }}</td>
                                            <td>{{ $partida->observaciones }}</td>
                                            <td>
                                                @include('licitaciones.requisicion.partidas.botones-estatus')
                                            </td>
                                            <td>
                                                <a href="{{ route('requisiciones.infopartida', [$partida->id, $id]) }}"
                                                    class="btn btn-sm btn-clean btn-hover-icon-success btn-icon"
                                                    title="Agregar información a la partida" data-theme="dark"
                                                    data-toggle="tooltip" data-placement="top">
                                                    <span class="svg-icon svg-icon-md">
                                                        <i class="flaticon-file-1"></i>
                                                    </span>
                                                </a>
                                            </td>
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
                            <a href="{{ route('requisiciones.catalogorequisicion') }}"
                                class="btn btn-secondary">Cancelar</a>
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
