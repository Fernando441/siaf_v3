<div class="col-md-12 py-4">
    <h4 class="text-center">Formulario para agendar cita</h4>
</div>
<form action="{{ route('taller.autorizarsolicitud') }}" method="POST" enctype="multipart/form-data" id="formAgendarcita">
    @csrf
    <input type="hidden" name="no_serie" value="{{ $unidad->no_serie }}">
    <input type="hidden" name="id" value="{{ $solicitud->id }}">
{{--     <div class="form-group row">
        <div class="col-md-6">
            <label for="rfc">RFC</label>
            <div class="input-group">
                <input type="text" name="rfc" id="rfc" class="form-control" placeholder="Escribe el RFC">
                <div class="input-group-append">
                    <span class="input-group-text">
                        <i class="fas fa-search"></i>
                    </span>
                </div>
            </div>
                <small class="form-text text-muted" id="rfcEncontrado">
                    Ingresa el RFC del proveedor para buscarlo en el sistema.
                </small>
        </div>           
        <div class="col-md-6">
            <label>Proveedor</label>
            <select name="proveedor" id="proveedor" class="form-control" required>
                <option value="">Seleccione un proveedor</option>
            </select>
            <small class="form-text text-primary" id="proveedoresEncontrados"></small>
        </div>
    </div> --}}
{{--     <div class="form-group row">
        <div class="col-md-6">
            <label for="cuenta">Cuenta</label>
            <select name="cuenta" id="cuenta" class="form-control" required>
                <option value="">Seleccione una cuenta</option>
            </select>
            <small class="form-text text-primary" id="cuentasEncontradas"></small>
        </div>
        <div class="col-md-6">
            <label for="direccion">Direccion</label>
            <select name="direccion" id="direccion" class="form-control" required>
                <option value="">Seleccione una direccion</option>
            </select>
            <small class="form-text text-primary" id="direccionesEncontradas"></small>
        </div>
    </div> --}}
{{--     <div class="form-group row">
        <div class="col-md-6">
            <label for="importe">Importe</label>
            <input type="number" name="importe" id="importe" class="form-control" placeholder="Importe" required>
        </div>
        <div class="col-md-6">
            <label>Fecha de la cita</label>
            <div class="input-group date" id="fecha_cita" data-target-input="nearest">
                <input type="text" name="fecha_cita" class="form-control datetimepicker-input" placeholder="Selecciona una fecha y hora" data-target="#fecha_cita" required>
                <div class="input-group-append" data-target="#fecha_cita" data-toggle="datetimepicker">
                    <span class="input-group-text">
                        <i class="ki ki-calendar"></i>
                    </span>
                </div>
            </div>
        </div>
    </div> --}}
</form>
