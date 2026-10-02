@extends('layouts.app')
@section('title')
    Documentos de la solicitud de mantenimiento
@endsection

@push('scripts')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <script src="{{ asset('js/taller/DocumentosSolicitud.js') }}" type="text/javascript"></script>

    <script type="text/javascript">



        $("#add_cotizacion").click(function(){
            $("#div_cotizacion").show();
            $("#add_cotizacion").hide();
        });

        $("#cerrar_cot").click(function(){
            $("#div_cotizacion").hide();
            $("#add_cotizacion").show();
        });
        
        $("#gd_cotizacion").click(function(){
            var file_add = document.getElementById("documento").value;
            var fecha_cotizacion = document.getElementById("fecha_cotizacion").value;
            var folio = document.getElementById("folio").value;
            var importe = document.getElementById("importe").value; 
            var iva = document.getElementById("iva").value; 

            if(file_add == "" || fecha_cotizacion == "" || folio=="" || importe == "" || iva ==""){
                Swal.fire("Para continuar debes agregar los datos solicitados");
            }else{
                Swal.fire({
                    position: "top-center",
                    icon: "success",
                    title: "Espere un momento, la información esta siendo procesada",
                    showConfirmButton: false
                });
                document.getElementById("frmCliente").submit();
            }
        });

    </script>
@endpush

@section('content')

<style type="text/css">
    .oculto
    {
        display: none;
    }
</style>
    <input type="hidden" id="documentosdatatable" value="{{ route('taller.documentosdatatable') }}">
    <input type="hidden" id="datatable_i18n" value="{{ asset('/js/datatables/i18n/es-mx.json') }}">
    <input type="hidden" id="get_archivo" value="{{ route('archivo.documentoSolicitudMantenimiento', ['id' => $solicitud->id]) }}">
    <input type="hidden" id="urlEliminarArchivo" value="{{ route('taller.eliminararchivo') }}">
    <div class="d-flex flex-row">

        <!--begin::List-->
        <div class="flex-row-fluid">
            <div class="d-flex flex-column flex-grow-1">

                <!--begin::Row-->
                <div class="row">
                    <div class="col-xl-12">
                        <div class="container">
                            <!--begin::Profile Personal Information-->
                            <div class="d-flex flex-row">
                                <!--begin::Content-->
                                <div class="flex-row-fluid">
                                    <!--begin::Card-->
                                    <div class="card card-custom card-stretch">
                                        <!--begin::Header-->
                                        <div class="card-header py-3">
                                            <div class="card-title align-items-start flex-column">
                                                <h3 class="card-title">Documentos de la solicitud de mantenimiento</h3>
                                            </div>
                                            <div class="card-toolbar">
                                                <span class="badge badge-primary badge-pill"
                                                    style="padding: 10px 30px;">Solicitud ID: {{ $solicitud->id }}</span>
                                            </div>
                                        </div>
                                        <!--end::Header-->

                                        <!--begin::Datatable-->
                                        <div class="card-body">
                                            
                                            @include('taller.componentes.informacion-solicitud')
                                            
                                            <div class="row mt-4">
                                                <div class="col-md-12">
                                                    @include('taller.componentes.informacion-unidad')
                                                </div>
                                            </div>
                                            <div class="row mt-4">
                                                <div class="col-md-12">


                                                    <div class="card card-custom">
                                                        <div class="card-header">
                                                            <div class="card-title">
                                                                <h3 class="card-label">
                                                                    Cotización
                                                                </h3>
                                                            </div>

                                                            <div class="card-toolbar">
                                                                <button  class="btn btn-sm btn-success font-weight-bold" id="add_cotizacion">
                                                                    <i class="flaticon2-cube"></i> Agregar cotización
                                                                </button>
                                                            </div>

                                                        </div>
                                                        <div class="card-body">
                                                            <form class="form" action="{{ route('taller.guardarCotizacion') }}" method="post" id="frmCliente" enctype="multipart/form-data">
                                                            @csrf   

                                                            <input type="hidden" name="taller_solicitud_id" id="taller_solicitud_id"
                                                            value="{{ $solicitud->id }}">

                                                            <div class="card card-custom oculto" id="div_cotizacion">
                                                                <div class="card-header">
                                                                    <div class="card-title">
                                                                        <span class="card-icon">
                                                                            <i class="flaticon2-chat-1 text-primary"></i>
                                                                        </span>
                                                                        <h3 class="card-label">
                                                                            <small>Agregar cotización</small>
                                                                        </h3>
                                                                    </div>

                                                                    <div class="card-toolbar">
                                                                        <button  class="btn btn-sm btn-danger font-weight-bold" id="cerrar_cot">
                                                                             Cerrar cotización
                                                                        </button>
                                                                    </div>

                                                                </div>
                                                                <div class="card-body">
                                                                    <div class="row">
                                                                        <div class="col-lg-6 form-group">
                                                                            <label>Documento</label>
                                                                            <div class='custom-file'>
                                                                              <input type='file' class='custom-file-input' id='documento' name='archivo' required />
                                                                              <label class='custom-file-label' for='archivo' >Selecciona un archivo</label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-6 form-group">
                                                                          <label>Fecha de cotización</label>
                                                                          <div class="input-group">
                                                                            <input type="date" name="fecha_cotizacion" id="fecha_cotizacion"  class="form-control"/>
                                                                          </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="row">
                                                                        <div class="col-lg-4 form-group">
                                                                          <label>Folio</label>
                                                                          <div class="input-group">
                                                                            <input type="text" name="folio" id="folio"  class="form-control"/>
                                                                          </div>
                                                                        </div>
                                                                        <div class="col-lg-4 form-group">
                                                                          <label>Importe</label>
                                                                          <div class="input-group">
                                                                            <input type="text" name="importe" id="importe"  class="form-control"/>
                                                                          </div>
                                                                        </div>
                                                                        <div class="col-lg-4 form-group">
                                                                          <label>Iva</label>
                                                                          <div class="input-group">
                                                                            <input type="text" name="iva" id="iva" value="16" class="form-control"/>
                                                                          </div>
                                                                        </div>   
                                                                    </div>
                                                                </form>
                                                                    <div class="row">
                                                                        <div class="col-lg-10"></div>
                                                                        <div class="col-lg-2 text-right">
                                                                            <button  class="btn btn-sm btn-success font-weight-bold" id="gd_cotizacion">
                                                                                 Guardar
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>

                                                            

                                                            <table class="table table-hover table-checkable mt-2" >
                                                                <thead class="text-center">
                                                                <tr>
                                                                    <th>No.</th>
                                                                    <th>Folio</th>
                                                                    <th>Documento</th>
                                                                    <th>Fecha de cotización</th>
                                                                    <th>Subtotal</th>
                                                                    <th>Iva</th>
                                                                    <th>Total</th>
                                                                </tr>
                                                                </thead>
                                
                                                                <tbody style="text-align: center;">
                                                                    @foreach($cotizacion as $k => $row)

                                                                    @php
                                                                        $multiplicacion = $row->subtotal * $row->iva;
                                                                        $porcentaje = $multiplicacion / 100;
                                                                        $suma = $row->subtotal + $porcentaje;
                                                                    @endphp

                                                                      <tr id="trDo">
                                                                          <td>{{ $row->id }}</td>
                                                                          <td>{{ $row->folio }}</td>
                                                                          <td>
                                                                              <a href="{{ route('archivo.cotizavionmantenimiento', ['id'=>$row->id]) }}" class="link-primary" target="_blank"> {{ $row->documento}} </a>
                                                                          </td>
                                                                          <td>   
                                                                              {{ $row->fecha_cotizacion }}                                             
                                                                          </td>
                                                                          <td>   
                                                                              ${{ $row->subtotal }}                                             
                                                                          </td>
                                                                          <td>   
                                                                              {{ $row->iva }}%                                             
                                                                          </td>
                                                                          <td>
                                                                              ${{ round($suma,2)}}
                                                                          </td>
                                                                      </tr>                                              
                                                                  @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>

                                                </div>


                                                <div class="col-md-12 mt-4">
                                                <h4 class=" mb-6">Subir documentación</h4>
                                                <!--bein::Formulario-->
                                                <form method="post"
                                                    action="{{ route('taller.guardardocumento') }}"
                                                    id="form_documentos" enctype="multipart/form-data" class="col-md-12">
                                                    <input type='hidden' id='tipoDocumentos'
                                                        value='{{ $jsonTipoDocumentos }}'>
                                                    <input type="hidden" name="taller_solicitud_id" id="taller_solicitud_id"
                                                        value="{{ $solicitud->id }}">
                                                    @csrf
                                                    <div class="row form-group">
                                                            <table class='table table-bordered table-hover'
                                                                id='tblFormDocumentos'>
                                                                <thead>
                                                                    <tr>
                                                                        <th>Documento</th>
                                                                        <th>Tipo de Documento</th>
                                                                        <th>Opción</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody id='tbodyDocumentos'>
                                                                </tbody>
                                                            </table>
                                                    </div>

                                                    <div class="row form-group">
                                                        <div class="col-lg-12 d-flex"
                                                            style="justify-content: space-between">
                                                            <a href="#"
                                                                class="btn btn-icon btn-outline-success btn-circle btn-sm mr-2 hrefAgregarOtroDocumento"
                                                                data-toggle="tooltip" data-theme="dark"
                                                                title="Agregar archivo">
                                                                <i class="flaticon2-plus"></i>
                                                            </a>

                                                            <button type="button" id="btnGuardarDocumentos"
                                                                class="btn btn-primary" title="Subir documentos">
                                                                Subir Documentos
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <!--end::Formulario -->
                                                </form>
                                                </div>
                                            </div>

                                            <div class="row form-group mt-4">
                                                <div class="col-md-12">
                                                    <h4 class="mb-4 text-center">Documentos</h4>
                                                    <table class="table table-hover table-checkable mt-2" id="tblDocumentos">
                                                        <thead class="text-center">
                                                        <tr>
                                                            <th>ID</th>
                                                            <th>Documento</th>
                                                            <th>Tipo de documento</th>
                                                            <th>Opciones</th>
                                                        </tr>
                                                        </thead>
                        
                                                        <tbody style="text-align: center;">
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            
                                        </div>
                                        {{-- card footer with a "Regresar" button link --}}
                                        <div class="card-footer">
                                        @if (Auth::user()->tipo_usuario_id === 2)
                                            <a href="{{ route('taller.garage.vermantenimientos') }}"
                                                class="btn btn-secondary btn-lg mr-2">
                                                <i class="la la-arrow-left"></i>Regresar
                                            </a>
                                        @else
                                            <a href="{{ route('taller.serviciossolicitados') }}"
                                                class="btn btn-secondary btn-lg mr-2">
                                                <i class="la la-arrow-left"></i>Regresar
                                            </a>
                                        @endif
                                        </div>
                                    </div>
                                    <!--end::Content-->
                                </div>
                                <!--end::Profile Personal Information-->
                            </div>
                        </div>
                    </div>
                    <!--end::Row-->
                </div>
            </div>
            <!--end::List-->
        </div>
    @endsection
