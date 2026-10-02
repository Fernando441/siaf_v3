@extends('layouts.app')
@push('scripts')
	{{-- <script src="{{ asset('js/cliente/AgregarCliente.js') }}"></script> --}}
    {{-- <script src="{{ asset('js/licitaciones/requicision_compras/CrearRequisicionCompras.js') }}"></script>  --}}
    <script src="{{ asset('js/licitaciones/requicision_compras/PagoRequisicionCompras.js') }}"></script> 
@endpush
@section('title')
    Ver información de la requisición
@endsection
@section('content')
    <input type="hidden" id="documentoEliminarPath" value="{{ route('finreqcompras.eliminardocumentorequisicion') }}">
    <!--begin::Card-->
    <div class="row">
        <div class="col-lg-12">
            <!--begin::Card-->
            <div class="card card-custom gutter-b">
                <div class="card-header">
                    <div class="card-title">
                        <h3 class="card-label">
                            Información del pago
                        </h3>
                    </div>
                </div>
                <div class="card-body">
                    <div class="card card-custom gutter-b">
                        <div class="card-header">
                            <div class="card-title">
                                <h3 class="card-label">
                                </h3>
                            </div>
                        </div>
                        <div class="card-body">
                                <div class="row form-group">


                                    <div class="col-lg-12">
                                        <table class='table table-bordered table-hover'>
                                            <thead>
                                                <tr>
                                                    <th>Descripción</th>
                                                    <th>Cantidad</th>
                                                    <th>Observaciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                              @foreach($detalle as $unid)
                                                <tr>
                                                  <td>{{ $unid->descripcion }}</td>
                                                  <td>{{ $unid->cantidad }}</td>
                                                  <td>{{ $unid->obervaciones }}</td>

                                                </tr>
                                              @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                        </div>
                    </div>

            <form class="form" action="{{ route('finreqcompras.addpago') }}" method="post" id="frmCliente" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id_requisicion" value="{{ $id_requisicion }}">
                    <div class="card card-custom gutter-b">
                        <div class="card-header">
                            <div class="card-title">
                                <h3 class="card-label">
                                </h3>
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table table-hover mb-6 table-responsive-sm" id="tblDocumentos">
                                <thead>
                                <tr>
                                    <th scope="col">Documento</th>
                                    <th scope="col">Importe</th>
                                    <th scope="col">Opción</th>
                                </tr>
                                </thead>
                                <tbody id='tbodyDocumentos'>
                                    @foreach($pago as $documento)
                                        <tr id="trDocumento{{ $documento->id }}">
                                            <td><a href="{{ route('archivo.requisicioncompras', ['id'=>$documento->id]) }}" class="link-primary" target="_blank"> Pago </a></td>
                                            <td>${{ $documento->importe }}</td>
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
                        </div>
                    </div>
                      <div class="row">
                        <div class="col-lg-6">
                            <button type="button"  id="btnGuardar" class="btn btn-success"><i class="la la-plus"></i>Guardar</button>
                            <a href="{{ route('finreqcompras.finreqcompras') }}"  class="btn btn-secondary"><i class="la la-arrow-left"></i>Regresar</a>
                        </div>
                    </div>                  
 </form>

                </div>
            </div>
        </div>
    </div>
    <!--end::Card-->

@endsection
