@extends('layouts.app')

@section('title')
    Inventario de resguardos
@endsection

@push('scripts')
  <script src="{{ asset('js/sistemas/CatalogoSistemas.js') }}"></script>
@endpush

@section('content')

<style>
    .oculto{
        display:none;
    }
</style>

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
                                <h3 class="card-label">Inventario de resguardos</h3>
                            </div>
                            <div class="card-toolbar">

                                <!--begin::Button-->
                                    <a href="{{ route('resguardo.agregarResguardo') }}" class="btn btn-light-primary font-weight-bolder mr-3 ml-3">
                                    <i class="la la-plus"></i>Nuevo</a>

                                <!--end::Button-->

                                <a href="{{ route('sistemas.catalogoinventarioinactivos') }}" class="btn btn-light-primary font-weight-bolder mr-3 ml-3">
                                    <i class="far fa-trash-alt"></i>Resguardos inactivos</a>

                            </div>
                        </div>
                        <div class="card-body">
                            
                            <!--begin: Datatable-->
                            <table class="table table-hover table-checkable table-responsive" id="kdatatable_inventario">
                                <thead>
                                <tr>
                                    <th>No. Folio</th>
                                    <th>No. Serie</th>
                                    <th>Tipo de equipo</th>
                                    <th>Marca</th>
                                    <th>Modelo</th>
                                    <th>Fecha ingreso</th>
                                    <th>Estatus</th>
                                    <th>Personal</th>
                                  <th class="text-center">Opciones</th>
                                </tr>
                                </thead>

   

                                <tfoot>
                                <tr>
                                    <th>No. Folio</th>
                                    <th>No. Serie</th>
                                    <th>Tipo de equipo</th>
                                    <th>Marca</th>
                                    <th>Modelo</th>
                                    <th>Fecha ingreso</th>
                                    <th>Estatus</th>
                                    <th>Personal</th>
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
                    <form action="{{ route('sistemas.deleteRegistro') }}" method="post" id="submit_desactivar">
                        @csrf
                        <div class="row form-group">
                            <div class="col-lg-12 mt-2">
                                <label>Motivo</label>
                                <input type="text" class="form-control" name="motivo" id="id_motivo_concurso" />
                                <input type="hidden" name="id" id="id_equipo">
                                <input type="hidden" name="no_serie" id="no_serie">
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