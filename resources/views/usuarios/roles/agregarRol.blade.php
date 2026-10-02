@extends('layouts.app')
@push('scripts')
    <script src="{{ asset('js/roles/AgregarRol.js') }}"></script>
@endpush
@section('title')
    Agregar Nuevo Rol
@endsection
@section('content')

<!--begin::Card-->
    <div class="row">
        <div class="col-lg-12">
            <!--begin::Card-->
            <div class="card card-custom gutter-b">
                <div class="card-header">
                    <h3 class="card-title">Agregar Nuevo Rol</h3>
                </div>
                
                <!--begin::Form-->
                <form class="form" action="{{ route('rol.agregarrol2') }}" method="post" id="frmRol" >
                    @csrf   
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-lg-6">
                                <label>Nombre del Rol</label>
                                <div class="input-group">
                                    <input type="text" name="name_rol" id="name_rol"  class="form-control specialCharts" required onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label>Color del Menú</label>
                                <div class="input-group">
                                    <input type="color" class="form-control" name="color_menu" id="color_menu"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-lg-6">
                                <button type="button"  id="btnGuardar" class="btn btn-success"><i class="la la-plus"></i>Guardar</button>
                                <a href="{{ route('rol.catalogoroles') }}"  class="btn btn-secondary"><i class="la la-arrow-left"></i>Regresar</a>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
            <!--end::Card-->
        </div>
    </div>
    <!--end::Card-->


@endsection
