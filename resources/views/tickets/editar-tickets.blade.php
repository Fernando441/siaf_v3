@extends('layouts.app')
@push('scripts')
    <script src="{{ asset('js/tickets/EditarTickets.js') }}"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
@endpush
@section('title')
    Editar tickets
@endsection
@section('content')
    <!--begin::Card-->
    <div class="row">
        <div class="col-lg-12">
            <!--begin::Card-->
            <div class="card card-custom gutter-b">
                <div class="card-header">
                    <h3 class="card-title">Editar ticket</h3>
                </div>
                <!--begin::Form-->
                <input type="hidden" id="documentoEliminarPath" value="{{ route('tickets.eliminardocumentocliente') }}">

                <form class="form" action="{{ route('tickets.editarTicket') }}" method="post" id="frmCliente"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="tipoArchivo" value="{{ json_encode(json_decode($cadenaTipoDocumento)) }}">
                    <input type="hidden" name="id" id="id" value="{{ $editar_ticket->id }}">
                    <div class="card-body">
                        <!--begin::tabs-->
                        <ul class="nav nav-tabs nav-tabs-line">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#kt_tab_pane_1">Información del
                                    Cliente</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#kt_tab_pane_2">Archivos</a>
                            </li>
                        </ul>
                        <div class="tab-content mt-5" id="myTabContent">
                            <div class="tab-pane fade show active mt-10" id="kt_tab_pane_1" role="tabpanel"
                                aria-labelledby="kt_tab_pane_2">
                                <div class="form-group row">
                                    <div class="col-lg-6">
                                        <label>Titulo</label>
                                        <div class="input-group">
                                            <input type="text" name="titulo" id="titulo" minlength="12" maxlength="13"
                                                class="form-control specialCharts" value="{{ $editar_ticket->titulo }}"
                                                required
                                                onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()" />
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <label>Descripcion</label>
                                        <div class="input-group">
                                            <input type="text" name="descripcion" id="descripcion"
                                                class="form-control specialCharts" value="{{ $editar_ticket->descripcion }}"
                                                required
                                                onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade mt-10" id="kt_tab_pane_2" role="tabpanel"
                                aria-labelledby="kt_tab_pane_2">

                                <div class="row form-group">
                                    <div class="col-lg-12" id="tblArchivos">
                                        <table class='table table-bordered table-hover' id='tblDocumentos'>
                                            <thead>
                                                <tr>
                                                    <th>Personal</th>
                                                    <th>Opción</th>
                                                </tr>
                                            </thead>
                                            <tbody id='tbodyDocumentos'>
                                                @foreach($ticket_usuarios_update as $ticket_usuario_update)
                                                    <tr id="trDocumento{{ $ticket_usuario_update->id }}">
                                                        <td>{{ $ticket_usuario_update->user->name }}</td>
                                                        <td>
                                                            <a href='#'
                                                                class='btn btn-sm btn-clean btn-hover-icon-success btn-icon hrefEliminarDocumento'
                                                                data-id='{{ $ticket_usuario_update->id }}'
                                                                data-documento='{{ $ticket_usuario_update->user->name }}'
                                                                data-toggle='tooltip' data-theme='dark' title='Eliminar'>
                                                                <i class='flaticon-delete'></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>


                                <div class="row form-group">
                                    <div class="col-lg-12">
                                        <a href="#"
                                            class="btn btn-icon btn-outline-success btn-circle btn-sm mr-2 hrefAgregarOtro"
                                            data-toggle="tooltip" data-theme="dark" title="Agregar personal">
                                            <i class="flaticon2-plus"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end::tabs-->

                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-lg-6">
                                <button type="button" id="btnGuardar" class="btn btn-success"><i
                                        class="la la-plus"></i>Guardar</button>
                                <a href="{{ route('tickets.catalogo-tickets') }}" class="btn btn-secondary"><i
                                        class="la la-arrow-left"></i>Regresar</a>
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