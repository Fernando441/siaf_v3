@extends('layouts.app')
@push('scripts')
    <script src="{{ asset('js/catalogos/segmentos/CrearSegmento.js') }}"></script> 
@endpush
@section('title')
    Agregar segmento
@endsection
@section('content')

    <!--begin::Card-->
    <div class="row">
        <div class="col-lg-12">
            <!--begin::Card-->
            <div class="card card-custom gutter-b">
                <div class="card-header">
                    <h3 class="card-title">Agregar segmento</h3>
                </div>
                <!--begin::Form-->
                <form action="{{ route('segmento.guardarsegmento') }}" method="post" id="submit_segmento">
                    @csrf
                    <div class="card-body">

                        <div class="form-group row">
                            <div class="col-lg-6">
                                <label>Tipo de vehículo</label>
                                <div class="input-group">
                                    <select class="form-control" id="tipo_vehiculo" name="tipo_vehiculo"  required >
                                        <option value="">Selecciona una opción</option>
                                        @foreach($tipovehiculo as $ub)
                                            <option value="{{ $ub->id }}" >{{ $ub->tipo_vehiculo }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label>Puertas</label>
                                <div class="input-group">
                                    <select class="form-control" id="puertas" name="puertas"  required >
                                        <option value="">Selecciona una opción</option>
                                        @foreach($puerta as $ub)
                                            <option value="{{ $ub->id }}" >{{ $ub->puertas }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-6">
                                <label>Carrocería</label>
                                <div class="input-group">
                                    <select class="form-control" id="carroceria" name="carroceria"  required >
                                        <option value="">Selecciona una opción</option>
                                        @foreach($carroceria as $ub)
                                            <option value="{{ $ub->id }}" >{{ $ub->carroceria }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label>No. Cilindros</label>
                                <div class="input-group">
                                    <select class="form-control" id="no_cilindros" name="no_cilindros"  required >
                                        <option value="">Selecciona una opción</option>
                                        @foreach($nocilindro as $ub)
                                            <option value="{{ $ub->id }}" >{{ $ub->no_cilindro }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
 {{--                            <div class="col-lg-6">
                                <label>Cilindros</label>
                                <div class="input-group">
                                    <select class="form-control" id="cilindros" name="cilindros"  required >
                                        <option value="">Selecciona una opción</option>
                                        @foreach($cilindro as $ub)
                                            <option value="{{ $ub->id }}" >{{ $ub->cilindro }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div> --}}
                            <div class="col-lg-6">
                                <label>Pasajeros</label>
                                <div class="input-group">
                                    <select class="form-control" id="pasajeros" name="pasajeros"  required >
                                        <option value="">Selecciona una opción</option>
                                        @foreach($pasajero as $ub)
                                            <option value="{{ $ub->id }}" >{{ $ub->segmento_pasajerocol }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label>Motor</label>
                                <div class="input-group">
                                    <select class="form-control" id="motor" name="motor"  required >
                                        <option value="">Selecciona una opción</option>
                                        @foreach($motor as $ub)
                                            <option value="{{ $ub->id }}" >{{ $ub->motor }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-6">
                                <label>Llanta de refacción</label>
                                <div class="input-group">
                                    <select class="form-control" id="llanta_refaccion" name="llanta_refaccion"  required >
                                        <option value="">Selecciona una opción</option>
                                        @foreach($lantarefaccion as $ub)
                                            <option value="{{ $ub->id }}" >{{ $ub->llanta_refaccion }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label>Espejos Laterales</label>
                                <div class="checkbox-inline">
                                    @foreach($espejoslaterales as $ub)
                                        <label class="checkbox">
                                            <input type="checkbox" name="espejos_laterales[]" value="{{ $ub->id }}"/>
                                            <span></span>
                                            {{ $ub->espejos_laterales }}
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-6">
                                <label>Accesorios</label>
                                <div class="checkbox-inline">
                                    @foreach($accesorio as $ub)
                                        <label class="checkbox">
                                            <input type="checkbox" name="accesorios[]" value="{{ $ub->id }}"/>
                                            <span></span>
                                            {{ $ub->accesorios }}
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label>Potencia</label>
                                <div class="input-group">
                                    <select class="form-control" id="potencia" name="potencia">
                                        <option value="">Selecciona una opción</option>
                                        @foreach($potencia as $ub)
                                            <option value="{{ $ub->id }}" >{{ $ub->potencia }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-6">
                                <label>Transmisión</label>
                                <div class="input-group">
                                    <select class="form-control" id="transmision" name="transmision"  required >
                                        <option value="">Selecciona una opción</option>
                                        @foreach($transmision as $ub)
                                            <option value="{{ $ub->id }}" >{{ $ub->transmision }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label>Radio</label>
                                <div class="input-group">
                                    <select class="form-control" id="radio" name="radio"  required >
                                        <option value="">Selecciona una opción</option>
                                        @foreach($radio as $ub)
                                            <option value="{{ $ub->id }}" >{{ $ub->radio }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-6">
                                <label>Dirección</label>
                                <div class="input-group">
                                    <select class="form-control" id="direccion" name="direccion">
                                        <option value="">Selecciona una opción</option>
                                        @foreach($direccion as $ub)
                                            <option value="{{ $ub->id }}" >{{ $ub->direccion }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label>Blindaje</label>
                                <div class="input-group">
                                    <select class="form-control" id="blindaje" name="blindaje">
                                        <option value="">Selecciona una opción</option>
                                        @foreach($blindaje as $ub)
                                            <option value="{{ $ub->id }}" >{{ $ub->blindaje }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-6">
                                <label>Capacidad</label>
                                <div class="input-group">
                                    <select class="form-control" id="capacidad" name="capacidad">
                                        <option value="">Selecciona una opción</option>
                                        @foreach($capacidad as $ub)
                                            <option value="{{ $ub->id }}" >{{ $ub->capacidad }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label>Gps</label>
                                <div class="input-group">
                                    <select class="form-control" id="gps" name="gps" >
                                        <option value="">Selecciona una opción</option>
                                        @foreach($gps as $ub)
                                            <option value="{{ $ub->id }}" >{{ $ub->gps }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-6">
                                <label>En inventario</label>
                                <div class="input-group">
                                    <select class="form-control" id="en_inventario" name="en_inventario"  required >
                                        <option value="">Selecciona una opción</option>
                                        @foreach($eninventario as $ub)
                                            <option value="{{ $ub->id }}" >{{ $ub->en_inventario }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!--end::tabs-->

                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-lg-6">
                                <button type="button"  id="btnGuardar" class="btn btn-success"><i class="la la-plus"></i>Guardar</button>
                                <a href="{{ route('segmento.catalogosegmentos') }}"  class="btn btn-secondary"><i class="la la-times"></i>Cancelar</a>
                            </div>
                        </div>
                    </div>
                {{-- </form> --}}
                <!--end::Form-->
            </div>
            <!--end::Card-->
        </div>
    </div>
    <!--end::Card-->

@endsection