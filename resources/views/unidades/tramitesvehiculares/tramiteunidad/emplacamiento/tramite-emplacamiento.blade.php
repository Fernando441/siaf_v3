@extends('layouts.app')
@section('title')
    Tramite vehicular emplacamiento
@endsection

@push('scripts')
  <script src="{{ asset('js/unidades/tramitesvehiculares/Tramites.js') }}"></script>
@endpush

@section('content')

  <div class="card card-custom gutter-b">
    <div class="card-header">
      <div class="card-title">
        <h3 class="card-label">
          Tramite vehicular emplacamiento
        </h3> 
      </div>
        <div class="card-toolbar">
          <a href="{{ route('unidad.tramitesvehiculares' ,$id_unidad) }}" class="btn btn-light-primary font-weight-bolder mr-3 ml-3"><i class="la la-arrow-left"></i>Regresar</a>
        </div>
    </div>
    <div class="card-body">
      <div class="row">
        <div class="col-lg-5">
          <div class="row">
            <h5>Información de la unidad</h5>
            <div class="col-lg-12 col-ls-6">
                <label>Marca</label>
                @foreach($marcas as $marca)
                  @if($marca->id == $unidad->id_marca)
                    <li>{{ strtoupper($marca->nombre_marca)}}</li>
                  @endif
                @endforeach
            </div>
            <div class="col-lg-12 col-ls-6">
                <label>Modelo</label>
                @foreach($modelos as $model)
                    @if($model->id == $unidad->id_modelo)
                      <li>{{ strtoupper($model->nombre_modelo)}}</li>
                    @endif
                @endforeach
            </div>
          </div>

          <div class="row mt-2">
            <div class="col-lg-12">
                <label>Año de la unidad</label>
                <li>{{ $unidad->unidad_year }}</li>
            </div>
            <div class="col-lg-12">
                <label>Número de serie</label>
                <li>{{ $unidad->no_serie }}</li>
            </div>
          </div>

          <div class="row mt-2">
            <div class="col-lg-12">
                <label>Placa</label>
                <li>{{ $unidad->placa }}</li>
            </div>
            <div class="col-lg-12">
                <label>Color</label>
                <li>{{ $unidad->color }}</li>
            </div>
          </div>
        </div>

        <div class="col-lg-7">
          @if($ver != 0)
            <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
              <div class="carousel-inner">

                @foreach($fotografias as $documento)
                <div class="carousel-item {{($ver == $documento->id) ? 'active' : ''}}">
                  <img class="d-block w-100" src="{{ route('archivo.fotografiaUnidad', ['id'=>$documento->id]) }}" height="400" alt="Second slide">
                </div>
                  @endforeach
              </div>
              <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
              </a>
              <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
              </a>
            </div>
          @else
            <img src="/img/no_disponible.png" width="300px">
          @endif
        </div>
      </div>


        <div class="row">
          <div class="col-lg-12">
            <div class="card card-custom gutter-b">
              <div class="card-header">
                <div class="card-title">
                  <h3 class="card-label">
                    Emplacamiento
                  </h3>
                </div>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-lg-8">
                    <span><b>Requisitos</b></span>
                    @foreach($req_tramite as $unid)
                      <li>{{ $unid->nombre_requisito }}</li>
                    @endforeach
                  </div>
                  <div class="col-lg-4 text-center">
                    @if(count($req_info) == 0)
                      <a href="{{ route('traveh.vistagrdemplacamiento', $id_unidad) }}" class="btn btn-light-primary font-weight-bolder mr-3 ml-3 mt-2">
                        <i class="la la-plus"></i>Nuevo
                      </a>
                      @endif
                  </div>
                </div>

                <div class="row mt-4">
                  <div class="col-lg-12">
                      <table class="table table-hover table-checkable" id="kdatatable_tramite">
                        <thead>
                          <tr>
                            <th>No.</th>
                            <th>Fecha de tramite</th>
                            <th>Número de placas</th>
                            <th>Tarjeta de circulación</th>
                            <th>Entidad</th>
                            <th>Engomado</th>
                            <th>Verificación</th>
                            <th class="text-center">Opciones</th>
                          </tr>
                        </thead>

                        <tbody>
                          @foreach($req_info as $unid)
                            <tr>
                              <td>{{ $unid->id }}</td>
                              <td>{{ date('d/m/Y', strtotime($unid->fecha_tramite))}} </td>
                              <td>{{ $unid->numero_placas }}</td> 
                              <td>{{ $unid->tarjeta_circularion }}</td>
                              <td>{{ $unid->estado->estado_nombre }}</td>
                              <td>
                                @if($unid->engomado == 1)
                                  <b style="color: yellow;">Amarillo</b>
                                @endif
                                @if($unid->engomado == 2)
                                  <b style="color: pink">Rosa</b>
                                @endif
                                @if($unid->engomado == 3)
                                  <b style="color: red">Rojo</b>
                                @endif
                                @if($unid->engomado == 4)
                                  <b style="color: green">Verde</b>
                                @endif
                                @if($unid->engomado == 5)
                                  <b style="color: blue">Azul</b>
                                @endif
                              </td>
                              <td>
                                @if($unid->verificacion_op == 1)
                                  <span class="label font-weight-bold label-outline-danger label-inline" >No Verifica</span>
                                @else
                                  <span class="label font-weight-bold label-outline-success label-inline" >Si Verifica</span>
                                @endif
                              </td>
                              <td class="text-center">
                                <a href="{{ route('traveh.vistaveremplacamiento', [$id_unidad,$unid->id ]) }}" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon" title="Ver tramite" data-theme="dark" data-toggle="tooltip" data-placement="top">
                                    <span class="svg-icon svg-icon-md">
                                        <i class="flaticon-eye"></i>
                                    </span>
                                </a>
                                @if($unid->op_estatus == 1)
                                  <a href="{{ route('traveh.vistaeditemplacamiento', [$id_unidad,$unid->id ]) }}" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon activar-requisito" data-id="{{ $unid->id }}" data-nombre="{{ $unid->fecha_tramite }}" data-toggle="tooltip" data-theme="dark" title="Editar tramite"><i class="flaticon-edit"></i></a>
                                @endif
                              </td>
                            </tr>
                          @endforeach
                        </tbody>

                        <tfoot>
                          <tr>
                            <th>No.</th>
                            <th>Fecha de tramite</th>
                            <th>Número de placas</th>
                            <th>Tarjeta de circulación</th>
                            <th>Entidad</th>
                            <th>Engomado</th>
                            <th>Verificación</th>
                            <th class="text-center">Opciones</th>
                          </tr>
                        </tfoot>

                      </table>
                      <input type="hidden" id="datatable_i18n" value="{{ asset('/js/datatables/i18n/es-mx.json') }}">
                  </div>
                </div>


              </div>
            </div>
          </div>
        </div>



    </div>
  </div>

<form method="post" id="tenencia_eliminar_form" action="{{ route('traveh.deleteinfoevtenencia') }}" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="id" id="id_eliminar_tenencia" value="">
    <input type="hidden" name="id_unidad" value="{{ $id_unidad }}">
</form>


@endsection

