@extends('layouts.app')
@push('scripts')
    <script src="{{ asset('js/tickets/CatalogoTickets.js') }}"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
@endpush

@section('title')
    Historial de Tickets
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
                                    <h3 class="card-label">Historial de Tickets Creados</h3>
                                </div>
                                <div class="card-toolbar">
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
                                            <th>Creado</th>
                                            <th>Fecha</th>
                                            
                                            <!-- <th>Estatus</th> -->
                                            <th class="text-center">Opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($tickets_historial as $ticket_historial)
                                            <tr>
                                                <td>{{ $ticket_historial->id }}</td>
                                                <td>{{ $ticket_historial->titulo }}</td>
                                                <td>{{ $ticket_historial->descripcion }}</td>
                                                <td>{{ $ticket_historial->user->name }}</td>
                                                <td>{{ $ticket_historial->created_at }}</td>
                                                
                                                <!-- <td>
                                                    @if ($ticket_historial->estatus == 0)
                                                        <span class="label font-weight-bold label-outline-warning label-inline">
                                                            Pendiente
                                                        </span>
                                                    @else
                                                        <span class="label font-weight-bold label-outline-success label-inline">
                                                            Finalizado
                                                        </span>
                                                    @endif
                                                </td> -->
                                                <td>
                                                    <a href="{{ route('tickets.ver-historial-tickets', $ticket_historial->id) }}"
                                                        class="btn btn-sm btn-clean btn-hover-icon-success btn-icon"
                                                        title="Ver ticket" data-theme="dark" data-toggle="tooltip"
                                                        data-placement="top">
                                                        <i class="flaticon-eye"></i>
                                                    </a>
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
@endsection