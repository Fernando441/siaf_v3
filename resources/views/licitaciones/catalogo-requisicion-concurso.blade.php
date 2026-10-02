@extends('layouts.app')
@section('title')
    Listado de requisiciones
@endsection
@push('scripts')
    <script src="{{ asset('js/licitaciones/requisicion/ListadoRequisicionesConcurso.js') }}"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
@endpush
@section('content')
    <!--begin::Card-->
    <div class="row">
        <div class="col-lg-12">
            <!--begin::Card-->
            <div class="card card-custom gutter-b">
                <div class="card-header">
                    <h3 class="card-title"><i class="flaticon2-file mr-4 text-primary"></i> Listado de requisiciones</h3>
                    <div class="card-toolbar">
                        <a class="btn btn-link-primary font-weight-bold mr-2 busqueda" data-toggle="collapse"
                            href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                            Busqueda
                        </a>

                        <input type="hidden" id="op_busqueda" value="1">

                        @if (in_array('119', Session::get('permisos')))
                            <a href="{{ route('concurso.requisiciones.nuevarequisicion') }}"
                                class="btn btn-light-primary font-weight-bolder mr-3 ml-3">
                                <i class="la la-plus mr-2"></i>Nueva
                            </a>
                        @endif

                        {{-- <a href="{{ route('concurso.requisiciones.catalogorequisicioninactivas') }}"
                            class="btn btn-light-primary font-weight-bolder mr-3 ml-3">
                            <i class="far fa-trash-alt"></i>Requisiciones inactivas</a> --}}

                        <!--begin::Dropdown-->
                        <div class="dropdown dropdown-inline mr-2">
                            <button type="button" class="btn btn-light-primary font-weight-bolder dropdown-toggle"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="svg-icon svg-icon-md">
                                    <!--begin::Svg Icon | path:assets/media/svg/icons/Design/PenAndRuller.svg-->
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                        width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <rect x="0" y="0" width="24" height="24" />
                                            <path
                                                d="M3,16 L5,16 C5.55228475,16 6,15.5522847 6,15 C6,14.4477153 5.55228475,14 5,14 L3,14 L3,12 L5,12 C5.55228475,12 6,11.5522847 6,11 C6,10.4477153 5.55228475,10 5,10 L3,10 L3,8 L5,8 C5.55228475,8 6,7.55228475 6,7 C6,6.44771525 5.55228475,6 5,6 L3,6 L3,4 C3,3.44771525 3.44771525,3 4,3 L10,3 C10.5522847,3 11,3.44771525 11,4 L11,19 C11,19.5522847 10.5522847,20 10,20 L4,20 C3.44771525,20 3,19.5522847 3,19 L3,16 Z"
                                                fill="#000000" opacity="0.3" />
                                            <path
                                                d="M16,3 L19,3 C20.1045695,3 21,3.8954305 21,5 L21,15.2485298 C21,15.7329761 20.8241635,16.200956 20.5051534,16.565539 L17.8762883,19.5699562 C17.6944473,19.7777745 17.378566,19.7988332 17.1707477,19.6169922 C17.1540423,19.602375 17.1383289,19.5866616 17.1237117,19.5699562 L14.4948466,16.565539 C14.1758365,16.200956 14,15.7329761 14,15.2485298 L14,5 C14,3.8954305 14.8954305,3 16,3 Z"
                                                fill="#000000" />
                                        </g>
                                    </svg>
                                    <!--end::Svg Icon-->
                                </span>Exportar</button>
                            <!--begin::Dropdown Menu-->
                            <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                                <!--begin::Navigation-->
                                <ul class="navi flex-column navi-hover py-2">

                                    <li class="navi-item">
                                        <a href="#" class="navi-link" id="export-excel">
                                            <span class="navi-icon">
                                                <i class="la la-file-excel-o"></i>
                                            </span>
                                            <span class="navi-text">Excel</span>
                                        </a>
                                    </li>
                                    {{--                                 <li class="navi-item">
                                    <a href="#" class="navi-link" id="export-pdf">
                                                    <span class="navi-icon">
                                                        <i class="la la-file-pdf-o"></i>
                                                    </span>
                                        <span class="navi-text">PDF</span>
                                    </a>
                                </li> --}}
                                    <li class="navi-item">
                                        <a href="#" class="navi-link" id="export-csv">
                                            <span class="navi-icon">
                                                <i class="la la-file-text-o"></i>
                                            </span>
                                            <span class="navi-text">CSV</span>
                                        </a>
                                    </li>
                                    <li class="navi-item">
                                        <a href="#" class="navi-link" id="export-print">
                                            <span class="navi-icon">
                                                <i class="la la-file-text-o"></i>
                                            </span>
                                            <span class="navi-text">Imprimir</span>
                                        </a>
                                    </li>

                                </ul>
                                <!--end::Navigation-->
                            </div>
                            <!--end::Dropdown Menu-->
                        </div>
                        <!--end::Dropdown-->
                    </div>
                </div>
                <!--begin::Form-->
                <form action="{{ route('concurso.requisiciones.guardarrequisicion') }}" method="post" id="submit_requisicion"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">

                        <div class="collapse" id="collapseExample">
                            <div class="card card-body">

                                <!--begin: Search Form-->
                                <form class="mb-15">
                                    @csrf
                                    <div class="row mb-6">
                                        <div class="col-lg-4 mb-lg-0 mb-6">
                                            <label>No. Requisición:</label>
                                            <input type="text" class="form-control datatable-input" data-col-index="0" />
                                        </div>
                                        <div class="col-lg-4 mb-lg-0 mb-6">
                                            <label>Solicitante:</label>
                                            <input type="text" class="form-control datatable-input" data-col-index="1" />
                                        </div>

                                        <div class="col-lg-4 mb-lg-0 mb-6">
                                            <label>Area:</label>
                                            <input type="text" class="form-control datatable-input" data-col-index="2" />
                                        </div>

                                    </div>

                                    <div class="row mt-8">
                                        <div class="col-lg-12">
                                            <button class="btn btn-primary btn-primary--icon" id="kt_search">
                                                <span><i class="la la-search"></i><span>Buscar</span></span>
                                            </button>&#160;&#160;
                                            <button class="btn btn-secondary btn-secondary--icon" id="kt_reset">
                                                <span><i class="la la-close"></i><span>Limpiar</span></span>
                                            </button>

                                        </div>
                                    </div>
                                </form>

                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <table class="table table-hover" id="tablaRequisiciones">
                                    <thead style="text-align:center;">
                                        <tr>
                                            <th>Folio</th>
                                            <th>Solicitante</th>
                                            <th>Area</th>
                                            <th>Estatus</th>
                                            <th>Fecha de solicitud</th>
                                            <th>Opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody style="text-align:center;">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-lg-6">
                                {{-- {{link_to('tablero', $title = 'Regresar', $attributes = ['class'=>'btn btn-secondary btn-lg'])}} --}}
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="datatable_i18n" value="{{ asset('/js/datatables/i18n/es-mx.json') }}">
                    <input type="hidden" id="requisicionesurl"
                        value="{{ route('concurso.requisiciones.requisiciondatatable') }}">
                    <input type="hidden" id="verrequisicionurl"
                        value="{{ route('concurso.requisiciones.verrequisicion', ['id' => 1]) }}">
                    <input type="hidden" id="editarrequisicionurl"
                        value="{{ route('concurso.requisiciones.editarrequisicion', ['id' => 1]) }}">
                    <input type="hidden" id="eliminarrequisicionurl"
                        value="{{ route('concurso.requisiciones.eliminarrequisicion') }}">
                    <input type="hidden" id="finanzasrequisicionurl"
                        value="{{ route('concurso.requisiciones.finanzasrequisicion') }}">
                    <input type="hidden" id="addinfo"
                        value="{{ route('concurso.requisiciones.addinfopartidas', ['id' => 1]) }}">
                </form>
                <!--end::Form-->
            </div>
            <!--end::Card-->
        </div>
    </div>
    <!--end::Card-->


    <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"
        id="model_delete_requisicion">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Desactivar requisición</h5>
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                        aria-label="Close">
                        <span class="svg-icon svg-icon-2x"></span>
                    </div>
                </div>

                <div class="modal-body">
                    <form action="{{ route('concurso.requisiciones.eliminarrequisicion') }}" method="post"
                        id="submit_desactivar">
                        @csrf
                        <div class="row form-group">
                            <div class="col-lg-12 mt-2">
                                <label>Motivo</label>
                                <input type="text" class="form-control" name="motivo" id="id_motivo_requisicion" />
                                <input type="hidden" name="id" id="id_del_req">
                            </div>
                        </div>
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn btn-secondary font-weight-bold"
                        data-dismiss="modal"><i class="la la-times"></i>Cancelar</button>
                    <button type="button" id="send_desactivar" class="btn btn-success"><i class="la la-plus"></i>Guardar</button>
                </div>
            </div>
        </div>
    </div>
@endsection
