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

    <div class="form-group row">
        <div class="col-lg-6">
            <label>Número económico</label>
            <div class="input-group">
                <input type="number" name="numero_economico" id="numero_economico" value="{{ $unidad->numero_economico }}"  class="form-control" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
            </div>
        </div>
        <div class="col-lg-6">
            <label>Placa</label>
            <div class="input-group">
                <input type="text" name="placa" id="placa" disabled class="form-control" value="{{ $unidad->placa }}" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
            </div>
        </div>
    </div>

    <div class="form-group row">

        <div class="col-lg-6">
            <label>Clave vehicular</label>
            <div class="input-group">
                <input type="text" name="clave_vehicular" id="clave_vehicular" value="{{ $unidad->clave_vehicular }}"  class="form-control" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
            </div>
        </div>
        <div class="col-lg-6">
            <label>Número de tarjeta de circulación</label>
            <div class="input-group">
                <input type="text" name="no_tarjeta_circulacion" id="no_tarjeta_circulacion" disabled  value="{{ $unidad->no_tarjeta_circulacion }}"  class="form-control" required onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
            </div>
        </div>
    </div>


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
            <label>Aseguradora</label>
            <select class="form-control" id="id_aseguradora" name="id_aseguradora" disabled  >
                <option value="">Selecciona una opción</option>
                @foreach($aseguradoras as $aseg)
                    <option value="{{ $aseg->id}}" {{($aseg->id == $unidad->id_aseguradora) ? 'selected' : ''}}>
                        {{ strtoupper($aseg->nombre_aseguradora)}}
                    </option>
                @endforeach
            </select>
        </div>
    </div>


    <div class="form-group row">
        <div class="col-lg-6">
            <label>Número de póliza de seguro</label>
            <div class="input-group">
                <input type="text" name="no_poliza_seguro" id="no_poliza_seguro" disabled  class="form-control" value="{{ $unidad->no_poliza_seguro }}"  onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
            </div>
        </div>
        <div class="col-lg-6">
            <label>Fecha de vencimiento de la póliza</label>
            <div class="input-group">
                @if($unidad->fecha_vencimiento_poliza == null || $unidad->fecha_vencimiento_poliza == "")
                    <input type="text" name="fecha_vencimiento_poliza" id="fecha_vencimiento_poliza" disabled readonly class="form-control" value="" />
                @else
                     <input type="text" name="fecha_vencimiento_poliza" id="fecha_vencimiento_poliza" disabled readonly class="form-control" value="{{ date('d/m/Y', strtotime($unidad->fecha_vencimiento_poliza))}}" />
                @endif
            </div>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-lg-6">
            <label>Número de inventario</label>
            <div class="input-group">
                <input type="text" name="numero_inventario" id="numero_inventario"  class="form-control" value="{{ $unidad->numero_inventario }}" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
            </div>
        </div>
    </div>



<input type="hidden" name="id_ubicacion_asignar" value="{{ $unidad->id_ubicacion }}">


            @if($unidad->fecha_asignacion == null)
                <input type="hidden" name="fecha_asignacion" id="fecha_asignacion" value="" class="form-control"  />
            @else
                <input type="hidden" name="fecha_asignacion" id="fecha_asignacion" value="{{ date('d/m/Y', strtotime($unidad->fecha_asignacion))}}" class="form-control"  />
            @endif
<input type="hidden" name="id_tipo_asignacion" value="{{ $unidad->id_tipo_asignacion }}">

<input type="hidden" name="contrato_op" value="2">