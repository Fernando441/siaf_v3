@extends('layouts.app')
@section('title')
    Información de la solicitud de servicio
@endsection

@push('scripts')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <script src="{{ asset('js/taller/VerSolicitud.js') }}" type="text/javascript"></script>
    <script>
        $('#fecha_cita').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
        });

        function buscarProveedor() {
            var rfc = $('#rfc').val();
            $.ajax({
                url: '{{ route('taller.buscarproveedor') }}',
                type: 'POST',
                data: {
                    rfc: rfc,
                    _token: '{{ csrf_token() }}'
                },
                success: function(data) {
                    $('#proveedor').empty();
                    $('#proveedor').append('<option value="">Seleccione un proveedor</option>');
                    $.each(data, function(i, item) {

                        $('#proveedor').append(
                            `<option value="${item.id}">${item.rfc} | ${item.nombre}</option>`);

                    });

                    $('#proveedoresEncontrados').text(data.length + ' proveedores encontrados');
                }

            });
        }

        $('#rfc').on('keyup', function() {
            if ($(this).val().length >= 1) {
                buscarProveedor();
            }
        });

        function getCuenta(id) {
            $.ajax({
                url: '{{ route('taller.getcuenta') }}',
                type: 'POST',
                data: {
                    id: id,
                    _token: '{{ csrf_token() }}'
                },
                success: function(data) {
                    $('#cuenta').empty();
                    $('#cuenta').append('<option value="">Seleccione una cuenta</option>');
                    $.each(data, function(i, item) {
                        $('#cuenta').append(
                            `<option value="${item.id}">${item.banco} | ${item.cuenta}</option>`);
                    });

                    $('#cuentasEncontradas').text(data.length + ' cuentas encontradas');
                }
            });
        }

        function getDireccion(id) {
            $.ajax({
                url: '{{ route('taller.getdireccion') }}',
                type: 'POST',
                data: {
                    id: id,
                    _token: '{{ csrf_token() }}'
                },
                success: function(data) {
                    $('#direccion').empty();
                    $('#direccion').append('<option value="">Seleccione una direccion</option>');
                    $.each(data, function(i, item) {
                        $('#direccion').append(`<option value="${item.id}">${item.direccion}</option>`);
                    });

                    $('#direccionesEncontradas').text(data.length + ' direcciones encontradas');
                }
            });
        }

        var proveedor_id = '';
        $('#proveedor').on('change', function() {
            proveedor_id = $(this).find(":selected").val();
            if (proveedor_id != '') {
                getCuenta(proveedor_id);
                getDireccion(proveedor_id);
            }
        });

        $('#btnAutorizar').on('click', function() {
            swal.fire({
                title: '¿Está seguro de enviar la solicitud?',
                text: "Autorizar con pago condicionado a la entrega de evidencias de trabajo terminado.",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Autorizar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.value) {
                    $('#formAutorizar').submit();
                }
            });
        });

        $('#btn-rechazar-solicitud').on('click', function() {
            Swal.fire({
                title: '¿Estas seguro?',
                text: "Rechazaras la solicitud de servicio.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, rechazar!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#form-rechazar-solicitud').submit();
                }
            })
        });
    </script>
@endpush

@section('content')
    <style type="text/css">
        .oculto{
            display: none;
        }
    </style>
    <div class="d-flex flex-row">

        <!--begin::List-->
        <div class="flex-row-fluid">
            <div class="d-flex flex-column flex-grow-1">

                <!--begin::Row-->
                <div class="row">
                    <div class="col-xl-12">
                        <div class="container">
                            <!--begin::Profile Personal Information-->
                            <div class="d-flex flex-row">
                                <!--begin::Content-->
                                <div class="flex-row-fluid">
                                    <!--begin::Card-->
                                    <div class="card card-custom card-stretch">
                                        <!--begin::Header-->
                                        <div class="card-header py-3">
                                            <div class="card-title align-items-start flex-column">
                                                <h3 class="card-title">
                                                    Información de la solicitud de servicio</h3>
                                            </div>
                                            <div class="card-toolbar">
                                                <span class="badge badge-primary badge-pill"
                                                    style="padding: 10px 30px;">Solicitud ID: {{ $solicitud->id }}</span>
                                            </div>
                                        </div>
                                        <!--end::Header-->

                                        <!--begin::Datatable-->
                                        <div class="card-body">


                                            <div class="card card-custom">
                                                <div class="card-header">

                                                </div>
                                                <div class="card-body">
                                                   @include('taller.componentes.informacion-solicitud')
                                                </div>

                                            </div>

                                            

                                            <div class="row mt-4">
                                                <div class="col-md-12">
                                                    @include('taller.componentes.informacion-unidad')
                                                </div>
                                            </div>
                                            {{-- Si la solicitud esta pendiente --}}
                                            @if ($solicitud->taller_solicitud_estado_id == 1)
                                                <div class="row mt-4">
                                                    <div class="col-md-12">
                                                        {{-- @include('taller.componentes.formulario-agendar-cita') --}}
                                                    </div>
                                                </div>
                                                <div class="card-footer">
                                                    <div class="d-flex">
{{--                                                         <button type="button" class="btn btn-primary px-6 btn-lg"
                                                            id="btn-aceptar-solicitud">Agendar servicio</button> --}}

{{--                                                         <button type="button" class="btn btn-secondary btn-lg ml-2"
                                                            id="btn-rechazar-solicitud">Rechazar</button> --}}

                                                        {{ Form::open(['route' => ['taller.rechazarsolicitud'], 'method' => 'POST', 'id' => 'form-rechazar-solicitud']) }}
                                                        {{ Form::hidden('id', $solicitud->id) }}
                                                        {{ Form::close() }}
                                                    </div>
                                                </div>
                                            @endif
                                            {{-- END: Si la solicitud esta pendiente --}}
                                            {{-- Si la solicitud esta preautorizada --}}
                                            @if ($solicitud->taller_solicitud_estado_id == 2)
                                                <div class="row mt-4">
                                                    <div class="col-md-12">
                                                        {{-- @include('taller.componentes.formulario-autorizar-servicio') --}}
                                                    </div>
                                                </div>
                                            @endif
                                            {{-- Si la solicitud esta autorizada --}}
                                            {{-- Formulario para mandar como Preautorizado con evidencia de trabajo terminado --}}
                                            @if ($solicitud->taller_solicitud_estado_id == 3)
                                                <div class="row mt-4">
                                                    <div class="col-md-12">
                                                        {{-- @include('taller.componentes.formulario-terminar-servicio') --}}
                                                    </div>
                                                </div>
                                            @endif

                                            {{-- Si la solicitud esta con evidencia --}}
                                            @if ($solicitud->taller_solicitud_estado_id == 4)
                                                <div class="row mt-4">
                                                    <div class="col-md-12">
                                                        {{-- @include('taller.componentes.formulario-confirmar-pago') --}}
                                                    </div>
                                                </div>
                                            @endif

                                            {{-- En tesoreria para Finalizar --}}
                                            @if ($solicitud->taller_solicitud_estado_id == 5)
                                                <div class="row mt-4">
                                                    <div class="col-md-12">
                                                        {{-- @include('taller.componentes.formulario-finalizar-mantenimiento') --}}
                                                    </div>
                                                </div>
                                            @endif

                                            {{-- Finalizado --}}
                                            {{-- @if ($solicitud->taller_solicitud_estado_id == 6) --}}

                                            {{-- @endif --}}

                                        </div>


                                            <div class="card card-custom">
                                                <div class="card-header">
                                                    <div class="card-title">
                                                        <h3 class="card-label">
                                                            Información del taller asignado
                                                        </h3>
                                                    </div>

                                                </div>
                                                <div class="card-body">
                                                    <div class="form-group row">
                                                      <div class="col-lg-4">
                                                        <label>Nombre</label>
                                                        <p>{{ $taller->nombre }}</p>
                                                      </div>

                                                      <div class="col-lg-4">
                                                        <label>Alias</label>
                                                        <p>{{ $taller->alias }}</p>
                                                      </div>

                                                      <div class="col-lg-4">
                                                        <label>Dirección</label>
                                                        <p>{{ $taller->direccion }}</p>
                                                      </div>
                                                    </div>

                                                    <div class="form-group row">
                                                      <div class="col-lg-4">
                                                        <label>Telefono local</label>
                                                        <p>{{ $taller->tel_local }}</p>
                                                      </div>

                                                      <div class="col-lg-4">
                                                        <label>Telefono celular</label>
                                                        <p>{{ $taller->tel_celular }}</p>
                                                      </div>

                                                      <div class="col-lg-4">
                                                        <label>Correo</label>
                                                        <p>{{ $taller->correo }}</p>
                                                      </div>
                                                    </div>


                                                    <div class="form-group row">
                                                      <div class="col-lg-4">
                                                        <label>Estado</label>
                                                        <p>{{ $taller->estado_nombre }}</p>
                                                      </div>

                                                      <div class="col-lg-4">
                                                        <label>Municipio</label>
                                                        <p>{{ $taller->municipio_nombre }}</p>
                                                      </div>

                                                      <div class="col-lg-4">
                                                        <label>Coordenadas</label>
                                                        <p>{{ $taller->coordenadas }}</p>
                                                      </div>
                                                    </div>

                                                    <div class="row">
                                                      <h4 class="card-title">Servicios</h4>
                                                    </div>

                                                    <div class="row">
                                                      @foreach($servicios_asignados as $value)
                                                        <div class="col-md-4">
                                                          <div class="form-group">
                                                            <span class="switch switch-icon">
                                                            <label> {{ $value->servicio->servicio }}
                                                            <input type="checkbox" name="servicio[]" checked disabled class='tablero_check all_generales' value="{{ $value->id }}" />
                                                            <span></span>
                                                            </label>
                                                            </span>
                                                          </div>
                                                        </div>            
                                                      @endforeach
                                                    </div>
                                                </div>

                                            </div>


                                        <div class="card card-custom">
                                            <div class="card-header">
                                                <div class="card-title">
                                                    <h3 class="card-label">
                                                        Evaluación
                                                    </h3>
                                                </div>

                                            </div>
                                            <div class="card-body">
                            <table class="table  mb-6 table-responsive-sm">
                                <thead>
                                <tr>
                                    <th scope="col">Categoria</th>
                                    <th scope="col">Criterio</th>
                                    <th scope="col" width="260">Calificación</th>
                                    <th scope="col" width="260">Obervaciones</th>
                                </tr>
                                </thead>
                                <tbody>
                                  <tr>
                                    <td><b>Técnica</b></td>
                                    <td>Calidad del trabajo (sin recurrencias, buena ejecución)</td>
                                    <td scope="col">
                                      <div class="row">
                                        <div class="col-lg-6">
                                            @if($evaluacion_taller->tec_calidad == 1)
                                                <p>Inaceptable</p>
                                            @endif
                                            @if($evaluacion_taller->tec_calidad == 2)
                                                <p>Deficiente</p>
                                            @endif
                                            @if($evaluacion_taller->tec_calidad == 3)
                                                <p>Regular</p>
                                            @endif
                                            @if($evaluacion_taller->tec_calidad == 4)
                                                <p>Bueno</p>
                                            @endif
                                            @if($evaluacion_taller->tec_calidad == 5)
                                                <p>Excelente</p>
                                            @endif
                                        </div>
                                        <div class="col-lg-6">
                                            @if($evaluacion_taller->tec_calidad == 1)
                                                <img width="20" id="tecnica_uno_st1"  src="{{ asset('theme/assets/media/logos/stars_uno.png') }}" />
                                            @endif
                                            @if($evaluacion_taller->tec_calidad == 2)
                                                <img width="40" id="tecnica_uno_st2"  src="{{ asset('theme/assets/media/logos/stars_dos.png') }}" />
                                            @endif
                                            @if($evaluacion_taller->tec_calidad == 3)
                                                <img width="60" id="tecnica_uno_st3"  src="{{ asset('theme/assets/media/logos/stars_tres.png') }}" />
                                            @endif
                                            @if($evaluacion_taller->tec_calidad == 4)
                                                <img width="80" id="tecnica_uno_st4" src="{{ asset('theme/assets/media/logos/stars_cuatro.png') }}" />
                                            @endif
                                            @if($evaluacion_taller->tec_calidad == 5)
                                                <img width="95" id="tecnica_uno_st5"  src="{{ asset('theme/assets/media/logos/stars.png') }}" />
                                            @endif
                                        </div>
                                      </div>
                                    </td>
                                    <td>
                                      <p>{{ $evaluacion_taller->tec_calidad_obs }}</p>
                                    </td>
                                  </tr>

                                  <tr>
                                    <td><b>Operativa</b></td>
                                    <td>Tiempo de respuesta (desde la solicitud)</td>
                                    <td>
                                      <div class="row">
                                        <div class="col-lg-6">
                                            @if($evaluacion_taller->ope_tiempo == 1)
                                                <p>Inaceptable</p>
                                            @endif
                                            @if($evaluacion_taller->ope_tiempo == 2)
                                                <p>Deficiente</p>
                                            @endif
                                            @if($evaluacion_taller->ope_tiempo == 3)
                                                <p>Regular</p>
                                            @endif
                                            @if($evaluacion_taller->ope_tiempo == 4)
                                                <p>Bueno</p>
                                            @endif
                                            @if($evaluacion_taller->ope_tiempo == 5)
                                                <p>Excelente</p>
                                            @endif
                                        </div>
                                        <div class="col-lg-6">
                                            @if($evaluacion_taller->ope_tiempo == 1)
                                                <img width="20" id="tecnica_uno_st1"  src="{{ asset('theme/assets/media/logos/stars_uno.png') }}" />
                                            @endif
                                            @if($evaluacion_taller->ope_tiempo == 2)
                                                <img width="40" id="tecnica_uno_st2"  src="{{ asset('theme/assets/media/logos/stars_dos.png') }}" />
                                            @endif
                                            @if($evaluacion_taller->ope_tiempo == 3)
                                                <img width="60" id="tecnica_uno_st3"  src="{{ asset('theme/assets/media/logos/stars_tres.png') }}" />
                                            @endif
                                            @if($evaluacion_taller->ope_tiempo == 4)
                                                <img width="80" id="tecnica_uno_st4" src="{{ asset('theme/assets/media/logos/stars_cuatro.png') }}" />
                                            @endif
                                            @if($evaluacion_taller->ope_tiempo == 5)
                                                <img width="95" id="tecnica_uno_st5"  src="{{ asset('theme/assets/media/logos/stars.png') }}" />
                                            @endif
                                        </div>
                                      </div>
                                    </td>
                                    <td><p>{{ $evaluacion_taller->ope_tiempo_obs }}</p></td>
                                  </tr>

                                  <tr>
                                    <td></td>
                                    <td>Cumplimiento en el tiempo de entrega establecido</td>
                                    <td>
                                      <div class="row">
                                        <div class="col-lg-6">
                                            @if($evaluacion_taller->ope_cumplimiento == 1)
                                                <p>Inaceptable</p>
                                            @endif
                                            @if($evaluacion_taller->ope_cumplimiento == 2)
                                                <p>Deficiente</p>
                                            @endif
                                            @if($evaluacion_taller->ope_cumplimiento == 3)
                                                <p>Regular</p>
                                            @endif
                                            @if($evaluacion_taller->ope_cumplimiento == 4)
                                                <p>Bueno</p>
                                            @endif
                                            @if($evaluacion_taller->ope_cumplimiento == 5)
                                                <p>Excelente</p>
                                            @endif
                                        </div>
                                        <div class="col-lg-6">
                                            @if($evaluacion_taller->ope_cumplimiento == 1)
                                                <img width="20" id="tecnica_uno_st1"  src="{{ asset('theme/assets/media/logos/stars_uno.png') }}" />
                                            @endif
                                            @if($evaluacion_taller->ope_cumplimiento == 2)
                                                <img width="40" id="tecnica_uno_st2"  src="{{ asset('theme/assets/media/logos/stars_dos.png') }}" />
                                            @endif
                                            @if($evaluacion_taller->ope_cumplimiento == 3)
                                                <img width="60" id="tecnica_uno_st3"  src="{{ asset('theme/assets/media/logos/stars_tres.png') }}" />
                                            @endif
                                            @if($evaluacion_taller->ope_cumplimiento == 4)
                                                <img width="80" id="tecnica_uno_st4" src="{{ asset('theme/assets/media/logos/stars_cuatro.png') }}" />
                                            @endif
                                            @if($evaluacion_taller->ope_cumplimiento == 5)
                                                <img width="95" id="tecnica_uno_st5"  src="{{ asset('theme/assets/media/logos/stars.png') }}" />
                                            @endif
                                        </div>
                                      </div>
                                    </td>
                                    <td><p>{{ $evaluacion_taller->ope_cumplimiento_obs }}</p></td>
                                  </tr>

                                  <tr>
                                    <td></td>
                                    <td>Cobertura y disponibilidad (zonas, horarios)</td>
                                    <td>
                                      <div class="row">
                                        <div class="col-lg-6">
                                             @if($evaluacion_taller->ope_cobertura == 1)
                                                <p>Inaceptable</p>
                                            @endif
                                            @if($evaluacion_taller->ope_cobertura == 2)
                                                <p>Deficiente</p>
                                            @endif
                                            @if($evaluacion_taller->ope_cobertura == 3)
                                                <p>Regular</p>
                                            @endif
                                            @if($evaluacion_taller->ope_cobertura == 4)
                                                <p>Bueno</p>
                                            @endif
                                            @if($evaluacion_taller->ope_cobertura == 5)
                                                <p>Excelente</p>
                                            @endif
                                        </div>
                                        <div class="col-lg-6">
                                            @if($evaluacion_taller->ope_cobertura == 1)
                                                <img width="20" id="tecnica_uno_st1"  src="{{ asset('theme/assets/media/logos/stars_uno.png') }}" />
                                            @endif
                                            @if($evaluacion_taller->ope_cobertura == 2)
                                                <img width="40" id="tecnica_uno_st2"  src="{{ asset('theme/assets/media/logos/stars_dos.png') }}" />
                                            @endif
                                            @if($evaluacion_taller->ope_cobertura == 3)
                                                <img width="60" id="tecnica_uno_st3"  src="{{ asset('theme/assets/media/logos/stars_tres.png') }}" />
                                            @endif
                                            @if($evaluacion_taller->ope_cobertura == 4)
                                                <img width="80" id="tecnica_uno_st4" src="{{ asset('theme/assets/media/logos/stars_cuatro.png') }}" />
                                            @endif
                                            @if($evaluacion_taller->ope_cobertura == 5)
                                                <img width="95" id="tecnica_uno_st5"  src="{{ asset('theme/assets/media/logos/stars.png') }}" />
                                            @endif
                                        </div>
                                      </div>
                                    </td>
                                    <td><p>{{ $evaluacion_taller->ope_cobertura_obs }}</p></td>
                                  </tr>
                                  {{-- // Operativa --}}
                                  <tr>
                                    <td><b>Administrativa</b></td>
                                    <td>Documentación completa (evidencias, cotización, factura)</td>
                                    <td>
                                      <div class="row">
                                        <div class="col-lg-6">
                                             @if($evaluacion_taller->adm_documentacion == 1)
                                                <p>Inaceptable</p>
                                            @endif
                                            @if($evaluacion_taller->adm_documentacion == 2)
                                                <p>Deficiente</p>
                                            @endif
                                            @if($evaluacion_taller->adm_documentacion == 3)
                                                <p>Regular</p>
                                            @endif
                                            @if($evaluacion_taller->adm_documentacion == 4)
                                                <p>Bueno</p>
                                            @endif
                                            @if($evaluacion_taller->adm_documentacion == 5)
                                                <p>Excelente</p>
                                            @endif
                                        </div>
                                        <div class="col-lg-6">
                                            @if($evaluacion_taller->adm_documentacion == 1)
                                                <img width="20" id="tecnica_uno_st1"  src="{{ asset('theme/assets/media/logos/stars_uno.png') }}" />
                                            @endif
                                            @if($evaluacion_taller->adm_documentacion == 2)
                                                <img width="40" id="tecnica_uno_st2"  src="{{ asset('theme/assets/media/logos/stars_dos.png') }}" />
                                            @endif
                                            @if($evaluacion_taller->adm_documentacion == 3)
                                                <img width="60" id="tecnica_uno_st3"  src="{{ asset('theme/assets/media/logos/stars_tres.png') }}" />
                                            @endif
                                            @if($evaluacion_taller->adm_documentacion == 4)
                                                <img width="80" id="tecnica_uno_st4" src="{{ asset('theme/assets/media/logos/stars_cuatro.png') }}" />
                                            @endif
                                            @if($evaluacion_taller->adm_documentacion == 5)
                                                <img width="95" id="tecnica_uno_st5"  src="{{ asset('theme/assets/media/logos/stars.png') }}" />
                                            @endif
                                        </div>
                                      </div>
                                    </td>
                                    <td><p>{{ $evaluacion_taller->adm_documentacion_obs }}</p></td>
                                  </tr>

                                  <tr>
                                    <td></td>
                                    <td>Claridad y desgloses en cotización</td>
                                    <td>
                                      <div class="row">
                                        <div class="col-lg-6">
                                             @if($evaluacion_taller->adm_claridad == 1)
                                                <p>Inaceptable</p>
                                            @endif
                                            @if($evaluacion_taller->adm_claridad == 2)
                                                <p>Deficiente</p>
                                            @endif
                                            @if($evaluacion_taller->adm_claridad == 3)
                                                <p>Regular</p>
                                            @endif
                                            @if($evaluacion_taller->adm_claridad == 4)
                                                <p>Bueno</p>
                                            @endif
                                            @if($evaluacion_taller->adm_claridad == 5)
                                                <p>Excelente</p>
                                            @endif
                                        </div>
                                        <div class="col-lg-6">
                                            @if($evaluacion_taller->adm_claridad == 1)
                                                <img width="20" id="tecnica_uno_st1"  src="{{ asset('theme/assets/media/logos/stars_uno.png') }}" />
                                            @endif
                                            @if($evaluacion_taller->adm_claridad == 2)
                                                <img width="40" id="tecnica_uno_st2"  src="{{ asset('theme/assets/media/logos/stars_dos.png') }}" />
                                            @endif
                                            @if($evaluacion_taller->adm_claridad == 3)
                                                <img width="60" id="tecnica_uno_st3"  src="{{ asset('theme/assets/media/logos/stars_tres.png') }}" />
                                            @endif
                                            @if($evaluacion_taller->adm_claridad == 4)
                                                <img width="80" id="tecnica_uno_st4" src="{{ asset('theme/assets/media/logos/stars_cuatro.png') }}" />
                                            @endif
                                            @if($evaluacion_taller->adm_claridad == 5)
                                                <img width="95" id="tecnica_uno_st5"  src="{{ asset('theme/assets/media/logos/stars.png') }}" />
                                            @endif
                                        </div>
                                      </div>
                                    </td>
                                    <td><p>{{ $evaluacion_taller->adm_claridad_obs }}</p></td>
                                  </tr>

                                  <tr>
                                    <td></td>
                                    <td>Registro y trazabilidad del servicio</td>
                                    <td>
                                      <div class="row">
                                        <div class="col-lg-6">
                                             @if($evaluacion_taller->adm_registro == 1)
                                                <p>Inaceptable</p>
                                            @endif
                                            @if($evaluacion_taller->adm_registro == 2)
                                                <p>Deficiente</p>
                                            @endif
                                            @if($evaluacion_taller->adm_registro == 3)
                                                <p>Regular</p>
                                            @endif
                                            @if($evaluacion_taller->adm_registro == 4)
                                                <p>Bueno</p>
                                            @endif
                                            @if($evaluacion_taller->adm_registro == 5)
                                                <p>Excelente</p>
                                            @endif
                                        </div>
                                        <div class="col-lg-6">
                                            @if($evaluacion_taller->adm_registro == 1)
                                                <img width="20" id="tecnica_uno_st1"  src="{{ asset('theme/assets/media/logos/stars_uno.png') }}" />
                                            @endif
                                            @if($evaluacion_taller->adm_registro == 2)
                                                <img width="40" id="tecnica_uno_st2"  src="{{ asset('theme/assets/media/logos/stars_dos.png') }}" />
                                            @endif
                                            @if($evaluacion_taller->adm_registro == 3)
                                                <img width="60" id="tecnica_uno_st3"  src="{{ asset('theme/assets/media/logos/stars_tres.png') }}" />
                                            @endif
                                            @if($evaluacion_taller->adm_registro == 4)
                                                <img width="80" id="tecnica_uno_st4" src="{{ asset('theme/assets/media/logos/stars_cuatro.png') }}" />
                                            @endif
                                            @if($evaluacion_taller->adm_registro == 5)
                                                <img width="95" id="tecnica_uno_st5"  src="{{ asset('theme/assets/media/logos/stars.png') }}" />
                                            @endif
                                        </div>
                                      </div>
                                    </td>
                                    <td><p>{{ $evaluacion_taller->adm_registro_obs }}</p></td>
                                  </tr>
                                  {{-- Administrativa --}}

                                  <tr>
                                    <td><b>Servicio al Cliente</b></td>
                                    <td>Trato hacia el personal de JETVAN</td>
                                    <td>
                                      <div class="row">
                                        <div class="col-lg-6">
                                             @if($evaluacion_taller->cli_trato == 1)
                                                <p>Inaceptable</p>
                                            @endif
                                            @if($evaluacion_taller->cli_trato == 2)
                                                <p>Deficiente</p>
                                            @endif
                                            @if($evaluacion_taller->cli_trato == 3)
                                                <p>Regular</p>
                                            @endif
                                            @if($evaluacion_taller->cli_trato == 4)
                                                <p>Bueno</p>
                                            @endif
                                            @if($evaluacion_taller->cli_trato == 5)
                                                <p>Excelente</p>
                                            @endif
                                        </div>
                                        <div class="col-lg-6">
                                            @if($evaluacion_taller->cli_trato == 1)
                                                <img width="20" id="tecnica_uno_st1"  src="{{ asset('theme/assets/media/logos/stars_uno.png') }}" />
                                            @endif
                                            @if($evaluacion_taller->cli_trato == 2)
                                                <img width="40" id="tecnica_uno_st2"  src="{{ asset('theme/assets/media/logos/stars_dos.png') }}" />
                                            @endif
                                            @if($evaluacion_taller->cli_trato == 3)
                                                <img width="60" id="tecnica_uno_st3"  src="{{ asset('theme/assets/media/logos/stars_tres.png') }}" />
                                            @endif
                                            @if($evaluacion_taller->cli_trato == 4)
                                                <img width="80" id="tecnica_uno_st4" src="{{ asset('theme/assets/media/logos/stars_cuatro.png') }}" />
                                            @endif
                                            @if($evaluacion_taller->cli_trato == 5)
                                                <img width="95" id="tecnica_uno_st5"  src="{{ asset('theme/assets/media/logos/stars.png') }}" />
                                            @endif
                                        </div>
                                      </div>
                                    </td>
                                    <td><p>{{ $evaluacion_taller->cli_trato_obs }}</p></td>
                                  </tr>

                                  <tr>
                                    <td></td>
                                    <td>Disposición para negociar o resolver problemas</td>
                                    <td>
                                      <div class="row">
                                        <div class="col-lg-6">
                                             @if($evaluacion_taller->cli_disposicion == 1)
                                                <p>Inaceptable</p>
                                            @endif
                                            @if($evaluacion_taller->cli_disposicion == 2)
                                                <p>Deficiente</p>
                                            @endif
                                            @if($evaluacion_taller->cli_disposicion == 3)
                                                <p>Regular</p>
                                            @endif
                                            @if($evaluacion_taller->cli_disposicion == 4)
                                                <p>Bueno</p>
                                            @endif
                                            @if($evaluacion_taller->cli_disposicion == 5)
                                                <p>Excelente</p>
                                            @endif
                                        </div>
                                        <div class="col-lg-6">
                                            @if($evaluacion_taller->cli_disposicion == 1)
                                                <img width="20" id="tecnica_uno_st1"  src="{{ asset('theme/assets/media/logos/stars_uno.png') }}" />
                                            @endif
                                            @if($evaluacion_taller->cli_disposicion == 2)
                                                <img width="40" id="tecnica_uno_st2"  src="{{ asset('theme/assets/media/logos/stars_dos.png') }}" />
                                            @endif
                                            @if($evaluacion_taller->cli_disposicion == 3)
                                                <img width="60" id="tecnica_uno_st3"  src="{{ asset('theme/assets/media/logos/stars_tres.png') }}" />
                                            @endif
                                            @if($evaluacion_taller->cli_disposicion == 4)
                                                <img width="80" id="tecnica_uno_st4" src="{{ asset('theme/assets/media/logos/stars_cuatro.png') }}" />
                                            @endif
                                            @if($evaluacion_taller->cli_disposicion == 5)
                                                <img width="95" id="tecnica_uno_st5"  src="{{ asset('theme/assets/media/logos/stars.png') }}" />
                                            @endif
                                        </div>
                                      </div>
                                    </td>
                                    <td><p>{{ $evaluacion_taller->cli_disposicion_obs }}</p></td>
                                  </tr>

                                  <tr>
                                    <td></td>
                                    <td>Resultados en encuestas de satisfacción</td>
                                    <td>
                                      <div class="row">
                                        <div class="col-lg-6">
                                             @if($evaluacion_taller->cli_resultados == 1)
                                                <p>Inaceptable</p>
                                            @endif
                                            @if($evaluacion_taller->cli_resultados == 2)
                                                <p>Deficiente</p>
                                            @endif
                                            @if($evaluacion_taller->cli_resultados == 3)
                                                <p>Regular</p>
                                            @endif
                                            @if($evaluacion_taller->cli_resultados == 4)
                                                <p>Bueno</p>
                                            @endif
                                            @if($evaluacion_taller->cli_resultados == 5)
                                                <p>Excelente</p>
                                            @endif
                                        </div>
                                        <div class="col-lg-6">
                                            @if($evaluacion_taller->cli_resultados == 1)
                                                <img width="20" id="tecnica_uno_st1"  src="{{ asset('theme/assets/media/logos/stars_uno.png') }}" />
                                            @endif
                                            @if($evaluacion_taller->cli_resultados == 2)
                                                <img width="40" id="tecnica_uno_st2"  src="{{ asset('theme/assets/media/logos/stars_dos.png') }}" />
                                            @endif
                                            @if($evaluacion_taller->cli_resultados == 3)
                                                <img width="60" id="tecnica_uno_st3"  src="{{ asset('theme/assets/media/logos/stars_tres.png') }}" />
                                            @endif
                                            @if($evaluacion_taller->cli_resultados == 4)
                                                <img width="80" id="tecnica_uno_st4" src="{{ asset('theme/assets/media/logos/stars_cuatro.png') }}" />
                                            @endif
                                            @if($evaluacion_taller->cli_resultados == 5)
                                                <img width="95" id="tecnica_uno_st5"  src="{{ asset('theme/assets/media/logos/stars.png') }}" />
                                            @endif
                                        </div>
                                      </div>
                                    </td>
                                    <td><p>{{ $evaluacion_taller->cli_resultados_obs }}</p></td>
                                  </tr>
                                  {{-- Servicio al Cliente --}}

                                  <tr>
                                    <td><b>Financiera</b></td>
                                    <td>Relación costo-beneficio</td>
                                    <td>
                                      <div class="row">
                                        <div class="col-lg-6">
                                             @if($evaluacion_taller->fin_relacion == 1)
                                                <p>Inaceptable</p>
                                            @endif
                                            @if($evaluacion_taller->fin_relacion == 2)
                                                <p>Deficiente</p>
                                            @endif
                                            @if($evaluacion_taller->fin_relacion == 3)
                                                <p>Regular</p>
                                            @endif
                                            @if($evaluacion_taller->fin_relacion == 4)
                                                <p>Bueno</p>
                                            @endif
                                            @if($evaluacion_taller->fin_relacion == 5)
                                                <p>Excelente</p>
                                            @endif
                                        </div>
                                        <div class="col-lg-6">
                                            @if($evaluacion_taller->fin_relacion == 1)
                                                <img width="20" id="tecnica_uno_st1"  src="{{ asset('theme/assets/media/logos/stars_uno.png') }}" />
                                            @endif
                                            @if($evaluacion_taller->fin_relacion == 2)
                                                <img width="40" id="tecnica_uno_st2"  src="{{ asset('theme/assets/media/logos/stars_dos.png') }}" />
                                            @endif
                                            @if($evaluacion_taller->fin_relacion == 3)
                                                <img width="60" id="tecnica_uno_st3"  src="{{ asset('theme/assets/media/logos/stars_tres.png') }}" />
                                            @endif
                                            @if($evaluacion_taller->fin_relacion == 4)
                                                <img width="80" id="tecnica_uno_st4" src="{{ asset('theme/assets/media/logos/stars_cuatro.png') }}" />
                                            @endif
                                            @if($evaluacion_taller->fin_relacion == 5)
                                                <img width="95" id="tecnica_uno_st5"  src="{{ asset('theme/assets/media/logos/stars.png') }}" />
                                            @endif
                                        </div>
                                      </div>
                                    </td>
                                    <td><p>{{ $evaluacion_taller->fin_relacion_obs }}</p></td>
                                  </tr>

                                  <tr>
                                    <td></td>
                                    <td>Entrega oportuna y correcta de facturación</td>
                                    <td>
                                      <div class="row">
                                        <div class="col-lg-6">
                                             @if($evaluacion_taller->fin_entrega == 1)
                                                <p>Inaceptable</p>
                                            @endif
                                            @if($evaluacion_taller->fin_entrega == 2)
                                                <p>Deficiente</p>
                                            @endif
                                            @if($evaluacion_taller->fin_entrega == 3)
                                                <p>Regular</p>
                                            @endif
                                            @if($evaluacion_taller->fin_entrega == 4)
                                                <p>Bueno</p>
                                            @endif
                                            @if($evaluacion_taller->fin_entrega == 5)
                                                <p>Excelente</p>
                                            @endif
                                        </div>
                                        <div class="col-lg-6">
                                            @if($evaluacion_taller->fin_entrega == 1)
                                                <img width="20" id="tecnica_uno_st1"  src="{{ asset('theme/assets/media/logos/stars_uno.png') }}" />
                                            @endif
                                            @if($evaluacion_taller->fin_entrega == 2)
                                                <img width="40" id="tecnica_uno_st2"  src="{{ asset('theme/assets/media/logos/stars_dos.png') }}" />
                                            @endif
                                            @if($evaluacion_taller->fin_entrega == 3)
                                                <img width="60" id="tecnica_uno_st3"  src="{{ asset('theme/assets/media/logos/stars_tres.png') }}" />
                                            @endif
                                            @if($evaluacion_taller->fin_entrega == 4)
                                                <img width="80" id="tecnica_uno_st4" src="{{ asset('theme/assets/media/logos/stars_cuatro.png') }}" />
                                            @endif
                                            @if($evaluacion_taller->fin_entrega == 5)
                                                <img width="95" id="tecnica_uno_st5"  src="{{ asset('theme/assets/media/logos/stars.png') }}" />
                                            @endif
                                        </div>
                                      </div>
                                    </td>
                                    <td><p>{{ $evaluacion_taller->fin_entrega_obs }}</p></td>
                                  </tr>

                                </tbody>
                            </table>
                                            </div>
                                            <div class="card-footer d-flex justify-content-between">
                                                <a href="{{ route('invtaller.editartaller', $taller) }}" class="btn btn-secondary px-6 btn-lg"><i class="la la-arrow-left"></i>Regresar</a>
                                            </div>
                                        </div>


                                    </div>
                                    <!--end::Content-->
                                </div>
                                <!--end::Profile Personal Information-->
                            </div>
                        </div>
                    </div>
                    <!--end::Row-->
                </div>
            </div>
            <!--end::List-->
        </div>
    @endsection
