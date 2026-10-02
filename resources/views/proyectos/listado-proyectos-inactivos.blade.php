@extends('layouts.app')
@push('scripts')
    <script src="{{ asset('js/contratos/CatalogoContratos.js') }}"></script>
@endpush

@section('title')
    Seguimiento de contratos inactivos
@endsection

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
                                <h3 class="card-label">Seguimiento de contratos inactivos</h3>
                            </div>
                            <div class="card-toolbar">

                                <!--begin::Button-->
                                <a href="{{ route('proyecto.listadoproyectos') }}" class="btn btn-light-primary font-weight-bolder mr-3 ml-3">
                                    <i class="la la-arrow-left"></i>Regresar</a>
                                <!--end::Button-->

                            </div>
                        </div>
                        <div class="card-body">
                            <!--begin: Datatable-->
                            <table class="table table-hover table-checkable" id="kdatatable_contrato_inactivo">
                                <thead>
                                <tr>
                                  <th>Folio</th>
                                  <th>Id Contrato</th>
                                  <th>No. Contrato</th>
                                  <th>Administrador de contrato</th>
                                  <th>Cliente</th>
                                  <th>Titulo servicio</th>
                                  <th>Tipo contratación</th>
                                  <th>Motivo</th>
                                  <th class="text-center">Opciones</th>
                                </tr>
                                </thead>

                                <tbody>
                                  @foreach($info_proyecto as $unid)
                                    <tr>
                                      <td>{{ $unid->no_folio }}</td>
                                      <td>{{ $unid->id_contrato }}</td>
                                      <td>{{ $unid->no_contrato }}</td>
                                      <td>{{ $unid->rsocial }}</td>
                                      <td>{{ $unid->rzcliente }}</td>
                                      <td>{{ $unid->titulo_servicio }}</td>
                                      <td>{{ $unid->namecontrato }}</td>
                                      <td><span style="color: red;">{{ $unid->motivo_desactivar }}</span></td>
                                      <td class="text-center">
                                        <button class="btn btn-sm btn-clean btn-hover-icon-success btn-icon activar-contrato" data-id="{{ $unid->idpro }}" data-nombre="{{ $unid->no_folio }}" data-bs-toggle="tooltip" data-bs-placement="top" title="Activar Contrato" ><i class="flaticon2-reply "></i></button>
                                      </td>
                                    </tr>
                                  @endforeach
                                </tbody>

                                <tfoot>
                                <tr>
                                  <th>No. Contrato</th>
                                  <th>Administrador de contrato</th>
                                  <th>Cliente</th>
                                  <th>Titulo servicio</th>
                                  <th>Tipo contratación</th>
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

  <form method="post" id="contrato_activar_form" action="{{ route('proyecto.activarproyecto') }}" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="id" id="id_delete" value="">
  </form> 


@endsection