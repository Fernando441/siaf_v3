@extends('layouts.app')

@section('title')
    Catálogo de patios
@endsection

@push('scripts')
  <script src="{{ asset('js/unidades/AsignacionUnidadesContratos.js') }}"></script>

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
                                <h3 class="card-label">Asignar unidades a la solicitud</h3>
                            </div>
                            <div class="card-toolbar">

                                <!--begin::Button-->
                                <a href="{{ route('movimientoslog.listadomovimientos') }}" class="btn btn-light-primary font-weight-bolder mr-3 ml-3">
                                  Regresar</a>
                                <!--end::Button-->

                            </div>
                        </div>
                        <div class="card-body">
                          <ul class="nav nav-tabs nav-tabs-line">
                              <li class="nav-item">
                                  <a class="nav-link active" data-toggle="tab" href="#kt_tab_pane_1">Patios disponibles</a>
                              </li>
                              <li class="nav-item">
                                  <a class="nav-link" data-toggle="tab" href="#kt_tab_pane_2">Unidades asignados</a>
                              </li>
                          </ul>

                          <div class="tab-content mt-5" id="myTabContent">
                            <div class="tab-pane fade show active mt-10" id="kt_tab_pane_1" role="tabpanel" aria-labelledby="kt_tab_pane_1">
                                <table class="table table-hover table-checkable" id="kdatatable_unidades_contratos">
                                    <thead>
                                    <tr>
                                      <th>No.</th>
                                      <th>Ubicación</th>
                                      <th class="text-center">Opciones</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                      @foreach($ubicacion as $unid)
                                        <tr>
                                          <td>{{ $unid->id }}</td>
                                          <td>{{ $unid->ubicacion }}</td>

                                          <td class="text-center">
                                            {{-- {{ route('asignarunidad.asignarunidadespatio', [$licitacion,$unid->id]) }} --}}
                                            <a href="" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon activar-ubicacion"  data-toggle="tooltip" data-theme="dark" title="Ver unidades" ><i class="flaticon-eye "></i></a>
                                          </td>
                                        </tr>
                                      @endforeach
                                    </tbody>

                                    <tfoot>
                                    <tr>
                                      <th>No.</th>
                                      <th>Ubicación</th>
                                      <th class="text-center">Opciones</th>
                                    </tr>
                                    </tfoot>

                                </table>
                            </div>

                            <div class="tab-pane fade mt-10" id="kt_tab_pane_2" role="tabpanel" aria-labelledby="kt_tab_pane_2">
                                <table class="table table-hover table-checkable" id="kdatatable_unidades_seleccionadas">
                                            <thead>
                                            <tr>
                                                <th>Folio</th>
                                                <th>Marca</th>
                                                <th>Modelo</th>
                                                <th>Serie</th>
                                                <th>Placa</th>
                                                <th>Año</th>
                                                <th>Segmento</th>
                                                <th>Tipo de asignación</th>
                                                <th>Fecha de asignación</th>
                                                <th>Cliente</th>
                                                {{-- <th>Acción</th> --}}
                                            </tr>
                                            </thead>

                                            <tbody>

                                            </tbody>

                                            <tfoot>
                                            <tr>
                                                <th>Folio</th>
                                                <th>Marca</th>
                                                <th>Modelo</th>
                                                <th>Serie</th>
                                                <th>Placa</th>
                                                <th>Año</th>
                                                <th>Segmento</th>
                                                <th>Tipo de asignación</th>
                                                <th>Fecha de asignación</th>
                                                <th>Cliente</th>
                                                {{-- <th>Acción</th> --}}
                                            </tr>
                                            </tfoot>

                                </table>
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



@endsection