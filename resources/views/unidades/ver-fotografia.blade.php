@if($ver != 0)
    <div class="row pb-10">
        <div class="col-lg-8">
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
        </div>
        <div class="col-lg-4 text-center">
            <div class="form-group row mt-2">
                <div class="col-lg-6 col-sm-6">
                    <label>Marca</label>
                    @foreach($marcas as $marca)
                        @if($marca->id == $unidad->id_marca)
                            <p>{{ strtoupper($marca->nombre_marca)}}</p>
                        @endif
                    @endforeach
                </div>
                <div class="col-lg-6 col-sm-6">
                    <label>Modelo</label>
                    @foreach($modelos as $model)
                        @if($model->id == $unidad->id_modelo)
                            <p>{{ strtoupper($model->nombre_modelo)}}</p>
                        @endif
                    @endforeach
                </div>
            </div>

            <div class="form-group row">
                <div class="col-lg-6 col-sm-6">
                    <label>Número de serie</label>
                    <p>{{ $unidad->no_serie }}</p>
                </div>
                <div class="col-lg-6 col-sm-6">
                    <label>No. Factura de compra</label>
                    <p>{{ $unidad->factura_compra }}</p>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-lg-6 col-sm-6">
                    <label>Placa</label>
                    <p>{{ $unidad->placa }}</p>
                </div>
                <div class="col-lg-6 col-sm-6">
                    <label>Color</label>
                    <p>{{ $unidad->color }}</p>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-lg-6 col-sm-6">
                    <label>Año de la unidad</label>
                    <p>{{ $unidad->unidad_year }}</p>
                </div>
                <div class="col-lg-6 col-sm-6">
                    <label>Número de tarjeta de circulación</label>
                    <p>{{ $unidad->no_tarjeta_circulacion }}</p>
                </div>
            </div>
        </div>
    </div>
@else

    <div class="row pb-10">
        <div class="col-lg-8 text-center">
            <img src="/img/no_disponible.png" width="300px">
        </div>
        <div class="col-lg-4 text-center">
            <div class="form-group row mt-2">
                <div class="col-lg-6 col-sm-6">
                    <label>Marca</label>
                    @foreach($marcas as $marca)
                        @if($marca->id == $unidad->id_marca)
                            <p>{{ strtoupper($marca->nombre_marca)}}</p>
                        @endif
                    @endforeach
                </div>
                <div class="col-lg-6 col-sm-6">
                    <label>Modelo</label>
                    @foreach($modelos as $model)
                        @if($model->id == $unidad->id_modelo)
                            <p>{{ strtoupper($model->nombre_modelo)}}</p>
                        @endif
                    @endforeach
                </div>
            </div>

            <div class="form-group row">
                <div class="col-lg-6 col-sm-6">
                    <label>Número de serie</label>
                    <p>{{ $unidad->no_serie }}</p>
                </div>
                <div class="col-lg-6 col-sm-6">
                    <label>No. Factura de compra</label>
                    <p>{{ $unidad->factura_compra }}</p>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-lg-6 col-sm-6">
                    <label>Placa</label>
                    <p>{{ $unidad->placa }}</p>
                </div>
                <div class="col-lg-6 col-sm-6">
                    <label>Color</label>
                    <p>{{ $unidad->color }}</p>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-lg-6 col-sm-6">
                    <label>Año de la unidad</label>
                    <p>{{ $unidad->unidad_year }}</p>
                </div>
                <div class="col-lg-6 col-sm-6">
                    <label>Número de tarjeta de circulación</label>
                    <p>{{ $unidad->no_tarjeta_circulacion }}</p>
                </div>
            </div>
        </div>
    </div>

@endif