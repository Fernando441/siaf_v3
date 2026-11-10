@extends('layouts.app')

@section('title')
    Siniestros DINA 
@endsection

@push('scripts')
  <script src="{{ asset('js/graficas.js') }}"></script>
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
                                <h3 class="card-label">Siniestros DINA </h3>
                            </div>
                            <div class="card-toolbar">

                                    <img alt="Logo" id="grafica" class="h-55px brand-logo" src="{{ asset('img/grafica.png') }}" />
                                <!--begin::Button-->
                                    <a href="{{ route('siniestro.crearsiniestro') }}" class="btn btn-light-primary font-weight-bolder mr-3 ml-3">
                                    <i class="la la-plus"></i>Nuevo</a>


                                    <a href="#" id="carga_masiva_equ" class="btn btn-light-primary font-weight-bolder mr-3 ml-3" ><i class="la la-plus"></i>carga masiva</a>
                                    <input type="hidden" id="num_carga" value="0">
                                <!--end::Button-->


                            </div>
                        </div>
                        <div class="card-body">
                            
                                <!-- ESTADISTICAS -->
                                <div class="row dashboard-stats">
                                    <!-- TOTAL DE TICKETS -->
                                    <div class="col-xl-3 col-lg-6 col-md-6">
                                        <div class="stat-card stat-blue">
                                            <div class="stat-content">
                                                <div class="stat-value">
                                                    {{ count($siniestro_dina) }}
                                                </div>
                                                <div class="stat-label">
                                                    Total de siniestros
                                                </div>
                                            </div>

                                            <div class="stat-icon">
                                                <i class="fas fa-ticket-alt"></i>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- TICKETS FINALIZADOS -->
                                    <div class="col-xl-3 col-lg-6 col-md-6">
                                        <div class="stat-card stat-cyan">
                                            <div class="stat-content">
                                                <div class="stat-value">
                                                   {{ count($siniestro_con_deducible) }}
                                                </div>
                                                <div class="stat-label">
                                                    Con Deducible
                                                </div>
                                            </div>

                                            <div class="stat-icon">
                                                <i class="fas fa-check-circle"></i>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- TICKETS PENDIENTES -->
                                    <div class="col-xl-3 col-lg-6 col-md-6">
                                        <div class="stat-card stat-gold">
                                            <div class="stat-content">
                                                <div class="stat-value">
                                                    {{ count($siniestro_con_recuperacion) }}
                                                </div>
                                                <div class="stat-label">
                                                    Con Recuperacion Aplicada
                                                </div>
                                            </div>

                                            <div class="stat-icon">
                                                <i class="fas fa-clock"></i>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- PORCENTAJE FINALIZADO -->
                                    <div class="col-xl-3 col-lg-6 col-md-6">
                                        <div class="stat-card stat-red">
                                            <div class="stat-content">
                                                <div class="stat-value">
                                                    {{-- Dato --}}
                                                </div>
                                                <div class="stat-label">
                                                    Siniestros Finalizados
                                                </div>
                                            </div>

                                            <div class="stat-icon">
                                                <i class="fas fa-chart-pie"></i>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <!-- FIN ESTADISTICAS -->

                                {{-- GRAFICAS --}}
                                <div class="row oculto" id="div_grafica">
                                    <input type="hidden" id="op_div_grafica" value="0">
                                    <div class="col-lg-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <h3 class="card-title">
                                                    KPI's
                                                </h3>
                                            </div>
                                            <div class="card-body">
                                                Centralize your team information with our management tools. Access detailed instructions, expert advice, and technical documentation to maintain an up-to-date team directory.
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- END GRAFICAS --}}

                            <div class="card card-custom gutter-b oculto" id="div_cargamasiva">
                              <div class="card-header">
                                <div class="card-title">
                                  <h3 class="card-label">
                                    <small>Carga masiva</small>
                                  </h3>
                                </div>
                              </div>
                              <div class="card-body">
                                 <a href="/layout/Carga Masiva Siniestros DINA.csv">Layout para la carga masiva</a>
                                    <div class="row">
                                      <div class="col-lg-10">
                                        <form class="form" action="{{ route('siniestro.cargamasivadina') }}" method="post" id="submit_carga" enctype="multipart/form-data" content="text/html; charset=utf-8">
                                          @csrf


                                          <div class="row">
                                              <div class="col-lg-12  form-group">
                                                  <div class='custom-file mt-2'>
                                                     <input type='file' class='custom-file-input' id='file_carga' name='file_carga' required />
                                                     <label class='custom-file-label' for='foto"+contadorFotografia+"'>Selecciona un archivo</label>
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
                          {{-- END  Carga masiva  --}}

                            <!--begin: Datatable-->
                            <table class="table table-hover table-checkable table-responsive" id="kdatatable_inventario">
                                <thead>
                                <tr>
                                    <th>No. Folio</th>
                                    <th>No. Siniestro</th>
                                    <th>No. Serie</th>
                                    <th>Proyecto</th>
                                    <th>Proveedor</th>
                                    <th>Deducible</th>
                                    <th>Recuperacion aplicada</th>
                                    <th>REF</th>
                                    <th>Creado por</th>
                                    <th>Formato</th>
                                    <th>Estado</th>
                                  <th class="text-center">Opciones</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($siniestro_dina as $siniestro)
                                        <tr>
                                            <td>{{ $siniestro->no_folio }}</td>
                                            <td><a href="{{ route('siniestro.versiniestro', $siniestro->id) }}">{{ $siniestro->no_siniestro }}</a></td>
                                            <td>{{ $siniestro->serie }}</td>
                                            <td>{{ $siniestro->nombre_proyecto }}</td>
                                            <td>Proveedor</td>
                                            <td>{{ $siniestro->deducible }}</td>
                                            <td>{{ $siniestro->recuperacion_aplicada }}</td>
                                            <td>S/N</td>
                                            <td>{{ $siniestro->userCreated->name}}</td>
                                            <td>{{ $siniestro->contratante }}</td>
                                            <td>S/N</td>
                                            <td>
                                                <a href="{{ route('siniestro.versiniestro', $siniestro->id) }}" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon" title="Ver registro" data-theme="dark" data-toggle="tooltip" data-placement="top"> <i class="flaticon-eye"></i></a>

                                                <a href="{{ route('siniestro.editasiniestro',$siniestro->id) }}" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon" title="Editar registro" data-theme="dark" data-toggle="tooltip" data-placement="top"><i class="flaticon-edit"></i></a>
                                            </td>
                                            
                                        </tr>
                                    @endforeach
                                    {{-- Datos --}}
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>No. Folio</th>
                                    <th>No. Siniestro</th>
                                    <th>No. Serie</th>
                                    <th>Proyecto</th>
                                    <th>Proveedor</th>
                                    <th>Deducible</th>
                                    <th>Recuperacion aplicada</th>
                                    <th>REF</th>
                                    <th>Creado por</th>
                                    <th>Formato</th>
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


@endsection