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
        <div class="flex-row-fluid">
            <div class="d-flex flex-column flex-grow-1">

                <div class="row">
                    <div class="col-xl-12">

                        <!-- TARJETA PRINCIPAL -->
                        <div class="card card-custom">

                            <!-- ENCABEZADO -->
                            <div class="card-header">
                                <div class="card-title">
                                    <span class="card-icon">
                                        <i class="flaticon2-file text-primary"></i>
                                    </span>
                                    <h3 class="card-label">
                                        Historial de Tickets Creados
                                    </h3>
                                </div>

                                <div class="card-toolbar">
                                    <input type="hidden" id="op_busqueda" value="1">

                                    <div class="dropdown dropdown-inline mr-2">
                                        <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                                            <ul class="navi flex-column navi-hover py-2">
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- CUERPO -->
                            <div class="card-body">

                                <!-- ESTADISTICAS -->
                                <div class="row dashboard-stats">

                                    <!-- TOTAL DE TICKETS -->
                                    <div class="col-xl-3 col-lg-6 col-md-6">
                                        <div class="stat-card stat-blue">
                                            <div class="stat-content">
                                                <div class="stat-value">
                                                    {{ count($tickets_historial) }}
                                                </div>
                                                <div class="stat-label">
                                                    Total de Tickets
                                                </div>
                                            </div>

                                            <div class="stat-icon">
                                                <i class="fas fa-ticket-alt"></i>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- TICKETS FINALIZADOS -->
                                    <div class="col-xl-3 col-lg-6 col-md-6">
                                        <div class="stat-card stat-cyan">
                                            <div class="stat-content">
                                                <div class="stat-value">
                                                    {{ $tickets_historial->where('estatus', 1)->count() }}
                                                </div>
                                                <div class="stat-label">
                                                    Tickets Finalizados
                                                </div>
                                            </div>

                                            <div class="stat-icon">
                                                <i class="fas fa-check-circle"></i>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- TICKETS PENDIENTES -->
                                    <div class="col-xl-3 col-lg-6 col-md-6">
                                        <div class="stat-card stat-gold">
                                            <div class="stat-content">
                                                <div class="stat-value">
                                                    {{ $tickets_historial->where('estatus', 0)->count() }}
                                                </div>
                                                <div class="stat-label">
                                                    Tickets Pendientes
                                                </div>
                                            </div>

                                            <div class="stat-icon">
                                                <i class="fas fa-clock"></i>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- PORCENTAJE FINALIZADO -->
                                    <div class="col-xl-3 col-lg-6 col-md-6">
                                        <div class="stat-card stat-red">
                                            <div class="stat-content">
                                                <div class="stat-value">
                                                    {{ count($tickets_historial) > 0
        ? round(($tickets_historial->where('estatus', 1)->count() / count($tickets_historial)) * 100)
        : 0 }}%
                                                </div>
                                                <div class="stat-label">
                                                    Tickets finalizados al
                                                </div>
                                            </div>

                                            <div class="stat-icon">
                                                <i class="fas fa-chart-pie"></i>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <!-- FIN ESTADISTICAS -->

                                <div class="collapse" id="collapseExample">
                                    <div class="card card-body">
                                    </div>
                                </div>

                                <!-- TABLA -->
                                <table class="table table-hover table-checkable" id="ticket">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Titulo</th>
                                            <th>Descripcion</th>
                                            <th>Creado</th>
                                            <th>Fecha</th>
                                            <th>Estatus</th>
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

                                                <td>
                                                    @if ($ticket_historial->estatus == 1)
                                                        <span class="label font-weight-bold label-outline-success label-inline">
                                                            FINALIZADO
                                                        </span>
                                                    @else
                                                        <span class="label font-weight-bold label-outline-warning label-inline">
                                                            PENDIENTE
                                                        </span>
                                                    @endif
                                                </td>

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
                            <!-- FIN CARD BODY -->

                        </div>
                        <!-- FIN CARD -->

                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection