@extends('layouts.app')
@push('scripts')
	<script src="{{ asset('js/unidades/translados/Translados.js') }}"></script>
    <script src="{{ asset('js/unidades/translados/TransladosUnidadDocumento.js') }}"></script>
@endpush
@section('title')
    Unidad en translado
@endsection
@section('content')

<style type="text/css">
    .title_tr{
        color: #669933!important;
    }

<style type="text/css">
html{

    font-family: sans-serif;

}

.lineatemp{

    position: relative;

    width: 600px;

    margin: 0 auto;

    border: 1px solid lightgray;

    border-radius: 10px;

}

.fila{

    display: flex;

    justify-content: start;

    border-bottom: 1px solid lightgray;

    position: relative;

}

.fila .disco{

    width: 36px;

    display: flex;

    flex-direction: column;

    position: relative;

    justify-content: center;

    align-items: center;

}

.fila .disco:after{

    content:'';

    position: absolute;

    top: 0;

    left: calc(505 - 2px);

    height: 100%;

    width: 3px;

    background: #80DEEA;

    z-index: -1;

}

.fila:first-child .disco:after{

    height: 50%;

    top: 50%;

}

.fila:last-child .disco:after{

    height: 50%;

 }

.fila .disco > div{

    width: 50%;

    aspect-ratio: 1/1;

    border-radius: 50%;

    background: lightblue;

    box-sizing: border-box;

}

/*.fila:hover .disco > div{

    border: 3px solid red;

    background: white;

}*/

.fila div:nth-of-type(2){

    width: 20%;

    padding: 4px;

    display: flex;

    align-items:center;

}

.fila div:nth-of-type(3){

    width: 60%;

    padding: 4px;

 }
</style>

</style>
    <input type="hidden" id="documentoEliminarPath" value="{{ route('movimientoslog.eliminardocumentotraslado') }}">
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
                                <h3 class="card-label">Unidad en solicitud de translado</h3>
                            </div>
                            <div class="card-toolbar">

                                <!--begin::Button-->
                                <a href="{{ route('transladistassol.versolicitudtransladista', $id_translado) }}" class="btn btn-light-primary font-weight-bolder mr-3 ml-3">
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


                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card card-custom">
                                        <div class="card-header">
                                            <div class="card-title">
                                                <h3 class="card-label">
                                                    Información de la solicitud
                                                </h3>
                                            </div>

                                        </div>
                                        <div class="card-body">

                                            @if($unidad_info->proyectos_id != null)
                                                <div class="row form-group">
                                                    <div class="col-lg-4 col-sm-6 form-group">
                                                        <label>Patios</label>
                                                         @foreach($ubicacion as $tras)
                                                            @if($translados_unidad->ubicacion_unidad_id == $tras->id)
                                                                <p>{{ $tras->ubicacion }}</p>
                                                            @endif
                                                        @endforeach

                                                    </div>
                                                </div>
                                            @else   
                                                <input type="hidden" class="form-control specialCharts" name="id_ubicacion" id="id_ubicacion" value="" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()" />
                                            @endif


                                            <div class="row form-group">
                                                <div class="col-lg-4 col-sm-6 form-group">
                                                    <label>Tipo de asignación</label>
                                                    <p>{{ $translados_unidad->tipo_asignacion }}</p>
                                                </div>

                                                <div class="col-lg-4 col-sm-6 form-group">
                                                    <label>Fecha de traslado</label>
                                                    <p>{{ $translados_unidad->fecha_translado }}</p>
                                                </div>
                                                <div class="col-lg-4 col-sm-6 form-group">
                                                    <label>Trasladista</label>
                                                     @foreach($trasladistas as $tras)
                                                        @if($translados_unidad->id_transportista == $tras->id)
                                                            <p>{{ $tras->name }}</p>
                                                        @endif
                                                    @endforeach
                                                </div>
                                                {{-- $trasladistas->id --}}
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-3 col-sm-6 form-group">
                                                    <label>Requerimiento</label>
                                                    <p>{{ $translados_unidad->requerimiento }}</p>
                                                </div>
                                                <div class="col-lg-3 col-sm-6 form-group">
                                                    <label>Transladadora</label>
                                                    <p>{{ $translados_unidad->transladadora }}</p>
                                                </div>
                                                <div class="col-lg-3 col-sm-6 form-group">
                                                    <label>Estatus</label>
                                                    <p>{{ $translados_unidad->estatus }}</p>
                                                </div>
                                                <div class="col-lg-3 col-sm-6 form-group">
                                                    <label>recoleccion</label>
                                                    <p>{{ $translados_unidad->recoleccion }}</p>
                                                </div>
                                            </div>


                                            <div class="row">
                                                <div class="col-lg-3 col-sm-6 form-group">
                                                    <label>Origen</label>
                                                    <p>{{ $translados_unidad->origen }}</p>
                                                </div>
                                                <div class="col-lg-3 col-sm-6 form-group">
                                                    <label>Cto. Origen</label>
                                                    <p>{{ $translados_unidad->cto_origen }}</p>
                                                </div>
                                                <div class="col-lg-3 col-sm-6 form-group">
                                                    <label>Destino</label>
                                                    <p>{{ $translados_unidad->destino }}</p>
                                                </div>
                                                <div class="col-lg-3 col-sm-6 form-group">
                                                    <label>Cto. Destino</label>
                                                    <p>{{ $translados_unidad->cto_destino }}</p>
                                                </div>
                                            </div>


                                            <div class="row">
                                                <div class="col-lg-12 col-sm-6 form-group">
                                                    <label>Obervaciones</label>
                                                    <p>{{ $translados_unidad->observaciones }}</p>
                                                </div>

                                            </div>

                                        </div>

                                    </div>
                                </div>
                            </div>


                            <div class="row">

                                <div class="col-lg-12">
                                    <div class="card card-custom">
                                        <div class="card-header">
                                            <div class="card-title">
                                                <span class="card-icon">
                                                </span>
                                                <h3 class="card-label">
                                                    Bitacora
                                                </h3>
                                            </div>
                                            <div class="card-toolbar">

                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="lineatemp">
                                                <div class="fila">
                                                    <div class="disco"><div></div></div>
                                                    <div>{{ $solicitud->created_at }}</div>
                                                    <div>Solicidud creada por <b>{{ $solicitud->userCreated->name}}</b></div>
                                                </div>

                                                <div class="fila">
                                                     <div class="disco"><div></div></div>
                                                     <div>{{ $solicitud->envio_transladista }}</div>
                                                     <div>Solicitud enviada a trasladista</div>
                                                 </div>

                                                <div class="fila">

                                                    <div class="disco"><div></div></div>
                                                    <div>2021-2023</div>
                                                    <div>Inventario de entrega</div>

                                                </div>
                                            </div> 
                                        </div>

                                    </div>
                                </div>

                            </div>


                        <ul class="nav nav-tabs nav-tabs-line">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#kt_tab_pane_1">Tramites vehiculares</a>
                            </li>
{{--                             <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#kt_tab_pane_2">Bitacora de movimientos</a>
                            </li> --}}
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#kt_tab_pane_3">Documentos</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#kt_tab_pane_4">Inventario de entrega</a>
                            </li>
                        </ul>

                        <div class="tab-content mt-5" id="myTabContent">
                            <div class="tab-pane fade show active mt-10" id="kt_tab_pane_1" role="tabpanel" aria-labelledby="kt_tab_pane_1">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="card card-custom">
                                                        <div class="card-header shadow_card">
                                                            <div class="card-title">
                                                                <h4 class="card-label">
                                                                    Emplacamiento
                                                                </h4>
                                                            </div>

                                                        </div>
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
                                            </div>

                                            {{-- END EMPLACAMIENTO --}}

                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="card card-custom">
                                                        <div class="card-header shadow_card">
                                                            <div class="card-title">
                                                                <h4 class="card-label">
                                                                    Tenencia
                                                                </h4>
                                                            </div>

                                                        </div>
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
                                            </div>

                                            {{-- END TENENCIA --}}


                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="card card-custom">
                                                        <div class="card-header shadow_card">
                                                            <div class="card-title">
                                                                <h4 class="card-label">
                                                                    Verificación
                                                                </h4>
                                                            </div>

                                                        </div>
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

                                            {{-- END VERIFICACION --}}
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

                            <div class="tab-pane fade mt-10" id="kt_tab_pane_3" role="tabpanel" aria-labelledby="kt_tab_pane_3">
                                <form class="form" action="{{ route('movimientoslog.guardardocumentounidad') }}" method="post" id="frmDocumentoUnidad" enctype="multipart/form-data">
                                @csrf
                                    <input type="hidden" name="id_traslado" value="{{ $id_translado }}">
                                    <input type="hidden" name="id_unidad" value="{{ $id_unidad }}">
                                    <div class="row form-group" >
                                        <div class="col-lg-12" id="tblArchivos">
                                            <table class='table table-bordered table-hover' id='tblDocumentos'>
                                                <thead>
                                                <tr>
                                                    <th>Adjuntar Documento</th>
                                                    <th>Tipo de Documento</th>
                                                    <th>Opción</th>
                                                </tr>
                                                </thead>
                                                <tbody id='tbodyDocumentos'>
                                                    @foreach($documentos as $documento)
                                                        <tr id="trDocumento{{ $documento->id }}">
                                                            <td>
                                                                <a href="{{ route('archivo.documentotraslado', ['id'=>$documento->id]) }}" class="link-primary" target="_blank"> {{ $documento->nombre }} </a>
                                                            </td>
                                                            <td>{{ $documento->nombre }}</td>
                                                            <td>
                                                                <a href='#' class='btn btn-sm btn-clean btn-hover-icon-success btn-icon hrefEliminarDocumento' data-id='{{ $documento->id }}' data-documento='{{ $documento->documento }}'  data-toggle='tooltip' data-theme='dark' title='Eliminar'>
                                                                    <i class='flaticon-delete'></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="row form-group">
                                        <div class="col-lg-12">
                                            <a href="#" class="btn btn-icon btn-outline-success btn-circle btn-sm mr-2 hrefAgregarOtro" data-toggle="tooltip" data-theme="dark" title="Agregar archivo">
                                                <i class="flaticon2-plus"></i>
                                            </a>
                                        </div>
                                    </div>

                                    <div class="row form-group">
                                        <div class="col-lg-12 text-left">
                                            <button type="button"  id="btnGuardarDocUnid" class="btn btn-success"><i class="la la-plus"></i>Guardar</button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div class="tab-pane fade mt-10" id="kt_tab_pane_4" role="tabpanel" aria-labelledby="kt_tab_pane_4">
                                <form class="form" action="{{ route('movimientoslog.editinventrega') }}" method="post" id="frmInventarioEntrega" enctype="multipart/form-data">
                                @csrf 

                                <input type="hidden" name="id_traslado" value="{{ $id_translado }}">     
                                <input type="hidden" name="id_unidad" value="{{ $id_unidad }}">                         
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="card card-custom gutter-b">
                                            <div class="card-header">
                                                <div class="card-title">
                                                    <h3 class="card-label">
                                                        Inventario de entrega
                                                    </h3>
                                                </div>
                                            </div>
                                            <div class="card-body">

                                                <div class="row text-center">
                                                    <div class="col-lg-4 col-sm-6">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label>Poliza de seguro</label>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group">    
                                                                    
                                                                  <span class="switch switch-icon">
                                                                  <label>
                                                                  <input type="checkbox" name="poliza_seguro"  {{($inventario_entrega->poliza_seguros == 1) ? 'checked' : ''}} class='user_check all_generales' value="1" />
                                                                  <span></span>
                                                                  </label>
                                                                  </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-4 col-sm-6">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label>Manual</label>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group">    
                                                                    
                                                                  <span class="switch switch-icon">
                                                                  <label>
                                                                  <input type="checkbox" name="manual" {{($inventario_entrega->manual == 1) ? 'checked' : ''}} class='user_check all_generales' value="1" />
                                                                  <span></span>
                                                                  </label>
                                                                  </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                 <div class="col-lg-4 col-sm-6">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label>Lugar</label>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group">    
                                                                    
                                                                  <span class="switch switch-icon">
                                                                  <label>
                                                                  <input type="checkbox" name="lugar" {{($inventario_entrega->lugar == 1) ? 'checked' : ''}} class='user_check all_generales' value="1" />
                                                                  <span></span>
                                                                  </label>
                                                                  </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="row text-center">
                                                    <div class="col-lg-4 col-sm-6">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label>No. Tarjeta de circulación</label>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group">    
                                                                    
                                                                  <span class="switch switch-icon">
                                                                  <label>
                                                                  <input type="checkbox" name="tarjeta_circulacion" {{($inventario_entrega->no_tarjeta_circulacion == 1) ? 'checked' : ''}} class='user_check all_generales' value="1" />
                                                                  <span></span>
                                                                  </label>
                                                                  </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-4 col-sm-6">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label>Verificación ambiental</label>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group">    
                                                                    
                                                                  <span class="switch switch-icon">
                                                                  <label>
                                                                  <input type="checkbox" name="verificacion_ambiental" {{($inventario_entrega->verificacion_ambiental == 1) ? 'checked' : ''}} class='user_check all_generales' value="1" />
                                                                  <span></span>
                                                                  </label>
                                                                  </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                 <div class="col-lg-4 col-sm-6">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label>Kilometraje</label>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group">    
                                                                    
                                                                  <span class="switch switch-icon">
                                                                  <label>
                                                                  <input type="checkbox" name="kilometraje" {{($inventario_entrega->kilometraje == 1) ? 'checked' : ''}} class='user_check all_generales' value="1" />
                                                                  <span></span>
                                                                  </label>
                                                                  </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="row text-center">
                                                    <div class="col-lg-4 col-sm-6">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label>Tenencia</label>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group">    
                                                                    
                                                                  <span class="switch switch-icon">
                                                                  <label>
                                                                  <input type="checkbox" name="tenencia" {{($inventario_entrega->tenencia == 1) ? 'checked' : ''}} class='user_check all_generales' value="1" />
                                                                  <span></span>
                                                                  </label>
                                                                  </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-4 col-sm-6">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label>Poliza de garantia de auto</label>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group">    
                                                                    
                                                                  <span class="switch switch-icon">
                                                                  <label>
                                                                  <input type="checkbox" name="poliza_garantia" {{($inventario_entrega->poliza_de_garantia == 1) ? 'checked' : ''}} class='user_check all_generales' value="1" />
                                                                  <span></span>
                                                                  </label>
                                                                  </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                {{-- E Q U I P O  y  H E R R A M I E N T A  D E L   V E H I C U L O --}}
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="card card-custom gutter-b">
                                            <div class="card-header">
                                                <div class="card-title">
                                                    <h3 class="card-label">
                                                        Equipo y herramienta del vehiculo
                                                    </h3>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div class="row text-center">
                                                    <div class="col-lg-4 col-sm-6">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label>Aire acondicionado</label>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group">    
                                                                    
                                                                  <span class="switch switch-icon">
                                                                  <label>
                                                                  <input type="checkbox" name="aire_acondicionado" {{($inventario_entrega->aire_acondicionado == 1) ? 'checked' : ''}} class='user_check all_generales' value="1" />
                                                                  <span></span>
                                                                  </label>
                                                                  </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-4 col-sm-6">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label>Llanta de refacción</label>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group">    
                                                                    
                                                                  <span class="switch switch-icon">
                                                                  <label>
                                                                  <input type="checkbox" name="llanta_refaccion" {{($inventario_entrega->llanta_refaccion == 1) ? 'checked' : ''}} class='user_check all_generales' value="1" />
                                                                  <span></span>
                                                                  </label>
                                                                  </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                 <div class="col-lg-4 col-sm-6">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label>Tapon de aceite</label>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group">    
                                                                    
                                                                  <span class="switch switch-icon">
                                                                  <label>
                                                                  <input type="checkbox" name="tapon_aceite" {{($inventario_entrega->tapon_aceite == 1) ? 'checked' : ''}} class='user_check all_generales' value="1" />
                                                                  <span></span>
                                                                  </label>
                                                                  </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="row text-center">
                                                    <div class="col-lg-4 col-sm-6">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label>Calefacción</label>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group">    
                                                                    
                                                                  <span class="switch switch-icon">
                                                                  <label>
                                                                  <input type="checkbox" name="calefaccion" {{($inventario_entrega->calefaccion == 1) ? 'checked' : ''}} class='user_check all_generales' value="1" />
                                                                  <span></span>
                                                                  </label>
                                                                  </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-4 col-sm-6">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label>Gato</label>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group">    
                                                                    
                                                                  <span class="switch switch-icon">
                                                                  <label>
                                                                  <input type="checkbox" name="gato" {{($inventario_entrega->gato == 1) ? 'checked' : ''}} class='user_check all_generales' value="1" />
                                                                  <span></span>
                                                                  </label>
                                                                  </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                 <div class="col-lg-4 col-sm-6">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label>Tapon de agua</label>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group">    
                                                                    
                                                                  <span class="switch switch-icon">
                                                                  <label>
                                                                  <input type="checkbox" name="tapon_agua" {{($inventario_entrega->tapon_agua == 1) ? 'checked' : ''}} class='user_check all_generales' value="1" />
                                                                  <span></span>
                                                                  </label>
                                                                  </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="row text-center">
                                                    <div class="col-lg-4 col-sm-6">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label>Radio AM/FM</label>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group">    
                                                                    
                                                                  <span class="switch switch-icon">
                                                                  <label>
                                                                  <input type="checkbox" name="radio" {{($inventario_entrega->radio == 1) ? 'checked' : ''}} class='user_check all_generales' value="1" />
                                                                  <span></span>
                                                                  </label>
                                                                  </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-4 col-sm-6">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label>Llave auxiliar</label>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group">    
                                                                    
                                                                  <span class="switch switch-icon">
                                                                  <label>
                                                                  <input type="checkbox" name="llave_auxiliar" {{($inventario_entrega->llave_auxiliar == 1) ? 'checked' : ''}} class='user_check all_generales' value="1" />
                                                                  <span></span>
                                                                  </label>
                                                                  </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 col-sm-6">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label>Tapon de gasolina</label>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group">    
                                                                    
                                                                  <span class="switch switch-icon">
                                                                  <label>
                                                                  <input type="checkbox" name="tapon_gasolina" {{($inventario_entrega->tapon_gasolina == 1) ? 'checked' : ''}} class='user_check all_generales' value="1" />
                                                                  <span></span>
                                                                  </label>
                                                                  </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="row text-center">
                                                    <div class="col-lg-4 col-sm-6">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label>Antena</label>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group">    
                                                                    
                                                                  <span class="switch switch-icon">
                                                                  <label>
                                                                  <input type="checkbox" name="antena" {{($inventario_entrega->antena == 1) ? 'checked' : ''}} class='user_check all_generales' value="1" />
                                                                  <span></span>
                                                                  </label>
                                                                  </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-4 col-sm-6">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label>Herramienta</label>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group">    
                                                                    
                                                                  <span class="switch switch-icon">
                                                                  <label>
                                                                  <input type="checkbox" name="herramienta" {{($inventario_entrega->herramienta == 1) ? 'checked' : ''}} class='user_check all_generales' value="1" />
                                                                  <span></span>
                                                                  </label>
                                                                  </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 col-sm-6">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label>Defensa lateral</label>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group">    
                                                                    
                                                                  <span class="switch switch-icon">
                                                                  <label>
                                                                  <input type="checkbox" name="defensa_lateral" {{($inventario_entrega->defensa_lateral == 1) ? 'checked' : ''}} class='user_check all_generales' value="1" />
                                                                  <span></span>
                                                                  </label>
                                                                  </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="row text-center">
                                                    <div class="col-lg-4 col-sm-6">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label>Encendedor</label>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group">    
                                                                    
                                                                  <span class="switch switch-icon">
                                                                  <label>
                                                                  <input type="checkbox" name="encendedor" {{($inventario_entrega->encendedor == 1) ? 'checked' : ''}} class='user_check all_generales' value="1" />
                                                                  <span></span>
                                                                  </label>
                                                                  </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-4 col-sm-6">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label>Extinguidor</label>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group">    
                                                                    
                                                                  <span class="switch switch-icon">
                                                                  <label>
                                                                  <input type="checkbox" name="extinguidor" {{($inventario_entrega->extinguidor == 1) ? 'checked' : ''}} class='user_check all_generales' value="1" />
                                                                  <span></span>
                                                                  </label>
                                                                  </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 col-sm-6">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label>Defensa trasera</label>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group">    
                                                                    
                                                                  <span class="switch switch-icon">
                                                                  <label>
                                                                  <input type="checkbox" name="defensa_trasera" {{($inventario_entrega->defensa_trasera == 1) ? 'checked' : ''}} class='user_check all_generales' value="1" />
                                                                  <span></span>
                                                                  </label>
                                                                  </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>



                                                <div class="row text-center">
                                                    <div class="col-lg-4 col-sm-6">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label>Ceniceros</label>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group">    
                                                                    
                                                                  <span class="switch switch-icon">
                                                                  <label>
                                                                  <input type="checkbox" name="ceniceros" {{($inventario_entrega->ceniceros == 1) ? 'checked' : ''}} class='user_check all_generales' value="1" />
                                                                  <span></span>
                                                                  </label>
                                                                  </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-4 col-sm-6">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label>Calaveras</label>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group">    
                                                                    
                                                                  <span class="switch switch-icon">
                                                                  <label>
                                                                  <input type="checkbox" name="calaveras" {{($inventario_entrega->calaveras == 1) ? 'checked' : ''}} class='user_check all_generales' value="1" />
                                                                  <span></span>
                                                                  </label>
                                                                  </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 col-sm-6">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label>Tapetes</label>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group">    
                                                                    
                                                                  <span class="switch switch-icon">
                                                                  <label>
                                                                  <input type="checkbox" name="tapetes" {{($inventario_entrega->tapetes == 1) ? 'checked' : ''}} class='user_check all_generales' value="1" />
                                                                  <span></span>
                                                                  </label>
                                                                  </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row text-center">
                                                    <div class="col-lg-4 col-sm-6">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label>Manijas</label>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group">    
                                                                    
                                                                  <span class="switch switch-icon">
                                                                  <label>
                                                                  <input type="checkbox" name="manijas" {{($inventario_entrega->manijas == 1) ? 'checked' : ''}} class='user_check all_generales' value="1" />
                                                                  <span></span>
                                                                  </label>
                                                                  </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-4 col-sm-6">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label>Parabrisas</label>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group">    
                                                                    
                                                                  <span class="switch switch-icon">
                                                                  <label>
                                                                  <input type="checkbox" name="parabrisas" {{($inventario_entrega->parabrisas == 1) ? 'checked' : ''}} class='user_check all_generales' value="1" />
                                                                  <span></span>
                                                                  </label>
                                                                  </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 col-sm-6">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label>Viceras</label>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group">    
                                                                    
                                                                  <span class="switch switch-icon">
                                                                  <label>
                                                                  <input type="checkbox" name="viceras" {{($inventario_entrega->viceras == 1) ? 'checked' : ''}} class='user_check all_generales' value="1" />
                                                                  <span></span>
                                                                  </label>
                                                                  </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="row text-center">
                                                    <div class="col-lg-4 col-sm-6">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label>Elevadores</label>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group">    
                                                                    
                                                                  <span class="switch switch-icon">
                                                                  <label>
                                                                  <input type="checkbox" name="elevadores" {{($inventario_entrega->elevadores == 1) ? 'checked' : ''}} class='user_check all_generales' value="1" />
                                                                  <span></span>
                                                                  </label>
                                                                  </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-4 col-sm-6">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label>Medallon</label>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group">    
                                                                    
                                                                  <span class="switch switch-icon">
                                                                  <label>
                                                                  <input type="checkbox" name="medallon" {{($inventario_entrega->medallon == 1) ? 'checked' : ''}} class='user_check all_generales' value="1" />
                                                                  <span></span>
                                                                  </label>
                                                                  </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 col-sm-6">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label>Biseles</label>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group">    
                                                                    
                                                                  <span class="switch switch-icon">
                                                                  <label>
                                                                  <input type="checkbox" name="biseles" {{($inventario_entrega->biseles == 1) ? 'checked' : ''}} class='user_check all_generales' value="1" />
                                                                  <span></span>
                                                                  </label>
                                                                  </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row text-center">
                                                    <div class="col-lg-4 col-sm-6">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label>Espejo retrovisor</label>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group">    
                                                                    
                                                                  <span class="switch switch-icon">
                                                                  <label>
                                                                  <input type="checkbox" name="espejo_retrovisor" {{($inventario_entrega->espejo_retrovisor == 1) ? 'checked' : ''}} class='user_check all_generales' value="1" />
                                                                  <span></span>
                                                                  </label>
                                                                  </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-4 col-sm-6">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label>Brazos limpiadores</label>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group">    
                                                                    
                                                                  <span class="switch switch-icon">
                                                                  <label>
                                                                  <input type="checkbox" name="brazos_limpiadores" {{($inventario_entrega->brazos_limpiadores == 1) ? 'checked' : ''}} class='user_check all_generales' value="1" />
                                                                  <span></span>
                                                                  </label>
                                                                  </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 col-sm-6">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label>Cuartos</label>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group">    
                                                                    
                                                                  <span class="switch switch-icon">
                                                                  <label>
                                                                  <input type="checkbox" name="cuartos" {{($inventario_entrega->cuartos == 1) ? 'checked' : ''}} class='user_check all_generales' value="1" />
                                                                  <span></span>
                                                                  </label>
                                                                  </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row text-center">
                                                    <div class="col-lg-4 col-sm-6">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label>Claxon</label>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group">    
                                                                    
                                                                  <span class="switch switch-icon">
                                                                  <label>
                                                                  <input type="checkbox" name="claxon" {{($inventario_entrega->claxon == 1) ? 'checked' : ''}} class='user_check all_generales' value="1" />
                                                                  <span></span>
                                                                  </label>
                                                                  </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-4 col-sm-6">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label>Espejos laterales</label>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group">    
                                                                    
                                                                  <span class="switch switch-icon">
                                                                  <label>
                                                                  <input type="checkbox" name="espejos_laterales" {{($inventario_entrega->espejos_laterales == 1) ? 'checked' : ''}} class='user_check all_generales' value="1" />
                                                                  <span></span>
                                                                  </label>
                                                                  </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 col-sm-6">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label>Stop</label>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group">    
                                                                    
                                                                  <span class="switch switch-icon">
                                                                  <label>
                                                                  <input type="checkbox" name="stop" {{($inventario_entrega->stop == 1) ? 'checked' : ''}} class='user_check all_generales' value="1" />
                                                                  <span></span>
                                                                  </label>
                                                                  </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="row text-center">
                                                    <div class="col-lg-4 col-sm-6">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label>Tapones de llantas</label>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group">    
                                                                    
                                                                  <span class="switch switch-icon">
                                                                  <label>
                                                                  <input type="checkbox" name="tapones_llantas" {{($inventario_entrega->tapones_llantas == 1) ? 'checked' : ''}} class='user_check all_generales' value="1" />
                                                                  <span></span>
                                                                  </label>
                                                                  </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-4 col-sm-6">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label>Señales de carretera</label>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group">    
                                                                    
                                                                  <span class="switch switch-icon">
                                                                  <label>
                                                                  <input type="checkbox" name="senales_carretera" {{($inventario_entrega->senales_carretera == 1) ? 'checked' : ''}} class='user_check all_generales' value="1" />
                                                                  <span></span>
                                                                  </label>
                                                                  </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 col-sm-6">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label>Duplicado de llaves</label>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group">    
                                                                    
                                                                  <span class="switch switch-icon">
                                                                  <label>
                                                                  <input type="checkbox" name="duplicado_llaves" {{($inventario_entrega->duplicado_llaves == 1) ? 'checked' : ''}} class='user_check all_generales' value="1" />
                                                                  <span></span>
                                                                  </label>
                                                                  </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="row text-center">
                                                    <div class="col-lg-4 col-sm-6">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label>Reflejantes</label>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group">    
                                                                    
                                                                  <span class="switch switch-icon">
                                                                  <label>
                                                                  <input type="checkbox" name="reflejantes" {{($inventario_entrega->reflejantes == 1) ? 'checked' : ''}} class='user_check all_generales' value="1" />
                                                                  <span></span>
                                                                  </label>
                                                                  </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-4 col-sm-6">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label>Cables para corriente</label>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group">    
                                                                    
                                                                  <span class="switch switch-icon">
                                                                  <label>
                                                                  <input type="checkbox" name="cables_corriente" {{($inventario_entrega->cables_corriente == 1) ? 'checked' : ''}} class='user_check all_generales' value="1" />
                                                                  <span></span>
                                                                  </label>
                                                                  </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 col-sm-6">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label>Acumulador</label>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group">    
                                                                    
                                                                  <span class="switch switch-icon">
                                                                  <label>
                                                                  <input type="checkbox" name="acumulador" {{($inventario_entrega->acumulador == 1) ? 'checked' : ''}} class='user_check all_generales' value="1" />
                                                                  <span></span>
                                                                  </label>
                                                                  </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                            </div>
                                        </div>
                                    </div>
                                </div>


                            {{-- LLantas  --}}
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="card card-custom gutter-b">
                                            <div class="card-header">
                                                <div class="card-title">
                                                    <h3 class="card-label">
                                                        Estado de las llantas
                                                    </h3>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-lg-12 form-group">
                                                        <label>Marca</label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" name="marca_llantas" value="{{ $inventario_entrega->marca_llantas }}" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()" required/>
                                                        </div>
                                                    </div>


                                                    <div class="col-lg-6 col-sm-6">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label>Delantero der.</label>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group">    
                                                                    
                                                                  <span class="switch switch-icon">
                                                                  <label>
                                                                  <input type="checkbox" name="llanta_delantera_derecha" {{($inventario_entrega->llanta_delantera_derecha == 1) ? 'checked' : ''}} class='user_check all_generales' value="1" />
                                                                  <span></span>
                                                                  </label>
                                                                  </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-6 col-sm-6">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label>Delantero izq.</label>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group">    
                                                                    
                                                                  <span class="switch switch-icon">
                                                                  <label>
                                                                  <input type="checkbox" name="llanta_delantera_izquierda" {{($inventario_entrega->llanta_delantera_izquierda == 1) ? 'checked' : ''}}  class='user_check all_generales' value="1" />
                                                                  <span></span>
                                                                  </label>
                                                                  </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="row">
                                                    <div class="col-lg-6 col-sm-6">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label>Traseros der.</label>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group">    
                                                                    
                                                                  <span class="switch switch-icon">
                                                                  <label>
                                                                  <input type="checkbox" name="llanta_trasera_derecha" {{($inventario_entrega->llanta_trasera_derecha == 1) ? 'checked' : ''}}  class='user_check all_generales' value="1" />
                                                                  <span></span>
                                                                  </label>
                                                                  </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-6 col-sm-6">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label>Traseros izq.</label>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group">    
                                                                    
                                                                  <span class="switch switch-icon">
                                                                  <label>
                                                                  <input type="checkbox" name="llanta_trasera_izquierda" {{($inventario_entrega->llanta_trasera_izquierda == 1) ? 'checked' : ''}} class='user_check all_generales' value="1" />
                                                                  <span></span>
                                                                  </label>
                                                                  </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-lg-6 col-sm-6">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label>Refacción</label>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group">    
                                                                    
                                                                  <span class="switch switch-icon">
                                                                  <label>
                                                                  <input type="checkbox" name="llantar_refaccion" {{($inventario_entrega->llantar_refaccion == 1) ? 'checked' : ''}} class='user_check all_generales' value="1" />
                                                                  <span></span>
                                                                  </label>
                                                                  </span>
                                                                </div>
                                                            </div>
                                                        </div>
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
                                                        Obervaciones generales
                                                    </h3>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                
                                                <div class="col-lg-12 text-center">
                                                    <img src="/img/medidor_gasolina.jpg" width="300px">
                                                </div>
                                                <div class="col-lg-12 form-group">
                                                    <label>Nivel de combustible</label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" name="nivel_combustible" value="{{ $inventario_entrega->nivel_combustible }}" required/>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>


                                </form>

                                <div class="row">
                                    <div class="col-lg-12 text-right">
                                        <button type="button"  id="btnGuardarInventario" class="btn btn-success"><i class="la la-plus"></i>Guardar Inventario</button>
                                    </div>
                                </div>
                                {{-- endinventario --}}

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
