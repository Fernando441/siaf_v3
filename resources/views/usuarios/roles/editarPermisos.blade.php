@extends('layouts.app')
@push('scripts')
    {{-- <script src="{{ asset('js/roles/AgregarRol.js') }}"></script> --}}
    <script src="{{ asset('js/roles/PermisosRol.js') }}"></script>
@endpush
@section('title')
    Agregar Rol
@endsection
@section('content')

<style type="text/css">
    /* .nav.nav-pills.nav-light-primary .nav-link.active {
        background-color:  #F3F6F9; !important;
    } */
</style>
@php  
    $permiso_roles_id = array();
    foreach($permisos_rol as $username) {
      $permiso_roles_id[] = $username->permission_id;
    }
  @endphp

<!--begin::Todo-->
<div class="d-flex flex-row">

    <!--begin::Aside-->
    {{-- @include('usuarios.roles.rol-nav') --}}
    <!--end::Aside-->

    <!--begin::List-->
    <div class="flex-row-fluid ml-lg-2">
        <div class="d-flex flex-column flex-grow-1">
            <!--begin::Row-->
            <div class="row">
                <div class="col-xl-12">

                    <div class="card card-custom gutter-b">

                        <div class="card-header">
                            <h3 class="card-title">Editar Permisos al Rol: &nbsp;{{ $rolInfo->name }}</h3>
                        </div>
                        <!--begin::Form-->
                        <form class="form" action="{{ route('rol.editarrol') }}" method="post" id="frmRol">
                            @csrf   
                            <input type="hidden" name="id" value="{{ $rolInfo->id }}">
                            <div class="card-body">

                                    <div class="row">
                                        <div class="col-4">
                                            <ul class="nav flex-column bg-light">

                                                <li class="navi-section text-secondary text-uppercase pb-0 pl-5">Sistema</li>

                                                <li class="nav-item mb-2">
                                                    <a class="nav-link active"  id="home-tab-5" data-toggle="tab" href="#tabSistema" >
                                                        <span class="nav-icon">
                                                            <i class="flaticon2-user-1 menu-icon"></i>
                                                        </span>
                                                        <span class="nav-text font-weight-bolder font-size-lg">Administración del sistema</span>
                                                    </a>
                                                </li>

                                                <li class="navi-section text-secondary text-uppercase pb-0 pl-5 pt-7">Direcciones</li>
                                                <li class="nav-item mb-2">
                                                    <a class="nav-link" id="profile-tab-5" data-toggle="tab" href="#tabComercial" aria-controls="profile">
                                                        <span class="nav-icon">
                                                            <i class="flaticon2-notepad "></i>
                                                        </span>
                                                        <span class="nav-text font-weight-bolder font-size-lg">Dirección comercial</span>
                                                    </a>
                                                </li>
                                               
                                                
                                                <li class="nav-item mb-2">
                                                    <a class="nav-link" id="profile-tab-5" data-toggle="tab" href="#tabAdmonContratos" aria-controls="profile">
                                                        <span class="nav-icon">
                                                            <i class="flaticon2-list"></i>
                                                        </span>
                                                        <span class="nav-text font-weight-bolder font-size-lg">Dirección de administración de contratos</span>
                                                    </a>
                                                </li>
                                                
                                                
                                                <li class="nav-item mb-2">
                                                    <a class="nav-link" id="profile-tab-5" data-toggle="tab" href="#tabDirOperaciones" aria-controls="profile">
                                                        <span class="nav-icon">
                                                            <i class="flaticon2-console"></i>
                                                        </span>
                                                        <span class="nav-text font-weight-bolder font-size-lg">Dirección de operaciones</span>
                                                    </a>
                                                </li>
                                               
                                                <li class="nav-item mb-2">
                                                    <a class="nav-link" id="profile-tab-5" data-toggle="tab" href="#tabDirFinanzas" aria-controls="profile">
                                                        <span class="nav-icon">
                                                            <i class="flaticon2-chart"></i>
                                                        </span>
                                                        <span class="nav-text font-weight-bolder font-size-lg">Dirección de administración y finanzas</span>
                                                    </a>
                                                </li>
                                               





                                                <li class="navi-section text-secondary text-uppercase pb-0 pl-5 pt-7">Catálogos</li>
                                                 <li class="nav-item mb-2">
                                                    <a class="nav-link" id="profile-tab-5" data-toggle="tab" href="#tabCatComercial" aria-controls="profile">
                                                        <span class="nav-icon">
                                                            <i class="flaticon2-folder"></i>
                                                        </span>
                                                        <span class="nav-text font-weight-bolder font-size-lg">Catalogos de dirección comercial</span>
                                                    </a>
                                                </li>
                                                 <li class="nav-item mb-2">
                                                    <a class="nav-link" id="profile-tab-5" data-toggle="tab" href="#tabCatAdmonContratos" aria-controls="profile">
                                                        <span class="nav-icon">
                                                            <i class="flaticon2-folder"></i>
                                                        </span>
                                                        <span class="nav-text font-weight-bolder font-size-lg">Catálogos de Dirección de administración de contratos</span>
                                                    </a>
                                                </li>
                                                 <li class="nav-item mb-2">
                                                    <a class="nav-link" id="profile-tab-5" data-toggle="tab" href="#tabCatDirOperaciones" aria-controls="profile">
                                                        <span class="nav-icon">
                                                            <i class="flaticon2-folder"></i>
                                                        </span>
                                                        <span class="nav-text font-weight-bolder font-size-lg">Catálogos de Dirección de Operaciones</span>
                                                    </a>
                                                </li>
                                                 <li class="nav-item mb-2">
                                                    <a class="nav-link" id="profile-tab-5" data-toggle="tab" href="#tabCatDirFinanzas" aria-controls="profile">
                                                        <span class="nav-icon">
                                                            <i class="flaticon2-folder"></i>
                                                        </span>
                                                        <span class="nav-text font-weight-bolder font-size-lg">Catálogos de Dirección de administración y finanzas</span>
                                                    </a>
                                                </li>
                                               
                                            </ul>
                                        </div>
                                        <div class="col-8">
                                            <div class="tab-content" id="myTabContent5">
                                                <div class="tab-pane fade active show" id="tabSistema" role="tabpanel" aria-labelledby="home-tab-5">
                                                    
                                                    
                                                    <!--- init -->        
                                                    <input type="hidden" value="{{ $rolInfo->id }}" name="idRol">
                                                    <div class="accordion accordion-solid accordion-toggle-plus accordion-toggle-arrow" id="accordionSistema">
                                                        <div class="card">
                                                            <div class="card-header" id="headingTablero">
                                                                <div class="card-title collapsed" data-toggle="collapse" data-target="#accordionTablero">
                                                                    <i class="flaticon-pie-chart-1"></i> Tablero    
                                                                </div>
                                                            </div>
                                                            <div id="accordionTablero" class="collapse" data-parent="#accordionSistema">
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
                                                                                    <input type="checkbox" {{(in_array($value->id , $permiso_roles_id)) ? 'checked' : ''}} name="permission[]" class="tablero_check all_generales" value="{{ $value->id }}">
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
                                                            <div class="card-header" id="headingRoles">
                                                                <div class="card-title collapsed" data-toggle="collapse" data-target="#collapseRoles">
                                                                    <i class="flaticon-security"></i> Listado de Roles    
                                                                </div>
                                                            </div>
                                                            <div id="collapseRoles" class="collapse" data-parent="#accordionSistema">
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
                                                                                    <input type="checkbox" {{(in_array($value->id , $permiso_roles_id)) ? 'checked' : ''}} name="permission[]" class="roles_check all_generales" value="{{ $value->id }}">
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
                                                            <div class="card-header" id="headingUsuarios">
                                                                <div class="card-title collapsed" data-toggle="collapse" data-target="#collapseUsuarios">
                                                                    <i class="flaticon-users-1"></i> Listado de Usuarios
                                                                </div>
                                                            </div>
                                                            <div id="collapseUsuarios" class="collapse" data-parent="#accordionSistema">
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
                                                                                    <input type="checkbox" {{(in_array($value->id , $permiso_roles_id)) ? 'checked' : ''}} name="permission[]" class="user_check all_generales" value="{{ $value->id }}">
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


                                                        <!--init:acordion-->
                                                        <div class="card">
                                                            <div class="card-header" id="headingCatSis">
                                                                <div class="card-title collapsed" data-toggle="collapse" data-target="#collapseCatSis">
                                                                    <i class="flaticon-folder-1"></i> Catalogos de administración del sistema
    
                                                                </div>
                                                            </div>
                                                            <div id="collapseCatSis" class="collapse" data-parent="#accordionSistema">
                                                                <div class="card-body">

                                                                    <div class="form-group row">
                                                                        <div class="col-9">
                                                                            <div class="checkbox-inline">
                                                                                <label class="checkbox mb-2">
                                                                                <input type="checkbox" id='all_areapers'>
                                                                                <span></span>Seleccionar todos</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group row">
                                                                    </div>

                                                                    @foreach($area_personal as $value)
                                                                    <div class="row mt-2">
                                                                        <div class="col-md-8">
                                                                            <label>{{ $value->guard_names }}</label>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <span class="switch switch-icon">
                                                                                <label>
                                                                                    <input type="checkbox" {{(in_array($value->id , $permiso_roles_id)) ? 'checked' : ''}} name="permission[]" class="areapers_check all_generales" value="{{ $value->id }}">
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
                                                        <!--end:acordion-->


                                                    </div>

                                                    <!--- end -->        

                                                </div>
                                                <div class="tab-pane fade" id="tabComercial" role="tabpanel" aria-labelledby="profile-tab-5">

                                                    <div class="accordion accordion-solid accordion-toggle-plus" id="accordionComercial">
                                                        
                                                        <div class="card">
                                                            <div class="card-header" id="headingClientes">
                                                                <div class="card-title collapsed" data-toggle="collapse" data-target="#accordionClientes">
                                                                    <i class="flaticon-profile"></i> Catálogo de clientes    
                                                                </div>
                                                            </div>
                                                            <div id="accordionClientes" class="collapse" data-parent="#accordionComercial">
                                                                <div class="card-body">

                                                                    <div class="form-group row">
                                                                        <div class="col-9">
                                                                            <div class="checkbox-inline">
                                                                                <label class="checkbox mb-2">
                                                                                <input type="checkbox" id='all_cliente'>
                                                                                <span></span>Seleccionar todos</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group row">
                                                                    </div>

                                                                    @foreach($cliente as $value)
                                                                    <div class="row mt-2">
                                                                        <div class="col-md-8">
                                                                            <label>{{ $value->guard_names }}</label>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <span class="switch switch-icon">
                                                                                <label>
                                                                                    <input type="checkbox"  {{(in_array($value->id , $permiso_roles_id)) ? 'checked' : ''}} name="permission[]" class="clientes_check all_generales" value="{{ $value->id }}">
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
                                                            <div class="card-header" id="headingConcursos">
                                                                <div class="card-title collapsed" data-toggle="collapse" data-target="#accordionConcursos">
                                                                    <i class="flaticon-folder-1"></i> Concursos    
                                                                </div>
                                                            </div>
                                                            <div id="accordionConcursos" class="collapse" data-parent="#accordionComercial">
                                                                <div class="card-body">

                                                                    <div class="form-group row">
                                                                        <div class="col-9">
                                                                            <div class="checkbox-inline">
                                                                                <label class="checkbox mb-2">
                                                                                <input type="checkbox" id='all_concursos'>
                                                                                <span></span>Seleccionar todos</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group row">
                                                                    </div>

                                                                    @foreach($concursos as $value)
                                                                    <div class="row mt-2">
                                                                        <div class="col-md-8">
                                                                            <label>{{ $value->guard_names }}</label>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <span class="switch switch-icon">
                                                                                <label>
                                                                                    <input type="checkbox"  {{(in_array($value->id , $permiso_roles_id)) ? 'checked' : ''}}  name="permission[]" class="concursos_check all_generales" value="{{ $value->id }}">
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
                                                            <div class="card-header" id="headingRequisicion">
                                                                <div class="card-title collapsed" data-toggle="collapse" data-target="#accordionRequisicion">
                                                                    <i class="flaticon-folder-2"></i> Requisiciones    
                                                                </div>
                                                            </div>
                                                            <div id="accordionRequisicion" class="collapse" data-parent="#accordionComercial">
                                                                <div class="card-body">

                                                                    <div class="form-group row">
                                                                        <div class="col-9">
                                                                            <div class="checkbox-inline">
                                                                                <label class="checkbox mb-2">
                                                                                <input type="checkbox" id='all_requisiciones'>
                                                                                <span></span>Seleccionar todos</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group row">
                                                                    </div>

                                                                    @foreach($requisiciones as $value)
                                                                    <div class="row mt-2">
                                                                        <div class="col-md-8">
                                                                            <label>{{ $value->guard_names }}</label>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <span class="switch switch-icon">
                                                                                <label>
                                                                                    <input type="checkbox"  {{(in_array($value->id , $permiso_roles_id)) ? 'checked' : ''}}  name="permission[]" class="requisiciones_check all_generales" value="{{ $value->id }}">
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
                                                            <div class="card-header" id="headingSegmentos">
                                                                <div class="card-title collapsed" data-toggle="collapse" data-target="#accordionSegmentos">
                                                                    <i class="flaticon-folder-4"></i> Administración de segmentos    
                                                                </div>
                                                            </div>
                                                            <div id="accordionSegmentos" class="collapse" data-parent="#accordionComercial">
                                                                <div class="card-body">

                                                                    <div class="form-group row">
                                                                        <div class="col-9">
                                                                            <div class="checkbox-inline">
                                                                                <label class="checkbox mb-2">
                                                                                <input type="checkbox" id='all_asegmento'>
                                                                                <span></span>Seleccionar todos</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group row">
                                                                    </div>

                                                                    @foreach($admin_segmento as $value)
                                                                    <div class="row mt-2">
                                                                        <div class="col-md-8">
                                                                            <label>{{ $value->guard_names }}</label>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <span class="switch switch-icon">
                                                                                <label>
                                                                                    <input type="checkbox"  {{(in_array($value->id , $permiso_roles_id)) ? 'checked' : ''}}  name="permission[]" class="asegmento_check all_generales" value="{{ $value->id }}">
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
                                                            <div class="card-header" id="headingParque">
                                                                <div class="card-title collapsed" data-toggle="collapse" data-target="#accordionParque">
                                                                    <i class="flaticon-car"></i> Parque Vehícular
                                                                </div>
                                                            </div>
                                                            <div id="accordionParque" class="collapse" data-parent="#accordionComercial">
                                                                <div class="card-body">

                                                                    <div class="form-group row">
                                                                        <div class="col-9">
                                                                            <div class="checkbox-inline">
                                                                                <label class="checkbox mb-2">
                                                                                <input type="checkbox" id='all_cliunidades'>
                                                                                <span></span>Seleccionar todos</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group row">
                                                                    </div>

                                                                    @foreach($cli_unidades as $value)
                                                                    <div class="row mt-2">
                                                                        <div class="col-md-8">
                                                                            <label>{{ $value->guard_names }}</label>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <span class="switch switch-icon">
                                                                                <label>
                                                                                    <input type="checkbox"  {{(in_array($value->id , $permiso_roles_id)) ? 'checked' : ''}}  name="permission[]" class="cliunidades_check all_generales" value="{{ $value->id }}">
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
                                                            <div class="card-header" id="headingGestorDoc">
                                                                <div class="card-title collapsed" data-toggle="collapse" data-target="#accordionGestorDoc">
                                                                    <i class="flaticon2-document"></i> Gestor Documentos
                                                                </div>
                                                            </div>
                                                            <div id="accordionGestorDoc" class="collapse" data-parent="#accordionComercial">
                                                                <div class="card-body">

                                                                    <div class="form-group row">
                                                                        <div class="col-9">
                                                                            <div class="checkbox-inline">
                                                                                <label class="checkbox mb-2">
                                                                                <input type="checkbox" id='all_gestordoc'>
                                                                                <span></span>Seleccionar todos</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group row">
                                                                    </div>

                                                                    @foreach($gestor_doc as $value)
                                                                    <div class="row mt-2">
                                                                        <div class="col-md-8">
                                                                            <label>{{ $value->guard_names }}</label>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <span class="switch switch-icon">
                                                                                <label>
                                                                                    <input type="checkbox"  {{(in_array($value->id , $permiso_roles_id)) ? 'checked' : ''}}  name="permission[]" class="gestordoc_check all_generales" value="{{ $value->id }}">
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
                                                </div>
                                                <div class="tab-pane fade" id="tabCatComercial" role="tabpanel" aria-labelledby="profile-tab-5">
                                                    <div class="accordion accordion-solid accordion-toggle-plus" id="accordionCatComercial">
                                                        
                                                        <div class="card">
                                                            <div class="card-header" id="headingEstados">
                                                                <div class="card-title collapsed" data-toggle="collapse" data-target="#accordionEstados">
                                                                    <i class="flaticon2-document"></i>Estados
                                                                </div>
                                                            </div>
                                                            <div id="accordionEstados" class="collapse" data-parent="#accordionCatComercial">
                                                                <div class="card-body">

                                                                    <div class="form-group row">
                                                                        <div class="col-9">
                                                                            <div class="checkbox-inline">
                                                                                <label class="checkbox mb-2">
                                                                                <input type="checkbox" id='all_estados'>
                                                                                <span></span>Seleccionar todos</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group row">
                                                                    </div>

                                                                    @foreach($estado as $value)
                                                                    <div class="row mt-2">
                                                                        <div class="col-md-8">
                                                                            <label>{{ $value->guard_names }}</label>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <span class="switch switch-icon">
                                                                                <label>
                                                                                    <input type="checkbox"  {{(in_array($value->id , $permiso_roles_id)) ? 'checked' : ''}}  name="permission[]" class="estados_check all_generales" value="{{ $value->id }}">
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
                                                            <div class="card-header" id="heading">
                                                                <div class="card-title collapsed" data-toggle="collapse" data-target="#accordionMunicipios">
                                                                    <i class="flaticon2-document"></i>Municipios
                                                                </div>
                                                            </div>
                                                            <div id="accordionMunicipios" class="collapse" data-parent="#accordionCatComercial">
                                                                <div class="card-body">

                                                                    <div class="form-group row">
                                                                        <div class="col-9">
                                                                            <div class="checkbox-inline">
                                                                                <label class="checkbox mb-2">
                                                                                <input type="checkbox" id='all_municipios'>
                                                                                <span></span>Seleccionar todos</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group row">
                                                                    </div>

                                                                    @foreach($municipio as $value)
                                                                    <div class="row mt-2">
                                                                        <div class="col-md-8">
                                                                            <label>{{ $value->guard_names }}</label>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <span class="switch switch-icon">
                                                                                <label>
                                                                                    <input type="checkbox"  {{(in_array($value->id , $permiso_roles_id)) ? 'checked' : ''}}  name="permission[]" class="municipios_check all_generales" value="{{ $value->id }}">
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
                                                            <div class="card-header" id="heading">
                                                                <div class="card-title collapsed" data-toggle="collapse" data-target="#accordionTVehiculos">
                                                                    <i class="flaticon2-document"></i>Tipos de vehículos
                                                                </div>
                                                            </div>
                                                            <div id="accordionTVehiculos" class="collapse" data-parent="#accordionCatComercial">
                                                                <div class="card-body">

                                                                    <div class="form-group row">
                                                                        <div class="col-9">
                                                                            <div class="checkbox-inline">
                                                                                <label class="checkbox mb-2">
                                                                                <input type="checkbox" id='all_astipovehiculo'>
                                                                                <span></span>Seleccionar todos</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group row">
                                                                    </div>

                                                                    @foreach($as_tipovehiculo as $value)
                                                                    <div class="row mt-2">
                                                                        <div class="col-md-8">
                                                                            <label>{{ $value->guard_names }}</label>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <span class="switch switch-icon">
                                                                                <label>
                                                                                    <input type="checkbox"  {{(in_array($value->id , $permiso_roles_id)) ? 'checked' : ''}} name="permission[]" class="astipovehiculo_check all_generales" value="{{ $value->id }}">
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
                                                            <div class="card-header" id="heading">
                                                                <div class="card-title collapsed" data-toggle="collapse" data-target="#accordionPuertas">
                                                                    <i class="flaticon2-document"></i>Puertas
                                                                </div>
                                                            </div>
                                                            <div id="accordionPuertas" class="collapse" data-parent="#accordionCatComercial">
                                                                <div class="card-body">

                                                                    <div class="form-group row">
                                                                        <div class="col-9">
                                                                            <div class="checkbox-inline">
                                                                                <label class="checkbox mb-2">
                                                                                <input type="checkbox" id='all_aspuerta'>
                                                                                <span></span>Seleccionar todos</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group row">
                                                                    </div>

                                                                    @foreach($as_puertas as $value)
                                                                    <div class="row mt-2">
                                                                        <div class="col-md-8">
                                                                            <label>{{ $value->guard_names }}</label>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <span class="switch switch-icon">
                                                                                <label>
                                                                                    <input type="checkbox"  {{(in_array($value->id , $permiso_roles_id)) ? 'checked' : ''}} name="permission[]" class="aspuerta_check all_generales" value="{{ $value->id }}">
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
                                                            <div class="card-header" id="heading">
                                                                <div class="card-title collapsed" data-toggle="collapse" data-target="#accordionCarroceria">
                                                                    <i class="flaticon2-document"></i>Carrocería
                                                                </div>
                                                            </div>
                                                            <div id="accordionCarroceria" class="collapse" data-parent="#accordionCatComercial">
                                                                <div class="card-body">

                                                                    <div class="form-group row">
                                                                        <div class="col-9">
                                                                            <div class="checkbox-inline">
                                                                                <label class="checkbox mb-2">
                                                                                <input type="checkbox" id='all_ascarroceria'>
                                                                                <span></span>Seleccionar todos</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group row">
                                                                    </div>

                                                                    @foreach($as_carroceria as $value)
                                                                    <div class="row mt-2">
                                                                        <div class="col-md-8">
                                                                            <label>{{ $value->guard_names }}</label>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <span class="switch switch-icon">
                                                                                <label>
                                                                                    <input type="checkbox"  {{(in_array($value->id , $permiso_roles_id)) ? 'checked' : ''}} name="permission[]" class="ascarroceria_check all_generales" value="{{ $value->id }}">
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
                                                            <div class="card-header" id="heading">
                                                                <div class="card-title collapsed" data-toggle="collapse" data-target="#accordionNoCilindros">
                                                                    <i class="flaticon2-document"></i>Número de cilindros
                                                                </div>
                                                            </div>
                                                            <div id="accordionNoCilindros" class="collapse" data-parent="#accordionCatComercial">
                                                                <div class="card-body">

                                                                    <div class="form-group row">
                                                                        <div class="col-9">
                                                                            <div class="checkbox-inline">
                                                                                <label class="checkbox mb-2">
                                                                                <input type="checkbox" id='all_asnumcilindros'>
                                                                                <span></span>Seleccionar todos</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group row">
                                                                    </div>

                                                                    @foreach($as_numcilindros as $value)
                                                                    <div class="row mt-2">
                                                                        <div class="col-md-8">
                                                                            <label>{{ $value->guard_names }}</label>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <span class="switch switch-icon">
                                                                                <label>
                                                                                    <input type="checkbox"  {{(in_array($value->id , $permiso_roles_id)) ? 'checked' : ''}}  name="permission[]" class="asnumcilindros_check all_generales" value="{{ $value->id }}">
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
                                                            <div class="card-header" id="heading">
                                                                <div class="card-title collapsed" data-toggle="collapse" data-target="#accordionPasajeros">
                                                                    <i class="flaticon2-document"></i>Pasajeros
                                                                </div>
                                                            </div>
                                                            <div id="accordionPasajeros" class="collapse" data-parent="#accordionCatComercial">
                                                                <div class="card-body">

                                                                    <div class="form-group row">
                                                                        <div class="col-9">
                                                                            <div class="checkbox-inline">
                                                                                <label class="checkbox mb-2">
                                                                                <input type="checkbox" id='all_aspasajeros'>
                                                                                <span></span>Seleccionar todos</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group row">
                                                                    </div>

                                                                    @foreach($as_pasajeros as $value)
                                                                    <div class="row mt-2">
                                                                        <div class="col-md-8">
                                                                            <label>{{ $value->guard_names }}</label>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <span class="switch switch-icon">
                                                                                <label>
                                                                                    <input type="checkbox"  {{(in_array($value->id , $permiso_roles_id)) ? 'checked' : ''}} name="permission[]" class="aspasajeros_check all_generales" value="{{ $value->id }}">
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
                                                            <div class="card-header" id="heading">
                                                                <div class="card-title collapsed" data-toggle="collapse" data-target="#accordionMotor">
                                                                    <i class="flaticon2-document"></i>Motor
                                                                </div>
                                                            </div>
                                                            <div id="accordionMotor" class="collapse" data-parent="#accordionCatComercial">
                                                                <div class="card-body">

                                                                    <div class="form-group row">
                                                                        <div class="col-9">
                                                                            <div class="checkbox-inline">
                                                                                <label class="checkbox mb-2">
                                                                                <input type="checkbox" id='all_motor'>
                                                                                <span></span>Seleccionar todos</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group row">
                                                                    </div>

                                                                    @foreach($as_motor as $value)
                                                                    <div class="row mt-2">
                                                                        <div class="col-md-8">
                                                                            <label>{{ $value->guard_names }}</label>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <span class="switch switch-icon">
                                                                                <label>
                                                                                    <input type="checkbox"  {{(in_array($value->id , $permiso_roles_id)) ? 'checked' : ''}}  name="permission[]" class="motor_check all_generales" value="{{ $value->id }}">
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
                                                            <div class="card-header" id="heading">
                                                                <div class="card-title collapsed" data-toggle="collapse" data-target="#accordionLlantaRefaccion">
                                                                    <i class="flaticon2-document"></i>Llanta de refacción
                                                                </div>
                                                            </div>
                                                            <div id="accordionLlantaRefaccion" class="collapse" data-parent="#accordionCatComercial">
                                                                <div class="card-body">

                                                                    <div class="form-group row">
                                                                        <div class="col-9">
                                                                            <div class="checkbox-inline">
                                                                                <label class="checkbox mb-2">
                                                                                <input type="checkbox" id='all_asllantarefaccion'>
                                                                                <span></span>Seleccionar todos</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group row">
                                                                    </div>

                                                                    @foreach($as_llantarefaccion as $value)
                                                                    <div class="row mt-2">
                                                                        <div class="col-md-8">
                                                                            <label>{{ $value->guard_names }}</label>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <span class="switch switch-icon">
                                                                                <label>
                                                                                    <input type="checkbox"  {{(in_array($value->id , $permiso_roles_id)) ? 'checked' : ''}} name="permission[]" class="asllantarefaccion_check all_generales" value="{{ $value->id }}">
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
                                                            <div class="card-header" id="heading">
                                                                <div class="card-title collapsed" data-toggle="collapse" data-target="#accordionEspejosLaterales">
                                                                    <i class="flaticon2-document"></i>Espejos laterales
                                                                </div>
                                                            </div>
                                                            <div id="accordionEspejosLaterales" class="collapse" data-parent="#accordionCatComercial">
                                                                <div class="card-body">

                                                                    <div class="form-group row">
                                                                        <div class="col-9">
                                                                            <div class="checkbox-inline">
                                                                                <label class="checkbox mb-2">
                                                                                <input type="checkbox" id='all_asespejoslaterales'>
                                                                                <span></span>Seleccionar todos</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group row">
                                                                    </div>

                                                                    @foreach($as_espejoslaterales as $value)
                                                                    <div class="row mt-2">
                                                                        <div class="col-md-8">
                                                                            <label>{{ $value->guard_names }}</label>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <span class="switch switch-icon">
                                                                                <label>
                                                                                    <input type="checkbox"  {{(in_array($value->id , $permiso_roles_id)) ? 'checked' : ''}} name="permission[]" class="asespejoslaterales_check all_generales" value="{{ $value->id }}">
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
                                                            <div class="card-header" id="heading">
                                                                <div class="card-title collapsed" data-toggle="collapse" data-target="#accordionAccesorios">
                                                                    <i class="flaticon2-document"></i>Accesorios
                                                                </div>
                                                            </div>
                                                            <div id="accordionAccesorios" class="collapse" data-parent="#accordionCatComercial">
                                                                <div class="card-body">

                                                                    <div class="form-group row">
                                                                        <div class="col-9">
                                                                            <div class="checkbox-inline">
                                                                                <label class="checkbox mb-2">
                                                                                <input type="checkbox" id='all_asaccesorios'>
                                                                                <span></span>Seleccionar todos</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group row">
                                                                    </div>

                                                                    @foreach($as_accesorios as $value)
                                                                    <div class="row mt-2">
                                                                        <div class="col-md-8">
                                                                            <label>{{ $value->guard_names }}</label>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <span class="switch switch-icon">
                                                                                <label>
                                                                                    <input type="checkbox"  {{(in_array($value->id , $permiso_roles_id)) ? 'checked' : ''}} name="permission[]" class="asaccesorios_check all_generales" value="{{ $value->id }}">
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
                                                            <div class="card-header" id="heading">
                                                                <div class="card-title collapsed" data-toggle="collapse" data-target="#accordionPotencia">
                                                                    <i class="flaticon2-document"></i>Potencia
                                                                </div>
                                                            </div>
                                                            <div id="accordionPotencia" class="collapse" data-parent="#accordionCatComercial">
                                                                <div class="card-body">

                                                                    <div class="form-group row">
                                                                        <div class="col-9">
                                                                            <div class="checkbox-inline">
                                                                                <label class="checkbox mb-2">
                                                                                <input type="checkbox" id='all_asapotencia'>
                                                                                <span></span>Seleccionar todos</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group row">
                                                                    </div>

                                                                    @foreach($as_postencia as $value)
                                                                    <div class="row mt-2">
                                                                        <div class="col-md-8">
                                                                            <label>{{ $value->guard_names }}</label>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <span class="switch switch-icon">
                                                                                <label>
                                                                                    <input type="checkbox"  {{(in_array($value->id , $permiso_roles_id)) ? 'checked' : ''}} name="permission[]" class="asapotencia_check all_generales" value="{{ $value->id }}">
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
                                                            <div class="card-header" id="heading">
                                                                <div class="card-title collapsed" data-toggle="collapse" data-target="#accordionTransmision">
                                                                    <i class="flaticon2-document"></i>Transmisión
                                                                </div>
                                                            </div>
                                                            <div id="accordionTransmision" class="collapse" data-parent="#accordionCatComercial">
                                                                <div class="card-body">

                                                                    <div class="form-group row">
                                                                        <div class="col-9">
                                                                            <div class="checkbox-inline">
                                                                                <label class="checkbox mb-2">
                                                                                <input type="checkbox" id='all_astransmision'>
                                                                                <span></span>Seleccionar todos</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group row">
                                                                    </div>

                                                                    @foreach($as_transmision as $value)
                                                                    <div class="row mt-2">
                                                                        <div class="col-md-8">
                                                                            <label>{{ $value->guard_names }}</label>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <span class="switch switch-icon">
                                                                                <label>
                                                                                    <input type="checkbox"  {{(in_array($value->id , $permiso_roles_id)) ? 'checked' : ''}} name="permission[]" class="astransmision_check all_generales" value="{{ $value->id }}">
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
                                                            <div class="card-header" id="heading">
                                                                <div class="card-title collapsed" data-toggle="collapse" data-target="#accordionRadio">
                                                                    <i class="flaticon2-document"></i>Radio
                                                                </div>
                                                            </div>
                                                            <div id="accordionRadio" class="collapse" data-parent="#accordionCatComercial">
                                                                <div class="card-body">

                                                                    <div class="form-group row">
                                                                        <div class="col-9">
                                                                            <div class="checkbox-inline">
                                                                                <label class="checkbox mb-2">
                                                                                <input type="checkbox" id='all_asradio'>
                                                                                <span></span>Seleccionar todos</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group row">
                                                                    </div>

                                                                    @foreach($as_radio as $value)
                                                                    <div class="row mt-2">
                                                                        <div class="col-md-8">
                                                                            <label>{{ $value->guard_names }}</label>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <span class="switch switch-icon">
                                                                                <label>
                                                                                    <input type="checkbox"  {{(in_array($value->id , $permiso_roles_id)) ? 'checked' : ''}} name="permission[]" class="asradio_check all_generales" value="{{ $value->id }}">
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
                                                            <div class="card-header" id="heading">
                                                                <div class="card-title collapsed" data-toggle="collapse" data-target="#accordionDireccion">
                                                                    <i class="flaticon2-document"></i>Dirección
                                                                </div>
                                                            </div>
                                                            <div id="accordionDireccion" class="collapse" data-parent="#accordionCatComercial">
                                                                <div class="card-body">

                                                                    <div class="form-group row">
                                                                        <div class="col-9">
                                                                            <div class="checkbox-inline">
                                                                                <label class="checkbox mb-2">
                                                                                <input type="checkbox" id='all_asdireccion'>
                                                                                <span></span>Seleccionar todos</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group row">
                                                                    </div>

                                                                    @foreach($as_direccion as $value)
                                                                    <div class="row mt-2">
                                                                        <div class="col-md-8">
                                                                            <label>{{ $value->guard_names }}</label>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <span class="switch switch-icon">
                                                                                <label>
                                                                                    <input type="checkbox"  {{(in_array($value->id , $permiso_roles_id)) ? 'checked' : ''}} name="permission[]" class="asdireccion_check all_generales" value="{{ $value->id }}">
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
                                                            <div class="card-header" id="heading">
                                                                <div class="card-title collapsed" data-toggle="collapse" data-target="#accordionBlindaje">
                                                                    <i class="flaticon2-document"></i>Blindaje
                                                                </div>
                                                            </div>
                                                            <div id="accordionBlindaje" class="collapse" data-parent="#accordionCatComercial">
                                                                <div class="card-body">

                                                                    <div class="form-group row">
                                                                        <div class="col-9">
                                                                            <div class="checkbox-inline">
                                                                                <label class="checkbox mb-2">
                                                                                <input type="checkbox" id='all_asblindaje'>
                                                                                <span></span>Seleccionar todos</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group row">
                                                                    </div>

                                                                    @foreach($as_blindaje as $value)
                                                                    <div class="row mt-2">
                                                                        <div class="col-md-8">
                                                                            <label>{{ $value->guard_names }}</label>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <span class="switch switch-icon">
                                                                                <label>
                                                                                    <input type="checkbox"  {{(in_array($value->id , $permiso_roles_id)) ? 'checked' : ''}} name="permission[]" class="asblindaje_check all_generales" value="{{ $value->id }}">
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
                                                            <div class="card-header" id="heading">
                                                                <div class="card-title collapsed" data-toggle="collapse" data-target="#accordionCapacidad">
                                                                    <i class="flaticon2-document"></i>Capacidad
                                                                </div>
                                                            </div>
                                                            <div id="accordionCapacidad" class="collapse" data-parent="#accordionCatComercial">
                                                                <div class="card-body">

                                                                    <div class="form-group row">
                                                                        <div class="col-9">
                                                                            <div class="checkbox-inline">
                                                                                <label class="checkbox mb-2">
                                                                                <input type="checkbox" id='all_ascapacidad'>
                                                                                <span></span>Seleccionar todos</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group row">
                                                                    </div>

                                                                    @foreach($as_capacidad as $value)
                                                                    <div class="row mt-2">
                                                                        <div class="col-md-8">
                                                                            <label>{{ $value->guard_names }}</label>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <span class="switch switch-icon">
                                                                                <label>
                                                                                    <input type="checkbox"  {{(in_array($value->id , $permiso_roles_id)) ? 'checked' : ''}} name="permission[]" class="ascapacidad_check all_generales" value="{{ $value->id }}">
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
                                                            <div class="card-header" id="heading">
                                                                <div class="card-title collapsed" data-toggle="collapse" data-target="#accordionGPS">
                                                                    <i class="flaticon2-document"></i>GPS
                                                                </div>
                                                            </div>
                                                            <div id="accordionGPS" class="collapse" data-parent="#accordionCatComercial">
                                                                <div class="card-body">

                                                                    <div class="form-group row">
                                                                        <div class="col-9">
                                                                            <div class="checkbox-inline">
                                                                                <label class="checkbox mb-2">
                                                                                <input type="checkbox" id='all_asgps'>
                                                                                <span></span>Seleccionar todos</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group row">
                                                                    </div>

                                                                    @foreach($as_gps as $value)
                                                                    <div class="row mt-2">
                                                                        <div class="col-md-8">
                                                                            <label>{{ $value->guard_names }}</label>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <span class="switch switch-icon">
                                                                                <label>
                                                                                    <input type="checkbox"  {{(in_array($value->id , $permiso_roles_id)) ? 'checked' : ''}} name="permission[]" class="asgps_check all_generales" value="{{ $value->id }}">
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
                                                            <div class="card-header" id="heading">
                                                                <div class="card-title collapsed" data-toggle="collapse" data-target="#accordionINVENTARIO">
                                                                    <i class="flaticon2-document"></i>En Inventario
                                                                </div>
                                                            </div>
                                                            <div id="accordionINVENTARIO" class="collapse" data-parent="#accordionCatComercial">
                                                                <div class="card-body">

                                                                    <div class="form-group row">
                                                                        <div class="col-9">
                                                                            <div class="checkbox-inline">
                                                                                <label class="checkbox mb-2">
                                                                                <input type="checkbox" id='all_asinventario'>
                                                                                <span></span>Seleccionar todos</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group row">
                                                                    </div>

                                                                    @foreach($as_inventario as $value)
                                                                    <div class="row mt-2">
                                                                        <div class="col-md-8">
                                                                            <label>{{ $value->guard_names }}</label>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <span class="switch switch-icon">
                                                                                <label>
                                                                                    <input type="checkbox"  {{(in_array($value->id , $permiso_roles_id)) ? 'checked' : ''}} name="permission[]" class="asinventario_check all_generales" value="{{ $value->id }}">
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
                                                            <div class="card-header" id="heading">
                                                                <div class="card-title collapsed" data-toggle="collapse" data-target="#accordionDOCCLIENTE">
                                                                    <i class="flaticon2-document"></i>Documentos Clientes
                                                                </div>
                                                            </div>
                                                            <div id="accordionDOCCLIENTE" class="collapse" data-parent="#accordionCatComercial">
                                                                <div class="card-body">

                                                                    <div class="form-group row">
                                                                        <div class="col-9">
                                                                            <div class="checkbox-inline">
                                                                                <label class="checkbox mb-2">
                                                                                <input type="checkbox" id='all_doccliente'>
                                                                                <span></span>Seleccionar todos</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group row">
                                                                    </div>

                                                                    @foreach($doc_cliente as $value)
                                                                    <div class="row mt-2">
                                                                        <div class="col-md-8">
                                                                            <label>{{ $value->guard_names }}</label>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <span class="switch switch-icon">
                                                                                <label>
                                                                                    <input type="checkbox"  {{(in_array($value->id , $permiso_roles_id)) ? 'checked' : ''}} name="permission[]" class="doccliente_check all_generales" value="{{ $value->id }}">
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
                                                            <div class="card-header" id="heading">
                                                                <div class="card-title collapsed" data-toggle="collapse" data-target="#accordiondocconcursos">
                                                                    <i class="flaticon2-document"></i>Documentos del Concurso
                                                                </div>
                                                            </div>
                                                            <div id="accordiondocconcursos" class="collapse" data-parent="#accordionCatComercial">
                                                                <div class="card-body">

                                                                    <div class="form-group row">
                                                                        <div class="col-9">
                                                                            <div class="checkbox-inline">
                                                                                <label class="checkbox mb-2">
                                                                                <input type="checkbox" id='all_docconcursos'>
                                                                                <span></span>Seleccionar todos</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group row">
                                                                    </div>

                                                                    @foreach($doc_concursos as $value)
                                                                    <div class="row mt-2">
                                                                        <div class="col-md-8">
                                                                            <label>{{ $value->guard_names }}</label>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <span class="switch switch-icon">
                                                                                <label>
                                                                                    <input type="checkbox"  {{(in_array($value->id , $permiso_roles_id)) ? 'checked' : ''}} name="permission[]" class="docconcursos_check all_generales" value="{{ $value->id }}">
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
                                                            <div class="card-header" id="heading">
                                                                <div class="card-title collapsed" data-toggle="collapse" data-target="#accordionpubconcursos">
                                                                    <i class="flaticon2-document"></i>Publicación del concurso
                                                                </div>
                                                            </div>
                                                            <div id="accordionpubconcursos" class="collapse" data-parent="#accordionCatComercial">
                                                                <div class="card-body">

                                                                    <div class="form-group row">
                                                                        <div class="col-9">
                                                                            <div class="checkbox-inline">
                                                                                <label class="checkbox mb-2">
                                                                                <input type="checkbox" id='all_pubconcursos'>
                                                                                <span></span>Seleccionar todos</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group row">
                                                                    </div>

                                                                    @foreach($pub_concurso as $value)
                                                                    <div class="row mt-2">
                                                                        <div class="col-md-8">
                                                                            <label>{{ $value->guard_names }}</label>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <span class="switch switch-icon">
                                                                                <label>
                                                                                    <input type="checkbox"  {{(in_array($value->id , $permiso_roles_id)) ? 'checked' : ''}} name="permission[]" class="pubconcursos_check all_generales" value="{{ $value->id }}">
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
                                                            <div class="card-header" id="heading">
                                                                <div class="card-title collapsed" data-toggle="collapse" data-target="#accordiontipcontratacion">
                                                                    <i class="flaticon2-document"></i>Tipos de Contratación
                                                                </div>
                                                            </div>
                                                            <div id="accordiontipcontratacion" class="collapse" data-parent="#accordionCatComercial">
                                                                <div class="card-body">

                                                                    <div class="form-group row">
                                                                        <div class="col-9">
                                                                            <div class="checkbox-inline">
                                                                                <label class="checkbox mb-2">
                                                                                <input type="checkbox" id='all_tipcontratacion'>
                                                                                <span></span>Seleccionar todos</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group row">
                                                                    </div>

                                                                    @foreach($tip_contratacion as $value)
                                                                    <div class="row mt-2">
                                                                        <div class="col-md-8">
                                                                            <label>{{ $value->guard_names }}</label>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <span class="switch switch-icon">
                                                                                <label>
                                                                                    <input type="checkbox"  {{(in_array($value->id , $permiso_roles_id)) ? 'checked' : ''}} name="permission[]" class="tipcontratacion_check all_generales" value="{{ $value->id }}">
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
                                                            <div class="card-header" id="heading">
                                                                <div class="card-title collapsed" data-toggle="collapse" data-target="#accordiontipdoccontrato">
                                                                    <i class="flaticon2-document"></i>Tipos de documentos del contrato
                                                                </div>
                                                            </div>
                                                            <div id="accordiontipdoccontrato" class="collapse" data-parent="#accordionCatComercial">
                                                                <div class="card-body">

                                                                    <div class="form-group row">
                                                                        <div class="col-9">
                                                                            <div class="checkbox-inline">
                                                                                <label class="checkbox mb-2">
                                                                                <input type="checkbox" id='all_tipdoccontrato'>
                                                                                <span></span>Seleccionar todos</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group row">
                                                                    </div>

                                                                    @foreach($tip_doc_contrato as $value)
                                                                    <div class="row mt-2">
                                                                        <div class="col-md-8">
                                                                            <label>{{ $value->guard_names }}</label>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <span class="switch switch-icon">
                                                                                <label>
                                                                                    <input type="checkbox" {{(in_array($value->id , $permiso_roles_id)) ? 'checked' : ''}} name="permission[]" class="tipdoccontrato_check all_generales" value="{{ $value->id }}">
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
                                                            <div class="card-header" id="heading">
                                                                <div class="card-title collapsed" data-toggle="collapse" data-target="#accordionadmincontrato">
                                                                    <i class="flaticon2-document"></i>Administradores de contratos
                                                                </div>
                                                            </div>
                                                            <div id="accordionadmincontrato" class="collapse" data-parent="#accordionCatComercial">
                                                                <div class="card-body">

                                                                    <div class="form-group row">
                                                                        <div class="col-9">
                                                                            <div class="checkbox-inline">
                                                                                <label class="checkbox mb-2">
                                                                                <input type="checkbox" id='all_admincontrato'>
                                                                                <span></span>Seleccionar todos</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group row">
                                                                    </div>

                                                                    @foreach($admin_contrato_cat as $value)
                                                                    <div class="row mt-2">
                                                                        <div class="col-md-8">
                                                                            <label>{{ $value->guard_names }}</label>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <span class="switch switch-icon">
                                                                                <label>
                                                                                    <input type="checkbox" {{(in_array($value->id , $permiso_roles_id)) ? 'checked' : ''}} name="permission[]" class="admincontrato_check all_generales" value="{{ $value->id }}">
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
                                                            <div class="card-header" id="heading">
                                                                <div class="card-title collapsed" data-toggle="collapse" data-target="#accordionconveniomod">
                                                                    <i class="flaticon2-document"></i>Tipo de convenio modificatorio
                                                                </div>
                                                            </div>
                                                            <div id="accordionconveniomod" class="collapse" data-parent="#accordionCatComercial">
                                                                <div class="card-body">

                                                                    <div class="form-group row">
                                                                        <div class="col-9">
                                                                            <div class="checkbox-inline">
                                                                                <label class="checkbox mb-2">
                                                                                <input type="checkbox" id='all_conveniomod'>
                                                                                <span></span>Seleccionar todos</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group row">
                                                                    </div>

                                                                    @foreach($tipo_convenio_mod as $value)
                                                                    <div class="row mt-2">
                                                                        <div class="col-md-8">
                                                                            <label>{{ $value->guard_names }}</label>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <span class="switch switch-icon">
                                                                                <label>
                                                                                    <input type="checkbox" {{(in_array($value->id , $permiso_roles_id)) ? 'checked' : ''}} name="permission[]" class="conveniomod_check all_generales" value="{{ $value->id }}">
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
                                                            <div class="card-header" id="heading">
                                                                <div class="card-title collapsed" data-toggle="collapse" data-target="#accordiontipofianza">
                                                                    <i class="flaticon2-document"></i>Tipo de fianza
                                                                </div>
                                                            </div>
                                                            <div id="accordiontipofianza" class="collapse" data-parent="#accordionCatComercial">
                                                                <div class="card-body">

                                                                    <div class="form-group row">
                                                                        <div class="col-9">
                                                                            <div class="checkbox-inline">
                                                                                <label class="checkbox mb-2">
                                                                                <input type="checkbox" id='all_tipofianza'>
                                                                                <span></span>Seleccionar todos</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group row">
                                                                    </div>

                                                                    @foreach($tipo_fianza as $value)
                                                                    <div class="row mt-2">
                                                                        <div class="col-md-8">
                                                                            <label>{{ $value->guard_names }}</label>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <span class="switch switch-icon">
                                                                                <label>
                                                                                    <input type="checkbox" {{(in_array($value->id , $permiso_roles_id)) ? 'checked' : ''}} name="permission[]" class="tipofianza_check all_generales" value="{{ $value->id }}">
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
                                                            <div class="card-header" id="heading">
                                                                <div class="card-title collapsed" data-toggle="collapse" data-target="#accordionlequipamiento">
                                                                    <i class="flaticon2-document"></i>Listado de equipamiento
                                                                </div>
                                                            </div>
                                                            <div id="accordionlequipamiento" class="collapse" data-parent="#accordionCatComercial">
                                                                <div class="card-body">

                                                                    <div class="form-group row">
                                                                        <div class="col-9">
                                                                            <div class="checkbox-inline">
                                                                                <label class="checkbox mb-2">
                                                                                <input type="checkbox" id='all_lequipamiento'>
                                                                                <span></span>Seleccionar todos</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group row">
                                                                    </div>

                                                                    @foreach($req_equipamiento as $value)
                                                                    <div class="row mt-2">
                                                                        <div class="col-md-8">
                                                                            <label>{{ $value->guard_names }}</label>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <span class="switch switch-icon">
                                                                                <label>
                                                                                    <input type="checkbox" {{(in_array($value->id , $permiso_roles_id)) ? 'checked' : ''}} name="permission[]" class="lequipamiento_check all_generales" value="{{ $value->id }}">
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
                                                            <div class="card-header" id="heading">
                                                                <div class="card-title collapsed" data-toggle="collapse" data-target="#accordionrtransporte">
                                                                    <i class="flaticon2-document"></i>Listado de tipo de transporte
                                                                </div>
                                                            </div>
                                                            <div id="accordionrtransporte" class="collapse" data-parent="#accordionCatComercial">
                                                                <div class="card-body">

                                                                    <div class="form-group row">
                                                                        <div class="col-9">
                                                                            <div class="checkbox-inline">
                                                                                <label class="checkbox mb-2">
                                                                                <input type="checkbox" id='all_rtransporte'>
                                                                                <span></span>Seleccionar todos</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group row">
                                                                    </div>

                                                                    @foreach($req_transporte as $value)
                                                                    <div class="row mt-2">
                                                                        <div class="col-md-8">
                                                                            <label>{{ $value->guard_names }}</label>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <span class="switch switch-icon">
                                                                                <label>
                                                                                    <input type="checkbox" {{(in_array($value->id , $permiso_roles_id)) ? 'checked' : ''}} name="permission[]" class="rtransporte_check all_generales" value="{{ $value->id }}">
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
                                                            <div class="card-header" id="heading">
                                                                <div class="card-title collapsed" data-toggle="collapse" data-target="#accordionrentidadf">
                                                                    <i class="flaticon2-document"></i>Listado de entidad federativa
                                                                </div>
                                                            </div>
                                                            <div id="accordionrentidadf" class="collapse" data-parent="#accordionCatComercial">
                                                                <div class="card-body">

                                                                    <div class="form-group row">
                                                                        <div class="col-9">
                                                                            <div class="checkbox-inline">
                                                                                <label class="checkbox mb-2">
                                                                                <input type="checkbox" id='all_rentidadf'>
                                                                                <span></span>Seleccionar todos</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group row">
                                                                    </div>

                                                                    @foreach($req_entidadfederativa as $value)
                                                                    <div class="row mt-2">
                                                                        <div class="col-md-8">
                                                                            <label>{{ $value->guard_names }}</label>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <span class="switch switch-icon">
                                                                                <label>
                                                                                    <input type="checkbox" {{(in_array($value->id , $permiso_roles_id)) ? 'checked' : ''}} name="permission[]" class="rentidadf_check all_generales" value="{{ $value->id }}">
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
                                                            <div class="card-header" id="heading">
                                                                <div class="card-title collapsed" data-toggle="collapse" data-target="#accordionrplacas">
                                                                    <i class="flaticon2-document"></i>Listado de tipos de placas
                                                                </div>
                                                            </div>
                                                            <div id="accordionrplacas" class="collapse" data-parent="#accordionCatComercial">
                                                                <div class="card-body">

                                                                    <div class="form-group row">
                                                                        <div class="col-9">
                                                                            <div class="checkbox-inline">
                                                                                <label class="checkbox mb-2">
                                                                                <input type="checkbox" id='all_rplacas'>
                                                                                <span></span>Seleccionar todos</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group row">
                                                                    </div>

                                                                    @foreach($req_placas as $value)
                                                                    <div class="row mt-2">
                                                                        <div class="col-md-8">
                                                                            <label>{{ $value->guard_names }}</label>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <span class="switch switch-icon">
                                                                                <label>
                                                                                    <input type="checkbox" {{(in_array($value->id , $permiso_roles_id)) ? 'checked' : ''}} name="permission[]" class="rplacas_check all_generales" value="{{ $value->id }}">
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
                                                            <div class="card-header" id="heading">
                                                                <div class="card-title collapsed" data-toggle="collapse" data-target="#accordionrcombustible">
                                                                    <i class="flaticon2-document"></i>Listado de tipos de combustible
                                                                </div>
                                                            </div>
                                                            <div id="accordionrcombustible" class="collapse" data-parent="#accordionCatComercial">
                                                                <div class="card-body">

                                                                    <div class="form-group row">
                                                                        <div class="col-9">
                                                                            <div class="checkbox-inline">
                                                                                <label class="checkbox mb-2">
                                                                                <input type="checkbox" id='all_rcombustible'>
                                                                                <span></span>Seleccionar todos</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group row">
                                                                    </div>

                                                                    @foreach($req_combustible as $value)
                                                                    <div class="row mt-2">
                                                                        <div class="col-md-8">
                                                                            <label>{{ $value->guard_names }}</label>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <span class="switch switch-icon">
                                                                                <label>
                                                                                    <input type="checkbox" {{(in_array($value->id , $permiso_roles_id)) ? 'checked' : ''}} name="permission[]" class="rcombustible_check all_generales" value="{{ $value->id }}">
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
                                                            <div class="card-header" id="heading">
                                                                <div class="card-title collapsed" data-toggle="collapse" data-target="#accordioncatafianzadora">
                                                                    <i class="flaticon2-document"></i>Listado de afianzadora
                                                                </div>
                                                            </div>
                                                            <div id="accordioncatafianzadora" class="collapse" data-parent="#accordionCatComercial">
                                                                <div class="card-body">

                                                                    <div class="form-group row">
                                                                        <div class="col-9">
                                                                            <div class="checkbox-inline">
                                                                                <label class="checkbox mb-2">
                                                                                <input type="checkbox" id='all_catafianzadora'>
                                                                                <span></span>Seleccionar todos</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group row">
                                                                    </div>

                                                                    @foreach($cat_afianzadora as $value)
                                                                    <div class="row mt-2">
                                                                        <div class="col-md-8">
                                                                            <label>{{ $value->guard_names }}</label>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <span class="switch switch-icon">
                                                                                <label>
                                                                                    <input type="checkbox" {{(in_array($value->id , $permiso_roles_id)) ? 'checked' : ''}} name="permission[]" class="catafianzadora_check all_generales" value="{{ $value->id }}">
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
                                                </div>





                                                <div class="tab-pane fade" id="tabAdmonContratos" role="tabpanel" aria-labelledby="profile-tab-5">
                                                    <div class="accordion accordion-solid accordion-toggle-plus" id="accordionAdmonContratos">

                                                        <div class="card">
                                                            <div class="card-header" id="heading">
                                                                <div class="card-title collapsed" data-toggle="collapse" data-target="#accordioncontratos">
                                                                    <i class="flaticon2-document"></i>Administración de contratos
                                                                </div>
                                                            </div>
                                                            <div id="accordioncontratos" class="collapse" data-parent="#accordionCatComercial">
                                                                <div class="card-body">

                                                                    <div class="form-group row">
                                                                        <div class="col-9">
                                                                            <div class="checkbox-inline">
                                                                                <label class="checkbox mb-2">
                                                                                <input type="checkbox" id='all_contratos'>
                                                                                <span></span>Seleccionar todos</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group row">
                                                                    </div>

                                                                    @foreach($admin_contratos as $value)
                                                                    <div class="row mt-2">
                                                                        <div class="col-md-8">
                                                                            <label>{{ $value->guard_names }}</label>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <span class="switch switch-icon">
                                                                                <label>
                                                                                    <input type="checkbox" {{(in_array($value->id , $permiso_roles_id)) ? 'checked' : ''}} name="permission[]" class="contratos_check all_generales" value="{{ $value->id }}">
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
                                                </div>    


                                                <div class="tab-pane fade" id="tabCatAdmonContratos" role="tabpanel" aria-labelledby="profile-tab-5">
                                                    <div class="accordion accordion-solid accordion-toggle-plus" id="accordionAdmonContratos">

                                                        <div class="card">
                                                            <div class="card-header" id="heading">
                                                                <div class="card-title collapsed" data-toggle="collapse" data-target="#accordionpenalizaciones">
                                                                    <i class="flaticon2-document"></i>Penalizaciones y deducciones
                                                                </div>
                                                            </div>
                                                            <div id="accordionpenalizaciones" class="collapse" data-parent="#accordionCatComercial">
                                                                <div class="card-body">

                                                                    <div class="form-group row">
                                                                        <div class="col-9">
                                                                            <div class="checkbox-inline">
                                                                                <label class="checkbox mb-2">
                                                                                <input type="checkbox" id='all_penalizaciones'>
                                                                                <span></span>Seleccionar todos</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group row">
                                                                    </div>

                                                                    @foreach($penalizaciones as $value)
                                                                    <div class="row mt-2">
                                                                        <div class="col-md-8">
                                                                            <label>{{ $value->guard_names }}</label>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <span class="switch switch-icon">
                                                                                <label>
                                                                                    <input type="checkbox" {{(in_array($value->id , $permiso_roles_id)) ? 'checked' : ''}} name="permission[]" class="penalizaciones_check all_generales" value="{{ $value->id }}">
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
                                                </div>
                                                
                                                


                                                <div class="tab-pane fade" id="tabDirOperaciones" role="tabpanel" aria-labelledby="profile-tab-5">
                                                    <div class="accordion accordion-solid accordion-toggle-plus" id="accordionAdmonContratos">

                                                        <div class="card">
                                                            <div class="card-header" id="heading">
                                                                <div class="card-title collapsed" data-toggle="collapse" data-target="#accordionunidad">
                                                                    <i class="flaticon2-document"></i>Parque Vehícular
                                                                </div>
                                                            </div>
                                                            <div id="accordionunidad" class="collapse" data-parent="#accordionAdmonContratos">
                                                                <div class="card-body">

                                                                    <div class="form-group row">
                                                                        <div class="col-9">
                                                                            <div class="checkbox-inline">
                                                                                <label class="checkbox mb-2">
                                                                                <input type="checkbox" id='all_unidad'>
                                                                                <span></span>Seleccionar todos</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group row">
                                                                    </div>

                                                                    @foreach($unidades as $value)
                                                                    <div class="row mt-2">
                                                                        <div class="col-md-8">
                                                                            <label>{{ $value->guard_names }}</label>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <span class="switch switch-icon">
                                                                                <label>
                                                                                    <input type="checkbox" {{(in_array($value->id , $permiso_roles_id)) ? 'checked' : ''}} name="permission[]" class="unidad_check all_unidades" value="{{ $value->id }}">
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
                                                            <div class="card-header" id="heading">
                                                                <div class="card-title collapsed" data-toggle="collapse" data-target="#accordionubicacion">
                                                                    <i class="flaticon2-document"></i>Patios
                                                                </div>
                                                            </div>
                                                            <div id="accordionubicacion" class="collapse" data-parent="#accordionAdmonContratos">
                                                                <div class="card-body">

                                                                    <div class="form-group row">
                                                                        <div class="col-9">
                                                                            <div class="checkbox-inline">
                                                                                <label class="checkbox mb-2">
                                                                                <input type="checkbox" id='all_ubicacion'>
                                                                                <span></span>Seleccionar todos</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group row">
                                                                    </div>

                                                                    @foreach($ubicaciones as $value)
                                                                    <div class="row mt-2">
                                                                        <div class="col-md-8">
                                                                            <label>{{ $value->guard_names }}</label>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <span class="switch switch-icon">
                                                                                <label>
                                                                                    <input type="checkbox" {{(in_array($value->id , $permiso_roles_id)) ? 'checked' : ''}} name="permission[]" class="ubicacion_check all_unidades" value="{{ $value->id }}">
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
                                                            <div class="card-header" id="heading">
                                                                <div class="card-title collapsed" data-toggle="collapse" data-target="#accordionasignacionunid">
                                                                    <i class="flaticon2-document"></i>Asignación de unidades
                                                                </div>
                                                            </div>
                                                            <div id="accordionasignacionunid" class="collapse" data-parent="#accordionAdmonContratos">
                                                                <div class="card-body">

                                                                    <div class="form-group row">
                                                                        <div class="col-9">
                                                                            <div class="checkbox-inline">
                                                                                <label class="checkbox mb-2">
                                                                                <input type="checkbox" id='all_asignacionunid'>
                                                                                <span></span>Seleccionar todos</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group row">
                                                                    </div>

                                                                    @foreach($asignacionunidades as $value)
                                                                    <div class="row mt-2">
                                                                        <div class="col-md-8">
                                                                            <label>{{ $value->guard_names }}</label>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <span class="switch switch-icon">
                                                                                <label>
                                                                                    <input type="checkbox" {{(in_array($value->id , $permiso_roles_id)) ? 'checked' : ''}} name="permission[]" class="asignacionunid_check all_unidades" value="{{ $value->id }}">
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
                                                            <div class="card-header" id="heading">
                                                                <div class="card-title collapsed" data-toggle="collapse" data-target="#accordionrequnidasig">
                                                                    <i class="flaticon2-document"></i>Requisiciones
                                                                </div>
                                                            </div>
                                                            <div id="accordionrequnidasig" class="collapse" data-parent="#accordionAdmonContratos">
                                                                <div class="card-body">

                                                                    <div class="form-group row">
                                                                        <div class="col-9">
                                                                            <div class="checkbox-inline">
                                                                                <label class="checkbox mb-2">
                                                                                <input type="checkbox" id='all_requnidasig'>
                                                                                <span></span>Seleccionar todos</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group row">
                                                                    </div>

                                                                    @foreach($unid_req_asignacion as $value)
                                                                    <div class="row mt-2">
                                                                        <div class="col-md-8">
                                                                            <label>{{ $value->guard_names }}</label>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <span class="switch switch-icon">
                                                                                <label>
                                                                                    <input type="checkbox" {{(in_array($value->id , $permiso_roles_id)) ? 'checked' : ''}} name="permission[]" class="requnidasig_check all_unidades" value="{{ $value->id }}">
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
                                                            <div class="card-header" id="heading">
                                                                <div class="card-title collapsed" data-toggle="collapse" data-target="#accordionmantenimiento">
                                                                    <i class="flaticon2-document"></i>Mantenimiento
                                                                </div>
                                                            </div>
                                                            <div id="accordionmantenimiento" class="collapse" data-parent="#accordionAdmonContratos">
                                                                <div class="card-body">

                                                                    <div class="form-group row">
                                                                        <div class="col-9">
                                                                            <div class="checkbox-inline">
                                                                                <label class="checkbox mb-2">
                                                                                <input type="checkbox" id='all_mantenimiento'>
                                                                                <span></span>Seleccionar todos</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group row">
                                                                    </div>

                                                                    @foreach($mantenimientos as $value)
                                                                    <div class="row mt-2">
                                                                        <div class="col-md-8">
                                                                            <label>{{ $value->guard_names }}</label>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <span class="switch switch-icon">
                                                                                <label>
                                                                                    <input type="checkbox" {{(in_array($value->id , $permiso_roles_id)) ? 'checked' : ''}} name="permission[]" class="mantenimiento_check all_unidades" value="{{ $value->id }}">
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
                                                </div>





                                                <div class="tab-pane fade" id="tabCatDirOperaciones" role="tabpanel" aria-labelledby="profile-tab-5">
                                                    <div class="accordion accordion-solid accordion-toggle-plus" id="accordionCatDirOperaciones">

                                                        <div class="card">
                                                            <div class="card-header" id="heading">
                                                                <div class="card-title collapsed" data-toggle="collapse" data-target="#accordionmarca">
                                                                    <i class="flaticon2-document"></i>Marcas
                                                                </div>
                                                            </div>
                                                            <div id="accordionmarca" class="collapse" data-parent="#accordionCatDirOperaciones">
                                                                <div class="card-body">

                                                                    <div class="form-group row">
                                                                        <div class="col-9">
                                                                            <div class="checkbox-inline">
                                                                                <label class="checkbox mb-2">
                                                                                <input type="checkbox" id='all_marca'>
                                                                                <span></span>Seleccionar todos</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group row">
                                                                    </div>

                                                                    @foreach($marcas as $value)
                                                                    <div class="row mt-2">
                                                                        <div class="col-md-8">
                                                                            <label>{{ $value->guard_names }}</label>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <span class="switch switch-icon">
                                                                                <label>
                                                                                    <input type="checkbox" {{(in_array($value->id , $permiso_roles_id)) ? 'checked' : ''}} name="permission[]" class="marca_check all_unidades" value="{{ $value->id }}">
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
                                                            <div class="card-header" id="heading">
                                                                <div class="card-title collapsed" data-toggle="collapse" data-target="#accordionmodelo">
                                                                    <i class="flaticon2-document"></i>Modelo
                                                                </div>
                                                            </div>
                                                            <div id="accordionmodelo" class="collapse" data-parent="#accordionCatDirOperaciones">
                                                                <div class="card-body">

                                                                    <div class="form-group row">
                                                                        <div class="col-9">
                                                                            <div class="checkbox-inline">
                                                                                <label class="checkbox mb-2">
                                                                                <input type="checkbox" id='all_modelo'>
                                                                                <span></span>Seleccionar todos</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group row">
                                                                    </div>

                                                                    @foreach($modelos as $value)
                                                                    <div class="row mt-2">
                                                                        <div class="col-md-8">
                                                                            <label>{{ $value->guard_names }}</label>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <span class="switch switch-icon">
                                                                                <label>
                                                                                    <input type="checkbox" {{(in_array($value->id , $permiso_roles_id)) ? 'checked' : ''}} name="permission[]" class="modelo_check all_unidades" value="{{ $value->id }}">
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
                                                            <div class="card-header" id="heading">
                                                                <div class="card-title collapsed" data-toggle="collapse" data-target="#accordiontipovehiculo">
                                                                    <i class="flaticon2-document"></i>Tipo de vehículo
                                                                </div>
                                                            </div>
                                                            <div id="accordiontipovehiculo" class="collapse" data-parent="#accordionCatDirOperaciones">
                                                                <div class="card-body">

                                                                    <div class="form-group row">
                                                                        <div class="col-9">
                                                                            <div class="checkbox-inline">
                                                                                <label class="checkbox mb-2">
                                                                                <input type="checkbox" id='all_tipovehiculo'>
                                                                                <span></span>Seleccionar todos</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group row">
                                                                    </div>

                                                                    @foreach($tipovehiculo as $value)
                                                                    <div class="row mt-2">
                                                                        <div class="col-md-8">
                                                                            <label>{{ $value->guard_names }}</label>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <span class="switch switch-icon">
                                                                                <label>
                                                                                    <input type="checkbox" {{(in_array($value->id , $permiso_roles_id)) ? 'checked' : ''}} name="permission[]" class="tipovehiculo_check all_unidades" value="{{ $value->id }}">
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
                                                            <div class="card-header" id="heading">
                                                                <div class="card-title collapsed" data-toggle="collapse" data-target="#accordionestatus">
                                                                    <i class="flaticon2-document"></i>Estatus
                                                                </div>
                                                            </div>
                                                            <div id="accordionestatus" class="collapse" data-parent="#accordionCatDirOperaciones">
                                                                <div class="card-body">

                                                                    <div class="form-group row">
                                                                        <div class="col-9">
                                                                            <div class="checkbox-inline">
                                                                                <label class="checkbox mb-2">
                                                                                <input type="checkbox" id='all_estatus'>
                                                                                <span></span>Seleccionar todos</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group row">
                                                                    </div>

                                                                    @foreach($estatus as $value)
                                                                    <div class="row mt-2">
                                                                        <div class="col-md-8">
                                                                            <label>{{ $value->guard_names }}</label>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <span class="switch switch-icon">
                                                                                <label>
                                                                                    <input type="checkbox" {{(in_array($value->id , $permiso_roles_id)) ? 'checked' : ''}} name="permission[]" class="estatus_check all_unidades" value="{{ $value->id }}">
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
                                                            <div class="card-header" id="heading">
                                                                <div class="card-title collapsed" data-toggle="collapse" data-target="#accordionaseguradora">
                                                                    <i class="flaticon2-document"></i>Aseguradoras
                                                                </div>
                                                            </div>
                                                            <div id="accordionaseguradora" class="collapse" data-parent="#accordionCatDirOperaciones">
                                                                <div class="card-body">

                                                                    <div class="form-group row">
                                                                        <div class="col-9">
                                                                            <div class="checkbox-inline">
                                                                                <label class="checkbox mb-2">
                                                                                <input type="checkbox" id='all_aseguradora'>
                                                                                <span></span>Seleccionar todos</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group row">
                                                                    </div>

                                                                    @foreach($aseguradoras as $value)
                                                                    <div class="row mt-2">
                                                                        <div class="col-md-8">
                                                                            <label>{{ $value->guard_names }}</label>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <span class="switch switch-icon">
                                                                                <label>
                                                                                    <input type="checkbox" {{(in_array($value->id , $permiso_roles_id)) ? 'checked' : ''}} name="permission[]" class="aseguradora_check all_unidades" value="{{ $value->id }}">
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
                                                            <div class="card-header" id="heading">
                                                                <div class="card-title collapsed" data-toggle="collapse" data-target="#accordionagencia">
                                                                    <i class="flaticon2-document"></i>Agencias de vehículos
                                                                </div>
                                                            </div>
                                                            <div id="accordionagencia" class="collapse" data-parent="#accordionCatDirOperaciones">
                                                                <div class="card-body">

                                                                    <div class="form-group row">
                                                                        <div class="col-9">
                                                                            <div class="checkbox-inline">
                                                                                <label class="checkbox mb-2">
                                                                                <input type="checkbox" id='all_agencia'>
                                                                                <span></span>Seleccionar todos</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group row">
                                                                    </div>

                                                                    @foreach($agencia as $value)
                                                                    <div class="row mt-2">
                                                                        <div class="col-md-8">
                                                                            <label>{{ $value->guard_names }}</label>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <span class="switch switch-icon">
                                                                                <label>
                                                                                    <input type="checkbox" {{(in_array($value->id , $permiso_roles_id)) ? 'checked' : ''}} name="permission[]" class="agencia_check all_unidades" value="{{ $value->id }}">
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
                                                            <div class="card-header" id="heading">
                                                                <div class="card-title collapsed" data-toggle="collapse" data-target="#accordiondocumento">
                                                                    <i class="flaticon2-document"></i>Tipo de documento
                                                                </div>
                                                            </div>
                                                            <div id="accordiondocumento" class="collapse" data-parent="#accordionCatDirOperaciones">
                                                                <div class="card-body">

                                                                    <div class="form-group row">
                                                                        <div class="col-9">
                                                                            <div class="checkbox-inline">
                                                                                <label class="checkbox mb-2">
                                                                                <input type="checkbox" id='all_documento'>
                                                                                <span></span>Seleccionar todos</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group row">
                                                                    </div>

                                                                    @foreach($tipo_documento as $value)
                                                                    <div class="row mt-2">
                                                                        <div class="col-md-8">
                                                                            <label>{{ $value->guard_names }}</label>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <span class="switch switch-icon">
                                                                                <label>
                                                                                    <input type="checkbox" {{(in_array($value->id , $permiso_roles_id)) ? 'checked' : ''}} name="permission[]" class="documento_check all_unidades" value="{{ $value->id }}">
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
                                                            <div class="card-header" id="heading">
                                                                <div class="card-title collapsed" data-toggle="collapse" data-target="#accordionasignacion">
                                                                    <i class="flaticon2-document"></i>Tipo de asignación
                                                                </div>
                                                            </div>
                                                            <div id="accordionasignacion" class="collapse" data-parent="#accordionCatDirOperaciones">
                                                                <div class="card-body">

                                                                    <div class="form-group row">
                                                                        <div class="col-9">
                                                                            <div class="checkbox-inline">
                                                                                <label class="checkbox mb-2">
                                                                                <input type="checkbox" id='all_asignacion'>
                                                                                <span></span>Seleccionar todos</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group row">
                                                                    </div>

                                                                    @foreach($tipo_asignacion as $value)
                                                                    <div class="row mt-2">
                                                                        <div class="col-md-8">
                                                                            <label>{{ $value->guard_names }}</label>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <span class="switch switch-icon">
                                                                                <label>
                                                                                    <input type="checkbox" {{(in_array($value->id , $permiso_roles_id)) ? 'checked' : ''}} name="permission[]" class="asignacion_check all_unidades" value="{{ $value->id }}">
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
                                                            <div class="card-header" id="heading">
                                                                <div class="card-title collapsed" data-toggle="collapse" data-target="#accordioninfopropietario">
                                                                    <i class="flaticon2-document"></i>Información del propietario
                                                                </div>
                                                            </div>
                                                            <div id="accordioninfopropietario" class="collapse" data-parent="#accordionCatDirOperaciones">
                                                                <div class="card-body">

                                                                    <div class="form-group row">
                                                                        <div class="col-9">
                                                                            <div class="checkbox-inline">
                                                                                <label class="checkbox mb-2">
                                                                                <input type="checkbox" id='all_infopropietario'>
                                                                                <span></span>Seleccionar todos</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group row">
                                                                    </div>

                                                                    @foreach($info_propietario as $value)
                                                                    <div class="row mt-2">
                                                                        <div class="col-md-8">
                                                                            <label>{{ $value->guard_names }}</label>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <span class="switch switch-icon">
                                                                                <label>
                                                                                    <input type="checkbox" {{(in_array($value->id , $permiso_roles_id)) ? 'checked' : ''}} name="permission[]" class="infopropietario_check all_unidades" value="{{ $value->id }}">
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
                                                            <div class="card-header" id="heading">
                                                                <div class="card-title collapsed" data-toggle="collapse" data-target="#accordiontraemplacamiento">
                                                                    <i class="flaticon2-document"></i>Tramite emplacamiento
                                                                </div>
                                                            </div>
                                                            <div id="accordiontraemplacamiento" class="collapse" data-parent="#accordionCatDirOperaciones">
                                                                <div class="card-body">

                                                                    <div class="form-group row">
                                                                        <div class="col-9">
                                                                            <div class="checkbox-inline">
                                                                                <label class="checkbox mb-2">
                                                                                <input type="checkbox" id='all_traemplacamiento'>
                                                                                <span></span>Seleccionar todos</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group row">
                                                                    </div>

                                                                    @foreach($tramite_emplacamiento as $value)
                                                                    <div class="row mt-2">
                                                                        <div class="col-md-8">
                                                                            <label>{{ $value->guard_names }}</label>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <span class="switch switch-icon">
                                                                                <label>
                                                                                    <input type="checkbox" {{(in_array($value->id , $permiso_roles_id)) ? 'checked' : ''}} name="permission[]" class="traemplacamiento_check all_unidades" value="{{ $value->id }}">
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
                                                            <div class="card-header" id="heading">
                                                                <div class="card-title collapsed" data-toggle="collapse" data-target="#accordiontratenencia">
                                                                    <i class="flaticon2-document"></i>Tramite tenencia
                                                                </div>
                                                            </div>
                                                            <div id="accordiontratenencia" class="collapse" data-parent="#accordionCatDirOperaciones">
                                                                <div class="card-body">

                                                                    <div class="form-group row">
                                                                        <div class="col-9">
                                                                            <div class="checkbox-inline">
                                                                                <label class="checkbox mb-2">
                                                                                <input type="checkbox" id='all_tratenencia'>
                                                                                <span></span>Seleccionar todos</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group row">
                                                                    </div>

                                                                    @foreach($tramite_tenencia as $value)
                                                                    <div class="row mt-2">
                                                                        <div class="col-md-8">
                                                                            <label>{{ $value->guard_names }}</label>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <span class="switch switch-icon">
                                                                                <label>
                                                                                    <input type="checkbox" {{(in_array($value->id , $permiso_roles_id)) ? 'checked' : ''}} name="permission[]" class="tratenencia_check all_unidades" value="{{ $value->id }}">
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
                                                            <div class="card-header" id="heading">
                                                                <div class="card-title collapsed" data-toggle="collapse" data-target="#accordiontraverificacion">
                                                                    <i class="flaticon2-document"></i>Tramite verificación
                                                                </div>
                                                            </div>
                                                            <div id="accordiontraverificacion" class="collapse" data-parent="#accordionCatDirOperaciones">
                                                                <div class="card-body">

                                                                    <div class="form-group row">
                                                                        <div class="col-9">
                                                                            <div class="checkbox-inline">
                                                                                <label class="checkbox mb-2">
                                                                                <input type="checkbox" id='all_traverificacion'>
                                                                                <span></span>Seleccionar todos</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group row">
                                                                    </div>

                                                                    @foreach($tramite_verificacion as $value)
                                                                    <div class="row mt-2">
                                                                        <div class="col-md-8">
                                                                            <label>{{ $value->guard_names }}</label>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <span class="switch switch-icon">
                                                                                <label>
                                                                                    <input type="checkbox" {{(in_array($value->id , $permiso_roles_id)) ? 'checked' : ''}} name="permission[]" class="traverificacion_check all_unidades" value="{{ $value->id }}">
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
                                                            <div class="card-header" id="heading">
                                                                <div class="card-title collapsed" data-toggle="collapse" data-target="#accordiontrareemplacamiento">
                                                                    <i class="flaticon2-document"></i>Tramite reemplacamiento
                                                                </div>
                                                            </div>
                                                            <div id="accordiontrareemplacamiento" class="collapse" data-parent="#accordionCatDirOperaciones">
                                                                <div class="card-body">

                                                                    <div class="form-group row">
                                                                        <div class="col-9">
                                                                            <div class="checkbox-inline">
                                                                                <label class="checkbox mb-2">
                                                                                <input type="checkbox" id='all_trareemplacamiento'>
                                                                                <span></span>Seleccionar todos</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group row">
                                                                    </div>

                                                                    @foreach($tramite_reemplacamiento as $value)
                                                                    <div class="row mt-2">
                                                                        <div class="col-md-8">
                                                                            <label>{{ $value->guard_names }}</label>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <span class="switch switch-icon">
                                                                                <label>
                                                                                    <input type="checkbox" {{(in_array($value->id , $permiso_roles_id)) ? 'checked' : ''}} name="permission[]" class="trareemplacamiento_check all_unidades" value="{{ $value->id }}">
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
                                                            <div class="card-header" id="heading">
                                                                <div class="card-title collapsed" data-toggle="collapse" data-target="#accordiontracambpropietario">
                                                                    <i class="flaticon2-document"></i>Tramite cambio de propietario
                                                                </div>
                                                            </div>
                                                            <div id="accordiontracambpropietario" class="collapse" data-parent="#accordionCatDirOperaciones">
                                                                <div class="card-body">

                                                                    <div class="form-group row">
                                                                        <div class="col-9">
                                                                            <div class="checkbox-inline">
                                                                                <label class="checkbox mb-2">
                                                                                <input type="checkbox" id='all_tracambpropietario'>
                                                                                <span></span>Seleccionar todos</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group row">
                                                                    </div>

                                                                    @foreach($tramite_cambiopropietario as $value)
                                                                    <div class="row mt-2">
                                                                        <div class="col-md-8">
                                                                            <label>{{ $value->guard_names }}</label>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <span class="switch switch-icon">
                                                                                <label>
                                                                                    <input type="checkbox" {{(in_array($value->id , $permiso_roles_id)) ? 'checked' : ''}} name="permission[]" class="tracambpropietario_check all_unidades" value="{{ $value->id }}">
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
                                                            <div class="card-header" id="heading">
                                                                <div class="card-title collapsed" data-toggle="collapse" data-target="#accordiontraaseguramiento">
                                                                    <i class="flaticon2-document"></i>Tramite aseguramiento
                                                                </div>
                                                            </div>
                                                            <div id="accordiontraaseguramiento" class="collapse" data-parent="#accordionCatDirOperaciones">
                                                                <div class="card-body">

                                                                    <div class="form-group row">
                                                                        <div class="col-9">
                                                                            <div class="checkbox-inline">
                                                                                <label class="checkbox mb-2">
                                                                                <input type="checkbox" id='all_traaseguramiento'>
                                                                                <span></span>Seleccionar todos</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group row">
                                                                    </div>

                                                                    @foreach($tramite_aseguramiento as $value)
                                                                    <div class="row mt-2">
                                                                        <div class="col-md-8">
                                                                            <label>{{ $value->guard_names }}</label>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <span class="switch switch-icon">
                                                                                <label>
                                                                                    <input type="checkbox" {{(in_array($value->id , $permiso_roles_id)) ? 'checked' : ''}} name="permission[]" class="traaseguramiento_check all_unidades" value="{{ $value->id }}">
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
                                                            <div class="card-header" id="heading">
                                                                <div class="card-title collapsed" data-toggle="collapse" data-target="#accordiontrabvventa">
                                                                    <i class="flaticon2-document"></i>Tramite baja de vehículo (venta)
                                                                </div>
                                                            </div>
                                                            <div id="accordiontrabvventa" class="collapse" data-parent="#accordionCatDirOperaciones">
                                                                <div class="card-body">

                                                                    <div class="form-group row">
                                                                        <div class="col-9">
                                                                            <div class="checkbox-inline">
                                                                                <label class="checkbox mb-2">
                                                                                <input type="checkbox" id='all_trabvventa'>
                                                                                <span></span>Seleccionar todos</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group row">
                                                                    </div>

                                                                    @foreach($tramite_bv_venta as $value)
                                                                    <div class="row mt-2">
                                                                        <div class="col-md-8">
                                                                            <label>{{ $value->guard_names }}</label>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <span class="switch switch-icon">
                                                                                <label>
                                                                                    <input type="checkbox" {{(in_array($value->id , $permiso_roles_id)) ? 'checked' : ''}} name="permission[]" class="trabvventa_check all_unidades" value="{{ $value->id }}">
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
                                                            <div class="card-header" id="heading">
                                                                <div class="card-title collapsed" data-toggle="collapse" data-target="#accordiontrabvrobo">
                                                                    <i class="flaticon2-document"></i>Tramite baja de vehículo (robo)
                                                                </div>
                                                            </div>
                                                            <div id="accordiontrabvrobo" class="collapse" data-parent="#accordionCatDirOperaciones">
                                                                <div class="card-body">

                                                                    <div class="form-group row">
                                                                        <div class="col-9">
                                                                            <div class="checkbox-inline">
                                                                                <label class="checkbox mb-2">
                                                                                <input type="checkbox" id='all_trabvrobo'>
                                                                                <span></span>Seleccionar todos</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group row">
                                                                    </div>

                                                                    @foreach($tramite_bv_robo as $value)
                                                                    <div class="row mt-2">
                                                                        <div class="col-md-8">
                                                                            <label>{{ $value->guard_names }}</label>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <span class="switch switch-icon">
                                                                                <label>
                                                                                    <input type="checkbox" {{(in_array($value->id , $permiso_roles_id)) ? 'checked' : ''}} name="permission[]" class="trabvrobo_check all_unidades" value="{{ $value->id }}">
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
                                                            <div class="card-header" id="heading">
                                                                <div class="card-title collapsed" data-toggle="collapse" data-target="#accordiontrabvsiniestro">
                                                                    <i class="flaticon2-document"></i>Tramite baja de vehículo (siniestro)
                                                                </div>
                                                            </div>
                                                            <div id="accordiontrabvsiniestro" class="collapse" data-parent="#accordionCatDirOperaciones">
                                                                <div class="card-body">

                                                                    <div class="form-group row">
                                                                        <div class="col-9">
                                                                            <div class="checkbox-inline">
                                                                                <label class="checkbox mb-2">
                                                                                <input type="checkbox" id='all_trabvsiniestro'>
                                                                                <span></span>Seleccionar todos</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group row">
                                                                    </div>

                                                                    @foreach($tramite_bv_siniestro as $value)
                                                                    <div class="row mt-2">
                                                                        <div class="col-md-8">
                                                                            <label>{{ $value->guard_names }}</label>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <span class="switch switch-icon">
                                                                                <label>
                                                                                    <input type="checkbox" {{(in_array($value->id , $permiso_roles_id)) ? 'checked' : ''}} name="permission[]" class="trabvsiniestro_check all_unidades" value="{{ $value->id }}">
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
                                                            <div class="card-header" id="heading">
                                                                <div class="card-title collapsed" data-toggle="collapse" data-target="#accordiontragps">
                                                                    <i class="flaticon2-document"></i>Tramite gps
                                                                </div>
                                                            </div>
                                                            <div id="accordiontragps" class="collapse" data-parent="#accordionCatDirOperaciones">
                                                                <div class="card-body">

                                                                    <div class="form-group row">
                                                                        <div class="col-9">
                                                                            <div class="checkbox-inline">
                                                                                <label class="checkbox mb-2">
                                                                                <input type="checkbox" id='all_tragps'>
                                                                                <span></span>Seleccionar todos</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group row">
                                                                    </div>

                                                                    @foreach($tramite_gps as $value)
                                                                    <div class="row mt-2">
                                                                        <div class="col-md-8">
                                                                            <label>{{ $value->guard_names }}</label>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <span class="switch switch-icon">
                                                                                <label>
                                                                                    <input type="checkbox" {{(in_array($value->id , $permiso_roles_id)) ? 'checked' : ''}} name="permission[]" class="tragps_check all_unidades" value="{{ $value->id }}">
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
                                                            <div class="card-header" id="heading">
                                                                <div class="card-title collapsed" data-toggle="collapse" data-target="#accordionestsiniestro">
                                                                    <i class="flaticon2-document"></i>Estatus del siniestro
                                                                </div>
                                                            </div>
                                                            <div id="accordionestsiniestro" class="collapse" data-parent="#accordionCatDirOperaciones">
                                                                <div class="card-body">

                                                                    <div class="form-group row">
                                                                        <div class="col-9">
                                                                            <div class="checkbox-inline">
                                                                                <label class="checkbox mb-2">
                                                                                <input type="checkbox" id='all_estsiniestro'>
                                                                                <span></span>Seleccionar todos</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group row">
                                                                    </div>

                                                                    @foreach($estatus_siniestro as $value)
                                                                    <div class="row mt-2">
                                                                        <div class="col-md-8">
                                                                            <label>{{ $value->guard_names }}</label>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <span class="switch switch-icon">
                                                                                <label>
                                                                                    <input type="checkbox" {{(in_array($value->id , $permiso_roles_id)) ? 'checked' : ''}} name="permission[]" class="estsiniestro_check all_unidades" value="{{ $value->id }}">
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
                                                            <div class="card-header" id="heading">
                                                                <div class="card-title collapsed" data-toggle="collapse" data-target="#accordionmansolicitud">
                                                                    <i class="flaticon2-document"></i>Mantenimiento talleres
                                                                </div>
                                                            </div>
                                                            <div id="accordionmansolicitud" class="collapse" data-parent="#accordionCatDirOperaciones">
                                                                <div class="card-body">

                                                                    <div class="form-group row">
                                                                        <div class="col-9">
                                                                            <div class="checkbox-inline">
                                                                                <label class="checkbox mb-2">
                                                                                <input type="checkbox" id='all_mansolicitud'>
                                                                                <span></span>Seleccionar todos</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group row">
                                                                    </div>

                                                                    @foreach($mantenimiento_solicitud as $value)
                                                                    <div class="row mt-2">
                                                                        <div class="col-md-8">
                                                                            <label>{{ $value->guard_names }}</label>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <span class="switch switch-icon">
                                                                                <label>
                                                                                    <input type="checkbox" {{(in_array($value->id , $permiso_roles_id)) ? 'checked' : ''}} name="permission[]" class="mansolicitud_check all_unidades" value="{{ $value->id }}">
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
                                                            <div class="card-header" id="heading">
                                                                <div class="card-title collapsed" data-toggle="collapse" data-target="#accordionsermantenimiento">
                                                                    <i class="flaticon2-document"></i>Servicios de talleres
                                                                </div>
                                                            </div>
                                                            <div id="accordionsermantenimiento" class="collapse" data-parent="#accordionCatDirOperaciones">
                                                                <div class="card-body">

                                                                    <div class="form-group row">
                                                                        <div class="col-9">
                                                                            <div class="checkbox-inline">
                                                                                <label class="checkbox mb-2">
                                                                                <input type="checkbox" id='all_sermantenimiento'>
                                                                                <span></span>Seleccionar todos</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group row">
                                                                    </div>

                                                                    @foreach($servicios_talleres as $value)
                                                                    <div class="row mt-2">
                                                                        <div class="col-md-8">
                                                                            <label>{{ $value->guard_names }}</label>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <span class="switch switch-icon">
                                                                                <label>
                                                                                    <input type="checkbox" {{(in_array($value->id , $permiso_roles_id)) ? 'checked' : ''}} name="permission[]" class="sermantenimiento_check all_unidades" value="{{ $value->id }}">
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
                                                            <div class="card-header" id="heading">
                                                                <div class="card-title collapsed" data-toggle="collapse" data-target="#accordiontipdoctaller">
                                                                    <i class="flaticon2-document"></i>Tipo de documentos del taller
                                                                </div>
                                                            </div>
                                                            <div id="accordiontipdoctaller" class="collapse" data-parent="#accordionCatDirOperaciones">
                                                                <div class="card-body">

                                                                    <div class="form-group row">
                                                                        <div class="col-9">
                                                                            <div class="checkbox-inline">
                                                                                <label class="checkbox mb-2">
                                                                                <input type="checkbox" id='all_tipdoctaller'>
                                                                                <span></span>Seleccionar todos</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group row">
                                                                    </div>

                                                                    @foreach($tip_documento_talleres as $value)
                                                                    <div class="row mt-2">
                                                                        <div class="col-md-8">
                                                                            <label>{{ $value->guard_names }}</label>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <span class="switch switch-icon">
                                                                                <label>
                                                                                    <input type="checkbox" {{(in_array($value->id , $permiso_roles_id)) ? 'checked' : ''}} name="permission[]" class="tipdoctaller_check all_unidades" value="{{ $value->id }}">
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
                                                </div>





                                                <div class="tab-pane fade" id="tabDirFinanzas" role="tabpanel" aria-labelledby="profile-tab-5">
                                                    <div class="accordion accordion-solid accordion-toggle-plus" id="accordionDirFinanzas">

                                                        <div class="card">
                                                            <div class="card-header" id="heading">
                                                                <div class="card-title collapsed" data-toggle="collapse" data-target="#accordionfinanzas">
                                                                    <i class="flaticon2-document"></i>Administración de operaciones
                                                                </div>
                                                            </div>
                                                            <div id="accordionfinanzas" class="collapse" data-parent="#accordionDirFinanzas">
                                                                <div class="card-body">

                                                                    <div class="form-group row">
                                                                        <div class="col-9">
                                                                            <div class="checkbox-inline">
                                                                                <label class="checkbox mb-2">
                                                                                <input type="checkbox" id='all_finanzas'>
                                                                                <span></span>Seleccionar todos</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group row">
                                                                    </div>

                                                                    @foreach($admin_finanzas as $value)
                                                                    <div class="row mt-2">
                                                                        <div class="col-md-8">
                                                                            <label>{{ $value->guard_names }}</label>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <span class="switch switch-icon">
                                                                                <label>
                                                                                    <input type="checkbox" {{(in_array($value->id , $permiso_roles_id)) ? 'checked' : ''}} name="permission[]" class="finanzas_check all_finanzas" value="{{ $value->id }}">
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
                                                            <div class="card-header" id="heading">
                                                                <div class="card-title collapsed" data-toggle="collapse" data-target="#accordionordencompra">
                                                                    <i class="flaticon2-document"></i>Orden de compra
                                                                </div>
                                                            </div>
                                                            <div id="accordionordencompra" class="collapse" data-parent="#accordionDirFinanzas">
                                                                <div class="card-body">

                                                                    <div class="form-group row">
                                                                        <div class="col-9">
                                                                            <div class="checkbox-inline">
                                                                                <label class="checkbox mb-2">
                                                                                <input type="checkbox" id='all_ordencompra'>
                                                                                <span></span>Seleccionar todos</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group row">
                                                                    </div>

                                                                    @foreach($orden_compra as $value)
                                                                    <div class="row mt-2">
                                                                        <div class="col-md-8">
                                                                            <label>{{ $value->guard_names }}</label>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <span class="switch switch-icon">
                                                                                <label>
                                                                                    <input type="checkbox" {{(in_array($value->id , $permiso_roles_id)) ? 'checked' : ''}} name="permission[]" class="ordencompra_check all_ordencompra" value="{{ $value->id }}">
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
                                                            <div class="card-header" id="heading">
                                                                <div class="card-title collapsed" data-toggle="collapse" data-target="#accordionestimacionfin">
                                                                    <i class="flaticon2-document"></i>Estimaciones
                                                                </div>
                                                            </div>
                                                            <div id="accordionestimacionfin" class="collapse" data-parent="#accordionDirFinanzas">
                                                                <div class="card-body">

                                                                    <div class="form-group row">
                                                                        <div class="col-9">
                                                                            <div class="checkbox-inline">
                                                                                <label class="checkbox mb-2">
                                                                                <input type="checkbox" id='all_estimacionfin'>
                                                                                <span></span>Seleccionar todos</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group row">
                                                                    </div>

                                                                    @foreach($estimaciones_fin as $value)
                                                                    <div class="row mt-2">
                                                                        <div class="col-md-8">
                                                                            <label>{{ $value->guard_names }}</label>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <span class="switch switch-icon">
                                                                                <label>
                                                                                    <input type="checkbox" {{(in_array($value->id , $permiso_roles_id)) ? 'checked' : ''}} name="permission[]" class="estimacionfin_check all_estimacionfin" value="{{ $value->id }}">
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
                                                </div>



                                                <div class="tab-pane fade" id="tabCatDirFinanzas" role="tabpanel" aria-labelledby="profile-tab-5">
                                                    <div class="accordion accordion-solid accordion-toggle-plus" id="accordionCatDirFinanzas">

                                                        <div class="card">
                                                            <div class="card-header" id="heading">
                                                                <div class="card-title collapsed" data-toggle="collapse" data-target="#accordiondoccompra">
                                                                    <i class="flaticon2-document"></i>Documentos de compras
                                                                </div>
                                                            </div>
                                                            <div id="accordiondoccompra" class="collapse" data-parent="#accordionCatDirFinanzas">
                                                                <div class="card-body">

                                                                    <div class="form-group row">
                                                                        <div class="col-9">
                                                                            <div class="checkbox-inline">
                                                                                <label class="checkbox mb-2">
                                                                                <input type="checkbox" id='all_doccompra'>
                                                                                <span></span>Seleccionar todos</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group row">
                                                                    </div>

                                                                    @foreach($doc_compra as $value)
                                                                    <div class="row mt-2">
                                                                        <div class="col-md-8">
                                                                            <label>{{ $value->guard_names }}</label>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <span class="switch switch-icon">
                                                                                <label>
                                                                                    <input type="checkbox" {{(in_array($value->id , $permiso_roles_id)) ? 'checked' : ''}} name="permission[]" class="doccompra_check all_ordencompra" value="{{ $value->id }}">
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
                                                            <div class="card-header" id="heading">
                                                                <div class="card-title collapsed" data-toggle="collapse" data-target="#accordionprovecompra">
                                                                    <i class="flaticon2-document"></i>Proveedores
                                                                </div>
                                                            </div>
                                                            <div id="accordionprovecompra" class="collapse" data-parent="#accordionCatDirFinanzas">
                                                                <div class="card-body">

                                                                    <div class="form-group row">
                                                                        <div class="col-9">
                                                                            <div class="checkbox-inline">
                                                                                <label class="checkbox mb-2">
                                                                                <input type="checkbox" id='all_provecompra'>
                                                                                <span></span>Seleccionar todos</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group row">
                                                                    </div>

                                                                    @foreach($proveedor_compra as $value)
                                                                    <div class="row mt-2">
                                                                        <div class="col-md-8">
                                                                            <label>{{ $value->guard_names }}</label>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <span class="switch switch-icon">
                                                                                <label>
                                                                                    <input type="checkbox" {{(in_array($value->id , $permiso_roles_id)) ? 'checked' : ''}} name="permission[]" class="provecompra_check all_ordencompra" value="{{ $value->id }}">
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
                                                            <div class="card-header" id="heading">
                                                                <div class="card-title collapsed" data-toggle="collapse" data-target="#accordionmepago">
                                                                    <i class="flaticon2-document"></i>Métodos de pago
                                                                </div>
                                                            </div>
                                                            <div id="accordionmepago" class="collapse" data-parent="#accordionCatDirFinanzas">
                                                                <div class="card-body">

                                                                    <div class="form-group row">
                                                                        <div class="col-9">
                                                                            <div class="checkbox-inline">
                                                                                <label class="checkbox mb-2">
                                                                                <input type="checkbox" id='all_mepago'>
                                                                                <span></span>Seleccionar todos</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group row">
                                                                    </div>

                                                                    @foreach($metodo_pago as $value)
                                                                    <div class="row mt-2">
                                                                        <div class="col-md-8">
                                                                            <label>{{ $value->guard_names }}</label>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <span class="switch switch-icon">
                                                                                <label>
                                                                                    <input type="checkbox" {{(in_array($value->id , $permiso_roles_id)) ? 'checked' : ''}} name="permission[]" class="mepago_check all_ordencompra" value="{{ $value->id }}">
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
                                                            <div class="card-header" id="heading">
                                                                <div class="card-title collapsed" data-toggle="collapse" data-target="#accordionformpago">
                                                                    <i class="flaticon2-document"></i>Formas de pago
                                                                </div>
                                                            </div>
                                                            <div id="accordionformpago" class="collapse" data-parent="#accordionCatDirFinanzas">
                                                                <div class="card-body">

                                                                    <div class="form-group row">
                                                                        <div class="col-9">
                                                                            <div class="checkbox-inline">
                                                                                <label class="checkbox mb-2">
                                                                                <input type="checkbox" id='all_formpago'>
                                                                                <span></span>Seleccionar todos</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group row">
                                                                    </div>

                                                                    @foreach($forma_pago as $value)
                                                                    <div class="row mt-2">
                                                                        <div class="col-md-8">
                                                                            <label>{{ $value->guard_names }}</label>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <span class="switch switch-icon">
                                                                                <label>
                                                                                    <input type="checkbox" {{(in_array($value->id , $permiso_roles_id)) ? 'checked' : ''}} name="permission[]" class="formpago_check all_ordencompra" value="{{ $value->id }}">
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
                                                            <div class="card-header" id="heading">
                                                                <div class="card-title collapsed" data-toggle="collapse" data-target="#accordionusocfdi">
                                                                    <i class="flaticon2-document"></i>Uso de CFDI
                                                                </div>
                                                            </div>
                                                            <div id="accordionusocfdi" class="collapse" data-parent="#accordionCatDirFinanzas">
                                                                <div class="card-body">

                                                                    <div class="form-group row">
                                                                        <div class="col-9">
                                                                            <div class="checkbox-inline">
                                                                                <label class="checkbox mb-2">
                                                                                <input type="checkbox" id='all_usocfdi'>
                                                                                <span></span>Seleccionar todos</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group row">
                                                                    </div>

                                                                    @foreach($uso_cdfi as $value)
                                                                    <div class="row mt-2">
                                                                        <div class="col-md-8">
                                                                            <label>{{ $value->guard_names }}</label>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <span class="switch switch-icon">
                                                                                <label>
                                                                                    <input type="checkbox" {{(in_array($value->id , $permiso_roles_id)) ? 'checked' : ''}} name="permission[]" class="usocfdi_check all_ordencompra" value="{{ $value->id }}">
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
                                                </div>




                                            </div>
                                        </div>
                                    </div>


                                
                            </div>
                            <div class="card-footer">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <button type="button"  id="btnGuardar" class="btn btn-success"><i class="la la-plus"></i>Guardar</button>
                                            <a href="{{ route('rol.catalogoroles') }}"  class="btn btn-secondary"><i class="la la-arrow-left"></i>Regresar</a>
                                        </div>
                                    </div>
                                </div>
                        </form>
                    </div>
                </div>   
            </div>
        </div>
    </div>
</div>
										 

@endsection
