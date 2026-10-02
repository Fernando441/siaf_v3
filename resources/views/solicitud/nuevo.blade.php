@extends('layouts.app')
@push('scripts')
    <script src="{{ asset('js/solicitud/nueva-solicitud.js') }}"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
@endpush
@section('title')
    Agregar Solicitud GPS
@endsection
@section('content')

    <!--begin::Card-->
    <div class="row">
        <div class="col-lg-12">
            <!--begin::Card-->
            <div class="card card-custom gutter-b">
                <div class="card-header">
                    <h3 class="card-title">Agregar Solicitud GPS</h3>
                </div>
                
                <!--begin::Form-->
                <form class="form" action="{{ route('solicitud.guardar') }}" method="post" id="frmSolicitud" enctype="multipart/form-data">
                    @csrf   
                    <input type='hidden' id='url_municipios' value='{{ route('cliente.obtenermunicipios') }}'>
                    <div class="card-body">


                        <!--begin::stepper-->
                        <div class="wizard wizard-3" id="wizard-solicitud" data-wizard-state="last" data-wizard-clickable="true">
                            <!--begin: Wizard Nav-->
                            <div class="wizard-nav">
                                <div class="wizard-steps px-8 py-8 px-lg-15 py-lg-3">
                                    <!--begin::Wizard Step 1 Nav-->
                                    <div class="wizard-step" data-wizard-type="step" data-wizard-state="done">
                                        <div class="wizard-label">
                                            <h3 class="wizard-title">
                                                <span>1.</span> Información de la Solicitud
                                            </h3>
                                            <div class="wizard-bar"></div>
                                        </div>
                                    </div>
                                    <!--end::Wizard Step 1 Nav-->
                
                                    <!--begin::Wizard Step 2 Nav-->
                                    <div class="wizard-step" data-wizard-type="step" data-wizard-state="done">
                                        <div class="wizard-label">
                                            <h3 class="wizard-title">
                                                <span>2.</span> Selecciona el Vehículo
                                            </h3>
                                            <div class="wizard-bar"></div>
                                        </div>
                                    </div>
                                    <!--end::Wizard Step 2 Nav-->
                
                                     
                                    <!--end::Wizard Step 4 Nav-->
                                </div>
                            </div>
                            <!--end: Wizard Nav-->
                
                            <!--begin: Wizard Body-->
                            <div class="row justify-content-center py-10 px-8 py-lg-12 px-lg-10">
                                <div class="col-xl-12 col-xxl-7">
                                    <!--begin: Wizard Form-->
                                    <form class="form fv-plugins-bootstrap fv-plugins-framework" id="kt_form">
                                        <!--begin: Wizard Step 1-->
                                        <div class="pb-5" data-wizard-type="step-content">
                                       
                                            <!--begin::Select-->
                                            <div class="form-group fv-plugins-icon-container">
                                                <label>Tipo de Solicitud</label>
                                                <select name="solicitud_tipo" class="form-control" required>
                                                    <option value="" >Seleccione una Opción</option>
                                                    @foreach ($solicitudTipo as $solicitud )
                                                        <option value="{{ $solicitud->id }}">{{ $solicitud->tipo }}</option>
                                                    @endforeach
                                                </select>
                                            <div class="fv-plugins-message-container"></div></div>
                                            <!--end::Select-->
                                            <div class="row">
                                                <div class="col-xl-6">
                                                    <!--begin::Input-->
                                                    <div class="form-group fv-plugins-icon-container has-success">
                                                        <label>Nombre del Contacto</label>
                                                        <input type="text" class="form-control" name="nombre_contacto" required>
                                                    <div class="fv-plugins-message-container"></div></div>
                                                    <!--end::Input-->
                                                </div>
                                                <div class="col-xl-6">
                                                    <!--begin::Input-->
                                                    <div class="form-group fv-plugins-icon-container has-success">
                                                        <label>Dirección del Contacto</label>
                                                        <input type="text" class="form-control" name="direccion_contacto" required >
                                                        <span class="form-text text-muted">Ingresar la dirección completa.</span>
                                                    <div class="fv-plugins-message-container"></div></div>
                                                    <!--end::Input-->
                                                </div>
                                            </div>
                                            <div class="row">
                                                <!--begin::Input-->
                                            <!--end::Input-->
                                            </div>
                                            <div class="row">
                                                <div class="col-xl-6">
                                                    <div class="form-group fv-plugins-icon-container has-success">
                                                        <label>Telefonos del Contacto</label>
                                                        <input type="text" class="form-control" name="telefono_contacto" required >
                                                    <div class="fv-plugins-message-container"></div></div>
                                                </div>
                                                <div class="col-xl-6">
                                                    <label>Comentarios</label>
                                                    <textarea class="form-control" name="comentario" id="" rows="3"></textarea>
                                                </div>
                                            </div>
                
                                        </div>
                                        <!--end: Wizard Step 1-->
                
                                        <!--begin: Wizard Step 2-->
                                        <div class="pb-5" data-wizard-type="step-content">
                                            <h4 class="mb-10 font-weight-bold text-dark">Selecciona los vehículos</h4>


                                            <div class="card-toolbar">
                                                <a class="btn btn-link-primary font-weight-bold mr-2 busqueda" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                                                    Busqueda
                                                </a>
                                            </div>

                                            <!--init: listado de vehículos-->
                                            <div class="collapse" id="collapseExample">
                                                <div class="card card-body">
                                                    <!--begin: Search Form-->
                                                    <form class="mb-15">
                                                        <div class="row">
                                                             
                                                            <div class="col-lg-12">
                                                                <div class="row mb-6">
                                                                    <div class="col-lg-4 mb-lg-0 mb-6" id="dv_folio">
                                                                        <label>No. Folio:</label>
                                                                        <input type="text" class="form-control datatable-input" data-col-index="0" />
                                                                        <input type="hidden" name="inp_folio" id="inp_folio" value="1">
                                                                    </div>
                                                                    <div class="col-lg-4 mb-lg-0 mb-6" id="dv_patio">
                                                                        <label>Patio:</label>
                                                                        <select name="" id="" class="form-control datatable-input" data-col-index="1">
                                                                            <option value="">Seleccione una opción</option>
                                                                            @foreach($ubicaciones as $ub)
                                                                                <option value="{{ $ub->id }}">{{ $ub->ubicacion }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                        <input type="hidden" name="inp_patio" id="inp_patio" value="1">
                                                                    </div>
                                                                    <div class="col-lg-4 mb-lg-0 mb-6" id="dv_contrato">
                                                                        <label>Id. Contrato:</label>
                                                                        <select class="form-control datatable-input" data-col-index="2">
                                                                            <option value="">Seleccione una opción</option>
                                                                            @foreach($contratos as $mar)
                                                                                <option value="{{ $mar->id }}">Folio:{{ $mar->id_contrato }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                        <input type="hidden" name="inp_contrato" id="inp_contrato" value="1">
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-8">
                                                                    <div class="col-lg-4 mb-lg-0 mb-6" id="dv_marca">
                                                                        <label>Marca:</label>
                                                                        <select class="form-control datatable-input" data-col-index="3">
                                                                            <option value="">Seleccione una opción</option>
                                                                            @foreach($marcas as $mar)
                                                                                <option value="{{ $mar->id }}">{{ $mar->nombre_marca }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                        <input type="hidden" name="inp_marca" id="inp_marca" value="1">
                                                                    </div>
                                                                    <div class="col-lg-4 mb-lg-0 mb-6" id="dv_modelo">
                                                                        <label>Modelo:</label>
                                                                        <select name="" id="" class="form-control datatable-input" data-col-index="4">
                                                                            <option value="">Seleccione una opción</option>
                                                                            @foreach($modelos as $mod)
                                                                                <option value="{{ $mod->id }}">{{ $mod->nombre_modelo }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                        <input type="hidden" name="inp_modelo" id="inp_modelo" value="1">
                                                                    </div>
                
                                                                     
                                                                </div>
                
                                                                <div class="row mb-8">
                                                                    <div class="col-lg-4 mb-lg-0 mb-6" id="dv_placa">
                                                                        <label>Placa:</label>
                                                                        <input type="text" class="form-control datatable-input" data-col-index="6" />
                                                                        <input type="hidden" name="inp_placa" id="inp_placa" value="1">
                                                                    </div>
                
                                                                    <div class="col-lg-4 mb-lg-0 mb-6" id="dv_year">
                                                                        <label>Año:</label>
                                                                        <input type="text" class="form-control datatable-input" data-col-index="7" />
                                                                        <input type="hidden" name="inp_placa" id="inp_year" value="1">
                                                                    </div>
                
                                                                    <div class="col-lg-4 mb-lg-0 mb-6 oculto" id="dv_economico">
                                                                        <label>Número económico:</label>
                                                                        <input type="text" class="form-control datatable-input" data-col-index="9" />
                                                                        <input type="hidden" name="inp_economico" id="inp_economico" value="0">
                                                                    </div>
                
                                                                    <div class="col-lg-4 mb-lg-0 mb-8 oculto" id="dv_clave">
                                                                        <label>Clave vehicular:</label>
                                                                        <input type="text" class="form-control datatable-input" data-col-index="10" />
                                                                        <input type="hidden" name="inp_clave" id="inp_clave" value="0">
                                                                    </div>
                
                                                                </div>

                                                                <div class="row mb-8">
                                                                  

                                                                    <div class="col-lg-8 mb-lg-0 mb-8 oculto" id="dv_multiseries">
                                                                        <label>Números de Series:</label>
                                                                        <textarea class="form-control datatable-input" data-col-index="5" rows="3" placeholder="Pega aquí tus series (una por línea)"></textarea>
                                                                        <input type="hidden" name="inp_multi_series" id="inp_multi_series" value="0">
                                                                    </div>
                
                                                                </div>
                
                                                                <div class="row mt-8">
                                                                    <div class="col-lg-12">
                                                                        <button class="btn btn-primary btn-primary--icon"
                                                                                id="kt_search">
                                                                                    <span>
                                                                                        <i class="la la-search"></i>
                                                                                        <span>Buscar</span>
                                                                                    </span>
                                                                        </button>&#160;&#160;
                                                                        <button class="btn btn-secondary btn-secondary--icon"
                                                                                id="kt_reset">
                                                                                    <span>
                                                                                        <i class="la la-close"></i>
                                                                                        <span>Limpiar</span>
                                                                                    </span>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                
                
                                                </div>
                                            </div>
                
                                            <!--begin: Datatable-->
                                            <table class="table table-hover table-checkable" id="kt_datatable_example_1">
                                                <thead>
                                                <tr>
                                                    <th>Folio</th>
                                                    <th>Patio</th>
                                                    <th>Id. Contrato</th>
                                                    <th>Marca</th>
                                                    <th>Modelo</th>
                                                    <th>Serie</th>
                                                    <th>Placa</th>
                                                    <th>Año</th>
                                                    <th>Estatus</th>
                                                    <th>Número economico</th>
                                                    <th class="text-center">Opciones</th>
                                                </tr>
                                                </thead>
                                                <tfoot>
                                                <tr>
                                                    <th>Folio</th>
                                                    <th>Patio</th>
                                                    <th>Id. Contrato</th>
                                                    <th>Marca</th>
                                                    <th>Modelo</th>
                                                    <th>Serie</th>
                                                    <th>Placa</th>
                                                    <th>Año</th>
                                                    <th>Estatus</th>
                                                    <th>Número economico</th>
                                                    <th class="text-center">Opciones</th>
                                                </tr>
                                                </tfoot>
                                            </table>
                                            <!--end: Datatable-->
                                            <div class="fv-plugins-message-container">
                                                <div class="fv-help-block" id="msgVehiculos"></div>
                                            </div>
                
                                            <input type="hidden" id="datatable_i18n" value="{{ asset('/js/datatables/i18n/es-mx.json') }}">
                                            <input type="hidden" id="unidaddatatable" value="{{ route('solicitud.unidadDatos') }}">
                                            <!--end: listado de vehículos-->
                                        </div>
                                        <!--end: Wizard Step 2-->
                 
                
                                        <!--begin: Wizard Actions-->
                                        <div class="d-flex justify-content-between border-top mt-5 pt-10">
                                            <div class="mr-2">
                                                <button type="button" class="btn btn-secondary" data-wizard-type="action-prev">
                                                    <i class="la la-arrow-left"></i>Regresar
                                                </button>
                                            </div>
                                            <div>
                                                <button type="button" class="btn btn-success btnGuardar"  id="btnGuardar" data-wizard-type="action-submit">
                                                    <i class="la la-arrow-right"></i> Enviar
                                                </button>
                                                <button type="button" class="btn btn-success" data-wizard-type="action-next">
                                                    <i class="la la-arrow-right"></i> Continuar
                                                </button>
                                            </div>
                                        </div>
                                        <!--end: Wizard Actions-->
                                    <div></div><div></div><div></div><div></div></form>
                                    <!--end: Wizard Form-->
                                </div>
                            </div>
                            <!--end: Wizard Body-->
                        </div>
                        <!--end::steper-->
                        

                    </div>
                    
                </form>
                <!--end::Form-->
            </div>
            <!--end::Card-->
        </div>
    </div>
    <!--end::Card-->

@endsection
