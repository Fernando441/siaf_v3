@extends('layouts.app')
@section('title')
    Documentos del Gestor
@endsection

@push('scripts')
    <script src="{{ asset('js/catalogos/gestor/documentos.js') }}"></script>
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
                                    <h3 class="card-label">Documentos</h3>
                                </div>
                                 
                            </div>
                            <div class="card-body">

                                <div class="collapse" id="collapseExample">
                                    <div class="card card-body mb-5">
                                        <!--begin: Search Form-->
                                        
                                    </div>
                                </div>
                                <!--bein::Formulario-->
                                @if (in_array('137', Session::get('permisos')))
                                    <form method="post" action="{{ route('catalogogestor.guardardocumento') }}" id="form_documentos" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="id_gestor" id="id_gestor"
                                            value="{{ $id_gestor }}">
                                        <!--begin::Formulario -->
                                        <div class="row form-group">
                                            <div class="col-lg-12" id="tblArchivos">
                                                <table class='table table-responsive-lg table-bordered table-hover' id='tblFormDocumentos'>
                                                    <thead>
                                                        <tr>
                                                            <th>Documento</th>
                                                            <th>Descripción</th>
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
                                            <th>Comentario</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                    </tbody>



                                </table>
                                <!--end: Datatable-->

                                <input type="hidden" id="datatable_i18n"
                                    value="{{ asset('/js/datatables/i18n/es-mx.json') }}">
                                <input type="hidden" id="gestordatatable"
                                    value="{{ route('catalogogestor.listadoDocumentosdatatable') }}">
                                <input type="hidden" id="eliminarArchivo"
                                    value="{{ route('catalogogestor.eliminardocumento') }}">
                                @php $url = url('/'); @endphp
                                <input type="hidden" id="urlarchivo" value="{{ $url }}">
                            </div>
                            <div class="card-footer">
                                <a href="{{ route('catalogogestor.listadocatalogogestor', ['id'=>1]) }}"
                                    class="btn btn-secondary"><i class="la la-arrow-left"></i> Regresar</a>
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
