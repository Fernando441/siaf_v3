@extends('layouts.app')

@section('title')
    Catálogo de asignaciones
@endsection

@push('scripts')
  <script src="{{ asset('js/catalogos/agencias/CatalogoAgencias.js') }}"></script>
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
                                <h3 class="card-label">Inventario de asignaciones</h3>
                            </div>
                            <div class="card-toolbar">

                                <!--begin::Button-->
                                  <a href="{{ route('asignarunidad.unidsinasignacion') }}" class="btn btn-light-warning font-weight-bolder mr-3 ml-3"><i class="flaticon2-delivery-truck"></i> sin asignar</a>
                                  <a href="{{ route('asignarunidad.unidadesasignadas') }}" class="btn btn-light-primary font-weight-bolder mr-3 ml-3"><i class="flaticon2-delivery-truck"></i> asignadas</a>

                                  <a href="{{ route('asignarunidad.nuevaasignacion') }}" class="btn btn-light-primary font-weight-bolder mr-3 ml-3">
                                  <i class="la la-plus"></i>Nueva asignación</a>
                                <!--end::Button-->

                            </div>
                        </div>
                        <div class="card-body">
                            <!--begin: Datatable-->
                            <table class="table table-hover table-checkable" id="kdatatable_agencias_inactivas">
                                <thead>
                                <tr>
                                  <th>No.</th>
                                  <th>Tipo Asignación</th>
                                  <th>Asignación</th>
                                  <th>Nombre asignación</th>
                                  <th>Contacto</th>
                                  <th>Dirección</th>
                                  <th>Subdirección</th>
                                  <th>Coordinación</th>
                                  <th>Calle</th>
                                  <th>Estado</th>
                                  <th>Municipio</th>
                                  <th class="text-center">Opciones</th>
                                </tr>
                                </thead>

                                <tbody>
                                  @foreach($asignacionLogistica as $unid)
                                    <tr>
                                      <td>{{ $unid->id }}</td>
                                      <td>
                                        @if( $unid->tipo_asignacion == 0)
                                          <span class="label font-weight-bold label-outline-warning label-inline" > Contrato </span>
                                        @else
                                          <span class="label font-weight-bold label-outline-primary label-inline" > Patio </span>
                                        @endif
                                      </td>
                                      <td>
                                        @if( $unid->tipo_asignacion == 0)
                                          {{ $unid->proyecto->no_contrato }}
                                          Titulo servicio: {{ $unid->proyecto->titulo_servicio }} - No. Contrato: {{ $unid->proyecto->no_contrato }} - No. convenio: {{ $unid->proyecto->no_convenio }}
                                        @else
                                          {{ $unid->ubicacionUnidad->ubicacion }} - {{ $unid->ubicacionUnidad->codigo }} 
                                        @endif                                        
                                      </td>

                                      <td>{{ $unid->nombre_asignacion }}</td>
                                      <td>{{ $unid->contacto }}</td>
                                      <td>{{ $unid->direccion }}</td>
                                      <td>{{ $unid->sub_direccion }}</td>
                                      <td>{{ $unid->coordinacion }}</td>
                                      <td>{{ $unid->calle }}</td>
                                      <td>{{ $unid->estado->estado_nombre }}</td>
                                      <td>{{ $unid->municipio->municipio_nombre }}</td>

                                      <td class="text-center">
                                        <a href="{{ route('asignarunidad.verasignacion',$unid->id) }}" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon btn-icon mr-2" title="Ver asignación" data-theme="dark" data-toggle="tooltip" data-placement="top">
                                            <span class="svg-icon svg-icon-md">
                                                <i class="flaticon-eye"></i>
                                            </span>
                                        </a>

                                        <a href="{{ route('asignarunidad.editarasignacion',$unid->id) }}" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon btn-icon mr-2" title="Editar asignación" data-theme="dark" data-toggle="tooltip" data-placement="top">
                                            <span class="svg-icon svg-icon-md">
                                                <i class="flaticon-edit"></i>
                                            </span>
                                        </a>

                                          <a href="{{ route('asignarunidad.patiosasignacion',$unid->id) }}" class="EnviarTransladista btn btn-sm btn-clean btn-hover-icon-success btn-icon"  title="Unidades asignadas" data-theme="dark" data-toggle="tooltip" data-placement="top" data-id="">
                                                  <i class="flaticon2-delivery-truck"></i>
                                          </a>

                                      </td>
                                    </tr>
                                  @endforeach
                                </tbody>

                                <tfoot>
                                <tr>
                                  <th>No.</th>
                                  <th>Tipo Asignación</th>
                                  <th>Asignación</th>
                                  <th>Nombre asignación</th>
                                  <th>Contacto</th>
                                  <th>Dirección</th>
                                  <th>Subdirección</th>
                                  <th>Coordinación</th>
                                  <th>Calle</th>
                                  <th>Estado</th>
                                  <th>Municipio</th>
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

 <form method="post" id="agencia_activar_form" action="{{ route('agencia.activaragencia') }}" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="id" id="id_act_agencia" value="">
  </form> 


@endsection