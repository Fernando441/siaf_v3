@extends('layouts.app')
@section('title')
    Solicitar Atención
@endsection

@push('scripts')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <script src="{{ asset('js/taller/BuscarUnidad.js') }}" type="text/javascript"></script>
@endpush

@section('content')
    <div class="d-flex flex-row">

        <!--begin::List-->
        <div class="flex-row-fluid">
            <div class="d-flex flex-column flex-grow-1">

                <!--begin::Row-->
                <div class="row">
                    <div class="col-xl-8 offset-xl-2">
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
                                                <h3 class="pt-2"><i class="flaticon-search text-dark pr-3"></i> Buscar
                                                    unidad para solicitar mantenimiento</h3>
                                            </div>
                                        </div>
                                        <!--end::Header-->

                                        <form autocomplete="off" class="form" id="buscarunidad" method="POST"
                                            enctype="multipart/form-data" action="{{ route('taller.buscarunidad') }}">
                                            @csrf
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
                                                                name="search_criteria" id="search_by_placas" value="placas"
                                                                data-name="Placas">
                                                            <label class="form-check-label"
                                                                for="search_by_placas">Placas</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                name="search_criteria" id="search_by_no_economico"
                                                                value="no_economico" data-name="No. Económico">
                                                            <label class="form-check-label" for="search_by_no_economico">No.
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
                                                            class="btn btn-primary mr-2 px-10 btn-lg">Buscar Unidad</button>
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
