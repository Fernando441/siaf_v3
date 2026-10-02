@extends('layouts.app')
@section('title')
    Equipamiento unidad
@endsection
@push('scripts')
    <script src="{{ asset('js/unidades/EquipamientoUnidad.js') }}"></script>
@endpush

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <div class="card card-custom gutter-b">
                <div class="card-header">
                    <h3 class="card-title">Equipamiento</h3>
                </div>

                    <div class="card-body">

                        <div class="row">
                            <div class="col-lg-8">
                                @if($ver != 0)
                                    <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                                      <div class="carousel-inner">

                                        @foreach($fotografias as $documento)
                                        <div class="carousel-item {{($ver == $documento->id) ? 'active' : ''}}">
                                          <img class="d-block w-100" src="{{ route('archivo.fotografiaUnidad', ['id'=>$documento->id]) }}" alt="Second slide">
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

                            <div class="col-lg-4 text-center">
                                <div class="form-group row mt-2">
                                    <div class="col-lg-6 col-sm-6">
                                        <label>Marca</label>
                                        @foreach($marcas as $marca)
                                            @if($marca->id == $unidad_info->id_marca)
                                                <p>{{ strtoupper($marca->nombre_marca)}}</p>
                                            @endif
                                        @endforeach
                                    </div>
                                    <div class="col-lg-6 col-sm-6">
                                        <label>Modelo</label>
                                        @foreach($modelos as $model)
                                            @if($model->id == $unidad_info->id_modelo)
                                                <p>{{ strtoupper($model->nombre_modelo)}}</p>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-lg-6 col-sm-6">
                                        <label>Número de serie</label>
                                        <p>{{ $unidad_info->no_serie }}</p>
                                    </div>
                                    <div class="col-lg-6 col-sm-6">
                                        <label>No. Factura de compra</label>
                                        <p>{{ $unidad_info->factura_compra }}</p>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-lg-6 col-sm-6">
                                        <label>Placa</label>
                                        <p>{{ $unidad_info->placa }}</p>
                                    </div>
                                    <div class="col-lg-6 col-sm-6">
                                        <label>Color</label>
                                        <p>{{ $unidad_info->color }}</p>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-lg-6 col-sm-6">
                                        <label>Año de la unidad</label>
                                        <p>{{ $unidad_info->unidad_year }}</p>
                                    </div>
                                    <div class="col-lg-6 col-sm-6">
                                        <label>Número de tarjeta de circulación</label>
                                        <p>{{ $unidad_info->no_tarjeta_circulacion }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="card card-custom gutter-b">
                            <div class="card-header">
                                <div class="card-title">
                                    <h3 class="card-label">Carga masiva </h3>
                                    <small> <a href="/layout/Carga Masiva Equipamiento.csv">Layout para la carga masiva</a></small>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-10">
                                        {{--  --}}
                                        <form class="form" action="{{ route('equipamientocsv.cagamasivaequipamiento') }}" method="post" id="submit_carga" enctype="multipart/form-data" content="text/html; charset=utf-8">
                                          @csrf

                                            <input type="hidden" name="unidad_id" value="{{ $unidad }}">
                                            <div class="row">
                                                <div class="col-lg-12  form-group">
                                                    <label>Carga Masiva</label>
                                                    <div class='custom-file'>
                                                        <input type='file' class='custom-file-input' id='file_carga' name='file_carga' required />
                                                        <label class='custom-file-label' for='foto"+contadorFotografia+"'>Selecciona un archivo</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>

                                    <div class="col-lg-2 mt-8 form-group">
                                        <button type="button" id="send_carga" class="btn btn-primary">Subir</button>
                                    </div>

                                </div>
                            </div>
                        </div>



                        <div class="card card-custom gutter-b">
                            <div class="card-header">
                                <div class="card-title">

                                </div>
                            </div>
                            <div class="card-body">
                                <ul class="nav nav-tabs nav-tabs-line" style="width: 100%;">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="tab" href="#kt_tab_pane_1">Equipamiento</a>
                                    </li>
                                    <li class="nav-item">
                                        @if($alert == 0)
                                            <a class="nav-link" data-toggle="tab" href="#kt_tab_pane_2">Información pendiente </a>
                                        @else
                                            <a class="nav-link" data-toggle="tab" href="#kt_tab_pane_2">Información pendiente  <span class="badge badge-square badge-warning">{{ $alert }}</span></a>
                                        @endif
                                        
                                    </li>
                                </ul>

                                <div class="tab-content mt-5" id="myTabContent" style="width: 100%;">
                                    <div class="tab-pane fade show active" id="kt_tab_pane_1" role="tabpanel" aria-labelledby="kt_tab_pane_1">
                                        <table class="table table-hover table-checkable" id="kdatatable_equipamiento_completo">
                                            <thead>
                                            <tr>
                                              <th>No.</th>
                                              <th>Nombre</th>
                                              <th>Evidencia</th>
                                              <th class="text-center">Opciones</th>
                                            </tr>
                                            </thead>

                                            <tbody>
                                              @foreach($equipamiento_completo as $unid)
                                                <tr>
                                                  <td>{{ $unid->id }}</td>
                                                  <td>{{ $unid->equipamiento }}</td>
                                                  <td>
                                                    
                                                        <img src="{{ route('archivo.evidenciaequipamiento', ['id'=>$unid->id]) }}">


                                                  </td>
                                                  <td class="text-center">
                                                        <a class="btn btn-sm btn-clean btn-hover-icon-success btn-icon eliminar-documento" data-id="{{ $unid->id }}" data-nombre="{{ $unid->equipamiento }}" data-toggle="tooltip" data-theme="dark" title="Eliminar equipamiento" ><i class="flaticon-delete "></i></a>
                                                  </td>
                                                </tr>
                                              @endforeach
                                            </tbody>

                                            <tfoot>
                                            <tr>
                                              <th>No.</th>
                                              <th>Nombre</th>
                                              <th>Evidencia</th>
                                              <th class="text-center">Opciones</th>
                                            </tr>
                                            </tfoot>

                                        </table>

                                    </div>

                                    <div class="tab-pane fade" id="kt_tab_pane_2" role="tabpanel" aria-labelledby="kt_tab_pane_2">
                                        <form class="form" action="{{ route('equipamientocsv.cargaevidencia') }}" method="post" id="submit_docs" enctype="multipart/form-data" >
                                        @csrf
                                            <input type="hidden" name="unidad" value="{{ $unidad }}">
                                            <table class="table table-hover table-checkable" id="kdatatable_equipamiento_pendiente">
                                                <thead>
                                                <tr>
                                                  <th>No.</th>
                                                  <th>Nombre</th>
                                                  <th>Evidencia</th>
                                                  <th class="text-center">Opciones</th>
                                                </tr>
                                                </thead>

                                                <tbody>
                                                  @foreach($equipamiento_pendiente as $unid)
                                                    <tr>
                                                      <td>{{ $unid->id }}</td>
                                                      <td>{{ $unid->equipamiento }}</td>
                                                      <td>
                                                          <div class="row">
                                                              <div class="col-lg-12  form-group">
                                                                  <label>Imagen</label>
                                                                  <div class='custom-file'>
                                                                     <input type='file' class='custom-file-input'+ name='file_carga[]' style="width: 190px;"/>
                                                                     <label class='custom-file-label' for='foto"+contadorFotografia+"'></label>
                                                                     <input type="hidden" name="id[]" value="{{  $unid->id }}">
                                                                  </div>
                                                              </div>
                                                          </div>
                                                      </td>
                                                      <td class="text-center">
                                                        <a class="btn btn-sm btn-clean btn-hover-icon-success btn-icon eliminar-documento" data-id="{{ $unid->id }}" data-nombre="{{ $unid->equipamiento }}" data-toggle="tooltip" data-theme="dark" title="Eliminar equipamiento" ><i class="flaticon-delete "></i></a>
                                                      </td>
                                                    </tr>
                                                  @endforeach
                                                </tbody>

                                                <tfoot>
                                                <tr>
                                                  <th>No.</th>
                                                  <th>Nombre</th>
                                                  <th>Evidencia</th>
                                                  <th class="text-center">Opciones</th>
                                                </tr>
                                                </tfoot>

                                            </table>



                                            <div class="row">
                                              <div class="col-lg-9"></div>
                                              <div class="col-lg-3 text-center">
                                                <button type="submit" id="add_doc_tecnica"  class="btn btn-success"><i class="la la-plus"></i>Guardar Evidencia</button>
                                              </div>
                                            </div>

                                        </form>

                                    </div>
                                </div>


                            </div>
                        </div>


                        <input type="hidden" id="datatable_i18n" value="{{ asset('/js/datatables/i18n/es-mx.json') }}">
                    </div>
                    <div class="card-footer" >
                        <div class="row">
                            <div class="col-lg-12">
                                {{-- <button type="button"  id="btnGuardar" class="btn btn-primary mr-2">Guardar</button> --}}
                                <a href="{{ route('unidad.catalogounidad') }}"  class="btn btn-secondary"><i class="la la-arrow-left"></i>Regresar</a>
                            </div>

                        </div>
                    </div>
            </div>
        </div>
    </div>

{{-- M O D A L S --}}
    <form method="post" id="eliminardoc_act_form" action="{{ route('equipamientocsv.eliminarevidencia') }}"
        enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="unidad_id" value="{{ $unidad }}">
        <input type="hidden" name="id" id="id_doc_act" value="">
    </form>


@endsection
