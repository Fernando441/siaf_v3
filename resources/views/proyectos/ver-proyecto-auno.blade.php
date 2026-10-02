<style type="text/css">
	.oculto{display: none;}
</style>
    	<input type="hidden" id="proyecto_id" name="id" value="{{ $pro->id }}">
    	{{-- <input type="hidden" name="licitacion" id="licitacion_edit" value="{{ $op }}"> --}}
    	<input type="hidden" name="id_proyecto[]" value="{{ $pro->id }}">
    	@foreach($info_licitacion as $lic) 	
	    	<div class="row form-group">
	    		<div class="col-lg-6">
	                <label>Folio del concurso</label>
	                <p>{{ $lic->folio }}</p>
	                <input type="hidden" name="licitacion" value="{{ $lic->id }}">
	    		</div>

	    		<div class="col-lg-6">
	                <label>No. Concurso</label>
	                <p>{{ $lic->no_licitacion }}</p>
	    		</div>
	    	</div>

                                            @if($pro->convenio_op == 1)

                                            @else
                                                <input type="hidden"  name="convenio_op" value="2">
                                                <div class="row form-group">
                                                    <div class="col-lg-6">
                                                        <label>No. Convenio</label>
                                                        <p>{{ $pro->no_convenio}}</p>
                                                        <input type="hidden" class="form-control" name="no_convenio" value="{{ $pro->no_convenio }}">
                                                    </div>
                      
                                                    <div class="col-lg-6">
                                                        <label>Modificaciones al contrato original</label>
                                                        <p>{{ $pro->proyectoModificacionConvenio->nombre_modificacion }}</p>
                                                    </div>
                                                </div>
                                            @endif


            <div class="row form-group">
                <div class="col-lg-6">
                    <label>Cliente</label>
                    <p>{{ $lic->razon_social }}</p>
                    <input type="hidden" name="id_cliente" value="{{ $lic->cliente }}">
                </div>
                <div class="col-lg-6">
                    <label>Título del servicio</label>
                    <p>{{ $lic->titulo_servicio }}</p>
                    <input type="hidden" name="titulo_servicio" value="{{ $lic->titulo_servicio }}">
                </div>
            </div>

            <div class="row form-group">
                <div class="col-lg-6">
                    <label>Tipo de contratación</label>
                    <p>{{ $lic->tipo_contratacion }}</p>
                    <input type="hidden" name="id_contrato" value="{{ $lic->contratacion }}">
                </div>

                <div class="col-lg-6">
                    <label>Prioridad</label>
                    @if($lic->id_licitacion_prioridad == 1)
                        <p><span class="label font-weight-bold label-outline-danger label-inline" >Alta</span></p>
                    @endif
                    @if($lic->id_licitacion_prioridad == 2)
                        <p><span class="label font-weight-bold label-outline-warning label-inline" >Media</span></p>
                    @endif
                    @if($lic->id_licitacion_prioridad == 3)
                        <p><span class="label font-weight-bold label-outline-primary label-inline" >Baja</span></p>
                    @endif
                </div>
            </div>
    	

        <div class="row form-group">
                <div class="col-lg-6">
                    <label>Id contrato</label>
                    <p>{{ $pro->id_contrato }}</p>
                </div>

            <div class="col-lg-6">
                <label>No. Contrato</label>
                <p>{{ $pro->no_contrato }}</p>
            </div>
        </div>

        <div class="row form-group">

            <div class="col-lg-6">
                <label>Fuente del proyecto</label>
				@foreach($fuente as $ub)
			        @if($ub->id == $pro->fuente_proyecto)
			           	<p>{{ strtoupper($ub->fuente_proyecto)}}</p>
			        @endif
				@endforeach
            </div>

            <div class="col-lg-6">
                <label>Fecha inicio de vigencia</label>
                <p>{{ date('d/m/Y', strtotime($pro->firma_inicio_vigencia))}}</p>
            </div>
        </div>

		<div class="row form-group">
            <div class="col-lg-6">
                <label>Fecha final de vigencia</label>
                <p>{{ date('d/m/Y', strtotime($pro->firma_final_vigencia))}}</p>
            </div>

            <div class="col-lg-6">
                <div class="form-group">
                    <label>Tipo de contrato</label>
                    <div class="radio-inline">
                    	@if($pro->contrato_op == '0')
	                        <label class="radio">
	                            <input type="radio" name="contrato_op{{ $pro->id }}" {{($pro->contrato_op == '0') ? 'checked' : ''}} id="tp1" checked value="0"/>
	                            <span></span>
	                            Contrato Abierto
	                        </label>
                    	@else
	                        <label class="radio">
	                            <input type="radio" name="contrato_op{{ $pro->id }}" {{($pro->contrato_op == '1') ? 'checked' : ''}} id="tp2" value="1"/>
	                            <span></span>
	                            Contrato Cerrado
	                        </label>
                    	@endif
                    </div>
                </div>
            </div>
		</div>

		<div class="form-group row">
			<div class="col-lg-6 abierto {{($pro->contrato_op  == '1') ? 'oculto' : ''}}">
				<label>Monto mínimo</label>
				<p>{{ $pro->presupuesto_minimo }}</p>
			</div>

			<div class="col-lg-6 {{($pro->contrato_op  == '0') ? 'oculto' : ''}} cerrado">
				<label>Importe general</label>
				<p>{{ $pro->importe_general }}</p>
			</div>


			<div class="col-lg-6 abierto {{($pro->contrato_op  == '1') ? 'oculto' : ''}}">
				<label>Monto máximo</label>
				<p>{{ $pro->presupuesto_maximo }}</p>
			</div>
            <div class="col-lg-6 {{($pro->contrato_op == '0') ? 'oculto' : ''}} cerrado">
            	<label>Iva</label>
            	<p>{{ $pro->iva }}</p>
            </div>
		</div>


    {{-- // END INFORMACION --}}

		<div class="row form-group">
			<div class="col-lg-6 mt-2">
				<label>Administrador de contrato</label>
				@foreach($emisores as $ub)
					@if($ub->id == $pro->id_emisor)
						<p>{{ strtoupper($ub->razon_social)}}</p>
					@endif
				@endforeach
			</div>

			<div class="col-lg-6">
				<label>Administrador del contrato por parte del cliente</label>
				<p>{{ $pro->nombre_administrativo }}</p>
			</div>
		</div>

		<div class="row form-group">

			<div class="col-lg-6">
				<label>Teléfonos del contacto administrativo del cliente</label>
				<p>{{ $pro->telefono_administrativo }}</p>
			</div>

			<div class="col-lg-6">
				<label>Correo electrónico del contacto administrativo del cliente</label>
				<p>{{ $pro->correo_administrativo }}</p>
			</div>
		</div>

		<div class="row form-group">
			<div class="col-lg-6">
				<label>Supervisor de Proyecto</label>
				@foreach($supervisores as $ub)
					@if($ub->id == $pro->supervisor_proyecto)
			            <p>{{ strtoupper($ub->name)}}</p>
			        @endif
				@endforeach
			</div>


			<div class="col-lg-6">
				<label>Ejecutivo de cuenta de JetVan</label>
				@foreach($user as $ub)
					@if($ub->id == $pro->id_responsable)
			            <p>{{ strtoupper($ub->name)}}</p>
			        @endif
				@endforeach
			</div>

		</div>

	@endforeach
