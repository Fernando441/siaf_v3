@extends('layouts.app')
@section('title')
    Listado de mantenimientos
@endsection

@push('scripts')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <script>
        // init kt_datatable with "es" as a default datatable language
        var datatable = $('#kt_datatable').DataTable({

            responsive: true,
            // Pagination settings
            dom: `<'row'<'col-sm-12'tr>>
                    <'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>`,

            lengthMenu: [5, 10, 25, 50],

            pageLength: 10,
            language: {
                lengthMenu: "Display _MENU_",
                url: $("#datatable_i18n").val(),
            },
        });
    </script>
@endpush

@section('content')
    <div class="d-flex flex-row">

        <!--begin::List-->
        <div class="flex-row-fluid">
            <div class="d-flex flex-column flex-grow-1">

                <!--begin::Row-->
                <div class="row">
                    <div class="col-xl-12">
                        <div class="container">
                            <!--begin::Profile Personal Information-->
                            <div class="d-flex flex-row">
                                <!--begin::Content-->
                                <div class="flex-row-fluid">
                                    <!--begin::Card-->
                                    <div class="card card-custom card-stretch">
                                        <!--begin::Header-->
                                        <div class="card-header py-3">
                                            <div class="card-title align-items-start flex-column">
                                                <h3 class="pt-2"><i class="flaticon-user-settings text-dark pr-3"></i> Listado de
                                                    mantenimientos de {{ Auth::user()->name }}</h3>
                                            </div>
                                        </div>
                                        <!--end::Header-->

                                        <!--begin::Form-->
                                        <form autocomplete="off" class="form" id="buscarunidad" method="POST"
                                            enctype="multipart/form-data" action="{{ route('taller.buscarunidad') }}">
                                            @csrf
                                            <input autocomplete="false" name="hidden" type="text" style="display:none;">
                                            <div class="card-body pb-1">

                                                <table class="table table-bordered table-hover table-checkable"
                                                    id="kt_datatable">
                                                    <thead>
                                                        <tr>
                                                            <th>Tipo</th>
                                                            <th>Taller asignado</th>
                                                            <th>Fecha de solicitud</th>
                                                            <th>Fecha de cita</th>
                                                            <th>No. Serie</th>
                                                            <th>Estado</th>
                                                            <th>Opciones</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        {{-- 1 pendiente
                                                        2 preautorizado
                                                        3 autorizado
                                                        4 con evidencia
                                                        5 tesorería
                                                        6 finalizado
                                                        7 incompleto
                                                        8 rechazado --}}
                                                        @foreach ($solicitudes as $solicitud)
                                                            <tr>
                                                                <td style="text-transform: capitalize;">
                                                                    {{ $solicitud->tipo_solicitud }}</th>
                                                                <td style="text-transform: capitalize;"
                                                                >{{ $solicitud->taller->nombre }}</td>
                                                                <td>
                                                                    {{ date('d/m/Y h:m', strtotime($solicitud->fecha_solicitud)) }}
                                                                </td>
                                                                <td>{{ date('d/m/Y h:m', strtotime($solicitud->fecha_cita)) }}
                                                                </td>
                                                                <td>{{ $solicitud->unidad->no_serie }}</td>
                                                                <td>
                                                                    @if ($solicitud->tallerSolicitudEstado->estado == 'pendiente')
                                                                        <span
                                                                            class="label label-lg font-weight-bold label-light-warning label-inline">Registrado</span>
                                                                    @elseif($solicitud->tallerSolicitudEstado->estado == 'preautorizado')
                                                                        <span
                                                                            class="label label-lg font-weight-bold label-light-primary label-inline">En revisión</span>
                                                                    @elseif($solicitud->tallerSolicitudEstado->estado == 'autorizado')
                                                                        <span
                                                                            class="label label-lg font-weight-bold label-light-success label-inline">En taller</span>
                                                                    @elseif($solicitud->tallerSolicitudEstado->estado == 'con evidencia')
                                                                        <span
                                                                            class="label label-lg font-weight-bold label-light-info label-inline">Proceso de salida</span>
                                                                    @elseif($solicitud->tallerSolicitudEstado->estado == 'tesorería')
                                                                        <span
                                                                            class="label label-lg font-weight-bold label-light-danger label-inline">Proceso de salida</span>
                                                                    @elseif($solicitud->tallerSolicitudEstado->estado == 'finalizado')
                                                                        <span
                                                                            class="label label-lg font-weight-bold label-light-success label-inline">Finalizado</span>
                                                                    @elseif($solicitud->tallerSolicitudEstado->estado == 'incompleto')
                                                                        <span
                                                                            class="label label-lg font-weight-bold label-light-warning label-inline">Incompleto</span>
                                                                    @elseif($solicitud->tallerSolicitudEstado->estado == 'rechazado')
                                                                        <span
                                                                            class="label label-lg font-weight-bold label-light-danger label-inline">Rechazado</span>
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    <a href="#"
                                                                        class="btn btn-sm btn-clean btn-hover-icon-success btn-icon"
                                                                        data-toggle="tooltip" data-placement="top"
                                                                        data-theme="dark" title="Ver mantenimiento">
                                                                        <i class="flaticon-eye"></i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>

                                                </table>

                                            </div>
                                            <div class="card-footer">
                                                <div class="row">
                                                    <div class="col-lg-12 d-flex" style="justify-content: space-between;">
                                                        <a href="{{ route('tablero.show') }}"
                                                            class="btn btn-secondary btn-lg"><i class="la la-arrow-left"></i>Regresar</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <!--end::Content-->
                            </div>
                            <!--end::Profile Personal Information-->
                        </div>
                    </div>
                    <input type="hidden" id="datatable_i18n" value="{{ asset('/js/datatables/i18n/es-mx.json') }}">
                </div>
                <!--end::Row-->
            </div>
        </div>
        <!--end::List-->
    </div>
@endsection
