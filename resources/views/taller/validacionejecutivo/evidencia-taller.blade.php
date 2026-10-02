@extends('layouts.app')

@section('title')
    Asignar taller a la solicitud
@endsection
@push('scripts')
    <script src="{{ asset('js/taller/CatalogoTaller.js') }}"></script>
    <script src="{{ asset('js/taller/EvidenciasSolicitudTaller.js') }}"></script>
@endpush


@section('content')
<style type="text/css">
  .oculto{
    display: none;
  }
</style>
    <!--begin::Card-->
    <div class="row">
        <div class="col-lg-12">
            <!--begin::Card-->
            <div class="card card-custom gutter-b">
                <div class="card-header">
                  @if($solicitudes->op_taller== 0 )
                    <h3 class="card-title">Asignar taller a la solicitud</h3>
                  @else
                    <div class="card-title">

                    </div>
                      @if($solicitudes->taller_solicitud_estado_id == 1 || $solicitudes->taller_solicitud_estado_id == 3)
                        <div class="card-toolbar">
                            <button id="delete_taller_solicitud" class="btn btn-sm btn-danger font-weight-bold">
                                {{-- <i class="flaticon2-cube"></i> --}} Quitar taller de la solicitud
                            </button>
                        </div>
                      @endif
                  @endif
                </div>
                <!--begin::Form-->
                    <div class="card-body">
                        @if($solicitudes->op_taller== 0)
                            <!--begin: Datatable-->
                            <table class="table table-hover table-checkable" id="kdatatable_talleres_inactivos">
                                <thead>
                                <tr>
                                  <th>Nombre</th>
                                  <th>Dirección</th>
                                  <th>Telefono</th>
                                  <th>Correo</th>
                                  <th>Municipio</th>
                                  <th>Estado</th>
                                  <th class="text-center">Opciones</th>
                                </tr>
                                </thead>

                                <tbody>
                                  @foreach($talleres as $unid)
                                    <tr>
                                      <td><a href="{{ route('taller.complementartallersol', [$id_solicitud, $unid->id ]) }}">{{ $unid->alias }}</a></td>
                                      <td>{{ $unid->direccion }}</td>
                                      <td>{{ $unid->telefono }}</td>
                                      <td>{{ $unid->correo }}</td>
                                      <td>{{ $unid->municipio_nombre }}</td>
                                      <td>{{ $unid->estado_nombre }}</td>

                                      <td class="text-center">
                                        <a href="{{ route('taller.complementartallersol', [$id_solicitud, $unid->id ]) }}" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon" data-id="{{ $unid->id }}" data-nombre="{{ $unid->alias }}" data-toggle="tooltip" data-theme="dark" title="Seleccionar Taller"> <i class="flaticon-eye"></i></a>
                                      </td>
                                    </tr>
                                  @endforeach
                                </tbody>

                                <tfoot>
                                <tr>
                                  <th>Nombre</th>
                                  <th>Dirección</th>
                                  <th>Telefono</th>
                                  <th>Correo</th>
                                  <th>Municipio</th>
                                  <th>Estado</th>
                                  <th class="text-center">Opciones</th>
                                </tr>
                                </tfoot>

                            </table>
                            <!--end: Datatable-->

                            <input type="hidden" id="datatable_i18n" value="{{ asset('/js/datatables/i18n/es-mx.json') }}">
                        @else

                            <div class="row">
                              <div class="col-lg-6"></div>
                              <div class="col-lg-3 text-center">
                                <label>Fecha de asignación</label> <br>
                                <b>{{ $asignado_id->fecha_asignacion }}</b>
                              </div>
                              <div class="col-lg-3 text-center">
                                <label>Usuario que asigno al taller</label>
                                <b>{{ $asignado_id->userCreated->name }}</b>
                              </div>
                            </div>

                                    <div class="card card-custom gutter-b">
                                      <div class="card-header">
                                        <div class="card-title">
                                          <h3 class="card-label">
                                            Información del taller asignado
                                          </h3>
                                        </div>

                                      </div>
                                      <div class="card-body">
                                        <div class="form-group row">
                                          <div class="col-lg-4">
                                            <label>Nombre</label>
                                            <p>{{ $taller->nombre }}</p>
                                          </div>

                                          <div class="col-lg-4">
                                            <label>Alias</label>
                                            <p>{{ $taller->alias }}</p>
                                          </div>

                                          <div class="col-lg-4">
                                            <label>Dirección</label>
                                            <p>{{ $taller->direccion }}</p>
                                          </div>
                                        </div>

                                        <div class="form-group row">
                                          <div class="col-lg-4">
                                            <label>Telefono local</label>
                                            <p>{{ $taller->tel_local }}</p>
                                          </div>

                                          <div class="col-lg-4">
                                            <label>Telefono celular</label>
                                            <p>{{ $taller->tel_celular }}</p>
                                          </div>

                                          <div class="col-lg-4">
                                            <label>Correo</label>
                                            <p>{{ $taller->correo }}</p>
                                          </div>
                                        </div>


                                        <div class="form-group row">
                                          <div class="col-lg-4">
                                            <label>Estado</label>
                                            <p>{{ $taller->estado_nombre }}</p>
                                          </div>

                                          <div class="col-lg-4">
                                            <label>Municipio</label>
                                            <p>{{ $taller->municipio_nombre }}</p>
                                          </div>

                                          <div class="col-lg-4">
                                            <label>Coordenadas</label>
                                            <p>{{ $taller->coordenadas }}</p>
                                          </div>
                                        </div>

                                        <div class="row">
                                          <h4 class="card-title">Servicios</h4>
                                        </div>

                                        <div class="row">
                                          @foreach($servicios_asignados as $value)
                                            <div class="col-md-4">
                                              <div class="form-group">
                                                <span class="switch switch-icon">
                                                <label> {{ $value->servicio->servicio }}
                                                <input type="checkbox" name="servicio[]" checked disabled class='tablero_check all_generales' value="{{ $value->id }}" />
                                                <span></span>
                                                </label>
                                                </span>
                                              </div>
                                            </div>            
                                          @endforeach
                                        </div>


                                      </div>
                                    </div>


                        @endif
                    </div>
{{--                     <div class="card-footer">
                        <div class="row">
                            <div class="col-lg-6">
                                <a href="{{ route('taller.serviciossolicitados') }}"  class="btn btn-secondary"> <i class="la la-arrow-left"></i>Regresar</a>
                            </div>
                        </div>
                    </div> --}}

                <!--end::Form-->
            </div>

            @if( $solicitudes->taller_solicitud_estado_id == 4)
            {{-- evidencias --}}
            <input type="hidden" id="documentoEliminarPath" value="{{ route('taller.eliminarevidenciataller') }}">
            
              <form class="form" action="{{ route('taller.evidenciassolicitudtaller') }}" method="post" id="frmCliente" enctype="multipart/form-data">
                  @csrf 
                <input type="hidden" name="id_solicitud" value="{{ $solicitudes->id }}">
                <div class="card card-custom">
                  <div class="card-header">
                    <div class="card-title">
                            <span class="card-icon">
                                {{-- <i class="flaticon2-chat-1 text-primary"></i> --}}
                            </span>
                      <h3 class="card-label">
                        Evidencias del taller
                      </h3>
                    </div>

                  </div>
                  <div class="card-body">

                            <table class="table table-hover mb-6 table-responsive-sm" id="tblDocumentos">
                                <thead>
                                <tr>
                                    <th scope="col">Documento</th>
                                    <th scope="col">Tipo de Documento</th>
                                    {{-- <th scope="col">Opción</th> --}}
                                </tr>
                                </thead>
                                <tbody id='tbodyDocumentos'>
                                    @foreach($documentos as $documento)
                                        <tr id="trDocumento{{ $documento->id }}">
                                            <td><a href="{{ route('archivo.evidenciamantenimiento', ['id'=>$documento->id]) }}" class="link-primary" target="_blank"> {{ $documento->evidencia }} </a></td>
                                            <td>{{ $documento->evidencia }}</td>
{{--                                             <td>
                                                <a href='#' class='btn btn-sm btn-clean btn-hover-icon-success btn-icon hrefEliminarDocumento' data-id='{{ $documento->id }}' data-documento='{{ $documento->documento }}'  data-toggle='tooltip' data-theme='dark' title='Eliminar'>
                                                    <i class='flaticon-delete'></i>
                                                </a>
                                            </td> --}}
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

{{--                             <div class="row form-group">
                                <div class="col-lg-12">
                                    <a href="#" class="btn btn-icon btn-outline-success btn-circle btn-sm mr-2 hrefAgregarOtro" data-toggle="tooltip" data-theme="dark" title="Agregar archivo">
                                        <i class="flaticon2-plus"></i>
                                    </a>
                                </div>
                            </div> --}}


                        {{-- <button type="button"  id="btnGuardar" class="btn btn-success"><i class="la la-plus"></i>Guardar evidencias</button> --}}
             
                  </div>
                </div>
              </form>



                <div class="card card-custom mt-4">
                  <div class="card-header">
                    <div class="card-title">
                            <span class="card-icon">
                                {{-- <i class="flaticon2-chat-1 text-primary"></i> --}}
                            </span>
                      <h3 class="card-label">
                        Evaluar del taller
                      </h3>
                    </div>

                  </div>
                  <div class="card-body">
                    @if($evaluacion_taller == null)
                    <form class="form" action="{{ route('taller.evaluaciontallerejecutivo') }}" method="post" id="frmCliente" enctype="multipart/form-data">
                    @csrf 
                      <input type="hidden" name="id_solicitud" value="{{ $solicitudes->id }}">
                            <table class="table  mb-6 table-responsive-sm">
                                <thead>
                                <tr>
                                    <th scope="col">Categoria</th>
                                    <th scope="col">Criterio</th>
                                    <th scope="col" width="260">Calificación</th>
                                    <th scope="col" width="260">Obervaciones</th>
                                </tr>
                                </thead>
                                <tbody>
                                  <tr>
                                    <td><b>Técnica</b></td>
                                    <td>Calidad del trabajo (sin recurrencias, buena ejecución)</td>
                                    <td scope="col">
                                      <div class="row">
                                        <div class="col-lg-7">
                                          <select class="form-control gray_area" id="tecnica_uno" name="tecnica_uno"  required >
                                              <option value="1" selected>Inaceptable</option>
                                              <option value="2" >Deficiente</option>
                                              <option value="3" >Regular</option>
                                              <option value="4" >Bueno</option>
                                              <option value="5" >Excelente</option>
                                          </select>
                                        </div>
                                        <div class="col-lg-5">
                                          <img width="20" id="tecnica_uno_st1"  src="{{ asset('theme/assets/media/logos/stars_uno.png') }}" />
                                          <img width="40" id="tecnica_uno_st2" class="oculto"  src="{{ asset('theme/assets/media/logos/stars_dos.png') }}" />
                                          <img width="60" id="tecnica_uno_st3" class="oculto"  src="{{ asset('theme/assets/media/logos/stars_tres.png') }}" />
                                          <img width="80" id="tecnica_uno_st4" class="oculto"  src="{{ asset('theme/assets/media/logos/stars_cuatro.png') }}" />
                                          <img width="95" id="tecnica_uno_st5" class="oculto"  src="{{ asset('theme/assets/media/logos/stars.png') }}" />
                                        </div>
                                      </div>
                                    </td>
                                    <td>
                                      <textarea class="form-control" name="tecnica_uno_ob"></textarea>
                                    </td>
                                  </tr>

                                  <tr>
                                    <td><b>Operativa</b></td>
                                    <td>Tiempo de respuesta (desde la solicitud)</td>
                                    <td>
                                      <div class="row">
                                        <div class="col-lg-7">
                                          <select class="form-control gray_area" id="operativa_uno" name="operativa_uno"  required >
                                              <option value="1" selected>Inaceptable</option>
                                              <option value="2" >Deficiente</option>
                                              <option value="3" >Regular</option>
                                              <option value="4" >Bueno</option>
                                              <option value="5" >Excelente</option>
                                          </select>
                                        </div>
                                        <div class="col-lg-5">
                                          <img width="20" id="operativa_uno_st1"  src="{{ asset('theme/assets/media/logos/stars_uno.png') }}" />
                                          <img width="40" id="operativa_uno_st2" class="oculto"  src="{{ asset('theme/assets/media/logos/stars_dos.png') }}" />
                                          <img width="60" id="operativa_uno_st3" class="oculto"  src="{{ asset('theme/assets/media/logos/stars_tres.png') }}" />
                                          <img width="80" id="operativa_uno_st4" class="oculto"  src="{{ asset('theme/assets/media/logos/stars_cuatro.png') }}" />
                                          <img width="95" id="operativa_uno_st5" class="oculto"  src="{{ asset('theme/assets/media/logos/stars.png') }}" />
                                        </div>
                                      </div>
                                    </td>
                                    <td><textarea class="form-control" name="operativa_uno_ob"></textarea></td>
                                  </tr>

                                  <tr>
                                    <td></td>
                                    <td>Cumplimiento en el tiempo de entrega establecido</td>
                                    <td>
                                      <div class="row">
                                        <div class="col-lg-7">
                                          <select class="form-control gray_area" id="operativa_dos" name="operativa_dos" required >
                                              <option value="1" selected>Inaceptable</option>
                                              <option value="2" >Deficiente</option>
                                              <option value="3" >Regular</option>
                                              <option value="4" >Bueno</option>
                                              <option value="5" >Excelente</option>
                                          </select>
                                        </div>
                                        <div class="col-lg-5">
                                          <img width="20" id="operativa_dos_st1"  src="{{ asset('theme/assets/media/logos/stars_uno.png') }}" />
                                          <img width="40" id="operativa_dos_st2" class="oculto"  src="{{ asset('theme/assets/media/logos/stars_dos.png') }}" />
                                          <img width="60" id="operativa_dos_st3" class="oculto"  src="{{ asset('theme/assets/media/logos/stars_tres.png') }}" />
                                          <img width="80" id="operativa_dos_st4" class="oculto"  src="{{ asset('theme/assets/media/logos/stars_cuatro.png') }}" />
                                          <img width="95" id="operativa_dos_st5" class="oculto"  src="{{ asset('theme/assets/media/logos/stars.png') }}" />
                                        </div>
                                      </div>
                                    </td>
                                    <td><textarea class="form-control" name="operativa_dos_ob"></textarea></td>
                                  </tr>

                                  <tr>
                                    <td></td>
                                    <td>Cobertura y disponibilidad (zonas, horarios)</td>
                                    <td>
                                      <div class="row">
                                        <div class="col-lg-7">
                                          <select class="form-control gray_area" id="operativa_tres" name="operativa_tres"  required >
                                              <option value="1" selected>Inaceptable</option>
                                              <option value="2" >Deficiente</option>
                                              <option value="3" >Regular</option>
                                              <option value="4" >Bueno</option>
                                              <option value="5" >Excelente</option>
                                          </select>
                                        </div>
                                        <div class="col-lg-5">
                                          <img width="20" id="operativa_tres_st1"  src="{{ asset('theme/assets/media/logos/stars_uno.png') }}" />
                                          <img width="40" id="operativa_tres_st2" class="oculto"  src="{{ asset('theme/assets/media/logos/stars_dos.png') }}" />
                                          <img width="60" id="operativa_tres_st3" class="oculto"  src="{{ asset('theme/assets/media/logos/stars_tres.png') }}" />
                                          <img width="80" id="operativa_tres_st4" class="oculto"  src="{{ asset('theme/assets/media/logos/stars_cuatro.png') }}" />
                                          <img width="95" id="operativa_tres_st5" class="oculto"  src="{{ asset('theme/assets/media/logos/stars.png') }}" />
                                        </div>
                                      </div>
                                    </td>
                                    <td><textarea class="form-control" name="operativa_tres_ob"></textarea></td>
                                  </tr>
                                  {{-- // Operativa --}}
                                  <tr>
                                    <td><b>Administrativa</b></td>
                                    <td>Documentación completa (evidencias, cotización, factura)</td>
                                    <td>
                                      <div class="row">
                                        <div class="col-lg-7">
                                          <select class="form-control gray_area" id="admin_uno" name="admin_uno"  required >
                                              <option value="1" selected>Inaceptable</option>
                                              <option value="2" >Deficiente</option>
                                              <option value="3" >Regular</option>
                                              <option value="4" >Bueno</option>
                                              <option value="5" >Excelente</option>
                                          </select>
                                        </div>
                                        <div class="col-lg-5">
                                          <img width="20" id="admin_uno_st1"  src="{{ asset('theme/assets/media/logos/stars_uno.png') }}" />
                                          <img width="40" id="admin_uno_st2" class="oculto"  src="{{ asset('theme/assets/media/logos/stars_dos.png') }}" />
                                          <img width="60" id="admin_uno_st3" class="oculto"  src="{{ asset('theme/assets/media/logos/stars_tres.png') }}" />
                                          <img width="80" id="admin_uno_st4" class="oculto"  src="{{ asset('theme/assets/media/logos/stars_cuatro.png') }}" />
                                          <img width="95" id="admin_uno_st5" class="oculto"  src="{{ asset('theme/assets/media/logos/stars.png') }}" />
                                        </div>
                                      </div>
                                    </td>
                                    <td><textarea class="form-control" name="admin_uno_ob"></textarea></td>
                                  </tr>

                                  <tr>
                                    <td></td>
                                    <td>Claridad y desgloses en cotización</td>
                                    <td>
                                      <div class="row">
                                        <div class="col-lg-7">
                                          <select class="form-control gray_area" id="admin_dos" name="admin_dos"  required >
                                              <option value="1" selected>Inaceptable</option>
                                              <option value="2" >Deficiente</option>
                                              <option value="3" >Regular</option>
                                              <option value="4" >Bueno</option>
                                              <option value="5" >Excelente</option>
                                          </select>
                                        </div>
                                        <div class="col-lg-5">
                                          <img width="20" id="admin_dos_st1"  src="{{ asset('theme/assets/media/logos/stars_uno.png') }}" />
                                          <img width="40" id="admin_dos_st2" class="oculto"  src="{{ asset('theme/assets/media/logos/stars_dos.png') }}" />
                                          <img width="60" id="admin_dos_st3" class="oculto"  src="{{ asset('theme/assets/media/logos/stars_tres.png') }}" />
                                          <img width="80" id="admin_dos_st4" class="oculto"  src="{{ asset('theme/assets/media/logos/stars_cuatro.png') }}" />
                                          <img width="95" id="admin_dos_st5" class="oculto"  src="{{ asset('theme/assets/media/logos/stars.png') }}" />
                                        </div>
                                      </div>
                                    </td>
                                    <td><textarea class="form-control" name="admin_dos_ob"></textarea></td>
                                  </tr>

                                  <tr>
                                    <td></td>
                                    <td>Registro y trazabilidad del servicio</td>
                                    <td>
                                      <div class="row">
                                        <div class="col-lg-7">
                                          <select class="form-control gray_area" id="admin_tres" name="admin_tres"  required >
                                              <option value="1" selected>Inaceptable</option>
                                              <option value="2" >Deficiente</option>
                                              <option value="3" >Regular</option>
                                              <option value="4" >Bueno</option>
                                              <option value="5" >Excelente</option>
                                          </select>
                                        </div>
                                        <div class="col-lg-5">
                                          <img width="20" id="admin_tres_st1"  src="{{ asset('theme/assets/media/logos/stars_uno.png') }}" />
                                          <img width="40" id="admin_tres_st2" class="oculto"  src="{{ asset('theme/assets/media/logos/stars_dos.png') }}" />
                                          <img width="60" id="admin_tres_st3" class="oculto"  src="{{ asset('theme/assets/media/logos/stars_tres.png') }}" />
                                          <img width="80" id="admin_tres_st4" class="oculto"  src="{{ asset('theme/assets/media/logos/stars_cuatro.png') }}" />
                                          <img width="95" id="admin_tres_st5" class="oculto"  src="{{ asset('theme/assets/media/logos/stars.png') }}" />
                                        </div>
                                      </div>
                                    </td>
                                    <td><textarea class="form-control" name="admin_tres_ob"></textarea></td>
                                  </tr>
                                  {{-- Administrativa --}}

                                  <tr>
                                    <td><b>Servicio al Cliente</b></td>
                                    <td>Trato hacia el personal de JETVAN</td>
                                    <td>
                                      <div class="row">
                                        <div class="col-lg-7">
                                          <select class="form-control gray_area" id="serv_uno" name="serv_uno"  required >
                                              <option value="1" selected>Inaceptable</option>
                                              <option value="2" >Deficiente</option>
                                              <option value="3" >Regular</option>
                                              <option value="4" >Bueno</option>
                                              <option value="5" >Excelente</option>
                                          </select>
                                        </div>
                                        <div class="col-lg-5">
                                          <img width="20" id="serv_uno_st1"  src="{{ asset('theme/assets/media/logos/stars_uno.png') }}" />
                                          <img width="40" id="serv_uno_st2" class="oculto"  src="{{ asset('theme/assets/media/logos/stars_dos.png') }}" />
                                          <img width="60" id="serv_uno_st3" class="oculto"  src="{{ asset('theme/assets/media/logos/stars_tres.png') }}" />
                                          <img width="80" id="serv_uno_st4" class="oculto"  src="{{ asset('theme/assets/media/logos/stars_cuatro.png') }}" />
                                          <img width="95" id="serv_uno_st5" class="oculto"  src="{{ asset('theme/assets/media/logos/stars.png') }}" />
                                        </div>
                                      </div>
                                    </td>
                                    <td><textarea class="form-control" name="serv_uno_ob"></textarea></td>
                                  </tr>

                                  <tr>
                                    <td></td>
                                    <td>Disposición para negociar o resolver problemas</td>
                                    <td>
                                      <div class="row">
                                        <div class="col-lg-7">
                                          <select class="form-control gray_area" id="serv_dos" name="serv_dos"  required >
                                              <option value="1" selected>Inaceptable</option>
                                              <option value="2" >Deficiente</option>
                                              <option value="3" >Regular</option>
                                              <option value="4" >Bueno</option>
                                              <option value="5" >Excelente</option>
                                          </select>
                                        </div>
                                        <div class="col-lg-5">
                                          <img width="20" id="serv_dos_st1"  src="{{ asset('theme/assets/media/logos/stars_uno.png') }}" />
                                          <img width="40" id="serv_dos_st2" class="oculto"  src="{{ asset('theme/assets/media/logos/stars_dos.png') }}" />
                                          <img width="60" id="serv_dos_st3" class="oculto"  src="{{ asset('theme/assets/media/logos/stars_tres.png') }}" />
                                          <img width="80" id="serv_dos_st4" class="oculto"  src="{{ asset('theme/assets/media/logos/stars_cuatro.png') }}" />
                                          <img width="95" id="serv_dos_st5" class="oculto"  src="{{ asset('theme/assets/media/logos/stars.png') }}" />
                                        </div>
                                      </div>
                                    </td>
                                    <td><textarea class="form-control" name="serv_dos_ob"></textarea></td>
                                  </tr>

                                  <tr>
                                    <td></td>
                                    <td>Resultados en encuestas de satisfacción</td>
                                    <td>
                                      <div class="row">
                                        <div class="col-lg-7">
                                          <select class="form-control gray_area" id="serv_tres" name="serv_tres"  required >
                                              <option value="1" selected>Inaceptable</option>
                                              <option value="2" >Deficiente</option>
                                              <option value="3" >Regular</option>
                                              <option value="4" >Bueno</option>
                                              <option value="5" >Excelente</option>
                                          </select>
                                        </div>
                                        <div class="col-lg-5">
                                          <img width="20" id="serv_tres_st1"  src="{{ asset('theme/assets/media/logos/stars_uno.png') }}" />
                                          <img width="40" id="serv_tres_st2" class="oculto"  src="{{ asset('theme/assets/media/logos/stars_dos.png') }}" />
                                          <img width="60" id="serv_tres_st3" class="oculto"  src="{{ asset('theme/assets/media/logos/stars_tres.png') }}" />
                                          <img width="80" id="serv_tres_st4" class="oculto"  src="{{ asset('theme/assets/media/logos/stars_cuatro.png') }}" />
                                          <img width="95" id="serv_tres_st5" class="oculto"  src="{{ asset('theme/assets/media/logos/stars.png') }}" />
                                        </div>
                                      </div>
                                    </td>
                                    <td><textarea class="form-control" name="serv_tres_ob"></textarea></td>
                                  </tr>
                                  {{-- Servicio al Cliente --}}

                                  <tr>
                                    <td><b>Financiera</b></td>
                                    <td>Relación costo-beneficio</td>
                                    <td>
                                      <div class="row">
                                        <div class="col-lg-7">
                                          <select class="form-control gray_area" id="fin_uno" name="fin_uno"  required >
                                              <option value="1" selected>Inaceptable</option>
                                              <option value="2" >Deficiente</option>
                                              <option value="3" >Regular</option>
                                              <option value="4" >Bueno</option>
                                              <option value="5" >Excelente</option>
                                          </select>
                                        </div>
                                        <div class="col-lg-5">
                                          <img width="20" id="fin_uno_st1"  src="{{ asset('theme/assets/media/logos/stars_uno.png') }}" />
                                          <img width="40" id="fin_uno_st2" class="oculto"  src="{{ asset('theme/assets/media/logos/stars_dos.png') }}" />
                                          <img width="60" id="fin_uno_st3" class="oculto"  src="{{ asset('theme/assets/media/logos/stars_tres.png') }}" />
                                          <img width="80" id="fin_uno_st4" class="oculto"  src="{{ asset('theme/assets/media/logos/stars_cuatro.png') }}" />
                                          <img width="95" id="fin_uno_st5" class="oculto"  src="{{ asset('theme/assets/media/logos/stars.png') }}" />
                                        </div>
                                      </div>
                                    </td>
                                    <td><textarea class="form-control" name="fin_uno_ob"></textarea></td>
                                  </tr>

                                  <tr>
                                    <td></td>
                                    <td>Entrega oportuna y correcta de facturación</td>
                                    <td>
                                      <div class="row">
                                        <div class="col-lg-7">
                                          <select class="form-control gray_area" id="fin_dos" name="fin_dos"  required >
                                              <option value="1" selected>Inaceptable</option>
                                              <option value="2" >Deficiente</option>
                                              <option value="3" >Regular</option>
                                              <option value="4" >Bueno</option>
                                              <option value="5" >Excelente</option>
                                          </select>
                                        </div>
                                        <div class="col-lg-5">
                                          <img width="20" id="fin_dos_st1"  src="{{ asset('theme/assets/media/logos/stars_uno.png') }}" />
                                          <img width="40" id="fin_dos_st2" class="oculto"  src="{{ asset('theme/assets/media/logos/stars_dos.png') }}" />
                                          <img width="60" id="fin_dos_st3" class="oculto"  src="{{ asset('theme/assets/media/logos/stars_tres.png') }}" />
                                          <img width="80" id="fin_dos_st4" class="oculto"  src="{{ asset('theme/assets/media/logos/stars_cuatro.png') }}" />
                                          <img width="95" id="fin_dos_st5" class="oculto"  src="{{ asset('theme/assets/media/logos/stars.png') }}" />
                                        </div>
                                      </div>
                                    </td>
                                    <td><textarea class="form-control" name="fin_dos_ob"></textarea></td>
                                  </tr>

                                </tbody>
                            </table>
                      <button type="submit"  id="btnGuardar" class="btn btn-success"><i class="la la-plus"></i>Guardar evaluación</button>
                    </form>

                    @else
                        <div class="row">
                            <div class="col-lg-8 text-center">
                                <img src="/img/administracion-permiso.png" width="420">
                            </div>
                            <div class="col-lg-4 text-center mt-4">
                                <img alt="Logo" class="h-125px brand-logo" src="{{ asset('theme/assets/media/logos/LogoJetVan-sin-fondo.png') }}" />
                                <h1>¡Evaluación realizada!</h1>
                            </div>
                        </div>
                    @endif
                  </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-lg-6">
                                <a href="{{ route('taller.Validacionmantenimientosejecutivo') }}"  class="btn btn-secondary"> <i class="la la-arrow-left"></i>Regresar</a>
                            </div>
                        </div>
                    </div>

                </div>

            @endif


            <!--end::Card-->
        </div>
    </div>
    <!--end::Card-->


  <form method="post" id="quitar_delete_form" action="{{ route('taller.eliminartallerasignado') }}" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="id_solicitud" id="id_solicitud" value="{{ $id_solicitud }}">
    <input type="hidden" name="taller" value="{{ $id_taller }}">
  </form>


@endsection


