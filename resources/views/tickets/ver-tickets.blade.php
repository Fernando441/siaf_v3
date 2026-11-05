@extends('layouts.app')
@push('scripts')
    <script src="{{ asset('js/tickets/CatalogoTickets.js') }}"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
@endpush
@section('title')
    Ver Ticket
@endsection
@section('content')
    <!--begin::Card-->
    <div class="row">
        <div class="col-lg-12">
            <!--begin::Card-->
            <div class="card card-custom gutter-b">
                <div class="card-header">
                    <h3 class="card-title">Ver Ticket</h3>

                </div>
                <!--begin::Form-->

                <div class="card-body">
                    <!--begin::tabs-->
                    <ul class="nav nav-tabs nav-tabs-line">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#kt_tab_pane_1">
                                Información del Ticket
                            </a>
                        </li>
                        <div class="ml-auto">
                            @if ($ticket->estatus == 1)
                                <span class="label font-weight-bold label-outline-success label-inline">
                                    FINALIZADO
                                </span>
                            @else
                                <button class="btn btn-success terminarTicketOriginal" title="Finalizar ticket"
                                    data-theme="dark" data-toggle="tooltip" data-id="{{ $ticket->id }}" data-placement="top">
                                    <i class="fas fa-check"></i> Finalizar
                                </button>
                            @endif
                        </div>


                    </ul>
                    <div class="tab-content mt-5" id="myTabContent">
                        <div class="tab-pane fade show active mt-10" id="kt_tab_pane_1" role="tabpanel"
                            aria-labelledby="kt_tab_pane_2">
                            <div class="form-group row">
                                <div class="col-lg-6">
                                    <label>Titulo</label>
                                    <div class="input-group">
                                        <p>{{ $ticket->titulo }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-6">
                                    <label>Descripcion</label>
                                    <div class="input-group">
                                        <p>{{ $ticket->descripcion }}</p>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <label>Fecha de creacion</label>
                                    <div class="input-group">
                                        <p>{{ $ticket->created_at }}</p>
                                    </div>
                                </div>
                            </div>
                            <table class="table table-hover table-checkable" id="ticket">
                                <thead>
                                    <tr>
                                        <th>Personas</th>
                                        <th>Estatus Visto</th>
                                        <th>Fecha Visto</th>
                                        <th>Estatus Finalizado</th>
                                        <th>Fecha Finalizado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($ticketinfouser as $ticket_principal)
                                        <tr>
                                            <td>{{ $ticket_principal->user->name }}</td>
                                            <td>
                                                @if ($ticket_principal->estatus_visto == 0)
                                                    <span class="label font-weight-bold label-outline-danger label-inline">
                                                        No Visto
                                                    </span>
                                                @else
                                                    <span class="label font-weight-bold label-outline-success label-inline">
                                                        Visto
                                                    </span>
                                                @endif
                                            </td>

                                            <td>
                                                @if ($ticket_principal->estatus_visto == 0)
                                                    <span>
                                                        -
                                                    </span>
                                                @else
                                                    <span>
                                                        {{ $ticket_principal->fecha_visto }}
                                                    </span>
                                                @endif

                                            </td>

                                            <td>
                                                @if ($ticket_principal->estatus_finalizado == 0)
                                                    <span class="label font-weight-bold label-outline-danger label-inline">
                                                        No Finalizado
                                                    </span>
                                                @else
                                                    <span class="label font-weight-bold label-outline-success label-inline">
                                                        Finalizado
                                                    </span>
                                                @endif
                                            </td>

                                            <td>
                                                @if ($ticket_principal->estatus_finalizado == 0)
                                                    <span>
                                                        -
                                                    </span>
                                                @else
                                                    <span>
                                                        {{ $ticket_principal->fecha_finalizado }}
                                                    </span>
                                                @endif

                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>


                        </div>
                        <div class="tab-pane fade mt-10" id="kt_tab_pane_2" role="tabpanel" aria-labelledby="kt_tab_pane_2">
                            <table class="table table-hover mb-6 table-responsive-sm" id="tblDocumentos">
                                <thead>
                                    <tr>
                                        <th scope="col">Documento</th>
                                        <th scope="col">Tipo de Documento</th>
                                    </tr>
                                </thead>
                                <tbody id='tbodyDocumentos'>

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!--end::tabs-->

                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-lg-6">
                            <a href="{{ route('tickets.catalogo-tickets') }}" class="btn btn-secondary"><i
                                    class="la la-arrow-left"></i>Regresar</a>
                        </div>
                    </div>
                </div>

                <!--end::Form-->
            </div>
            <!--end::Card-->
        </div>
    </div>
    <!--end::Card-->
    <form method="post" id="ticket_terminado_original" action="{{ route('tickets.terminadoticketoriginal') }}"
        enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="id" id="idticketerminadoriginal" value="">
    </form>
@endsection