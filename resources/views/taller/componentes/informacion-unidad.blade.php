<!---begin::informacion-->
<div class="card card-custom gutter-b">
    <div class="card-header">
        <div class="card-title">
            <h3 class="card-label">
                Información de la unidad
            </h3>
        </div>
        <div class="card-toolbar">
            <a href="#" class="btn btn-sm btn-icon btn-light-primary" id="toggleInformacion" data-toggle="tooltip" data-theme="dark" data-original-title="Ocultar información">
                <i class="ki ki-arrow-up icon-sm"></i>
            </a>
        </div>
    </div>
    <div class="card-body" id="informacion">
        <div class="row">
            <div class="col-lg-4">
                <div class="form-group row">
                    <div class="col-lg-6">
                        <label>Marca</label>
                        {{ $unidad->marcaUnidad->nombre_marca }}
                    </div>
                    <div class="col-lg-6">
                        <label>Submarca</label>
                        <p></p>
                    </div>
                </div>
                <!-- -->
                <div class="form-group row">
                    <div class="col-lg-6">
                        <label>Clave Vehicular</label>
                        <p></p>
                    </div>
                    
                    <div class="col-lg-6">
                        <label>Transmision</label>
                        {{ $unidad->transmision }}
                    </div>
                </div>
                <!-- -->
                <div class="form-group row">
                    <div class="col-lg-6">
                        <label>Modelo</label>
                        {{ $unidad->modeloUnidad->nombre_modelo }}
                    </div>
                    <div class="col-lg-6">
                        <label>Motor</label>
                        <p></p><!-- falta -->{{-- $unidad->complementoUnidad->motor --}}
                    </div>
                </div>
                <!-- -->
                <div class="form-group row">
                    <div class="col-lg-6">
                        <label>Color</label>
                        <p></p><!-- falta -->{{-- $unidad->complementoUnidad->pintura --}}
                    </div>
                    <div class="col-lg-6">
                        <label>Clave Vehicular Empresa</label>
                        <p>FCA Mexico, S.A. de C.V. (antes Chrysler de Mexico, S.A. de C.V.)</p>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-6">
                        <label>Clave Vehicular Modelo</label>
                        <p>Mitsubishi L200 (importado)</p>
                    </div>
                    <div class="col-lg-6">
                        <label>Clave Vehicular Version</label>
                        <p>07 : Manual, gasolina</p>
                    </div>
                </div>
            </div>

            @if($ver == 0)
                <div class="col-lg-8">
                    <div class="card card-custom gutter-b">

                        <!--begin::Form-->
                            <div class="card-body">
                                <div class="row">

                                    <div class="col-lg-12 text-center mt-4">
                                        <img alt="Logo" class="h-55px brand-logo" src="{{ asset('theme/assets/media/logos/logojetvanhq2.png') }}" />
                                        <h4>Tu unidad no tiene fotografias.</h4>

                                        <div class="row mt-4">
                                            <h5>Para mayor información comunicate con dirección de operaciones.</h5>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="card-footer">

                            </div>

                        <!--end::Form-->
                    </div>                   
                </div>
            @else
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
            @endif
        </div>
    </div>
</div><!---end::informacion-->