@extends('layouts.app')
@section('title')
    Catálogo de municipios
@endsection

@push('scripts')
  <script src="{{ asset('js/catalogos/CatalogoMunicipios.js') }}"></script> 
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
                                <h3 class="card-label">Inventario de municipios</h3>
                            </div>
                            <div class="card-toolbar">

                                <!--begin::Button-->
                                <a href="{{ route('cliente.catalogoMunicipio') }}" class="btn btn-light-primary font-weight-bolder mr-3 ml-3">
                                  Regresar</a>
                                <!--end::Button-->

                            </div>
                        </div>
                        <div class="card-body">
                            <!--begin: Datatable-->
                            <table class="table table-hover table-checkable" id="kdatatable_municipios_inactivos">
                                <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nombre</th>
                                    <th>Estado</th>
                                  <th class="text-center">Opciones</th>
                                </tr>
                                </thead>

                                <tbody>
                                  @foreach($municipios as $municipio)
                                    <tr>
                                        <td>{{ $municipio->id_municipio }}</td>
                                        <td>{{ $municipio->municipio_nombre }}</td>
                                        <td>{{ $municipio->estado_nombre }}</td>

                                      <td class="text-center">
                                        <a class="btn btn-sm btn-clean btn-hover-icon-success btn-icon activar_municipio" data-id="{{ $municipio->id_municipio }}" data-nombre="{{ $municipio->municipio_nombre }}" data-toggle="tooltip" data-theme="dark" title="Activar Municipio" ><i class="flaticon2-reply "></i></a>
                                      </td>
                                    </tr>
                                  @endforeach
                                </tbody>

                                <tfoot>
                                <tr>
                                    <th>No.</th>
                                    <th>Nombre</th>
                                    <th>Estado</th>
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

  <form method="post" id="municipios_act_form" action="{{ route('cliente.activarmunicipio') }}" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="id" id="id_act_municipio" value="">
  </form>


@endsection