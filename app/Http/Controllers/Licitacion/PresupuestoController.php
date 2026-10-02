<?php

namespace App\Http\Controllers\Licitacion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;
use App\Models\Unidad\Unidad;
use App\Models\Licitacion\Licitacion;
use App\Models\Presupuesto\PresupuestoLicitacion;
use App\Models\Presupuesto\UnidadesPresupuesto;

class PresupuestoController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function crearpresupuesto($licitacion)
    {
    	$unidades = Unidad::select('unidad.id', 'unidad.folio', 'unidad.id_ubicacion', 'unidad.fecha', 'unidad.id_marca', 	'unidad.id_modelo','unidad.unidad_year','unidad.no_serie', 'unidad.placa', 'unidad.transmision', 
            	'unidad.no_tarjeta_circulacion', 'unidad.no_poliza_seguro', 'unidad.fecha_vencimiento_poliza', 
            	'unidad.numero_inventario', 'unidad.color', 'unidad.id_status', 'mu.nombre_marca', 
            	'mou.nombre_modelo', 'uu.ubicacion')
            ->leftjoin("marca_unidad as mu","mu.id","unidad.id_marca")
            ->leftjoin("modelo_unidad as mou", "mou.id", '=',"unidad.id_modelo")
            ->leftjoin("ubicacion_unidad as uu", "uu.id", '=',"unidad.id_ubicacion")
            ->where('unidad.status_delete', 0)
            ->get();

        $info_lic = Licitacion::where('id',$licitacion)->get();

    	return view('licitaciones.presupuestos.crear-presupuesto', compact('unidades', 'licitacion', 'info_lic'));    	
    }

    public function guardarunidades(Request $request)
    {
    	$pres = PresupuestoLicitacion::latest('id')->first();
    	if($pres == null){
	    	$numero = 0; 
			$numero_final = str_pad($numero, 5, '0', STR_PAD_LEFT); 
			$numero_final++; 
			$numero_final = str_pad($numero_final, 5, '0', STR_PAD_LEFT);
			$num = $numero + 1;
			$folio = "FP".$numero_final;

		}else{
			$consulta = PresupuestoLicitacion::select("folio_num")->latest()->first();	
			$data =strlen($consulta->folio_num);
			if($data == 1){ $num_cero = 5; } if($data == 2){ $num_cero = 4; } if($data == 3){ $num_cero = 3; } if($data == 4){ $num_cero = 2; }
    		$numero = $consulta->folio_num; 
    		$numero_final = str_pad($numero, $num_cero, '0', STR_PAD_LEFT); 
			$numero_final++; 
			$numero_final = str_pad($numero_final, $num_cero, '0', STR_PAD_LEFT);
			$num = $numero + 1;
			$folio = "FL".$numero_final;
		}
	    
	    $data = [
	    	'id_licitacion' => $request->licitacion,
	        'folio_presupuesto' => $folio,
	        'folio_num' => $num,
	        'iduserCreated' =>auth()->user()->id,
	        'iduserUpdated' =>auth()->user()->id,
	        'created_at' =>date('Y-m-d H:i:s'),
	        'updated_at' =>date('Y-m-d H:i:s')
	    ];
	    PresupuestoLicitacion::insert($data);

	    $folio_pre = PresupuestoLicitacion::where('folio_presupuesto',$folio)->first();

	    foreach ($request->unidad as $key) {
		    $data = [
		    	'id_licitacion' => $request->licitacion,
		        'id_presupuesto' => $folio_pre->id,
		        'id_unidad' => $key,
		        'iduserCreated' =>auth()->user()->id,
		        'iduserUpdated' =>auth()->user()->id,
		        'created_at' =>date('Y-m-d H:i:s'),
		        'updated_at' =>date('Y-m-d H:i:s')
		    ];

		    UnidadesPresupuesto::insert($data);
	    }
	    
    	session()->flash('success', 'El presupuesto se creo correctamente');
    	return redirect()->route('presupuesto.presupuesto', $folio_pre->id);
    }

    public function presupuesto($presupuesto)
    {

		$unidades = UnidadesPresupuesto::select('un.id', 'un.folio', 'un.id_ubicacion', 'un.fecha', 'un.id_marca', 	'un.id_modelo','un.unidad_year','un.no_serie', 'un.placa', 'un.transmision', 
            	'un.no_tarjeta_circulacion', 'un.no_poliza_seguro', 'un.fecha_vencimiento_poliza', 
            	'un.numero_inventario', 'un.color', 'un.id_status', 'mu.nombre_marca', 
            	'mou.nombre_modelo', 'uu.ubicacion', 'unidades_presupuestos.id_licitacion', 
            	'unidades_presupuestos.id_presupuesto', 'unidades_presupuestos.id_unidad')
            ->leftjoin("unidad as un","un.id","unidades_presupuestos.id_unidad")
            ->leftjoin("marca_unidad as mu","mu.id","un.id_marca")
            ->leftjoin("modelo_unidad as mou", "mou.id", '=',"un.id_modelo")
            ->leftjoin("ubicacion_unidad as uu", "uu.id", '=',"un.id_ubicacion")
            ->where('un.status_delete', 0)
            ->where('unidades_presupuestos.id_presupuesto', $presupuesto)
            ->get();

    	return view('licitaciones.presupuestos.presupuesto', compact('presupuesto', 'unidades'));
    }

    public function listadopresupuestos()
    {

    	$presupuesto = PresupuestoLicitacion::where('status_delete', 0)->get();

    	return view('licitaciones.presupuestos.catalogo-presupuestos', compact('presupuesto'));
    }


}