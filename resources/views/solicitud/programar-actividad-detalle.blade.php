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
        <p>{{ $solicitudes->solicitudEstatus->estatus }}</p>
    </div>
</div>

 



@if (!empty($solicitudes->comentarios))
<div class="form-group row">
    
    <div class="col-lg-6">
        <label>Comentarios</label>
        <div class="input-group">
            <p>{{ !empty($solicitudes->comentarios) ? $solicitudes->comentarios : ''}}</p>
        </div>
    </div>

    <div class="col-lg-6">
        
    </div>
    
</div>
@endif

<div class="separator separator-dashed my-8"></div>

<div class="row form-group">
    <div class="col-lg-6">
      <label>Nombre del técnico responsable</label>
      <input type="text" class="form-control" name="nombre_tecnico" id="nombre_tecnico" value="@if(!empty($solicitudEjecucion)){{ $solicitudEjecucion->nombre_tecnico }}@endif" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()" required/>
      <span class="form-text text-muted">Nombre del técnico responsable que realizará la actividad.</span>
    </div>
    <div class="col-lg-6">
        <label >Fecha y hora de atención</label>
        <div class="input-group date" id="kt_datetimepicker_9" data-target-input="nearest">
            <input type="text" class="form-control datetimepicker-input" rel-id="@if(!empty($solicitudEjecucion)){{ Carbon\Carbon::parse($solicitudEjecucion->fecha_actividad)->format('d/m/Y h:i A') }}@endif" value="@if(!empty($solicitudEjecucion)){{ Carbon\Carbon::parse($solicitudEjecucion->fecha_actividad)->format('d/m/Y h:i A') }}@endif" data-target="#kt_datetimepicker_9" id="fecha_actividad" name="fecha_actividad" required />
            <div class="input-group-append" data-target="#kt_datetimepicker_9" data-toggle="datetimepicker">
                <span class="input-group-text">
                    <i class="ki ki-calendar"></i>
                </span>
            </div>
        </div>
        <span class="form-text text-muted">Fecha y hora de atención de la actividad a realizar.</span>
    </div>
</div>

<div class="form-group row">
    <div class="col-lg-12">
        <!--begin: Datatable-->
        <table class="table table-hover table-checkable" id="kt_datatable_example_1">
            <thead>
            <tr>
                <th>Folio</th>
                <th>Patio</th>
                <th>Id. Contrato</th>
                <th>Marca</th>
                <th>Modelo</th>
                <th>Serie</th>
                <th>Placa</th>
                <th>Año</th>
                <th>Estatus</th>
                <th>Número economico</th>
                <th class="text-center">Opciones</th>
            </tr>
            </thead>
            <tfoot>
            <tr>
                <th>Folio</th>
                <th>Patio</th>
                <th>Id. Contrato</th>
                <th>Marca</th>
                <th>Modelo</th>
                <th>Serie</th>
                <th>Placa</th>
                <th>Año</th>
                <th>Estatus</th>
                <th>Número economico</th>
                <th class="text-center">Opciones</th>
            </tr>
            </tfoot>
        </table>
        <!--end: Datatable-->
        <div class="fv-plugins-message-container">
            <div class="fv-help-block" id="msgVehiculos"></div>
        </div>

        <input type="hidden" id="datatable_i18n" value="{{ asset('/js/datatables/i18n/es-mx.json') }}">
        <input type="hidden" id="unidaddatatable" value="{{ route('solicitud.unidadDatosSolicitud') }}">
        <!--end: listado de vehículos-->
    </div>
</div>
<input type="hidden" id="solicitud_id" value="{{ $solicitudId }}" />


