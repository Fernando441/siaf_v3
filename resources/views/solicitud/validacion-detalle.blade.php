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

<div class="form-group row">
    
    <div class="col-lg-12">
        <label>Comentarios</label>
        <div class="input-group">
            <textarea name="comentarios" id="comentarios" class="form-control"  onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()" ></textarea>
        </div>
    </div>
</div>

<div class="form-group row">
    <div class="col-lg-12">
        <!--begin: Datatable-->
        <table class="table table-hover table-checkable" id="kt_datatable_example_1">
            <thead>
            <tr>
                <th>Folio</th>
                <th>Marca</th>
                <th>Modelo</th>
                <th>Serie</th>
                <th>Placa</th>
                <th>Año</th>
                <th>Estatus</th>
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
                <th>Estatus</th>
            </tr>
            </tfoot>
        </table>
        <!--end: Datatable-->

        <input type="hidden" id="datatable_i18n" value="{{ asset('/js/datatables/i18n/es-mx.json') }}">
        <input type="hidden" id="unidaddatatable" value="{{ route('solicitud.unidadDatosSolicitud') }}">
        <!--end: listado de vehículos-->
    </div>
</div>
