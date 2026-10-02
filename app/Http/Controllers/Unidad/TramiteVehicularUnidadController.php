<?php

namespace App\Http\Controllers\Unidad;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Services\Money;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;

use App\Models\Cliente\Estado;
use App\Models\Cliente\Municipio;
use App\Models\Unidad\Unidad;
use App\Models\Unidad\MarcaUnidad;
use App\Models\Unidad\ModeloUnidad;
use App\Models\Unidad\UnidadFotografia;
use App\Models\Unidad\InformacionPropietario;
use App\Models\Unidad\AseguradoraUnidad;
use App\Models\Unidad\TipoCobertura;
use App\Models\Unidad\TramiteGestor;
use App\Models\Unidad\TramiteTipoPlacas;

//Emplacamiento
	use App\Models\Unidad\TramiteEmplacamientoInfo;
	use App\Models\Unidad\TramiteEmplacamientoDoc;
	use App\Models\Unidad\TramiteEmplacamientoRequisito;
	use App\Models\Unidad\TramiteEmplacamientoEvidencia;
//END Emplacamiento

// Tenencia
	use App\Models\Unidad\TramiteTenenciaRequisito;
	use App\Models\Unidad\TramiteTenenciaEvidencia;
	use App\Models\Unidad\TramiteTenenciaInfo;
	use App\Models\Unidad\TramiteTenenciaDoc;
// END Tenencia

// Verificación
	use App\Models\Unidad\TramiteVerificacionRequisito;
	use App\Models\Unidad\TramiteVerificacionEvidencia;
	use App\Models\Unidad\TramiteVerificacionDoc;
	use App\Models\Unidad\TramiteVerificacionInfo;
// END Verificacion

// Aseguramiento
	use App\Models\Unidad\TramiteAseguramientoRequisito;
	use App\Models\Unidad\TramiteAseguramientoEvidencia;
	use App\Models\Unidad\TramiteAseguramientoInfo;
	use App\Models\Unidad\TramiteAseguramientoDoc;
    use App\Models\Unidad\TramiteAseguramientoEstatus;
// END Aseguramiento

//Reemplacamiento
	use App\Models\Unidad\TramiteReemplacamientoRequisito;
	use App\Models\Unidad\TramiteReemplacamientoEvidencia;
	use App\Models\Unidad\TramiteReemplacamientoInfo;
	use App\Models\Unidad\TramiteReemplacamientoDoc;
//END Remplacamiento

//Baja vehiculo
	use App\Models\Unidad\TramiteBajaVehiculoSiniestroRequisito;
	use App\Models\Unidad\TramiteBajaVehiculoSiniestroEvidencia;
    use App\Models\Unidad\TramiteBajaVehiculoSiniestroEstatus;
	use App\Models\Unidad\TramiteBajavehiculoSiniestroInfo;
	use App\Models\Unidad\TramiteBajavehiculoSiniestroDoc;
    use App\Models\Unidad\TramiteBajaVehiculoSiniestroTipo;
	//END Siniestro

	use App\Models\Unidad\TramiteBajaVehiculoRequisito;  //venta
	use App\Models\Unidad\TramiteBajaVehiculoEvidencia;
	use App\Models\Unidad\TramiteBajaVehiculoVentaInfo;
	use App\Models\Unidad\TramiteBajaVehiculoVentaDoc;
	//END Venta

	use App\Models\Unidad\TramiteBajaVehiculoRoboRequisito;
	use App\Models\Unidad\TramiteBajaVehiculoRoboEvidencia;
	use App\Models\Unidad\TramiteBajaVehiculoRoboInfo;
	use App\Models\Unidad\TramiteBajaVehiculoRoboDoc;
	//END Robo
//END baja vehiculo

//Cambio de propietario
	use App\Models\Unidad\TramiteCambioPropietarioRequisito;
	use App\Models\Unidad\TramiteCambioPropietarioEvidencia;
	use App\Models\Unidad\TramiteCambioPropietarioInfo;
	use App\Models\Unidad\TramiteCambioPropietarioDoc;
//END Cambio de propietario

// Tramite GPS
    use App\Models\Unidad\TramiteGpsRequisito;
    use App\Models\Unidad\TramiteGpsEvidencia;
    use App\Models\Unidad\TramiteGpsInfo;
    use App\Models\Unidad\TramiteGpsDoc;
// END Tramite GPS

    use Mpdf\Mpdf;
    use Illuminate\Support\Facades\File;
    use Maatwebsite\Excel\Facades\Excel;
    use App\Imports\SiniestrosImport;
    use App\Imports\ReemplacamientosImport;
    use App\Imports\VerificacionImport;
    use App\Imports\AseguramientoImport;
    use App\Imports\TenenciaImport;
    use App\Imports\RoboImport;
    use App\Imports\VentaImport;
    use App\Imports\CambioPropietarioImport;
    use App\Imports\ReposisiocImport;

    use App\Models\Unidad\GestorDocumento;

class TramiteVehicularUnidadController extends Controller
{

    protected $money_format;
    public function __construct( Money $money_format) {
        $this->middleware('auth');
        $this->money_format = $money_format;
    }

    public function tramitevtenencia($id_unidad)
    {
    	$unidad = Unidad::find($id_unidad);
		$req_tramite = TramiteTenenciaRequisito::where('id_status_delete', 1)->get();
		$ev_tramite = TramiteTenenciaEvidencia::where('id_status_delete', 1)->get();
		$info_propietario = InformacionPropietario::where('id_status_delete', 1)->get();
        $marcas = MarcaUnidad::where('id_status_delete', 1)->get();
        $modelos = ModeloUnidad::where('id_status_delete', 1)->get();
        $fotografias = UnidadFotografia::where('unidad_id', $id_unidad)->get();
        $active = UnidadFotografia::where('unidad_id', $id_unidad)->first();

        if ($active == null) {
            $ver = 0;
        } else {
            $ver = $active->id;
        }

        $req_info = TramiteTenenciaInfo::where('unidad_id', $id_unidad)->orderBy('id', 'DESC')->get();

    	return view('unidades.tramitesvehiculares.tramiteunidad.tenencia.tramite-tenencia', compact('req_tramite', 'ev_tramite', 'info_propietario', 'id_unidad', 'marcas', 'modelos', 'ver', 'fotografias', 'unidad', 'req_info'));
    }

    public function vistagrdtenencia($id_unidad)
    {
    	$info_propietario = InformacionPropietario::where('id_status_delete', 1)->get();
        $documentos = TramiteTenenciaEvidencia::where('id_status_delete',1)->get();
        $gestor = TramiteGestor::where('id_status_delete',1)->get();

        //tipo de documentos en formato json
        $cadenaTipoDocumento = "";
        foreach($documentos as $documento){
            $cadenaTipoDocumento .= '"'.$documento->id.'":"'.$documento->nombre_evidencia.'",';
        }
        $cadenaTipoDocumento = '{'.rtrim($cadenaTipoDocumento, ',').'}';

        return view('unidades.tramitesvehiculares.tramiteunidad.tenencia.tramite-tenencia-guardar', compact('info_propietario', 'cadenaTipoDocumento', 'id_unidad', 'gestor'));
    }

    public function addinfoevtenencia(Request $request)
    {

    	$upd_info_tenencia = TramiteTenenciaInfo::where('op_estatus', 1)->get();
    	
        foreach ($upd_info_tenencia as $key => $value) {
	        $data = [
	            'op_estatus' => 2,
	            'updated_at' =>date('Y-m-d H:i:s'),
	            'iduserCreated' =>auth()->user()->id,        
	        ];
            TramiteTenenciaInfo::where('id', $value->id)->update($data);
        }

        $data = [
            'unidad_tramite_gestor_id'=> $request->gestor,
        	'unidad_id' => $request->id_unidad,
        	'id_propietario' => $request->id_propietario,
            'fecha_tramite' => $request->fecha_pago ? Carbon::createFromFormat('d/m/Y', $request->fecha_pago)->format('Y-m-d'):null,
            'observaciones' => $request->observaciones,
            'op_estatus' => 1,
            'id_status_delete' => 1,
            'importe' => $request->importe ? $this->money_format->clearFormat($request->importe):null,
            'created_at' =>date('Y-m-d H:i:s'),
            'updated_at' =>date('Y-m-d H:i:s'),
            'iduserCreated' =>auth()->user()->id,
            'iduserUpdated' =>auth()->user()->id,
        ];
        $unidad_tramite_tenencia_info_id = TramiteTenenciaInfo::insertGetId($data);

        $colIdDocumento = $request->id_documento;
        if($request->hasfile('archivo')){
            $archivos = $request->file('archivo');
            foreach($archivos as $indice => $archivo)
            {
                $archivoNombre = $archivo->hashName();
                $mimeType = $archivo->getMimeType();
                Storage::putFileAs('unidad/' . $request->id_unidad, $archivo, $archivoNombre);
                $data = [
                	'unidad_id'=>$request->id_unidad,
                    'unidad_tramite_tenencia_info_id' => $unidad_tramite_tenencia_info_id,
                    'id_evidencia' =>$colIdDocumento[$indice],
                    'documento' => $archivoNombre,
                    'created_at' =>date('Y-m-d H:i:s'),
                    'iduserCreated' =>auth()->user()->id
                ];
                TramiteTenenciaDoc::insert($data);
            }
        }

        session()->flash('success', 'El pago de la tenencia se añadió correctamente');
        return redirect()->route('traveh.tvtenencia', $request->id_unidad);


    }

    public function vistaedittenencia($id_unidad, $id_pago)
    {

    	$tramite_info  = TramiteTenenciaInfo::where('id', $id_pago)->first();
    	$tramite_evidencia  = TramiteTenenciaDoc::where('unidad_tramite_tenencia_info_id', $id_pago)->get();
    	$info_propietario = InformacionPropietario::where('id_status_delete', 1)->get();
        $documentos = TramiteTenenciaEvidencia::where('id_status_delete',1)->get();
        $gestor = TramiteGestor::where('id_status_delete',1)->get();

        //tipo de documentos en formato json
        $cadenaTipoDocumento = "";
        foreach($documentos as $documento){
            $cadenaTipoDocumento .= '"'.$documento->id.'":"'.$documento->nombre_evidencia.'",';
        }
        $cadenaTipoDocumento = '{'.rtrim($cadenaTipoDocumento, ',').'}';

        return view('unidades.tramitesvehiculares.tramiteunidad.tenencia.tramite-tenencia-editar', compact('info_propietario', 'cadenaTipoDocumento', 'id_unidad', 'tramite_info', 'id_pago', 'tramite_evidencia', 'gestor'));
    }

    public function editinfoevtenencia(Request $request)
    {
        $data = [
            'unidad_tramite_gestor_id'=> $request->gestor,
        	'id_propietario' => $request->id_propietario,
            'fecha_tramite' => $request->fecha_pago ? Carbon::createFromFormat('d/m/Y', $request->fecha_pago)->format('Y-m-d'):null,
            'observaciones' => $request->observaciones,
            'importe' => $request->importe ? $this->money_format->clearFormat($request->importe):null,
            'updated_at' =>date('Y-m-d H:i:s'),
            'iduserUpdated' =>auth()->user()->id,
        ];

        TramiteTenenciaInfo::where('id', $request->id_pago)->update($data);


        $colIdDocumento = $request->id_documento;
        if($request->hasfile('archivo')){
            $archivos = $request->file('archivo');
            foreach($archivos as $indice => $archivo)
            {
                $archivoNombre = $archivo->hashName();
                $mimeType = $archivo->getMimeType();
                Storage::putFileAs('unidad/' . $request->id_unidad, $archivo, $archivoNombre);
                $data = [
                	'unidad_id'=>$request->id_unidad,
                    'unidad_tramite_tenencia_info_id' => $request->id_pago,
                    'id_evidencia' =>$colIdDocumento[$indice],
                    'documento' => $archivoNombre,
                    'created_at' =>date('Y-m-d H:i:s'),
                    'iduserCreated' =>auth()->user()->id
                ];
                TramiteTenenciaDoc::insert($data);
            }
        }

        session()->flash('success', 'El pago de la tenencia se modifico correctamente');
        return redirect()->route('traveh.tvtenencia', $request->id_unidad);
    }

    public function eliminardocumentoevtenencia(Request $request)
    {
        $doc = TramiteTenenciaDoc::findOrFail($request->id);
        $estatus = true;
        if ($doc){
            Storage::delete('unidad/'. $request->unidad_id.'/'.$doc->documento);
            TramiteTenenciaDoc::where('id', $request->id)->delete();
        }else{
            $estatus = false;
        }

        return response()->json([
            'estatus' => $estatus,
        ]);
    }

    public function vistavertenencia($id_unidad, $id_pago)
    {
    	$tramite_info  = TramiteTenenciaInfo::where('id', $id_pago)->first();
    	$tramite_evidencia  = TramiteTenenciaDoc::where('unidad_tramite_tenencia_info_id', $id_pago)->get();
    	$info_propietario = InformacionPropietario::where('id', $tramite_info->id_propietario)->first();
        $documentos = TramiteTenenciaEvidencia::where('id_status_delete',1)->get();
        $estados = Estado::orderBy('id_estado', 'asc')->where('id_status_delete', 1)->get();
        $municipios = Municipio::orderBy('id_municipio', 'asc')->where('id_status_delete', 1)->get();
        //tipo de documentos en formato json
        $cadenaTipoDocumento = "";
        foreach($documentos as $documento){
            $cadenaTipoDocumento .= '"'.$documento->id.'":"'.$documento->nombre_evidencia.'",';
        }
        $cadenaTipoDocumento = '{'.rtrim($cadenaTipoDocumento, ',').'}';

        return view('unidades.tramitesvehiculares.tramiteunidad.tenencia.tramite-tenencia-ver', compact('info_propietario', 'cadenaTipoDocumento', 'id_unidad', 'tramite_info', 'id_pago', 'tramite_evidencia', 'estados' , 'municipios'));    	
    }

    public function deleteinfoevtenencia(Request $request)
    {

        $doc = TramiteTenenciaDoc::where('unidad_tramite_tenencia_info_id', $request->id)->get();
        $estatus = true;
        if ($doc){
	        foreach ($doc as $key => $value) {
	            Storage::delete('unidad/'. $request->id_unidad.'/'.$value->documento);
	            TramiteTenenciaDoc::where('id', $value->id)->delete();
	        }
        }else{
            $estatus = false;
        }

        $tramite_info  = TramiteTenenciaInfo::where('id', $request->id)->delete();


        session()->flash('success', 'El pago de la tenencia se elimino correctamente');
        return redirect()->route('traveh.tvtenencia', $request->id_unidad);
    }

    public function cargamasivatenencia(Request $request)
    {
        Excel::import(new TenenciaImport,request()->file('file_carga'));

        session()->flash('success', 'Se importó correctamente el archivo.');
        return redirect()->route('traveh.tvtenencia', $request->id_unidad);           
    }

// E N D   T R A M I T E   T E N E N C I A ---------------------------------------------------------------------------------------------------------------------------------- END TENENCIA
    public function tramitevemplacamiento($id_unidad)
    {
    	$unidad = Unidad::find($id_unidad);
		$req_tramite = TramiteEmplacamientoRequisito::where('id_status_delete', 1)->get();
		$ev_tramite = TramiteEmplacamientoEvidencia::where('id_status_delete', 1)->get();
		$info_propietario = InformacionPropietario::where('id_status_delete', 1)->get();
        $marcas = MarcaUnidad::where('id_status_delete', 1)->get();
        $modelos = ModeloUnidad::where('id_status_delete', 1)->get();
        $fotografias = UnidadFotografia::where('unidad_id', $id_unidad)->get();
        $active = UnidadFotografia::where('unidad_id', $id_unidad)->first();

        if ($active == null) {
            $ver = 0;
        } else {
            $ver = $active->id;
        }

       	$req_info = TramiteEmplacamientoInfo::where('unidad_id', $id_unidad)->orderBy('id', 'DESC')->get();

    	return view('unidades.tramitesvehiculares.tramiteunidad.emplacamiento.tramite-emplacamiento', compact('req_tramite', 'ev_tramite', 'info_propietario', 'id_unidad', 'marcas', 'modelos', 'ver', 'fotografias', 'unidad', 'req_info'));
    }

    public function vistagrdemplacamiento($id_unidad)
    {
    	$estados = Estado::orderBy('id_estado', 'asc')->where('id_status_delete', 1)->get();
    	$info_propietario = InformacionPropietario::where('id_status_delete', 1)->get();
        $documentos = TramiteEmplacamientoEvidencia::where('id_status_delete',1)->get();
        $gestor = TramiteGestor::where('id_status_delete',1)->get();
        $tipo_placa = TramiteTipoPlacas::where('id_status_delete',1)->get();

        //tipo de documentos en formato json
        $cadenaTipoDocumento = "";
        foreach($documentos as $documento){
            $cadenaTipoDocumento .= '"'.$documento->id.'":"'.$documento->nombre_evidencia.'",';
        }
        $cadenaTipoDocumento = '{'.rtrim($cadenaTipoDocumento, ',').'}';

        return view('unidades.tramitesvehiculares.tramiteunidad.emplacamiento.tramite-emplacamiento-guardar', compact('info_propietario', 'cadenaTipoDocumento', 'id_unidad', 'estados', 'gestor', 'tipo_placa'));
    }

    public function addinfoevemplacamiento(Request $request)
    {
        $entidad_placas = Estado::where('id_estado', $request->entidad_placas)->first();
        // dd($entidad_placas->estado_nombre);
        $data = [
        	// 'no_tarjeta_circulacion' => $request->tarjeta_circularion,
            'placa' => $request->numero_placas,
            'op_engomado' => $request->engomado,
            'holograma' => $request->holograma,
            'entidad_placas' => $entidad_placas->estado_nombre,
            'verificacion_op' => $request->verificacion_op,
            'updated_at' =>date('Y-m-d H:i:s'),
            'iduserUpdated' =>auth()->user()->id,
        ];

        Unidad::where('id', $request->id_unidad)->update($data);


        $data = [
            'unidad_tramite_gestor_id'=> $request->gestor,
            'fecha_expedicion' => $request->fecha_expedicion ? Carbon::createFromFormat('d/m/Y', $request->fecha_expedicion)->format('Y-m-d'):null,
            'unidad_tramite_tipo_placas_id' => $request->tipo_placa,
        	'unidad_id' => $request->id_unidad,
        	'id_propietario' => $request->id_propietario,
            'fecha_tramite' => $request->fecha_tramite ? Carbon::createFromFormat('d/m/Y', $request->fecha_tramite)->format('Y-m-d'):null,
            'numero_placas' => $request->numero_placas,
            'entidad_placas' => $request->entidad_placas,
            'engomado' => $request->engomado,
            'holograma' => $request->holograma,
            'verificacion_op' => $request->verificacion_op,
            'tarjeta_circularion' => $request->tarjeta_circularion,
            'fecha_emision_tarjeta' => $request->fecha_emision ? Carbon::createFromFormat('d/m/Y', $request->fecha_emision)->format('Y-m-d'):null,
            'fecha_vencimiento_tarjeta' => $request->fecha_vencimiento_placas ? Carbon::createFromFormat('d/m/Y', $request->fecha_vencimiento_placas)->format('Y-m-d'):null,
            'observaciones' => $request->observaciones,
            'importe' => $request->importe ? $this->money_format->clearFormat($request->importe):null,
            'op_estatus' => 1,
            'id_status_delete' => 1,
            'created_at' =>date('Y-m-d H:i:s'),
            'updated_at' =>date('Y-m-d H:i:s'),
            'iduserCreated' =>auth()->user()->id,
            'iduserUpdated' =>auth()->user()->id,
        ];
        $unidad_tramite_tenencia_info_id = TramiteEmplacamientoInfo::insertGetId($data);

        $colIdDocumento = $request->id_documento;
        if($request->hasfile('archivo')){
            $archivos = $request->file('archivo');
            foreach($archivos as $indice => $archivo)
            {
                $archivoNombre = $archivo->hashName();
                $mimeType = $archivo->getMimeType();
                Storage::putFileAs('unidad/' . $request->id_unidad, $archivo, $archivoNombre);
                $data = [
                	'unidad_id'=>$request->id_unidad,
                    'unidad_tramite_emplacamiento_info_id' => $unidad_tramite_tenencia_info_id,
                    'id_evidencia' =>$colIdDocumento[$indice],
                    'documento' => $archivoNombre,
                    'created_at' =>date('Y-m-d H:i:s'),
                    'iduserCreated' =>auth()->user()->id
                ];
                TramiteEmplacamientoDoc::insert($data);
            }
        }

        session()->flash('success', 'La información de emplacamiento se añadió correctamente');
        return redirect()->route('traveh.tvemplacamiento', $request->id_unidad);   	
    }

    public function vistaeditemplacamiento($id_unidad, $id_tramite)
    {
    	$tramite_info  = TramiteEmplacamientoInfo::where('id', $id_tramite)->first();
    	$tramite_evidencia  = TramiteEmplacamientoDoc::where('unidad_tramite_emplacamiento_info_id', $id_tramite)->get();
    	$info_propietario = InformacionPropietario::where('id_status_delete', 1)->get();
    	$estados = Estado::orderBy('id_estado', 'asc')->where('id_status_delete', 1)->get();
        $documentos = TramiteEmplacamientoEvidencia::where('id_status_delete',1)->get();
        $gestor = TramiteGestor::where('id_status_delete',1)->get();
        $tipo_placa = TramiteTipoPlacas::where('id_status_delete',1)->get();

        //tipo de documentos en formato json
        $cadenaTipoDocumento = "";
        foreach($documentos as $documento){
            $cadenaTipoDocumento .= '"'.$documento->id.'":"'.$documento->nombre_evidencia.'",';
        }
        $cadenaTipoDocumento = '{'.rtrim($cadenaTipoDocumento, ',').'}';

        return view('unidades.tramitesvehiculares.tramiteunidad.emplacamiento.tramite-emplacamiento-editar', compact('info_propietario', 'cadenaTipoDocumento', 'id_unidad', 'tramite_info', 'id_tramite', 'tramite_evidencia', 'estados', 'gestor', 'tipo_placa'));    	
    }

    public function eliminardocumentoevemplaca(Request $request)
    {
        $doc = TramiteEmplacamientoDoc::findOrFail($request->id);
        $estatus = true;
        if ($doc){
            Storage::delete('unidad/'. $request->unidad_id.'/'.$doc->documento);
            TramiteEmplacamientoDoc::where('id', $request->id)->delete();
        }else{
            $estatus = false;
        }

        return response()->json([
            'estatus' => $estatus,
        ]);
    }

    public function editinfoevemplacamiento(Request $request)
    {

        $entidad_placas = Estado::where('id_estado', $request->entidad_placas)->first();

        $data = [
        	'no_tarjeta_circulacion' => $request->tarjeta_circularion,
            'placa' => $request->numero_placas,
            'op_engomado' => $request->engomado,
            'holograma' => $request->holograma,
            'entidad_placas' => $entidad_placas->estado_nombre,
            'verificacion_op' => $request->verificacion_op,
            'updated_at' =>date('Y-m-d H:i:s'),
            'iduserUpdated' =>auth()->user()->id,
        ];

        Unidad::where('id', $request->id_unidad)->update($data);   
        

        $data = [
            'unidad_tramite_gestor_id'=> $request->gestor,
            'fecha_expedicion' => $request->fecha_expedicion ? Carbon::createFromFormat('d/m/Y', $request->fecha_expedicion)->format('Y-m-d'):null,
            'unidad_tramite_tipo_placas_id' => $request->tipo_placa,
        	'unidad_id' => $request->id_unidad,
        	'id_propietario' => $request->id_propietario,
            'fecha_tramite' => $request->fecha_tramite ? Carbon::createFromFormat('d/m/Y', $request->fecha_tramite)->format('Y-m-d'):null,
            'numero_placas' => $request->numero_placas,
            'entidad_placas' => $request->entidad_placas,
            'engomado' => $request->engomado,
            'holograma' => $request->holograma,
            'verificacion_op' => $request->verificacion_op,
            'tarjeta_circularion' => $request->tarjeta_circularion,
            'fecha_emision_tarjeta' => $request->fecha_emision ? Carbon::createFromFormat('d/m/Y', $request->fecha_emision)->format('Y-m-d'):null,
            'fecha_vencimiento_tarjeta' => $request->fecha_vencimiento_placas ? Carbon::createFromFormat('d/m/Y', $request->fecha_vencimiento_placas)->format('Y-m-d'):null,
            'observaciones' => $request->observaciones,
            'op_estatus' => 1,
            'importe' => $request->importe ? $this->money_format->clearFormat($request->importe):null,
            'id_status_delete' => 1,
            'updated_at' =>date('Y-m-d H:i:s'),
            'iduserUpdated' =>auth()->user()->id,
        ];
        TramiteEmplacamientoInfo::where('id', $request->id_emplacamiento)->update($data);  

        $colIdDocumento = $request->id_documento;
        if($request->hasfile('archivo')){
            $archivos = $request->file('archivo');
            foreach($archivos as $indice => $archivo)
            {
                $archivoNombre = $archivo->hashName();
                $mimeType = $archivo->getMimeType();
                Storage::putFileAs('unidad/' . $request->id_unidad, $archivo, $archivoNombre);
                $data = [
                	'unidad_id'=>$request->id_unidad,
                    'unidad_tramite_emplacamiento_info_id' => $request->id_emplacamiento,
                    'id_evidencia' =>$colIdDocumento[$indice],
                    'documento' => $archivoNombre,
                    'created_at' =>date('Y-m-d H:i:s'),
                    'iduserCreated' =>auth()->user()->id
                ];
                TramiteEmplacamientoDoc::insert($data);
            }
        }

        session()->flash('success', 'La información de emplacamiento se modifico correctamente');
        return redirect()->route('traveh.tvemplacamiento', $request->id_unidad); 
    }

    public function vistaveremplacamiento($id_unidad,$id_tramite)
    {
    	$tramite_info  = TramiteEmplacamientoInfo::where('id', $id_tramite)->first();
    	$tramite_evidencia  = TramiteEmplacamientoDoc::where('unidad_tramite_emplacamiento_info_id', $id_tramite)->get();
    	$info_propietario = InformacionPropietario::where('id', $tramite_info->id_propietario)->first();
    	$estados = Estado::orderBy('id_estado', 'asc')->where('id_status_delete', 1)->get();
        $documentos = TramiteEmplacamientoEvidencia::where('id_status_delete',1)->get();
        $municipios = Municipio::orderBy('id_municipio', 'asc')->where('id_status_delete', 1)->get();
        //tipo de documentos en formato json
        $cadenaTipoDocumento = "";
        foreach($documentos as $documento){
            $cadenaTipoDocumento .= '"'.$documento->id.'":"'.$documento->nombre_evidencia.'",';
        }
        $cadenaTipoDocumento = '{'.rtrim($cadenaTipoDocumento, ',').'}';

        return view('unidades.tramitesvehiculares.tramiteunidad.emplacamiento.tramite-emplacamiento-ver', compact('info_propietario', 'cadenaTipoDocumento', 'id_unidad', 'tramite_info', 'id_tramite', 'tramite_evidencia', 'estados', 'municipios'));     	
    }

// E N D   T R A M I T E  V E R I F I C A C I O N---------------------------------------------------------------------------------------------------------------------------------- END VERIFICACION

    public function tramitevverificacion($id_unidad)
    {
    	$unidad = Unidad::find($id_unidad);
		$req_tramite = TramiteVerificacionRequisito::where('id_status_delete', 1)->get();
		$ev_tramite = TramiteVerificacionEvidencia::where('id_status_delete', 1)->get();
		$info_propietario = InformacionPropietario::where('id_status_delete', 1)->get();
        $marcas = MarcaUnidad::where('id_status_delete', 1)->get();
        $modelos = ModeloUnidad::where('id_status_delete', 1)->get();
        $fotografias = UnidadFotografia::where('unidad_id', $id_unidad)->get();
        $active = UnidadFotografia::where('unidad_id', $id_unidad)->first();

        if ($active == null) {
            $ver = 0;
        } else {
            $ver = $active->id;
        }

        $req_info = TramiteVerificacionInfo::where('unidad_id', $id_unidad)->orderBy('id', 'DESC')->get();

    	return view('unidades.tramitesvehiculares.tramiteunidad.verificacion.tramite-verificacion', compact('req_tramite', 'ev_tramite', 'info_propietario', 'id_unidad', 'marcas', 'modelos', 'ver', 'fotografias', 'unidad', 'req_info'));
    }

    public function vistagrdverificacion($id_unidad)
    {
    	$info_propietario = InformacionPropietario::where('id_status_delete', 1)->get();
        $documentos = TramiteVerificacionEvidencia::where('id_status_delete',1)->get();
        $gestor = TramiteGestor::where('id_status_delete',1)->get();
        $estados = Estado::orderBy('id_estado', 'asc')->where('id_status_delete', 1)->get();

        //tipo de documentos en formato json
        $cadenaTipoDocumento = "";
        foreach($documentos as $documento){
            $cadenaTipoDocumento .= '"'.$documento->id.'":"'.$documento->nombre_evidencia.'",';
        }
        $cadenaTipoDocumento = '{'.rtrim($cadenaTipoDocumento, ',').'}';

        return view('unidades.tramitesvehiculares.tramiteunidad.verificacion.tramite-verificacion-guardar', compact('info_propietario', 'cadenaTipoDocumento', 'id_unidad', 'gestor', 'estados'));
    }

    public function addinfoevverificacion(Request $request)
    {
        // dd($request);
    	$upd_info_tenencia = TramiteVerificacionInfo::where('unidad_id', $request->id_unidad)->where('op_estatus', 1)->get();
    	
        foreach ($upd_info_tenencia as $key => $value) {
	        $data = [
	            'op_estatus' => 2,
	            'updated_at' =>date('Y-m-d H:i:s'),
	            'iduserCreated' =>auth()->user()->id,        
	        ];
            TramiteVerificacionInfo::where('id', $value->id)->update($data);
        }

        $data = [
            'unidad_tramite_gestor_id' => $request->gestor, 
            'tipo_reporte' => $request->tipo_reporte,
            'entidad_id' => $request->entidad,
            'fecha_vencimiento' => $request->fecha_vencimiento ? Carbon::createFromFormat('d/m/Y', $request->fecha_vencimiento)->format('Y-m-d'):null,
            'fecha_entrega' => $request->fecha_entrega ? Carbon::createFromFormat('d/m/Y', $request->fecha_entrega)->format('Y-m-d'):null,
            'nombre_receptor' => $request->nombre_receptor,
        	'unidad_id' => $request->id_unidad,
        	'id_propietario' => $request->id_propietario,
            'fecha_tramite' => $request->fecha_tramite ? Carbon::createFromFormat('d/m/Y', $request->fecha_tramite)->format('Y-m-d'):null,
            'observaciones' => $request->observaciones,
            'op_estatus' => 1,
            'importe' => $request->importe ? $this->money_format->clearFormat($request->importe):null,
            'id_status_delete' => 1,
            'created_at' =>date('Y-m-d H:i:s'),
            'updated_at' =>date('Y-m-d H:i:s'),
            'iduserCreated' =>auth()->user()->id,
            'iduserUpdated' =>auth()->user()->id,
        ];
        $unidad_tramite_info_id = TramiteVerificacionInfo::insertGetId($data);

        $colIdDocumento = $request->id_documento;
        if($request->hasfile('archivo')){
            $archivos = $request->file('archivo');
            foreach($archivos as $indice => $archivo)
            {
                $archivoNombre = $archivo->hashName();
                $mimeType = $archivo->getMimeType();
                Storage::putFileAs('unidad/' . $request->id_unidad, $archivo, $archivoNombre);
                $data = [
                	'unidad_id'=>$request->id_unidad,
                    'unidad_tramite_verificacion_info_id' => $unidad_tramite_info_id,
                    'id_evidencia' =>$colIdDocumento[$indice],
                    'documento' => $archivoNombre,
                    'created_at' =>date('Y-m-d H:i:s'),
                    'iduserCreated' =>auth()->user()->id
                ];
                TramiteVerificacionDoc::insert($data);
            }
        }

        session()->flash('success', 'La información del tramite se añadió correctamente');
        return redirect()->route('traveh.tvverificacion', $request->id_unidad);    	
    }

    public function vistaeditverificacion($id_unidad, $id_pago)
    {
    	$tramite_info  = TramiteVerificacionInfo::where('id', $id_pago)->first();
    	$tramite_evidencia  = TramiteVerificacionDoc::where('unidad_tramite_verificacion_info_id', $id_pago)->get();
    	$info_propietario = InformacionPropietario::where('id_status_delete', 1)->get();
        $documentos = TramiteVerificacionEvidencia::where('id_status_delete',1)->get();
        $gestor = TramiteGestor::where('id_status_delete',1)->get();
        $estados = Estado::orderBy('id_estado', 'asc')->where('id_status_delete', 1)->get();

        //tipo de documentos en formato json
        $cadenaTipoDocumento = "";
        foreach($documentos as $documento){
            $cadenaTipoDocumento .= '"'.$documento->id.'":"'.$documento->nombre_evidencia.'",';
        }
        $cadenaTipoDocumento = '{'.rtrim($cadenaTipoDocumento, ',').'}';

        return view('unidades.tramitesvehiculares.tramiteunidad.verificacion.tramite-verificacion-editar', compact('info_propietario', 'cadenaTipoDocumento', 'id_unidad', 'tramite_info', 'id_pago', 'tramite_evidencia', 'gestor', 'estados'));    	
    }

    public function eliminardocumentoevverificac(Request $request)
    {
        $doc = TramiteVerificacionDoc::findOrFail($request->id);
        $estatus = true;
        if ($doc){
            Storage::delete('unidad/'. $request->unidad_id.'/'.$doc->documento);
            TramiteVerificacionDoc::where('id', $request->id)->delete();
        }else{
            $estatus = false;
        }

        return response()->json([
            'estatus' => $estatus,
        ]);   	
    }

    public function editinfoevverificacion(Request $request)
    {
        $data = [
            'unidad_tramite_gestor_id' => $request->gestor, 
            'tipo_reporte' => $request->tipo_reporte,
            'entidad_id' => $request->entidad,
            'fecha_vencimiento' => $request->fecha_vencimiento ? Carbon::createFromFormat('d/m/Y', $request->fecha_vencimiento)->format('Y-m-d'):null,
            'fecha_entrega' => $request->fecha_entrega ? Carbon::createFromFormat('d/m/Y', $request->fecha_entrega)->format('Y-m-d'):null,
            'nombre_receptor' => $request->nombre_receptor,
        	'id_propietario' => $request->id_propietario,
            'fecha_tramite' => $request->fecha_tramite ? Carbon::createFromFormat('d/m/Y', $request->fecha_tramite)->format('Y-m-d'):null,
            'observaciones' => $request->observaciones,
            'importe' => $request->importe ? $this->money_format->clearFormat($request->importe):null,
            'updated_at' =>date('Y-m-d H:i:s'),
            'iduserUpdated' =>auth()->user()->id,
        ];

        TramiteVerificacionInfo::where('id', $request->id_pago)->update($data);


        $colIdDocumento = $request->id_documento;
        if($request->hasfile('archivo')){
            $archivos = $request->file('archivo');
            foreach($archivos as $indice => $archivo)
            {
                $archivoNombre = $archivo->hashName();
                $mimeType = $archivo->getMimeType();
                Storage::putFileAs('unidad/' . $request->id_unidad, $archivo, $archivoNombre);
                $data = [
                	'unidad_id'=>$request->id_unidad,
                    'unidad_tramite_verificacion_info_id' => $request->id_pago,
                    'id_evidencia' =>$colIdDocumento[$indice],
                    'documento' => $archivoNombre,
                    'created_at' =>date('Y-m-d H:i:s'),
                    'iduserCreated' =>auth()->user()->id
                ];
                TramiteVerificacionDoc::insert($data);
            }
        }

        session()->flash('success', 'La información del tramite se modifico correctamente');
        return redirect()->route('traveh.tvverificacion', $request->id_unidad);     	
    }

    public function vistaververificacion($id_unidad, $id_pago)
    {
    	$tramite_info  = TramiteVerificacionInfo::where('id', $id_pago)->first();
    	$tramite_evidencia  = TramiteVerificacionDoc::where('unidad_tramite_verificacion_info_id', $id_pago)->get();
    	$info_propietario = InformacionPropietario::where('id_status_delete', 1)->get();
        $documentos = TramiteVerificacionEvidencia::where('id_status_delete',1)->get();
        $info_propietario = InformacionPropietario::where('id', $tramite_info->id_propietario)->first();
        $estados = Estado::orderBy('id_estado', 'asc')->where('id_status_delete', 1)->get();
        $municipios = Municipio::orderBy('id_municipio', 'asc')->where('id_status_delete', 1)->get();
        //tipo de documentos en formato json
        $cadenaTipoDocumento = "";
        foreach($documentos as $documento){
            $cadenaTipoDocumento .= '"'.$documento->id.'":"'.$documento->nombre_evidencia.'",';
        }
        $cadenaTipoDocumento = '{'.rtrim($cadenaTipoDocumento, ',').'}';

        return view('unidades.tramitesvehiculares.tramiteunidad.verificacion.tramite-verificacion-ver', compact('info_propietario', 'cadenaTipoDocumento', 'id_unidad', 'tramite_info', 'id_pago', 'tramite_evidencia', 'info_propietario', 'estados', 'municipios'));     	
    }

    public function deleteinfoevverificacion(Request $request)
    {
        $doc = TramiteVerificacionDoc::where('unidad_tramite_verificacion_info_id', $request->id)->get();
        $estatus = true;
        if ($doc){
	        foreach ($doc as $key => $value) {
	            Storage::delete('unidad/'. $request->id_unidad.'/'.$value->documento);
	            TramiteVerificacionDoc::where('id', $value->id)->delete();
	        }
        }else{
            $estatus = false;
        }

        $tramite_info  = TramiteVerificacionInfo::where('id', $request->id)->delete();


        session()->flash('success', 'El registro de verificación se elimino correctamente');
        return redirect()->route('traveh.tvverificacion', $request->id_unidad);    	
    }

    public function cargamasivaverificacion(Request $request)
    {
        Excel::import(new VerificacionImport,request()->file('file_carga'));

        session()->flash('success', 'Se importó correctamente el archivo.');
        return redirect()->route('traveh.tvverificacion', $request->id_unidad);         
    }


// E N D   T R A M I T E  V E R I F I C A C I O N------------------------------------------------------------------------------------------------------------------------------- END VERIFICACION


    public function tramitevaseguramiento($id_unidad)
    {
    	$unidad = Unidad::find($id_unidad);
		$req_tramite = TramiteAseguramientoRequisito::where('id_status_delete', 1)->get();
		$ev_tramite = TramiteAseguramientoEvidencia::where('id_status_delete', 1)->get();
		$info_propietario = InformacionPropietario::where('id_status_delete', 1)->get();
        $marcas = MarcaUnidad::where('id_status_delete', 1)->get();
        $modelos = ModeloUnidad::where('id_status_delete', 1)->get();
        $fotografias = UnidadFotografia::where('unidad_id', $id_unidad)->get();
        $active = UnidadFotografia::where('unidad_id', $id_unidad)->first();

        if ($active == null) {
            $ver = 0;
        } else {
            $ver = $active->id;
        }

        $req_info = TramiteAseguramientoInfo::where('unidad_id', $id_unidad)->orderBy('id', 'DESC')->get();

    	return view('unidades.tramitesvehiculares.tramiteunidad.aseguramiento.tramite-aseguramiento', compact('req_tramite', 'ev_tramite', 'info_propietario', 'id_unidad', 'marcas', 'modelos', 'ver', 'fotografias', 'unidad', 'req_info'));
    }

    public function vistagrdaseguramiento($id_unidad)
    {	
        $unidad_info = Unidad::where('id', $id_unidad)->first();
    	$aseguradora = AseguradoraUnidad::where('id_status_delete', 1)->get();
    	$tipo_cobertura =TipoCobertura::where('id_status_delete', 1)->get();
    	$info_propietario = InformacionPropietario::where('id_status_delete', 1)->get();
        $documentos = TramiteAseguramientoEvidencia::where('id_status_delete',1)->get();
        $gestor = TramiteGestor::where('id_status_delete',1)->get();
        $estatus_aseg = TramiteAseguramientoEstatus::where('id_status_delete',1)->get();

        //tipo de documentos en formato json
        $cadenaTipoDocumento = "";
        foreach($documentos as $documento){
            $cadenaTipoDocumento .= '"'.$documento->id.'":"'.$documento->nombre_evidencia.'",';
        }
        $cadenaTipoDocumento = '{'.rtrim($cadenaTipoDocumento, ',').'}';

        return view('unidades.tramitesvehiculares.tramiteunidad.aseguramiento.tramite-aseguramiento-guardar', compact('info_propietario', 'cadenaTipoDocumento', 'id_unidad', 'aseguradora', 'tipo_cobertura', 'gestor', 'estatus_aseg', 'unidad_info'));    	
    }

    public function addinfoevaseguramiento(Request $request)
    {

        $unidad_info = Unidad::where('id', $request->id_unidad)->first();
    	$upd_info_tenencia = TramiteAseguramientoInfo::where('unidad_id', $request->id_unidad)->where('op_estatus', 1)->get();
    	
        foreach ($upd_info_tenencia as $key => $value) {
	        $data = [
	            'op_estatus' => 2,
	            'updated_at' =>date('Y-m-d H:i:s'),
	            'iduserCreated' =>auth()->user()->id,        
	        ];
            TramiteAseguramientoInfo::where('id', $value->id)->update($data);
        }


        $data = [
        	'id_aseguradora' => $request->aseguradora_id,
        	'fecha_vencimiento_poliza' => $request->fecha_final_seguro ? Carbon::createFromFormat('d/m/Y', $request->fecha_final_seguro)->format('Y-m-d'):null,
        	'no_poliza_seguro' => $request->no_poliza,
            'updated_at' =>date('Y-m-d H:i:s'),
            'iduserUpdated' =>auth()->user()->id,
        ];

        Unidad::where('id', $request->id_unidad)->update($data);


        $data = [
            'unidad_tramite_gestor_id'=> $request->gestor,
        	'unidad_id' => $request->id_unidad,
        	'unidad_informacion_propietario_id' => $request->id_propietario,
        	'aseguradora_id' => $request->aseguradora_id,
        	'tipo_cobertura_id' => $request->tipo_cobertura_id,
        	'no_poliza' => $request->no_poliza,
            'fecha_inicial_seguro' => $request->fecha_inicial_seguro ? Carbon::createFromFormat('d/m/Y', $request->fecha_inicial_seguro)->format('Y-m-d'):null,
            'fecha_final_seguro' => $request->fecha_final_seguro ? Carbon::createFromFormat('d/m/Y', $request->fecha_final_seguro)->format('Y-m-d'):null,
            'observaciones' => $request->observaciones,
            'importe' => $request->importe ? $this->money_format->clearFormat($request->importe):null,
            'op_estatus' => 1,
            'id_status_delete' => 1,

            'valor_factura' => $request->valor_factura ? $this->money_format->clearFormat($request->valor_factura):null,
            'fecha_factura_eq_esp' => $request->fecha_factura_eq_esp ? Carbon::createFromFormat('d/m/Y', $request->fecha_factura_eq_esp )->format('Y-m-d'):null,
            'fecha_factura_adaptacion' => $request->fecha_factura_adaptacion ? Carbon::createFromFormat('d/m/Y', $request->fecha_factura_adaptacion)->format('Y-m-d'):null,

            'descripcion' => $request->descripcion,
            'modelo' => $request->modelo,
            'serie' => $request->serie,
            'uso_unidad_poliza' => $request->uso_unidad_poliza,
            'valor_eq_esp' => $request->valor_eq_esp ? $this->money_format->clearFormat($request->valor_eq_esp):null,
            'valor_adaptacion' => $request->valor_adaptacion ? $this->money_format->clearFormat($request->valor_adaptacion):null,
            'nombre_archivo_poliza' => $request->nombre_archivo_poliza,
            'inciso' => $request->inciso,
            'prima_neta' => $request->prima_neta ? $this->money_format->clearFormat($request->prima_neta):null,
            'recargos' => $request->recargos ? $this->money_format->clearFormat($request->recargos):null,
            'gastos_exp' => $request->gastos_exp ? $this->money_format->clearFormat($request->gastos_exp):null,
            'sub_total' => $request->sub_total ? $this->money_format->clearFormat($request->sub_total):null,
            'iva' => $request->iva ? $this->money_format->clearFormat($request->iva):null,
            'prima_total' => $request->prima_total ? $this->money_format->clearFormat($request->prima_total):null,
            'primer_recibo' => $request->primer_recibo ? $this->money_format->clearFormat($request->primer_recibo):null,
            'recibos_sub' => $request->recibos_sub ? $this->money_format->clearFormat($request->recibos_sub):null,

            'servicio'=> $request->servicio,
            'tramite_estatus'=> $request->estatus,

            'created_at' =>date('Y-m-d H:i:s'),
            'updated_at' =>date('Y-m-d H:i:s'),
            'iduserCreated' =>auth()->user()->id,
            'iduserUpdated' =>auth()->user()->id,
        ];
        $unidad_tramite_info_id = TramiteAseguramientoInfo::insertGetId($data);

        $colIdDocumento = $request->id_documento;
        if($request->hasfile('archivo')){
            $archivos = $request->file('archivo');
            foreach($archivos as $indice => $archivo)
            {
                $archivoNombre = $archivo->hashName();
                $mimeType = $archivo->getMimeType();
                Storage::putFileAs('unidad/' . $request->id_unidad, $archivo, $archivoNombre);
                $data = [
                	'unidad_id'=>$request->id_unidad,
                    'unidad_tramite_aseguramiento_info_id' => $unidad_tramite_info_id,
                    'id_evidencia' =>$colIdDocumento[$indice],
                    'documento' => $archivoNombre,
                    'created_at' =>date('Y-m-d H:i:s'),
                    'iduserCreated' =>auth()->user()->id
                ];
                TramiteAseguramientoDoc::insert($data);
            }
        }

        session()->flash('success', 'La información del tramite se añadió correctamente');
        return redirect()->route('traveh.tvaseguramiento', $request->id_unidad);     	
    }

    public function vistaeditaseguramiento($id_unidad, $id_pago)
    {
    	$aseguradora = AseguradoraUnidad::where('id_status_delete', 1)->get();
    	$tipo_cobertura =TipoCobertura::where('id_status_delete', 1)->get();
    	$info_propietario = InformacionPropietario::where('id_status_delete', 1)->get();
        $documentos = TramiteAseguramientoEvidencia::where('id_status_delete',1)->get();

    	$tramite_info  = TramiteAseguramientoInfo::where('id', $id_pago)->first();
    	$tramite_evidencia  = TramiteAseguramientoDoc::where('unidad_tramite_aseguramiento_info_id', $id_pago)->get();
        $gestor = TramiteGestor::where('id_status_delete',1)->get();
        $estatus_aseg = TramiteAseguramientoEstatus::where('id_status_delete',1)->get();

        //tipo de documentos en formato json
        $cadenaTipoDocumento = "";
        foreach($documentos as $documento){
            $cadenaTipoDocumento .= '"'.$documento->id.'":"'.$documento->nombre_evidencia.'",';
        }
        $cadenaTipoDocumento = '{'.rtrim($cadenaTipoDocumento, ',').'}';

        return view('unidades.tramitesvehiculares.tramiteunidad.aseguramiento.tramite-aseguramiento-editar', compact('info_propietario', 'cadenaTipoDocumento', 'id_unidad', 'aseguradora', 'tipo_cobertura', 'tramite_info', 'tramite_evidencia', 'id_pago', 'gestor', 'estatus_aseg'));        	
    }

    public function eliminardocumentoevaseg(Request $request)
    {
        $doc = TramiteAseguramientoDoc::findOrFail($request->id);
        $estatus = true;
        if ($doc){
            Storage::delete('unidad/'. $request->unidad_id.'/'.$doc->documento);
            TramiteAseguramientoDoc::where('id', $request->id)->delete();
        }else{
            $estatus = false;
        }

        return response()->json([
            'estatus' => $estatus,
        ]);    	
    }

    public function editinfoevaseguramiento(Request $request)
    {

        $data = [
        	'id_aseguradora' => $request->aseguradora_id,
        	'fecha_vencimiento_poliza' => $request->fecha_final_seguro ? Carbon::createFromFormat('d/m/Y', $request->fecha_final_seguro)->format('Y-m-d'):null,
        	'no_poliza_seguro' => $request->no_poliza,
            'updated_at' =>date('Y-m-d H:i:s'),
            'iduserUpdated' =>auth()->user()->id,
        ];

        Unidad::where('id', $request->id_unidad)->update($data);


        $data = [
        	'unidad_id' => $request->id_unidad,
        	'unidad_informacion_propietario_id' => $request->id_propietario,
        	'aseguradora_id' => $request->aseguradora_id,
        	'tipo_cobertura_id' => $request->tipo_cobertura_id,
        	'no_poliza' => $request->no_poliza,
            'fecha_inicial_seguro' => $request->fecha_inicial_seguro ? Carbon::createFromFormat('d/m/Y', $request->fecha_inicial_seguro)->format('Y-m-d'):null,
            'fecha_final_seguro' => $request->fecha_final_seguro ? Carbon::createFromFormat('d/m/Y', $request->fecha_final_seguro)->format('Y-m-d'):null,
            'observaciones' => $request->observaciones,
            'importe' => $request->importe ? $this->money_format->clearFormat($request->importe):null,

            'valor_factura' => $request->valor_factura ? $this->money_format->clearFormat($request->valor_factura):null,
            'fecha_factura_eq_esp' => $request->fecha_factura_eq_esp ? Carbon::createFromFormat('d/m/Y', $request->fecha_factura_eq_esp )->format('Y-m-d'):null,
            'fecha_factura_adaptacion' => $request->fecha_factura_adaptacion ? Carbon::createFromFormat('d/m/Y', $request->fecha_factura_adaptacion)->format('Y-m-d'):null,

            'descripcion' => $request->descripcion,
            'modelo' => $request->modelo,
            'serie' => $request->serie,
            'uso_unidad_poliza' => $request->uso_unidad_poliza,
            'valor_eq_esp' => $request->valor_eq_esp ? $this->money_format->clearFormat($request->valor_eq_esp):null,
            'valor_adaptacion' => $request->valor_adaptacion ? $this->money_format->clearFormat($request->valor_adaptacion):null,
            'nombre_archivo_poliza' => $request->nombre_archivo_poliza,
            'inciso' => $request->inciso,
            'prima_neta' => $request->prima_neta ? $this->money_format->clearFormat($request->prima_neta):null,
            'recargos' => $request->recargos ? $this->money_format->clearFormat($request->recargos):null,
            'gastos_exp' => $request->gastos_exp ? $this->money_format->clearFormat($request->gastos_exp):null,
            'sub_total' => $request->sub_total ? $this->money_format->clearFormat($request->sub_total):null,
            'iva' => $request->iva ? $this->money_format->clearFormat($request->iva):null,
            'prima_total' => $request->prima_total ? $this->money_format->clearFormat($request->prima_total):null,
            'primer_recibo' => $request->primer_recibo ? $this->money_format->clearFormat($request->primer_recibo):null,
            'recibos_sub' => $request->recibos_sub ? $this->money_format->clearFormat($request->recibos_sub):null,
            'servicio'=> $request->servicio,
            'tramite_estatus'=> $request->estatus,

            'updated_at' =>date('Y-m-d H:i:s'),
            'iduserUpdated' =>auth()->user()->id,
        ];
        TramiteAseguramientoInfo::where('id', $request->id_pago)->update($data);

        $colIdDocumento = $request->id_documento;
        if($request->hasfile('archivo')){
            $archivos = $request->file('archivo');
            foreach($archivos as $indice => $archivo)
            {
                $archivoNombre = $archivo->hashName();
                $mimeType = $archivo->getMimeType();
                Storage::putFileAs('unidad/' . $request->id_unidad, $archivo, $archivoNombre);
                $data = [
                	'unidad_id'=>$request->id_unidad,
                    'unidad_tramite_aseguramiento_info_id' => $request->id_pago,
                    'id_evidencia' =>$colIdDocumento[$indice],
                    'documento' => $archivoNombre,
                    'created_at' =>date('Y-m-d H:i:s'),
                    'iduserCreated' =>auth()->user()->id
                ];
                TramiteAseguramientoDoc::insert($data);
            }
        }

        session()->flash('success', 'La información del tramite se modifico correctamente');
        return redirect()->route('traveh.tvaseguramiento', $request->id_unidad);    	
    }

    public function vistaveraseguramiento($id_unidad, $id_pago)
    {
    	$aseguradora = AseguradoraUnidad::where('id_status_delete', 1)->get();
    	$tipo_cobertura =TipoCobertura::where('id_status_delete', 1)->get();
        $documentos = TramiteAseguramientoEvidencia::where('id_status_delete',1)->get();

    	$tramite_info  = TramiteAseguramientoInfo::where('id', $id_pago)->first();
    	$info_propietario = InformacionPropietario::where('id', $tramite_info->unidad_informacion_propietario_id)->first();
    	$tramite_evidencia  = TramiteAseguramientoDoc::where('unidad_tramite_aseguramiento_info_id', $id_pago)->get();
        $estatus_aseg = TramiteAseguramientoEstatus::where('id_status_delete',1)->get();


        $estados = Estado::orderBy('id_estado', 'asc')->where('id_status_delete', 1)->get();
        $municipios = Municipio::orderBy('id_municipio', 'asc')->where('id_status_delete', 1)->get();
        //tipo de documentos en formato json
        $cadenaTipoDocumento = "";
        foreach($documentos as $documento){
            $cadenaTipoDocumento .= '"'.$documento->id.'":"'.$documento->nombre_evidencia.'",';
        }
        $cadenaTipoDocumento = '{'.rtrim($cadenaTipoDocumento, ',').'}';

        return view('unidades.tramitesvehiculares.tramiteunidad.aseguramiento.tramite-aseguramiento-ver', compact('info_propietario', 'cadenaTipoDocumento', 'id_unidad', 'aseguradora', 'tipo_cobertura', 'tramite_info', 'tramite_evidencia', 'id_pago', 'estados', 'municipios', 'estatus_aseg'));       	
    }

    public function deleteinfoevaseguramiento(Request $request)
    {

        $data = [
        	'id_aseguradora' => null,
        	'fecha_vencimiento_poliza' => null,
        	'no_poliza_seguro' => '',
            'updated_at' =>date('Y-m-d H:i:s'),
            'iduserUpdated' =>auth()->user()->id,
        ];

        Unidad::where('id', $request->id_unidad)->update($data);



        $doc = TramiteAseguramientoDoc::where('unidad_tramite_aseguramiento_info_id', $request->id)->get();
        $estatus = true;
        if ($doc){
	        foreach ($doc as $key => $value) {
	            Storage::delete('unidad/'. $request->id_unidad.'/'.$value->documento);
	            TramiteAseguramientoDoc::where('id', $value->id)->delete();
	        }
        }else{
            $estatus = false;
        }

        $tramite_info  = TramiteAseguramientoInfo::where('id', $request->id)->delete();


        session()->flash('success', 'El registro de aseguramiento se elimino correctamente');
        return redirect()->route('traveh.tvaseguramiento', $request->id_unidad);    	
    }

    public function cargamasivaaseguramiento(Request $request)
    {
        Excel::import(new AseguramientoImport,request()->file('file_carga'));

        session()->flash('success', 'Se importó correctamente el archivo.');
        return redirect()->route('traveh.tvaseguramiento', $request->id_unidad);          
    }

// E N D   T R A M I T E  A S E G U R A M I E N T O ------------------------------------------------------------------------------------------------------------------------------  END  ASEGURAMIENTO

    public function tramitevreemplaca($id_unidad)
    {
    	$unidad = Unidad::find($id_unidad);
		$req_tramite = TramiteReemplacamientoRequisito::where('id_status_delete', 1)->get();
		$ev_tramite = TramiteReemplacamientoEvidencia::where('id_status_delete', 1)->get();
		$info_propietario = InformacionPropietario::where('id_status_delete', 1)->get();
        $marcas = MarcaUnidad::where('id_status_delete', 1)->get();
        $modelos = ModeloUnidad::where('id_status_delete', 1)->get();
        $fotografias = UnidadFotografia::where('unidad_id', $id_unidad)->get();
        $active = UnidadFotografia::where('unidad_id', $id_unidad)->first();

        if ($active == null) {
            $ver = 0;
        } else {
            $ver = $active->id;
        }

       	$req_info = TramiteReemplacamientoInfo::where('unidad_id', $id_unidad)->orderBy('id', 'DESC')->get();

    	return view('unidades.tramitesvehiculares.tramiteunidad.reemplacamiento.tramite-reemplacamiento', compact('req_tramite', 'ev_tramite', 'info_propietario', 'id_unidad', 'marcas', 'modelos', 'ver', 'fotografias', 'unidad', 'req_info'));
    }

    public function vistagrdreemplacamiento($id_unidad)
    {
    	$estados = Estado::orderBy('id_estado', 'asc')->where('id_status_delete', 1)->get();
    	$info_propietario = InformacionPropietario::where('id_status_delete', 1)->get();
        $documentos = TramiteReemplacamientoEvidencia::where('id_status_delete',1)->get();
        $gestor = TramiteGestor::where('id_status_delete',1)->get();
        $tipo_placa = TramiteTipoPlacas::where('id_status_delete',1)->get();
        //tipo de documentos en formato json
        $cadenaTipoDocumento = "";
        foreach($documentos as $documento){
            $cadenaTipoDocumento .= '"'.$documento->id.'":"'.$documento->nombre_evidencia.'",';
        }
        $cadenaTipoDocumento = '{'.rtrim($cadenaTipoDocumento, ',').'}';

        return view('unidades.tramitesvehiculares.tramiteunidad.reemplacamiento.tramite-reemplacamiento-guardar', compact('info_propietario', 'cadenaTipoDocumento', 'id_unidad', 'estados', 'gestor', 'tipo_placa'));    	
    }

    public function addinfoevreemplacamiento(Request $request)
    {
        // dd($request);
    	$upd_info_emplacamiento = TramiteEmplacamientoInfo::where('unidad_id', $request->id_unidad)->first();
    	if($upd_info_emplacamiento->op_estatus == 1)
    	{
	        $data = [
	            'op_estatus' => 2,
	            'updated_at' =>date('Y-m-d H:i:s'),
	            'iduserCreated' =>auth()->user()->id,        
	        ];
            TramiteEmplacamientoInfo::where('id', $upd_info_emplacamiento->id)->update($data);    		
    	}


        $entidad_placas = Estado::where('id_estado', $request->entidad_placas)->first();

        $data = [
        	'no_tarjeta_circulacion' => $request->tarjeta_circularion,
            'placa' => $request->numero_placas,
            'op_engomado' => $request->engomado,
            'holograma' => $request->holograma,
            'entidad_placas' => $entidad_placas->estado_nombre,
            'verificacion_op' => $request->verificacion_op,
            'updated_at' =>date('Y-m-d H:i:s'),
            'iduserUpdated' =>auth()->user()->id,
        ];

        Unidad::where('id', $request->id_unidad)->update($data);
        // Edit unidad

    	$upd_info_tenencia = TramiteReemplacamientoInfo::where('unidad_id', $request->id_unidad)->where('op_estatus', 1)->get();
    	
        foreach ($upd_info_tenencia as $key => $value) {
	        $data = [
	            'op_estatus' => 2,
	            'updated_at' =>date('Y-m-d H:i:s'),
	            'iduserCreated' =>auth()->user()->id,        
	        ];
            TramiteReemplacamientoInfo::where('id', $value->id)->update($data);
        }
        //Edit estatus reemplacamiento

        $data = [
            'unidad_tramite_gestor_id'=> $request->gestor,
            'fecha_expedicion' => $request->fecha_expedicion ? Carbon::createFromFormat('d/m/Y', $request->fecha_expedicion)->format('Y-m-d'):null,
            'unidad_tramite_tipo_placas_id' => $request->tipo_placa,
        	'unidad_id' => $request->id_unidad,
        	'id_propietario' => $request->id_propietario,
            'fecha_tramite' => $request->fecha_tramite ? Carbon::createFromFormat('d/m/Y', $request->fecha_tramite)->format('Y-m-d'):null,
            'numero_placas' => $request->numero_placas,
            'entidad_placas' => $request->entidad_placas,
            'engomado' => $request->engomado,
            'holograma' => $request->holograma,
            'verificacion_op' => $request->verificacion_op,
            'tarjeta_circularion' => $request->tarjeta_circularion,
            'fecha_emision_tarjeta' => $request->fecha_emision ? Carbon::createFromFormat('d/m/Y', $request->fecha_emision)->format('Y-m-d'):null,
            'fecha_vencimiento_tarjeta' => $request->fecha_vencimiento_placas ? Carbon::createFromFormat('d/m/Y', $request->fecha_vencimiento_placas)->format('Y-m-d'):null,
            'observaciones' => $request->observaciones,
            'importe' => $request->importe ? $this->money_format->clearFormat($request->importe):null,
            'op_estatus' => 1,
            'id_status_delete' => 1,
            'created_at' =>date('Y-m-d H:i:s'),
            'updated_at' =>date('Y-m-d H:i:s'),
            'iduserCreated' =>auth()->user()->id,
            'iduserUpdated' =>auth()->user()->id,
        ];
        $unidad_tramite_tenencia_info_id = TramiteReemplacamientoInfo::insertGetId($data);

        $colIdDocumento = $request->id_documento;
        if($request->hasfile('archivo')){
            $archivos = $request->file('archivo');
            foreach($archivos as $indice => $archivo)
            {
                $archivoNombre = $archivo->hashName();
                $mimeType = $archivo->getMimeType();
                Storage::putFileAs('unidad/' . $request->id_unidad, $archivo, $archivoNombre);
                $data = [
                	'unidad_id'=>$request->id_unidad,
                    'unidad_tramite_reemplacamiento_info_id' => $unidad_tramite_tenencia_info_id,
                    'id_evidencia' =>$colIdDocumento[$indice],
                    'documento' => $archivoNombre,
                    'created_at' =>date('Y-m-d H:i:s'),
                    'iduserCreated' =>auth()->user()->id
                ];
                TramiteReemplacamientoDoc::insert($data);
            }
        }

        session()->flash('success', 'La información de reemplacamiento se añadió correctamente');
        return redirect()->route('traveh.tvreemplaca', $request->id_unidad);   	    	
    }

    public function vistaeditreemplacamiento($id_unidad, $id_tramite)
    {
    	$tramite_info  = TramiteReemplacamientoInfo::where('id', $id_tramite)->first();
    	$tramite_evidencia  = TramiteReemplacamientoDoc::where('unidad_tramite_reemplacamiento_info_id', $id_tramite)->get();
    	$info_propietario = InformacionPropietario::where('id_status_delete', 1)->get();
    	$estados = Estado::orderBy('id_estado', 'asc')->where('id_status_delete', 1)->get();
        $documentos = TramiteReemplacamientoEvidencia::where('id_status_delete',1)->get();
        $gestor = TramiteGestor::where('id_status_delete',1)->get();
        $tipo_placa = TramiteTipoPlacas::where('id_status_delete',1)->get();
        //tipo de documentos en formato json
        $cadenaTipoDocumento = "";
        foreach($documentos as $documento){
            $cadenaTipoDocumento .= '"'.$documento->id.'":"'.$documento->nombre_evidencia.'",';
        }
        $cadenaTipoDocumento = '{'.rtrim($cadenaTipoDocumento, ',').'}';

        return view('unidades.tramitesvehiculares.tramiteunidad.reemplacamiento.tramite-reemplacamiento-editar', compact('info_propietario', 'cadenaTipoDocumento', 'id_unidad', 'tramite_info', 'id_tramite', 'tramite_evidencia', 'estados', 'gestor', 'tipo_placa'));     	
    }

    public function eliminardocumentoevreemplaca(Request $request)
    {
        $doc = TramiteReemplacamientoDoc::findOrFail($request->id);
        $estatus = true;
        if ($doc){
            Storage::delete('unidad/'. $request->unidad_id.'/'.$doc->documento);
            TramiteReemplacamientoDoc::where('id', $request->id)->delete();
        }else{
            $estatus = false;
        }

        return response()->json([
            'estatus' => $estatus,
        ]);    	
    }

    public function editinfoevreemplacamiento(Request $request)
    {
        $entidad_placas = Estado::where('id_estado', $request->entidad_placas)->first();

        $data = [
        	'no_tarjeta_circulacion' => $request->tarjeta_circularion,
            'placa' => $request->numero_placas,
            'op_engomado' => $request->engomado,
            'entidad_placas' => $entidad_placas->estado_nombre,
            'verificacion_op' => $request->verificacion_op,
            'updated_at' =>date('Y-m-d H:i:s'),
            'iduserUpdated' =>auth()->user()->id,
        ];

        Unidad::where('id', $request->id_unidad)->update($data);   
        


        $data = [
            'unidad_tramite_gestor_id'=> $request->gestor,
            'fecha_expedicion' => $request->fecha_expedicion ? Carbon::createFromFormat('d/m/Y', $request->fecha_expedicion)->format('Y-m-d'):null,
            'unidad_tramite_tipo_placas_id' => $request->tipo_placa,
        	'unidad_id' => $request->id_unidad,
        	'id_propietario' => $request->id_propietario,
            'fecha_tramite' => $request->fecha_tramite ? Carbon::createFromFormat('d/m/Y', $request->fecha_tramite)->format('Y-m-d'):null,
            'numero_placas' => $request->numero_placas,
            'entidad_placas' => $request->entidad_placas,
            'engomado' => $request->engomado,
            'holograma' => $request->holograma,
            'verificacion_op' => $request->verificacion_op,
            'tarjeta_circularion' => $request->tarjeta_circularion,
            'fecha_emision_tarjeta' => $request->fecha_emision ? Carbon::createFromFormat('d/m/Y', $request->fecha_emision)->format('Y-m-d'):null,
            'fecha_vencimiento_tarjeta' => $request->fecha_vencimiento_placas ? Carbon::createFromFormat('d/m/Y', $request->fecha_vencimiento_placas)->format('Y-m-d'):null,
            'observaciones' => $request->observaciones,
            'importe' => $request->importe ? $this->money_format->clearFormat($request->importe):null,
            'op_estatus' => 1,
            'id_status_delete' => 1,
            'updated_at' =>date('Y-m-d H:i:s'),
            'iduserUpdated' =>auth()->user()->id,
        ];
        TramiteReemplacamientoInfo::where('id', $request->id_emplacamiento)->update($data);  

        $colIdDocumento = $request->id_documento;
        if($request->hasfile('archivo')){
            $archivos = $request->file('archivo');
            foreach($archivos as $indice => $archivo)
            {
                $archivoNombre = $archivo->hashName();
                $mimeType = $archivo->getMimeType();
                Storage::putFileAs('unidad/' . $request->id_unidad, $archivo, $archivoNombre);
                $data = [
                	'unidad_id'=>$request->id_unidad,
                    'unidad_tramite_reemplacamiento_info_id' => $request->id_emplacamiento,
                    'id_evidencia' =>$colIdDocumento[$indice],
                    'documento' => $archivoNombre,
                    'created_at' =>date('Y-m-d H:i:s'),
                    'iduserCreated' =>auth()->user()->id
                ];
                TramiteReemplacamientoDoc::insert($data);
            }
        }

        session()->flash('success', 'La información de reemplacamiento se modifico correctamente');
        return redirect()->route('traveh.tvreemplaca', $request->id_unidad);     	
    }

    public function vistaverreemplacamiento($id_unidad,$id_tramite)
    {
    	$tramite_info  = TramiteReemplacamientoInfo::where('id', $id_tramite)->first();
    	$tramite_evidencia  = TramiteReemplacamientoDoc::where('unidad_tramite_reemplacamiento_info_id', $id_tramite)->get();
    	$info_propietario = InformacionPropietario::where('id', $tramite_info->id_propietario)->first();
    	$estados = Estado::orderBy('id_estado', 'asc')->where('id_status_delete', 1)->get();
        $documentos = TramiteEmplacamientoEvidencia::where('id_status_delete',1)->get();
        $municipios = Municipio::orderBy('id_municipio', 'asc')->where('id_status_delete', 1)->get();
        //tipo de documentos en formato json
        $cadenaTipoDocumento = "";
        foreach($documentos as $documento){
            $cadenaTipoDocumento .= '"'.$documento->id.'":"'.$documento->nombre_evidencia.'",';
        }
        $cadenaTipoDocumento = '{'.rtrim($cadenaTipoDocumento, ',').'}';

        return view('unidades.tramitesvehiculares.tramiteunidad.reemplacamiento.tramite-reemplacamiento-ver', compact('info_propietario', 'cadenaTipoDocumento', 'id_unidad', 'tramite_info', 'id_tramite', 'tramite_evidencia', 'estados', 'municipios'));     	
    }

    public function cargamasivareemplacamiento(Request $request)
    {
        
        Excel::import(new ReemplacamientosImport,request()->file('file_carga'));

        session()->flash('success', 'Se importó correctamente el archivo.');
        return redirect()->route('traveh.tvreemplaca', $request->id_unidad);  
    }

// E N D   T R A M I T E  R E E M P L A C A M I E N T O------------------------------------------------------------------------------------------------------------------------  END  REEMPLACAMIENTO


    public function tramitevbjsiniestro($id_unidad)
    {
    	$unidad = Unidad::find($id_unidad);
		$req_tramite = TramiteBajaVehiculoSiniestroRequisito::where('id_status_delete', 1)->get();
		$ev_tramite = TramiteBajaVehiculoSiniestroEvidencia::where('id_status_delete', 1)->get();
		$info_propietario = InformacionPropietario::where('id_status_delete', 1)->get();
        $marcas = MarcaUnidad::where('id_status_delete', 1)->get();
        $modelos = ModeloUnidad::where('id_status_delete', 1)->get();
        $fotografias = UnidadFotografia::where('unidad_id', $id_unidad)->get();
        $active = UnidadFotografia::where('unidad_id', $id_unidad)->first();

        if ($active == null) {
            $ver = 0;
        } else {
            $ver = $active->id;
        }

        $req_info = TramiteBajaVehiculoSiniestroInfo::where('unidad_id', $id_unidad)->orderBy('id', 'DESC')->get();

    	return view('unidades.tramitesvehiculares.tramiteunidad.bajavehiculo.siniestro.tramite-siniestro', compact('req_tramite', 'ev_tramite', 'info_propietario', 'id_unidad', 'marcas', 'modelos', 'ver', 'fotografias', 'unidad', 'req_info'));    	
    }

    public function vistagrbvsiniestro($id_unidad)
    {
    	$info_propietario = InformacionPropietario::where('id_status_delete', 1)->get();
        $documentos = TramiteBajaVehiculoSiniestroEvidencia::where('id_status_delete',1)->get();
        $estatus = TramiteBajaVehiculoSiniestroEstatus::where('id_status_delete',1)->get();
        $gestor = TramiteGestor::where('id_status_delete',1)->get();
        $estados = Estado::orderBy('id_estado', 'asc')->where('id_status_delete', 1)->get();
        $municipios = Municipio::orderBy('id_municipio', 'asc')->where('id_status_delete', 1)->get();
        $tipo_siniestro = TramiteBajaVehiculoSiniestroTipo::where('id_status_delete',1)->get();

        //tipo de documentos en formato json
        $cadenaTipoDocumento = "";
        foreach($documentos as $documento){
            $cadenaTipoDocumento .= '"'.$documento->id.'":"'.$documento->nombre_evidencia.'",';
        }
        $cadenaTipoDocumento = '{'.rtrim($cadenaTipoDocumento, ',').'}';

        return view('unidades.tramitesvehiculares.tramiteunidad.bajavehiculo.siniestro.tramite-siniestro-guardar', compact('info_propietario', 'cadenaTipoDocumento', 'id_unidad', 'estatus', 'gestor', 'estados', 'municipios', 'tipo_siniestro'));   	
    }

    public function addinfoevbvsiniestro(Request $request)
    {
        
    	$upd_info_tenencia = TramiteBajaVehiculoSiniestroInfo::where('unidad_id', $request->id_unidad)->where('op_estatus', 1)->get();

    	
        foreach ($upd_info_tenencia as $key => $value) {
	        $data = [
	            'op_estatus' => 2,
	            'updated_at' =>date('Y-m-d H:i:s'),
	            'iduserCreated' =>auth()->user()->id,        
	        ];
            TramiteBajaVehiculoSiniestroInfo::where('id', $value->id)->update($data);
        }


        $data = [
        	'unidad_id' => $request->id_unidad,
        	'id_propietario' => $request->id_propietario,
            'fecha_tramite' => $request->fecha_tramite ? Carbon::createFromFormat('d/m/Y', $request->fecha_tramite)->format('Y-m-d'):null,
            'observaciones' => $request->observaciones,
            'op_estatus' => 1,
            'estatus_id' => $request->estatus_id,
            'importe' => $request->importe ? $this->money_format->clearFormat($request->importe):null,
            'id_status_delete' => 1,
            'created_at' =>date('Y-m-d H:i:s'),
            'updated_at' =>date('Y-m-d H:i:s'),
            'iduserCreated' =>auth()->user()->id,
            'iduserUpdated' =>auth()->user()->id,
            'unidad_tramite_gestor_id' => $request->gestor,
            'fecha_ocurrencia' => $request->fecha_ocurrencia ? Carbon::createFromFormat('d/m/Y', $request->fecha_ocurrencia)->format('Y-m-d'):null, 
            'fecha_conclusion' => $request->fecha_conclusion ? Carbon::createFromFormat('d/m/Y', $request->fecha_conclusion)->format('Y-m-d'):null, 
            'cia_seguros' => $request->cia_seguros,
            'no_siniestro' => $request->no_siniestro,
            'no_reporte' => $request->no_reporte,
            'conductor' => $request->conductor,
            'autoridad_participante' => $request->autoridad_participante,
            'no_carpeta' => $request->no_carpeta,
            'estado_id_estado' =>$request->id_estado,
            'municipio_id_municipio' =>$request->id_municipio,
            'unidad_tramite_bajavehiculo_siniestro_tipo_id' => $request->unidad_tramite_bajavehiculo_siniestro_tipo_id,
        ];

        $unidad_tramite_bvsiniestro_info_id = TramiteBajaVehiculoSiniestroInfo::insertGetId($data);

        $colIdDocumento = $request->id_documento;
        if($request->hasfile('archivo')){
            $archivos = $request->file('archivo');
            foreach($archivos as $indice => $archivo)
            {
                $archivoNombre = $archivo->hashName();
                $mimeType = $archivo->getMimeType();
                Storage::putFileAs('unidad/' . $request->id_unidad, $archivo, $archivoNombre);
                $data = [
                	'unidad_id'=>$request->id_unidad,
                    'unidad_tramite_bajavehiculo_siniestro_info_id' => $unidad_tramite_bvsiniestro_info_id,
                    'id_evidencia' =>$colIdDocumento[$indice],
                    'documento' => $archivoNombre,
                    'created_at' =>date('Y-m-d H:i:s'),
                    'iduserCreated' =>auth()->user()->id
                ];
                TramiteBajaVehiculoSiniestroDoc::insert($data);
            }
        }

        session()->flash('success', 'El siniestro se añadió correctamente');
        return redirect()->route('traveh.tvbjsiniestro', $request->id_unidad);   	
    }

    public function vistaeditbvsiniestro($id_unidad, $id_pago)
    {

    	$tramite_info  = TramiteBajaVehiculoSiniestroInfo::where('id', $id_pago)->first();
    	$tramite_evidencia  = TramiteBajaVehiculoSiniestroDoc::where('unidad_tramite_bajavehiculo_siniestro_info_id', $id_pago)->get();
    	$info_propietario = InformacionPropietario::where('id_status_delete', 1)->get();
        $documentos = TramiteBajaVehiculoSiniestroEvidencia::where('id_status_delete',1)->get();
        $estatus = TramiteBajaVehiculoSiniestroEstatus::where('id_status_delete',1)->get();
        $gestor = TramiteGestor::where('id_status_delete',1)->get();
        $estados = Estado::orderBy('id_estado', 'asc')->where('id_status_delete', 1)->get();
        $municipios = Municipio::orderBy('id_municipio', 'asc')->where('id_status_delete', 1)->get();
        $tipo_siniestro = TramiteBajaVehiculoSiniestroTipo::where('id_status_delete',1)->get();

        //tipo de documentos en formato json
        $cadenaTipoDocumento = "";
        foreach($documentos as $documento){
            $cadenaTipoDocumento .= '"'.$documento->id.'":"'.$documento->nombre_evidencia.'",';
        }
        $cadenaTipoDocumento = '{'.rtrim($cadenaTipoDocumento, ',').'}';

        return view('unidades.tramitesvehiculares.tramiteunidad.bajavehiculo.siniestro.tramite-siniestro-editar', compact('info_propietario', 'cadenaTipoDocumento', 'id_unidad', 'tramite_info', 'id_pago', 'tramite_evidencia', 'estatus', 'gestor', 'estados','municipios', 'tipo_siniestro'));    	
    }

    public function eliminardocumentoevbvsini(Request $request)
    {
        $doc = TramiteBajaVehiculoSiniestroDoc::findOrFail($request->id);
        $estatus = true;
        if ($doc){
            Storage::delete('unidad/'. $request->unidad_id.'/'.$doc->documento);
            TramiteBajaVehiculoSiniestroDoc::where('id', $request->id)->delete();
        }else{
            $estatus = false;
        }

        return response()->json([
            'estatus' => $estatus,
        ]);    	
    }

    public function editinfoevbvsiniestro(Request $request)
    {
        $data = [
        	'id_propietario' => $request->id_propietario,
            'fecha_tramite' => $request->fecha_tramite ? Carbon::createFromFormat('d/m/Y', $request->fecha_tramite)->format('Y-m-d'):null,
            'observaciones' => $request->observaciones,
            'estatus_id' => $request->estatus_id,
            'importe' => $request->importe ? $this->money_format->clearFormat($request->importe):null,
            'updated_at' =>date('Y-m-d H:i:s'),
            'iduserUpdated' =>auth()->user()->id,
            'unidad_tramite_gestor_id' => $request->gestor,
            'fecha_ocurrencia' => $request->fecha_ocurrencia ? Carbon::createFromFormat('d/m/Y', $request->fecha_ocurrencia)->format('Y-m-d'):null, 
            'fecha_conclusion' => $request->fecha_conclusion ? Carbon::createFromFormat('d/m/Y', $request->fecha_conclusion)->format('Y-m-d'):null, 
            'cia_seguros' => $request->cia_seguros,
            'no_siniestro' => $request->no_siniestro,
            'no_reporte' => $request->no_reporte,
            'conductor' => $request->conductor,
            'autoridad_participante' => $request->autoridad_participante,
            'no_carpeta' => $request->no_carpeta,
            'estado_id_estado' =>$request->id_estado,
            'municipio_id_municipio' =>$request->id_municipio,
            'unidad_tramite_bajavehiculo_siniestro_tipo_id' => $request->unidad_tramite_bajavehiculo_siniestro_tipo_id,
        ];

        TramiteBajaVehiculoSiniestroInfo::where('id', $request->id_pago)->update($data);


        $colIdDocumento = $request->id_documento;
        if($request->hasfile('archivo')){
            $archivos = $request->file('archivo');
            foreach($archivos as $indice => $archivo)
            {
                $archivoNombre = $archivo->hashName();
                $mimeType = $archivo->getMimeType();
                Storage::putFileAs('unidad/' . $request->id_unidad, $archivo, $archivoNombre);
                $data = [
                	'unidad_id'=>$request->id_unidad,
                    'unidad_tramite_bajavehiculo_siniestro_info_id' => $request->id_pago,
                    'id_evidencia' =>$colIdDocumento[$indice],
                    'documento' => $archivoNombre,
                    'created_at' =>date('Y-m-d H:i:s'),
                    'iduserCreated' =>auth()->user()->id
                ];
                TramiteBajaVehiculoSiniestroDoc::insert($data);
            }
        }

        session()->flash('success', 'El siniestro se modifico correctamente');
        return redirect()->route('traveh.tvbjsiniestro', $request->id_unidad);    	
    }

    public function vistaverbvsiniestro($id_unidad, $id_pago)
    {
    	$tramite_info  = TramiteBajaVehiculoSiniestroInfo::where('id', $id_pago)->first();
    	$tramite_evidencia  = TramiteBajaVehiculoSiniestroDoc::where('unidad_tramite_bajavehiculo_siniestro_info_id', $id_pago)->get();
    	$info_propietario = InformacionPropietario::where('id', $tramite_info->id_propietario)->first();
        $documentos = TramiteBajaVehiculoSiniestroEvidencia::where('id_status_delete',1)->get();
        $estados = Estado::orderBy('id_estado', 'asc')->where('id_status_delete', 1)->get();
        $municipios = Municipio::orderBy('id_municipio', 'asc')->where('id_status_delete', 1)->get();
        //tipo de documentos en formato json
        $cadenaTipoDocumento = "";
        foreach($documentos as $documento){
            $cadenaTipoDocumento .= '"'.$documento->id.'":"'.$documento->nombre_evidencia.'",';
        }
        $cadenaTipoDocumento = '{'.rtrim($cadenaTipoDocumento, ',').'}';

        return view('unidades.tramitesvehiculares.tramiteunidad.bajavehiculo.siniestro.tramite-siniestro-ver', compact('info_propietario', 'cadenaTipoDocumento', 'id_unidad', 'tramite_info', 'id_pago', 'tramite_evidencia', 'estados' , 'municipios'));     	
    }

    public function deleteinfoevbvsiniestro(Request $request)
    {
        $doc = TramiteBajaVehiculoSiniestroDoc::where('unidad_tramite_bajavehiculo_siniestro_info_id', $request->id)->get();
        $estatus = true;
        if ($doc){
	        foreach ($doc as $key => $value) {
	            Storage::delete('unidad/'. $request->id_unidad.'/'.$value->documento);
	            TramiteBajaVehiculoSiniestroDoc::where('id', $value->id)->delete();
	        }
        }else{
            $estatus = false;
        }

        $tramite_info  = TramiteBajaVehiculoSiniestroInfo::where('id', $request->id)->delete();


        session()->flash('success', 'El siniestro se elimino correctamente');
        return redirect()->route('traveh.tvbjsiniestro', $request->id_unidad);    	
    }


    public function cargamasivasiniestros(Request $request)
    {
        // dd($request);
        Excel::import(new SiniestrosImport,request()->file('file_carga'));

        session()->flash('success', 'Se importó correctamente el archivo.');
        return redirect()->route('traveh.tvbjsiniestro', $request->id_unidad);  
    }

// E N D   T R A M I T E  B V  S I N I E S T R O------------------------------------------------------------------------------------------------------------------------  END  BV SINIESTRO

    public function tramitevbjventa($id_unidad)
    {
    	$unidad = Unidad::find($id_unidad);
		$req_tramite = TramiteBajaVehiculoRequisito::where('id_status_delete', 1)->get();
		$ev_tramite = TramiteBajaVehiculoEvidencia::where('id_status_delete', 1)->get();
		$info_propietario = InformacionPropietario::where('id_status_delete', 1)->get();
        $marcas = MarcaUnidad::where('id_status_delete', 1)->get();
        $modelos = ModeloUnidad::where('id_status_delete', 1)->get();
        $fotografias = UnidadFotografia::where('unidad_id', $id_unidad)->get();
        $active = UnidadFotografia::where('unidad_id', $id_unidad)->first();

        if ($active == null) {
            $ver = 0;
        } else {
            $ver = $active->id;
        }

        $req_info = TramiteBajaVehiculoVentaInfo::where('unidad_id', $id_unidad)->orderBy('id', 'DESC')->get();

    	return view('unidades.tramitesvehiculares.tramiteunidad.bajavehiculo.venta.tramite-venta', compact('req_tramite', 'ev_tramite', 'info_propietario', 'id_unidad', 'marcas', 'modelos', 'ver', 'fotografias', 'unidad', 'req_info')); 
    }

    public function vistagrbvventa($id_unidad)
    {
    	$info_propietario = InformacionPropietario::where('id_status_delete', 1)->get();
        $documentos = TramiteBajaVehiculoEvidencia::where('id_status_delete',1)->get();

        //tipo de documentos en formato json
        $cadenaTipoDocumento = "";
        foreach($documentos as $documento){
            $cadenaTipoDocumento .= '"'.$documento->id.'":"'.$documento->nombre_evidencia.'",';
        }
        $cadenaTipoDocumento = '{'.rtrim($cadenaTipoDocumento, ',').'}';

        return view('unidades.tramitesvehiculares.tramiteunidad.bajavehiculo.venta.tramite-venta-guardar', compact('info_propietario', 'cadenaTipoDocumento', 'id_unidad'));     	
    }

    public function addinfoevbvventa(Request $request)
    {
    	$unidad_edit = Unidad::where('id', $request->id_unidad)->first();
    	

	        $data = [
	            'id_status_delete' => 2,
	            'op_tramite_desactivar' => 1,
	            'motivo_desactivar'=> "UNIDAD VENDIDA",
	            'updated_at' =>date('Y-m-d H:i:s'),
	            'iduserCreated' =>auth()->user()->id,        
	        ];
            Unidad::where('id', $request->id_unidad)->update($data);
        

        $data = [
        	'unidad_id' => $request->id_unidad,
        	'id_propietario' => $request->id_propietario,
            'fecha_tramite' => $request->fecha_tramite ? Carbon::createFromFormat('d/m/Y', $request->fecha_tramite)->format('Y-m-d'):null,
            'observaciones' => $request->observaciones,
            'op_estatus' => 1,
            'id_status_delete' => 1,
            'created_at' =>date('Y-m-d H:i:s'),
            'updated_at' =>date('Y-m-d H:i:s'),
            'iduserCreated' =>auth()->user()->id,
            'iduserUpdated' =>auth()->user()->id,
        ];
        $unidad_tramite_bvsiniestro_info_id = TramiteBajaVehiculoVentaInfo::insertGetId($data);

        $colIdDocumento = $request->id_documento;
        if($request->hasfile('archivo')){
            $archivos = $request->file('archivo');
            foreach($archivos as $indice => $archivo)
            {
                $archivoNombre = $archivo->hashName();
                $mimeType = $archivo->getMimeType();
                Storage::putFileAs('unidad/' . $request->id_unidad, $archivo, $archivoNombre);
                $data = [
                	'unidad_id'=>$request->id_unidad,
                    'unidad_tramite_bajavehiculo_venta_info_id' => $unidad_tramite_bvsiniestro_info_id,
                    'id_evidencia' =>$colIdDocumento[$indice],
                    'documento' => $archivoNombre,
                    'created_at' =>date('Y-m-d H:i:s'),
                    'iduserCreated' =>auth()->user()->id
                ];
                TramiteBajaVehiculoVentaDoc::insert($data);
            }
        }

        session()->flash('success', 'La información de la venta se añadió correctamente');
        return redirect()->route('traveh.tvbjventa', $request->id_unidad);    	
    }

    public function vistaeditbvventa($id_unidad, $id_pago)
    {

    	$tramite_info  = TramiteBajaVehiculoVentaInfo::where('id', $id_pago)->first();
    	$tramite_evidencia  = TramiteBajaVehiculoVentaDoc::where('unidad_tramite_bajavehiculo_venta_info_id', $id_pago)->get();
    	$info_propietario = InformacionPropietario::where('id_status_delete', 1)->get();
        $documentos = TramiteBajaVehiculoEvidencia::where('id_status_delete',1)->get();

        //tipo de documentos en formato json
        $cadenaTipoDocumento = "";
        foreach($documentos as $documento){
            $cadenaTipoDocumento .= '"'.$documento->id.'":"'.$documento->nombre_evidencia.'",';
        }
        $cadenaTipoDocumento = '{'.rtrim($cadenaTipoDocumento, ',').'}';

        return view('unidades.tramitesvehiculares.tramiteunidad.bajavehiculo.venta.tramite-venta-editar', compact('info_propietario', 'cadenaTipoDocumento', 'id_unidad', 'tramite_info', 'id_pago', 'tramite_evidencia'));       	
    }

    public function eliminardocumentoevbvventa(Request $request)
    {
        $doc = TramiteBajaVehiculoVentaDoc::findOrFail($request->id);
        $estatus = true;
        if ($doc){
            Storage::delete('unidad/'. $request->unidad_id.'/'.$doc->documento);
            TramiteBajaVehiculoVentaDoc::where('id', $request->id)->delete();
        }else{
            $estatus = false;
        }

        return response()->json([
            'estatus' => $estatus,
        ]);     	
    }

    public function editinfoevbvventa(Request $request)
    {
        $data = [
        	'id_propietario' => $request->id_propietario,
            'fecha_tramite' => $request->fecha_tramite ? Carbon::createFromFormat('d/m/Y', $request->fecha_tramite)->format('Y-m-d'):null,
            'observaciones' => $request->observaciones,
            'updated_at' =>date('Y-m-d H:i:s'),
            'iduserUpdated' =>auth()->user()->id,
        ];

        TramiteBajaVehiculoVentaInfo::where('id', $request->id_pago)->update($data);


        $colIdDocumento = $request->id_documento;
        if($request->hasfile('archivo')){
            $archivos = $request->file('archivo');
            foreach($archivos as $indice => $archivo)
            {
                $archivoNombre = $archivo->hashName();
                $mimeType = $archivo->getMimeType();
                Storage::putFileAs('unidad/' . $request->id_unidad, $archivo, $archivoNombre);
                $data = [
                	'unidad_id'=>$request->id_unidad,
                    'unidad_tramite_bajavehiculo_venta_info_id' => $request->id_pago,
                    'id_evidencia' =>$colIdDocumento[$indice],
                    'documento' => $archivoNombre,
                    'created_at' =>date('Y-m-d H:i:s'),
                    'iduserCreated' =>auth()->user()->id
                ];
                TramiteBajaVehiculoVentaDoc::insert($data);
            }
        }

        session()->flash('success', 'La información de la venta se modifico correctamente');
        return redirect()->route('traveh.tvbjventa', $request->id_unidad);       	
    }

    public function vistaverbvventa($id_unidad, $id_pago)
    {
    	$tramite_info  = TramiteBajaVehiculoVentaInfo::where('id', $id_pago)->first();
    	$tramite_evidencia  = TramiteBajaVehiculoVentaDoc::where('unidad_tramite_bajavehiculo_venta_info_id', $id_pago)->get();
    	$info_propietario = InformacionPropietario::where('id_status_delete', 1)->get();
        $documentos = TramiteBajaVehiculoEvidencia::where('id_status_delete',1)->get();
		$info_propietario = InformacionPropietario::where('id', $tramite_info->id_propietario)->first();
        $estados = Estado::orderBy('id_estado', 'asc')->where('id_status_delete', 1)->get();
        $municipios = Municipio::orderBy('id_municipio', 'asc')->where('id_status_delete', 1)->get();
        //tipo de documentos en formato json
        $cadenaTipoDocumento = "";
        foreach($documentos as $documento){
            $cadenaTipoDocumento .= '"'.$documento->id.'":"'.$documento->nombre_evidencia.'",';
        }
        $cadenaTipoDocumento = '{'.rtrim($cadenaTipoDocumento, ',').'}';

    	return view('unidades.tramitesvehiculares.tramiteunidad.bajavehiculo.venta.tramite-venta-ver', compact('info_propietario', 'cadenaTipoDocumento', 'id_unidad', 'tramite_info', 'id_pago', 'tramite_evidencia', 'estados', 'municipios'));     	
    }

    public function cargamasivaventa(Request $request)
    {
        Excel::import(new VentaImport,request()->file('file_carga'));

        session()->flash('success', 'Se importó correctamente el archivo.');
        return redirect()->route('traveh.tvbjventa', $request->id_unidad);              
    }


// E N D   T R A M I T E  B V   V E N T A------------------------------------------------------------------------------------------------------------------------  END  BV VENTA

    public function tramitevbjrobo($id_unidad)
    {
    	$unidad = Unidad::find($id_unidad);
		$req_tramite = TramiteBajaVehiculoRoboRequisito::where('id_status_delete', 1)->get();
		$ev_tramite = TramiteBajaVehiculoRoboEvidencia::where('id_status_delete', 1)->get();
		$info_propietario = InformacionPropietario::where('id_status_delete', 1)->get();
        $marcas = MarcaUnidad::where('id_status_delete', 1)->get();
        $modelos = ModeloUnidad::where('id_status_delete', 1)->get();
        $fotografias = UnidadFotografia::where('unidad_id', $id_unidad)->get();
        $active = UnidadFotografia::where('unidad_id', $id_unidad)->first();

        if ($active == null) {
            $ver = 0;
        } else {
            $ver = $active->id;
        }

        $req_info = TramiteBajaVehiculoRoboInfo::where('unidad_id', $id_unidad)->orderBy('id', 'DESC')->get();

    	return view('unidades.tramitesvehiculares.tramiteunidad.bajavehiculo.robo.tramite-robo', compact('req_tramite', 'ev_tramite', 'info_propietario', 'id_unidad', 'marcas', 'modelos', 'ver', 'fotografias', 'unidad', 'req_info'));     	
    }

    public function vistagrbvrobo($id_unidad)
    {
    	$info_propietario = InformacionPropietario::where('id_status_delete', 1)->get();
        $documentos = TramiteBajaVehiculoRoboEvidencia::where('id_status_delete',1)->get();

        //tipo de documentos en formato json
        $cadenaTipoDocumento = "";
        foreach($documentos as $documento){
            $cadenaTipoDocumento .= '"'.$documento->id.'":"'.$documento->nombre_evidencia.'",';
        }
        $cadenaTipoDocumento = '{'.rtrim($cadenaTipoDocumento, ',').'}';

        return view('unidades.tramitesvehiculares.tramiteunidad.bajavehiculo.robo.tramite-robo-guardar', compact('info_propietario', 'cadenaTipoDocumento', 'id_unidad'));   	    	
    }

    public function addinfoevbvrobo(Request $request)
    {
    	$unidad_edit = Unidad::where('id', $request->id_unidad)->first();
    	

	        $data = [
	            'id_status_delete' => 2,
	            'op_tramite_desactivar' => 1,
	            'motivo_desactivar'=> "UNIDAD ROBADA",
	            'updated_at' =>date('Y-m-d H:i:s'),
	            'iduserCreated' =>auth()->user()->id,        
	        ];
            Unidad::where('id', $request->id_unidad)->update($data);
        

        $data = [
        	'unidad_id' => $request->id_unidad,
        	'id_propietario' => $request->id_propietario,
            'fecha_tramite' => $request->fecha_tramite ? Carbon::createFromFormat('d/m/Y', $request->fecha_tramite)->format('Y-m-d'):null,
            'observaciones' => $request->observaciones,
            'op_estatus' => 1,
            'id_status_delete' => 1,
            'created_at' =>date('Y-m-d H:i:s'),
            'updated_at' =>date('Y-m-d H:i:s'),
            'iduserCreated' =>auth()->user()->id,
            'iduserUpdated' =>auth()->user()->id,
        ];
        $unidad_tramite_bvsiniestro_info_id = TramiteBajaVehiculoRoboInfo::insertGetId($data);

        $colIdDocumento = $request->id_documento;
        if($request->hasfile('archivo')){
            $archivos = $request->file('archivo');
            foreach($archivos as $indice => $archivo)
            {
                $archivoNombre = $archivo->hashName();
                $mimeType = $archivo->getMimeType();
                Storage::putFileAs('unidad/' . $request->id_unidad, $archivo, $archivoNombre);
                $data = [
                	'unidad_id'=>$request->id_unidad,
                    'unidad_tramite_bajavehiculo_robo_info_id' => $unidad_tramite_bvsiniestro_info_id,
                    'id_evidencia' =>$colIdDocumento[$indice],
                    'documento' => $archivoNombre,
                    'created_at' =>date('Y-m-d H:i:s'),
                    'iduserCreated' =>auth()->user()->id
                ];
                TramiteBajaVehiculoRoboDoc::insert($data);
            }
        }

        session()->flash('success', 'La información del robo se añadió correctamente');
        return redirect()->route('traveh.tvbjrobo', $request->id_unidad);    	   	
    }

    public function vistaeditbvrobo($id_unidad, $id_pago)
    {
    	$tramite_info  = TramiteBajaVehiculoRoboInfo::where('id', $id_pago)->first();
    	$tramite_evidencia  = TramiteBajaVehiculoRoboDoc::where('unidad_tramite_bajavehiculo_robo_info_id', $id_pago)->get();
    	$info_propietario = InformacionPropietario::where('id_status_delete', 1)->get();
        $documentos = TramiteBajaVehiculoRoboEvidencia::where('id_status_delete',1)->get();

        //tipo de documentos en formato json
        $cadenaTipoDocumento = "";
        foreach($documentos as $documento){
            $cadenaTipoDocumento .= '"'.$documento->id.'":"'.$documento->nombre_evidencia.'",';
        }
        $cadenaTipoDocumento = '{'.rtrim($cadenaTipoDocumento, ',').'}';

        return view('unidades.tramitesvehiculares.tramiteunidad.bajavehiculo.robo.tramite-robo-editar', compact('info_propietario', 'cadenaTipoDocumento', 'id_unidad', 'tramite_info', 'id_pago', 'tramite_evidencia'));  	
    }

    public function eliminardocumentoevbvrobo(Request $request)
    {
        $doc = TramiteBajaVehiculoRoboDoc::findOrFail($request->id);
        $estatus = true;
        if ($doc){
            Storage::delete('unidad/'. $request->unidad_id.'/'.$doc->documento);
            TramiteBajaVehiculoRoboDoc::where('id', $request->id)->delete();
        }else{
            $estatus = false;
        }

        return response()->json([
            'estatus' => $estatus,
        ]);  
    }

    public function editinfoevbvrobo(Request $request)
    {
        $data = [
        	'id_propietario' => $request->id_propietario,
            'fecha_tramite' => $request->fecha_tramite ? Carbon::createFromFormat('d/m/Y', $request->fecha_tramite)->format('Y-m-d'):null,
            'observaciones' => $request->observaciones,
            'updated_at' =>date('Y-m-d H:i:s'),
            'iduserUpdated' =>auth()->user()->id,
        ];

        TramiteBajaVehiculoRoboInfo::where('id', $request->id_pago)->update($data);


        $colIdDocumento = $request->id_documento;
        if($request->hasfile('archivo')){
            $archivos = $request->file('archivo');
            foreach($archivos as $indice => $archivo)
            {
                $archivoNombre = $archivo->hashName();
                $mimeType = $archivo->getMimeType();
                Storage::putFileAs('unidad/' . $request->id_unidad, $archivo, $archivoNombre);
                $data = [
                	'unidad_id'=>$request->id_unidad,
                    'unidad_tramite_bajavehiculo_robo_info_id' => $request->id_pago,
                    'id_evidencia' =>$colIdDocumento[$indice],
                    'documento' => $archivoNombre,
                    'created_at' =>date('Y-m-d H:i:s'),
                    'iduserCreated' =>auth()->user()->id
                ];
                TramiteBajaVehiculoRoboDoc::insert($data);
            }
        }

        session()->flash('success', 'La información del robo se modifico correctamente');
        return redirect()->route('traveh.tvbjrobo', $request->id_unidad);      	
    }

    public function vistaverbvrobo($id_unidad, $id_pago)
    {
    	$tramite_info  = TramiteBajaVehiculoRoboInfo::where('id', $id_pago)->first();
    	$tramite_evidencia  = TramiteBajaVehiculoRoboDoc::where('unidad_tramite_bajavehiculo_robo_info_id', $id_pago)->get();
    	$info_propietario = InformacionPropietario::where('id', $tramite_info->id_propietario)->first();
        $documentos = TramiteBajaVehiculoRoboEvidencia::where('id_status_delete',1)->get();
        $estados = Estado::orderBy('id_estado', 'asc')->where('id_status_delete', 1)->get();
        $municipios = Municipio::orderBy('id_municipio', 'asc')->where('id_status_delete', 1)->get();
        //tipo de documentos en formato json
        $cadenaTipoDocumento = "";
        foreach($documentos as $documento){
            $cadenaTipoDocumento .= '"'.$documento->id.'":"'.$documento->nombre_evidencia.'",';
        }
        $cadenaTipoDocumento = '{'.rtrim($cadenaTipoDocumento, ',').'}';

    	return view('unidades.tramitesvehiculares.tramiteunidad.bajavehiculo.robo.tramite-robo-ver', compact('info_propietario', 'cadenaTipoDocumento', 'id_unidad', 'tramite_info', 'id_pago', 'tramite_evidencia', 'estados', 'municipios'));     	    	
    }

    public function cargamasivarobo(Request $request)
    {
        Excel::import(new RoboImport,request()->file('file_carga'));

        session()->flash('success', 'Se importó correctamente el archivo.');
        return redirect()->route('traveh.tvbjrobo', $request->id_unidad);         
    }

// E N D   T R A M I T E  B V   R O B O ------------------------------------------------------------------------------------------------------------------------  END  BV ROBO

    public function tramitevcambiopro($id_unidad)
    {
    	$unidad = Unidad::find($id_unidad);
		$req_tramite = TramiteCambioPropietarioRequisito::where('id_status_delete', 1)->get();
		$ev_tramite = TramiteCambioPropietarioEvidencia::where('id_status_delete', 1)->get();
		$info_propietario = InformacionPropietario::where('id_status_delete', 1)->get();
        $marcas = MarcaUnidad::where('id_status_delete', 1)->get();
        $modelos = ModeloUnidad::where('id_status_delete', 1)->get();
        $fotografias = UnidadFotografia::where('unidad_id', $id_unidad)->get();
        $active = UnidadFotografia::where('unidad_id', $id_unidad)->first();

        if ($active == null) {
            $ver = 0;
        } else {
            $ver = $active->id;
        }

        $req_info = TramiteCambioPropietarioInfo::where('unidad_id', $id_unidad)->orderBy('id', 'DESC')->get();

    	return view('unidades.tramitesvehiculares.tramiteunidad.cambiopropietario.tramite-cambiopropietario', compact('req_tramite', 'ev_tramite', 'info_propietario', 'id_unidad', 'marcas', 'modelos', 'ver', 'fotografias', 'unidad', 'req_info'));
    }

    public function vistagrdcambiopro($id_unidad)
    {
    	$info_propietario = InformacionPropietario::where('id_status_delete', 1)->get();
        $documentos = TramiteCambioPropietarioEvidencia::where('id_status_delete',1)->get();
        $gestor = TramiteGestor::where('id_status_delete',1)->get();

        //tipo de documentos en formato json
        $cadenaTipoDocumento = "";
        foreach($documentos as $documento){
            $cadenaTipoDocumento .= '"'.$documento->id.'":"'.$documento->nombre_evidencia.'",';
        }
        $cadenaTipoDocumento = '{'.rtrim($cadenaTipoDocumento, ',').'}';

        return view('unidades.tramitesvehiculares.tramiteunidad.cambiopropietario.tramite-cambiopropietario-guardar', compact('info_propietario', 'cadenaTipoDocumento', 'id_unidad', 'gestor'));   	
    }

    public function addinfoevcambiopro(Request $request)
    {
    	$upd_info_tenencia = TramiteCambioPropietarioInfo::where('op_estatus', 1)->get();
    	
        foreach ($upd_info_tenencia as $key => $value) {
	        $data = [
	            'op_estatus' => 2,
	            'updated_at' =>date('Y-m-d H:i:s'),
	            'iduserCreated' =>auth()->user()->id,        
	        ];
            TramiteCambioPropietarioInfo::where('id', $value->id)->update($data);
        }

        $data = [
            'unidad_tramite_gestor_id'=> $request->gestor,
        	'unidad_id' => $request->id_unidad,
        	'id_propietario' => $request->id_propietario,
            'fecha_tramite' => $request->fecha_pago ? Carbon::createFromFormat('d/m/Y', $request->fecha_pago)->format('Y-m-d'):null,
            'observaciones' => $request->observaciones,
            'importe' => $request->importe ? $this->money_format->clearFormat($request->importe):null,
            'op_estatus' => 1,
            'id_status_delete' => 1,
            'created_at' =>date('Y-m-d H:i:s'),
            'updated_at' =>date('Y-m-d H:i:s'),
            'iduserCreated' =>auth()->user()->id,
            'iduserUpdated' =>auth()->user()->id,
        ];
        $unidad_tramite_tenencia_info_id = TramiteCambioPropietarioInfo::insertGetId($data);

        $colIdDocumento = $request->id_documento;
        if($request->hasfile('archivo')){
            $archivos = $request->file('archivo');
            foreach($archivos as $indice => $archivo)
            {
                $archivoNombre = $archivo->hashName();
                $mimeType = $archivo->getMimeType();
                Storage::putFileAs('unidad/' . $request->id_unidad, $archivo, $archivoNombre);
                $data = [
                	'unidad_id'=>$request->id_unidad,
                    'unidad_tramite_cambiopropietario_info_id' => $unidad_tramite_tenencia_info_id,
                    'id_evidencia' =>$colIdDocumento[$indice],
                    'documento' => $archivoNombre,
                    'created_at' =>date('Y-m-d H:i:s'),
                    'iduserCreated' =>auth()->user()->id
                ];
                TramiteCambioPropietarioDoc::insert($data);
            }
        }

        session()->flash('success', 'El tramite se añadió correctamente');
        return redirect()->route('traveh.tvcambiopro', $request->id_unidad);    	
    }

    public function vistaeditcambiopro($id_unidad, $id_pago)
    {
    	$tramite_info  = TramiteCambioPropietarioInfo::where('id', $id_pago)->first();
    	$tramite_evidencia  = TramiteCambioPropietarioDoc::where('unidad_tramite_cambiopropietario_info_id', $id_pago)->get();
    	$info_propietario = InformacionPropietario::where('id_status_delete', 1)->get();
        $documentos = TramiteCambioPropietarioEvidencia::where('id_status_delete',1)->get();
        $gestor = TramiteGestor::where('id_status_delete',1)->get();

        //tipo de documentos en formato json
        $cadenaTipoDocumento = "";
        foreach($documentos as $documento){
            $cadenaTipoDocumento .= '"'.$documento->id.'":"'.$documento->nombre_evidencia.'",';
        }
        $cadenaTipoDocumento = '{'.rtrim($cadenaTipoDocumento, ',').'}';

        return view('unidades.tramitesvehiculares.tramiteunidad.cambiopropietario.tramite-cambiopropietario-editar', compact('info_propietario', 'cadenaTipoDocumento', 'id_unidad', 'tramite_info', 'id_pago', 'tramite_evidencia', 'gestor'));    	
    }

    public function eliminardocumentoevcambiop(Request $request)
    {
        $doc = TramiteCambioPropietarioDoc::findOrFail($request->id);
        $estatus = true;
        if ($doc){
            Storage::delete('unidad/'. $request->unidad_id.'/'.$doc->documento);
            TramiteCambioPropietarioDoc::where('id', $request->id)->delete();
        }else{
            $estatus = false;
        }

        return response()->json([
            'estatus' => $estatus,
        ]);
    }

    public function editinfoevcambiopro(Request $request)
    {
        $data = [
            'unidad_tramite_gestor_id'=> $request->gestor,
        	'id_propietario' => $request->id_propietario,
            'fecha_tramite' => $request->fecha_pago ? Carbon::createFromFormat('d/m/Y', $request->fecha_pago)->format('Y-m-d'):null,
            'observaciones' => $request->observaciones,
            'importe' => $request->importe ? $this->money_format->clearFormat($request->importe):null,
            'updated_at' =>date('Y-m-d H:i:s'),
            'iduserUpdated' =>auth()->user()->id,
        ];

        TramiteCambioPropietarioInfo::where('id', $request->id_pago)->update($data);


        $colIdDocumento = $request->id_documento;
        if($request->hasfile('archivo')){
            $archivos = $request->file('archivo');
            foreach($archivos as $indice => $archivo)
            {
                $archivoNombre = $archivo->hashName();
                $mimeType = $archivo->getMimeType();
                Storage::putFileAs('unidad/' . $request->id_unidad, $archivo, $archivoNombre);
                $data = [
                	'unidad_id'=>$request->id_unidad,
                    'unidad_tramite_cambiopropietario_info_id' => $request->id_pago,
                    'id_evidencia' =>$colIdDocumento[$indice],
                    'documento' => $archivoNombre,
                    'created_at' =>date('Y-m-d H:i:s'),
                    'iduserCreated' =>auth()->user()->id
                ];
                TramiteCambioPropietarioDoc::insert($data);
            }
        }

        session()->flash('success', 'El tramite se se modifico correctamente');
        return redirect()->route('traveh.tvcambiopro', $request->id_unidad);   
    }

    public function vistavercambiopro($id_unidad, $id_pago)
    {
    	$tramite_info  = TramiteCambioPropietarioInfo::where('id', $id_pago)->first();
    	$tramite_evidencia  = TramiteCambioPropietarioDoc::where('unidad_tramite_cambiopropietario_info_id', $id_pago)->get();
    	$info_propietario = InformacionPropietario::where('id', $tramite_info->id_propietario)->first();
        $documentos = TramiteCambioPropietarioEvidencia::where('id_status_delete',1)->get();
        $estados = Estado::orderBy('id_estado', 'asc')->where('id_status_delete', 1)->get();
        $municipios = Municipio::orderBy('id_municipio', 'asc')->where('id_status_delete', 1)->get();
        //tipo de documentos en formato json
        $cadenaTipoDocumento = "";
        foreach($documentos as $documento){
            $cadenaTipoDocumento .= '"'.$documento->id.'":"'.$documento->nombre_evidencia.'",';
        }
        $cadenaTipoDocumento = '{'.rtrim($cadenaTipoDocumento, ',').'}';

        return view('unidades.tramitesvehiculares.tramiteunidad.cambiopropietario.tramite-cambiopropietario-ver', compact('info_propietario', 'cadenaTipoDocumento', 'id_unidad', 'tramite_info', 'id_pago', 'tramite_evidencia', 'estados' , 'municipios'));     	
    }

    public function deleteinfoevcambiopro(Request $request)
    {

        $doc = TramiteCambioPropietarioDoc::where('unidad_tramite_cambiopropietario_info_id', $request->id)->get();
        $estatus = true;
        if ($doc){
	        foreach ($doc as $key => $value) {
	            Storage::delete('unidad/'. $request->id_unidad.'/'.$value->documento);
	            TramiteCambioPropietarioDoc::where('id', $value->id)->delete();
	        }
        }else{
            $estatus = false;
        }

        $tramite_info  = TramiteCambioPropietarioInfo::where('id', $request->id)->delete();


        session()->flash('success', 'La información del movimiento se elimino correctamente');
        return redirect()->route('traveh.tvcambiopro', $request->id_unidad);    	
    }


    public function cargamasivacambiopropietario(Request $request)
    {
        Excel::import(new CambioPropietarioImport,request()->file('file_carga'));

        session()->flash('success', 'Se importó correctamente el archivo.');
        return redirect()->route('traveh.tvcambiopro', $request->id_unidad);         
    }


// E N D   T R A M I T E  C A M B I O  P R O P I E T A R I O ------------------------------------------------------------------------------------------------------------------------  END  BV CAMBIO

    public function tramitevgps($id_unidad)
    {
        $unidad = Unidad::find($id_unidad);
        $req_tramite = TramiteGpsRequisito::where('id_status_delete', 1)->get();
        $ev_tramite = TramiteGpsEvidencia::where('id_status_delete', 1)->get();
        $info_propietario = InformacionPropietario::where('id_status_delete', 1)->get();
        $marcas = MarcaUnidad::where('id_status_delete', 1)->get();
        $modelos = ModeloUnidad::where('id_status_delete', 1)->get();
        $fotografias = UnidadFotografia::where('unidad_id', $id_unidad)->get();
        $active = UnidadFotografia::where('unidad_id', $id_unidad)->first();

        if ($active == null) {
            $ver = 0;
        } else {
            $ver = $active->id;
        }

        $req_info = TramiteGpsInfo::where('unidad_id', $id_unidad)->orderBy('id', 'DESC')->get();

        return view('unidades.tramitesvehiculares.tramiteunidad.gps.tramite-gps', compact('req_tramite', 'ev_tramite', 'info_propietario', 'id_unidad', 'marcas', 'modelos', 'ver', 'fotografias', 'unidad', 'req_info'));
    }

    public function vistagrdgps($id_unidad)
    {
        $info_propietario = InformacionPropietario::where('id_status_delete', 1)->get();
        $documentos = TramiteGpsEvidencia::where('id_status_delete',1)->get();
        $gestor = TramiteGestor::where('id_status_delete',1)->get();

        //tipo de documentos en formato json
        $cadenaTipoDocumento = "";
        foreach($documentos as $documento){
            $cadenaTipoDocumento .= '"'.$documento->id.'":"'.$documento->nombre_evidencia.'",';
        }
        $cadenaTipoDocumento = '{'.rtrim($cadenaTipoDocumento, ',').'}';

        return view('unidades.tramitesvehiculares.tramiteunidad.gps.tramite-gps-guardar', compact('info_propietario', 'cadenaTipoDocumento', 'id_unidad', 'gestor')); 
    }

	public function addinfoevgps(Request $request)
    {

        $data = [
            'unidad_tramite_gestor_id'=> $request->gestor,
        	'unidad_id' => $request->id_unidad,
        	'id_propietario' => $request->id_propietario,
            'fecha_instalacion' => $request->fecha_pago ? Carbon::createFromFormat('d/m/Y', $request->fecha_pago)->format('Y-m-d'):null,
            'observaciones' => $request->observaciones,
            'importe' => $request->importe ? $this->money_format->clearFormat($request->importe):null,
            'op_estatus' => 1,
            'id_status_delete' => 1,
            'created_at' =>date('Y-m-d H:i:s'),
            'updated_at' =>date('Y-m-d H:i:s'),
            'iduserCreated' =>auth()->user()->id,
            'iduserUpdated' =>auth()->user()->id,
        ];
        $unidad_tramite_gps_info_id = TramiteGpsInfo::insertGetId($data);

        $colIdDocumento = $request->id_documento;
        if($request->hasfile('archivo')){
            $archivos = $request->file('archivo');
            foreach($archivos as $indice => $archivo)
            {
                $archivoNombre = $archivo->hashName();
                $mimeType = $archivo->getMimeType();
                Storage::putFileAs('unidad/' . $request->id_unidad, $archivo, $archivoNombre);
                $data = [
                	'unidad_id'=>$request->id_unidad,
                    'id_evidencia' =>$colIdDocumento[$indice],
					'unidad_tramite_gps_info_id' => $unidad_tramite_gps_info_id,
                    'documento' => $archivoNombre,
                    'created_at' =>date('Y-m-d H:i:s'),
                    'iduserCreated' =>auth()->user()->id
                ];
                TramiteGpsDoc::insert($data);
            }
        }
		// dd('aqui');
        session()->flash('success', 'El tramite se añadió correctamente');
        return redirect()->route('traveh.tvgps', $request->id_unidad);    	
    }

	public function vistavercambiogps($id_unidad, $id_pago)
    {
    	$tramite_info  = TramiteGpsInfo::where('id', $id_pago)->first();
    	$tramite_evidencia  = TramiteGpsDoc::where('unidad_tramite_gps_info_id', $id_pago)->get();
    	$info_propietario = InformacionPropietario::where('id', $tramite_info->id_propietario)->first();
        $documentos = TramiteGpsEvidencia::where('id_status_delete',1)->get();
        $estados = Estado::orderBy('id_estado', 'asc')->where('id_status_delete', 1)->get();
        $municipios = Municipio::orderBy('id_municipio', 'asc')->where('id_status_delete', 1)->get();
        //tipo de documentos en formato json
        $cadenaTipoDocumento = "";
        foreach($documentos as $documento){
            $cadenaTipoDocumento .= '"'.$documento->id.'":"'.$documento->nombre_evidencia.'",';
        }
        $cadenaTipoDocumento = '{'.rtrim($cadenaTipoDocumento, ',').'}';

        return view('unidades.tramitesvehiculares.tramiteunidad.gps.tramite-gps-ver', compact('info_propietario', 'cadenaTipoDocumento', 'id_unidad', 'tramite_info', 'id_pago', 'tramite_evidencia', 'estados' , 'municipios'));     	
    }

    public function cargamasivagps(Request $request)
    {
        Excel::import(new ReposisiocImport,request()->file('file_carga'));

        session()->flash('success', 'Se importó correctamente el archivo.');
        return redirect()->route('traveh.tvgps', $request->id_unidad);       
    }


// E N D   T R A M I T E  C A M B I O  G P S  (REPOSICION) ------------------------------------------------------------------------------------------------------------------------  END  BV reposicion

	public function listadocatalogogestor()
    {
        $data = TramiteGestor::where('id_status_delete', 1)->get();

        return view('unidades.gestor.catalogo-gestor', compact('data'));
    }

	public function catalogogestordatatable(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $search_arr = $request->get('search');
        $searchValue = $search_arr['value']; // Search value

        // Total records
        $totalRecords = TramiteGestor::select('count(*) as allcount')->where('id_status_delete', 1)->count();
        $totalRecordswithFilter = TramiteGestor::select('count(*) as allcount')->where('id_status_delete', 1)->where('id', 'like', '%' . $searchValue . '%')->count();
        // Fetch records
        $records = TramiteGestor::select('*')
            ->where('id_status_delete', 1)
            ->skip($start)
            ->take($rowperpage);

        $valor = "No";
        // Bandera para varlidar si no hay filtros   $valor = "No";
        foreach ($columnName_arr as $indice => $columna) {
            if ($columna['data'] == 'nombre') {
                if (!empty($columna['search']['value'])) {
                    $valor = trim($columna['search']['value']);
                    $records = $records->where("nombre", 'like', '%' . $valor . '%');
                }
            }
        }

        if ($valor == "No") {
            $records = $records->get();
        } else {
            $records = $records->get();
            $totalRecords = count($records);
            $totalRecordswithFilter = count($records);
        }

        $data_arr = array();
        $pro = "";
        foreach ($records as $record) {

            $data_arr[] = array(
                "id" => $record->id,
                "nombre" => $record->nombre,
                "correo" => $record->correo,
                "telefono1" => $record->telefono,
                "telefono2" => $record->telefono_dos,
                'acciones' => null,
            );
        }

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr
        );

        return response()->json($response);
    }

    public function guardarcatalogogestor(Request $request)
    {

        if (empty($request->nombre)) {
            session()->flash('error', 'El registro no puede estar vacio');
            return redirect()->route('catalogogestor.listadocatalogogestor');
        }

        $data = [
            'nombre' => $request->nombre,
            'telefono' => $request->telefono1,
            'telefono_dos' => $request->telefono2,
            'correo' => $request->correo,
            'id_status_delete' => 1,
            'iduserCreated' => auth()->user()->id,
            'iduserUpdated' => auth()->user()->id,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        TramiteGestor::insert($data);

        session()->flash('success', 'El registro se creo correctamente');
        return redirect()->route('catalogogestor.listadocatalogogestor');
    }

    public function editarcatalogogestor(Request $request)
    {

        $data = [
            'nombre' => $request->nombre,
            'telefono' => $request->telefono1,
            'telefono_dos' => $request->telefono2,
            'correo' => $request->correo,
            'iduserUpdated' => auth()->user()->id,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        TramiteGestor::where('id', $request->id_gestor_edit)->update($data);

        session()->flash('success', 'El registro modifico correctamente');
        return redirect()->route('catalogogestor.listadocatalogogestor');
    }

    public function desactivarcatalogogestor(Request $request)
    {
        $data = [
            'id_status_delete' => 2,
            'iduserUpdated' => auth()->user()->id,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        TramiteGestor::where('id', $request->id_gestor)->update($data);

        session()->flash('success', 'El registro se desactivo correctamente');
        return redirect()->route('catalogogestor.listadocatalogogestor');
    }

    public function catalogogestorinactivas()
    {
        $data = TramiteGestor::where('id_status_delete', 2)->get();

        return view('unidades.gestor.catalogo-gestor-inactivos', compact('data'));
    }

    public function activarcatalogogestor(Request $request)
    {
        $data = [
            'id_status_delete' => 1,
            'iduserUpdated' => auth()->user()->id,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        TramiteGestor::where('id', $request->id)->update($data);

        session()->flash('success', 'El registro se activo correctamente');
        return redirect()->route('catalogogestor.catalogogestorinactivas');
    }

    public function gestorDocumentos(Request $request)
    {
        $documentos = GestorDocumento::where('id_gestor', $request->id)->get();
        $id_gestor = $request->id;
        return view('unidades.gestor.catalogo-documentos', compact('documentos','id_gestor'), );
    }

    public function guardarDocumento(Request $request)
    {
        if ($request->hasfile('archivo')) {

            $archivos = $request->file('archivo');
            $colIdComentario = $request->id_tipo_comentario;


            foreach ($archivos as $indice => $archivo) {

                // Validacion de extensiones permitidas
                $extensionesPermitidas = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'txt', 'jpg', 'jpeg', 'png', 'gif', 'zip', 'rar', '7z'];
                $extensionArchivo = $archivo->getClientOriginalExtension();
                if (!in_array($extensionArchivo, $extensionesPermitidas)) {
                    return redirect()->back()->with('error', 'El archivo ' . $archivo->getClientOriginalName() . ' no es permitido');
                }

                $archivoNombre = $archivo->hashName();
                Storage::putFileAs('gestoresdocumentos/', $archivo, $archivoNombre);
                $comentario = $colIdComentario[$indice];

                $data = [
                    'id_gestor' => $request->id_gestor,
                    'documento' => $archivoNombre,
                    'mime_type' => $archivo->getMimeType(),
                    'descripcion' => $comentario,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'iduserCreated' => auth()->user()->id,
                ];

                GestorDocumento::insert($data);
            }
        }

        if (!$request->hasfile('archivo')) {
            return redirect()->back()->with('error', 'No se ha subido ningun archivo');
        }
        session()->flash('success', 'El documento se creo correctamente');
        return redirect()->route('catalogogestor.listadoDocumentos', ['id' => $request->id_gestor]);
    }

    public function gestorDatatable(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $search_arr = $request->get('search');
        $documentoSearch = $request->get('search');
        $id_gestor = $request->get('id_gestor');

        // Total records
        $totalRecords = GestorDocumento::select('count(*) as allcount')->where('id_gestor', $id_gestor)->count();
		$totalRecordswithFilter = GestorDocumento::select('count(*) as allcount')->where('id_gestor', $id_gestor)->count();

        /* Getting the first element of the array. */
        $order_arr = $columnIndex_arr[0];

        /* Getting the column index of the column that is being sorted. */
        $order_column_index = $order_arr['column'];

        /* Getting the direction of the sort. */
        $order_dir = $order_arr['dir'];

        /* Getting the column name from the array of columns. */
        $order_column_name = $columnName_arr[$order_column_index]['data'];
        $order_column_dir = $order_dir;

        $order_column_dir = $order_column_dir == 'asc' ? 'asc' : 'desc';

        $query = GestorDocumento::select('*')->where('id_gestor', $id_gestor);

        $totalRecordswithFilter = $query->count();

        $records = $query->orderBy($order_column_name, $order_column_dir)
            ->skip($start)->take($rowperpage)->get();

        $data_arr = array();
        foreach ($records as $record) {

            $data_arr[] = array(
                "id" => $record->id,
                "documento" => $record->documento,
                "descripcion" => $record->descripcion,
                'acciones' => null
            );
        }

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr
        );

        return response()->json($response);
    }

    
    public function gestoresEliminarDocumento(Request $request)
    {

        $id = $request->id;
        $archivo = GestorDocumento::where('id', $id)->first();
        $documento = $archivo->documento;
        Storage::delete('gestoresdocumentos/' . $documento);
        GestorDocumento::where('id', $id)->delete();
        $estatus = true;

        return response()->json([
            'estatus' => $estatus,
        ]);
    }
}