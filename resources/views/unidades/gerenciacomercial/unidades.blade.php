@extends('layouts.app')
@push('scripts')
    <script src="{{ asset('js/unidades/CatalogoUnidadesComercial.js') }}"></script>
	<meta name="csrf-token" content="{{ csrf_token() }}" />
@endpush
@section('title')
    Inventario de vehículos
@endsection
@section('content')
<style type="text/css">
    .oculto{
        display: none;
    }
</style>

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
                                <h3 class="card-label">Inventario de vehículos</h3>
                            </div>
                            <div class="card-toolbar">


                                <a class="btn btn-link-primary font-weight-bold mr-2 busqueda" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                                    Busqueda
                                </a>

                                <!--begin::Dropdown-->
                                <div class="dropdown dropdown-inline mr-2">
                                    <button type="button" class="btn btn-light-primary font-weight-bolder dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
												<span class="svg-icon svg-icon-md">
													<!--begin::Svg Icon | path:assets/media/svg/icons/Design/PenAndRuller.svg-->
													<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
														<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
															<rect x="0" y="0" width="24" height="24" />
															<path d="M3,16 L5,16 C5.55228475,16 6,15.5522847 6,15 C6,14.4477153 5.55228475,14 5,14 L3,14 L3,12 L5,12 C5.55228475,12 6,11.5522847 6,11 C6,10.4477153 5.55228475,10 5,10 L3,10 L3,8 L5,8 C5.55228475,8 6,7.55228475 6,7 C6,6.44771525 5.55228475,6 5,6 L3,6 L3,4 C3,3.44771525 3.44771525,3 4,3 L10,3 C10.5522847,3 11,3.44771525 11,4 L11,19 C11,19.5522847 10.5522847,20 10,20 L4,20 C3.44771525,20 3,19.5522847 3,19 L3,16 Z" fill="#000000" opacity="0.3" />
															<path d="M16,3 L19,3 C20.1045695,3 21,3.8954305 21,5 L21,15.2485298 C21,15.7329761 20.8241635,16.200956 20.5051534,16.565539 L17.8762883,19.5699562 C17.6944473,19.7777745 17.378566,19.7988332 17.1707477,19.6169922 C17.1540423,19.602375 17.1383289,19.5866616 17.1237117,19.5699562 L14.4948466,16.565539 C14.1758365,16.200956 14,15.7329761 14,15.2485298 L14,5 C14,3.8954305 14.8954305,3 16,3 Z" fill="#000000" />
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
{{--                                             <li class="navi-item">
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
                        <div class="card-body">

                            <div class="collapse" id="collapseExample">
                                <div class="card card-body">

                                    <!--begin: Search Form-->
                                    <form class="mb-15">
                                        <div class="row mb-6">
                                            <div class="col-lg-4 mb-lg-0 mb-6">
                                                <label>No. Folio:</label>
                                                <input type="text" class="form-control datatable-input" data-col-index="0" />
                                            </div>
                                            <div class="col-lg-4 mb-lg-0 mb-6">
                                                <label>Patio:</label>
                                                <select name="" id="" class="form-control datatable-input" data-col-index="1">
                                                    <option value="">Seleccione una opción</option>
                                                    @foreach($ubicaciones as $ub)
                                                        <option value="{{ $ub->id }}">{{ $ub->ubicacion }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-lg-4 mb-lg-0 mb-6">
                                                <label>Id. Contrato:</label>
                                                <select class="form-control datatable-input" data-col-index="2">
                                                    <option value="">Seleccione una opción</option>
                                                    @foreach($contratos as $mar)
                                                        <option value="{{ $mar->id }}">Folio:{{ $mar->id_contrato }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mb-8">
                                            <div class="col-lg-4 mb-lg-0 mb-6">
                                                <label>Marca:</label>
                                                <select class="form-control datatable-input" data-col-index="3">
                                                    <option value="">Seleccione una opción</option>
                                                    @foreach($marcas as $mar)
                                                        <option value="{{ $mar->id }}">{{ $mar->nombre_marca }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-lg-4 mb-lg-0 mb-6">
                                                <label>Modelo:</label>
                                                <select name="" id="" class="form-control datatable-input" data-col-index="4">
                                                    <option value="">Seleccione una opción</option>
                                                    @foreach($modelos as $mod)
                                                        <option value="{{ $mod->id }}">{{ $mod->nombre_modelo }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-lg-4 mb-lg-0 mb-6">
                                                <label>No. Serie:</label>
                                                <input type="text" class="form-control datatable-input" data-col-index="5" />
                                            </div>
                                        </div>

                                        <div class="row mb-8">
                                            <div class="col-lg-4 mb-lg-0 mb-6">
                                                <label>Placa:</label>
                                                <input type="text" class="form-control datatable-input" data-col-index="6" />
                                            </div>
{{--                                             <div class="col-lg-4 mb-lg-0 mb-6">
                                                <label>Estatus:</label>
                                                <select name="" id="" class="form-control datatable-input" data-col-index="7">
                                                    <option value="">Seleccione una opción</option>
                                                    @foreach($estatus as $mod)
                                                        <option value="{{ $mod->id }}">{{ $mod->nombre_status }}</option>
                                                    @endforeach
                                                </select>
                                            </div> --}}
                                        </div>

                                        <div class="row mt-8">
                                            <div class="col-lg-12">
                                                <button class="btn btn-primary btn-primary--icon"
                                                        id="kt_search">
                                                            <span>
                                                                <i class="la la-search"></i>
                                                                <span>Buscar</span>
                                                            </span>
                                                </button>&#160;&#160;
                                                <button class="btn btn-secondary btn-secondary--icon"
                                                        id="kt_reset">
                                                            <span>
                                                                <i class="la la-close"></i>
                                                                <span>Limpiar</span>
                                                            </span>
                                                </button>
                                            </div>
                                        </div>
                                    </form>


                                </div>
                            </div>

                            <!--begin: Datatable-->
                            <table class="table table-hover table-checkable" id="kt_datatable_example_1">
                                <thead>
                                <tr>
                                    <th>Folio</th>
                                    <th>Patio</th>
                                    <th>Id. Contrato</th>
                                    <th>Marca</th>
                                    <th>Modelo</th>
                                    <th>Serie</th>
                                    <th>Placa</th>
                                    <th>Año</th>
                                    <th>Estatus</th>
                                    <th class="text-center">Opciones</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th>Folio</th>
                                    <th>Patio</th>
                                    <th>Id. Contrato</th>
                                    <th>Marca</th>
                                    <th>Modelo</th>
                                    <th>Serie</th>
                                    <th>Placa</th>
                                    <th>Año</th>
                                    <th>Estatus</th>
                                    <th class="text-center">Opciones</th>
                                </tr>
                                </tfoot>

                            </table>
                            <!--end: Datatable-->

                            <input type="hidden" id="datatable_i18n" value="{{ asset('/js/datatables/i18n/es-mx.json') }}">
                            <input type="hidden" id="unidaddatatable" value="{{ route('comercialinv.unidaddatatablecomercial') }}">

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
