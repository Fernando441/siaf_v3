	@if($complemento_unidad == null)
			<div class="row">
				<div class="col-lg-6">
					<div class="form-group">
						<label>Número de GPS</label>
						<p> -- </p>
					</div>
					<div class="form-group">
						<label>Kilometraje</label>
						<p> -- </p>
					</div>
					<div class="form-group">
						<label>Marca de bateria</label>
						<p> -- </p>
					</div>
					<div class="form-group">
						<label>Marca de llantas</label>
						<p> -- </p>
					</div>
					<div class="form-group">
						<label>Rin</label>
						<p> -- </p>
					</div>
					<div class="form-group">
						<label>Motor</label>
						<p> -- </p>
					</div>
					<div class="form-group">
						<label>Vestiduras</label>
						<p> -- </p>
					</div>
					<div class="form-group">
						<label>Llantas</label>
						<p> -- </p>
					</div>
					<div class="form-group">
						<label>Pintura</label>
						<p> -- </p>
					</div>
				</div>

				<div class="col-lg-6">
					<div class="card card-custom gutter-b">
		 				<div class="card-header">
		  					<div class="card-title">
		   						<h3 class="card-label">
		    					{{-- Basic Card --}}
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
									            <input type="radio" name="llanta_refaccion" disabled value="Si"/>
									            <span></span>
									            Si
									        </label>
									        <label class="radio">
									            <input type="radio" name="llanta_refaccion" disabled  value="No"/>
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
									            <input type="radio" name="gato" disabled value="Si"/>
									            <span></span>
									            Si
									        </label>
									        <label class="radio">
									            <input type="radio" name="gato" disabled  value="No"/>
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
									            <input type="radio" name="herramientas" disabled value="Si"/>
									            <span></span>
									            Si
									        </label>
									        <label class="radio">
									            <input type="radio" name="herramientas" disabled  value="No"/>
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
									            <input type="radio" name="espejo_retrovisor" disabled value="Si"/>
									            <span></span>
									            Si
									        </label>
									        <label class="radio">
									            <input type="radio" name="espejo_retrovisor" disabled value="No"/>
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
									            <input type="radio" name="funciona_motor" disabled value="Si"/>
									            <span></span>
									            Si
									        </label>
									        <label class="radio">
									            <input type="radio" name="funciona_motor" disabled value="No"/>
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
									            <input type="radio" name="llaves_vehiculo" disabled value="Si"/>
									            <span></span>
									            Si
									        </label>
									        <label class="radio">
									            <input type="radio" name="llaves_vehiculo" disabled value="No"/>
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
									            <input type="radio" name="radio" disabled value="Si"/>
									            <span></span>
									            Si
									        </label>
									        <label class="radio">
									            <input type="radio" name="radio" disabled value="No"/>
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
									            <input type="radio" name="bocinas" disabled value="Si"/>
									            <span></span>
									            Si
									        </label>
									        <label class="radio">
									            <input type="radio" name="bocinas" disabled value="No"/>
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
									            <input type="radio" name="aire_acondicionado" disabled value="Si"/>
									            <span></span>
									            Si
									        </label>
									        <label class="radio">
									            <input type="radio" name="aire_acondicionado" disabled value="No"/>
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
									            <input type="radio" name="birlos" disabled value="Si"/>
									            <span></span>
									            Si
									        </label>
									        <label class="radio">
									            <input type="radio" name="birlos" disabled value="No"/>
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
									            <input type="radio" name="tapetes" disabled value="Si"/>
									            <span></span>
									            Si
									        </label>
									        <label class="radio">
									            <input type="radio" name="tapetes" disabled value="No"/>
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
									            <input type="radio" name="senalizaciones" disabled value="Si"/>
									            <span></span>
									            Si
									        </label>
									        <label class="radio">
									            <input type="radio" name="senalizaciones" disabled value="No"/>
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
						<label>Conteo_niv</label>
						<p> -- </p>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="form-group">
						<label>Conteo_year</label>
						<p> -- </p>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-lg-6">
					<div class="form-group">
						<label>Rango Km</label>
						<p> -- </p>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="form-group">
						<label>Registro Repuve</label>
						<p> -- </p>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-lg-6">
					<div class="form-group">
						<label>Fecha de ingreso</label>
						<p> -- </p>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="form-group">
						<label>Fecha de salida</label>
						<p> -- </p>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-lg-12">
				<div class="form-group">
					<label>Observaciones</label>
					<p> -- </p>
				</div>
				</div>
			</div>



	@else
	
			<div class="row">
				<div class="col-lg-6">
					<div class="form-group">
						<label>Número de GPS</label>
						<p>{{ $complemento_unidad->num_gps }}</p>
					</div>
					<div class="form-group">
						<label>Kilometraje</label>
						<p>{{ $complemento_unidad->kilometraje }}</p>
					</div>
					<div class="form-group">
						<label>Marca de bateria</label>
						<p>{{ $complemento_unidad->marca_bateria }}</p>
					</div>
					<div class="form-group">
						<label>Marca de llantas</label>
						<p>{{ $complemento_unidad->marca_llantas }}</p>
					</div>
					<div class="form-group">
						<label>Rin</label>
						<p>{{ $complemento_unidad->rin }}</p>
					</div>
					<div class="form-group">
						<label>Motor</label>
						<p>{{ $complemento_unidad->motor }}</p>
					</div>
					<div class="form-group">
						<label>Vestiduras</label>
						<p>{{ $complemento_unidad->vestiduras }}</p>
					</div>
					<div class="form-group">
						<label>Llantas</label>
						<p>{{ $complemento_unidad->llantas }}</p>
					</div>
					<div class="form-group">
						<label>Pintura</label>
						<p>{{ $complemento_unidad->pintura }}</p>
					</div>
				</div>

				<div class="col-lg-6">
					<div class="card card-custom gutter-b">
		 				<div class="card-header">
		  					<div class="card-title">
		   						<h3 class="card-label">
		    					{{-- Basic Card --}}
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
									            <input type="radio" name="llanta_refaccion" {{($complemento_unidad->llanta_refaccion == 'Si') ? 'checked' : ''}} disabled value="Si"/>
									            <span></span>
									            Si
									        </label>
									        <label class="radio">
									            <input type="radio" name="llanta_refaccion" {{($complemento_unidad->llanta_refaccion == 'No') ? 'checked' : ''}} disabled value="No"/>
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
									            <input type="radio" name="gato" {{($complemento_unidad->gato == 'Si') ? 'checked' : ''}} disabled value="Si"/>
									            <span></span>
									            Si
									        </label>
									        <label class="radio">
									            <input type="radio" name="gato" {{($complemento_unidad->gato == 'No') ? 'checked' : ''}} disabled value="No"/>
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
									            <input type="radio" name="herramientas" {{($complemento_unidad->herramientas == 'Si') ? 'checked' : ''}} disabled value="Si"/>
									            <span></span>
									            Si
									        </label>
									        <label class="radio">
									            <input type="radio" name="herramientas" {{($complemento_unidad->herramientas == 'No') ? 'checked' : ''}} disabled value="No"/>
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
									            <input type="radio" name="espejo_retrovisor" {{($complemento_unidad->espejo_retrovisor == 'Si') ? 'checked' : ''}} disabled value="Si"/>
									            <span></span>
									            Si
									        </label>
									        <label class="radio">
									            <input type="radio" name="espejo_retrovisor" {{($complemento_unidad->espejo_retrovisor == 'No') ? 'checked' : ''}} disabled value="No"/>
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
									            <input type="radio" name="funciona_motor" {{($complemento_unidad->funciona_motor == 'Si') ? 'checked' : ''}} disabled value="Si"/>
									            <span></span>
									            Si
									        </label>
									        <label class="radio">
									            <input type="radio" name="funciona_motor" {{($complemento_unidad->funciona_motor == 'No') ? 'checked' : ''}} disabled value="No"/>
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
									            <input type="radio" name="llaves_vehiculo" {{($complemento_unidad->llaves_vehiculo == 'Si') ? 'checked' : ''}} disabled value="Si"/>
									            <span></span>
									            Si
									        </label>
									        <label class="radio">
									            <input type="radio" name="llaves_vehiculo" {{($complemento_unidad->llaves_vehiculo == 'No') ? 'checked' : ''}} disabled value="No"/>
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
									            <input type="radio" name="radio" {{($complemento_unidad->radio == 'Si') ? 'checked' : ''}} disabled value="Si"/>
									            <span></span>
									            Si
									        </label>
									        <label class="radio">
									            <input type="radio" name="radio" {{($complemento_unidad->radio == 'No') ? 'checked' : ''}} disabled value="No"/>
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
									            <input type="radio" name="bocinas" {{($complemento_unidad->bocinas == 'Si') ? 'checked' : ''}} disabled value="Si"/>
									            <span></span>
									            Si
									        </label>
									        <label class="radio">
									            <input type="radio" name="bocinas" {{($complemento_unidad->bocinas == 'No') ? 'checked' : ''}} disabled value="No"/>
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
									            <input type="radio" name="aire_acondicionado" {{($complemento_unidad->aire_acondicionado == 'Si') ? 'checked' : ''}} disabled value="Si"/>
									            <span></span>
									            Si
									        </label>
									        <label class="radio">
									            <input type="radio" name="aire_acondicionado" {{($complemento_unidad->aire_acondicionado == 'No') ? 'checked' : ''}} disabled value="No"/>
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
									            <input type="radio" name="birlos" {{($complemento_unidad->birlos == 'Si') ? 'checked' : ''}} disabled value="Si"/>
									            <span></span>
									            Si
									        </label>
									        <label class="radio">
									            <input type="radio" name="birlos" {{($complemento_unidad->birlos == 'No') ? 'checked' : ''}} disabled value="No"/>
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
									            <input type="radio" name="tapetes" {{($complemento_unidad->tapetes == 'Si') ? 'checked' : ''}} disabled value="Si"/>
									            <span></span>
									            Si
									        </label>
									        <label class="radio">
									            <input type="radio" name="tapetes" {{($complemento_unidad->tapetes == 'No') ? 'checked' : ''}} disabled value="No"/>
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
									            <input type="radio" name="senalizaciones" {{($complemento_unidad->senalizaciones == 'Si') ? 'checked' : ''}} disabled value="Si"/>
									            <span></span>
									            Si
									        </label>
									        <label class="radio">
									            <input type="radio" name="senalizaciones" {{($complemento_unidad->senalizaciones == 'No') ? 'checked' : ''}} disabled value="No"/>
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
						<label>Conteo_niv</label>
						<p>{{ $complemento_unidad->conteo_niv }}</p>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="form-group">
						<label>Conteo_year</label>
						<p>{{ $complemento_unidad->conteo_year }}</p>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-lg-6">
					<div class="form-group">
						<label>Rango Km</label>
						<p>{{ $complemento_unidad->rango_km }}</p>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="form-group">
						<label>Registro Repuve</label>
						<p>{{ $complemento_unidad->registro_repuve }}</p>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-lg-6">
					<div class="form-group">
						<label>Fecha de ingreso</label>
						<p>{{ $complemento_unidad->fecha_ingreso }}</p>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="form-group">
						<label>Fecha de salida</label>
						<p>{{ $complemento_unidad->fecha_salida }}</p>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-lg-12">
				<div class="form-group">
					<label>Observaciones</label>
					<p>{{ $complemento_unidad->observaciones }}</p>
				</div>
				</div>
			</div>
	@endif