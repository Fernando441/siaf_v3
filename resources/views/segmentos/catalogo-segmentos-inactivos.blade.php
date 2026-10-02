@extends('layouts.app')
@section('title')
  Inventario de segmentos inactivos
@endsection

@push('scripts')
  <script src="{{ asset('js/catalogos/segmentos/Segmentos.js') }}"></script>
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
                                <h3 class="card-label">Inventario de segmentos inactivos</h3>
                            </div>
                            <div class="card-toolbar">

                                <!--begin::Button-->
                                <a href="{{ route('segmento.catalogosegmentos') }}" class="btn btn-light-primary font-weight-bolder mr-3 ml-3">
                                    <i class="la la-arrow-left"></i> Regresar</a>
                                <!--end::Button-->

                            </div>
                        </div>
                        <div class="card-body">
                            <!--begin: Datatable-->
                            <table class="table table-hover table-checkable" id="kdatatable_segmentos_inactivos">
                                <thead>
                                <tr>
                                  <th>No.</th>
                                  <th>Tipo de vehículo</th>
                                  <th>Carrocería</th>
                                  <th>Motor</th>
                                  <th>Transmisión</th>
                                  <th>Puertas</th>
                                  <th>Motivo</th>
                                  <th class="text-center">Opciones</th>
                                </tr>
                                </thead>

                                <tbody>
                                  @foreach($records as $unid)
                                    <tr>
                                      <td>{{ $unid->id }}</td>
                                      <td>{{ $unid->tipo_vehiculo }}</td>
                                      <td>{{ $unid->carroceria }}</td>
                                      <td>{{ $unid->motor }}</td>
                                      <td>{{ $unid->transmision }}</td>
                                      <td>{{ $unid->puertas }}</td>
                                      <td><span style="color: red">{{ $unid->motivo_desactivar }}</span></td>
                                      <td class="text-center">
                                        <button class="btn btn-sm btn-clean btn-hover-icon-success btn-icon activar-segmentos" data-id="{{ $unid->id }}" data-nombre="{{ $unid->tipo_vehiculo }}" data-toggle="tooltip" data-theme="dark" title="Activar Segmento"><i class="flaticon2-reply "></i></button>
                                      </td>
                                    </tr>
                                  @endforeach
                                </tbody>

                                <tfoot>
                                <tr>
                                  <th>No.</th>
                                  <th>Tipo de vehículo</th>
                                  <th>Carrocería</th>
                                  <th>Motor</th>
                                  <th>Transmisión</th>
                                  <th>Puertas</th>
                                  <th>Motivo</th>
                                  <th class="text-center">Opciones</th>
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

<input type="hidden" id="datatable_i18n" value="{{ asset('/js/datatables/i18n/es-mx.json') }}">
<form method="post" id="segmento_activar_form" action="{{ route('segmento.activarsegmento') }}" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="id" id="id_delete" value="">
</form>

@endsection