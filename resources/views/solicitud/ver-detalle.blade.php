<div class="form-group row">
    <div class="col-lg-6">
        <label>#ID</label>
        <p>{{ $solicitudes->id }}</p>
    </div>
    <div class="col-lg-6">
        <label>Tipo</label>
        <p>{{ $solicitudes->SolicitudTipo->tipo }}</p>
    </div>
</div>


<div class="form-group row">
    <div class="col-lg-6">
        <label>Contacto</label>
        <p>{{ $solicitudes->nombre }}</p>
    </div>
    <div class="col-lg-6">
        <label>Dirección y Teléfono</label>
        <p>{{ $solicitudes->direccion }} {{ $solicitudes->telefono }}</p>
    </div>
</div>

<div class="form-group row">
    <div class="col-lg-6">
        <label>Fecha</label>
        <p>{{ $solicitudes->fecha }}</p>
    </div>
    <div class="col-lg-6">
        <label>Estatus</label>
        <p>
            <span class="label label-lg label-light-warning label-inline">
                {{ $solicitudes->solicitudEstatus->estatus }}
            </span>
        </p>
    </div>
</div>

<div class="form-group row">
    
    <div class="col-lg-6">
        @if(!empty($solicitudes->comentarios))
        <label>Comentarios registro de solicitud</label>
        <div class="input-group">
            <p>{{ !empty($solicitudes->comentarios) ? $solicitudes->comentarios : ''}}</p>
        </div>
        @endif
    </div>

    <div class="col-lg-6">
        @if(!empty($solicitudValidacion->comentarios))
        <label>Comentarios validación de solicitud</label>
        <div class="input-group">
            <p>{{ $solicitudValidacion->comentarios }}</p>
        </div>
        @endif
    </div>
    
</div>

@if(!empty($solicitudes->comentarios_finalizacion))    
<div class="form-group row">
    
    <div class="col-lg-6">
        <label>Comentarios finalización de solicitud</label>
        <div class="input-group">
            <p>{{ !empty($solicitudes->comentarios_finalizacion) ? $solicitudes->comentarios_finalizacion : ''}}</p>
        </div>
    </div>
    
    <div class="col-lg-6">
    </div>
    
</div>
@endif


<ul class="nav nav-tabs nav-tabs-line">
    <li class="nav-item">
        <a class="nav-link active" data-toggle="tab" href="#tab-vehiculos">Vehículos</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#tab-actividades">Bitácora</a>
    </li>
</ul>

<div class="tab-content mt-5" id="myTabContent">
    <div class="tab-pane fade mt-10 active show" id="tab-vehiculos" role="tabpanel" aria-labelledby="tab-vehiculos">
        <table class="table table-hover table-checkable" id="tabla-vehiculos">
            <thead>
            <tr>
                <th>Folio</th>
                <th>Marca</th>
                <th>Modelo</th>
                <th>Serie</th>
                <th>Placa</th>
                <th>Año</th>
                <th>IDGPS</th>
                <th>Estatus</th>
                <th class="text-center">Opciones</th>
            </tr>
            </thead>
            <tfoot>
            <tr>
                <th>Folio</th>
                <th>Marca</th>
                <th>Modelo</th>
                <th>Serie</th>
                <th>Placa</th>
                <th>Año</th>
                <th>IDGPS</th>
                <th>Estatus</th>
                <th class="text-center">Opciones</th>
            </tr>
            </tfoot>
        </table>
        <!--end: Datatable-->

        <input type="hidden" id="datatable_i18n" value="{{ asset('/js/datatables/i18n/es-mx.json') }}">
        <input type="hidden" id="unidaddatatable" value="{{ route('solicitud.unidadDatosSolicitud') }}">
        <!--end: listado de vehículos-->
    </div>

    <div class="tab-pane fade mt-10" id="tab-actividades" role="tabpanel" aria-labelledby="tab-actividades">

        <div class="timeline timeline-5">
            <div class="timeline-items">
                
                @foreach($solicitudBitacora as $bitacora)
                <div class="timeline-item">
                    <!--begin::Icon-->
                    <div class="timeline-media bg-light-secondary">
                        <span class="svg-icon svg-icon-success svg-icon-md">
                            <!--begin::Svg Icon | path:assets/media/svg/icons/Home/Library.svg-->
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect x="0" y="0" width="24" height="24"/>
                                    <path d="M12,21 C7.02943725,21 3,16.9705627 3,12 C3,7.02943725 7.02943725,3 12,3 C16.9705627,3 21,7.02943725 21,12 C21,16.9705627 16.9705627,21 12,21 Z M12,18 C15.3137085,18 18,15.3137085 18,12 C18,8.6862915 15.3137085,6 12,6 C8.6862915,6 6,8.6862915 6,12 C6,15.3137085 8.6862915,18 12,18 Z" fill="#000000"/>
                                    <path d="M12,16 C14.209139,16 16,14.209139 16,12 C16,9.790861 14.209139,8 12,8 C9.790861,8 8,9.790861 8,12 C8,14.209139 9.790861,16 12,16 Z" fill="#000000" opacity="0.3"/>
                                </g>
                            </svg> 
                            <!--end::Svg Icon-->
                        </span>
                    </div>
                    <!--end::Icon-->
                    <!--begin::Info-->
                    <div class="timeline-desc timeline-desc-light-success">
                        <span class="text-dark-75 font-weight-bold">{{ $bitacora->created_at->format('d/m/Y H:i')  }} - {{ $bitacora->solicitudEstatus->estatus }}</span>
                        <p class="font-weight-normal text-dark-50 pt-1 pb-2">{{ $bitacora->bitacora }}</p>
                    </div>
                    <!--end::Info-->
                </div>
                @endforeach
            </div>
        </div>
    </div>

  </div>

