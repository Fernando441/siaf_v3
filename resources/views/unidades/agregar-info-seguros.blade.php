@extends('layouts.app')
@section('title')
    Información del seguro
@endsection
@push('scripts')
    <script src="{{ asset('js/unidades/Agregarinfoseguros.js') }}"></script>
@endpush

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <div class="card card-custom gutter-b">
                <div class="card-header">
                    <h3 class="card-title">Información del seguro</h3>
                </div>

                <form class="form" action="{{ route('unidad.guardarinfoseguro') }}" method="post" id="submit_unidad" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <input type="hidden" name="unidad_id" value="{{ $unidad }}">
                        <div class="form-group row">
                            <div class="col-lg-6">
                                <label>Nombre o razón social del titular del seguro</label>
                                <div class="input-group">
                                    <input type="text" name="nombre_titular" id="nombre_titular"  class="form-control" required onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label>Dirección del titular del seguro y del vehículo asegurado</label>
                                <div class="input-group">
                                    <input type="text" name="direccion_titular" id="direccion_titular"  class="form-control" required onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                </div>
                            </div>
                        </div>


                        <div class="form-group row">
                            <div class="col-lg-6">
                                <label>Número de póliza de seguro del automóvil</label>
                                <div class="input-group">
                                    <input type="text" name="numero_poliza" id="numero_poliza"  class="form-control" required onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label>Fecha de inicio de la cobertura</label>
                                <div class="input-group">
                                    <input type="text" name="fecha_cobertura" id="fecha_cobertura"  class="form-control" readonly required />
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-lg-6">
                                <label>Fecha de finalización de la cobertura</label>
                                <div class="input-group">
                                    <input type="text" name="fecha_final_cobertura" id="fecha_final_cobertura" readonly class="form-control" required />
                                </div>
                            </div>
                                <div class="col-lg-6">
                                    <label>Tipo de cobertura</label>
                                    <select class="form-control" id="tipo_cobertura" name="tipo_cobertura" >
                                        <option value="">Selecciona una opción</option>
                                            @foreach($tipo_cobertura as $vehiculo)
                                                <option value="{{ $vehiculo->id }}" >{{ $vehiculo->tipo_cobertura }}</option>
                                            @endforeach
                                    </select>
                                </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-lg-6">
                                <label>Límites de cobertura y deducibles</label>
                                <div class="input-group">
                                    <input type="text" name="limites_cobertura" id="limites_cobertura"  class="form-control" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label>Correo electrónico del titular del seguro</label>
                                <div class="input-group">
                                    <input type="text" name="email_titutlar" id="email_titutlar"  class="form-control" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-lg-6">
                                <label>Telefono del titular del seguro</label>
                                <div class="input-group">
                                    <input type="number" name="telefono_titular" id="telefono_titular"  class="form-control"/>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label>Nombre de contacto de la compañia de seguros</label>
                                <div class="input-group">
                                    <input type="text" name="nombre_compania" id="nombre_compania"  class="form-control" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"/>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-lg-6">
                                <label>Telefono de contacto de la compañia de seguros</label>
                                <div class="input-group">
                                    <input type="number" name="telefono_compania" id="telefono_compania"  class="form-control" />
                                </div>
                            </div>
                        </div>



                    </div>
                    <div class="card-footer" >
                        <div class="row">
                            <div class="col-lg-12">
                                <button type="button"  id="btnGuardar" class="btn btn-success"><i class="la la-plus"></i>Guardar</button>
                                <a href="{{ route('unidad.catalogounidad') }}"  class="btn btn-secondary"><i class="la la-arrow-left"></i>Regresar</a>
                            </div>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
