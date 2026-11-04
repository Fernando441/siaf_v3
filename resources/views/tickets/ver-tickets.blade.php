@extends('layouts.app')

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
                            <a class="nav-link active" data-toggle="tab" href="#kt_tab_pane_1">Información del Ticket</a>
                        </li>
                    </ul>
                    <div class="tab-content mt-5" id="myTabContent">
                        <div class="tab-pane fade show active mt-10" id="kt_tab_pane_1" role="tabpanel"
                            aria-labelledby="kt_tab_pane_2">
                            <div class="form-group row">
                                <div class="col-lg-6">
                                    <label>Titulo</label>
                                    <div class="input-group">
                                        <p>{{ $ticket_pendiente->ticket->titulo }}</p>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <label>Fecha de visto</label>
                                    <div class="input-group">
                                        <p>{{ $ticket_pendiente->fecha_visto }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-6">
                                    <label>Descripcion</label>
                                    <div class="input-group">
                                        <p>{{ $ticket_pendiente->ticket->descripcion }}</p>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <label>Estatus visto</label>
                                    <div class="input-group">
                                        
                                        @if ($ticket_pendiente->estatus_visto == 0)
                                            <span class="label font-weight-bold label-outline-danger label-inline">No Visto</span>
                                        @else
                                            <span class="label font-weight-bold label-outline-success label-inline">Visto</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <label>Fecha de creacion</label>
                                    <div class="input-group">
                                        <p>{{ $ticket_pendiente->created_at }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-6">
                                    <label>Persona que asigno</label>
                                    <div class="input-group">
                                        <p>{{ $ticket_pendiente->user->name }}</p>
                                    </div>
                                </div>

                            </div>


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
                            <a href="{{ route('tickets.catalogo-tickets-pendientes') }}" class="btn btn-secondary"><i
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


@endsection