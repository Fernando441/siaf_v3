@extends('layouts.app')
@section('title')
    Catálogo de requisiciones inactivas
@endsection

@push('scripts')
    <script src="{{ asset('js/licitaciones/requisicion/ListadoRequisiciones.js') }}"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
@endpush


@section('content')
    <div class="d-flex flex-row">

        <!--begin::List-->
        <div class="flex-row-fluid">
            <div class="d-flex flex-column flex-grow-1">

                <!--begin::Row-->
                <div class="row">
                    <div class="col-xl-12">

                        <!--begin::Card-->
                        <div class="card card-custom">
                            <div class="card-header">
                                <div class="card-title">
                                    <span class="card-icon">
                                        <i class="flaticon2-file text-primary"></i>
                                    </span>
                                    <h3 class="card-label">Catálogo de requisiciones inactivas</h3>
                                </div>
                                <div class="card-toolbar">

                                    <!--begin::Button-->
                                    <a href="{{ route('concurso.requisiciones.catalogorequisicion') }}"
                                        class="btn btn-light-primary font-weight-bolder mr-3 ml-3">
                                        Regresar</a>
                                    <!--end::Button-->

                                </div>
                            </div>
                            <div class="card-body">
                                <!--begin: Datatable-->
                                <table class="table table-hover table-checkable" id="kdatatable_requisicones_inactiva">
                                    <thead>
                                        <tr>
                                            <th>Folio</th>
                                            <th>Solicitante</th>
                                            <th>Area</th>
                                            <th>Estatus</th>
                                            <th>Fecha de solicitud</th>
                                            <th>Motivo</th>
                                            <th>Opciones</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($requisiones as $unid)
                                            <tr>
                                                <td>{{ $unid->folio }}</td>
                                                <td>{{ $unid->usersolicitante->name }}</td>
                                                <td>{{ $unid->areaPersonal->nombre_area }}</td>
                                                <td>Desactivado</td>
                                                <td>{{ $unid->fecha_solicitud }}</td>
                                                <td><span style="color: red;">{{ $unid->motivo_desactivar }}</span></td>

                                                <td class="text-center">
                                                    <button
                                                        class="btn btn-sm btn-clean btn-hover-icon-success btn-icon activar-requisicion"
                                                        data-id="{{ $unid->id }}" data-nombre="{{ $unid->folio }}"
                                                        data-toggle="tooltip" data-theme="dark"
                                                        title="Activar Requisicón"><i class="flaticon2-reply "></i></button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>

                                    <tfoot>
                                        <tr>
                                            <th>Folio</th>
                                            <th>Solicitante</th>
                                            <th>Area</th>
                                            <th>Estatus</th>
                                            <th>Fecha de solicitud</th>
                                            <th>Motivo</th>
                                            <th>Opciones</th>
                                        </tr>
                                    </tfoot>

                                </table>
                                <!--end: Datatable-->

                                <input type="hidden" id="datatable_i18n"
                                    value="{{ asset('/js/datatables/i18n/es-mx.json') }}">

                            </div>
                        </div>
                        <!--end::Card-->
                        <!--end::Card-->
                    </div>

                </div>
                <!--end::Row-->
            </div>
        </div>
        <!--end::List-->
    </div>

    <form method="post" id="requisicion_act_form" action="{{ route('concurso.requisiciones.activarrequisicion') }}"
        enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="id" id="id_requisicion_act" value="">
    </form>
@endsection
