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
                                    <h3 class="card-label">Tickets Pendientes</h3>
                                </div>
                                <div class="card-toolbar">




                                    <!--begin::Button-->
                                    @if (in_array("34", Session::get('permisos')))
                                        <a href="{{ route('tickets.catalogo-tickets') }}"
                                            class="btn btn-light-primary font-weight-bolder mr-3 ml-3">
                                            <i class="la la-arrow-left"></i>Regresar</a>
                                        
                                    @endif
                                    <input type="hidden" id="op_busqueda" value="1">
                                    <!--end::Button-->

                                    


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
                                            <th>Ticket</th>
                                            <th>Fecha de creación</th>
                                            <th>Visualizado</th>
                                            <th>Fecha visto</th>
                                            <th>Finalizado</th>
                                            <th>Fecha Finalizado</th>
                                            <th class="text-center">Opciones</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach($tickets_pendientes as $ticket_pendiente)
                                            <tr>
                                                <td>{{ $ticket_pendiente->id }}</td>
                                                <td>{{ $ticket_pendiente->ticket->titulo }}</td>
                                                <td>{{ $ticket_pendiente->ticket->created_at }}</td>
                                                <td>
                                                    @if ($ticket_pendiente->estatus_visto == 0)
                                                        <span class="label font-weight-bold label-outline-danger label-inline">No Visto</span>
                                                    @else
                                                        <span class="label font-weight-bold label-outline-success label-inline">Visto</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($ticket_pendiente->estatus_visto == 0)
                                                        -
                                                    @else
                                                        {{ $ticket_pendiente->fecha_visto }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($ticket_pendiente->estatus_finalizado == 0)
                                                        <span class="label font-weight-bold label-outline-danger label-inline">No Finalizado</span>
                                                    @else
                                                        <span class="label font-weight-bold label-outline-success label-inline">Finalizado</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($ticket_pendiente->estatus_finalizado == 0)
                                                        -
                                                    @else
                                                        {{ $ticket_pendiente->fecha_finalizado }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($ticket_pendiente->estatus_visto == 1)
                                                        <a href="{{ route('tickets.ver-tickets-pendientes', $ticket_pendiente->id) }}" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon"
                                                        title="Ver ticket" data-theme="dark" data-toggle="tooltip"
                                                        data-placement="top">
                                                        <i class="flaticon-eye"></i>
                                                    </a>
                                                    @else
                                                    <button 
                                                        class="btn btn-sm btn-clean btn-hover-icon-success btn-icon verTicket"
                                                        title="Ver ticket"
                                                        data-theme="dark"
                                                        data-toggle="tooltip"
                                                        data-id="{{$ticket_pendiente->id}}"
                                                        
                                                        data-placement="top">
                                                        <i class="flaticon-eye"></i>
                                                    </button>
                                                    @endif
                                                    
                                                </td>
                                                
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <!--end: Datatable-->

                                
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
 <form method="post" id="ticket_form" action="{{ route('tickets.updateTicket') }}" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="id" id="idticket" value="">
  </form> 
   


@endsection