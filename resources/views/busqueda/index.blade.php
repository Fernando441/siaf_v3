@extends('layouts.app')
@push('scripts')
    <script src="{{ asset('js/busqueda/index.js') }}"></script>
	<meta name="csrf-token" content="{{ csrf_token() }}" />
@endpush
@section('title')
    Busquedas
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
                                <h3 class="card-label">Búsquedas</h3>
                            </div>
                            <div class="card-toolbar">
                            </div>
                        </div>
                        <div class="card-body">

                            <div class="collapsex" id="collapseExample">
                                <div class="card card-body">

                                    <!--begin: Search Form-->
                                    <form id="form" method="post" action="{{ route('busqueda.busqueda') }}" class="form">
                                        @csrf    
                                        <input type='hidden' id='bid' name='bid' value='{{ $bid }}'>
                                        <div class="form-group row ">
                                            <div class="col-lg-12">
                                                <label ><h6 class="fw-bold">Tipo de Búsquedas</h6> </label>
                                                <div class="input-group pt-4">
                                                    <div class="radio-inline">
                                                        <label class="radio">
                                                            <input type="radio" name="tipo" value="1" required>
                                                            <span></span>
                                                            Por Número de Serie
                                                        </label>
                                                        <label class="radio">
                                                            <input type="radio" name="tipo" value="2" required>
                                                            <span></span>
                                                            Por Número de Placa
                                                        </label>
                                                        <label class="radio">
                                                            <input type="radio" name="tipo" value="3" required>
                                                            <span></span>
                                                            Por Número Económico
                                                        </label>
                                                        <label class="radio">
                                                            <input type="radio" name="tipo" value="4" required>
                                                            <span></span>
                                                            Por Marca
                                                        </label>
                                                        <label class="radio">
                                                            <input type="radio" name="tipo" value="5" required>
                                                            <span></span>
                                                            Por Modelo
                                                        </label>
                                                        
                                                    </div>
                                                    
                                                </div>
                                                <div class="input-group pt-4">
                                                    <div class="radio-inline">
                                                        
                                                        
                                                        <label class="radio">
                                                            <input type="radio" name="tipo" value="6" required>
                                                            <span></span>
                                                            Por Entidad Federativa
                                                        </label>
                                                        <label class="radio">
                                                            <input type="radio" name="tipo" value="7" required>
                                                            <span></span>
                                                            Por Color de Engomado
                                                        </label>
                                                        <label class="radio">
                                                            <input type="radio" name="tipo" value="8" required>
                                                            <span></span>
                                                            Por Clave Vehícular
                                                        </label>
                                                        
                                                    </div>
                                                    
                                                </div>
                                                
                                            </div>

                                            <div class="col-lg-12 pt-5">
                                                <label>Por Tipo de Trámite</label>
                                                <div class="input-group">
                                                    <div class="radio-inline">
                                                        <label class="radio pt-4">
                                                            <input type="radio" name="tipo" value="9" required>
                                                            <span></span>
                                                            Emplacamiento
                                                        </label>
                                                        <label class="radio pt-4">
                                                            <input type="radio" name="tipo" value="10" required>
                                                            <span></span>
                                                            Tenencia y/o pago de derechos
                                                        </label>
                                                        <label class="radio pt-4">
                                                            <input type="radio" name="tipo" value="11" required>
                                                            <span></span>
                                                            Verificación
                                                        </label>
                                                        <label class="radio pt-4">
                                                            <input type="radio" name="tipo" value="12" required>
                                                            <span></span>
                                                            Aseguramiento
                                                        </label>
                                                        <label class="radio pt-4">
                                                            <input type="radio" name="tipo" value="13" required>
                                                            <span></span>
                                                            Reemplacamiento
                                                        </label>
                                                        <label class="radio pt-4">
                                                            <input type="radio" name="tipo" value="14" required>
                                                            <span></span>
                                                            Cambio de propietario
                                                        </label>
                                                        <label class="radio pt-4">
                                                            <input type="radio" name="tipo" value="15" required>
                                                            <span></span>
                                                            Reposición
                                                        </label>
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                         <div class="form-group row ">
                                            <div class="col-lg-12">
                                                <textarea class="form-control" rows="10" name="listado" id="listado" ></textarea>
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
                                            
                                            <div class="col-lg-2">
                                                <div class="input-group">
                                                    <div class="checkbox-inline">
                                                        <label class="checkbox pt-5">
                                                            <input type="checkbox" name="campos[numero_economico]" value="1" checked>
                                                            <span></span>
                                                            Número Económico
                                                        </label>
                                                        <label class="checkbox pt-5">
                                                            <input type="checkbox" name="campos[serie]" value="1" checked>
                                                            <span></span>
                                                            Serie (VIN)
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-2">
                                                <div class="input-group">
                                                    <div class="checkbox-inline">
                                                        <label class="checkbox pt-5">
                                                            <input type="checkbox" name="campos[placas]" value="1" checked>
                                                            <span></span>
                                                            Placas
                                                        </label>
                                                        <label class="checkbox pt-5">
                                                            <input type="checkbox" name="campos[estatus]" value="1" checked>
                                                            <span></span>
                                                            Estatus del Vehículo
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-2">
                                                <div class="input-group">
                                                    <div class="checkbox-inline">
                                                        <label class="checkbox pt-5">
                                                            <input type="checkbox" name="campos[ubicacion]" value="1" checked>
                                                            <span></span>
                                                            Ubicación
                                                        </label>
                                                        <label class="checkbox pt-5">
                                                            <input type="checkbox" name="campos[proyecto]" value="1" checked>
                                                            <span></span>
                                                            Proyecto
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-2">
                                                <div class="input-group">
                                                    <div class="checkbox-inline">
                                                        <label class="checkbox pt-5">
                                                            <input type="checkbox" name="campos[marca]" value="1" checked>
                                                            <span></span>
                                                            Marca
                                                        </label>
                                                        <label class="checkbox pt-5">
                                                            <input type="checkbox" name="campos[modelo]" value="1" checked>
                                                            <span></span>
                                                            Modelo
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>

                                            
                                            <div class="col-lg-2">
                                                <div class="input-group">
                                                    <div class="checkbox-inline">
                                                        <label class="checkbox pt-5">
                                                            <input type="checkbox" name="campos[anio]" value="1" checked>
                                                            <span></span>
                                                            Año
                                                        </label>
                                                        <label class="checkbox pt-5">
                                                            <input type="checkbox" name="campos[color]" value="1" checked>
                                                            <span></span>
                                                            Color
                                                        </label>
                                                        
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-2">
                                                <div class="input-group">
                                                    <div class="checkbox-inline">
                                                        <label class="checkbox pt-5">
                                                            <input type="checkbox" name="campos[unidad_tipo]" value="1" checked>
                                                            <span></span>
                                                            Tipo de Vehículo
                                                        </label>
                                                        <label class="checkbox  pt-5">
                                                            <input type="checkbox" name="campos[motor]" value="1" checked>
                                                            <span></span>
                                                            Motor
                                                        </label>
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-2">
                                                <div class="input-group">
                                                    <div class="checkbox-inline">
                                                        <label class="checkbox pt-5">
                                                            <input type="checkbox" name="campos[transmision]" value="1" checked>
                                                            <span></span>
                                                            Transmisión
                                                        </label>
                                                        <label class="checkbox pt-5">
                                                            <input type="checkbox" name="campos[fecha_alta]" value="1" checked>
                                                            <span></span>
                                                            Fecha de Alta
                                                        </label>
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-2">
                                                <div class="input-group">
                                                    <div class="checkbox-inline">
                                                        <label class="checkbox  pt-5">
                                                            <input type="checkbox" name="campos[fecha_asignacion]" value="1" checked>
                                                            <span></span>
                                                            Fecha de Asignación
                                                        </label>
                                                        <label class="checkbox  pt-5">
                                                            <input type="checkbox" name="campos[kilometraje]" value="1" checked>
                                                            <span></span>
                                                            Kilometraje
                                                        </label>
                                                        
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-2">
                                                <div class="input-group">
                                                    <div class="checkbox-inline">
                                                        <label class="checkbox  pt-5">
                                                            <input type="checkbox" name="campos[poliza]" value="1" checked>
                                                            <span></span>
                                                            Póliza
                                                        </label>
                                                        <label class="checkbox  pt-5">
                                                            <input type="checkbox" name="campos[factura]" value="1" checked>
                                                            <span></span>
                                                            Factura
                                                        </label>
                                                        
                                                        
                                                    </div>
                                                </div>
                                            </div>
 
                                            <div class="col-lg-2">
                                                <div class="input-group">
                                                    <div class="checkbox-inline">
                                                        <label class="checkbox  pt-5">
                                                            <input type="checkbox" name="campos[color_engomado]" value="1" checked>
                                                            <span></span>
                                                            Color Engomado
                                                        </label>
                                                        <label class="checkbox  pt-5">
                                                            <input type="checkbox" name="campos[clave_vehicular]" value="1" checked>
                                                            <span></span>
                                                            Clave Vehícular
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-2">
                                                <div class="input-group">
                                                    <div class="checkbox-inline">
                                                        <label class="checkbox  pt-5">
                                                            <input type="checkbox" name="campos[entidad_federativa]" value="1" checked>
                                                            <span></span>
                                                            Entidad Federativa
                                                        </label>
                                                        
                                                        
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
