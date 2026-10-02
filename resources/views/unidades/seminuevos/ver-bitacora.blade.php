<div class="row">
  <div class="col-lg-12">
    <ul class="nav nav-tabs  nav-tabs-line">
      <li class="nav-item">
        <a class="nav-link active" data-toggle="tab" href="#mantenimientos">Mantenimientos</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#movimientos">Movimientos del vehículo</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#seguros">Seguros</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#gps">GPS</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#tramites">Trámites vehiculares</a>
      </li>

      <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#actual">Situación actual</a>
      </li>
    </ul>
    <div class="tab-content mt-5" id="myTabContent">
      <div class="tab-pane fade show active mt-10" id="mantenimientos" role="tabpanel" aria-labelledby="mantenimientos">
        <table class="table table-hover table-checkable" id="kdatatable_mantenimientos">
          <thead>
            <tr>
              <th>ID</th>
              <th>Fecha de solicitud</th>
              <th>Proveedor</th>
              <th>Tipo</th>
              <th>Concepto</th>
              <th>Estatus</th>
              <th>Opciones</th>
            </tr>
          </thead>
          <tbody>
            @foreach($solicitudes as $unid)
              <tr>
                <td>{{ $unid->id }}</td>
                <td>{{ $unid->fecha_solicitud }}</td>
                <td>No asignado</td>
                <td>{{ $unid->tallerTipoSolicitud->tipo }}</td>
                <td>{{ $unid->concepto }}</td>
                <td>
                  @if($unid->tallerSolicitudEstado->estado == "PENDIENTE" || $unid->tallerSolicitudEstado->estado == "Pendiente")
                    <span class="label label-lg font-weight-bold label-light-danger label-inline">{{ $unid->tallerSolicitudEstado->estado }}</span>
                  @endif
                  @if($unid->tallerSolicitudEstado->estado == "PREAUTORIZADO" || $unid->tallerSolicitudEstado->estado == "Preautorizado")
                    <span class="label label-lg font-weight-bold label-light-warning label-inline">{{ $unid->tallerSolicitudEstado->estado }}</span>
                  @endif
                  @if($unid->tallerSolicitudEstado->estado == "AUTORIZADO" || $unid->tallerSolicitudEstado->estado == "Autorizado")
                    <span class="label label-lg font-weight-bold label-light-success label-inline">{{ $unid->tallerSolicitudEstado->estado }}</span>
                  @endif
                  @if($unid->tallerSolicitudEstado->estado == "CON EVIDENCIA" || $unid->tallerSolicitudEstado->estado == "Con evidencia")
                    <span style="color:#1bc538;background-color:#caf7c9;width:120px;" class="label label-lg font-weight-bold label-light-success label-inline">{{ $unid->tallerSolicitudEstado->estado }}</span>
                  @endif
                  @if($unid->tallerSolicitudEstado->estado == "TESORERÍA" || $unid->tallerSolicitudEstado->estado == "Tesorería")
                    <span style="color:#f1bd00;background-color:#fcfdb9;" class="label label-lg font-weight-bold label-light-success label-inline">{{ $unid->tallerSolicitudEstado->estado }}</span>
                  @endif
                  @if($unid->tallerSolicitudEstado->estado == "FINALIZADO" || $unid->tallerSolicitudEstado->estado == "Finalizado")
                    <span class="label label-lg font-weight-bold label-dark label-inline">{{ $unid->tallerSolicitudEstado->estado }}</span>
                  @endif
                  @if($unid->tallerSolicitudEstado->estado == "INCOMPLETO" || $unid->tallerSolicitudEstado->estado == "Incompleto")
                    <span class="label label-lg font-weight-bold label-warning label-inline">{{ $unid->tallerSolicitudEstado->estado }}</span>
                  @endif
                  @if($unid->tallerSolicitudEstado->estado == "RECHAZADO" || $unid->tallerSolicitudEstado->estado == "Rechazado")
                    <span class="label label-lg font-weight-bold label-light-dark label-inline">{{ $unid->tallerSolicitudEstado->estado }}</span>
                  @endif

                </td>
                <td></td>
              </tr>
            @endforeach
          </tbody>
          <tfoot>
            <tr>
              <th>ID</th>
              <th>Fecha de solicitud</th>
              <th>Proveedor</th>
              <th>Tipo</th>
              <th>Concepto</th>
              <th>Estatus</th>
              <th>Opciones</th>
            </tr>
          </tfoot>
        </table>
      </div>
      <div class="tab-pane fade mt-10" id="movimientos" role="tabpanel" aria-labelledby="movimientos">
        <div class="row">
          <div class="col-lg-12">
            <table class="table table-hover table-checkable" id="kdatatable_bitacora">
              <thead>
                <tr>
                  <th>Fecha movimiento</th>
                  <th>Asignación</th>
                  <th>Tipo de asignación</th>
                  <th>Movimiento</th>
                </tr>
              </thead>
              <tbody>
                @foreach($unidad_movimiento as $unid)
                  <tr>
                    <td>{{ $unid->fecha_asignacion }}</td>
                    <td>
                        @if($unid->op_asignacion == 0)
                            <p><span class="label font-weight-bold label-outline-success label-inline">Asignado</span></p>
                        @else
                            <p><span class="label font-weight-bold label-outline-danger label-inline">Retirado</span></p>
                        @endif
                    </td>
                    <td>{{ $unid->tipo_asignacion }}</td>
                    <td>
                        @if($unid->op_asignacion == 0)
                            <p><b>PATIO</b>: "{{ $unid->ubicacion }}" --> <b>CONTRATO</b>: {{ $unid->no_folio }}</p>
                        @else
                            <p><b>CONTRATO</b>: {{ $unid->no_folio }} --> <b>PATIO</b>: "{{ $unid->ubicacion }}" </p>
                        @endif
                    </td>
                  </tr>
                @endforeach
              </tbody>
              <tfoot>
                <tr>
                  <th>Fecha movimiento</th>
                  <th>Asignación</th>
                  <th>Tipo de asignación</th>
                  <th>Movimiento</th>
                </tr>
              </tfoot>

            </table>
          </div>
        </div>
      </div>
      {{-- END  MOVIMIENTOS DEL VEHICULO --}}
      <div class="tab-pane fade mt-10" id="seguros" role="tabpanel" aria-labelledby="seguros">
        <div class="row">
          <div class="col-lg-12">
            <table class="table table-hover table-checkable" id="kdatatable_seguros">
              <thead>
                <tr>
                  <th>Nombre del titular.</th>
                  <th>Dirección del titular</th>
                  <th>Número de poliza</th>
                  <th>Fecha de inicio</th>
                  <th>Fecha de finalización</th>
                  <th>Tipo de cobertura</th>
                </tr>
              </thead>
              <tbody>
                @foreach($info_seguros as $unid)
                  <tr>
                    <td>{{ $unid->nombre_titular }}</td>
                    <td>{{ $unid->direccion_titular }}</td>
                    <td>{{ $unid->numero_poliza }}</td>
                    <td>{{ date('d/m/Y', strtotime($unid->fecha_cobertura))}}</td>
                    <td>{{ date('d/m/Y', strtotime($unid->fecha_final_cobertura))}}</td>
                    <td>{{ $unid->unidadTipoCobertura->tipo_cobertura }}</td>
                  </tr>
                @endforeach
              </tbody>
              <tfoot>
                <tr>
                  <th>Nombre del titular.</th>
                  <th>Dirección del titular</th>
                  <th>Número de poliza</th>
                  <th>Fecha de inicio</th>
                  <th>Fecha de finalización</th>
                  <th>Tipo de cobertura</th>
                </tr>
              </tfoot>

            </table>
          </div>
        </div>
      </div>
      {{-- END  SEGUROS --}}
      <div class="tab-pane fade mt-10" id="tramites" role="tabpanel" aria-labelledby="tramites">
        Trámites vehiculares
      </div>
      <div class="tab-pane fade mt-10" id="gps" role="tabpanel" aria-labelledby="gps">
        <div class="row">
          <div class="col-lg-12">
            <table class="table table-hover table-checkable" id="kdatatable_gps">
              <thead>
                <tr>
                  <th>Número de identificación.</th>
                  <th>Marca del GPS</th>
                  <th>Modelo del GPS</th>
                  <th>Fecha de instalación</th>
                  <th>Información del proveedor</th>
                </tr>
              </thead>
              <tbody>
                @foreach($info_gps as $unid)
                  <tr>
                    <td>{{ $unid->numero_gps }}</td>
                    <td>{{ $unid->marca_gps }}</td>
                    <td>{{ $unid->modelo_gps }}</td>
                    <td>{{ date('d/m/Y', strtotime($unid->fecha_instalacion))}}</td>
                    <td>{{ $unid->info_proveedor }}</td>
                  </tr>
                @endforeach
              </tbody>
              <tfoot>
                <tr>
                  <th>Número de identificación.</th>
                  <th>Marca del GPS</th>
                  <th>Modelo del GPS</th>
                  <th>Fecha de instalación</th>
                  <th>Información del proveedor</th>
                </tr>
              </tfoot>

            </table>
          </div>
        </div>
      </div>
      <div class="tab-pane fade mt-10" id="actual" role="tabpanel" aria-labelledby="actual">
        Situación actual
      </div>
    </div>
  </div>
</div>

  <!--end: Datatable-->
<input type="hidden" id="datatable_i18n" value="{{ asset('/js/datatables/i18n/es-mx.json') }}">
<input type="hidden" id="datatable_mov" value="{{ asset('/js/datatables/i18n/es-mx.json') }}">