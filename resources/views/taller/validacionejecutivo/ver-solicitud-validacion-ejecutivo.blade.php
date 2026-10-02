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

{{--                                             <div class="row">
                                                <div class="col-lg-6"></div>
                                                <div class="col-lg-6">
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <button id="btn-autorizar"  class="btn btn-light-success font-weight-bold mr-2">Autorizar</button>

                                                        </div>
                                                        <div class="col-lg-6">
                                                            <button id="btn-rechazar" class="btn btn-light-danger font-weight-bold mr-2">Rechazar</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> --}}

                                            <div class="row oculto" id="rechazar-div">

                                                <form method="post" id="rechazar_form" action="{{ route('taller.rechazarsolicitudmantenimientoejecutivo') }}" enctype="multipart/form-data">
                                                @csrf
                                                    <div class="col-lg-12">
                                                        <input type="hidden" name="id_solicitud" value="{{ $solicitud->id }}">
                                                        <label>Motivo por el cual rechazas la solicitud:</label>
                                                        <textarea class="form-control" name="motivo" id="motivo" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"></textarea>
                                                    </div>
                                                </form>

                                                <div class="row">
                                                    <div class="col-lg-10"></div>
                                                    <div class="col-lg-2 text-center mt-2">
                                                        <button id="btn-rechazar-form" class="btn btn-light-danger font-weight-bold mr-2">Guardar</button>
                                                    </div>
                                                </div>

                                                <form method="post" id="validar_form" action="{{ route('taller.validacionsolicitudmantenimientoejecutivo') }}" enctype="multipart/form-data">
                                                @csrf
                                                    <input type="hidden" name="id_solicitud" value="{{ $solicitud->id }}">
                                                </form>

                                            </div>

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
                                                        Documentos de la solicitud
                                                    </h3>
                                                </div>

                                            </div>
                                            <div class="card-body">
                                                    <table class="table table-hover table-checkable mt-2" id="tblDocumentos">
                                                        <thead class="text-center">
                                                        <tr>
                                                            <th>Documento</th>
                                                            <th>Tipo de documento</th>
                                                        </tr>
                                                        </thead>
                        
                                                        <tbody style="text-align: center;">

                                                            @foreach($documentos_solicitud as $documento)
                                                                <tr id="trDocumento{{ $documento->id }}">
                                                                    <td>
                                                                        <a href="{{ route('archivo.documentoSolicitudMantenimiento', ['id'=>$documento->id]) }}" class="link-primary" target="_blank"> {{ $documento->tallerSolicitudTipoDocumento->tipo }} </a>
                                                                    </td>
                                                                    <td>{{ $documento->tallerSolicitudTipoDocumento->tipo }}</td>
                                                                    <td>
                                                                    </td>
                                                                </tr>
                                                            @endforeach

                                                        </tbody>
                                                    </table>
                                            </div>
                                            <div class="card-footer d-flex justify-content-between">
                                                <a href="{{ route('taller.Validacionmantenimientosejecutivo') }}" class="btn btn-secondary px-6 btn-lg"><i class="la la-arrow-left"></i>Regresar</a>
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
