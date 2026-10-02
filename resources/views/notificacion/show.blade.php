@extends('layouts.app')
@section('title')
    Notificaciones
@endsection
@push('scripts')
	<script src="{{ asset('js/tablero/Notificaciones.js') }}"></script> 
@endpush
@section('content')
@php
@endphp
    <div class="d-flex flex-row">
    <!--begin::List-->
    <div class="flex-row-fluid">
        <div class="d-flex flex-column flex-grow-1">

            <!--begin::Row-->
            <div class="row">
                <div class="col-xl-12">

                <!--begin::Card-->
                    <div class="card card-custom">
                        <div class="card-header">
                            <div class="card-title">
                              <span class="card-icon">
                                <i class="flaticon2-file text-primary"></i>
                              </span>
                              <h3 class="card-label">Notificaciones</h3>
                            </div>
                        </div>
                        <div class="card-body">
                        <ul class="nav nav-tabs nav-tabs-line">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#kt_tab_pane_1">Notificaciones </a>
                            </li>

                        </ul>
                        <div class="tab-content mt-5" id="myTabContent">
                            <div class="tab-pane fade show active mt-10" id="kt_tab_pane_1" role="tabpanel" aria-labelledby="kt_tab_pane_2">
								<div class="py-5">
								 <div class="table-responsive">
								  <table class="table table-row-dashed table-row-gray-300 gy-7" id="kdatatable_notificaciones">
								   <thead>
								    <tr class="fw-bold fs-6 text-gray-800">
								     <th>No.</th>
								     <th>Modulo</th>
								     <th>Notificación</th>
								     <th>Fecha de notificación</th>
								     <th>Modificó</th>
								     <th>Opción</th>
								    </tr>
								   </thead>
								   <tbody>
	                                  @foreach($not as $unid)
                                    <tr>
                                      <td>{{ $unid->id }}</td>
                                      <td>
                                        @if($unid->modulo_id == 1)
                                            <p>Usuarios</p>
                                        @endif
                                        @if($unid->modulo_id == 2)
                                            <p>Concursos</p>
                                        @endif
                                      </td>
                                      <td>{{ $unid->notificacion }}</td>
                                      <td>{{ $unid->fecha_notificacion }}</td>
                                      <td>{{ $unid->usermodifico->name }}</td>

                                      <td class="text-center">

                                        @if($unid->modulo_id == 2)
                                            <a href="{{ route('tablero.vernotconcurso', $unid->licitaciones_id) }}" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon" data-id="{{ $unid->id }}" data-toggle="tooltip" data-theme="dark" title="Ver Notificación" ><i class="flaticon-eye"></i></a>
                                        @endif

                                        
                                      </td>
                                    </tr>
                                  @endforeach
								   </tbody>
								  </table>
								 </div>
								</div>                
                            </div>
                            <div class="tab-pane fade mt-10" id="kt_tab_pane_2" role="tabpanel" aria-labelledby="kt_tab_pane_2">
                                
                            </div>

                        </div>
                    </div>
                    <!--end::Card-->
                    <!--end::Card-->
                </div>
            </div>
            <!--end::Row-->


        </div>
    </div>
    <!--end::List-->
</div>

@endsection




