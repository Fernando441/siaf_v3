<table class="table table-hover mb-6 table-responsive-sm kdatatable_clientes_proyectos">
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Telefono</th>
            <th>Correo</th>
            <th>RFC</th>
            <th>Acción</th>
        </tr>
    </thead>
    <tbody id="tbodyDoc_{{ $pro->id }}">
        @foreach($usuarios_clientes as $unid)
            {{-- @if($unid->proyectos_id == $unid->id) --}}
                <tr>
                    <td>{{ $unid->name }}</td>
                    <td>{{ $unid->telefono }}</td>
                    <td>{{ $unid->email }}</td>
                    <td>{{ $unid->rfc }}</td>
                    <td>
                        @if (in_array($unid->id, $data))
                            <div class="checkbox-inline">
                                <label class="checkbox">
                                    <input type="checkbox" name="cliente_{{ $pro->id }}[]" value="{{ $unid->id }}" checked />
                                    <span></span>
                                </label>
                            </div>
                        @else
                            <div class="checkbox-inline">
                                <label class="checkbox">
                                    <input type="checkbox" name="cliente_{{ $pro->id }}[]" value="{{ $unid->id }}"  />
                                    <span></span>
                                </label>
                            </div>
                        @endif
                    </td>
                </tr>
            {{-- @endif --}}
        @endforeach
    </tbody>
</table>