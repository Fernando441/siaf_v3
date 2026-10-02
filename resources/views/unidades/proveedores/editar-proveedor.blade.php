@extends('layouts.app')
@push('scripts')
    <script src="{{ asset('js/catalogos/proveedores/EditarProveedor.js') }}"></script> 
@endpush
@section('title')
    Editar Proveedor
@endsection
@section('content')

    <!--begin::Card-->
    <div class="row">
        <div class="col-lg-12">
            <!--begin::Card-->
            <div class="card card-custom gutter-b">
                <div class="card-header">
                    <h3 class="card-title">Agregar Proveedor</h3>
                </div>
                <!--begin::Form-->
                <form action="{{ route('proveedor.editarproveedor') }}" method="post" id="submit_proveedor">
                    @csrf
                    <div class="card-body">
                        @foreach($proveedor_info as $pro)
                            <input type="hidden" name="id" value="{{ $pro->id }}">
                            <div class="form-group row">
                                <div class="col-lg-6">
                                    <label>Nombre del proveedor</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" value="{{ $pro->nombre }}" name="nombre" id="nombre" required onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <label>Dirección</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" value="{{ $pro->direccion }}" name="direccion" id="direccion" required onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-6">
                                    <label>Teléfono</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" value="{{ $pro->telefono }}" name="telefono" id="telefono"/>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <label>Contacto</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" value="{{ $pro->contacto }}" name="contacto" id="contacto" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-6">
                                    <label>Correo</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" value="{{ $pro->correo }}" name="correo" id="correo" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <label>Giro comercial</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" value="{{ $pro->giro_comercial }}" name="giro_comercial" id="giro_comercial" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-6">
                                    <label>RFC</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" value="{{ $pro->rfc }}" name="rfc" id="rfc" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                    </div>
                                </div>
                            {{-- proveedorTipo --}}
                            <div class="col-lg-6">
                                <label>Tipo de proveedor</label>
                                <div class="input-group">
                                    <select class="form-control" name="proveedorTipo" id="proveedorTipo">
                                        <option value="">Seleccione una opción</option>
                                        @foreach($tipos_proveedor as $pt)
                                            <option value="{{ $pt->id }}" {{ $pt->id == $pro->proveedor_tipo_id ? 'selected' : '' }}>{{ $pt->tipo }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-lg-12">
                                    <label>Convenio con el proveedor</label>
                                    <div class="input-group">
                                        <textarea class="form-control" name="convenio"  id="convenio" rows="3" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">{{ $pro->convenio }}</textarea>
                                    </div>
                                </div>
                            </div>
                            
                            <!--end::tabs-->
                        @endforeach
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-lg-6">
                                <button type="button"  id="btnGuardar" class="btn btn-success"><i class="la la-plus"></i>Guardar</button>
                                <a href="{{ route('proveedor.catalogoproveedores') }}"  class="btn btn-secondary"><i class="la la-arrow-left"></i>Regresar</a>
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