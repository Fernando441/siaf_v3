<table class="table table-hover mb-6 table-responsive-sm" id="tbodyDoc_{{ $pro->id }}">
    <thead>
        <tr>
            <th scope="col">Documento</th>
            <th scope="col">Tipo de Documento</th>
            {{-- <th scope="col">Opción</th> --}}
        </tr>
    </thead>
    <tbody id="tbodyDoc_{{ $pro->id }}">
        @foreach($documentos as $documento)
            @if($documento->id_proyecto == $pro->id)
                <tr id="trDocumento{{ $documento->id }}_{{ $pro->id }}">
                    <td><a href="{{ route('archivo.documentoProyecto', ['id'=>$documento->id]) }}" class="link-primary" target="_blank"> {{ $documento->proyectoTipoDocumento->tipo }} </a></td>
                    <td>{{ $documento->proyectoTipoDocumento->tipo }}</td>
{{--                     <td>
                        <a href='#' class='btn btn-sm btn-clean btn-hover-icon-success btn-icon hrefEliminar' data-id='{{ $documento->id }}' data-documento='{{ $documento->documento }}'  data-proyecto="{{ $pro->id }}" data-toggle='tooltip' data-theme='dark' title='Eliminar'>
                            <i class='flaticon-delete'></i>
                        </a>
                    </td> --}}
                </tr>
            @endif
        @endforeach
    </tbody>
</table>

