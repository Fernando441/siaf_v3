@extends('layouts.app')
@section('title')
    Editar Requisicion
@endsection
@push('scripts')
    <script src="{{ asset('js/licitaciones/requisicion/EditarRequisicion.js') }}"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
@endpush
@section('content')
    <input type="hidden" id="documentoEliminarPath" value="{{ route('requisiciones.eliminarpartida') }}">
    <div class="row">
        <div class="col-lg-12">
            <!--begin::Card-->
            <div class="card card-custom gutter-b">
                <div class="card-header">
                    <h3 class="card-title">Editar requisición {{ $requisicion->folio }}</h3>
                </div>
                <!--begin::Form-->
                <input type='hidden' id='tipovehiculo' value='{{ $cadenatipovehiculo }}'>
                <form class="form" action="{{ route('requisiciones.editarpartida') }}" method="post"
                    id="formCrearRequisicion" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        @if ($requisicion->requisicion_estatus_id == 7)
                            <span style="color:red; font-size: 14px; font-weight: bold;">Finanzas regreso la requisición por
                                el motivo:</span> <span>{{ $requisicion->motivo_finanzas }}</span>
                        @endif

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
                            <div class="tab-pane fade show active mt-10" id="kt_tab_pane_1" role="tabpanel"
                                aria-labelledby="kt_tab_pane_2">

                                <div class="row form-group">
                                    <div class="col-lg-6">
                                        <label>Solicitante</label>
                                        <select class="form-control" id="solicitante" name="solicitante" required>
                                            <option value="">Selecciona una opción </option>
                                            @foreach ($solicitante as $cli)
                                                <option value="{{ $cli->id }}"
                                                    {{ $cli->id == $requisicion->solicitante ? 'selected' : '' }}>
                                                    {{ strtoupper($cli->name) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-lg-6">
                                        <label>Area</label>
                                        <select class="form-control" name="area" id="area" required>
                                            <option value="">Selecciona un opción</option>
                                            @foreach ($area_personal as $cli)
                                                <option value="{{ $cli->id }}"
                                                    {{ $cli->id == $requisicion->id_area ? 'selected' : '' }}>
                                                    {{ strtoupper($cli->nombre_area) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col-lg-6">
                                        <label>Fecha de Solicitud</label>
                                        <div class="input-group date" id="kt_datetimepicker_1" data-target-input="nearest">
                                            <input type="text" name="fecha_solicitud"
                                                class="form-control datetimepicker-input"
                                                value="{{ $requisicion->fecha_solicitud }}"
                                                placeholder="Selecciona Fecha y Hora" data-target="#kt_datetimepicker_1"
                                                required />
                                            <div class="input-group-append" data-target="#kt_datetimepicker_1"
                                                data-toggle="datetimepicker">
                                                <span class="input-group-text">
                                                    <i class="ki ki-calendar"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="tab-pane fade mt-10" id="kt_tab_pane_2" role="tabpanel"
                                aria-labelledby="kt_tab_pane_3">

                                <table class="table table-hover mb-6 table-responsive-sm" id="tblDocumentos">
                                    <thead>
                                        <tr>
                                            <th>Descripción</th>
                                            <th>Cantidad</th>
                                            <th>Observaciones</th>
                                            <th>Estatus</th>
                                            <th>Opción</th>
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
                                                    <a href='#'
                                                        class='btn btn-sm btn-clean btn-hover-icon-success btn-icon hrefEliminarDocumento'
                                                        data-id='{{ $partida->id }}'
                                                        data-documento='{{ $partida->segmento->segmentoTipoVehiculo->tipo_vehiculo }}'
                                                        data-toggle='tooltip' data-theme='dark' title='Eliminar'>
                                                        <i class='flaticon-delete'></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                <div class="row form-group">
                                    <div class="col-lg-12">
                                        <a href="#"
                                            class="btn btn-icon btn-outline-success btn-circle btn-sm mr-2 hrefAgregarOtro"
                                            data-toggle="tooltip" data-theme="dark" title="Agregar archivo">
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
                                <button type="button" id="btnGuardarUnidad" class="btn btn-success"><i class="la la-plus"></i>Guardar</button>
                                <a href="{{ route('requisiciones.catalogorequisicion') }}"
                                    class="btn btn-secondary"><i class="la la-arrow-left"></i>Regresar</a>
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
