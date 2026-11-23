@extends('layouts.app')

@section('title')
    Siniestros HDI 
@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.js"></script>
    <script src="{{ asset('js/siniestros/GraficaSiniestros.js') }}"></script>
    <script src="{{ asset('js/siniestros/Catalogosiniestro.js') }}"></script>
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
                                <a class="grafica-tooltip">
                                    <img alt="Logo" id="grafica" class="button-grafica brand-logo"
                                            src="{{ asset('img/grafica.png') }} " title="Graficar" />
                                    <span class="tooltip-text"></span>
                                </a>


                                <h3 class="card-label">Siniestros HDI </h3>
                            </div>
                            <div class="card-toolbar">

                                    
                                <!--begin::Button-->
                                    <a href="{{ route('siniestro.crearsiniestrohdi') }}" class="btn btn-light-primary font-weight-bolder mr-3 ml-3">
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
                                                    {{-- {{ count($siniestro_dina) }} --}}
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
                                                   {{-- {{ count($siniestro_con_deducible) }} --}}
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
                                                    {{-- {{ count($siniestro_con_recuperacion) }} --}}
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
                                                    {{-- {{ count($siniestro_con_ambas) }} --}}
                                                </div>
                                                <div class="stat-label">
                                                    Siniestros con Ambas
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
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <canvas id="siniestros_deducible" style="width: 100px;"></canvas>
{{--                                                         <input type="hidden" id="siniestro_con_deducible" value="{{ count($siniestro_con_deducible) }}">
                                                        <input type="hidden" id="siniestro_recuperacion" value="{{ count($siniestro_con_recuperacion) }}">
                                                        <input type="hidden" id="siniestro_ambas" value="{{ count($siniestro_con_ambas) }}"> --}}
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <canvas id="barras" style="width: 100px;"></canvas>
                                                    </div>
                                                </div>
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
                                 <a href="/layout/Carga Masiva Siniestros HDI.csv">Layout para la carga masiva</a>
                                    <div class="row">
                                      <div class="col-lg-10">
                                        <form class="form" action="{{ route('siniestro.cargamasivhdi') }}" method="post" id="submit_carga" enctype="multipart/form-data" content="text/html; charset=utf-8">
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
                            <table class="table table-hover table-checkable" id="kdatatable_inventario">
                                <thead>
                                <tr>
                                    <th>No. Folio</th>
                                    <th>No. Siniestro</th>
                                    <th>No. Serie</th>
                                    <th class="text-center">Opciones</th>
                                    <th>Reporte cabina</th>
                                    <th>Fecha ocurrido</th>
                                    <th>Año ocurrido</th>
                                    <th>No. Poliza</th>
                                    <th>Proyecto</th>
                                    <th>Estatus poliza</th>
                                    <th>Inicio de vigencia</th>
                                    <th>Termino vigencia</th>                                  
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($siniestro_hdi as $siniestro)
                                        <tr>
                                            <td>{{ $siniestro->no_folio }}</td>
                                            <td><a href="{{ route('siniestro.versiniestrohdi', $siniestro->id) }}">{{ $siniestro->numero_siniestro }}</a></td>
                                            <td>{{ $siniestro->serie }}</td>
                                            <td>
                                                <button rel-path="{{ route('siniestro.versiniestrodinaPDF', $siniestro->id) }}" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon modal-pdf" title="Ver PDF" data-theme="dark"  data-toggle="tooltip" data-placement="top">
                                                        <i class="far fa-file-pdf"></i>
                                                </button>

                                                <a href="{{ route('siniestro.versiniestro', $siniestro->id) }}" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon" title="Ver registro" data-theme="dark" data-toggle="tooltip" data-placement="top"> <i class="flaticon-eye"></i></a>

                                                <a href="{{ route('siniestro.editarsiniestrohdi',$siniestro->id) }}" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon" title="Editar registro" data-theme="dark" data-toggle="tooltip" data-placement="top"><i class="flaticon-edit"></i></a>
                                            </td>
                                            <td>{{ $siniestro->reporte_cabina }}</td>
                                            <td>{{ $siniestro->fecha_ocurrido }}</td>
                                            <td>{{ $siniestro->proyecto }}</td>
                                            <td>{{ $siniestro->year }}</td>
                                            <td>{{ $siniestro->numero_poliza }}</td>
                                            <td>{{ $siniestro->estatus_poliza }}</td>
                                            <td>{{ $siniestro->inicio_vigencia }}</td>
                                            <td>{{ $siniestro->termino_vigencia }}</td>
                                        </tr>
                                    @endforeach
                                    
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>No. Folio</th>
                                    <th>No. Siniestro</th>
                                    <th>No. Serie</th>
                                    <th class="text-center">Opciones</th>
                                    <th>Reporte cabina</th>
                                    <th>Fecha ocurrido</th>
                                    <th>Año ocurrido</th>
                                    <th>No. Poliza</th>
                                    <th>Proyecto</th>
                                    <th>Estatus poliza</th>
                                    <th>Inicio de vigencia</th>
                                    <th>Termino vigencia</th>                                    
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



    <div class="modal fade" id="exampleModalSizeSm" tabindex="-1" role="dialog" aria-labelledby="exampleModalSizeSm"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Siniestro</h5>
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