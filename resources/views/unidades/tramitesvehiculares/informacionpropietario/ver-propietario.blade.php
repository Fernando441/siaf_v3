@extends('layouts.app')
@push('scripts')
	<script src="{{ asset('js/catalogos/Tramitesvehiculares/InformacionPropietarioAgregar.js') }}"></script> 
    <meta name="csrf-token" content="{{ csrf_token() }}" />
@endpush
@section('title')
    Informacion Propietario
@endsection
@section('content')

    <!--begin::Card-->
    <div class="row">
        <div class="col-lg-12">
            <!--begin::Card-->
            <div class="card card-custom gutter-b">
                <div class="card-header">
                    <h3 class="card-title">Propietario</h3>
                </div>
                
                    <input type='hidden' id='url_municipios' value='{{ route('cliente.obtenermunicipios') }}'>
                    <input type="hidden" name="id_propietario" value="{{ $propietario->id }}">
                    <div class="card-body">
                        <!--begin::tabs-->
                        <ul class="nav nav-tabs nav-tabs-line">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#kt_tab_pane_1">Información del propietario</a>
                            </li>

                        </ul>
                        <div class="tab-content mt-5" id="myTabContent">
                            <div class="tab-pane fade show active mt-10" id="kt_tab_pane_1" role="tabpanel" aria-labelledby="kt_tab_pane_1">
                                <div class="form-group row">
                                    <div class="col-lg-6">
                                        <label>Nombre completo del propietario</label>
                                        <div class="input-group">
                                            <p>{{ $propietario->nombre_propietario }}</p>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <label>RFC</label>
                                        <div class="input-group">
                                            <p>{{ $propietario->rfc }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-6">
                                        <label>Número de identificación</label>
                                        <div class="input-group">
                                            <p>{{ $propietario->no_identificacion }}</p>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <label>Dirección</label>
                                        <div class="input-group">
                                            <p>{{ $propietario->direccion }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-6">
                                        <label>Estado</label>
                                        @foreach($estados as $estado)
                                            @if($estado->id_estado == $propietario->estado_id )
                                                <p>{{ $estado->estado_nombre }}</p>
                                            @endif
                                        @endforeach

                                    </div>
                                    <div class="col-lg-6">
                                        <label>Municipio y/o Alcaldía.</label>
                                        @foreach($municipios as $municipio)
                                            @if($municipio->id_municipio == $propietario->ciudad_id )
                                                <p>{{ $municipio->municipio_nombre }}</p>
                                            @endif
                                        @endforeach

                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-lg-3">
                                        <label>Codigo Postal</label>
                                        <div class="input-group">
                                            <p>{{ $propietario->cp }}</p>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <label>Teléfono</label>
                                        <div class="input-group">
                                           <p>{{ $propietario->telefono }}</p>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <label>Correo electrónico</label>
                                        <div class="input-group">
                                            <p>{{ $propietario->correo }}</p>
                                        </div>
                                    </div>
                                </div>

                            </div>


                        </div>
                        <!--end::tabs-->

                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-lg-6">
                                <a href="{{ route('propietario.infopropietario') }}"  class="btn btn-secondary"><i class="la la-arrow-left"></i>Regresar</a>
                            </div>
                        </div>
                    </div>

                <!--end::Form-->
            </div>
            <!--end::Card-->
        </div>
    </div>
    <!--end::Card-->

@endsection
