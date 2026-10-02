@extends('layouts.app')
@section('title')
    Tablero
@endsection
@push('scripts')
	<script src="{{ asset('js/tablero/Notificaciones.js') }}"></script> 
@endpush
@section('content')
@php
@endphp
	@if (Session::has('permisos'))
		@if (in_array("109", Session::get('permisos')))
			<div class="row">
				@if(Auth::user()->tipo_usuario_id != 1 && Auth::user()->tipo_usuario_id != 2)
					<iframe id="zohoAnalitycs"  class="col-12 col-lg-12 col-md-12" frameborder=0 width="900" height="2300" src="https://analytics.zoho.com/open-view/2452363000000006828"></iframe>
				@endif
			</div>
		@endif
	@endif
@endsection




