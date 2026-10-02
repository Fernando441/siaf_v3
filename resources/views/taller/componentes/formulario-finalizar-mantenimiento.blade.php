@push('scripts')
<script>
    $('#btnFinalizar').click(function () {
        Swal.fire({
            title: '¿Está seguro de finalizar el mantenimiento?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: '¡Sí, finalizar!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $('#formTerminarservicio').submit();
            }
        })
    });

</script>
@endpush
<input type="hidden" id="datatable_i18n" value="{{ asset('/js/datatables/i18n/es-mx.json') }}">
<form action="{{ route('taller.finalizarsolicitud') }}" method="POST" enctype="multipart/form-data" id="formTerminarservicio">
    @csrf
    <input type="hidden" name="no_serie" value="{{ $unidad->no_serie }}">
    <input type="hidden" name="idSolicitud" id="idSolicitud" value="{{ $solicitud->id }}">
    <input type="hidden" id="get_archivo" value="{{ route('archivo.documentoSolicitudMantenimiento', ['id' => $solicitud->id]) }}">

    <div class="row">
            <div class="col-md-12 d-flex" style="justify-content: space-between;">
                <div>
                    <button type="button" class="btn btn-lg btn-primary mr-2" id="btnFinalizar">
                        Finalizar mantenimiento
                    </button>

                </div>
                
                <div>
                    <a href="{{ route('taller.serviciossolicitados') }}" class="btn btn-lg btn-secondary float-right">
                        <i class="la la-arrow-left"></i>Regresar
                    </a>  
                </div>
            </div>
        </div>
        {{ Form::hidden('id', $solicitud->id) }}
</form>

