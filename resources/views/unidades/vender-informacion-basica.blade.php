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
            <label>Aplicación de políticas de venta y
                acuerdos (Condiciones de la unidad,
                evaluación física y mecánica, modelo, etc.)</label>
            <div class="input-group">
                <span class="switch switch-icon">
                    <label>
                    <input type="checkbox" name="politicas" value="1" required>
                    <span></span>
                    </label>
                </span>
            </div>
        </div>
        <div class="col-lg-6">
            <label>Comentarios</label>
            <div class="input-group">
                <textarea name="comentarios" id="comentarios" class="form-control"  onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"></textarea>
            </div>
        </div>
    </div>

    