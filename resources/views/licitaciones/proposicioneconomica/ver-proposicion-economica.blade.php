@extends('layouts.app')
@push('scripts')
    <script src="{{ asset('js/licitaciones/proposicioneconomica/EditarProposicion.js') }}"></script> 
@endpush
@section('title')
    Ver propuesta económica
@endsection
@section('content')

    <!--begin::Card-->
    <div class="row">
        <div class="col-lg-12">
            <!--begin::Card-->
            <div class="card card-custom gutter-b">
                <div class="card-header">
                    <h3 class="card-title">Ver propuesta económica</h3>
                </div>
                <!--begin::Form-->

                    <div class="card-body">

                        <div class="row">
                            @foreach($licitacion as $lic)
                                <div class="col-lg-4 col-sm-6 form-group">
                                    <label>Folio de concurso</label>
                                    <p>{{ $lic->folio }}</p>
                                </div>

                                <div class="col-lg-4 col-sm-6 form-group">
                                    <label>No. Concurso</label>
                                    <p>{{ $lic->no_licitacion }}</p>
                                </div>


                                <div class="col-lg-4 col-sm-6 form-group">
                                    <label>Titulo del servicio</label>
                                    <p>{{ $lic->titulo_servicio }}</p>
                                </div>

                                <div class="col-lg-4 col-sm-6 form-group">
                                    <label>Fecha y firma de formalización del contrato</label>
                                    <p>{{ date('d/m/Y', strtotime($lic->firma_entrega))}}</p>
                                </div>

                                <div class="col-lg-4 col-sm-6 form-group">
                                    <label>Cliente</label>
                                    <p>{{ $lic->razon_social }}</p>
                                </div>
                                <input type="hidden" name="licitacion_id" value="{{ $lic->id }}">
                            @endforeach
                        </div>

                        <table class="table table-hover table-checkable" id="">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Tipo de vehículo</th>
                                    <th>Carrocería</th>
                                    <th>Motor</th>
                                    <th>Transmisión</th>
                                    <th>Cantidad</th>
                                    <th>Precio Unitario</th>
                                    <th>Total</th>
                                </tr>
                            </thead>

                            <tbody>
                                @php $precio_unitario = 0; @endphp
                                @foreach($segmento as $unid)
                                    <tr>
                                        <td>{{ $unid->id }}</td>
                                        <td>{{ $unid->tipo_vehiculo }}</td>
                                        <td>{{ $unid->carroceria }}</td>
                                        <td>{{ $unid->motor }}</td>
                                        <td>{{ $unid->transmision }}</td>
                                        <td class="text-center">
                                            <label>{{ $unid->cantidad }}</label>
                                        </td>
                                        <td class="text-center">
                                            <label>${{ number_format($unid->precio_unitario,2,'.',',') }}</label>
                                        </td>
                                        @php 
                                            $total = $unid->cantidad * $unid->precio_unitario; 
                                            $precio_unitario = $precio_unitario + $total;
                                            $iva = $precio_unitario * 0.16;
                                            $total_monto = $precio_unitario + $iva;
                                        @endphp
                                        <td>
                                            <label id="total">${{ number_format($total,2,'.',',') }}</label>
                                        </td>
                                    </tr>

                                @endforeach
                            </tbody>

                            <tbody>

                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>
                                            <h4>Subtotal</h4>
                                        </td>
                                        <td>
                                            <p>${{ number_format($precio_unitario,2,'.',',') }}</p>
                                        </td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>
                                           <h4>Iva</h4> 
                                        </td>
                                        <td>
                                            <p>${{ number_format($iva,2,'.',',') }}</p>
                                        </td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>
                                            <h4>Total</h4>
                                        </td>
                                        <td>
                                            <p>{{ number_format($precio_unitario,2,'.',',') }}</p>
                                        </td>
                                        <td></td>
                                    </tr>

                            </tbody>

                        </table>
                            <!--end: Datatable-->

                        <input type="hidden" id="datatable_i18n" value="{{ asset('/js/datatables/i18n/es-mx.json') }}">

                        @foreach($proposicioneconomica as $pro)
                            <div class="form-group mt-4">
                                <label for="observaciones">Observaciones</label>
                                <p>{{ $pro->observaciones }}</p>
                            </div>
                            <input type="hidden" name="licitacion_id" value="{{ $pro->licitacion_id }}">
                        @endforeach
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-lg-6">
                                <a href="{{ route('proposicioneconomica.catalogoproposicioneconomica') }}"  class="btn btn-secondary">Cancelar</a>
                            </div>
                        </div>
                    </div>

            </div>
            <!--end::Card-->
        </div>
    </div>
    <!--end::Card-->


@endsection