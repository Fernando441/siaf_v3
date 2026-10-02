<div class="form-group">
    <div class="col-lg-6">
        <div class="form-group">
            <label>Selecciona una opción</label>
            <div class="radio-inline">
                <label class="radio">
                    <input type="radio" name="contrato_op" {{($unidad->unidad_asignacion_id == '1') ? 'checked' : ''}}  id="tp1"  value="1"/>
                    <span></span>
                    Asignar a Contrato
                </label>
                <label class="radio">
                    <input type="radio" name="contrato_op" {{($unidad->unidad_asignacion_id == '2') ? 'checked' : ''}} id="tp2"  value="2"/>
                    <span></span>
                    Asignar a Patio
                </label>
            </div>
        </div>
    </div>
</div>

<div class="row form-group">
    <div class="col-lg-6 {{($unidad->unidad_asignacion_id == '1' || $unidad->unidad_asignacion_id == '0') ? 'oculto' : ''}} div_patio">
        <label>Patio</label>
        <select class="form-control" id="id_ubicacion_asignar" name="id_ubicacion_asignar">
            <option value="">Selecciona una opción</option>
            @foreach($ubicaciones as $cli)
                <option value="{{ $cli->id}}" {{($cli->id == $unidad->id_ubicacion) ? 'selected' : ''}}>
                    {{ $cli->ubicacion }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-lg-6 div_contrato {{($unidad->unidad_asignacion_id == '2' || $unidad->unidad_asignacion_id == '0') ? 'oculto' : ''}}">
        <label>Contrato</label>
        <select class="form-control" id="id_contrato_asignar" name="id_contrato_asignar">
            <option value="">Selecciona una opción</option>
            @foreach($contratos as $cont)
                <option value="{{ $cont->id}}" {{($cont->id == $unidad->proyectos_id) ? 'selected' : ''}}>
                    Id contrato: {{ $cont->id_contrato }} / No. Contrato: {{ $cont->no_contrato }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-lg-6">
        <label>Fecha de asignación</label>
        <div class="input-group">
            @if($unidad->fecha_asignacion == null)
                <input type="text" name="fecha_asignacion" id="fecha_asignacion" value="" class="form-control" required />
            @else
                <input type="text" name="fecha_asignacion" id="fecha_asignacion" value="{{ date('d/m/Y', strtotime($unidad->fecha_asignacion))}}" class="form-control" required />
            @endif
        </div>
    </div> 
</div>

<div class="row form-group">
    <div class="col-lg-6">
        <label>Tipo de asignación</label>
        <select class="form-control" id="id_tipo_asignacion" name="id_tipo_asignacion" required>
            <option value="">Selecciona una opción</option>
            @foreach($tipoasignacion as $asig)
                <option value="{{ $asig->id}}" {{($asig->id == $unidad->id_tipo_asignacion) ? 'selected' : ''}}>
                    {{ $asig->tipo_asignacion }}
                </option>
            @endforeach
        </select>
    </div>
</div>