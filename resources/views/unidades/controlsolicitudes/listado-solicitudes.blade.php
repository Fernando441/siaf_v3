@extends('layouts.app')

@section('title')
    Control de solicitudes
@endsection

@push('scripts')
  <script src="{{ asset('js/unidades/ControlSolicitudesEjecutivo.js') }}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.js"></script>
  <script type="text/javascript">


  var sus_motivo_falla = document.getElementById("sus_motivo_falla").value;
  var sus_motivo_siniestro = document.getElementById("sus_motivo_siniestro").value;
  var sus_motivo_perdida = document.getElementById("sus_motivo_perdida").value;    
  var ctx = document.getElementById('motivo_susutituta').getContext('2d');
  var myChartsemanados = new Chart(ctx, {
      type: 'doughnut',
      data: {
          labels:['Falla mecanica','Siniestro','Perdida total'],
          datasets: [{
              label: 'Motivo',
              data: [sus_motivo_falla, sus_motivo_siniestro, sus_motivo_perdida],
              backgroundColor: [
                  'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)'
              ],
              borderColor: [
                  'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)'
              ],
              borderWidth: 1
          }]
      },
      options: {
          scales: {
              yAxes: [{
                  ticks: {
                      beginAtZero: true
                  }
              }]
          }
      }
  });

  var sustituto_estatus_solicitado = document.getElementById("sustituto_estatus_solicitado").value;
  var sustituto_estatus_envlogistica = document.getElementById("sustituto_estatus_envlogistica").value;
  var sustituto_estatus_unidasignada = document.getElementById("sustituto_estatus_unidasignada").value;
  var sustituto_estatus_finalizado = document.getElementById("sustituto_estatus_finalizado").value;  
  var ctx_tipo = document.getElementById('susutituto_estatus').getContext('2d');
  var myChartsemanados = new Chart(ctx_tipo, {
      type: 'bar',
      data: {
          labels:['Solicitado','Enviada a logística','Unidad sustituta asignada', 'Finalizada'],
          datasets: [{
              label: 'Tipo de solicitud',
              data: [sustituto_estatus_solicitado, sustituto_estatus_envlogistica, sustituto_estatus_unidasignada, sustituto_estatus_finalizado],
              backgroundColor: [
                  'rgba(138, 115, 25, 0.2)',
                  'rgba(255, 99, 132, 0.2)',
                  'rgba(54, 162, 235, 0.2)',
                  'rgba(255, 206, 86, 0.2)'
              ],
              borderColor: [
                  'rgba(138, 115, 25, 1)',
                  'rgba(255, 99, 132, 1)',
                  'rgba(54, 162, 235, 1)',
                  'rgba(255, 206, 86, 1)'
              ],
              borderWidth: 1
          }]
      },
      options: {
          scales: {
              yAxes: [{
                  ticks: {
                      beginAtZero: true
                  }
              }]
          }
      }
  });



$("#kdatatable_sustituta").DataTable({
    language: {
        'lengthMenu': 'Display _MENU_',
        "url": $('#datatable_i18n').val()
    },

    "dom":
    "<'row'" +
    "<'col-sm-6 d-flex align-items-center justify-conten-start'l>" +
    "<'col-sm-6 d-flex align-items-center justify-content-end'f>" +
    ">" +

    "<'table-responsive'tr>" +

    "<'row'" +
    "<'col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start'i>" +
    "<'col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end'p>" +
    ">"
});
//END ------------------------------------------------------------------------------------------------------------------------------------ SOlicitudes Sustitutas

  var mantenimientSolicitud_prioridad_alta = document.getElementById("mantenimientSolicitud_prioridad_alta").value;
  var mantenimientSolicitud_prioridad_media = document.getElementById("mantenimientSolicitud_prioridad_media").value;
  var mantenimientSolicitud_prioridad_baja = document.getElementById("mantenimientSolicitud_prioridad_baja").value;
  var ctx = document.getElementById('prioridad2').getContext('2d');
  var myChartsemanados = new Chart(ctx, {
      type: 'doughnut',
      data: {
          labels:['Alta','Media','Baja'],
          datasets: [{
              label: 'Prioridad',
              data: [mantenimientSolicitud_prioridad_alta, mantenimientSolicitud_prioridad_media, mantenimientSolicitud_prioridad_baja],
              backgroundColor: [
                  'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)'
              ],
              borderColor: [
                  'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)'
              ],
              borderWidth: 1
          }]
      },
      options: {
          scales: {
              yAxes: [{
                  ticks: {
                      beginAtZero: true
                  }
              }]
          }
      }
  });

  var ms_tipo_preventivo = document.getElementById("ms_tipo_preventivo").value;
  var ms_tipo_correctivo = document.getElementById("ms_tipo_correctivo").value;
  var ms_tipo_siniestro = document.getElementById("ms_tipo_siniestro").value;
  var ms_tipo_admin = document.getElementById("ms_tipo_admin").value;
  var ctx_tipo = document.getElementById('tipo_solicitud2').getContext('2d');
  var myChartsemanados = new Chart(ctx_tipo, {
      type: 'bar',
      data: {
          labels:['Correctivo','Preventivo','Siniestro', 'Administrativo'],
          datasets: [{
              label: 'Tipo de solicitud',
              data: [ms_tipo_preventivo, ms_tipo_correctivo, ms_tipo_siniestro, ms_tipo_admin],
              backgroundColor: [
                  'rgba(138, 115, 25, 0.2)',
                  'rgba(255, 99, 132, 0.2)',
                  'rgba(54, 162, 235, 0.2)',
                  'rgba(255, 206, 86, 0.2)'
              ],
              borderColor: [
                  'rgba(138, 115, 25, 1)',
                  'rgba(255, 99, 132, 1)',
                  'rgba(54, 162, 235, 1)',
                  'rgba(255, 206, 86, 1)'
              ],
              borderWidth: 1
          }]
      },
      options: {
          scales: {
              yAxes: [{
                  ticks: {
                      beginAtZero: true
                  }
              }]
          }
      }
  });

  var ms_estatus_pendiente = document.getElementById("ms_estatus_pendiente").value;
  var ms_estatus_envrevision = document.getElementById("ms_estatus_envrevision").value;
  var ms_estatus_rechazado = document.getElementById("ms_estatus_rechazado").value;
  var ms_estatus_autorizado = document.getElementById("ms_estatus_autorizado").value;
  var ms_estatus_finalizado = document.getElementById("ms_estatus_finalizado").value;
  var ms_estatus_entaller = document.getElementById("ms_estatus_entaller").value;
  var ctx_estatus = document.getElementById('estatus2').getContext('2d');
  var myChartsemanados = new Chart(ctx_estatus, {
      type: 'bar',
      data: {
          labels:['Pendiente','Enviado a revision','Rechazado', 'Autorizado', 'Finalizado'],
          datasets: [{
              label: 'Estatus',
              data: [ms_estatus_pendiente, ms_estatus_envrevision, ms_estatus_rechazado, ms_estatus_autorizado,ms_estatus_finalizado],
              backgroundColor: [
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(160, 255, 97, 0.2)',
                    'rgba(229, 97, 255, 0.2)',
                    'rgba(209, 230, 121, 0.2)',
                    'rgba(138, 115, 25, 0.2)'
              ],
              borderColor: [
                    'rgba(54, 162, 235, 1)',
                    'rgba(160, 255, 97, 1)',
                    'rgba(229, 97, 255, 1)',
                    'rgba(209, 230, 121, 1)',
                    'rgba(138, 115, 25, 1)'
              ],
              borderWidth: 1
          }]
      },
      options: {
          scales: {
              yAxes: [{
                  ticks: {
                      beginAtZero: true
                  }
              }]
          }
      }
  });

$("#kdatatable_mantenimiento").DataTable({
    language: {
        'lengthMenu': 'Display _MENU_',
        "url": $('#datatable_i18n').val()
    },

    "dom":
    "<'row'" +
    "<'col-sm-6 d-flex align-items-center justify-conten-start'l>" +
    "<'col-sm-6 d-flex align-items-center justify-content-end'f>" +
    ">" +

    "<'table-responsive'tr>" +

    "<'row'" +
    "<'col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start'i>" +
    "<'col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end'p>" +
    ">"
});

//END ------------------------------------------------------------------------------------------------------------------------- solicitudes mantenimiento


  var as_tipo_patio = document.getElementById("as_tipo_patio").value;
  var as_tipo_contrato = document.getElementById("as_tipo_contrato").value;
  var ctx_estatus = document.getElementById('tipo_asignacion').getContext('2d');
  var myChartsemanados = new Chart(ctx_estatus, {
      type: 'bar',
      data: {
          labels:['Patio','Contrato'],
          datasets: [{
              label: 'Tipo de asignación',
              data: [as_tipo_patio, as_tipo_contrato],
              backgroundColor: [
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(160, 255, 97, 0.2)',
              ],
              borderColor: [
                    'rgba(54, 162, 235, 1)',
                    'rgba(160, 255, 97, 1)',
              ],
              borderWidth: 1
          }]
      },
      options: {
          scales: {
              yAxes: [{
                  ticks: {
                      beginAtZero: true
                  }
              }]
          }
      }
  });


$("#kdatatable_asignacion").DataTable({
    language: {
        'lengthMenu': 'Display _MENU_',
        "url": $('#datatable_i18n').val()
    },

    "dom":
    "<'row'" +
    "<'col-sm-6 d-flex align-items-center justify-conten-start'l>" +
    "<'col-sm-6 d-flex align-items-center justify-content-end'f>" +
    ">" +

    "<'table-responsive'tr>" +

    "<'row'" +
    "<'col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start'i>" +
    "<'col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end'p>" +
    ">"
});

//END ------------------------------------------------------------------------------------------------------------------------- solicitudes asignacion


  var traslados_estatus_pendiente = document.getElementById("traslados_estatus_pendiente").value;
  var traslados_estatus_trasladista = document.getElementById("traslados_estatus_trasladista").value;
  var traslados_estatus_operador = document.getElementById("traslados_estatus_operador").value;
  var ctx_estatus = document.getElementById('traslado_estatus').getContext('2d');
  var myChartsemanados = new Chart(ctx_estatus, {
      type: 'bar',
      data: {
          labels:['Pendiente','Enviado a Trasladista', 'Enviado al operador'],
          datasets: [{
              label: 'Estatus',
              data: [traslados_estatus_pendiente, traslados_estatus_trasladista, traslados_estatus_operador],
              backgroundColor: [
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(160, 255, 97, 0.2)',
                    'rgba(138, 115, 25, 0.2)'
              ],
              borderColor: [
                    'rgba(54, 162, 235, 1)',
                    'rgba(160, 255, 97, 1)',
                    'rgba(138, 115, 25, 1)'

              ],
              borderWidth: 1
          }]
      },
      options: {
          scales: {
              yAxes: [{
                  ticks: {
                      beginAtZero: true
                  }
              }]
          }
      }
  });

$("#kdatatable_traslados").DataTable({
    language: {
        'lengthMenu': 'Display _MENU_',
        "url": $('#datatable_i18n').val()
    },

    "dom":
    "<'row'" +
    "<'col-sm-6 d-flex align-items-center justify-conten-start'l>" +
    "<'col-sm-6 d-flex align-items-center justify-content-end'f>" +
    ">" +

    "<'table-responsive'tr>" +

    "<'row'" +
    "<'col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start'i>" +
    "<'col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end'p>" +
    ">"
});

//END ------------------------------------------------------------------------------------------------------------------------- solicitudes traslado

  var gps_estatus_solicitada = document.getElementById("gps_estatus_solicitada").value;
  var gps_estatus_env_proveedor = document.getElementById("gps_estatus_env_proveedor").value;
  var gps_estatus_finalizada = document.getElementById("gps_estatus_finalizada").value;
  var gps_estatus_pendiente = document.getElementById("gps_estatus_pendiente").value;
  var gps_estatus_validacion = document.getElementById("gps_estatus_validacion").value;
  var gps_estatus_rechazada = document.getElementById("gps_estatus_rechazada").value;
  var ctx = document.getElementById('gps_estatus').getContext('2d');
  var myChartsemanados = new Chart(ctx, {
      type: 'doughnut',
      data: {
          labels:['Solicitada','Enviada al proveedor','Finalizada', 'Pendiente', 'Enviada para su validación', 'Rechazado'],
          datasets: [{
              label: 'Prioridad',
              data: [gps_estatus_solicitada, gps_estatus_env_proveedor, gps_estatus_finalizada,gps_estatus_pendiente, gps_estatus_validacion, gps_estatus_rechazada],
              backgroundColor: [
                  'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
              ],
              borderColor: [
                  'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
              ],
              borderWidth: 1
          }]
      },
      options: {
          scales: {
              yAxes: [{
                  ticks: {
                      beginAtZero: true
                  }
              }]
          }
      }
  });


$("#kdatatable_gps").DataTable({
    language: {
        'lengthMenu': 'Display _MENU_',
        "url": $('#datatable_i18n').val()
    },

    "dom":
    "<'row'" +
    "<'col-sm-6 d-flex align-items-center justify-conten-start'l>" +
    "<'col-sm-6 d-flex align-items-center justify-content-end'f>" +
    ">" +

    "<'table-responsive'tr>" +

    "<'row'" +
    "<'col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start'i>" +
    "<'col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end'p>" +
    ">"
});

//END ------------------------------------------------------------------------------------------------------------------------- solicitudes gps



  $('.op_solicitudes').on('change', function() {
      var selectedValue = $(this).val(); // Gets the value attribute of the selected option

      if( selectedValue == 1){
        document.getElementById("div_mantenimiento").scrollIntoView({
          behavior: "smooth"
        });        
      }


      if( selectedValue == 2){
        document.getElementById("div_sustitutas").scrollIntoView({
          behavior: "smooth"
        });        
      }

      if( selectedValue == 3){
        document.getElementById("div_asignacionunidades").scrollIntoView({
          behavior: "smooth"
        });        
      }

      if( selectedValue == 4){
        document.getElementById("div_traslados").scrollIntoView({
          behavior: "smooth"
        });        
      }

      if( selectedValue == 5){
        document.getElementById("div_gps").scrollIntoView({
          behavior: "smooth"
        });        
      }
      
  });


  $("#ver_mantenimiento").click(function(){
    $("#sol_mantenimiento").show();
        document.getElementById("sol_mantenimiento").scrollIntoView({
          behavior: "smooth"
        });  
    
  });

  $("#ver_unidsustitutas").click(function(){
    $("#sol_sustitutas").show();
        document.getElementById("sol_sustitutas").scrollIntoView({
          behavior: "smooth"
        });  
    
  });

  $("#ver_asignacion").click(function(){
    $("#sol_asignacion").show();
        document.getElementById("sol_asignacion").scrollIntoView({
          behavior: "smooth"
        });  
    
  });

  $("#ver_traslados").click(function(){
    $("#sol_traslados").show();
        document.getElementById("sol_traslados").scrollIntoView({
          behavior: "smooth"
        });  
    
  });


  $("#ver_gps").click(function(){
    $("#sol_gps").show();
        document.getElementById("sol_gps").scrollIntoView({
          behavior: "smooth"
        });  
    
  });

  </script>

@endpush

@section('content')

<style type="text/css">
  .oculto{display: none;}
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
                                <h3 class="card-label">Control de solicitudes</h3>
                            </div>
                            <div class="card-toolbar">
                                <select class="form-control op_solicitudes" name="op_solicitudes"  required >
                                      <option value="1" selected>Mantenimiento</option>
                                      <option value="2">Unidades sustitutas</option>
                                      <option value="3">Asignacion unidades</option>
                                      <option value="4">Traslados</option>
                                      <option value="5">GPS</option>
                                </select>

                            </div>
                        </div>
                        <div class="card-body">

                          <div class="card card-custom" id="div_mantenimiento">
                              <div class="card-header">
                                <div class="card-title">
                                  <span class="card-icon">
                                    <i class="flaticon2-file text-primary"></i>
                                  </span>
                                  <h3 class="card-label">Mantenimiento</h3>
                                </div>
                                <div class="card-toolbar">
                                  <button id="ver_mantenimiento" class="btn btn-light-primary font-weight-bolder mr-3 ml-3">
                                    <i class="flaticon-eye"></i>Ver solicitudes
                                  </button> 

                                </div>
                              </div>
                              <div class="card-body">

                                <div class="row">
                                  <div class="col-lg-12 text-center">
                                    <span style="font-size: 20px;">Total de solicitudes </span> <span style="font-size: 20px; font-weight: bold; color: #669933;">{{ $total_mantenimientSolicitud }}</span>
                                  </div>
                                </div>

                                <div class="row">
                                  <div class="col-lg-6">
                                    <input type="hidden" id="mantenimientSolicitud_prioridad_alta" value="{{ count($mantenimientSolicitud_prioridad_alta) }}">
                                    <input type="hidden" id="mantenimientSolicitud_prioridad_media" value="{{ count($mantenimientSolicitud_prioridad_media) }}">
                                    <input type="hidden" id="mantenimientSolicitud_prioridad_baja" value="{{ count($mantenimientSolicitud_prioridad_baja) }}">
                                    <canvas id="prioridad2" style="width: 100px;"></canvas>
                                  </div>

                                  <div class="col-lg-6">
                                    <input type="hidden" id="ms_tipo_preventivo" value="{{ count($ms_tipo_preventivo) }}">
                                    <input type="hidden" id="ms_tipo_correctivo" value="{{ count($ms_tipo_correctivo) }}">
                                    <input type="hidden" id="ms_tipo_siniestro" value="{{ count($ms_tipo_siniestro) }}">
                                    <input type="hidden" id="ms_tipo_admin" value="{{ count($ms_tipo_admin) }}">
                                    <canvas id="tipo_solicitud2" style="width: 100px;"></canvas>
                                  </div>

                                </div>


                                <div class="row mt-2">
                                  <div class="col-lg-6">
                                    <input type="hidden" id="ms_estatus_pendiente" value="{{ count($ms_estatus_pendiente) }}">
                                    <input type="hidden" id="ms_estatus_envrevision" value="{{ count($ms_estatus_envrevision) }}">
                                    <input type="hidden" id="ms_estatus_rechazado" value="{{ count($ms_estatus_rechazado) }}">
                                    <input type="hidden" id="ms_estatus_autorizado" value="{{ count($ms_estatus_autorizado) }}">
                                    <input type="hidden" id="ms_estatus_finalizado" value="{{ count($ms_estatus_finalizado) }}">
                                    <input type="hidden" id="ms_estatus_entaller" value="{{ count($ms_estatus_entaller) }}">
                                    <canvas id="estatus2" style="width: 100px;"></canvas>
                                  </div>
                                </div>


                                <div class="row oculto" id="sol_mantenimiento">
                                  <!--begin: Datatable-->
                                  <div class="col-lg-12">
                                    <table class="table table-hover table-checkable table-responsive" id="kdatatable_mantenimiento">
                                        <thead>
                                        <tr>
                                          <th>ID</th>
                                          <th>Fecha de solicitud</th>
                                          <th>Unidad</th>
                                          <th>Prioridad</th>
                                          <th>Tipo</th>
                                          <th>Concepto</th>
                                          {{-- <th>Cliente</th> --}}
                                          <th>Estatus</th>
                                          <th>Opciones</th>
                                        </tr>
                                        </thead>

                                        <tbody>
                                          @foreach($mantenimientSolicitud as $unid)
                                            <tr>
                                              <td>{{ $unid->id }}</td>
                                              <td>{{ $unid->fecha_solicitud }}</td>
                                              <td>{{ $unid->unidad->no_serie }}</td>
                                              <td>
                                                @if($unid->prioridad == 2)
                                                  <span class="label label-lg font-weight-bold label-light-success label-inline">BAJA</span>
                                                @endif
                                                @if($unid->prioridad == 1)
                                                  <span class="label label-lg font-weight-bold label-light-warning label-inline">MEDIA</span>
                                                @endif
                                                @if($unid->prioridad == 0)
                                                  <span class="label label-lg font-weight-bold label-light-danger label-inline">ALTA</span>
                                                @endif
                                              </td>
                                              <td>{{ $unid->tipo_solicitud }}</td>
                                              <td>{{ $unid->concepto }}</td>
                                              <td>1</td>
                                              <td class="text-center">
                                                <a href="{{ route('controlsol.versolmantenimiento', $unid->id) }}" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon activar-cliente" data-id="{{ $unid->id }}" data-nombre="{{ $unid->id }}" data-toggle="tooltip" data-theme="dark" title="Ver solicitud" ><i class="flaticon-eye"></i></a>
                                              </td>
                                            </tr>
                                          @endforeach
                                        </tbody>

                                        <tfoot>
                                        <tr>
                                          <th>ID</th>
                                          <th>Fecha de solicitud</th>
                                          <th>Unidad</th>
                                          <th>Prioridad</th>
                                          <th>Tipo</th>
                                          <th>Concepto</th>
                                          {{-- <th>Cliente</th> --}}
                                          <th>Estatus</th>
                                          <th>Opciones</th>
                                        </tr>
                                        </tfoot>

                                    </table>
                                    <input type="hidden" id="datatable_i18n" value="{{ asset('/js/datatables/i18n/es-mx.json') }}">
                                  </div>
                                  <!--end: Datatable-->
                                </div>

                              </div>
                          </div>
                    {{-- end mantenimiento --}}

                            
                          <div class="row" id="div_sustitutas">
                            <div class="col-lg-9"></div>
                            <div class="col-lg-3">
                                <select class="form-control op_solicitudes" name="op_solicitudes"  required >
                                      <option value="1">Mantenimiento</option>
                                      <option value="2" selected>Unidades sustitutas</option>
                                      <option value="3">Asignacion unidades</option>
                                      <option value="4">Traslados</option>
                                      <option value="5">GPS</option>
                                </select>

                            </div>
                          </div>

                          <div class="card card-custom mt-2">
                              <div class="card-header">
                                <div class="card-title">
                                  <span class="card-icon">
                                    <i class="flaticon2-file text-primary"></i>
                                  </span>
                                  <h3 class="card-label">Unidades sustitutas</h3>
                                </div>
                                <div class="card-toolbar">
                                  <button id="ver_unidsustitutas" class="btn btn-light-primary font-weight-bolder mr-3 ml-3">
                                    <i class="flaticon-eye"></i>Ver solicitudes
                                  </button> 

                                </div>
                              </div>
                              <div class="card-body">

                                <div class="row">
                                  <div class="col-lg-12 text-center">
                                    <span style="font-size: 20px;">Total de solicitudes </span> <span style="font-size: 20px; font-weight: bold; color: #669933;">{{ count($sustituto_solicitud) }}</span>
                                  </div>
                                </div>

                                <div class="row">
                                  <div class="col-lg-6">
                                    <input type="hidden" id="sus_motivo_falla" value="{{ count($sus_motivo_falla) }}">
                                    <input type="hidden" id="sus_motivo_siniestro" value="{{ count($sus_motivo_siniestro) }}">
                                    <input type="hidden" id="sus_motivo_perdida" value="{{ count($sus_motivo_perdida) }}">
                                    <canvas id="motivo_susutituta" style="width: 100px;"></canvas>
                                  </div>

                                  <div class="col-lg-6">
                                    <input type="hidden" id="sustituto_estatus_solicitado" value="{{ count($sustituto_estatus_solicitado) }}">
                                    <input type="hidden" id="sustituto_estatus_envlogistica" value="{{ count($sustituto_estatus_envlogistica) }}">
                                    <input type="hidden" id="sustituto_estatus_unidasignada" value="{{ count($sustituto_estatus_unidasignada) }}">
                                    <input type="hidden" id="sustituto_estatus_finalizado" value="{{ count($sustituto_estatus_finalizado) }}">
                                    <canvas id="susutituto_estatus" style="width: 100px;"></canvas>
                                  </div>

                                </div>


                                <div class="row oculto " id="sol_sustitutas">
                                  <!--begin: Datatable-->
                                  <div class="col-lg-12 mt-4">
                                    <table class="table table-hover table-checkable table-responsive" id="kdatatable_sustituta">
                                        <thead>
                                        <tr>
                                          <th>Nombre responsable</th>
                                          <th>Fecha y hora de solicitud</th>
                                          <th>Motivo</th>
                                          <th>Unidad base</th>
                                          <th>Contrato</th>
                                          <th>Estado</th>
                                          <th>Municipio</th>
                                          <th>Estatus</th> 
                                          <th class="text-center">Opciones</th>
                                        </tr>
                                        </thead>

                                        <tbody>
                                          @foreach($sustituto_solicitud as $unid)
                                            <tr>
                                              <td>{{ $unid->nombre_responsable }}</td>
                                              <td>{{ $unid->created_at }}</td>
                                              <td>
                                                @if($unid->motivo_id == 1)
                                                  <span class="label label-lg font-weight-bold label-light-success label-inline">Falla mecanica</span>
                                                @endif
                                                @if($unid->motivo_id == 2)
                                                  <span class="label label-lg font-weight-bold label-light-warning label-inline">Siniestro</span>
                                                @endif
                                                @if($unid->motivo_id == 3)
                                                  <span class="label label-lg font-weight-bold label-light-danger label-inline">Perdida total</span>
                                                @endif
                                              </td>
                                              <td>{{ $unid->unidad->no_serie }}</td>
                                              <td>{{ $unid->proyecto->no_contrato }}</td>
                                              <td>{{ $unid->estado_id}}</td>
                                              <td>{{ $unid->municipio_id}}</td>
                                              <td>
                                                @if($unid->estatus == 1)
                                                  <span class="label label-lg font-weight-bold label-light-primary label-inline">Solicitado</span>
                                                @endif
                                                @if($unid->estatus == 2)
                                                  <span class="label label-lg font-weight-bold label-light-warning label-inline">Enviada a logística</span>
                                                @endif
                                                @if($unid->estatus == 3)
                                                  <span class="label label-lg font-weight-bold label-light-danger label-inline">Unidad sustituta asignada</span>
                                                @endif
                                                @if($unid->estatus == 4)
                                                  <span class="label label-lg font-weight-bold label-light-success label-inline">Solicitud Finalizada</span>
                                                @endif
                                              </td>
                                              <td class="text-center">
                                                <a href="{{ route('controlsol.versolsustitutos', $unid->id) }}"  class="btn btn-sm btn-clean btn-hover-icon-success btn-icon activar-cliente" data-id="{{ $unid->id }}" data-nombre="{{ $unid->id }}" data-toggle="tooltip" data-theme="dark" title="Ver solicitud" ><i class="flaticon-eye"></i></a>
                                              </td>
                                            </tr>
                                          @endforeach
                                        </tbody>

                                        <tfoot>
                                        <tr>
                                          <th>Nombre responsable</th>
                                          <th>Fecha y hora de solicitud</th>
                                          <th>Motivo</th>
                                          <th>Unidad base</th>
                                          <th>Contrato</th>
                                          <th>Estado</th>
                                          <th>Municipio</th>
                                          <th>Estatus</th> 
                                          <th class="text-center">Opciones</th>
                                        </tr>
                                        </tfoot>

                                    </table>
                                    <input type="hidden" id="datatable_i18n" value="{{ asset('/js/datatables/i18n/es-mx.json') }}">
                                  </div>
                                  <!--end: Datatable-->
                                </div>

                              </div>
                          </div>
                    {{-- end Unidades sustitutas --}}


                          <div class="row mt-3" id="div_asignacionunidades">
                            <div class="col-lg-9"></div>
                            <div class="col-lg-3">
                                <select class="form-control op_solicitudes" name="op_solicitudes"  required >
                                      <option value="1">Mantenimiento</option>
                                      <option value="2">Unidades sustitutas</option>
                                      <option value="3" selected>Asignacion unidades</option>
                                      <option value="4">Traslados</option>
                                      <option value="5">GPS</option>
                                </select>

                            </div>
                          </div>

                          <div class="card card-custom mt-2">
                              <div class="card-header">
                                <div class="card-title">
                                  <span class="card-icon">
                                    <i class="flaticon2-file text-primary"></i>
                                  </span>
                                  <h3 class="card-label">Asignacion Unidades</h3>
                                </div>
                                <div class="card-toolbar">
                                  <button id="ver_asignacion" class="btn btn-light-primary font-weight-bolder mr-3 ml-3">
                                    <i class="flaticon-eye"></i>Ver solicitudes
                                  </button> 

                                </div>
                              </div>
                              <div class="card-body">

                                <div class="row">
                                  <div class="col-lg-12 text-center">
                                    <span style="font-size: 20px;">Total de solicitudes </span> <span style="font-size: 20px; font-weight: bold; color: #669933;">{{ count($asignacion_unidades) }}</span>
                                  </div>
                                </div>

                                <div class="row">
                                  <div class="col-lg-6">
                                    <input type="hidden" id="as_tipo_patio" value="{{ count($as_tipo_patio) }}">
                                    <input type="hidden" id="as_tipo_contrato" value="{{ count($as_tipo_contrato) }}">
                                    <canvas id="tipo_asignacion" style="width: 100px;"></canvas>
                                  </div>

                                  <div class="col-lg-6">
                                    <input type="hidden" id="sustituto_estatus_solicitado" value="{{ count($sustituto_estatus_solicitado) }}">
                                    <input type="hidden" id="sustituto_estatus_envlogistica" value="{{ count($sustituto_estatus_envlogistica) }}">
                                    <input type="hidden" id="sustituto_estatus_unidasignada" value="{{ count($sustituto_estatus_unidasignada) }}">
                                    <input type="hidden" id="sustituto_estatus_finalizado" value="{{ count($sustituto_estatus_finalizado) }}">
                                    <canvas id="susutituto_estatus" style="width: 100px;"></canvas>
                                  </div>

                                </div>


                                <div class="row oculto" id="sol_asignacion">
                                  <!--begin: Datatable-->
                                  <div class="col-lg-12">
                                    <table class="table table-hover table-checkable table-responsive" id="kdatatable_asignacion">
                                        <thead>
                                        <tr>
                                          <th>No.</th>
                                          <th>Tipo Asignación</th>
                                          <th>Asignación</th>
                                          <th>Nombre asignación</th>
                                          <th>Contacto</th>
                                          <th>Dirección</th>
                                          <th>Subdirección</th>
                                          <th>Coordinación</th>
                                          <th>Calle</th>
                                          <th>Estado</th>
                                          <th>Municipio</th>
                                          <th class="text-center">Opciones</th>
                                        </tr>
                                        </thead>

                                        <tbody>
                                          @foreach($asignacion_unidades as $unid)
                                            <tr>
                                              <td>{{ $unid->id }}</td>
                                              <td>
                                                @if( $unid->tipo_asignacion == 0)
                                                  <span class="label font-weight-bold label-outline-warning label-inline" > Contrato </span>
                                                @else
                                                  <span class="label font-weight-bold label-outline-primary label-inline" > Patio </span>
                                                @endif
                                              </td>
                                              <td>
                                                @if( $unid->tipo_asignacion == 0)
                                                  {{ $unid->proyecto->no_contrato }}
                                                  Titulo servicio: {{ $unid->proyecto->titulo_servicio }} - No. Contrato: {{ $unid->proyecto->no_contrato }} - No. convenio: {{ $unid->proyecto->no_convenio }}
                                                @else
                                                  {{ $unid->ubicacionUnidad->ubicacion }} - {{ $unid->ubicacionUnidad->codigo }} 
                                                @endif                                        
                                              </td>

                                              <td>{{ $unid->nombre_asignacion }}</td>
                                              <td>{{ $unid->contacto }}</td>
                                              <td>{{ $unid->direccion }}</td>
                                              <td>{{ $unid->sub_direccion }}</td>
                                              <td>{{ $unid->coordinacion }}</td>
                                              <td>{{ $unid->calle }}</td>
                                              <td>{{ $unid->estado->estado_nombre }}</td>
                                              <td>{{ $unid->municipio->municipio_nombre }}</td>

                                              <td class="text-center">
                                                <a href="{{ route('controlsol.versolasignacion', $unid->id) }}" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon btn-icon mr-2" title="Ver asignación" data-theme="dark" data-toggle="tooltip" data-placement="top">
                                                    <span class="svg-icon svg-icon-md">
                                                        <i class="flaticon-eye"></i>
                                                    </span>
                                                </a>
                                              </td>
                                            </tr>
                                          @endforeach
                                        </tbody>

                                        <tfoot>
                                        <tr>
                                          <th>No.</th>
                                          <th>Tipo Asignación</th>
                                          <th>Asignación</th>
                                          <th>Nombre asignación</th>
                                          <th>Contacto</th>
                                          <th>Dirección</th>
                                          <th>Subdirección</th>
                                          <th>Coordinación</th>
                                          <th>Calle</th>
                                          <th>Estado</th>
                                          <th>Municipio</th>
                                          <th class="text-center">Opciones</th>
                                        </tr>
                                        </tfoot>

                                    </table>
                                    <input type="hidden" id="datatable_i18n" value="{{ asset('/js/datatables/i18n/es-mx.json') }}">
                                  </div>
                                  <!--end: Datatable-->
                                </div>

                              </div>
                          </div>
                    {{-- end Unidades sustitutas --}}

                          <div class="row mt-3" id="div_traslados">
                            <div class="col-lg-9"></div>
                            <div class="col-lg-3">
                                <select class="form-control op_solicitudes" name="op_solicitudes"  required >
                                      <option value="1">Mantenimiento</option>
                                      <option value="2">Unidades sustitutas</option>
                                      <option value="3">Asignacion unidades</option>
                                      <option value="4" selected>Traslados</option>
                                      <option value="5">GPS</option>
                                </select>

                            </div>
                          </div>

                          <div class="card card-custom mt-2">
                              <div class="card-header">
                                <div class="card-title">
                                  <span class="card-icon">
                                    <i class="flaticon2-file text-primary"></i>
                                  </span>
                                  <h3 class="card-label">Traslados</h3>
                                </div>
                                <div class="card-toolbar">
                                  <button id="ver_traslados" class="btn btn-light-primary font-weight-bolder mr-3 ml-3">
                                    <i class="flaticon-eye"></i>Ver solicitudes
                                  </button> 

                                </div>
                              </div>
                              <div class="card-body">

                                <div class="row">
                                  <div class="col-lg-12 text-center">
                                    <span style="font-size: 20px;">Total de solicitudes </span> <span style="font-size: 20px; font-weight: bold; color: #669933;">{{ count($traslados) }}</span>
                                  </div>
                                </div>

                                <div class="row">

                                  <div class="col-lg-6">
                                    <input type="hidden" id="traslados_estatus_pendiente" value="{{ count($traslados_estatus_pendiente) }}">
                                    <input type="hidden" id="traslados_estatus_trasladista" value="{{ count($traslados_estatus_trasladista) }}">
                                    <input type="hidden" id="traslados_estatus_operador" value="{{ count($traslados_estatus_operador) }}">
                                    <canvas id="traslado_estatus" style="width: 100px;"></canvas>
                                  </div>

                                </div>


                                <div class="row oculto" id="sol_traslados">
                                  <!--begin: Datatable-->
                                  <div class="col-lg-12">
                                    <table class="table table-hover table-checkable table-responsive" id="kdatatable_traslados">
                                      <thead>
                                      <tr>
                                        <th>No.</th>
                                        <th>Nombre Traslados</th>
                                        <th>Observaciones</th>
                                        <th>Fecha de solicitud</th>
                                        <th>Realizada por</th>
                                        <th>Estatus</th>
                                        <th class="text-center">Opciones</th>
                                      </tr>
                                      </thead>

                                      <tbody>
                                        @foreach($traslados as $unid)
                                          <tr>
                                            <td>{{ $unid->id }}</td>
                                            <td>{{ $unid->nombre_translado }}</td>
                                            <td>{{ $unid->observaciones }}</td>
                                            <td>{{ $unid->created_at }}</td>
                                            <td>{{ $unid->userCreated->name }}</td>
                                            <td>
                                              @if($unid->estatus_id == 0)
                                                <span style="color:black; background-color:#caf7c9;width:130px;" class="label label-lg font-weight-bold label-light-danger label-inline">Pendiente</span>
                                              @endif

                                              @if($unid->estatus_id == 1)
                                                <span style="color:black; background-color:#ffb444;width:102px; height:38px;" class="label label-lg font-weight-bold label-light-warning label-inline">Enviado a Trasladista</span>
                                              @endif

                                              @if($unid->estatus_id == 2)
                                                <span style="color:black; background-color:#44ffe3;width:130px;" class="label label-lg font-weight-bold label-light-primary label-inline">Enviado al operador</span>
                                              @endif
                                            </td>

                                            <td class="text-center">
                                              <a href="{{ route('controlsol.versoltraslado', $unid->id) }}"class="btn btn-sm btn-clean btn-hover-icon-success btn-icon btn-icon mr-2" title="Ver solicitud" data-theme="dark" data-toggle="tooltip" data-placement="top">
                                                  <span class="svg-icon svg-icon-md">
                                                      <i class="flaticon-eye"></i>
                                                  </span>
                                              </a>
                                            </td>
                                          </tr>
                                        @endforeach

                                      </tbody>

                                      <tfoot>
                                      <tr>
                                        <th>No.</th>
                                        <th>Nombre Traslados</th>
                                        <th>Observaciones</th>
                                        <th>Fecha de solicitud</th>
                                        <th>Realizada por</th>
                                        <th>Estatus</th>
                                        <th class="text-center">Opciones</th>
                                      </tr>
                                      </tfoot>

                                    </table>
                                    <input type="hidden" id="datatable_i18n" value="{{ asset('/js/datatables/i18n/es-mx.json') }}">
                                  </div>
                                  <!--end: Datatable-->
                                </div>

                              </div>
                          </div>
                    {{-- end Unidades traslados --}}

                          <div class="row mt-3" id="div_gps">
                            <div class="col-lg-9"></div>
                            <div class="col-lg-3">
                                <select class="form-control op_solicitudes" name="op_solicitudes"  required >
                                      <option value="1">Mantenimiento</option>
                                      <option value="2">Unidades sustitutas</option>
                                      <option value="3">Asignacion unidades</option>
                                      <option value="4">Traslados</option>
                                      <option value="5" selected>GPS</option>
                                </select>

                            </div>
                          </div>

                          <div class="card card-custom mt-2">
                              <div class="card-header">
                                <div class="card-title">
                                  <span class="card-icon">
                                    <i class="flaticon2-file text-primary"></i>
                                  </span>
                                  <h3 class="card-label">GPS</h3>
                                </div>
                                <div class="card-toolbar">
                                  <button id="ver_gps" class="btn btn-light-primary font-weight-bolder mr-3 ml-3">
                                    <i class="flaticon-eye"></i>Ver solicitudes
                                  </button> 

                                </div>
                              </div>
                              <div class="card-body">

                                <div class="row">
                                  <div class="col-lg-12 text-center">
                                    <span style="font-size: 20px;">Total de solicitudes </span> <span style="font-size: 20px; font-weight: bold; color: #669933;">{{ count($gps) }}</span>
                                  </div>
                                </div>

                                <div class="row">

                                  <div class="col-lg-6">
                                    <input type="hidden" id="gps_estatus_solicitada" value="{{ count($gps_estatus_solicitada) }}">
                                    <input type="hidden" id="gps_estatus_env_proveedor" value="{{ count($gps_estatus_env_proveedor) }}">
                                    <input type="hidden" id="gps_estatus_finalizada" value="{{ count($gps_estatus_finalizada) }}">
                                    <input type="hidden" id="gps_estatus_pendiente" value="{{ count($gps_estatus_pendiente) }}">
                                    <input type="hidden" id="gps_estatus_validacion" value="{{ count($gps_estatus_validacion) }}">
                                    <input type="hidden" id="gps_estatus_rechazada" value="{{ count($gps_estatus_rechazada) }}">
                                    <canvas id="gps_estatus" style="width: 100px;"></canvas>
                                  </div>

                                </div>


                                <div class="row oculto" id="sol_gps">
                                  <!--begin: Datatable-->
                                  <div class="col-lg-12">
                                    <table class="table table-hover table-checkable table-responsive" id="kdatatable_gps">
                                      <thead>
                                      <tr>
                                        <th>#ID</th>
                                        <th>Tipo</th>
                                        <th>Contacto</th>
                                        <th>Fecha</th>
                                        <th>Estatus</th>
                                        <th class="text-center">Opciones</th>
                                      </tr>
                                      </thead>

                                      <tbody>
                                        @foreach($gps as $unid)
                                          <tr>
                                            <td>{{ $unid->id }}</td>
                                            <td>{{ $unid->solicitudTipo->tipo }}</td>
                                            <td>{{ $unid->nombre }}</td>
                                            <td>{{ $unid->fecha }}</td>
                                            <td>
                                              @if($unid->solicitud_estatus_id == 1)
                                                <span style="color:black; background-color:#caf7c9;width:130px;" class="label label-lg font-weight-bold label-light-danger label-inline">Solicitada</span>
                                              @endif

                                              @if($unid->solicitud_estatus_id == 2)
                                                <span style="color:black; background-color:#ffb444;width:102px; height:38px;" class="label label-lg font-weight-bold label-light-warning label-inline">Enviada al proveedor</span>
                                              @endif

                                              @if($unid->solicitud_estatus_id == 3)
                                                <span style="color:black; background-color:#44ffe3;width:130px;" class="label label-lg font-weight-bold label-light-primary label-inline">Finalizada</span>
                                              @endif

                                              @if($unid->solicitud_estatus_id == 4)
                                                <span style="color:black; background-color:#caf7c9;width:130px;" class="label label-lg font-weight-bold label-light-danger label-inline">Pendiente</span>
                                              @endif

                                              @if($unid->solicitud_estatus_id == 5)
                                                <span style="color:black; background-color:#ffb444;width:102px; height:38px;" class="label label-lg font-weight-bold label-light-warning label-inline">Enviada para su validación</span>
                                              @endif

                                              @if($unid->solicitud_estatus_id == 6)
                                                <span style="color:black; background-color:#44ffe3;width:130px;" class="label label-lg font-weight-bold label-light-primary label-inline">Rechazado</span>
                                              @endif
                                            </td>

                                            <td class="text-center">
                                              <a href="{{ route('controlsol.versolgps',$unid->id) }}" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon btn-icon mr-2" title="Ver solicitud" data-theme="dark" data-toggle="tooltip" data-placement="top">
                                                  <span class="svg-icon svg-icon-md">
                                                      <i class="flaticon-eye"></i>
                                                  </span>
                                              </a>
                                            </td>
                                          </tr>
                                        @endforeach

                                      </tbody>

                                      <tfoot>
                                      <tr>
                                        <th>#ID</th>
                                        <th>Tipo</th>
                                        <th>Contacto</th>
                                        <th>Fecha</th>
                                        <th>Estatus</th>
                                        <th class="text-center">Opciones</th>
                                      </tr>
                                      </tfoot>

                                    </table>
                                    <input type="hidden" id="datatable_i18n" value="{{ asset('/js/datatables/i18n/es-mx.json') }}">
                                  </div>
                                  <!--end: Datatable-->
                                </div>

                              </div>
                          </div>
                    {{-- end Unidades gps --}}

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