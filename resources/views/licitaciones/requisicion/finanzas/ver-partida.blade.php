@extends('layouts.app')
@section('title')
    Ver información a la partida
@endsection
@push('scripts')
@endpush
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <!--begin::Card-->
            <div class="card card-custom gutter-b">
                <div class="card-header">
                    <h3 class="card-title">Ver información a la partida</h3>
                </div>
                    <input type="hidden" name="requisicion_id" id="requisicion_id" value="{{ $info_partida->requisicion_id }}">
                    <input type="hidden" name="partida_id" id="partida_id" value="{{ $info_partida->id }}">
                    <input type="hidden" id="datatable_i18n" value="{{ asset('/js/datatables/i18n/es-mx.json') }}">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="row form-group">
                                    <div class="col-lg-3">
                                        <label for="folio">Folio de la requisición:</label>
                                        <p>{{ $info_partida->requisicion->folio }}</p>
                                    </div>
                                    <div class="col-lg-3 text-capitalize">
                                        <label for="tipo_vehiculo">Descripción:</label>
                                        <p>
                                            {{ $info_partida->segmento->segmentoTipoVehiculo->tipo_vehiculo }},
                                            {{ $info_partida->segmento->segmentoNoCilindro->no_cilindro }} cilindros,
                                            {{ $info_partida->segmento->segmentoTransmision->transmision }},
                                            {{ $info_partida->segmento->segmentoMotor->motor }}
                                        </p>
                                    </div>
                                    <div class="col-lg-3">
                                        @if($info_partida->op_cantidades == 0)
                                            <label for="cantidad">Cantidades:</label>
                                            <p>Mínima: <b>{{ $info_partida->cantidad }}</b></p>
                                            <p>Mánima: <b>{{ $info_partida->cantidad_maxima }}</b></p>
                                        @else
                                            <label for="cantidad">Cantidad:</label>
                                            <p><b>{{ $info_partida->cantidad }}</b></p>
                                        @endif
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="observaciones">Observaciones:</label>
                                        <p>{{ $info_partida->observaciones }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!--begin::tabs-->
                        <ul class="nav nav-tabs nav-tabs-line">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#kt_tab_pane_1">Equipamiento</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#kt_tab_pane_2">Aseguramiento</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#kt_tab_pane_3">Emplacamiento</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#kt_tab_pane_4">Lugar de entrega del
                                    vehículo</a>
                            </li>
                        </ul>
                        <div class="tab-content mt-5" id="myTabContent">
                            {{-- Equipamiento --}}
                            <div class="tab-pane fade show active mt-10" id="kt_tab_pane_1" role="tabpanel"
                                aria-labelledby="kt_tab_pane_2">

                                <div class="row form-group">
                                    <div class="col-lg-12" id="tblArchivos">
                                        <h4 class="card-label">Equipamiento</h4>
                                        <table class='table table-bordered table-hover' id='tblRegistros'>
                                            <thead>
                                                <tr>
                                                    <th>Cantidad</th>
                                                    <th>Grupo</th>
                                                    <th>Documento</th>
                                                    <th>Observaciones</th>
                                                </tr>
                                            </thead>
                                            <tbody id='tbodyDocumentos'>
                                                @foreach ($equipamientos as $equipamiento)
                                                    <tr id="trRegistro{{ $equipamiento->id }}">
                                                        <td>
                                                            <p>{{ $equipamiento->cantidad }}</p>
                                                        </td>
                                                        <td>
                                                            <p>{{ $equipamiento->requisicionGrupo->descripcion }}
                                                            </p>
                                                        </td>
                                                            @if($equipamiento->op_documento == 1)
                                                                <td>
                                                                    <a href="{{ route('archivo.archivorequisicionequipamiento', ['id'=>$equipamiento->id]) }}" class="link-primary" target="_blank"> {{ $equipamiento->archivo_equipamiento }} </a>
                                                                </td>
                                                            @else
                                                                <td>
                                                                    <a href="{{ route('archivo.archivorequisicionequipamientosinconcurso', ['id'=>$equipamiento->id]) }}" class="link-primary" target="_blank"> {{ $equipamiento->archivo_equipamiento }} </a>
                                                                </td>
                                                            @endif
                                                        <td>
                                                            <p>{{ $equipamiento->observaciones }}</p>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>
                            {{-- /Equipamiento --}}
                            {{-- Aseguramiento --}}
                            <div class="tab-pane fade mt-10" id="kt_tab_pane_2" role="tabpanel"
                                aria-labelledby="kt_tab_pane_2">
                                
                                <div class="row form-group">
                                    <div class="col-lg-12" id="tblArchivos2">
                                        <h4 class="card-label">Aseguramiento</h4>
                                        <table class='table table-bordered table-hover' id='tblRegistros2'>
                                            <thead>
                                                <tr>
                                                    <th>Cantidad</th>
                                                    <th>Tipo de transporte</th>
                                                    <th>Cobertura</th>
                                                    <th>Vigencia inicial</th>
                                                    <th>Vigencia final</th>
                                                    <th>Observaciones</th>
                                                </tr>
                                            </thead>
                                            <tbody id='tbodyDocumentos2'>
                                                @foreach ($aseguramientos as $aseguramiento)
                                                    <tr id="trRegistroAseguramiento{{ $aseguramiento->id }}">
                                                        <td>
                                                            <p>{{ $aseguramiento->cantidad }}</p>
                                                        </td>
                                                        <td>
                                                            <p>{{ $aseguramiento->requisicionTipoTransporte->descripcion }}</p>
                                                        </td>                                                            
                                                            @if($aseguramiento->op_documento_aseg == 1)
                                                                <td>
                                                                    <a href="{{ route('archivo.archivorequisicionaseguramiento', ['id'=>$aseguramiento->id]) }}" class="link-primary" target="_blank"> {{ $aseguramiento->doc_aseguramiento }} </a>
                                                                </td>
                                                            @else
                                                                <td>
                                                                   <a href="{{ route('archivo.archivorequisicionaseguramientosinconcurso', ['id'=>$equipamiento->id]) }}" class="link-primary" target="_blank"> {{ $equipamiento->archivo_equipamiento }} </a>
                                                                </td>
                                                            @endif
                                                        <td>
                                                            <p>{{ $aseguramiento->vigencia }}</p>
                                                        </td>
                                                        <td>
                                                            <p>{{ $aseguramiento->vigencia_fin }}</p>
                                                        </td>
                                                        <td>
                                                            <p>{{ $aseguramiento->observaciones }}</p>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>
                            {{-- /Aseguramiento --}}
                            {{-- Emplacamiento --}}
                            <div class="tab-pane fade mt-10" id="kt_tab_pane_3" role="tabpanel"
                                aria-labelledby="kt_tab_pane_3">
                                
                                <div class="row form-group">
                                    <div class="col-lg-12" id="tblArchivos3">
                                        <h4 class="card-label">Emplacamiento</h4>
                                        <table class='table table-bordered table-hover' id='tblRegistros3'>
                                            <thead>
                                                <tr>
                                                    <th>Cantidad</th>
                                                    <th>Entidad federativa</th>
                                                    <th>Tipo de placas</th>
                                                </tr>
                                            </thead>
                                            <tbody id='tbodyDocumentos3'>
                                                @foreach ($emplacamientos as $emplacamiento)
                                                    <tr id="trRegistroEmplacamiento{{ $emplacamiento->id }}">
                                                        <td>
                                                            <p>{{ $emplacamiento->cantidad }}</p>
                                                        </td>
                                                        <td>
                                                            <p>{{ $emplacamiento->requisicionEntidadFederativa->descripcion }}
                                                        </td>
                                                        <td>
                                                            <p>{{ $emplacamiento->requisicionTipoPlacas->descripcion }}</p>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            {{-- /Emplacamiento --}}
                            {{-- Lugar de entrega del vehículo --}}
                            <div class="tab-pane fade mt-10" id="kt_tab_pane_4" role="tabpanel"
                                aria-labelledby="kt_tab_pane_4">
                                
                                <div class="row form-group">
                                    <div class="col-lg-12" id="tblArchivos4">
                                        <h4 class="card-label">Lugar de entrega del vehículo</h4>
                                        <table class='table table-bordered table-hover' id='tblRegistros4'>
                                            <thead>
                                                <tr>
                                                    <th>Cantidad</th>
                                                    <th>Fecha de entrega</th>
                                                    <th>Entidad federativa</th>
                                                    <th>Municipio</th>
                                                    <th>Localidad</th>
                                                    <th>Combustible</th>
                                                    <th>Observaciones</th>
                                                </tr>
                                            </thead>
                                            <tbody id='tbodyDocumentos4'>
                                                @foreach ($lugares_entrega as $lugarEntrega)
                                                    <tr id="trRegistroLugarEntrega{{ $lugarEntrega->id }}">
                                                        <td>
                                                            <p>{{ $lugarEntrega->cantidad }}</p>
                                                        </td>
                                                        <td>
                                                            <p>{{ $lugarEntrega->fecha_entrega }}</p>
                                                        </td>
                                                        <td>
                                                            <p>{{ $lugarEntrega->requisicionEntidadFederativa->descripcion }}
                                                        </td>
                                                        <td>
                                                            <p>{{ $lugarEntrega->municipio }}</p>
                                                        </td>
                                                        <td>
                                                            <p>{{ $lugarEntrega->localidad }}</p>
                                                        </td>
                                                        <td>
                                                            <p>{{ $lugarEntrega->requisicionCombustible->descripcion }}</p>
                                                        </td>
                                                        <td>
                                                            <p>{{ $lugarEntrega->observaciones }}</p>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            {{-- /Lugar de entrega del vehículo --}}

                        </div>
                        <!--end::tabs-->

                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-lg-6">
                                <a href="{{ route('finanzas.verrequisicion', $requisicion) }}"
                                    class="btn btn-secondary"><i class="la la-arrow-left"></i>Regresar</a>
                            </div>

                        </div>
                    </div>
            </div>
            <!--end::Card-->
        </div>
    </div>
    <!--end::Card-->
@endsection
