@extends('layouts.app')

@section('title')
    Catálogo de unidades en patio
@endsection

@push('scripts')
    <script src="{{ asset('js/catalogos/CatalogoUbicaciones.js') }}"></script>
@endpush

@section('content')
    <div class="d-flex flex-row">

    <!--begin::List-->
    <div class="flex-row-fluid">
        <div class="d-flex flex-column flex-grow-1">

            <!--begin::Row-->
            <div class="row">
                <div class="col-xl-12">

                <!--begin::Card-->
                    <div class="card card-custom">
                        <div class="card-header">
                            <div class="card-title">
                      <span class="card-icon">
                        <i class="flaticon2-file text-primary"></i>
                      </span>
                                <h3 class="card-label">Inventario de unidades</h3>
                            </div>
                            <div class="card-toolbar">

                                <!--begin::Button-->
                                <a href="{{ route('ubicacion.catalogoubicaciones') }}" class="btn btn-light-primary font-weight-bolder mr-3 ml-3">
                                    <i class="la la-arrow-left"></i>Regresar</a>
                                <!--end::Button-->

                            </div>
                        </div>
                        <div class="card-body">
                            <!--begin: Datatable-->
                            <table class="table table-hover table-checkable" id="kdatatable_ubicaciones_inactivas">
                                <thead>
                                <tr>
                                    <th>Folio</th>
                                    <th>Ubicación</th>
                                    <th>Marca</th>
                                    <th>Modelo</th>
                                    <th>Serie</th>
                                    <th>Placa</th>
                                    <th>Año</th>
                                </tr>
                                </thead>

                                <tbody>
                                  @foreach($ubicacion_data as $unid)
                                    <tr>
                                      <td>{{ $unid->folio }}</td>
                                      <td>{{ $unid->ubicacion }}</td>
                                      <td>{{ $unid->nombre_marca }}</td>
                                      <td>{{ $unid->nombre_modelo }}</td>
                                      <td>{{ $unid->no_serie }}</td>
                                      <td>{{ $unid->placa }}</td>
                                      <td>{{ $unid->unidad_year }}</td>
                                    </tr>
                                  @endforeach
                                </tbody>

                                <tfoot>
                                <tr>
                                    <th>Folio</th>
                                    <th>Ubicación</th>
                                    <th>Marca</th>
                                    <th>Modelo</th>
                                    <th>Serie</th>
                                    <th>Placa</th>
                                    <th>Año</th>
                                </tr>
                                </tfoot>

                            </table>
                            <!--end: Datatable-->

                            <input type="hidden" id="datatable_i18n" value="{{ asset('/js/datatables/i18n/es-mx.json') }}">

                        </div>
                    </div>
                    <!--end::Card-->
                    <!--end::Card-->
                </div>

            </div>
            <!--end::Row-->
        </div>
    </div>
    <!--end::List-->
</div>

<form method="post" id="ubicacion_act_form" action="{{ route('ubicacion.activarubicacion') }}" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="id" id="id_delete" value="">
</form> 

@endsection