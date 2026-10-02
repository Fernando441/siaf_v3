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

    @foreach($or_prov as $prov)
        <div class="izquierdab borde_gris" style="text-align:justify; text-justify:inter-word; margin-top: 20px;">
            <strong>Nombre del proveedor:</strong> {{ $prov->proveedor->nombre }}<BR>
            <strong>Nombre Contacto:</strong> {{ $prov->proveedor->contacto }} <BR>
            <strong>Datos de Contacto:</strong> {{ $prov->proveedor->telefono }} {{ $prov->proveedor->correo }} {{ $prov->proveedor->rfc }} <BR>
            <strong>Dirección:</strong> {{ $prov->proveedor->dirección }}<BR>
            <strong>Convenio:</strong> {{ $prov->proveedor->convenio }}<BR>
        </div>

        <br>

        <table class="table" cellpadding="8" style="overflow:wrap" >
            <thead>
                <tr>
                    <th class="table_header" width="33%" colspan="5" style="text-align: center;" ><strong>Unidades</strong></th>
                </tr>
                
            </thead>
            <tbody>
                <tr>
                    <td><strong>Cantidad</strong></td>
                    <td><strong>Tipo</strong></td>
                    <td><strong>Cilindros</strong></td>
                    <td><strong>Transmisión</strong></td>
                    <td><strong>Motor</strong></td>
                </tr>

                @php $cons = 0; @endphp
                @foreach($or_partidas as $partidas)
                    @if($prov->id == $partidas->requisicion_orden_proveedor_id)
                    <tr>
                        <td class="text-center"><p> {{ $partidas->cantidad }} </p> </td>
                        <td>{{ $partidas->segmento->segmentoTipoVehiculo->tipo_vehiculo }}</td>
                        <td>{{ $partidas->segmento->segmentoTransmision->transmision }}</td>
                        <td>{{ $partidas->segmento->segmentoNoCilindro->no_cilindro }}</td>
                        <td>{{ $partidas->segmento->segmentoMotor->motor }}</td>
                    </tr>
                    @endif
                @endforeach
                <tr >
                    <td colspan="2" ><strong>Forma de pago</strong> {{ $prov->requisicionFormaPago->forma_pago }}</td>
                    <td colspan="2" ><strong>Método de pago</strong> {{ $prov->requisicionMetodoPago->clave }} - {{ $prov->requisicionMetodoPago->metodo_pago }}</td>
                    <td colspan="1" ><strong>Uso de CFDI</strong> {{ $prov->uso_cfdi }}</td>
                </tr>
                
            </tbody>
        </table>
    @endforeach    
</body>
</html>
