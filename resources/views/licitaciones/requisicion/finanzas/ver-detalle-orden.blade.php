                            <div class="col-lg-12">
                                <!--begin::Card-->
                                <div class="card card-custom gutter-b">
                                    <div class="card-header">
                                        <h3 class="card-title"><span class="badge badge-square badge-warning"></span> Detalle</h3>
                                    </div>
                                    <div class="card-toolbar">

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
                                                        <th>Accion</th>
                                                    </tr>
                                                </thead>
                                                <tbody id='tbodyDocumentos_{{ $prov->id }}'>
                                                    @php $cons = 0; @endphp
                                                    @foreach($or_partidas as $partidas)
                                                        @if($partidas->requisicion_orden_proveedor_id == 5)
                                                            <tr id="trDocumento{{ $prov->id }}">
                                                                <td>{{ $partidas->cantidad }}</td>
                                                                <td>{{ $partidas->segmento->segmentoTipoVehiculo->tipo_vehiculo }}</td>
                                                                <td>{{ $partidas->segmento->segmentoTransmision->transmision }}</td>
                                                                <td>{{ $partidas->segmento->segmentoNoCilindro->no_cilindro }} cilindros</td>
                                                                <td>{{ $partidas->segmento->segmentoMotor->motor }}</td> 
                                                                <td>
                                                                    <button class="btn btn-sm btn-clean btn-hover-icon-success btn-icon activar_estado" data-id="{{ $partidas->id }}" data-toggle="tooltip" data-theme="dark" title="Eliminar registro" ><i class="flaticon-delete"></i></button>
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