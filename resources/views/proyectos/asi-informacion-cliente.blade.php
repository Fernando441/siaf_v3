@extends('layouts.app')
@section('title')
    Asignar clientes al contrato
@endsection
@push('scripts')
	<script src="{{ asset('js/contratos/Asignarclientes.js') }}"></script>
	<meta name="csrf-token" content="{{ csrf_token() }}" />
@endpush
@section('content')

@php
	foreach ($info_cliente as $key ) {
		$avatar = $key['avatar'];
		$nombre_user = $key['name'];
		$email_user = $key['email'];
		$phone_user = $key['telefono'];
		$rfc_user = $key['rfc'];
	}
@endphp

<div class="row">
	<div class="col-lg-12">
		<div class="card card-custom gutter-b">
			<div class="card-header">
				<div class="card-title">
					<h3 class="card-label">
						Información del cliente
					</h3>
				</div>
			</div>
			<div class="card-body">

				<div class="card card-custom gutter-b">
					<div class="card-header">
						<div class="card-title">
							<h3 class="card-label">
								Información basica
							</h3>
						</div>
					</div>
					<div class="card-body">
						<div class="row">
							<div class="col-lg-4 text-center">
								<img src="{{ route('archivo.documentoAvatar', $avatar) }}" width="200">
							</div>
							<div class="col-lg-8">
								<div class="row form-group">
									<div class="col-lg-6">
										<label>Nombre</label>
										<p>{{ $nombre_user }}</p>
									</div>
									<div class="col-lg-6">
										<label>Correo</label>
										<p>{{ $email_user }}</p>
									</div>
								</div>

								<div class="row form-group">
									<div class="col-lg-6">
										<label>Telefono</label>
										<p>{{ $phone_user }}</p>
									</div>
									<div class="col-lg-6">
										<label>RFC</label>
										<p>{{ $rfc_user }}</p>
									</div>
								</div>

							</div>
						</div>
					</div>
				</div>



                <table class="table table-hover table-checkable" id="kdatatable_infocliente">
                    <thead>
                        <tr>
                            <th>Folio</th>
                            <th>Marca</th>
                            <th>Modelo</th>
                            <th>Serie</th>
                            <th>Placa</th>
                            <th>Año</th>
                            <th>Segmento</th>
                            <th>Tipo de asignación</th>
                            <th>Fecha de asignación</th>
                            {{-- <th>Acción</th> --}}
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($unidades_seleccionadas as $unid)
                            <tr>
                                <td>{{ $unid->folio }}</td>
                                <td>{{ $unid->nombre_marca }}</td>
                                <td>{{ $unid->nombre_modelo }}</td>
                                <td>{{ $unid->no_serie }}</td>
                                <td>{{ $unid->placa }}</td>
                                <td>{{ $unid->unidad_year }}</td>
                                <td> {{ $unid->tipo_vehiculo }}, {{ $unid->motor }}, {{ $unid->transmision }} </td>
                                <td> {{ $unid->tipo_asignacion }} </td>
                                <td> {{ $unid->fecha_asignacion }}  </td>
                            </tr>

                        @endforeach
                    </tbody>

                    <tfoot>
                        <tr>
                            <th>Folio</th>
                            <th>Marca</th>
                            <th>Modelo</th>
                            <th>Serie</th>
                            <th>Placa</th>
                            <th>Año</th>
                            <th>Segmento</th>
                            <th>Tipo de asignación</th>
                            <th>Fecha de asignación</th>
                            {{-- <th>Acción</th> --}}
                        </tr>
                    </tfoot>

                </table>
			</div>
		</div>
	</div>
</div>


@endsection