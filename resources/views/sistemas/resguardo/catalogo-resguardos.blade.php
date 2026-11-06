@extends('layouts.app')

@section('title')
    Inventario de resguardos
@endsection

@push('scripts')
  <script src="{{ asset('js/sistemas/CatalogoSistemas.js') }}"></script>
  <script>
    $(".modal-pdf").on('click', function () {
      var path = $(this).attr('rel-path');
      var modal = $("#exampleModalSizeSm");
      var object_pdf = $("#modal-body");
      var content = `<object id="object_pdf" type="application/pdf" data="`+path+`" width="100%" height="500" style="height: 85vh;">No Support</object>`;
      object_pdf.html(content);
      modal.modal("show");
    });
  </script>
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
                            <div class="row">
                                <div class="col-lg-12">
                            
                                    <!--begin: Datatable-->
                                    <table class="table table-hover table-checkable" id="kdatatable_inventario">
                                        <thead>
                                        <tr>
                                            <th>No. Folio</th>
                                            <th>Usuario</th>
                                            <th>Fecha resguardo</th>
                                            <th>Descripcion</th>
                                            <th>Estatus</th>
                                          <th class="text-center">Opciones</th>
                                        </tr>
                                        </thead>
                                          @foreach($resguardo as $unid)
                                            <tr>
                                              <td>{{ $unid->no_folio }}</td>
                                              <td>{{ $unid->user_resguardo }}</td>
                                              <td>{{ $unid->fecha_asignacion }}</td>
                                              <td>{{ $unid->descripcion }}</td>
                                              <td></td>
                                              
                                              <td class="text-center">
                                                <button rel-path="{{ route('resguardo.verPDF', $unid->id) }}" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon modal-pdf" title="Ver PDF" data-theme="dark"  data-toggle="tooltip" data-placement="top">
                                                        <i class="far fa-file-pdf"></i>
                                                </button>
                                                <a href="{{ route('resguardo.verResguardo',$unid->id) }}" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon" title="Ver resguardo" data-theme="dark" data-toggle="tooltip" data-placement="top"> <i class="flaticon-eye"></i></a>

                                                <a href="{{ route('resguardo.editResguardo',$unid->id) }}" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon" title="Editar resguardo" data-theme="dark" data-toggle="tooltip" data-placement="top"><i class="flaticon-edit"></i></a>

                                                <button class="btn btn-sm btn-clean btn-hover-icon-success btn-icon desctiva_reg" data-id="{{ $unid->id }}" data-nombre="{{ $unid->no_folio }}" data-toggle="modal" data-target="#model_delete_concurso" data-toggle="tooltip" data-theme="dark" title="Desactivar resguardo">
                                                        <i class="flaticon-delete"></i>
                                                </button>
                                              </td>
                                            </tr>
                                          @endforeach
           

                                        <tfoot>
                                        <tr>
                                            <th>No. Folio</th>
                                            <th>Usuario</th>
                                            <th>Fecha resguardo</th>
                                            <th>Descripcion</th>
                                            <th>Estatus</th>
                                          <th class="text-center">Opciones</th>
                                        </tr>
                                        </tfoot>

                                    </table>
                                    <!--end: Datatable-->
                                </div>
                            </div>

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
                    <h5 class="modal-title">Desactivar resguardo</h5>
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


    <div class="modal fade" id="exampleModalSizeSm" tabindex="-1" role="dialog" aria-labelledby="exampleModalSizeSm"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Resguardo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <div id="modal-body" class="modal-body">
                    
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn btn-secondary font-weight-bold" data-dismiss="modal"><i
                            class="la la-times"></i>Cerrar</button>
                     
                </div>
            </div>
        </div>
    </div>

@endsection