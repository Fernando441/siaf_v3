@extends('layouts.app')
@push('scripts')
    <script src="{{ asset('js/busqueda/resultadosseguros.js') }}"></script>
	<meta name="csrf-token" content="{{ csrf_token() }}" />
@endpush
@section('title')
    Resultados aseguramiento
@endsection
@section('content')

    <div class="d-flex flex-row">

    <!--begin::List-->
    <div class="flex-row-fluid">
        <div class="d-flex flex-column flex-grow-1">

            <!--begin::Row-->
            <div class="row">
                <div class="col-xl-12">

                <!--begin::Card-->
                    <div class="card card-custom">
                        <div class="card-header">
                            <div class="card-title">
											<span class="card-icon">
												<i class="flaticon2-search text-primary"></i>
											</span>
                                <h3 class="card-label">Resultados aseguramiento</h3>
                            </div>
                            <div class="card-toolbar">
                                <a href="javascript: void(0);" id="btnExcel" class="btn btn-outline-success btn-sm mr-3">
                                    <i class="flaticon-download"></i>Descargar en Excel
                                </a>
                                <a href="{{ route('busqueda.busqseguros') }}" class="btn btn-outline-secondary btn-sm">
											<i class="ki ki-long-arrow-back icon-sm"></i>Regresar
                                </a>
                            </div>
                        </div>
                        <div class="card-body">

                            
                            <div class="collapsex" id="collapseExample">
                                <div class="card card-body">
                                    <input type="hidden" id="unidades_total" value="@php echo count($unidades['unidades']); @endphp" />


                                <div class="table-responsive">
                                    <table class="table table-hover table-sm table-bordered">
                                        <thead class="thead-light">
                                            <tr>
                                                @foreach ($unidades['titulos'] as $titulo )
                                                    <th scope="col">{{ $titulo }}</th>
                                                @endforeach
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($unidades['unidades'] as $unidad)
                                            <tr>
                                                @php
                                                    $valores = array_values($unidad);
                                                @endphp
                                                @foreach ($valores as $valor)
                                                    <td>{{ $valor }}</td>
                                                @endforeach   
                                            </tr>
                                             @empty
                                                <tr>
                                                    <td colspan="99" class="text-center">Sin resultados</td>
                                                </tr>
                                            @endforelse

                                                
                                            
                                             
                                            
                                        </tbody>
                                    </table>
                                </div>


                                </div>
                            </div>

                             

                        </div>
                    </div>
                    <!--end::Card-->
                    <!--end::Card-->
                </div>

            </div>
            <!--end::Row-->
        </div>
    </div>
    <!--end::List-->
</div>
<form id="formseguros" method="post" action="{{ route('busqueda.excelseguros') }}" class="form">
    @csrf    
    <input type='hidden' id='bid' name='bid' value='{{ $bid }}'>
</form>
@endsection
