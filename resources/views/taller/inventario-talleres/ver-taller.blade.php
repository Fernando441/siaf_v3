@extends('layouts.app')
@push('scripts')
	<script src="{{ asset('js/Taller/EditarTaller.js') }}"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
@endpush
@section('title')
    Editar taller
@endsection
@section('content')
<!--begin::Card-->

<div class="row">
    <div class="col-lg-12">
        <!--begin::Card-->
        <div class="card card-custom gutter-b">
            <div class="card-header">
            <div class="card-title">

                <h3 class="card-label">
                    Editar taller
                </h3>
            </div>
            <div class="card-toolbar">
                <h3>{{ $taller_info->calificacion }}</h3>
                {{-- <img alt="Logo" class="h-55px brand-logo" src="{{ asset('theme/assets/media/calificacion/calificacion.png') }}" /> --}}
            </div>

            </div>
            <!--begin::Form-->
            <input type="hidden" id="documentoEliminarPath" value="{{ route('invtaller.eliminardocumentotaller') }}">
            
            <form class="form" action="{{ route('invtaller.modificartaller') }}" method="post" id="frmCliente" enctype="multipart/form-data">
                @csrf
                <input type='hidden' id='url_municipios' value='{{ route('cliente.obtenermunicipios') }}'>
                <input type='hidden' id='tipoArchivo' value='{{ $cadenaTipoDocumento }}'>
                <input type="hidden" name="id_taller" id="id_taller" value="{{ $id_taller }}">
                <div class="card-body">
                    <!--begin::tabs-->
                    <ul class="nav nav-tabs nav-tabs-line">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#kt_tab_pane_1">Información del taller</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#kt_tab_pane_3">Servicios</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#kt_tab_pane_2">Documentos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#kt_tab_pane_4">Calificaciones</a>
                        </li>
                    </ul>
                    <div class="tab-content mt-5" id="myTabContent">
                        <div class="tab-pane fade show active mt-10" id="kt_tab_pane_1" role="tabpanel" aria-labelledby="kt_tab_pane_2">

                                <div class="row form-group">
                                    @if($taller_info->user_taller != null)
                                        <div class="col-lg-6">
                                            <label>Usuario</label>
                                            <p>Nombre: <b>{{ $taller_info->userTaller->name }}</b> / Correo: <b>{{ $taller_info->userTaller->email }}</b></p>
                                        </div>                                      
                                    @else
                                        <div class="col-lg-6">
                                            <label>Usuarios</label>
                                            <p><b>Usuario no asignado</b></p>
                                        </div>
                                    @endif
                                </div>


                                <div class="form-group row">
                                    <div class="col-lg-6">
                                        <label>Razón social</label>
                                        <div class="input-group">
                                            <p>{{ $taller_info->nombre }}</p>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <label>Alias</label>
                                        <div class="input-group">
                                            <p>{{ $taller_info->alias }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col-lg-6">
                                        <label>RFC</label>
                                        <div class="input-group">
                                            <p>{{ $taller_info->rfc }}</p>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <label>Calle y número</label>
                                        <div class="input-group">
                                            <p>{{ $taller_info->direccion }}</p>
                                        </div>
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <div class="col-lg-6">
                                        <label>Colonia</label>
                                        <div class="input-group">
                                            <p>{{ $taller_info->colonia }}</p>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <label>Codigo postal</label>
                                        <div class="input-group">
                                            <p>{{ $taller_info->codigo_postal }}</p>
                                        </div>
                                    </div>

                                </div>

                                <div class="form-group row">
                                    <div class="col-lg-6">
                                        <label>Estado</label>

                                        @foreach($estados as $estado)
                                            @if($taller_info->estado_id == $estado->id_estado)
                                                <p>{{ $estado->estado_nombre }}</p>
                                            @endif
                                        @endforeach

                                    </div>
                                    <div class="col-lg-6">
                                        <label>Municipio y/o Alcaldía.</label>
                                         @foreach($municipios as $municipio)
                                            @if($taller_info->municipio_id == $municipio->id_municipio)
                                                <p>{{ $municipio->municipio_nombre }}</p>
                                            @endif
                                        @endforeach

                                    </div>

                                </div>


                                <div class="form-group row">
                                    <div class="col-lg-4">
                                        <label>Telefono local</label>
                                        <div class="input-group">
                                            <p>{{ $taller_info->tel_local }}</p>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <label>Telefono celular</label>
                                        <div class="input-group">
                                            <p>{{ $taller_info->tel_celular }}</p>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <label>Telefono tres</label>
                                        <div class="input-group">
                                            <p>{{ $taller_info->tel_tres }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col-lg-6">
                                        <label>Nombre</label>
                                        <div class="input-group">
                                            <p>{{ $taller_info->nombre_resp }}</p>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <label>Correo electronico</label>
                                        <div class="input-group">
                                            <p>{{ $taller_info->correo }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <label for="observaciones">Observaciones</label>
                                    <p>{{ $taller_info->observaciones }}</p>
                                </div>

                                <div class="form-group row">
                                    <div class="col-lg-12">
                                        <label>Coordenadas</label>
                                        <div class="input-group">
                                            <p>{{ $taller_info->coordenadas }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-lg-12">
                                        <label>Referencia</label>
                                        <p>{{ $taller_info->referencia }}</p>
                                    </div>
                                </div>

                        </div>
                        <div class="tab-pane fade mt-10" id="kt_tab_pane_2" role="tabpanel" aria-labelledby="kt_tab_pane_2">
                            <table class="table table-hover mb-6 table-responsive-sm" id="tblDocumentos">
                                <thead>
                                <tr>
                                    <th scope="col">Documento</th>
                                    <th scope="col">Tipo de Documento</th>
                                    {{-- <th scope="col">Opción</th> --}}
                                </tr>
                                </thead>
                                <tbody id='tbodyDocumentos'>
                                    @foreach($documento_taller as $documento)
                                        <tr id="trDocumento{{ $documento->id }}">
                                            <td>
                                                <a href="{{ route('archivo.documentoTaller', ['id'=>$documento->id]) }}" class="link-primary" target="_blank"> {{ $documento->documento }} </a>
                                            </td>
                                            <td>{{ $documento->tallerTipoDocumento->tipo_documento }}</td>
                                            <td>
{{--                                                 <a href='#' class='btn btn-sm btn-clean btn-hover-icon-success btn-icon hrefEliminarDocumento' data-id='{{ $documento->id }}' data-documento='{{ $documento->documento }}'  data-toggle='tooltip' data-theme='dark' title='Eliminar'>
                                                    <i class='flaticon-delete'></i>
                                                </a> --}}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>



                        </div>


                            @php  
                                $servicios_id = array();
                                foreach($servicios_asignados as $asignar) {
                                  $servicios_id[] = $asignar->servicio_id;
                                }
                            @endphp

                            <div class="tab-pane fade mt-10" id="kt_tab_pane_3" role="tabpanel" aria-labelledby="kt_tab_pane_3">
                                <div class="row">
                                        @foreach($servicios as $value)
                                            <div class="col-md-4">
                                              <div class="form-group">
                                                <span class="switch switch-icon">
                                                <label> {{ $value->servicio }}
                                                <input type="checkbox" disabled name="servicio[]" {{(in_array($value->id , $servicios_id)) ? 'checked' : ''}} class='tablero_check all_generales' value="{{ $value->id }}" />
                                                <span></span>
                                                </label>
                                                </span>
                                              </div>
                                            </div>            
                                        @endforeach
                                </div>
                            </div>



                        <div class="tab-pane fade mt-10" id="kt_tab_pane_4" role="tabpanel" aria-labelledby="kt_tab_pane_4">
                            <table class="table table-hover mb-6 table-responsive-sm">
                                <thead>
                                <tr>
                                    <th scope="col">Solicitud taller</th>
                                    <th scope="col">Técnica</th>
                                    <th scope="col">Operativa</th>
                                    <th scope="col">Administrativa</th>
                                    <th scope="col">Servicio al Cliente</th>
                                    <th scope="col">Financiera</th>
                                    <th scope="col">Calificación</th>
                                    <th scope="col">Opciones</th>
                                </tr>
                                </thead>
                                <tbody >
                                    @foreach($evaluaciones as $sol)
                                        <tr>
                                            <td>
                                               {{ $sol->taller_solicitud_id }}
                                            </td>
                                            <td>{{ round($sol->res_tecnica / 2,2) }}</td>
                                            <td>{{ round($sol->res_operativa / 3,2) }}</td>
                                            <td>{{ round($sol->res_operativa / 3, 2) }}</td>
                                            <td>{{ round($sol->res_cliente / 3, 2) }}</td>
                                            <td>{{ round($sol->res_financiera / 2, 2) }}</td>
                                            <td>{{ round($sol->res_total / 12, 2) }}</td>
                                            <td>
                                                <a href="{{ route('invtaller.evaluaciontaller',[$id_taller, $sol->taller_solicitud_id]) }}" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon" data-toggle="tooltip" data-theme="dark" title="Ver detalle" ><i class="flaticon-eye"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div>


                    </div>
                    <!--end::tabs-->

                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-lg-6">
                            {{-- <button type="button"  id="btnGuardar" class="btn btn-success"><i class="la la-plus"></i>Guardar</button> --}}
                            <a href="{{ route('invtaller.inventariotaller') }}"  class="btn btn-secondary"><i class="la la-arrow-left"></i>Regresar</a>
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
