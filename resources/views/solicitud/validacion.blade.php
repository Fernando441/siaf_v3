@extends('layouts.app')
@section('title')
    Validación Solicitud GPS
@endsection
@push('scripts')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <script src="{{ asset('js/solicitud/validacion.js') }}"></script>
@endpush

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <div class="card card-custom gutter-b">
                <div class="card-header">
                    <h3 class="card-title">Validación Solicitud GPS</h3>
                </div>

                <form class="form" action="{{ route('solicitud.guardarValidacion') }}" method="post" id="solicitud">
                    @csrf
                    <input type="hidden" id="opcion_guardar" name="opcion_guardar" value="" />
                    <input type="hidden" id="solicitud_id" name="solicitud_id" value="{{ $solicitudes->id }}" />
                    <input type="hidden" id="solicitud_ejecucion_id" name="solicitud_ejecucion_id" value="@isset($solicitudEjecucion->id) {{ $solicitudEjecucion->id }} @endisset" />

                    <div class="card-body">
                        @include('solicitud.validacion-detalle')
                        
                        <div class="card-footer px-0" style="padding-bottom: 0px;">
                            <div class="row">
                                <div class="col-lg-6">
                                    <button type="button" id="btn_visto_bueno" class="btn btn-success" data-wizard-type="action-next">
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


 {{-- V E N D E R    U N I D A D --}}



@endsection
