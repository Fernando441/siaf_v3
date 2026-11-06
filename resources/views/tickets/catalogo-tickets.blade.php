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
                                    @endif
                                    <input type="hidden" id="op_busqueda" value="1">

                                    <!--begin::Dropdown-->
                                    <div class="dropdown dropdown-inline mr-2">

                                        <!--begin::Dropdown Menu-->
                                        <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                                            <!--begin::Navigation-->
                                            <ul class="navi flex-column navi-hover py-2">
                                            </ul>
                                        </div>
                                    </div>
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
                                            <th>Estatus</th>
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
                                                <td>
                                                    @if ($ticket_activo->estatus == 0)
                                                        <span class="label font-weight-bold label-outline-warning label-inline">
                                                            Pendiente
                                                        </span>
                                                    @else
                                                        <span class="label font-weight-bold label-outline-success label-inline">
                                                            Finalizado
                                                        </span>
                                                    @endif
                                                </td>
                                                <td><a href="{{ route('tickets.ver-tickets', $ticket_activo->id) }}"
                                                        class="btn btn-sm btn-clean btn-hover-icon-success btn-icon"
                                                        title="Ver ticket" data-theme="dark" data-toggle="tooltip"
                                                        data-placement="top">
                                                        <i class="flaticon-eye"></i>
                                                    </a>
                                                    @if ($ticket_activo->estatus_usuarios == 0)
                                                        <a href="{{ route('tickets.editar-tickets', $ticket_activo->id)}}"
                                                            class="btn btn-sm btn-clean btn-hover-icon-success btn-icon"
                                                            title="Editar ticket" data-theme="dark" data-toggle="tooltip"
                                                            data-placement="top">
                                                            <i class="flaticon-edit"></i>
                                                        </a>
                                                        <button
                                                            class="btn btn-sm btn-clean btn-hover-icon-success btn-icon eliminarTicket"
                                                            title="Eliminar ticket" data-theme="dark" data-toggle="tooltip"
                                                            data-id="{{ $ticket_activo->id }}" data-placement="top">
                                                            <i class="flaticon-delete"></i>
                                                        </button>
                                                        <!-- <a class="btn btn-sm btn-clean btn-hover-icon-success btn-icon" onClick=""
                                                                                    data-toggle="modal" data-target="#model_delete_user"
                                                                                    data-toggle="tooltip" data-theme="dark" title="Eliminar ticket">
                                                                                    <i class="flaticon-delete"></i>
                                                                                </a> -->
                                                    @else

                                                    @endif

                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <form method="post" id="ticket_terminado" action="{{ route('tickets.eliminarTicket') }}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="id" id="idticketerminado" value="">
    </form>
@endsection