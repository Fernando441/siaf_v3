@extends('layouts.app')
@push('scripts')
	{{-- <script src="{{ asset('js/cliente/AgregarCliente.js') }}"></script> --}}
    <script src="{{ asset('js/unidades/tramitesvehiculares/EditarTenencia.js') }}"></script>
@endpush
@section('title')
    Ver información del siniestro
@endsection
@section('content')

    <!--begin::Card-->
    <div class="row">
        <div class="col-lg-12">
            <!--begin::Card-->
            <div class="card card-custom gutter-b">
                <div class="card-header">
                    <h3 class="card-title">Ver información del siniestro</h3>
                </div>
                <input type="hidden" id="documentoEliminarPath" value="{{ route('traveh.eliminardocumentoevtenencia') }}">
                <!--begin::Form-->
  
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

                                <div class="form-group row mt-2">
                                    <div class="col-lg-4">
                                        <label>Fecha del tramite</label>
                                        <div class="input-group">
                                            <p>{{ date('d/m/Y', strtotime($tramite_info->fecha_tramite))}}</p>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <label>Fecha de ocurrencia</label>
                                        <div class="input-group">
                                            <p>{{ date('d/m/Y', strtotime($tramite_info->fecha_ocurrencia))}}</p>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <label>Fecha de conclusion</label>
                                        <div class="input-group">
                                            <p>{{ date('d/m/Y', strtotime($tramite_info->fecha_conclusion))}}</p>
                                        </div>
                                    </div>
                                </div>


                                <div class="row form-group">
                                    <div class="col-lg-6">
                                        <label>Cía de seguros</label>
                                        <p>{{ $tramite_info->cia_seguros }}</p>
                                    </div> 
                                    <div class="col-lg-6">
                                        <label>No. siniestro</label>
                                        <p>{{ $tramite_info->no_siniestro }}</p>
                                    </div>                                     
                                </div>

                                <div class="row form-group">
                                    <div class="col-lg-6">
                                        <label>No. Reporte</label>
                                        <p>{{ $tramite_info->no_reporte }}</p>
                                    </div> 
                                    <div class="col-lg-6">
                                        <label>Conductor</label>
                                        <p>{{ $tramite_info->conductor }}</p>
                                    </div>                                     
                                </div>

                                <div class="row form-group">
                                    <div class="col-lg-6">
                                        <label>Autoridad participante</label>
                                        <p>{{ $tramite_info->autoridad_participante }}</p>
                                    </div> 
                                    <div class="col-lg-6">
                                        <label>No. Carpeta (Denuncia)</label>
                                        <p>{{ $tramite_info->no_carpeta }}</p>
                                    </div>                                     
                                </div>


                                <div class="form-group row">
                                    <div class="col-lg-6">
                                        <label>Estatus del siniestro</label>
                                        <p>{{ $tramite_info->TramiteBajavehiculoSiniestroEstatus->nombre_estatus }}</p>
                                    </div>

                                    <div class="col-lg-6">
                                        <label>Importe</label>
                                        <p>${{ $tramite_info->importe }}</p>
                                    </div> 
                                </div>

                                <div class="row form-group">
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
                                                            <a href="{{ route('archivo.documentoPagoBvSiniestro', ['id'=>$documento->id]) }}" class="link-primary" target="_blank"> {{ $documento->documento }} </a>
                                                        </td>
                                                        <td>{{ $documento->TramiteBajavehiculoSiniestroEvidencia->nombre_evidencia }}</td>
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
                                <a href="{{ route('traveh.tvbjsiniestro', $id_unidad) }}"  class="btn btn-secondary"><i class="la la-arrow-left"></i>Regresar</a>
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
