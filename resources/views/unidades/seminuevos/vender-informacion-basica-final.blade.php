    <div class="form-group row">
        <div class="col-lg-6">
            <label>Marca</label>
            @foreach($marcas as $marca)
                @if($marca->id == $unidad->id_marca)
                    <p>{{ strtoupper($marca->nombre_marca)}}</p>
                @endif
            @endforeach
        </div>
        <div class="col-lg-6">
            <label>Modelo</label>
            @foreach($modelos as $model)
                @if($model->id == $unidad->id_modelo)
                    <p>{{ strtoupper($model->nombre_modelo)}}</p>
                @endif
            @endforeach
        </div>
    </div>


    <div class="form-group row">
        <div class="col-lg-6">
            <label>Número de serie</label>
            <p>{{ $unidad->no_serie }}</p>
        </div>
        <div class="col-lg-6">
            <label>No. Factura de compra</label>
            <p>{{ $unidad->factura_compra }}</p>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-lg-6">
            <label>Color</label>
            <p>{{ $unidad->color }}</p>
        </div>
        <div class="col-lg-6">
            <label>Año de la unidad</label>
            <p>{{ $unidad->unidad_year }}</p>
        </div>
    </div>
<div class="separator separator-dashed my-10"></div>
    <div class="form-group row">
        <div class="col-lg-6">
            <label>Retiro de placas y tarjeta de circulación</label>
            <div class="input-group">
                <span class="switch switch-icon">
                    <label>
                    <input type="checkbox" name="placas" value="1" {{($unidadVenta->retiro_placas ==1) ? 'checked' : ''}} >
                    <span></span>
                    </label>
                </span>
            </div>
        </div>
        <div class="col-lg-6">
            <label>Retiro de GPS, y quitar balizado</label>
            <div class="input-group">
                <span class="switch switch-icon">
                    <label>
                    <input type="checkbox" name="gps" value="1" {{($unidadVenta->retiro_gps ==1) ? 'checked' : ''}} >
                    <span></span>
                    </label>
                </span>
            </div>
        </div>
    </div>
    

    <div class="form-group row">
        <div class="col-lg-6">
            <label>Apartado de Unidad según políticas</label>
            <div class="input-group">
                <span class="switch switch-icon">
                    <label>
                    <input type="checkbox" name="apartado" value="1" {{($unidadVenta->apartado_politicas==1) ? 'checked' : ''}} >
                    <span></span>
                    </label>
                </span>
            </div>
        </div>
        <div class="col-lg-6">
            <label>Confirmación Directiva para venta de la unidad</label>
            <div class="input-group">
                <span class="switch switch-icon">
                    <label>
                    <input type="checkbox" name="confirmacion" value="1" {{($unidadVenta->confirmacion_directiva ==1) ? 'checked' : ''}}>
                    <span></span>
                    </label>
                </span>
            </div>
        </div>
    </div>

    <div class="separator separator-solid my-10" style="border-bottom-width: 2px;"></div>

    <div class="form-group row">
        <div class="col-lg-3">
            <label>Venta</label>
            <input type="number" class="form-control" name="precio_venta" id="precio_venta" value="{{ !empty($unidadVenta->precio_venta) ? $unidadVenta->precio_venta : ''}}">
        </div>
        <div class="col-lg-3">
            <label>Compra</label>
            <input type="number" class="form-control" name="compra" id="compra" value="{{ !empty($unidadVenta->compra) ? $unidadVenta->compra : ''}}">
        </div>
        <div class="col-lg-3">
            <label>Media</label>
            <input type="number" class="form-control" name="media" id="media" value="{{ !empty($unidadVenta->media) ? $unidadVenta->media : ''}}" readonly>
        </div>
        <div class="col-lg-3">
            <label>% de Ajuste sobre valor Compra Aut</label>
            <input type="number" class="form-control" name="ajustes_sobre_valor" id="ajustes_sobre_valor" value="{{ !empty($unidadVenta->ajustes_sobre_valor) ? $unidadVenta->ajustes_sobre_valor : ''}}">
        </div>
    </div>

    <div class="form-group row">
        <div class="col-lg-3">
            <label>Precio con ajuste vs Autométrica</label>
            <input type="number" class="form-control" name="autometrica" id="autometrica" value="{{ !empty($unidadVenta->autometrica) ? $unidadVenta->autometrica : ''}}">
        </div>
        <div class="col-lg-3">
            <label>% Ajuste Conversión</label>
            <input type="number" class="form-control" name="ajustes_conversion" id="ajustes_conversion" value="{{ !empty($unidadVenta->ajustes_conversion) ? $unidadVenta->ajustes_conversion : ''}}">
        </div>
        <div class="col-lg-3">
            <label>CONVERSION (Pipa, caja, blindaje ambulancia, policía, contenedor)</label>
            <input type="number" class="form-control" name="conversion" id="conversion" value="{{ !empty($unidadVenta->conversion) ? $unidadVenta->conversion : ''}}">
        </div>
        <div class="col-lg-3">
            <label>Precio conversión con ajuste</label>
            <input type="number" class="form-control" name="conversion_ajuste" id="conversion_ajuste" value="{{ !empty($unidadVenta->conversion_ajuste) ? $unidadVenta->conversion_ajuste : ''}}">
        </div>
    </div>

    

    <div class="form-group row">
        <div class="col-lg-6">
            <label>PRECIO VENTA (Vehículo + conversión)</label>
            <input type="number" class="form-control" name="venta_final" id="venta_final" value="{{ !empty($unidadVenta->venta_final) ? $unidadVenta->venta_final : ''}}">
        </div>
        <div class="col-lg-6">
            
        </div>
    </div>

    <div class="separator separator-solid my-10" style="border-bottom-width: 2px;"></div>

    <div class="form-group row">
        <div class="col-lg-6">
            <label>Precio de Mercado</label>
            <input type="number" class="form-control" name="precio_mercado" id="precio_mercado" value="{{ !empty($unidadVenta->precio_mercado) ? $unidadVenta->precio_mercado : ''}}" >
        </div>
        <div class="col-lg-6">
            
        </div>
    </div>

    <div class="form-group row">
        <div class="col-lg-6">
            <label>Fecha de de pago de la unidad</label>
            <input type="text" class="form-control" name="fecha_pago" id="fecha_pago" value="@isset($unidadVenta->fecha_pago) {{ date('d/m/Y', strtotime($unidadVenta->fecha_pago))}} @endisset">
        </div>
        <div class="col-lg-6">
            <label>Fecha de entrega de la unidad al comprador</label>
            <input type="text" class="form-control" name="fecha_entrega" id="fecha_entrega" value="@isset($unidadVenta->fecha_entrega) {{ date('d/m/Y', strtotime($unidadVenta->fecha_entrega))}} @endisset">
        </div>
    </div>

    <div class="form-group row">
        <div class="col-lg-6">
            <label>Fecha de registro para venta</label>
            <input type="text" class="form-control" name="fecha_registro_venta" id="fecha_registro_venta"  value="@isset($unidadVenta->fecha_registro_venta) {{ date('d/m/Y', strtotime($unidadVenta->fecha_registro_venta))}} @endisset">
        </div>
        <div class="col-lg-6">
            <label>Fecha en la que se vendió</label>
            <input type="text" class="form-control" name="fecha_venta" id="fecha_venta" value="@isset($unidadVenta->fecha_registro_venta) {{ date('d/m/Y', strtotime($unidadVenta->fecha_venta))}} @endisset">
        </div>
    </div>

    <div class="form-group row">
        <div class="col-lg-6">
            <label>Número de factura</label>
            <input type="text" class="form-control" name="numero_factura" id="numero_factura" value="{{ !empty($unidadVenta->numero_factura) ? $unidadVenta->numero_factura : ''}}">
        </div>
        <div class="col-lg-6">
            <label>Vendedor responsable de la unidad</label>
            <input type="text" class="form-control" name="vendedor_unidad" id="vendedor_unidad" value="{{ !empty($unidadVenta->vendedor_unidad) ? $unidadVenta->vendedor_unidad : ''}}">
        </div>
    </div>
    <div class="separator separator-dashed my-10"></div>
    
    <div class="form-group row">
        <div class="col-lg-6">
            <label>Nombre del Cliente</label>
            <input type="text" class="form-control" name="nombre_cliente" id="nombre_cliente" value="{{ !empty($unidadVenta->nombre_cliente) ? $unidadVenta->nombre_cliente : ''}}">
        </div>
        <div class="col-lg-6">
            <label>Dirección del Cliente</label>
            <input type="text" class="form-control" name="direccion_cliente" id="direccion_cliente" value="{{ !empty($unidadVenta->direccion_cliente) ? $unidadVenta->direccion_cliente : ''}}">
        </div>
    </div>
    

    <div class="form-group row">
        
        <div class="col-lg-6">
            <label>Identificación oficial del cliente</label>
            <input type="text" class="form-control" name="identificacion_cliente" id="identificacion_cliente" value="{{ !empty($unidadVenta->identificacion_cliente) ? $unidadVenta->identificacion_cliente : ''}}">
        </div>
        
        <div class="col-lg-6">
            
            <label>RFC</label>
            <div class="input-group">
                <input type="text" class="form-control" name="rfc" id="rfc" value="{{ !empty($unidadVenta->rfc) ? $unidadVenta->rfc : ''}}">
            </div>
        </div>
        
    </div>


    <div class="form-group row">
        
        <div class="col-lg-6">
            <label>Tipo de Persona</label>
            <div class="radio-inline">
                @foreach ($tipoPersona as $persona)
                    <label class="radio">
                        <input type="radio" name="tipo_persona" id="tipo_persona" value="{{ $persona->id }}" {{($unidadVenta->id_tipo_persona == $persona->id) ? 'checked' : ''}}  />
                        <span></span>
                        {{ $persona->tipo }}
                    </label>
                @endforeach
                
            </div>
        </div>
        
        <div class="col-lg-6">
            
            
        </div>
        
    </div>

    <div id="documentos_requeridos" style="visibility:{{ isset($unidadVenta->id_tipo_persona) ? 'visible' : 'hidden' }}" class="form-group row">
        <div class="col-md-4 col-lg-4">
            <label>Cédula fiscal actualizada</label>
            <div class="input-group">
                <span class="switch switch-icon">
                    <label>
                    <input type="checkbox" name="cedula_fiscal" value="1" {{($unidadVenta->cedula_fiscal == 1) ? 'checked' : ''}} >
                    <span></span>
                    </label>
                </span>
            </div>
        </div>
        <div class="col-md-4 col-lg-4">
            <label id="lbl_ine">INE vigente</label>
            <div class="input-group">
                <span class="switch switch-icon">
                    <label>
                    <input type="checkbox" name="ine_vigente" value="1" {{($unidadVenta->ine_vigente == 1) ? 'checked' : ''}}>
                    <span></span>
                    </label>
                </span>
            </div>
        </div>
        <div class="col-md-4 col-lg-4">
            <label>Copia del comprobante de pago realizado por el cliente</label>
            <div class="input-group">
                <span class="switch switch-icon">
                    <label>
                    <input type="checkbox" name="comprobante_pago" value="1" {{($unidadVenta->comprobante_pago == 1) ? 'checked' : ''}}>
                    <span></span>
                    </label>
                </span>
            </div>
        </div>
    </div>

    <div class="separator separator-dashed my-10"></div>

    <div class="form-group row">
        
        <div class="col-lg-12">
            
            <label>Comentarios</label>
            <div class="input-group">
                <textarea name="comentarios" id="comentarios" class="form-control"  onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">{{ !empty($unidadVenta->confirmacion_comentarios) ? $unidadVenta->confirmacion_comentarios : ''}}</textarea>
            </div>
        </div>
        
    </div>

    