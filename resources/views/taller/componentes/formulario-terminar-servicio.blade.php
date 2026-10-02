@push('scripts')
<script src="{{ asset('js/taller/TablaDocumentosSolicitud.js') }}" type="text/javascript"></script>
<script>
    $('#btnPreautorizarConEvidencia').click(function () {
        Swal.fire({
            title: '¿Está seguro de preautorizar la solicitud?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: '¡Sí, preautorizar!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $('#formPreautorizarConEvidencia').submit();
            }
        })
    });

</script>
@endpush
<input type="hidden" id="get_tabla_documentos" value="{{ route('taller.gettabladocumentos') }}">
<input type="hidden" id="datatable_i18n" value="{{ asset('/js/datatables/i18n/es-mx.json') }}">
<form action="#" method="POST" enctype="multipart/form-data" id="formTerminarservicio">
    @csrf
    <input type="hidden" name="no_serie" value="{{ $unidad->no_serie }}">
    <input type="hidden" name="idSolicitud" id="idSolicitud" value="{{ $solicitud->id }}">
    <input type="hidden" id="get_archivo" value="{{ route('archivo.documentoSolicitudMantenimiento', ['id' => $solicitud->id]) }}">
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
                    <p>{{ $solicitud->importe }}</p>
                </div>
                <div class="col-md-6">
                    <label>Fecha de la cita</label>
                    @php 
                        $fecha_cita = new DateTime($solicitud->fecha_cita);
                        $fecha_cita = $fecha_cita->format('d/m/Y H:i A');
                    @endphp
                    <p>{{ $fecha_cita }}</p>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-6">
                    <label for="proveedor">Proveedor</label>
                    <p>{{ $solicitud->proveedor->nombre }}</p>
                </div>
                <div class="col-md-6">
                    <label for="cuenta">Cuenta</label>
                    <p>{{ $solicitud->proveedorCuentas->cuenta }}</p>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-12">
                    <label for="direccion">Dirección</label>
                    <p>{{ $solicitud->proveedorDireccion->direccion }}</p>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-12 mt-8">
                    <h4 class="text-uppercase mb-4 text-center">Documentos</h4>
                    <table class="table table-hover table-checkable mt-2" id="tablaDocumentos">
                        <thead class="text-center">
                        <tr>
                            <th>ID</th>
                            <th>Documento</th>
                            <th>Tipo de documento</th>			    					
                        </tr>
                        </thead>

                        <tbody style="text-align: center;">
                        </tbody>
                    </table>
                </div>
            </div>
    </div>
    <div class="card-footer">
        <div class="row">
            <div class="col-md-12 d-flex" style="justify-content: space-between;">
                <div>
                    <button type="button" class="btn btn-lg btn-primary mr-2" id="btnPreautorizarConEvidencia" {{ $evidencia ? '' : 'disabled' }}>
                        Preautorizar servicio
                    </button>

                    <button type="button" class="btn btn-secondary btn-lg ml-2" id="btn-rechazar-solicitud">Rechazar</button>

                    {{-- if $evidencia is false show a message --}}
                    @if(!$evidencia)
                        <span class="form-text text-danger">Se necesita subir la evidencia de trabajo terminado.</span>
                    @else
                        <span class="form-text text-primary">Hay evidencia de trabajo terminado.</span>
                    @endif
                </div>
                
                <div>
                    <a href="{{ route('taller.serviciossolicitados') }}" class="btn btn-lg btn-secondary float-right">
                        <i class="la la-arrow-left"></i>Regresar
                    </a>  
                </div>
            </div>
        </div>
    </div>
</div>
</form>
{{ Form::open(['route' => ['taller.rechazarsolicitud'], 'method' => 'POST', 'id' => 'form-rechazar-solicitud']) }}
    {{ Form::hidden('id', $solicitud->id) }}
{{ Form::close() }}

{{ Form::open(['route' => ['taller.preautorizarconevidencia'], 'method' => 'POST', 'id' => 'formPreautorizarConEvidencia']) }}
    {{ Form::hidden('id', $solicitud->id) }}
{{ Form::close() }}
