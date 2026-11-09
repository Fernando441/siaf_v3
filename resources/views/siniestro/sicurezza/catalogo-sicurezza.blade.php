@extends('layouts.app')

@section('title')
    Siniestros SICUREZZA 
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
                                <h3 class="card-label">Siniestros SICUREZZA </h3>
                            </div>
                            <div class="card-toolbar">

                                <!--begin::Button-->
                                    <a href="{{ route('sistemas.agregarRegistro') }}" class="btn btn-light-primary font-weight-bolder mr-3 ml-3">
                                    <i class="la la-plus"></i>Nuevo</a>



                                  <a href="#" id="carga_masiva_equ" class="btn btn-light-primary font-weight-bolder mr-3 ml-3" >
                                  <i class="la la-plus"></i>carga masiva</a>
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
                                                    {{-- dato --}}
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
                                                   {{-- dato --}}
                                                </div>
                                                <div class="stat-label">
                                                    Siniestros Finalizados
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
                                                    {{-- dato --}}
                                                </div>
                                                <div class="stat-label">
                                                    Siniestros Pendientes
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
                                                    Pendiente
                                                </div>
                                            </div>

                                            <div class="stat-icon">
                                                <i class="fas fa-chart-pie"></i>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <!-- FIN ESTADISTICAS -->

                            
                            <div class="card card-custom gutter-b oculto" id="div_cargamasiva">
                              <div class="card-header">
                                <div class="card-title">
                                  <h3 class="card-label">
                                    <small>Carga masiva</small>
                                  </h3>
                                </div>
                              </div>
                              <div class="card-body">
                                 <a href="/layout/Carga Masiva Siniestros Sicurezza.csv">Layout para la carga masiva</a>
                                    <div class="row">
                                      <div class="col-lg-10">
                                        <form class="form" action="{{ route('siniestro.cargamasivasicuezza') }}" method="post" id="submit_carga" enctype="multipart/form-data" content="text/html; charset=utf-8">
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
                                    {{-- Datos --}}
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


@endsection