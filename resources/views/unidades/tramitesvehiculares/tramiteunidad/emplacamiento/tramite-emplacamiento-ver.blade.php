@extends('layouts.app')
@push('scripts')
    <script src="{{ asset('js/unidades/tramitesvehiculares/EditarEmplacamiento.js') }}"></script>
@endpush
@section('title')
    Tramite de emplacamiento
@endsection
@section('content')

    <!--begin::Card-->
    <div class="row">
        <div class="col-lg-12">
            <!--begin::Card-->
            <div class="card card-custom gutter-b">
                <div class="card-header">
                    <h3 class="card-title">Ver información del emplacamiento</h3>
                </div>
                <input type="hidden" id="documentoEliminarPath" value="{{ route('traveh.eliminardocumentoevemplaca') }}">
                <!--begin::Form-->
  
                    <input type="hidden" name="id_unidad" value="{{ $id_unidad }}">
                    <input type="hidden" name="id_emplacamiento" value="{{ $id_tramite }}">
                    <input type='hidden' id='tipoArchivo' value='{{ $cadenaTipoDocumento }}'>
                    <div class="card-body">
                        <!--begin::tabs-->
                        <ul class="nav nav-tabs nav-tabs-line">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#kt_tab_pane_1">Información del tramite</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#kt_tab_pane_2">Evidencias</a>
                            </li>
                        </ul>
                        <div class="tab-content mt-5" id="myTabContent">
                            <div class="tab-pane fade show active mt-10" id="kt_tab_pane_1" role="tabpanel" aria-labelledby="kt_tab_pane_1">

                                <div class="card card-custom" id="kt_card_1">
                                    <div class="card-header">
                                        <div class="card-title">
                                            <h3 class="card-label">Información del propietario</h3>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group row">
                                            <div class="col-lg-4">
                                                <label>Nombre del propietario</label>
                                                <div class="input-group">
                                                    <p>{{ $info_propietario->nombre_propietario }}</p>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <label>RFC</label>
                                                <div class="input-group">
                                                    <p>{{ $info_propietario->rfc }}</p>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <label>Número de identificación</label>
                                                <div class="input-group">
                                                    <p>{{ $info_propietario->no_identificacion }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-lg-4">
                                                <label>Dirección</label>
                                                <div class="input-group">
                                                    <p>{{ $info_propietario->direccion }}</p>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <label>Estado</label>
                                                <div class="input-group">
                                                    @foreach($estados as $estado)
                                                        @if($estado->id_estado == $info_propietario->estado_id )
                                                            <p>{{ $estado->estado_nombre }}</p>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                 <label>Municipio y/o Alcaldía.</label>
                                                <div class="input-group">
                                                    @foreach($municipios as $municipio)
                                                        @if($municipio->id_municipio == $info_propietario->ciudad_id )
                                                            <p>{{ $municipio->municipio_nombre }}</p>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-lg-4">
                                                <label>Codigo Postal</label>
                                                <div class="input-group">
                                                    <p>{{ $info_propietario->cp }}</p>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <label>Teléfono</label>
                                                <div class="input-group">
                                                    <p>{{ $info_propietario->telefono }}</p>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <label>Correo electrónico</label>
                                                <div class="input-group">
                                                    <p>{{ $info_propietario->correo }}</p>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-lg-6">
                                        <label>Fecha del trámite</label>
                                        <div class="input-group">
                                            <p>{{ date('d/m/Y', strtotime($tramite_info->fecha_tramite))}}</p>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <label>Importe</label>
                                        <div class="input-group">
                                            <p>${{ $tramite_info->importe }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-lg-6">
                                        <label>Número de placas</label>
                                        <div class="input-group">
                                            <p>{{ $tramite_info->numero_placas }}</p>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <label>Entidad de las placas</label>
                                        @foreach($estados as $pro)
                                            @if($tramite_info->entidad_placas == $pro->id_estado)
                                                <p>{{ $pro->estado_nombre }}</p>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-lg-6">
                                         <label>Engomado</label>
                                        @if($tramite_info->engomado == 1)
                                            <span>Amarillo</span>
                                        @endif
                                        @if($tramite_info->engomado == 2)
                                            <span>Rosa</span>
                                        @endif
                                        @if($tramite_info->engomado == 3)
                                            <span>Rojo</span>
                                        @endif
                                        @if($tramite_info->engomado == 4)
                                            <span>Verde</span>
                                        @endif
                                        @if($tramite_info->engomado == 5)
                                            <span>Azul</span>
                                        @endif

                                        <img src="/img/verificacion.png" width="440px">
                                    </div>
                                    <div class="col-lg-6">
                                        <label>Holograma</label>
                                        <div class="input-group">
                                           <p>{{ $tramite_info->holograma }}</p>
                                        </div>   
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-lg-6">
                                        @if($tramite_info->verificacion_op == 1)
                                            <span class="label font-weight-bold label-outline-danger label-inline" style="font-size: 16px">No Verifica</span>
                                        @else
                                            <span class="label font-weight-bold label-outline-success label-inline"style="font-size: 16px" >Si Verifica</span>
                                        @endif
                                    </div>
                                    <div class="col-lg-6">
                                        <label>Tarjeta de circulación</label>
                                        <p>{{ $tramite_info->tarjeta_circularion }}</p>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-lg-6">
                                        <label>Fecha de emisión de la tarjeta de circulación</label>
                                        <div class="input-group">
                                            <p>{{ date('d/m/Y', strtotime($tramite_info->fecha_emision_tarjeta))}}</p>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <label>Fecha de vencimiento de la tarjeta de circulación</label>
                                        <div class="input-group">
                                            @if($tramite_info->fecha_vencimiento_tarjeta != null ||$tramite_info->fecha_vencimiento_tarjeta != "")
                                                <p>{{ date('d/m/Y', strtotime($tramite_info->fecha_vencimiento_tarjeta))}}</p>
                                            @else
                                                <p></p>
                                            @endif

                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-lg-12">
                                        <label for="observaciones">Observaciones</label>
                                        <p>{{ $tramite_info->observaciones }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade mt-10" id="kt_tab_pane_2" role="tabpanel" aria-labelledby="kt_tab_pane_2">

                                <div class="row form-group" >
                                    <div class="col-lg-12" id="tblArchivos">
                                        <table class="table table-hover mb-6 table-responsive-sm" id="tblDocumentos">
                                            <thead>
                                            <tr>
                                                <th scope="col">Documento</th>
                                                <th scope="col">Tipo de Documento</th>
                                            </tr>
                                            </thead>
                                            <tbody id='tbodyDocumentos'>
                                                @foreach($tramite_evidencia as $documento)
                                                    <tr id="trDocumento{{ $documento->id }}">
                                                        <td>
                                                            <a href="{{ route('archivo.documentoPagoEmplacamiento', ['id'=>$documento->id]) }}" class="link-primary" target="_blank"> {{ $documento->unidadTramiteEmplacamientoEvidencia->nombre_evidencia }} </a>
                                                        </td>
                                                        <td>{{ $documento->unidadTramiteEmplacamientoEvidencia->nombre_evidencia }}</td>

                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>


                            </div>

                        </div>
                        <!--end::tabs-->

                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-lg-6">
                                <a href="{{ route('traveh.tvemplacamiento', $id_unidad) }}"  class="btn btn-secondary"><i class="la la-arrow-left"></i>Regresar</a>
                            </div>
                        </div>
                    </div>

                <!--end::Form-->
            </div>
            <!--end::Card-->
        </div>
    </div>
    <!--end::Card-->

@endsection
