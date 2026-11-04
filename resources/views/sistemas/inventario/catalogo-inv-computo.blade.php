@extends('layouts.app')

@section('title')
    Inventario de equipo de computo
@endsection

@push('scripts')
  <script src="{{ asset('js/sistemas/CatalogoSistemas.js') }}"></script>
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
                                <h3 class="card-label">Inventario de equipo de computo</h3>
                            </div>
                            <div class="card-toolbar">

                                <!--begin::Button-->
                                    <a href="{{ route('sistemas.agregarRegistro') }}" class="btn btn-light-primary font-weight-bolder mr-3 ml-3">
                                    <i class="la la-plus"></i>Nuevo</a>
                                <!--end::Button-->

                            </div>
                        </div>
                        <div class="card-body">
                            <!--begin: Datatable-->
                            <table class="table table-hover table-checkable" id="kdatatable_inventario">
                                <thead>
                                <tr>
                                    <th>No. Folio</th>
                                    <th>No. Serie</th>
                                    <th>Tipo de equipo</th>
                                    <th>Marca</th>
                                    <th>Modelo</th>
                                    <th>Fecha ingreso</th>
                                    <th>Estatus</th>
                                  <th class="text-center">Opciones</th>
                                </tr>
                                </thead>

                                <tbody>
                                  @foreach($inventario as $unid)
                                    <tr>
                                      <td>{{ $unid->no_folio }}</td>
                                      <td>{{ $unid->no_serie }}</td>
                                      <td>{{ $unid->Tipoequipo->tipo_equipo }}</td>
                                      <td>{{ $unid->marca }}</td>
                                      <td>{{ $unid->modelo }}</td>
                                      <td>{{ $unid->fecha_ingreso }}</td>
                                      <td>
                                          @if($unid->estatus_asignado == 0)
                                            <span class="label font-weight-bold label-outline-danger label-inline" >No asignado</span>
                                          @else
                                            <span class="label font-weight-bold label-outline-success label-inline" >Asignado</span>
                                          @endif

                                      </td>

                                      <td class="text-center">
                                        <a href="{{ route('sistemas.verRegistro',$unid->id) }}" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon" title="Ver equipo" data-theme="dark" data-toggle="tooltip" data-placement="top"> <i class="flaticon-eye"></i></a>

                                        <a href="{{ route('sistemas.editarRegistro',$unid->id) }}" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon" title="Editar equipo" data-theme="dark" data-toggle="tooltip" data-placement="top"><i class="flaticon-edit"></i></a>

                                        <button class="btn btn-sm btn-clean btn-hover-icon-success btn-icon" data-toggle="modal" data-target="#model_delete_concurso" data-toggle="tooltip" data-theme="dark" title="Desactivar equipo">
                                                <i class="flaticon-delete"></i>
                                        </button>
                                      </td>
                                    </tr>
                                  @endforeach
                                </tbody>

                                <tfoot>
                                <tr>
                                    <th>No. Folio</th>
                                    <th>No. Serie</th>
                                    <th>Tipo de equipo</th>
                                    <th>Marca</th>
                                    <th>Modelo</th>
                                    <th>Fecha ingreso</th>
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

 <form method="post" id="cli_act_form" action="{{ route('cliente.activarcliente') }}" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="id" id="id_cli_act" value="">
  </form> 


    <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"
        id="model_delete_concurso">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Desactivar equipo</h5>
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                        aria-label="Close">
                        <span class="svg-icon svg-icon-2x"></span>
                    </div>
                </div>

                <div class="modal-body">
                    <form action="{{ route('licitacion.eliminarlicitacion') }}" method="post" id="submit_desactivar">
                        @csrf
                        <div class="row form-group">
                            <div class="col-lg-12 mt-2">
                                <label>Motivo</label>
                                <input type="text" class="form-control" name="motivo" id="id_motivo_concurso" />
                                <input type="hidden" name="id" id="id_del_lic">
                                <input type="hidden" name="name_concurso" id="name_concurso">
                            </div>
                        </div>
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn btn-secondary font-weight-bold" data-dismiss="modal"><i
                            class="la la-times"></i>Cancelar</button>
                    <button type="button" id="send_desactivar" class="btn btn-success"><i
                            class="la la-plus"></i>Guardar</button>
                </div>
            </div>
        </div>
    </div>
@endsection