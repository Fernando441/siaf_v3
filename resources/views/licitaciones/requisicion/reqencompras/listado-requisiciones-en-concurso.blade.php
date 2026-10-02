@extends('layouts.app')
@section('title')
    Listado de requisiciones
@endsection
@push('scripts')
    <script src="{{ asset('js/licitaciones/requisicion/ListadoRequisicionesConcurso.js') }}"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
@endpush
@section('content')
    
<style type="text/css">
    .oculto{
        display: none;
    }
    .op_select{
box-shadow: 0px 7px 5px -2px rgba(174,251,117,0.74);
-webkit-box-shadow: 0px 7px 5px -2px rgba(174,251,117,0.74);
-moz-box-shadow: 0px 7px 5px -2px rgba(174,251,117,0.74);  
    }
</style>

    <!--begin::Card-->
    <div class="row">
        <div class="col-lg-12">
            <!--begin::Card-->
            <div class="card card-custom gutter-b">
                <div class="card-header">
                    <h3 class="card-title"><i class="flaticon2-file mr-4 text-primary"></i> Requisiciones: No. concurso {{ $info->no_licitacion }}</h3>
                    <div class="card-toolbar">


                        <input type="hidden" id="op_busqueda" value="1">

                        @if (in_array('119', Session::get('permisos')))
                            <a href="{{ route('reqconcurso.nvareqmenuconcurso',$id_licitacion) }}"
                                class="btn btn-light-primary font-weight-bolder mr-3 ml-3">
                                <i class="la la-plus mr-2"></i>Nueva requisición
                            </a>
                        @endif

                    @if (in_array(114, $permiso_array))
                        <a href="{{ route('licitacion.ver',$info->id)}}" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon " title="Ver concurso" data-theme="dark" data-toggle="tooltip" data-placement="top">
                            <i class="flaticon-eye"></i>
                        </a>   {{-- VER licitacion --}}
                    @endif

                    @if (in_array(116, $permiso_array))
                        <a href="{{ route('licitacion.editarlicitacion',$info->id) }}" class="btn btn-sm  btn-hover-icon-success btn-icon" title="Editar concurso" data-theme="dark" data-toggle="tooltip" data-placement="top">
                            <i class="flaticon-edit"></i>
                        </a>   {{-- Editar licitacion --}}
                    @endif

                    @if (in_array(133, $permiso_array))
                        @if($info->acto_fallo == null || $info->acto_fallo == "")
                        @else
                            <a href="{{ route('licitacion.agregar',$info->id) }}" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon" title="Crear contrato" data-theme="dark" data-toggle="tooltip" data-placement="top">
                                <i class="flaticon-file-1"></i>
                            </a>  {{-- Agregar contrato --}}
                        @endif
                    @endif

                    @if (in_array(134, $permiso_array))
                        <a href="{{ route('proposicioneconomica.crearproposicioneconomica', [$info->id,1,$info->tipo_contrato]) }}" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon" title="Crear propuesta económica" data-theme="dark" data-toggle="tooltip" data-placement="top">
                            <i class="flaticon-presentation-1"></i>
                        </a>   {{-- Propuesta economica --}}
                    @endif

                    @if (in_array(135, $permiso_array))
                        <a href="{{ route('propuestatecnica.crearpropuestatecnica',$info->id) }}" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon" title="Crear propuesta" data-theme="dark" data-toggle="tooltip" data-placement="top">
                            <i class="flaticon2-website"></i>  
                        </a>   {{-- Propuesta Tecnica --}}
                    @endif

                    @if (in_array(143, $permiso_array))
                        <a href="{{ route('licitacion.informacionfinanzas',$info->id) }}" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon" title="Información de las fianzas y seguros" data-theme="dark" data-toggle="tooltip" data-placement="top">
                                <i class="flaticon-notepad"></i>
                        </a>   {{-- Finanzas --}}
                    @endif

                    <a href="{{ route('licitacion.listadolicitaciones') }}" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon" data-toggle="tooltip" data-theme="dark" title="Salir" ><i class="flaticon2-reply "></i></a>


                        {{-- <a href="{{ route('concurso.requisiciones.catalogorequisicioninactivas') }}"
                            class="btn btn-light-primary font-weight-bolder mr-3 ml-3">
                            <i class="far fa-trash-alt"></i>Requisiciones inactivas</a> --}}

                        <!--begin::Dropdown-->

                        <!--end::Dropdown-->
                    </div>
                </div>
                <!--begin::Form-->
                <form action="{{ route('concurso.requisiciones.guardarrequisicion') }}" method="post" id="submit_requisicion"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">


                        <div class="row">
                            <div class="col-lg-12">
                                <table class="table table-hover" id="tablaRequisicionesenconcurso">
                                    <thead style="text-align:center;">
                                        <tr>
                                            <th>Folio</th>
                                            <th>Solicitante</th>
                                            <th>Area</th>
                                            <th>Estatus</th>
                                            <th>Fecha de solicitud</th>
                                            <th>Opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody style="text-align:center;">

                                      @foreach($requisiciones as $unid)
                                        <tr>
                                          <td>{{ $unid->folio }}</td>
                                          <td>{{ $unid->usersolicitante->name }}</td>
                                          <td>{{ $unid->areaPersonal->nombre_area }}</td>
                                          <td>{{ $unid->requisicionEstatus->estatus }}</td>
                                          <td>{{ $unid->fecha_solicitud }}</td>
                                          
                                          <td class="text-center">
                                            @if($unid->requisicion_estatus_id== 1 || $unid->requisicion_estatus_id== 7)

                                                <a href="{{ route('reqconcurso.verrequisicionmenu', [$unid->id, $id_licitacion]) }}" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon" title="Ver requisición" data-theme="dark" data-toggle="tooltip" data-placement="top">
                                                        <i class="flaticon-eye"></i>
                                                </a>

                                                <a href="{{ route('reqconcurso.addinfopartidaslic', [$unid->id, $id_licitacion]) }}" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon" title="Agregar información" data-theme="dark" data-toggle="tooltip" data-placement="top">
                                                        <i class="flaticon2-open-text-book"></i>
                                                </a>

                                                <a  class="finanzasRequisicionlic btn btn-sm btn-clean btn-hover-icon-success btn-icon" title="Enviar a finanzas" data-theme="dark" data-toggle="tooltip" data-placement="top" data-id="{{$unid->id}}" data-licitacion="{{$id_licitacion}}">
                                                        <i class="flaticon2-delivery-truck"></i>
                                                </a>
                                            @else

                                                <a href="`+verrequisicionurl+full.id+`" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon" title="Ver requisición" data-theme="dark" data-toggle="tooltip" data-placement="top">
                                                    <i class="flaticon-eye"></i>
                                                </a>

                                            @endif

                                          </td>
                                        </tr>
                                      @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-lg-6">
                                {{-- {{link_to('tablero', $title = 'Regresar', $attributes = ['class'=>'btn btn-secondary btn-lg'])}} --}}
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="datatable_i18n" value="{{ asset('/js/datatables/i18n/es-mx.json') }}">
                    <input type="hidden" id="requisicionesurl"
                        value="{{ route('reqconcurso.reqenconcursoDataTable') }}">
                    <input type="hidden" id="verrequisicionurl" value="{{ route('concurso.requisiciones.verrequisicion', ['id' => 1]) }}">
                    <input type="hidden" id="editarrequisicionurl" value="{{ route('concurso.requisiciones.editarrequisicion', ['id' => 1]) }}">
                    <input type="hidden" id="eliminarrequisicionurl" value="{{ route('concurso.requisiciones.eliminarrequisicion') }}">
                    <input type="hidden" id="finanzasrequisicionurl" value="{{ route('reqconcurso.finanzasrequisicionlic') }}">
                    <input type="hidden" id="addinfo" value="{{ route('concurso.requisiciones.addinfopartidas', ['id' => 1]) }}">
                </form>
                <!--end::Form-->
            </div>
            <!--end::Card-->
        </div>
    </div>
    <!--end::Card-->


    <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"
        id="model_delete_requisicion">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Desactivar requisición</h5>
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                        aria-label="Close">
                        <span class="svg-icon svg-icon-2x"></span>
                    </div>
                </div>

                <div class="modal-body">
                    <form action="{{ route('concurso.requisiciones.eliminarrequisicion') }}" method="post"
                        id="submit_desactivar">
                        @csrf
                        <div class="row form-group">
                            <div class="col-lg-12 mt-2">
                                <label>Motivo</label>
                                <input type="text" class="form-control" name="motivo" id="id_motivo_requisicion" />
                                <input type="hidden" name="id" id="id_del_req">
                            </div>
                        </div>
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn btn-secondary font-weight-bold"
                        data-dismiss="modal"><i class="la la-times"></i>Cancelar</button>
                    <button type="button" id="send_desactivar" class="btn btn-success"><i class="la la-plus"></i>Guardar</button>
                </div>
            </div>
        </div>
    </div>
@endsection
