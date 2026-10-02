@extends('layouts.app')

@section('title')
    Asignación
@endsection

@push('scripts')
  <script src="{{ asset('js/unidades/QuitarUnidadesAsignacion.js') }}"></script>

@endpush

@section('content')

  <style type="text/css">
    .checkbox>span{
      background-color: #c9c9c9 !important;
    }

    .checkbox > input:checked ~ span {
      background-color: #669933 !important;;
    }
  </style>

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
                                <h3 class="card-label">Asignación</h3>
                            </div>
                            <div class="card-toolbar">

                                <!--begin::Button-->
                                <a href="{{ route('asignarunidad.asignacioncontratos') }}" class="btn btn-light-primary font-weight-bolder mr-3 ml-3"><i class="la la-arrow-left"></i>
                                  Regresar</a>
                                <!--end::Button-->

                            </div>
                        </div>
                        <div class="card-body">


                          <div class="card card-custom">
                            <div class="card-body">
                              <div class="row">
                                <div class="col-lg-3">
                                  <label><b>Nombre de la asignación</b></label>
                                  <p>{{ $asignacionLogistica->nombre_asignacion }}</p>
                                </div>
                                <div class="col-lg-3">
                                  <label><b>Dirección</b></label>
                                  <p>{{ $asignacionLogistica->direccion }}</p>
                                </div>
                                <div class="col-lg-3">
                                  <label><b>Subdirección</b></label>
                                  <p>{{ $asignacionLogistica->sub_direccion }}</p>
                                </div>
                                <div class="col-lg-3">
                                  <label> <b>Coordinación</b></label>
                                  <p>{{ $asignacionLogistica->coordinacion }}</p>
                                </div>
                              </div>

                              <div class="row">
                                <div class="col-lg-3">
                                  <label><b>Area</b></label>
                                  <p>{{ $asignacionLogistica->area }}</p>
                                </div>
                                <div class="col-lg-3">
                                  <label><b>Partida</b></label>
                                  <p>{{ $asignacionLogistica->partida }}</p>
                                </div>
                                <div class="col-lg-3">
                                  <label><b>Población</b></label>
                                  <p>{{ $asignacionLogistica->poblacion }}</p>
                                </div>
                                <div class="col-lg-3">
                                  <label> <b>Contacto</b></label>
                                  <p>{{ $asignacionLogistica->contacto }}</p>
                                </div>
                              </div>

                              <div class="row">
                                <div class="col-lg-3">
                                  <label><b>Estado</b></label>
                                  <p>{{ $asignacionLogistica->estado->estado_nombre }}</p>
                                </div>
                                <div class="col-lg-3">
                                  <label><b>Municipio y/o Alcaldía.</b></label>
                                  <p>{{ $asignacionLogistica->municipio->municipio_nombre }}</p>
                                </div>
                                <div class="col-lg-3">
                                  <label><b>Calle</b></label>
                                  <p>{{ $asignacionLogistica->calle }}</p>
                                </div>
                                <div class="col-lg-3">
                                  <label> <b>CP</b></label>
                                  <p>{{ $asignacionLogistica->cp }}</p>
                                </div>
                              </div>

                              <div class="row">
                                <div class="col-lg-12">
                                  <label> <b>Observaciones</b></label>
                                  <p>{{ $asignacionLogistica->observaciones }}</p>
                                </div>
                              </div>


                            </div>

                          </div>

                          <div class="row">
                            <div class="col-lg-12">
                                <a href="{{ route('asignarunidad.asignacionbusqueda', $id_asignacion) }}" class="btn btn-light-primary font-weight-bolder mr-3 ml-3">
                                  Asignar por busqueda <i class="la la-search"></i></a>
                            </div>
                          </div>

                          <ul class="nav nav-tabs nav-tabs-line mt-2">
                              <li class="nav-item">
                                  <a class="nav-link active" data-toggle="tab" href="#kt_tab_pane_1">Patios disponibles</a>
                              </li>
                              <li class="nav-item">
                                  <a class="nav-link" data-toggle="tab" href="#kt_tab_pane_3">Requisiciones</a>
                              </li>
                              <li class="nav-item">
                                  <a class="nav-link" data-toggle="tab" href="#kt_tab_pane_2">Unidades asignados</a>
                              </li>
                          </ul>

                          <div class="tab-content mt-5" id="myTabContent">
                            <div class="tab-pane fade show active mt-10" id="kt_tab_pane_1" role="tabpanel" aria-labelledby="kt_tab_pane_1">
                                <table class="table table-hover table-checkable" id="kdatatable_unidades_contratos">
                                    <thead>
                                    <tr>
                                      <th>No.</th>
                                      <th>Ubicación</th>
                                      <th class="text-center">Opciones</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                      @foreach($ubicacion as $unid)
                                        <tr>
                                          <td>{{ $unid->id }}</td>
                                          <td>{{ $unid->ubicacion }}</td>

                                          <td class="text-center">
                                            <a href="{{ route('asignarunidad.unidadespatiolog', [$id_asignacion,$unid->id]) }}" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon activar-ubicacion"  data-toggle="tooltip" data-theme="dark" title="Ver unidades" ><i class="flaticon-eye "></i></a>
                                          </td>
                                        </tr>
                                      @endforeach
                                    </tbody>

                                    <tfoot>
                                    <tr>
                                      <th>No.</th>
                                      <th>Ubicación</th>
                                      <th class="text-center">Opciones</th>
                                    </tr>
                                    </tfoot>

                                </table>
                            </div>

                            <div class="tab-pane fade mt-10" id="kt_tab_pane_3" role="tabpanel" aria-labelledby="kt_tab_pane_3">
                                <table class="table table-hover table-checkable" id="kdatatable_unidades_requisiciones">
                                    <thead>
                                    <tr>
                                      <th>Folio</th>
                                      <th>Solicitante</th>
                                      <th>Area</th>
                                      <th>Estatus</th>
                                      <th>Fecha de solicitud</th>
                                      <th class="text-center">Opciones</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                      @foreach($requisicion as $unid)
                                        <tr>
                                          <td>{{ $unid->folio }}</td>
                                          <td>{{ $unid->usersolicitante->name }}</td>
                                          <td>{{ $unid->areaPersonal->nombre_area }}</td>
                                          <td>{{ $unid->requisicionEstatus->estatus }}</td>
                                          <td>{{ $unid->fecha_solicitud }}</td>

                                          <td class="text-center">
                                            <a href="{{ route('asignarunidad.unidadrequisicionlog', [$id_asignacion,$unid->id]) }}" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon activar-ubicacion"  data-toggle="tooltip" data-theme="dark" title="Ver unidades" ><i class="flaticon-eye "></i></a>
                                          </td>
                                        </tr>
                                      @endforeach
                                    </tbody>

                                    <tfoot>
                                    <tr>
                                      <th>Folio</th>
                                      <th>Solicitante</th>
                                      <th>Area</th>
                                      <th>Estatus</th>
                                      <th>Fecha de solicitud</th>
                                      <th class="text-center">Opciones</th>
                                    </tr>
                                    </tfoot>

                                </table>

                            </div>


                            <div class="tab-pane fade mt-10" id="kt_tab_pane_2" role="tabpanel" aria-labelledby="kt_tab_pane_2">
                              <form action="{{ route('asignarunidad.deleteunidasig') }}" method="post"
                                id="submit_proposicion">
                                @csrf
                                <input type="hidden" name="id_asignacion" value="{{ $id_asignacion }}">
                                <table class="table table-hover table-checkable" id="kdatatable_uni_cont">
                                            <thead>
                                            <tr>
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
                                                <th>Acción</th>
                                            </tr>
                                            </thead>

                                            <tbody>
                                              @foreach($unidades_seleccionadas as $unid)
                                                <tr>
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
                                                  <td>
                                                    <div class="checkbox-inline">
                                                        <label class="checkbox">
                                                            <input type="checkbox" name="segmento[]"
                                                                value="{{ $unid->id }}" />
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                  </td>
                                                </tr>

                                              @endforeach
                                            </tbody>

                                            <tfoot>
                                            <tr>
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
                                                <th>Acción</th>
                                            </tr>
                                            </tfoot>

                                </table>



                                        <div class="row">
                                          <div class="col-lg-9"></div>
                                          <div class="col-lg-3 text-center">
                                            <button type="button" id="btnGuardar" class="btn btn-success">Quitar unidades</button>
                                          </div>
                                        </div>


                              </form>
                            </div>
                          </div>

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



@endsection