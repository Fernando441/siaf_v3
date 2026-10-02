@extends('layouts.app')
@push('scripts')
@endpush
@section('title')
    Ver concurso
@endsection
@section('content')
<style type="text/css">
    .oculto{
        display: none;
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
                <h3 class="card-title">Ver concurso</h3>

                <div class="card-toolbar">
                    @if (in_array(114, $permiso_array))
                        <a href="{{ route('licitacion.ver',$info->id)}}" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon op_select" title="Ver concurso" data-theme="dark" data-toggle="tooltip" data-placement="top">
                            <i class="flaticon-eye"></i>
                        </a>   {{-- VER licitacion --}}
                    @endif

                    @if (in_array(116, $permiso_array))
                        <a href="{{ route('licitacion.editarlicitacion',$info->id) }}" class="btn btn-sm  btn-hover-icon-success btn-icon" title="Editar concurso" data-theme="dark" data-toggle="tooltip" data-placement="top">
                            <i class="flaticon-edit"></i>
                        </a>   {{-- Editar licitacion --}}
                    @endif

                    @if (in_array(133, $permiso_array))
                        @if($info->acto_fallo == null || $info->acto_fallo == "")
                        @else
                            <a href="{{ route('licitacion.agregar',$info->id) }}" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon" title="Crear contrato" data-theme="dark" data-toggle="tooltip" data-placement="top">
                                <i class="flaticon-file-1"></i>
                            </a>  {{-- Agregar contrato --}}
                        @endif
                    @endif

                    @if (in_array(134, $permiso_array))
                        <a href="{{ route('proposicioneconomica.crearproposicioneconomica', [$info->id,1,$info->tipo_contrato]) }}" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon" title="Crear propuesta económica" data-theme="dark" data-toggle="tooltip" data-placement="top">
                            <i class="flaticon-presentation-1"></i>
                        </a>   {{-- Propuesta economica --}}
                    @endif

                    @if (in_array(135, $permiso_array))
                        <a href="{{ route('propuestatecnica.crearpropuestatecnica',$info->id) }}" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon" title="Crear propuesta" data-theme="dark" data-toggle="tooltip" data-placement="top">
                            <i class="flaticon2-website"></i>  
                        </a>   {{-- Propuesta Tecnica --}}
                    @endif

                    @if (in_array(143, $permiso_array))
                        <a href="{{ route('licitacion.informacionfinanzas',$info->id) }}" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon" title="Información de las fianzas y seguros" data-theme="dark" data-toggle="tooltip" data-placement="top">
                                <i class="flaticon-notepad"></i>
                        </a>   {{-- Finanzas --}}
                    @endif

                    @if (in_array(135, $permiso_array))
                        <a href="{{ route('reqconcurso.listadoreqconsursos',$info->id) }}" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon" title="Requisiciones" data-theme="dark" data-toggle="tooltip" data-placement="top">
                                <i class="flaticon2-delivery-truck"></i>
                        </a>
                     @endif

                    <a href="{{ route('licitacion.listadolicitaciones') }}" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon" data-toggle="tooltip" data-theme="dark" title="Salir" ><i class="flaticon2-reply "></i></a>
                </div>

            </div>
            <!--begin::Form-->
            <form action="" method="post" >
                <input type="hidden" name="id" value="{{ $info->id }}">
                @csrf
                <div class="card-body">


                    <!--begin::tabs-->
                    <ul class="nav nav-tabs nav-tabs-line">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#kt_tab_pane_4">Fecha técnica</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#kt_tab_pane_1">Información basica</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#kt_tab_pane_2">Documentos</a>
                        </li>
                        @if($info->id_licitacion_estatus == 2)
                            <li>
                                 <a class="nav-link" data-toggle="tab" href="#kt_tab_pane_3">Información del contrato</a>
                            </li>
                        @endif
                    </ul>

                    <div class="tab-content mt-5" id="myTabContent">
                        <div class="tab-pane fade show active mt-10" id="kt_tab_pane_4" role="tabpanel" aria-labelledby="kt_tab_pane_4">

                            <div class="card card-custom gutter-b">
                                <div class="card-header">
                                    <div class="card-title">
                                        <h3 class="card-label">
                                            Información general
                                        </h3>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-4 col-sm-6 form-group">
                                            <label>Folio del concurso</label>
                                            <p>{{ $info->folio }}</p>
                                        </div>

                                        <div class="col-lg-4 col-sm-6 form-group">
                                            <label>No. Concurso</label>
                                            <p>{{ $info->no_licitacion }}</p>
                                        </div>


                                        <div class="col-lg-4 col-sm-6 form-group">
                                            <label>Titulo del servicio</label>
                                            <p>{{ $info->titulo_servicio }}</p>
                                        </div>

                                        <div class="col-lg-4 col-sm-6 form-group">
                                            <label>Fecha y firma de formalización del contrato</label>
                                            @if($info->firma_entrega == null || $info->firma_entrega == "")
                                                <p>Sin información</p>
                                            @else
                                                <p>{{ date('d/m/Y', strtotime($info->firma_entrega))}}</p>
                                            @endif
                                        </div>

                                        <div class="col-lg-4 col-sm-6 form-group">
                                            <label>Cliente</label>
                                            <p>{{ $cliente->razon_social }}</p>
                                        </div>

                                        <div class="col-lg-4 col-sm-6 form-group">
                                            <label>Prioridad</label>
                                            @if($info->id_licitacion_prioridad == 1)
                                                <p><span class="label font-weight-bold label-outline-danger label-inline" >Alta</span></p>
                                            @endif
                                            @if($info->id_licitacion_prioridad == 2)
                                                <p><span class="label font-weight-bold label-outline-warning label-inline" >Media</span></p>
                                            @endif
                                            @if($info->id_licitacion_prioridad == 3)
                                                <p><span class="label font-weight-bold label-outline-primary label-inline" >Baja</span></p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                {{-- Propuesta economica abierta --}}
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

                                        <div class="col-lg-4">
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
                                        <div class="col-lg-4">
                                            @if($info->tipo_contrato == 0)
                                                <label>Contrato Abierto</label>
                                            @else
                                                <label>Contrato Cerrado</label>
                                            @endif
                                        </div>
                                    </div>

                            </div>
                        </div>

                        <input type="hidden" id="precio_cotizar_op" value="{{ $precio_cotizar }}">
                        <input type="hidden" id="dia_op" value="{{ $precio_diario }}">
                        <input type="hidden" id="mes_op" value="{{ $precio_mes }}">
                        <input type="hidden" id="anual_op" value="{{ $precio_anual }}">

                        @if($info->tipo_contrato == 0)
                        <table class="table table-hover table-checkable table-responsive">
                            <thead>
                                <tr>
                                    <th>Partida</th>
                                    <th>Tipo de vehículo</th>
                                    <th>Carrocería</th>
                                    <th>Motor</th>
                                    <th>Transmisión</th>
                                    <th>Cantidad mínima</th>
                                    <th>Cantidad máxima</th>
                                    <th>Precio unitario</th>
                                    <th></th>
                                    <th>Total mínimo</th>
                                    <th>Total máximo</th>
                                    <th>
                                        @if($precio_cotizar ==0)
                                            Total día mínimo
                                        @endif
                                        @if($precio_cotizar ==1)
                                            Total mes mínimo
                                        @endif
                                        @if($precio_cotizar ==2)
                                            Total año mínimo
                                        @endif
                                    </th>
                                    <th>
                                        @if($precio_cotizar ==0)
                                            Total día maximo
                                        @endif
                                        @if($precio_cotizar ==1)
                                            Total mes maximo
                                        @endif
                                        @if($precio_cotizar ==2)
                                            Total año maximo
                                        @endif
                                    </th>
                                </tr>
                            </thead>

                            <tbody>
                                @php 
                                    $precio_unitario = 0; $iva = 0; $total_monto=0; 
                                    $precio_unitariomax = 0; $ivamax = 0; $total_montomax=0;  $subtotal_calculo_minimo=0; $subtotal_calculo_maximo=0;
                                @endphp 
                                @foreach($segmento as $unid)
                                    <tr>
                                        <td>{{ $unid->partida }}</td>
                                        <td>{{ $unid->tipo_vehiculo }}</td>
                                        <td>{{ $unid->carroceria }}</td>
                                        <td>{{ $unid->motor }}</td>
                                        <td>{{ $unid->transmision }}</td>
                                        <td class="text-center">
                                            <input type="hidden" name="segmento[]" value="{{ $unid->id }}">
                                            {{ $unid->cantidad }}
                                        </td>
                                        <td>
                                            {{ $unid->cantidad_maxima }}
                                        </td>
                                        <td class="text-center">
                                            {{ $unid->precio_unitario }}
                                        </td>
                                        <td>
                                            {{ $unid->precio_unitario }}
                                        </td>
                                        @php 
                                            $total = $unid->cantidad * $unid->precio_unitario; 
                                            $precio_unitario = $precio_unitario + $total;
                                            $iva = $precio_unitario * 0.16;
                                            $total_monto = $precio_unitario + $iva;
                                            // END precios minimos

                                            $totalmax = $unid->cantidad_maxima * $unid->precio_unitario; 
                                            $precio_unitariomax = $precio_unitariomax + $totalmax;
                                            $ivamax = $precio_unitariomax * 0.16;
                                            $total_montomax = $precio_unitariomax + $ivamax;

                                            if($precio_cotizar == 0){
                                                $precio_dia = $precio_diario;
                                                $total_precio_calculo_minimo = $total / $precio_dia;
                                                $subtotal_calculo_minimo = $subtotal_calculo_minimo + $total_precio_calculo_minimo;
                                                $iva_calculo_minimo = $subtotal_calculo_minimo * 0.16;
                                                $total_monto_calculo_minimo = $subtotal_calculo_minimo + $iva_calculo_minimo;
                                                //Minimo

                                                $precio_dia = $precio_diario;
                                                $total_precio_calculo_maximo = $totalmax / $precio_dia;
                                                $subtotal_calculo_maximo = $subtotal_calculo_maximo + $total_precio_calculo_maximo;
                                                $iva_calculo_maximo = $subtotal_calculo_maximo * 0.16;
                                                $total_monto_calculo_maximo = $subtotal_calculo_maximo + $iva_calculo_maximo;      
                                            }

                                            if($precio_cotizar == 1){
                                                $precio_por_mes = $precio_mes;
                                                $total_precio_calculo_minimo = $total * $precio_por_mes;
                                                $subtotal_calculo_minimo = $subtotal_calculo_minimo + $total_precio_calculo_minimo;
                                                $iva_calculo_minimo = $subtotal_calculo_minimo * 0.16;
                                                $total_monto_calculo_minimo = $subtotal_calculo_minimo + $iva_calculo_minimo;
                                                //Minimo

                                                $precio_por_mes = $precio_mes;
                                                $total_precio_calculo_maximo = $totalmax * $precio_por_mes;
                                                $subtotal_calculo_maximo = $subtotal_calculo_maximo + $total_precio_calculo_maximo;
                                                $iva_calculo_maximo = $subtotal_calculo_maximo * 0.16;
                                                $total_monto_calculo_maximo = $subtotal_calculo_maximo + $iva_calculo_maximo;      
                                            }


                                            if($precio_cotizar == 2){
                                                $precio_por_anual = $precio_anual *12;
                                                $total_precio_calculo_minimo = $total * $precio_por_anual;
                                                $subtotal_calculo_minimo = $subtotal_calculo_minimo + $total_precio_calculo_minimo;
                                                $iva_calculo_minimo = $subtotal_calculo_minimo * 0.16;
                                                $total_monto_calculo_minimo = $subtotal_calculo_minimo + $iva_calculo_minimo;
                                                //Minimo

                                                $precio_por_anual = $precio_anual *12;
                                                $total_precio_calculo_maximo = $totalmax * $precio_por_anual;
                                                $subtotal_calculo_maximo = $subtotal_calculo_maximo + $total_precio_calculo_maximo;
                                                $iva_calculo_maximo = $subtotal_calculo_maximo * 0.16;
                                                $total_monto_calculo_maximo = $subtotal_calculo_maximo + $iva_calculo_maximo;      
                                            }


                                        @endphp
                                        <td>
                                             {{ number_format($total,2,'.',',') }}
                                             <input type="hidden" class="form-control monto total_m total_input"  value="{{ $total }}">
                                        </td>

                                        <td>
                                             {{ number_format($totalmax,2,'.',',') }}
                                             <input type="hidden" class="form-control monto total_m_maximo total_input_maximo"  value="{{ $total_montomax }}">
                                        </td>

                                        <td>
                                           {{ number_format($total_precio_calculo_minimo,2,'.',',') }}
                                        </td>


                                        <td>
                                            {{ number_format($total_precio_calculo_maximo,2,'.',',') }}
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
                                        <td></td>
                                        <td></td>
                                        <td><h5>Subtotal</h5></td>
                                        <td> {{ number_format($precio_unitario,2,'.',',') }}</td>
                                        <td>
                                            {{ number_format($precio_unitariomax,2,'.',',') }}
                                        </td>
                                        <td>
                                            {{ number_format($subtotal_calculo_minimo,2,'.',',') }}
                                        </td>
                                        <td>
                                            {{ number_format($subtotal_calculo_maximo,2,'.',',') }}
                                        </td>

                                        
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td><h5>Iva</h5></td>
                                        <td>
                                             {{ number_format($iva,2,'.',',') }}
                                        </td>
                                        <td>
                                            {{ number_format($ivamax,2,'.',',') }}
                                        </td>
                                        <td>
                                            {{ number_format($iva_calculo_minimo,2,'.',',') }}
                                        </td>
                                        <td>
                                            {{ number_format($iva_calculo_maximo,2,'.',',') }}
                                        </td>
                                        
                                    </tr>

                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td><h5>Total</h5></td>
                                        <td>
                                            {{ number_format($total_monto,2,'.',',') }}
                                        </td>
                                        <td>
                                            {{ number_format($total_montomax,2,'.',',') }}
                                        </td>
                                        <td>
                                           {{ number_format($total_monto_calculo_minimo,2,'.',',') }}
                                        </td>
                                        <td>
                                            {{ number_format($total_monto_calculo_maximo,2,'.',',') }}
                                        </td>

                                        
                                    </tr>



                            </tbody>
                        </table>
                        @else
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
                                        <td>{{ $unid->partida }}</td>
                                        <td>{{ $unid->tipo_vehiculo }}</td>
                                        <td>{{ $unid->carroceria }}</td>
                                        <td>{{ $unid->motor }}</td>
                                        <td>{{ $unid->transmision }}</td>
                                        <td class="text-center">
                                            <input type="hidden" name="segmento[]" value="{{ $unid->id }}">
                                            {{-- <input type="number" onkeyup="myFunction()" class="form-control cantidad" name="cantidad[]" id="cantidad" value="{{ $unid->cantidad }}"/> --}}
                                            {{ $unid->cantidad }}
                                        </td>
                                        <td class="text-center">
                                            {{-- <input type="text" class="form-control data precio_unitario" name="precio_unitario[]" id="precio_unitario" onkeyup="myFunction()" value="{{ $unid->precio_unitario }}" /> --}}
                                            {{ $unid->precio_unitario }}
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
                                             {{ number_format($total,2,'.',',') }}
                                             <input type="hidden" class="form-control monto total_m total_input"  value="{{ $total }}">
                                        </td>
                                        <td>
                                            {{ number_format($total_precio_calculo,2,'.',',') }}
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
                                            {{ number_format($precio_unitario,2,'.',',') }}                                       
                                        </td>
                                        <td>
                                            {{ number_format($subtotal_calculo,2,'.',',') }}
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
                                            <{{ number_format($iva,2,'.',',') }}
                                        </td>
                                        <td>
                                            {{ number_format($iva_calculo,2,'.',',') }}
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
                                            {{ number_format($total_monto,2,'.',',') }}
                                        </td>
                                        <td>
                                           {{ number_format($total_monto_calculo,2,'.',',') }}
                                        </td>
                                    </tr>

                            </tbody>
                        </table>
                        @endif
                {{-- END propuesta economica abierta --}}

                        </div>


                        <div class="tab-pane fade mt-10" id="kt_tab_pane_1" role="tabpanel" aria-labelledby="kt_tab_pane_1">

                            <div class="row form-group">

                                <div class="col-lg-6">
                                    <label>Folio</label>
                                    <p>{{ $info->folio }}</p>
                                </div>

                                <div class="col-lg-6">
                                    <label>Fecha registro</label>
                                    <p>{{ $info->created_at->format('d/m/Y') }}</p>
                                </div>

                            </div>

                            <div class="row form-group">
                                <div class="col-lg-6">
                                    <label>Publicación del concurso</label>
                                    @foreach($publicacion as $ub)
                                        @if($info->publicacion_licitacion == $ub->id)
                                            <p>{{ $ub->publicacion_licitacion }}</p>
                                        @endif
                                    @endforeach
                                </div>
                                <div class="col-lg-6">
                                    <label>Prioridad</label>
                                    <p>{{ $info->licitacionPrioridad->prioridad }}</p>
                                </div>

                            </div>

                            <div class="row form-group">
                                <div class="col-lg-6">
                                    <label>Cliente</label>
                                    <p>{{ $cliente->razon_social }}</p>
                                </div>
                                <div class="col-lg-6">
                                    <label>Titulo del servicio</label>
                                    <p> {{ $info->titulo_servicio }}</p>
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-lg-6">
                                    <label>Tipo de contratación</label>
                                    <p>{{ $tipo_contratacion->tipo_contratacion }}</p>
                                </div>
                                <div class="col-lg-6">
                                    <label>No. Concurso</label>
                                    <p>{{ $info->no_licitacion }}</p>
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-lg-6">
                                    <label>Fecha de visita</label>
                                    @if($info->fecha_visita == null || $info->fecha_visita== "")
                                        <p>Sin información</p>
                                    @else
                                        <p>{{ date('d/m/Y', strtotime($info->fecha_visita))}}</p>
                                    @endif
                                </div>
                                <div class="col-lg-6">
                                    <label>Fecha de junta de aclaraciones</label>
                                    @if($info->junta_aclaraciones == null || $info->junta_aclaraciones == "")
                                        <p>Sin información</p>
                                    @else
                                        <p>{{ date('d/m/Y', strtotime($info->junta_aclaraciones))}}</p>
                                    @endif
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-lg-6">
                                    <label>Fecha de presentación y apertura de proposiciones</label>
                                    @if($info->apertura_proposiciones == null || $info->apertura_proposiciones == "")
                                        <p>Sin información</p>
                                    @else
                                        <p>{{ date('d/m/Y', strtotime($info->apertura_proposiciones))}}</p>
                                    @endif
                                </div>
                                <div class="col-lg-6">
                                    <label>Fecha de acto de fallo</label>
                                    @if($info->acto_fallo == null || $info->acto_fallo == "")
                                        <p>Sin información</p>
                                    @else
                                        <p>{{ date('d/m/Y', strtotime($info->acto_fallo))}}</p>
                                    @endif
                                </div>
{{-- 
                                <div class="col-lg-6">
                                    <label>Nombre de empresa o participación conjunta</label>
                                    <p>{{ $info->participacion_conjunta }}</p>
                                </div> --}}
                            </div>

                            <div class="row form-group">

                                <div class="col-lg-6">
                                    <label>Monto ofertado</label>
                                    <p>{{ $info->monto_ofertado }}</p>
                                </div>
                                <div class="col-lg-6">
                                    <label>Monto adjudicado</label>
                                    <p>{{ $info->monto_ganado }}</p>
                                </div>

                            </div>

                            <div class="row form-group">
                                <div class="col-lg-6">
                                    <label>Número de la fianza</label>
                                    <p>{{ $info->porcentaje_efectividad }}</p>
                                </div>
                                <div class="col-lg-6">
                                    <label>Monto de la fianza</label>
                                    <p>{{ $info->monto_fianza }}</p>
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-lg-6">
                                    <label>Firma de contrato o entrega</label>
                                    <p>{{ $info->firma_entrega }}</p>
                                </div>
                                <div class="col-lg-6">
                                    <label>Fecha de entrega de los servicios</label>
                                    @if($info->fecha_entrega == null || $info->fecha_entrega == "")
                                        <p>Sin información</p>
                                    @else
                                        <p>{{ date('d/m/Y', strtotime($info->fecha_entrega))}}</p>
                                    @endif
                                </div>
                            </div>

                            <div class="row form-group">
{{--                                 <div class="col-lg-6">
                                    <label>Fecha de cierre</label>
                                    <p>{{ date('d/m/Y', strtotime($info->fecha_cierre))}}</p>
                                </div> --}}
                                <div class="col-lg-12">
                                    <label>Observaciones</label>
                                    <p>{{ $info->observaciones }}</p>
                                </div>
                            </div>

                        </div>
                        <div class="tab-pane fade mt-5" id="kt_tab_pane_2" role="tabpanel" aria-labelledby="kt_tab_pane_2">

                            <table class="table table-hover mb-6">
                                <thead>
                                <tr>
                                    <th scope="col">Documento</th>
                                    <th scope="col">Tipo de Documento</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($documentos as $documento)
                                    <tr>
                                        <td><a href="{{ route('archivo.documentoLicitacion', ['id'=>$documento->id]) }}" class="link-primary" target="_blank"> {{ $documento->tipoDocumentosLicitaciones->documento_licitacion }} </a></td>
                                        <td>{{ $documento->tipoDocumentosLicitaciones->documento_licitacion }}</td>

                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>

                        </div>

                        <div class="tab-pane fade mt-5" id="kt_tab_pane_3" role="tabpanel" aria-labelledby="kt_tab_pane_3">
                            @if($op_contrato == 1)
                            @foreach($contrato as $cont)
                                <div class="row form-group">
                                    <div class="col-lg-6">
                                        <label>Título del servicio</label>
                                        <p>{{ $cont->titulo_servicio }}</p>
                                    </div>

                                    <div class="col-lg-6">
                                        <label>Vigencia</label>
                                        <p> Fecha inicial: {{ date('d/m/Y', strtotime($cont->firma_inicio_vigencia)) }} - Fecha de término {{ date('d/m/Y', strtotime($cont->firma_final_vigencia)) }}</p>
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col-lg-6">
                                        <label>Folio</label>
                                        <p>{{ $cont->no_folio }}</p>
                                    </div>

                                    <div class="col-lg-6">
                                        <label>relación de vehículos arrendados y ubicación</label>
                                    </div>
                                </div>


                                <div class="row form-group">
                                    <div class="col-lg-6">
                                        <label>Id contrato</label>
                                        <p>{{ $cont->id_contrato }}</p>
                                    </div>

                                    <div class="col-lg-6">
                                        <label>No. Contrato</label>
                                        <p>{{ $cont->no_contrato }}</p>
                                    </div>
                                </div>


                                <div class="row form-group">
                                    <div class="col-lg-6">
                                        <label>Tipo de contrato</label>
                                        <p>
                                            <div class="radio-inline">
                                                @if($cont->contrato_op == '0')
                                                    <label class="radio">
                                                        <input type="radio" name="contrato_op"  id="tp1" checked value="0"/>
                                                        <span></span>
                                                        Contrato Abierto
                                                    </label>
                                                @else
                                                    <label class="radio">
                                                        <input type="radio" name="contrato_op" checked id="tp2" value="1"/>
                                                        <span></span>
                                                        Contrato Cerrado
                                                    </label>
                                                @endif
                                            </div>
                                        </p>
                                    </div>

                                    <div class="col-lg-6">
                                        <label>Tipo de contratación</label>
                                        <p>{{ $tipo_contratacion->tipo_contratacion }}</p>
                                    </div>
                                </div>

                                <div class="row form-group">

                                    <div class="col-lg-6 {{($cont->contrato_op == '1') ? 'oculto' : ''}}">
                                        <label>Presupuesto mínimo</label>
                                        <p>{{ number_format($cont->presupuesto_minimo,2,'.',',') }}</p>
                                    </div>

                                    <div class="col-lg-6 {{($cont->contrato_op == '0') ? 'oculto' : ''}}">
                                        <label>Importe general</label>
                                        <p>{{ number_format($cont->importe_general,2,'.',',') }}</p>
                                    </div>

                                    <div class="col-lg-6 {{($cont->contrato_op == '1') ? 'oculto' : ''}}">
                                        <label>Presupuesto maximo</label>
                                        <p>{{ number_format($cont->presupuesto_maximo,2,'.',',') }}</p>
                                    </div>
                                </div>

                            @endforeach
                            @endif
                        </div>


                    </div>
                    <!--end::tabs-->

                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-lg-12">
                            <a href="{{ route('licitacion.listadolicitaciones') }}"  class="btn btn-secondary"><i class="la la-arrow-left"></i>Regresar</a>
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

@endsection
