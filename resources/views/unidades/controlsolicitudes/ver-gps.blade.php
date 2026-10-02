@extends('layouts.app')
@section('title')
    Ver Solicitud GPS
@endsection
@push('scripts')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <script src="{{ asset('js/solicitud/ver-solicitud.js') }}"></script>
@endpush

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <div class="card card-custom gutter-b">
                <div class="card-header">
                    <h3 class="card-title">Ver Solicitud GPS</h3>
                </div>

                <form class="form" action="{{ route('solicitud.listado') }}" method="post" id="solicitud">
                    @csrf
                    <input type="hidden" id="solicitud_id" name="solicitud_id" value="{{ $solicitudes->id }}" />
                    <input type="hidden" id="solicitud_ejecucion_id" name="solicitud_ejecucion_id" value="@isset($solicitudEjecucion->id) {{ $solicitudEjecucion->id }} @endisset" />
                    <div class="card-body">
                        @include('solicitud.ver-detalle')
                        
                        <div class="card-footer px-0" style="padding-bottom: 0px;">
                            <div class="row">
                                <div class="col-lg-6">
                                    <a href="{{ route('controlsol.controlsolicitudes') }}"  class="btn btn-secondary"><i class="la la-arrow-left"></i>Regresar</a>
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
                    <h5 class="modal-title">Actividad</h5>
    
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
                                    <div class="dropzone-items" id="dropzone-items">
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
