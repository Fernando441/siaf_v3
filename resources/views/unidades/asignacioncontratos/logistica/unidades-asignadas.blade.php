@extends('layouts.app')

@section('title')
   Inventario de unidades asignadas
@endsection

@push('scripts')
  <script src="{{ asset('js/catalogos/agencias/CatalogoAgencias.js') }}"></script>
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
                                <h3 class="card-label">Inventario de unidades asignadas</h3>
                            </div>
                            <div class="card-toolbar">

                                <!--begin::Button-->
                                  <a href="{{ route('asignarunidad.asignacioncontratos') }}" class="btn btn-light-primary font-weight-bolder mr-3 ml-3"></i>Regresar</a>

                                <!--end::Button-->

                            </div>
                        </div>
                        <div class="card-body">
                            <!--begin: Datatable-->
                            <table class="table table-hover table-checkable" id="kdatatable_agencias_inactivas">
                                            <thead>
                                            <tr>
                                                <th>Nombre asignación</th>
                                                <th>Serie</th>
                                                <th>Marca</th>
                                                <th>Modelo</th>
                                                <th>No. Economico</th>
                                                <th>Placa</th>
                                                <th>Año</th>
                                                <th>Estatus</th>
                                                <th>Fecha de asignación</th>
                                                <th>Asignado por:</th>
                                                <th>Asignado de:</th>
                                            </tr>
                                            </thead>

                                            <tbody>
                                              @foreach($unidades_seleccionadas as $unid)
                                                <tr>
                                                  <td>{{ $unid->nombre_asignacion }}</td>
                                                  <td>{{ $unid->no_serie }}</td>
                                                  <td>{{ $unid->nombre_marca }}</td>
                                                  <td>{{ $unid->nombre_modelo }}</td>
                                                  <td>{{ $unid->numero_economico }}</td>
                                                  <td>{{ $unid->placa }}</td>
                                                  <td>{{ $unid->unidad_year }}</td>
                                                  <td>
                                                    @if($unid->op_unidad_nueva == 0)
                                                      <span class="label font-weight-bold  label-outline label-inline" style="color: green; border: 1px solid green !important">Nueva</span>
                                                    @else
                                                      <span class="label font-weight-bold  label-outline label-inline" style="color: orange; border: 1px solid orange !important">Seminueva</span>
                                                    @endif
                                                  </td>
                                                  <td> {{ $unid->fecha_asignacion }}  </td>
                                                  <td> {{ $unid->name }}   </td>
                                                  <td>
                                                    @if($unid->op_asignacion == 0)
                                                      Patio: {{ $unid->ubicacionUnidad->ubicacion }} {{ $unid->ubicacionUnidad->codigo }}
                                                    @else
                                                      Requisicion: {{ $unid->folioreq }}
                                                    @endif
                                                  </td>

                                                </tr>

                                              @endforeach
                                            </tbody>

                                            <tfoot>
                                            <tr>
                                                <th>Nombre asignación</th>
                                                <th>Serie</th>
                                                
                                                <th>Marca</th>
                                                <th>Modelo</th>
                                                <th>No. Economico</th>
                                                <th>Placa</th>
                                                <th>Año</th>
                                                <th>Estatus</th>
                                                <th>Fecha de asignación</th>
                                                <th>Asignado por:</th>
                                                <th>Asignado de:</th>
                                            </tr>
                                            </tfoot>

                            </table>
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

 <form method="post" id="agencia_activar_form" action="{{ route('agencia.activaragencia') }}" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="id" id="id_act_agencia" value="">
  </form> 


@endsection