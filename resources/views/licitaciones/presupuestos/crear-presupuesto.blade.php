@extends('layouts.app')
@push('scripts')
  <script src="{{ asset('js/licitaciones/presupuestos/AgregarPresupuesto.js') }}"></script>
@endpush

@section('title')
  Agregar Presupuesto
@endsection

@section('content')
<div class="card card-custom">
    <div class="card-header">
      @foreach($info_lic as $unid)
        <h3 class="card-title">Prespuesto / Folio licitación: {{ $unid->folio }}</h3>
      @endforeach
    </div>

    <div class="card-body">

      <div class="table-responsive">
        <form action="{{ route('presupuesto.guardarunidades') }}" method="post" id="submit_unidad">
        @csrf
        <input type="hidden" name="licitacion" value="{{ $licitacion }}">
          <table class="table table-striped gy-7 gs-7 kdatatable_presupuestos">
              <thead>
                <tr class="fw-bold fs-6 text-gray-800 border-bottom border-gray-200">
                  <th>Folio</th>
                  <th>Ubicacion</th>
                  <th>Marca</th>
                  <th>Modelo</th>
                  <th>Serie</th>
                  <th>Placa</th>
                  <th>Transmisión</th>
                  <th>Año</th>
                  <th>Fotos</th>
                  <th class="text-center">Opciones</th>
                </tr>
              </thead>
              <tbody>
                @foreach($unidades as $unid)
                  <tr>
                    <td>{{ $unid->folio }}</td>
                    <td>{{ $unid->ubicacion }}</td>
                    <td>{{ $unid->nombre_marca}}</td>
                    <td>{{ $unid->nombre_modelo}}</td>
                    <td>{{ $unid->no_serie}}</td>
                    <td>{{ $unid->placa}}</td>
                    <td>{{ $unid->transmision}}</td>
                    <td>{{ $unid->unidad_year}}</td>
                    <td>
                      <a class='example-image-link' href='/img/frontier-2022-2.jpg' data-lightbox='example-1'><img class='example-image' src='/img/frontier-2022-2.jpg' id='camara_div' alt='image-1'  width='90' /></a>
                    </td>
                    <td class="text-center">
                        <input class="form-check-input unidades" type="checkbox" value="{{ $unid->id }}" name="unidad[]">
                    </td>

                  </tr>
                @endforeach
              </tbody>
          </table>
        </form>
      </div>
    </div>


    <div class="card-footer">
      <div class="row">
        <div class="col-lg-6">
          <button type="button" id="next_step" class="btn btn-success"><i class="la la-plus"></i>Guardar</button>
          <a href="{{ route('licitacion.listadolicitaciones') }}"  class="btn btn-secondary"><i class="la la-times"></i>Cancelar</a>
        </div>
      </div>
    </div>

</div>

  <input type="hidden" id="datatable_i18n" value="{{ asset('/js/datatables/i18n/es-mx.json') }}">
  <form method="post" id="documento_act_form" action="{{ route('documentos.activardocumento') }}" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="id" id="id_documento_act" value="">
  </form>

@endsection