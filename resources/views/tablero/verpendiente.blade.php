@extends('layouts.app')

@section('title')
    Pendiente
@endsection

@push('scripts')
	<script src="{{ asset('js/tablero/Notificaciones.js') }}"></script>
	<script src="{{ asset('js/tablero/EvidenciaPendientes.js') }}"></script>
	<meta name="csrf-token" content="{{ csrf_token() }}" />
@endpush

@section('content')
<style type="text/css">
/* ==========================================
   TIMELINE
   ========================================== */

.timeline-card {
    border: 0;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.06);
}


/* CONTENEDOR */

.timeline {
    position: relative;
    padding: 10px 0;
}


/* ITEM */

.timeline-item {
    position: relative;

    display: flex;

    min-height: 105px;

    padding-left: 55px;
}


/* LINEA VERTICAL */

.timeline-line {
    position: absolute;

    left: 20px;
    top: 40px;
    bottom: -20px;

    width: 2px;

    background: #e4e6ef;
}


/* No mostrar línea en el último elemento */

.timeline-item:last-child .timeline-line {
    display: none;
}


/* ICONO */

.timeline-icon {
    position: absolute;

    left: 0;
    top: 0;

    width: 42px;
    height: 42px;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 50%;

    background: #3699ff;

    color: #fff;

    font-size: 15px;

    z-index: 2;

    box-shadow: 0 3px 8px rgba(0, 0, 0, 0.12);
}


/* CONTENIDO */

.timeline-content {
    width: 100%;

    padding: 0 0 25px 15px;
}


/* HEADER */

.timeline-header {
    display: flex;

    justify-content: space-between;
    align-items: center;

    margin-bottom: 6px;
}


/* TITULO */

.timeline-title {
    color: #181c32;

    font-size: 14px;
    font-weight: 600;
}


/* HORA */

.timeline-time {
    color: #a1a5b7;

    font-size: 11px;
}


/* DESCRIPCION */

.timeline-description {
    color: #7e8299;

    font-size: 12px;

    line-height: 1.6;

    margin-bottom: 8px;
}


/* BADGE */

.timeline-user .badge {
    font-size: 10px;

    padding: 5px 8px;
}


/* ==========================================
   METRONIC COLORS
   ========================================== */

.timeline-icon.bg-primary {
    background-color: #3699ff !important;
}

.timeline-icon.bg-success {
    background-color: #669933 !important;
}

.timeline-icon.bg-warning {
    background-color: #efff00  !important;
}

.timeline-icon.bg-danger {
    background-color: #f64e60 !important;
}


/* ==========================================
   RESPONSIVE
   ========================================== */

@media (max-width: 576px) {

    .timeline-header {
        display: block;
    }

    .timeline-time {
        display: block;

        margin-top: 3px;
    }

    .timeline-content {
        padding-left: 10px;
    }

}
</style>
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-custom gutter-b">
                <div class="card-header">
                    <h3 class="card-title">Pendiente - <span style="font-weight: 600">{{ $pendiente->titulo }}</span>   </h3>

                    @if($pendiente->op_finalizado == 0)
	  					<div class="flex gap-3 mt-2">
	  						<button id="finalizar_pendiente"  class="btn btn-success">Marcar como finalizado</button>
	 					</div>
 					@endif

				 <form method="post" id="form_pendiente" action="{{ route('taller.pendientefinalizado') }}" enctype="multipart/form-data">
				    @csrf
				    <input type="hidden" name="id" id="id" value="{{ $pendiente->id }}">
				 </form>

                </div>
                
                    <div class="card-body">
	                	<div class="row form-group">
                            <div class="col-lg-7">
                            	<div class="row"> 	
                            		<div class="col-lg-4"> 	
		                                <label>Prioridad</label>
		                                <div class="radio-inline">
		                                	@if($pendiente->prioridad == 0)
			                                    <label class="radio">
			                                        <input type="radio" checked name="prioridad" value="0" required />
			                                        <span></span>
			                                        Alta
			                                    </label>
		                                    @endif

		                                    @if($pendiente->prioridad == 1)
			                                    <label class="radio">
			                                        <input type="radio" name="prioridad" value="1" required />
			                                        <span></span>
			                                        Media
			                                    </label>
			                                @endif

			                                @if($pendiente->prioridad == 2)
			                                    <label class="radio">
			                                        <input type="radio" name="prioridad" value="2" required />
			                                        <span></span>
			                                        Baja
			                                    </label>
			                                @endif

		                                </div>
                            		</div>

                            		<div class="col-lg-4"> 	
	                    				<label>Fecha y hora inicio</label>
	                    				<span>{{ $pendiente->fecha_hora_inicio }}</span>
                            		</div>

                            		<div class="col-lg-4"> 	
	                    				<label>Fecha y hora final</label>
	                    				<span>{{ $pendiente->fecha_hora_final }}</span>
                            		</div>

                            	</div>

                            	<div class="row mt-2">	
                            		<div class="col-lg-12">	
                            			<span>{{ $pendiente->descripcion }}</span>
                            		</div>
                            	</div>

			                	<form class="form" action="{{ route('taller.pendienteevidencia') }}" method="post" id="frmPendiente" enctype="multipart/form-data">
			                    @csrf   
			                    	<input type="hidden" name="id_evidencia" value="{{ $pendiente->id }}">

	                                  <div class="row form-group mt-3">
	                                    <div class="col-lg-12" id="tblArchivos">
	                                        <table class='table table-bordered table-hover' id='tblDocumentos'>
	                                            <thead>
	                                            <tr>
	                                                <th>Adjuntar Documento</th>
	                                                <th>Nombre de Evidencia</th>
	                                                <th>Opción</th>
	                                            </tr>
	                                            </thead>
	                                            <tbody id='tbodyDocumentos'>
				                                    @foreach($evidencia as $documento)
				                                        <tr id="trDocumento{{ $documento->id }}">
				                                            <td><a href="{{ route('archivo.evidenciapendiente', ['id'=>$documento->id]) }}" class="link-primary" target="_blank"> Evidencia </a></td>
				                                            <td>{{ $documento->nombre_evidencia }}</td>
				                                        </tr>
				                                    @endforeach
	                                            </tbody>
	                                        </table>
	                                    </div>
	                                </div>

	                                @if($pendiente->op_finalizado != 1)
		                                <div class="row form-group">
		                                    <div class="col-lg-12">
		                                        <a href="#" class="btn btn-icon btn-outline-success btn-circle btn-sm mr-2 hrefAgregarOtro" data-toggle="tooltip" data-theme="dark" title="Agregar evidencia">
		                                            <i class="flaticon2-plus"></i>
		                                        </a>
		                                    </div>
		                                </div>


		                              	<div class="row">
		                              		<div class="col-lg-12 text-right">
		                              			<button type="button"  id="btnGuardar" class="btn btn-success"><i class="la la-plus"></i>Guardar</button>
		                              		</div>
		                              	</div>
	                              	@endif
                              </form>
                            </div>


                            <div class="col-lg-5">	
								<div class="card timeline-card">
								    <div class="card-header" style="padding: 0.3rem 1.25rem !important">
								        <h3 class="card-title">
								            Resumen
								        </h3>
								    </div>

								    <div class="card-body">

								        <div class="timeline">


								            <div class="timeline-item">

								                <div class="timeline-line"></div>

								                <div class="timeline-icon bg-warning">
								                    <i class="fas fa-exclamation"></i>
								                </div>

								                <div class="timeline-content">

								                    <div class="timeline-header">
								                        <span class="timeline-title">
								                            Pendiente
								                        </span>

								                        <span class="timeline-time">
								                            {{ $pendiente->created_at }}
								                        </span>
								                    </div>

								                    <div class="timeline-description">
								                        {{ $pendiente->userCreated->name }}
								                    </div>

								                    <div class="timeline-user">
								                        <span class="badge badge-light-warning">
								                         
								                        </span>
								                    </div>

								                </div>

								            </div>

								            @if($pendiente->op_finalizado == 1)
								            
								            <div class="timeline-item">

								                <div class="timeline-line"></div>

								                <div class="timeline-icon bg-success">
								                    <i class="fas fa-check"></i>
								                </div>

								                <div class="timeline-content">

								                    <div class="timeline-header">
								                        <span class="timeline-title">
								                            Completada
								                        </span>

								                        <span class="timeline-time">
								                            {{ $pendiente->updated_at }}
								                        </span>
								                    </div>

								                    <div class="timeline-description">
								                        {{ $pendiente->userUpdated->name }}
								                    </div>

								                </div>

								            </div>

								            @endif

								        </div>

								    </div>
								</div>
                            </div>

	                	</div>


                    </div>

                    <div class="card-footer">
                        <div class="row">
                            <div class="col-lg-6">
                                <a href="{{ route('tablero.show') }}"  class="btn btn-secondary"> <i class="la la-arrow-left"></i>Regresar</a>
                            </div>
                        </div>
                    </div>

            </div>
        </div>
    </div>



@endsection


