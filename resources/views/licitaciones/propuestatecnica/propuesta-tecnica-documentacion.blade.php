@extends('layouts.app')
@section('title')
    Propuesta técnica
@endsection

@push('scripts')
<script src="{{ asset('js/licitaciones/propuestatecnica/Cargamasiva.js') }}"></script>
  <meta name="csrf-token" content="{{ csrf_token() }}" />
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
                              <h3 class="card-label">Propuesta técnica</h3>

                            </div>


                              <div class="card-toolbar">
                                  <a class="btn btn-link-primary font-weight-bold mr-2 " 
                                      href="{{ route('propuestatecnica.crearpropuestatecnica', $licitacion) }}" role="button" >
                                      Regresar
                                  </a>
                              </div>
                        </div>
                        <div class="card-body">

                        <ul class="nav nav-tabs nav-tabs-line" style="width: 100%;">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#kt_tab_pane_1">Carga de información</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#kt_tab_pane_2">Propuesta técnica</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#kt_tab_pane_3">Propuesta económica </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#kt_tab_pane_4"> Legal y administrativa </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#kt_tab_pane_5">Otros </a>
                            </li>
                        </ul>


                        <div class="tab-content mt-5" id="myTabContent" style="width: 100%;">
                            <!-- tabs content -->
                            <!--Información Legal-->
                            <div class="tab-pane fade show active" id="kt_tab_pane_1" role="tabpanel" aria-labelledby="kt_tab_pane_2">


                                <div class="card card-custom gutter-b">
                                  <div class="card-header">
                                    <div class="card-title">
                                      <h3 class="card-label">Carga masiva </h3>
                                      <small> <a href="/layout/Formato propuesta tecnica.csv">Layout para la carga masiva</a></small>
                                    </div>
                                  </div>
                                  <div class="card-body">
                                    <div class="row">
                                      <div class="col-lg-10">
                                        <form class="form" action="{{ route('propuestatecnica.cargamasiva') }}" method="post" id="submit_carga" enctype="multipart/form-data" content="text/html; charset=utf-8">
                                          @csrf

                                          <input type="hidden" name="licitacion_id" value="{{ $licitacion }}">
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




                              @if($propuesta_if != null )
                                {{-- <div class="row"> --}}
                              <!--begin: Datatable-->
                                  
                                    <form class="form" action="{{ route('propuestatecnica.cargadocumentoreal') }}" method="post" id="submit_docs" enctype="multipart/form-data" >
                                    @csrf
                                    <input type="hidden" name="licitacion_id" value="{{ $licitacion }}">
                                      <table class="table table-hover table-checkable table-responsive" id="kdatatable_documentolicitacion_inactiva">
                                          <thead>
                                          <tr>
                                            <th>Num.</th>
                                            <th>Nombre del requerimiento</th>
                                            <th>Descripción</th>
                                            <th>Obligatorio</th>
                                            <th>Respuesta</th>
                                            <th class="text-center">Opciones</th>
                                            <th>Sección</th>
                                            <th>Documento</th>
                                            <th>Opción</th>
                                          </tr>
                                          </thead>

                                          <tbody>
                                            @foreach($propuesta as $unid)
                                              <tr>
                                                <td>{{ $unid->num }} </td>
                                                <td>{{ $unid->nombre_requerimiento }}</td>
                                                <td>{{ $unid->descripcion }}</td>
                                                <td>{{ $unid->obligatorio }}</td>
                                                <td>{{ $unid->respuesta }}</td>
                                                <td>{{ $unid->acciones }}</td>
                                                <td>
                                                  <input type="hidden" name="id[]" value="{{  $unid->id }}">
                                                  <div class="form-group">
                                                    <label>Sección</label>
                                                    <select class="form-control" name="seccion[]"  style="width: 220px;">
                                                        <option value="0">Selecciona un opción</option>
                                                        <option value="1">Propuesta técnica</option>
                                                        <option value="2">Propuesta económica</option>
                                                        <option value="3">Propuesta legal y administrativa</option>
                                                        <option value="4">Otros</option>
                                                    </select>
                                                  </div>
                                                </td>
                                                <td>
                                                  <div class="row">
                                                      <div class="col-lg-12  form-group">
                                                          <label>Archivo</label>
                                                          <div class='custom-file'>
                                                             <input type='file' class='custom-file-input'+ name='file_carga[]' style="width: 190px;"/>
                                                             <label class='custom-file-label' for='foto"+contadorFotografia+"'></label>
                                                          </div>
                                                      </div>
                                                  </div>
                                                </td>
                                                <td>
                                                  <a class="btn btn-sm btn-clean btn-hover-icon-success btn-icon eliminar-documento" data-id="{{ $unid->id }}" data-nombre="{{ $unid->nombre_requerimiento }}" data-toggle="tooltip" data-theme="dark" title="Eliminar registro" ><i class="flaticon-delete"></i></a>
                                                </td>
                                              </tr>
                                            @endforeach
                                          </tbody>

                                          <tfoot>
                                          <tr>
                                            <th>Num.</th>
                                            <th>Nombre del requerimiento</th>
                                            <th>Descripción</th>
                                            <th>Obligatorio</th>
                                            <th>Respuesta</th>
                                            <th class="text-center">Opciones</th>
                                            <th>Sección</th>
                                            <th>Documento</th>
                                            <th>Opción</th>
                                          </tr>
                                          </tfoot>

                                      </table>
                                      <!--end: Datatable-->

                                        <div class="row">
                                          <div class="col-lg-9"></div>
                                          <div class="col-lg-3 text-center">
                                            <button type="submit" id="add_doc_tecnica"  class="btn btn-primary">Guardar Documentos</button>
                                          </div>
                                        </div>

                                    </form>

                                  
                              <input type="hidden" id="datatable_i18n" value="{{ asset('/js/datatables/i18n/es-mx.json') }}">
                                {{-- </div> --}}
                              @endif


                            </div>
                            <!--Propuesta técnica cargada-->
                            <div class="tab-pane fade" id="kt_tab_pane_2" role="tabpanel" aria-labelledby="kt_tab_pane_2">
                              <div class="row">
                                <div class="col-lg-12">
                                      <table class="table table-hover table-checkable table-responsive" id="kdatatable_documentos_final">
                                          <thead>
                                            <tr>
                                              <th>Num.</th>
                                              <th>Nombre del requerimiento</th>
                                              <th>Descripción</th>
                                              <th>Obligatorio</th>
                                              <th>Respuesta</th>
                                              <th class="text-center">Opciones</th>
                                              <th>Opción</th>
                                            </tr>
                                          </thead>

                                          <tbody>
                                            @foreach($propuesta_tecnica as $unid)
                                              <tr>
             
                                                <td>{{ $unid->num }}</td>
                                                <td>{{ $unid->nombre_requerimiento }}</td>
                                                <td>{{ $unid->descripcion }}</td>
                                                <td>{{ $unid->obligatorio }}</td>
                                                <td>{{ $unid->respuesta }}</td>
                                                <td>{{ $unid->acciones }}</td>
                                                <td>
                                                  <a href="{{ route('archivo.documentoPropuestaeconomica', ['id'=>$unid->id]) }}" data-toggle="tooltip" data-theme="dark" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon" target="_blank" title="Ver documento">
                                                    <span class="svg-icon svg-icon-md">
                                                      <i class="flaticon-eye"></i>
                                                    </span> 
                                                  </a>

                                                  <button class="btn btn-sm btn-clean btn-hover-icon-success btn-icon eliminar-real" data-id="{{ $unid->id }}" data-nombre="{{ $unid->nombre_requerimiento }}" data-toggle="tooltip" data-theme="dark" title="Eliminar registro" ><i class="flaticon-delete"></i></button>
                                                </td>

                                              </tr>
                                            @endforeach
                                          </tbody>

                                          <tfoot>
                                          <tr>
                                            <th>Num.</th>
                                            <th>Nombre del requerimiento</th>
                                            <th>Descripción</th>
                                            <th>Obligatorio</th>
                                            <th>Respuesta</th>
                                            <th class="text-center">Opciones</th>
                                            <th>Opción</th>
                                          </tr>
                                          </tfoot>

                                      </table>
                                </div>
                              </div>
                            </div>


                            <div class="tab-pane fade" id="kt_tab_pane_3" role="tabpanel" aria-labelledby="kt_tab_pane_3">
                              <div class="row">
                                <div class="col-lg-12">
                                      <table class="table table-hover table-checkable table-responsive" id="kdatatable_documentos_economica">
                                          <thead>
                                            <tr>
                                              <th>Num.</th>
                                              <th>Nombre del requerimiento</th>
                                              <th>Descripción</th>
                                              <th>Obligatorio</th>
                                              <th>Respuesta</th>
                                              <th class="text-center">Opciones</th>
                                              <th>Opción</th>
                                            </tr>
                                          </thead>

                                          <tbody>
                                            @foreach($propuesta_economica as $unid)
                                              <tr>
             
                                                <td>{{ $unid->num }}</td>
                                                <td>{{ $unid->nombre_requerimiento }}</td>
                                                <td>{{ $unid->descripcion }}</td>
                                                <td>{{ $unid->obligatorio }}</td>
                                                <td>{{ $unid->respuesta }}</td>
                                                <td>{{ $unid->acciones }}</td>
                                                <td>
                                                  <a href="{{ route('archivo.documentoPropuestaeconomica', ['id'=>$unid->id]) }}" data-toggle="tooltip" data-theme="dark" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon" target="_blank" title="Ver documento">
                                                    <span class="svg-icon svg-icon-md">
                                                      <i class="flaticon-eye"></i>
                                                    </span> 
                                                  </a>

                                                  <button class="btn btn-sm btn-clean btn-hover-icon-success btn-icon eliminar-real" data-id="{{ $unid->id }}" data-nombre="{{ $unid->nombre_requerimiento }}" data-toggle="tooltip" data-theme="dark" title="Eliminar registro" ><i class="flaticon-delete"></i></button>
                                                </td>

                                              </tr>
                                            @endforeach
                                          </tbody>

                                          <tfoot>
                                          <tr>
                                            <th>Num.</th>
                                            <th>Nombre del requerimiento</th>
                                            <th>Descripción</th>
                                            <th>Obligatorio</th>
                                            <th>Respuesta</th>
                                            <th class="text-center">Opciones</th>
                                            <th>Opción</th>
                                          </tr>
                                          </tfoot>

                                      </table>
                                </div>
                              </div>

                            </div>


                            <div class="tab-pane fade" id="kt_tab_pane_4" role="tabpanel" aria-labelledby="kt_tab_pane_4">
                              <div class="row">
                                <div class="col-lg-12">
                                      <table class="table table-hover table-checkable table-responsive" id="kdatatable_documentos_administrativa">
                                          <thead>
                                            <tr>
                                              <th>Num.</th>
                                              <th>Nombre del requerimiento</th>
                                              <th>Descripción</th>
                                              <th>Obligatorio</th>
                                              <th>Respuesta</th>
                                              <th class="text-center">Opciones</th>
                                              <th>Opción</th>
                                            </tr>
                                          </thead>

                                          <tbody>
                                            @foreach($propuesta_administrativa as $unid)
                                              <tr>
             
                                                <td>{{ $unid->num }}</td>
                                                <td>{{ $unid->nombre_requerimiento }}</td>
                                                <td>{{ $unid->descripcion }}</td>
                                                <td>{{ $unid->obligatorio }}</td>
                                                <td>{{ $unid->respuesta }}</td>
                                                <td>{{ $unid->acciones }}</td>
                                                <td>
                                                  <a href="{{ route('archivo.documentoPropuestaeconomica', ['id'=>$unid->id]) }}" data-toggle="tooltip" data-theme="dark" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon" target="_blank" title="Ver documento">
                                                    <span class="svg-icon svg-icon-md">
                                                      <i class="flaticon-eye"></i>
                                                    </span> 
                                                  </a>

                                                  <button class="btn btn-sm btn-clean btn-hover-icon-success btn-icon eliminar-real" data-id="{{ $unid->id }}" data-nombre="{{ $unid->nombre_requerimiento }}" data-toggle="tooltip" data-theme="dark" title="Eliminar registro" ><i class="flaticon-delete"></i></button>
                                                </td>

                                              </tr>
                                            @endforeach
                                          </tbody>

                                          <tfoot>
                                          <tr>
                                            <th>Num.</th>
                                            <th>Nombre del requerimiento</th>
                                            <th>Descripción</th>
                                            <th>Obligatorio</th>
                                            <th>Respuesta</th>
                                            <th class="text-center">Opciones</th>
                                            <th>Opción</th>
                                          </tr>
                                          </tfoot>

                                      </table>
                                </div>
                              </div>

                            </div>


                            <div class="tab-pane fade" id="kt_tab_pane_5" role="tabpanel" aria-labelledby="kt_tab_pane_5">
                              <div class="row">
                                <div class="col-lg-12">
                                      <table class="table table-hover table-checkable table-responsive" id="kdatatable_documentos_otros">
                                          <thead>
                                            <tr>
                                              <th>Num.</th>
                                              <th>Nombre del requerimiento</th>
                                              <th>Descripción</th>
                                              <th>Obligatorio</th>
                                              <th>Respuesta</th>
                                              <th class="text-center">Opciones</th>
                                              <th>Opción</th>
                                            </tr>
                                          </thead>

                                          <tbody>
                                            @foreach($propuesta_otros as $unid)
                                              <tr>
             
                                                <td>{{ $unid->num }}</td>
                                                <td>{{ $unid->nombre_requerimiento }}</td>
                                                <td>{{ $unid->descripcion }}</td>
                                                <td>{{ $unid->obligatorio }}</td>
                                                <td>{{ $unid->respuesta }}</td>
                                                <td>{{ $unid->acciones }}</td>
                                                <td>
                                                  <a href="{{ route('archivo.documentoPropuestaeconomica', ['id'=>$unid->id]) }}" data-toggle="tooltip" data-theme="dark" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon" target="_blank" title="Ver documento">
                                                    <span class="svg-icon svg-icon-md">
                                                      <i class="flaticon-eye"></i>
                                                    </span> 
                                                  </a>

                                                  <button class="btn btn-sm btn-clean btn-hover-icon-success btn-icon eliminar-real" data-id="{{ $unid->id }}" data-nombre="{{ $unid->nombre_requerimiento }}" data-toggle="tooltip" data-theme="dark" title="Eliminar registro" ><i class="flaticon-delete"></i></button>
                                                </td>

                                              </tr>
                                            @endforeach
                                          </tbody>

                                          <tfoot>
                                          <tr>
                                            <th>Num.</th>
                                            <th>Nombre del requerimiento</th>
                                            <th>Descripción</th>
                                            <th>Obligatorio</th>
                                            <th>Respuesta</th>
                                            <th class="text-center">Opciones</th>
                                            <th>Opción</th>
                                          </tr>
                                          </tfoot>

                                      </table>
                                </div>
                              </div>

                            </div>



                        </div> <!-- end tabs content -->

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

{{-- M O D A L S --}}
    <form method="post" id="eliminardoc_act_form" action="{{ route('propuestatecnica.eliminardocumento') }}"
        enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="licitacion_id" value="{{ $licitacion }}">
        <input type="hidden" name="id" id="id_doc_act" value="">
    </form>


    <form method="post" id="eliminarreal_act_form" action="{{ route('propuestatecnica.eliminardocumentoreal') }}"
        enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="licitacion_id" value="{{ $licitacion }}">
        <input type="hidden" name="id" id="id_doc_real" value="">
    </form>


@endsection