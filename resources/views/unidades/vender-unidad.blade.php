@extends('layouts.app')
@section('title')
    Vender Unidad
@endsection
@push('scripts')
    <script src="{{ asset('js/unidades/VenderUnidad.js') }}"></script>
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
                    <h3 class="card-title">Vender Unidad</h3>
                </div>

                <form class="form" action="{{ route('unidad.ventaGuardar') }}" method="post" id="vender_unidad">
                    @csrf
                    <input type="hidden" name="unidad_id" value="{{ $unidad->id }}">
                    <div class="card-body">
                        @include('unidades.vender-informacion-basica')
                        <div class="alert alert-light" role="alert">
                            Al guardar, la unidad será enviada al catálogo de unidades disponibles para venta.
                        </div>
                        <div class="card-footer px-0" style="padding-bottom: 0px;">
                            <div class="row">
                                <div class="col-lg-6">
                                    <button type="button"  id="btnGuardar" class="btn btn-success"><i class="la la-plus"></i>Guardar</button>
                                    <a href="{{ route('unidad.catalogounidad') }}"  class="btn btn-secondary"><i class="la la-arrow-left"></i>Regresar</a>
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
