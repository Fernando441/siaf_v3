@extends('layouts.app')
@section('title')
    Información del seguro
@endsection
@push('scripts')
    <script src="{{ asset('js/unidades/Agregarinfogps.js') }}"></script>
@endpush

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <div class="card card-custom gutter-b">
                <div class="card-header">
                    <h3 class="card-title">Información del gps</h3>
                </div>

                <form class="form" action="{{ route('unidad.guardarinfogps') }}" method="post" id="submit_unidad" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <input type="hidden" name="unidad_id" value="{{ $unidad }}">
                        <div class="form-group row">
                            <div class="col-lg-6">
                                <label>Número de identificación del dispositivo GPS</label>
                                <div class="input-group">
                                    <input type="text" name="numero_gps" id="numero_gps"  class="form-control" required onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label>Marca del dispositivo gps</label>
                                <div class="input-group">
                                    <input type="text" name="marca_gps" id="marca_gps"  class="form-control" required onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                </div>
                            </div>
                        </div>


                        <div class="form-group row">
                            <div class="col-lg-6">
                                <label>Modelo del dispositivo gps</label>
                                <div class="input-group">
                                    <input type="text" name="modelo_gps" id="modelo_gps"  class="form-control" required onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label>Fecha de instalación</label>
                                <div class="input-group">
                                    <input type="text" name="fecha_instalacion" id="fecha_instalacion"  class="form-control" readonly required />
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-lg-12">
                                <label>Información del proveedor de servicios de GPS utilizado</label>
                                <div class="input-group">
                                    <input type="text" name="info_proveedor" id="info_proveedor" class="form-control" required onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                </div>
                            </div>

                        </div>

                    </div>
                    <div class="card-footer" >
                        <div class="row">
                            <div class="col-lg-12">
                                <button type="button"  id="btnGuardar" class="btn btn-success"><i class="la la-plus"></i>Guardar</button>
                                <a href="{{ route('unidad.catalogounidad') }}"  class="btn btn-secondary"><i class="la la-arrow-left"></i>Regresar</a>
                            </div>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
