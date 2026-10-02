@extends('layouts.app')
@section('title')
    Gestor de documentos
@endsection

@push('scripts')
    <script src="{{ asset('js/licitaciones/gestordocumentos/gestorDocumentos.js') }}"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
@endpush

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
                                        <i class="flaticon-tabs text-primary"></i>
                                    </span>
                                    <h3 class="card-label">Catalogo de documentos</h3>
                                </div>
                                <div class="card-toolbar">

                                    <a class="btn btn-link-primary font-weight-bold mr-2 busqueda" data-toggle="collapse"
                                        href="#collapseExample" role="button" aria-expanded="false"
                                        aria-controls="collapseExample">
                                        Busqueda avanzada
                                    </a>

                                </div>
                            </div>
                            <div class="card-body">

                                <div class="collapse" id="collapseExample">
                                    <div class="card card-body mb-5">
                                        <!--begin: Search Form-->
                                        <form class="mb-8">
                                            <div class="row mb-6">
                                                <div class="col-lg-4 mb-lg-0 mb-4">
                                                    <label>Busqueda de documento:</label>
                                                    <input type="text" name="search" id="search"
                                                        placeholder="Buscar por nombre de documento y comentarios"
                                                        class="form-control datatable-input kt-input" data-col-index="1" />
                                                </div>
                                                <div class="col-lg-4 mb-lg-0 mb-4">
                                                    <label>Tipo de documento:</label>
                                                    <select class="form-control kt-selectpicker" name="tipoDocumento"
                                                        id="busquedaTipoDocumento" data-live-search="true"
                                                        data-col-index="3">
                                                        <option value="">Seleccione un tipo de documento</option>
                                                        @foreach ($tipoDocumentos as $tipoDocumento)
                                                            <option value="{{ $tipoDocumento->informacion }}">
                                                                {{ $tipoDocumento->informacion }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-lg-4 mb-lg-0 mb-4">
                                                    <label>Fecha:</label>
                                                    <div class="input-daterange input-group">
                                                        <select class="form-control" id="year">
                                                            <option value="">Año</option>
                                                        </select>
                                                        <select class="form-control" id="month">
                                                            <option value="">Mes</option>
                                                        </select>
                                                        <select class="form-control" id="day">
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col-lg-6 mb-lg-0">
                                                    <div class="mt-2">
                                                        <input type="checkbox" data-switch="true"
                                                            name="mostrarArchivosSubidosPorMi"
                                                            id="mostrarArchivosSubidosPorMi" value="false"
                                                            data-on-text="SI" data-off-text="NO" data-on-color="primary"
                                                            data-size="sm" />
                                                            Solo mostrar archivos subidos por mi
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mt-8">
                                                <div class="col-lg-12 d-flex">
                                                    <button class="btn btn-secondary btn-secondary--icon" id="kt_reset">
                                                        <span><i class="la la-close"></i><span>Limpiar</span></span>
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <!--bein::Formulario-->
                                @if (in_array('137', Session::get('permisos')))
                                    <form method="post" action="{{ route('gestordocumentos.guardardocumento') }}"
                                        id="form_documentos" enctype="multipart/form-data">
                                        <input type='hidden' id='tipoDocumentos' value='{{ $jsonTipoDocumentos }}'>
                                        @csrf
                                        <!--begin::Formulario -->
                                        <div class="row form-group">
                                            <div class="col-lg-12" id="tblArchivos">
                                                <table class='table table-responsive-lg table-bordered table-hover' id='tblFormDocumentos'>
                                                    <thead>
                                                        <tr>
                                                            <th>Documento</th>
                                                            <th>Tipo de Documento</th>
                                                            <th>Comentarios</th>
                                                            <th>Fecha</th>
                                                            <th>Opción</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id='tbodyDocumentos'>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <div class="row form-group">
                                            <div class="col-lg-12 d-flex" style="justify-content: space-between">
                                                <a href="#"
                                                    class="btn btn-icon btn-outline-success btn-circle btn-sm mr-2 hrefAgregarOtroDocumento"
                                                    data-toggle="tooltip" data-theme="dark" title="Agregar archivo">
                                                    <i class="flaticon2-plus"></i>
                                                </a>

                                                <button type="button" id="btnGuardarDocumentos" class="btn btn-primary"
                                                    title="Subir documentos">
                                                    Subir Documentos
                                                </button>
                                            </div>
                                        </div>
                                        <!--end::Formulario -->
                                    </form>
                                @endif
                                <!--begin: Datatable-->
                                <table class="table table-responsive-lg table-hover table-checkable " id="tblDocumentos">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Documento</th>
                                            <th>Tamaño</th>
                                            <th>Tipo de documento</th>
                                            <th>Comentario</th>
                                            <th>Fecha de carga</th>
                                            <th>Fecha de creacion</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                    </tbody>



                                </table>
                                <!--end: Datatable-->

                                <input type="hidden" id="datatable_i18n"
                                    value="{{ asset('/js/datatables/i18n/es-mx.json') }}">
                                <input type="hidden" id="gestordatatable"
                                    value="{{ route('gestordocumentos.gestordocumentodatatable') }}">
                                <input type="hidden" id="eliminarArchivo"
                                    value="{{ route('gestordocumentos.eliminardocumento') }}">
                                @php $url = url('/'); @endphp
                                <input type="hidden" id="urlarchivo" value="{{ $url }}">
                            </div>
                            <div class="card-footer">
                                {{ link_to('tablero', $title = 'Regresar', $attributes = ['class' => 'btn btn-secondary']) }}
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
@endsection
