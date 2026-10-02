@extends('layouts.app')
@section('title')
    Agregar Unidad Carga Masiva
@endsection
@push('scripts')
	{{-- <script src="{{ asset('js/unidades/CrearUnidad.js') }}"></script> --}}
@endpush
@section('content')

<div class="row">
    <div class="col-lg-12">
        <!--begin::Card-->
        <div class="card card-custom gutter-b">
            <div class="card-header">
                <h3 class="card-title">Agregar Unidad por carga masiva</h3>
            </div>
            <div class="card-body">
            	<div class="row">

	            	<div class="col-lg-4">
	            		<div class="card card-custom gutter-b">
				            <div class="card-header">
				                <h3 class="card-title">* Instrucciones</h3>
				            </div>
				            <div class="card-body">
			            		<div class="row">
			            			<a href="">Layout para la carga masiva</a>
			            		</div>
			            		<div class="row mt-2">
			            			<li>1.- Descargar el layout</li>
			            		</div>
				            </div>
	            		</div>
	            	</div>

	            	<div class="col-lg-8">
                         <div class="form-group row">
                                	<div class="col-lg-6">
                                		<label>Archivo</label>
            				           	<div class='custom-file'>
            				               <input type='file' class='custom-file-input' id='file_masivo' name='carga_masiva' required />
            				               <label class='custom-file-label' for='file_masivo'>Selecciona un archivo</label>
            				           	</div>
                                	</div>
                         </div>

	            	</div>
            	</div>

            </div>
         </div>
    </div>
</div>

@endsection