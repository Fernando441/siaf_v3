@extends('layouts.app')
@section('title')
    Tramite vehicular verificación
@endsection

@push('scripts')
  <script src="{{ asset('js/unidades/tramitesvehiculares/Tramites.js') }}"></script>
@endpush

@section('content')

  <div class="card card-custom gutter-b">
    <div class="card-header">
      <div class="card-title">
        <h3 class="card-label">
          Tramite vehicular verificación
        </h3> 
      </div>
        <div class="card-toolbar">
          <a href="{{ route('unidad.tramitesvehiculares' ,$id_unidad) }}" class="btn btn-light-primary font-weight-bolder mr-3 ml-3">Regresar</a>
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

          <div class="row mt-2">
            <div class="col-lg-12">
                <label>Engomado</label>
                  @if($unidad->op_engomado == 1)
                      <b style="color: yellow;">Amarillo</b>
                  @endif
                  @if($unidad->op_engomado == 2)
                      <b style="color: pink">Rosa</b>
                  @endif
                  @if($unidad->op_engomado == 3)
                      <b style="color: red">Rojo</b>
                  @endif
                  @if($unidad->op_engomado == 4)
                      <b style="color: green">Verde</b>
                  @endif
                  @if($unidad->op_engomado == 5)
                      <b style="color: blue">Azul</b>
                  @endif
            </div>
            <div class="col-lg-12">
                <label>¿La unidad verifica?</label>
                  @if($unidad->verificacion_op == 1)
                      <span class="label font-weight-bold label-outline-danger label-inline" style="font-size: 16px">No Verifica</span>
                  @endif
                  @if($unidad->verificacion_op == 2)
                      <span class="label font-weight-bold label-outline-success label-inline"style="font-size: 16px" >Si Verifica</span>
                  @endif
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
                  <div class="col-lg-12 mt-2">
                    <img src="/img/verificacion.jpg" width="480px">
                  </div>

                </div>

        <div class="row">
          <div class="col-lg-12">
            <div class="card card-custom gutter-b">
              <div class="card-header">
                <div class="card-title">
                  <h3 class="card-label">
                    Verificación
                  </h3>
                </div>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-lg-6">
                    <span><b>Requisitos</b></span>
                    @foreach($req_tramite as $unid)
                      <li>{{ $unid->nombre_requisito }}</li>
                    @endforeach
                  </div>
                  <div class="col-lg-6 text-center">
                    @if($unidad->verificacion_op == 2)
                      <a href="{{ route('traveh.vistagrdverificacion', $id_unidad) }}" class="btn btn-light-primary font-weight-bolder mr-3 ml-3 mt-2">
                        <i class="la la-plus"></i>Nuevo
                      </a>

                      
                      <a href="#" class="btn btn-light-primary font-weight-bolder mr-3 ml-3 mt-2" data-toggle="modal" data-target="#exampleModal">
                                    <i class="la la-plus"></i>Carga Masiva</a>
                      @endif


                  </div>
                </div>

                <div class="row mt-4">
                  <div class="col-lg-12">
                      <table class="table table-hover table-checkable" id="kdatatable_tramite">
                        <thead>
                          <tr>
                            <th>No.</th>
                            <th>Fecha de expedición de certificado</th>
                            <th>Fecha de vencimiento de certificado</th>
                            <th>Fecha de entrega de certificado</th>
                            <th>Tipo de reporte</th>
                            <th>Observaciones</th>
                            <th class="text-center">Opciones</th>
                          </tr>
                        </thead>

                        <tbody>
                          @foreach($req_info as $unid)
                            <tr>
                              <td>{{ $unid->id }}</td>
                              <td>{{ $unid->fecha_tramite }}</td>
                              <td>{{ $unid->fecha_vencimiento }}</td>
                              <td>{{ $unid->fecha_entrega}}</td>
                              <td>{{ $unid->tipo_reporte }}</td>
                              <td>{{ $unid->observaciones }}</td>
                              <td class="text-center">
                                <a href="{{route('traveh.vistaververificacion', [$unid->unidad_id, $unid->id]) }}" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon" title="Ver tramite" data-theme="dark" data-toggle="tooltip" data-placement="top">
                                    <span class="svg-icon svg-icon-md">
                                        <i class="flaticon-eye"></i>
                                    </span>
                                </a>
                                @if($unid->op_estatus == 1)
                                  <a href="{{ route('traveh.vistaeditverificacion', [$unid->unidad_id, $unid->id]) }}" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon activar-requisito" data-id="{{ $unid->id }}" data-nombre="{{ $unid->fecha_tramite }}" data-toggle="tooltip" data-theme="dark" title="Editar tramite"><i class="flaticon-edit"></i></a>

                                  <button class="btn btn-sm btn-clean btn-hover-icon-success btn-icon eliminar_verificacion" data-toggle="tooltip" data-id="{{ $unid->id }}" data-nombre="{{ $unid->fecha_tramite }}"  data-theme="dark" title="Eliminar tramite">
                                    <span class="svg-icon svg-icon-md">
                                      <i class="flaticon-delete"></i>
                                    </span>
                                  </button>
                                @endif
                              </td>
                            </tr>
                          @endforeach
                        </tbody>

                        <tfoot>
                          <tr>
                            <th>No.</th>
                            <th>Fecha de verificación</th>
                            <th>Observaciones</th>
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

<form method="post" id="verificacion_eliminar_form" action="{{ route('traveh.deleteinfoevverificacion') }}" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="id" id="id_eliminar_verificacion" value="">
    <input type="hidden" name="id_unidad" value="{{ $id_unidad }}">
</form>


  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title">Carga masiva tramite de verificación</h5>
                  <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                      <span class="svg-icon svg-icon-2x"></span>
                  </div>
              </div>

              <div class="modal-body">
            <form action="{{ route('traveh.cargamasivaverificacion') }}" enctype="multipart/form-data" method="post" id="submit_evidencia">
            @csrf

                <div class="row form-group">
                  <a href="/layout/Carga Masiva Verificacion.csv">Layout para la carga masiva</a>
                </div>
                  <input type="hidden" name="id_unidad" value="{{ $id_unidad }}">
                    <div class="row form-group">
                      <div class="col-lg-12 mt-2">
                          <label>Archivo</label>
                          <div class='custom-file'>
                             <input type='file' class='custom-file-input' id='file_carga' name='file_carga' required />
                             <label class='custom-file-label' for='foto"+contadorFotografia+"'>Selecciona un archivo</label>
                          </div>
                      </div>
                    </div>
                </form>
              </div>

              <div class="modal-footer">
                  <button type="button" class="btn btn btn-secondary font-weight-bold" data-dismiss="modal"><i class="la la-times"></i>Cancelar</button>
                  <button type="button" id="send_evidencia_tramite" class="btn btn-success"><i class="la la-plus"></i>Guardar</button>
              </div>
          </div>
      </div>
  </div>

@endsection

