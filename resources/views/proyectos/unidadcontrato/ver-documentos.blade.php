<table class="table table-hover mb-6 table-responsive-sm" id="tblDocumentos">
    <thead>
    <tr>
        <th scope="col">Documento</th>
        <th scope="col">Tipo de Documento</th>
    </tr>
    </thead>
    <tbody id='tbodyDocumentos'>
        @foreach($documentos as $documento)
            <tr id="trDocumento{{ $documento->id }}">
                <td><a href="{{ route('archivo.documentoUnidad', ['id'=>$documento->id]) }}" class="link-primary" target="_blank"> {{ $documento->documento }} </a></td>
                <td>{{ $documento->unidadTipoDocumento->tipo }}</td>
            </tr>
        @endforeach
    </tbody>
</table>