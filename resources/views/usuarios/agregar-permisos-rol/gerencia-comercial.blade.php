<div class="card card-custom mt-3">
  <div class="card-header sombra_card">
    <h3 class="card-title">Dirección comercial</h3>
    <div class="card-toolbar">
      <input type='checkbox' id='all_clientes_check'> Seleccionar Todos los permisos
    </div>
  </div>
  <div class="card-body">
    <div class="row">
      <div class="col-md-4">
        <ul class="nav nav-tabs nav-tabs-line">
          <li class="nav-item">
            <a class="nav-link clientes_tab" data-toggle="tab" href="#kt_tab_pane_9"><b>Catálogo de clientes</b></a>
          </li>
        </ul>

        <div class="tab-content" id="myTabContent">
          <div class="tab-pane fade show" id="kt_tab_pane_9" role="tabpanel">
            <div class="form-group">
              <input type="hidden" id="op_cliente" value="0">

              <div class="row">
                <div class="col-md-4"></div>
                <div class="col-md-8 oldcheck">
                  <input type='checkbox' id='all_cliente'> Seleccionar todos
                </div>
              </div>

              @foreach($cliente as $value)
                <div class="row mt-2">
                  <div class="col-md-8">
                    <label>{{ $value->guard_names }}</label>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <span class="switch switch-icon">
                        <label>
                          <input type="checkbox" name="permission[]" class='clientes_check all_clientes' value="{{ $value->id }}"> 
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
            <a class="nav-link concursos_tab" data-toggle="tab" href="#kt_tab_pane_concursos"><b>Concursos</b></a>
          </li>
        </ul>

        <div class="tab-content" id="myTabContent">
          <div class="tab-pane fade show" id="kt_tab_pane_concursos" role="tabpanel">
            <div class="form-group">
              <input type="hidden" id="op_concursos" value="0">

              <div class="row">
                <div class="col-md-4"></div>
                <div class="col-md-8 oldcheck">
                  <input type='checkbox' id='all_concursos'> Seleccionar todos
                </div>
              </div>

              @foreach($concursos as $value)
                <div class="row mt-2">
                  <div class="col-md-8">
                    <label>{{ $value->guard_names }}</label>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <span class="switch switch-icon">
                        <label>
                          <input type="checkbox" name="permission[]"  class='concursos_check all_clientes' value="{{ $value->id }}"> 
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
            <a class="nav-link requisiciones_tab" data-toggle="tab" href="#kt_tab_pane_requisiciones"><b>Requisiciones</b></a>
          </li>
        </ul>

        <div class="tab-content" id="myTabContent">
          <div class="tab-pane fade show" id="kt_tab_pane_requisiciones" role="tabpanel">
            <div class="form-group">
              <input type="hidden" id="op_requisiciones" value="0">

              <div class="row">
                <div class="col-md-4"></div>
                <div class="col-md-8 oldcheck">
                  <input type='checkbox' id='all_requisiciones'> Seleccionar todos
                </div>
              </div>

              @foreach($requisiciones as $value)
                <div class="row mt-2">
                  <div class="col-md-8">
                    <label>{{ $value->guard_names }}</label>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <span class="switch switch-icon">
                        <label>
                          <input type="checkbox" name="permission[]"  class='requisiciones_check all_clientes' value="{{ $value->id }}"> 
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
            <a class="nav-link asegmento_tab" data-toggle="tab" href="#kt_tab_pane_16"><b>Administración de segmentos</b></a>
          </li>
        </ul>

        <div class="tab-content" id="myTabContent">
          <div class="tab-pane fade show" id="kt_tab_pane_16" role="tabpanel">
            <div class="form-group">
              <input type="hidden" id="op_asegmento" value="0">

              <div class="row">
                <div class="col-md-4"></div>
                <div class="col-md-8 oldcheck">
                  <input type='checkbox' id='all_asegmento'> Seleccionar todos
                </div>
              </div>

              @foreach($admin_segmento as $value)
                <div class="row mt-2">
                  <div class="col-md-8">
                    <label>{{ $value->guard_names }}</label>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <span class="switch switch-icon">
                        <label>
                          <input type="checkbox" name="permission[]" class='asegmento_check all_clientes' value="{{ $value->id }}"> 
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
            <a class="nav-link cliunidades_tab" data-toggle="tab" href="#kt_tab_pane_cliunidades"><b>Parque Vehícular</b></a>
          </li>
        </ul>

        <div class="tab-content" id="myTabContent">
          <div class="tab-pane fade show" id="kt_tab_pane_cliunidades" role="tabpanel">
            <div class="form-group">
              <input type="hidden" id="op_cliunidades" value="0">

              <div class="row">
                <div class="col-md-4"></div>
                <div class="col-md-8 oldcheck">
                  <input type='checkbox' id='all_cliunidades'> Seleccionar todos
                </div>
              </div>

              @foreach($cli_unidades as $value)
                <div class="row mt-2">
                  <div class="col-md-8">
                    <label>{{ $value->guard_names }}</label>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <span class="switch switch-icon">
                        <label>
                          <input type="checkbox" name="permission[]" class='cliunidades_check all_clientes' value="{{ $value->id }}"> 
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
            <a class="nav-link gestordoc_tab" data-toggle="tab" href="#kt_tab_pane_gestordoc"><b>Gestor Documentos</b></a>
          </li>
        </ul>

        <div class="tab-content" id="myTabContent">
          <div class="tab-pane fade show" id="kt_tab_pane_gestordoc" role="tabpanel">
            <div class="form-group">
              <input type="hidden" id="op_gestordoc" value="0">

              <div class="row">
                <div class="col-md-4"></div>
                <div class="col-md-8 oldcheck">
                  <input type='checkbox' id='all_gestordoc'> Seleccionar todos
                </div>
              </div>

              @foreach($gestor_doc as $value)
                <div class="row mt-2">
                  <div class="col-md-8">
                    <label>{{ $value->guard_names }}</label>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <span class="switch switch-icon">
                        <label>
                          <input type="checkbox" name="permission[]"  class='gestordoc_check all_clientes' value="{{ $value->id }}"> 
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

{{-- C A T A L O G O S --}}
    <div class="card card-custom gutter-b">
      <div class="card-header sombra_card_catalogo">
        <div class="card-title">
          <h3 class="card-label">
            <span>Catalogos de dirección comercial</span>
          </h3>
        </div>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-4">
            <ul class="nav nav-tabs nav-tabs-line">
              <li class="nav-item">
                <a class="nav-link estados_tab" data-toggle="tab" href="#kt_tab_pane_10">Estados</a>
              </li>
            </ul>

            <div class="tab-content" id="myTabContent">
              <div class="tab-pane fade show" id="kt_tab_pane_10" role="tabpanel">
                <div class="form-group">
                  <input type="hidden" id="op_estado" value="0">
                  <div class="row">
                    <div class="col-md-4"></div>
                    <div class="col-md-8 oldcheck">
                      <input type='checkbox' id='all_estados'> Seleccionar todos
                    </div>
                  </div>

                  @foreach($estado as $value)
                    <div class="row mt-2">
                      <div class="col-md-8">
                        <label>{{ $value->guard_names }}</label>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <span class="switch switch-icon">
                            <label>
                              <input type="checkbox" name="permission[]" class='estados_check all_clientes' value="{{ $value->id }}"> 
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
                <a class="nav-link municipios_tab" data-toggle="tab" href="#kt_tab_pane_11">Municipios</a>
              </li>
            </ul>

            <div class="tab-content" id="myTabContent">
              <div class="tab-pane fade show" id="kt_tab_pane_11" role="tabpanel">
                <div class="form-group">
                  <input type="hidden" id="op_municipios" value="0">
                  <div class="row">
                    <div class="col-md-4"></div>
                    <div class="col-md-8 oldcheck">
                      <input type='checkbox' id='all_municipios'> Seleccionar todos
                    </div>
                  </div>

                  @foreach($municipio as $value)
                    <div class="row mt-2">
                      <div class="col-md-8">
                        <label>{{ $value->guard_names }}</label>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <span class="switch switch-icon">
                            <label>
                              <input type="checkbox" name="permission[]" class='municipios_check all_clientes' value="{{ $value->id }}"> 
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
                <a class="nav-link astipovehiculo_tab" data-toggle="tab" href="#kt_tab_pane_17">Tipos de vehículos</a>
              </li>
            </ul>

            <div class="tab-content" id="myTabContent">
              <div class="tab-pane fade show" id="kt_tab_pane_17" role="tabpanel">
                <div class="form-group">
                  <input type="hidden" id="op_astipovehiculo" value="0">

                  <div class="row">
                    <div class="col-md-4"></div>
                    <div class="col-md-8 oldcheck">
                      <input type='checkbox' id='all_astipovehiculo'> Seleccionar todos
                    </div>
                  </div>

                  @foreach($as_tipovehiculo as $value)
                    <div class="row mt-2">
                      <div class="col-md-8">
                        <label>{{ $value->guard_names }}</label>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <span class="switch switch-icon">
                            <label>
                              <input type="checkbox" name="permission[]" class='astipovehiculo_check all_clientes' value="{{ $value->id }}"> 
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
                <a class="nav-link aspuerta_tab" data-toggle="tab" href="#kt_tab_pane_18">Puertas</a>
              </li>
            </ul>

            <div class="tab-content" id="myTabContent">
              <div class="tab-pane fade show" id="kt_tab_pane_18" role="tabpanel">
                <div class="form-group">
                  <input type="hidden" id="op_aspuerta" value="0">

                  <div class="row">
                    <div class="col-md-4"></div>
                    <div class="col-md-8 oldcheck">
                      <input type='checkbox' id='all_aspuerta'> Seleccionar todos
                    </div>
                  </div>

                  @foreach($as_puertas as $value)
                    <div class="row mt-2">
                      <div class="col-md-8">
                        <label>{{ $value->guard_names }}</label>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <span class="switch switch-icon">
                            <label>
                              <input type="checkbox" name="permission[]" class='aspuerta_check all_clientes' value="{{ $value->id }}"> 
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
                <a class="nav-link ascarroceria_tab" data-toggle="tab" href="#kt_tab_pane_19">Carrocería</a>
              </li>
            </ul>

            <div class="tab-content" id="myTabContent">
              <div class="tab-pane fade show" id="kt_tab_pane_19" role="tabpanel">
                <div class="form-group">
                  <input type="hidden" id="op_ascarroceria" value="0">

                  <div class="row">
                    <div class="col-md-4"></div>
                    <div class="col-md-8 oldcheck">
                      <input type='checkbox' id='all_ascarroceria'> Seleccionar todos
                    </div>
                  </div>

                  @foreach($as_carroceria as $value)
                    <div class="row mt-2">
                      <div class="col-md-8">
                        <label>{{ $value->guard_names }}</label>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <span class="switch switch-icon">
                            <label>
                              <input type="checkbox" name="permission[]" class='ascarroceria_check all_clientes' value="{{ $value->id }}"> 
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
                <a class="nav-link asnumcilindros_tab" data-toggle="tab" href="#kt_tab_pane_20">Número de cilindros</a>
              </li>
            </ul>

            <div class="tab-content" id="myTabContent">
              <div class="tab-pane fade show" id="kt_tab_pane_20" role="tabpanel">
                <div class="form-group">
                  <input type="hidden" id="op_asnumcilindros" value="0">

                  <div class="row">
                    <div class="col-md-4"></div>
                    <div class="col-md-8 oldcheck">
                      <input type='checkbox' id='all_asnumcilindros'> Seleccionar todos
                    </div>
                  </div>

                  @foreach($as_numcilindros as $value)
                    <div class="row mt-2">
                      <div class="col-md-8">
                        <label>{{ $value->guard_names }}</label>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <span class="switch switch-icon">
                            <label>
                              <input type="checkbox" name="permission[]" class='asnumcilindros_check all_clientes' value="{{ $value->id }}"> 
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
                <a class="nav-link aspasajeros_tab" data-toggle="tab" href="#kt_tab_pane_21">Pasajeros</a>
              </li>
            </ul>

            <div class="tab-content" id="myTabContent">
              <div class="tab-pane fade show" id="kt_tab_pane_21" role="tabpanel">
                <div class="form-group">
                  <input type="hidden" id="op_aspasajeros" value="0">

                  <div class="row">
                    <div class="col-md-4"></div>
                    <div class="col-md-8 oldcheck">
                      <input type='checkbox' id='all_aspasajeros'> Seleccionar todos
                    </div>
                  </div>

                  @foreach($as_pasajeros as $value)
                    <div class="row mt-2">
                      <div class="col-md-8">
                        <label>{{ $value->guard_names }}</label>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <span class="switch switch-icon">
                            <label>
                              <input type="checkbox" name="permission[]" class='aspasajeros_check all_clientes' value="{{ $value->id }}"> 
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
                <a class="nav-link motor_tab" data-toggle="tab" href="#kt_tab_pane_22">Motor</a>
              </li>
            </ul>

            <div class="tab-content" id="myTabContent">
              <div class="tab-pane fade show" id="kt_tab_pane_22" role="tabpanel">
                <div class="form-group">
                  <input type="hidden" id="op_motor" value="0">

                  <div class="row">
                    <div class="col-md-4"></div>
                    <div class="col-md-8 oldcheck">
                      <input type='checkbox' id='all_motor'> Seleccionar todos
                    </div>
                  </div>

                  @foreach($as_motor as $value)
                    <div class="row mt-2">
                      <div class="col-md-8">
                        <label>{{ $value->guard_names }}</label>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <span class="switch switch-icon">
                            <label>
                              <input type="checkbox" name="permission[]" class='motor_check all_clientes' value="{{ $value->id }}"> 
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
                <a class="nav-link asllantarefaccion_tab" data-toggle="tab" href="#kt_tab_pane_23">Llanta de refacción</a>
              </li>
            </ul>

            <div class="tab-content" id="myTabContent">
              <div class="tab-pane fade show" id="kt_tab_pane_23" role="tabpanel">
                <div class="form-group">
                  <input type="hidden" id="op_asllantarefaccion" value="0">

                  <div class="row">
                    <div class="col-md-4"></div>
                    <div class="col-md-8 oldcheck">
                      <input type='checkbox' id='all_asllantarefaccion'> Seleccionar todos
                    </div>
                  </div>

                  @foreach($as_llantarefaccion as $value)
                    <div class="row mt-2">
                      <div class="col-md-8">
                        <label>{{ $value->guard_names }}</label>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <span class="switch switch-icon">
                            <label>
                              <input type="checkbox" name="permission[]" class='asllantarefaccion_check all_clientes' value="{{ $value->id }}"> 
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
                <a class="nav-link asespejoslaterales_tab" data-toggle="tab" href="#kt_tab_pane_24">Espejos laterales</a>
              </li>
            </ul>

            <div class="tab-content" id="myTabContent">
              <div class="tab-pane fade show" id="kt_tab_pane_24" role="tabpanel">
                <div class="form-group">
                  <input type="hidden" id="op_asespejoslaterales" value="0">

                  <div class="row">
                    <div class="col-md-4"></div>
                    <div class="col-md-8 oldcheck">
                      <input type='checkbox' id='all_asespejoslaterales'> Seleccionar todos
                    </div>
                  </div>

                  @foreach($as_espejoslaterales as $value)
                    <div class="row mt-2">
                      <div class="col-md-8">
                        <label>{{ $value->guard_names }}</label>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <span class="switch switch-icon">
                            <label>
                              <input type="checkbox" name="permission[]" class='asespejoslaterales_check all_clientes' value="{{ $value->id }}"> 
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
                <a class="nav-link asaccesorios_tab" data-toggle="tab" href="#kt_tab_pane_25">Accesorios</a>
              </li>
            </ul>

            <div class="tab-content" id="myTabContent">
              <div class="tab-pane fade show" id="kt_tab_pane_25" role="tabpanel">
                <div class="form-group">
                  <input type="hidden" id="op_asaccesorios" value="0">

                  <div class="row">
                    <div class="col-md-4"></div>
                    <div class="col-md-8 oldcheck">
                      <input type='checkbox' id='all_asaccesorios'> Seleccionar todos
                    </div>
                  </div>

                  @foreach($as_accesorios as $value)
                    <div class="row mt-2">
                      <div class="col-md-8">
                        <label>{{ $value->guard_names }}</label>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <span class="switch switch-icon">
                            <label>
                              <input type="checkbox" name="permission[]" class='asaccesorios_check all_clientes' value="{{ $value->id }}"> 
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
                <a class="nav-link asapotencia_tab" data-toggle="tab" href="#kt_tab_pane_26">Potencia</a>
              </li>
            </ul>

            <div class="tab-content" id="myTabContent">
              <div class="tab-pane fade show" id="kt_tab_pane_26" role="tabpanel">
                <div class="form-group">
                  <input type="hidden" id="op_asapotencia" value="0">

                  <div class="row">
                    <div class="col-md-4"></div>
                    <div class="col-md-8 oldcheck">
                      <input type='checkbox' id='all_asapotencia'> Seleccionar todos
                    </div>
                  </div>

                  @foreach($as_postencia as $value)
                    <div class="row mt-2">
                      <div class="col-md-8">
                        <label>{{ $value->guard_names }}</label>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <span class="switch switch-icon">
                            <label>
                              <input type="checkbox" name="permission[]" class='asapotencia_check all_clientes' value="{{ $value->id }}"> 
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
                <a class="nav-link astransmision_tab" data-toggle="tab" href="#kt_tab_pane_27">Transmisión</a>
              </li>
            </ul>

            <div class="tab-content" id="myTabContent">
              <div class="tab-pane fade show" id="kt_tab_pane_27" role="tabpanel">
                <div class="form-group">
                  <input type="hidden" id="op_astransmision" value="0">

                  <div class="row">
                    <div class="col-md-4"></div>
                    <div class="col-md-8 oldcheck">
                      <input type='checkbox' id='all_astransmision'> Seleccionar todos
                    </div>
                  </div>

                  @foreach($as_transmision as $value)
                    <div class="row mt-2">
                      <div class="col-md-8">
                        <label>{{ $value->guard_names }}</label>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <span class="switch switch-icon">
                            <label>
                              <input type="checkbox" name="permission[]" class='astransmision_check all_clientes' value="{{ $value->id }}"> 
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
                <a class="nav-link asradio_tab" data-toggle="tab" href="#kt_tab_pane_asradio">Radio</a>
              </li>
            </ul>

            <div class="tab-content" id="myTabContent">
              <div class="tab-pane fade show" id="kt_tab_pane_asradio" role="tabpanel">
                <div class="form-group">
                  <input type="hidden" id="op_asradio" value="0">

                  <div class="row">
                    <div class="col-md-4"></div>
                    <div class="col-md-8 oldcheck">
                      <input type='checkbox' id='all_asradio'> Seleccionar todos
                    </div>
                  </div>

                  @foreach($as_radio as $value)
                    <div class="row mt-2">
                      <div class="col-md-8">
                        <label>{{ $value->guard_names }}</label>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <span class="switch switch-icon">
                            <label>
                              <input type="checkbox" name="permission[]" class='asradio_check all_clientes' value="{{ $value->id }}"> 
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
                <a class="nav-link asdireccion_tab" data-toggle="tab" href="#kt_tab_pane_asdireccion">Dirección</a>
              </li>
            </ul>

            <div class="tab-content" id="myTabContent">
              <div class="tab-pane fade show" id="kt_tab_pane_asdireccion" role="tabpanel">
                <div class="form-group">
                  <input type="hidden" id="op_asdireccion" value="0">

                  <div class="row">
                    <div class="col-md-4"></div>
                    <div class="col-md-8 oldcheck">
                      <input type='checkbox' id='all_asdireccion'> Seleccionar todos
                    </div>
                  </div>

                  @foreach($as_direccion as $value)
                    <div class="row mt-2">
                      <div class="col-md-8">
                        <label>{{ $value->guard_names }}</label>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <span class="switch switch-icon">
                            <label>
                              <input type="checkbox" name="permission[]" class='asdireccion_check all_clientes' value="{{ $value->id }}"> 
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
                <a class="nav-link asblindaje_tab" data-toggle="tab" href="#kt_tab_pane_asblindaje">Blindaje</a>
              </li>
            </ul>

            <div class="tab-content" id="myTabContent">
              <div class="tab-pane fade show" id="kt_tab_pane_asblindaje" role="tabpanel">
                <div class="form-group">
                  <input type="hidden" id="op_asblindaje" value="0">

                  <div class="row">
                    <div class="col-md-4"></div>
                    <div class="col-md-8 oldcheck">
                      <input type='checkbox' id='all_asblindaje'> Seleccionar todos
                    </div>
                  </div>

                  @foreach($as_blindaje as $value)
                    <div class="row mt-2">
                      <div class="col-md-8">
                        <label>{{ $value->guard_names }}</label>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <span class="switch switch-icon">
                            <label>
                              <input type="checkbox" name="permission[]" class='asblindaje_check all_clientes' value="{{ $value->id }}"> 
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
                <a class="nav-link ascapacidad_tab" data-toggle="tab" href="#kt_tab_pane_ascapacidad">Capacidad</a>
              </li>
            </ul>

            <div class="tab-content" id="myTabContent">
              <div class="tab-pane fade show" id="kt_tab_pane_ascapacidad" role="tabpanel">
                <div class="form-group">
                  <input type="hidden" id="op_ascapacidad" value="0">

                  <div class="row">
                    <div class="col-md-4"></div>
                    <div class="col-md-8 oldcheck">
                      <input type='checkbox' id='all_ascapacidad'> Seleccionar todos
                    </div>
                  </div>

                  @foreach($as_capacidad as $value)
                    <div class="row mt-2">
                      <div class="col-md-8">
                        <label>{{ $value->guard_names }}</label>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <span class="switch switch-icon">
                            <label>
                              <input type="checkbox" name="permission[]" class='ascapacidad_check all_clientes' value="{{ $value->id }}"> 
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
                <a class="nav-link asgps_tab" data-toggle="tab" href="#kt_tab_pane_asgps">GPS</a>
              </li>
            </ul>

            <div class="tab-content" id="myTabContent">
              <div class="tab-pane fade show" id="kt_tab_pane_asgps" role="tabpanel">
                <div class="form-group">
                  <input type="hidden" id="op_asgps" value="0">

                  <div class="row">
                    <div class="col-md-4"></div>
                    <div class="col-md-8 oldcheck">
                      <input type='checkbox' id='all_asgps'> Seleccionar todos
                    </div>
                  </div>

                  @foreach($as_gps as $value)
                    <div class="row mt-2">
                      <div class="col-md-8">
                        <label>{{ $value->guard_names }}</label>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <span class="switch switch-icon">
                            <label>
                              <input type="checkbox" name="permission[]" class='asgps_check all_clientes' value="{{ $value->id }}"> 
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
                <a class="nav-link asinventario_tab" data-toggle="tab" href="#kt_tab_pane_asinventario">En inventario</a>
              </li>
            </ul>

            <div class="tab-content" id="myTabContent">
              <div class="tab-pane fade show" id="kt_tab_pane_asinventario" role="tabpanel">
                <div class="form-group">
                  <input type="hidden" id="op_asinventario" value="0">

                  <div class="row">
                    <div class="col-md-4"></div>
                    <div class="col-md-8 oldcheck">
                      <input type='checkbox' id='all_asinventario'> Seleccionar todos
                    </div>
                  </div>

                  @foreach($as_inventario as $value)
                    <div class="row mt-2">
                      <div class="col-md-8">
                        <label>{{ $value->guard_names }}</label>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <span class="switch switch-icon">
                            <label>
                              <input type="checkbox" name="permission[]" class='asinventario_check all_clientes' value="{{ $value->id }}"> 
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
                <a class="nav-link doccliente_tab" data-toggle="tab" href="#kt_tab_pane_doccliente">Documentos del cliente</a>
              </li>
            </ul>

            <div class="tab-content" id="myTabContent">
              <div class="tab-pane fade show" id="kt_tab_pane_doccliente" role="tabpanel">
                <div class="form-group">
                  <input type="hidden" id="op_doccliente" value="0">

                  <div class="row">
                    <div class="col-md-4"></div>
                    <div class="col-md-8 oldcheck">
                      <input type='checkbox' id='all_doccliente'> Seleccionar todos
                    </div>
                  </div>

                  @foreach($doc_cliente as $value)
                    <div class="row mt-2">
                      <div class="col-md-8">
                        <label>{{ $value->guard_names }}</label>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <span class="switch switch-icon">
                            <label>
                              <input type="checkbox" name="permission[]" class='doccliente_check all_clientes' value="{{ $value->id }}"> 
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
                <a class="nav-link docconcursos_tab" data-toggle="tab" href="#kt_tab_pane_031">Documentos del concurso</a>
              </li>
            </ul>

            <div class="tab-content" id="myTabContent">
              <div class="tab-pane fade show" id="kt_tab_pane_031" role="tabpanel">
                <div class="form-group">
                  <input type="hidden" id="op_docconcursos" value="0">

                  <div class="row">
                    <div class="col-md-4"></div>
                    <div class="col-md-8 oldcheck">
                      <input type='checkbox' id='all_docconcursos'> Seleccionar todos
                    </div>
                  </div>

                  @foreach($doc_concursos as $value)
                    <div class="row mt-2">
                      <div class="col-md-8">
                        <label>{{ $value->guard_names }}</label>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <span class="switch switch-icon">
                            <label>
                              <input type="checkbox" name="permission[]" class='docconcursos_check all_clientes' value="{{ $value->id }}"> 
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
                <a class="nav-link pubconcursos_tab" data-toggle="tab" href="#kt_tab_pane_032">Publicación del concurso</a>
              </li>
            </ul>

            <div class="tab-content" id="myTabContent">
              <div class="tab-pane fade show" id="kt_tab_pane_032" role="tabpanel">
                <div class="form-group">
                  <input type="hidden" id="op_pubconcursos" value="0">

                  <div class="row">
                    <div class="col-md-4"></div>
                    <div class="col-md-8 oldcheck">
                      <input type='checkbox' id='all_pubconcursos'> Seleccionar todos
                    </div>
                  </div>

                  @foreach($pub_concurso as $value)
                    <div class="row mt-2">
                      <div class="col-md-8">
                        <label>{{ $value->guard_names }}</label>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <span class="switch switch-icon">
                            <label>
                              <input type="checkbox" name="permission[]" class='pubconcursos_check all_clientes' value="{{ $value->id }}"> 
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
                <a class="nav-link tipcontratacion_tab" data-toggle="tab" href="#kt_tab_pane_033">Tipos de contratación</a>
              </li>
            </ul>

            <div class="tab-content" id="myTabContent">
              <div class="tab-pane fade show" id="kt_tab_pane_033" role="tabpanel">
                <div class="form-group">
                  <input type="hidden" id="op_tipcontratacion" value="0">

                  <div class="row">
                    <div class="col-md-4"></div>
                    <div class="col-md-8 oldcheck">
                      <input type='checkbox' id='all_tipcontratacion'> Seleccionar todos
                    </div>
                  </div>

                  @foreach($tip_contratacion as $value)
                    <div class="row mt-2">
                      <div class="col-md-8">
                        <label>{{ $value->guard_names }}</label>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <span class="switch switch-icon">
                            <label>
                              <input type="checkbox" name="permission[]" class='tipcontratacion_check all_clientes' value="{{ $value->id }}"> 
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
                <a class="nav-link tipdoccontrato_tab" data-toggle="tab" href="#kt_tab_pane_tipdoccont">Tipos de documentos del contrato</a>
              </li>
            </ul>

            <div class="tab-content" id="myTabContent">
              <div class="tab-pane fade show" id="kt_tab_pane_tipdoccont" role="tabpanel">
                <div class="form-group">
                  <input type="hidden" id="op_tipdoccontrato" value="0">

                  <div class="row">
                    <div class="col-md-4"></div>
                    <div class="col-md-8 oldcheck">
                      <input type='checkbox' id='all_tipdoccontrato'> Seleccionar todos
                    </div>
                  </div>

                  @foreach($tip_doc_contrato as $value)
                    <div class="row mt-2">
                      <div class="col-md-8">
                        <label>{{ $value->guard_names }}</label>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <span class="switch switch-icon">
                            <label>
                              <input type="checkbox" name="permission[]" class='tipdoccontrato_check all_clientes' value="{{ $value->id }}"> 
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
                <a class="nav-link admincontrato_tab" data-toggle="tab" href="#kt_tab_pane_admincontrato">Administradores de contratos</a>
              </li>
            </ul>

            <div class="tab-content" id="myTabContent">
              <div class="tab-pane fade show" id="kt_tab_pane_admincontrato" role="tabpanel">
                <div class="form-group">
                  <input type="hidden" id="op_admincontrato" value="0">

                  <div class="row">
                    <div class="col-md-4"></div>
                    <div class="col-md-8 oldcheck">
                      <input type='checkbox' id='all_admincontrato'> Seleccionar todos
                    </div>
                  </div>

                  @foreach($admin_contrato_cat as $value)
                    <div class="row mt-2">
                      <div class="col-md-8">
                        <label>{{ $value->guard_names }}</label>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <span class="switch switch-icon">
                            <label>
                              <input type="checkbox" name="permission[]" class='admincontrato_check all_clientes' value="{{ $value->id }}"> 
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
                <a class="nav-link conveniomod_tab" data-toggle="tab" href="#kt_tab_pane_conveniomod">Tipo de convenio modificatorio</a>
              </li>
            </ul>

            <div class="tab-content" id="myTabContent">
              <div class="tab-pane fade show" id="kt_tab_pane_conveniomod" role="tabpanel">
                <div class="form-group">
                  <input type="hidden" id="op_conveniomod" value="0">

                  <div class="row">
                    <div class="col-md-4"></div>
                    <div class="col-md-8 oldcheck">
                      <input type='checkbox' id='all_conveniomod'> Seleccionar todos
                    </div>
                  </div>

                  @foreach($tipo_convenio_mod as $value)
                    <div class="row mt-2">
                      <div class="col-md-8">
                        <label>{{ $value->guard_names }}</label>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <span class="switch switch-icon">
                            <label>
                              <input type="checkbox" name="permission[]" class='conveniomod_check all_clientes' value="{{ $value->id }}"> 
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
                <a class="nav-link tipofianza_tab" data-toggle="tab" href="#kt_tab_pane_tipofianza">Tipo de fianza</a>
              </li>
            </ul>

            <div class="tab-content" id="myTabContent">
              <div class="tab-pane fade show" id="kt_tab_pane_tipofianza" role="tabpanel">
                <div class="form-group">
                  <input type="hidden" id="op_tipofianza" value="0">

                  <div class="row">
                    <div class="col-md-4"></div>
                    <div class="col-md-8 oldcheck">
                      <input type='checkbox' id='all_tipofianza'> Seleccionar todos
                    </div>
                  </div>

                  @foreach($tipo_fianza as $value)
                    <div class="row mt-2">
                      <div class="col-md-8">
                        <label>{{ $value->guard_names }}</label>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <span class="switch switch-icon">
                            <label>
                              <input type="checkbox" name="permission[]" class='tipofianza_check all_clientes' value="{{ $value->id }}"> 
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
                <a class="nav-link lequipamiento_tab" data-toggle="tab" href="#kt_tab_pane_lequipamiento">Listado de equipamiento</a>
              </li>
            </ul>

            <div class="tab-content" id="myTabContent">
              <div class="tab-pane fade show" id="kt_tab_pane_lequipamiento" role="tabpanel">
                <div class="form-group">
                  <input type="hidden" id="op_lequipamiento" value="0">

                  <div class="row">
                    <div class="col-md-4"></div>
                    <div class="col-md-8 oldcheck">
                      <input type='checkbox' id='all_lequipamiento'> Seleccionar todos
                    </div>
                  </div>

                  @foreach($req_equipamiento as $value)
                    <div class="row mt-2">
                      <div class="col-md-8">
                        <label>{{ $value->guard_names }}</label>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <span class="switch switch-icon">
                            <label>
                              <input type="checkbox" name="permission[]" class='lequipamiento_check all_clientes' value="{{ $value->id }}"> 
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
                <a class="nav-link rtransporte_tab" data-toggle="tab" href="#kt_tab_pane_rtransporte">Listado de tipo de transporte</a>
              </li>
            </ul>

            <div class="tab-content" id="myTabContent">
              <div class="tab-pane fade show" id="kt_tab_pane_rtransporte" role="tabpanel">
                <div class="form-group">
                  <input type="hidden" id="op_rtransporte" value="0">

                  <div class="row">
                    <div class="col-md-4"></div>
                    <div class="col-md-8 oldcheck">
                      <input type='checkbox' id='all_rtransporte'> Seleccionar todos
                    </div>
                  </div>

                  @foreach($req_transporte as $value)
                    <div class="row mt-2">
                      <div class="col-md-8">
                        <label>{{ $value->guard_names }}</label>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <span class="switch switch-icon">
                            <label>
                              <input type="checkbox" name="permission[]" class='rtransporte_check all_clientes' value="{{ $value->id }}"> 
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
                <a class="nav-link rentidadf_tab" data-toggle="tab" href="#kt_tab_pane_rentidadf">Listado de entidad federativa</a>
              </li>
            </ul>

            <div class="tab-content" id="myTabContent">
              <div class="tab-pane fade show" id="kt_tab_pane_rentidadf" role="tabpanel">
                <div class="form-group">
                  <input type="hidden" id="op_rentidadf" value="0">

                  <div class="row">
                    <div class="col-md-4"></div>
                    <div class="col-md-8 oldcheck">
                      <input type='checkbox' id='all_rentidadf'> Seleccionar todos
                    </div>
                  </div>

                  @foreach($req_entidadfederativa as $value)
                    <div class="row mt-2">
                      <div class="col-md-8">
                        <label>{{ $value->guard_names }}</label>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <span class="switch switch-icon">
                            <label>
                              <input type="checkbox" name="permission[]" class='rentidadf_check all_clientes' value="{{ $value->id }}"> 
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
                <a class="nav-link rplacas_tab" data-toggle="tab" href="#kt_tab_pane_rplacas">Listado de tipos de placas</a>
              </li>
            </ul>

            <div class="tab-content" id="myTabContent">
              <div class="tab-pane fade show" id="kt_tab_pane_rplacas" role="tabpanel">
                <div class="form-group">
                  <input type="hidden" id="op_rplacas" value="0">

                  <div class="row">
                    <div class="col-md-4"></div>
                    <div class="col-md-8 oldcheck">
                      <input type='checkbox' id='all_rplacas'> Seleccionar todos
                    </div>
                  </div>

                  @foreach($req_placas as $value)
                    <div class="row mt-2">
                      <div class="col-md-8">
                        <label>{{ $value->guard_names }}</label>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <span class="switch switch-icon">
                            <label>
                              <input type="checkbox" name="permission[]" class='rplacas_check all_clientes' value="{{ $value->id }}"> 
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
                <a class="nav-link rcombustible_tab" data-toggle="tab" href="#kt_tab_pane_rcombustible">Listado de tipos de combustible</a>
              </li>
            </ul>

            <div class="tab-content" id="myTabContent">
              <div class="tab-pane fade show" id="kt_tab_pane_rcombustible" role="tabpanel">
                <div class="form-group">
                  <input type="hidden" id="op_rcombustible" value="0">

                  <div class="row">
                    <div class="col-md-4"></div>
                    <div class="col-md-8 oldcheck">
                      <input type='checkbox' id='all_rcombustible'> Seleccionar todos
                    </div>
                  </div>

                  @foreach($req_combustible as $value)
                    <div class="row mt-2">
                      <div class="col-md-8">
                        <label>{{ $value->guard_names }}</label>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <span class="switch switch-icon">
                            <label>
                              <input type="checkbox" name="permission[]" class='rcombustible_check all_clientes' value="{{ $value->id }}"> 
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
                <a class="nav-link catafianzadora_tab" data-toggle="tab" href="#kt_tab_pane_catafianzadora">Listado de afianzadora</a>
              </li>
            </ul>

            <div class="tab-content" id="myTabContent">
              <div class="tab-pane fade show" id="kt_tab_pane_catafianzadora" role="tabpanel">
                <div class="form-group">
                  <input type="hidden" id="op_catafianzadora" value="0">

                  <div class="row">
                    <div class="col-md-4"></div>
                    <div class="col-md-8 oldcheck">
                      <input type='checkbox' id='all_catafianzadora'> Seleccionar todos
                    </div>
                  </div>

                  @foreach($cat_afianzadora as $value)
                    <div class="row mt-2">
                      <div class="col-md-8">
                        <label>{{ $value->guard_names }}</label>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <span class="switch switch-icon">
                            <label>
                              <input type="checkbox" name="permission[]" class='catafianzadora_check all_clientes' value="{{ $value->id }}"> 
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