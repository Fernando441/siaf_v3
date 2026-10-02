@extends('layouts.app')
@push('scripts')
    <script src="{{ asset('js/unidades/Unidadesbase.js') }}"></script> 
    <script src="{{ asset('js/unidades/AgregarUnidadesbase.js') }}"></script> 
@endpush
@section('title')
    Crear solicitud de sustitutos - validación de unidad
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
                    <h3 class="card-title">Crear solicitud de sustitutos - validación de unidad</h3>
                </div>
                <!--begin::Form-->
                <form class="form" action="{{ route('unidadessustitutas.guardarsolicitud') }}" method="post" id="frmCliente" enctype="multipart/form-data">
                    @csrf   
                    <input type='hidden' id='url_municipios' value='{{ route('cliente.obtenermunicipios') }}'>
                    <div class="card-body">

                        <div class="row">
                            @if($unidad->unidad_asignacion_id == 1)
                                @if($proyecto_info->op_sustituto == 0)
                                    <div class="col-lg-12 text-center" style="background-color: #669933">
                                        <span class="label-alert">La unidad se encuentra en un contrato </span>
                                    </div>
                                @else
                                    <div class="col-lg-12 text-center" style="background-color: #669933">
                                        <span class="label-alert">La unidad se encuentra en un contrato pero no permite unidades sustitutas</span>
                                    </div>
                                @endif

                            @else
                                <div class="col-lg-12 text-center" style="background-color: #ff4b4b">
                                    <span class="label-alert">La unidad no se encuentra en un contrato</span>
                                </div>
                            @endif
                        </div>

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

                        @if($unidad->unidad_asignacion_id == 1 && $proyecto_info->op_sustituto == 0)
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
{{--                                                             <div class="col-lg-6">
                                                                <label>Fecha y hora de solicitud</label>
                                                                <input type="datetime-local" class="form-control" name="fecha_solicitud" 
                                                                    id="fecha_solicitud" required/>
                                                            </div> --}}
                                                            <div class="col-lg-6">
                                                                <label>Motivo</label>
                                                                <select class="form-control" id="motivo" name="motivo"  required >
                                                                    <option value="">Selecciona una opción</option>
                                                                    @foreach($sustituto as $estado)
                                                                        <option value="{{ $estado->id }}" >{{ $estado->motivo }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="row form-group">
                                                            <div class="col-lg-12">
                                                                <label>Descripción del motivo</label>
                                                                <textarea class="form-control specialCharts" name="desc_motivo" id="desc_motivo"
                                                                    onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"></textarea>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <label style="color:#669933">Domicilio de resguardo de la unidad base </label>
                                                        </div>

                                                        <div class="form-group row">
                                                            <div class="col-lg-6">
                                                                <label>Estado</label>
                                                                <select class="form-control" id="id_estado" name="id_estado"  required >
                                                                    <option value="">Selecciona una opción</option>
                                                                    @foreach($estados as $estado)
                                                                        <option value="{{ $estado->id_estado }}" >{{ $estado->estado_nombre }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <label>Municipio y/o Alcaldía.</label>
                                                                <select class="form-control" id="id_municipio" name="id_municipio"  required>
                                                                    <option></option>
                        {{--                                             <option value="">Selecciona una opción</option>
                                                                    @foreach($municipios as $municipio)
                                                                        <option value="{{ $municipio->id_municipio }}" >{{ $municipio->municipio_nombre }}</option>
                                                                    @endforeach --}}
                                                                </select>
                                                            </div>
                                                        </div>


                                                        <div class="row form-group">
                                                            <div class="col-lg-5">
                                                                <label>Calle</label>
                                                                <input type="text" class="form-control" name="calle" id="calle" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                                            </div>

                                                            <div class="col-lg-5">
                                                                <label>Colonia</label>
                                                                <input type="text" class="form-control" name="colonia" id="colonia" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                                            </div>

                                                            <div class="col-lg-2">
                                                                <label>Código postal</label>
                                                                <input type="text" class="form-control" name="cp" id="cp" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <label style="color:#669933">Contacto responsable  </label>
                                                        </div>

                                                        <div class="row form-group">
                                                            <div class="col-lg-5">
                                                                <label>Nombre</label>
                                                                <input type="text" class="form-control" name="nombre_responsable" id="nombre_responsable" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                                            </div>

                                                            <div class="col-lg-5">
                                                                <label>Email</label>
                                                                <input type="text" class="form-control" name="email" id="email" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                                            </div>

                                                            <div class="col-lg-2">
                                                                <label>Telefono</label>
                                                                <input type="text" class="form-control" name="telefono" id="telefono" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
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

                                                        <div class="row form-group">
                                                            <div class="col-lg-12">
                                                                <a href="#" class="btn btn-icon btn-outline-success btn-circle btn-sm mr-2 hrefAgregarOtro" data-toggle="tooltip" data-theme="dark" title="Agregar archivo">
                                                                    <i class="flaticon2-plus"></i>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>


                                                </div>





                                            </div>

                                        <!--end::Form-->
                                    </div>
                                </div>
                            </div>

                        @endif



                        <!--end::tabs-->
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-lg-6">
                                @if($unidad->unidad_asignacion_id == 1 && $proyecto_info->op_sustituto == 0)
                                    <button type="button"  id="btnGuardarSolicitud" class="btn btn-success"><i class="la la-plus"></i>Guardar</button>
                                @else
                                    <a href="{{ route('unidadessustitutas.crearsolicutud') }}"  class="btn btn-secondary"><i class="la la-arrow-left"></i>Regresar</a>
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

@endsection