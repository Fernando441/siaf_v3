@extends('layouts.app')
@push('scripts')
	{{-- <script src="{{ asset('js/cliente/AgregarCliente.js') }}"></script> --}}
    <script src="{{ asset('js/unidades/tramitesvehiculares/EditarAseguramiento.js') }}"></script>
@endpush
@section('title')
    Ver tramite de aseguramiento
@endsection
@section('content')

    <!--begin::Card-->
    <div class="row">
        <div class="col-lg-12">
            <!--begin::Card-->
            <div class="card card-custom gutter-b">
                <div class="card-header">
                    <h3 class="card-title">Ver tramite de aseguramiento</h3>
                </div>
                <input type="hidden" id="documentoEliminarPath" value="{{ route('traveh.eliminardocumentoevaseg') }}">
                <!--begin::Form-->
 
                    <input type="hidden" name="id_unidad" value="{{ $id_unidad }}">
                    <input type="hidden" name="id_pago" value="{{ $id_pago }}">
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
                                    <div class="col-lg-8">
                                        <label>Descripción</label>
                                        <div class="input-group">
                                            <p>{{ $tramite_info->descripcion }}</p>
                                        </div>
                                    </div> 
                                    <div class="col-lg-4">
                                        <label>Modelo</label>
                                        <div class="input-group">
                                            <p>{{ $tramite_info->modelo }}</p>
                                        </div>
                                    </div> 
                                </div>

                                <div class="form-group row">
                                    <div class="col-lg-6">
                                        <label>No. Serie</label>
                                        <div class="input-group">
                                            <p>{{ $tramite_info->serie }}</p>
                                        </div>
                                    </div> 
                                    <div class="col-lg-6">
                                        <label>Uso de la unidad en la poliza</label>
                                        <div class="input-group">
                                            <p>{{ $tramite_info->uso_unidad_poliza }}</p>
                                        </div>
                                    </div> 
                                </div>

                                {{-- Nuevos campos --}}
                                <div class="row form-group">
                                    <div class="col-lg-4">
                                        <label>Valor factura</label>
                                        <div class="input-group">
                                            <p>${{ $tramite_info->valor_factura }}</p>
                                        </div>
                                    </div>  

                                    <div class="col-lg-4">
                                        <label>Equipo especial - Fecha de factura</label>
                                        <div class="input-group">
                                            <p>{{ date('d/m/Y', strtotime($tramite_info->fecha_factura_eq_esp))}}</p>
                                        </div>
                                    </div>  

                                    <div class="col-lg-4">
                                        <label>Adaptacion - Fecha de factura</label>
                                        <div class="input-group">
                                            <p>{{ date('d/m/Y', strtotime($tramite_info->fecha_factura_adaptacion))}}</p>
                                        </div>
                                    </div>  
                                </div>
                                {{-- Nuevos campos --}}


                                <div class="row form-group">
                                    <div class="col-lg-4">
                                        <label>Suma asegurada de unidad</label>
                                        <div class="input-group">
                                           <p>${{ $tramite_info->importe }}</p>
                                        </div>
                                    </div>  

                                    <div class="col-lg-4">
                                        <label>Valor EQ. ESP.</label>
                                        <div class="input-group">
                                            <p>${{ $tramite_info->valor_eq_esp }}</p>
                                        </div>
                                    </div>  

                                    <div class="col-lg-4">
                                        <label>Valor adaptacion</label>
                                        <div class="input-group">
                                            <p>${{ $tramite_info->valor_adaptacion }}</p>
                                        </div>
                                    </div>  
                                </div>


                                <div class="row form-group">
                                    <div class="col-lg-6">
                                        <label>Nombre del archivo poliza</label>
                                        <div class="input-group">
                                            <p>{{ $tramite_info->nombre_archivo_poliza }}</p>
                                        </div>
                                    </div> 
                                    <div class="col-lg-6">
                                        <label>Nombre de la aseguradora</label>
                                            @foreach($aseguradora as $tp)
                                                @if($tramite_info->aseguradora_id == $tp->id)
                                                    <p>{{ strtoupper( $tp->nombre_aseguradora) }}</p>
                                                @endif
                                            @endforeach
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-lg-4">
                                        <label>Número de la poliza</label>
                                        <div class="input-group">
                                            <p>{{ $tramite_info->no_poliza }}</p>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <label>Tipo de cobertura</label>
                                            @foreach($tipo_cobertura as $tp)
                                                @if($tramite_info->tipo_cobertura_id == $tp->id)
                                                    <p>{{ strtoupper( $tp->tipo_cobertura) }}</p>
                                                @endif
                                            @endforeach
                                    </div>
                                    <div class="col-lg-4">
                                        <label>Inciso</label>
                                        <div class="input-group">
                                            <p>{{ $tramite_info->inciso }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-lg-6">
                                        <label>Vigencia inicial del seguro </label>
                                        <div class="input-group">
                                            <p>{{ date('d/m/Y', strtotime($tramite_info->fecha_inicial_seguro))}}</p>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <label>Vigencia final del seguro </label>
                                        <div class="input-group">
                                            <p>{{ date('d/m/Y', strtotime($tramite_info->fecha_final_seguro))}}</p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <div class="col-lg-4">
                                        <label>Prima neta</label>
                                        <div class="input-group">
                                            <p>${{ $tramite_info->prima_neta }}</p>
                                        </div>
                                    </div>  

                                    <div class="col-lg-4">
                                        <label>Regargos</label>
                                        <div class="input-group">
                                            <p>${{ $tramite_info->recargos }}</p>
                                        </div>
                                    </div>  

                                    <div class="col-lg-4">
                                        <label>Gastos Exp.</label>
                                        <div class="input-group">
                                            <p>{{ $tramite_info->gastos_exp }}</p>
                                        </div>
                                    </div>
                                </div> 

                                <div class="form-group row">
                                    <div class="col-lg-4">
                                        <label>Sub total</label>
                                        <div class="input-group">
                                            <p>{{ $tramite_info->sub_total }}</p>
                                        </div>
                                    </div>  

                                    <div class="col-lg-4">
                                        <label>IVA</label>
                                        <div class="input-group">
                                            <p>{{ $tramite_info->iva }}</p>
                                        </div>
                                    </div>  

                                    <div class="col-lg-4">
                                        <label>Prima total</label>
                                        <div class="input-group">
                                            <p>${{ $tramite_info->prima_total }}</p>
                                        </div>
                                    </div>
                                </div>  
 
                                 <div class="form-group row">
                                    <div class="col-lg-6">
                                        <label>1er recibo</label>
                                        <div class="input-group">
                                            <p>${{ $tramite_info->primer_recibo }}</p>
                                        </div>
                                    </div>  

                                    <div class="col-lg-6">
                                        <label>Recibos subsecuentes</label>
                                        <div class="input-group">
                                            <p>${{ $tramite_info->recibos_sub }}</p>
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
                                                            <a href="{{ route('archivo.documentoPagoAseguramiento', ['id'=>$documento->id]) }}" class="link-primary" target="_blank"> {{ $documento->documento }} </a>
                                                        </td>
                                                        <td>{{ $documento->unidadTramiteAseguramientoEvidencia->nombre_evidencia }}</td>

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
                                <a href="{{ route('traveh.tvaseguramiento', $id_unidad) }}"  class="btn btn-secondary"><i class="la la-arrow-left"></i>Regresar</a>
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
