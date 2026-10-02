@extends('layouts.app')
@push('scripts')
	{{-- <script src="{{ asset('js/cliente/AgregarCliente.js') }}"></script> --}}
    <script src="{{ asset('js/licitaciones/requicision_compras/EditarRequisicionCompras.js') }}"></script> 
@endpush
@section('title')
    Editar información de la requisición
@endsection
@section('content')

    <!--begin::Card-->
    <div class="row">
        <div class="col-lg-12">
            <!--begin::Card-->
            <div class="card card-custom gutter-b">
                <div class="card-header">
                    <h3 class="card-title">Editar información de la requisición</h3>
                </div>
                <input type="hidden" id="documentoEliminarPath" value="{{ route('reqcompras.eliminardatorequisicon') }}">
                <!--begin::Form-->
                <form class="form" action="{{ route('reqcompras.updatereqcompras') }}" method="post" id="frmCliente" enctype="multipart/form-data">
                    @csrf   
                    <input type="hidden" name="id_requisicion" value="{{ $requisicion->id }}">
                    {{-- <input type='hidden' id='tipoArchivo' value='{{ $cadenaTipoDocumento }}'> --}}
                    <div class="card-body">
                        @if($requisicion->op_estatus == 0 && $requisicion->op_rechazo == 1)
                            <span style="color: red;">{{ $requisicion->motivo_rechazo }}</span>
                        @endif
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
                                            <input type="text" name="titulo_requisicion" value="{{ $requisicion->titulo_requisicion }}" id="titulo_requisicion"  class="form-control" required />
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <label>Solicitante</label>
                                        <div class="input-group">
                                            <input type="text" name="user" id="user" value="{{ $requisicion->userCreated->name  }}"  class="form-control" required readonly />
                                        </div>
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col-lg-6">
                                        <label>Area</label>
                                        <select class="form-control" id="area_personal_id" name="area_personal_id"  required >
                                            <option value="">Selecciona una opción</option>
                                            @foreach($area as $pro)
                                                <option value="{{ $pro->id }}" @selected($requisicion->area_personal_id == $pro->id) >{{ $pro->nombre_area }} </option>
                                            @endforeach
                                        </select>

                                    </div>
                                    <div class="col-lg-6">
                                        <label>Fecha de Solicitud</label>
                                        <div class="input-group date" id="kt_datetimepicker_1" data-target-input="nearest">
                                            <input type="text" class="form-control datetimepicker-input" value="{{ $requisicion->fecha_requisicion  }}" placeholder="Select date & time" name="fecha_solicitud" data-target="#kt_datetimepicker_1"/>
                                            <div class="input-group-append" data-target="#kt_datetimepicker_1" data-toggle="datetimepicker">
                                             <span class="input-group-text">
                                              <i class="ki ki-calendar"></i>
                                             </span>
                                            </div>
                                           </div>                                         
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-lg-12">
                                        <label for="observaciones">Observaciones</label>
                                        <textarea class="form-control" name="comentario" id="comentario" rows="3" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"> {{ $requisicion->comentario }}
                                        </textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade mt-10" id="kt_tab_pane_2" role="tabpanel" aria-labelledby="kt_tab_pane_2">
                                <table class="table table-hover mb-6 table-responsive-sm" id="tblDocumentos">
                                    <thead>
                                    <tr>
                                        <th>Descripción</th>
                                        <th>Cantidad</th>
                                        <th>Observaciones</th>
                                        <th>Opción</th>
                                    </tr>
                                    </thead>
                                    <tbody id='tbodyDocumentos'>
                                        @foreach($detalle as $documento)
                                            <tr id="trDocumento{{ $documento->id }}">
                                                <td>{{ $documento->descripcion }}</td>
                                                <td>{{ $documento->cantidad }}</td>
                                                <td>{{ $documento->obervaciones }}</td>
                                                <td>
                                                    <a href='#' class='btn btn-sm btn-clean btn-hover-icon-success btn-icon hrefEliminarDocumento' data-id='{{ $documento->id }}' data-documento='{{ $documento->descripcion }}'  data-toggle='tooltip' data-theme='dark' title='Eliminar'>
                                                        <i class='flaticon-delete'></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                <div class="row form-group">
                                    <div class="col-lg-12">
                                        <a href="#" class="btn btn-icon btn-outline-success btn-circle btn-sm mr-2 hrefAgregarOtro" data-toggle="tooltip" data-theme="dark" title="Agregar archivo">
                                            <i class="flaticon2-plus"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!--end::tabs-->

                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-lg-6">
                                <button type="button"  id="btnGuardar" class="btn btn-success"><i class="la la-plus"></i>Guardar</button>
                                <a href="{{ route('reqcompras.reqcompras') }}"  class="btn btn-secondary"><i class="la la-times"></i>Cancelar</a>
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
