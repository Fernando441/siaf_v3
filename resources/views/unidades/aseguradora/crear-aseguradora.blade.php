@extends('layouts.app')
@push('scripts')
    <script src="{{ asset('js/catalogos/aseguradora/CrearAseguradora.js') }}"></script> 
@endpush
@section('title')
    Agregar Aseguradora
@endsection
@section('content')

    <!--begin::Card-->
    <div class="row">
        <div class="col-lg-12">
            <!--begin::Card-->
            <div class="card card-custom gutter-b">
                <div class="card-header">
                    <h3 class="card-title">Agregar Aseguradora</h3>
                </div>
                <!--begin::Form-->
                <form action="{{ route('aseguradora.guardaraseguradora') }}" method="post" id="submit_aseguradora">
                    @csrf
                    <div class="card-body">

                                <div class="form-group row">
                                    <div class="col-lg-6">
                                        <label>Nombre de la aseguradora</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="nombre_aseguradora" id="aseguradora_add" required onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <label>Nombre completo del contacto</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="nombre_contacto" id="nombre_contacto" required onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-6">
                                        <label>Email del contacto</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="email_contacto" id="email_contacto" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <label>Teléfono del contacto</label>
                                        <div class="input-group">
                                            <input type="number" class="form-control" name="telefono_contacto" id="telefono_contacto"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-6">
                                        <label>Calle</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="calle" id="calle" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <label>Colonia / Delegación</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="colonia" id="colonia" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-6">
                                        <label>Codigo postal</label>
                                        <div class="input-group">
                                            <input type="number" class="form-control" name="cp" id="cp"/>
                                        </div>
                                    </div>
                                </div>

                        <!--end::tabs-->

                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-lg-6">
                                <button type="button"  id="btnGuardar" class="btn btn-success"><i class="la la-plus"></i>Guardar</button>
                                <a href="{{ route('aseguradora.catalogoaseguradora') }}"  class="btn btn-secondary">     <i class="la la-arrow-left"></i>Regresar</a>
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