@extends('layouts.app')
@push('scripts')
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.js"></script>

<script type="text/javascript">
    var enero = 5;
    var febrero = 15;
    var marzo = 20;
    var abril = 5;
    var mayo = 7;
    var junio = 12;
    var julio = 10;

    var ctx = document.getElementById('myChartpedidos').getContext('2d');
    var myChartpedidos = new Chart(ctx, {
        type: 'bar',
        data: {
            labels:['NISSAN','VOLKSWAGEN','DODGE','KIA','TOYOTA','CHEVROLET','RENAULT'],
            datasets: [{
                label: 'Marca',
                data: [enero, febrero, marzo, abril, mayo, junio, julio],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)',
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(160, 255, 97, 0.2)',
                    'rgba(229, 97, 255, 0.2)',
                    'rgba(209, 230, 121, 0.2)',
                    'rgba(138, 115, 25, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)',
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(160, 255, 97, 1)',
                    'rgba(229, 97, 255, 1)',
                    'rgba(209, 230, 121, 1)',
                    'rgba(138, 115, 25, 1)'

                ],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)',
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(160, 255, 97, 0.2)',
                    'rgba(229, 97, 255, 0.2)',
                    'rgba(209, 230, 121, 0.2)',
                    'rgba(138, 115, 25, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)',
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(160, 255, 97, 1)',
                    'rgba(229, 97, 255, 1)',
                    'rgba(209, 230, 121, 1)',
                    'rgba(138, 115, 25, 1)'
                ],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)',
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(160, 255, 97, 0.2)',
                    'rgba(209, 230, 121, 0.2)',
                    'rgba(138, 115, 25, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)',
                    'rgba(255, 159, 64, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(160, 255, 97, 1)',
                    'rgba(229, 97, 255, 1)',
                    'rgba(209, 230, 121, 1)',
                    'rgba(138, 115, 25, 1)'
                ],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)',
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(160, 255, 97, 0.2)',
                    'rgba(229, 97, 255, 0.2)',
                    'rgba(209, 230, 121, 0.2)',
                    'rgba(138, 115, 25, 0.2)'
                ],
                borderWidth: 2
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });
</script>


<script type="text/javascript">
    var enero = 25;
    var febrero = 45;

    var ctx = document.getElementById('myChartpedidosu').getContext('2d');
    var myChartpedidos = new Chart(ctx, {
        type: 'polarArea',
        data: {
            labels:['EN PATIO','VENTA/RENTA'],
            datasets: [{
                label: 'Estatus',
                data: [enero, febrero],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)',
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(160, 255, 97, 0.2)',
                    'rgba(229, 97, 255, 0.2)',
                    'rgba(209, 230, 121, 0.2)',
                    'rgba(138, 115, 25, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)',
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(160, 255, 97, 1)',
                    'rgba(229, 97, 255, 1)',
                    'rgba(209, 230, 121, 1)',
                    'rgba(138, 115, 25, 1)'

                ],
                borderWidth: 2
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });
</script>


<script type="text/javascript">
    var enero = 15;
    var febrero = 5;
    var marzo = 25;
    var abril = 4;
    var mayo = 27;
    var junio = 16;
    var julio = 4;

    var ctx = document.getElementById('myChartpedidosdos').getContext('2d');
    var myChartpedidos = new Chart(ctx, {
        type: 'line',
        data: {
            labels:['Charger','Jetta','Frontier','Duster','RAM 1500/2500','Versa', 'Suburban'],
            datasets: [{
                label: 'Modelo',
                data: [enero, febrero,marzo,abril,mayo,junio,julio],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)',
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(160, 255, 97, 0.2)',
                    'rgba(229, 97, 255, 0.2)',
                    'rgba(209, 230, 121, 0.2)',
                    'rgba(138, 115, 25, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)',
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(160, 255, 97, 1)',
                    'rgba(229, 97, 255, 1)',
                    'rgba(209, 230, 121, 1)',
                    'rgba(138, 115, 25, 1)'

                ],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)',
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(160, 255, 97, 0.2)',
                    'rgba(229, 97, 255, 0.2)',
                    'rgba(209, 230, 121, 0.2)',
                    'rgba(138, 115, 25, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)',
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(160, 255, 97, 1)',
                    'rgba(229, 97, 255, 1)',
                    'rgba(209, 230, 121, 1)',
                    'rgba(138, 115, 25, 1)'
                ],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)',
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(160, 255, 97, 0.2)',
                    'rgba(209, 230, 121, 0.2)',
                    'rgba(138, 115, 25, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)',
                    'rgba(255, 159, 64, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(160, 255, 97, 1)',
                    'rgba(229, 97, 255, 1)',
                    'rgba(209, 230, 121, 1)',
                    'rgba(138, 115, 25, 1)'
                ],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)',
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(160, 255, 97, 0.2)',
                    'rgba(229, 97, 255, 0.2)',
                    'rgba(209, 230, 121, 0.2)',
                    'rgba(138, 115, 25, 0.2)'
                ],                borderWidth: 2
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });
</script>

@endpush

@section('content')
 <style type="text/css">
  	.oculto{display: none;}
    .title-pdf{ font-weight: bold; font-size: 14px; }
  	.colorbar{ background-color: white !important; }
	.progress{
        width: 130px; height: 130px; line-height: 120px; background: none; margin: 0 auto; box-shadow: none; 
        position: relative;
    }
	.progress:after{
	    content: ""; width: 100%; height: 100%; border-radius: 50%; border: 12px solid #fff; position: absolute;
	    top: 0; left: 0;
	}
	.progress > span{ width: 50%; height: 100%; overflow: hidden; position: absolute; top: 0; z-index: 1; }
	.numero{ font-size: 33px !important; margin-left: 22px; height: 90px !important; margin-top: 10px;}
	.texto{ border: 0px !important; width: 165px; margin-top: 50px !important; }	
	.progress .progress-left{ left: 0; }
	.progress .progress-bar{
	    width: 100%; height: 100%; background: none; border-width: 20px; border-style: solid; position: absolute; top: 0;
	}
	.progress .progress-left .progress-bar{
	    left: 100%; border-top-right-radius: 290px; border-bottom-right-radius: 290px; border-left: 0;
	    -webkit-transform-origin: center left; transform-origin: center left;
	}
	.progress .progress-right{ right: 0; }
	.progress .progress-right .progress-bar{
	    left: -100%; border-top-left-radius: 160px; border-bottom-left-radius: 160px; border-right: 0;
	    -webkit-transform-origin: center right; transform-origin: center right; animation: loading-1 1.8s linear forwards;
	}
	.progress .progress-value{
	    width: 90%; height: 90%; border-radius: 50%; font-size: 24px; color: #fff; line-height: 135px;
	    text-align: center; position: absolute; top: 5%;left: 5%;
	}
	.progress.blue .progress-bar{ border-color: #049dff; }
	.progress.blue .progress-left .progress-bar{ animation: loading-1 1.8s linear forwards 1.8s; }
	.progress.yellow .progress-bar{ border-color: yellow; }
	.progress.yellow .progress-left .progress-bar{ animation: loading-1 1.8s linear forwards 1.8s; }
	.progress.red .progress-bar{ border-color: red; }
	.progress.red .progress-left .progress-bar{ animation: loading-1 1.8s linear forwards 1.8s; }
	.progress.orange .progress-bar{ border-color: orange; }
	.progress.orange .progress-left .progress-bar{ animation: loading-1 1.8s linear forwards 1.8s; }
	.progress.pink .progress-bar{ border-color: #ed687c; }
	.progress.pink .progress-left .progress-bar{ animation: loading-4 1.8s linear forwards 1.8s; }
	.progress.green .progress-bar{ border-color: #1abc9c; }
	.progress.green .progress-left .progress-bar{ animation: loading-1 1.8s linear forwards 1.8s; }
	.numero{ background-color: transparent !important; border: 0px !important; width: 145px !important; }

	@keyframes loading-1{
	    0%{ -webkit-transform: rotate(0deg); transform: rotate(0deg); }
	    100%{ -webkit-transform: rotate(180deg); transform: rotate(180deg); }
	}
	@keyframes loading-2{
	    0%{ -webkit-transform: rotate(0deg); transform: rotate(0deg); }
	   	100%{ -webkit-transform: rotate(144deg); transform: rotate(144deg); }
	}
	@keyframes loading-3{
	    0%{ -webkit-transform: rotate(0deg); transform: rotate(0deg); }
	    100%{ -webkit-transform: rotate(90deg); transform: rotate(90deg); }
	}
	@keyframes loading-4{
	    0%{ -webkit-transform: rotate(0deg); transform: rotate(0deg); }
	    100%{ -webkit-transform: rotate(36deg); transform: rotate(36deg); }
	}
	@keyframes loading-5{
	    0%{ -webkit-transform: rotate(0deg); transform: rotate(0deg); }
	    100%{ -webkit-transform: rotate(126deg); transform: rotate(126deg); }
	}
	@media only screen and (max-width: 990px){ .progress{ margin-bottom: 20px; }.footer{margin-top: 200px;}
	}
  </style>

	<div class="row">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h3 class="card-title">Avisos</h3>
                    <div class="card-toolbar">
                    </div>
                </div>
                <div class="card-body">
{{--                         <div class="progress green colorbar">
                            <span class="progress-left">
                                <span class="progress-bar"></span>
                            </span>
                            <span class="progress-right">
                                <span class="progress-bar"></span>
                            </span>
                            <div class="progress-value">
                                <h2 class="barra" style="margin-left: 16px">
                                    <input type="text" value="70" class="numero" readonly>
                                </h2>
                            </div>
                        </div> --}}
                </div>

                    <div class="card-footer text-center">
                        <img src="http://ec2-54-87-16-81.compute-1.amazonaws.com/theme/assets/media/logos/logo.gif" width="220">
                    </div>

            </div>
        </div>
		<div class="col-lg-4">
			<div class="card shadow-sm">
 {{--    			<div class="card-header">
        			<h3 class="card-title">Unidades por marca</h3>
        			<div class="card-toolbar">
        			</div>
    			</div> --}}
    			<div class="card-body">
        			<canvas id="myChartpedidos" style="width: 100px;"></canvas> 
    			</div>
			</div>
		</div>

	</div>


	<div class="row mt-4">
		<div class="col-lg-6">
			<div class="card shadow-sm">
    			<div class="card-header">
        			<h3 class="card-title">Unidades por estatus</h3>
        			<div class="card-toolbar">
        			</div>
    			</div>
    			<div class="card-body">
        			<canvas id="myChartpedidosu" style="width: 100px;"></canvas> 
    			</div>
			</div>
		</div>
		<div class="col-lg-6">
			<div class="card shadow-sm">
    			<div class="card-header">
        			<h3 class="card-title">Unidades por modelo</h3>
        			<div class="card-toolbar">
        			</div>
    			</div>
    			<div class="card-body">
    				<canvas id="myChartpedidosdos" style="width: 100px;"></canvas>
    			</div>

			</div>
		</div>
	</div>

	

@endsection