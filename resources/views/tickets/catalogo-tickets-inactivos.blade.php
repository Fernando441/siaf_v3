@extends('layouts.app')

@section('title')
  Inventario de tickets inactivos
@endsection

@push('scripts')
  <script src="{{ asset('js/cliente/CatalogoClientes.js') }}"></script>
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
                  <h3 class="card-label">Inventario de tickets inactivos</h3>
                </div>
                <div class="card-toolbar">

                  <!--begin::Button-->
                  <a href="{{ route('tickets.catalogo-tickets') }}"
                    class="btn btn-light-primary font-weight-bolder mr-3 ml-3">
                    <i class="la la-arrow-left"></i>Regresar</a>
                  <!--end::Button-->

                </div>
              </div>
              <div class="card-body">
                <!--begin: Datatable-->
                <table class="table table-hover table-checkable" id="kdatatable_clientes_inactivos">
                  <thead>
                    <tr>
                      <th>Titulo</th>
                      <th>Descripcion</th>
                      <th>Asigno</th>
                      <th>Fecha</th>
                      <th>Archivos</th>
                      <th class="text-center">Opciones</th>
                    </tr>
                  </thead>

                  <tbody>

                  </tbody>



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

  <form method="post" id="cli_act_form" action="{{ route('cliente.activarcliente') }}" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="id" id="id_cli_act" value="">
  </form>

@endsection