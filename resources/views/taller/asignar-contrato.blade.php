@extends('layouts.app')
@section('title')
    Asignar contrato a ejecutivo
@endsection

@push('scripts')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <script src="{{ asset('js/taller/BuscarUnidad.js') }}" type="text/javascript"></script>
@endpush

@section('content')

    <div class="d-flex flex-row">

    <!--begin::List-->
    <div class="flex-row-fluid">
        <div class="d-flex flex-column flex-grow-1">

            <!--begin::Row-->
            <div class="row">
                <div class="col-xl-12">
                    <div class="container">
                        <!--begin::Profile Personal Information-->
                        <div class="d-flex flex-row">
                            <!--begin::Content-->
                            <div class="flex-row-fluid">
                                <!--begin::Card-->
                                <div class="card card-custom card-stretch">
                                    <!--begin::Header-->
                                    <div class="card-header py-3">
                                        <div class="card-title align-items-start flex-column">
                                            <h3 class="pt-2"><i class="flaticon-search text-dark pr-3"></i> Asignar contrato a ejecutivo</h3>
                                        </div>
                                    </div>
                                    <!--end::Header-->

                                    <!--begin::Form-->
                                    <form class="form" id="buscarunidad" method="POST" enctype="multipart/form-data" action="{{ route('taller.buscarunidad') }}">
                                        @csrf
                                        <div class="card-body pb-1">
                                            <div class="form-group row">
                                                {{-- Listado de usuarios --}}
                                                <label class="col-form-label col-lg-2 col-sm-12 d-flex" style="align-items: center;">Ejecutivo</label>
                                                <div class="col-lg-10 col-md-10 col-sm-12">
                                                    <select class="form-control" id="id_usuario" name="id_usuario">
                                                        <option value="">Seleccionar ejecutivo</option>
                                                        @foreach($usuarios as $usuario)
                                                            <option value="{{ $usuario->id }}">{{ $usuario->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    <span class="form-text text-muted">Selecciona el ejecutivo al que se le asignará el contrato.</span>
                                                </div>
                                            </div>
                                            {{-- Listado de proyectos --}}
                                            <div class="form-group row">
                                                <label class="col-form-label col-lg-2 col-sm-12 d-flex" style="align-items: center;">Proyecto</label>
                                                <div class="col-lg-10 col-md-10 col-sm-12">
                                                    <select class="form-control" id="id_proyecto" name="id_proyecto">
                                                        <option value="">Seleccionar contrato</option>
                                                        @foreach($proyectos as $proyecto)
                                                            <option value="{{ $proyecto->id }}">No. Folio: {{ $proyecto->no_folio }} No. Contrato: {{ $proyecto->no_contrato }} Cliente: {{ $proyecto->client->razon_social }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <div class="row">
                                                <div class="col-lg-12 d-flex" style="justify-content: space-between;">
                                                    <button type="button" id="buttonBuscarUnidad" class="btn btn-success mr-2 px-10 btn-lg"><i class="la la-plus"></i>Asignar contrato</button>
                                                    <a href="{{ route('tablero.show') }}" class="btn btn-secondary btn-lg"><i class="la la-arrow-left"></i>Regresar</a>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div> 
                            <!--end::Content-->
                        </div>
                        <!--end::Profile Personal Information-->
                    </div>
                </div>
            </div>
            <!--end::Row-->
        </div>
    </div>
    <!--end::List-->
</div>
	
@endsection