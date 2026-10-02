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
            /*               border: 1px solid black;*/
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
            /*width: 100%;*/
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
            /*border-color: inherit;*/
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





    </style>
</head>
<body>

        <div class="izquierdab borde_gris" style="text-align:justify; text-justify:inter-word; margin-top: 100px;">
            <strong>Periodo:</strong> {{ $info_estimacion->periodo_inicial }} - {{ $info_estimacion->periodo_final}} <BR>
            <strong>Cliente:</strong> {{ $info_estimacion->cliente->razon_social }}<BR>
            <strong>RFC:</strong> {{ $info_estimacion->cliente->rfc }}  <BR>
            <strong>Dirección:</strong> {{ $info_estimacion->cliente->calle_numero }}, COLONIA {{ $info_estimacion->cliente->colonia }}, {{ $info_estimacion->cliente->estado->estado_nombre }}, {{ $info_estimacion->cliente->municipio->municipio_nombre }}, C.P {{ $info_estimacion->cliente->codigo_postal }}  <BR>
        </div>

        <br>

        <table class="table" cellpadding="8" style="page-break-inside: avoid;">
            <thead>
                <tr>
                    <th class="table_header" width="33%" colspan="2" style="text-align: center;" ><strong>Datos de la estimación</strong></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td ><strong>Datos del contrato:</strong></td>
                    <td ><strong>Información del cliente:</strong></td>
                </tr>
                <tr>
                    <td ><strong>Titulo servicio:</strong> {{ $info_estimacion->proyecto->titulo_servicio }}</td>
                    <td ><strong>Razon social:</strong> {{ $info_estimacion->cliente->razon_social }}</td>
                </tr>
                <tr>
                    <td ><strong>Id. Contrato:</strong> {{ $info_estimacion->proyecto->id_contrato }}</td>
                    <td ><strong>RFC</strong> {{ $info_estimacion->cliente->rfc }}</td>
                </tr>
                <tr>
                    <td ><strong>No. Contrato:</strong> {{ $info_estimacion->proyecto->no_contrato }}</td>
                    <td ><strong>Dirección:</strong> {{ $info_estimacion->cliente->calle_numero }} {{ $info_estimacion->cliente->colonia }} {{ $info_estimacion->cliente->estado->estado_nombre }} {{ $info_estimacion->cliente->municipio->municipio_nombre }}</td>
                </tr>
                <tr>
                    <td ><strong>Inicio de vigencia:</strong> {{ date('d/m/Y' , strtotime( $info_estimacion->proyecto->firma_inicio_vigencia)) }} </td>
                </tr>    
                <tr>
                    <td ><strong>Fin de vigencia:</strong> {{  date('d/m/Y' , strtotime( $info_estimacion->proyecto->firma_final_vigencia)) }}</td>
                </tr>

            </tbody>
        </table>


        <table class="table" cellpadding="8" style="overflow:wrap">
            <thead>
                <tr>
                    <th class="table_header" width="33%" colspan="4" style="text-align: center;" ><strong>Resumen de la estimación</strong></th>
                </tr>
            </thead>
            <tbody>
                @php
                    $result = [];
                    foreach ($unidaes_estimacion as $k => $row) {
                        $result[$row['segmentos_id']][$k] = $row;
                    }

                @endphp
                <tr>
                    <td ><strong>Cantidad</strong></td>
                    <td ><strong>Segmento</strong></td>
                    <td ><strong>Costo mensual</strong></td>
                    <td ><strong>Total</strong></td>
                </tr>

                    @foreach($result as $k => $row)
                    <tr>
                        <td>{{ count($row) }}</td>
                            @php
                            $total_seg = 0; $precio_unitario_seg= 0;
                                foreach ($row as $key => $value) {
                                    $total_seg = $value->dias_trabajo  * $value->precio_segmento;
                                    $precio_unitario_seg = $precio_unitario_seg + $total_seg;
                                    // var_dump($precio_unitario_seg);
                                }                                                          
                            @endphp 
                        <td>{{ $value->segmento->segmentoTipoVehiculo->tipo_vehiculo }} {{ $value->segmento->segmentoMotor->motor }}  {{ $value->segmento->segmentoTransmision->transmision }}</td>
                        <td>{{ $total_seg }}</td>
                        <td>   {{ $precio_unitario_seg }}  </td>
                    </tr>                                              
                    @endforeach

            </tbody>
        </table>        

        <table class="table" cellpadding="8" style="overflow:wrap" >
            <thead>
                <tr>
                    <th class="table_header" width="33%" colspan="7" style="text-align: center;" ><strong>Unidades</strong></th>
                </tr>
                
            </thead>
            <tbody>
                <tr>
                    {{-- <td><strong>Segmento</strong></td> --}}
                    <td><strong>Número economico</strong></td>
                    <td><strong>Marca</strong></td>
                    <td><strong>Modelo</strong></td>
                    <td><strong>No.serie</strong></td>
                    <td><strong>Precio Unitario</strong></td>
                    <td><strong>Dias trabajados</strong></td>
                    <td><strong>Total mensual</strong></td>
                </tr>

                @php $precio_unitario = 0; $iva = 0; $total_monto=0; $subtotal_calculo=0; $iva_calculo=0; @endphp
                @foreach($unidaes_estimacion as $unid)
                    @php 
                        $total = $unid->precio_segmento * $unid->dias_trabajo;
                        $precio_unitario = $precio_unitario + $total;
                        $iva = $precio_unitario * 0.16;
                        $total_monto = $precio_unitario + $iva;
                    @endphp
                                      @if($unid->dias_trabajo == 30)
                                      <tr>
                                      @else
                                        <tr style="background-color: #ffe189;">
                                      @endif
                        {{-- <td>{{ $unid->segmentos_id }} </td> --}}
                        <td>{{ $unid->unidad->numero_economico }}</td>
                        <td>{{ $unid->unidad->marcaUnidad->nombre_marca }}</td>
                        <td>{{ $unid->unidad->modeloUnidad->nombre_modelo }}</td>
                        <td>{{ $unid->unidad->no_serie }}</td>
                        <td>{{ number_format($unid->precio_segmento,2,'.',',') }}</td>
                        <td class="text-center">
                            <p>{{ $unid->dias_trabajo }}</p>
                        </td>
                        <td class="text-left">
                            <p>{{ number_format($total,2,'.',',') }}</p>
                        </td>

                    </tr>
                @endforeach

                <tr >
                    <td align="right" colspan="6"><strong>Subtotal: </strong></td> <td class="text-left" > ${{ number_format($total_monto,2,'.',',') }}</td>
                </tr>
                <tr >    
                    <td align="right" colspan="6"><strong>IVA 16%: </strong></td> <td class="text-left" >${{ number_format($iva,2,'.',',') }}</td>
                </tr >
                <tr >    
                    <td align="right" colspan="6"><strong>Total: </strong></td> <td align="left">${{ number_format($total_monto,2,'.',',') }}</td>
                </tr>
                
            </tbody>
        </table>

</body>
</html>
