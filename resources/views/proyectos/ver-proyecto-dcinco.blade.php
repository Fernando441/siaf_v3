<table class="table table-hover mb-6 table-responsive-sm kdatatable_unidades_proyectos">
    <thead>
        <tr>
            <th>Unidad</th>
            <th>No. Serie</th>
            <th>Placa</th>
            <th>Año</th>
            <th>Fecha de asignación</th>
            <th>Tipo asignación</th>
            <th>Cliente</th>
            <th>Asignación</th>
            <th>Inventario de entrega</th>
        </tr>
    </thead>
    <tbody id="tbodyDoc_{{ $pro->id }}">
        @foreach($unidad_movimiento as $unid)
            @if($unid->proyectos_id == $pro->id)
                <tr>
                    <td>{{ $unid->nombre_marca }} / {{ $unid->nombre_modelo }}</td>
                    <td>{{ $unid->no_serie }}</td>
                    <td>{{ $unid->placa }}</td>
                    <td>{{ $unid->unidad_year }}</td>
                    <td>{{ $unid->fecha_asignacion }}</td>
                    <td>{{ $unid->tipo_asignacion }}</td>
                    <td>{{ $unid->name }}</td>
                    <td>
                        @if($unid->op_asignacion == 0)
                            <p><span class="label font-weight-bold label-outline-success label-inline">Asignado</span></p>
                        @else
                            <p><span class="label font-weight-bold label-outline-danger label-inline">Retirado</span></p>
                        @endif
                    </td>
                    <td>
                        @if($unid->op_asignacion == 0)
                            <a href="{{ route('proyecto.verinventarioentrega', [$unid->unidad_id, $unid->licitaciones_id, 2]) }}" class="btn btn-sm btn-outline-success btn-icon ml-4" title="Ver inventario" data-theme="dark" data-toggle="tooltip" data-placement="top">
                                <span class="svg-icon svg-icon-md">
                                    <i class="flaticon-eye"></i>
                                </span>
                            </a>
                        @else
                            <a href="{{ route('proyecto.verinventariosalida', [$unid->unidad_id, $unid->licitaciones_id, 2]) }}" class="btn btn-sm btn-outline-success btn-icon ml-4" title="Ver inventario" data-theme="dark" data-toggle="tooltip" data-placement="top">
                                <span class="svg-icon svg-icon-md">
                                    <i class="flaticon-eye"></i>
                                </span>
                            </a>
                        @endif
                    </td>

                </tr>
            @endif
        @endforeach
    </tbody>
</table>