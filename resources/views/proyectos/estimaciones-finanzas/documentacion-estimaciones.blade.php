@extends('layouts.app')
@section('title')
    Adjuntar evidencia de pago de la Estimación
@endsection
@push('scripts')

  <script src="{{ asset('js/contratos/EstimacionesEvidenciaPago.js') }}"></script>
	<meta name="csrf-token" content="{{ csrf_token() }}" />
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
                                <h3 class="card-label">Adjuntar evidencia de pago de la Estimación</h3>
                            </div>
                            <div class="card-toolbar">

                                <!--begin::Button-->
{{--                                 <a href="{{ route('estimaciones.estimaciones', $licitacion) }}" class="btn btn-light-primary font-weight-bolder mr-3 ml-3">
                                    <i class="la la-arrow-left"></i>Regresar
                                </a> --}}
                                <!--end::Button-->

                            </div>
                        </div>
                        <div class="card-body">
                          <input type="hidden" id="documentoEliminarPath" value="{{ route('estimacionesfin.eliminardocumentoestimacion') }}">
                          <input type="hidden" id="notacreditoEliminarPath" value="{{ route('estimacionesfin.eliminardocumentonotacredito') }}">

                          <div class="card card-custom gutter-b">
                            <div class="card-header">
                              <div class="card-title">
                                <h3 class="card-label">
                                  Periodo <small>{{ $info_estimacion->periodo_inicial }} / {{ $info_estimacion->periodo_final}}</small>
                                </h3>
                              </div>
                            </div>
                            <div class="card-body">
                              <div class="row">
                                <div class="col-lg-12 text-right">
                                  <button id="finalizar_estimacion" class="btn btn-warning">
                                      <i class="flaticon2-pie-chart"></i> Finalizar estimación
                                  </button>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-lg-6">
                                  <div class="card card-custom gutter-b">
                                    <div class="card-header">
                                      <div class="card-title">
                                        <h3 class="card-label">
                                          <small>Información contrato</small>
                                        </h3>
                                      </div>
                                    </div>
                                    <div class="card-body">
                                      <div class="row form-group">
                                        <div class="col-lg-6">
                                            <label>Id. Contrato</label>
                                            <p>{{ $info_estimacion->proyecto->id_contrato }}</p>
                                        </div>
                                        <div class="col-lg-6">
                                            <label>No. Contrato</label>
                                            <p>{{ $info_estimacion->proyecto->no_contrato }}</p>
                                        </div>
                                      </div>

                                      <div class="row form-group">
                                        <div class="col-lg-6">
                                            <label>Titulo servicio</label>
                                            <p>{{ $info_estimacion->proyecto->titulo_servicio }}</p>
                                        </div>
                                        <div class="col-lg-6">
                                            <label>Inicio de vigencia</label>
                                            <p>{{ date('d/m/Y' , strtotime( $info_estimacion->proyecto->firma_inicio_vigencia)) }}</p>
                                        </div>
                                      </div>

                                      <div class="row form-group">
                                        <div class="col-lg-6">
                                            <label>Fin de vigencia</label>
                                            <p>{{  date('d/m/Y' , strtotime( $info_estimacion->proyecto->firma_final_vigencia)) }}</p>
                                        </div>
                                      </div>


                                    </div>
                                  </div>
                                </div>
                                <div class="col-lg-6">
                                  <div class="card card-custom gutter-b">
                                    <div class="card-header">
                                      <div class="card-title">
                                        <h3 class="card-label">
                                          <small>Información cliente</small>
                                        </h3>
                                      </div>
                                    </div>
                                    <div class="card-body">
                                      <div class="row form-group">
                                        <div class="col-lg-6">
                                            <label>Razon social</label>
                                            <p>{{ $info_estimacion->cliente->razon_social }}</p>
                                        </div>
                                        <div class="col-lg-6">
                                            <label>RFC</label>
                                            <p>{{ $info_estimacion->cliente->rfc }}</p>
                                        </div>
                                      </div>

                                      <div class="row form-group">
                                        <div class="col-lg-6">
                                            <label>Calle y número</label>
                                            <p>{{ $info_estimacion->cliente->calle_numero }}</p>
                                        </div>
                                        <div class="col-lg-6">
                                            <label>Colonia</label>
                                            <p>{{ $info_estimacion->cliente->colonia }}</p>
                                        </div>
                                      </div>

                                      <div class="row form-group">
                                        <div class="col-lg-6">
                                            <label>CP</label>
                                            <p>{{ $info_estimacion->cliente->codigo_postal }}</p>
                                        </div>
                                        <div class="col-lg-6">
                                            <label>Estado</label>
                                            <p>{{ $info_estimacion->cliente->estado->estado_nombre }}</p>
                                        </div>
                                      </div>

                                      <div class="row form-group">
                                        <div class="col-lg-6">
                                            <label>Municipio</label>
                                            <p>{{ $info_estimacion->cliente->municipio->municipio_nombre }}</p>
                                        </div>
                                        <div class="col-lg-6">
                                            <label>Cédula fiscal</label>
                                            <p>{{ $info_estimacion->cliente->cedula_fiscal }}</p>
                                        </div>
                                      </div>

                                    </div>
                                  </div>
                                </div>
                              </div>

                              <div class="row">
                                <div class="col-lg-12">
                                  <div class="card card-custom gutter-b">
                                    <div class="card-header">
                                      <div class="card-title">
                                        <h3 class="card-label">
                                          <small>Resumen de la estimación</small>
                                        </h3>
                                      </div>
                                    </div>
                                    <div class="card-body">
                                      @php
                                        $result = [];
                                        foreach ($unidaes_estimacion as $k => $row) {
                                            $result[$row['segmentos_id']][$k] = $row;
                                        }

                                      @endphp

                                      <table class="table table-hover mb-6 table-responsive-sm" id="tblresumen">
                                          <thead>
                                          <tr>
                                              <th scope="col">Cantidad</th>
                                              <th scope="col">Segmento</th>
                                              <th scope="col">Costo mensual</th>
                                              <th scope="col">Total</th>
                                          </tr>
                                          </thead>
                                          <tbody id='tbodyResumen'>
                                              @foreach($result as $k => $row)
                                              <tr id="trDo">
                                                  <td>{{ count($row) }}</td>
                                                    @php
                                                    $total_seg = 0; $precio_unitario_seg= 0;
                                                        foreach ($row as $key => $value) {
                                                          $total_seg = $value->dias_trabajo  * $value->precio_segmento;
                                                          $precio_unitario_seg = $precio_unitario_seg + $total_seg;
                                                          // var_dump($precio_unitario_seg);
                                                        }                                                          
                                                    @endphp 
                                                  <td>{{ $value->segmento->segmentoTipoVehiculo->tipo_vehiculo }} {{ $value->segmento->segmentoMotor->motor }}  {{ $value->segmento->segmentoTransmision->transmision }}</td>
                                                  <td>{{ $total_seg }}</td>
                                                  <td>   
                                                    {{ $precio_unitario_seg }}                                                
                                                  </td>
                                              </tr>                                              
                                              @endforeach



                                          </tbody>
                                      </table>

                                    </div>
                                  </div>
                                </div>
                              </div>

                            </div>
                          </div>

                        <ul class="nav nav-tabs nav-tabs-line">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#kt_tab_pane_3">Evidencia de pago</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#kt_tab_pane_4">Nota de credito</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link " data-toggle="tab" href="#kt_tab_pane_1">Información estimación</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#kt_tab_pane_2">Seguimiento con el cliente</a>
                            </li>

                        </ul>
                        <div class="tab-content mt-5" id="myTabContent">
                          <div class="tab-pane fade mt-10" id="kt_tab_pane_1" role="tabpanel" aria-labelledby="kt_tab_pane_1">
                              <!--begin: Datatable-->

                              <table class="table table-hover table-checkable" id="kdatatable">
                                  <thead>
                                  <tr>
                                    <th>No.</th>
                                    <th>Segmento</th>
                                    <th>Número economico</th>
                                    <th>Marca</th>
                                    <th>Modelo</th>
                                    <th>No.serie</th>
                                    <th>Placas</th>
                                    <th>Precio unitario</th>
                                    <th>Dias trabajados</th>
                                    <th class="text-center">Total mensual</th>
                                  </tr>
                                  </thead>

                                  <tbody>
                                    @php $precio_unitario = 0; $iva = 0; $total_monto=0; $subtotal_calculo=0; $iva_calculo=0; @endphp
                                    @foreach($unidaes_estimacion as $unid)
                                      @if($unid->dias_trabajo == 30)
                                      <tr>
                                      @else
                                        <tr style="background-color: #ffe189;">
                                      @endif
                                        <input type="hidden" name="id[]" value="{{ $unid->id }}">
                                        <td>{{ $unid->id }}</td>
                                        <td>{{ $unid->segmento->segmentoTipoVehiculo->tipo_vehiculo }} {{ $unid->segmento->segmentoMotor->motor }}  {{ $unid->segmento->segmentoTransmision->transmision }}</td>
                                        <td>{{ $unid->unidad->numero_economico }}</td>
                                        <td>{{ $unid->unidad->marcaUnidad->nombre_marca }}</td>
                                        <td>{{ $unid->unidad->modeloUnidad->nombre_modelo }}</td>
                                        <td>{{ $unid->unidad->no_serie }}</td>
                                        <td>{{ $unid->unidad->placa }}</td>
                                        <td>
                                            {{ $unid->precio_segmento }}
                                            <input type="hidden" name="precio_segmento[]" class="form-control monto input total_input" id="precio_segmento" value="{{ $unid->precio_segmento }}">
                                        </td>
                                        <td>
                                            {{ $unid->dias_trabajo }}
                                        </td>
                                        <td>
                                            @php
                                              $total = $unid->precio_segmento * $unid->dias_trabajo;
                                              $precio_unitario = $precio_unitario + $total;
                                              $iva = $precio_unitario * 0.16;
                                              $total_monto = $precio_unitario + $iva;
                                            @endphp

                                            {{ number_format($total,2,'.',',') }}
                                            <input type="hidden" class="form-control monto total_m total_input"  value="{{ $total }}">
                                        </td>
                                      </tr>
                                    @endforeach
                                  </tbody>
                                  <tbody>
                                      <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td> <h4>Subtotal: </h4></td>
                                        <td>
                                            {{ number_format($iva,2,'.',',') }}
                                        </td>
                                      </tr>

                                      <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td> <h4>Iva: </h4></td>
                                        <td>
                                            {{ number_format($iva,2,'.',',') }}
                                        </td>
                                      </tr>


                                      <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td> <h4>Total: </h4></td>
                                        <td>
                                            {{ number_format($total_monto,2,'.',',') }}
                                        </td>
                                      </tr>


                                  </tbody>

                              </table>
                              <!--end: Datatable-->
                              
                                <input type="hidden" id="datatable_i18n" value="{{ asset('/js/datatables/i18n/es-mx.json') }}">
                                <a href="{{ route('estimacionesfin.catalogoestimaciones') }}"  class="btn btn-secondary"><i class="la la-arrow-left"></i>Regresar</a>
                          </div>

                          <div class="tab-pane fade mt-10" id="kt_tab_pane_2" role="tabpanel" aria-labelledby="kt_tab_pane_2">
                            <input type='hidden' id='url_seguimiento' value='{{ route('estimaciones.addseguimientoestimacion') }}'>
                            <input type='hidden' id='url_seguimiento_delete' value='{{ route('estimaciones.deleteseguimientoestimacion') }}'>

                              <table class="table table-hover table-checkable" id="kdatatable_seguimiento">
                                  <thead>
                                  <tr>
                                    <th>Estatus de estimación</th>
                                    <th>Fecha de envío al cliente</th>
                                    <th>Observaciones</th>
                                  </tr>
                                  </thead>

                                  <tbody>
                                  @foreach($seguimiento as $unid)
                                    <tr>
                                      <td>
                                        @if($unid->estatus_estimacion == 1)
                                          <span class="label font-weight-bold label-outline-danger label-outline label-inline">Rechazada</span>
                                        @else
                                          <span class="label font-weight-bold label-outline-success label-outline label-inline">Aceptada</span>
                                        @endif
                                      </td>
                                      <td> {{ date('d/m/Y  h:i  A' , strtotime( $unid->fecha_envio)) }}</td>
                                      <td>{{ $unid->observaciones }}</td>

                                    </tr>
                                  @endforeach
                                  </tbody>

                                  <tfoot>
                                  <tr>
                                    <th>Estatus de estimación</th>
                                    <th>Fecha de envío al cliente</th>
                                    <th>Observaciones</th>
                                  </tr>
                                  </tfoot>

                              </table>
                              <input type="hidden" id="datatable_i18n" value="{{ asset('/js/datatables/i18n/es-mx.json') }}">

                              <a href="{{ route('estimacionesfin.catalogoestimaciones') }}"  class="btn btn-secondary"><i class="la la-arrow-left"></i>Regresar</a>
                          </div>

                          
                          <div class="tab-pane fade show active mt-10" id="kt_tab_pane_3" role="tabpanel" aria-labelledby="kt_tab_pane_3">
                            <form class="form" action="{{ route('estimacionesfin.addevidenciapagoesti') }}" method="post" id="frmCliente" enctype="multipart/form-data">
                                @csrf
                                <input type='hidden' id='tipoArchivo' value='{{ $cadenaTipoDocumento }}'>
                                <input type="hidden" name="id_estimacion" value="{{ $estimacion }}">
                                <input type="hidden" name="licitacion_id" value="{{ $licitacion }}">
                                <input type="hidden" name="estimacion_id" value="{{ $estimacion }}">

                            <table class="table table-hover mb-6 table-responsive-sm" id="tblDocumentos">
                                <thead>
                                <tr>
                                    <th scope="col">Documento</th>
                                    <th scope="col">Tipo de Documento</th>
                                    <th scope="col">Fecha de evidencia</th>
                                    <th scope="col">Opción</th>
                                </tr>
                                </thead>
                                <tbody id='tbodyDocumentos'>
                                    @foreach($documentos as $documento)
                                        <tr id="trDocumento{{ $documento->id }}">
                                            <td><a href="{{ route('archivo.estimacionespago', ['id'=>$documento->id]) }}" class="link-primary" target="_blank"> {{ $documento->proyectoEstimacionesTipoDocumento->tipo_documento }} </a></td>
                                            <td>{{ $documento->proyectoEstimacionesTipoDocumento->tipo_documento }}</td>
                                            <td>
                                                {{ date('d/m/Y  h:i  A' , strtotime($documento->fecha_pago)) }}
                                            </td>
                                            <td>
                                                <a href='#' class='btn btn-sm btn-clean btn-hover-icon-success btn-icon hrefEliminarDocumento' data-id='{{ $documento->id }}' data-documento='{{ $documento->documento }}'  data-toggle='tooltip' data-theme='dark' title='Eliminar'>
                                                    <i class='flaticon-delete'></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <div class="row form-group">
                                <div class="col-lg-12">
                                    <a href="#" class="btn btn-icon btn-outline-success btn-circle btn-sm mr-2 hrefAgregarOtro" data-toggle="tooltip" data-theme="dark" title="Agregar archivo">
                                        <i class="flaticon2-plus"></i>
                                    </a>
                                </div>
                            </div>
                            <button type="button"  id="btnGuardar" class="btn btn-success"><i class="la la-plus"></i>Guardar</button>
                            <a href="{{ route('estimacionesfin.catalogoestimaciones') }}"  class="btn btn-secondary"><i class="la la-arrow-left"></i>Regresar</a>
                            </form>
                          </div>

                          <div class="tab-pane fade mt-10" id="kt_tab_pane_4" role="tabpanel" aria-labelledby="kt_tab_pane_4">
                            <div class="row">
                              <div class="col-lg-12" id="div_add_nota">
                                <button class="btn btn-icon btn-outline-success btn-circle btn-sm mr-2" id="agregarnotacredito" data-toggle="tooltip" data-theme="dark" title="Agregar nota credito">
                                  <i class="flaticon2-plus"></i>
                                </button>
                              </div>

                              <div class="col-lg-12" id="div_delete_nota" style="display: none;">
                                <button class="btn btn-icon btn-outline-danger btn-circle btn-sm mr-2" id="deletenotacredito" data-toggle="tooltip" data-theme="dark" title="Cerrar">
                                  <i class="flaticon2-cancel"></i>
                                </button>
                              </div>

                              <div class="col-lg-12  mt-3" id="div_nota_credito" style="display: none;">
                                <form class="form" action="{{ route('estimacionesfin.addnotacreditoestimacion') }}" method="post" id="formnotacredito" enctype="multipart/form-data">
                                  @csrf
                                <input type="hidden" name="licitacion_id" value="{{ $licitacion }}">
                                <input type="hidden" name="estimacion_id" value="{{ $estimacion }}">

                                <div class="row form-group">
                                  <div class='custom-file'>
                                      <input type='file' class='custom-file-input' id='documento' name='archivo' required />
                                      <label class='custom-file-label' for='archivo'>Selecciona un archivo</label>
                                  </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col-lg-6">
                                      <label>Número de la nota de crédito</label>
                                      <div class="input-group">
                                        <input type="text" name="no_nota_credito" id="no_nota_credito"  class="form-control"/>
                                      </div>
                                    </div>
                                    <div class="col-lg-6">
                                      <label>Fecha de emisión</label>
                                      <div class="input-group">
                                        <input type="datetime-local" name="fecha_emision" id="fecha_emision"  class="form-control"/>
                                      </div>
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col-lg-6">
                                      <label>Referencia de la factura original</label>
                                      <div class="input-group">
                                        <input type="text" name="referencia_factura" id="referencia_factura"  class="form-control"/>
                                      </div>
                                    </div>
                                    <div class="col-lg-6">
                                      <label>Monto a acreditar</label>
                                      <div class="input-group">
                                        <input type="text" name="monto_creditar" id="monto_creditar"  class="form-control"/>
                                      </div>
                                    </div>
                                </div>


                                <div class="row form-group">
                                  <div class="col-lg-12">
                                    <label>Descripción detallada del motivo</label>
                                    <textarea class="form-control" name="observaciones" id="observaciones" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"></textarea>
                                  </div>
                                </div>

                                  <button type="button"  id="btnnotacredito" class="btn btn-success"><i class="la la-plus"></i>Guardar</button>

                                </form>
                              </div>
                            </div>

                              <div class="card card-custom gutter-b">
                                <div class="card-header">
                                  <div class="card-title">
                                    <h3 class="card-label">
                                      Notas de crédito
                                    </h3>
                                  </div>
                                </div>
                                <div class="card-body">
                                  <table class="table table-hover mb-6 table-responsive-sm" id="tblnotascredito">
                                      <thead>
                                      <tr>
                                          <th scope="col">Evidencia</th>
                                          <th scope="col">Número de la nota de crédito</th>
                                          <th scope="col">Fecha de emisión</th>
                                          <th scope="col">Referencia de la factura original</th>
                                          <th scope="col">Monto a acreditar</th>
                                          <th scope="col">Descripción detallada del motivo</th>
                                          <th scope="col">Opción</th>
                                      </tr>
                                      </thead>
                                      <tbody id='tbodyDocumentosnotas'>
                                          @foreach($notascredito as $documento)
                                              <tr id="trDocumentonota">
                                                  <td>
                                                    <a href="{{ route('archivo.estimacionnotacredito', ['id'=>$documento->id]) }}" class="link-primary" target="_blank"> {{ $documento->no_nota_credito }} </a>
                                                  </td>
                                                  <td>{{ $documento->no_nota_credito }}</td>
                                                  <td>{{ date('d/m/Y  h:i  A' , strtotime($documento->fecha_emision )) }}</td>
                                                  <td>{{ $documento->referencia_factura }}</td>
                                                  <td>${{ number_format($documento->monto_creditar,2,'.',',') }}</td>
                                                  <td>{{ $documento->observaciones }}</td>
                                                  <td>
                                                      <a href='#' class='btn btn-sm btn-clean btn-hover-icon-success btn-icon hrefEliminarNotaCredito' data-id='{{ $documento->id }}' data-documento='{{ $documento->documento }}'  data-toggle='tooltip' data-theme='dark' title='Eliminar'>
                                                          <i class='flaticon-delete'></i>
                                                      </a>
                                                  </td>
                                              </tr>
                                          @endforeach
                                      </tbody>
                                  </table>
                                </div>
                              </div>


                          </div>

                        </div>
                        
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




    <form method="post" id="finalizar_finanzas_form" action="{{ route('estimacionesfin.finalizarestimacion') }}"
        enctype="multipart/form-data">
        @csrf
          <input type="hidden" name="licitacion_id" value="{{ $licitacion }}">
          <input type="hidden" name="estimacion_id" value="{{ $estimacion }}">
    </form>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script>
    // generamos un evento click y keyup para cada elemento input con la clase .input
    var input=document.querySelectorAll(".input");
    input.forEach(function(e) {
        e.addEventListener("click",multiplica);
        e.addEventListener("keyup",multiplica);
    });
     
    const formatoMexico = (number) => {
        const exp = /(\d)(?=(\d{3})+(?!\d))/g;
        const rep = '$1,';
        let arr = number.toString().split('.');
        arr[0] = arr[0].replace(exp,rep);
        return arr[1] ? arr.join('.'): arr[0];
    }

    function multiplica() {


        var tr=this.closest("tr");
  
        var total=1;
        var total_calculo = 1;
        var inputs=tr.querySelectorAll(".input");
        inputs.forEach(function(e) {
            total*=e.value;
        });
        console.log("total" + total)
        tr.querySelector(".total").value=formatoMexico(total.toFixed(2));
        tr.querySelector(".total_m").value=total.toFixed(2);
        
        calcularTotal(this.closest("table"));
    }
     

    function calcularTotal(e) {
        var total=0;
        var total_calculo = 0;

        var totales=e.querySelectorAll(".total_m");
        totales.forEach(function(e) {
            total+=parseFloat(e.value);
        });
        var iva = total.toFixed(2) * 0.16;
        var subtotal = iva + total;
        
        e.getElementsByClassName("totales_c")[0].value=formatoMexico(total.toFixed(2));
        e.getElementsByClassName("iva")[0].value=formatoMexico(iva.toFixed(2));
        e.getElementsByClassName("subt")[0].value=formatoMexico(subtotal.toFixed(2));   


    }
</script>


@endsection