@extends('layouts.app')
@section('title')
    Solicitar Atención de mi Unidad
@endsection

@push('scripts')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <script src="{{ asset('js/taller/BuscarUnidadCliente.js') }}" type="text/javascript"></script>
    <script>
        var input_servicio = document.getElementById('servicio');

        function set_tipo_servicio(tipo) {
            input_servicio.value = tipo;
        }
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
                                                <h3 class="pt-2">
                                                    Solicitar atención de mi unidad</h3>
                                            </div>
                                        </div>
                                        <!--end::Header-->

                                        <div class="card card-custom gutter-b" style="box-shadow: 0px 0px !important;">
                                            <!--begin::Body-->
                                            <div class="card-body">
                                                <h5 class="card-title">Selecciona el tipo de servicio que requieres</h5>
                                                <!--begin::Nav Tabs-->
                                                <ul class="dashboard-tabs nav nav-pills nav-secondary row row-paddingless m-0 p-0 flex-column flex-sm-row"
                                                    role="tablist">
                                                    <!--begin::Item-->
                                                    <li
                                                        class="nav-item d-flex col-sm flex-grow-1 flex-shrink-0 mr-3 mb-3 mb-lg-0">
                                                        <a class="nav-link border py-10 d-flex flex-grow-1 rounded flex-column align-items-center"
                                                            data-toggle="pill" href="#tab_forms_widget_1"
                                                            onclick="set_tipo_servicio('correctivo')">
                                                            <span class="nav-icon py-2 w-auto">
                                                                <i class="flaticon-settings-1 icon-3x"></i>
                                                            </span>
                                                            <span
                                                                class="nav-text font-size-lg py-2 font-weight-bold text-center">Correctivo</span>
                                                        </a>
                                                    </li>
                                                    <!--end::Item-->
                                                    <!--begin::Item-->

                                                    <!--end::Item-->
                                                    <!--begin::Item-->

                                                    <!--end::Item-->
                                                    <!--begin::Item-->
                                                    <li
                                                        class="nav-item d-flex col-sm flex-grow-1 flex-shrink-0 mr-3 mb-3 mb-lg-0">
                                                        <a class="nav-link border py-10 d-flex flex-grow-1 rounded flex-column align-items-center"
                                                            data-toggle="pill" href="#tab_forms_widget_4"
                                                            onclick="set_tipo_servicio('preventivo')">
                                                            <span class="nav-icon py-2 w-auto">
                                                                <i class="flaticon-interface-1 icon-3x"></i>
                                                            </span>
                                                            <span
                                                                class="nav-text font-size-lg py-2 font-weight-bolder text-center">Preventivo</span>
                                                        </a>
                                                    </li>
                                                    <!--end::Item-->
                                                    <!--begin::Item-->
                                                    <li
                                                        class="nav-item d-flex col-sm flex-grow-1 flex-shrink-0 mr-3 mb-3 mb-lg-0">
                                                        <a class="nav-link border py-10 d-flex flex-grow-1 rounded flex-column align-items-center"
                                                            data-toggle="pill" href="#tab_forms_widget_5"
                                                            onclick="set_tipo_servicio('siniestro')">
                                                            <span class="nav-icon py-2 w-auto">
                                                                <i class="flaticon2-warning icon-3x"></i>
                                                            </span>
                                                            <span
                                                                class="nav-text font-size-lg py-2 font-weight-bolder text-center">Siniestro</span>
                                                        </a>
                                                    </li>
                                                    <!--end::Item-->
                                                    <!--begin::Item-->
                                                    <li
                                                        class="nav-item d-flex col-sm flex-grow-1 flex-shrink-0 mr-0 mb-3 mb-lg-0">
                                                        <a class="nav-link border py-10 d-flex flex-grow-1 rounded flex-column align-items-center"
                                                            data-toggle="pill" href="#tab_forms_widget_5"
                                                            onclick="set_tipo_servicio('administrativo')">
                                                            <span class="nav-icon py-2 w-auto">
                                                                <i class="flaticon2-file-2 icon-3x"></i>
                                                            </span>
                                                            <span
                                                                class="nav-text font-size-lg py-2 font-weight-bolder text-center">Administrativo</span>
                                                        </a>
                                                    </li>
                                                    <!--end::Item-->
                                                </ul>
                                                <!--end::Nav Tabs-->
                                                <!--begin::Nav Content-->
                                                <div class="tab-content m-0 p-0">
                                                    <div class="tab-pane active" id="forms_widget_tab_1" role="tabpanel">
                                                    </div>
                                                    <div class="tab-pane" id="forms_widget_tab_2" role="tabpanel"></div>
                                                    <div class="tab-pane" id="forms_widget_tab_3" role="tabpanel"></div>
                                                    <div class="tab-pane" id="forms_widget_tab_4" role="tabpanel"></div>
                                                    <div class="tab-pane" id="forms_widget_tab_6" role="tabpanel"></div>
                                                </div>
                                                <!--end::Nav Content-->
                                            </div>
                                            <!--end::Body-->
                                        </div>

                                        <form autocomplete="off" class="form" id="buscarunidad" method="POST"
                                            enctype="multipart/form-data" action="{{ route('taller.buscarunidad') }}">
                                            @csrf
                                            <input type="text" name="servicio" id="servicio" value=""
                                                style="display:none;">
                                            <input autocomplete="false" name="hidden" type="text" style="display:none;">
                                            <div class="card-body pb-1">
                                                <!-- radio buttons to select search criteria -->
                                                <div class="form-group row">
                                                    <label class="col-form-label col-lg-2 col-sm-12 d-flex"
                                                        style="align-items: center;">Buscar por:</label>
                                                    <div class="col-lg-10 col-md-10 col-sm-12">
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                name="search_criteria" id="search_by_no_serie"
                                                                value="no_serie" checked data-name="No. Serie">
                                                            <label class="form-check-label" for="search_by_no_serie">No.
                                                                Serie</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                name="search_criteria" id="search_by_placas"
                                                                value="placas" data-name="Placas">
                                                            <label class="form-check-label"
                                                                for="search_by_placas">Placas</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                name="search_criteria" id="search_by_no_economico"
                                                                value="no_economico" data-name="No. Económico">
                                                            <label class="form-check-label"
                                                                for="search_by_no_economico">No.
                                                                Económico</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- input to search by selected criteria -->
                                                <div class="form-group row">
                                                    <label class="col-form-label col-lg-2 col-sm-12 d-flex"
                                                        style="align-items: center;" id="search_criteria_label">No.
                                                        Serie</label>
                                                    <div class="col-lg-10 col-md-10 col-sm-12">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control form-control-lg"
                                                                id="search_criteria_input" name="search_criteria_input"
                                                                placeholder="No. Serie" required autofocus>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-footer">
                                                <div class="row">
                                                    <div class="col-lg-12 d-flex" style="justify-content: space-between;">
                                                        <button type="button" id="buttonBuscarUnidad"
                                                            class="btn btn-primary mr-2 px-10 btn-lg">Buscar
                                                            Unidad</button>
                                                        <a href="{{ route('tablero.show') }}"
                                                            class="btn btn-secondary btn-lg">Cancelar</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>

                                        <script>
                                            // update input label and placeholder based on selected criteria
                                            const searchCriteriaRadios = document.querySelectorAll('input[name="search_criteria"]');
                                            const searchCriteriaLabel = document.getElementById('search_criteria_label');
                                            const searchCriteriaInput = document.getElementById('search_criteria_input');
                                            searchCriteriaRadios.forEach(radio => {
                                                radio.addEventListener('change', () => {
                                                    searchCriteriaLabel.textContent = radio.dataset.name;
                                                    searchCriteriaInput.placeholder = radio.dataset.name;
                                                });
                                            });
                                        </script>
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
