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
                title: '¿Está seguro de autorizar la solicitud?',
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

                                            @include('taller.componentes.informacion-solicitud')

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
                                                <div class="row mt-4">
                                                    <div class="col-md-12">
                                                        <div class="d-flex">
                                                            <a href="{{ route('taller.serviciossolicitados') }}"
                                                                class="btn btn-secondary px-6 btn-lg"><i class="la la-arrow-left"></i>Regresar</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            {{-- @endif --}}

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
