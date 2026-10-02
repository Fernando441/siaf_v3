
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
            <label>Número económico</label>
            <p>{{ $unidad->numero_economico }}</p>
        </div>
        <div class="col-lg-6">
            <label>Placa</label>
            <p>{{ $unidad->placa }}</p>
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
            <label>Número de tarjeta de circulación</label>
            <p>{{ $unidad->no_tarjeta_circulacion }}</p>
        </div>
        <div class="col-lg-6">
            <label>Ubicación</label>
            @foreach($ubicaciones as $ub)
                @if($ub->id == $unidad->id_ubicacion)
                    <p>{{ strtoupper($ub->ubicacion)}}</p>
                @endif
            @endforeach
        </div>
    </div>
    <div class="form-group row">
        <div class="col-lg-6">
            <label>Transmisión</label>
            @if('ESTANDAR' == $unidad->transmision)
                <p>ESTÁNDAR</p>
            @else
                <p>AUTOMÁTICO</p>
            @endif
        </div>
        <div class="col-lg-6">
            <label>Estatus</label>
            @foreach($estatus as $est)
                @if($est->id == $unidad->id_status)
                    <p>{{ strtoupper($est->nombre_status)}}</p>
                @endif
            @endforeach
        </div>
    </div>

    <div class="form-group row">
        <div class="col-lg-6">
            <label>Aseguradora</label>
            @foreach($aseguradoras as $aseg)
                @if($aseg->id == $unidad->id_aseguradora)
                    <p>{{ strtoupper($aseg->nombre_aseguradora)}}</p>
                @endif
            @endforeach
        </div>
        <div class="col-lg-6">
            <label>Número de póliza de seguro</label>
            <p>{{ $unidad->no_poliza_seguro }}</p>
        </div>

    </div>

    <div class="form-group row">
        <div class="col-lg-6">
            <label>Fecha de vencimiento de la póliza</label>

            <p>{{ date('d/m/Y', strtotime($unidad->fecha_vencimiento_poliza))}}</p>
        </div>
        <div class="col-lg-6">
            <label>Número de inventario</label>
            <p>{{ $unidad->numero_inventario }}</p>
        </div>
    </div>
