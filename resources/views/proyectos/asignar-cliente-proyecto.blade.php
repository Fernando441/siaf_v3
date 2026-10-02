@extends('layouts.app')
@section('title')
    Asignar clientes al contrato
@endsection
@push('scripts')
	<script src="{{ asset('js/contratos/Asignarclientes.js') }}"></script>
	<meta name="csrf-token" content="{{ csrf_token() }}" />
@endpush
@section('content')


<div class="row">
	<div class="col-lg-12">
		<div class="card card-custom gutter-b">
			<div class="card-header">
				<div class="card-title">
					<h3 class="card-label">
						Clientes del contrato
					</h3>
				</div>
			</div>
			<div class="card-body">

				<ul class="nav nav-tabs nav-tabs-line">
				    <li class="nav-item">
				        <a class="nav-link active" data-toggle="tab" href="#kt_tab_pane_1">Asignar clientes al contrato</a>
				    </li>
				    <li class="nav-item">
				        <a class="nav-link" data-toggle="tab" href="#kt_tab_pane_2">Clientes asignados</a>
				    </li>
				</ul>

				<div class="tab-content mt-5" id="myTabContent">
					<div class="tab-pane fade show active mt-10" id="kt_tab_pane_1" role="tabpanel" aria-labelledby="kt_tab_pane_1">
                        <form action="{{ route('proyecto.asclientecontrato') }}" method="post" id="submit_clientes_contrato" enctype="multipart/form-data">
                        @csrf

                        <input type="hidden" name="licitacion" value="{{ $licitacion }}">

							<table class="table table-hover mb-6 table-responsive-sm" id="kdatatable_clientes_proyectos">
							    <thead>
							        <tr>
							            <th>Nombre</th>
							            <th>Telefono</th>
							            <th>Correo</th>
							            <th>RFC</th>
							            <th>Acción</th>
							        </tr>
							    </thead>
							    <tbody id="tbodyDoc">
							        @foreach($usuarios_clientes as $unid)
							            {{-- @if($unid->proyectos_id == $unid->id) --}}
							                <tr>
							                    <td>{{ $unid->name }}</td>
							                    <td>{{ $unid->telefono }}</td>
							                    <td>{{ $unid->email }}</td>
							                    <td>{{ $unid->rfc }}</td>
							                    <td>
							                        <div class="checkbox-inline">
							                            <label class="checkbox">
							                                <input type="checkbox" name="cliente[]" value="{{ $unid->id }}" />
							                                <span></span>
							                            </label>
							                        </div>

							                    </td>
							                </tr>
							            {{-- @endif --}}
							        @endforeach
							    </tbody>
							</table>
							
                            <div class="row" >
                                <div class="col-lg-12" style="margin-top: 25px;">
                                	<button type="submit"  id="btnGuardarUnidad" class="btn btn-primary mr-2">Guardar cliente</button>
                                </div>
                            </div>


						</form>
						<input type="hidden" id="datatable_i18n" value="{{ asset('/js/datatables/i18n/es-mx.json') }}">
                    </div>

                    <div class="tab-pane fade mt-10" id="kt_tab_pane_2" role="tabpanel" aria-labelledby="kt_tab_pane_2">
							<table class="table table-hover mb-6 table-responsive-sm" id="kdatatable_clientes_asignados">
							    <thead>
							        <tr>
							            <th>Nombre</th>
							            <th>Telefono</th>
							            <th>Correo</th>
							            <th>RFC</th>
							            <th>Acción</th>
							        </tr>
							    </thead>
							    <tbody id="tbodyDoc">
							        @foreach($usuarios_asignados as $unid)
							            {{-- @if($unid->proyectos_id == $unid->id) --}}
							                <tr>
							                    <td>{{ $unid->user->name }}</td>
							                    <td>{{ $unid->user->telefono }}</td>
							                    <td>{{ $unid->user->email }}</td>
							                    <td>{{ $unid->user->rfc }}</td>
							                    <td>
							                    	<a href="{{ route('proyecto.informacioncliente', [$licitacion, $unid->cliente_id]) }}" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon"  title="Ver información del cliente"  data-theme="dark" data-toggle="tooltip" data-placement="top"><i class="flaticon-eye"></i></a>

							                    	<button class="btn btn-sm btn-clean btn-hover-icon-success btn-icon eliminar-cliente" data-id="{{ $unid->cliente_id }}" data-nombre="{{  $unid->user->name }}" data-toggle="tooltip" data-theme="dark" title="Eliminar cliente del contrato" ><i class="flaticon-delete "></i></button>
							                    </td>
							                </tr>
							            {{-- @endif --}}
							        @endforeach
							    </tbody>
							</table>
                    </div>
				</div>

			</div>
		</div>
	</div>
</div>

<form method="post" id="cliente_act_form" action="{{ route('proyecto.eliminarclientecontrato') }}" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="id" id="id_delete" value="">
    <input type="hidden" name="id_licitacion" id="id_licitacion" value="{{ $licitacion }}">
</form>


@endsection