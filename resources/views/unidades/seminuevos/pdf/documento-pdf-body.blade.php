<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<style type="text/css">
		div {
			/*border: 1px solid #000000;*/
		}

		body {
			font-family:'Helvetica, Arial, sans-serif; font-size: 12px;';
			font-size: 12px;
		}

		#divDatos div {
			padding-bottom: 7px;
		}

		#div-pie p {
			margin: 0px auto auto 200px;
			text-align: right;
			font-size: 70%;
		}

		.table {
			margin-bottom: 0.9rem;
			background-color: rgba(0,0,0,0);
		}

		table {
			border-collapse: collapse;
			page-break-inside: avoid;
		}

		thead {
			display: table-header-group;
			vertical-align: middle;
		}

		.table thead th {
			vertical-align: bottom;
			border-bottom: 2px solid #f4f5f8;
		}

		.table th {
			font-weight: 500;
		}

		.table th, .table td {
			padding: .75rem;
			vertical-align: top;
			border-top: 1px solid #f4f5f8;
		}

		.borde_gris {
			background: white;
			border: 1px solid #e7e7ea;
			padding: 20px;
		}

		thead th {
			background: #73ab17;
			color: #fff;
			border-bottom: 0;
			border-top: 0;
		}

		.table thead th {
			vertical-align: bottom;
			border-bottom: 2px solid #f4f5f8;
		}

		.table th {
			font-weight: 500;
		}

		.table th, .table td {
			padding: .75rem;
			vertical-align: top;
			border-top: 1px solid #e7e7ea;
		}

		table tr {
			page-break-inside: avoid;
		}

		.seccion-titulo {
			font-size: 13px;
			font-weight: bold;
			margin-bottom: 6px;
		}

		.firma td {
			text-align: center;
			padding-top: 34px;
			width: 33.33%;
		}
	</style>
</head>
<body>

	<div class="izquierdab borde_gris" style="text-align:justify; text-justify:inter-word; margin-top: 20px;">
		<strong>Nombre del cliente:</strong> {{ $pedidoData->nombre_cliente ?? ($unidadVenta->nombre_cliente ?? '-') }}<br>
		<strong>RFC:</strong> {{ $pedidoData->rfc ?? ($unidadVenta->rfc ?? '-') }}<br>
		<strong>Correo electrónico:</strong> {{ $pedidoData->correo_electronico ?? '-' }}<br>
		<strong>Número telefónico:</strong> {{ $pedidoData->numero_telefono ?? '-' }}<br>
		<strong>Dirección completa:</strong> {{ $pedidoData->direccion_completa ?? ($unidadVenta->direccion_cliente ?? '-') }}
	</div>

	<br>

	<table class="table" cellpadding="8" style="overflow:wrap" width="100%">
		<thead>
			<tr>
				<th colspan="2" style="text-align: center;"><strong>Datos de la unidad</strong></th>
			</tr>
		</thead>
		<tbody>
			<tr><td><strong>Marca</strong></td><td>{{ $unidadInfo->nombre_marca ?? '-' }}</td></tr>
			<tr><td><strong>Modelo</strong></td><td>{{ $unidadInfo->nombre_modelo ?? '-' }}</td></tr>
			<tr><td><strong>Patio</strong></td><td>{{ $unidadInfo->patio ?? '-' }}</td></tr>
			<tr><td><strong>Año</strong></td><td>{{ $unidadInfo->unidad_year ?? '-' }}</td></tr>
			<tr><td><strong>No. Serie</strong></td><td>{{ $unidadInfo->no_serie ?? '-' }}</td></tr>
			<tr><td><strong>Placa</strong></td><td>{{ $unidadInfo->placa ?? '-' }}</td></tr>
			<tr><td><strong>Número económico</strong></td><td>{{ $unidadInfo->numero_economico ?? '-' }}</td></tr>
			<tr><td><strong>Color</strong></td><td>{{ $unidadInfo->color ?? '-' }}</td></tr>
			<tr><td><strong>Fecha de venta</strong></td><td>{{ $unidadVenta->fecha_venta ? \Carbon\Carbon::parse($unidadVenta->fecha_venta)->format('d/m/Y') : '-' }}</td></tr>
			<tr>
				<td><strong>Precio de venta</strong></td>
				<td>${{ number_format((float) ($unidadVenta->precio_venta ?? 0), 2, '.', ',') }}</td>
			</tr>
			<tr>
				<td><strong>No. Factura</strong></td>
				<td>{{ $unidadVenta->numero_factura ?? '-' }}</td>
			</tr>
		</tbody>
	</table>

	<table class="firma" cellpadding="0" cellspacing="0" style="margin-top: 18px; width:100%;">
		<tr>
			<td>
				_______________________________<br>
				Quien autoriza la venta
			</td>
			<td>
				_______________________________<br>
				Tesorería
			</td>
			<td>
				_______________________________<br>
				Visto bueno
			</td>
		</tr>
	</table>

</body>
</html>
