@extends('layouts.app')
@section('title')
    Catálogo de requisitos inactivos
@endsection

@push('scripts')
    <script src="{{ asset('js/catalogos/Tramitesvehiculares/CatalogoEmplacamientoRequisito.js') }}"></script>
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
                                <h3 class="card-label">Inventario de requisitos para el tramite de emplacamiento</h3>
                            </div>
                            <div class="card-toolbar">

                                <!--begin::Button-->
                                <a href="{{ route('templacamiento.listadoemplacamiento') }}" class="btn btn-light-primary font-weight-bolder mr-3 ml-3">
                                    <i class="la la-arrow-left"></i> Regresar</a>
                                <!--end::Button-->

                            </div>
                        </div>
                        <div class="card-body">
                            <!--begin: Datatable-->
                            <table class="table table-hover table-checkable" id="kdatatable_requisitoemp_inactivo">
                                <thead>
                                <tr>
                                  <th>No.</th>
                                  <th>Nombre del requisito</th>
                                  <th class="text-center">Opciones</th>
                                </tr>
                                </thead>

                                <tbody>
                                  @foreach($emplacamientorequisito as $unid)
                                    <tr>
                                      <td>{{ $unid->id }}</td>
                                      <td>{{ $unid->nombre_requisito }}</td>

                                      <td class="text-center">
                                        <button class="btn btn-sm btn-clean btn-hover-icon-success btn-icon activar-requisito" data-id="{{ $unid->id }}" data-nombre="{{ $unid->nombre_requisito }}" data-toggle="tooltip" data-theme="dark" title="Activar Requisito"><i class="flaticon-reply "></i></button>
                                      </td>
                                    </tr>
                                  @endforeach
                                </tbody>

                                <tfoot>
                                <tr>
                                  <th>No.</th>
                                  <th>Nombre del requisito</th>
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

<input type="hidden" id="datatable_i18n" value="{{ asset('/js/datatables/i18n/es-mx.json') }}">
<form method="post" id="requisito_activar_form" action="{{ route('templacamiento.activarrequisitoemp') }}" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="id" id="id_requisito_act" value="">
</form>

@endsection