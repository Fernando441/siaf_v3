@extends('layouts.app')
@push('scripts')
	<script src="{{ asset('js/unidades/translados/Translados.js') }}"></script>
@endpush
@section('title')
    Solicitud de traslado
@endsection
@section('content')
<style type="text/css">
    .tr_info{
        font-size: 12px;
    }
    .id_tr{
        color:#669933;
        font-size: 15px;
        font-weight:bold;
    }
    .oculto{
        display: none;
    }
</style>


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
                                <h3 class="card-label">Asignar unidades a la solicitud</h3>
                            </div>
                            <div class="card-toolbar">

                                <!--begin::Button-->
                                <a href="{{ route('movimientoslog.listadomovimientos') }}" class="btn btn-light-primary font-weight-bolder mr-3 ml-3">
                                  Regresar</a>
                                <!--end::Button-->

                            </div>
                        </div>
                        <div class="card-body">

                            <div class="row form-group">
{{--                                 <div class="col-lg-6">
                                    <a href="/layout/Carga Masiva Unidades.csv">Layout para la carga masiva</a>
                                </div> --}}
{{--                                 <div class="col-lg-6">
                                    <a class="btn_transladistas"><i class="flaticon-users-1"></i>Ver trasladistas</a>
                                </div> --}}
                            </div>

                            <div class="row" id="div_transladitas" style="display: none;">
                                <input type="hidden" id="op_transladista" value="0">

                                <div class="col-lg-12">
                                    <div class="card card-custom">
                                        <div class="card-header">
                                            <div class="card-title">
                                                <h3 class="card-label">
                                                    Trasladistas
                                                </h3>
                                            </div>

                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                @foreach($users as $unid)
                                                    <div class="col-lg-6">
                                                        <div class="row">
                                                            <div class="col-lg-4">
                                                                @if($unid->avatar == null)
                                                                    <img src="{{ asset('img/no_disponible.png') }}" width="130">
                                                                @else
                                                                    <img src="{{ route('archivo.documentoAvatar', $unid->avatar) }}" width="130">
                                                                @endif
                                                            </div>
                                                            <div class="col-lg-8 mt-2">
                                                                <span class="tr_info">Id: <span class="id_tr">{{ $unid->id }}</span></span><br>
                                                                <span class="tr_info">Nombre: <b>{{ $unid->name }}</b></span><br>
                                                                <span class="tr_info">correo: <b>{{ $unid->email }}</b></span>
                                                            </div>
                                                        </div> 
                                                    </div>               
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

{{--                             <form action="{{ route('movimientoslog.unidadestranslados') }}" method="post" id="submit_carga" enctype="multipart/form-data">
                            @csrf

                                <div class="row">
                                    <div class="col-lg-4 mt-2 form-group">
                                        <label>Titulo del traslado</label>
                                        <input type="text" class="form-control specialCharts" name="titulo_translado" id="titulo_translado" required onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()" />
                                    </div>
                                    <div class="col-lg-8 mt-2 form-group">
                                        <label>Carga Masiva de Unidades</label>
                                        <div class='custom-file'>
                                           <input type='file' class='custom-file-input' id='file_carga' name='file_carga' required />
                                           <label class='custom-file-label' for='foto"+contadorFotografia+"'>Selecciona un archivo</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12">
                                        <label>Observaciones</label>
                                        <textarea class="form-control specialCharts" name="observaciones" id="observaciones" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"></textarea>
                                    </div>
                                </div>
                            </form> --}}

<form action="{{ route('movimientoslog.unidadestranslados') }}" method="post" id="submit_carga" enctype="multipart/form-data">
                            @csrf


                            <div class="row form-group">
                                <div class="col-lg-5 mt-2 form-group">
                                    <label>Título  del traslado</label>
                                    <input type="text" class="form-control specialCharts" name="titulo_translado" id="titulo_translado" required onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()" />
                                </div>  
                                <div class="col-lg-7">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <!--begin:Option-->
                                            <label class="d-flex flex-stack mb-5 cursor-pointer" id="asig_unidades">
                                                <!--begin:Label-->
                                                <span class="d-flex align-items-center me-2">
                                                    <!--begin:Icon-->
                                                    <span class="symbol symbol-50px me-6">
                                                        <span class="symbol-label bg-light-primary">
                                                            <i class="ki-duotone ki-compass fs-1 text-primary"><span class="path1"></span><span class="path2"></span></i>
                                                        </span>
                                                    </span>
                                                    <!--end:Icon-->

                                                    <!--begin:Info-->
                                                    <span class="d-flex flex-column">
                                                        <span class="fw-bold fs-6">Asignacion de unidades</span>
                                                    </span>
                                                    <!--end:Info-->
                                                </span>
                                                <!--end:Label-->

                                                <!--begin:Input-->
                                                <span class="form-check form-check-custom form-check-solid">
                                                    <input class="form-check-input" type="radio"  name="category" value="1"/>
                                                </span>
                                                <!--end:Input-->
                                            </label>
                                            <!--end::Option-->  
                                        </div>
                                        <div class="col-lg-6">
                                            <!--begin:Option-->
                                            <label class="d-flex flex-stack mb-5 cursor-pointer" id="unid_susustitutas">
                                                <!--begin:Label-->
                                                <span class="d-flex align-items-center me-2">
                                                    <!--begin:Icon-->
                                                    <span class="symbol symbol-50px me-6">
                                                        <span class="symbol-label bg-light-danger">
                                                            <i class="ki-duotone ki-element-11 fs-1 text-danger"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></i>
                                                        </span>
                                                    </span>
                                                    <!--end:Icon-->

                                                    <!--begin:Info-->
                                                    <span class="d-flex flex-column">
                                                        <span class="fw-bold fs-6">Unidades sustitutas</span>
                                                    </span>
                                                    <!--end:Info-->
                                                </span>
                                                <!--end:Label-->

                                                <!--begin:Input-->
                                                <span class="form-check form-check-custom form-check-solid">
                                                    <input class="form-check-input" type="radio" name="category" value="2"/>
                                                </span>
                                                <!--end:Input-->
                                            </label>
                                            <!--end::Option-->
                                        </div>
                                    </div>
                                </div>                              
                            </div>

                            <input type="hidden" name="op_solicitud" id="op_solicitud" value="0">

                            <div class="row form-group oculto" id="div_asignacion">
                                <div class="col-lg-6">
                                    <label>Solicitudes de asignación de unidaddes</label>
                                    <select class="form-control" id="id_asignacion" name="id_asignacion"  required >
                                        <option value="">Selecciona una opción</option>
                                        @foreach($asignacionLogistica as $asignacion)
                                            <option value="{{ $asignacion->id }}" >{{ $asignacion->nombre_asignacion }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row form-group oculto" id="div_sustitutas">
                                <div class="col-lg-6">
                                    <label>Solicitudes de unidades sustitutas</label>
                                    <select class="form-control" id="id_sustituta" name="id_sustituta"  required >
                                        <option value="">Selecciona una opción</option>
                                        @foreach($sustituto as $sust)
                                            <option value="{{ $sust->id }}" >Motivo: {{ $sust->motivo }} - Unidad base: {{ $sust->no_serie }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>


                            <div class="row form-group">
                                <div class="col-lg-12">
                                    <label>Observaciones</label>
                                    <textarea class="form-control specialCharts" name="observaciones" id="observaciones" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"></textarea>
                                </div>
                            </div>

</form>
                            <div class="row form-group mt-2">
                                <div class="col-lg-9"></div>
                                <div class="col-lg-3">
                                    <button type="button" id="send_carga" class="btn btn-primary">Guardar solicitud</button>
                                </div>
                            </div>


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
