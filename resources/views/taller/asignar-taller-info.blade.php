@extends('layouts.app')

@section('title')
    Asignar taller a la solicitud
@endsection
@push('scripts')
    <script src="{{ asset('js/taller/CatalogoTaller.js') }}"></script>
@endpush



@section('content')

    <!--begin::Card-->
    <div class="row">
        <div class="col-lg-12">
            <!--begin::Card-->
            <div class="card card-custom gutter-b">
                <div class="card-header">
                    <h3 class="card-title">Asignar taller a la solicitud</h3>
                </div>
                <!--begin::Form-->
                    <div class="card-body">

                      <div class="card card-custom gutter-b">
                        <div class="card-header">
                          <div class="card-title">
                            <h3 class="card-label">
                              Información del taller
                            </h3>
                          </div>

                          <div class="card-toolbar">
                              <button id="asignacion_taller" class="btn btn-sm btn-success font-weight-bold">
                                  <i class="flaticon2-cube"></i> Asignar taller
                              </button>
                          </div>

                        </div>
                        <div class="card-body">
                          <div class="form-group row">
                            <div class="col-lg-4">
                              <label>Nombre</label>
                              <p>{{ $taller->nombre }}</p>
                            </div>

                            <div class="col-lg-4">
                              <label>Alias</label>
                              <p>{{ $taller->alias }}</p>
                            </div>

                            <div class="col-lg-4">
                              <label>Dirección</label>
                              <p>{{ $taller->direccion }}</p>
                            </div>
                          </div>

                          <div class="form-group row">
                            <div class="col-lg-4">
                              <label>Telefono local</label>
                              <p>{{ $taller->tel_local }}</p>
                            </div>

                            <div class="col-lg-4">
                              <label>Telefono celular</label>
                              <p>{{ $taller->tel_celular }}</p>
                            </div>

                            <div class="col-lg-4">
                              <label>Correo</label>
                              <p>{{ $taller->correo }}</p>
                            </div>
                          </div>


                          <div class="form-group row">
                            <div class="col-lg-4">
                              <label>Estado</label>
                              <p>{{ $taller->estado_nombre }}</p>
                            </div>

                            <div class="col-lg-4">
                              <label>Municipio</label>
                              <p>{{ $taller->municipio_nombre }}</p>
                            </div>

                            <div class="col-lg-4">
                              <label>Coordenadas</label>
                              <p>{{ $taller->coordenadas }}</p>
                            </div>
                          </div>

                          <div class="row">
                            <h4 class="card-title">Servicios</h4>
                          </div>

                          <div class="row">
                            @foreach($servicios_asignados as $value)
                              <div class="col-md-4">
                                <div class="form-group">
                                  <span class="switch switch-icon">
                                  <label> {{ $value->servicio->servicio }}
                                  <input type="checkbox" name="servicio[]" checked disabled class='tablero_check all_generales' value="{{ $value->id }}" />
                                  <span></span>
                                  </label>
                                  </span>
                                </div>
                              </div>            
                            @endforeach
                          </div>


                        </div>
                      </div>


                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-lg-6">
                                <a href="{{ route('taller.listadotallersol', $id_solicitud) }}"  class="btn btn-secondary"> <i class="la la-arrow-left"></i>Regresar</a>
                            </div>
                        </div>
                    </div>

                <!--end::Form-->
            </div>
            <!--end::Card-->
        </div>
    </div>
    <!--end::Card-->



  <form method="post" id="asignacion_delete_form" action="{{ route('taller.tallerasignadosolicitud') }}" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="id_solicitud" id="id_solicitud" value="{{ $id_solicitud }}">
    <input type="hidden" name="taller" value="{{ $id_taller }}">
  </form>


@endsection