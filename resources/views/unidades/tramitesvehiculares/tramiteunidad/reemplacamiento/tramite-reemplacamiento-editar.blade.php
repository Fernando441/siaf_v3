@extends('layouts.app')
@push('scripts')
    <script src="{{ asset('js/unidades/tramitesvehiculares/EditarEmplacamiento.js') }}"></script>
@endpush
@section('title')
    Tramite de reemplacamiento
@endsection
@section('content')

    <!--begin::Card-->
    <div class="row">
        <div class="col-lg-12">
            <!--begin::Card-->
            <div class="card card-custom gutter-b">
                <div class="card-header">
                    <h3 class="card-title">Editar información del reemplacamiento</h3>
                </div>
                <input type="hidden" id="documentoEliminarPath" value="{{ route('traveh.eliminardocumentoevreemplaca') }}">
                <!--begin::Form-->
                <form class="form" action="{{ route('traveh.editinfoevreemplacamiento') }}" method="post" id="frmCliente" enctype="multipart/form-data">
                    @csrf   
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
                                <div class="form-group row">
                                    <div class="col-lg-6">
                                        <label>Gestor</label>
                                        <select class="form-control" id="gestor" name="gestor"  required >
                                            <option value="">Selecciona una opción</option>
                                            @foreach($gestor as $pro)
                                                <option value="{{ $pro->id }}" @selected($tramite_info->unidad_tramite_gestor_id == $pro->id) >{{ $pro->nombre }} - Telefono: {{ $pro->telefono }} - correo: {{ $pro->correo }} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-6">
                                        <label>Propietario</label>
                                        <select class="form-control" id="id_propietario" name="id_propietario"  required >
                                            <option value="">Selecciona una opción</option>
                                            @foreach($info_propietario as $tp)
                                                <option value="{{ $tp->id }}" @selected($tramite_info->id_propietario == $tp->id) >{{ strtoupper( $tp->nombre_propietario) }}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-lg-6">
                                        <label>Tipo placa</label>
                                        <select class="form-control" id="tipo_placa" name="tipo_placa"  required >
                                            <option value="">Selecciona una opción</option>
                                            @foreach($tipo_placa as $pro)
                                                <option value="{{ $pro->id }}"   @selected($tramite_info->unidad_tramite_tipo_placas_id == $pro->id)>{{ $pro->tipo_placas }} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-6">
                                        <label>Fecha del trámite</label>
                                        <div class="input-group">
                                            <input type="text" name="fecha_tramite" id="fecha_tramite" value="{{ date('d/m/Y', strtotime($tramite_info->fecha_tramite))}}" class="form-control" required readonly />
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-lg-6">
                                        <label>Fecha de expedición</label>
                                        <div class="input-group">
                                            <input type="text" name="fecha_expedicion" id="fecha_expedicion" value="{{ date('d/m/Y', strtotime($tramite_info->fecha_expedicion))}}" class="form-control" required readonly />
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <label>Fecha de vencimiento</label>
                                        <div class="input-group">
                                            <input type="text" name="fecha_vencimiento_placas" id="fecha_vencimiento_placas" value="{{ date('d/m/Y', strtotime($tramite_info->fecha_vencimiento_tarjeta))}}" class="form-control" required readonly />
                                        </div>
                                    </div>     
                                </div>

                                <div class="form-group row">
                                    <div class="col-lg-6">
                                        <label>Importe</label>
                                        <div class="input-group">
                                            <input type="text" name="importe" id="importe"  class="form-control" value="{{ $tramite_info->importe }}" required />
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <label>Número de placas</label>
                                        <div class="input-group">
                                            <input type="text" name="numero_placas" id="numero_placas" value="{{ $tramite_info->numero_placas }}"  class="form-control" required onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-lg-6">
                                        <label>Entidad de las placas</label>
                                        <select class="form-control" id="entidad_placas" name="entidad_placas"  required >
                                            <option value="">Selecciona una opción</option>
                                            @foreach($estados as $pro)
                                                <option value="{{ $pro->id_estado }}" @selected($tramite_info->entidad_placas == $pro->id_estado) >{{ strtoupper( $pro->estado_nombre) }}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                    <div class="col-lg-6">
                                        <label>Engomado</label>
                                        <div class="radio-inline">
                                            <label class="radio">
                                                <input type="radio" {{($tramite_info->engomado == 1) ? 'checked' : ''}} name="engomado" value="1" />
                                                <span></span>
                                                Amarillo
                                            </label>
                                            <label class="radio">
                                                <input type="radio" {{($tramite_info->engomado == 2) ? 'checked' : ''}}  name="engomado" value="2" />
                                                <span></span>
                                                Rosa
                                            </label>
                                            <label class="radio">
                                                <input type="radio" {{($tramite_info->engomado == 3) ? 'checked' : ''}} name="engomado" value="3" />
                                                <span></span>
                                                Rojo
                                            </label>
                                            <label class="radio">
                                                <input type="radio" {{($tramite_info->engomado == 4) ? 'checked' : ''}} name="engomado" value="4" />
                                                <span></span>
                                                Verde
                                            </label>
                                            <label class="radio">
                                                <input type="radio" {{($tramite_info->engomado == 5) ? 'checked' : ''}} name="engomado" value="5" />
                                                <span></span>
                                                Azul
                                            </label>
                                        </div>
                                        <img src="/img/verificacion.png" width="440px">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-lg-6">
                                        <label>Holograma</label>
                                        <div class="input-group">
                                            <input type="text" name="holograma" id="holograma" value="{{ $tramite_info->holograma }}" class="form-control" required onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <label>¿La unidad verifica?</label>
                                        <select class="form-control" id="verificacion_op" name="verificacion_op"  required >
                                            <option value="" disabled>Selecciona una opción</option>
                                            <option value="1"  {{($tramite_info->verificacion_op == 1) ? 'selected' : ''}}>No</option>
                                            <option value="2" {{($tramite_info->verificacion_op == 2) ? 'selected' : ''}}>Si</option>
                                        </select>
                                    </div>
                                </div>

{{--                                 <div class="form-group row">
                                    <div class="col-lg-6">
                                        <label>Tarjeta de circulación</label>
                                        <div class="input-group">
                                            <input type="text" name="tarjeta_circularion" id="tarjeta_circularion" value="{{ $tramite_info->tarjeta_circularion }}" class="form-control" required onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <label>Fecha de emisión de la tarjeta de circulación</label>
                                        <div class="input-group">
                                            <input type="text" name="fecha_emision" id="fecha_emision" value="{{ date('d/m/Y', strtotime($tramite_info->fecha_emision_tarjeta))}}"  class="form-control" required readonly />
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-lg-6">
                                        <label>Fecha de vencimiento de la tarjeta de circulación</label>
                                        <div class="input-group">
                                            @if($tramite_info->fecha_vencimiento_tarjeta != null ||$tramite_info->fecha_vencimiento_tarjeta != "")
                                                <input type="text" class="form-control" name="fecha_vencimiento" id="fecha_vencimiento" readonly value="{{ date('d/m/Y', strtotime($tramite_info->fecha_vencimiento_tarjeta))}}"/>
                                            @else
                                                <input type="text" class="form-control" name="fecha_vencimiento" id="fecha_vencimiento" readonly value=""/>
                                            @endif

                                        </div>
                                    </div>
                                </div> --}}

                                <div class="form-group row">
                                    <div class="col-lg-12">
                                        <label for="observaciones">Observaciones</label>
                                        <textarea class="form-control" name="observaciones" id="observaciones" rows="3" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">{{ $tramite_info->observaciones }}</textarea>
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
                                                <th scope="col">Opción</th>
                                            </tr>
                                            </thead>
                                            <tbody id='tbodyDocumentos'>
                                                @foreach($tramite_evidencia as $documento)
                                                    <tr id="trDocumento{{ $documento->id }}">
                                                        <td>
                                                            <a href="{{ route('archivo.documentoPagoReemplacamiento', ['id'=>$documento->id]) }}" class="link-primary" target="_blank"> {{ $documento->documento }} </a>
                                                        </td>
                                                        <td>{{ $documento->unidadTramiteEmplacamientoEvidencia->nombre_evidencia }}</td>
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
                            </div>

                        </div>
                        <!--end::tabs-->

                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-lg-6">
                                <button type="button"  id="btnGuardar" class="btn btn-success"><i class="la la-plus"></i>Guardar</button>
                                <a href="{{ route('traveh.tvreemplaca', $id_unidad) }}"  class="btn btn-secondary"><i class="la la-arrow-left"></i>Regresar</a>
                            </div>
                        </div>
                    </div>
                </form>
                <!--end::Form-->
            </div>
            <!--end::Card-->
        </div>
    </div>
    <!--end::Card-->

@endsection
