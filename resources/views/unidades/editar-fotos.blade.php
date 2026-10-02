<div class="row">
	<div class="col-lg-1"></div>
	<div class="col-lg-10">
		<div class="row">
			<div class="col-lg-8">
				<form action="{{ route('unidad.guardarfotounidad') }}" method="post" id="submit_fotoadd">
    			@csrf
					<div class="input-group mb-5">
						<input type="hidden" name="id_unidad" value="{{ $unidad_id }}">
					    <input type="file" class="form-control" name="foto_unidad" id="foto_unidad" aria-describedby="basic-addon3"/>
					</div>
				</form>
			</div>
			<div class="col-lg-4">
				<button id="add_foto" class="btn btn-success">+ Agregar foto</button>
			</div>
		</div>
	</div>
	<div class="col-lg-1"></div>
</div>

<div class="row mt-4">
 	<table class="table table-striped gy-7 gs-7">
  		<thead>
   			<tr class="fw-bold fs-6 text-gray-800 border-bottom border-gray-200">
    			<th>No.</th>
    			<th>Fotografia</th>
    			<th class="text-center">Opciones</th>
   			</tr>
  		</thead>
  		<tbody>
            {{-- @foreach($fotosunidad as $unid) --}}
                <tr>
                    <td>1</td>
                    <td><a class="example-image-link" href="/img/frontier-2022-2.jpg" data-lightbox="example-1"><img class="example-image oculto" src="/img/frontier-2022-2.jpg" id="camara_div" alt="image-1"  width="90" /></a></td>
                    <td class="text-center">
						<a class="btn btn-outline-info edit_proveedor" href=""><i class="far fa-edit"></i></a>
					 	<a class="btn btn-outline-danger borrar" data-id=""><i class="far fa-trash-alt"></i></a>
                    </td>
                </tr>
            {{-- @endforeach --}}
  		</tbody>
 	</table>
</div>