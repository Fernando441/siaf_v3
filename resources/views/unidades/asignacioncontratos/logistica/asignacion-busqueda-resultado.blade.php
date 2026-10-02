@extends('layouts.app')

@section('title')
    Asignación por busqueda
@endsection

@push('scripts')
  <script src="{{ asset('js/unidades/QuitarUnidadesAsignacion.js') }}"></script>
  <script src="{{ asset('js/unidades/AsignartotalUnidadesBusqueda.js') }}"></script>

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
                                <h3 class="card-label">Asignación por busqueda resultados</h3>
                            </div>
                            <div class="card-toolbar">

                                <!--begin::Button-->
                                <a href="{{ route('asignarunidad.patiosasignacion', $id_asignacion) }}" class="btn btn-light-primary font-weight-bolder mr-3 ml-3"><i class="la la-arrow-left"></i>
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

                        <form id="form" method="post" action="{{ route('asignarunidad.busquedaasig') }}" class="form">
                        @csrf  

                          <input type="hidden" name="id_asignacion" value="{{ $id_asignacion }}">

                          <div class="form-group row ">
                              <div class="col-lg-12">
                                  <label>Tipos de Búsquedas</label>
                                  <div class="input-group">
                                      <div class="radio-inline">
                                          <label class="radio">
                                              <input type="radio" checked name="tipo" value="1" required>
                                              <span></span>
                                              Por Número de Serie
                                          </label>
                                          <label class="radio">
                                              <input type="radio" name="tipo" value="2" required>
                                              <span></span>
                                              Por Número de Placa
                                          </label>
                                          <label class="radio">
                                              <input type="radio" name="tipo" value="3" required>
                                              <span></span>
                                              Por Número Económico
                                          </label>
                                      </div>
                                  </div>
                              </div>
                          </div>


                          <div class="form-group row ">
                            <div class="col-lg-12">
                                <textarea class="form-control" rows="10" name="listado" id="listado" required> </textarea>
                                <small class="form-text text-muted" >Pegue aquí el listado de números de serie, o números de placas.</small>
                                <a class="btn btn-sm btn-clean btn-hover-icon-success btn-icon" onclick="document.getElementById('listado').value='';" data-toggle="tooltip" data-theme="dark" title="Limpiar Caja de Texto">
                                    <i class="flaticon-delete"></i>
                                </a>
                            </div>
                          </div>

                          <div class="card-footer">
                              <div class="row">
                                  <div class="col-lg-8">
                                      <button type="submit"  id="btnGuardar" class="btn btn-success"><i class="la la-search"></i>Buscar</button>
                                  </div>
                              </div>
                          </div>

                        </form>

                          <form action="{{ route('asignarunidad.addtotalunidadesbus') }}" method="post"
                            id="submit_proposicion">
                            @csrf
                                <input type="hidden" name="id_asignacion" value="{{ $id_asignacion }}">

                                        <table class="table table-hover table-checkable" id="kdatatable_uni_cont">
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
                                                <th>Asignación</th>
                                                <th></th>
                                                <th>Accion</th>
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

                                                  <td>
                                                    @if($unid->apartado_asignacion == 0)
                                                      
                                                      <span class="label font-weight-bold  label-outline label-inline" style="color: green; border: 1px solid green !important">Disponible</span>
                                                    @else
                                                      <span class="label font-weight-bold label-outline-warning label-inline" >Apartada</span>  
                                                    @endif
                                                  </td>
                                                  <td>
                                                    @if($unid->apartado_asignacion == 0)
                                                      
                                                      {{-- <span class="label font-weight-bold  label-outline label-inline" style="color: green; border: 1px solid green !important">Disponible</span> --}}
                                                    @else
                                                        <span style="font-size: 12px;">{{ $unid->nombre_asignacion }}</span>
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
                                                <th>Folio</th>
                                                <th>Ubicación</th>
                                                <th>Marca</th>
                                                <th>Modelo</th>
                                                <th>Serie</th>
                                                <th>Placa</th>
                                                <th>Año</th>
                                                <th>Unidad</th>
                                                <th>Asignación</th>
                                                <th></th>
                                                <th>Accion</th>
                                            </tr>
                                            </tfoot>

                                        </table>


                                        <div class="row">
                                          <div class="col-lg-9"></div>
                                          <div class="col-lg-3 text-center">
                                            <button type="button" id="btnGuardarbusqueda" class="btn btn-success">Asignar unidades</button>
                                          </div>
                                        </div>


                                  </form>
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