@extends('layouts.app')
@section('title')
    Ver Unidad
@endsection
@push('scripts')
    <script src="{{ asset('js/unidades/EditarUnidad.js') }}"></script>
@endpush
@section('content')

 {{-- E D I T A R    U N I D A D --}}

    <div class="row">
        <div class="col-lg-12">
            <div class="card card-custom gutter-b">
                <div class="card-header">
                    <h3 class="card-title">Ver Unidad</h3>
                </div>

                    <input type="hidden" name="id" value="{{ $unidad->id }}">
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
                                <a class="nav-link" data-toggle="tab" href="#kt_tab_pane_4">Fotografía</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#kt_tab_pane_5">Bitácora</a>
                            </li>
                        </ul>
                        <div class="tab-content mt-5" id="myTabContent">
                            <div class="tab-pane fade show active mt-10" id="kt_tab_pane_1" role="tabpanel" aria-labelledby="kt_tab_pane_2">
                                @include('unidades.gerenciacomercial.ver-informacion-basica')
                            </div>
                            <div class="tab-pane fade mt-10" id="kt_tab_pane_2" role="tabpanel" aria-labelledby="kt_tab_pane_2">
                                @include('unidades.gerenciacomercial.ver-informacion-general')
                            </div>
                            <div class="tab-pane fade mt-10" id="kt_tab_pane_3" role="tabpanel" aria-labelledby="kt_tab_pane_3">
                                @include('unidades.gerenciacomercial.ver-documentos')
                            </div>
                            <div class="tab-pane fade mt-10" id="kt_tab_pane_4" role="tabpanel" aria-labelledby="kt_tab_pane_4">
                                @include('unidades.gerenciacomercial.ver-fotografia')
                            </div>
                            <div class="tab-pane fade mt-10" id="kt_tab_pane_5" role="tabpanel" aria-labelledby="kt_tab_pane_5">
                                @include('unidades.gerenciacomercial.ver-bitacora')
                            </div>
                    </div>
                    <div class="card-footer px-0" style="padding-bottom: 0px;">
                        <div class="row">
                            <div class="col-lg-6">
                                <a href="{{ route('comercialinv.inventariocomercial') }}"  class="btn btn-secondary"><i class="la la-arrow-left"></i>Regresar</a>
                            </div>

                        </div>
                    </div>

            </div>
        </div>
    </div>


 {{-- E D I T A R    U N I D A D --}}



@endsection
