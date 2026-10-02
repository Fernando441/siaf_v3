@extends('layouts.app')
@push('scripts')
    <script src="{{ asset('js/catalogos/agencias/CrearAgencia.js') }}"></script> 
@endpush
@section('title')
    Agregar Agencia
@endsection
@section('content')

    <!--begin::Card-->
    <div class="row">
        <div class="col-lg-12">
            <!--begin::Card-->
            <div class="card card-custom gutter-b">
                <div class="card-header">
                    <h3 class="card-title">Agregar Agencia</h3>
                </div>
                <!--begin::Form-->
                <form action="{{ route('agencia.guardaragencia') }}" method="post" id="submit_agencia">
                    @csrf
                    <div class="card-body">

                        <div class="form-group row">
                            <div class="col-lg-6">
                                <label>Nombre o razon social</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="razon_social" id="razon_social" required onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label>Proveedores</label>
                                <select class="form-control" name="id_proveedor" id="id_proveedor" required>
                                    <option value="">Selecciona un opción</option>
                                    @foreach($proveedor as $pro)
                                        <option value="{{ $pro->id }}" >{{ $pro->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-6">
                                <label>Contacto</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="contacto" id="contacto" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label>Puesto</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="puesto" id="puesto" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-6">
                                <label>Dirección</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="direccion" id="direccion" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label>Telefono</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" name="telefono" id="telefono"/>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-6">
                                <label>Correo</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="correo" id="correo" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                </div>
                            </div>
                        </div>

                        <!--end::tabs-->

                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-lg-6">
                                <button type="button"  id="btnGuardar" class="btn btn-success"><i class="la la-plus"></i>Guardar</button>
                                <a href="{{ route('agencia.catalogoagencias') }}"  class="btn btn-secondary"><i class="la la-arrow-left"></i>Regresar</a>
                            </div>
                        </div>
                    </div>
                </form>
                <!--end::Form-->
            </div>
            <!--end::Card-->
        </div>
    </div>
    <!--end::Card-->

@endsection