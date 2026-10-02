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



        <table class="table" cellpadding="8" style="page-break-inside: avoid;">
            <thead>
                <tr>
                    <th class="table_header" width="33%" colspan="2" style="text-align: center;" ><strong>Datos de la requisición</strong></th>
                </tr>
            </thead>
            <tbody>


                <tr>
                    <td ><strong>Titulo de la requisición:</strong> {{ $requisicion->titulo_requisicion }}</td>
                    <td ><strong>Solicitante:</strong> {{ $requisicion->userCreated->name}} </td>
                </tr>
                <tr>
                    <td ><strong>Area:</strong> 
                                        @foreach($area as $are)
                                            @if($are->id == $requisicion->area_personal_id )
                                                <p>{{ $are->nombre_area }}</p>
                                            @endif
                                        @endforeach
                    </td>
                    <td ><strong>Fecha de Solicitud:</strong>
                        @if(!empty($requisicion->fecha_requisicion ))
                            {{ date('d/m/Y', strtotime($requisicion->fecha_requisicion ))}}
                        @endif
                    </td>
                </tr>

 
                <tr>
                    <td colspan="2" ><strong>Observaciones:</strong> {{ $requisicion->comentario }}</td>
                </tr>
            </tbody>
        </table>


        <table class="table" cellpadding="8" style="overflow:wrap" >
            <thead>
                <tr>
                    <th class="table_header" width="33%" colspan="8" style="text-align: center;" ><strong>Información solicitada</strong></th>
                </tr>
                
            </thead>
            <tbody>
                <tr>
                    <td><strong>Descripción</strong></td>
                    <td><strong>Cantidad</strong></td>
                    <td><strong>Observaciones</strong></td>
                </tr>

                @foreach($detalle as $unid)
                    <tr>
                        <td>{{ $unid->descripcion }}</td>
                        <td>{{ $unid->cantidad }}</td>
                        <td>{{ $unid->obervaciones }}</td>

                    </tr>
                @endforeach

            </tbody>
        </table>

</body>
</html>
