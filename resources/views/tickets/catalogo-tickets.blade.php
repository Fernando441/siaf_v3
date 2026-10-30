@extends('layouts.app')
@push('scripts')
    <script src="{{ asset('js/tickets/CatalogoTickets.js') }}"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
@endpush

@section('title')
    Catalogo de Tickets
@endsection

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
                                    <h3 class="card-label">Catalogo de Tickets Creados</h3>
                                </div>
                                <div class="card-toolbar">




                                    <!--begin::Button-->
                                    @if (in_array("34", Session::get('permisos')))
                                        <a href="{{ route('tickets.crear-tickets') }}"
                                            class="btn btn-light-primary font-weight-bolder mr-3 ml-3">
                                            <i class="la la-plus"></i>Nuevo ticket</a>
                                        <a href="{{ route('tickets.catalogo-tickets-pendientes') }}"
                                            class="btn btn-light-primary font-weight-bolder mr-3 ml-3">
                                            <i class="la la-plus"></i>Tickets Pendientes</a>
                                    @endif
                                    <input type="hidden" id="op_busqueda" value="1">
                                    <!--end::Button-->

                                    <a href="{{ route('tickets.catalogo-tickets-inactivos') }}"
                                        class="btn btn-light-primary font-weight-bolder mr-3 ml-3">
                                        <i class="far fa-trash-alt"></i>Tickets terminados</a>


                                    <!--begin::Dropdown-->
                                    <div class="dropdown dropdown-inline mr-2">

                                        <!--begin::Dropdown Menu-->
                                        <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                                            <!--begin::Navigation-->
                                            <ul class="navi flex-column navi-hover py-2">



                                            </ul>
                                            <!--end::Navigation-->
                                        </div>
                                        <!--end::Dropdown Menu-->
                                    </div>
                                    <!--end::Dropdown-->




                                </div>
                            </div>
                            <div class="card-body">

                                <div class="collapse" id="collapseExample">
                                    <div class="card card-body">




                                    </div>
                                </div>

                                <!--begin: Datatable-->
                                <table class="table table-hover table-checkable" id="ticket">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Titulo</th>
                                            <th>Descripcion</th>
                                            <th>Fecha</th>
                                            <th class="text-center">Opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($tickets_activos as $ticket_activo)
                                            <tr>
                                                <td>{{ $ticket_activo->id }}</td>
                                                <td>{{ $ticket_activo->titulo }}</td>
                                                <td>{{ $ticket_activo->descripcion }}</td>
                                                <td>{{ $ticket_activo->created_at }}</td>
                                                <td><a href="" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon"
                                                        title="Ver ticket" data-theme="dark" data-toggle="tooltip"
                                                        data-placement="top">
                                                        <i class="flaticon-eye"></i>
                                                    </a>
                                                    <a href="" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon"
                                                        title="Editar ticket" data-theme="dark" data-toggle="tooltip"
                                                        data-placement="top">
                                                        <i class="flaticon-edit"></i>
                                                    </a>
                                                    <a class="btn btn-sm btn-clean btn-hover-icon-success btn-icon" onClick=""
                                                        data-toggle="modal" data-target="#model_delete_user"
                                                        data-toggle="tooltip" data-theme="dark" title="Eliminar ticket">
                                                        <i class="flaticon-delete"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>

                                </table>
                                <!--end: Datatable-->

                                <!-- <input type="hidden" id="datatable_i18n"
                                                    value="{{ asset('/js/datatables/i18n/es-mx.json') }}">
                                                <input type="hidden" id="clientedatatable" value="{{ route('cliente.clientedatatable') }}"> -->
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



    {{-- M O D A L S --}}
    <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"
        id="model_delete_user">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Desactivar cliente</h5>
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                        aria-label="Close">
                        <span class="svg-icon svg-icon-2x"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection