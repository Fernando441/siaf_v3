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
            <strong>Servicio:</strong> {{ $info->titulo_servicio }}<BR>
            <strong>Cliente:</strong> {{ $cliente->razon_social }}<BR>
                @if(!empty($info->firma_entrega))
                    <strong>Fecha Contrato:</strong> {{ date('d/m/Y', strtotime($info->firma_entrega))}}<BR>
                @endif
            <strong>Prioridad:</strong> 
                @if($info->id_licitacion_prioridad == 1)
                    Alta
                @endif
                @if($info->id_licitacion_prioridad == 2)
                    Media
                @endif
                @if($info->id_licitacion_prioridad == 3)
                    Baja
                @endif
            <BR>
        </div>

        <br>

        <table class="table" cellpadding="8" style="page-break-inside: avoid;">
            <thead>
                <tr>
                    <th class="table_header" width="33%" colspan="2" style="text-align: center;" ><strong>Datos del Concurso</strong></th>
                </tr>
            </thead>
            <tbody>


                <tr>
                    <td ><strong>Tipo de contratación:</strong> {{ $tipo_contratacion->tipo_contratacion }}</td>
                    <td ><strong>Publicación del concurso:</strong>
                        @foreach($publicacion as $ub)
                            @if($info->publicacion_licitacion == $ub->id)
                                <p>{{ $ub->publicacion_licitacion }}</p>
                            @endif
                        @endforeach
                    </td>
                </tr>
                <tr>
                    <td ><strong>Fecha registro:</strong> {{ $info->created_at->format('d/m/Y') }}</td>
                    <td ><strong>Fecha de visita:</strong>
                        @if(!empty($info->fecha_visita))
                            {{ date('d/m/Y', strtotime($info->fecha_visita))}}
                        @endif
                    </td>
                </tr>
                <tr>
                    <td ><strong>Fecha de junta de aclaraciones:</strong> 
                        @if(!empty($info->junta_aclaraciones))
                            {{ date('d/m/Y', strtotime($info->junta_aclaraciones))}}
                        @endif
                    </td>
                    <td ><strong>Fecha de presentación y apertura de proposiciones:</strong> 
                        @if(!empty($info->apertura_proposiciones))
                            {{ date('d/m/Y', strtotime($info->apertura_proposiciones))}}
                        @endif
                    </td>
                </tr>
                <tr>
                    <td ><strong>Fecha de acto de fallo:</strong> 
                        @if(!empty($info->acto_fallo))
                            {{ date('d/m/Y', strtotime($info->acto_fallo))}}
                        @endif
                    </td>
                    <td ><strong>Firma de contrato o entrega:</strong>
                        @if(!empty($info->firma_entrega))
                            {{ date('d/m/Y', strtotime($info->firma_entrega))}}
                        @endif
                    </td>
                </tr>    
                <tr>
                    <td  colspan="2"><strong>Fecha de entrega de los servicios:</strong>
                        @if(!empty($info->fecha_entrega))
                            {{ date('d/m/Y', strtotime($info->fecha_entrega))}}
                        @endif
                    </td>
                </tr>

                <tr>
                    <td ><strong>Monto ofertado:</strong> 
                        {{ $info->monto_ofertado }}
                    </td>
                    <td ><strong>Monto adjudicado:</strong> 
                        {{ $info->monto_ganado }}
                    </td>
                </tr>  
                <tr>
                    <td colspan="2" ><strong>Observaciones:</strong> {{ $info->observaciones }}</td>
                </tr>
            </tbody>
        </table>

        @php $precio_unitario = 0; $iva = 0; $total_monto=0; @endphp
        @foreach($segmento as $unid)
            @php 
                $total = $unid->cantidad * $unid->precio_unitario; 
                $precio_unitario = $precio_unitario + $total;
                $iva = $precio_unitario * 0.16;
                $total_monto = $precio_unitario + $iva;
            @endphp
        @endforeach
        
        <table class="table" cellpadding="8" style="overflow:wrap" >
            <thead>
                <tr>
                    <th class="table_header" width="33%" colspan="8" style="text-align: center;" ><strong>Propuesta Económica</strong></th>
                </tr>
                
            </thead>
            <tbody>
                <tr>
                    <td><strong>No.</strong></td>
                    <td><strong>Tipo de vehículo</strong></td>
                    <td><strong>Carrocería</strong></td>
                    <td><strong>Motor</strong></td>
                    <td><strong>Transmisión</strong></td>
                    <td><strong>Cantidad</strong></td>
                    <td><strong>Precio Unitario</strong></td>
                    <td><strong>Total</strong></td>
                </tr>

                @php $precio_unitario = 0; $iva = 0; $total_monto=0; @endphp
                @foreach($segmento as $unid)
                    @php 
                        $total = $unid->cantidad * $unid->precio_unitario; 
                        $precio_unitario = $precio_unitario + $total;
                        $iva = $precio_unitario * 0.16;
                        $total_monto = $precio_unitario + $iva;
                    @endphp
                    <tr>
                        <td>{{ $unid->id }}</td>
                        <td>{{ $unid->tipo_vehiculo }}</td>
                        <td>{{ $unid->carroceria }}</td>
                        <td>{{ $unid->motor }}</td>
                        <td>{{ $unid->transmision }}</td>
                        <td class="text-center">
                            <p>{{ $unid->cantidad }}</p>
                        </td>
                        <td class="text-center">
                            <p>{{ number_format($unid->precio_unitario,2,'.',',') }}</p>
                        </td>

                        <td>
                            <p>{{ number_format($total,2,'.',',') }}</p>
                        </td>
                    </tr>
                @endforeach

                <tr >
                    <td colspan="3" ><strong>Monto Propuesta económica:</strong> ${{ number_format($total_monto,2,'.',',') }}</td>
                    <td colspan="1" >&nbsp;</td>
                    <td colspan="2" ><strong>Subtotal: </strong>${{ number_format($precio_unitario,2,'.',',') }}</td>
                    <td colspan="2" ><strong>IVA 16%: </strong>${{ number_format($iva,2,'.',',') }}</td>
                </tr>
                
            </tbody>
        </table>

</body>
</html>
