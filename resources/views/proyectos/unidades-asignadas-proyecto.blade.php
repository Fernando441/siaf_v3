@extends('layouts.app')
@section('title')
    Unidades asignadas
@endsection
@push('scripts')
	<script src="{{ asset('js/contratos/EditarContrato.js') }}"></script>
	<meta name="csrf-token" content="{{ csrf_token() }}" />
@endpush
@section('content')


<div class="row">
	<div class="col-lg-12">
		<div class="card card-custom gutter-b">
			<div class="card-header">
				<div class="card-title">
					<h3 class="card-label">
						Unidades asignadas
					</h3>
				</div>

        <div class="card-toolbar">
                <form action="{{ route('proyecto.descargaunidadescontrato') }}" method="post" class="form" id="submit_retirar_unidad" enctype="multipart/form-data">
                @csrf
                	<input type="hidden" name="id_licitacion" value="{{ $licitacion }}">
		            <button type="submit" class="btn btn-sm btn-success font-weight-bold">
		                <i class="flaticon2-cube"></i> Descargar unidades
		            </button>
		        </form>
        </div>

			</div>
			<div class="card-body">

				<table class="table table-hover mb-6 table-responsive-sm kdatatable_unidades_proyectos">
				    <thead>
				        <tr>
				            <th>Unidad</th>
				            <th>No. Serie</th>
				            <th>Placa</th>
				            <th>Año</th>
				            <th>Fecha de asignación</th>
				            <th>Tipo asignación</th>
				            <th>Cliente</th>
				            <th>Retirar unidad</th>
				        </tr>
				    </thead>
				    <tbody id="tbodyDoc_">
				        @foreach($unidad_movimiento as $unid)
				            {{-- @if($unid->proyectos_id == $pro->id) --}}
				                <tr>
				                    <td>{{ $unid->nombre_marca }} / {{ $unid->nombre_modelo }}</td>
				                    <td>{{ $unid->no_serie }}</td>
				                    <td>{{ $unid->placa }}</td>
				                    <td>{{ $unid->unidad_year }}</td>
				                    <td>{{ $unid->fecha_asignacion }}</td>
				                    <td>{{ $unid->tipo_asignacion }}</td>
				                    <td>{{ $unid->name }}</td>

				                    <td>
{{-- 				                        <a href="{{ route('proyecto.verinventarioentrega', [$unid->unidad_id, $unid->licitaciones_id, 3]) }}" class="btn btn-sm btn-outline-success btn-icon ml-4" title="Ver inventario" data-theme="dark" data-toggle="tooltip" data-placement="top">
				                            <span class="svg-icon svg-icon-md">
				                                <i class="flaticon-eye"></i>
				                            </span>
				                        </a> --}}


										<a href="{{ route('proyecto.retunidadesasignadasproyecto',  [$unid->id, $unid->licitaciones_id]) }}" class="btn btn-sm btn-outline-success btn-icon ml-4" title="Proceso para retirar unidad" data-theme="dark" data-toggle="tooltip" data-placement="top">
				                            <span class="svg-icon svg-icon-md">
				                                <i class="flaticon-eye"></i>
				                            </span>
				                        </a> 

				                    </td>

				                </tr>
				            {{-- @endif --}}
				            <input type="hidden" id="datatable_i18n" value="{{ asset('/js/datatables/i18n/es-mx.json') }}">
				        @endforeach
				    </tbody>
				</table>

			</div>
		</div>
	</div>
</div>



@endsection