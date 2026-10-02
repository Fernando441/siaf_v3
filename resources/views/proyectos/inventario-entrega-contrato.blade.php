@extends('layouts.app')
@section('title')
    Ver unidad
@endsection
@push('scripts')

@endpush
@section('content')

    <div class="row">
        <div class="col-lg-12">
            <div class="card card-custom gutter-b">
                <div class="card-header">
                    <h3 class="card-title">Inventario de entrega</h3>
                </div>
                <form action="{{ route('asignarunidad.inventarioaddunidad') }}" method="post" id="submit_requisicion_unidad" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="licitacion_id" value="{{ $licitacion }}">
                <input type="hidden" name="unidad_id" value="{{ $unidad }}">
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
                                                      <input type="checkbox" name="poliza_seguro" {{($inventarioentrega->poliza_seguro == 1) ? 'checked' : ''}} disabled class='user_check all_generales' value="1" />
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
                                                      <input type="checkbox" name="manual" {{($inventarioentrega->manual == 1) ? 'checked' : ''}} disabled class='user_check all_generales' value="1" />
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
                                                      <input type="checkbox" name="lugar"  {{($inventarioentrega->lugar == 1) ? 'checked' : ''}} disabled class='user_check all_generales' value="1" />
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
                                                      <input type="checkbox" name="tarjeta_circulacion" {{($inventarioentrega->tarjeta_circulacion == 1) ? 'checked' : ''}} disabled  class='user_check all_generales' value="1" />
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
                                                      <input type="checkbox" name="verificacion_ambiental" {{($inventarioentrega->verificacion_ambiental == 1) ? 'checked' : ''}} disabled class='user_check all_generales' value="1" />
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
                                                      <input type="checkbox" name="kilometraje" {{($inventarioentrega->kilometraje == 1) ? 'checked' : ''}} disabled class='user_check all_generales' value="1" />
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
                                                      <input type="checkbox" name="tenencia" {{($inventarioentrega->tenencia == 1) ? 'checked' : ''}} disabled class='user_check all_generales' value="1" />
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
                                                      <input type="checkbox" name="poliza_garantia" {{($inventarioentrega->poliza_garantia == 1) ? 'checked' : ''}} disabled class='user_check all_generales' value="1" />
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
                                                      <input type="checkbox" name="aire_acondicionado" {{($inventarioentrega->aire_acondicionado == 1) ? 'checked' : ''}} disabled class='user_check all_generales' value="1" />
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
                                                      <input type="checkbox" name="llanta_refaccion" {{($inventarioentrega->llanta_refaccion == 1) ? 'checked' : ''}} disabled class='user_check all_generales' value="1" />
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
                                                      <input type="checkbox" name="tapon_aceite" {{($inventarioentrega->tapon_aceite == 1) ? 'checked' : ''}} disabled class='user_check all_generales' value="1" />
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
                                                      <input type="checkbox" name="calefaccion" {{($inventarioentrega->calefaccion == 1) ? 'checked' : ''}} disabled class='user_check all_generales' value="1" />
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
                                                      <input type="checkbox" name="gato" {{($inventarioentrega->gato == 1) ? 'checked' : ''}} disabled class='user_check all_generales' value="1" />
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
                                                      <input type="checkbox" name="tapon_agua" {{($inventarioentrega->tapon_agua == 1) ? 'checked' : ''}} disabled class='user_check all_generales' value="1" />
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
                                                      <input type="checkbox" name="radio" {{($inventarioentrega->radio == 1) ? 'checked' : ''}} disabled class='user_check all_generales' value="1" />
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
                                                      <input type="checkbox" name="llave_auxiliar" {{($inventarioentrega->llave_auxiliar == 1) ? 'checked' : ''}} disabled class='user_check all_generales' value="1" />
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
                                                      <input type="checkbox" name="tapon_gasolina" {{($inventarioentrega->tapon_gasolina == 1) ? 'checked' : ''}} disabled class='user_check all_generales' value="1" />
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
                                                      <input type="checkbox" name="antena" {{($inventarioentrega->antena == 1) ? 'checked' : ''}} disabled class='user_check all_generales' value="1" />
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
                                                      <input type="checkbox" name="herramienta" {{($inventarioentrega->herramienta == 1) ? 'checked' : ''}} disabled class='user_check all_generales' value="1" />
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
                                                      <input type="checkbox" name="defensa_lateral" {{($inventarioentrega->defensa_lateral == 1) ? 'checked' : ''}} disabled class='user_check all_generales' value="1" />
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
                                                      <input type="checkbox" name="encendedor" {{($inventarioentrega->encendedor == 1) ? 'checked' : ''}} disabled class='user_check all_generales' value="1" />
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
                                                      <input type="checkbox" name="extinguidor" {{($inventarioentrega->extinguidor == 1) ? 'checked' : ''}} disabled class='user_check all_generales' value="1" />
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
                                                      <input type="checkbox" name="defensa_trasera" {{($inventarioentrega->defensa_trasera == 1) ? 'checked' : ''}} disabled class='user_check all_generales' value="1" />
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
                                                      <input type="checkbox" name="ceniceros" {{($inventarioentrega->ceniceros == 1) ? 'checked' : ''}} disabled class='user_check all_generales' value="1" />
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
                                                      <input type="checkbox" name="calaveras" {{($inventarioentrega->calaveras == 1) ? 'checked' : ''}} disabled class='user_check all_generales' value="1" />
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
                                                      <input type="checkbox" name="tapetes" {{($inventarioentrega->tapetes == 1) ? 'checked' : ''}} disabled class='user_check all_generales' value="1" />
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
                                                      <input type="checkbox" name="manijas" {{($inventarioentrega->manijas == 1) ? 'checked' : ''}} disabled class='user_check all_generales' value="1" />
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
                                                      <input type="checkbox" name="parabrisas" {{($inventarioentrega->parabrisas == 1) ? 'checked' : ''}} disabled class='user_check all_generales' value="1" />
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
                                                      <input type="checkbox" name="viceras" {{($inventarioentrega->viceras == 1) ? 'checked' : ''}} disabled class='user_check all_generales' value="1" />
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
                                                      <input type="checkbox" name="elevadores" {{($inventarioentrega->elevadores == 1) ? 'checked' : ''}} disabled class='user_check all_generales' value="1" />
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
                                                      <input type="checkbox" name="medallon" {{($inventarioentrega->medallon == 1) ? 'checked' : ''}} disabled class='user_check all_generales' value="1" />
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
                                                      <input type="checkbox" name="biseles" {{($inventarioentrega->biseles == 1) ? 'checked' : ''}} disabled class='user_check all_generales' value="1" />
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
                                                      <input type="checkbox" name="espejo_retrovisor"  {{($inventarioentrega->espejo_retrovisor == 1) ? 'checked' : ''}} disabled class='user_check all_generales' value="1" />
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
                                                      <input type="checkbox" name="brazos_limpiadores" {{($inventarioentrega->brazos_limpiadores == 1) ? 'checked' : ''}} disabled class='user_check all_generales' value="1" />
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
                                                      <input type="checkbox" name="cuartos" {{($inventarioentrega->cuartos == 1) ? 'checked' : ''}} disabled class='user_check all_generales' value="1" />
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
                                                      <input type="checkbox" name="claxon" {{($inventarioentrega->claxon == 1) ? 'checked' : ''}} disabled class='user_check all_generales' value="1" />
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
                                                      <input type="checkbox" name="espejos_laterales" {{($inventarioentrega->espejos_laterales == 1) ? 'checked' : ''}} disabled class='user_check all_generales' value="1" />
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
                                                      <input type="checkbox" name="stop" {{($inventarioentrega->stop == 1) ? 'checked' : ''}} disabled class='user_check all_generales' value="1" />
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
                                                      <input type="checkbox" name="tapones_llantas" {{($inventarioentrega->tapones_llantas == 1) ? 'checked' : ''}} disabled class='user_check all_generales' value="1" />
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
                                                      <input type="checkbox" name="senales_carretera" {{($inventarioentrega->senales_carretera == 1) ? 'checked' : ''}} disabled class='user_check all_generales' value="1" />
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
                                                      <input type="checkbox" name="duplicado_llaves"  {{($inventarioentrega->duplicado_llaves == 1) ? 'checked' : ''}} disabled class='user_check all_generales' value="1" />
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
                                                      <input type="checkbox" name="reflejantes" {{($inventarioentrega->reflejantes == 1) ? 'checked' : ''}} disabled class='user_check all_generales' value="1" />
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
                                                      <input type="checkbox" name="cables_corriente" {{($inventarioentrega->cables_corriente == 1) ? 'checked' : ''}} disabled class='user_check all_generales' value="1" />
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
                                                      <input type="checkbox" name="acumulador" {{($inventarioentrega->acumulador == 1) ? 'checked' : ''}} disabled class='user_check all_generales' value="1" />
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
                                                <p>{{ $inventarioentrega->marca_llantas }}</p>
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
                                                      <input type="checkbox" name="llanta_delantera_derecha" {{($inventarioentrega->llanta_delantera_derecha == 1) ? 'checked' : ''}} disabled class='user_check all_generales' value="1" />
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
                                                      <input type="checkbox" name="llanta_delantera_izquierda" {{($inventarioentrega->llanta_delantera_izquierda == 1) ? 'checked' : ''}} disabled class='user_check all_generales' value="1" />
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
                                                      <input type="checkbox" name="llanta_trasera_derecha" {{($inventarioentrega->llanta_trasera_derecha == 1) ? 'checked' : ''}} disabled class='user_check all_generales' value="1" />
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
                                                      <input type="checkbox" name="llanta_trasera_izquierda" {{($inventarioentrega->llanta_trasera_izquierda == 1) ? 'checked' : ''}} disabled class='user_check all_generales' value="1" />
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
                                                      <input type="checkbox" name="llantar_refaccion" {{($inventarioentrega->llantar_refaccion == 1) ? 'checked' : ''}} disabled class='user_check all_generales' value="1" />
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
                                            <p>{{ $inventarioentrega->nivel_combustible }}</p>
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
                                  <p>{{ $inventarioentrega->nombre_jetvan }}</p>
                              </div>
                          </div>

                          <div class="col-lg-6 form-group">
                            <label>Fecha y hora de entrega</label>
                            <p>{{ $inventarioentrega->fecha_jetvan }}</p>
                          </div>
                        </div>


                        <div class="row">
                          <div class="col-lg-2 form-group">
                            <label>Personal</label>
                            @if($inventarioentrega->personal == 0)
                              <p>Interno</p>
                            @else
                              <p>Externo</p>
                            @endif
                          </div>


                          <div class="col-lg-6 form-group">
                              <label>Nombre de la persona que entregara el vehículo al cliente</label>
                              <div class="input-group">
                                <p>{{ $inventarioentrega->nombre_entrega }}</p>
                              </div>
                          </div>

                          <div class="col-lg-4 form-group">
                            <label>Fecha y hora de recepción</label>
                            <p>{{ $inventarioentrega->fecha_entrega }}</p>
                          </div>

                        </div>


                        <div class="row">
                          <div class="col-lg-6 form-group">
                              <label>Nombre de la persona que recibe el vehículo por parte del cliente</label>
                              <div class="input-group">
                                <p>{{ $inventarioentrega->nombre_cliente }}</p>
                              </div>
                          </div>

                          <div class="col-lg-6 form-group">
                            <label>Fecha y hora de recepción</label>
                            <p>{{ $inventarioentrega->fecha_recepcion }}</p>
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

                          <div class="col-lg-6 form-group">
                            <label>Tipo de translado</label>
                            @if($inventarioentrega->personal == 0)
                              <p>Rodado</p>
                            @else
                              <p>Transportado</p>
                            @endif
                          </div>

                          <div class="col-lg-6">
                            <label>Opciones</label>
                            @if($inventarioentrega->requiere_permiso == 0)
                              <p>Cuenta con placas</p>
                            @endif
                            @if($inventarioentrega->requiere_permiso == 1)
                              <p>Requiere translado con permiso</p>
                            @endif
                            @if($inventarioentrega->requiere_permiso == 2)
                              <p>Placas de translado</p>
                            @endif
                          </div> 


                        </div>

                        <div class="row form-group">
                          <div class="col-lg-4">
                            <label>Estado</label>
                            @foreach($estados as $estado)
                                @if($inventarioentrega->entidad_federativa == $estado->id_estado)
                                    <p>{{ $estado->estado_nombre }}</p>
                                @endif
                            @endforeach
                          </div>
                          <div class="col-lg-8">
                              <label>Colonia</label>
                              <div class="input-group">
                                  <p>{{ $inventarioentrega->colonia }}</p>
                              </div>
                          </div>

                        </div>

                        <div class="row form-group">
                          <div class="col-lg-8">
                              <label>Calle</label>
                              <div class="input-group">
                                  <p>{{ $inventarioentrega->calle }}</p>
                              </div>
                          </div>
                          <div class="col-lg-4">
                              <label>Número exterior</label>
                              <div class="input-group">
                                  <p>{{ $inventarioentrega->numero_ext }}</p>
                              </div>
                          </div>
                        </div>

                        <div class="row form-group">
                          <div class="col-lg-6">
                              <label>Número interior</label>
                              <div class="input-group">
                                  <p>{{ $inventarioentrega->numero_int }}</p>
                              </div>
                          </div>

                          <div class="col-lg-6">
                              <label>Codigo postal</label>
                              <div class="input-group">
                                  <p>{{ $inventarioentrega->codigo_postal }}</p>
                              </div>
                          </div>
                        </div>

                      </div>
                    </div>
                    {{-- //Direccion entrega end --}}


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
                            @foreach($estados as $estado)
                                @if($inventarioentrega->entidad_federativa_recoleccion == $estado->id_estado)
                                    <p>{{ $estado->estado_nombre }}</p>
                                @endif
                            @endforeach
                          </div>
                          <div class="col-lg-8">
                              <label>Colonia</label>
                              <div class="input-group">
                                  <p>{{ $inventarioentrega->colonia_recoleccion }}</p>
                              </div>
                          </div>

                        </div>

                        <div class="row form-group">
                          <div class="col-lg-8">
                              <label>Calle</label>
                              <div class="input-group">
                                  <p>{{ $inventarioentrega->calle_recoleccion }}</p>
                              </div>
                          </div>
                          <div class="col-lg-4">
                              <label>Número exterior</label>
                              <div class="input-group">
                                  <p>{{ $inventarioentrega->numero_ext_recoleccion }}</p>
                              </div>
                          </div>
                        </div>

                        <div class="row form-group">
                          <div class="col-lg-6">
                              <label>Número interior</label>
                              <div class="input-group">
                                  <p>{{ $inventarioentrega->numero_int_recoleccion }}</p>
                              </div>
                          </div>

                          <div class="col-lg-6">
                              <label>Codigo postal</label>
                              <div class="input-group">
                                  <p>{{ $inventarioentrega->codigo_postal_recoleccion }}</p>
                              </div>
                          </div>
                        </div>

                      </div>
                    </div>


                    <div class="row">
                      <div class="col-lg-12">
                        <label>Observaciones</label>
                        <p>{{ $inventarioentrega->observaciones }}</p>
                      </div>
                    </div>



                    <div class="card-footer px-0" style="padding-bottom: 0px;">
                        <div class="row">
                            <div class="col-lg-6">
                              @if($op == 1)
                                <a href="{{ route('proyecto.editarproyecto', $licitacion) }}"  class="btn btn-secondary"><i class="la la-arrow-left"></i>Regresar</a>
                              @endif

                              @if($op == 2)
                                <a href="{{ route('proyecto.verproyecto', $licitacion) }}"  class="btn btn-secondary"><i class="la la-arrow-left"></i>Regresar</a>
                              @endif

                              @if($op == 3)
                                <a href="{{ route('proyecto.unidadesasignadasproyecto', $licitacion) }}"  class="btn btn-secondary"><i class="la la-arrow-left"></i>Regresar</a>
                              @endif


                            </div>

                        </div>
                    </div>
                  </form>
                </div>
            </div>
        </div>
    </div>

@endsection
