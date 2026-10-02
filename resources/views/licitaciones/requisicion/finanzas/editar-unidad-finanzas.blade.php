@extends('layouts.app')
@section('title')
    Editar unidad
@endsection
@push('scripts')
    <script src="{{ asset('js/unidades/EditarUnidad.js') }}"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
@endpush

@section('content')
<style type="text/css">
    .oculto{
        display: none;
    }
</style>
 {{-- E D I T A R    U N I D A D --}}
    <input type="hidden" id="documentoEliminarPath" value="{{ route('unidad.eliminardocumento') }}">
    <input type="hidden" id="fotografiaEliminarPath" value="{{ route('unidad.eliminarfotografia') }}">

    <div class="row">
        <div class="col-lg-12">
            <div class="card card-custom gutter-b">
                <div class="card-header">
                    <h3 class="card-title">Editar unidad</h3>
                </div>

                <form class="form" action="{{ route('finanzas.editarunidadfin') }}" method="post" id="submit_unidad" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{ $unidad->id }}">
                    <input type='hidden' id='tipoArchivo' value='{{ $cadenaTipoDocumento }}'>

                    <input type="hidden" name="requisicion_id" value="{{ $requisicion_id }}">
                    <input type="hidden" name="orden_id" value="{{ $orden_id }}">
                    <input type="hidden" name="prov" value="{{ $prov }}">
                    <div class="card-body">

                        <ul class="nav nav-tabs nav-tabs-line">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#kt_tab_pane_1">Datos del Vehículo</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#kt_tab_pane_2">Condiciones Físicas del Vehículo</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#kt_tab_pane_3">Documentos</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#kt_tab_pane_4">Fotografías</a>
                            </li>
                        </ul>
                        <div class="tab-content mt-5" id="myTabContent">
                            <div class="tab-pane fade show active mt-10" id="kt_tab_pane_1" role="tabpanel" aria-labelledby="kt_tab_pane_2">

                                @include('licitaciones.requisicion.finanzas.unidad-edit.editar-informacion-basica')
                            </div>
                            <div class="tab-pane fade mt-10" id="kt_tab_pane_2" role="tabpanel" aria-labelledby="kt_tab_pane_2">
                                @include('licitaciones.requisicion.finanzas.unidad-edit.editar-condiciones-fisicas')
                            </div>
                            <div class="tab-pane fade mt-10" id="kt_tab_pane_3" role="tabpanel" aria-labelledby="kt_tab_pane_3">
                                @include('licitaciones.requisicion.finanzas.unidad-edit.editar-documento-finanzas')
                            </div>
                            <div class="tab-pane fade mt-10" id="kt_tab_pane_4" role="tabpanel" aria-labelledby="kt_tab_pane_4">
                                {{-- @include('unidades.editar-fotografia') --}}
                            </div>
                    </div>
                    <div class="card-footer px-0" style="padding-bottom: 0px;">
                        <div class="row">
                            <div class="col-lg-6">
                                <button type="button"  id="btnGuardarUnidad" class="btn btn-success"><i class="la la-plus"></i>Guardar</button>
                                <a href="{{ route('finanzas.verordendetalle',[$requisicion_id, $orden_id, $prov]) }}"  class="btn btn-secondary"><i class="la la-arrow-left"></i>Regresar</a>
                            </div>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>


 {{-- E D I T A R    U N I D A D --}}



@endsection
