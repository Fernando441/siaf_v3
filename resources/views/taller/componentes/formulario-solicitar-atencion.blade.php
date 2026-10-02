<!--begin::Form-->
<form class="form" id="solicitaratencion" method="POST" enctype="multipart/form-data"
    action="{{ route('taller.registrarsolicitud') }}">
    @csrf
    <input type="hidden" name="no_serie" value="{{ $unidad->no_serie }}">
    @push('scripts')
        <script>
            $("#informacion").hide();
        </script>
    @endpush
    <div class="card-body">
        @if (Session::has('servicio'))
            <h5 class="my-6 font-size-h3 text-center">Tipo de solicitud: <span style="text-transform: capitalize;"
                    class="text-primary font-weight-bolder font-size-h3">
                    {{ Session::get('servicio') }}</span></h5>
            <input type="hidden" name="tipo_solicitud" value="{{ Session::get('servicio') }}">
            {{-- Si es cliente = 1 --}}
            <input type="hidden" name="redirect" value="1"> 
        @endif
        @include('taller.componentes.informacion-unidad')
        <div class="form-group row my-6">
            <div class="col-lg-12">
                <h3 class="font-size-h6 mb-5">Ultimos mantenimientos</h3>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-checkable" id="kt_datatable">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Tipo</th>
                                <th>Concepto</th>
                                <th>Importe</th>
                                <th>Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($ultimos_mantenimientos as $mantenimiento)
                                <tr>
                                    <td>{{ date('d/m/Y h:m', strtotime($mantenimiento->fecha_cita)) }}</td>
                                    <td style="text-transform: capitalize;">{{ $mantenimiento->tipo_solicitud }}</td>
                                    <td style="text-transform: capitalize;">{{ $mantenimiento->concepto }}</td>
                                    <td>$ {{ number_format($mantenimiento->importe, 2, '.', ',') }}</td>
                                    <td>
                                        <a href="#" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon"
                                            title="Ver detalles">
                                            <i class="flaticon-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div>
                    @if (!Session::has('servicio'))
                        <div class="form-group m-0">
                            <label>Seleccione el tipo de solicitud</label>
                            <div class="row">
                                <div class="col-lg-3">
                                    <label class="option">
                                        <span class="option-control">
                                            <span class="radio">
                                                <input type="radio" name="tipo_solicitud" value="correctivo"
                                                    checked="checked" />
                                                <span></span>
                                            </span>
                                        </span>
                                        <span class="option-label">
                                            <span class="option-head">
                                                <span class="option-title">
                                                    Correctivo
                                                </span>
                                                <span class="option-focus">
                                                    <i class="flaticon-settings-1"></i>
                                                </span>
                                            </span>
                                        </span>
                                    </label>
                                </div>
                                <div class="col-lg-3">
                                    <label class="option">
                                        <span class="option-control">
                                            <span class="radio">
                                                <input type="radio" name="tipo_solicitud" value="preventivo" />
                                                <span></span>
                                            </span>
                                        </span>
                                        <span class="option-label">
                                            <span class="option-head">
                                                <span class="option-title">
                                                    Preventivo
                                                </span>
                                                <span class="option-focus">
                                                    <i class="flaticon-interface-1"></i>
                                                </span>
                                            </span>
                                        </span>
                                    </label>
                                </div>
                                <div class="col-lg-3">
                                    <label class="option">
                                        <span class="option-control">
                                            <span class="radio">
                                                <input type="radio" name="tipo_solicitud" value="siniestro" />
                                                <span></span>
                                            </span>
                                        </span>
                                        <span class="option-label">
                                            <span class="option-head">
                                                <span class="option-title">
                                                    Siniestro
                                                </span>
                                                <span class="option-focus">
                                                    <i class="flaticon2-warning"></i>
                                                </span>
                                            </span>
                                        </span>
                                    </label>
                                </div>
                                <div class="col-lg-3">
                                    <label class="option">
                                        <span class="option-control">
                                            <span class="radio">
                                                <input type="radio" name="tipo_solicitud" value="administrativo" />
                                                <span></span>
                                            </span>
                                        </span>
                                        <span class="option-label">
                                            <span class="option-head">
                                                <span class="option-title">
                                                    Administrativo
                                                </span>
                                                <span class="option-focus">
                                                    <i class="flaticon2-file-2"></i>
                                                </span>
                                            </span>
                                        </span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-lg-6">
                <label>Kilometraje Actual</label>
                <input type="text" class="form-control form-control-md" id="kilometraje" name="kilometraje"
                    placeholder="Kilometraje actual" required>
            </div>

            <div class="col-lg-6">
                <label>Prioridad</label>
                <div class="radio-inline">
                    <label class="radio">
                        <input type="radio" checked name="prioridad" value="0" />
                        <span></span>
                        Alta
                    </label>
                    <label class="radio">
                        <input type="radio" name="prioridad" value="1" />
                        <span></span>
                        Media
                    </label>
                    <label class="radio">
                        <input type="radio" name="prioridad" value="2" />
                        <span></span>
                        Baja
                    </label>
                </div>
            </div>

            <div class="col-lg-6">
{{--                 <label>Odómetro y tarjeta de circulación <i class="fas fa-info-circle" data-toggle="tooltip"
                        data-placement="top"
                        title="Tomar foto del odometro junto a la tarjeta de circulacion"></i></label> --}}
                <div class="custom-file">
                    <input type="hidden" class="custom-file-input form-control form-control-lg" id="foto_odometro"
                        name="foto_odometro">
                    {{-- <label class="custom-file-label" for="foto_odometro">Seleccionar archivo</label> --}}
                </div>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-lg-12">
                <label>Concepto</label>
                <select name="concepto" id="concepto" class="form-control form-control-md" required>
                    <option value="">Seleccionar concepto</option>
                    <option value="cambio_aceite">Cambio de aceite del motor</option>
                    <option value="rotacion_neumaticos">Rotación de neumáticos</option>
                    <option value="cambio_filtro_aire">Cambio de filtro de aire</option>
                    <option value="cambio_filtro_aceite">Cambio de filtro de aceite</option>
                    <option value="verificacion_liquido_frenos">Verificación de líquido de frenos</option>
                    <option value="cambio_pastillas_freno">Cambio de pastillas de freno</option>
                    <option value="inspeccion_liquido_transmision">Inspección de líquido de transmisión</option>
                    <option value="verificacion_correa_distribucion">Verificación de la correa de distribución</option>
                    <option value="reemplazo_bujias">Reemplazo de bujías</option>
                    <option value="inspeccion_cables_bujias">Inspección de los cables de las bujías</option>
                    <option value="revision_presion_neumaticos">Revisión de la presión de los neumáticos</option>
                    <option value="alineacion_ruedas">Alineación de ruedas</option>
                    <option value="verificacion_luces_faros">Verificación de luces y faros</option>
                    <option value="cambio_liquido_direccion">Cambio de líquido de dirección asistida</option>
                    <option value="inspeccion_bateria">Inspección de batería</option>
                    <option value="cambio_filtro_combustible">Cambio de filtro de combustible</option>
                    <option value="inspeccion_escape_emisiones">Inspección de escape y sistema de emisiones</option>
                    <option value="verificacion_nivel_refrigerante">Verificación del nivel de
                        refrigerante/anticongelante</option>
                    <option value="inspeccion_banda_serpentina">Inspección de la banda serpentina</option>
                    <option value="cambio_liquido_transmision">Cambio de líquido de transmisión</option>
                    <option value="revision_amortiguadores_suspension">Revisión de amortiguadores y suspensión</option>
                    <option value="inspeccion_correas">Inspección de correas</option>
                    <option value="cambio_balatas_freno">Cambio de balatas de freno</option>
                    <option value="verificacion_nivel_aceite_diferencial">Verificación de nivel de aceite en
                        diferencial</option>
                    <option value="inspeccion_aire_acondicionado">Inspección de sistema de aire acondicionado</option>
                    <option value="limpieza_inyectores">Limpieza de inyectores</option>
                    <option value="verificacion_liquido_limpiaparabrisas">Verificación de líquido de limpiaparabrisas
                    </option>
                    <option value="limpieza_sistema_admision_aire">Limpieza de sistema de admisión de aire</option>
                    <option value="verificacion_sistema_calefaccion">Verificación del sistema de calefacción</option>
                    <option value="inspeccion_general_seguridad">Inspección general de seguridad</option>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-lg-12">
                <label>Observaciones</label>
                <textarea class="form-control form-control-lg" id="observaciones" name="observaciones" rows="3"
                    placeholder="Observaciones" required></textarea>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-lg-12">
                <label>Ubicacion Actual de la unidad</label>
                <input type="text" class="form-control form-control-lg" id="domicilio" name="domicilio"
                    placeholder="Domicilio" required>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-lg-6">
                <label>Codigo Postal</label>
                <input type="text" class="form-control form-control-lg" id="codigopostal" name="codigopostal"
                    placeholder="Codigo Postal" required>
            </div>

            <div class="col-lg-3">
                <label>Solicita traslado?</label>
                <div class="radio-inline form-control-lg">
                    <label class="radio">
                        <input type="radio" name="traslado" value="1" />
                        <span></span>Si</label>
                    <label class="radio">
                        <input type="radio" name="traslado" value="0" checked="checked" />
                        <span></span>No</label>
                </div>
            </div>

            <div class="col-lg-3">
                <label>Solicita sustituto?</label>
                <div class="radio-inline form-control-lg">
                    <label class="radio">
                        <input type="radio" name="sustituto" value="1" />
                        <span></span>Si</label>
                    <label class="radio">
                        <input type="radio" name="sustituto" value="0" checked="checked" />
                        <span></span>No</label>
                </div>
            </div>
{{--             <div class="col-lg-6">
                <label>Taller</label>
                <select name="taller" id="taller" class="form-control form-control-md" required>
                    <option value="">Seleccionar taller</option>
                    @foreach ($talleres as $taller)
                        <option value="{{ $taller->id }}">{{ $taller->nombre }}</option>
                    @endforeach
                </select>
            </div> --}}
        </div>
        @if (Session::get('servicio') == 'correctivo')
            <div class="form-group row">
                <div class="col-lg-6">
                    <label>Descripción de la falla</label>
                    <input type="text" class="form-control form-control-lg" id="falla" name="falla"
                        placeholder="Descripción de la falla" required>
                </div>
            </div>
        @endif
    </div>
    <div class="card-footer">
        <div class="row">
            <div class="col-lg-12 d-flex" style="justify-content: space-between;">
                <button type="button" id="registrarSolicitud" class="btn btn-primary mr-2 px-5 btn-md"><i class="la la-plus"></i>Registrar
                    Solicitud</button>
                <a href="{{ route('taller.solicitaratencion') }}" class="btn btn-secondary btn-md"><i class="la la-arrow-left"></i>Regresar</a>
            </div>
        </div>
    </div>
</form>
