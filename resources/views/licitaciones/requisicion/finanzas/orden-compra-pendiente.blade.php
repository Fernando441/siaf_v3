@extends('layouts.app')
@push('scripts')
	<script src="{{ asset('js/licitaciones/requisicion/finanzas/Generarordencompra.js') }}"></script>
@endpush
@section('title')
    Orden de compra
@endsection
@section('content')

    <!--begin::Card-->
    <div class="row">
        <div class="col-lg-12">
            <!--begin::Card-->
            <div class="card card-custom gutter-b">
                <div class="card-header">
                    <h3 class="card-title">Orden de compra</h3>
                     
                    <div class="card-toolbar">
                        <a href="{{ route('finanzas.ordencompra', $requisicion_id) }}"  class="btn btn-light-primary font-weight-bolder mr-3 ml-3">Regresar</a>
                    </div>
                </div>
                <!--begin::Form-->
{{--                 <form action="{{ route('user.guardarusuario') }}" method="post" id="submit_user">
                    @csrf --}}
                    <div class="card-body">
                        @php $detail = 1;  @endphp




                        @foreach($or_prov as $prov)
                            <div class="col-lg-12">
                                <!--begin::Card-->
                                <div class="card card-custom gutter-b">
                                    <div class="card-header">
                                        <h3 class="card-title"><span class="badge badge-square badge-warning" style="font-weight: bold">{{ $detail }}</span> Detalle de la compra  
                                            <a href="{{ route('finanzas.verordendetalle', [$requisicion_id,$orden_id,$prov->id]) }}" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon ml-2" title="Ver detalle general" data-theme="dark" data-toggle="tooltip" data-placement="top">
                                                <span class="svg-icon svg-icon-md">
                                                    <i class="flaticon-eye"></i>
                                                </span>
                                            </a>
                                            
                                        </h3>
                                        <div class="card-toolbar">
                                            <span style="font-weight: bold; font-size: 20px;">${{ number_format($prov->precio_unitario,2,'.',',') }}</span>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row form-group">
                                            <div class="col-lg-4">
                                                <label>Nombre del proveedor</label>
                                                <p>{{ $prov->proveedor->nombre }}</p>
                                            </div>
                                            <div class="col-lg-4">
                                                <label>Contacto</label>
                                                <p>{{ $prov->proveedor->contacto }}</p>
                                            </div>
                                           <div class="col-lg-4">
                                                <label>Telefono</label>
                                                <p>{{ $prov->proveedor->telefono }}</p>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-lg-4">
                                                <label>Correo electrónico</label>
                                                <p>{{ $prov->proveedor->correo }}</p>
                                            </div>
                                            <div class="col-lg-4">
                                                <label>RFC</label>
                                                <p>{{ $prov->proveedor->rfc }}</p>
                                            </div>
                                           <div class="col-lg-4">
                                                <label>Dirección</label>
                                                <p>{{ $prov->proveedor->dirección }}</p>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-lg-12">
                                                <label>Convenio</label>
                                                <p>{{ $prov->proveedor->convenio }}</p>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <table class="table table-hover mb-6 table-responsive-sm">
                                                <thead>
                                                    <tr>
                                                        <th>Cantidad</th>
                                                        <th>Tipo</th>
                                                        <th>Cilindros</th>
                                                        <th>Transmisión</th>
                                                        <th>Motor</th>
                                                        <th>Accion</th>
                                                    </tr>
                                                </thead>
                                                <tbody id='tbodyDocumentos_{{ $prov->id }}'>
                                                    @php $cons = 0; @endphp
                                                    @foreach($or_partidas as $partidas)
                                                        @if($prov->id == $partidas->requisicion_orden_proveedor_id)
                                                            <tr id="trDocumento{{ $partidas->id }}">
                                                                <td>{{ $partidas->cantidad }}</td>
                                                                <td>{{ $partidas->segmento->segmentoTipoVehiculo->tipo_vehiculo }}</td>
                                                                <td>{{ $partidas->segmento->segmentoTransmision->transmision }}</td>
                                                                <td>{{ $partidas->segmento->segmentoNoCilindro->no_cilindro }} cilindros</td>
                                                                <td>{{ $partidas->segmento->segmentoMotor->motor }}</td> 
                                                                <td>
                                                                    <button class="btn btn-sm btn-clean btn-hover-icon-success btn-icon eliminar-partida" data-id="{{ $partidas->id }}" data-nombre="{{ $partidas->segmento->segmentoTipoVehiculo->tipo_vehiculo }}" data-orden="{{ $orden_id }}" data-requisicion="{{ $requisicion_id }}" data-toggle="tooltip" data-theme="dark" title="Eliminar registro" ><i class="flaticon-delete"></i></button>
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-lg-4">
                                                <label>Forma de pago</label>
                                                <p>{{ $prov->requisicionFormaPago->forma_pago }}</p>
                                            </div>
                                            <div class="col-lg-4">
                                                <label>Método de pago</label>
                                                <p>{{ $prov->requisicionMetodoPago->clave }} - {{ $prov->requisicionMetodoPago->metodo_pago }}</p>
                                            </div>
                                            <div class="col-lg-4">
                                                <label>Uso de CFDI</label>
                                                <p>{{ $prov->uso_cfdi }} </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end::Card-->
                            </div>

                             @php $detail = $detail + 1 ;  @endphp
                        @endforeach
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-lg-6">
                                {{-- <button type="button"  id="btnGuardar" class="btn btn-primary mr-2">Finalizar</button> --}}
                               {{--  <a href="{{ route('finanzas.ordencompra', $requisicion_id) }}"  class="btn btn-secondary">Regresar</a> --}}
                            </div>
                        </div>
                    </div>
                {{-- </form> --}}
                <!--end::Form-->
            </div>
            <!--end::Card-->
        </div>
    </div>
    <!--end::Card-->

    <form method="post" id="partida_delete_form" action="{{ route('finanzas.eliminarpartidaorden') }}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="id" id="id_delete" value="">
        <input type="hidden" name="orden" id="id_orden" value="">
        <input type="hidden" name="requisicion" id="id_requisicion" value="">
        
    </form>

    <div class="modal fade" id="exampleModalSizeSm" tabindex="-1" role="dialog" aria-labelledby="exampleModalSizeSm"
    aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Orden de compra</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div id="modal-body" class="modal-body">
                
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn btn-secondary font-weight-bold" data-dismiss="modal"><i
                        class="la la-times"></i>Cerrar</button>
                 
            </div>
        </div>
    </div>
</div>

@endsection