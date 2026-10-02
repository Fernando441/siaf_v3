@extends('layouts.app')
@push('scripts')
	<script src="{{ asset('js/unidades/translados/Translados.js') }}"></script>
@endpush
@section('title')
    Solicitud de traslado
@endsection
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
                                <h3 class="card-label">Ver solicitud de traslado</h3>
                            </div>
                            <div class="card-toolbar">

                                <!--begin::Button-->
                                <a href="{{ route('controlsol.controlsolicitudes') }}" class="btn btn-light-primary font-weight-bolder mr-3 ml-3">
                                  Regresar</a>
                                <!--end::Button-->

                            </div>
                        </div>
                        <div class="card-body">

                            <form action="{{ route('movimientoslog.unidadestranslados') }}" method="post" id="submit_carga" enctype="multipart/form-data">
                            @csrf

                                <div class="row">
                                    <div class="col-lg-4 mt-2 form-group">
                                        <label>Titulo del translado</label>
                                        <p>{{ $solicitud->nombre_translado }}</p>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12">
                                        <label>Observaciones</label>
                                        <p>{{ $solicitud->observaciones }}</p>
                                    </div>
                                </div>


                                <div class="row mt-4">
                                    <div class="col-lg-12">
                                        <div class="card card-custom">
                                            <div class="card-header">
                                                <div class="card-title">
                                                    <span class="card-icon">
                                                        <i class="flaticon-truck text-primary"></i>
                                                    </span>
                                                    <h3 class="card-label">
                                                        Información de la solicitud
                                                    </h3>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                @if($tipo_solicitud == 1)
                                                    <div class="form-group row">
                                                        <div class="col-lg-6">
                                                            <label>Nombre de la asignación</label>
                                                            <div class="input-group">
                                                                <p>{{ $sol_asignacion->nombre_asignacion }}</p>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <label>Dirección</label>
                                                            <div class="input-group">
                                                                <p>{{ $sol_asignacion->direccion }}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col-lg-6">
                                                            <label>Subdirección</label>
                                                            <div class="input-group">
                                                                <p>{{ $sol_asignacion->sub_direccion }}</p>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <label>Coordinación</label>
                                                            <div class="input-group">
                                                                <p>{{ $sol_asignacion->coordinacion }}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col-lg-4">
                                                            <label>Area</label>
                                                            <div class="input-group">
                                                                <p>{{ $sol_asignacion->area }}</p>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <label>Partida</label>
                                                            <div class="input-group">
                                                                <p>{{ $sol_asignacion->partida }}</p>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <label>Población</label>
                                                            <div class="input-group">
                                                                <p>{{ $sol_asignacion->poblacion }}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col-lg-5">
                                                            <label>Estado</label>
                                                            @foreach($estados as $estado)
                                                                @if($sol_asignacion->id_estado == $estado->id_estado)
                                                                    <p>{{ $estado->estado_nombre }}</p>
                                                                @endif
                                                            @endforeach
                                                        </div>
                                                        <div class="col-lg-5">
                                                            <label>Municipio y/o Alcaldía.</label>
                                                             @foreach($municipios as $municipio)
                                                                @if($sol_asignacion->id_municipio == $municipio->id_municipio)
                                                                    <p>{{ $municipio->municipio_nombre }}</p>
                                                                @endif
                                                            @endforeach
                                                        </div>
                                                        <div class="col-lg-2">
                                                            <label>CP</label>
                                                            <div class="input-group">
                                                                <p>{{ $sol_asignacion->cp }}</p>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <div class="col-lg-6">
                                                            <label>Calle</label>
                                                            <div class="input-group">
                                                                <p>{{ $sol_asignacion->calle }}</p>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <label>Contacto</label>
                                                            <div class="input-group">
                                                                <p>{{ $sol_asignacion->contacto }}</p>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label>Observaciones</label>
                                                        <p>{{ $sol_asignacion->observaciones }}</p>
                                                    </div>


                                                    <div class="row">
                                                        <div class="col-lg-12">
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
                                                                        </tr>
                                                                        </thead>

                                                                        <tbody>
                                                                          @foreach($unidades_seleccionadas as $unid)
                                                                            <tr>
                                                                              <td> <a href="{{ route('movimientoslog.verinfounidadtraslado', [$id_translado,$unid->id]) }}">{{ $unid->no_serie }}</a></td>
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
                                                        </div>
                                                    </div>


                    {{-- sustituto --}}        @else

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
                                                                    <p> <a href="{{ route('movimientoslog.verinfounidadtraslado', [$id_translado,$unidad->id]) }}">{{ $unidad->no_serie }}</a></p>
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

                                                        @if($solicitud_sustituto->estatus == 3 || $solicitud_sustituto->estatus == 4)
                                                            <div class="row">
                                                                <div class="col-lg-12">
                                                                    <div class="card card-custom gutter-b">
                                                                        <div class="card-header">
                                                                            <h3 class="card-title">Unidad sustituta</h3>
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
                                                                                                <p> <a href="{{ route('movimientoslog.verinfounidadtraslado', [$id_translado,$unidad_sustituta->id]) }}">{{ $unidad_sustituta->no_serie }}</a></p>
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


                                                                            </div>
                                                                        <!--end::Form-->
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        @endif
                                                    @endif
    {{-- end tipo solicitud --}}               @endif
{{--                                                 <table class="table table-hover table-checkable" id="kdatatable_unidades_seleccionadas">
                                                            <thead>
                                                            <tr>
                                                                <th>Ubicación unidad</th>
                                                                <th>Marca</th>
                                                                <th>Modelo</th>
                                                                <th>Serie</th>
                                                                <th>Placa</th>
                                                                <th>Año</th>
                                                                <th>Requerimiento</th>
                                                                <th>Transladadora</th>
                                                                <th>Origen</th>
                                                                <th>Cto. Origen</th>
                                                                <th>Destino</th>
                                                                <th>Cto. Destino</th>
                                                                <th>Estatus</th>
                                                                <th>Tipo de asignación</th>
                                                                <th>Fecha de translado</th>
                                                                <th>Transladista</th>
                                                                <th>Acción</th>
                                                            </tr>
                                                            </thead>

                                                            <tbody>
                                                              @foreach($unidades_seleccionadas as $unid)
                                                                <tr>
                                                                    <td>
                                                                        @if($unid->ubicacion == null)
                                                                           <b>Folio contrato:</b> {{ $unid->no_folio }}
                                                                        @else
                                                                            <b>Patio:</b> {{ $unid->ubicacion }}  
                                                                        @endif
                                                                        
                                                                    </td>
                                                                    <td>{{ $unid->nombre_marca }}</td>
                                                                    <td>{{ $unid->nombre_modelo }}</td>
                                                                    <td><a href="{{ route('movimientoslog.unidadestranslado', [$id_translado,$unid->id]) }}">{{ $unid->no_serie }}</a></td>
                                                                    <td>{{ $unid->placa }}</td>
                                                                    <td>{{ $unid->unidad_year }}</td>
                                                                    <td>{{ $unid->requerimiento }}</td>
                                                                    <td>{{ $unid->transladadora }}</td>
                                                                    <td>{{ $unid->origen }}</td>
                                                                    <td>{{ $unid->cto_origen }}</td>
                                                                    <td>{{ $unid->destino }}</td>
                                                                    <td>{{ $unid->cto_destino }}</td>
                                                                    <td>{{ $unid->estatus }}</td>
                                                                    <td> {{ $unid->asignacion_translado }} </td>
                                                                    <td> {{ $unid->fecha_translado }}  </td>
                                                                    <td>{{ $unid->name }} </td>
                                                                  <td>
                                                                    <a  class="eliminar-unidad btn btn-sm btn-clean btn-hover-icon-success btn-icon btn-icon mr-2"  data-id="{{ $unid->id }}" data-nombre="{{ $unid->no_serie }}" title="Eliminar unidad" data-theme="dark" data-toggle="tooltip" data-placement="top">
                                                                        <span class="svg-icon svg-icon-md">
                                                                            <i class="flaticon-delete"></i>
                                                                        </span>
                                                                    </a>
                                                                  </td>
                                                                </tr>

                                                              @endforeach
                                                            </tbody>

                                                            <tfoot>
                                                            <tr>
                                                                <th>Ubicación unidad</th>
                                                                <th>Marca</th>
                                                                <th>Modelo</th>
                                                                <th>Serie</th>
                                                                <th>Placa</th>
                                                                <th>Año</th>
                                                                <th>Requerimiento</th>
                                                                <th>Transladadora</th>
                                                                <th>Origen</th>
                                                                <th>Cto. Origen</th>
                                                                <th>Destino</th>
                                                                <th>Cto. Destino</th>
                                                                <th>Estatus</th>
                                                                <th>Tipo de asignación</th>
                                                                <th>Fecha de translado</th>
                                                                <th>Transladista</th>
                                                                <th>Acción</th>
                                                            </tr>
                                                            </tfoot>

                                                </table> --}}
                                                <input type="hidden" id="datatable_i18n" value="{{ asset('/js/datatables/i18n/es-mx.json') }}">
                                            </div>

                                        </div>
                                    </div>
                                </div>

                            </form>




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
