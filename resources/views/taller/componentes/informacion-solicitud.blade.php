@if($solicitud->taller_solicitud_estado_id == 3)

    <div class="card card-custom">

        <div class="card-body">
            <div class="row">
                <div class="col-lg-6 form-group">
                    <label class="d-block">Motivo de rechazo</label> 
                    <span style="color: red; font-size: 14px">{{ $solicitud->motivo }}</span>
                </div>
                <div class="col-lg-3 form-group">
                    <label class="d-block">Usuario que rechazo la solicitud</label> 
                    <p>{{ $solicitud->userValidacion->name }}</p>
                </div>
                <div class="col-lg-3 form-group">
                    <label class="d-block">Fecha de rechazo</label> 
                    <p>{{ $solicitud->fecha_validacion}}</p>
                </div>

            </div>
        </div>

    </div>

@endif

<div class="row mt-2">
    <div class="col-md-3">
        <div class="form-group">
            <label class="d-block">No. Serie</label>
            <p>{{ $solicitud->unidad->no_serie }}</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label class="d-block">Tipo de Solicitud</label>
            <p>{{ $solicitud->tallerTipoSolicitud->tipo }}</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label class="d-block">Estatus de la solicitud</label>
            @php
                $id = $solicitud->tallerSolicitudEstado->id;
                $styles = '';
                switch ($id) {
                    case 1:
                        //pendiente
                        $color_estatus = 'label-light-danger';
                        break;
                    case 2:
                        //preautorizado
                        $color_estatus = 'label-light-warning';
                        break;
                    case 3:
                        //autorizado
                        $color_estatus = 'label-light-success';
                        break;
                    case 4:
                        //con evidencia
                        $color_estatus = 'label-light-primary';
                        $styles = 'color:#1bc538;background-color:#caf7c9;';
                        break;
                    case 5:
                        //tesorería
                        $color_estatus = 'label-light-primary';
                        $styles = 'color:#f1bd00;background-color:#fcfdb9;';
                        break;
                    case 6:
                        //finalizado
                        $color_estatus = 'label-dark';
                        break;
                    case 7:
                        //incompleto
                        $color_estatus = 'label-warning';
                        break;
                    case 8:
                        //rechazado
                        $color_estatus = 'label-light-dark';
                        break;
                    default:
                        $color_estatus = 'label-light-dark';
                        break;
                }
            @endphp
            <p class="label label-lg font-weight-bold {{ $color_estatus }} label-inline text-capitalize"
                style="{{ $styles }}">
                {{ $solicitud->tallerSolicitudEstado->estado }}
            </p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label class="d-block">Fecha de solicitud</label>
            @php $fecha_solicitud = date('d-m-Y', strtotime($solicitud->fecha_solicitud)); @endphp
            @php $hora = date('H:i', strtotime($solicitud->fecha_solicitud)); @endphp
            @if ($hora >= 12)
                @php
                    $hora = date('h:i', strtotime($solicitud->fecha_solicitud));
                    $hora = $hora . ' PM';
                @endphp
            @else
                @php
                    $hora = date('h:i', strtotime($solicitud->fecha_solicitud));
                    $hora = $hora . ' AM';
                @endphp
            @endif
            <p>{{ $fecha_solicitud }}
                {{ $hora }}</p>
        </div>
    </div>
</div>
<div class="row mt-7">
    <div class="col-md-4">
        <div class="form-group">
            <label>Proveedor </label>
            <p>{{ $solicitud->proveedores_id == null ? 'Sin asignar' : $solicitud->proveedor->nombre }}</p>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>Concepto</label>
            @php
                $concepto = $solicitud->concepto;
                if ($concepto == null || $concepto == '') {
                    $concepto = 'Sin asignar';
                }
            @endphp
            <p>{{ $concepto }}</p>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>Observaciones</label>
            <p>{{ $solicitud->observaciones }}</p>
        </div>
    </div>
</div>
<div class="row mt-8">
    <div class="col-md-4">
        <div class="form-group">
            <label>Kilometraje Actual</label>
            <p>{{ $solicitud->kilometraje }}</p>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>Ubicacion Actual</label>
            <p>{{ $solicitud->domicilio }}</p>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>Codigo Postal</label>
            <p>{{ $solicitud->codigo_postal }}</p>
        </div>
    </div>
</div>
