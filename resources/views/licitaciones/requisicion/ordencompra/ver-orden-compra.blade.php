@extends('layouts.app')
@push('scripts')
    <script src="{{ asset('js/licitaciones/requisicion/ordencompra/ListadoOrdenCompra.js') }}"></script>
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
                                        <h3 class="card-title"><span class="badge badge-square badge-warning">{{ $detail }}</span> Detalle</h3>
                                        <div class="card-toolbar">
                                            <span style="font-weight: bold; font-size: 20px;">${{ number_format($prov->precio_unitario,2,'.',',') }}</span>
                                            <a href="" rel-path="{{ route('ordencompra.verOrdenPagoPDF', ['id' => $requisicion_id, 'orden' => $orden_id, 'id_orden_prov' => $prov->id]) }}" target="blank" class="btn btn-lg btn-clean btn-hover-icon-success btn-icon modal-pdf" title="Ver PDF" data-theme="dark"  data-toggle="tooltip" data-placement="top"><i class="far fa-file-pdf"></i></a>
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
                                            <table class="table table-hover mb-6 table-responsive-sm">
                                                <thead>
                                                    <tr>
                                                        <th>Cantidad</th>
                                                        <th>Tipo</th>
                                                        <th>Cilindros</th>
                                                        <th>Transmisión</th>
                                                        <th>Motor</th>
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
                                <a href="{{ route('ordencompra.catalogoordencompra') }}"  class="btn btn-secondary">Regresar</a>
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


    <div class="modal fade" id="exampleModalSizeSm" tabindex="-1" role="dialog" aria-labelledby="exampleModalSizeSm"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Orden de Compra</h5>
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