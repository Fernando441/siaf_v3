@extends('layouts.app')
@section('title')
    Solicitar atención
@endsection

@push('scripts')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <script src="{{ asset('js/taller/SolicitarAtencion.js') }}" type="text/javascript"></script>
@endpush

@section('content')
    <div class="d-flex flex-row">

    <!--begin::List-->
    <div class="flex-row-fluid">
        <div class="d-flex flex-column flex-grow-1">

            <!--begin::Row-->
            <div class="row">
                <div class="col-xl-12">
                    <div class="container">
                        <!--begin::Profile Personal Information-->
                        <div class="d-flex flex-row">
                            <!--begin::Content-->
                            <div class="flex-row-fluid">
                                <!--begin::Card-->
                                <div class="card card-custom card-stretch">
                                    <!--begin::Header-->
                                    <div class="card-header py-3">
                                        <div class="card-title align-items-start flex-column">
                                            <h3 class="card-title">Solicitar atención</h3>
                                        </div>
                                    </div>
                                    <!--end::Header-->
                                    <!-- Placas Card -->
                                    <div class="card">
                                        <div class="card-body py-3 pt-5">
                                            <div class="row text-center">
                                                <div class="col-md-6">
                                                    <div>
                                                        <h3>
                                                            No. Serie: <span class="ml-3 badge badge-pill badge-dark px-6">{{ $unidad->no_serie }}</span>
                                                        </h3>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div>
                                                        <h3>Placas: <span class="ml-3 badge badge-pill badge-primary px-6" style="text-transform: uppercase;">
                                                            @if($unidad->placa == null)
                                                                Sin Placas
                                                            @else
                                                                {{ $unidad->placa }}
                                                            @endif
                                                        </span></h3>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Estados:
                                        1	pendiente	
                                        2	preautorizado	
                                        3	autorizado	
                                        4	con evidencia	
                                        5	tesorería	@TODO
                                        6	finalizado	@TODO
                                        7	incompleto	
                                        8	rechazado	 --}}
                                    
                                    {{-- @if($unidad->unidad_asignacion_id === 1 && $unidad->proyectos_id !== null && $unidad->proyecto->firma_final_vigencia > date('Y-m-d') && $estado < 1) --}}
                                        @include('taller.componentes.formulario-solicitar-atencion')
                                    {{-- @endif --}}
                                    
{{--                                     @if($unidad->unidad_asignacion_id === 1 && $unidad->proyectos_id === null)
                                        @include('taller.componentes.msg-no-contrato')
                                    @endif
                                    
                                    @if($unidad->unidad_asignacion_id === 2)
                                        @include('taller.componentes.msg-unidad-oficina')
                                    @endif
                                    
                                    @if($unidad->unidad_asignacion_id === 1 && $unidad->proyectos_id !== null && $unidad->proyecto->firma_final_vigencia < date('Y-m-d'))
                                        @include('taller.componentes.msg-contrato-vencido')
                                    @endif
                                    
                                    @if ($estado != 6 && $estado != 7 && $estado != 8)
                                        @if($estado >= 1 && $unidad->unidad_asignacion_id === 1 && $unidad->proyectos_id !== null && $unidad->proyecto->firma_final_vigencia > date('Y-m-d'))
                                            @include('taller.componentes.msg-unidad-en-mantenimiento')
                                        @endif
                                    @else
                                        @if($unidad->unidad_asignacion_id === 1 && $unidad->proyectos_id !== null && $unidad->proyecto->firma_final_vigencia > date('Y-m-d'))
                                            @include('taller.componentes.formulario-solicitar-atencion')
                                        @endif
                                    @endif --}}

                                </div>
                            </div>
                            <!--end::Content-->
                        </div>
                        <!--end::Profile Personal Information-->
                    </div>
                </div>
            </div>
            <!--end::Row-->
        </div>
    </div>
    <!--end::List-->
</div>
	
@endsection