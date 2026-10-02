@extends('layouts.app')
@section('title')
    Nueva requisición
@endsection
@push('scripts')
    <script src="{{ asset('js/licitaciones/requisicion/CrearRequisicionConcurso.js') }}"></script>
    <script>
        $('#kt_datetimepicker_1').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
            locale: 'es',
            defaultDate: new Date()
        });
    </script>
@endpush
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <!--begin::Card-->
            <div class="card card-custom gutter-b">
                <div class="card-header">
                    <h3 class="card-title">Nueva requisición</h3>
                </div>
                <!--begin::Form-->
                <form class="form" action="{{ route('concurso.requisiciones.guardarrequisicion') }}" method="post"
                    id="formCrearRequisicion" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">


                        <!--begin::tabs-->
                        <ul class="nav nav-tabs nav-tabs-line">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#kt_tab_pane_1">Datos generales</a>
                            </li>
                        </ul>
                        <div class="tab-content mt-5" id="myTabContent">
                            <div class="tab-pane fade show active mt-10" id="kt_tab_pane_1" role="tabpanel"
                                aria-labelledby="kt_tab_pane_2">

                                <div class="row form-group">
                                    <div class="col-lg-6">
                                        <label>Solicitante</label>
                                        {{-- <select class="form-control" name="solicitante" id="solicitante" readonly required>
                                            <option value="">Selecciona un opción</option>
                                            @foreach ($solicitante as $cli)
                                                <option value="{{ $cli->id }}"
                                                    @if ($cli->id == Auth::user()->id) selected @endif>{{ $cli->name }}
                                                </option>
                                            @endforeach
                                        </select> --}}
                                        {{-- Input readonly --}}
                                        <input class="form-control" type="text" value="{{ Auth::user()->name }}" readonly>
                                        <input type="hidden" name="solicitante" value="{{ Auth::user()->id }}" required>
                                        <small class="form-text text-muted">El solicitante es el usuario que está
                                            logueado</small>
                                    </div>

                                    <div class="col-lg-6">
                                        <label>Area</label>
                                        {{-- <select class="form-control" name="area" id="area" readonly required>
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
                                        </select> --}}
                                        <input class="form-control" type="text" value="{{ Auth::user()->areaPersonal->nombre_area }}" readonly>
                                        <input type="hidden" name="area" value="{{ Auth::user()->area_personal_id }}" required>
                                        <small class="form-text text-muted">Área del usuario que está
                                            logueado</small>
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col-lg-6">
                                        <label>Fecha de Solicitud</label>
                                        <div class="input-group date" id="kt_datetimepicker_1" data-target-input="nearest">
                                            <input type="text" class="form-control datetimepicker-input"
                                                placeholder="Select date & time" name="fecha_solicitud"
                                                data-target="#kt_datetimepicker_1" />
                                            <div class="input-group-append" data-target="#kt_datetimepicker_1"
                                                data-toggle="datetimepicker">
                                                <span class="input-group-text">
                                                    <i class="ki ki-calendar"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <label>Concurso</label>
                                        <select class="form-control" name="licitacion" id="licitacion" required>
                                            <option value="">Selecciona un opción</option>
                                            @foreach ($licitacionesArray as $licitacion)
                                                <option value="{{ $licitacion->id }}">No.
                                                    {{ $licitacion->no_licitacion }} -
                                                    {{ $licitacion->titulo_servicio }} - Fecha acto fallo:
                                                    {{ $licitacion->acto_fallo }} 
                                                </option>
                                            @endforeach
                                        </select>
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
                                <a href="{{ route('concurso.requisiciones.catalogorequisicion') }}"
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
