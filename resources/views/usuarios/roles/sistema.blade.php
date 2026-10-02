<input type="hidden" value="{{ $rolInfo->id }}" name="idRol">
<div class="accordion accordion-solid accordion-toggle-plus" id="accordionExample6">
    <div class="card">
        <div class="card-header" id="headingOne6">
            <div class="card-title" data-toggle="collapse" data-target="#collapse1">
                <i class="flaticon-pie-chart-1"></i> Tablero    
            </div>
        </div>
        <div id="collapse1" class="collapse show" data-parent="#accordionExample6">
            <div class="card-body">

                <div class="form-group row">
                    <div class="col-9">
                        <div class="checkbox-inline">
                            <label class="checkbox mb-2">
                            <input type="checkbox" id='CheckTablero'>
                            <span></span>Seleccionar todos</label>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                </div>

                @foreach($tablero as $value)
                <div class="row mt-2">
                    <div class="col-md-8">
                        <label>{{ $value->guard_names }}</label>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <span class="switch switch-icon">
                            <label>
                                <input type="checkbox" name="permission[]" class="tablero_check all_generales" value="{{ $value->id }}">
                                <span></span>
                            </label>
                            </span>
                        </div>
                    </div>
                </div>       
                @endforeach   
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header" id="headingOne6">
            <div class="card-title" data-toggle="collapse" data-target="#collapse2">
                <i class="flaticon-security"></i> Listado de Roles    
            </div>
        </div>
        <div id="collapse2" class="collapse" data-parent="#accordionExample6">
            <div class="card-body">

                <div class="form-group row">
                    <div class="col-9">
                        <div class="checkbox-inline">
                            <label class="checkbox mb-2">
                            <input type="checkbox" id='CheckAll'>
                            <span></span>Seleccionar todos</label>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                </div>

                @foreach($rol as $value)
                <div class="row mt-2">
                    <div class="col-md-8">
                        <label>{{ $value->guard_names }}</label>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <span class="switch switch-icon">
                            <label>
                                <input type="checkbox" name="permission[]" class="roles_check all_generales" value="{{ $value->id }}">
                                <span></span>
                            </label>
                            </span>
                        </div>
                    </div>
                </div>       
                @endforeach   
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header" id="headingOne6">
            <div class="card-title" data-toggle="collapse" data-target="#collapse3">
                <i class="flaticon-users-1"></i> Listado de Usuarios
            </div>
        </div>
        <div id="collapse3" class="collapse" data-parent="#accordionExample6">
            <div class="card-body">

                <div class="form-group row">
                    <div class="col-9">
                        <div class="checkbox-inline">
                            <label class="checkbox mb-2">
                            <input type="checkbox" id='all_user'>
                            <span></span>Seleccionar todos</label>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                </div>

                @foreach($usuarios as $value)
                <div class="row mt-2">
                    <div class="col-md-8">
                        <label>{{ $value->guard_names }}</label>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <span class="switch switch-icon">
                            <label>
                                <input type="checkbox" name="permission[]" class="user_check all_generales" value="{{ $value->id }}">
                                <span></span>
                            </label>
                            </span>
                        </div>
                    </div>
                </div>       
                @endforeach   
            </div>
        </div>
    </div>

</div>
