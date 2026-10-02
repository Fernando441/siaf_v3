@extends('layouts.app')
@section('title')
    Ver unidad
@endsection
@push('scripts')
  <script src="{{ asset('js/unidades/AsignarUnidadContrato.js') }}"></script>
  <meta name="csrf-token" content="{{ csrf_token() }}" />
@endpush
@section('content')
  @if($inventarioentrega == null)
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-custom gutter-b">
                <div class="card-header">
                    <h3 class="card-title">Inventario de entrega</h3>
                    <div class="card-toolbar">
                        @if($unidad_info->op_unidad_nueva == 0)
                          <span class="label font-weight-bold  label-outline label-inline" style="font-size: 16px ; color: green; border: 1px solid green !important">Unidad Nueva</span>
                        @else
                          <span class="label font-weight-bold  label-outline label-inline" style="font-size: 16px ; color: orange; border: 1px solid orange !important">Unidad Seminueva</span>
                        @endif
                    </div>
                </div>
                <form action="{{ route('asignarunidad.inventarioaddunidad') }}" method="post" id="submit_asignar_unidad" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="licitacion_id" value="{{ $licitacion }}">
                <input type="hidden" name="unidad_id" value="{{ $unidad }}">
                <input type="hidden" name="patio_id" value="{{ $patio }}">
                <div class="card-body">

                    <div class="row">
                        <div class="col-lg-8">
                            @if($ver != 0)
                                <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                                  <div class="carousel-inner">

                                    @foreach($fotografias as $documento)
                                    <div class="carousel-item {{($ver == $documento->id) ? 'active' : ''}}">
                                      <img class="d-block w-100" src="{{ route('archivo.fotografiaUnidad', ['id'=>$documento->id]) }}" alt="Second slide">
                                    </div>
                                     @endforeach
                                  </div>
                                  <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Previous</span>
                                  </a>
                                  <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Next</span>
                                  </a>
                                </div>
                            @else
                                <img src="/img/no_disponible.png" width="300px">
                            @endif
                        </div>

                        <div class="col-lg-4 text-center">
                            <div class="form-group row mt-2">
                                <div class="col-lg-6 col-sm-6">
                                    <label>Marca</label>
                                    @foreach($marcas as $marca)
                                        @if($marca->id == $unidad_info->id_marca)
                                            <p>{{ strtoupper($marca->nombre_marca)}}</p>
                                        @endif
                                    @endforeach
                                </div>
                                <div class="col-lg-6 col-sm-6">
                                    <label>Modelo</label>
                                    @foreach($modelos as $model)
                                        @if($model->id == $unidad_info->id_modelo)
                                            <p>{{ strtoupper($model->nombre_modelo)}}</p>
                                        @endif
                                    @endforeach
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-lg-6 col-sm-6">
                                    <label>Número de serie</label>
                                    <p>{{ $unidad_info->no_serie }}</p>
                                </div>
                                <div class="col-lg-6 col-sm-6">
                                    <label>No. Factura de compra</label>
                                    <p>{{ $unidad_info->factura_compra }}</p>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-lg-6 col-sm-6">
                                    <label>Placa</label>
                                    <p>{{ $unidad_info->placa }}</p>
                                </div>
                                <div class="col-lg-6 col-sm-6">
                                    <label>Color</label>
                                    <p>{{ $unidad_info->color }}</p>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-lg-6 col-sm-6">
                                    <label>Año de la unidad</label>
                                    <p>{{ $unidad_info->unidad_year }}</p>
                                </div>
                                <div class="col-lg-6 col-sm-6">
                                    <label>Número de tarjeta de circulación</label>
                                    <p>{{ $unidad_info->no_tarjeta_circulacion }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

{{-- 
                    <div class="row">
                                    <div class="col-lg-6">
                                        <label>Contrato</label>
                                        <select class="form-control" name="contrato_id" id="contrato_id" required>
                                            <option value="">Selecciona una opción</option>
                                            @foreach ($proyectos as $ub)
                                                <option value="{{ $ub->id }}"   >Id contrato: {{ $ub->id_contrato }} / No.Contrato: {{ $ub->no_contrato }} 
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                    </div> --}}

{{-- ñlefdjnf --}}
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card card-custom gutter-b">
                                <div class="card-header">
                                    <div class="card-title">
                                        <h3 class="card-label">
                                            Documentos del vehiculo
                                        </h3>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row text-center">
                                        <div class="col-lg-4 col-sm-6">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Poliza de seguro</label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">    
                                                        
                                                      <span class="switch switch-icon">
                                                      <label>
                                                      <input type="checkbox" checked name="poliza_seguro" class='user_check all_generales' value="1" />
                                                      <span></span>
                                                      </label>
                                                      </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-sm-6">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Manual</label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">    
                                                        
                                                      <span class="switch switch-icon">
                                                      <label>
                                                      <input type="checkbox" checked name="manual" class='user_check all_generales' value="1" />
                                                      <span></span>
                                                      </label>
                                                      </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                     <div class="col-lg-4 col-sm-6">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Lugar</label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">    
                                                        
                                                      <span class="switch switch-icon">
                                                      <label>
                                                      <input type="checkbox" checked name="lugar" class='user_check all_generales' value="1" />
                                                      <span></span>
                                                      </label>
                                                      </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="row text-center">
                                        <div class="col-lg-4 col-sm-6">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>No. Tarjeta de circulación</label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">    
                                                        
                                                      <span class="switch switch-icon">
                                                      <label>
                                                      <input type="checkbox" checked name="tarjeta_circulacion" class='user_check all_generales' value="1" />
                                                      <span></span>
                                                      </label>
                                                      </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-sm-6">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Verificación ambiental</label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">    
                                                        
                                                      <span class="switch switch-icon">
                                                      <label>
                                                      <input type="checkbox" checked name="verificacion_ambiental" class='user_check all_generales' value="1" />
                                                      <span></span>
                                                      </label>
                                                      </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                     <div class="col-lg-4 col-sm-6">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Kilometraje</label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">    
                                                        
                                                      <span class="switch switch-icon">
                                                      <label>
                                                      <input type="checkbox" checked name="kilometraje" class='user_check all_generales' value="1" />
                                                      <span></span>
                                                      </label>
                                                      </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="row text-center">
                                        <div class="col-lg-4 col-sm-6">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Tenencia</label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">    
                                                        
                                                      <span class="switch switch-icon">
                                                      <label>
                                                      <input type="checkbox" checked name="tenencia" class='user_check all_generales' value="1" />
                                                      <span></span>
                                                      </label>
                                                      </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-sm-6">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Poliza de garantia de auto</label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">    
                                                        
                                                      <span class="switch switch-icon">
                                                      <label>
                                                      <input type="checkbox" checked name="poliza_garantia" class='user_check all_generales' value="1" />
                                                      <span></span>
                                                      </label>
                                                      </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- E Q U I P O  y  H E R R A M I E N T A  D E L   V E H I C U L O --}}
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card card-custom gutter-b">
                                <div class="card-header">
                                    <div class="card-title">
                                        <h3 class="card-label">
                                            Equipo y herramienta del vehiculo
                                        </h3>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row text-center">
                                        <div class="col-lg-4 col-sm-6">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Aire acondicionado</label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">    
                                                        
                                                      <span class="switch switch-icon">
                                                      <label>
                                                      <input type="checkbox" checked name="aire_acondicionado" class='user_check all_generales' value="1" />
                                                      <span></span>
                                                      </label>
                                                      </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-sm-6">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Llanta de refacción</label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">    
                                                        
                                                      <span class="switch switch-icon">
                                                      <label>
                                                      <input type="checkbox" checked name="llanta_refaccion" class='user_check all_generales' value="1" />
                                                      <span></span>
                                                      </label>
                                                      </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                     <div class="col-lg-4 col-sm-6">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Tapon de aceite</label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">    
                                                        
                                                      <span class="switch switch-icon">
                                                      <label>
                                                      <input type="checkbox" checked name="tapon_aceite" class='user_check all_generales' value="1" />
                                                      <span></span>
                                                      </label>
                                                      </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="row text-center">
                                        <div class="col-lg-4 col-sm-6">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Calefacción</label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">    
                                                        
                                                      <span class="switch switch-icon">
                                                      <label>
                                                      <input type="checkbox" checked name="calefaccion" class='user_check all_generales' value="1" />
                                                      <span></span>
                                                      </label>
                                                      </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-sm-6">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Gato</label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">    
                                                        
                                                      <span class="switch switch-icon">
                                                      <label>
                                                      <input type="checkbox" checked name="gato" class='user_check all_generales' value="1" />
                                                      <span></span>
                                                      </label>
                                                      </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                     <div class="col-lg-4 col-sm-6">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Tapon de agua</label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">    
                                                        
                                                      <span class="switch switch-icon">
                                                      <label>
                                                      <input type="checkbox" checked name="tapon_agua" class='user_check all_generales' value="1" />
                                                      <span></span>
                                                      </label>
                                                      </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="row text-center">
                                        <div class="col-lg-4 col-sm-6">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Radio AM/FM</label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">    
                                                        
                                                      <span class="switch switch-icon">
                                                      <label>
                                                      <input type="checkbox" checked name="radio" class='user_check all_generales' value="1" />
                                                      <span></span>
                                                      </label>
                                                      </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-sm-6">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Llave auxiliar</label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">    
                                                        
                                                      <span class="switch switch-icon">
                                                      <label>
                                                      <input type="checkbox" checked name="llave_auxiliar" class='user_check all_generales' value="1" />
                                                      <span></span>
                                                      </label>
                                                      </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-sm-6">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Tapon de gasolina</label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">    
                                                        
                                                      <span class="switch switch-icon">
                                                      <label>
                                                      <input type="checkbox" checked name="tapon_gasolina" class='user_check all_generales' value="1" />
                                                      <span></span>
                                                      </label>
                                                      </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="row text-center">
                                        <div class="col-lg-4 col-sm-6">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Antena</label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">    
                                                        
                                                      <span class="switch switch-icon">
                                                      <label>
                                                      <input type="checkbox" checked name="antena" class='user_check all_generales' value="1" />
                                                      <span></span>
                                                      </label>
                                                      </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-sm-6">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Herramienta</label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">    
                                                        
                                                      <span class="switch switch-icon">
                                                      <label>
                                                      <input type="checkbox" checked name="herramienta" class='user_check all_generales' value="1" />
                                                      <span></span>
                                                      </label>
                                                      </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-sm-6">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Defensa lateral</label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">    
                                                        
                                                      <span class="switch switch-icon">
                                                      <label>
                                                      <input type="checkbox" checked name="defensa_lateral" class='user_check all_generales' value="1" />
                                                      <span></span>
                                                      </label>
                                                      </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="row text-center">
                                        <div class="col-lg-4 col-sm-6">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Encendedor</label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">    
                                                        
                                                      <span class="switch switch-icon">
                                                      <label>
                                                      <input type="checkbox" checked name="encendedor" class='user_check all_generales' value="1" />
                                                      <span></span>
                                                      </label>
                                                      </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-sm-6">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Extinguidor</label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">    
                                                        
                                                      <span class="switch switch-icon">
                                                      <label>
                                                      <input type="checkbox" checked name="extinguidor" class='user_check all_generales' value="1" />
                                                      <span></span>
                                                      </label>
                                                      </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-sm-6">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Defensa trasera</label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">    
                                                        
                                                      <span class="switch switch-icon">
                                                      <label>
                                                      <input type="checkbox" checked name="defensa_trasera" class='user_check all_generales' value="1" />
                                                      <span></span>
                                                      </label>
                                                      </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>



                                    <div class="row text-center">
                                        <div class="col-lg-4 col-sm-6">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Ceniceros</label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">    
                                                        
                                                      <span class="switch switch-icon">
                                                      <label>
                                                      <input type="checkbox" checked name="ceniceros" class='user_check all_generales' value="1" />
                                                      <span></span>
                                                      </label>
                                                      </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-sm-6">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Calaveras</label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">    
                                                        
                                                      <span class="switch switch-icon">
                                                      <label>
                                                      <input type="checkbox" checked name="calaveras" class='user_check all_generales' value="1" />
                                                      <span></span>
                                                      </label>
                                                      </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-sm-6">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Tapetes</label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">    
                                                        
                                                      <span class="switch switch-icon">
                                                      <label>
                                                      <input type="checkbox" checked name="tapetes" class='user_check all_generales' value="1" />
                                                      <span></span>
                                                      </label>
                                                      </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row text-center">
                                        <div class="col-lg-4 col-sm-6">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Manijas</label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">    
                                                        
                                                      <span class="switch switch-icon">
                                                      <label>
                                                      <input type="checkbox" checked name="manijas" class='user_check all_generales' value="1" />
                                                      <span></span>
                                                      </label>
                                                      </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-sm-6">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Parabrisas</label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">    
                                                        
                                                      <span class="switch switch-icon">
                                                      <label>
                                                      <input type="checkbox" checked name="parabrisas" class='user_check all_generales' value="1" />
                                                      <span></span>
                                                      </label>
                                                      </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-sm-6">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Viceras</label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">    
                                                        
                                                      <span class="switch switch-icon">
                                                      <label>
                                                      <input type="checkbox" checked name="viceras" class='user_check all_generales' value="1" />
                                                      <span></span>
                                                      </label>
                                                      </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="row text-center">
                                        <div class="col-lg-4 col-sm-6">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Elevadores</label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">    
                                                        
                                                      <span class="switch switch-icon">
                                                      <label>
                                                      <input type="checkbox" checked name="elevadores" class='user_check all_generales' value="1" />
                                                      <span></span>
                                                      </label>
                                                      </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-sm-6">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Medallon</label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">    
                                                        
                                                      <span class="switch switch-icon">
                                                      <label>
                                                      <input type="checkbox" checked name="medallon" class='user_check all_generales' value="1" />
                                                      <span></span>
                                                      </label>
                                                      </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-sm-6">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Biseles</label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">    
                                                        
                                                      <span class="switch switch-icon">
                                                      <label>
                                                      <input type="checkbox" checked name="biseles" class='user_check all_generales' value="1" />
                                                      <span></span>
                                                      </label>
                                                      </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row text-center">
                                        <div class="col-lg-4 col-sm-6">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Espejo retrovisor</label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">    
                                                        
                                                      <span class="switch switch-icon">
                                                      <label>
                                                      <input type="checkbox" checked name="espejo_retrovisor" class='user_check all_generales' value="1" />
                                                      <span></span>
                                                      </label>
                                                      </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-sm-6">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Brazos limpiadores</label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">    
                                                        
                                                      <span class="switch switch-icon">
                                                      <label>
                                                      <input type="checkbox" checked name="brazos_limpiadores" class='user_check all_generales' value="1" />
                                                      <span></span>
                                                      </label>
                                                      </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-sm-6">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Cuartos</label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">    
                                                        
                                                      <span class="switch switch-icon">
                                                      <label>
                                                      <input type="checkbox" checked name="cuartos" class='user_check all_generales' value="1" />
                                                      <span></span>
                                                      </label>
                                                      </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row text-center">
                                        <div class="col-lg-4 col-sm-6">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Claxon</label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">    
                                                        
                                                      <span class="switch switch-icon">
                                                      <label>
                                                      <input type="checkbox" checked name="claxon" class='user_check all_generales' value="1" />
                                                      <span></span>
                                                      </label>
                                                      </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-sm-6">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Espejos laterales</label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">    
                                                        
                                                      <span class="switch switch-icon">
                                                      <label>
                                                      <input type="checkbox" checked name="espejos_laterales" class='user_check all_generales' value="1" />
                                                      <span></span>
                                                      </label>
                                                      </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-sm-6">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Stop</label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">    
                                                        
                                                      <span class="switch switch-icon">
                                                      <label>
                                                      <input type="checkbox" checked name="stop" class='user_check all_generales' value="1" />
                                                      <span></span>
                                                      </label>
                                                      </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="row text-center">
                                        <div class="col-lg-4 col-sm-6">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Tapones de llantas</label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">    
                                                        
                                                      <span class="switch switch-icon">
                                                      <label>
                                                      <input type="checkbox" checked name="tapones_llantas" class='user_check all_generales' value="1" />
                                                      <span></span>
                                                      </label>
                                                      </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-sm-6">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Señales de carretera</label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">    
                                                        
                                                      <span class="switch switch-icon">
                                                      <label>
                                                      <input type="checkbox" checked name="senales_carretera" class='user_check all_generales' value="1" />
                                                      <span></span>
                                                      </label>
                                                      </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-sm-6">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Duplicado de llaves</label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">    
                                                        
                                                      <span class="switch switch-icon">
                                                      <label>
                                                      <input type="checkbox" checked name="duplicado_llaves" class='user_check all_generales' value="1" />
                                                      <span></span>
                                                      </label>
                                                      </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="row text-center">
                                        <div class="col-lg-4 col-sm-6">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Reflejantes</label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">    
                                                        
                                                      <span class="switch switch-icon">
                                                      <label>
                                                      <input type="checkbox" checked name="reflejantes" class='user_check all_generales' value="1" />
                                                      <span></span>
                                                      </label>
                                                      </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-sm-6">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Cables para corriente</label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">    
                                                        
                                                      <span class="switch switch-icon">
                                                      <label>
                                                      <input type="checkbox" checked name="cables_corriente" class='user_check all_generales' value="1" />
                                                      <span></span>
                                                      </label>
                                                      </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-sm-6">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Acumulador</label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">    
                                                        
                                                      <span class="switch switch-icon">
                                                      <label>
                                                      <input type="checkbox" checked name="acumulador" class='user_check all_generales' value="1" />
                                                      <span></span>
                                                      </label>
                                                      </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row text-center">

                                    </div>




                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- copiar --}}
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="card card-custom gutter-b">
                                <div class="card-header">
                                    <div class="card-title">
                                        <h3 class="card-label">
                                            Estado de las llantas
                                        </h3>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-12 form-group">
                                            <label>Marca</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="marca_llantas" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()" required/>
                                            </div>
                                        </div>


                                        <div class="col-lg-6 col-sm-6">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Delantero der.</label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">    
                                                        
                                                      <span class="switch switch-icon">
                                                      <label>
                                                      <input type="checkbox" checked name="llanta_delantera_derecha" class='user_check all_generales' value="1" />
                                                      <span></span>
                                                      </label>
                                                      </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-6 col-sm-6">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Delantero izq.</label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">    
                                                        
                                                      <span class="switch switch-icon">
                                                      <label>
                                                      <input type="checkbox" checked name="llanta_delantera_izquierda" class='user_check all_generales' value="1" />
                                                      <span></span>
                                                      </label>
                                                      </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="row">
                                        <div class="col-lg-6 col-sm-6">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Traseros der.</label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">    
                                                        
                                                      <span class="switch switch-icon">
                                                      <label>
                                                      <input type="checkbox" checked name="llanta_trasera_derecha" class='user_check all_generales' value="1" />
                                                      <span></span>
                                                      </label>
                                                      </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-6 col-sm-6">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Traseros izq.</label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">    
                                                        
                                                      <span class="switch switch-icon">
                                                      <label>
                                                      <input type="checkbox" checked name="llanta_trasera_izquierda" class='user_check all_generales' value="1" />
                                                      <span></span>
                                                      </label>
                                                      </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-6 col-sm-6">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Refacción</label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">    
                                                        
                                                      <span class="switch switch-icon">
                                                      <label>
                                                      <input type="checkbox" checked name="llantar_refaccion" class='user_check all_generales' value="1" />
                                                      <span></span>
                                                      </label>
                                                      </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="card card-custom gutter-b">
                                <div class="card-header">
                                    <div class="card-title">
                                        <h3 class="card-label">
                                            Obervaciones generales
                                        </h3>
                                    </div>
                                </div>
                                <div class="card-body">
                                    
                                    <div class="col-lg-12 text-center">
                                        <img src="/img/medidor_gasolina.jpg" width="300px">
                                    </div>
                                    <div class="col-lg-12 form-group">
                                        <label>Nivel de combustible</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="nivel_combustible" required/>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- END COMBUSTIBLE --}}

                    <div class="card card-custom gutter-b">
                      <div class="card-header">
                        <div class="card-title">
                          <h3 class="card-label">
                            Logística
                          </h3>
                        </div>
                      </div>
                      <div class="card-body">
                        <div class="row">
                          <div class="col-lg-6 form-group">
                              <label>Nombre de la persona de JETVAN, que entrega el vehículo</label>
                              <div class="input-group">
                                  <input type="text" class="form-control" name="nombre_jetvan" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()" required/>
                              </div>
                          </div>

                          <div class="col-lg-6 form-group">
                            <label>Fecha y hora de entrega</label>
                            <input type="datetime-local" name="fecha_jetvan" required class="form-control"  id="fecha_jetvan">
                          </div>
                        </div>


                        <div class="row">
                          <div class="col-lg-2 form-group">
                            <label>Personal</label>
                            <div class="radio-inline">
                              <label class="radio">
                                  <input type="radio" checked name="personal" value="0" />
                                  <span></span>
                                  Interno
                              </label>
                              <label class="radio">
                                  <input type="radio" name="personal" value="1" />
                                  <span></span>
                                  Externo
                              </label>
                            </div>
                          </div>


                          <div class="col-lg-6 form-group">
                              <label>Nombre de la persona que entregara el vehículo al cliente</label>
                              <div class="input-group">
                                  <input type="text" class="form-control" name="nombre_entrega" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()" required/>
                              </div>
                          </div>

                          <div class="col-lg-4 form-group">
                            <label>Fecha y hora de recepción</label>
                            <input type="datetime-local" name="fecha_entrega" required class="form-control"  id="fecha_entrega">
                          </div>

                        </div>


                        <div class="row">
                          <div class="col-lg-6 form-group">
                              <label>Nombre de la persona que recibe el vehículo por parte del cliente</label>
                              <div class="input-group">
                                  <input type="text" class="form-control" name="nombre_cliente" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()" required/>
                              </div>
                          </div>

                          <div class="col-lg-6 form-group">
                            <label>Fecha y hora de recepción</label>
                            <input type="datetime-local" name="fecha_recepcion" required class="form-control"  id="fecha_recepcion">
                          </div>
                        </div>

                      </div>
                    </div>

                    <div class="card card-custom gutter-b">
                      <div class="card-header">
                        <div class="card-title">
                          <h3 class="card-label">
                            <small>Dirección de entrega</small>
                          </h3>
                        </div>
                      </div>
                      <div class="card-body">

                        <div class="row form-group">
                          <div class="col-lg-6">
                            <label>Tipo de translado</label>
                            <div class="radio-inline">
                              <label class="radio">
                                  <input type="radio" checked name="tipo_translado" value="0" />
                                  <span></span>
                                  Rodado
                              </label>
                              <label class="radio">
                                  <input type="radio"   name="tipo_translado" value="1" />
                                  <span></span>
                                  Transportado
                              </label>
                            </div>
                          </div> 

                          <div class="col-lg-6">
                            <label>Opciones</label>
                            <div class="radio-inline">
                              <label class="radio">
                                  <input type="radio" checked name="requiere_permiso" value="0" />
                                  <span></span>
                                  Cuenta con placas
                              </label>
                              <label class="radio">
                                  <input type="radio"   name="requiere_permiso" value="1" />
                                  <span></span>
                                  Requiere translado con permiso
                              </label>
                              <label class="radio">
                                  <input type="radio"   name="requiere_permiso" value="2" />
                                  <span></span>
                                  Placas de translado
                              </label>

                            </div>
                          </div> 

                        </div>

                        <div class="row form-group">
                          <div class="col-lg-4">
                            <label>Estado</label>
                            <select class="form-control" id="entidad_federativa" name="entidad_federativa"  required >
                              <option value="">Selecciona una opción</option>
                              @foreach($estados as $estado)
                                <option value="{{ $estado->id_estado }}" >{{ $estado->estado_nombre }}</option>
                              @endforeach
                            </select>
                          </div>

                          <div class="col-lg-8">
                              <label>Colonia</label>
                              <div class="input-group">
                                  <input type="text" class="form-control" name="colonia"  onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()" required/>
                              </div>
                          </div>

                        </div>

                        <div class="row form-group">
                          <div class="col-lg-8">
                              <label>Calle</label>
                              <div class="input-group">
                                  <input type="text" class="form-control" name="calle"  onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()" required/>
                              </div>
                          </div>
                          <div class="col-lg-4">
                              <label>Número exterior</label>
                              <div class="input-group">
                                  <input type="text" class="form-control" name="numero_ext"  onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                              </div>
                          </div>
                        </div>

                        <div class="row form-group">
                          <div class="col-lg-6">
                              <label>Número interior</label>
                              <div class="input-group">
                                  <input type="text" class="form-control" name="numero_int"  onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                              </div>
                          </div>

                          <div class="col-lg-6">
                              <label>Codigo postal</label>
                              <div class="input-group">
                                  <input type="text" class="form-control" name="codigo_postal"  onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                              </div>
                          </div>
                        </div>

                      </div>
                    </div>
                    {{-- Direccion de entrega end --}}


                    <div class="card card-custom gutter-b">
                      <div class="card-header">
                        <div class="card-title">
                          <h3 class="card-label">
                            <small>Dirección de recolección</small>
                          </h3>
                        </div>
                      </div>
                      <div class="card-body">

                        <div class="row form-group">
                          <div class="col-lg-4">
                            <label>Estado</label>
                            <select class="form-control" id="entidad_federativa_recoleccion" name="entidad_federativa_recoleccion"  required >
                              <option value="">Selecciona una opción</option>
                              @foreach($estados as $estado)
                                <option value="{{ $estado->id_estado }}" >{{ $estado->estado_nombre }}</option>
                              @endforeach
                            </select>
                          </div>

                          <div class="col-lg-8">
                              <label>Colonia</label>
                              <div class="input-group">
                                  <input type="text" class="form-control" name="colonia_recoleccion"  onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()" required/>
                              </div>
                          </div>

                        </div>

                        <div class="row form-group">
                          <div class="col-lg-8">
                              <label>Calle</label>
                              <div class="input-group">
                                  <input type="text" class="form-control" name="calle_recoleccion"  onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()" required/>
                              </div>
                          </div>
                          <div class="col-lg-4">
                              <label>Número exterior</label>
                              <div class="input-group">
                                  <input type="text" class="form-control" name="numero_ext_recoleccion"  onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                              </div>
                          </div>
                        </div>

                        <div class="row form-group">
                          <div class="col-lg-6">
                              <label>Número interior</label>
                              <div class="input-group">
                                  <input type="text" class="form-control" name="numero_int_recoleccion"  onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                              </div>
                          </div>

                          <div class="col-lg-6">
                              <label>Codigo postal</label>
                              <div class="input-group">
                                  <input type="text" class="form-control" name="codigo_postal_recoleccion"  onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                              </div>
                          </div>
                        </div>

                      </div>
                    </div>


                    <div class="row">
                      <div class="col-lg-12">
                        <label>Observaciones</label>
                        <textarea class="form-control" name="observaciones" id="observaciones" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"></textarea>
                      </div>
                    </div>



                    <div class="card-footer px-0" style="padding-bottom: 0px;">
                        <div class="row">
                            <div class="col-lg-6">
                              <button type="submit"  id="btnGuardar" class="btn btn-primary mr-2">Guardar inventario</button>
                                <a href="{{ route('asignarunidad.asignarunidadespatio', [$licitacion, $patio]) }}"  class="btn btn-secondary"><i class="la la-arrow-left"></i>Regresar</a>
                            </div>

                        </div>
                    </div>
                  </form>
                </div>
            </div>
        </div>
    </div>

{{-- //NOTA --}}
   @else


    <div class="row">
        <div class="col-lg-12">
            <div class="card card-custom gutter-b">
                <div class="card-header">
                    <h3 class="card-title">Inventario de entrega</h3>
                </div>
                <form action="{{ route('asignarunidad.inventarioaddunidad') }}" method="post" id="submit_asignar_unidad" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="licitacion_id" value="{{ $licitacion }}">
                <input type="hidden" name="unidad_id" value="{{ $unidad }}">
                <input type="hidden" name="patio_id" value="{{ $patio }}">
                <div class="card-body">

                    <div class="row">
                        <div class="col-lg-8">
                            @if($ver != 0)
                                <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                                  <div class="carousel-inner">

                                    @foreach($fotografias as $documento)
                                    <div class="carousel-item {{($ver == $documento->id) ? 'active' : ''}}">
                                      <img class="d-block w-100" src="{{ route('archivo.fotografiaUnidad', ['id'=>$documento->id]) }}" alt="Second slide">
                                    </div>
                                     @endforeach
                                  </div>
                                  <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Previous</span>
                                  </a>
                                  <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Next</span>
                                  </a>
                                </div>
                            @else
                                <img src="/img/no_disponible.png" width="300px">
                            @endif
                        </div>

                        <div class="col-lg-4 text-center">
                            <div class="form-group row mt-2">
                                <div class="col-lg-6 col-sm-6">
                                    <label>Marca</label>
                                    @foreach($marcas as $marca)
                                        @if($marca->id == $unidad_info->id_marca)
                                            <p>{{ strtoupper($marca->nombre_marca)}}</p>
                                        @endif
                                    @endforeach
                                </div>
                                <div class="col-lg-6 col-sm-6">
                                    <label>Modelo</label>
                                    @foreach($modelos as $model)
                                        @if($model->id == $unidad_info->id_modelo)
                                            <p>{{ strtoupper($model->nombre_modelo)}}</p>
                                        @endif
                                    @endforeach
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-lg-6 col-sm-6">
                                    <label>Número de serie</label>
                                    <p>{{ $unidad_info->no_serie }}</p>
                                </div>
                                <div class="col-lg-6 col-sm-6">
                                    <label>No. Factura de compra</label>
                                    <p>{{ $unidad_info->factura_compra }}</p>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-lg-6 col-sm-6">
                                    <label>Placa</label>
                                    <p>{{ $unidad_info->placa }}</p>
                                </div>
                                <div class="col-lg-6 col-sm-6">
                                    <label>Color</label>
                                    <p>{{ $unidad_info->color }}</p>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-lg-6 col-sm-6">
                                    <label>Año de la unidad</label>
                                    <p>{{ $unidad_info->unidad_year }}</p>
                                </div>
                                <div class="col-lg-6 col-sm-6">
                                    <label>Número de tarjeta de circulación</label>
                                    <p>{{ $unidad_info->no_tarjeta_circulacion }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
{{-- 

                    <div class="row">
                                    <div class="col-lg-6">
                                        <label>Contrato</label>
                                        <select class="form-control" name="contrato_id" id="contrato_id" required>
                                            <option value="">Selecciona una opción</option>
                                            @foreach ($proyectos as $ub)
                                                <option value="{{ $ub->id }}" @selected($ub->id == $inventarioentrega->proyectos_id)>Id contrato: {{ $ub->id_contrato }} / No.Contrato: {{ $ub->no_contrato }} 
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                    </div> --}}


                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card card-custom gutter-b">
                                <div class="card-header">
                                    <div class="card-title">
                                        <h3 class="card-label">
                                            Documentos del vehiculo
                                        </h3>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row text-center">
                                        <div class="col-lg-4 col-sm-6">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Poliza de seguro</label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">    
                                                        
                                                      <span class="switch switch-icon">
                                                      <label>
                                                      <input type="checkbox" name="poliza_seguro" {{($inventarioentrega->poliza_seguro == 1) ? 'checked' : ''}} class='user_check all_generales' value="1" />
                                                      <span></span>
                                                      </label>
                                                      </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-sm-6">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Manual</label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">    
                                                        
                                                      <span class="switch switch-icon">
                                                      <label>
                                                      <input type="checkbox" name="manual" {{($inventarioentrega->manual == 1) ? 'checked' : ''}} class='user_check all_generales' value="1" />
                                                      <span></span>
                                                      </label>
                                                      </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                     <div class="col-lg-4 col-sm-6">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Lugar</label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">    
                                                        
                                                      <span class="switch switch-icon">
                                                      <label>
                                                      <input type="checkbox" name="lugar"  {{($inventarioentrega->lugar == 1) ? 'checked' : ''}} class='user_check all_generales' value="1" />
                                                      <span></span>
                                                      </label>
                                                      </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="row text-center">
                                        <div class="col-lg-4 col-sm-6">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>No. Tarjeta de circulación</label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">    
                                                        
                                                      <span class="switch switch-icon">
                                                      <label>
                                                      <input type="checkbox" name="tarjeta_circulacion" {{($inventarioentrega->tarjeta_circulacion == 1) ? 'checked' : ''}}   class='user_check all_generales' value="1" />
                                                      <span></span>
                                                      </label>
                                                      </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-sm-6">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Verificación ambiental</label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">    
                                                        
                                                      <span class="switch switch-icon">
                                                      <label>
                                                      <input type="checkbox" name="verificacion_ambiental" {{($inventarioentrega->verificacion_ambiental == 1) ? 'checked' : ''}} class='user_check all_generales' value="1" />
                                                      <span></span>
                                                      </label>
                                                      </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                     <div class="col-lg-4 col-sm-6">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Kilometraje</label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">    
                                                        
                                                      <span class="switch switch-icon">
                                                      <label>
                                                      <input type="checkbox" name="kilometraje" {{($inventarioentrega->kilometraje == 1) ? 'checked' : ''}} class='user_check all_generales' value="1" />
                                                      <span></span>
                                                      </label>
                                                      </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="row text-center">
                                        <div class="col-lg-4 col-sm-6">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Tenencia</label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">    
                                                        
                                                      <span class="switch switch-icon">
                                                      <label>
                                                      <input type="checkbox" name="tenencia" {{($inventarioentrega->tenencia == 1) ? 'checked' : ''}} class='user_check all_generales' value="1" />
                                                      <span></span>
                                                      </label>
                                                      </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-sm-6">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Poliza de garantia de auto</label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">    
                                                        
                                                      <span class="switch switch-icon">
                                                      <label>
                                                      <input type="checkbox" name="poliza_garantia" {{($inventarioentrega->poliza_garantia == 1) ? 'checked' : ''}} class='user_check all_generales' value="1" />
                                                      <span></span>
                                                      </label>
                                                      </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- E Q U I P O  y  H E R R A M I E N T A  D E L   V E H I C U L O --}}
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card card-custom gutter-b">
                                <div class="card-header">
                                    <div class="card-title">
                                        <h3 class="card-label">
                                            Equipo y herramienta del vehiculo
                                        </h3>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row text-center">
                                        <div class="col-lg-4 col-sm-6">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Aire acondicionado</label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">    
                                                        
                                                      <span class="switch switch-icon">
                                                      <label>
                                                      <input type="checkbox" name="aire_acondicionado" {{($inventarioentrega->aire_acondicionado == 1) ? 'checked' : ''}} class='user_check all_generales' value="1" />
                                                      <span></span>
                                                      </label>
                                                      </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-sm-6">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Llanta de refacción</label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">    
                                                        
                                                      <span class="switch switch-icon">
                                                      <label>
                                                      <input type="checkbox" name="llanta_refaccion" {{($inventarioentrega->llanta_refaccion == 1) ? 'checked' : ''}} class='user_check all_generales' value="1" />
                                                      <span></span>
                                                      </label>
                                                      </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                     <div class="col-lg-4 col-sm-6">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Tapon de aceite</label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">    
                                                        
                                                      <span class="switch switch-icon">
                                                      <label>
                                                      <input type="checkbox" name="tapon_aceite" {{($inventarioentrega->tapon_aceite == 1) ? 'checked' : ''}} class='user_check all_generales' value="1" />
                                                      <span></span>
                                                      </label>
                                                      </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="row text-center">
                                        <div class="col-lg-4 col-sm-6">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Calefacción</label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">    
                                                        
                                                      <span class="switch switch-icon">
                                                      <label>
                                                      <input type="checkbox" name="calefaccion" {{($inventarioentrega->calefaccion == 1) ? 'checked' : ''}} class='user_check all_generales' value="1" />
                                                      <span></span>
                                                      </label>
                                                      </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-sm-6">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Gato</label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">    
                                                        
                                                      <span class="switch switch-icon">
                                                      <label>
                                                      <input type="checkbox" name="gato" {{($inventarioentrega->gato == 1) ? 'checked' : ''}} class='user_check all_generales' value="1" />
                                                      <span></span>
                                                      </label>
                                                      </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                     <div class="col-lg-4 col-sm-6">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Tapon de agua</label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">    
                                                        
                                                      <span class="switch switch-icon">
                                                      <label>
                                                      <input type="checkbox" name="tapon_agua" {{($inventarioentrega->tapon_agua == 1) ? 'checked' : ''}} class='user_check all_generales' value="1" />
                                                      <span></span>
                                                      </label>
                                                      </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="row text-center">
                                        <div class="col-lg-4 col-sm-6">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Radio AM/FM</label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">    
                                                        
                                                      <span class="switch switch-icon">
                                                      <label>
                                                      <input type="checkbox" name="radio" {{($inventarioentrega->radio == 1) ? 'checked' : ''}} class='user_check all_generales' value="1" />
                                                      <span></span>
                                                      </label>
                                                      </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-sm-6">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Llave auxiliar</label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">    
                                                        
                                                      <span class="switch switch-icon">
                                                      <label>
                                                      <input type="checkbox" name="llave_auxiliar" {{($inventarioentrega->llave_auxiliar == 1) ? 'checked' : ''}} class='user_check all_generales' value="1" />
                                                      <span></span>
                                                      </label>
                                                      </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-sm-6">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Tapon de gasolina</label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">    
                                                        
                                                      <span class="switch switch-icon">
                                                      <label>
                                                      <input type="checkbox" name="tapon_gasolina" {{($inventarioentrega->tapon_gasolina == 1) ? 'checked' : ''}} class='user_check all_generales' value="1" />
                                                      <span></span>
                                                      </label>
                                                      </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="row text-center">
                                        <div class="col-lg-4 col-sm-6">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Antena</label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">    
                                                        
                                                      <span class="switch switch-icon">
                                                      <label>
                                                      <input type="checkbox" name="antena" {{($inventarioentrega->antena == 1) ? 'checked' : ''}} class='user_check all_generales' value="1" />
                                                      <span></span>
                                                      </label>
                                                      </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-sm-6">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Herramienta</label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">    
                                                        
                                                      <span class="switch switch-icon">
                                                      <label>
                                                      <input type="checkbox" name="herramienta" {{($inventarioentrega->herramienta == 1) ? 'checked' : ''}} class='user_check all_generales' value="1" />
                                                      <span></span>
                                                      </label>
                                                      </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-sm-6">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Defensa lateral</label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">    
                                                        
                                                      <span class="switch switch-icon">
                                                      <label>
                                                      <input type="checkbox" name="defensa_lateral" {{($inventarioentrega->defensa_lateral == 1) ? 'checked' : ''}} class='user_check all_generales' value="1" />
                                                      <span></span>
                                                      </label>
                                                      </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="row text-center">
                                        <div class="col-lg-4 col-sm-6">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Encendedor</label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">    
                                                        
                                                      <span class="switch switch-icon">
                                                      <label>
                                                      <input type="checkbox" name="encendedor" {{($inventarioentrega->encendedor == 1) ? 'checked' : ''}} class='user_check all_generales' value="1" />
                                                      <span></span>
                                                      </label>
                                                      </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-sm-6">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Extinguidor</label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">    
                                                        
                                                      <span class="switch switch-icon">
                                                      <label>
                                                      <input type="checkbox" name="extinguidor" {{($inventarioentrega->extinguidor == 1) ? 'checked' : ''}} class='user_check all_generales' value="1" />
                                                      <span></span>
                                                      </label>
                                                      </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-sm-6">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Defensa trasera</label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">    
                                                        
                                                      <span class="switch switch-icon">
                                                      <label>
                                                      <input type="checkbox" name="defensa_trasera" {{($inventarioentrega->defensa_trasera == 1) ? 'checked' : ''}} class='user_check all_generales' value="1" />
                                                      <span></span>
                                                      </label>
                                                      </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>



                                    <div class="row text-center">
                                        <div class="col-lg-4 col-sm-6">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Ceniceros</label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">    
                                                        
                                                      <span class="switch switch-icon">
                                                      <label>
                                                      <input type="checkbox" name="ceniceros" {{($inventarioentrega->ceniceros == 1) ? 'checked' : ''}} class='user_check all_generales' value="1" />
                                                      <span></span>
                                                      </label>
                                                      </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-sm-6">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Calaveras</label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">    
                                                        
                                                      <span class="switch switch-icon">
                                                      <label>
                                                      <input type="checkbox" name="calaveras" {{($inventarioentrega->calaveras == 1) ? 'checked' : ''}} class='user_check all_generales' value="1" />
                                                      <span></span>
                                                      </label>
                                                      </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-sm-6">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Tapetes</label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">    
                                                        
                                                      <span class="switch switch-icon">
                                                      <label>
                                                      <input type="checkbox" name="tapetes" {{($inventarioentrega->tapetes == 1) ? 'checked' : ''}} class='user_check all_generales' value="1" />
                                                      <span></span>
                                                      </label>
                                                      </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row text-center">
                                        <div class="col-lg-4 col-sm-6">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Manijas</label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">    
                                                        
                                                      <span class="switch switch-icon">
                                                      <label>
                                                      <input type="checkbox" name="manijas" {{($inventarioentrega->manijas == 1) ? 'checked' : ''}} class='user_check all_generales' value="1" />
                                                      <span></span>
                                                      </label>
                                                      </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-sm-6">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Parabrisas</label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">    
                                                        
                                                      <span class="switch switch-icon">
                                                      <label>
                                                      <input type="checkbox" name="parabrisas" {{($inventarioentrega->parabrisas == 1) ? 'checked' : ''}} class='user_check all_generales' value="1" />
                                                      <span></span>
                                                      </label>
                                                      </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-sm-6">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Viceras</label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">    
                                                        
                                                      <span class="switch switch-icon">
                                                      <label>
                                                      <input type="checkbox" name="viceras" {{($inventarioentrega->viceras == 1) ? 'checked' : ''}} class='user_check all_generales' value="1" />
                                                      <span></span>
                                                      </label>
                                                      </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="row text-center">
                                        <div class="col-lg-4 col-sm-6">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Elevadores</label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">    
                                                        
                                                      <span class="switch switch-icon">
                                                      <label>
                                                      <input type="checkbox" name="elevadores" {{($inventarioentrega->elevadores == 1) ? 'checked' : ''}} class='user_check all_generales' value="1" />
                                                      <span></span>
                                                      </label>
                                                      </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-sm-6">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Medallon</label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">    
                                                        
                                                      <span class="switch switch-icon">
                                                      <label>
                                                      <input type="checkbox" name="medallon" {{($inventarioentrega->medallon == 1) ? 'checked' : ''}} class='user_check all_generales' value="1" />
                                                      <span></span>
                                                      </label>
                                                      </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-sm-6">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Biseles</label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">    
                                                        
                                                      <span class="switch switch-icon">
                                                      <label>
                                                      <input type="checkbox" name="biseles" {{($inventarioentrega->biseles == 1) ? 'checked' : ''}} class='user_check all_generales' value="1" />
                                                      <span></span>
                                                      </label>
                                                      </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row text-center">
                                        <div class="col-lg-4 col-sm-6">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Espejo retrovisor</label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">    
                                                        
                                                      <span class="switch switch-icon">
                                                      <label>
                                                      <input type="checkbox" name="espejo_retrovisor"  {{($inventarioentrega->espejo_retrovisor == 1) ? 'checked' : ''}} class='user_check all_generales' value="1" />
                                                      <span></span>
                                                      </label>
                                                      </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-sm-6">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Brazos limpiadores</label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">    
                                                        
                                                      <span class="switch switch-icon">
                                                      <label>
                                                      <input type="checkbox" name="brazos_limpiadores" {{($inventarioentrega->brazos_limpiadores == 1) ? 'checked' : ''}} class='user_check all_generales' value="1" />
                                                      <span></span>
                                                      </label>
                                                      </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-sm-6">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Cuartos</label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">    
                                                        
                                                      <span class="switch switch-icon">
                                                      <label>
                                                      <input type="checkbox" name="cuartos" {{($inventarioentrega->cuartos == 1) ? 'checked' : ''}} class='user_check all_generales' value="1" />
                                                      <span></span>
                                                      </label>
                                                      </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row text-center">
                                        <div class="col-lg-4 col-sm-6">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Claxon</label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">    
                                                        
                                                      <span class="switch switch-icon">
                                                      <label>
                                                      <input type="checkbox" name="claxon" {{($inventarioentrega->claxon == 1) ? 'checked' : ''}} class='user_check all_generales' value="1" />
                                                      <span></span>
                                                      </label>
                                                      </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-sm-6">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Espejos laterales</label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">    
                                                        
                                                      <span class="switch switch-icon">
                                                      <label>
                                                      <input type="checkbox" name="espejos_laterales" {{($inventarioentrega->espejos_laterales == 1) ? 'checked' : ''}}  class='user_check all_generales' value="1" />
                                                      <span></span>
                                                      </label>
                                                      </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-sm-6">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Stop</label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">    
                                                        
                                                      <span class="switch switch-icon">
                                                      <label>
                                                      <input type="checkbox" name="stop" {{($inventarioentrega->stop == 1) ? 'checked' : ''}} class='user_check all_generales' value="1" />
                                                      <span></span>
                                                      </label>
                                                      </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="row text-center">
                                        <div class="col-lg-4 col-sm-6">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Tapones de llantas</label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">    
                                                        
                                                      <span class="switch switch-icon">
                                                      <label>
                                                      <input type="checkbox" name="tapones_llantas" {{($inventarioentrega->tapones_llantas == 1) ? 'checked' : ''}} class='user_check all_generales' value="1" />
                                                      <span></span>
                                                      </label>
                                                      </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-sm-6">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Señales de carretera</label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">    
                                                        
                                                      <span class="switch switch-icon">
                                                      <label>
                                                      <input type="checkbox" name="senales_carretera" {{($inventarioentrega->senales_carretera == 1) ? 'checked' : ''}} class='user_check all_generales' value="1" />
                                                      <span></span>
                                                      </label>
                                                      </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-sm-6">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Duplicado de llaves</label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">    
                                                        
                                                      <span class="switch switch-icon">
                                                      <label>
                                                      <input type="checkbox" name="duplicado_llaves"  {{($inventarioentrega->duplicado_llaves == 1) ? 'checked' : ''}} class='user_check all_generales' value="1" />
                                                      <span></span>
                                                      </label>
                                                      </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="row text-center">
                                        <div class="col-lg-4 col-sm-6">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Reflejantes</label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">    
                                                        
                                                      <span class="switch switch-icon">
                                                      <label>
                                                      <input type="checkbox" name="reflejantes" {{($inventarioentrega->reflejantes == 1) ? 'checked' : ''}} class='user_check all_generales' value="1" />
                                                      <span></span>
                                                      </label>
                                                      </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-sm-6">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Cables para corriente</label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">    
                                                        
                                                      <span class="switch switch-icon">
                                                      <label>
                                                      <input type="checkbox" name="cables_corriente" {{($inventarioentrega->cables_corriente == 1) ? 'checked' : ''}} class='user_check all_generales' value="1" />
                                                      <span></span>
                                                      </label>
                                                      </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-sm-6">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Acumulador</label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">    
                                                        
                                                      <span class="switch switch-icon">
                                                      <label>
                                                      <input type="checkbox" name="acumulador" {{($inventarioentrega->acumulador == 1) ? 'checked' : ''}} class='user_check all_generales' value="1" />
                                                      <span></span>
                                                      </label>
                                                      </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row text-center">

                                    </div>




                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-lg-6">
                            <div class="card card-custom gutter-b">
                                <div class="card-header">
                                    <div class="card-title">
                                        <h3 class="card-label">
                                            Estado de las llantas
                                        </h3>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-12 form-group">
                                            <label>Marca</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="marca_llantas" value="{{ $inventarioentrega->marca_llantas }}" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()" required/>
                                            </div>
                                        </div>


                                        <div class="col-lg-6 col-sm-6">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Delantero der.</label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">    
                                                        
                                                      <span class="switch switch-icon">
                                                      <label>
                                                      <input type="checkbox" name="llanta_delantera_derecha" {{($inventarioentrega->llanta_delantera_derecha == 1) ? 'checked' : ''}} class='user_check all_generales' value="1" />
                                                      <span></span>
                                                      </label>
                                                      </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-6 col-sm-6">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Delantero izq.</label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">    
                                                        
                                                      <span class="switch switch-icon">
                                                      <label>
                                                      <input type="checkbox" name="llanta_delantera_izquierda" {{($inventarioentrega->llanta_delantera_izquierda == 1) ? 'checked' : ''}}  class='user_check all_generales' value="1" />
                                                      <span></span>
                                                      </label>
                                                      </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="row">
                                        <div class="col-lg-6 col-sm-6">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Traseros der.</label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">    
                                                        
                                                      <span class="switch switch-icon">
                                                      <label>
                                                      <input type="checkbox" name="llanta_trasera_derecha" {{($inventarioentrega->llanta_trasera_derecha == 1) ? 'checked' : ''}}  class='user_check all_generales' value="1" />
                                                      <span></span>
                                                      </label>
                                                      </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-6 col-sm-6">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Traseros izq.</label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">    
                                                        
                                                      <span class="switch switch-icon">
                                                      <label>
                                                      <input type="checkbox" name="llanta_trasera_izquierda" {{($inventarioentrega->llanta_trasera_izquierda == 1) ? 'checked' : ''}} class='user_check all_generales' value="1" />
                                                      <span></span>
                                                      </label>
                                                      </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-6 col-sm-6">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Refacción</label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">    
                                                        
                                                      <span class="switch switch-icon">
                                                      <label>
                                                      <input type="checkbox" name="llantar_refaccion" {{($inventarioentrega->llantar_refaccion == 1) ? 'checked' : ''}} class='user_check all_generales' value="1" />
                                                      <span></span>
                                                      </label>
                                                      </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="card card-custom gutter-b">
                                <div class="card-header">
                                    <div class="card-title">
                                        <h3 class="card-label">
                                            Obervaciones generales
                                        </h3>
                                    </div>
                                </div>
                                <div class="card-body">
                                    
                                    <div class="col-lg-12 text-center">
                                        <img src="/img/medidor_gasolina.jpg" width="300px">
                                    </div>
                                    <div class="col-lg-12 form-group">
                                        <label>Nivel de combustible</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="nivel_combustible" value="{{ $inventarioentrega->nivel_combustible }}" required/>
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
                            Logística
                          </h3>
                        </div>
                      </div>
                      <div class="card-body">
                        <div class="row">
                          <div class="col-lg-6 form-group">
                              <label>Nombre de la persona de JETVAN, que entrega el vehículo</label>
                              <div class="input-group">
                                  <input type="text" class="form-control" name="nombre_jetvan" value="{{ $inventarioentrega->nombre_jetvan }}" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()" required/>
                              </div>
                          </div>

                          <div class="col-lg-6 form-group">
                            <label>Fecha y hora de entrega</label>
                            <input type="datetime-local" name="fecha_jetvan" value="{{ $inventarioentrega->fecha_jetvan }}" required class="form-control"  id="fecha_jetvan">
                          </div>
                        </div>


                        <div class="row">
                          <div class="col-lg-2 form-group">
                            <label>Personal</label>
                            <div class="radio-inline">
                              <label class="radio">
                                  <input type="radio" {{($inventarioentrega->personal == 0) ? 'checked' : ''}}  name="personal" value="0" />
                                  <span></span>
                                  Interno
                              </label>
                              <label class="radio">
                                  <input type="radio" {{($inventarioentrega->personal == 1) ? 'checked' : ''}}  name="personal" value="1" />
                                  <span></span>
                                  Externo
                              </label>
                            </div>
                          </div>


                          <div class="col-lg-6 form-group">
                              <label>Nombre de la persona que entregara el vehículo al cliente</label>
                              <div class="input-group">
                                  <input type="text" class="form-control" name="nombre_entrega" value="{{ $inventarioentrega->nombre_entrega }}" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()" required/>
                              </div>
                          </div>

                          <div class="col-lg-4 form-group">
                            <label>Fecha y hora de recepción</label>
                            <input type="datetime-local" name="fecha_entrega" value="{{ $inventarioentrega->fecha_entrega }}" required class="form-control"  id="fecha_entrega">
                          </div>

                        </div>


                        <div class="row">
                          <div class="col-lg-6 form-group">
                              <label>Nombre de la persona que recibe el vehículo por parte del cliente</label>
                              <div class="input-group">
                                  <input type="text" class="form-control" name="nombre_cliente" value="{{ $inventarioentrega->nombre_cliente }}" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()" required/>
                              </div>
                          </div>

                          <div class="col-lg-6 form-group">
                            <label>Fecha y hora de recepción</label>
                            <input type="datetime-local" name="fecha_recepcion" value="{{ $inventarioentrega->fecha_recepcion }}" required class="form-control"  id="fecha_recepcion">
                          </div>
                        </div>
                      </div>
                    </div>


                    <div class="card card-custom gutter-b">
                      <div class="card-header">
                        <div class="card-title">
                          <h3 class="card-label">
                            <small>Dirección de entrega</small>
                          </h3>
                        </div>
                      </div>
                      <div class="card-body">

                        <div class="row form-group">
                          <div class="col-lg-6">
                            <label>Tipo de translado</label>
                            <div class="radio-inline">
                              <label class="radio">
                                  <input type="radio" {{($inventarioentrega->tipo_translado == 0) ? 'checked' : ''}}  name="tipo_translado" value="0" />
                                  <span></span>
                                  Rodado
                              </label>
                              <label class="radio">
                                  <input type="radio" {{($inventarioentrega->tipo_translado == 1) ? 'checked' : ''}}  name="tipo_translado" value="1" />
                                  <span></span>
                                  Transportado
                              </label>
                            </div>
                          </div>  


                          <div class="col-lg-6">
                            <label>Opciones</label>
                            <div class="radio-inline">
                              <label class="radio">
                                  <input type="radio" {{($inventarioentrega->requiere_permiso == 0) ? 'checked' : ''}}   name="requiere_permiso" value="0" />
                                  <span></span>
                                  Cuenta con placas
                              </label>
                              <label class="radio">
                                  <input type="radio" {{($inventarioentrega->requiere_permiso == 1) ? 'checked' : ''}}    name="requiere_permiso" value="1" />
                                  <span></span>
                                  Requiere translado con permiso
                              </label>
                              <label class="radio">
                                  <input type="radio"  {{($inventarioentrega->requiere_permiso == 2) ? 'checked' : ''}}   name="requiere_permiso" value="2" />
                                  <span></span>
                                  Placas de translado
                              </label>

                            </div>
                          </div> 

                        </div>

                        <div class="row form-group">
                          <div class="col-lg-4">
                            <label>Estado</label>
                            <select class="form-control" id="entidad_federativa" name="entidad_federativa"  required >
                              <option value="">Selecciona una opción</option>
                                @foreach($estados as $estado)
                                  <option value="{{ $estado->id_estado }}" @selected($inventarioentrega->entidad_federativa == $estado->id_estado) >{{ $estado->estado_nombre }}</option>
                                @endforeach
                            </select>
                          </div>
                          <div class="col-lg-8">
                              <label>Colonia</label>
                              <div class="input-group">
                                  <input type="text" class="form-control" name="colonia" value="{{ $inventarioentrega->colonia }}" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()" required/>
                              </div>
                          </div>

                        </div>

                        <div class="row form-group">
                          <div class="col-lg-8">
                              <label>Calle</label>
                              <div class="input-group">
                                  <input type="text" class="form-control" name="calle" value="{{ $inventarioentrega->calle }}" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()" required/>
                              </div>
                          </div>
                          <div class="col-lg-4">
                              <label>Número exterior</label>
                              <div class="input-group">
                                  <input type="text" class="form-control" name="numero_ext" value="{{ $inventarioentrega->numero_ext }}" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                              </div>
                          </div>
                        </div>

                        <div class="row form-group">
                          <div class="col-lg-6">
                              <label>Número interior</label>
                              <div class="input-group">
                                  <input type="text" class="form-control" name="numero_int" value="{{ $inventarioentrega->numero_int }}" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                              </div>
                          </div>

                          <div class="col-lg-6">
                              <label>Codigo postal</label>
                              <div class="input-group">
                                  <input type="text" class="form-control" name="codigo_postal" value="{{ $inventarioentrega->codigo_postal }}" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                              </div>
                          </div>
                        </div>

                      </div>
                    </div>

                    {{-- Direccion_entrega end --}}



                    <div class="card card-custom gutter-b">
                      <div class="card-header">
                        <div class="card-title">
                          <h3 class="card-label">
                            <small>Dirección de recolección</small>
                          </h3>
                        </div>
                      </div>
                      <div class="card-body">

                        <div class="row form-group">
                          <div class="col-lg-4">
                            <label>Estado</label>
                            <select class="form-control" id="entidad_federativa_recoleccion" name="entidad_federativa_recoleccion"  required >
                              <option value="">Selecciona una opción</option>
                                @foreach($estados as $estado)
                                  <option value="{{ $estado->id_estado }}" @selected($inventarioentrega->entidad_federativa_recoleccion == $estado->id_estado) >{{ $estado->estado_nombre }}</option>
                                @endforeach
                            </select>
                          </div>

                          <div class="col-lg-8">
                              <label>Colonia</label>
                              <div class="input-group">
                                  <input type="text" class="form-control" name="colonia_recoleccion" value="{{ $inventarioentrega->colonia_recoleccion }}" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()" required/>
                              </div>
                          </div>

                        </div>

                        <div class="row form-group">
                          <div class="col-lg-8">
                              <label>Calle</label>
                              <div class="input-group">
                                  <input type="text" class="form-control" name="calle_recoleccion" value="{{ $inventarioentrega->calle_recoleccion }}" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()" required/>
                              </div>
                          </div>
                          <div class="col-lg-4">
                              <label>Número exterior</label>
                              <div class="input-group">
                                  <input type="text" class="form-control" name="numero_ext_recoleccion" value="{{ $inventarioentrega->numero_ext_recoleccion }}" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                              </div>
                          </div>
                        </div>

                        <div class="row form-group">
                          <div class="col-lg-6">
                              <label>Número interior</label>
                              <div class="input-group">
                                  <input type="text" class="form-control" name="numero_int_recoleccion" value="{{ $inventarioentrega->numero_int_recoleccion }}" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                              </div>
                          </div>

                          <div class="col-lg-6">
                              <label>Codigo postal</label>
                              <div class="input-group">
                                  <input type="text" class="form-control" name="codigo_postal_recoleccion" value="{{ $inventarioentrega->codigo_postal_recoleccion }}" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                              </div>
                          </div>
                        </div>

                      </div>
                    </div>



                    <div class="row">
                      <div class="col-lg-12">
                        <label>Observaciones</label>
                        <textarea class="form-control" name="observaciones" id="observaciones" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">{{ $inventarioentrega->observaciones }}</textarea>
                      </div>
                    </div>



                    <div class="card-footer px-0" style="padding-bottom: 0px;">
                        <div class="row">
                            <div class="col-lg-6">
                              <button type="submit"  id="btnGuardar" class="btn btn-primary mr-2">Guardar inventario</button>
                                <a href="{{ route('asignarunidad.asignarunidadespatio', [$licitacion, $patio]) }}"  class="btn btn-secondary"><i class="la la-arrow-left"></i>Regresar</a>
                            </div>

                        </div>
                    </div>
                  </form>
                </div>
            </div>
        </div>
    </div>



@endif
@endsection
