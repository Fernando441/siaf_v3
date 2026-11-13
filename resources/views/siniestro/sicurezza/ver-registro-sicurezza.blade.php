@extends('layouts.app')

@section('title')
    Ver siniestro
@endsection
@section('content')
<style>
    .price-success{
        font-size: 16px;
    }
</style>
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
                            <a class="nav-link active" data-toggle="tab" href="#kt_tab_pane_1">Datos generales</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#kt_tab_pane_2">Archivos</a>
                        </li>
                    </ul>
                    <div class="tab-content mt-5" id="myTabContent">
                        <div class="tab-pane fade show active mt-10" id="kt_tab_pane_1" role="tabpanel" aria-labelledby="kt_tab_pane_2">
                            <div class="form-group row">
                                <div class="col-lg-6">
                                    <div class="card card-custom">
                                        <div class="card-header">
                                            <div class="card-title">
                                                <span class="card-icon">
                                                    <i class="flaticon2-file text-primary"></i>
                                                </span>
                                                <h3 class="card-label">Informacion del siniestro</h3>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <label>No. Folio</label>
                                                    <div class="input-group">
                                                        <p>{{ $siniestro_sicurezza->no_folio }}</p>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <label>Siniestro completo</label>
                                                    <div class="input-group">
                                                        <p>{{ $siniestro_sicurezza->siniestro_completo }}</p>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <label>No. Serie</label>
                                                    <div class="input-group">
                                                        <p>{{ $siniestro_sicurezza->serie }}</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row mt-3">
                                                <div class="col-lg-4">
                                                    <label>Proyecto</label>
                                                    <div class="input-group">
                                                        <p>{{ $siniestro_sicurezza->proyecto }}</p>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <label>Fecha ocurrencia</label>
                                                    <div class="input-group">
                                                        <p>{{ $siniestro_sicurezza->fecha_ocurrencia }}</p>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <label>Causa enfermedad</label>
                                                    <div class="input-group">
                                                        <p>{{ $siniestro_sicurezza->causa_enfermedad }}</p>
                                                    </div>
                                                </div>    
                                            </div>

                                            <div class="row mt-3">
                                                <div class="col-lg-4">
                                                    <label>Recuperacion aplicada</label>
                                                    <div class="input-group">
                                                        @if($siniestro_sicurezza->recuperacion_aplicada == '0.00')
                                                            <p> <span class="label font-weight-bold label-outline-danger label-inline">${{ $siniestro_sicurezza->recuperacion_aplicada }}</span></p>
                                                        @else
                                                            <p> <span class="label font-weight-bold label-outline-success label-inline">${{ $siniestro_sicurezza->recuperacion_aplicada }}</span></p>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <label>Deducibles</label>
                                                    <div class="input-group">
                                                        @if($siniestro_sicurezza->deducibles == '0.00')
                                                            <p> <span class="label font-weight-bold label-outline-danger label-inline">${{ $siniestro_sicurezza->deducibles }}</span></p>
                                                        @else
                                                            <p> <span class="label font-weight-bold label-outline-success label-inline price-success">${{ $siniestro_sicurezza->deducibles }}</span></p>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <label>Nombre agente</label>
                                                    <div class="input-group">
                                                        <p>{{ $siniestro_sicurezza->nombre_agente }}</p>
                                                    </div>
                                                </div>    
                                            </div>


                                            <div class="row mt-3">
                                                <div class="col-lg-4">
                                                    <label>Asegurado</label>
                                                    <div class="input-group">
                                                        <p>{{ $siniestro_sicurezza->asegurado }}</p>
                                                    </div>
                                                </div> 
                                                <div class="col-lg-4">
                                                    <label>Modelo</label>
                                                    <div class="input-group">
                                                        <p>{{ $siniestro_sicurezza->modelo }}</p>
                                                    </div>
                                                </div> 
                                                <div class="col-lg-4">
                                                    <label>Descripcion auto</label>
                                                    <div class="input-group">
                                                        <p>{{ $siniestro_sicurezza->descripcion_auto }}</p>
                                                    </div>
                                                </div>    
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 text-center">

                                </div>
                            </div>

                            @if($unidad != null)
                                <div class="form-group row">
                                    <div class="col-lg-6 text-center">
                                        @if($ver != 0)
                                            <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                                                <div class="carousel-inner">
                                                    @foreach($fotografias as $documento)
                                                        <div class="carousel-item {{($ver == $documento->id) ? 'active' : ''}}">
                                                            <img class="d-block w-100" src="{{ route('archivo.fotografiaUnidad', ['id'=>$documento->id]) }}" alt="Second slide">
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                    <span class="sr-only">Previous</span>
                                                </a>
                                                <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                    <span class="sr-only">Next</span>
                                                </a>
                                            </div>
                                        @else
                                            <img src="/img/no_disponible.png" width="300px">
                                        @endif
                                    </div>


                                    <div class="col-lg-6">
                                        <div class="card card-custom">
                                            <div class="card-header">
                                                <div class="card-title">
                                                    <span class="card-icon">
                                                        <i class="flaticon-truck text-primary"></i>
                                                    </span>
                                                    <h3 class="card-label">Informacion de la unidad</h3>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <label>No. Serie</label>
                                                        <div class="input-group">
                                                            <p>{{ $unidad->no_serie }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <label>Numero economico</label>
                                                        <div class="input-group">
                                                            <p>{{ $unidad->numero_economico }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <label>Placa</label>
                                                        <div class="input-group">
                                                            <p>{{ $unidad->placa }}</p>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            

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
                            <a href="{{ route('siniestro.catalogosicurezza') }}"  class="btn btn-secondary"><i class="la la-arrow-left"></i>Regresar</a>
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
