@extends('layouts.app')

@section('title')
    Ver siniestro
@endsection
@section('content')
<!--begin::Card-->
<div class="row">
    <div class="col-lg-12">
        <!--begin::Card-->
        <div class="card card-custom gutter-b">
            <div class="card-header">
                <h3 class="card-title">Ver siniestro</h3>
            </div>
            <!--begin::Form-->
                <input type="hidden" name="id_siniestro" id="id_siniestro" value="{{ $id_siniestro }}">
                <div class="card-body">
                    <!--begin::tabs-->
                    <ul class="nav nav-tabs nav-tabs-line">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#kt_tab_pane_1">Información del siniestro</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#kt_tab_pane_2">Archivos</a>
                        </li>
                    </ul>
                    <div class="tab-content mt-5" id="myTabContent">
                        <div class="tab-pane fade show active mt-10" id="kt_tab_pane_1" role="tabpanel" aria-labelledby="kt_tab_pane_2">
                            <div class="form-group row">
                                <div class="col-lg-4">
                                    <label>No. Folio</label>
                                    <div class="input-group">
                                        <p>{{ $siniestro_dina->no_folio }}</p>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <label>No. Siniestro</label>
                                    <div class="input-group">
                                        <p>{{ $siniestro_dina->no_siniestro }}</p>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <label>No. Serie</label>
                                    <div class="input-group">
                                        <p>{{ $siniestro_dina->serie }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-4">
                                    <label>Contratante</label>
                                    <div class="input-group">
                                        <p>{{ $siniestro_dina->contratante }}</p>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <label>Proyecto poliza</label>
                                    <div class="input-group">
                                        <p>{{ $siniestro_dina->proyecto_poliza }}</p>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <label>Nombre proyecto</label>
                                    <div class="input-group">
                                        <p>{{ $siniestro_dina->nombre_proyecto }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-4">
                                    <label>Inicio</label>
                                    <div class="input-group">
                                        <p>{{ $siniestro_dina->inicio }}</p>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <label>Fin</label>
                                    <div class="input-group">
                                        <p>{{ $siniestro_dina->fin }}</p>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <label>Moneda</label>
                                    <div class="input-group">
                                        <p>{{ $siniestro_dina->moneda }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-lg-4">
                                    <label>Poliza</label>
                                    <div class="input-group">
                                        <p>{{ $siniestro_dina->poliza }}</p>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <label>Fecha ocurrencia</label>
                                    <div class="input-group">
                                        <p>{{ $siniestro_dina->fecha_ocurrencia }}</p>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <label>Tipo de siniestro inicial</label>
                                    <div class="input-group">
                                        <p>{{ $siniestro_dina->tipo_siniestro_inicial }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-lg-4">
                                    <label>Deducibles</label>
                                    <div class="input-group">
                                        <p>${{ $siniestro_dina->deducible }}</p>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <label>Recuperacion aplicada</label>
                                    <div class="input-group">
                                        <p>{{ $siniestro_dina->recuperacion_aplizada }}</p>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <label>Nombre agente</label>
                                    <div class="input-group">
                                        <p>{{ $siniestro_dina->nombre_agente }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-lg-4">
                                    <label>Modelo</label>
                                    <div class="input-group">
                                        <p>{{ $siniestro_dina->modelo }}</p>
                                    </div>
                                </div>

                            </div>

                        </div>
                        <div class="tab-pane fade mt-10" id="kt_tab_pane_2" role="tabpanel" aria-labelledby="kt_tab_pane_2">
                            <table class="table table-hover mb-6 table-responsive-sm" id="tblDocumentos">
                                <thead>
                                <tr>
                                    <th scope="col">Documento</th>
                                    <th scope="col">Tipo de Documento</th>
                                </tr>
                                </thead>
                                <tbody id='tbodyDocumentos'>
{{--                                     @foreach($documentos as $documento)
                                        <tr id="trDocumento{{ $documento->id }}">
                                            <td><a href="{{ route('archivo.documentoCliente', ['id'=>$documento->id]) }}" class="link-primary" target="_blank"> {{ $documento->clienteTipoDocumento->tipo }} </a></td>
                                            <td>{{ $documento->clienteTipoDocumento->tipo }}</td>
                                        </tr>
                                    @endforeach --}}
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!--end::tabs-->

                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-lg-6">
                            <a href="{{ route('siniestro.catalogodina') }}"  class="btn btn-secondary"><i class="la la-arrow-left"></i>Regresar</a>
                        </div>
                    </div>
                </div>

            <!--end::Form-->
        </div>
        <!--end::Card-->
    </div>
</div>
<!--end::Card-->


@endsection
