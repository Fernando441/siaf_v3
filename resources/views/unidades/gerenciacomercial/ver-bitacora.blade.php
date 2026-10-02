<table class="table table-hover table-checkable" id="kdatatable_bitacora">
    <thead>
      <tr>
        <th>No.</th>
        <th>Asignación</th>
        <th>Tipo de Asignación</th>
        <th>Contrato</th>
        <th>Patio</th>
        <th>Fecha Asignación</th>
        <th>Fecha Salida</th>
      </tr>
    </thead>
    <tbody>
      @foreach($bitacora_unidad as $unid)
        <tr>
          <td>{{ $unid->id }}</td>
          <td>{{ $unid->asignacion }}</td>
          <td>{{ $unid->tipo_asignacion }}</td>
          @if($unid->asignacion_id == 1)
            <td>Id contrato: {{ $unid->id_contrato }} / No. Contrato: {{ $unid->no_contrato }}</td>
            <td> -- </td>
          @else
            <td> -- </td>
            <td> {{ $unid->ubicacion }} </td>
          @endif
          <td>{{ date('d/m/Y', strtotime($unid->fecha_asignacion))}}</td>
          @if($unid->fecha_salida == "")
            <td>Actual</td>
          @else
            <td>{{ date('d/m/Y', strtotime($unid->fecha_salida))}}</td>
          @endif
        </tr>
      @endforeach
    </tbody>
    <tfoot>
      <tr>
        <th>No.</th>
        <th>Asignación</th>
        <th>Tipo de Asignación</th>
        <th>Contrato</th>
        <th>Patio</th>
        <th>Fecha Asignación</th>
        <th>Fecha Salida</th>
      </tr>
    </tfoot>

</table>
  <!--end: Datatable-->
<input type="hidden" id="datatable_i18n" value="{{ asset('/js/datatables/i18n/es-mx.json') }}">