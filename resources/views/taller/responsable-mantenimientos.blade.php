@extends('layouts.app')
@section('title')
    Inventario de mantenimientos
@endsection

@push('scripts')
  <script src="{{ asset('js/taller/VerSolicitud.js') }}"></script> 
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
                                <h3 class="card-label">Inventario de mantenimientos</h3>
                            </div>
                            <div class="card-toolbar">

                                <!--begin::Button-->

                                <!--end::Button-->

                            </div>
                        </div>
                        <div class="card-body">
                            <!--begin: Datatable-->
                            <table class="table table-hover table-checkable" id="kdatatable_mantenimientos">
                                <thead>
                                <tr>
                                  <th>No.</th>
                                  <th>Fecha de solicitud</th>
                                  <th>No. Serie</th>
                                  <th>Tipo</th>
                                  <th>Estatus</th>
                                  <th>Prioridad</th>
                                  <th>Ejecutivo de cuenta</th>
                                  <th>Ejecutivo mantenimiento</th>
                                  <th class="text-center">Opciones</th>
                                </tr>
                                </thead>

                                <tbody>
                                  @foreach($solicitudes as $unid)
                                    <tr>
                                      <td>{{ $unid->id }}</td>
                                      <td>{{ $unid->fecha_solicitud }}</td>
                                      <td>{{ $unid->unidad->no_serie }}</td>
                                      <td>{{ strtoupper($unid->tipo_solicitud) }}</td>
                                      <td>
                                        
                                        @if($unid->taller_solicitud_estado_id == 1)
                                          <span style="color:black; background-color:#caf7c9;width:120px;" class="label label-lg font-weight-bold label-light-success label-inline">{{ $unid->tallerSolicitudEstado->estado }}</span>
                                        @endif

                                        @if($unid->taller_solicitud_estado_id == 2)
                                          <span class="label label-lg font-weight-bold label-light-warning label-inline">{{ $unid->tallerSolicitudEstado->estado }}</span>
                                        @endif

                                        @if($unid->taller_solicitud_estado_id == 3)
                                          <span class="label label-lg font-weight-bold label-light-danger label-inline">{{ $unid->tallerSolicitudEstado->estado }}</span>
                                        @endif

                                        @if($unid->taller_solicitud_estado_id == 4)
                                          <span class="label label-lg font-weight-bold label-light-success label-inline">{{ $unid->tallerSolicitudEstado->estado }}</span>
                                        @endif

                                        @if($unid->taller_solicitud_estado_id == 5)
                                          <span class="label label-lg font-weight-bold label-dark label-inline">{{ $unid->tallerSolicitudEstado->estado }}</span>
                                        @endif

                                        @if($unid->taller_solicitud_estado_id == 6)
                                          <span class="label label-lg font-weight-bold label-light-warning label-inline">{{ $unid->tallerSolicitudEstado->estado }}</span>
                                        @endif

                                      </td>
                                      <td>
                                        @if( $unid->prioridad == 0)
                                          <span class="label label-lg font-weight-bold label-light-danger label-inline">ALTA</span>
                                        
                                        @endif
                                        @if( $unid->prioridad == 1)
                                          <span class="label label-lg font-weight-bold label-light-warning label-inline">MEDIA</span>
                                        @endif
                                        
                                        @if( $unid->prioridad == 2)
                                          <span class="label label-lg font-weight-bold label-light-success label-inline">BAJA</span>
                                        @endif
                                      </td>
                                      <td>{{ $unid->userCreated->name }}</td>
                                      <td>
                                        @if($unid->ejecutivo_mantenimiento != null)
                                          {{ $unid->ejecutivomantenimiento->name }}
                                        @else
                                          No Asignado
                                        @endif
                                      </td>
                                      

                                      <td class="text-center">
                                        <a href="{{ route('taller.versolicitudresponsablemantenimiento',  $unid->id ) }}" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon activar_estado" data-toggle="tooltip" data-theme="dark" title="Ver mantenimiento" ><i class="flaticon-eye"></i></a>
                                      </td>
                                    </tr>
                                  @endforeach
                                </tbody>

                                <tfoot>
                                <tr>
                                  <th>No.</th>
                                  <th>Fecha de solicitud</th>
                                  <th>No. Serie</th>
                                  <th>Tipo</th>
                                  <th>Estatus</th>
                                  <th>Prioridad</th>
                                  <th>Ejecutivo de cuenta</th>
                                  <th>Ejecutivo mantenimiento</th>
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

  <form method="post" id="estado_act_form" action="{{ route('cliente.activarestado') }}" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="id" id="id_act_estado" value="">
  </form>


@endsection