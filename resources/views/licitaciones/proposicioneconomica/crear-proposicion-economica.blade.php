@extends('layouts.app')
@push('scripts')
    <script src="{{ asset('js/licitaciones/proposicioneconomica/CrearProposicion.js') }}"></script>
@endpush
@section('title')
    Agregar propuesta económica
@endsection
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
                    <h3 class="card-title">Agregar propuesta económica</h3>
@foreach ($licitacion as $lic)
    @php
        $lici_id = $lic->id;
        $tipo_contrato = $lic->tipo_contrato;
        $acto_fallo = $lic->acto_fallo;
    @endphp
@endforeach
                    <div class="card-toolbar">
                        @if (in_array(114, $permiso_array))
                            <a href="{{ route('licitacion.ver',$lici_id)}}" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon" title="Ver concurso" data-theme="dark" data-toggle="tooltip" data-placement="top">
                                <i class="flaticon-eye"></i>
                            </a>   {{-- VER licitacion --}}
                        @endif

                        @if (in_array(116, $permiso_array))
                            <a href="{{ route('licitacion.editarlicitacion',$lici_id) }}" class="btn btn-sm  btn-hover-icon-success btn-icon" title="Editar concurso" data-theme="dark" data-toggle="tooltip" data-placement="top">
                                <i class="flaticon-edit"></i>
                            </a>   {{-- Editar licitacion --}}
                        @endif

                        @if (in_array(133, $permiso_array))
                            @if($acto_fallo == null || $acto_fallo == "")
                            @else
                                <a href="{{ route('licitacion.agregar',$lici_id) }}" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon" title="Crear contrato" data-theme="dark" data-toggle="tooltip" data-placement="top">
                                    <i class="flaticon-file-1"></i>
                                </a>  {{-- Agregar contrato --}}
                            @endif
                        @endif

                        @if (in_array(134, $permiso_array))
                            <a href="{{ route('proposicioneconomica.crearproposicioneconomica', [$lici_id,1,$tipo_contrato]) }}" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon op_select" title="Crear propuesta económica" data-theme="dark" data-toggle="tooltip" data-placement="top">
                                <i class="flaticon-presentation-1"></i>
                            </a>   {{-- Propuesta economica --}}
                        @endif

                        @if (in_array(135, $permiso_array))
                            <a href="{{ route('propuestatecnica.crearpropuestatecnica',$lici_id) }}" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon" title="Crear propuesta" data-theme="dark" data-toggle="tooltip" data-placement="top">
                                <i class="flaticon2-website"></i>  
                            </a>   {{-- Propuesta Tecnica --}}
                        @endif

                        @if (in_array(143, $permiso_array))
                            <a href="{{ route('licitacion.informacionfinanzas',$lici_id) }}" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon" title="Información de las fianzas y seguros" data-theme="dark" data-toggle="tooltip" data-placement="top">
                                    <i class="flaticon-notepad"></i>
                            </a>   {{-- Finanzas --}}
                        @endif


                        @if (in_array(135, $permiso_array))
                            <a href="{{ route('reqconcurso.listadoreqconsursos',$lici_id) }}" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon" title="Requisiciones" data-theme="dark" data-toggle="tooltip" data-placement="top">
                                    <i class="flaticon2-delivery-truck"></i>
                            </a>
                         @endif

                        <a href="{{ route('licitacion.listadolicitaciones') }}" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon" data-toggle="tooltip" data-theme="dark" title="Salir" ><i class="flaticon2-reply "></i></a>
                    </div>

                </div>
                <!--begin::Form-->
                <form action="{{ route('proposicioneconomica.guardarproposicioneconomica') }}" method="post"
                    id="submit_proposicion">
                    @csrf

                    
                    <div class="card-body">
                        <div class="row">
                            @foreach ($licitacion as $lic)
                                <div class="col-lg-4 col-sm-6 form-group">
                                    <label>Folio del concurso</label>
                                    <p>{{ $lic->folio }}</p>
                                </div>

                                <div class="col-lg-4 col-sm-6 form-group">
                                    <label>No. Concruso</label>
                                    <p>{{ $lic->no_licitacion }}</p>
                                </div>

                                <div class="col-lg-4 col-sm-6 form-group">
                                    <label>Titulo del servicio</label>
                                    <p>{{ $lic->titulo_servicio }}</p>
                                </div>

                                <div class="col-lg-4 col-sm-6 form-group">
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
                                </div>

                                <div class="col-lg-4 col-sm-6 form-group">
                                    <label>Cliente</label>
                                    <p>{{ $lic->razon_social }}</p>
                                </div>
                                <input type="hidden" name="licitacion_id" value="{{ $lic->id }}">
                                <input type="hidden" name="tipo_contrato" value="{{ $contrato }}">
                            @endforeach
                        </div>

                            <div class="card card-custom gutter-b">
                                <div class="card-header">
                                    <div class="card-title">
                                        <h3 class="card-label">
                                            Precio a cotizar
                                        </h3>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row form-group">
                                        @if ($op == 1)
                                            <div class="col-lg-6">
                                                <label>Precio unitario a cotizar</label>
                                                <div class="radio-inline">
                                                    <label class="radio">
                                                        <input type="radio" {{($propuesta->precio_cotizar == 0) ? 'checked' : ''}} name="precio_cotizar" id="pre_diario" value="0"/>
                                                        <span></span>
                                                        Diario
                                                    </label>
                                                    <label class="radio">
                                                        <input type="radio" {{($propuesta->precio_cotizar == 1) ? 'checked' : ''}} name="precio_cotizar" id="pre_mensual" value="1"/>
                                                        <span></span>
                                                        Mensual
                                                    </label>
                                                    <label class="radio">
                                                        <input type="radio" {{($propuesta->precio_cotizar == 2) ? 'checked' : ''}} name="precio_cotizar" id="pre_anual" value="2"/>
                                                        <span></span>
                                                        Anual
                                                    </label>
                                                </div>
                                            </div>

                                            @if($propuesta->precio_cotizar == 0)
                                                <div class="col-lg-6" id="div_precio_diario">
                                                    <label>Dias a cotizar</label>
                                                    <input type="text" class="form-control" name="precio_cotizar_diario" value="30"  />
                                                </div>

                                                <div class="col-lg-6 oculto" id="div_precio_mensual">
                                                    <label>Meses a cotizar</label>
                                                    <input type="text" class="form-control" name="precio_cotizar_mes"  value="" />
                                                </div>

                                                <div class="col-lg-6 oculto" id="div_precio_anual">
                                                    <label>Años a cotizar</label>
                                                    <input type="text" class="form-control" name="precio_cotizar_anual"  value="" />
                                                </div>
                                            @endif


                                            @if($propuesta->precio_cotizar == 1)
                                                <div class="col-lg-6 oculto" id="div_precio_diario">
                                                    <label>Dias a cotizar</label>
                                                    <input type="text" class="form-control" name="precio_cotizar_diario"  value="30" />
                                                </div>

                                                <div class="col-lg-6 " id="div_precio_mensual">
                                                    <label>Meses a cotizar</label>
                                                    <input type="text" class="form-control" name="precio_cotizar_mes" value="{{ $propuesta->precio_cotizar_mes }}" value="" />
                                                </div>

                                                <div class="col-lg-6 oculto" id="div_precio_anual">
                                                    <label>Años a cotizar</label>
                                                    <input type="text" class="form-control" name="precio_cotizar_anual"  value="" />
                                                </div>
                                            @endif


                                            @if($propuesta->precio_cotizar == 2)
                                                <div class="col-lg-6 oculto" id="div_precio_diario">
                                                    <label>Dias a cotizar</label>
                                                    <input type="text" class="form-control" name="precio_cotizar_diario"  value="30" />
                                                </div>

                                                <div class="col-lg-6 oculto" id="div_precio_mensual">
                                                    <label>Meses a cotizar</label>
                                                    <input type="text" class="form-control" name="precio_cotizar_mes"  value="" />
                                                </div>

                                                <div class="col-lg-6 " id="div_precio_anual">
                                                    <label>Años a cotizar</label>
                                                    <input type="text" class="form-control" name="precio_cotizar_anual" value="{{ $propuesta->precio_cotizar_anual }}" value="" />
                                                </div>
                                            @endif


                                        @else
                                            <div class="col-lg-6">
                                                <label>Precio unitario a cotizar</label>
                                                <div class="radio-inline">
                                                    <label class="radio">
                                                        <input type="radio" checked name="precio_cotizar" id="pre_diario" value="0"/>
                                                        <span></span>
                                                        Diario
                                                    </label>
                                                    <label class="radio">
                                                        <input type="radio"  name="precio_cotizar"  id="pre_mensual" value="1"/>
                                                        <span></span>
                                                        Mensual
                                                    </label>
                                                    <label class="radio">
                                                        <input type="radio"  name="precio_cotizar"  id="pre_anual" value="2"/>
                                                        <span></span>
                                                        Anual
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="col-lg-6" id="div_precio_diario">
                                                <label>Dias a cotizar</label>
                                                <input type="text" class="form-control" name="precio_cotizar_diario" value="30" />
                                            </div>

                                            <div class="col-lg-6 oculto" id="div_precio_mensual">
                                                <label>Meses a cotizar</label>
                                                <input type="text" class="form-control" name="precio_cotizar_mes"  value="" />
                                            </div>

                                            <div class="col-lg-6 oculto" id="div_precio_anual">
                                                <label>Años a cotizar</label>
                                                <input type="text" class="form-control" name="precio_cotizar_anual"  value="" />
                                            </div>

                                        @endif
                                    </div>

                            </div>
                        </div>


                        <table class="table table-hover table-checkable" id="kdatatable_proposicion_economica">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Tipo de vehículo</th>
                                    <th>Carrocería</th>
                                    <th>Motor</th>
                                    <th>Transmisión</th>
                                    <th>Puertas</th>
                                    <th class="text-center">Opciones</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($segmento as $unid)
                                    <tr>
                                        <td>{{ $unid->id }}</td>
                                        <td>{{ $unid->tipo_vehiculo }}</td>
                                        <td>{{ $unid->carroceria }}</td>
                                        <td>{{ $unid->motor }}</td>
                                        <td>{{ $unid->transmision }}</td>
                                        <td>{{ $unid->puertas }}</td>

                                        <td class="text-center">
                                            @if ($op == 1)
                                                @if (in_array($unid->id, $data))
                                                    <div class="checkbox-inline">
                                                        <label class="checkbox">
                                                            <input type="checkbox" name="segmento[]" checked
                                                                value="{{ $unid->id }}" />
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                @else
                                                    <div class="checkbox-inline">
                                                        <label class="checkbox">
                                                            <input type="checkbox" name="segmento[]"
                                                                value="{{ $unid->id }}" />
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                @endif
                                            @else
                                                <div class="checkbox-inline">
                                                    <label class="checkbox">
                                                        <input type="checkbox" name="segmento[]"
                                                            value="{{ $unid->id }}" />
                                                        <span></span>
                                                    </label>
                                                </div>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>

                            <tfoot>
                                <tr>
                                    <th>No.</th>
                                    <th>Tipo de vehículo</th>
                                    <th>Carrocería</th>
                                    <th>Motor</th>
                                    <th>Transmisión</th>
                                    <th>Puertas</th>
                                    <th class="text-center">Opciones</th>
                                </tr>
                            </tfoot>

                        </table>
                        <!--end: Datatable-->

                        <input type="hidden" id="datatable_i18n" value="{{ asset('/js/datatables/i18n/es-mx.json') }}">

                        <div class="form-group mb-1">
                            <label for="observaciones">Observaciones</label>
                            @if ($op == 1)
                                <textarea class="form-control specialCharts" name="observaciones" id="observaciones" rows="3" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">{{ $propuesta->observaciones }}</textarea>
                            @else
                                <textarea class="form-control specialCharts" name="observaciones" id="observaciones" rows="3" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"></textarea>
                            @endif
                            <input type="hidden" name="op" value="{{ $op }}">
                            <input type="hidden" name="redirect" value="{{ $redirect }}">
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-lg-6">
                                <button type="button" id="btnGuardar" class="btn btn-success mr-2"><i class="la la-arrow-right"></i>Continuar</button>
                                @if ($redirect == 1)
                                    <a href="{{ route('licitacion.listadolicitaciones') }}"
                                        class="btn btn-secondary"><i class="la la-arrow-left"></i>Regresar</a>
                                @else
                                    <a href="{{ route('proposicioneconomica.catalogoproposicioneconomica') }}"
                                        class="btn btn-secondary"><i class="la la-arrow-left"></i>Regresar</a>
                                @endif
                            </div>
                            <div class="col-lg-6 text-lg-right">
                                @if ($propuestaEconomica)
                                    <p class="text-danger">Ya existe una propuesta económica para esta licitación</p>
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
