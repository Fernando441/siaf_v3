@extends('layouts.app')
@push('scripts')
	<script src="{{ asset('js/licitaciones/requisicion/finanzas/Agregardocumentacion.js') }}"></script>
	<meta name="csrf-token" content="{{ csrf_token() }}" />
@endpush
@section('title')
    Detalle de orden de compra
@endsection
@section('content')


<div class="card card-custom gutter-b">
	<div class="card-header">

			<h3 class="card-title">
				Detalle de orden de compra
				                                
			</h3>
            <div class="card-toolbar">
                <a href="{{ route('finanzas.verordenpendiente',[$requisicion_id,$orden_id]) }}" class="btn btn-light-primary font-weight-bolder mr-3 ml-3">Regresar</a>
            </div>
	</div>
	<input type='hidden' id='tipoArchivo' value='{{ $cadenaTipoDocumento }}'>
	<div class="card-body">
		<div class="row">
			<div class="col-lg-5">
				<div class="card card-custom gutter-b">
					<div class="card-header">
						<div class="card-title">
							<h3 class="card-label">
								Proveedor
							</h3>
						</div>
					</div>
					<div class="card-body">
						@foreach($or_prov as $prov)
                            <div class="row form-group">
                                <div class="col-lg-6">
                                    <label>Nombre del proveedor</label>
                                    <p>{{ $prov->proveedor->nombre }}</p>
                                </div>
                                <div class="col-lg-6">
                                    <label>Contacto</label>
                                    <p>{{ $prov->proveedor->contacto }}</p>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-lg-6">
                                    <label>Telefono</label>
                                    <p>{{ $prov->proveedor->telefono }}</p>
                                </div>
                                <div class="col-lg-6">
                                    <label>Correo electrónico</label>
                                    <p>{{ $prov->proveedor->correo }}</p>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-lg-6">
                                    <label>RFC</label>
                                    <p>{{ $prov->proveedor->rfc }}</p>
                                </div>
                                <div class="col-lg-6">
                                    <label>Dirección</label>
                                    <p>{{ $prov->proveedor->dirección }}</p>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-lg-12">
                                    <label>Convenio</label>
                                    <p>{{ $prov->proveedor->convenio }}</p>
                                </div>
                            </div>
                        @endforeach
					</div>
				</div>
			</div>
			<div class="col-lg-7">
				<div class="card card-custom gutter-b">
					<div class="card-header">
						<div class="card-title">
							<h3 class="card-label">
								Pago
							</h3>
						</div>
					</div>
					<div class="card-body">
                        <div class="row form-group">
                            <div class="col-lg-6">
                                <label>Forma de pago</label>
                                <p>{{ $prov->requisicionFormaPago->forma_pago }}</p>
                            </div>
                            <div class="col-lg-6">
                                <label>Método de pago</label>
                                <p>{{ $prov->requisicionMetodoPago->clave }} - {{ $prov->requisicionMetodoPago->metodo_pago }}</p>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-lg-6">
                                <label>Uso de CFDI</label>
                                <p>{{ $prov->uso_cfdi }} </p>
                            </div>
                        </div>

                        <div class="row form-group">
                        	<div class="col-lg-12 text-center">
                        		@foreach($or_prov as $prov)
                        			<span style="font-weight: bold; font-size: 26px;">${{ number_format($prov->precio_unitario,2,'.',',') }}</span>
                        		@endforeach
                        	</div>
                        </div>


					</div>
				</div>
			</div>
		</div>


		<div class="card card-custom gutter-b">
			<div class="card-header">
				<div class="card-title">
					<h3 class="card-label">
						Unidades por segmento
					</h3>
				</div>
			</div>
			<div class="card-body">
                <div class="row form-group">
                    <table class="table table-hover mb-6 table-responsive-sm">
                        <thead>
                            <tr>
                                <th>Cantidad</th>
                                <th>Tipo</th>
                                <th>Cilindros</th>
                                <th>Transmisión</th>
                                <th>Motor</th>
                            </tr>
                        </thead>
                        <tbody id='tbodyDocumentos_{{ $prov->id }}'>
                             @php $cons = 0; @endphp
                             @foreach($or_partidas as $partidas)
                                @if($prov->id == $partidas->requisicion_orden_proveedor_id)
                                    <tr id="trDocumento{{ $partidas->id }}">
                                        <td>{{ $partidas->cantidad }}</td>
                                        <td>{{ $partidas->segmento->segmentoTipoVehiculo->tipo_vehiculo }}</td>
                                        <td>{{ $partidas->segmento->segmentoTransmision->transmision }}</td>
                                        <td>{{ $partidas->segmento->segmentoNoCilindro->no_cilindro }} cilindros</td>
                                        <td>{{ $partidas->segmento->segmentoMotor->motor }}</td> 
                                    </tr>
                                @endif
                             @endforeach
                        </tbody>
                    </table>
                </div>
			</div>
		</div>

		<input type="hidden" id="documentoEliminarPath" value="{{ route('finanzas.eliminarevidenciaorden') }}">

		<form class="form" action="{{ route('finanzas.agregarevidenciaorden') }}" method="post" id="frmCliente" enctype="multipart/form-data">
        @csrf
			<div class="card card-custom gutter-b">
				<div class="card-header">
					<div class="card-title">
						<h3 class="card-label">
							Documentación
						</h3>
					</div>
				</div>
				<div class="card-body">
	                <input type="hidden" name="requisicion_id" value="{{ $requisicion_id }}">
	                <input type="hidden" name="orden_id" value="{{ $orden_id }}">
	                <input type="hidden" name="prov" value="{{ $rs_prov }}">
	                <div class="row form-group">
	                    <div class="col-lg-12" id="tblArchivos">
                            <table class="table table-hover mb-6 table-responsive-sm" id="tblDocumentos">
                                <thead>
                                <tr>
                                    <th scope="col">Documento</th>
                                    <th scope="col">Tipo de Documento</th>
                                    <th scope="col">Opción</th>
                                </tr>
                                </thead>
                                <tbody id='tbodyDocumentos'>
                                    @foreach($or_evidencias as $documento)
                                        <tr id="trDocumento{{ $documento->id }}">
                                            <td><a href="{{ route('archivo.documentoEvidenciaOrdenCompra', ['id'=>$documento->id]) }}" class="link-primary" target="_blank"> {{ $documento->documento }} </a></td>
                                            <td>{{ $documento->requisicionDocumentosCompra->tipo_documento }}</td>
                                            <td>
                                                <a href='#' class='btn btn-sm btn-clean btn-hover-icon-success btn-icon hrefEliminarDocumento' data-id='{{ $documento->id }}' data-documento='{{ $documento->documento }}'  data-toggle='tooltip' data-theme='dark' title='Eliminar'>
                                                    <i class='flaticon-delete'></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
	                    </div>
	                </div>

	                <div class="row form-group">
	                    <div class="col-lg-12">
	                        <a href="#"
	                          	class="btn btn-icon btn-outline-success btn-circle btn-sm mr-2 hrefAgregarOtro"
	                            data-toggle="tooltip" data-theme="dark" title="Agregar archivo">
	                            <i class="flaticon2-plus"></i>
	                        </a>
	                    </div>
	                </div>
				</div>
			</div>

            <div class="card-footer">
                <div class="row">
                    <div class="col-lg-9"></div>
                    <div class="col-lg-3">
                        <button type="button"  id="btnGuardar" class="btn btn-primary mr-2">Guardar documentos</button>
                    </div>
                </div>
            </div>
			
		</form>




		<div class="card card-custom gutter-b">
			<div class="card-header">
				<div class="card-title">
					<h3 class="card-label">
						Unidades compradas
					</h3>
				</div>
			</div>
			<div class="card-body">
                <div class="row form-group">
                	<a href="/layout/Carga Masiva Unidades.csv">Layout para la carga masiva</a>
                </div>

                <form action="{{ route('finanzas.cargamasivaexcel') }}" method="post" id="submit_carga" enctype="multipart/form-data">
                @csrf

                <input type="hidden" name="requisicion_id" value="{{ $requisicion_id }}">
                <input type="hidden" name="orden_id" value="{{ $orden_id }}">
                <input type="hidden" name="prov" value="{{ $rs_prov }}">
                <div class="row">
                    <div class="col-lg-12 mt-2 form-group">
                        <label>Carga Masiva de Unidades</label>
                        <div class='custom-file'>
                           <input type='file' class='custom-file-input' id='file_carga' name='file_carga' required />
                           <label class='custom-file-label' for='foto"+contadorFotografia+"'>Selecciona un archivo</label>
                        </div>
                    </div>
                </div>
                </form>

                <div class="row form-group">
                	<div class="col-lg-9"></div>
                	<div class="col-lg-3">
                		<button type="button" id="send_carga" class="btn btn-primary">Guardar unidades</button>
                	</div>
                </div>

					<table class="table table-hover mb-6 table-responsive-sm" id="kdatatable_unidades_compras">
					    <thead>
					        <tr>
					            <th>Folio</th>
					            <th>Marca</th>
					            <th>Modelo</th>
					            <th>Serie</th>
					            <th>Placa</th>
					            <th>Año</th>
					            <th>Forma Pago</th>
					            <th>Estatus pago</th>

					            <th>Accion</th>
					        </tr>
					    </thead>
					    <tbody id="">
					        @foreach($records as $unid)
					                <tr>
					                    <td>{{ $unid->folio }}</td>
					                    <td>{{ $unid->nombre_marca }}</td>
					                    <td>{{ $unid->nombre_modelo }}</td>
					                    <td>{{ $unid->no_serie }}</td>
					                    <td>{{ $unid->placa }}</td>
					                    <td>{{ $unid->unidad_year }}</td>
					                    <td> 
					                    	@if($unid->forma_compra == 1)
					                    		<span class="label font-weight-bold label-outline-success label-inline" style="width: 90px;">Contado</span> 
					                    	@else
					                    		<span class="label font-weight-bold label-outline-warning label-inline" style="width: 90px;">Credito</span> 
					                    	@endif
					                    </td>
					                    <td> 
					                    	@if($unid->estatus_pagado == 1)
					                    		<span class="label font-weight-bold label-outline-success label-inline" style="width: 90px;">Pagada</span> 
					                    	@else
					                    		<span class="label font-weight-bold label-outline-danger label-inline" style="width: 90px;">No Pagada</span> 
					                    	@endif
					                    </td>
					                    <td>
					                        <a href="{{ route('finanzas.editarunidadfinanzas',[$requisicion_id,$orden_id, $prov, $unid->id]) }}" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon" title="Ver unidad" data-theme="dark" data-toggle="tooltip" data-placement="top">
					                            <span class="svg-icon svg-icon-md">
					                                <i class="flaticon-eye"></i>
					                            </span>
					                        </a>
						                    @if($unid->op_equipamiento == 1)
								                <a href="{{ route('finanzas.efinanzasunidadfinanzas',[$requisicion_id,$orden_id, $prov, $unid->id]) }}" class="btn btn-sm btn-outline-success btn-icon mt-2" title="Ver unidad" data-theme="dark" data-toggle="tooltip" data-placement="top">
								                    <span class="svg-icon svg-icon-m ">
								                        <i class="flaticon2-gear"></i>
								                    </span>
								                </a>
					                        @endif
					                    </td>
					                </tr>
					        @endforeach
					    </tbody>
					</table>
			</div>
		</div>


	</div>
</div>


@endsection