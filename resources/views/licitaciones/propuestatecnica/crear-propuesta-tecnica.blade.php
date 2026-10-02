@extends('layouts.app')
@push('scripts')
<script src="{{ asset('js/licitaciones/propuestatecnica/crearPropuesta.js') }}"></script>
<meta name="csrf-token" id="csrf-token" content="{{ csrf_token() }}" />
@endpush
@section('title')
Agregar propuesta 
@endsection
@section('content')

<style type="text/css">
    .op_select{
box-shadow: 0px 7px 5px -2px rgba(174,251,117,0.74);
-webkit-box-shadow: 0px 7px 5px -2px rgba(174,251,117,0.74);
-moz-box-shadow: 0px 7px 5px -2px rgba(174,251,117,0.74);  
    }
</style>
<form action="{{ route('propuestatecnica.guardarpropuestatecnica') }}" method="post" class="submit_propuesta" id="submit_propuesta" enctype="multipart/form-data">
    <input type='hidden' id='tipoArchivoLegal' value='{{ $cadenaTipoDocLegal }}'>
    <input type='hidden' id='tipoArchivoAdministrativa' value='{{ $cadenaTipoDocAdministrativa }}'>
    <input type='hidden' id='tipoArchivoFiscal' value='{{ $cadenaTipoDocFiscal }}'>
    <input type='hidden' id='tipoArchivoFinanciera' value='{{ $cadenaTipoDocFinanciera }}'>
    <input type='hidden' id='tipoArchivoGestor' value='{{ $cadenaTipoDocGestor }}'>
    <input type='hidden' id='cadenaSelectSubtext' value='{{ $cadenaSelectSubtext }}'>
    <input type="hidden" id="propuestaTecnicaEliminarPath" value="{{ route('propuestatecnica.eliminarpropuestatecnica') }}">
    <input type="hidden" id="datatable_i18n" value="{{ asset('/js/datatables/i18n/es-mx.json') }}">
    @php $urlGestorDocumentos = url('/'); @endphp
    <input type="hidden" id="urlarchivo" value="{{ $urlGestorDocumentos }}">
    @csrf
    <!--begin::Card-->
@foreach($licitacion as $lic)
    @php
        $licitacion_id_doc = $lic->id;
                $lici_id = $lic->id;
        $tipo_contrato = $lic->tipo_contrato;
        $acto_fallo = $lic->acto_fallo;
    @endphp
@endforeach

    <div class="row">
        <div class="col-lg-12">
            <!--begin::Card-->
            <div class="card card-custom gutter-b">
                <div class="card-header">
                    <h3 class="card-title">Agregar propuesta </h3>

                    <div class="card-toolbar">

                        @if (in_array(114, $permiso_array))
                            <a href="{{ route('licitacion.ver',$lici_id)}}" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon" title="Ver concurso" data-theme="dark" data-toggle="tooltip" data-placement="top">
                                <i class="flaticon-eye"></i>
                            </a>   {{-- VER licitacion --}}
                        @endif

                        @if (in_array(116, $permiso_array))
                            <a href="{{ route('licitacion.editarlicitacion',$lici_id) }}" class="btn btn-sm  btn-hover-icon-success btn-icon" title="Editar concurso" data-theme="dark" data-toggle="tooltip" data-placement="top">
                                <i class="flaticon-edit"></i>
                            </a>   {{-- Editar licitacion --}}
                        @endif

                        @if (in_array(133, $permiso_array))
                            @if($acto_fallo == null || $acto_fallo == "")
                            @else
                                <a href="{{ route('licitacion.agregar',$lici_id) }}" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon" title="Crear contrato" data-theme="dark" data-toggle="tooltip" data-placement="top">
                                    <i class="flaticon-file-1"></i>
                                </a>  {{-- Agregar contrato --}}
                            @endif
                        @endif

                        @if (in_array(134, $permiso_array))
                            <a href="{{ route('proposicioneconomica.crearproposicioneconomica', [$lici_id,1,$tipo_contrato]) }}" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon" title="Crear propuesta económica" data-theme="dark" data-toggle="tooltip" data-placement="top">
                                <i class="flaticon-presentation-1"></i>
                            </a>   {{-- Propuesta economica --}}
                        @endif

                        @if (in_array(135, $permiso_array))
                            <a href="{{ route('propuestatecnica.crearpropuestatecnica',$lici_id) }}" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon op_select" title="Crear propuesta" data-theme="dark" data-toggle="tooltip" data-placement="top">
                                <i class="flaticon2-website"></i>  
                            </a>   {{-- Propuesta Tecnica --}}
                        @endif

                        @if (in_array(143, $permiso_array))
                            <a href="{{ route('licitacion.informacionfinanzas',$lici_id) }}" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon" title="Información de las fianzas y seguros" data-theme="dark" data-toggle="tooltip" data-placement="top">
                                    <i class="flaticon-notepad"></i>
                            </a>   {{-- Finanzas --}}
                        @endif


                        @if (in_array(135, $permiso_array))
                            <a href="{{ route('reqconcurso.listadoreqconsursos',$lici_id) }}" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon" title="Requisiciones" data-theme="dark" data-toggle="tooltip" data-placement="top">
                                    <i class="flaticon2-delivery-truck"></i>
                            </a>
                         @endif

                        

                        <a href="{{ route('licitacion.listadolicitaciones') }}" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon" data-toggle="tooltip" data-theme="dark" title="Salir" ><i class="flaticon2-reply "></i></a>


                        <a class="btn btn-link-primary font-weight-bold mr-2 " 
                            href="{{ route('propuestatecnica.propuestatecnicadoc', $licitacion_id_doc) }}" role="button" >
                            Propuesta Técnica
                        </a>
                    </div>

                </div>

                <!--begin::Form-->
                <div class="card-body">
                    <div class="row">
                        @foreach($licitacion as $lic)
                        @php $licitacion_folio = $lic->folio; @endphp
                        <input type="hidden" name="licitacion_id" value="{{ $lic->id }}">
                        <div class="col-lg-4 col-sm-6 form-group">
                            <label>Folio del concurso</label>
                            <p>
                            <a href="{{ route('licitacion.ver', $lic->id) }}" target="_blank" class="text-primary"
                                data-toggle="tooltip" data-theme="dark" title="Abrir concurso en otra ventana">
                                {{ $lic->folio }} <i class="la la-external-link-alt text-primary"></i>
                            </a>
                            </p>
                        </div>

                        <div class="col-lg-4 col-sm-6 form-group">
                            <label>No. Concurso</label>
                            <p>{{ $lic->no_licitacion }}</p>
                        </div>


                        <div class="col-lg-4 col-sm-6 form-group">
                            <label>Titulo del servicio</label>
                            <p>{{ $lic->titulo_servicio }}</p>
                        </div>

                        <div class="col-lg-4 col-sm-6 form-group">
                            <label>Fecha y firma de formalización del contrato</label>
                            <p>{{ date('d/m/Y', strtotime($lic->firma_entrega))}}</p>
                        </div>

                        <div class="col-lg-4 col-sm-6 form-group">
                            <label>Cliente</label>
                            <p>{{ $lic->razon_social }}</p>
                        </div>
                        <input type="hidden" name="licitacion_id" value="{{ $lic->id }}">
                        @endforeach
                    </div>
                    <div class="row">
                        <ul class="nav nav-tabs nav-tabs-line" style="width: 100%;">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#kt_tab_pane_1">Información Legal</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#kt_tab_pane_2">Información Administrativa</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#kt_tab_pane_3">Información Fiscal</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#kt_tab_pane_4">Información Financiera</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#kt_tab_pane_5">Otros</a>
                            </li>
                        </ul>
                        <div class="tab-content mt-5" id="myTabContent" style="width: 100%;">
                            <!-- tabs content -->
                            <!--Información Legal-->
                            <div class="tab-pane fade show active" id="kt_tab_pane_1" role="tabpanel" aria-labelledby="kt_tab_pane_2">
                                <!--begin::Formulario -->
                                <div class="row form-group">
                                    <div class="col-lg-12" id="tblArchivos">
                                        <table class='table table-bordered table-hover' id='tblDocumentos'>
                                            <thead>
                                                <tr>
                                                    <th>Documento</th>
                                                    <th>Opción</th>
                                                </tr>
                                            </thead>
                                            <tbody id='tbodyDocumentos'>
                                                @foreach($propuesta_tecnica_legal_documentos as $documento_legal)
                                                <tr id="trStorageDocumentolegal{{ $documento_legal->id }}">
                                                    <td>
                                                        <x-documento :documento="$documento_legal->licitacionGestorDocumentos" :urlGestorDocumentos="$urlGestorDocumentos" />
                                                    </td>
                                                    <td>
                                                        {{-- eliminar archivo --}}
                                                        <button type='button' class='btn btn-clean btn-icon btn-outline-success hrefEliminarDocumento' data-tipo='legal' data-id='{{ $documento_legal->id }}' data-folio='{{ $licitacion_folio }}' data-toggle="tooltip" data-theme="dark" title="Eliminar Archivo"><i class=' flaticon-delete'></i></button>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col-lg-12">
                                        <a href="#" class="btn btn-icon btn-outline-success btn-circle btn-sm mr-2 hrefAgregarOtroLegal" data-toggle="tooltip" data-theme="dark" title="Agregar archivo">
                                            <i class="flaticon2-plus"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <!--Información Administrativa-->
                            <div class="tab-pane fade" id="kt_tab_pane_2" role="tabpanel" aria-labelledby="kt_tab_pane_2">
                                <div class="row form-group">
                                    <div class="col-lg-12" id="tblArchivosAdministrativa">
                                        <table class='table table-bordered table-hover' id='tblDocumentosAdministrativa'>
                                            <thead>
                                                <tr>
                                                    <th>Documento</th>
                                                    <th>Opción</th>
                                                </tr>
                                            </thead>
                                            <tbody id='tbodyDocumentosAdministrativa'>
                                                @foreach($propuesta_tecnica_administrativa_documentos as $documento_administrativa)
                                                <tr id="trStorageDocumentoadministrativa{{ $documento_administrativa->id }}">
                                                    <td>
                                                        <p>
                                                            <x-documento :documento="$documento_administrativa->licitacionGestorDocumentos" :urlGestorDocumentos="$urlGestorDocumentos" />
                                                        </p>
                                                    </td>

                                                    <td>
                                                        <button type='button' class='btn btn-clean btn-icon btn-outline-success hrefEliminarDocumento' data-tipo='administrativa' data-id='{{ $documento_administrativa->id }}' data-folio='{{ $licitacion_folio }}' data-toggle="tooltip" data-theme="dark" title="Eliminar Archivo"><i class=' flaticon-delete'></i></button>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col-lg-12">
                                        <a href="#" class="btn btn-icon btn-outline-success btn-circle btn-sm mr-2 hrefAgregarOtroAdministrativa" data-toggle="tooltip" data-theme="dark" title="Agregar archivo">
                                            <i class="flaticon2-plus"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <!--Información Fiscal-->
                            <div class="tab-pane fade" id="kt_tab_pane_3" role="tabpanel" aria-labelledby="kt_tab_pane_3">
                                <div class="row form-group">
                                    <div class="col-lg-12" id="tblArchivosFiscal">
                                        <table class='table table-bordered table-hover' id='tblDocumentosFiscal'>
                                            <thead>
                                                <tr>
                                                    <th>Documento</th>
                                                    <th>Opción</th>
                                                </tr>
                                            </thead>
                                            <tbody id='tbodyDocumentosFiscal'>
                                                @foreach($propuesta_tecnica_fiscal_documentos as $documento_fiscal)
                                                <tr id="trStorageDocumentofiscal{{ $documento_fiscal->id }}">
                                                    <td>
                                                        <x-documento :documento="$documento_fiscal->licitacionGestorDocumentos" :urlGestorDocumentos="$urlGestorDocumentos" />
                                                    </td>
                                                    <td>
                                                        <button type='button' class='btn btn-clean btn-icon btn-outline-success hrefEliminarDocumento' data-tipo='fiscal' data-id='{{ $documento_fiscal->id }}' data-folio='{{ $licitacion_folio }}' data-toggle="tooltip" data-theme="dark" title="Eliminar Archivo"><i class=' flaticon-delete'></i></button>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col-lg-12">
                                        <a href="#" class="btn btn-icon btn-outline-success btn-circle btn-sm mr-2 hrefAgregarOtroFiscal" data-toggle="tooltip" data-theme="dark" title="Agregar archivo">
                                            <i class="flaticon2-plus"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <!--Información Financiera-->
                            <div class="tab-pane fade" id="kt_tab_pane_4" role="tabpanel" aria-labelledby="kt_tab_pane_4">
                                <div class="row form-group">
                                    <div class="col-lg-12" id="tblArchivosFinanciera">
                                        <table class='table table-bordered table-hover' id='tblDocumentosFinanciera'>
                                            <thead>
                                                <tr>
                                                    <th>Documento</th>
                                                    <th>Opción</th>
                                                </tr>
                                            </thead>
                                            <tbody id='tbodyDocumentosFinanciera'>
                                                @foreach($propuesta_tecnica_financiera_documentos as $documento_financiera)
                                                <tr id="trStorageDocumentofinanciera{{ $documento_financiera->id }}">
                                                    <td>
                                                        <x-documento :documento="$documento_financiera->licitacionGestorDocumentos" :urlGestorDocumentos="$urlGestorDocumentos" />
                                                    </td>
                                                    <td>
                                                        <button type='button' class='btn btn-clean btn-icon btn-outline-success hrefEliminarDocumento' data-tipo='financiera' data-id='{{ $documento_financiera->id }}' data-folio='{{ $licitacion_folio }}' data-toggle="tooltip" data-theme="dark" title="Eliminar Archivo"><i class=' flaticon-delete'></i></button>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col-lg-12">
                                        <a href="#" class="btn btn-icon btn-outline-success btn-circle btn-sm mr-2 hrefAgregarOtroFinanciera" data-toggle="tooltip" data-theme="dark" title="Agregar archivo">
                                            <i class="flaticon2-plus"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <!--Otros-->
                            <div class="tab-pane fade" id="kt_tab_pane_5" role="tabpanel" aria-labelledby="kt_tab_pane_5">
                                <div class="row form-group">
                                    <div class="col-lg-12" id="tblArchivosOtros">
                                        <table class='table table-bordered table-hover' id='tblDocumentosOtros'>
                                            <thead>
                                                <tr>
                                                    <th>Documento</th>
                                                    <th>Tipo de Documento</th>
                                                    <th>Opción</th>
                                                </tr>
                                            </thead>
                                            <tbody id='tbodyDocumentosOtros'>
                                                @foreach($propuesta_tecnica_otro_documentos as $documento_otro)
                                                <tr id="trStorageDocumentootros{{ $documento_otro->id }}">
                                                    <td>
                                                    <a href="{{ route('archivo.propuestaTecnica',  ['id' => $documento_otro->id, 'folio' => $licitacion_folio, 'tipo' => 'otros']) }}" target="_blank">{{ $documento_otro->licitacion_informacion_otro }}</a>
                                                    </td>
                                                    <td>
                                                        <p>{{ $documento_otro->licitacion_informacion_otro }}</p>
                                                    </td>
                                                    <td>
                                                        <button type='button' class='btn btn-clean btn-icon btn-outline-success hrefEliminarDocumento' data-tipo='otros' data-id='{{ $documento_otro->id }}' data-folio='{{ $licitacion_folio }}' data-toggle="tooltip" data-theme="dark" title="Eliminar Archivo"><i class=' flaticon-delete'></i></button>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        <input type="hidden" id="datatable_i18n" value="{{ asset('/js/datatables/i18n/es-mx.json') }}">
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col-lg-12">
                                        <a href="#" class="btn btn-icon btn-outline-success btn-circle btn-sm mr-2 hrefAgregarOtroOtros" data-toggle="tooltip" data-theme="dark" title="Agregar archivo">
                                            <i class="flaticon2-plus"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- end tabs content -->
                    </div>
                    <div class="card-footer px-0">
                        <div class="row">
                            <div class="col-lg-6">
                                <button type="button" id="btnGuardarPropuesta" class="btn btn-success btnGuardarPropuesta"><i class="la la-plus"></i>Guardar</button>
                                <a href="{{ route('licitacion.listadolicitaciones') }}" class="btn btn-secondary"><i class="la la-times"></i>Cancelar</a>
                            </div>
                        </div>
                    </div>
                    <!--end::Formulario -->
                </div><!-- end card body -->
            </div>
            <!--end::Card-->
        </div>
    </div>
    <!--end::Card-->

</form>
@endsection