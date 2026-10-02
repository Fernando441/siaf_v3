@push('scripts')
    <script>
        // datatable
        var table = $('#datatable').DataTable({
            // español
            "language": {
                "url": "{{ asset('/js/datatables/i18n/es-mx.json') }}",
            },
        });
    </script>
@endpush
<form action="{{ route('taller.actualizarsolicitud') }}" method="POST">
    @csrf
    <input type="hidden" name="id" value="{{ $solicitud->id }}">
    <div class="row">
        <div class="col-md-3">
            <div class="form-group">
                <label for="no_serie">No. Serie</label>
                <p class="font-weight-bold text-uppercase">
                    {{ $solicitud->unidad->no_serie }}</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="tipo_solicitud">Tipo de Solicitud</label>
                {{-- select from $tiposSolicitud --}}
                <select name="tipo_solicitud" id="tipo_solicitud" class="form-control">
                    @foreach ($tiposSolicitud as $tipoSolicitud)
                        <option value="{{ $tipoSolicitud->tipo }}" class="text-capitalize"
                            {{ $tipoSolicitud->id == $solicitud->tipo_solicitud ? 'selected' : '' }}>
                            {{ $tipoSolicitud->tipo }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="estatus_solicitud">Estatus de la solicitud</label>
                <select name="estatus_solicitud" id="estatus_solicitud" class="form-control">
                    <option value="0" class="text-capitalize">
                        Actual: {{ $solicitud->tallerSolicitudEstado->estado }}</option>
                    @foreach ($estadosSolicitud as $estadoSolicitud)
                        <option value="{{ $estadoSolicitud->id }}" class="text-capitalize"
                            {{ $estadoSolicitud->id == $solicitud->tallerSolicitudEstado->id ? 'selected' : '' }}>
                            {{ $estadoSolicitud->estado }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="fecha_solicitud">Fecha de solicitud</label>
                <input type="datetime-local" id="fecha_solicitud" name="fecha_solicitud" class="form-control"
                    value="{{ $solicitud->fecha_solicitud }}">
            </div>
        </div>
    </div>
    <div class="row mt-7">
        <div class="col-md-4">
            <div class="form-group">
{{--                 <label for="proveedor">Proveedor</label>
                <p>
                    {{ $solicitud->proveedores_id == null ? 'Sin asignar' : $solicitud->proveedor->nombre }}
                </p> --}}
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="concepto">Concepto</label>
                <input type="text" id="concepto" name="concepto" class="form-control"
                    value="{{ $solicitud->concepto }}">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="observaciones">Observaciones</label>
                <input type="text" id="observaciones" name="observaciones" class="form-control"
                    value="{{ $solicitud->observaciones }}">
            </div>
        </div>
    </div>
    <div class="row mt-8">
        <div class="col-md-4">
            <div class="form-group">
                <label for="kilometraje">Kilometraje Actual</label>
                <input type="number" id="kilometraje" name="kilometraje" class="form-control"
                    value="{{ $solicitud->kilometraje }}">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="domicilio">Ubicacion Actual</label>
                <input type="text" id="domicilio" name="domicilio" class="form-control"
                    value="{{ $solicitud->domicilio }}">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="codigo_postal">Codigo Postal</label>
                <input type="text" id="codigo_postal" name="codigo_postal" class="form-control"
                    value="{{ $solicitud->codigo_postal }}">
            </div>
        </div>
    </div>
    <div class="row mt-8">
        {{-- fecha_cita --}}
        <div class="col-md-4">
            <div class="form-group">
                <label for="fecha_cita">Fecha de cita</label>
                <input type="datetime-local" id="fecha_cita" name="fecha_cita" class="form-control"
                    value="{{ $solicitud->fecha_cita }}">
            </div>
        </div>
        {{-- descripcion_falla --}}
        <div class="col-md-4">
            <div class="form-group">
                <label for="descripcion_falla">Descripcion de la falla (si aplica)</label>
                <input type="text" id="descripcion_falla" name="descripcion_falla" class="form-control"
                    value="{{ $solicitud->descripcion_falla }}">
            </div>
        </div>
        {{-- traslado input switch --}}
        <div class="col-md-2">
            <div class="form-group">
                <label class="col col-form-label">Traslado</label>


                <div class="radio-inline form-control-lg">
                    <label class="radio">
                        <input type="radio" name="traslado" value="1" {{ $solicitud->traslado == 1 ? 'checked' : '' }}>
                        <span></span>Si</label>
                    <label class="radio">
                        <input type="radio" name="traslado" value="0" {{ $solicitud->traslado == 0 ? 'checked' : '' }}> 
                        <span></span>No</label>
                </div>


            </div>
        </div>
        {{-- sustituto switch --}}
        <div class="col-md-2">
            <div class="form-group">
                <label class="col col-form-label">Sustituto</label>
                <div class="radio-inline form-control-lg">
                    <label class="radio">
                        <input type="radio" name="sustituto" value="1" {{ $solicitud->sustituto == 1 ? 'checked' : '' }} />
                        <span></span>Si</label>
                    <label class="radio">
                        <input type="radio" name="sustituto" value="0"{{ $solicitud->sustituto == 0 ? 'checked' : '' }} />
                        <span></span>No</label>
                </div>

            </div>
        </div>
    </div>
    <div class="col-md-12 my-4">
        @include('taller.componentes.informacion-unidad')
    </div>

    <div class="form-group row pt-6">
        <div class="col-lg-12">
            <h3 class="font-size-h4 mb-5">Ultimos mantenimientos</h3>
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-checkable" id="datatable">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Tipo</th>
                            <th>Concepto</th>
                            <th>Importe</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ultimos_mantenimientos as $mantenimiento)
                            <tr>
                                <td>{{ date('d/m/Y h:m', strtotime($mantenimiento->fecha_cita)) }}</td>
                                <td style="text-transform: capitalize;">{{ $mantenimiento->tipo_solicitud }}</td>
                                <td style="text-transform: capitalize;">{{ $mantenimiento->concepto }}</td>
                                <td>$ {{ number_format($mantenimiento->importe, 2, '.', ',') }}</td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon"
                                        title="Ver detalles">
                                        <i class="flaticon-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="d-flex">
            <button type="submit" class="btn btn-success mr-4"><i class="la la-plus"></i>Guardar cambios</button> <a
                href="{{ route('taller.serviciossolicitados') }}" class="btn btn-secondary px-6 btn-lg"><i class="la la-arrow-left"></i>Regresar</a>
        </div>
    </div>
</form>
