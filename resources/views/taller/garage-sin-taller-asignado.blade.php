@extends('layouts.app')
@section('title')
    Mi Taller | Servicios Solicitados
@endsection

@push('scripts')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
@endpush

@section('content')
    <div class="d-flex flex-row">

        <!--begin::List-->
        <div class="flex-row-fluid">
            <div class="d-flex flex-column flex-grow-1">

                <!--begin::Row-->
                <div class="row">
                    <div class="col-xl-12">
                        <div>
                            <!--begin::Profile Personal Information-->
                            <div class="d-flex flex-row">
                                <!--begin::Content-->
                                <div class="flex-row-fluid">
                                    <!--begin::Card-->
                                    <div class="card card-custom card-stretch">
                                        <!--begin::Header-->
                                        <div class="card-header py-3">
                                            <div class="card-title align-items-start flex-column">
                                                <h3 class="pt-2 card-label"><i class="fas fa-warehouse mr-2"></i>
                                                    Mi Taller | Servicios Solicitados</h3>
                                            </div>
                                        </div>
                                        <!--end::Header-->

                                        <!--begin::Datatable-->
                                        <div class="card-body" style="min-height: 600px;">
                                            <!-- Bootstarp alert "Sin taller asignado" -->
                                            <div class="alert alert-custom alert-notice alert-warning fade show"
                                                role="alert">
                                                <div class="alert-icon"><i class="flaticon-warning"></i></div>
                                                <div class="alert-text">A este usuario no se le ha asignado un taller.</div>
                                            </div>

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
