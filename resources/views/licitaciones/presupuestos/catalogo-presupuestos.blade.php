@extends('layouts.app')
@push('scripts')
  <script src="{{ asset('js/licitaciones/presupuestos/AgregarPresupuesto.js') }}"></script>
@endpush
@section('title')
    Catálogo de Presupuestos
@endsection
@section('content')
<div class="card card-custom">
    <div class="card-header">
        <h3 class="card-title">Presupuestos</h3>
        <div class="card-toolbar">

        </div>
    </div>

    <div class="card-body">

        @if(session()->has('success'))
          <div class="row">
              <div class="alert alert-success" style="width: 100%;" align="center">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                  <strong>Notificación: </strong>
                  {{ session()->get('success') }}
              </div>
          </div>
        @endif

    <div class="row">
      <div class="col-md-8"></div>
      <div class="col-md-4 text-center">
         {{-- <a href="{{ route('documentos.docmuentosinactivos') }}" style="color:red;"><i class="far fa-trash-alt"></i> Tipo de documentos Desactivados</a> --}}
      </div>
    </div>


    <div class="table-responsive">
      <table class="table table-striped gy-7 gs-7 kdatatable_presupuestos">
          <thead>
            <tr class="fw-bold fs-6 text-gray-800 border-bottom border-gray-200">
              <th>No.</th>
              <th>Folio presupuesto</th>
              <th class="text-center">Opciones</th>
            </tr>
          </thead>
          <tbody>
            @foreach($presupuesto as $unid)
              <tr>
                <td>{{ $unid->id }}</td>
                <td>{{ $unid->folio_presupuesto }}</td>
                <td class="text-center">
                    <a class="btn btn-sm btn-clean btn-hover-icon-success btn-icon edit_documento" href="{{ route('presupuesto.presupuesto', $unid->id) }}" data-toggle="tooltip" data-theme="dark" title="Editar Presupuesto"><i class="flaticon-edit"></i></a>
                   <button class="btn btn-sm btn-clean btn-hover-icon-success btn-icon desactivar-documento" data-id="{{ $unid->id }}" data-nombre="{{ $unid->folio_presupuesto }}" data-toggle="tooltip" data-theme="dark" title="Desactivar Presupuesto"><i class="flaticon-delete "></i></button>
                </td>

              </tr>
            @endforeach
          </tbody>
      </table>
    </div>
    </div>

</div>


  <input type="hidden" id="datatable_i18n" value="{{ asset('/js/datatables/i18n/es-mx.json') }}">
{{--   <form method="post" id="documento_delete_form" action="{{ route('documentos.eliminardocumento') }}" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="id" id="id_documento_emisor" value="">
  </form> --}}

@endsection