@extends('layouts.app')
@push('scripts')
    <script src="{{ asset('js/tickets/AgregarTickets.js') }}"></script>
@endpush
@section('title')
    Generar Ticket
@endsection
@section('content')

    <!--begin::Card-->
    <div class="row">
        <div class="col-lg-12">
            <!--begin::Card-->
            <div class="card card-custom gutter-b">
                <div class="card-header">
                    <h3 class="card-title">Generar Ticket</h3>
                </div>

                <!--begin::Form-->
                <form class="form" action="{{ route('tickets.guardarTickets') }}" method="post" id="frmTickets"
                    enctype="multipart/form-data">
                    @csrf
                    <!-- <input type='hidden' id='url_municipios' value='{{ route('cliente.obtenermunicipios') }}'> -->
                    <input type='hidden' id='tipoArchivo' value='{{ $cadenaTipoDocumento }}'>
                    <div class="card-body">
                        <!--begin::tabs-->
                        <ul class="nav nav-tabs nav-tabs-line">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#kt_tab_pane_1">Información del
                                    ticket</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#kt_tab_pane_2">Asignar</a>
                            </li>
                        </ul>
                        <div class="tab-content mt-5" id="myTabContent">
                            <div class="tab-pane fade show active mt-10" id="kt_tab_pane_1" role="tabpanel"
                                aria-labelledby="kt_tab_pane_1">
                                <div class="form-group row">
                                    <div class="col-lg-6">
                                        <label>Titulo</label>
                                        <div class="input-group">
                                            <input type="text" name="titulo" id="titulo" class="form-control specialCharts"
                                                required
                                                onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()" />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-12">
                                        <label>Descripcion</label>
                                        <div class="input-group">
                                            <textarea class="form-control specialCharts" name="descripcion" id="descripcion"
                                                onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"></textarea>
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