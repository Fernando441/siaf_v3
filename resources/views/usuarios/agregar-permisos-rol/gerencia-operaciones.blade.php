<div class="card card-custom mt-3">
  <div class="card-header sombra_card">
    <h3 class="card-title">Dirección de operaciones</h3>
    <div class="card-toolbar">
      <input type='checkbox' id='all_unidades_check'> Seleccionar Todos los permisos
    </div>
  </div>
  <div class="card-body">
    <div class="row">
      <div class="col-md-4">
        <ul class="nav nav-tabs nav-tabs-line">
          <li class="nav-item">
            <a class="nav-link unidad_tab" data-toggle="tab" href="#kt_tab_pane_3"><b>Parque Vehicular</b></a>
          </li>
        </ul>

        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade" id="kt_tab_pane_3" role="tabpanel">
              <div class="form-group">
                <input type="hidden" id="op_unidad" value="0">

                <div class="row">
                  <div class="col-md-4"></div>
                  <div class="col-md-8 oldcheck">
                    <input type='checkbox' id='all_unidad'> Seleccionar todos
                  </div>
                </div>

                @foreach($unidades as $value)
                  <div class="row mt-2">
                    <div class="col-md-8">
                      <label>{{ $value->guard_names }}</label>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <span class="switch switch-icon">
                        <label>
                        <input type="checkbox" name="permission[]" class='unidad_check all_unidades' value="{{ $value->id }}"> 
                        <span></span>
                        </label>
                        </span>
                      </div>
                    </div>
                  </div>
                                      
                @endforeach
              </div>
            </div>
        </div>
      </div>

      <div class="col-md-4">
        <ul class="nav nav-tabs nav-tabs-line">
          <li class="nav-item">
            <a class="nav-link ubicacion_tab" data-toggle="tab" href="#kt_tab_pane_6"><b>Patios</b></a>
          </li>
        </ul>

        <div class="tab-content" id="myTabContent">
          <div class="tab-pane fade" id="kt_tab_pane_6" role="tabpanel">
            <div class="form-group">
              <input type="hidden" id="op_ubicacion" value="0">
              <div class="row">
                <div class="col-md-4"></div>
                <div class="col-md-8 oldcheck">
                  <input type='checkbox' id='all_ubicacion'> Seleccionar todos
                </div>
              </div>

              @foreach($ubicaciones as $value)
                <div class="row mt-2">
                  <div class="col-md-8">
                    <label>{{ $value->guard_names }}</label>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <span class="switch switch-icon">
                      <label>
                      <input type="checkbox" name="permission[]" class='ubicacion_check all_unidades' value="{{ $value->id }}"> 
                      <span></span>
                      </label>
                      </span>
                    </div>
                  </div>
                </div>                   
              @endforeach
            </div>
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <ul class="nav nav-tabs nav-tabs-line">
          <li class="nav-item">
            <a class="nav-link asignacionunid_tab" data-toggle="tab" href="#kt_tab_pane_asignacionunid"><b>Asignación de unidades</b></a>
          </li>
        </ul>

        <div class="tab-content" id="myTabContent">
          <div class="tab-pane fade" id="kt_tab_pane_asignacionunid" role="tabpanel">
            <div class="form-group">
              <input type="hidden" id="op_asignacionunid" value="0">
              <div class="row">
                <div class="col-md-4"></div>
                <div class="col-md-8 oldcheck">
                  <input type='checkbox' id='all_asignacionunid'> Seleccionar todos
                </div>
              </div>

              @foreach($asignacionunidades as $value)
                <div class="row mt-2">
                  <div class="col-md-8">
                    <label>{{ $value->guard_names }}</label>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <span class="switch switch-icon">
                      <label>
                      <input type="checkbox" name="permission[]" class='asignacionunid_check all_unidades' value="{{ $value->id }}"> 
                      <span></span>
                      </label>
                      </span>
                    </div>
                  </div>
                </div>                   
              @endforeach
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row">

      <div class="col-md-4">
        <ul class="nav nav-tabs nav-tabs-line">
          <li class="nav-item">
            <a class="nav-link requnidasig_tab" data-toggle="tab" href="#kt_tab_pane_requnidasig"><b>Requisiciones</b></a>
          </li>
        </ul>

        <div class="tab-content" id="myTabContent">
          <div class="tab-pane fade" id="kt_tab_pane_requnidasig" role="tabpanel">
            <div class="form-group">
              <input type="hidden" id="op_requnidasig" value="0">
              <div class="row">
                <div class="col-md-4"></div>
                <div class="col-md-8 oldcheck">
                  <input type='checkbox' id='all_requnidasig'> Seleccionar todos
                </div>
              </div>

              @foreach($unid_req_asignacion as $value)
                <div class="row mt-2">
                  <div class="col-md-8">
                    <label>{{ $value->guard_names }}</label>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <span class="switch switch-icon">
                      <label>
                      <input type="checkbox" name="permission[]" class='requnidasig_check all_unidades' value="{{ $value->id }}"> 
                      <span></span>
                      </label>
                      </span>
                    </div>
                  </div>
                </div>                   
              @endforeach
            </div>
          </div>
        </div>
      </div>



      <div class="col-md-4">
        <ul class="nav nav-tabs nav-tabs-line">
          <li class="nav-item">
            <a class="nav-link mantenimiento_tab" data-toggle="tab" href="#kt_tab_pane_mantenimiento"><b>Mantenimiento</b></a>
          </li>
        </ul>

        <div class="tab-content" id="myTabContent">
          <div class="tab-pane fade" id="kt_tab_pane_mantenimiento" role="tabpanel">
            <div class="form-group">
              <input type="hidden" id="op_mantenimiento" value="0">
              <div class="row">
                <div class="col-md-4"></div>
                <div class="col-md-8 oldcheck">
                  <input type='checkbox' id='all_mantenimiento'> Seleccionar todos
                </div>
              </div>

              @foreach($mantenimientos as $value)
                <div class="row mt-2">
                  <div class="col-md-8">
                    <label>{{ $value->guard_names }}</label>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <span class="switch switch-icon">
                      <label>
                      <input type="checkbox" name="permission[]" class='mantenimiento_check all_unidades' value="{{ $value->id }}"> 
                      <span></span>
                      </label>
                      </span>
                    </div>
                  </div>
                </div>                   
              @endforeach
            </div>
          </div>
        </div>
      </div>
    </div>


    <div class="card card-custom gutter-b">
      <div class="card-header sombra_card_catalogo">
        <div class="card-title">
          <h3 class="card-label">
            Catalogos de dirección de operaciones
          </h3>
        </div>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-4">
            <ul class="nav nav-tabs nav-tabs-line">
              <li class="nav-item">
                <a class="nav-link marca_tab" data-toggle="tab" href="#kt_tab_pane_4">Marcas</a>
              </li>
            </ul>


            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade" id="kt_tab_pane_4" role="tabpanel">
                  <div class="form-group">
                    <input type="hidden" id="op_marca" value="0">

                    <div class="row">
                      <div class="col-md-4"></div>
                      <div class="col-md-8 oldcheck">
                        <input type='checkbox' id='all_marca'> Seleccionar todos
                      </div>
                    </div>

                    @foreach($marcas as $value)
                      <div class="row mt-2">
                        <div class="col-md-8">
                          <label>{{ $value->guard_names }}</label>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <span class="switch switch-icon">
                            <label>
                            <input type="checkbox" name="permission[]" class='marca_check all_unidades' value="{{ $value->id }}"> 
                            <span></span>
                            </label>
                            </span>
                          </div>
                        </div>
                      </div>                
                    @endforeach
                  </div>
                </div>
            </div>
          </div>

          <div class="col-md-4">
            <ul class="nav nav-tabs nav-tabs-line">
              <li class="nav-item">
                <a class="nav-link modelo_tab" data-toggle="tab" href="#kt_tab_pane_5">Modelo</a>
              </li>
            </ul>

            <div class="tab-content" id="myTabContent">
              <div class="tab-pane fade" id="kt_tab_pane_5" role="tabpanel">
                <div class="form-group">
                  <input type="hidden" id="op_modelo" value="0">
                  <div class="row">
                    <div class="col-md-4"></div>
                    <div class="col-md-8 oldcheck">
                      <input type='checkbox' id='all_modelo'> Seleccionar todos
                    </div>
                  </div>

                  @foreach($modelos as $value)
                    <div class="row mt-2">
                      <div class="col-md-8">
                        <label>{{ $value->guard_names }}</label>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <span class="switch switch-icon">
                          <label>
                          <input type="checkbox" name="permission[]" class='modelo_check all_unidades' value="{{ $value->id }}"> 
                          <span></span>
                          </label>
                          </span>
                        </div>
                      </div>
                    </div>
                                          
                  @endforeach
                </div>
              </div>
            </div>
          </div>


          <div class="col-md-4">
            <ul class="nav nav-tabs nav-tabs-line">
              <li class="nav-item">
                <a class="nav-link tipovehiculo_tab" data-toggle="tab" href="#kt_tab_pane_12">Tipo de vehículo</a>
              </li>
            </ul>

            <div class="tab-content" id="myTabContent">
              <div class="tab-pane fade" id="kt_tab_pane_12" role="tabpanel">
                <div class="form-group">
                  <input type="hidden" id="op_tipovehiculo" value="0">

                  <div class="row">
                    <div class="col-md-4"></div>
                    <div class="col-md-8 oldcheck">
                      <input type='checkbox' id='all_tipovehiculo'> Seleccionar todos
                    </div>
                  </div>

                  @foreach($tipovehiculo as $value)
                    <div class="row mt-2">
                      <div class="col-md-8">
                        <label>{{ $value->guard_names }}</label>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <span class="switch switch-icon">
                          <label>
                          <input type="checkbox" name="permission[]" class='tipovehiculo_check all_unidades' value="{{ $value->id }}"> 
                          <span></span>
                          </label>
                          </span>
                        </div>
                      </div>
                    </div>
                                          
                  @endforeach
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="row"> 
          <div class="col-md-4">
            <ul class="nav nav-tabs nav-tabs-line">
              <li class="nav-item">
                <a class="nav-link estatus_tab" data-toggle="tab" href="#kt_tab_pane_7">Estatus</a>
              </li>
            </ul>

            <div class="tab-content" id="myTabContent">
              <div class="tab-pane fade" id="kt_tab_pane_7" role="tabpanel">
                <div class="form-group">
                  <input type="hidden" id="op_estatus" value="0">

                  <div class="row">
                    <div class="col-md-4"></div>
                    <div class="col-md-8 oldcheck">
                      <input type='checkbox' id='all_estatus'> Seleccionar todos
                    </div>
                  </div>

                  @foreach($estatus as $value)
                    <div class="row mt-2">
                      <div class="col-md-8">
                        <label>{{ $value->guard_names }}</label>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <span class="switch switch-icon">
                          <label>
                          <input type="checkbox" name="permission[]" class='estatus_check all_unidades' value="{{ $value->id }}"> 
                          <span></span>
                          </label>
                          </span>
                        </div>
                      </div>
                    </div>                  
                  @endforeach
                </div>
              </div>
            </div>
          </div>

          <div class="col-md-4">
            <ul class="nav nav-tabs nav-tabs-line">
              <li class="nav-item">
                <a class="nav-link aseguradora_tab" data-toggle="tab" href="#kt_tab_pane_8">Aseguradoras</a>
              </li>
            </ul>

            <div class="tab-content" id="myTabContent">
              <div class="tab-pane fade" id="kt_tab_pane_8" role="tabpanel">
                <div class="form-group">
                  <input type="hidden" id="op_aseguradora" value="0">

                  <div class="row">
                    <div class="col-md-4"></div>
                    <div class="col-md-8 oldcheck">
                      <input type='checkbox' id='all_aseguradora'> Seleccionar todos
                    </div>
                  </div>

                  @foreach($aseguradoras as $value)
                    <div class="row mt-2">
                      <div class="col-md-8">
                        <label>{{ $value->guard_names }}</label>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <span class="switch switch-icon">
                          <label>
                          <input type="checkbox" name="permission[]" class='aseguradora_check all_unidades' value="{{ $value->id }}"> 
                          <span></span>
                          </label>
                          </span>
                        </div>
                      </div>
                    </div>
                                          
                  @endforeach
                </div>
              </div>
            </div>
          </div>

          <div class="col-md-4">
            <ul class="nav nav-tabs nav-tabs-line">
              <li class="nav-item">
                <a class="nav-link agencia_tab" data-toggle="tab" href="#kt_tab_pane_13">Agencias de vehículos</a>
              </li>
            </ul>

            <div class="tab-content" id="myTabContent">
              <div class="tab-pane fade" id="kt_tab_pane_13" role="tabpanel">
                <div class="form-group">
                  <input type="hidden" id="op_agencia" value="0">

                  <div class="row">
                    <div class="col-md-4"></div>
                    <div class="col-md-8 oldcheck">
                      <input type='checkbox' id='all_agencia'> Seleccionar todos
                    </div>
                  </div>

                  @foreach($agencia as $value)
                    <div class="row mt-2">
                      <div class="col-md-8">
                        <label>{{ $value->guard_names }}</label>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <span class="switch switch-icon">
                          <label>
                          <input type="checkbox" name="permission[]" class='agencia_check all_unidades' value="{{ $value->id }}"> 
                          <span></span>
                          </label>
                          </span>
                        </div>
                      </div>
                    </div>
                                          
                  @endforeach
                </div>
              </div>
            </div>
          </div>

        </div>

        <div class="row">
          <div class="col-md-4">
            <ul class="nav nav-tabs nav-tabs-line">
              <li class="nav-item">
                <a class="nav-link documento_tab" data-toggle="tab" href="#kt_tab_pane_14">Tipo de documento</a>
              </li>
            </ul>

            <div class="tab-content" id="myTabContent">
              <div class="tab-pane fade" id="kt_tab_pane_14" role="tabpanel">
                <div class="form-group">
                  <input type="hidden" id="op_documento" value="0">

                  <div class="row">
                    <div class="col-md-4"></div>
                    <div class="col-md-8 oldcheck">
                      <input type='checkbox' id='all_documento'> Seleccionar todos
                    </div>
                  </div>

                  @foreach($tipo_documento as $value)
                    <div class="row mt-2">
                      <div class="col-md-8">
                        <label>{{ $value->guard_names }}</label>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <span class="switch switch-icon">
                          <label>
                          <input type="checkbox" name="permission[]" class='documento_check all_unidades' value="{{ $value->id }}"> 
                          <span></span>
                          </label>
                          </span>
                        </div>
                      </div>
                    </div>
                                          
                  @endforeach
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <ul class="nav nav-tabs nav-tabs-line">
              <li class="nav-item">
                <a class="nav-link asignacion_tab" data-toggle="tab" href="#kt_tab_pane_15">Tipo de asignación</a>
              </li>
            </ul>

            <div class="tab-content" id="myTabContent">
              <div class="tab-pane fade" id="kt_tab_pane_15" role="tabpanel">
                <div class="form-group">
                  <input type="hidden" id="op_asignacion" value="0">

                  <div class="row">
                    <div class="col-md-4"></div>
                    <div class="col-md-8 oldcheck">
                      <input type='checkbox' id='all_asignacion'> Seleccionar todos
                    </div>
                  </div>

                  @foreach($tipo_asignacion as $value)
                    <div class="row mt-2">
                      <div class="col-md-8">
                        <label>{{ $value->guard_names }}</label>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <span class="switch switch-icon">
                          <label>
                          <input type="checkbox" name="permission[]" class='asignacion_check all_unidades' value="{{ $value->id }}"> 
                          <span></span>
                          </label>
                          </span>
                        </div>
                      </div>
                    </div>
                                          
                  @endforeach
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <ul class="nav nav-tabs nav-tabs-line">
              <li class="nav-item">
                <a class="nav-link infopropietario_tab" data-toggle="tab" href="#kt_tab_pane_infopropietario">Información del propietario</a>
              </li>
            </ul>

            <div class="tab-content" id="myTabContent">
              <div class="tab-pane fade" id="kt_tab_pane_infopropietario" role="tabpanel">
                <div class="form-group">
                  <input type="hidden" id="op_infopropietario" value="0">

                  <div class="row">
                    <div class="col-md-4"></div>
                    <div class="col-md-8 oldcheck">
                      <input type='checkbox' id='all_infopropietario'> Seleccionar todos
                    </div>
                  </div>

                  @foreach($info_propietario as $value)
                    <div class="row mt-2">
                      <div class="col-md-8">
                        <label>{{ $value->guard_names }}</label>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <span class="switch switch-icon">
                          <label>
                          <input type="checkbox" name="permission[]" class='infopropietario_check all_unidades' value="{{ $value->id }}"> 
                          <span></span>
                          </label>
                          </span>
                        </div>
                      </div>
                    </div>
                                          
                  @endforeach
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-4">
            <ul class="nav nav-tabs nav-tabs-line">
              <li class="nav-item">
                <a class="nav-link traemplacamiento_tab" data-toggle="tab" href="#kt_tab_pane_traemplacamiento">Tramite emplacamiento</a>
              </li>
            </ul>

            <div class="tab-content" id="myTabContent">
              <div class="tab-pane fade" id="kt_tab_pane_traemplacamiento" role="tabpanel">
                <div class="form-group">
                  <input type="hidden" id="op_traemplacamiento" value="0">

                  <div class="row">
                    <div class="col-md-4"></div>
                    <div class="col-md-8 oldcheck">
                      <input type='checkbox' id='all_traemplacamiento'> Seleccionar todos
                    </div>
                  </div>

                  @foreach($tramite_emplacamiento as $value)
                    <div class="row mt-2">
                      <div class="col-md-8">
                        <label>{{ $value->guard_names }}</label>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <span class="switch switch-icon">
                          <label>
                          <input type="checkbox" name="permission[]" class='traemplacamiento_check all_unidades' value="{{ $value->id }}"> 
                          <span></span>
                          </label>
                          </span>
                        </div>
                      </div>
                    </div>
                                          
                  @endforeach
                </div>
              </div>
            </div>
          </div>

          <div class="col-md-4">
            <ul class="nav nav-tabs nav-tabs-line">
              <li class="nav-item">
                <a class="nav-link tratenencia_tab" data-toggle="tab" href="#kt_tab_pane_tratenencia">Tramite tenencia</a>
              </li>
            </ul>

            <div class="tab-content" id="myTabContent">
              <div class="tab-pane fade" id="kt_tab_pane_tratenencia" role="tabpanel">
                <div class="form-group">
                  <input type="hidden" id="op_tratenencia" value="0">

                  <div class="row">
                    <div class="col-md-4"></div>
                    <div class="col-md-8 oldcheck">
                      <input type='checkbox' id='all_tratenencia'> Seleccionar todos
                    </div>
                  </div>

                  @foreach($tramite_tenencia as $value)
                    <div class="row mt-2">
                      <div class="col-md-8">
                        <label>{{ $value->guard_names }}</label>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <span class="switch switch-icon">
                          <label>
                          <input type="checkbox" name="permission[]" class='tratenencia_check all_unidades' value="{{ $value->id }}"> 
                          <span></span>
                          </label>
                          </span>
                        </div>
                      </div>
                    </div>
                                          
                  @endforeach
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <ul class="nav nav-tabs nav-tabs-line">
              <li class="nav-item">
                <a class="nav-link traverificacion_tab" data-toggle="tab" href="#kt_tab_pane_traverificacion">Tramite verificación</a>
              </li>
            </ul>

            <div class="tab-content" id="myTabContent">
              <div class="tab-pane fade" id="kt_tab_pane_traverificacion" role="tabpanel">
                <div class="form-group">
                  <input type="hidden" id="op_traverificacion" value="0">

                  <div class="row">
                    <div class="col-md-4"></div>
                    <div class="col-md-8 oldcheck">
                      <input type='checkbox' id='all_traverificacion'> Seleccionar todos
                    </div>
                  </div>

                  @foreach($tramite_verificacion as $value)
                    <div class="row mt-2">
                      <div class="col-md-8">
                        <label>{{ $value->guard_names }}</label>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <span class="switch switch-icon">
                          <label>
                          <input type="checkbox" name="permission[]" class='traverificacion_check all_unidades' value="{{ $value->id }}"> 
                          <span></span>
                          </label>
                          </span>
                        </div>
                      </div>
                    </div>
                                          
                  @endforeach
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-4">
            <ul class="nav nav-tabs nav-tabs-line">
              <li class="nav-item">
                <a class="nav-link trareemplacamiento_tab" data-toggle="tab" href="#kt_tab_pane_trareemplacamiento">Tramite reemplacamiento</a>
              </li>
            </ul>

            <div class="tab-content" id="myTabContent">
              <div class="tab-pane fade" id="kt_tab_pane_trareemplacamiento" role="tabpanel">
                <div class="form-group">
                  <input type="hidden" id="op_trareemplacamiento" value="0">

                  <div class="row">
                    <div class="col-md-4"></div>
                    <div class="col-md-8 oldcheck">
                      <input type='checkbox' id='all_trareemplacamiento'> Seleccionar todos
                    </div>
                  </div>

                  @foreach($tramite_reemplacamiento as $value)
                    <div class="row mt-2">
                      <div class="col-md-8">
                        <label>{{ $value->guard_names }}</label>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <span class="switch switch-icon">
                          <label>
                          <input type="checkbox" name="permission[]" class='trareemplacamiento_check all_unidades' value="{{ $value->id }}"> 
                          <span></span>
                          </label>
                          </span>
                        </div>
                      </div>
                    </div>
                                          
                  @endforeach
                </div>
              </div>
            </div>
          </div>

          <div class="col-md-4">
            <ul class="nav nav-tabs nav-tabs-line">
              <li class="nav-item">
                <a class="nav-link tracambpropietario_tab" data-toggle="tab" href="#kt_tab_pane_tracambpropietario">Tramite cambio de propietario</a>
              </li>
            </ul>

            <div class="tab-content" id="myTabContent">
              <div class="tab-pane fade" id="kt_tab_pane_tracambpropietario" role="tabpanel">
                <div class="form-group">
                  <input type="hidden" id="op_tracambpropietario" value="0">

                  <div class="row">
                    <div class="col-md-4"></div>
                    <div class="col-md-8 oldcheck">
                      <input type='checkbox' id='all_tracambpropietario'> Seleccionar todos
                    </div>
                  </div>

                  @foreach($tramite_cambiopropietario as $value)
                    <div class="row mt-2">
                      <div class="col-md-8">
                        <label>{{ $value->guard_names }}</label>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <span class="switch switch-icon">
                          <label>
                          <input type="checkbox" name="permission[]" class='tracambpropietario_check all_unidades' value="{{ $value->id }}"> 
                          <span></span>
                          </label>
                          </span>
                        </div>
                      </div>
                    </div>
                                          
                  @endforeach
                </div>
              </div>
            </div>
          </div>

          <div class="col-md-4">
            <ul class="nav nav-tabs nav-tabs-line">
              <li class="nav-item">
                <a class="nav-link traaseguramiento_tab" data-toggle="tab" href="#kt_tab_pane_traaseguramiento">Tramite aseguramiento</a>
              </li>
            </ul>

            <div class="tab-content" id="myTabContent">
              <div class="tab-pane fade" id="kt_tab_pane_traaseguramiento" role="tabpanel">
                <div class="form-group">
                  <input type="hidden" id="op_traaseguramiento" value="0">

                  <div class="row">
                    <div class="col-md-4"></div>
                    <div class="col-md-8 oldcheck">
                      <input type='checkbox' id='all_traaseguramiento'> Seleccionar todos
                    </div>
                  </div>

                  @foreach($tramite_aseguramiento as $value)
                    <div class="row mt-2">
                      <div class="col-md-8">
                        <label>{{ $value->guard_names }}</label>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <span class="switch switch-icon">
                          <label>
                          <input type="checkbox" name="permission[]" class='traaseguramiento_check all_unidades' value="{{ $value->id }}"> 
                          <span></span>
                          </label>
                          </span>
                        </div>
                      </div>
                    </div>
                                          
                  @endforeach
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-4">
            <ul class="nav nav-tabs nav-tabs-line">
              <li class="nav-item">
                <a class="nav-link trabvventa_tab" data-toggle="tab" href="#kt_tab_pane_trabvventa">Tramite baja de vehículo (venta)</a>
              </li>
            </ul>

            <div class="tab-content" id="myTabContent">
              <div class="tab-pane fade" id="kt_tab_pane_trabvventa" role="tabpanel">
                <div class="form-group">
                  <input type="hidden" id="op_trabvventa" value="0">

                  <div class="row">
                    <div class="col-md-4"></div>
                    <div class="col-md-8 oldcheck">
                      <input type='checkbox' id='all_trabvventa'> Seleccionar todos
                    </div>
                  </div>

                  @foreach($tramite_bv_venta as $value)
                    <div class="row mt-2">
                      <div class="col-md-8">
                        <label>{{ $value->guard_names }}</label>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <span class="switch switch-icon">
                          <label>
                          <input type="checkbox" name="permission[]" class='trabvventa_check all_unidades' value="{{ $value->id }}"> 
                          <span></span>
                          </label>
                          </span>
                        </div>
                      </div>
                    </div>
                                          
                  @endforeach
                </div>
              </div>
            </div>
          </div>

          <div class="col-md-4">
            <ul class="nav nav-tabs nav-tabs-line">
              <li class="nav-item">
                <a class="nav-link trabvrobo_tab" data-toggle="tab" href="#kt_tab_pane_trabvrobo">Tramite baja de vehículo (robo)</a>
              </li>
            </ul>

            <div class="tab-content" id="myTabContent">
              <div class="tab-pane fade" id="kt_tab_pane_trabvrobo" role="tabpanel">
                <div class="form-group">
                  <input type="hidden" id="op_trabvrobo" value="0">

                  <div class="row">
                    <div class="col-md-4"></div>
                    <div class="col-md-8 oldcheck">
                      <input type='checkbox' id='all_trabvrobo'> Seleccionar todos
                    </div>
                  </div>

                  @foreach($tramite_bv_robo as $value)
                    <div class="row mt-2">
                      <div class="col-md-8">
                        <label>{{ $value->guard_names }}</label>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <span class="switch switch-icon">
                          <label>
                          <input type="checkbox" name="permission[]" class='trabvrobo_check all_unidades' value="{{ $value->id }}"> 
                          <span></span>
                          </label>
                          </span>
                        </div>
                      </div>
                    </div>
                                          
                  @endforeach
                </div>
              </div>
            </div>
          </div>


          <div class="col-md-4">
            <ul class="nav nav-tabs nav-tabs-line">
              <li class="nav-item">
                <a class="nav-link trabvsiniestro_tab" data-toggle="tab" href="#kt_tab_pane_trabvsiniestro">Tramite baja de vehículo (siniestro)</a>
              </li>
            </ul>

            <div class="tab-content" id="myTabContent">
              <div class="tab-pane fade" id="kt_tab_pane_trabvsiniestro" role="tabpanel">
                <div class="form-group">
                  <input type="hidden" id="op_trabvsiniestro" value="0">

                  <div class="row">
                    <div class="col-md-4"></div>
                    <div class="col-md-8 oldcheck">
                      <input type='checkbox' id='all_trabvsiniestro'> Seleccionar todos
                    </div>
                  </div>

                  @foreach($tramite_bv_siniestro as $value)
                    <div class="row mt-2">
                      <div class="col-md-8">
                        <label>{{ $value->guard_names }}</label>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <span class="switch switch-icon">
                          <label>
                          <input type="checkbox" name="permission[]" class='trabvsiniestro_check all_unidades' value="{{ $value->id }}"> 
                          <span></span>
                          </label>
                          </span>
                        </div>
                      </div>
                    </div>
                                          
                  @endforeach
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-4">
            <ul class="nav nav-tabs nav-tabs-line">
              <li class="nav-item">
                <a class="nav-link tragps_tab" data-toggle="tab" href="#kt_tab_pane_tragps">Tramite gps</a>
              </li>
            </ul>

            <div class="tab-content" id="myTabContent">
              <div class="tab-pane fade" id="kt_tab_pane_tragps" role="tabpanel">
                <div class="form-group">
                  <input type="hidden" id="op_tragps" value="0">

                  <div class="row">
                    <div class="col-md-4"></div>
                    <div class="col-md-8 oldcheck">
                      <input type='checkbox' id='all_tragps'> Seleccionar todos
                    </div>
                  </div>

                  @foreach($tramite_gps as $value)
                    <div class="row mt-2">
                      <div class="col-md-8">
                        <label>{{ $value->guard_names }}</label>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <span class="switch switch-icon">
                          <label>
                          <input type="checkbox" name="permission[]" class='tragps_check all_unidades' value="{{ $value->id }}"> 
                          <span></span>
                          </label>
                          </span>
                        </div>
                      </div>
                    </div>
                                          
                  @endforeach
                </div>
              </div>
            </div>
          </div>


          <div class="col-md-4">
            <ul class="nav nav-tabs nav-tabs-line">
              <li class="nav-item">
                <a class="nav-link estsiniestro_tab" data-toggle="tab" href="#kt_tab_pane_estsiniestro">Estatus del siniestro</a>
              </li>
            </ul>

            <div class="tab-content" id="myTabContent">
              <div class="tab-pane fade" id="kt_tab_pane_estsiniestro" role="tabpanel">
                <div class="form-group">
                  <input type="hidden" id="op_estsiniestro" value="0">

                  <div class="row">
                    <div class="col-md-4"></div>
                    <div class="col-md-8 oldcheck">
                      <input type='checkbox' id='all_estsiniestro'> Seleccionar todos
                    </div>
                  </div>

                  @foreach($estatus_siniestro as $value)
                    <div class="row mt-2">
                      <div class="col-md-8">
                        <label>{{ $value->guard_names }}</label>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <span class="switch switch-icon">
                          <label>
                          <input type="checkbox" name="permission[]" class='estsiniestro_check all_unidades' value="{{ $value->id }}"> 
                          <span></span>
                          </label>
                          </span>
                        </div>
                      </div>
                    </div>
                                          
                  @endforeach
                </div>
              </div>
            </div>
          </div>


          <div class="col-md-4">
            <ul class="nav nav-tabs nav-tabs-line">
              <li class="nav-item">
                <a class="nav-link mansolicitud_tab" data-toggle="tab" href="#kt_tab_pane_mansolicitud">Mantenimiento talleres</a>
              </li>
            </ul>

            <div class="tab-content" id="myTabContent">
              <div class="tab-pane fade" id="kt_tab_pane_mansolicitud" role="tabpanel">
                <div class="form-group">
                  <input type="hidden" id="op_mansolicitud" value="0">

                  <div class="row">
                    <div class="col-md-4"></div>
                    <div class="col-md-8 oldcheck">
                      <input type='checkbox' id='all_mansolicitud'> Seleccionar todos
                    </div>
                  </div>

                  @foreach($mantenimiento_solicitud as $value)
                    <div class="row mt-2">
                      <div class="col-md-8">
                        <label>{{ $value->guard_names }}</label>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <span class="switch switch-icon">
                          <label>
                          <input type="checkbox" name="permission[]" class='mansolicitud_check all_unidades' value="{{ $value->id }}"> 
                          <span></span>
                          </label>
                          </span>
                        </div>
                      </div>
                    </div>
                                          
                  @endforeach
                </div>
              </div>
            </div>
          </div>

        </div>

        <div class="row">
          <div class="col-md-4">
            <ul class="nav nav-tabs nav-tabs-line">
              <li class="nav-item">
                <a class="nav-link sermantenimiento_tab" data-toggle="tab" href="#kt_tab_pane_sermantenimiento">Servicios de talleres</a>
              </li>
            </ul>

            <div class="tab-content" id="myTabContent">
              <div class="tab-pane fade" id="kt_tab_pane_sermantenimiento" role="tabpanel">
                <div class="form-group">
                  <input type="hidden" id="op_sermantenimiento" value="0">

                  <div class="row">
                    <div class="col-md-4"></div>
                    <div class="col-md-8 oldcheck">
                      <input type='checkbox' id='all_sermantenimiento'> Seleccionar todos
                    </div>
                  </div>

                  @foreach($servicios_talleres as $value)
                    <div class="row mt-2">
                      <div class="col-md-8">
                        <label>{{ $value->guard_names }}</label>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <span class="switch switch-icon">
                          <label>
                          <input type="checkbox" name="permission[]" class='sermantenimiento_check all_unidades' value="{{ $value->id }}"> 
                          <span></span>
                          </label>
                          </span>
                        </div>
                      </div>
                    </div>
                                          
                  @endforeach
                </div>
              </div>
            </div>
          </div>
          
          <div class="col-md-4">
            <ul class="nav nav-tabs nav-tabs-line">
              <li class="nav-item">
                <a class="nav-link tipdoctaller_tab" data-toggle="tab" href="#kt_tab_pane_tipdoctaller">Tipo de documentos del taller</a>
              </li>
            </ul>

            <div class="tab-content" id="myTabContent">
              <div class="tab-pane fade" id="kt_tab_pane_tipdoctaller" role="tabpanel">
                <div class="form-group">
                  <input type="hidden" id="op_tipdoctaller" value="0">

                  <div class="row">
                    <div class="col-md-4"></div>
                    <div class="col-md-8 oldcheck">
                      <input type='checkbox' id='all_tipdoctaller'> Seleccionar todos
                    </div>
                  </div>

                  @foreach($tip_documento_talleres as $value)
                    <div class="row mt-2">
                      <div class="col-md-8">
                        <label>{{ $value->guard_names }}</label>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <span class="switch switch-icon">
                          <label>
                          <input type="checkbox" name="permission[]" class='tipdoctaller_check all_unidades' value="{{ $value->id }}"> 
                          <span></span>
                          </label>
                          </span>
                        </div>
                      </div>
                    </div>
                                          
                  @endforeach
                </div>
              </div>
            </div>
          </div>
        </div>




      </div>
    </div>

  </div>
</div>