@extends('layouts.app')
@section('title')
    Catálogo de administradores de contrato
@endsection

@push('scripts')
  <script src="{{ asset('js/catalogos/CatalogoAdministradoresContrato.js') }}"></script> 
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
                                <h3 class="card-label">Inventario de administradores</h3>
                            </div>
                            <div class="card-toolbar">

                                <!--begin::Button-->
                                <a href="{{ route('emisores.listadoemisores') }}" class="btn btn-light-primary font-weight-bolder mr-3 ml-3">
                                  Regresar</a>
                                <!--end::Button-->

                            </div>
                        </div>
                        <div class="card-body">
                            <!--begin: Datatable-->
                            <table class="table table-hover table-checkable" id="kdatatable_emisores_inactiva">
                                <thead>
                                <tr>
                                  <th>No.</th>
                                  <th>Razón Social</th>
                                  <th>RFC</th>
                                  <th>Domicilio Fiscal</th>
                                  <th class="text-center">Opciones</th>
                                </tr>
                                </thead>

                                <tbody>
                                  @foreach($emisores as $unid)
                                    <tr>
                                      <td>{{ $unid->id }}</td>
                                      <td>{{ $unid->razon_social }}</td>
                                      <td>{{ $unid->rfc }}</td>
                                      <td>{{ $unid->dom_fiscal }}</td>

                                      <td class="text-center">
                                        <button class="btn btn-sm btn-clean btn-hover-icon-success btn-icon activar-emisor" data-id="{{ $unid->id }}" data-nombre="{{ $unid->razon_social }}" data-toggle="tooltip" data-theme="dark" title="Activar Administrador" ><i class="flaticon2-reply "></i></button>
                                      </td>
                                    </tr>
                                  @endforeach
                                </tbody>

                                <tfoot>
                                <tr>
                                  <th>No.</th>
                                  <th>Razón Social</th>
                                  <th>RFC</th>
                                  <th>Domicilio Fiscal</th>
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
  
  <form method="post" id="emisor_activar_form" action="{{ route('emisores.activaremisor') }}" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="id" id="id_act_emisor" value="">
  </form>

@endsection