@extends('layouts.app')

@section('title')
   Revision de Requisiciones de compras
@endsection

@push('scripts')
  <script src="{{ asset('js/licitaciones/requicision_compras/RequisicionCompras.js') }}"></script> 
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
                                <i class="flaticon2-file text-primary"></i>
                              </span>
                              <h3 class="card-label">Listado de requisiciones compras </h3>
                            </div>
                            <div class="card-toolbar">


{{--                                 <a class="btn btn-link-primary font-weight-bold mr-2 busqueda" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                                    Busqueda
                                </a> --}}

                                <!--begin::Button-->
{{-- 
                                <a href="{{ route('afianzadora.listadocatalogoafianzadorainactivas') }}" class="btn btn-light-primary font-weight-bolder mr-3 ml-3">
                                    <i class="far fa-trash-alt"></i>Requisiciones Inactivas</a> --}}

                                <!--end::Button-->


                                <!--begin::Dropdown-->
                                <div class="dropdown dropdown-inline mr-2">
{{--                                   <button type="button" class="btn btn-light-primary font-weight-bolder dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="svg-icon svg-icon-md">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                      <rect x="0" y="0" width="24" height="24" />
                                      <path d="M3,16 L5,16 C5.55228475,16 6,15.5522847 6,15 C6,14.4477153 5.55228475,14 5,14 L3,14 L3,12 L5,12 C5.55228475,12 6,11.5522847 6,11 C6,10.4477153 5.55228475,10 5,10 L3,10 L3,8 L5,8 C5.55228475,8 6,7.55228475 6,7 C6,6.44771525 5.55228475,6 5,6 L3,6 L3,4 C3,3.44771525 3.44771525,3 4,3 L10,3 C10.5522847,3 11,3.44771525 11,4 L11,19 C11,19.5522847 10.5522847,20 10,20 L4,20 C3.44771525,20 3,19.5522847 3,19 L3,16 Z" fill="#000000" opacity="0.3" />
                                      <path d="M16,3 L19,3 C20.1045695,3 21,3.8954305 21,5 L21,15.2485298 C21,15.7329761 20.8241635,16.200956 20.5051534,16.565539 L17.8762883,19.5699562 C17.6944473,19.7777745 17.378566,19.7988332 17.1707477,19.6169922 C17.1540423,19.602375 17.1383289,19.5866616 17.1237117,19.5699562 L14.4948466,16.565539 C14.1758365,16.200956 14,15.7329761 14,15.2485298 L14,5 C14,3.8954305 14.8954305,3 16,3 Z" fill="#000000" />
                                    </g>
                                    </svg>
                                    </span>Exportar
                                  </button> --}}
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
                                  <div class="col-lg-6 mb-lg-0 mb-6">
                                    <label>Nombre de la afianzadora:</label>
                                    <input type="text" class="form-control datatable-input" data-col-index="1" />
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


                        <!--begin: Datatable-->
                          <table class="table table-hover table-checkable" id="kdatatable_reqcompras">
                            <thead>
                              <tr>
                                <th>No.</th>
                                <th>Titulo</th>
                                <th>Fecha requisición</th>
                                <th>Creada por:</th>
                                <th>Estatus</th>
                                <th class="text-center">Opciones</th>
                              </tr>
                            </thead>
                                <tbody>
                                  @foreach($data as $unid)
                                    <tr>
                                      <td>{{ $unid->id }}</td>
                                      <td>{{ $unid->titulo_requisicion }}</td>
                                      <td>{{ $unid->fecha_requisicion }}</td>
                                      <td>{{ $unid->userCreated->name }}</td>
                                      <td>
                                        @if($unid->op_estatus == 0)
                                          <span class="label font-weight-bold label-outline-dark  label-inline" >En proceso...</span>
                                        @endif

                                        @if($unid->op_estatus == 1)
                                          <span class="label font-weight-bold label-outline-warning   label-inline" >Enviada a revisión</span>
                                        @endif

                                        @if($unid->op_estatus == 2)
                                          <span class="label font-weight-bold label-outline-primary   label-inline" >En espera de pago</span>
                                        @endif

                                      </td>

                                      <td class="text-center">
                                        <a href="{{ route('finreqcompras.pagocomprareq',$unid->id ) }}" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon" data-id="{{ $unid->id }}" data-nombre="{{ $unid->titulo_requisicion }}" data-toggle="tooltip" data-theme="dark" title="Ver requisición" ><i class="flaticon-eye"></i></a>

                                        <a href="{{ route('finreqcompras.infopago',$unid->id ) }}" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon" data-id="{{ $unid->id }}" data-nombre="{{ $unid->titulo_requisicion }}" data-toggle="tooltip" data-theme="dark" title="Información pago" ><i class="flaticon-file-1"></i></a>


                                        <a href="{{ route('reqcompras.verPDF',$unid->id) }}" target="blank" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon modal-pdf" title="Ver PDF" data-theme="dark"  data-toggle="tooltip" data-placement="top"><i class="far fa-file-pdf"></i></a>

                                      </td>



                                    </tr>
                                  @endforeach
                                </tbody>
                            <tfoot>
                              <tr>
                                <th>No.</th>
                                <th>Titulo</th>
                                <th>Fecha requisición</th>
                                <th>Creada por:</th>
                                <th>Estatus</th>
                                <th class="text-center">Opciones</th>
                              </tr>
                            </tfoot>

                          </table>
                          <!--end: Datatable-->
                          <input type="hidden" id="datatable_i18n" value="{{ asset('/js/datatables/i18n/es-mx.json') }}">

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


      <input type="hidden" id="finanzasrequisicionurl" value="{{ route('reqcompras.envrequisicionrevision') }}">

{{-- 
    <div class="modal fade" id="exampleModalSizeSm" tabindex="-1" role="dialog" aria-labelledby="exampleModalSizeSm"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Requisicion</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <div id="modal-body" class="modal-body">
                    
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn btn-secondary font-weight-bold" data-dismiss="modal"><i
                            class="la la-times"></i>Cerrar</button>
                     
                </div>
            </div>
        </div>
    </div> --}}

@endsection