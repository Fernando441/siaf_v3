@extends('layouts.app')
@section('title')
    Catálogo de tipo de convenio modificatorio
@endsection

@push('scripts')
  <script src="{{ asset('js/catalogos/CatalogoConvenioModificatorio.js') }}"></script> 
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

                <!--begin::Card-->
                    <div class="card card-custom">
                        <div class="card-header">
                            <div class="card-title">
                      <span class="card-icon">
                        <i class="flaticon2-file text-primary"></i>
                      </span>
                                <h3 class="card-label">Inventario de tipos de convenio modificatorio</h3>
                            </div>
                            <div class="card-toolbar">

                                <!--begin::Button-->
                                <a href="{{ route('conveniom.listadoconveniomodificatorio') }}" class="btn btn-light-primary font-weight-bolder mr-3 ml-3">
                                    <i class="la la-arrow-left"></i>Regresar</a>
                                <!--end::Button-->

                            </div>
                        </div>
                        <div class="card-body">
                            <!--begin: Datatable-->
                            <table class="table table-hover table-checkable" id="kdatatable_conveniom_inactiva">
                                <thead>
                                <tr>
                                  <th>No.</th>
                                  <th>Convenio modificatorio</th>
                                  <th class="text-center">Opciones</th>
                                </tr>
                                </thead>

                                <tbody>
                                  @foreach($convenio as $unid)
                                    <tr>
                                      <td>{{ $unid->id }}</td>
                                      <td>{{ $unid->nombre_modificacion }}</td>

                                      <td class="text-center">
                                        <button class="btn btn-sm btn-clean btn-hover-icon-success btn-icon activar-convenio" data-id="{{ $unid->id }}" data-nombre="{{ $unid->nombre_modificacion }}" data-toggle="tooltip" data-theme="dark" title="Activar tipo de convenio modificatorio" ><i class="flaticon2-reply "></i></button>
                                      </td>
                                    </tr>
                                  @endforeach
                                </tbody>

                                <tfoot>
                                <tr>
                                  <th>No.</th>
                                  <th>Convenio modificatorio</th>
                                  <th class="text-center">Opciones</th>
                                </tr>
                                </tfoot>

                            </table>
                            <!--end: Datatable-->

                            <input type="hidden" id="datatable_i18n" value="{{ asset('/js/datatables/i18n/es-mx.json') }}">

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

  <form method="post" id="convenio_act_form" action="{{ route('conveniom.activarconveniomodificatorio') }}" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="id" id="id_convenio_act" value="">
  </form> 

@endsection