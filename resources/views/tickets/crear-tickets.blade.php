@extends('layouts.app')
@push('scripts')
    <script src="{{ asset('js/cliente/AgregarCliente.js') }}"></script>
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
                <form class="form" action="{{ route('cliente.guardarCliente') }}" method="post" id="frmCliente"
                    enctype="multipart/form-data">
                    @csrf
                    <input type='hidden' id='url_municipios' value='{{ route('cliente.obtenermunicipios') }}'>
                    <input type='hidden' id='tipoArchivo' value=''>
                    <div class="card-body">
                        <!--begin::tabs-->
                        <ul class="nav nav-tabs nav-tabs-line">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#kt_tab_pane_1">Información del ticket</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#kt_tab_pane_2">Archivos</a>
                            </li>
                        </ul>
                        <div class="tab-content mt-5" id="myTabContent">
                            <div class="tab-pane fade show active mt-10" id="kt_tab_pane_1" role="tabpanel"
                                aria-labelledby="kt_tab_pane_1">
                                <div class="form-group row">
                                    <div class="col-lg-6">
                                        <label>Titulo</label>
                                        <div class="input-group">
                                            <input type="text" name="rfc" id="rfc" class="form-control specialCharts"
                                                required
                                                onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()" />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-12">
                                        <label>Descripcion</label>
                                        <div class="input-group">
                                            <input type="text" name="cedula_fiscal" id="cedula_fiscal" class="form-control"
                                                required
                                                onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()" />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-6">
                                        <label>Area</label>
                                        <select class="form-control" id="id_estado" name="id_estado" required>
                                            <option value="">Selecciona una opción</option>

                                        </select>
                                    </div>
                                    <div class="col-lg-6">
                                        <label>Usuario:</label>
                                        <select class="form-control" id="id_municipio" name="id_municipio" required>
                                            <option></option>
                                            {{-- <option value="">Selecciona una opción</option>
                                            @foreach($municipios as $municipio)
                                            <option value="{{ $municipio->id_municipio }}">{{ $municipio->municipio_nombre
                                                }}</option>
                                            @endforeach --}}
                                        </select>
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
                                                    <th>Adjuntar Documento</th>
                                                    <th>Tipo de Documento</th>
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
                                            data-toggle="tooltip" data-theme="dark" title="Agregar archivo">
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