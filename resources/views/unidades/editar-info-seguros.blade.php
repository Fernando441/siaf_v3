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

                <form class="form" action="{{ route('unidad.editarinfoseguro') }}" method="post" id="submit_unidad" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <input type="hidden" name="unidad_id" value="{{ $unidad }}">
                        <div class="form-group row">
                            <div class="col-lg-6">
                                <label>Nombre o razón social del titular del seguro</label>
                                <div class="input-group">
                                    <input type="text" name="nombre_titular" id="nombre_titular"  class="form-control" value="{{ $info_seguro_unidad->nombre_titular }}" required />
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label>Dirección del titular del seguro y del vehículo asegurado</label>
                                <div class="input-group">
                                    <input type="text" name="direccion_titular" id="direccion_titular" value="{{ $info_seguro_unidad->direccion_titular }}"  class="form-control" required />
                                </div>
                            </div>
                        </div>


                        <div class="form-group row">
                            <div class="col-lg-6">
                                <label>Número de póliza de seguro del automóvil</label>
                                <div class="input-group">
                                    <input type="text" name="numero_poliza" id="numero_poliza" value="{{ $info_seguro_unidad->numero_poliza }}"  class="form-control" required />
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label>Fecha de inicio de la cobertura</label>
                                <div class="input-group">
                                    <input type="text" name="fecha_cobertura" id="fecha_cobertura"  class="form-control" value="{{ date('d/m/Y', strtotime($info_seguro_unidad->fecha_cobertura))}}" readonly required />
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-lg-6">
                                <label>Fecha de finalización de la cobertura</label>
                                <div class="input-group">
                                    <input type="text" name="fecha_final_cobertura" id="fecha_final_cobertura" readonly value="{{ date('d/m/Y', strtotime($info_seguro_unidad->fecha_final_cobertura))}}" class="form-control" required />
                                </div>
                            </div>
                                <div class="col-lg-6">
                                    <label>Tipo de cobertura</label>
                                    <select class="form-control" id="tipo_cobertura" name="tipo_cobertura" >
                                        <option value="">Selecciona una opción</option>
                                            @foreach($tipo_cobertura as $model)
                                                <option value="{{ $model->id}}" {{($model->id == $info_seguro_unidad->unidad_tipo_cobertura_id) ? 'selected' : ''}}>
                                                    {{ strtoupper($model->tipo_cobertura)}}
                                                </option>
                                            @endforeach

                                    </select>
                                </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-lg-6">
                                <label>Límites de cobertura y deducibles</label>
                                <div class="input-group">
                                    <input type="text" name="limites_cobertura" id="limites_cobertura" value="{{ $info_seguro_unidad->limites_cobertura }}"  class="form-control" />
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label>Correo electrónico del titular del seguro</label>
                                <div class="input-group">
                                    <input type="text" name="email_titutlar" id="email_titutlar" value="{{ $info_seguro_unidad->email_titutlar }}"  class="form-control" />
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-lg-6">
                                <label>Telefono del titular del seguro</label>
                                <div class="input-group">
                                    <input type="number" name="telefono_titular" id="telefono_titular" value="{{ $info_seguro_unidad->telefono_titular }}"  class="form-control"/>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label>Nombre de contacto de la compañia de seguros</label>
                                <div class="input-group">
                                    <input type="text" name="nombre_compania" id="nombre_compania" value="{{ $info_seguro_unidad->nombre_compania }}"  class="form-control" />
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-lg-6">
                                <label>Telefono de contacto de la compañia de seguros</label>
                                <div class="input-group">
                                    <input type="number" name="telefono_compania" id="telefono_compania" value="{{ $info_seguro_unidad->telefono_compania }}"  class="form-control" />
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
