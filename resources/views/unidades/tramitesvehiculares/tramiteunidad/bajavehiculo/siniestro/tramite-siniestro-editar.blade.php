@extends('layouts.app')
@push('scripts')
	{{-- <script src="{{ asset('js/cliente/AgregarCliente.js') }}"></script> --}}
    <script src="{{ asset('js/unidades/tramitesvehiculares/EditarBajaVehicularsiniestro.js') }}"></script>
@endpush
@section('title')
    Editar información del siniestro
@endsection
@section('content')

    <!--begin::Card-->
    <div class="row">
        <div class="col-lg-12">
            <!--begin::Card-->
            <div class="card card-custom gutter-b">
                <div class="card-header">
                    <h3 class="card-title">Editar información del siniestro</h3>
                </div>
                <input type="hidden" id="documentoEliminarPath" value="{{ route('traveh.eliminardocumentoevbvsini') }}">
                <input type='hidden' id='url_municipios' value='{{ route('cliente.obtenermunicipios') }}'>
                <!--begin::Form-->
                <form class="form" action="{{ route('traveh.editinfoevbvsiniestro') }}" method="post" id="frmCliente" enctype="multipart/form-data">
                    @csrf   
                    <input type="hidden" name="id_unidad" value="{{ $id_unidad }}">
                    <input type="hidden" name="id_pago" value="{{ $id_pago }}">
                    <input type='hidden' id='tipoArchivo' value='{{ $cadenaTipoDocumento }}'>
                    <div class="card-body">
                        <!--begin::tabs-->
                        <ul class="nav nav-tabs nav-tabs-line">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#kt_tab_pane_1">Información del siniestro</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#kt_tab_pane_2">Evidencias</a>
                            </li>
                        </ul>
                        <div class="tab-content mt-5" id="myTabContent">
                            <div class="tab-pane fade show active mt-10" id="kt_tab_pane_1" role="tabpanel" aria-labelledby="kt_tab_pane_1">

                                <div class="row form-group">
                                    <div class="col-lg-6">
                                        <label>Tipo de siniestro</label>
                                        <select class="form-control" id="unidad_tramite_bajavehiculo_siniestro_tipo_id" name="unidad_tramite_bajavehiculo_siniestro_tipo_id"  required >
                                            <option value="">Selecciona una opción</option>
                                            @foreach($tipo_siniestro as $pro)
                                                <option value="{{ $pro->id }}" @selected($tramite_info->unidad_tramite_bajavehiculo_siniestro_tipo_id == $pro->id)>{{ $pro->tipo_siniestro }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <div class="col-lg-6">
                                        <label>Propietario</label>
                                        <select class="form-control" id="id_propietario" name="id_propietario"  required >
                                            <option value="">Selecciona una opción</option>
                                            @foreach($info_propietario as $tp)
                                                <option value="{{ $tp->id }}" @selected($tramite_info->id_propietario == $tp->id) >{{ strtoupper( $tp->nombre_propietario) }}</option>
                                            @endforeach

                                        </select>
                                    </div>

                                    <div class="col-lg-6">
                                        <label>Gestor</label>
                                        <select class="form-control" id="gestor" name="gestor"  required >
                                            <option value="">Selecciona una opción</option>
                                            @foreach($gestor as $pro)
                                                <option value="{{ $pro->id }}" @selected($tramite_info->gestor == $tp->unidad_tramite_gestor_id) >{{ $pro->nombre }} - Telefono: {{ $pro->telefono }} - correo: {{ $pro->correo }} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col-lg-4">
                                        <label>Fecha de tramite</label>
                                        <div class="input-group">
                                            <input type="text" name="fecha_tramite" id="fecha_pago" value="{{ date('d/m/Y', strtotime($tramite_info->fecha_tramite))}}" class="form-control" required readonly />
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <label>Fecha de ocurrencia</label>
                                        <div class="input-group">
                                            <input type="text" name="fecha_ocurrencia" id="fecha_ocurrencia" value="{{ date('d/m/Y', strtotime($tramite_info->fecha_ocurrencia))}}"  class="form-control" required readonly />
                                        </div>
                                    </div> 
                                    <div class="col-lg-4">
                                        <label>Fecha de conclusion</label>
                                        <div class="input-group">
                                            <input type="text" name="fecha_conclusion" id="fecha_conclusion" value="{{ date('d/m/Y', strtotime($tramite_info->fecha_conclusion))}}"  class="form-control" required readonly />
                                        </div>
                                    </div> 
                                </div>



                                <div class="row form-group">
                                    <div class="col-lg-6">
                                        <label>Cía de seguros</label>
                                        <input type="text" class="form-control" name="cia_seguros" value="{{ $tramite_info->cia_seguros }}" id="cia_seguros" required />
                                    </div> 
                                    <div class="col-lg-6">
                                        <label>No. siniestro</label>
                                        <input type="text" class="form-control" name="no_siniestro" value="{{ $tramite_info->no_siniestro }}" id="no_siniestro" required />
                                    </div>                                     
                                </div>

                                <div class="row form-group">
                                    <div class="col-lg-6">
                                        <label>No. Reporte</label>
                                        <input type="text" class="form-control" name="no_reporte" value="{{ $tramite_info->no_reporte }}" id="no_reporte"  />
                                    </div> 
                                    <div class="col-lg-6">
                                        <label>Conductor</label>
                                        <input type="text" class="form-control" name="conductor" value="{{ $tramite_info->conductor }}" id="conductor"  />
                                    </div>                                     
                                </div>

                                <div class="row form-group">
                                    <div class="col-lg-6">
                                        <label>Autoridad participante</label>
                                        <input type="text" class="form-control" name="autoridad_participante" value="{{ $tramite_info->autoridad_participante }}" id="autoridad_participante"  />
                                    </div> 
                                    <div class="col-lg-6">
                                        <label>No. Carpeta (Denuncia)</label>
                                        <input type="text" class="form-control" name="no_carpeta" value="{{ $tramite_info->no_carpeta }}" id="no_carpeta"  />
                                    </div>                                     
                                </div>

                                <div class="form-group row">
                                    <div class="col-lg-6">
                                        <label>Estatus del siniestro</label>
                                        <select class="form-control" id="estatus_id" name="estatus_id"  required >
                                            <option value="">Selecciona una opción</option>
                                            @foreach($estatus as $tp)
                                                <option value="{{ $tp->id }}" @selected($tramite_info->estatus_id == $tp->id) >{{ strtoupper( $tp->nombre_estatus) }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-lg-6">
                                        <label>Importe</label>
                                        <input type="text" class="form-control" name="importe" id="importe" value="{{ $tramite_info->importe }}" required />
                                    </div> 
                                </div>

                            <div class="form-group row">
                                <div class="col-lg-6">
                                    <label>Estado</label>
                                    <select class="form-control" id="id_estado" name="id_estado"  required >
                                        <option value="">Selecciona una opción</option>
                                        @foreach($estados as $estado)
                                            <option value="{{ $estado->id_estado }}" @selected($tramite_info->estado_id_estado == $estado->id_estado) >{{ $estado->estado_nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-6">
                                    <label>Municipio y/o Alcaldía.</label>
                                    <select class="form-control" id="id_municipio" name="id_municipio"  required  >
                                        <option value="">Selecciona una opción</option>
                                        @foreach($municipios as $municipio)
                                            <option value="{{ $municipio->id_municipio }}" @selected($tramite_info->municipio_id_municipio == $municipio->id_municipio) >{{ $municipio->municipio_nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>

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
                                                            <a href="{{ route('archivo.documentoPagoBvSiniestro', ['id'=>$documento->id]) }}" class="link-primary" target="_blank"> {{ $documento->documento }} </a>
                                                        </td>
                                                        <td>{{ $documento->TramiteBajavehiculoSiniestroEvidencia->nombre_evidencia }}</td>
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
                                <a href="{{ route('traveh.tvbjsiniestro', $id_unidad) }}"  class="btn btn-secondary"><i class="la la-times"></i>Cancelar</a>
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
