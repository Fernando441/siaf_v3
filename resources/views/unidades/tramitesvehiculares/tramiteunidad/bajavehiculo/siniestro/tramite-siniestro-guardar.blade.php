@extends('layouts.app')
@push('scripts')
	{{-- <script src="{{ asset('js/cliente/AgregarCliente.js') }}"></script> --}}
    <script src="{{ asset('js/unidades/tramitesvehiculares/AgregarBajaVehicularsiniestro.js') }}"></script>
@endpush
@section('title')
    Agregar información del siniestro
@endsection
@section('content')

    <!--begin::Card-->
    <div class="row">
        <div class="col-lg-12">
            <!--begin::Card-->
            <div class="card card-custom gutter-b">
                <div class="card-header">
                    <h3 class="card-title">Agregar información del siniestro</h3>
                </div>
                <input type='hidden' id='url_municipios' value='{{ route('cliente.obtenermunicipios') }}'>
                <!--begin::Form-->
                <form class="form" action="{{ route('traveh.addinfoevbvsiniestro') }}" method="post" id="frmCliente" enctype="multipart/form-data">
                    @csrf   
                    <input type="hidden" name="id_unidad" value="{{ $id_unidad }}">
                    <input type='hidden' id='tipoArchivo' value='{{ $cadenaTipoDocumento }}'>
                    <div class="card-body">
                        <!--begin::tabs-->
                        <ul class="nav nav-tabs nav-tabs-line">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#kt_tab_pane_1">Información del siniestro</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#kt_tab_pane_2">Evidencias</a>
                            </li>
                        </ul>
                        <div class="tab-content mt-5" id="myTabContent">
                            <div class="tab-pane fade show active mt-10" id="kt_tab_pane_1" role="tabpanel" aria-labelledby="kt_tab_pane_1">

                                <div class="row form-group">
                                    <div class="col-lg-6">
                                        <label>Tipo de siniestro</label>
                                        <select class="form-control" id="unidad_tramite_bajavehiculo_siniestro_tipo_id" name="unidad_tramite_bajavehiculo_siniestro_tipo_id"  required >
                                            <option value="">Selecciona una opción</option>
                                            @foreach($tipo_siniestro as $pro)
                                                <option value="{{ $pro->id }}" >{{ $pro->tipo_siniestro }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-lg-6">
                                        <label>Propietario</label>
                                        <select class="form-control" id="id_propietario" name="id_propietario"  required >
                                            <option value="">Selecciona una opción</option>
                                            @foreach($info_propietario as $pro)
                                                <option value="{{ $pro->id }}" >{{ $pro->nombre_propietario }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-lg-6">
                                        <label>Gestor</label>
                                        <select class="form-control" id="gestor" name="gestor"  required >
                                            <option value="">Selecciona una opción</option>
                                            @foreach($gestor as $pro)
                                                <option value="{{ $pro->id }}" >{{ $pro->nombre }} - Telefono: {{ $pro->telefono }} - correo: {{ $pro->correo }} </option>
                                            @endforeach
                                        </select>
                                    </div>

                                </div>

                                <div class="row form-group">
                                    <div class="col-lg-4">
                                        <label>Fecha de tramite</label>
                                        <div class="input-group">
                                            <input type="text" name="fecha_tramite" id="fecha_pago"  class="form-control" required readonly />
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <label>Fecha de ocurrencia</label>
                                        <div class="input-group">
                                            <input type="text" name="fecha_ocurrencia" id="fecha_ocurrencia"  class="form-control" required readonly />
                                        </div>
                                    </div> 
                                    <div class="col-lg-4">
                                        <label>Fecha de conclusion</label>
                                        <div class="input-group">
                                            <input type="text" name="fecha_conclusion" id="fecha_conclusion"  class="form-control" required readonly />
                                        </div>
                                    </div> 
                                </div>

                                <div class="row form-group">
                                    <div class="col-lg-6">
                                        <label>Cía de seguros</label>
                                        <input type="text" class="form-control" name="cia_seguros" id="cia_seguros" required />
                                    </div> 
                                    <div class="col-lg-6">
                                        <label>No. siniestro</label>
                                        <input type="text" class="form-control" name="no_siniestro" id="no_siniestro" required />
                                    </div>                                     
                                </div>

                                <div class="row form-group">
                                    <div class="col-lg-6">
                                        <label>No. Reporte</label>
                                        <input type="text" class="form-control" name="no_reporte" id="no_reporte"  />
                                    </div> 
                                    <div class="col-lg-6">
                                        <label>Conductor</label>
                                        <input type="text" class="form-control" name="conductor" id="conductor"  />
                                    </div>                                     
                                </div>

                                <div class="row form-group">
                                    <div class="col-lg-6">
                                        <label>Autoridad participante</label>
                                        <input type="text" class="form-control" name="autoridad_participante" id="autoridad_participante"  />
                                    </div> 
                                    <div class="col-lg-6">
                                        <label>No. Carpeta (Denuncia)</label>
                                        <input type="text" class="form-control" name="no_carpeta" id="no_carpeta"  />
                                    </div>                                     
                                </div>


                                <div class="form-group row">
                                    <div class="col-lg-6">
                                        <label>Estatus del siniestro</label>
                                        <select class="form-control" id="estatus_id" name="estatus_id"  required >
                                            <option value="">Selecciona una opción</option>
                                            @foreach($estatus as $pro)
                                                <option value="{{ $pro->id }}" >{{ $pro->nombre_estatus }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-6">
                                        <label>Importe</label>
                                        <input type="text" class="form-control" name="importe" id="importe" required />
                                    </div> 
                                </div>

                                <div class="form-group row">
                                    <div class="col-lg-6">
                                        <label>Estado</label>
                                        <select class="form-control" id="id_estado" name="id_estado"  required >
                                            <option value="">Selecciona una opción</option>
                                            @foreach($estados as $estado)
                                                <option value="{{ $estado->id_estado }}" >{{ $estado->estado_nombre }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-6">
                                        <label>Municipio y/o Alcaldía.</label>
                                        <select class="form-control" id="id_municipio" name="id_municipio"  required>
                                            <option></option>
{{--                                             <option value="">Selecciona una opción</option>
                                            @foreach($municipios as $municipio)
                                                <option value="{{ $municipio->id_municipio }}" >{{ $municipio->municipio_nombre }}</option>
                                            @endforeach --}}
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-lg-12">
                                        <label for="observaciones">Observaciones</label>
                                        <textarea class="form-control" name="observaciones" id="observaciones" rows="3" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"></textarea>
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
                                </div>
                            </div>

                        </div>
                        <!--end::tabs-->

                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-lg-6">
                                <button type="button"  id="btnGuardar" class="btn btn-success"><i class="la la-plus"></i>Guardar</button>
                                <a href="{{ route('traveh.tvbjsiniestro', $id_unidad) }}"  class="btn btn-secondary"><i class="la la-arrow-left"></i>Regresar</a>
                            </div>
                        </div>
                    </div>
                </form>
                <!--end::Form-->
            </div>
            <!--end::Card-->
        </div>
    </div>
    <!--end::Card-->

@endsection
