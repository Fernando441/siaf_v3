@extends('layouts.app')
@push('scripts')
    
    <script type="text/javascript">
	    lightbox.option({
	      'resizeDuration': 200,
	      'wrapAround': true
	    });
    </script>
@endpush

@section('content')

	<style type="text/css">
		.title{
			font-weight: 600;
			font-size: 16px;
		}
	</style>

	<div class="row">
		<div class="col-md-7">
			<div class="card shadow-sm">
				<div class="card-header">
					<h3 class="card-title">Información de la unidad</h3>
					<div class="card-toolbar">
					</div>
				</div>
				<div class="card-body">
					<div class="row">
						@foreach($info_unidad as $info)
							<div class="col-md-6">
								<span class="title">Folio: </span>  <span class="text-info">{{ $info->folio }}</span><br>
								<span class="title">Ubicación: </span> <span class="text-info"> {{ $info->ubicacion }}</span><br>
								<span class="title">Marca: </span><span class="text-info"> {{ $info->nombre_marca }}</span><br>
								<span class="title">Modelo: </span><span class="text-info"> {{ $info->nombre_modelo }}</span><br>
								<span class="title">Año: </span><span class="text-info"> {{ $info->unidad_year }}</span><br>
								<span class="title">Color: </span><span class="text-info"> {{ $info->color }}</span><br>
								<span class="title">Transmisión: </span><span class="text-info"> {{ $info->transmision }}</span><br>
							</div>

							<div class="col-md-6">
								<span class="title">Placa: </span>  <span class="text-info">{{ $info->placa }}</span><br>
								<span class="title">No. Serie: </span> <span class="text-info"> {{ $info->no_serie }}</span><br>
								<span class="title">No. Tarjeta Circulación: </span><span class="text-info"> {{ $info->no_tarjeta_circulacion }}</span><br>
								<span class="title">No. Poliza seguro: </span><span class="text-info"> {{ $info->no_poliza_seguro }}</span><br>
								<span class="title">Aseguradora: </span><span class="text-info"> {{ $info->nombre_aseguradora }}</span><br>
								<span class="title">Fecha vencimiento poliza: </span>
								<span class="text-info"> 
									@if ($info->fecha_vencimiento_poliza == null)
										ND
									@else
										{{ $info->nombre_aseguradora }}
									@endif
								</span><br>
							</div>

						@endforeach
					</div>

				</div>
			</div>
		</div>
		<div class="col-md-5">
			<div class="card shadow-sm">
{{-- 				<div class="card-header">
					<h3 class="card-title"></h3>
			        <div class="card-toolbar">
			          <a href="{{ route('unidad.catalogounidad') }}" class="btn btn-warning">Regresar</a>
			        </div>
				</div> --}}
				<div class="card-body text-center">
					<div id="kt_carousel_1_carousel" class="carousel carousel-custom slide" data-bs-ride="carousel" data-bs-interval="8000">
					    <!--begin::Heading-->
					    <div class="d-flex align-items-center justify-content-between flex-wrap">
					        <!--begin::Label-->
					        <!--end::Label-->

					        <!--begin::Carousel Indicators-->
					        <ol class="p-0 m-0 carousel-indicators carousel-indicators-dots">
					            <li data-bs-target="#kt_carousel_1_carousel" data-bs-slide-to="0" class="ms-1 active"></li>
					            <li data-bs-target="#kt_carousel_1_carousel" data-bs-slide-to="1" class="ms-1"></li>
					            <li data-bs-target="#kt_carousel_1_carousel" data-bs-slide-to="2" class="ms-1"></li>
					        </ol>
					        <!--end::Carousel Indicators-->
					    </div>
					    <!--end::Heading-->

					    <!--begin::Carousel-->
					    <div class="carousel-inner pt-8">
					        <!--begin::Item-->
					        <div class="carousel-item active">
					            <a class="example-image-link" href="/img/frontier-2022-2.jpg" data-lightbox="example-1"><img class="example-image oculto" src="/img/frontier-2022-2.jpg" id="camara_div" alt="image-1"  width="240" /></a>
					        </div>
					        <!--end::Item-->

					        <!--begin::Item-->
					        <div class="carousel-item">
					            <a class="example-image-link" href="/img/frontier-2022-2.jpg" data-lightbox="example-1"><img class="example-image oculto" src="/img/frontier-2022-2.jpg" id="camara_div" alt="image-1"  width="240" /></a>
					        </div>
					        <!--end::Item-->

					        <!--begin::Item-->
					        <div class="carousel-item">
					            <a class="example-image-link" href="/img/frontier-2022-2.jpg" data-lightbox="example-1"><img class="example-image oculto" src="/img/frontier-2022-2.jpg" id="camara_div" alt="image-1"  width="240" /></a>
					        </div>
					        <!--end::Item-->
					    </div>
					    <!--end::Carousel-->
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		
	</div>

@endsection