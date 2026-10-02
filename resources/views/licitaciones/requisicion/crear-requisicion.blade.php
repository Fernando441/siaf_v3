@extends('layouts.app')
@section('title')
    Nueva requisición sin contrato
@endsection
@push('scripts')
    <script src="{{ asset('js/licitaciones/requisicion/CrearRequisicion.js') }}"></script>
@endpush
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <!--begin::Card-->
            <div class="card card-custom gutter-b">
                <div class="card-header">
                    <h3 class="card-title">Nueva requisición sin contrato</h3>
                </div>
                <!--begin::Form-->
                <input type='hidden' id='tipovehiculo' value='{{ $cadenatipovehiculo }}'>
                <form class="form" action="{{ route('requisiciones.guardarrequisicion') }}" method="post"
                    id="formCrearRequisicion" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">


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
                                        <select class="form-control" name="solicitante" id="solicitante" readonly required>
                                            <option value="">Selecciona un opción</option>
                                            @foreach ($solicitante as $cli)
                                                <option value="{{ $cli->id }}"
                                                    @if ($cli->id == Auth::user()->id) selected @endif>{{ $cli->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-lg-6">
                                        <label>Area</label>
                                        <select class="form-control" name="area" id="area" readonly required>
                                            <option value="">Selecciona un opción</option>
                                            @foreach ($area_personal as $cli)
                                                @if (Auth::user()->area_personal_id != 0 || Auth::user()->area_personal_id != null)
                                                        <option value="{{ $cli->id }}" @if ($cli->id == Auth::user()->area_personal_id) selected @endif>
                                                            {{ $cli->nombre_area }}
                                                        </option>
                                                @else
                                                    <option value="{{ $cli->id }}">{{ $cli->nombre_area }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col-lg-6">
                                        <label>Fecha de Solicitud</label>
                                        <div class="input-group date" id="kt_datetimepicker_1" data-target-input="nearest">
                                            <input type="text" class="form-control datetimepicker-input" placeholder="Select date & time" name="fecha_solicitud" data-target="#kt_datetimepicker_1"/>
                                            <div class="input-group-append" data-target="#kt_datetimepicker_1" data-toggle="datetimepicker">
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

                                <div class="row form-group">


                                    <div class="col-lg-12" id="tblArchivos">
                                        <table class='table table-bordered table-hover' id='tblDocumentos'>
                                            <thead>
                                                <tr>
                                                    <th>Descripción</th>
                                                    <th>Cantidad</th>
                                                    <th>Observaciones</th>
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
                                    class="btn btn-secondary"><i class="la la-times"></i>Cancelar</a>
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
