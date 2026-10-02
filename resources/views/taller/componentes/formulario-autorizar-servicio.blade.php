<form action="{{ route('taller.autorizarparaevidencia') }}" method="POST" enctype="multipart/form-data" id="formAutorizar">
    @csrf
    <input type="hidden" name="no_serie" value="{{ $unidad->no_serie }}">
    <input type="hidden" name="id" value="{{ $solicitud->id }}">
<div class="card card-custom gutter-b">
    <div class="card-header">
        <div class="card-title">
            <h3 class="card-label">Datos de la solicitud de mantenimiento</h3>
        </div>
    </div>

    <div class="card-body">
            <div class="form-group row">
                <div class="col-md-6">
                    <label for="importe">Importe</label>
                    <input type="number" name="importe" id="importe" class="form-control" value="{{ $solicitud->importe }}" required>
                </div>
                <div class="col-md-6">
                    <label>Fecha de la cita</label>
                    <div class="input-group date" id="fecha_cita" data-target-input="nearest">
                        <input type="text" name="fecha_cita" class="form-control datetimepicker-input" value="{{ $solicitud->fecha_cita }}" data-target="#fecha_cita" required>
                        <div class="input-group-append" data-target="#fecha_cita" data-toggle="datetimepicker">
                            <span class="input-group-text">
                                <i class="ki ki-calendar"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            @php
                $proveedor_cuenta = $solicitud->proveedorCuentas->cuenta;
                if (is_null($proveedor_cuenta) || empty($proveedor_cuenta)) {
                    $proveedor_cuenta = "N/A";
                }
            @endphp
            <div class="form-group row">
                <div class="col-md-6">
                    <label for="proveedor">Proveedor</label>
                    <input type="text" name="proveedor" id="proveedor" class="form-control" value="{{ $solicitud->proveedores_id == null ? 'Sin asignar' : $solicitud->proveedor->nombre }}" disabled>
                </div>
                <div class="col-md-6">
                    <label for="cuenta">Cuenta</label>
                    <input type="text" name="cuenta" id="cuenta" class="form-control" value="{{ $proveedor_cuenta }}" disabled>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-12">
                    <label for="direccion">Dirección</label>
                    <input type="text" name="direccion" id="direccion" class="form-control" value="{{ $solicitud->proveedorDireccion->direccion }}" disabled>
                </div>
            </div>
    </div>

    <div class="card-footer">
        <div class="row">
            <div class="col-md-12 d-flex">
                <button type="button" class="btn btn-lg btn-success mr-2" id="btnAutorizar"><i class="la la-plus"></i>Autorizar</button>

                <button type="button" class="btn btn-secondary btn-lg ml-2" 
                id="btn-rechazar-solicitud">Rechazar</button>

                <a href="{{ route('taller.serviciossolicitados') }}" class="btn btn-lg btn-secondary ml-auto"><i class="la la-arrow-left"></i>Regresar</a>
            </div>
        </div>
    </div>
</div>
</form>
{{ Form::open(['route' => ['taller.rechazarsolicitud'], 'method' => 'POST', 'id' => 'form-rechazar-solicitud']) }}
    {{ Form::hidden('id', $solicitud->id) }}
{{ Form::close() }}