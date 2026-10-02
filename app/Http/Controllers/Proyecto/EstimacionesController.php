<?php

namespace App\Http\Controllers\Proyecto;

use Mpdf\Mpdf;
use Carbon\Carbon;
use App\Models\Rol;
use App\Models\User;
use App\Services\Folio;
use App\Services\Money;
use App\Models\RolPermiso;
use Illuminate\Http\Request;
use App\Models\Unidad\Unidad;
use App\Models\Cliente\Cliente;
use App\Models\Proyecto\Emisor;
use App\Models\Proyecto\Proyecto;

use App\Models\Unidad\FotoUnidad;
use App\Models\Unidad\MarcaUnidad;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Models\Unidad\ModeloUnidad;
use App\Models\Unidad\StatusUnidad;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Models\Licitacion\Licitacion;
use App\Models\Proyecto\PagoProyecto;
use App\Models\Proyecto\TipoContrato;
use App\Models\Proyecto\DeductivaPago;
use App\Models\Unidad\UbicacionUnidad;

use App\Models\Unidad\UnidadDocumento;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use App\Models\Proyecto\FuenteProyecto;
use App\Models\Unidad\InventarioSalida;
use App\Models\Unidad\UnidadFotografia;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use App\Models\Unidad\AseguradoraUnidad;
use App\Models\Unidad\ComplementoUnidad;
use App\Models\Unidad\InventarioEntrega;
use App\Models\Unidad\UnidadMovimientos;
use Illuminate\Support\Facades\Response;
use Spatie\Permission\Models\Permission;
use App\Models\Proyecto\EstimacionesPago;
use App\Models\Proyecto\ProyectoClientes;
use App\Models\Proyecto\ProyectoDocumento;

use App\Models\Licitacion\TipoContratacion;
use App\Models\Proyecto\EstimacionesProyecto;
use App\Models\Proyecto\EstimacionesUnidades;
use App\Models\Proyecto\ProyectoTipoDocumento;
use App\Models\Unidad\AsignacionRegistroUnidad;

use App\Models\Proyecto\EstimacionesNotaCredito;
use App\Models\Proyecto\PenalizacionesDeducciones;
use App\Models\Proyecto\ProyectoModificacionConvenio;
use App\Models\Proyecto\EstimacionesSeguimientocliente;


class EstimacionesController extends Controller
{
    protected $folio;
    public function __construct(Folio $folio) {
        $this->middleware('auth');
        $this->folio = $folio;
    }

    public function estimaciones($licitacion)
    {
        $unidad_movimiento = Unidad::select('unidad.id','unidad.folio','unidad.id_ubicacion','unidad.fecha','unidad.id_marca','unidad.id_modelo','unidad.unidad_year','unidad.no_serie','unidad.placa',
            'unidad.transmision','unidad.no_tarjeta_circulacion','unidad.no_poliza_seguro','unidad.fecha_vencimiento_poliza','unidad.numero_inventario','unidad.color','unidad.id_status',
            'mu.nombre_marca','mou.nombre_modelo','uu.ubicacion','st.nombre_status','unidad.proyectos_id', 'unidad.licitaciones_id', 'unidad.fecha_asignacion', 'use.name', 'uta.tipo_asignacion')
            ->leftjoin("marca_unidad as mu", "mu.id", "unidad.id_marca")
            ->leftjoin("modelo_unidad as mou", "mou.id", '=', "unidad.id_modelo")
            ->leftjoin("ubicacion_unidad as uu", "uu.id", '=', "unidad.id_ubicacion")
            ->leftjoin("status_unidad as st", "st.id", '=', "unidad.id_status")
            ->leftjoin("users as use", "use.id", "unidad.cliente_id")
            ->leftjoin("unidad_tipo_asignacion as uta", "uta.id", "unidad.id_tipo_asignacion")
            ->where('unidad.licitaciones_id', $licitacion)->get();

        $proyecto = Proyecto::where('licitacion_id', $licitacion)->orderBy('id', 'desc')->first();


        $estimaciones = EstimacionesProyecto::select('proyecto_estimaciones.id', 'proyecto_estimaciones.proyectos_id', 'proyecto_estimaciones.id_status_delete', 'proyecto_estimaciones.cliente_id', 'proyecto_estimaciones.periodo_inicial', 'proyecto_estimaciones.periodo_final', 'proyecto_estimaciones.no_folio', 'proyecto_estimaciones.seguimiento_estimaciones', 'proyecto_estimaciones.importe_estimacion', 'proyecto_estimaciones.estatus_envio')
            ->where('proyecto_estimaciones.licitaciones_id', $licitacion)
            ->where('proyecto_estimaciones.id_status_delete', 1)
            ->get();
            // dd($estimaciones);

        return view('proyectos.estimaciones.listado-estimaciones', compact('unidad_movimiento', 'licitacion', 'estimaciones', 'proyecto'));       
    }

    public function guardarestimacion(Request $request)
    {
    	$proyecto = Proyecto::where('licitacion_id', $request->licitacion_id)->orderBy('id', 'desc')->first();

        $data = [
            'no_folio' => $this->folio->getFolioEstimaciones(),
        	'proyectos_id' => $proyecto->id,
            'licitaciones_id' => $request->licitacion_id,
            'cliente_id' => $proyecto->id_cliente,
            'periodo_inicial' => $request->periodo_inicial ? Carbon::createFromFormat('Y-m-d', $request->periodo_inicial)->format('Y-m-d') : null,
            'periodo_final' => $request->periodo_final ? Carbon::createFromFormat('Y-m-d', $request->periodo_final)->format('Y-m-d') : null,
            'id_status_delete' => 1,
            'estatus_envio'=> 0,
            'seguimiento_estimaciones' =>0,
            'iduserCreated' => auth()->user()->id,
            'iduserUpdated' => auth()->user()->id,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        
        $id_estimacion = EstimacionesProyecto::insertGetId($data);

        $unidad_movimiento = Unidad::select('unidad.id','unidad.folio', 'unidad.proyectos_id', 'unidad.licitaciones_id', 'unidad.fecha_asignacion', 'use.name', 'uta.tipo_asignacion', 'lpe.precio_unitario','lpe.segmento_id')
        	->leftjoin("licitacion_proposicion_economica as lpe", "lpe.id", "unidad.licitacion_propuesta_economica_id")
            ->leftjoin("users as use", "use.id", "unidad.cliente_id")
            ->leftjoin("unidad_tipo_asignacion as uta", "uta.id", "unidad.id_tipo_asignacion")
            ->where('unidad.licitaciones_id', $request->licitacion_id)->get();
        

        foreach ($unidad_movimiento as $key => $value) {
	        $data_unidad = [
	        	'unidad_id' =>  $value->id,
	        	'segmentos_id' => $value->segmento_id,
	        	'proyecto_estimaciones_id' => $id_estimacion,
	        	'licitaciones_id' => $request->licitacion_id,
	        	'proyectos_id' => $proyecto->id,
	            'dias_trabajo' => 30,
	            'precio_segmento' => $value->precio_unitario,
	            'iduserCreated' => auth()->user()->id,
	            'iduserUpdated' => auth()->user()->id,
	            'created_at' => date('Y-m-d H:i:s'),
	            'updated_at' => date('Y-m-d H:i:s')
	        ];

	        EstimacionesUnidades::insert($data_unidad);
        }


        session()->flash('success', 'La estimación se creo correctamente');
        return redirect()->route('estimaciones.estimaciones', $request->licitacion_id);

    }

    public function detalleestimacion($licitacion, $estimacion)
    {
    	$info_estimacion = EstimacionesProyecto::where('id', $estimacion)->first();

    	$unidaes_estimacion = EstimacionesUnidades::where('proyecto_estimaciones_id', $estimacion)->get();

        $seguimiento = EstimacionesSeguimientocliente::where('estimacion_id', $estimacion)->get();

    	return view('proyectos.estimaciones.detalle-estimaciones', compact('unidaes_estimacion', 'info_estimacion', 'licitacion', 'estimacion', 'seguimiento')); 
    }

    public function guardarestimacionunidades(Request $request)
    {

            for ($i = 0; $i < count($request->id); $i++) {

                $data = [
                    'id' => $request->id[$i],
                    'dias_trabajo' => $request->dias_trabajo[$i],
                    'iduserUpdated' => auth()->user()->id,
                    'updated_at' => date('Y-m-d H:i:s')
                ];

                EstimacionesUnidades::where('id', $request->id[$i])->update($data);
            }

        session()->flash('success', 'La estimación se modifico correctamente');
        return redirect()->route('estimaciones.detalleestimacion', [$request->licitacion_id, $request->estimacion_id]);
    }

    public function addseguimientoestimacion(Request $request)
    {
        $data_seguimiento = [
            'estimacion_id' => $request->id_estimacion_seguimiento,
            'estatus_estimacion' => $request->estatus_envio,
            'fecha_envio' => $request->fecha_envio_cliente,
            'observaciones' => $request->observaciones,
            'iduserCreated' => auth()->user()->id,
            'iduserUpdated' => auth()->user()->id,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        EstimacionesSeguimientocliente::insert($data_seguimiento);

        return response()->json(['success']);
    }

    public function deleteseguimientoestimacion(Request $request)
    {
        EstimacionesSeguimientocliente::where('id', $request->id)->delete();

        return response()->json(['success']);
    }

    public function estimacionafinanzas(Request $request)
    {
        
        $unidaes_estimacion = EstimacionesUnidades::where('proyecto_estimaciones_id', $request->id)->get();
        $precio_unitario = 0; $iva = 0; $total_monto=0; $subtotal_calculo=0; $iva_calculo=0;
            foreach($unidaes_estimacion as $unid){
                $total = $unid->precio_segmento * $unid->dias_trabajo;
                $precio_unitario = $precio_unitario + $total;
                $iva = $precio_unitario * 0.16;
                $total_monto = $precio_unitario + $iva;
            }

                $data = [
                    'importe_estimacion' => $total_monto,
                    'estatus_envio' => 1,
                    'seguimiento_estimaciones' => 1,
                    'iduserUpdated' => auth()->user()->id,
                    'updated_at' => date('Y-m-d H:i:s')
                ];

                EstimacionesProyecto::where('id', $request->id)->update($data);

        session()->flash('success', 'La estimación se envio correctamente');
        return redirect()->route('estimaciones.estimaciones', $request->licitacion);
    }

    public function verestimacion($licitacion, $estimacion)
    {
        $info_estimacion = EstimacionesProyecto::where('id', $estimacion)->first();

        $unidaes_estimacion = EstimacionesUnidades::where('proyecto_estimaciones_id', $estimacion)->get();

        $result = [];
        $segmentos = [];
        foreach ($unidaes_estimacion as $k => $row) {
            $result[$row['segmentos_id']][$k] = $row;
        }
        $precio_unitario = 0;  $iva = 0; $total_monto=0; $subtotal_calculo=0; $iva_calculo=0;
        foreach ($result as $key => $value) {
            foreach ($value as $data => $segmento) {
                // dd($segmento->id);
                $total = $segmento->precio_segmento * $segmento->dias_trabajo;
                $precio_unitario = $precio_unitario + $total;
                $iva = $precio_unitario * 0.16;
                $total_monto = $precio_unitario + $iva;
            }
             // dd($total);
        }


        $seguimiento = EstimacionesSeguimientocliente::where('estimacion_id', $estimacion)->get();

        $documentos = EstimacionesPago::where('estimacion_id',$estimacion)->get();

        $notascredito = EstimacionesNotaCredito::where('estimacion_id',$estimacion)->get();

        return view('proyectos.estimaciones.ver-estimacion', compact('unidaes_estimacion', 'info_estimacion', 'licitacion', 'estimacion', 'seguimiento', 'documentos', 'notascredito'));         
    }

    public function verestimacionproPDF($estimacion)
    {

        $info_estimacion = EstimacionesProyecto::where('id', $estimacion)->first();

        $unidaes_estimacion = EstimacionesUnidades::where('proyecto_estimaciones_id', $estimacion)->get();

        $seguimiento = EstimacionesSeguimientocliente::where('estimacion_id', $estimacion)->get();

        $documentos = EstimacionesPago::where('estimacion_id',$estimacion)->get();

        $notascredito = EstimacionesNotaCredito::where('estimacion_id',$estimacion)->get();

        $header = view('proyectos.ver-estimaciones-pdf-header', compact('info_estimacion'))->render();
        $footer = view('proyectos.ver-estimaciones-pdf-footer')->render();
        $body = view('proyectos.ver-estimaciones-pdf-body', compact('info_estimacion','unidaes_estimacion', 'seguimiento'))->render();

        $path = public_path() . '/theme/assets/media/logos/logojetvan-pdf.jpg';
        
        $mpdf = new Mpdf(['format' => [216, 340]]);
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->setAutoTopMargin = 'stretch';
        $mpdf->setAutoBottomMargin = 'stretch';
        $mpdf->SetHTMLHeader($header);
        $mpdf->SetFooter($footer);
        $mpdf->WriteHTML($body);
        if(File::exists($path)) {
            $mpdf->imageVars['logo'] = File::get($path);
        }
        $mpdf->Output();
    }

    public function descargarEstimacionExcel($licitacion, $estimacion)
    {
        return \Maatwebsite\Excel\Facades\Excel::download(
            new \App\Exports\EstimacionesProyectoExport($estimacion),
            'estimacion-' . $estimacion . '.xlsx'
        );
    }


}