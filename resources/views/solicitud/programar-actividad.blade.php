@extends('layouts.app')
@section('title')
    Programar Actividad
@endsection
@push('scripts')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <script src="{{ asset('js/solicitud/programar-actividad-proveedor.js') }}"></script>
    <script src="{{ asset('theme/assets/js/pages/crud/forms/widgets/bootstrap-datetimepicker.js') }}"></script>
@endpush

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <div class="card card-custom gutter-b">
                <div class="card-header">
                    <h3 class="card-title">Programar Actividad</h3>
                </div>

                <form class="form" action="{{ route('solicitud.guardarActividad') }}" method="post" id="frmProgramarActividad">
                    @csrf
                    <input type="hidden" id="opcion_guardar" name="opcion_guardar" value="" />
                    <input type="hidden" id="solicitud_id" name="solicitud_id" value="{{ $solicitudes->id }}" />
                    <input type="hidden" id="unidad_id"  value="" />
                    <input type="hidden" id="guardar_detalle_path" value="{{ route('solicitud.guardarDetalle') }}" />
                    <input type="hidden" id="solicitud_ejecucion_id" name="solicitud_ejecucion_id" value="@if(!empty($solicitudEjecucion)){{ $solicitudEjecucion->id }}@endif" />

                    <div class="card-body">
                        @include('solicitud.programar-actividad-detalle')
                        
                        <div class="card-footer px-0" style="padding-bottom: 0px;">
                            <div class="row">
                                <div class="col-lg-12">
                                    <button type="button" id="btnGuardarFinalizar" class="btn btn-success" data-wizard-type="action-next">
                                        <i class="la la-plus"></i> Guardar y finalizar
                                    </button>
                                    <button type="button" id="btnGuardarContinuarDespues" class="btn btn-primary" data-wizard-type="action-next">
                                        <i class="la la-calendar"></i> Guardar y continuar después
                                    </button>
                                    <a href="{{ route('solicitud.listadoProveedor') }}"  class="btn btn-secondary"><i class="la la-arrow-left"></i>Regresar</a>
                                </div>

                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" id="modal_programar_actividad">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Programar Actividad</h5>
  
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <span class="svg-icon svg-icon-2x"></span>
                    </div>
                </div>
  
                <div class="modal-body">
                    <form class="form" method="post" id="frmProgramarActividadDetalle">
                        <div class="row form-group">
                            <div class="col-lg-12">
                                <label>IDGPS</label>
                                <input type="text" class="form-control" name="idgps" id="idgps" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()" required/>
                                <span class="form-text text-muted">ID del dispositivo GPS.</span>
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-lg-12">
                                <label>Comentarios</label>
                                <textarea class="form-control" name="comentarios_detalle" id="comentarios_detalle" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"></textarea>
                                <span class="form-text text-muted">Comentarios de la actividad realizada.</span>
                            </div>
                        </div>
                    </form>
                </div>
  
                <div class="modal-footer">
                    <button type="button" class="btn btn btn-secondary font-weight-bold" data-dismiss="modal">
                        <i class="la la-arrow-left"></i>
                        Cancelar
                    </button>
                    <button type="button" id="btnGuardarDetalle" class="btn btn-success">
                        <i class="la la-plus"></i>
                        Guardar
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
