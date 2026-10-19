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

use App\Models\Proyecto\EstimacionesTipoDocumento;
use App\Models\Proyecto\PenalizacionesDeducciones;
use App\Models\Proyecto\ProyectoModificacionConvenio;
use App\Models\Proyecto\EstimacionesSeguimientocliente;

class EstimacionesFinanzasController extends Controller
{
    protected $folio;
    protected $money_format;
    public function __construct(Folio $folio, Money $money_format) {
        $this->middleware('auth');
        $this->folio = $folio;
        $this->money_format = $money_format;
    }

    public function catalogoestimaciones()
    {

        $estimaciones = EstimacionesProyecto::select('proyecto_estimaciones.id', 'proyecto_estimaciones.proyectos_id', 'proyecto_estimaciones.id_status_delete', 'proyecto_estimaciones.cliente_id', 'proyecto_estimaciones.periodo_inicial', 'proyecto_estimaciones.periodo_final', 'proyecto_estimaciones.no_folio', 'proyecto_estimaciones.seguimiento_estimaciones', 'proyecto_estimaciones.importe_estimacion','proyecto_estimaciones.estatus_envio', 'proyecto_estimaciones.licitaciones_id', 'pr.no_contrato')
        	->leftjoin("proyectos as pr", "pr.id", "proyecto_estimaciones.proyectos_id")
            ->where('proyecto_estimaciones.estatus_envio', 1)
            ->where('proyecto_estimaciones.id_status_delete', 1)
            ->get();


        return view('proyectos.estimaciones-finanzas.listado-estimaciones-finanzas', compact( 'estimaciones'));  
    }

    public function verestimacionfin($licitacion, $estimacion)
    {
        $info_estimacion = EstimacionesProyecto::where('id', $estimacion)->first();

        $unidaes_estimacion = EstimacionesUnidades::where('proyecto_estimaciones_id', $estimacion)->get();

        $seguimiento = EstimacionesSeguimientocliente::where('estimacion_id', $estimacion)->get();

        $documentos = EstimacionesPago::where('estimacion_id',$estimacion)->get();

        $notascredito = EstimacionesNotaCredito::where('estimacion_id',$estimacion)->get();

        return view('proyectos.estimaciones-finanzas.ver-estimacion-finanzas', compact('unidaes_estimacion', 'info_estimacion', 'licitacion', 'estimacion', 'seguimiento', 'documentos', 'notascredito')); 	
    }

    public function evidenciapagoest($licitacion, $estimacion)
    {
        $info_estimacion = EstimacionesProyecto::where('id', $estimacion)->first();

        $unidaes_estimacion = EstimacionesUnidades::where('proyecto_estimaciones_id', $estimacion)->get();

        $seguimiento = EstimacionesSeguimientocliente::where('estimacion_id', $estimacion)->get();

        $documento = EstimacionesTipoDocumento::where('id_status_delete',1)->get();

        $cadenaTipoDocumento = "";
        foreach($documento as $doc){
            $cadenaTipoDocumento .= '"'.$doc->id.'":"'.$doc->tipo_documento.'",';
        }
        $cadenaTipoDocumento = '{'.rtrim($cadenaTipoDocumento, ',').'}';

        $documentos = EstimacionesPago::where('estimacion_id',$estimacion)->get();

        $notascredito = EstimacionesNotaCredito::where('estimacion_id',$estimacion)->get();

    return view('proyectos.estimaciones-finanzas.documentacion-estimaciones', compact('unidaes_estimacion', 'info_estimacion', 'licitacion', 'estimacion', 'seguimiento', 'cadenaTipoDocumento', 'documentos', 'notascredito')); 	    	
    }

    public function addevidenciapagoesti(Request $request)
    {

        $colIdDocumento = $request->id_documento;
        $colIdFecha = $request->fecha;

        if($request->hasfile('archivo')){
            $archivos = $request->file('archivo');
            foreach($archivos as $indice => $archivo)
            {
                $archivoNombre = $archivo->hashName();
                $mimeType = $archivo->getMimeType();
                Storage::putFileAs('estimaciones/'.$request->estimacion_id, $archivo, $archivoNombre);
                $data = [
                    'estimacion_id' => $request->estimacion_id,
                    'proyecto_estimaciones_tipo_documento_id' =>$colIdDocumento[$indice],
                    'documento' => $archivoNombre,
                    'fecha_pago' =>$colIdFecha[$indice],
                    'created_at' =>date('Y-m-d H:i:s'),
                    'iduserCreated' =>auth()->user()->id
                ];
                EstimacionesPago::insert($data);
            }
        }

        session()->flash('success', 'La evidencia de pago se agrego correctamente');
        return redirect()->route('estimacionesfin.catalogoestimaciones');
    }


    public function eliminardocumentoestimacion(Request $request)
    {
        $doc = EstimacionesPago::findOrFail($request->id);
        $estatus = true;
        if ($doc){
            Storage::delete('estimaciones/'.$doc->estimacion_id.'/'.$doc->documento);
            EstimacionesPago::where('id', $request->id)->delete();
        }else{
            $estatus = false;
        }

        return response()->json([
            'estatus' => $estatus,
        ]);
    }

    public function addnotacreditoestimacion(Request $request)
    {
        
        if($request->hasfile('archivo')){
            $archivos = $request->file('archivo');
            $archivoNombre = $archivos->hashName();
            $mimeType = $archivos->getMimeType();
            Storage::putFileAs('estimaciones/'.$request->estimacion_id, $archivos, $archivoNombre);
            $data = [
                'estimacion_id' => $request->estimacion_id,
                'documento' => $archivoNombre,
                'fecha_emision' =>$request->fecha_emision,
                'no_nota_credito' =>$request->no_nota_credito,
                'referencia_factura' =>$request->referencia_factura,
                'monto_creditar' => $request->monto_creditar? $this->money_format->clearFormat($request->monto_creditar) : null,
                'observaciones' =>$request->observaciones,
                'created_at' =>date('Y-m-d H:i:s'),
                'iduserCreated' =>auth()->user()->id
            ];
            EstimacionesNotaCredito::insert($data);
        }


        session()->flash('success', 'La nota de crédito se agrego correctamente');
        return redirect()->route('estimacionesfin.evidenciapagoest', [$request->licitacion_id,$request->estimacion_id]);

    }

    public function eliminardocumentonotacredito(Request $request)
    {
        $doc = EstimacionesNotaCredito::findOrFail($request->id);
        $estatus = true;
        if ($doc){
            Storage::delete('estimaciones/'.$doc->estimacion_id.'/'.$doc->documento);
            EstimacionesNotaCredito::where('id', $request->id)->delete();
        }else{
            $estatus = false;
        }

        return response()->json([
            'estatus' => $estatus,
        ]);        
    }

    public function verestimacionPDF($estimacion)
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

    public function finalizarestimacion(Request $request)
    {

        $data = [
            'seguimiento_estimaciones' => 2,
            'iduserUpdated' => auth()->user()->id,
            'updated_at' => date('Y-m-d H:i:s')
        ];


        EstimacionesProyecto::where('id', $request->estimacion_id)->update($data);

        session()->flash('success', 'La estimación se finalizo correctamente');
        return redirect()->route('estimacionesfin.catalogoestimaciones');

    }
}