@extends('layouts.app')

@section('title')
    Asignar taller a la solicitud
@endsection
@push('scripts')
    <script src="{{ asset('js/taller/CatalogoTaller.js') }}"></script>
    <script src="{{ asset('js/taller/EvidenciasSolicitudTaller.js') }}"></script>
@endpush


@section('content')

    <!--begin::Card-->
    <div class="row">
        <div class="col-lg-12">


            @if( $solicitudes->taller_solicitud_estado_id == 4)
            {{-- evidencias --}}
            <input type="hidden" id="documentoEliminarPath" value="{{ route('taller.eliminarevidenciataller') }}">
            
              <form class="form" action="{{ route('taller.evidenciassolicitudtaller') }}" method="post" id="frmCliente" enctype="multipart/form-data">
                  @csrf 
                <input type="hidden" name="id_solicitud" value="{{ $solicitudes->id }}">
                <div class="card card-custom">
                  <div class="card-header">
                    <div class="card-title">
                            <span class="card-icon">
                                {{-- <i class="flaticon2-chat-1 text-primary"></i> --}}
                            </span>
                      <h3 class="card-label">
                        Evidencias del taller

                      </h3>
                    </div>

                  </div>
                  <div class="card-body">

{{--                                   <div class="row form-group" >
                                      <div class="col-lg-12" id="tblArchivos">
                                          <table class='table table-bordered table-hover' id='tblDocumentos'>
                                              <thead>
                                              <tr>
                                                  <th>Adjuntar Documento</th>
                                                  <th>Tipo de Evidencia</th>
                                                  <th>Opción</th>
                                              </tr>
                                              </thead>
                                              <tbody id='tbodyDocumentos'>
                                              </tbody>
                                          </table>
                                      </div>
                                  </div>

                                  <div class="row form-group">
                                      <div class="col-lg-12">
                                          <a href="#" class="btn btn-icon btn-outline-success btn-circle btn-sm mr-2 hrefAgregarOtro" data-toggle="tooltip" data-theme="dark" title="Agregar archivo">
                                              <i class="flaticon2-plus"></i>
                                          </a>
                                      </div>
                                  </div> --}}

                            <table class="table table-hover mb-6 table-responsive-sm" id="tblDocumentos">
                                <thead>
                                <tr>
                                    <th scope="col">Documento</th>
                                    <th scope="col">Tipo de Documento</th>
                                    <th scope="col">Opción</th>
                                </tr>
                                </thead>
                                <tbody id='tbodyDocumentos'>
                                    @foreach($documentos as $documento)
                                        <tr id="trDocumento{{ $documento->id }}">
                                            <td><a href="{{ route('archivo.evidenciamantenimiento', ['id'=>$documento->id]) }}" class="link-primary" target="_blank"> {{ $documento->evidencia }} </a></td>
                                            <td>{{ $documento->evidencia }}</td>
                                            <td>
                                                <a href='#' class='btn btn-sm btn-clean btn-hover-icon-success btn-icon hrefEliminarDocumento' data-id='{{ $documento->id }}' data-documento='{{ $documento->documento }}'  data-toggle='tooltip' data-theme='dark' title='Eliminar'>
                                                    <i class='flaticon-delete'></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <div class="row form-group">
                                <div class="col-lg-12">
                                    <a href="#" class="btn btn-icon btn-outline-success btn-circle btn-sm mr-2 hrefAgregarOtro" data-toggle="tooltip" data-theme="dark" title="Agregar archivo">
                                        <i class="flaticon2-plus"></i>
                                    </a>
                                </div>
                            </div>


                        <button type="button"  id="btnGuardar" class="btn btn-success"><i class="la la-plus"></i>Guardar</button>
                        <a href="{{ route('tllmodulo.listadosolmanttl') }}"  class="btn btn-secondary"> <i class="la la-arrow-left"></i>Regresar</a>
             
                  </div>
                </div>
              </form>
            @endif


            <!--end::Card-->
        </div>
    </div>
    <!--end::Card-->


  <form method="post" id="quitar_delete_form" action="{{ route('taller.eliminartallerasignado') }}" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="id_solicitud" id="id_solicitud" value="{{ $id_solicitud }}">
    <input type="hidden" name="taller" value="{{ $id_taller }}">
  </form>


@endsection


