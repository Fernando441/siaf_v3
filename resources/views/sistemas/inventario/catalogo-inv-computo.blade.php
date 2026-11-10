@extends('layouts.app')

@section('title')
  Inventario de equipo de computo
@endsection

@push('scripts')
  <script src="{{ asset('js/sistemas/CatalogoSistemas.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="{{ asset('js/sistemas/GraficasSistemas.js') }}"></script>
@endpush

@section('content')

  <style>
    .oculto {
      display: none;
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
                  <h3 class="card-label">Inventario de equipo de computo</h3>
                </div>
                <div class="card-toolbar">
                  <img alt="Logo" id="grafica" class="h-55px brand-logo" src="{{ asset('img/grafica.png') }}" />
                  <!--begin::Button-->
                  <a href="{{ route('sistemas.agregarRegistro') }}"
                    class="btn btn-light-primary font-weight-bolder mr-3 ml-3">
                    <i class="la la-plus"></i>Nuevo</a>



                  <a href="#" id="carga_masiva_equ" class="btn btn-light-primary font-weight-bolder mr-3 ml-3">
                    <i class="la la-plus"></i>carga masiva</a>
                  <input type="hidden" id="num_carga" value="0">
                  <!--end::Button-->

                  <a href="{{ route('sistemas.catalogoinventarioinactivos') }}"
                    class="btn btn-light-primary font-weight-bolder mr-3 ml-3">
                    <i class="far fa-trash-alt"></i>Registros inactivos</a>

                </div>

              </div>

              <div class="card-body">
                <!-- ESTADISTICAS -->
                <div class="row dashboard-stats">

                  <!-- TOTAL DE EQUIPOS -->
                  <div class="col-xl-3 col-lg-6 col-md-6">
                    <div class="stat-card stat-blue">
                      <div class="stat-content">
                        <div class="stat-value">
                          {{ count($inventario) }}
                        </div>
                        <div class="stat-label">
                          Total de equipos
                        </div>
                      </div>

                      <div class="stat-icon">
                        <i class="fas fa-laptop"></i>
                      </div>
                    </div>
                  </div>

                  <!-- EQUIPOS ASIGNADOS -->
                  <div class="col-xl-3 col-lg-6 col-md-6">
                    <div class="stat-card stat-cyan">
                      <div class="stat-content">
                        <div class="stat-value">
                          {{ $inventario->where('estatus_asignado', 1)->count()}}
                        </div>
                        <div class="stat-label">
                          Equipos asignados
                        </div>

                      </div>

                      <div class="stat-icon">
                        <i class="fas fa-check-circle"></i>
                      </div>
                    </div>
                  </div>

                  <!-- EQUIPOS SIN ASIGNAR -->
                  <div class="col-xl-3 col-lg-6 col-md-6">
                    <div class="stat-card stat-gold">
                      <div class="stat-content">
                        <div class="stat-value">
                          {{ $inventario->where('estatus_asignado', 0)->count()}}
                        </div>
                        <div class="stat-label">
                          Equipos sin asignar
                        </div>
                      </div>

                      <div class="stat-icon">
                        <i class="fas fa-clock"></i>
                      </div>
                    </div>
                  </div>

                  <!-- PORCENTAJE -->
                  <div class="col-xl-3 col-lg-6 col-md-6">
                    <div class="stat-card stat-red">
                      <div class="stat-content">
                        <div class="stat-value">

                        </div>
                        <div class="stat-label">
                          BUSCAR
                        </div>
                      </div>

                      <div class="stat-icon">
                        <i class="fas fa-chart-pie"></i>
                      </div>
                    </div>
                  </div>

                </div>
                <!-- FIN ESTADISTICAS -->

                {{-- PANEL DE GRAFICAS --}}
                <div class="row oculto" id="div_grafica">

                  <div class="col-lg-12">
                    <div class="card">
                      <div class="card-header">
                        <h3 class="card-title">Dashboard KPI's</h3>
                      </div>

                      <div class="card-body">
                        <div class="row">
                          <!-- GRAFICA DE DONA -->
                          <div class="col-lg-4 col-md-6 mb-4">
                            <canvas id="graficaDona" style="width: 100px;"></canvas>
                            <input type="hidden" id="totales_inventario" value="{{ count($inventario) }}">
                          </div>
                          <div class="col-lg-4 col-md-6 mb-4">
                            <canvas id="graficaDonas" style="width: 100px;"></canvas>
                            <input type="hidden" id="totales_inventario" value="{{ count($inventario) }}">
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                </div>
                {{-- FIN PANEL --}}

                <div class="card card-custom gutter-b oculto" id="div_cargamasiva">
                  <div class="card-header">
                    <div class="card-title">
                      <h3 class="card-label">
                        <small>Carga masiva</small>
                      </h3>
                    </div>
                  </div>
                  <div class="card-body">
                    <a href="/layout/Carga Masiva Inventario Sistemas.csv">Layout para la carga masiva</a>
                    <div class="row">
                      <div class="col-lg-10">
                        <form class="form" action="" method="post" id="submit_carga" enctype="multipart/form-data"
                          content="text/html; charset=utf-8">
                          @csrf


                          <div class="row">
                            <div class="col-lg-12  form-group">
                              <div class='custom-file mt-2'>
                                <input type='file' class='custom-file-input' id='file_carga' name='file_carga' required />
                                <label class='custom-file-label' for='foto"+contadorFotografia+"'>Selecciona un
                                  archivo</label>
                              </div>
                            </div>
                          </div>
                        </form>
                      </div>

                      <div class="col-lg-2 mt-2 form-group">
                        <button type="button" id="send_carga" class="btn btn-primary">Subir</button>
                      </div>

                    </div>

                  </div>
                </div>
                {{-- END Carga masiva --}}

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
                            <span class="label font-weight-bold label-outline-danger label-inline"
                              style="width: 120px; font-size: 10px; font-weight: bold;">No asignado</span>
                          @else
                            <span class="label font-weight-bold label-outline-success label-inline">Asignado</span>
                          @endif

                        </td>
                        <td>
                          @if($unid->estatus_asignado == 0)
                            ---
                          @else
                            {{ $unid->userAsignado->name }}
                          @endif
                        </td>

                        <td class="text-center">
                          <a href="{{ route('sistemas.verRegistro', $unid->id) }}"
                            class="btn btn-sm btn-clean btn-hover-icon-success btn-icon" title="Ver equipo"
                            data-theme="dark" data-toggle="tooltip" data-placement="top"> <i class="flaticon-eye"></i></a>

                          <a href="{{ route('sistemas.editarRegistro', $unid->id) }}"
                            class="btn btn-sm btn-clean btn-hover-icon-success btn-icon" title="Editar equipo"
                            data-theme="dark" data-toggle="tooltip" data-placement="top"><i class="flaticon-edit"></i></a>

                          <button class="btn btn-sm btn-clean btn-hover-icon-success btn-icon desctiva_reg"
                            data-id="{{ $unid->id }}" data-nombre="{{ $unid->no_serie }}" data-toggle="modal"
                            data-target="#model_delete_concurso" data-toggle="tooltip" data-theme="dark"
                            title="Desactivar equipo">
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
          <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
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
          <button type="button" id="send_desactivar" class="btn btn-success"><i class="la la-plus"></i>Guardar</button>
        </div>
      </div>
    </div>
  </div>
@endsection