

	@if($complemento_unidad == null)

			<div class="row">
				<div class="col-lg-6">
					<div class="form-group">
						<label>Número de GPS</label>
						<input type="text" class="form-control" name="num_gps" id="num_gps" value="" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
					</div>
					<div class="form-group">
						<label>Kilometraje</label>
						<input type="text" class="form-control" name="kilometraje" id="kilometraje" value="" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
					</div>
					<div class="form-group">
						<label>Marca de bateria</label>
						<input type="text" class="form-control" name="marca_bateria" id="marca_bateria" value="" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
					</div>
					<div class="form-group">
						<label>Marca de llantas</label>
						<input type="text" class="form-control" name="marca_llantas" id="marca_llantas"  value="" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
					</div>
					<div class="form-group">
						<label>Rin</label>
						<input type="text" class="form-control" name="rin" id="rin" value="" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
					</div>
					<div class="form-group">
						<label>Motor</label>
						<input type="text" class="form-control" name="motor" id="motor" value="" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
					</div>
					<div class="form-group">
						<label>Vestiduras</label>
						<input type="text" class="form-control" name="vestiduras" id="vestiduras" value="" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
					</div>
					<div class="form-group">
						<label>Llantas</label>
						<input type="text" class="form-control" name="llantas" id="llantas" value="" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
					</div>
				</div>

				<div class="col-lg-6">
					<div class="card card-custom gutter-b">
		 				<div class="card-header">
		  					<div class="card-title">
		   						<h3 class="card-label">
		    					<small>Extras</small>
		   						</h3>
		  					</div>
		 				</div>
		 				<div class="card-body">
							<div class="row form-group">
								<div class="col-lg-6 col-sm-6">
									<div class="form-group">
									    <label>LLanta de Refacción</label>
									    <div class="radio-inline">
									        <label class="radio">
									            <input type="radio" name="llanta_refaccion" checked value="Si"/>
									            <span></span>
									            Si
									        </label>
									        <label class="radio">
									            <input type="radio" name="llanta_refaccion"  value="No"/>
									            <span></span>
									            No
									        </label>
									    </div>
									</div>
								</div>
								<div class="col-lg-6 col-sm-6">
									<div class="form-group">
									    <label>Gato</label>
									    <div class="radio-inline">
									        <label class="radio">
									            <input type="radio" name="gato" checked value="Si"/>
									            <span></span>
									            Si
									        </label>
									        <label class="radio">
									            <input type="radio" name="gato"  value="No"/>
									            <span></span>
									            No
									        </label>
									    </div>
									</div>
								</div>
							</div>
							<div class="row form-group">
								<div class="col-lg-6 col-sm-6">
									<div class="form-group">
									    <label>Herramientas</label>
									    <div class="radio-inline">
									        <label class="radio">
									            <input type="radio" name="herramientas" checked value="Si"/>
									            <span></span>
									            Si
									        </label>
									        <label class="radio">
									            <input type="radio" name="herramientas"  value="No"/>
									            <span></span>
									            No
									        </label>
									    </div>
									</div>
								</div>
								<div class="col-lg-6 col-sm-6">
									<div class="form-group">
									    <label>Espejo Retrovisor</label>
									    <div class="radio-inline">
									        <label class="radio">
									            <input type="radio" name="espejo_retrovisor" checked value="Si"/>
									            <span></span>
									            Si
									        </label>
									        <label class="radio">
									            <input type="radio" name="espejo_retrovisor"  value="No"/>
									            <span></span>
									            No
									        </label>
									    </div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-6 col-sm-6">
									<div class="form-group">
									    <label>Funciona motor</label>
									    <div class="radio-inline">
									        <label class="radio">
									            <input type="radio" name="funciona_motor" checked value="Si"/>
									            <span></span>
									            Si
									        </label>
									        <label class="radio">
									            <input type="radio" name="funciona_motor"  value="No"/>
									            <span></span>
									            No
									        </label>
									    </div>
									</div>
								</div>
								<div class="col-lg-6 col-sm-6">
									<div class="form-group">
									    <label>Llaves vehículo</label>
									    <div class="radio-inline">
									        <label class="radio">
									            <input type="radio" name="llaves_vehiculo" checked value="Si"/>
									            <span></span>
									            Si
									        </label>
									        <label class="radio">
									            <input type="radio" name="llaves_vehiculo"  value="No"/>
									            <span></span>
									            No
									        </label>
									    </div>
									</div>
								</div>
							</div>
							<div class="row form-group">
								<div class="col-lg-6 col-sm-6">
									<div class="form-group">
									    <label>Radio</label>
									    <div class="radio-inline">
									        <label class="radio">
									            <input type="radio" name="radio" checked value="Si"/>
									            <span></span>
									            Si
									        </label>
									        <label class="radio">
									            <input type="radio" name="radio"  value="No"/>
									            <span></span>
									            No
									        </label>
									    </div>
									</div>
								</div>
								<div class="col-lg-6 col-sm-6">
									<div class="form-group">
									    <label>Bocinas</label>
									    <div class="radio-inline">
									        <label class="radio">
									            <input type="radio" name="bocinas" checked value="Si"/>
									            <span></span>
									            Si
									        </label>
									        <label class="radio">
									            <input type="radio" name="bocinas"  value="No"/>
									            <span></span>
									            No
									        </label>
									    </div>
									</div>
								</div>
							</div>
							<div class="row form-group">
								<div class="col-lg-6 col-sm-6">
									<div class="form-group">
									    <label>Aire Acondicionado</label>
									    <div class="radio-inline">
									        <label class="radio">
									            <input type="radio" name="aire_acondicionado" checked value="Si"/>
									            <span></span>
									            Si
									        </label>
									        <label class="radio">
									            <input type="radio" name="aire_acondicionado"  value="No"/>
									            <span></span>
									            No
									        </label>
									    </div>
									</div>
								</div>
								<div class="col-lg-6 col-sm-6">
									<div class="form-group">
									    <label>Birlos</label>
									    <div class="radio-inline">
									        <label class="radio">
									            <input type="radio" name="birlos" checked value="Si"/>
									            <span></span>
									            Si
									        </label>
									        <label class="radio">
									            <input type="radio" name="birlos"  value="No"/>
									            <span></span>
									            No
									        </label>
									    </div>
									</div>
								</div>
							</div>
							<div class="row form-group">
								<div class="col-lg-6 col-sm-6">
									<div class="form-group">
									    <label>Tapetes</label>
									    <div class="radio-inline">
									        <label class="radio">
									            <input type="radio" name="tapetes" checked value="Si"/>
									            <span></span>
									            Si
									        </label>
									        <label class="radio">
									            <input type="radio" name="tapetes" value="No"/>
									            <span></span>
									            No
									        </label>
									    </div>
									</div>
								</div>
								<div class="col-lg-6 col-sm-6">
									<div class="form-group">
									    <label>Señalizaciones</label>
									    <div class="radio-inline">
									        <label class="radio">
									            <input type="radio" name="senalizaciones" checked value="Si"/>
									            <span></span>
									            Si
									        </label>
									        <label class="radio">
									            <input type="radio" name="senalizaciones" value="No"/>
									            <span></span>
									            No
									        </label>
									    </div>
									</div>
								</div>
							</div>
		 				</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-lg-6">
					<div class="form-group">
						<label>Pintura</label>
						<input type="text" class="form-control" name="pintura" id="pintura" value="" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="form-group">
						<label>Conteo_niv</label>
						<input type="text" class="form-control" name="conteo_niv" id="conteo_niv" value="" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-lg-6">
					<div class="form-group">
						<label>Conteo_year</label>
						<input type="text" class="form-control" name="conteo_year" id="conteo_year" value="" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="form-group">
						<label>Rango Km</label>
						<input type="text" class="form-control" name="rango_km" id="rango_km" value="" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-lg-6">
					<div class="form-group">
						<label>Registro Repuve</label>
						<input type="text" class="form-control" name="registro_repuve" id="registro_repuve" value="" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="form-group">
						<label>Fecha de ingreso</label>
						<input type="text" class="form-control" name="fecha_ingreso" id="fecha_ingreso" value="" readonly />
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-lg-6">
					<div class="form-group">
						<label>Fecha de salida</label>
						<input type="text" class="form-control" name="fecha_salida" id="fecha_salida" value="" readonly />
					</div>
				</div>
				<div class="col-lg-6">
					<div class="form-group">
						<label>Observaciones</label>
						<textarea class="form-control" name="observaciones" aria-label="With textarea" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"></textarea>
					</div>
				</div>
			</div>



	@else
	
			<div class="row">
				<div class="col-lg-6">
					<div class="form-group">
						<label>Número de GPS</label>
						<input type="text" class="form-control" name="num_gps" id="num_gps" value="{{ $complemento_unidad->num_gps }}" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
					</div>
					<div class="form-group">
						<label>Kilometraje</label>
						<input type="text" class="form-control" name="kilometraje" id="kilometraje" value="{{ $complemento_unidad->kilometraje }}" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
					</div>
					<div class="form-group">
						<label>Marca de bateria</label>
						<input type="text" class="form-control" name="marca_bateria" id="marca_bateria" value="{{ $complemento_unidad->marca_bateria }}" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
					</div>
					<div class="form-group">
						<label>Marca de llantas</label>
						<input type="text" class="form-control" name="marca_llantas" id="marca_llantas"  value="{{ $complemento_unidad->marca_llantas }}" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
					</div>
					<div class="form-group">
						<label>Rin</label>
						<input type="text" class="form-control" name="rin" id="rin" value="{{ $complemento_unidad->rin }}" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
					</div>
					<div class="form-group">
						<label>Motor</label>
						<input type="text" class="form-control" name="motor" id="motor" value="{{ $complemento_unidad->motor }}" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
					</div>
					<div class="form-group">
						<label>Vestiduras</label>
						<input type="text" class="form-control" name="vestiduras" id="vestiduras" value="{{ $complemento_unidad->vestiduras }}" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
					</div>
					<div class="form-group">
						<label>Llantas</label>
						<input type="text" class="form-control" name="llantas" id="llantas" value="{{ $complemento_unidad->llantas }}" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
					</div>
				</div>

				<div class="col-lg-6">
					<div class="card card-custom gutter-b">
		 				<div class="card-header">
		  					<div class="card-title">
		   						<h3 class="card-label">
		    					<small>Extras</small>
		   						</h3>
		  					</div>
		 				</div>
		 				<div class="card-body">
							<div class="row form-group">
								<div class="col-lg-6 col-sm-6">
									<div class="form-group">
									    <label>LLanta de Refacción</label>
									    <div class="radio-inline">
									        <label class="radio">
									            <input type="radio" name="llanta_refaccion" {{($complemento_unidad->llanta_refaccion == 'Si') ? 'checked' : ''}} value="Si"/>
									            <span></span>
									            Si
									        </label>
									        <label class="radio">
									            <input type="radio" name="llanta_refaccion" {{($complemento_unidad->llanta_refaccion == 'No') ? 'checked' : ''}} value="No"/>
									            <span></span>
									            No
									        </label>
									    </div>
									</div>
								</div>
								<div class="col-lg-6 col-sm-6">
									<div class="form-group">
									    <label>Gato</label>
									    <div class="radio-inline">
									        <label class="radio">
									            <input type="radio" name="gato" {{($complemento_unidad->gato == 'Si') ? 'checked' : ''}} value="Si"/>
									            <span></span>
									            Si
									        </label>
									        <label class="radio">
									            <input type="radio" name="gato" {{($complemento_unidad->gato == 'No') ? 'checked' : ''}} value="No"/>
									            <span></span>
									            No
									        </label>
									    </div>
									</div>
								</div>
							</div>
							<div class="row form-group">
								<div class="col-lg-6 col-sm-6">
									<div class="form-group">
									    <label>Herramientas</label>
									    <div class="radio-inline">
									        <label class="radio">
									            <input type="radio" name="herramientas" {{($complemento_unidad->herramientas == 'Si') ? 'checked' : ''}} value="Si"/>
									            <span></span>
									            Si
									        </label>
									        <label class="radio">
									            <input type="radio" name="herramientas" {{($complemento_unidad->herramientas == 'No') ? 'checked' : ''}} value="No"/>
									            <span></span>
									            No
									        </label>
									    </div>
									</div>
								</div>
								<div class="col-lg-6 col-sm-6">
									<div class="form-group">
									    <label>Espejo Retrovisor</label>
									    <div class="radio-inline">
									        <label class="radio">
									            <input type="radio" name="espejo_retrovisor" {{($complemento_unidad->espejo_retrovisor == 'Si') ? 'checked' : ''}} value="Si"/>
									            <span></span>
									            Si
									        </label>
									        <label class="radio">
									            <input type="radio" name="espejo_retrovisor" {{($complemento_unidad->espejo_retrovisor == 'No') ? 'checked' : ''}} value="No"/>
									            <span></span>
									            No
									        </label>
									    </div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-6 col-sm-6">
									<div class="form-group">
									    <label>Funciona motor</label>
									    <div class="radio-inline">
									        <label class="radio">
									            <input type="radio" name="funciona_motor" {{($complemento_unidad->funciona_motor == 'Si') ? 'checked' : ''}} value="Si"/>
									            <span></span>
									            Si
									        </label>
									        <label class="radio">
									            <input type="radio" name="funciona_motor" {{($complemento_unidad->funciona_motor == 'No') ? 'checked' : ''}} value="No"/>
									            <span></span>
									            No
									        </label>
									    </div>
									</div>
								</div>
								<div class="col-lg-6 col-sm-6">
									<div class="form-group">
									    <label>Llaves vehículo</label>
									    <div class="radio-inline">
									        <label class="radio">
									            <input type="radio" name="llaves_vehiculo" {{($complemento_unidad->llaves_vehiculo == 'Si') ? 'checked' : ''}} value="Si"/>
									            <span></span>
									            Si
									        </label>
									        <label class="radio">
									            <input type="radio" name="llaves_vehiculo" {{($complemento_unidad->llaves_vehiculo == 'No') ? 'checked' : ''}} value="No"/>
									            <span></span>
									            No
									        </label>
									    </div>
									</div>
								</div>
							</div>
							<div class="row form-group">
								<div class="col-lg-6 col-sm-6">
									<div class="form-group">
									    <label>Radio</label>
									    <div class="radio-inline">
									        <label class="radio">
									            <input type="radio" name="radio" {{($complemento_unidad->radio == 'Si') ? 'checked' : ''}} value="Si"/>
									            <span></span>
									            Si
									        </label>
									        <label class="radio">
									            <input type="radio" name="radio" {{($complemento_unidad->radio == 'No') ? 'checked' : ''}} value="No"/>
									            <span></span>
									            No
									        </label>
									    </div>
									</div>
								</div>
								<div class="col-lg-6 col-sm-6">
									<div class="form-group">
									    <label>Bocinas</label>
									    <div class="radio-inline">
									        <label class="radio">
									            <input type="radio" name="bocinas" {{($complemento_unidad->bocinas == 'Si') ? 'checked' : ''}} value="Si"/>
									            <span></span>
									            Si
									        </label>
									        <label class="radio">
									            <input type="radio" name="bocinas" {{($complemento_unidad->bocinas == 'No') ? 'checked' : ''}} value="No"/>
									            <span></span>
									            No
									        </label>
									    </div>
									</div>
								</div>
							</div>
							<div class="row form-group">
								<div class="col-lg-6 col-sm-6">
									<div class="form-group">
									    <label>Aire Acondicionado</label>
									    <div class="radio-inline">
									        <label class="radio">
									            <input type="radio" name="aire_acondicionado" {{($complemento_unidad->aire_acondicionado == 'Si') ? 'checked' : ''}} value="Si"/>
									            <span></span>
									            Si
									        </label>
									        <label class="radio">
									            <input type="radio" name="aire_acondicionado" {{($complemento_unidad->aire_acondicionado == 'No') ? 'checked' : ''}} value="No"/>
									            <span></span>
									            No
									        </label>
									    </div>
									</div>
								</div>
								<div class="col-lg-6 col-sm-6">
									<div class="form-group">
									    <label>Birlos</label>
									    <div class="radio-inline">
									        <label class="radio">
									            <input type="radio" name="birlos" {{($complemento_unidad->birlos == 'Si') ? 'checked' : ''}} value="Si"/>
									            <span></span>
									            Si
									        </label>
									        <label class="radio">
									            <input type="radio" name="birlos" {{($complemento_unidad->birlos == 'No') ? 'checked' : ''}} value="No"/>
									            <span></span>
									            No
									        </label>
									    </div>
									</div>
								</div>
							</div>
							<div class="row form-group">
								<div class="col-lg-6 col-sm-6">
									<div class="form-group">
									    <label>Tapetes</label>
									    <div class="radio-inline">
									        <label class="radio">
									            <input type="radio" name="tapetes" {{($complemento_unidad->tapetes == 'Si') ? 'checked' : ''}} value="Si"/>
									            <span></span>
									            Si
									        </label>
									        <label class="radio">
									            <input type="radio" name="tapetes" {{($complemento_unidad->tapetes == 'No') ? 'checked' : ''}} value="No"/>
									            <span></span>
									            No
									        </label>
									    </div>
									</div>
								</div>
								<div class="col-lg-6 col-sm-6">
									<div class="form-group">
									    <label>Señalizaciones</label>
									    <div class="radio-inline">
									        <label class="radio">
									            <input type="radio" name="senalizaciones" {{($complemento_unidad->senalizaciones == 'Si') ? 'checked' : ''}} value="Si"/>
									            <span></span>
									            Si
									        </label>
									        <label class="radio">
									            <input type="radio" name="senalizaciones" {{($complemento_unidad->senalizaciones == 'No') ? 'checked' : ''}} value="No"/>
									            <span></span>
									            No
									        </label>
									    </div>
									</div>
								</div>
							</div>
		 				</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-lg-6">
					<div class="form-group">
						<label>Pintura</label>
						<input type="text" class="form-control" name="pintura" id="pintura" value="{{ $complemento_unidad->pintura }}" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="form-group">
						<label>Conteo_niv</label>
						<input type="text" class="form-control" name="conteo_niv" id="conteo_niv" value="{{ $complemento_unidad->conteo_niv }}" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-lg-6">
					<div class="form-group">
						<label>Conteo_year</label>
						<input type="text" class="form-control" name="conteo_year" id="conteo_year" value="{{ $complemento_unidad->conteo_year }}" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="form-group">
						<label>Rango Km</label>
						<input type="text" class="form-control" name="rango_km" id="rango_km" value="{{ $complemento_unidad->rango_km }}" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-lg-6">
					<div class="form-group">
						<label>Registro Repuve</label>
						<input type="text" class="form-control" name="registro_repuve" id="registro_repuve" value="{{ $complemento_unidad->registro_repuve }}" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="form-group">
						<label>Fecha de ingreso</label>
						<input type="text" class="form-control" name="fecha_ingreso" id="fecha_ingreso" value="{{ $complemento_unidad->fecha_ingreso }}" readonly />
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-lg-6">
					<div class="form-group">
						<label>Fecha de salida</label>
						<input type="text" class="form-control" name="fecha_salida" id="fecha_salida" value="{{ $complemento_unidad->fecha_salida }}" readonly />
					</div>
				</div>
				<div class="col-lg-6">
					<div class="form-group">
						<label>Observaciones</label>
						<textarea class="form-control" name="observaciones" aria-label="With textarea" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">{{ $complemento_unidad->observaciones }}</textarea>
					</div>
				</div>
			</div>
	@endif

