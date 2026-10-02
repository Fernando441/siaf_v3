@extends('layouts.app')
@push('scripts')
	<script src="{{ asset('js/unidades/translados/Translados.js') }}"></script>
@endpush
@section('title')
    Ficha técnica  unidad
@endsection
@section('content')

<style type="text/css">
    .title_tr{
        /*color: #669933!important;*/
        font-weight: bold;
    }

    .shadow_card{
box-shadow: 0px 6px 3px -1px rgba(102,153,51,1);
-webkit-box-shadow: 0px 6px 3px -1px rgba(102,153,51,1);
-moz-box-shadow: 0px 6px 3px -1px rgba(102,153,51,1);
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
                                <h3 class="card-label">Ficha técnica  unidad</h3>
                            </div>
                            <div class="card-toolbar">

                                <!--begin::Button-->
                                <a href="{{ route('fichatecnica.listadofichatecnica') }}" class="btn btn-light-primary font-weight-bolder mr-3 ml-3">
                                  Regresar</a>
                                <!--end::Button-->

                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-8">
                                    @if($ver != 0)
                                        <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                                          <div class="carousel-inner">

                                            @foreach($fotografias as $documento)
                                            <div class="carousel-item {{($ver == $documento->id) ? 'active' : ''}}">
                                              <img class="d-block w-100" src="{{ route('archivo.fotografiaUnidad', ['id'=>$documento->id]) }}" alt="Second slide">
                                            </div>
                                             @endforeach
                                          </div>
                                          <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                            <span class="sr-only">Previous</span>
                                          </a>
                                          <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                            <span class="sr-only">Next</span>
                                          </a>
                                        </div>
                                    @else
                                        <img src="/img/no_disponible.png" width="300px">
                                    @endif
                                </div>

                                <div class="col-lg-4 text-center">
                                    <div class="form-group row mt-2">
                                        <div class="col-lg-6 col-sm-6">
                                            <label>Marca</label>
                                            @foreach($marcas as $marca)
                                                @if($marca->id == $unidad_info->id_marca)
                                                    <p>{{ strtoupper($marca->nombre_marca)}}</p>
                                                @endif
                                            @endforeach
                                        </div>
                                        <div class="col-lg-6 col-sm-6">
                                            <label>Modelo</label>
                                            @foreach($modelos as $model)
                                                @if($model->id == $unidad_info->id_modelo)
                                                    <p>{{ strtoupper($model->nombre_modelo)}}</p>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-lg-6 col-sm-6">
                                            <label>Número de serie</label>
                                            <p>{{ $unidad_info->no_serie }}</p>
                                        </div>
                                        <div class="col-lg-6 col-sm-6">
                                            <label>No. Factura de compra</label>
                                            <p>{{ $unidad_info->factura_compra }}</p>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-lg-6 col-sm-6">
                                            <label>Placa</label>
                                            <p>{{ $unidad_info->placa }}</p>
                                        </div>
                                        <div class="col-lg-6 col-sm-6">
                                            <label>Color</label>
                                            <p>{{ $unidad_info->color }}</p>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-lg-6 col-sm-6">
                                            <label>Año de la unidad</label>
                                            <p>{{ $unidad_info->unidad_year }}</p>
                                        </div>
                                        <div class="col-lg-6 col-sm-6">
                                            <label>Número de tarjeta de circulación</label>
                                            <p>{{ $unidad_info->no_tarjeta_circulacion }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        <ul class="nav nav-tabs nav-tabs-line">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#kt_tab_pane_1">Tramites vehiculares</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#kt_tab_pane_2">Bitacora de movimientos</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#kt_tab_pane_4">Mantenimientos</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#kt_tab_pane_3">Documentos</a>
                            </li>
                        </ul>


                        <div class="tab-content mt-5" id="myTabContent">
                            <div class="tab-pane fade show active mt-10" id="kt_tab_pane_1" role="tabpanel" aria-labelledby="kt_tab_pane_1">

                                <div class="accordion accordion-toggle-arrow" id="accordionExample1">
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="card-title" data-toggle="collapse" data-target="#collapseOne1">
                                                Emplacamiento
                                            </div>
                                        </div>
                                        <div id="collapseOne1" class="collapse show" data-parent="#accordionExample1">
                                            <div class="card-body">
                                                            @if(count($emplcamiento) == 0)
                                                                <div class="row">
                                                                    <div class="col-lg-12 text-center">
                                                                        <h5 style="color:red;">No se encontro información del tramite</h5>
                                                                    </div>
                                                                </div>
                                                            @else
                                                              <table class="table table-hover table-checkable" id="kdatatable_tramite">
                                                                <thead>
                                                                  <tr>
                                                                    <th>Fecha de vencimiento</th>
                                                                    <th>Número de placas</th>
                                                                    <th>Entidad</th>
                                                                    <th>Engomado</th>
                                                                    <th>Verificación</th>
                                                                  </tr>
                                                                </thead>

                                                                <tbody>
                                                                  @foreach($emplcamiento as $unid)
                                                                    <tr>
                                                                      <td>{{ date('d/m/Y', strtotime($unid->fecha_vencimiento_tarjeta))}} </td>
                                                                      <td>{{ $unid->numero_placas }}</td> 
                                                                      <td>{{ $unid->estado->estado_nombre }}</td>
                                                                      <td>
                                                                        @if($unid->engomado == 1)
                                                                          <b style="color: yellow;">Amarillo</b>
                                                                        @endif
                                                                        @if($unid->engomado == 2)
                                                                          <b style="color: pink">Rosa</b>
                                                                        @endif
                                                                        @if($unid->engomado == 3)
                                                                          <b style="color: red">Rojo</b>
                                                                        @endif
                                                                        @if($unid->engomado == 4)
                                                                          <b style="color: green">Verde</b>
                                                                        @endif
                                                                        @if($unid->engomado == 5)
                                                                          <b style="color: blue">Azul</b>
                                                                        @endif
                                                                      </td>
                                                                      <td>
                                                                        @if($unid->verificacion_op == 1)
                                                                          <span class="label font-weight-bold label-outline-danger label-inline" >No Verifica</span>
                                                                        @else
                                                                          <span class="label font-weight-bold label-outline-success label-inline" >Si Verifica</span>
                                                                        @endif
                                                                      </td>
                                                                    </tr>
                                                                  @endforeach
                                                                </tbody>

                                                              </table>
                                                            @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="card-title collapsed" data-toggle="collapse" data-target="#collapseTwo1">
                                                Tenencia
                                            </div>
                                        </div>
                                        <div id="collapseTwo1" class="collapse" data-parent="#accordionExample1">
                                            <div class="card-body">
                                                            @if(count($tenencia) == 0)
                                                                <div class="row">
                                                                    <div class="col-lg-12 text-center">
                                                                        <h5 style="color:red;">No se encontro información del tramite</h5>
                                                                    </div>
                                                                </div>
                                                            @else
                                                              <table class="table table-hover table-checkable" id="kdatatable_tramite">
                                                                <thead>
                                                                  <tr>
                                                                    <th>Fecha de pago</th>
                                                                    <th>Observaciones</th>
                                                                  </tr>
                                                                </thead>

                                                                <tbody>
                                                                  @foreach($tenencia as $unid)
                                                                    <tr>
                                                                      <td>{{ $unid->fecha_tramite }}</td>
                                                                      <td>{{ $unid->observaciones }}</td>
                                                                    </tr>
                                                                  @endforeach
                                                                </tbody>


                                                              </table>
                                                            @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="card-title collapsed" data-toggle="collapse" data-target="#collapseThree1">
                                                Verificación
                                            </div>
                                        </div>
                                        <div id="collapseThree1" class="collapse" data-parent="#accordionExample1">
                                            <div class="card-body">
                                                            @if(count($verificacion) == 0)
                                                                <div class="row">
                                                                    <div class="col-lg-12 text-center">
                                                                        <h5 style="color:red;">No se encontro información del tramite</h5>
                                                                    </div>
                                                                </div>
                                                            @else
                                                              <table class="table table-hover table-checkable" id="kdatatable_tramite">
                                                                <thead>
                                                                  <tr>
                                                                    <th>Fecha de expedición de certificado</th>
                                                                    <th>Fecha de vencimiento de certificado</th>
                                                                    <th>Fecha de entrega de certificado</th>
                                                                    <th>Tipo de reporte</th>
                                                                    <th>Observaciones</th>
                                                                  </tr>
                                                                </thead>

                                                                <tbody>
                                                                  @foreach($verificacion as $unid)
                                                                    <tr>
                                                                      <td>{{ $unid->fecha_tramite }}</td>
                                                                      <td>{{ $unid->fecha_vencimiento }}</td>
                                                                      <td>{{ $unid->fecha_entrega}}</td>
                                                                      <td>{{ $unid->tipo_reporte }}</td>
                                                                      <td>{{ $unid->observaciones }}</td>
                                                                    </tr>
                                                                  @endforeach
                                                                </tbody>


                                                              </table>
                                                            @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>



                            </div>

                            <div class="tab-pane fade mt-10" id="kt_tab_pane_2" role="tabpanel" aria-labelledby="kt_tab_pane_2">

                                <div class="row">
                                  <div class="col-lg-12">
                                    <table class="table table-hover table-checkable" id="kdatatable_bitacora">
                                      <thead>
                                        <tr>
                                          <th>Fecha movimiento</th>
                                          <th>Asignación</th>
                                          <th>Tipo de asignación</th>
                                          <th>Inventario entrega</th>
                                          <th>Inventario salida</th>
                                          <th>Origen</th>
                                          <th>Destino</th>
                                        </tr>
                                      </thead>
                                      <tbody>
{{--                                         @foreach($unidad_movimiento as $unid)
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
                                        @endforeach --}}
                                      </tbody>
                                      <tfoot>
                                        <tr>
                                          <th>Fecha movimiento</th>
                                          <th>Asignación</th>
                                          <th>Tipo de asignación</th>
                                          <th>Inventario entrega</th>
                                          <th>Inventario salida</th>
                                          <th>Origen</th>
                                          <th>Destino</th>
                                        </tr>
                                      </tfoot>

                                    </table>
                                  </div>
                                </div>
                                <input type="hidden" id="datatable_mov" value="{{ asset('/js/datatables/i18n/es-mx.json') }}">
                            </div>


                            <div class="tab-pane fade mt-10" id="kt_tab_pane_4" role="tabpanel" aria-labelledby="kt_tab_pane_4">
                                <div class="row">
                                  <div class="col-lg-12">
                                    <table class="table table-hover table-checkable" id="kdatatable_mant">
                                      <thead>
                                        <tr>
                                            <th>Fecha de solicitud</th>
                                            <th>Unidad</th>
                                            <th>Tipo</th>
                                            <th>Concepto</th>
                                            <th>Estatus</th>
                                            <th>Monto total</th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                        @foreach($mantenimientos as $unid)
                                          <tr>
                                            <td>{{ $unid->fecha_solicitud }}</td>
                                            <td>{{ $unid->unidad->no_serie }}</td>
                                            <td>{{ $unid->tipo_solicitud }}</td>
                                            <td>{{ $unid->concepto }}</td>
                                            <td>{{ $unid->tallerSolicitudEstado->estado }}</td>
                                            <td>
                                                @if($unid->importe_total != null || $unid->importe_total != 0)
                                                    ${{ $unid->importe_total }}
                                                @else
                                                    Sin pago
                                                @endif
                                            </td>
                                          </tr>
                                        @endforeach
                                      </tbody>
                                      <tfoot>
                                        <tr>
                                            <th>Fecha de solicitud</th>
                                            <th>Unidad</th>
                                            <th>Tipo</th>
                                            <th>Concepto</th>
                                            <th>Estatus</th>
                                            <th>Monto total</th>
                                        </tr>
                                      </tfoot>

                                    </table>
                                    <input type="hidden" id="datatable_montenimiento" value="{{ asset('/js/datatables/i18n/es-mx.json') }}">
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

@endsection
