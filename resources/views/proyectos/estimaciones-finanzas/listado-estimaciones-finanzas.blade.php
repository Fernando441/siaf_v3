@extends('layouts.app')
@section('title')
    Estimaciones
@endsection
@push('scripts')
	<script src="{{ asset('js/contratos/Estimaciones.js') }}"></script>
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

                <!--begin::Card-->
                    <div class="card card-custom">
                        <div class="card-header">
                            <div class="card-title">
                      <span class="card-icon">
                        <i class="flaticon2-file text-primary"></i>
                      </span>
                                <h3 class="card-label">Inventario de estimaciones</h3>
                            </div>
                            <div class="card-toolbar">


                                <!--begin::Button-->
                                <!--end::Button-->

                            </div>
                        </div>
                        <div class="card-body">
                            <!--begin: Datatable-->
                            <table class="table table-hover table-checkable" id="kdatatable_estimaciones">
                                <thead>
                                <tr>
                                  <th>Folio estimación</th>
                                  <th>No. Contrato</th>
                                  <th>Cliente</th>
                                  <th>Periodo inicial</th>
                                  <th>Periodo final</th>
                                  <th>Importe</th>
                                  <th>Estatus</th>
                                  <th class="text-center">Opciones</th>
                                </tr>
                                </thead>

                                <tbody>
                                  @foreach($estimaciones as $unid)
                                    <tr>
                                      <td>{{ $unid->no_folio }}</td>
                                      <td>{{ $unid->no_contrato }}</td>
                                      <td>{{ $unid->cliente->razon_social }}</td>
                                      <td>{{ date('d/m/Y ' , strtotime( $unid->periodo_inicial)) }}</td>
                                      <td>{{ date('d/m/Y ' , strtotime( $unid->periodo_final)) }}</td>
                                      <td>
                                          @if($unid->seguimiento_estimaciones == 0)
                                            <span class="font-weight-bold">*El importe sera visible al enviar a finanzas</span>
                                          @else
                                            <span class="label font-weight-bold label-outline-success label-outline label-inline">${{ number_format($unid->importe_estimacion,2,'.',',') }}</span>
                                          @endif
                                      </td>
                                      <td>
                                          @if($unid->seguimiento_estimaciones == 0)
                                            En proceso
                                          @endif
                                          @if($unid->seguimiento_estimaciones == 1)
                                            Enviada a finanzas
                                          @endif
                                          @if($unid->seguimiento_estimaciones == 2)
                                            Finalizada
                                          @endif
                                      </td>
                                      <td class="text-center">
                                        <button rel-path="/finanzas/ver-estimacion-pdf/{{$unid->id}}"  class="btn btn-sm btn-clean btn-hover-icon-success btn-icon modal-pdf" title="Ver PDF" data-theme="dark"  data-toggle="tooltip" data-placement="top">
                                                <i class="far fa-file-pdf"></i>
                                        </button>

                                        <a href="{{ route('estimacionesfin.verestimacionfin', [$unid->licitaciones_id, $unid->id ]) }}"  class="btn btn-sm btn-clean btn-hover-icon-success btn-icon " data-toggle="tooltip" data-theme="dark" title="Ver estimación" ><i class="flaticon-eye"></i></a>

                                        <a href="{{ route('estimacionesfin.evidenciapagoest', [$unid->licitaciones_id, $unid->id ]) }}"  class="btn btn-sm btn-clean btn-hover-icon-success btn-icon " data-toggle="tooltip" data-theme="dark" title="Evidencia de pago" ><i class="flaticon-file-1"></i></a>
                                      </td>
                                    </tr>
                                  @endforeach
                                </tbody>

                                <tfoot>
                                <tr>
                                  <th>Folio estimación</th>
                                  <th>No. Contrato</th>
                                  <th>Cliente</th>
                                  <th>Periodo inicial</th>
                                  <th>Periodo final</th>
                                  <th>Importe</th>
                                  <th>Estatus</th>
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


    <form method="post" id="send_finanzas_form" action="{{ route('estimaciones.estimacionafinanzas') }}"
        enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="id" id="id_estimacion" value="">
        {{-- <input type="hidden" name="licitacion" value="{{ $licitacion }}"> --}}
    </form>



    <div class="modal fade" id="exampleModalSizeSm" tabindex="-1" role="dialog" aria-labelledby="exampleModalSizeSm"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Estimación</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <div id="modal-body" class="modal-body">
                    
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn btn-secondary font-weight-bold" data-dismiss="modal"><i
                            class="la la-times"></i>Cerrar</button>
                     
                </div>
            </div>
        </div>
    </div>

@endsection