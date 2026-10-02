@extends('layouts.app')
@push('scripts')
    <script src="{{ asset('js/unidades/Unidadesbase.js') }}"></script> 
    <script src="{{ asset('js/unidades/AgregarUnidadesbaseLogistica.js') }}"></script> 
@endpush
@section('title')
    Asignar unidad sustituta
@endsection
@section('content')


<style type="text/css">
    .oculto{
        display: none;
    }
    .label-alert{
        font-size: 20px;
        color: white;
        font-weight: bold;
    }
</style>
    <!--begin::Card-->
    <div class="row">
        <div class="col-lg-12">
            <!--begin::Card-->
            <div class="card card-custom gutter-b">
                <div class="card-header">
                    <h3 class="card-title">Asignar unidad sustituta</h3>

                    @if($solicitud_sustituto->estatus == 3)
                        <div className="card-toolbar">
                            <button type="button"  id="btnfinalizarsolicitud" class="btn btn-success"></i>Finalizar solicitud</button>
                        </div>
                    @endif

                </div>
                <!--begin::Form-->
                <form class="form" action="{{ route('unidadessustitutas.addunidadsolicitud') }}" method="post" id="submit_asignarunidad" enctype="multipart/form-data">
                    @csrf   
                    {{-- <input type='hidden' id='url_municipios' value='{{ route('cliente.obtenermunicipios') }}'> --}}
                    <input type="hidden" name="id_solicitud" value={{ $id_solicitud }}>
                    <div class="card-body">

{{--                         <div class="row">
                            @if($unidad->unidad_asignacion_id == 1)
                                <div class="col-lg-12 text-center" style="background-color: #669933">
                                    <span class="label-alert">La unidad se encuentra en un contrato</span>
                                </div>
                            @else
                                <div class="col-lg-12 text-center" style="background-color: #ff4b4b">
                                    <span class="label-alert">La unidad no se encuentra en un contrato</span>
                                </div>
                            @endif
                        </div> --}}

                        <div class="row mt-3">
                            <div class="col-lg-4">
                                <div class="form-group row">
                                    <div class="col-lg-6">
                                        <label>Marca</label>
                                        <p>{{ $unidad->marcaUnidad->nombre_marca }}</p>
                                    </div>
                                    <div class="col-lg-6">
                                        <label>Modelo</label>
                                        <p>{{ $unidad->modeloUnidad->nombre_modelo }}</p>
                                    </div>
                                </div>
                                <!-- -->
                                <div class="form-group row">
                                    <div class="col-lg-6">
                                        <label>No. Serie</label>
                                        <p>{{ $unidad->no_serie }}</p>
                                    </div>
                                    
                                    <div class="col-lg-6">
                                        <label>Transmision</label>
                                        <p>{{ $unidad->transmision }}</p>
                                    </div>
                                </div>
                                <!-- -->
                                <div class="form-group row">
                                    <div class="col-lg-6">
                                        <label>Placa</label>
                                        <p>{{ $unidad->placa }}</p>
                                    </div>
                                    <div class="col-lg-6">
                                        <label>Año</label>
                                        <p>{{ $unidad->unidad_year }}</p>
                                    </div>
                                </div>
                                <!-- -->
                                <div class="form-group row">
                                    <div class="col-lg-6">
                                        <label>No. Económico</label>
                                        <p>{{ $unidad->numero_economico }}</p>
                                    </div>
                                    <div class="col-lg-6">
                                        <label>Color</label>
                                        <p>{{ $unidad->color }}</p>
                                    </div>

                                </div>

                            </div>

                            @if($ver == 0)
                                <div class="col-lg-8">
                                    <div class="card card-custom gutter-b">

                                        <!--begin::Form-->
                                            <div class="card-body">
                                                <div class="row">

                                                    <div class="col-lg-12 text-center mt-4">
                                                        <img alt="Logo" class="h-55px brand-logo" src="{{ asset('theme/assets/media/logos/logojetvanhq2.png') }}" />
                                                        <h4>Tu unidad no tiene fotografias.</h4>

                                                        <div class="row mt-4">
                                                            <h5>Para mayor información comunicate con dirección de operaciones.</h5>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="card-footer">

                                            </div>

                                        <!--end::Form-->
                                    </div>                   
                                </div>
                            @else
                                <div class="col-lg-8">
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
                                </div>
                            @endif
                        </div>

                        @if($unidad->unidad_asignacion_id == 1)
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card card-custom gutter-b">
                                        <div class="card-header">
                                            <h3 class="card-title">Información del Contrato</h3>
                                        </div>

                                            <div class="card-body">
                                                {{-- {{ $proyecto_info }} --}}
                                                <div class="form-group row">
                                                    <div class="col-lg-4">
                                                        <label>No. Contrato</label>
                                                        <p>{{ $proyecto_info->no_contrato }}</p>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <label>Titulo servicio</label>
                                                        <p>{{ $proyecto_info->titulo_servicio }}</p>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        @foreach($info_licitacion as $lic)
                                                            <label>Prioridad</label>
                                                            @if($lic->id_licitacion_prioridad == 1)
                                                                <p><span class="label font-weight-bold label-outline-danger label-inline" >Alta</span></p>
                                                            @endif
                                                            @if($lic->id_licitacion_prioridad == 2)
                                                                <p><span class="label font-weight-bold label-outline-warning label-inline" >Media</span></p>
                                                            @endif
                                                            @if($lic->id_licitacion_prioridad == 3)
                                                                <p><span class="label font-weight-bold label-outline-primary label-inline" >Baja</span></p>
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <div class="col-lg-4">
                                                        <label>Cliente</label>
                                                        <p>{{ $proyecto_info->client->razon_social }}</p>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <label>Fecha inicio de vigencia</label>
                                                        <p>{{ date('d/m/Y', strtotime($proyecto_info->firma_inicio_vigencia))}}</p>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <label>Fecha final de vigencia</label>
                                                        <p>{{ date('d/m/Y', strtotime($proyecto_info->firma_final_vigencia))}}</p>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    @if($proyecto_info->op_sustituto == 0)
                                                        <p><span class="label font-weight-bold label-outline-success label-inline" style="font-size: 14px;">El contrato permite unidades sustitutas</span></p>
                                                    @else
                                                        <p><span class="label font-weight-bold label-outline-danger label-inline" style="font-size: 14px;">El contrato no permite unidades sustitutas</span></p>
                                                    @endif
                                                </div>

                                            </div>

                                        <!--end::Form-->
                                    </div>
                                </div>
                            </div>



                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card card-custom gutter-b">
                                        <div class="card-header">
                                            <h3 class="card-title">Información para la sustitución</h3>
                                        </div>

                                            <div class="card-body">

                                                <ul class="nav nav-tabs nav-tabs-line">
                                                    <li class="nav-item">
                                                        <a class="nav-link active" data-toggle="tab" href="#kt_tab_pane_1">Información general</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" data-toggle="tab" href="#kt_tab_pane_2">Archivos</a>
                                                    </li>
                                                </ul>

                                                <div class="tab-content mt-5" id="myTabContent">
                                                    <div class="tab-pane fade show active mt-10" id="kt_tab_pane_1" role="tabpanel" aria-labelledby="kt_tab_pane_1">

                                                        <input type="hidden" name="proyectos_id" value="{{ $proyecto_info->id }}">
                                                        <input type="hidden" name="unidad_id_base" value="{{ $unidad->id }}">

                                                        <div class="row form-group">
                                                            <div class="col-lg-6">
                                                                <label>Fecha y hora de solicitud</label>
                                                                
                                                                <p>{{ $solicitud_sustituto->fecha_hora_solicitud }}</p>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <label>Motivo</label>
                                                                <p>{{ $solicitud_sustituto->sustitutoMotivo->motivo }}</p>
                                                            </div>
                                                        </div>

                                                        <div class="row form-group">
                                                            <div class="col-lg-12">
                                                                <label>Descripción del motivo</label>
                                                                <p>{{ $solicitud_sustituto->descripcion_motivo }}</p>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <label style="color:#669933">Domicilio de resguardo de la unidad base </label>
                                                        </div>

                                                        <div class="form-group row">
                                                            <div class="col-lg-6">
                                                                <label>Estado</label>
                                                                @foreach($estados as $estado)
                                                                    @if($solicitud_sustituto->estado_id == $estado->id_estado)
                                                                        <p>{{ $estado->estado_nombre }}</p>
                                                                    @endif
                                                                @endforeach
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <label>Municipio y/o Alcaldía.</label>
                                                                 @foreach($municipios as $municipio)
                                                                    @if($solicitud_sustituto->municipio_id == $municipio->id_municipio)
                                                                        <p>{{ $municipio->municipio_nombre }}</p>
                                                                    @endif
                                                                @endforeach
                                                            </div>
                                                        </div>


                                                        <div class="row form-group">
                                                            <div class="col-lg-5">
                                                                <label>Calle</label>
                                                                <p>{{ $solicitud_sustituto->calle }}</p>
                                                            </div>

                                                            <div class="col-lg-5">
                                                                <label>Colonia</label>
                                                                <p>{{ $solicitud_sustituto->coloni }}</p>
                                                            </div>

                                                            <div class="col-lg-2">
                                                                <label>Código postal</label>
                                                                <p>{{ $solicitud_sustituto->codigo_postal }}</p>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <label style="color:#669933">Contacto responsable  </label>
                                                        </div>

                                                        <div class="row form-group">
                                                            <div class="col-lg-5">
                                                                <label>Nombre</label>
                                                                <p>{{ $solicitud_sustituto->nombre_responsable }}</p>
                                                            </div>

                                                            <div class="col-lg-5">
                                                                <label>Email</label>
                                                                <p>{{ $solicitud_sustituto->email }}</p>
                                                            </div>

                                                            <div class="col-lg-2">
                                                                <label>Telefono</label>
                                                                <p>{{ $solicitud_sustituto->telefono }}</p>
                                                            </div>

                                                        </div>
                                                    </div>


                                                    <div class="tab-pane fade mt-10" id="kt_tab_pane_2" role="tabpanel" aria-labelledby="kt_tab_pane_2">

                                                        <div class="row form-group" >
                                                            <div class="col-lg-12" id="tblArchivos">
                                                                <table class='table table-bordered table-hover' id='tblDocumentos'>
                                                                    <thead>
                                                                    <tr>
                                                                        <th>Adjuntar Documento</th>
                                                                        <th>Tipo de Documento</th>
                                                                        <th>Opción</th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody id='tbodyDocumentos'>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>


                                                    </div>


                                                </div>

                                            </div>

                                        <!--end::Form-->
                                    </div>
                                </div>
                            </div>

                            @if($solicitud_sustituto->estatus == 3)
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="card card-custom gutter-b">
                                            <div class="card-header">
                                                <h3 class="card-title">Unidad sustituta</h3>
                                                <div className="card-toolbar">
                                                    <button type="button"  id="btneliminarunidad" class="btn btn-danger"></i>Eliminar unidad</button>
                                                </div>



                                            </div>

                                                <div class="card-body">
                                                    <div class="row mt-3">
                                                        <div class="col-lg-4">
                                                            <div class="form-group row">
                                                                <div class="col-lg-6">
                                                                    <label>Marca</label>
                                                                    <p>{{ $unidad_sustituta->marcaUnidad->nombre_marca }}</p>
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <label>Modelo</label>
                                                                    <p>{{ $unidad_sustituta->modeloUnidad->nombre_modelo }}</p>
                                                                </div>
                                                            </div>
                                                            <!-- -->
                                                            <div class="form-group row">
                                                                <div class="col-lg-6">
                                                                    <label>No. Serie</label>
                                                                    <p>{{ $unidad_sustituta->no_serie }}</p>
                                                                </div>
                                                                
                                                                <div class="col-lg-6">
                                                                    <label>Transmision</label>
                                                                    <p>{{ $unidad_sustituta->transmision }}</p>
                                                                </div>
                                                            </div>
                                                            <!-- -->
                                                            <div class="form-group row">
                                                                <div class="col-lg-6">
                                                                    <label>Placa</label>
                                                                    <p>{{ $unidad_sustituta->placa }}</p>
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <label>Año</label>
                                                                    <p>{{ $unidad_sustituta->unidad_year }}</p>
                                                                </div>
                                                            </div>
                                                            <!-- -->
                                                            <div class="form-group row">
                                                                <div class="col-lg-6">
                                                                    <label>No. Económico</label>
                                                                    <p>{{ $unidad_sustituta->numero_economico }}</p>
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <label>Color</label>
                                                                    <p>{{ $unidad_sustituta->color }}</p>
                                                                </div>

                                                            </div>

                                                        </div>

                                                        @if($ver_s == 0)
                                                            <div class="col-lg-8">
                                                                <div class="card card-custom gutter-b">

                                                                    <!--begin::Form-->
                                                                        <div class="card-body">
                                                                            <div class="row">

                                                                                <div class="col-lg-12 text-center mt-4">
                                                                                    <img alt="Logo" class="h-55px brand-logo" src="{{ asset('theme/assets/media/logos/logojetvanhq2.png') }}" />
                                                                                    <h4>Tu unidad no tiene fotografias.</h4>

                                                                                    <div class="row mt-4">
                                                                                        <h5>Para mayor información comunicate con dirección de operaciones.</h5>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                        </div>
                                                                        <div class="card-footer">

                                                                        </div>

                                                                    <!--end::Form-->
                                                                </div>                   
                                                            </div>
                                                        @else
                                                            <div class="col-lg-8">
                                                                <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                                                                  <div class="carousel-inner">

                                                                    @foreach($fotografias_sustitutas as $documento)
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
                                                            </div>
                                                        @endif
                                                    </div>


                                                </div>
                                            <!--end::Form-->
                                        </div>
                                    </div>
                                </div>


                            @else
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="card card-custom gutter-b">
                                            <div class="card-header">
                                                <h3 class="card-title">Seleccionar unidad a la solicitud</h3>
                                            </div>

                                                <div class="card-body">

                                                    <table class="table table-hover table-checkable" id="kdatatable_search_unidad">
                                                        <thead>
                                                        <tr>
                                                            <th>Folio</th>
                                                            <th>Marca</th>
                                                            <th>Modelo</th>
                                                            <th>Serie</th>
                                                            <th>Placa</th>
                                                            <th>Número económico</th>
                                                            <th>Año</th>
                                                            <th>Acción</th>
                                                        </tr>
                                                        </thead>

                                                        <tbody>
                                                          @foreach($ubicacion_data as $unid)
                                                            <tr>
                                                              <td>{{ $unid->folio }}</td>
                                                              <td>{{ $unid->nombre_marca }}</td>
                                                              <td>{{ $unid->nombre_modelo }}</td>
                                                              <td>{{ $unid->no_serie }}</td>
                                                              <td>{{ $unid->placa }}</td>
                                                              <td>{{ $unid->numero_economico }}</td>
                                                              <td>{{ $unid->unidad_year }}</td>
                                                              <td>
                                                                  <input type="radio" class="form-check-input" name="radios" id="radio1" value="{{ $unid->id }}" />


                                                              </td>
                                                            </tr>

                                                          @endforeach
                                                        </tbody>

                                                        <tfoot>
                                                        <tr>
                                                            <th>Folio</th>
                                                            <th>Marca</th>
                                                            <th>Modelo</th>
                                                            <th>Serie</th>
                                                            <th>Placa</th>
                                                            <th>Número económico</th>
                                                            <th>Año</th>
                                                            <th>Acción</th>
                                                        </tr>
                                                        </tfoot>
                                                    </table>
                                                    <input type="hidden" id="datatable_i18n" value="{{ asset('/js/datatables/i18n/es-mx.json') }}">

                                                </div>
                                            <!--end::Form-->
                                        </div>
                                    </div>
                                </div>

                            @endif
                        @endif



                        <!--end::tabs-->
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-lg-6">
                                    <a href="{{ route('unidadessustitutas.listadosustitutologistica') }}"  class="btn btn-secondary"><i class="la la-arrow-left"></i>Regresar</a>
                                    @if($solicitud_sustituto->estatus == 3)
                                    @else
                                        <button type="button"  id="btnGuardarSolicitud" class="btn btn-success"><i class="la la-plus"></i>Guardar</button>
                                    @endif
                                    
                                    
                            </div>
                        </div>
                    </div>
                </form>
                <!--end::Form-->
            </div>
            <!--end::Card-->
        </div>
    </div>
    <!--end::Card-->
@if($solicitud_sustituto->estatus == 3)

    <form method="post" id="eliminar_sustituto" action="{{ route('unidadessustitutas.deleteunidadsolicitud') }}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="id_unidad" id="id_unidad" value="{{ $unidad_sustituta->id }}">
        <input type="hidden" name="id_solicitud" value="{{ $solicitud_sustituto->id }}">
    </form>

    <form method="post" id="finalizar_sustituto" action="{{ route('unidadessustitutas.finalizarsolicitud') }}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="id_solicitud" value="{{ $solicitud_sustituto->id }}">
    </form>

@endif


@endsection