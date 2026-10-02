<table class="table table-hover mb-6 table-responsive-sm" id="tblDocumentos_deductiva_{{ $pro->id }}">
    <thead>
    <tr>
        <th scope="col">Documento</th>
        <th scope="col">Avance financiero</th>
        <th scope="col">Fecha</th>
        <th scope="col">Monto</th>
        {{-- <th scope="col">Opción</th> --}}
    </tr>
    </thead>
    <tbody id='tbodyDocumentosDP'>
        @foreach($deductivapago as $unid)
            @if($unid->proyecto_id == $pro->id)
                <tr id="trDocumentoDP{{ $unid->id }}_{{ $pro->id }}">
                    <td>
                        <a href="{{ route('archivo.documentoDeductivaPago', ['id'=>$unid->id]) }}" class="link-primary" target="_blank"> DEDUCTIVA </a>
                    </td>
                    <td>No.{{ $unid->pagoid }} -Fecha de pago: {{ $unid->fecha_pago }} -Monto: {{ $unid->monto }}</td>
                    <td> {{ date('d/m/Y', strtotime($unid->fecha_deductiva))}}</td>
                    <td>${{ number_format($unid->monto_deductiva,2,'.',',') }}</td>
{{--                     <td>
                        <a href='#' class='btn btn-sm btn-clean btn-hover-icon-success btn-icon hrefEliminarDeductivaP' data-id='{{ $unid->id }}' data-documento='{{ $unid->deductiva_pago }}' data-proyecto="{{ $pro->id }}"  data-toggle='tooltip' data-theme='dark' title='Eliminar'>
                            <i class='flaticon-delete'></i>
                        </a>
                    </td> --}}
                </tr>
            @endif
        @endforeach
    </tbody>
</table>
