@extends('layouts.app')
@section('title')
    Vender Unidad
@endsection
@push('scripts')
    <script src="{{ asset('js/unidades/seminuevos/CatalogoUnidadesApartadosEditar.js') }}"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
@endpush

@section('content')
<style type="text/css">
    .oculto{
        display: none;
    }
</style>
 {{-- V E N T A    U N I D A D --}}
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-custom gutter-b">
                <div class="card-header">
                    <h3 class="card-title">Unidad Apartados Editar</h3>
                </div>

                <form class="form" action="{{ route('seminuevos.catalogoApartadoGuardar') }}" method="post" id="frmApartadosEditar">
                    @csrf
                    <input type="hidden" name="id_seminuevos_apartado" value="{{ $apartados->id }}">
                    <div class="card-body">
                        <div class="form-group row pb-10">
                            <div class="col-lg-6">
                                <label>Nombre del vendedor</label>
                                <p>{{ $apartados->vendedor_nombre }}</p>
                            </div>
                            <div class="col-lg-6">
                                <label>Número de días apartado</label>
                               <input type="number" class="form-control" name="dias_apartado" id="dias_apartado" max="365" min="0" value="{{ $apartados->dias_apartado }}">
                            </div>
                        </div>
                        
                        <div class="card-footer px-0 " style="padding-bottom: 0px;">
                            <div class="row">
                                <div class="col-lg-6">
                                    <button type="button"  id="btnGuardar" class="btn btn-primary"><i class="la la-plus"></i>Guardar</button>
                                    <a href="{{ route('seminuevos.catalogoUnidadVentaApartado') }}"  class="btn btn-secondary"><i class="la la-arrow-left"></i>Regresar</a>
                                </div>

                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>


 {{-- V E N D E R    U N I D A D --}}



@endsection
