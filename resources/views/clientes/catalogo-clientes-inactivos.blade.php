@extends('layouts.app')

@section('title')
    Inventario de clientes inactivos
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
                                <h3 class="card-label">Inventario de clientes inactivos</h3>
                            </div>
                            <div class="card-toolbar">

                                <!--begin::Button-->
                                <a href="{{ route('cliente.catalogoCliente') }}" class="btn btn-light-primary font-weight-bolder mr-3 ml-3">
                                    <i class="la la-arrow-left"></i>Regresar</a>
                                <!--end::Button-->

                            </div>
                        </div>
                        <div class="card-body">
                            <!--begin: Datatable-->
                            <table class="table table-hover table-checkable" id="kdatatable_clientes_inactivos">
                                <thead>
                                <tr>
                                    <th>RFC</th>
                                    <th>Razon Social</th>
                                    <th>Alias</th>
                                    <th>Calle y Número</th>
                                    <th>Colonia</th>
                                    <th>Municipio</th>
                                    <th>Estado</th>
                                    <th>C.P.</th>
                                    <th>Motivo</th>
                                  <th class="text-center">Opciones</th>
                                </tr>
                                </thead>

                                <tbody>
                                  @foreach($clientes as $unid)
                                    <tr>
                                      <td>{{ $unid->rfc }}</td>
                                      <td>{{ $unid->razon_social }}</td>
                                      <td>{{ $unid->alias }}</td>
                                      <td>{{ $unid->calle_numero }}</td>
                                      <td>{{ $unid->colonia }}</td>
                                      <td>{{ $unid->municipio_nombre }}</td>
                                      <td>{{ $unid->estado_nombre }}</td>
                                      <td>{{ $unid->codigo_postal }}</td>
                                      <td><span style="color: red;">{{ $unid->motivo_desactivar }}</span></td>

                                      <td class="text-center">
                                        <a class="btn btn-sm btn-clean btn-hover-icon-success btn-icon activar-cliente" data-id="{{ $unid->id }}" data-nombre="{{ $unid->rfc }}" data-toggle="tooltip" data-theme="dark" title="Activar Cliente" ><i class="flaticon2-reply "></i></a>
                                      </td>
                                    </tr>
                                  @endforeach
                                </tbody>

                                <tfoot>
                                <tr>
                                    <th>RFC</th>
                                    <th>Razon Social</th>
                                    <th>Alias</th>
                                    <th>Calle y Número</th>
                                    <th>Colonia</th>
                                    <th>Municipio</th>
                                    <th>Estado</th>
                                    <th>C.P.</th>
                                    <th>Motivo</th>
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

 <form method="post" id="cli_act_form" action="{{ route('cliente.activarcliente') }}" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="id" id="id_cli_act" value="">
  </form> 

@endsection