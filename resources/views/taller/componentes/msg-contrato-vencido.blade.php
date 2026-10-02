<div class="card-body">
    <div class="alert alert-custom alert-primary" role="alert">
        <div class="alert-icon"><i class="flaticon-warning"></i></div>
        <div class="alert-text">
            El contrato de la unidad no esta vigente. 
            <span class="badge badge-pill badge-light px-6 ml-4">
                Expiro el {{ date('d-m-Y', strtotime($unidad->proyecto->firma_final_vigencia)) }}
            </span>
        </div>
    </div>
    @include('taller.componentes.informacion-unidad')
    <div class="card-footer">
        <div class="row">
            <div class="col-md-6 pb-0 px-0">
                <a href="{{ route('taller.solicitaratencion') }}" class="btn btn-lg btn-secondary"><i class="la la-arrow-left"></i>Regresar</a>
            </div>
        </div>
</div>