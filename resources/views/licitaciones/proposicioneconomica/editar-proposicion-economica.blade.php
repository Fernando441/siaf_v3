@extends('layouts.app')
@push('scripts')
    <script src="{{ asset('js/licitaciones/proposicioneconomica/EditarProposicion.js') }}"></script> 
@endpush
@section('title')
    Editar propuesta económica
@endsection
@section('content')
    <style type="text/css">
        .total_input{
            width: 140px;
        }
        .partida_text{
             width: 140px;
        }
    .op_select{
box-shadow: 0px 7px 5px -2px rgba(174,251,117,0.74);
-webkit-box-shadow: 0px 7px 5px -2px rgba(174,251,117,0.74);
-moz-box-shadow: 0px 7px 5px -2px rgba(174,251,117,0.74);  
    }
    </style>
    <!--begin::Card-->
    <div class="row">
        <div class="col-lg-12">
            <!--begin::Card-->
            <div class="card card-custom gutter-b">
                <div class="card-header">
                    <h3 class="card-title">Editar propuesta económica</h3>
@foreach ($licitacion as $lic)
    @php
        $lici_id = $lic->id;
        $tipo_contrato = $lic->tipo_contrato;
        $acto_fallo = $lic->acto_fallo;
    @endphp
@endforeach
                    <div class="card-toolbar">
                        @if (in_array(114, $permiso_array))
                            <a href="{{ route('licitacion.ver',$lici_id)}}" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon" title="Ver concurso" data-theme="dark" data-toggle="tooltip" data-placement="top">
                                <i class="flaticon-eye"></i>
                            </a>   {{-- VER licitacion --}}
                        @endif

                        @if (in_array(116, $permiso_array))
                            <a href="{{ route('licitacion.editarlicitacion',$lici_id) }}" class="btn btn-sm  btn-hover-icon-success btn-icon" title="Editar concurso" data-theme="dark" data-toggle="tooltip" data-placement="top">
                                <i class="flaticon-edit"></i>
                            </a>   {{-- Editar licitacion --}}
                        @endif

                        @if (in_array(133, $permiso_array))
                            @if($acto_fallo == null || $acto_fallo == ""){
                            @else
                                <a href="{{ route('licitacion.agregar',$lici_id) }}" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon" title="Crear contrato" data-theme="dark" data-toggle="tooltip" data-placement="top">
                                    <i class="flaticon-file-1"></i>
                                </a>  {{-- Agregar contrato --}}
                            @endif
                        @endif

                        @if (in_array(134, $permiso_array))
                            <a href="{{ route('proposicioneconomica.crearproposicioneconomica', [$lici_id,1,$tipo_contrato]) }}" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon op_select" title="Crear propuesta económica" data-theme="dark" data-toggle="tooltip" data-placement="top">
                                <i class="flaticon-presentation-1"></i>
                            </a>   {{-- Propuesta economica --}}
                        @endif

                        @if (in_array(135, $permiso_array))
                            <a href="{{ route('propuestatecnica.crearpropuestatecnica',$lici_id) }}" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon" title="Crear propuesta" data-theme="dark" data-toggle="tooltip" data-placement="top">
                                <i class="flaticon2-website"></i>  
                            </a>   {{-- Propuesta Tecnica --}}
                        @endif

                        @if (in_array(143, $permiso_array))
                            <a href="{{ route('licitacion.informacionfinanzas',$lici_id) }}" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon" title="Información de las fianzas y seguros" data-theme="dark" data-toggle="tooltip" data-placement="top">
                                    <i class="flaticon-notepad"></i>
                            </a>   {{-- Finanzas --}}
                        @endif

                        <a href="{{ route('licitacion.listadolicitaciones') }}" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon" data-toggle="tooltip" data-theme="dark" title="Salir" ><i class="flaticon2-reply "></i></a>
                    </div>
                </div>
                <!--begin::Form-->
                <form action="{{ route('proposicioneconomica.modificarproposicioneconomica') }}" method="post" id="submit_proposicion">
                    @csrf


                        <input type="hidden" name="ref_proposicion" value="{{ $proposicion }}">
                        <input type="hidden" name="ref_redirect" value="{{ $redirect }}">
                        <input type="hidden" name="ref_contrato" value="{{ $contrato }}">

                    <div class="card-body">
                        <input type="hidden" name="op_economica" value="0">
                        <div class="row">
                            @foreach($licitacion as $lic)
                                <div class="col-lg-4 col-sm-6 form-group">
                                    <label>Folio del concurso</label>
                                    <p>{{ $lic->folio }}</p>
                                </div>

                                <div class="col-lg-4 col-sm-6 form-group">
                                    <label>No. Concurso</label>
                                    <p>{{ $lic->no_licitacion }}</p>
                                </div>

                                <div class="col-lg-4 col-sm-6 form-group">
                                    <label>Titulo del servicio</label>
                                    <p>{{ $lic->titulo_servicio }}</p>
                                </div>

                                <div class="col-lg-4 col-sm-6 form-group">
                                        <label>Prioridad</label>
                                        @if($lic->id_licitacion_prioridad == 1)
                                            <p><span class="label font-weight-bold label-outline-danger label-inline" >Alta</span></p>
                                        @endif
                                        @if($lic->id_licitacion_prioridad == 2)
                                            <p><span class="label font-weight-bold label-outline-warning label-inline" >Media</span></p>
                                        @endif
                                        @if($lic->id_licitacion_prioridad == 3)
                                            <p><span class="label font-weight-bold label-outline-primary label-inline" >Baja</span></p>
                                        @endif
                                </div>

                                <div class="col-lg-4 col-sm-6 form-group">
                                    <label>Cliente</label>
                                    <p>{{ $lic->razon_social }}</p>
                                </div>
                                <input type="hidden" name="licitacion_id" value="{{ $lic->id }}">
                            @endforeach
                        </div>

                        <div class="row form-group">

                            @foreach($proposicioneconomica as $pro)
                                @php
                                    $precio_cotizar = $pro->precio_cotizar;
                                    $precio_diario = $pro->precio_cotizar_diario;
                                    $precio_mes = $pro->precio_cotizar_mes;
                                    $precio_anual = $pro->precio_cotizar_anual;
                                @endphp
                            @endforeach
                        </div>

                            <div class="card card-custom gutter-b">
                                <div class="card-header">
                                    <div class="card-title">
                                        <h3 class="card-label">
                                            Precio a cotizar
                                        </h3>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row form-group">

                                        <div class="col-lg-6">
                                            <label>Precio unitario a cotizar</label>
                                            @if($precio_cotizar ==0)
                                                <p><span class="label font-weight-bold label-outline-primary label-inline" style="font-size: 16px">Diario / {{ $precio_diario }}</span></p>
                                            @endif
                                            @if($precio_cotizar ==1)
                                                <p><span class="label font-weight-bold label-outline-primary label-inline" style="font-size: 16px">Mes / {{ $precio_mes }}</span></p>
                                            @endif
                                            @if($precio_cotizar ==2)
                                                <p><span class="label font-weight-bold label-outline-primary label-inline" style="font-size: 16px">Anual / {{ $precio_anual }}</span></p>
                                            @endif

                                        </div>
                                    </div>

                            </div>
                        </div>
                        <input type="hidden" id="precio_cotizar_op" value="{{ $precio_cotizar }}">
                        <input type="hidden" id="dia_op" value="{{ $precio_diario }}">
                        <input type="hidden" id="mes_op" value="{{ $precio_mes }}">
                        <input type="hidden" id="anual_op" value="{{ $precio_anual }}">
                        <table class="table table-hover table-checkable table-responsive">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Tipo de vehículo</th>
                                    <th>Carrocería</th>
                                    <th>Motor</th>
                                    <th>Transmisión</th>
                                    <th>Cantidad</th>
                                    <th>Precio Unitario</th>
                                    <th>Total</th>
                                    <th>
                                        @if($precio_cotizar ==0)
                                            Total día
                                        @endif
                                        @if($precio_cotizar ==1)
                                            Total mes
                                        @endif
                                        @if($precio_cotizar ==2)
                                            Total año
                                        @endif
                                    </th>
                                    {{-- <th>Acciones</th> --}}
                                </tr>
                            </thead>

                            <tbody>
                                @php $precio_unitario = 0; $iva = 0; $total_monto=0; $subtotal_calculo=0; $iva_calculo=0; @endphp
                                @foreach($segmento as $unid)
                                    <tr>
                                        <td><input type="text" class="form-control partida_text" name="partida[]" value="{{ $unid->partida }}"></td>
                                        <td>{{ $unid->tipo_vehiculo }}</td>
                                        <td>{{ $unid->carroceria }}</td>
                                        <td>{{ $unid->motor }}</td>
                                        <td>{{ $unid->transmision }}</td>
                                        <td class="text-center">
                                            <input type="hidden" name="segmento[]" value="{{ $unid->id }}">
                                            {{-- <input type="number" onkeyup="myFunction()" class="form-control cantidad" name="cantidad[]" id="cantidad" value="{{ $unid->cantidad }}"/> --}}
                                            <input type="number" class="form-control monto input total_input" name="cantidad[]" value="{{ $unid->cantidad }}">
                                        </td>
                                        <td class="text-center">
                                            {{-- <input type="text" class="form-control data precio_unitario" name="precio_unitario[]" id="precio_unitario" onkeyup="myFunction()" value="{{ $unid->precio_unitario }}" /> --}}
                                            <input type="number" class="form-control monto input total_input"name="precio_unitario[]" value="{{ $unid->precio_unitario }}">
                                        </td>
                                        @php 
                                            $total = $unid->cantidad * $unid->precio_unitario; 
                                            $precio_unitario = $precio_unitario + $total;
                                            $iva = $precio_unitario * 0.16;
                                            $total_monto = $precio_unitario + $iva;

                                            if($precio_cotizar == 0){
                                                $precio_dia = $precio_diario;
                                                $total_precio_calculo = $total / $precio_dia;
                                                $subtotal_calculo = $subtotal_calculo + $total_precio_calculo;
                                                $iva_calculo = $subtotal_calculo * 0.16;
                                                $total_monto_calculo = $subtotal_calculo + $iva_calculo;
                                            }

                                            if($precio_cotizar == 1){
                                                $precio_por_mes = $precio_mes;
                                                $total_precio_calculo = $total * $precio_por_mes;
                                                $subtotal_calculo = $subtotal_calculo + $total_precio_calculo;
                                                $iva_calculo = $subtotal_calculo * 0.16;
                                                $total_monto_calculo = $subtotal_calculo + $iva_calculo;
                                            }

                                            if($precio_cotizar == 2){
                                                $precio_por_anual = $precio_anual *12;
                                                $total_precio_calculo = $total * $precio_por_anual;
                                                $subtotal_calculo = $subtotal_calculo + $total_precio_calculo;
                                                $iva_calculo = $subtotal_calculo * 0.16;
                                                $total_monto_calculo = $subtotal_calculo + $iva_calculo;
                                            }
                                        @endphp
                                        <td>
                                            {{-- <label class="total" id="total">${{ number_format($total,2,'.',',') }}</label> --}}
                                             <input type="text" class="form-control monto total total_input" value="{{ number_format($total,2,'.',',') }}" disabled>
                                             <input type="hidden" class="form-control monto total_m total_input"  value="{{ $total }}">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control monto total total_c total_input" value="{{ number_format($total_precio_calculo,2,'.',',') }}" disabled>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tbody>

                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>
                                            <h4>Subtotal</h4>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control monto totales total_input" id="subtotal_minimo" value="{{ number_format($precio_unitario,2,'.',',') }}" disabled>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control monto totales_c total_input" id="subtotal_minimo" value="{{ number_format($subtotal_calculo,2,'.',',') }}" disabled>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>
                                            <h4>Iva</h4> 
                                        </td>
                                        <td>
                                            <input type="text" class="form-control monto iva total_input" value="{{ number_format($iva,2,'.',',') }}" disabled>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control monto iva_c total_input" value="{{ number_format($iva_calculo,2,'.',',') }}" disabled>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>
                                            <h4>Total</h4>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control monto subt total_input" value="{{ number_format($total_monto,2,'.',',') }}" disabled>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control monto subt_c total_input" value="{{ number_format($total_monto_calculo,2,'.',',') }}" disabled>
                                        </td>
                                    </tr>

                            </tbody>
                        </table>
                            <!--end: Datatable-->

                        <input type="hidden" id="datatable_i18n" value="{{ asset('/js/datatables/i18n/es-mx.json') }}">


                        @foreach($proposicioneconomica as $pro)
                            <div class="form-group">
                                <label for="observaciones">Observaciones</label>
                                <textarea class="form-control specialCharts" name="observaciones" id="observaciones" rows="3" required onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">{{ $pro->observaciones }}</textarea>
                            </div>
{{--                             <div class="form-group row">
                               <div class="col-lg-6">
                                    <label>Tipo de cotización de la fianza</label>
                                    <div class="radio-inline">
                                        <label class="radio">
                                            <input type="radio" checked name="tipo_cotizacion_fianza" value="0"/>
                                            <span></span>
                                            Día
                                        </label>
                                        <label class="radio">
                                            <input type="radio" name="tipo_cotizacion_fianza" value="1"/>
                                            <span></span>
                                            Mes
                                        </label>
                                        <label class="radio">
                                            <input type="radio" name="tipo_cotizacion_fianza" value="2"/>
                                            <span></span>
                                            Año
                                        </label>
                                    </div>
                                </div>


                                <div class="col-lg-6">
                                    <label>Número de fianza de sostenibilidad de la oferta</label>
                                    <input type="text" class="form-control" name="numero_sostenibilidad" id="numero_sostenibilidad" value="{{ $pro->numero_sostenibilidad }}" />
                                </div>
                            </div> --}}
{{-- 
                            <div class="row form-group">
                               <div class="col-lg-6">
                                    <label>Seleccionar el porcentaje de fianza</label>
                                    <div class="radio-inline">
                                        <label class="radio">
                                            <input type="radio" name="porcentaje_fianza" id="por_dos" value="0"/>
                                            <span></span>
                                            2%
                                        </label>
                                        <label class="radio">
                                            <input type="radio" name="porcentaje_fianza" id="por_cinco" value="1"/>
                                            <span></span>
                                            5%
                                        </label>
                                        <label class="radio">
                                            <input type="radio" name="porcentaje_fianza" id="por_diez" value="2"/>
                                            <span></span>
                                            10%
                                        </label>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <label>Importe</label>
                                    <input type="text" class="form-control" name="importe" id="importe" value="{{ $pro->importe }}" />
                                </div>
                            </div> --}}

{{--                             <div class="form-group row">
                                <div class="col-lg-6">
                                    <label>Afianzadora</label>
                                    <select class="form-control" name="nombre_afianzadora" id="nombre_afianzadora" required>
                                        <option value="">Selecciona una opción</option>
                                        @foreach($afianzadora as $ub)
                                            <option value="{{ $ub->id }}" @selected($pro->afianzadoras_id  == $ub->id) >{{ $ub->nombre_afianzadora }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-6">
                                    <label>Vigencia de fianza</label>
                                    @if($pro->vigencia_fianza == null || $pro->vigencia_fianza == "")
                                        <input type="text" class="form-control" redonly name="vigencia_fianza" id="vigencia_fianza" value="" />
                                    @else
                                        <input type="text" class="form-control" redonly name="vigencia_fianza" id="vigencia_fianza" value="{{ date('d/m/Y', strtotime($pro->vigencia_fianza))}}" />
                                    @endif
                                </div>
                            </div> --}}
                            <input type="hidden" name="licitacion_id" value="{{ $pro->licitacion_id }}">
                            <input type="hidden" name="redirect" value="{{ $redirect }}">
                        @endforeach
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-lg-6">
                                <button type="button"  id="btnGuardar" class="btn btn-success"><i class="la la-plus"></i>Guardar</button>
                                @if($redirect == 1)
                                    <a href="{{ route('licitacion.listadolicitaciones') }}"  class="btn btn-secondary"><i class="la la-arrow-left"></i>Regresar</a>
                                @else
                                    <a href="{{ route('proposicioneconomica.catalogoproposicioneconomica') }}"  class="btn btn-secondary"><i class="la la-arrow-left"></i>Regresar</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </form>
                <!--end::Form-->
            </div>
            <!--end::Card-->
        </div>
    </div>
    <!--end::Card-->

    <form method="post" id="segmento_delete_form" action="{{ route('proposicioneconomica.eliminarpropuesta') }}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="id" id="id_delete" value="">
        @foreach($proposicioneconomica as $pro)
            <input type="hidden" name="licitacion_id" value="{{ $pro->id }}">
        @endforeach
    </form>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script>
    // generamos un evento click y keyup para cada elemento input con la clase .input
    var input=document.querySelectorAll(".input");
    input.forEach(function(e) {
        e.addEventListener("click",multiplica);
        e.addEventListener("keyup",multiplica);
    });
     
    const formatoMexico = (number) => {
        const exp = /(\d)(?=(\d{3})+(?!\d))/g;
        const rep = '$1,';
        let arr = number.toString().split('.');
        arr[0] = arr[0].replace(exp,rep);
        return arr[1] ? arr.join('.'): arr[0];
    }

    function multiplica() {
        var op_precio = document.getElementById("precio_cotizar_op").value;
        var dia_op = document.getElementById("dia_op").value;
        var mes_op = document.getElementById("mes_op").value;
        var anual_op = document.getElementById("anual_op").value;
        console.log("opcion calcular" + op_precio);
        var tr=this.closest("tr");
     
        var total=1;
        var total_calculo = 1;
        var inputs=tr.querySelectorAll(".input");
        inputs.forEach(function(e) {
            total*=e.value;
            if(op_precio == 0){
                total_calculo = total / dia_op;
            }

            if(op_precio == 1){
                total_calculo = total * mes_op;
            }

            if(op_precio == 2){
                total_calculo = total * (anual_op * 12);
            }


        });
        console.log("total" + total)
        tr.querySelector(".total").value=formatoMexico(total.toFixed(2));
        tr.querySelector(".total_m").value=total.toFixed(2);
        tr.querySelector(".total_c").value=total_calculo.toFixed(2);
        
        calcularTotal(this.closest("table"));
    }
     

    function calcularTotal(e) {
        var total=0;
        var total_calculo = 0;

        var totales=e.querySelectorAll(".total_m");
        totales.forEach(function(e) {
            total+=parseFloat(e.value);
        });
        var iva = total.toFixed(2) * 0.16;
        var subtotal = iva + total;
        
        e.getElementsByClassName("totales")[0].value=formatoMexico(total.toFixed(2));
        e.getElementsByClassName("iva")[0].value=formatoMexico(iva.toFixed(2));
        e.getElementsByClassName("subt")[0].value=formatoMexico(subtotal.toFixed(2));   


        var totales_c=e.querySelectorAll(".total_c");
        totales_c.forEach(function(e) {
            total_calculo+=parseFloat(e.value);
        });
        var iva = total_calculo.toFixed(2) * 0.16;
        var subtotal = iva + total_calculo;
        
        e.getElementsByClassName("totales_c")[0].value=formatoMexico(total_calculo.toFixed(2));
        e.getElementsByClassName("iva_c")[0].value=formatoMexico(iva.toFixed(2));
        e.getElementsByClassName("subt_c")[0].value=formatoMexico(subtotal.toFixed(2));   



    }
</script>


<script type="text/javascript">

     $("#por_dos").click(function(){
        document.getElementById("importe").value = "";

        var minimo = document.getElementById("subtotal_minimo").value;
        var sub_minimo = minimo.replace(/,/g, "");


        var mult_minimo = (parseFloat(sub_minimo) * 2)/100;
        var total_minimo = parseFloat(sub_minimo) + mult_minimo;
        
        document.getElementById("importe").value = formatoMexico(total_minimo.toFixed(2));

     });

     $("#por_cinco").click(function(){
        document.getElementById("importe").value = "";


        var minimo = document.getElementById("subtotal_minimo").value;
        var sub_minimo = minimo.replace(/,/g, "");


        var mult_minimo = (parseFloat(sub_minimo) * 5)/100;
        var total_minimo = parseFloat(sub_minimo) + mult_minimo;
        
        document.getElementById("importe").value = formatoMexico(total_minimo.toFixed(2));;

     });

     $("#por_diez").click(function(){
        document.getElementById("importe").value = "";


        var minimo = document.getElementById("subtotal_minimo").value;
        var sub_minimo = minimo.replace(/,/g, "");


        var mult_minimo = (parseFloat(sub_minimo) * 10)/100;
        var total_minimo = parseFloat(sub_minimo) + mult_minimo;
        
        document.getElementById("importe").value = formatoMexico(total_minimo.toFixed(2));;


     });
</script>

@endsection