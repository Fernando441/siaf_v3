@extends('layouts.app')
@push('scripts')
    <script src="{{ asset('js/busqueda/index.js') }}"></script>
	<meta name="csrf-token" content="{{ csrf_token() }}" />
@endpush
@section('title')
    Busquedas aseguramiento 
@endsection
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
												<i class="flaticon2-search text-primary"></i>
											</span>
                                <h3 class="card-label">Búsquedas aseguramiento</h3>
                            </div>
                            <div class="card-toolbar">
                            </div>
                        </div>
                        <div class="card-body">

                            <div class="collapsex" id="collapseExample">
                                <div class="card card-body">

                                    <!--begin: Search Form-->
                                    <form id="form" method="post" action="{{ route('busqueda.busquedaaseguramiento') }}" class="form">
                                        @csrf    
                                        <input type='hidden' id='bid' name='bid' value='{{ $bid }}'>
                                        <div class="form-group row ">
                                            <div class="col-lg-12">
                                                <label>Tipos de Búsquedas</label>
                                                <div class="input-group">
                                                    <div class="radio-inline">
                                                        <label class="radio">
                                                            <input type="radio" checked name="tipo" value="1" required>
                                                            <span></span>
                                                            Por Número de Serie
                                                        </label>
{{--                                                         <label class="radio">
                                                            <input type="radio" name="tipo" value="2" required>
                                                            <span></span>
                                                            Por Número de Placa
                                                        </label>
                                                        <label class="radio">
                                                            <input type="radio" name="tipo" value="3" required>
                                                            <span></span>
                                                            Por Número Económico
                                                        </label> --}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                         <div class="form-group row ">
                                            <div class="col-lg-12">
                                                <textarea class="form-control" rows="10" name="listado" id="listado" required></textarea>
                                                <small class="form-text text-muted" >Pegue aquí el listado de números de serie, o números de placas.</small>
                                                <a class="btn btn-sm btn-clean btn-hover-icon-success btn-icon" onclick="document.getElementById('listado').value='';" data-toggle="tooltip" data-theme="dark" title="Limpiar Caja de Texto">
                                                    <i class="flaticon-delete"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="form-group row pt-5">
                                            <div class="col-lg-12">
                                                <label class="" >Selecciona los Campos de Salida</label>
                                            </div>
                                        </div>
                                        <div class="form-group row ">
                                            
                                            <div class="col-lg-3">
                                                <div class="input-group">
                                                    <div class="checkbox-inline">
                                                        <label class="checkbox pt-5">
                                                            <input type="checkbox" name="campos[agente]" value="1" checked>
                                                            <span></span>
                                                            Agente
                                                        </label>
                                                        <label class="checkbox pt-5">
                                                            <input type="checkbox" name="campos[poliza]" value="1" checked>
                                                            <span></span>
                                                           Poliza
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="input-group">
                                                    <div class="checkbox-inline">
                                                        <label class="checkbox pt-5">
                                                            <input type="checkbox" name="campos[inciso]" value="1" checked>
                                                            <span></span>
                                                            Inciso
                                                        </label>
                                                        <label class="checkbox pt-5">
                                                            <input type="checkbox" name="campos[orden_trabajo]" value="1" checked>
                                                            <span></span>
                                                            Orden de trabajo O/T
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="input-group">
                                                    <div class="checkbox-inline">
                                                        <label class="checkbox pt-5">
                                                            <input type="checkbox" name="campos[observaciones]" value="1" checked>
                                                            <span></span>
                                                            Observaciones
                                                        </label>
                                                        <label class="checkbox pt-5">
                                                            <input type="checkbox" name="campos[fecha_inicial_seguro]" value="1" checked>
                                                            <span></span>
                                                            Inicio de vigencia
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="input-group">
                                                    <div class="checkbox-inline">
                                                        <label class="checkbox pt-5">
                                                            <input type="checkbox" name="campos[fecha_final_seguro]" value="1" checked>
                                                            <span></span>
                                                            Fin vigencia
                                                        </label>
                                                        <label class="checkbox pt-5">
                                                            <input type="checkbox" name="campos[valor_factura]" value="1" checked>
                                                            <span></span>
                                                            Valor factura
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>

                                            
                                            <div class="col-lg-3">
                                                <div class="input-group">
                                                    <div class="checkbox-inline">
                                                        <label class="checkbox pt-5">
                                                            <input type="checkbox" name="campos[fecha_factura_eq_esp]" value="1" checked>
                                                            <span></span>
                                                            Equipo especial - Fecha de factura
                                                        </label>
                                                        <label class="checkbox pt-5">
                                                            <input type="checkbox" name="campos[fecha_factura_adaptacion]" value="1" checked>
                                                            <span></span>
                                                            Adaptacion - Fecha de factura
                                                        </label>
                                                        
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="input-group">
                                                    <div class="checkbox-inline">
                                                        <label class="checkbox pt-5">
                                                            <input type="checkbox" name="campos[importe]" value="1" checked>
                                                            <span></span>
                                                            Suma asegurada de unidad
                                                        </label>
                                                        <label class="checkbox  pt-5">
                                                            <input type="checkbox" name="campos[valor_eq_esp]" value="1" checked>
                                                            <span></span>
                                                            Valor EQ. ESP. - Suma asegurada EQ. ESP.
                                                        </label>
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="input-group">
                                                    <div class="checkbox-inline">
                                                        <label class="checkbox pt-5">
                                                            <input type="checkbox" name="campos[valor_adaptacion]" value="1" checked>
                                                            <span></span>
                                                            Valor adaptacion - Suma asegurada Adapt.
                                                        </label>
                                                        <label class="checkbox pt-5">
                                                            <input type="checkbox" name="campos[nombre_archivo_poliza]" value="1" checked>
                                                            <span></span>
                                                            Nombre del archivo poliza
                                                        </label>
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="input-group">
                                                    <div class="checkbox-inline">
                                                        <label class="checkbox  pt-5">
                                                            <input type="checkbox" name="campos[aseguradora_id]" value="1" checked>
                                                            <span></span>
                                                            Aseguradora
                                                        </label>
                                                        <label class="checkbox  pt-5">
                                                            <input type="checkbox" name="campos[tipo_cobertura_id]" value="1" checked>
                                                            <span></span>
                                                            Cobertura
                                                        </label>
                                                        
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="input-group">
                                                    <div class="checkbox-inline">
                                                        <label class="checkbox  pt-5">
                                                            <input type="checkbox" name="campos[prima_neta]" value="1" checked>
                                                            <span></span>
                                                            Prima neta
                                                        </label>
                                                        <label class="checkbox  pt-5">
                                                            <input type="checkbox" name="campos[recargos]" value="1" checked>
                                                            <span></span>
                                                            Regargos
                                                        </label>
                                                        
                                                        
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="col-lg-3">
                                                <div class="input-group">
                                                    <div class="checkbox-inline">
                                                        <label class="checkbox  pt-5">
                                                            <input type="checkbox" name="campos[servicio]" value="1" checked>
                                                            <span></span>
                                                            Servicio
                                                        </label>
{{--                                                         <label class="checkbox  pt-5">
                                                            <input type="checkbox" name="campos[tramite_estatus]" value="1" checked>
                                                            <span></span>
                                                            Estatus
                                                        </label> --}}
                                                        
                                                        
                                                    </div>
                                                </div>
                                            </div>

                                             
                                        </div>


                                        <div class="card-footer">
                                            <div class="row">
                                                <div class="col-lg-8">
                                                    <button type="button"  id="btnGuardar" class="btn btn-success"><i class="la la-search"></i>Buscar</button>
                                                </div>
                                            </div>
                                        </div>

                                    </form>


                                </div>
                            </div>

                             

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

@endsection
