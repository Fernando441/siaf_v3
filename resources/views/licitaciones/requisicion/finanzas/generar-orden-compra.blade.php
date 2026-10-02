@extends('layouts.app')
@section('title')
    Generar orden de compra
@endsection
@push('scripts')
    <script src="{{ asset('js/licitaciones/requisicion/finanzas/Generarordencompra.js') }}"></script>
@endpush
@section('content')

    <!--begin::Card-->
    <div class="row">
        <div class="col-lg-12">
            <!--begin::Card-->
            <div class="card card-custom gutter-b">
                <div class="card-header">
                    <h3 class="card-title"> Generar orden de compra</h3>
                    <div class="card-toolbar">
                        @if($orden_compra != null)
                            <a href="{{ route('finanzas.verordenpendiente', [$id, $orden_compra]) }}" class="btn btn-primary mr-2">
                                <i class="flaticon2-cube"></i> Ver Orden compra
                            </a>
                        @endif
                    </div>
                </div>

                <!--begin::Form-->
                <form action="{{ route('finanzas.generarordencompra') }}" method="post" id="submit_user">
                    @csrf
                    <input type="hidden" name="requisicion_id" value="{{ $id }}">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-8"></div>
                                {{-- @if($req->visto_bueno_operaciones == 1)
                                    <div class="col-lg-4">
                                        <a href="#" id="vistobueno" class="btn btn-icon btn-danger btn-circle text-center">
                                            <i class="flaticon2-checkmark"></i>
                                        </a>
                                        <span style="color: gray; font-size: 12px">* Para continuar es necesario dar visto bueno a la requisición</span>
                                    </div>
                                @else
                                    <div class="col-lg-4">
                                        <a href="#"  class="btn btn-icon btn-success btn-circle text-center">
                                            <i class="flaticon2-checkmark"></i>
                                        </a>
                                        <br>
                                        <span style="color: gray; font-size: 12px">Visto bueno realizado por {{ $req->uservistobueno->name }} con fecha del {{ $req->hora_vistobueno }}</span>
                                    </div>
                                @endif --}}
                        </div>

                    <div class="row mt-2">
                        <div class="col-lg-12">
                            <div class="row form-group">
                                <div class="col-lg-3">
                                    <label>Folio</label>
                                    <p>{{ $requisicion->folio}}</p>
                                </div>
                                <div class="col-lg-3">
                                    <label>Solicitante</label>
                                    <p>{{ $requisicion->usersolicitante->name}}</p>
                                </div>
                                <div class="col-lg-3">
                                    <label>Area</label>
                                    <p>{{ $requisicion->areaPersonal->nombre_area }}</p>
                                </div>
                                <div class="col-lg-3">
                                    <label>Fecha de Solicitud</label>
                                    <p>{{  $requisicion->fecha_solicitud }}</p>
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-lg-6">
                                    <label>Proveedor</label>
                                    <select class="form-control" name="proveedor" id="proveedor" required>
                                        <option value="">Selecciona un opción</option>
                                        @foreach($proveedor as $cli)
                                            <option value="{{ $cli->id }}" data-nombre="{{ $cli->nombre }}" data-contacto="{{ $cli->contacto }}"  data-telefono="{{ $cli->telefono }}" data-correo="{{ $cli->correo }}" data-direccion="{{ $cli->direccion }}" data-rfc="{{ $cli->rfc }}" data-convenio="{{ $cli->convenio }}">{{ $cli->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-lg-12">
                                    <div class="card card-custom gutter-b">
                                        <div class="card-header">
                                            <h3 class="card-title">Datos del proveedor</h3>
                                        </div>
                                        <div class="card-body">
                                            <div class="row form-group info_proveedor">
                                                <div class="col-md-4">
                                                    <label>Contacto</label><br>
                                                    <span id="contacto_proveedor"></span>
                                                </div>
                                                <div class="col-md-4">
                                                    <label>Telefono</label><br>
                                                    <span id="telefono_proveedor"></span>
                                                </div>
                                                <div class="col-md-4">
                                                    <label>Correo electrónico</label><br>
                                                    <span id="correo_proveedor"></span>
                                                </div>
                                            </div> 
                                            <div class="row form-group info_proveedor">
                                                <div class="col-md-4">
                                                    <label>RFC</label><br>
                                                    <p id="rfc_proveedor"></p>
                                                </div>
                                                <div class="col-md-8">
                                                    <label>Dirección</label><br>
                                                    <p id="direccion_proveedor"></p>
                                                </div>
                                            </div>
                                            <div class="row form-group info_proveedor">
                                                <div class="col-md-12">
                                                    <label>Convenio</label><br>
                                                    <p id="convenio_proveedor"></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> 
                        </div>

                    </div>


                    <div class="row mt-4">
                        <div class="col-lg-12">
                            <!--begin::Card-->
                            <div class="card card-custom gutter-b">
                                <div class="card-header">
                                    <h3 class="card-title">Partidas</h3>
                                </div>
                                <!--begin::Form-->
                                    <div class="card-body">
{{-- 
                                        <div class="col-lg-12">
                                            <span style="font-weight: bold;">Por medio de la presente me permito solicitarle formalmente el suministro de los vehículos que a continuación describo:</span>
                                        </div> --}}
                                        <div class="col-lg-12">
                                            <table class="table table-hover mb-6 table-responsive-sm" id="tblDocumentos">
                                                <thead>
                                                    <tr>
                                                        <th>Cantidad</th>
                                                        <th>Tipo</th>
                                                        <th>Cilindros</th>
                                                        <th>Transmisión</th>
                                                        <th>Motor</th>
                                                        <th>Observaciones</th>
                                                        <th>Ingresa una cantidad</th>
                                                    </tr>
                                                </thead>
                                                <tbody id='tbodyDocumentos'>
                                                    @php $cons = 0; @endphp
                                                    @foreach($partidas as $documento)
                                                        <tr id="trDocumento{{ $documento->id }}">
                                                            <td>{{ $documento->cantidad_orden }}</td>
                                                            <td>{{ $documento->segmento->segmentoTipoVehiculo->tipo_vehiculo }}</td>
                                                            <td>{{ $documento->segmento->segmentoTransmision->transmision }}</td>
                                                            <td>{{ $documento->segmento->segmentoNoCilindro->no_cilindro }} cilindros</td>
                                                            <td>{{ $documento->segmento->segmentoMotor->motor }}</td> 
                                                            <td>{{ $documento->observaciones }}</td>
                                                            <td>
                                                                <div class="">
                                                                    <input type="hidden" name="id_partida[]" value="{{ $documento->id }}">
                                                                    <input type="number" data-cons="{{ $cons }}" data-limit="{{ $documento->cantidad_orden }}" class="form-control limit-num" name="cantidad[]" />
                                                                    @php $cons = $cons+1; @endphp
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                <!--end::Form-->
                            </div>
                            <!--end::Card-->
                        </div>
                    </div>

                    <div class="card card-custom gutter-b">
                        <div class="card-header">
                            <div class="card-title">
                                <h3 class="card-label">
                                    Unidades seleccionadas por operaciones
                                </h3>
                            </div>
                        </div>
                        <div class="card-body">

                            <table class="table table-hover table-checkable table-responsive" id="kdatatable_unidades_req">
                                <thead>
                                    <tr>
                                        <th>Folio</th>
                                        <th>Ubicación</th>
                                        <th>Marca</th>
                                        <th>Modelo</th>
                                        <th>Serie</th>
                                        <th>Placa</th>
                                        <th>Año</th>
                                        <th>Segmento</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach($unidades_req as $unid)
                                        <tr>
                                            <td>{{ $unid->folio }}</td>
                                            <td>{{ $unid->ubicacion }}</td>
                                            <td>{{ $unid->nombre_marca }}</td>
                                            <td>{{ $unid->nombre_modelo }}</td>
                                            <td>{{ $unid->no_serie }}</td>
                                            <td>{{ $unid->placa }}</td>
                                            <td>{{ $unid->unidad_year }}</td>
                                            <td>{{ $unid->requisicionPartida->segmento->segmentoTipoVehiculo->tipo_vehiculo  }}, {{ $unid->requisicionPartida->segmento->segmentoTransmision->transmision}}, {{ $unid->requisicionPartida->segmento->segmentoNoCilindro->no_cilindro}} cilindros, {{ $unid->requisicionPartida->segmento->segmentoMotor->motor}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>

                            </table>
                        </div>
                    </div>

<input type="hidden" id="datatable_i18n" value="{{ asset('/js/datatables/i18n/es-mx.json') }}">


                    <div class="row mt-4">
                        <div class="col-lg-12">
                            <div class="card card-custom gutter-b">
                                <div class="card-header">
                                    <h3 class="card-title">Datos de facturación</h3>
                                </div>
                                    <div class="card-body">
                                        <div class="row form-group">
                                            <div class="col-lg-6">
                                                <label>Monto del pedido</label>
                                                <input type="text" class="form-control" name="precio_unitario" id="precio_unitario" required/>
                                            </div>
                                            <div class="col-lg-6">
                                                <label>Forma de pago</label>
                                                <select class="form-control" name="forma_pago" id="forma_pago" required>
                                                    <option value="">Selecciona un opción</option>
                                                    @foreach($forma_pago as $cli)
                                                        <option value="{{ $cli->id }}">{{ $cli->forma_pago }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
{{--                                             <div class="col-lg-6">
                                                <label>Método de pago</label>
                                                <select class="form-control" name="metodo_pago" id="metodo_pago" required>
                                                    <option value="">Selecciona un opción</option>
                                                    @foreach($metodo_pago as $cli)
                                                        <option value="{{ $cli->id }}">{{ $cli->clave }} - {{ $cli->metodo_pago }}</option>
                                                    @endforeach
                                                </select>
                                            </div> --}}
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-lg-6">
                                                <label>Uso del CFDI</label>
                                                <select class="form-control" name="cfdi" id="cfdi" required>
                                                    <option value="">Selecciona un opción</option>
                                                    @foreach($cfdis as $cfdi)
                                                        <option value="{{ $cfdi->uso_cfdi }}">{{ $cfdi->uso_cfdi }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>


                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-lg-6">
                                @if($op == 2)
                                    <button type="button"  id="btnGuardar" class="btn btn-success"><i class="la la-plus"></i>Guardar</button>
                                @else
                                    <a href=""  class="btn btn-primary">Continuar</a>
                                @endif
                                <a href="{{ route('finanzas.catalogorequisicion') }}"  class="btn btn-secondary"><i class="la la-times"></i>Cancelar</a>
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

