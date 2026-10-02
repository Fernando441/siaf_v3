@extends('layouts.app')
@push('scripts')
    <script src="{{ asset('js/unidades/Unidadesbase.js') }}"></script> 
@endpush
@section('title')
    Crear solicitud de sustitutos
@endsection
@section('content')


<style type="text/css">
    .oculto{
        display: none;
    }
</style>
    <!--begin::Card-->
    <div class="row">
        <div class="col-lg-12">
            <!--begin::Card-->
            <div class="card card-custom gutter-b">
                <div class="card-header">
                    <h3 class="card-title">Crear solicitud de sustitutos</h3>
                </div>
                <!--begin::Form-->
                <form action="{{ route('unidadessustitutas.busquedaunidadbase') }}" method="post" id="submit_busquedasustitutos">
                    @csrf
                    <div class="card-body">

                        <div class="row">
                            <div class="col-lg-6">
                                <h5>Buscar unidad base</h5>
                            </div>
                        </div>


                        <div class="form-group row mt-2">
                            <div class="col-lg-6">
                                <label>Tipo de busqueda</label>
                                <div class="radio-inline">
                                    <label class="radio">
                                        <input type="radio" onclick="tipobusqueda(this);" checked name="busqueda" value="0" />
                                        <span></span>
                                        No. Económico
                                    </label>
                                    <label class="radio">
                                        <input type="radio" onclick="tipobusqueda(this);" name="busqueda" value="1" />
                                        <span></span>
                                        No. Serie
                                    </label>
                                    <label class="radio">
                                        <input type="radio" onclick="tipobusqueda(this);" name="busqueda" value="2" />
                                        <span></span>
                                        Placa
                                    </label>
                                </div>
                            </div>

                            <div class="col-lg-6" id="op_economico">
                                <label>No. Económico</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="no_economico" id="no_economico"  onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                </div>
                            </div>

                            <div class="col-lg-6 oculto" id="op_serie">
                                <label>No. Serie</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="no_serie" id="no_serie"  onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                </div>
                            </div>

                            <div class="col-lg-6 oculto" id="op_placa">
                                <label>Placa</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="placa" id="placa"  onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                </div>
                            </div>

                        </div>


                        <!--end::tabs-->
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-lg-6">
                                <button type="button"  id="btnGuardar" class="btn btn-success"><i class="la la-plus"></i>Buscar</button>
                                <a href="{{ route('unidadessustitutas.listadounidadessustitutas') }}"  class="btn btn-secondary"><i class="la la-times"></i>Cancelar</a>
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