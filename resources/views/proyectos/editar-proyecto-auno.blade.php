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
				<p>${{ number_format($pro->presupuesto_minimo,2,'.',',') }}</p>
			</div>

			<div class="col-lg-6 {{($pro->contrato_op  == '0') ? 'oculto' : ''}} cerrado">
				<label>Monto del contrato</label>
				<p>${{ number_format($pro->importe_general,2,'.',',') }}</p>
			</div>


			<div class="col-lg-6 abierto {{($pro->contrato_op  == '1') ? 'oculto' : ''}}">
				<label>Monto máximo</label>
				<p>${{ number_format($pro->presupuesto_maximo,2,'.',',') }}</p>
			</div>
            <div class="col-lg-6 {{($pro->contrato_op == '0') ? 'oculto' : ''}} cerrado">
            	<label>Iva</label>
            	<p>${{ number_format($pro->iva,2,'.',',') }}</p>
            </div>
		</div>


    {{-- // END INFORMACION --}}

		<div class="row form-group">
			<div class="col-lg-6 mt-2">
				<label>Administrador de contrato</label>
				@foreach($emisores as $ub)
			        @if($ub->id == $pro->id_emisor)
			            <p>{{ $ub->razon_social }}</p>
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
{{-- 			<div class="col-lg-6">
				<label>Supervisor de Proyecto</label>
				@foreach($supervisores as $ub)
			        @if($ub->id == $pro->supervisor_proyecto)
			            <p>{{ strtoupper($ub->name)}}</p>
			        @endif
				@endforeach
			</div> --}}

            <div class="col-lg-4">
                <label>Supervisor de contrato</label>
                <select class="form-control" name="supervisor_proyecto[]" id="supervisor_proyecto" required>
                    <option value="">Selecciona una opción</option>
                    @foreach($supervisores as $ub)
                        <option value="{{ $ub->id}}" {{($ub->id == $pro->supervisor_proyecto) ? 'selected' : ''}}>
                            {{ strtoupper($ub->name)}}
                        </option>
                    @endforeach
                </select>
            </div>

			<div class="col-lg-4">
               	<label>Ejecutivo de cuenta de JetVan</label>
                <select class="form-control" name="id_responsable[]" id="id_responsable" required>
                    <option value="">Selecciona una opción </option>
                    @foreach($user as $ub)
                        <option value="{{ $ub->id}}" {{($ub->id == $pro->id_responsable) ? 'selected' : ''}}>
                            {{ strtoupper($ub->name)}}
                        </option>
                    @endforeach
                </select>
			</div>

            <div class="col-lg-4">
                <label>Unidades sustitutas</label>

                <select class="form-control" name="op_sustituto[]" id="op_sustituto" required>
                    <option value="">Selecciona una opción </option>
                    <option value="0" {{($pro->op_sustituto == 0) ? 'selected' : ''}}>Si</option>
                    <option value="1" {{($pro->op_sustituto == 1) ? 'selected' : ''}}>No</option>
                </select>

            </div>
		</div>



	@endforeach
