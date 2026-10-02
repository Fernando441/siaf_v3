@extends('layouts.app')
@section('title')
    Validación Solicitud GPS
@endsection
@push('styles')
@endpush
@push('scripts')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <script src="{{ asset('vendors/dropzone/dropzone.min.js') }}"></script>
    <script>
        Dropzone.autoDiscover = false;
    </script>
    <script src="{{ asset('js/solicitud/validacion-actividad.js') }}"></script>
@endpush

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <div class="card card-custom gutter-b">
                <div class="card-header">
                    <h3 class="card-title">Validación Solicitud GPS</h3>
                </div>

                <form class="form" action="{{ route('solicitud.guardarValidacionActividad') }}" method="post" id="frm-solicitud-validacion">
                    @csrf
                    <input type="hidden" id="opcion_guardar" name="opcion_guardar" value="" />
                    <input type="hidden" id="solicitud_id" name="solicitud_id" value="{{ $solicitud->id }}" />
                    <input type="hidden" id="solicitud_ejecucion_id" name="solicitud_ejecucion_id" value="{{ $solicitudEjecucion->id }}" />

                    <div class="card-body">
                        @include('solicitud.validacion-actividad-detalle')
                        
                        <div class="card-footer px-0" style="padding-bottom: 0px;">
                            <div class="row">
                                <div class="col-lg-6">
                                    <button type="button" id="btnGuardarFinalizar" class="btn btn-success" data-wizard-type="action-next">
                                        <i class="la la-arrow-right"></i> Enviar Visto Bueno
                                    </button>
                                    <button type="button" id="btn_rechazar" class="btn btn-warning" data-wizard-type="action-next">
                                        <i class="la la-close"></i> Rechazar
                                    </button>
                                    <a href="{{ route('solicitud.listadoValidacion') }}"  class="btn btn-secondary"><i class="la la-arrow-left"></i>Regresar</a>
                                </div>

                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>


 <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" id="modal_programar_actividad">
    <input type="hidden" id="actividad-unidad-id" name="actividad-unidad-id" value="" />
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Programar Actividad</h5>

                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <span class="svg-icon svg-icon-2x"></span>
                </div>
            </div>

            <div class="modal-body">
                    <div class="row form-group">
                        <div class="col-lg-12">
                            <label>IDGPS</label>
                            <div class="input-group">
                                <p id="idgps"></p>
                            </div>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-lg-12">
                            <label>Comentarios</label>
                            <div class="input-group">
                                <p id="comentarios_detalle"></p>
                            </div>
                        </div>
                    </div>
                    <div class="separator separator-dashed my-8"></div>
                    <div class="form-group row">
                        <div class="col-lg-12 col-md-12 col-sm-12">

                            <div class="dropzonex dropzone-multi subir_archivos" id="dropzone-validacion" data-id-requisito="">
                                <div class="dropzone-panel mb-lg-0 mb-2">
                                    <a class="dropzone-select btn btn-light-primary font-weight-bold btn-sm">Seleccionar archivo</a>
                                </div>
                                <div class="dropzone-items">
                                    <div class="dropzone-item" style="display:none">
                                        <div class="dropzone-file">
                                            <div class="dropzone-filename" title="some_image_file_name.jpg">
                                                <span data-dz-name="">some_image_file_name.jpg</span>
                                                <strong>(
                                                    <span data-dz-size="">340kb</span>)</strong>
                                            </div>
                                            <div class="dropzone-error" data-dz-errormessage=""></div>
                                        </div>
                                        <div class="dropzone-progress">
                                            <div class="progress">
                                                <div class="progress-bar bg-primary" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0" data-dz-uploadprogress=""></div>
                                            </div>
                                        </div>
                                        <div class="dropzone-toolbar">
                                            <span class="dropzone-delete" data-dz-remove="">
                                                <i class="flaticon2-cross"></i>
                                            </span>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn btn-secondary font-weight-bold" data-dismiss="modal">
                    <i class="la la-arrow-left"></i>
                    Regresar
                </button>
            </div>
        </div>
    </div>
</div>


@endsection
