@extends('layouts.app')
@push('scripts')
  <script src="{{ asset('js/licitaciones/CatalogoLicitaciones.js') }}"></script>
@endpush
@section('title')
    Listado de concursos inactivos
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
                                <h3 class="card-label">Listado de concursos inactivos</h3>
                            </div>
                            <div class="card-toolbar">

                                <!--begin::Button-->
                                <a href="{{ route('licitacion.listadolicitaciones') }}" class="btn btn-light-primary font-weight-bolder mr-3 ml-3">
                                    <i class="la la-arrow-left"></i>Regresar</a>
                                <!--end::Button-->

                            </div>
                        </div>
                        <div class="card-body">
                            <!--begin: Datatable-->
                            <table class="table table-hover table-checkable" id="kdatatable_licitaciones_inactivas">
                                <thead>
                                <tr>
                                  <th>Folio</th>
                                  <th>Cliente</th>
                                  <th>Titulo servicio</th>
                                  <th>Prioridad</th>
                                  <th>Publicación del concurso</th>
                                  <th>Fecha visita</th>
                                  <th>Tipo de contratación</th>
                                  <th>Motivo</th>
                                  <th class="text-center">Opciones</th>
                                </tr>
                                </thead>

                                <tbody>
                                  @foreach($licitaciones as $unid)
                                    <tr>
                                      <td>{{ $unid->folio }}</td>
                                      <td>{{ $unid->razon_social }}</td>
                                      <td>{{ $unid->titulo_servicio }}</td>
                                      <td>
                                          <span class="label font-weight-bold label-outline-danger label-inline" >{{ $unid->licitacionPrioridad->prioridad }}</span>
                                      </td>
                                      <td>{{ $unid->publ }}</td>
                                      <td>{{ $unid->fecha_visita }}</td>
                                      <td>{{ $unid->tipo_contratacion }}</td>
                                      <td><span style="color: red;">{{ $unid->motivo_desactivar }}</span></td>
                                      <td class="text-center">
                                        <button class="btn btn-sm btn-clean btn-hover-icon-success btn-icon activar-licitacion" data-id="{{ $unid->id }}" data-nombre="{{ $unid->folio }}" data-toggle="tooltip" data-theme="dark" title="Activar Licitación" ><i class="flaticon2-reply "></i></button>
                                      </td>
                                    </tr>
                                  @endforeach
                                </tbody>

                                <tfoot>
                                <tr>
                                  <th>Folio</th>
                                  <th>Cliente</th>
                                  <th>Titulo servicio</th>
                                  <th>Prioridad</th>
                                  <th>Publicación del concurso</th>
                                  <th>Fecha visita</th>
                                  <th>Tipo de contratación</th>
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

 <form method="post" id="lic_act_form" action="{{ route('licitacion.activarlicitacion') }}" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="id" id="id_lic_act" value="">
  </form>

@endsection
