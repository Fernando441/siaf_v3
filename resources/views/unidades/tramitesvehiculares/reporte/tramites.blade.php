@extends('layouts.app')
@push('scripts')
    <script src="{{ asset('js/unidades/reporte/index.js') }}"></script>
	<meta name="csrf-token" content="{{ csrf_token() }}" />
@endpush
@section('title')
    Busquedas
@endsection
@section('content')

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
                                                    <i class="flaticon2-search text-primary"></i>
                                                </span>
                                    <h3 class="card-label">Reporte de Trámites Vehículares</h3>
                                </div>
                                <div class="card-toolbar">
                                </div>
                            </div>
                            <div class="card-body">

                                <div class="collapsex" id="collapseExample">
                                    <div class="card card-body">

                                        <!--begin: Search Form-->
                                        <form id="form" method="post" action="{{ route('tramiteReporte.consulta') }}" class="form">
                                            @csrf    
                                            <input type='hidden' id='bid' name='bid' value='{{ $bid }}'>

                                            <div class="form-group row ">
                                                <div class="col-lg-6">
                                                    <label>Fecha Inicio de Trámite</label>
                                                    <input type="text" class="form-control" readonly="" name="fecha_inicio" id="fecha_inicio" required>
                                                </div>
                                                <div class="col-lg-6">
                                                    <label>Fecha Final de Trámite</label>
                                                    <input type="text" class="form-control" readonly="" name="fecha_final" id="fecha_final" required>
                                                </div>
                                            </div>

                                            <div class="form-group row pt-5">
                                                <div class="col-lg-12">
                                                    <small class="form-text text-muted" >Ingrese los datos para realizar al reporte.</small>
                                                </div>
                                            </div>



                                            <div class="card-footer">
                                                <div class="row">
                                                    <div class="col-lg-8">
                                                        <button type="button"  id="btnGuardar" class="btn btn-success"><i class="la la-search"></i>Buscar</button>
                                                    </div>
                                                </div>
                                            </div>

                                        </form>


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
