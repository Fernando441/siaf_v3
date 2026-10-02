<div class="card card-custom mt-4">
  <div class="card-header sombra_card">
    <h3 class="card-title">Dirección de administración y finanzas</h3>
    <div class="card-toolbar">
      <input type='checkbox' id='all_finanzas_check'> Seleccionar Todos los permisos
    </div>
  </div>
  <div class="card-body">
    <div class="row">
      <div class="col-md-4">  
        <ul class="nav nav-tabs nav-tabs-line">
          <li class="nav-item">
            <a class="nav-link finanzas_tab" data-toggle="tab" href="#kt_tab_pane_finanzas"><b>Administración de requisiciónes</b></a>
          </li>
        </ul>

        <div class="tab-content" id="myTabContent">
          <div class="tab-pane fade" id="kt_tab_pane_finanzas" role="tabpanel">
            <input type="hidden" id="op_finanzas" value="0">
            <div class="row">
              <div class="col-md-4"></div>
              <div class="col-md-8 oldcheck">
                <input type='checkbox' id='all_finanzas'> Seleccionar todos
              </div>
            </div>
            @foreach($admin_finanzas as $value)
              <div class="row mt-2">
                <div class="col-md-8">
                  <label>{{ $value->guard_names }}</label>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <span class="switch switch-icon">
                    <label>
                    <input type="checkbox" name="permission[]" {{(in_array($value->id , $permiso_roles_id)) ? 'checked' : ''}} class='finanzas_check all_finanzas' value="{{ $value->id }}" />
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

      <div class="col-md-4">  
        <ul class="nav nav-tabs nav-tabs-line">
          <li class="nav-item">
            <a class="nav-link ordencompra_tab" data-toggle="tab" href="#kt_tab_pane_ordencompra"><b>Orden de compra</b></a>
          </li>
        </ul>

        <div class="tab-content" id="myTabContent">
          <div class="tab-pane fade" id="kt_tab_pane_ordencompra" role="tabpanel">
            <input type="hidden" id="op_ordencompra" value="0">
            <div class="row">
              <div class="col-md-4"></div>
              <div class="col-md-8 oldcheck">
                <input type='checkbox' id='all_ordencompra'> Seleccionar todos
              </div>
            </div>
            @foreach($orden_compra as $value)
              <div class="row mt-2">
                <div class="col-md-8">
                  <label>{{ $value->guard_names }}</label>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <span class="switch switch-icon">
                    <label>
                    <input type="checkbox" name="permission[]" {{(in_array($value->id , $permiso_roles_id)) ? 'checked' : ''}} class='ordencompra_check all_ordencompra' value="{{ $value->id }}" />
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


      <div class="col-md-4">  
        <ul class="nav nav-tabs nav-tabs-line">
          <li class="nav-item">
            <a class="nav-link estimacionfin_tab" data-toggle="tab" href="#kt_tab_pane_estimacionfin"><b>Estimaciones</b></a>
          </li>
        </ul>

        <div class="tab-content" id="myTabContent">
          <div class="tab-pane fade" id="kt_tab_pane_estimacionfin" role="tabpanel">
            <input type="hidden" id="op_estimacionfin" value="0">
            <div class="row">
              <div class="col-md-4"></div>
              <div class="col-md-8 oldcheck">
                <input type='checkbox' id='all_estimacionfin'> Seleccionar todos
              </div>
            </div>
            @foreach($estimaciones_fin as $value)
              <div class="row mt-2">
                <div class="col-md-8">
                  <label>{{ $value->guard_names }}</label>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <span class="switch switch-icon">
                    <label>
                    <input type="checkbox" name="permission[]" {{(in_array($value->id , $permiso_roles_id)) ? 'checked' : ''}} class='estimacionfin_check all_estimacionfin' value="{{ $value->id }}" />
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


    <div class="card card-custom gutter-b">
      <div class="card-header sombra_card_catalogo">
        <div class="card-title">
          <h3 class="card-label">
            Catalogos de dirección de administración y finanzas
          </h3>
        </div>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-4">  
            <ul class="nav nav-tabs nav-tabs-line">
              <li class="nav-item">
                <a class="nav-link doccompra_tab" data-toggle="tab" href="#kt_tab_pane_doccompra"><b>Documentos de compras</b></a>
              </li>
            </ul>

            <div class="tab-content" id="myTabContent">
              <div class="tab-pane fade" id="kt_tab_pane_doccompra" role="tabpanel">
                <input type="hidden" id="op_doccompra" value="0">
                <div class="row">
                  <div class="col-md-4"></div>
                  <div class="col-md-8 oldcheck">
                    <input type='checkbox' id='all_doccompra'> Seleccionar todos
                  </div>
                </div>
                @foreach($doc_compra as $value)
                  <div class="row mt-2">
                    <div class="col-md-8">
                      <label>{{ $value->guard_names }}</label>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <span class="switch switch-icon">
                        <label>
                        <input type="checkbox" name="permission[]" {{(in_array($value->id , $permiso_roles_id)) ? 'checked' : ''}} class='doccompra_check all_ordencompra' value="{{ $value->id }}" />
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
          <div class="col-md-4">  
            <ul class="nav nav-tabs nav-tabs-line">
              <li class="nav-item">
                <a class="nav-link provecompra_tab" data-toggle="tab" href="#kt_tab_pane_provecompra"><b>Proveedores</b></a>
              </li>
            </ul>

            <div class="tab-content" id="myTabContent">
              <div class="tab-pane fade" id="kt_tab_pane_provecompra" role="tabpanel">
                <input type="hidden" id="op_provecompra" value="0">
                <div class="row">
                  <div class="col-md-4"></div>
                  <div class="col-md-8 oldcheck">
                    <input type='checkbox' id='all_provecompra'> Seleccionar todos
                  </div>
                </div>
                @foreach($proveedor_compra as $value)
                  <div class="row mt-2">
                    <div class="col-md-8">
                      <label>{{ $value->guard_names }}</label>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <span class="switch switch-icon">
                        <label>
                        <input type="checkbox" name="permission[]" {{(in_array($value->id , $permiso_roles_id)) ? 'checked' : ''}} class='provecompra_check all_ordencompra' value="{{ $value->id }}" />
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
          <div class="col-md-4">  
            <ul class="nav nav-tabs nav-tabs-line">
              <li class="nav-item">
                <a class="nav-link mepago_tab" data-toggle="tab" href="#kt_tab_pane_mepago"><b>Métodos de pago</b></a>
              </li>
            </ul>

            <div class="tab-content" id="myTabContent">
              <div class="tab-pane fade" id="kt_tab_pane_mepago" role="tabpanel">
                <input type="hidden" id="op_mepago" value="0">
                <div class="row">
                  <div class="col-md-4"></div>
                  <div class="col-md-8 oldcheck">
                    <input type='checkbox' id='all_mepago'> Seleccionar todos
                  </div>
                </div>
                @foreach($metodo_pago as $value)
                  <div class="row mt-2">
                    <div class="col-md-8">
                      <label>{{ $value->guard_names }}</label>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <span class="switch switch-icon">
                        <label>
                        <input type="checkbox" name="permission[]" {{(in_array($value->id , $permiso_roles_id)) ? 'checked' : ''}} class='mepago_check all_ordencompra' value="{{ $value->id }}" />
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

        <div class="row">
          <div class="col-md-4">  
            <ul class="nav nav-tabs nav-tabs-line">
              <li class="nav-item">
                <a class="nav-link formpago_tab" data-toggle="tab" href="#kt_tab_pane_formpago"><b>Formas de pago</b></a>
              </li>
            </ul>

            <div class="tab-content" id="myTabContent">
              <div class="tab-pane fade" id="kt_tab_pane_formpago" role="tabpanel">
                <input type="hidden" id="op_formpago" value="0">
                <div class="row">
                  <div class="col-md-4"></div>
                  <div class="col-md-8 oldcheck">
                    <input type='checkbox' id='all_formpago'> Seleccionar todos
                  </div>
                </div>
                @foreach($forma_pago as $value)
                  <div class="row mt-2">
                    <div class="col-md-8">
                      <label>{{ $value->guard_names }}</label>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <span class="switch switch-icon">
                        <label>
                        <input type="checkbox" name="permission[]" {{(in_array($value->id , $permiso_roles_id)) ? 'checked' : ''}} class='formpago_check all_ordencompra' value="{{ $value->id }}" />
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

          <div class="col-md-4">  
            <ul class="nav nav-tabs nav-tabs-line">
              <li class="nav-item">
                <a class="nav-link usocfdi_tab" data-toggle="tab" href="#kt_tab_pane_usocfdi"><b>Uso de CFDI</b></a>
              </li>
            </ul>

            <div class="tab-content" id="myTabContent">
              <div class="tab-pane fade" id="kt_tab_pane_usocfdi" role="tabpanel">
                <input type="hidden" id="op_usocfdi" value="0">
                <div class="row">
                  <div class="col-md-4"></div>
                  <div class="col-md-8 oldcheck">
                    <input type='checkbox' id='all_usocfdi'> Seleccionar todos
                  </div>
                </div>
                @foreach($uso_cdfi as $value)
                  <div class="row mt-2">
                    <div class="col-md-8">
                      <label>{{ $value->guard_names }}</label>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <span class="switch switch-icon">
                        <label>
                        <input type="checkbox" name="permission[]" {{(in_array($value->id , $permiso_roles_id)) ? 'checked' : ''}} class='usocfdi_check all_ordencompra' value="{{ $value->id }}" />
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