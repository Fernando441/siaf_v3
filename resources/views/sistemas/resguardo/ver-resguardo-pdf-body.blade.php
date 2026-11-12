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
            background: #C4C4C4;
            color: #000000;
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
            <strong>NO. FOLIO: {{ $resguardo->no_folio }}</strong>  <BR>
            <strong>FECHA DEL RESGUARDO: {{ $resguardo->fecha_asignacion }}</strong>  <BR>
            <BR>
        </div>

        <br>

        <table class="table" cellpadding="8" style="page-break-inside: avoid;">
            <thead>
                <tr>
                    <th class="table_header" width="33%" colspan="2" style="text-align: center;" ><strong>DATOS DEL USUARIO</strong></th>
                </tr>
            </thead>
            <tbody>


                <tr>
                    <td ><strong>NOMBRE: {{ $user_resguardo->name }}</strong></td>
                    <td ><strong>EXT:</strong>
                    </td>
                </tr>
                <tr>
                    <td ><strong>PUESTO: </strong> </td>
                    <td ><strong>TEL: {{ $user_resguardo->telefono }}</strong>
                    </td>
                </tr>
                <tr>
                    <td ><strong>AREA: {{ $user_resguardo->areaPersonal->nombre_area }}</strong> 
                    </td>
                    <td ><strong>CORREO: {{ $user_resguardo->email }}</strong> 
                    </td>
                </tr>
                <tr>
                    <td ><strong>JEFE INMEDIATO:</strong> 
                    </td>

                </tr>    

 

            </tbody>
        </table>

        
        <table class="table" cellpadding="8" style="overflow:wrap" >
            <thead>
                <tr>
                    <th class="table_header" width="33%" colspan="8" style="text-align: center;" ><strong>DATOS DEL EQUIPO DE COMPUTO</strong></th>
                </tr>
                
            </thead>
            <tbody>
                <tr>
                    <td><strong>No. Folio</strong></td>
                    <td><strong>No. Serie</strong></td>
                    <td><strong>Tipo de equipo</strong></td>
                    <td><strong>Marca</strong></td>
                    <td><strong>Modelo</strong></td>
                </tr>

                @foreach($equipos_asignados as $unid)

                    <tr>
                        <td>{{ $unid->folio }}</td>
                        <td>{{ $unid->no_serie }}</td>
                        <td>{{ $unid->tipo_equipo }}</td>
                        <td>{{ $unid->marca }}</td>
                        <td>{{ $unid->modelo }}</td>
                    </tr>
                @endforeach                
            </tbody>
        </table>


        <table class="table" cellpadding="8" style="overflow:wrap" >
            <thead>
                <tr>
                    <th class="table_header" width="33%" colspan="8" style="text-align: center;" ><strong>Nota</strong></th>
                </tr>
                
            </thead>
            <tbody>

                <tr>
                    <td width="33%" colspan="8" style="text-align: justify;">
                        <span>
                            AL FIRMAR ESTE DOCUMENTO ESTOY DE ACUERDO QUE SE ME HACE RESPONSABLE DEL EQUIPO DE COMPUTO ASIGNADO, COMO DE LOS ACCESORIOS, SERE EL RESPONSABLE POR MOTIVOS DE DESCUIDO O DAÑO FISICO QUE SE PRESENTE.
                        </span>

                    </td>
                </tr>
                <tr>
                    <td width="33%" colspan="8" style="text-align: justify;">
                        <span >
                            ESTOY DE ACUERDO EN DARLE USO CORRECTO PARA MIS ACTIVIDADES DIARIAS Y ASI MISMO ESTOY INFORMADO QUE LA RESPONSABILIDAD DE LA INFORMACION QUE TENGA EN MI EQUIPO ES MIA Y TENGO QUE REALIZAR RESPALDO DE LA INFORMACION POR MOTIVOS DE DAÑO AL EQUIPO O POR FORMATEO DEL EQUIPO POR REPARACION.
                        </span>
                    </td>
                </tr>

               
            </tbody>
        </table>


        <table style="width: 100%; border-collapse: collapse; text-align: center; margin-top: 110px;">
            <tr>
                <td style="width: 50%; padding: 15px;">
                    <h4>{{ $user_resguardo->name }}</h4>
                    <p>_____________________________________________________</p>
                    <h3>NOMBRE Y FIRMA DEL USUARIO</h3>
                </td>

                <td style="width: 50%; padding: 15px;">
                    <h4>{{ $resguardo->userCreated->name }}</h4>
                    <p>_____________________________________________________</p>
                    <h3>NOMBRE Y FIRMA DEL AREA DE SISTEMAS</h3>
                    
                </td>
            </tr>
        </table>


</body>
</html>
