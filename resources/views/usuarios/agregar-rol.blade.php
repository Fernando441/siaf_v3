@extends('layouts.app')
@push('scripts')
  {{-- <script src="{{ asset('js/Usuarios.js') }}"></script> --}}
  <script src="{{ asset('js/roles/AgregarRol.js') }}"></script>
  <script src="{{ asset('js/roles/PermisosRol.js') }}"></script>
@endpush
@section('title')
    Agregar rol
@endsection
@section('content')

<style type="text/css">
  .oldcheck{
    text-align: right;
  }

  .sombra_card{
    -webkit-box-shadow: 0px 10px 5px -8px rgba(114,171,23,1);
    -moz-box-shadow: 0px 10px 5px -8px rgba(114,171,23,1);
    box-shadow: 0px 10px 5px -8px rgba(114,171,23,1);
  }

  .sombra_card_catalogo{
    -webkit-box-shadow: 0px 10px 5px -9px rgba(204,12,115,1);
    -moz-box-shadow: 0px 10px 5px -9px rgba(204,12,115,1);
    box-shadow: 0px 10px 5px -9px rgba(204,12,115,1);
  }
</style>


    <!--begin::Card-->
    <div class="row">
        <div class="col-lg-12">
            <!--begin::Card-->
            <div class="card card-custom gutter-b">
                <div class="card-header">
                    <h3 class="card-title">Agregar rol</h3>
                </div>
                <!--begin::Form-->
                <form class="form" action="{{ route('rol.guardarrol') }}" method="post" id="frmRol">
                  @csrf
                    <div class="card-body">

                  <div class="row">
                    <div class="col-lg-8 mt-2">
                      <label>Nombre del rol</label>
                      <input type="text" class="form-control" name="name_rol" id="name_rol" required onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                    </div>
                    <div class="col-lg-4 mt-2">
                      <label>Color del menú</label>
                      <input type="color" class="form-control" name="color_menu" id="color_menu" required/>
                    </div>
                  </div>
                      @include('usuarios.agregar-permisos-rol.administracion-sistema')
                      @include('usuarios.agregar-permisos-rol.gerencia-comercial')
                      @include('usuarios.agregar-permisos-rol.gerencia-administracioncontratos')
                      @include('usuarios.agregar-permisos-rol.gerencia-operaciones')
                      @include('usuarios.agregar-permisos-rol.gerencia-finanzas')
                      
                    </div>
                </form>
                <!--end::Form-->

                    <div class="card-footer">
                        <div class="row">
                            <div class="col-lg-6">
                                <button type="button"  id="btnGuardar" class="btn btn-success">
                                    <i class="la la-plus"></i>Guardar
                                </button>
                                <a href="{{ route('rol.catalogoroles') }}"  class="btn btn-secondary">
                                    <i class="la la-arrow-left"></i>Regresar</a>
                            </div>
                        </div>
                    </div>

            </div>
            <!--end::Card-->
        </div>
    </div>
    <!--end::Card-->


@endsection