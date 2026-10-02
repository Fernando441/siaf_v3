    <div class="form-group row">
        <div class="col-lg-6">
                <div class="form-group">
                    <label>Forma de compra</label>
                    <div class="radio-inline">
                        
                            <label class="radio">
                                <input type="radio" name="forma_compra" {{($unidad->forma_compra == '0') ? 'checked' : ''}} id="tp1" checked value="0"/>
                                <span></span>
                                Credito
                            </label>
                        
                            <label class="radio">
                                <input type="radio" name="forma_compra" {{($unidad->forma_compra == '1') ? 'checked' : ''}} id="tp2" value="1"/>
                                <span></span>
                                Contado
                            </label>
                    </div>
                </div>
        </div>
        <div class="col-lg-6">
                <div class="form-group">
                    <label>Estatus de la unidad</label>
                    <div class="radio-inline">
                        
                            <label class="radio">
                                <input type="radio" name="estatus_op" {{($unidad->estatus_pagado == '0') ? 'checked' : ''}} id="tp1" checked value="0"/>
                                <span></span>
                                No pagada
                            </label>
                        
                            <label class="radio">
                                <input type="radio" name="estatus_op" {{($unidad->estatus_pagado == '1') ? 'checked' : ''}} id="tp2" value="1"/>
                                <span></span>
                                Pagada
                            </label>
                    </div>
                </div>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-lg-6">
            <label>Marca</label>
            <select class="form-control" id="id_marca" name="id_marca" required >
                <option value="">Selecciona una opción</option>
                @foreach($marcas as $marca)
                    <option value="{{ $marca->id}}" {{($marca->id == $unidad->id_marca) ? 'selected' : ''}}>
                        {{ strtoupper($marca->nombre_marca)}}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-lg-6">
            <label>Modelo</label>
            <select class="form-control" id="id_modelo" name="id_modelo"  required >
                <option value="">Selecciona una opción</option>
                @foreach($modelos as $model)
                    <option value="{{ $model->id}}" {{($model->id == $unidad->id_modelo) ? 'selected' : ''}}>
                        {{ strtoupper($model->nombre_modelo)}}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="form-group row">
{{--         <div class="col-lg-6">
            <label>Tipo de vehículo</label>
            <select class="form-control" id="id_tipovehiculo" name="id_tipovehiculo"  required >
                <option value="">Selecciona una opción</option>
                @foreach($tipovehiculo as $vehiculo)
                    <option value="{{ $vehiculo->id}}" {{($vehiculo->id == $unidad->id_vehiculo_tipo) ? 'selected' : ''}}>
                        {{ strtoupper($vehiculo->vehiculo_tipo)}}
                    </option>
                @endforeach
            </select>
        </div> --}}
        <div class="col-lg-6">
            <label>Número de serie</label>
            <div class="input-group">
                <input type="text" name="no_serie" id="no_serie"  class="form-control" required value="{{ $unidad->no_serie }}" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
            </div>
        </div>
        <div class="col-lg-6">
            <label>No. Factura de compra</label>
            <div class="input-group">
                <input type="text" name="factura_compra" id="factura_compra" value="{{ $unidad->factura_compra }}" required class="form-control" required onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
            </div>
        </div>

    </div>

    <div class="form-group row">
        <div class="col-lg-6">
            <label>Fecha de factura</label>
            <div class="input-group">
                @if($unidad->fecha_factura == null)
                    <input type="text" name="fecha_factura" id="fecha_factura" readonly value="" class="form-control" />
                @else
                    <input type="text" name="fecha_factura" id="fecha_factura" readonly value="{{ date('d/m/Y', strtotime($unidad->fecha_factura))}}" class="form-control" />
                @endif
            </div>
        </div>
{{--         <div class="col-lg-6">
            <label>Número económico</label>
            <div class="input-group">
                <input type="number" name="numero_economico" id="numero_economico" value="{{ $unidad->numero_economico }}"  class="form-control" />
            </div>
        </div> --}}
        <div class="col-lg-6">
            <label>Importe iva incluido</label>
            <div class="input-group">
                <input type="text" name="importe_iva" id="importe_iva" value="{{ $unidad->importe_iva }}"  class="form-control" required />
            </div>
        </div>
    </div>

{{--     <div class="form-group row">
        <div class="col-lg-6">
            <label>Importe iva incluido</label>
            <div class="input-group">
                <input type="text" name="importe_iva" id="importe_iva" value="{{ $unidad->importe_iva }}"  class="form-control" required />
            </div>
        </div>
        <div class="col-lg-6">
            <label>Placa</label>
            <div class="input-group">
                <input type="text" name="placa" id="placa"  class="form-control" required value="{{ $unidad->placa }}"/>
            </div>
        </div>
    </div> --}}

    <div class="form-group row">
{{--         <div class="col-lg-6">
            <label>Clave vehicular</label>
            <div class="input-group">
                <input type="text" name="clave_vehicular" id="clave_vehicular" value="{{ $unidad->clave_vehicular }}"  class="form-control" required />
            </div>
        </div> --}}
        <div class="col-lg-6">
            <label>Color</label>
            <div class="input-group">
                <input type="text" name="color" id="color"  class="form-control" required value="{{ $unidad->color }}" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
            </div>
        </div>
        <div class="col-lg-6">
            <label>Año de la unidad</label>
            <div class="input-group">
                <input type="text" name="unidad_year" id="unidad_year"  readonly class="form-control" required value="{{ $unidad->unidad_year }}"  />
            </div>
        </div>
    </div>
    <input type="hidden" name="id_status" value="{{ $unidad->id_status }}">
{{-- 
    <div class="form-group row">
        <div class="col-lg-6">
            <label>Año de la unidad</label>
            <div class="input-group">
                <input type="text" name="unidad_year" id="unidad_year"  readonly class="form-control" required value="{{ $unidad->unidad_year }}"  />
            </div>
        </div>
        <div class="col-lg-6">
            <label>Número de tarjeta de circulación</label>
            <div class="input-group">
                <input type="text" name="no_tarjeta_circulacion" id="no_tarjeta_circulacion"  value="{{ $unidad->no_tarjeta_circulacion }}"  class="form-control" required />
            </div>
        </div>
    </div> --}}

{{--     
    <div class="form-group row">
        <div class="col-lg-6">
            <label>Transmisión</label>
            <select class="form-control"  name="transmision" id="transmision" required >
                <option value="">Selecciona la Opción</option>
                <option value="ESTANDAR" {{('ESTANDAR' == $unidad->transmision) ? 'selected' : ''}}>ESTÁNDAR</option>
                <option value="AUTOMATICO" {{('AUTOMATICO' == $unidad->transmision) ? 'selected' : ''}}>AUTOMÁTICO</option>
            </select>
        </div>
        <div class="col-lg-6">
            <label>Estatus</label>
            <select class="form-control" id="id_status" name="id_status"  required  >
                <option value="">Selecciona una opción</option>
                @foreach($estatus as $est)
                    <option value="{{ $est->id}}" {{($est->id == $unidad->id_status) ? 'selected' : ''}}>
                        {{ strtoupper($est->nombre_status)}}
                    </option>
                @endforeach
            </select>
        </div>
    </div> --}}

{{--     <div class="form-group row">
        <div class="col-lg-6">
            <label>Aseguradora</label>
            <select class="form-control" id="id_aseguradora" name="id_aseguradora"   >
                <option value="">Selecciona una opción</option>
                @foreach($aseguradoras as $aseg)
                    <option value="{{ $aseg->id}}" {{($aseg->id == $unidad->id_aseguradora) ? 'selected' : ''}}>
                        {{ strtoupper($aseg->nombre_aseguradora)}}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-lg-6">
            <label>Número de póliza de seguro</label>
            <div class="input-group">
                <input type="text" name="no_poliza_seguro" id="no_poliza_seguro"  class="form-control" value="{{ $unidad->no_poliza_seguro }}"  />
            </div>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-lg-6">
            <label>Fecha de vencimiento de la póliza</label>
            <div class="input-group">
                <input type="text" name="fecha_vencimiento_poliza" id="fecha_vencimiento_poliza" readonly class="form-control" value="{{ date('d/m/Y', strtotime($unidad->fecha_vencimiento_poliza))}}" />
            </div>
        </div>
        <div class="col-lg-6">
            <label>Número de inventario</label>
            <div class="input-group">
                <input type="text" name="numero_inventario" id="numero_inventario"  class="form-control" value="{{ $unidad->numero_inventario }}" />
            </div>
        </div>
    </div> --}}
