@extends('layouts.app')
@push('scripts')
	<script src="{{ asset('js/Cliente.js') }}"></script>
@endpush

@section('content')
<div class="card shadow-sm">

	    <div class="card-header">
	        <h3 class="card-title">Editar Municipio</h3>
	    </div>

	    <div class="card-body">

			<form action="{{ route('cliente.editarMunicipio') }}" method="post" id="submit_municipio_edit">
				@csrf

				<input type="hidden" name="id_municipio" id="id_municipio" value="{{ $municipio }}">
				<div class="modal-body">
					@foreach($info_municipio as $mun)
                    <div class="row">
                        <div class="col-lg-12 mt-2">
                            <input type="text" class="form-control" name="municipio" id="municipio_edit" placeholder="Nombre del municipio" aria-label="Nombre del municipio" value="{{ $mun->municipio_nombre }}" aria-describedby="basic-addon1"/>
                        </div>
                    </div>

					<div class="col-lg-12 mt-2">
						<select class="form-select" name="id_estado" id="ub" data-control="select2" data-placeholder="Ubicaciónes">
						    <option value="0" disabled>Selecciona una ubicación</option>
			                @foreach($estados as $ub)
			                    {{-- <option value="{{ $ub->id }}" >{{ $ub->ubicacion }}</option> --}}
			                    <option value="{{ $ub->id_estado}}" {{($ub->id == $mun->id_estado) ? 'selected' : ''}}>
	                                {{ strtoupper($ub->estado_nombre)}}
	                             </option>
			                @endforeach
						</select>
					</div>
					@endforeach
				</div>

				<div class="row">
					<div class="col-lg-8 mt-3">
					</div>
					<div class="col-lg-4 mt-3 text-right">
						<a href="{{ route('cliente.catalogoMunicipio') }}" style="margin-right: 7px;" class="btn btn-danger"> <i class="la la-arrow-left"></i>Regresar </a>
						<button type="submit" id="edit_municipio_submit" class="btn btn-success"><i class="la la-plus"></i>Guardar</button>
					</div>
				</div>
			</form>

	    </div>
</div>
@endsection