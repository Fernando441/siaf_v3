@extends('layouts.app')
@section('title')
    Catálogo de talleres inactivos
@endsection

@push('scripts')
    <script src="{{ asset('js/taller/CatalogoTaller.js') }}"></script>
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
                                <h3 class="card-label">Inventario de talleres</h3>
                            </div>
                            <div class="card-toolbar">

                                <!--begin::Button-->
                                <a href="{{ route('invtaller.inventariotaller') }}" class="btn btn-light-primary font-weight-bolder mr-3 ml-3">
                                    <i class="la la-arrow-left"></i>  Regresar</a>
                                <!--end::Button-->

                            </div>
                        </div>
                        <div class="card-body">
                            <!--begin: Datatable-->
                            <table class="table table-hover table-checkable" id="kdatatable_talleres_inactivos">
                                <thead>
                                <tr>
                                  <th>Motivo Desactivar</th>
                                  <th>Nombre</th>
                                  <th>Dirección</th>
                                  <th>Telefono</th>
                                  <th>Correo</th>
                                  <th>Municipio</th>
                                  <th>Estado</th>
                                  <th class="text-center">Opciones</th>
                                </tr>
                                </thead>

                                <tbody>
                                  @foreach($talleres as $unid)
                                    <tr>
                                      <td><span style="color:red;">{{ $unid->motivo }}</span></td>
                                      <td>{{ $unid->alias }}</td>
                                      <td>{{ $unid->direccion }}</td>
                                      <td>{{ $unid->telefono }}</td>
                                      <td>{{ $unid->correo }}</td>
                                      <td>{{ $unid->municipio_nombre }}</td>
                                      <td>{{ $unid->estado_nombre }}</td>

                                      <td class="text-center">
                                        <button class="btn btn-sm btn-clean btn-hover-icon-success btn-icon activar-taller" data-id="{{ $unid->id }}" data-nombre="{{ $unid->alias }}" data-toggle="tooltip" data-theme="dark" title="Activar taller" ><i class="flaticon2-reply "></i></button>
                                      </td>
                                    </tr>
                                  @endforeach
                                </tbody>

                                <tfoot>
                                <tr>
                                  <th>Nombre</th>
                                  <th>Dirección</th>
                                  <th>Telefono</th>
                                  <th>Correo</th>
                                  <th>Municipio</th>
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

  <form method="post" id="taller_activar_form" action="{{ route('invtaller.activarintaller') }}" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="id" id="id_delete" value="">
  </form> 


@endsection