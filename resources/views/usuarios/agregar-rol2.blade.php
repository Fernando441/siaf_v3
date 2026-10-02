@extends('layouts.app')
@push('scripts')
    {{-- <script src="{{ asset('js/roles/AgregarRol.js') }}"></script> --}}
    <script src="{{ asset('js/roles/PermisosRol.js') }}"></script>
@endpush
@section('title')
    Agregar Rol
@endsection
@section('content')

 



<!--begin::Todo-->
<div class="d-flex flex-row">

    <!--begin::Aside-->
    @include('usuarios.roles.rol-nav')
    <!--end::Aside-->

    <!--begin::List-->
    <div class="flex-row-fluid ml-lg-2">
        <div class="d-flex flex-column flex-grow-1">
            <!--begin::Row-->
            <div class="row">
                <div class="col-xl-12">

                    <div class="card card-custom gutter-b">

                        <div class="card-header">
                            <h3 class="card-title">Agregar Permisos</h3>
                        </div>
                        <!--begin::Form-->
                        <form class="form" action="{{ route('rol.guardarrol') }}" method="post" id="frmRol">
                            @csrf   
                            <input type="hidden" name="menu" value="{{ $menu }}" >
                            <div class="card-body">

                                <div class="form-group row">
                                    <div class="col-lg-12">
                                        <label>Nombre del Rol</label>
                                        <div class="input-group">
                                            <p>{{ $rolInfo->name }}</p>
                                        </div>
                                    </div>
                                     
                                </div>

                                <div class="accordion accordion-solid accordion-toggle-plus" id="accordionExample6">
                                    <div class="card">
                                        @php($plantilla = 'usuarios.roles.' . $plantillaPermisos)
                                        @include($plantilla)
                                    </div>
                                </div>
                                
                            </div>
                            <div class="card-footer">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <button type="button"  id="btnGuardar" class="btn btn-success"><i class="la la-plus"></i>Guardar</button>
                                            <a href="{{ route('cliente.catalogoCliente') }}"  class="btn btn-secondary"><i class="la la-arrow-left"></i>Regresar</a>
                                        </div>
                                    </div>
                                </div>
                        </form>
                    </div>
                </div>   
            </div>
        </div>
    </div>
</div>
										 

@endsection
