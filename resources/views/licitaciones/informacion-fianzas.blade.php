@extends('layouts.app')
@push('scripts')
    <script src="{{ asset('js/licitaciones/InformacionFinanciera.js') }}"></script> 
    {{-- <script src="{{ asset('js/licitaciones/SegurosResponsabilidadCivil.js') }}"></script>  --}}
@endpush
@section('title')
    Información de las fianzas y seguros
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
    @if($count_segmento == 0)
        no hay propuesta economica
    @else
        <div class="row">
            <div class="col-lg-12">
                <!--begin::Card-->
                <div class="card card-custom gutter-b">
                    <div class="card-header">
                        <h3 class="card-title">Información de las fianzas y seguros</h3>
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
                            @if($acto_fallo == null || $acto_fallo == "")
                            @else
                                <a href="{{ route('licitacion.agregar',$lici_id) }}" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon" title="Crear contrato" data-theme="dark" data-toggle="tooltip" data-placement="top">
                                    <i class="flaticon-file-1"></i>
                                </a>  {{-- Agregar contrato --}}
                            @endif
                        @endif

                        @if (in_array(134, $permiso_array))
                            <a href="{{ route('proposicioneconomica.crearproposicioneconomica', [$lici_id,1,$tipo_contrato]) }}" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon" title="Crear propuesta económica" data-theme="dark" data-toggle="tooltip" data-placement="top">
                                <i class="flaticon-presentation-1"></i>
                            </a>   {{-- Propuesta economica --}}
                        @endif

                        @if (in_array(135, $permiso_array))
                            <a href="{{ route('propuestatecnica.crearpropuestatecnica',$lici_id) }}" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon" title="Crear propuesta" data-theme="dark" data-toggle="tooltip" data-placement="top">
                                <i class="flaticon2-website"></i>  
                            </a>   {{-- Propuesta Tecnica --}}
                        @endif

                        @if (in_array(143, $permiso_array))
                            <a href="{{ route('licitacion.informacionfinanzas',$lici_id) }}" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon op_select" title="Información de las fianzas y seguros" data-theme="dark" data-toggle="tooltip" data-placement="top">
                                    <i class="flaticon-notepad"></i>
                            </a>   {{-- Finanzas --}}
                        @endif


                        @if (in_array(135, $permiso_array))
                            <a href="{{ route('reqconcurso.listadoreqconsursos',$lici_id) }}" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon" title="Requisiciones" data-theme="dark" data-toggle="tooltip" data-placement="top">
                                    <i class="flaticon2-delivery-truck"></i>
                            </a>
                         @endif



                        <a href="{{ route('licitacion.listadolicitaciones') }}" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon" data-toggle="tooltip" data-theme="dark" title="Salir" ><i class="flaticon2-reply "></i></a>
                    </div>
                    </div>
                    <!--begin::Form-->

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
                            @foreach($licitacion as $lic)
                                @php
                                    $op_licitacion = $lic->tipo_contrato;
                                @endphp
                            @endforeach

                            @if($op_licitacion == 1)
                                <div class="row">
                                    <div class="col-lg-12">
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
                                                </tr>
                                            </thead>

                                            <tbody>
                                                @php $precio_unitario = 0; $iva = 0; $total_monto=0; $subtotal_calculo=0; $iva_calculo=0;@endphp
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
                                                        <td class="text-center">
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
                                                            {{ number_format($total,2,'.',',') }}
                                                            <input type="hidden" class="form-control monto total_m total_input"  value="{{ $total }}">
                                                        </td>
                                                        <td>{{ number_format($total_precio_calculo,2,'.',',') }}</td>
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
                                                            {{ number_format($iva,2,'.',',') }}
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
                                    </div>
                                </div>
                            @else
                                <div class="row">
                                    <div class="col-lg-12">
                                        <table class="table table-hover table-checkable table-responsive">
                                            <thead>
                                                <tr>
                                                    <th>Partida</th>
                                                    <th>Tipo de vehículo</th>
                                                    <th>Carrocería</th>
                                                    <th>Motor</th>
                                                    <th>Transmisión</th>
                                                    <th>Cantidad Mínima</th>
                                                    <th>Cantidad Máxima</th>
                                                    <th>Precio Unitario </th>
                                                    <th></th>
                                                    <th>Total Mínimo</th>
                                                    <th>Total Máximo</th>
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
                                                    $precio_unitariomax = 0; $ivamax = 0; $total_montomax=0;
                                                    $subtotal_calculo_minimo=0; $subtotal_calculo_maximo=0;
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
                                                            {{-- {{ $unid->precio_unitario_maximo }} --}}
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
                                                             <input type="hidden" class="form-control monto total_m_maximo total_input_maximo"  value="{{ $totalmax }}">
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
                                    </div>
                                </div>
                            @endif
                            <input type="hidden" id="datatable_i18n" value="{{ asset('/js/datatables/i18n/es-mx.json') }}">

                            @foreach($proposicioneconomica as $pro)
                                <div class="form-group">
                                    <label for="observaciones">Observaciones</label>
                                    <P>{{ $pro->observaciones }}</P>
                                </div>

                                <input type="hidden" name="licitacion_id" value="{{ $pro->licitacion_id }}">
                            @endforeach
                        </div>
                </div>
            </div>
        </div>

        <div class="card card-custom gutter-b">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">
                    </h3>
                </div>
            </div>
            <div class="card-body">
               <form action="{{ route('licitacion.modificarinfofinanciera') }}" method="post" id="submit_informacion_financiera" enctype="multipart/form-data">
                @csrf
                <ul class="nav nav-tabs nav-tabs-line">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#kt_tab_pane_1">Finanzas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#kt_tab_pane_2">Seguro RC</a>
                    </li>
                </ul>

                <input type="hidden" id="documentoEliminarPath" value="{{ route('licitacion.eliminarinfofinanciera') }}">
                <input type="hidden" id="documentoEliminarPathSeguros" value="{{ route('licitacion.eliminarinfosegurorc') }}">

                <div class="tab-content mt-5" id="myTabContent">
                    <div class="tab-pane fade show active mt-10" id="kt_tab_pane_1" role="tabpanel" aria-labelledby="kt_tab_pane_1">

                                <input type="hidden" name="id_licitacion" value="{{ $idlicitacion }}">
                                <input type='hidden' id='tipoArchivo' value='{{ $cadenaTipoDocumento }}'>
                                <input type='hidden' id='tipoArchivos' value='{{ $cadenaTipoFianza }}'>
                                    <div class="row form-group">
                                        <div class="col-lg-12" id="tblArchivos">
                                            <h4 class="card-label"></h4>
                                            <table class='table  table-responsive' id='tblRegistros'>
                                                <thead>
                                                    <tr>
                                                        <th>Documento</th>
                                                        <th>Tipo de fianza</th>
                                                        <th>Nombre de la aseguradora</th>
                                                        <th>Vigencia inicial</th>
                                                        <th>Vigencia final</th>
                                                        <th>Porcentaje</th>
                                                        <th>Importe</th>
                                                        <th>Opciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody id='tbodyDocumentos'>
                                                    @foreach($licitacion_fianzas as $documento)
                                                        <tr id="trDocumento{{ $documento->id }}">
                                                            <td>
                                                                <a href="{{ route('archivo.documentofianza', ['id'=>$documento->id]) }}" class="link-primary" target="_blank"> {{ $documento->licitacionTipoFianza->tipo_fianza }} </a>
                                                            </td>
                                                            <td>{{ $documento->licitacionTipoFianza->tipo_fianza }}</td>
                                                            <td>{{ $documento->afianzadora->nombre_afianzadora }}</td>
                                                            <td>{{ date('d/m/Y', strtotime($documento->vigencia_inicial))}}</td>
                                                            <td>{{ date('d/m/Y', strtotime($documento->vigencia_final))}}</td>
                                                            <td>{{ $documento->porcentaje }}%</td>
                                                            <td>
                                                                @if($op_licitacion == 1)
                                                                    @php
                                                                        $sub_fin = ($subtotal_calculo * $documento->porcentaje) / 100;
                                                                        $total_fin =  $subtotal_calculo + $sub_fin;
                                                                        // Calculo contrato cerrad
                                                                    @endphp
                                                                    <b>${{ number_format($total_fin,2,'.',',') }}</b>
                                                                @else
                                                                     @php
                                                                        $sub_fin = ($subtotal_calculo_minimo * $documento->porcentaje) / 100;
                                                                        $total_fin =  $subtotal_calculo_minimo + $sub_fin; 

                                                                        $sub_fin_max = ($subtotal_calculo_maximo * $documento->porcentaje) / 100;
                                                                        $total_fin_max =  $subtotal_calculo_maximo + $sub_fin_max;                                                                    
                                                                        // Calculo conttrato abierto
                                                                        @endphp
                                                                    <b>${{ number_format($total_fin,2,'.',',') }}</b> <span>Importe Min</span><br>
                                                                    <b>${{ number_format($total_fin_max,2,'.',',') }}</b> <span>Importe Max</span>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                <a href='#' class='btn btn-sm btn-clean btn-hover-icon-success btn-icon hrefEliminarDocumento' data-id='{{ $documento->id }}' data-documento='{{ $documento->documento }}'  data-toggle='tooltip' data-theme='dark' title='Eliminar'>
                                                                    <i class='flaticon-delete'></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="row form-group">
                                        <div class="col-lg-12">
                                            <a href="#"
                                                class="btn btn-icon btn-outline-success btn-circle btn-sm mr-2 hrefAgregarOtro"
                                                data-toggle="tooltip" data-theme="dark" title="Agregar Fianza">
                                                <i class="flaticon2-plus"></i>
                                            </a>
                                        </div>
                                    </div>



                    </div>

                    <div class="tab-pane fade mt-10" id="kt_tab_pane_2" role="tabpanel" aria-labelledby="kt_tab_pane_2">

                            <div class="row form-group">
                                <div class="col-lg-12" id="tblArchivos">
                                    <h4 class="card-label"></h4>
                                    <table class='table  table-responsive' id='tblRegistrosdos'>
                                        <thead>
                                            <tr>
                                                <th>Documento</th>
                                                <th>Nombre de la aseguradora</th>
                                                <th>Vigencia inicial</th>
                                                <th>Vigencia final</th>
                                                <th>Porcentaje</th>
                                                <th>Importe</th>
                                                <th>Opciones</th>
                                            </tr>
                                        </thead>
                                        <tbody id='tbodyDocumentosdos'>
                                            @foreach($licitacion_segurosrc as $documento)
                                                <tr id="trDocumento{{ $documento->id }}">
                                                    <td>
                                                        <a href="{{ route('archivo.documentosegurorc', ['id'=>$documento->id]) }}" class="link-primary" target="_blank"> {{ $documento->afianzadora->nombre_afianzadora }} </a>
                                                    </td>
                                                    <td>{{ $documento->afianzadora->nombre_afianzadora }}</td>
                                                    <td>{{ date('d/m/Y', strtotime($documento->vigencia_inicialrc))}}</td>
                                                    <td>{{ date('d/m/Y', strtotime($documento->vigencia_finalrc))}}</td>
                                                    <td>{{ $documento->porcentajerc }}%</td>
                                                    <td>
{{--                                                         @php
                                                            $sub_rc = ($subtotal_calculo * $documento->porcentajerc) / 100;
                                                            $total_rc =  $subtotal_calculo + $sub_rc;
                                                        @endphp
                                                        ${{ number_format($total_rc,2,'.',',') }} --}}


                                                                @if($op_licitacion == 1)
                                                                    @php
                                                                        $sub_rc = ($subtotal_calculo * $documento->porcentajerc) / 100;
                                                                        $total_rc =  $subtotal_calculo + $sub_rc;
                                                                        // Calculo contrato cerrado
                                                                    @endphp
                                                                    <b>${{ number_format($total_rc,2,'.',',') }}</b>
                                                                @else
                                                                     @php
                                                                        $sub_rc = ($subtotal_calculo_minimo * $documento->porcentajerc) / 100;
                                                                        $total_rc =  $subtotal_calculo_minimo + $sub_rc;

                                                                        $sub_rc_max = ($subtotal_calculo_maximo * $documento->porcentajerc) / 100;
                                                                        $total_rc_max =  $subtotal_calculo_maximo + $sub_rc_max;                                                                    
                                                                        // Calculo conttrato abierto
                                                                        @endphp
                                                                    <b>${{ number_format($total_rc,2,'.',',') }}</b> <span>Importe Min</span><br>
                                                                    <b>${{ number_format($total_rc_max,2,'.',',') }}</b> <span>Importe Max</span>
                                                                @endif


                                                    </td>
                                                    <td>
                                                        <a href='#' class='btn btn-sm btn-clean btn-hover-icon-success btn-icon hrefEliminarDocumentodos' data-id='{{ $documento->id }}' data-documento='{{ $documento->documento_rc }}'  data-toggle='tooltip' data-theme='dark' title='Eliminar'>
                                                            <i class='flaticon-delete'></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-lg-12">
                                    <a href="#"
                                        class="btn btn-icon btn-outline-success btn-circle btn-sm mr-2 hrefAgregarOtrodos"
                                        data-toggle="tooltip" data-theme="dark" title="Agregar Seguro RC">
                                        <i class="flaticon2-plus"></i>
                                    </a>
                                </div>
                            </div>
                    </div>
                    
                </div>

                <div class="row">
                    <div class="col-lg-12  mt-3">
                        <button type="button" id="btnGuardarInformacion"
                        class="btn btn-success"><i class="la la-plus"></i>Guardar</button>
                    </div>
                </div>


            </form>

            </div>
        </div>
    @endif


@endsection

