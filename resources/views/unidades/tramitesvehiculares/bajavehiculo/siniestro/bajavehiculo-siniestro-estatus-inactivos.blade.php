@extends('layouts.app')
@section('title')
    Catálogo de estatus inactivos
@endsection

@push('scripts')
    <script src="{{ asset('js/catalogos/Tramitesvehiculares/CatalogoBajaVehiculoSiniestroEstatus.js') }}"></script>
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
                                <h3 class="card-label">Inventario de Estatus (Siniestro)</h3>
                            </div>
                            <div class="card-toolbar">

                                <!--begin::Button-->
                                <a href="{{ route('bajasin.listadoestatusbajastro') }}" class="btn btn-light-primary font-weight-bolder mr-3 ml-3">
                                    <i class="la la-arrow-left"></i> Regresar</a>
                                <!--end::Button-->

                            </div>
                        </div>
                        <div class="card-body">
                            <!--begin: Datatable-->
                            <table class="table table-hover table-checkable" id="kdatatable_estatus_inactivo">
                                <thead>
                                <tr>
                                  <th>No.</th>
                                  <th>Nombre del estatus</th>
                                  <th class="text-center">Opciones</th>
                                </tr>
                                </thead>

                                <tbody>
                                  @foreach($aseguramientorequisito as $unid)
                                    <tr>
                                      <td>{{ $unid->id }}</td>
                                      <td>{{ $unid->nombre_estatus }}</td>

                                      <td class="text-center">
                                        <button class="btn btn-sm btn-clean btn-hover-icon-success btn-icon activar-estatus" data-id="{{ $unid->id }}" data-nombre="{{ $unid->nombre_estatus }}" data-toggle="tooltip" data-theme="dark" title="Activar Estatus"><i class="flaticon-reply "></i></button>
                                      </td>
                                    </tr>
                                  @endforeach
                                </tbody>

                                <tfoot>
                                <tr>
                                  <th>No.</th>
                                  <th>Nombre del estatus</th>
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
<form method="post" id="estatus_activar_form" action="{{ route('bajasin.activasintroest') }}" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="id" id="id_estatus_act" value="">
</form>

@endsection