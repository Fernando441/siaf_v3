@extends('layouts.app')
@section('title')
    Tramites vehiculares
@endsection
@push('scripts')
    <script src="{{ asset('js/unidades/Tramitevehicular.js') }}"></script>
@endpush

@section('content')
<style type="text/css">
    .oculto{
        display: none;
    }
</style>
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-custom gutter-b">
                <div class="card-header">
                    <h3 class="card-title">Tramites vehiculares</h3>
                </div>

                <form class="form" action="" method="post" id="submit_unidad" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <input type="hidden" name="unidad_id" value="{{ $unidad }}">
                        <div class="form-group row">
                            <div class="col-lg-8">
                                {{-- <label>Selecciona el tramite a realizar</label> --}}
                            </div>
                            <div class="col-lg-4 text-center">
{{--                                 <button class="btn btn-sm btn-light-primary font-weight-bold">
                                    <i class="flaticon2-cube"></i> Carga Masiva
                                </button> --}}
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="card card-custom gutter-b">
                                    <div class="card-header">
                                        <div class="card-title">
                                            <h3 class="card-label">
                                                Emplacamiento
                                            </h3>

                                            <div class="card-toolbar">
                                                <a href="{{ route('traveh.tvemplacamiento', $unidad) }}" class="btn btn-sm btn-light-primary font-weight-bold">
                                                    <i class="flaticon2-cube"></i> Reralizar tramite
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <label><b>Requisitos</b></label>
                                        @foreach($req_emplacamiento as $unid)
                                            <li>{{ $unid->nombre_requisito }}</li>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="card card-custom gutter-b">
                                    <div class="card-header">
                                        <div class="card-title">
                                            <h3 class="card-label">
                                                Tenencia y/o pago de derechos
                                            </h3>

                                            <div class="card-toolbar">
                                                <a href="{{ route('traveh.tvtenencia', $unidad) }}" class="btn btn-sm btn-light-primary font-weight-bold">
                                                    <i class="flaticon2-cube"></i> Reralizar tramite
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <label><b>Requisitos</b></label>
                                        @foreach($req_tenencia as $unid)
                                            <li>{{ $unid->nombre_requisito }}</li>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="card card-custom gutter-b">
                                    <div class="card-header">
                                        <div class="card-title">
                                            <h3 class="card-label">
                                                Verificación
                                            </h3>

                                            <div class="card-toolbar">
                                                <a href="{{ route('traveh.tvverificacion', $unidad) }}" class="btn btn-sm btn-light-primary font-weight-bold">
                                                    <i class="flaticon2-cube"></i> Reralizar tramite
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <label><b>Requisitos</b></label>
                                        @foreach($req_verificacion as $unid)
                                            <li>{{ $unid->nombre_requisito }}</li>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

{{--                             <div class="col-lg-6">
                                <div class="card card-custom gutter-b">
                                    <div class="card-header">
                                        <div class="card-title">
                                            <h3 class="card-label">
                                                Aseguramiento
                                            </h3>

                                            <div class="card-toolbar">
                                                <a href="{{ route('traveh.tvaseguramiento', $unidad) }}" class="btn btn-sm btn-light-primary font-weight-bold">
                                                    <i class="flaticon2-cube"></i> Reralizar tramite
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <label><b>Requisitos</b></label>
                                        @foreach($req_aseguramiento as $unid)
                                            <li>{{ $unid->nombre_requisito }}</li>
                                        @endforeach
                                    </div>
                                </div>
                            </div> --}}

                            <div class="col-lg-6">
                                <div class="card card-custom gutter-b">
                                    <div class="card-header">
                                        <div class="card-title">
                                            <h3 class="card-label">
                                                Reemplacamiento
                                            </h3>

                                            <div class="card-toolbar">
                                                <a href="{{ route('traveh.tvreemplaca', $unidad) }}" class="btn btn-sm btn-light-primary font-weight-bold">
                                                    <i class="flaticon2-cube"></i> Reralizar tramite
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <label><b>Requisitos</b></label>
                                        @foreach($req_reemplacamiento as $unid)
                                            <li>{{ $unid->nombre_requisito }}</li>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                        </div>


                        <div class="row">
                            <div class="col-lg-6">
                                <div class="card card-custom gutter-b">
                                    <div class="card-header">
                                        <div class="card-title">
                                            <h3 class="card-label">
                                                Baja vehículo
                                            </h3>

                                            <div class="card-toolbar">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="row">
                                                    <div class="col-lg-8">
                                                        <label><b>Requisitos por venta</b></label>
                                                        @foreach($req_bajav_venta as $unid)
                                                            <li>{{ $unid->nombre_requisito }}</li>
                                                        @endforeach  
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <a href="{{ route('traveh.tvbjventa',$unidad) }}" class="btn btn-sm btn-light-primary font-weight-bold">
                                                            <i class="flaticon2-cube"></i> Reralizar tramite
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 mt-2">
                                                <div class="row">
                                                    <div class="col-lg-8">
                                                        <label><b>Requisitos por robo</b></label>
                                                        @foreach($req_bajav_robo as $unid)
                                                            <li>{{ $unid->nombre_requisito }}</li>
                                                        @endforeach  
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <a href="{{ route('traveh.tvbjrobo',$unidad) }}" class="btn btn-sm btn-light-primary font-weight-bold">
                                                            <i class="flaticon2-cube"></i> Reralizar tramite
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mt-2">
                                            <div class="col-lg-12 mt-2">
                                                <div class="row">
                                                    <div class="col-lg-8">
                                                        <label><b>Requisitos por siniestro</b></label>
                                                        @foreach($req_bajav_siniestro as $unid)
                                                            <li>{{ $unid->nombre_requisito }}</li>
                                                        @endforeach
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <a href="{{ route('traveh.tvbjsiniestro',$unidad) }}" class="btn btn-sm btn-light-primary font-weight-bold">
                                                            <i class="flaticon2-cube"></i> Reralizar tramite
                                                        </a>
                                                    </div>
                                                </div>    
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="card card-custom gutter-b">
                                    <div class="card-header">
                                        <div class="card-title">
                                            <h3 class="card-label">
                                                Cambio de propietario
                                            </h3>

                                            <div class="card-toolbar">
                                                <a href="{{ route('traveh.tvcambiopro', $unidad) }}" class="btn btn-sm btn-light-primary font-weight-bold">
                                                    <i class="flaticon2-cube"></i> Reralizar tramite
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <label><b>Requisitos</b></label>
                                        @foreach($req_cambio_propietario as $unid)
                                            <li>{{ $unid->nombre_requisito }}</li>
                                        @endforeach
                                    </div>
                                </div>
                            </div>


                        </div>

                        <div class="row">


                            <div class="col-lg-6">
                                <div class="card card-custom gutter-b">
                                    <div class="card-header">
                                        <div class="card-title">
                                            <h3 class="card-label">
                                                Reposición
                                            </h3>

                                            <div class="card-toolbar">
                                                <a href="{{ route('traveh.tvgps', $unidad) }}" class="btn btn-sm btn-light-primary font-weight-bold">
                                                    <i class="flaticon2-cube"></i> Realizar tramite
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <label><b>Requisitos</b></label>
                                        @foreach($req_gps as $unid)
                                            <li>{{ $unid->nombre_requisito }}</li>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                        </div>




{{--                         <div class="row oculto" id="div_altavehiculo">
                            <div class="card card-custom gutter-b">
                                <div class="card-header">
                                    <div class="card-title">
                                        <h3 class="card-label">
                                            Alta de vehículo
                                            <small></small>
                                        </h3>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <label>Registro del vehiculo ante autoridad competente.</label>
                                        </div>

                                        <div class="col-lg-12">
                                            <span><b>Requisitos</b></span>
                                            <ul>
                                              <li>Pago de derechos</li>
                                              <li>Documentos que acrediten la propiedad</li>
                                              <li>Factura</li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="row form-group" >
                                        <div class="col-lg-12" id="tblArchivos">
                                            <table class='table table-bordered table-hover' id='tblDocumentos'>
                                                <thead>
                                                <tr>
                                                    <th>Adjuntar Documento</th>
                                                    <th>Fecha de alta</th>
                                                    <th>Opción</th>
                                                </tr>
                                                </thead>
                                                <tbody id='tbodyDocumentos'>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="row form-group">
                                        <div class="col-lg-12">
                                            <a href="#" class="btn btn-icon btn-outline-success btn-circle btn-sm mr-2 hrefAgregarOtro" data-toggle="tooltip" data-theme="dark" title="Agregar archivo">
                                                <i class="flaticon2-plus"></i>
                                            </a>
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div> --}}


{{--                         <div class="row oculto" id="divcambiopropietario">
                            <div class="card card-custom gutter-b">
                                <div class="card-header">
                                    <div class="card-title">
                                        <h3 class="card-label">
                                            Cambio de propietario
                                            <small></small>
                                        </h3>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <label>Transferencia de propiedad de un vehículo entre propietarios, con cambio de nombre en los registros.</label>
                                        </div>

                                        <div class="col-lg-12">
                                            <span><b>Requisitos</b></span>
                                            <ul>
                                              <li>Tarjeta de circulación</li>
                                              <li>Placas</li>
                                              <li>Acreditar propiedad (factura)</li>
                                              <li>Requisitado de formato</li>
                                              <li>Entrega de laminas</li>
                                              <li>Entrega de la tarjeta de circulación</li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="row form-group" >
                                        <div class="col-lg-12" id="tblArchivos">
                                            <table class='table table-bordered table-hover' id='tblDocumentos'>
                                                <thead>
                                                <tr>
                                                    <th>Adjuntar Documento</th>
                                                    <th>Fecha del tramite</th>
                                                    <th>Opción</th>
                                                </tr>
                                                </thead>
                                                <tbody id='tbodyDocumentos'>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="row form-group">
                                        <div class="col-lg-12">
                                            <a href="#" class="btn btn-icon btn-outline-success btn-circle btn-sm mr-2 hrefAgregarOtro" data-toggle="tooltip" data-theme="dark" title="Agregar archivo">
                                                <i class="flaticon2-plus"></i>
                                            </a>
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div> --}}

                    </div>
                    <div class="card-footer" >
                        <div class="row">
                            <div class="col-lg-12">
                                {{-- <button type="button"  id="btnGuardar" class="btn btn-primary mr-2">Guardar</button> --}}
                                <a href="{{ route('unidad.catalogounidad') }}"  class="btn btn-secondary"><i class="la la-arrow-left"></i>Regresar</a>
                            </div>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
