<table class="table table-hover mb-6 table-responsive-sm" id="tblDocumentosF">
    <thead>
    <tr>
        <th scope="col">Fotografía</th>
        <th scope="col">Opción</th>
    </tr>
    </thead>
    <tbody id='tbodyDocumentosF'>
        @foreach($fotografias as $documento)
            <tr id="trFotografia{{ $documento->id }}">
                <td><a href="{{ route('archivo.fotografiaUnidad', ['id'=>$documento->id]) }}" class="link-primary" target="_blank"> {{ $documento->fotografia }} </a></td>
                <td>
                    <a href='#' class='btn btn-sm btn-clean btn-hover-icon-success btn-icon hrefEliminarFotografia' data-id='{{ $documento->id }}' data-documento='{{ $documento->fotografia }}'  data-toggle='tooltip' data-theme='dark' title='Eliminar'>
                        <i class='flaticon-delete'></i>
                    </a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<div class="row form-group">
    <div class="col-lg-12">
        <a href="#" class="btn btn-icon btn-outline-success btn-circle btn-sm mr-2 hrefAgregarOtroF" data-toggle="tooltip" data-theme="dark" title="Agregar archivo">
            <i class="flaticon2-plus"></i>
        </a>
    </div>
</div>
