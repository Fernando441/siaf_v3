@extends('layouts.app')

@section('title')
    Catálogo de unidades en patio {{ $ubi_patio->ubicacion }}
@endsection

@push('scripts')
    <script src="{{ asset('js/catalogos/CatalogoUbicaciones.js') }}"></script>
@endpush

@section('content')
    <div class="d-flex flex-row">

    <!--begin::List-->
    <div class="flex-row-fluid">
        <div class="d-flex flex-column flex-grow-1">

            <!--begin::Row-->
            <div class="row">
                <div class="col-xl-12">

                <!--begin::Card-->
                    <div class="card card-custom">
                        <div class="card-header">
                            <div class="card-title">
                      <span class="card-icon">
                        <i class="flaticon2-file text-primary"></i>
                      </span>
                                <h3 class="card-label">Catálogo de unidades en patio {{ $ubi_patio->ubicacion }}</h3>
                            </div>
                            <div class="card-toolbar">

                                <!--begin::Button-->
                                <a href="{{ route('reqoperaciones.asignacionunidades', $requisicion) }}" class="btn btn-light-primary font-weight-bolder mr-3 ml-3">
                                  Regresar</a>
                                <!--end::Button-->

                            </div>
                        </div>
                        <div class="card-body">
                            <div class="card card-custom gutter-b">
                                <div class="card-header">
                                    <div class="card-title">
                                        <h3 class="card-label">
                                            Detalle de la requisición
                                        </h3>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <table class="table table-hover mb-6 table-responsive-sm" id="tblDocumentos">
                                        <thead>
                                            <tr>
                                                <th>Descripción</th>
                                                <th>Cantidad</th>
                                                <th>Observaciones</th>
                                            </tr>
                                        </thead>
                                        <tbody id='tbodyDocumentos'>
                                            @foreach ($partidas as $partida)
                                                <tr id="trDocumento{{ $partida->id }}">
                                                    <td>{{ $partida->segmento->segmentoTipoVehiculo->tipo_vehiculo }},
                                                        {{ $partida->segmento->segmentoNoCilindro->no_cilindro }} cilindros,
                                                        {{ $partida->segmento->segmentoTransmision->transmision }},
                                                        {{ $partida->segmento->segmentoMotor->motor }}</td>
                                                    <td>{{ $partida->cantidad }}</td>
                                                    <td>{{ $partida->observaciones }}</td>
                                                    <td>
                                                        
                                                    </td>

                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="card card-custom gutter-b">
                                <div class="card-header">
                                    <div class="card-title">
                                        <h3 class="card-label">
                                            Unidades disponibles
                                        </h3>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('reqoperaciones.asignarunidadrequisicion') }}" method="post" id="submit_requisicion_unidad"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="id_requisicion" value="{{ $requisicion }}">
                                        <!--begin: Datatable-->
                                        <table class="table table-hover table-checkable table-responsive" >
                                            <thead>
                                            <tr>
                                                <th>Folio</th>
                                                <th>Ubicación</th>
                                                <th>Marca</th>
                                                <th>Modelo</th>
                                                <th>Serie</th>
                                                <th>Placa</th>
                                                <th>Año</th>
                                                <th>Opción</th>
                                                <th>Segmento</th>
                                            </tr>
                                            </thead>

                                            <tbody>
                                              @foreach($ubicacion_data as $unid)
                                                <tr>
                                                  <td>{{ $unid->folio }}</td>
                                                  <td>{{ $unid->ubicacion }}</td>
                                                  <td>{{ $unid->nombre_marca }}</td>
                                                  <td>{{ $unid->nombre_modelo }}</td>
                                                  <td>{{ $unid->no_serie }}</td>
                                                  <td>{{ $unid->placa }}</td>
                                                  <td>{{ $unid->unidad_year }}</td>
                                                  <td>
                                                        @if($req->visto_bueno_operaciones == 1)
                                                            <div class="checkbox-inline">
                                                                <label class="checkbox">
                                                                    <input type="checkbox" name="unidad[]" value="{{ $unid->id }}" />
                                                                    <span></span>
                                                                </label>
                                                            </div>
                                                        @else
                                                        @endif
                                                  </td>
                                                  <td>
                                                    @if($req->visto_bueno_operaciones == 1)
                                                        <select class="form-control" name="segmento[]"  style="width: 220px;">
                                                            <option value="">Selecciona un opción</option>
                                                            @foreach($partidas as $partida)
                                                                <option value="{{ $partida->id }}">{{ $partida->segmento->segmentoTipoVehiculo->tipo_vehiculo }},
                                                                {{ $partida->segmento->segmentoNoCilindro->no_cilindro }} cilindros,
                                                                {{ $partida->segmento->segmentoTransmision->transmision }},
                                                                {{ $partida->segmento->segmentoMotor->motor }}</option>
                                                            @endforeach
                                                        </select>
                                                    @else
                                                    @endif

                                                  </td>
                                                </tr>
                                              @endforeach
                                            </tbody>

                                            <tfoot>
                                            <tr>
                                                <th>Folio</th>
                                                <th>Ubicación</th>
                                                <th>Marca</th>
                                                <th>Modelo</th>
                                                <th>Serie</th>
                                                <th>Placa</th>
                                                <th>Año</th>
                                                <th>Opción</th>
                                                <th>Segmento</th>
                                            </tr>
                                            </tfoot>

                                        </table>
                                        <!--end: Datatable-->
                                        @if($req->visto_bueno_operaciones == 1)
                                            <div class="row">
                                                <div class="col-lg-8"></div>
                                                <div class="col-lg-4 text-center">
                                                    <button type="submit"  id="btnGuardarUnidad" class="btn btn-primary mr-2">Guardar unidades</button>
                                                </div>
                                            </div>
                                        @else

                                        @endif

                                    </form>
                                    <input type="hidden" id="datatable_i18n" value="{{ asset('/js/datatables/i18n/es-mx.json') }}">
                                </div>
                                <div class="card-footer">

                                </div>

                            </div>


                        </div>
                    </div>
                    <!--end::Card-->
                    <!--end::Card-->
                </div>

            </div>
            <!--end::Row-->
        </div>
    </div>
    <!--end::List-->
</div>

<form method="post" id="ubicacion_act_form" action="{{ route('ubicacion.activarubicacion') }}" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="id" id="id_delete" value="">
</form> 

@endsection