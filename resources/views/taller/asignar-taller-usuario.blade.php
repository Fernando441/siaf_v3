@extends('layouts.app')
@section('title')
    Asignar taller a usuario
@endsection

@push('scripts')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
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
                                            <h3 class="pt-2"><i class="flaticon-search text-dark pr-3"></i> Asignar taller a usuario</h3>
                                        </div>
                                    </div>
                                    <!--end::Header-->

                                    <!--begin::Form-->
                                    <form class="form" id="asignarTaller" method="POST" enctype="multipart/form-data" action="{{ route('taller.asignartallerusuariopost') }}">
                                        @csrf
                                        <div class="card-body pb-1">
                                            <div class="form-group row">
                                                {{-- Listado de usuarios --}}
                                                <label class="col-form-label col-lg-2 col-sm-12 d-flex" style="align-items: center;">Usuario</label>
                                                <div class="col-lg-10 col-md-10 col-sm-12">
                                                    <select class="form-control" id="id_usuario" name="id_usuario" required>
                                                        <option value="">Seleccionar usuario</option>
                                                        @foreach($usuarios as $usuario)
                                                            <option value="{{ $usuario->id }}">{{ $usuario->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    <span class="form-text text-muted">Selecciona el usuario al que se le asignará el taller.</span>
                                                </div>
                                            </div>
                                            {{-- Listado de talleres --}}
                                            <div class="form-group row">
                                                <label class="col-form-label col-lg-2 col-sm-12 d-flex" style="align-items: center;">Taller</label>
                                                <div class="col-lg-10 col-md-10 col-sm-12">
                                                    <select class="form-control" id="id_taller" name="id_taller" required>
                                                        <option value="">Seleccionar taller</option>
                                                        @foreach($talleres as $taller)
                                                            <option value="{{ $taller->id }}">{{ $taller->nombre }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <div class="row">
                                                <div class="col-lg-12 d-flex" style="justify-content: space-between;">
                                                    <button type="submit" id="buttonBuscarUnidad" class="btn btn-success mr-2 px-10 btn-lg"><i class="la la-plus"></i>Asignar taller</button>
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