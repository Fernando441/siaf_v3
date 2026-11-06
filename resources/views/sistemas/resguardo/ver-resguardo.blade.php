@extends('layouts.app')
@push('scripts')
    <script src="{{ asset('js/sistemas/EditResguardo.js') }}"></script>
@endpush
@section('title')
    Ver resguardo
@endsection
@section('content')
    <style>
        .bold_equipo{
            font-weight: 500;  
        }
    </style>
    <!--begin::Card-->
    <div class="row">
        <div class="col-lg-12">
            <!--begin::Card-->
            <div class="card card-custom gutter-b">
                <div class="card-header">
                    <h3 class="card-title">Ver resguardo</h3>
                </div>
                
                    <div class="card-body">
                        <!--begin::tabs-->
                        <ul class="nav nav-tabs nav-tabs-line">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#kt_tab_pane_1">Información del Cliente</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#kt_tab_pane_2">Archivos</a>
                            </li>
                        </ul>
                        <div class="tab-content mt-5" id="myTabContent">
                            <div class="tab-pane fade show active mt-10" id="kt_tab_pane_1" role="tabpanel" aria-labelledby="kt_tab_pane_1">
                                <div class="form-group row">
                                    <div class="col-lg-6">
                                        <label>Usuario</label>
                                        @foreach($usuarios as $estado)
                                            @if($resguardo->user_resguardo == $estado->id)
                                                <p>{{ $estado->name }}</p>
                                            @endif
                                        @endforeach

                                    </div>
                                    <div class="col-lg-6">
                                        <label>Fecha asignacion</label>
                                        <div class="input-group">
                                           <p>{{ $resguardo->fecha_asignacion }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row form-group" >
                                    <div class="col-lg-12" id="tblEquipos">
                                        <table class='table table-bordered table-hover' id='tblDocEquipos'>
                                            <thead>
                                            <tr>
                                                <th>Equipo</th>
                                            </tr>
                                            </thead>
                                            <tbody id='tbodyDocEquipos'>
                                                @foreach($equipos_asignados as $documento)
                                                    <tr id="trDocumento{{ $documento->id }}">
                                                        <td><span class="bold_equipo"> No. folio: </span>{{ $documento->inventarioEquipoComputo->no_folio }} <span class="bold_equipo">No. serie:</span> {{ $documento->inventarioEquipoComputo->no_serie }} <span class="bold_equipo">Marca:</span> {{ $documento->inventarioEquipoComputo->marca }}</td>

                                                    </tr>
                                                @endforeach   
                                            </tbody>
                                        </table>
                                    </div>
                                </div>


                                <div class="row form-group">
                                    <div class="col-lg-12">
                                        <label>Descripcion</label>
                                        <p>{{ $resguardo->descripcion }}</p>
                                    </div>
                                </div>


                            </div>
                            <div class="tab-pane fade mt-10" id="kt_tab_pane_2" role="tabpanel" aria-labelledby="kt_tab_pane_2">

                                <div class="row form-group" >
                                    <div class="col-lg-12" id="tblArchivos">
                                        <table class='table table-bordered table-hover' id='tblDocumentos'>
                                            <thead>
                                            <tr>
                                                <th>Adjuntar Documento</th>
                                                <th>Tipo de Documento</th>
                                            </tr>
                                            </thead>
                                            <tbody id='tbodyDocumentos'>
                                                @foreach($documentos_asignados as $documento)
                                                    <tr id="trDocumento{{ $documento->id }}">
                                                        <td><a href="{{ route('archivo.documentoRes', ['id'=>$documento->id]) }}" class="link-primary" target="_blank"> {{ $documento->ResguardoTipoEvidencia->tipo_evidencia }} </a></td>
                                                        <td>{{ $documento->ResguardoTipoEvidencia->tipo_evidencia }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>

                        </div>
                        <!--end::tabs-->

                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-lg-6">
                                <a href="{{ route('resguardo.catalogoresguardo') }}"  class="btn btn-secondary"><i class="la la-arrow-left"></i>Regresar</a>
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
