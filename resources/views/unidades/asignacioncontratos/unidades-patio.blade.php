@extends('layouts.app')
@section('title')
    Catálogo de unidades en patio
@endsection

@push('scripts')
  <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
<script src="{{ asset('js/unidades/AsignacionEditarUnidades.js') }}"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
  <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<script type="text/javascript">

 // $('.fecha_asignacion').datepicker({ format: 'yyyy-dd-mm' });

var date = $('.fecha_asignacion').datepicker({ dateFormat: 'yy-mm-dd' }).val();

</script>
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
                                <h3 class="card-label">Inventario de unidades</h3>
                            </div>
                            <div class="card-toolbar">

                                <!--begin::Button-->
                                <a href="{{ route('asignarunidad.unidadescontrato', $licitacion) }}" class="btn btn-light-primary font-weight-bolder mr-3 ml-3">
                                    <i class="la la-arrow-left"></i> Regresar</a>
                                <!--end::Button-->

                            </div>
                        </div>
                        <div class="card-body">
                            <!--begin: Datatable-->
                            <form action="{{ route('asignarunidad.asignacionunidadescontrato') }}" method="post" id="submit_requisicion_unidad" enctype="multipart/form-data">
                              @csrf
                                <input type="hidden" name="licitacion" value="{{ $licitacion }}">
                                <input type="hidden" name="patio" value="{{ $patio }}">
                                        <table class="table table-hover table-checkable table-responsive" id="kdatatable_uni_cont">
                                            <thead>
                                            <tr>
                                                <th>Folio</th>
                                                <th>Ubicación</th>
                                                <th>Marca</th>
                                                <th>Modelo</th>
                                                <th>Serie</th>
                                                <th>Placa</th>
                                                <th>Año</th>
                                                <th>Unidad</th>
                                                <th>Inventario entrega</th>
                                                <th>Segmento</th>
                                                <th>Tipo de asignación</th>
                                                <th>Fecha de asignación</th>
                                                <th>Cliente</th>
                                                {{-- <th>Acción</th> --}}
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
                                                    @if($unid->op_unidad_nueva == 0)
                                                      <span class="label font-weight-bold  label-outline label-inline" style="color: green; border: 1px solid green !important">Nueva</span>
                                                    @else
                                                      <span class="label font-weight-bold  label-outline label-inline" style="color: orange; border: 1px solid orange !important">Seminueva</span>
                                                    @endif
                                                  </td>
                                                  <td class="text-center">
                                                    @if($unid->inv_entrega != 0)
                                                      <a href="{{ route('asignarunidad.inventarioentrega',[$licitacion, $patio, $unid->id]) }}" class="btn btn-clean btn-icon btn-outline-warning mt-1"  data-toggle="tooltip" data-theme="dark" title="Inventrario de entrega" ><i class="flaticon-notepad"></i></a>
                                                    @else
                                                       <a href="{{ route('asignarunidad.inventarioentrega',[$licitacion, $patio, $unid->id]) }}" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon"  data-toggle="tooltip" data-theme="dark" title="Inventrario de entrega" ><i class="flaticon-notepad"></i></a>
                                                    @endif
                                                  </td>
                                                  {{-- @php $inv_entrega = 1; @endphp --}}

                                                  @if($unid->inv_entrega != 0 )
                                                    <td>
                                                        <select class="form-control" name="segmento[]"  style="width: 220px;">
                                                              <option value="">Selecciona un opción</option>
                                                              @foreach($segmento as $asi)
                                                                  <option value="{{ $asi->id }}">{{ $asi->tipo_vehiculo}}, {{ $asi->motor}}, {{ $asi->transmision}}</option>
                                                              @endforeach
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <select class="form-control" name="asignacion[]"  style="width: 220px;">
                                                              <option value="">Selecciona un opción</option>
                                                              @foreach($tipoasignacion as $asi)
                                                                  <option value="{{ $asi->id }}">{{ $asi->tipo_asignacion}}</option>
                                                              @endforeach
                                                        </select>
                                                    </td>
                                                    <td>
                                                      <input type="text" name="fecha_asignacion[]" readonly value="" class="form-control fecha_asignacion" style="width: 120px;"/>
                                                    </td>
                                                    <td>
                                                        <select class="form-control" name="cliente[]"  style="width: 220px;">
                                                              <option value="">Selecciona un opción</option>
                                                              @foreach($usuarios_asignados as $asi)
                                                                  <option value="{{ $asi->cliente_id }}">{{ $asi->user->name }}</option>
                                                              @endforeach
                                                        </select>
                                                    </td>
                                                  @else
                                                    <td>
                                                      <input type="hidden" name="segmento[]" value="">
                                                        <select class="form-control" name=""  style="width: 220px;" disabled>
                                                              <option value="null" selected>Selecciona un opción</option>
                                                              @foreach($segmento as $asi)
                                                                  <option value="{{ $asi->id }}">{{ $asi->tipo_vehiculo}}, {{ $asi->motor}}, {{ $asi->transmision}}</option>
                                                              @endforeach
                                                        </select>
                                                    </td>
                                                    <td>
                                                      <input type="hidden" name="asignacion[]" value="">
                                                        <select class="form-control" name=""  style="width: 220px;" disabled>
                                                              <option value="">Selecciona un opción</option>
                                                              @foreach($tipoasignacion as $asi)
                                                                  <option value="{{ $asi->id }}">{{ $asi->tipo_asignacion}}</option>
                                                              @endforeach
                                                        </select>
                                                    </td>
                                                    <td>
                                                      <input type="hidden" name="fecha_asignacion[]">
                                                      <input type="text" name="" value="" disabled class="form-control fecha_asignacion" style="width: 120px;"/>
                                                    </td>
                                                    <td>
                                                      <input type="hidden" name="cliente[]" value="">
                                                        <select class="form-control" name="" disabled style="width: 220px;">
                                                              <option value="">Selecciona un opción</option>
                                                              @foreach($usuarios_asignados as $asi)
                                                                  <option value="{{ $asi->cliente_id }}">{{ $asi->user->name }}</option>
                                                              @endforeach
                                                        </select>
                                                    </td>
                                                  @endif
                                                  <td>
                                                      <input type="hidden" name="unidad[]"  value="{{ $unid->id }}" >
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
                                                <th>Unidad</th>
                                                <th>Inventario entrega</th>
                                                <th>Segmento</th>
                                                <th>Tipo de asignación</th>
                                                <th>Fecha de asignación</th>
                                                <th>Cliente</th>
                                                {{-- <th>Acción</th> --}}
                                            </tr>
                                            </tfoot>

                                        </table>
                                        <button type="submit"  id="btnGuardarUnidad" class="btn btn-primary mr-2">Guardar unidades</button>
                              </form>
                            <!--end: Datatable-->

                            <input type="hidden" id="datatable_i18n" value="{{ asset('/js/datatables/i18n/es-mx.json') }}">

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
  
  <form method="post" id="emisor_activar_form" action="{{ route('emisores.activaremisor') }}" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="id" id="id_act_emisor" value="">
  </form>

@endsection