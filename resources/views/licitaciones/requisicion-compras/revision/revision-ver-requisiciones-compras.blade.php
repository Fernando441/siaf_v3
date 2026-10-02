@extends('layouts.app')
@push('scripts')
	{{-- <script src="{{ asset('js/cliente/AgregarCliente.js') }}"></script> --}}
    <script src="{{ asset('js/licitaciones/requicision_compras/VerRequisicionCompras.js') }}"></script> 

@endpush
@section('title')
    Ver información de la requisición
@endsection
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
                    <h3 class="card-title">Ver información de la requisición</h3>
                </div>
                
                <!--begin::Form-->

{{--                     <input type="hidden" name="id_unidad" value="{{ $id_unidad }}">
                    <input type='hidden' id='tipoArchivo' value='{{ $cadenaTipoDocumento }}'> --}}
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6"></div>
                            <div class="col-lg-6">
                                <div class="row text-center">
                                    <div class="col-lg-6">
                                        <button id="btn-autorizar"  class="btn btn-light-success font-weight-bold mr-2">Enviar a finanzas</button>

                                    </div>
                                    <div class="col-lg-6">
                                        <button id="btn-rechazar" class="btn btn-light-danger font-weight-bold mr-2">Rechazar Solicitud</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row oculto" id="rechazar-div">

                            <form method="post" id="rechazar_form" action="{{ route('reqcompras.rechazarreqcompras') }}" enctype="multipart/form-data">
                            @csrf
                                <div class="col-lg-12">
                                    <input type="hidden" name="id_solicitud" value="{{ $requisicion->id }}">
                                    <label>Motivo por el cual rechazas la solicitud:</label>
                                    <textarea class="form-control" name="motivo" id="motivo" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"></textarea>
                                </div>
                            </form>

                            <div class="row">
                                <div class="col-lg-10"></div>
                                <div class="col-lg-2 text-center mt-2">
                                    <button id="btn-rechazar-form" class="btn btn-light-danger font-weight-bold mr-2">Guardar</button>
                                </div>
                            </div>

                            <form method="post" id="validar_form" action="{{ route('reqcompras.validareqcompras') }}" enctype="multipart/form-data">
                            @csrf
                                <input type="hidden" name="id_solicitud" value="{{ $requisicion->id }}">
                            </form>

                        </div>
                <form class="form" action="{{ route('reqcompras.guardarreqcompras') }}" method="post" id="frmCliente" enctype="multipart/form-data">
                    @csrf   
                        <!--begin::tabs-->
                        <ul class="nav nav-tabs nav-tabs-line">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#kt_tab_pane_1">Información general</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#kt_tab_pane_2">Evidencias</a>
                            </li>
                        </ul>
                        <div class="tab-content mt-5" id="myTabContent">
                            <div class="tab-pane fade show active mt-10" id="kt_tab_pane_1" role="tabpanel" aria-labelledby="kt_tab_pane_1">

                                <div class="form-group row">
                                    <div class="col-lg-6">
                                        <label>Titulo de la requisición</label>
                                        <div class="input-group">
                                            <p>{{ $requisicion->titulo_requisicion }}</p>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <label>Solicitante</label>
                                        <div class="input-group">
                                            <p>{{ $requisicion->userCreated->name}}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col-lg-6">
                                        <label>Area</label>
                                        @foreach($area as $are)
                                            @if($are->id == $requisicion->area_personal_id )
                                                <p>{{ $are->nombre_area }}</p>
                                            @endif
                                        @endforeach
                                    </div>
                                    <div class="col-lg-6">
                                        <label>Fecha de Solicitud</label>
                                        <div class="input-group date" id="kt_datetimepicker_1" data-target-input="nearest">
                                            <p>{{ $requisicion->fecha_requisicion }}</p>
                                        </div>                                         
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-lg-12">
                                        <label for="observaciones">Observaciones</label>
                                        <p> <p>{{ $requisicion->comentario}}</p></p>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade mt-10" id="kt_tab_pane_2" role="tabpanel" aria-labelledby="kt_tab_pane_2">

                                <div class="row form-group">


                                    <div class="col-lg-12" id="tblArchivos">
                                        <table class='table table-bordered table-hover' id='tblDocumentos'>
                                            <thead>
                                                <tr>
                                                    <th>Descripción</th>
                                                    <th>Cantidad</th>
                                                    <th>Observaciones</th>
                                                </tr>
                                            </thead>
                                            <tbody id='tbodyDocumentos'>
                                              @foreach($detalle as $unid)
                                                <tr>
                                                  <td>{{ $unid->descripcion }}</td>
                                                  <td>{{ $unid->cantidad }}</td>
                                                  <td>{{ $unid->obervaciones }}</td>

                                                </tr>
                                              @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>

                        </div>
                        <!--end::tabs-->

                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-lg-6">
                                <a href="{{ route('reqcompras.reqrevisioncompras') }}"  class="btn btn-secondary"><i class="la la-times"></i>Regresar</a>
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
