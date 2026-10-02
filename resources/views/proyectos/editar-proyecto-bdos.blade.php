 <table class="table table-hover mb-6 table-responsive-sm" id="tblDocumentos_avance_{{ $pro->id }}">
    <thead>
    <tr>
        <th scope="col">Documento</th>
        <th scope="col">Fecha</th>
        <th scope="col">Monto</th>
        <th scope="col">Opción</th>
    </tr>
    </thead>
    <tbody id='tbodyDocumentos'>
    	@php $monto_pagos = 0; @endphp
        @foreach($pagos as $unid)
            @if($unid->id_proyecto == $pro->id)
                <tr id="trDocumentoAV{{ $unid->id }}_{{ $pro->id }}">
                    <td>
                    	<a href="{{ route('archivo.documentoAvanceFinanciero', ['id'=>$unid->id]) }}" class="link-primary" target="_blank"> {{ $unid->factura }} </a>
                    </td>
                    <td> {{ date('d/m/Y', strtotime($unid->fecha_pago))}}</td>
                    <td>${{ number_format($unid->monto,2,'.',',') }}</td>
                    <td>
                        <a href='#' class='btn btn-sm btn-clean btn-hover-icon-success btn-icon hrefEliminarAvanc' data-id='{{ $unid->id }}' data-documento='{{ $unid->factura }}' data-proyecto="{{ $pro->id }}"  data-toggle='tooltip' data-theme='dark' title='Eliminar'>
                            <i class='flaticon-delete'></i>
                        </a>
                    </td>
                </tr>
                @php 
                	$monto_pagos = $monto_pagos + $unid->monto; 
                @endphp
            @endif
        @endforeach
    </tbody>
</table>

<div class="row form-group">
    <div class="col-lg-12">
        <a href="#" class="btn btn-icon btn-outline-success btn-circle btn-sm mr-2 hrefAgregarOtroAvance" data-id="{{ $pro->id }}" data-toggle="tooltip" data-theme="dark" title="Agregar archivo">
            <i class="flaticon2-plus"></i>
        </a>
    </div>
</div>

<div class="row mt-3">
	<div class="col-md-8">
			@php $no_contrato = $pro->no_folio;  @endphp
				@if($pro->contrato_op == 1)
					<span>Importe general del contrato:</span> 
					<span class="datos-style">${{ number_format($pro->importe_general,2,'.',',') }}</span>
				@else
					<span>Presupuesto maximo:</span> 
					<span class="datos-style">${{ number_format($pro->presupuesto_maximo,2,'.',',') }}</span>
				@endif
				<br>

				<span>Fecha de termino de Vigencia del Contrato:</span> 
				<span class="datos-style">{{ $pro->firma_final_vigencia }}</span>
	</div>
	<div class="col-md-4">
		

			@php
				$hoy =date("Y-m-d"); 

					$vigencia = $pro->firma_final_vigencia;
					$importe_general = $pro->importe_general; 
					$presupuesto_maximo = $pro->presupuesto_maximo;


				if($pro->contrato_op == 1){
					$pendiente_cobro = $importe_general - $monto_pagos;
				}else{
					$pendiente_cobro = $presupuesto_maximo - $monto_pagos;
				}


				$firstDate  = new DateTime($vigencia);
				$secondDate = new DateTime($hoy);
				$intvl = $firstDate->diff($secondDate);

				if($firstDate > $secondDate) {
					$op_vencer = 1;
				}else{
					$op_vencer = 0;
				}

			@endphp

			<div class="row">
				<div class="table-responsive">
 					<table class="table">
  						<thead>
   							<tr class="fw-bolder fs-6 text-gray-800">
    							<th>Pendiente de cobro:</th>
    							<th>${{ number_format($pendiente_cobro,2,'.',',') }}</th>
    							
   							</tr>
  						</thead>
 					</table>
				</div>

				<div class="table-responsive">
 					<table class="table">
  						<thead>
   							<tr class="fw-bolder fs-6 text-gray-800">
    							<th>Dias por vencer el contrado:</th>
    							@if($op_vencer == 1)
    								<th>@php echo $intvl->days . " días " @endphp</th>
    							@else
    								<th>- @php echo $intvl->days . " días " @endphp</th>
    							@endif
   							</tr>
  						</thead>
 					</table>
				</div>
				
			</div>

	</div>
</div>