<?php

namespace App\Http\Controllers\Archivo;

use App\Http\Controllers\Controller;
use App\Models\Licitacion\DocumentoLicitacion;
use App\Models\Licitacion\Licitacion;
use App\Models\Proyecto\ProyectoDocumento;
use App\Models\Proyecto\PagoProyecto;
use App\Models\Proyecto\DeductivaPago;
use App\Models\Unidad\UnidadDocumento;
use App\Models\Cliente\ClienteDocumento;
use App\Models\Licitacion\LicitacionPropuestaTecnicaLegal;
use App\Models\Licitacion\LicitacionPropuestaTecnicaAdministrativa;
use App\Models\Licitacion\LicitacionPropuestaTecnicaFiscal;
use App\Models\Licitacion\LicitacionPropuestaTecnicaFinanciera;
use App\Models\Licitacion\LicitacionPropuestaTecnicaOtro;
use App\Models\Licitacion\LicitacionGestorDocumentos;
use App\Models\Requisicion\Requisicion;
use App\Models\Requisicion\RequisicionPartida;
use App\Models\Taller\TallerSolicitudDocumento;
use App\Models\Unidad\UnidadFotografia;
use App\Models\Licitacion\LicitacionPropuestaCargaFinal;
use App\Models\Licitacion\RequisicionPartidaEquipamiento;
use App\Models\Licitacion\RequisicionPartidaAseguramiento;
use App\Models\Unidad\UnidadEquipamiento;
use App\Models\Licitacion\LicitacionFianza;
use App\Models\Licitacion\LicitacionSeguroRC;
    use App\Models\Unidad\TramiteTenenciaInfo;
    use App\Models\Unidad\TramiteTenenciaDoc;
    use App\Models\Unidad\TramiteEmplacamientoInfo;
    use App\Models\Unidad\TramiteEmplacamientoDoc;
    use App\Models\Unidad\TramiteVerificacionInfo;
    use App\Models\Unidad\TramiteVerificacionDoc;
    use App\Models\Unidad\TramiteAseguramientoInfo;
    use App\Models\Unidad\TramiteAseguramientoDoc;
    use App\Models\Unidad\TramiteReemplacamientoInfo;
    use App\Models\Unidad\TramiteReemplacamientoDoc;
    use App\Models\Unidad\TramiteBajavehiculoSiniestroInfo;
    use App\Models\Unidad\TramiteBajavehiculoSiniestroDoc;
    use App\Models\Unidad\TramiteBajaVehiculoVentaInfo;
    use App\Models\Unidad\TramiteBajaVehiculoVentaDoc;
    use App\Models\Unidad\TramiteBajaVehiculoRoboInfo;
    use App\Models\Unidad\TramiteBajaVehiculoRoboDoc;
    use App\Models\Unidad\TramiteCambioPropietarioInfo;
    use App\Models\Unidad\TramiteCambioPropietarioDoc;

use App\Models\Proyecto\EstimacionesPago;
use App\Models\Proyecto\EstimacionesNotaCredito;
use App\Models\Taller\DocumentoTaller;
use App\Models\Requisicion\RequisicionEvidenciaCompra;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Taller\EvidenciaTaller;
use App\Models\Taller\CotizacionTaller;
use App\Models\Unidad\GestorDocumento;
use App\Models\Licitacion\ComprasRequisicion;
use App\Models\Licitacion\ComprasRequisicionPago;
use App\Models\Licitacion\RequisicionConversion;
use App\Models\Unidad\SeminuevosDocumentos;

use App\Models\Logistica\AsignacionDocumento;
use App\Models\Taller\TallerPagoFinanzas;
use App\Models\Logistica\SustitutoEvidencia;
use App\Models\Translados\TrasladoUnidadDocumento;

class ArchivoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function documentoLicitacion(Request $request) {

        $user = auth()->user();
        $id = $request->id;
        $documento = DocumentoLicitacion::findOrFail($id);
        $existeArchivo = Storage::exists('licitacion/'.$documento->licitaciones->folio.'/'.$documento->documento);
        if($user && $documento && $existeArchivo) {
            return Storage::download('licitacion/'.$documento->licitaciones->folio.'/'.$documento->documento, $documento->documento, ['Content-Disposition'=>'inline; filename="'.$documento->documento.'"']);
        }else{
            return abort('403');
        }
    }

    public function documentoProyecto(Request $request) {
        $user = auth()->user();
        $id = $request->id;
        $documento = ProyectoDocumento::findOrFail($id);
        $existeArchivo = Storage::exists('proyecto/'.$documento->id_proyecto.'/'.$documento->documento);
        if($user && $documento && $existeArchivo) {
            return Storage::download('proyecto/'.$documento->id_proyecto.'/'.$documento->documento, $documento->documento, ['Content-Disposition'=>'inline; filename="'.$documento->documento.'"']);
        }else{
            return abort('403');
        }
    }

    public function documentoAvanceFinanciero(Request $request)
    {
        $user = auth()->user();
        $id = $request->id;
        $documento = PagoProyecto::findOrFail($id);
        $existeArchivo = Storage::exists('proyecto/'.$documento->id_proyecto.'/AvanceFinanciero/'.$documento->factura);
        if($user && $documento && $existeArchivo) {
            return Storage::download('proyecto/'.$documento->id_proyecto.'/AvanceFinanciero/'.$documento->factura, $documento->factura, ['Content-Disposition'=>'inline; filename="'.$documento->factura.'"']);
        }else{
            return abort('403');
        }
    }

    public function documentoDeductivaPago(Request $request)
    {
        $user = auth()->user();
        $id = $request->id;
        $documento = DeductivaPago::findOrFail($id);
        $existeArchivo = Storage::exists('proyecto/'.$documento->proyecto_id.'/DeductivaPago/'.$documento->deductiva_pago);
        if($user && $documento && $existeArchivo) {
            return Storage::download('proyecto/'.$documento->proyecto_id.'/DeductivaPago/'.$documento->deductiva_pago, $documento->factura, ['Content-Disposition'=>'inline; filename="'.$documento->deductiva_pago.'"']);
        }else{
            return abort('403');
        }        
    }

    public function documentoUnidad(Request $request)
    {
        $user = auth()->user();
        $id = $request->id;
        $documento = UnidadDocumento::findOrFail($id);
        $existeArchivo = Storage::exists('unidad/'.$documento->id_unidad.'/'.$documento->documento);
        if($user && $documento && $existeArchivo) {
            return Storage::download('unidad/'.$documento->id_unidad.'/'.$documento->documento, $documento->documento, ['Content-Disposition'=>'inline; filename="'.$documento->documento.'"']);
        }else{
            return abort('403');
        } 
    }

    public function fotografiaUnidad(Request $request)
    {
        $user = auth()->user();
        $id = $request->id;
        $documento = UnidadFotografia::findOrFail($id);
        $existeArchivo = Storage::exists('unidad/'.$documento->unidad_id.'/'.$documento->fotografia);
        if($user && $documento && $existeArchivo) {
            return Storage::download('unidad/'.$documento->unidad_id.'/'.$documento->fotografia, $documento->fotografia, ['Content-Disposition'=>'inline; filename="'.$documento->fotografia.'"']);
        }else{
            return abort('403');
        }         
    }


    public function documentoCliente(Request $request)
    {
        $user = auth()->user();
        $id = $request->id;
        $documento = ClienteDocumento::findOrFail($id);
        $existeArchivo = Storage::exists('cliente/'.$documento->id_cliente.'/'.$documento->documento);
        if($user && $documento && $existeArchivo) {
            return Storage::download('cliente/'.$documento->id_cliente.'/'.$documento->documento, $documento->documento, ['Content-Disposition'=>'inline; filename="'.$documento->documento.'"']);
        }else{
            return abort('403');
        }         
    }

    public function documentoPropuestaTecnica(Request $request)
    {
        // dd($request->id);
        $user = auth()->user();
        $tipo = $request->tipo;
        $id = $request->id;
        $folio = $request->folio;
        
        if($tipo == 'legal') {
            // $documento = LicitacionPropuestaTecnicaLegal::findOrFail($id);
            // $existeArchivo = Storage::exists('licitacion/'.$folio.'/propuestatecnica/'.$documento->documento);
            $existeArchivo = Storage::exists('gestordocumentos/'.$id);
            if($user && $existeArchivo) {
                return Storage::download('gestordocumentos/'.$id, $id, ['Content-Disposition'=>'inline; filename="'.$id.'"']);
            }else{
                return abort('403');
            } 

        }elseif($tipo == 'administrativa') {
            // $documento = LicitacionPropuestaTecnicaAdministrativa::findOrFail($id);
            // $existeArchivo = Storage::exists('licitacion/'.$folio.'/propuestatecnica/'.$documento->documento);
            $existeArchivo = Storage::exists('gestordocumentos/'.$id);
            if($user && $existeArchivo) {
                return Storage::download('gestordocumentos/'.$id, $id, ['Content-Disposition'=>'inline; filename="'.$id.'"']);
            }else{
                return abort('403');
            } 

        }elseif($tipo == 'fiscal') {
            // $documento = LicitacionPropuestaTecnicaFiscal::findOrFail($id);
            // $existeArchivo = Storage::exists('licitacion/'.$folio.'/propuestatecnica/'.$documento->documento);
            $existeArchivo = Storage::exists('gestordocumentos/'.$id);
            if($user && $existeArchivo) {
                return Storage::download('gestordocumentos/'.$id, $id, ['Content-Disposition'=>'inline; filename="'.$id.'"']);
            }else{
                return abort('403');
            } 

        }elseif($tipo == 'financiera') {
            // $documento = LicitacionPropuestaTecnicaFinanciera::findOrFail($id);
            // $existeArchivo = Storage::exists('licitacion/'.$folio.'/propuestatecnica/'.$documento->documento);
            // dd($id);
            $existeArchivo = Storage::exists('gestordocumentos/'.$id);
            if($user && $existeArchivo) {
                return Storage::download('gestordocumentos/'.$id, $id, ['Content-Disposition'=>'inline; filename="'.$id.'"']);
            }else{
                return abort('403');
            } 
        }elseif($tipo == 'otros') {
            $documento = LicitacionPropuestaTecnicaOtro::findOrFail($id);
            $existeArchivo = Storage::exists('licitacion/'.$folio.'/propuestatecnica/'.$documento->documento);

            if($user && $documento && $existeArchivo) {
                return Storage::download('licitacion/'.$folio.'/propuestatecnica/'.$documento->documento, $documento->documento, ['Content-Disposition'=>'inline; filename="'.$documento->documento.'"']);
            }else{
                return abort('403');
            }            
        }

    
    }

    public function documentoGestor(Request $request)
    {
        $user = auth()->user();
        $id = $request->id;
        $documento = LicitacionGestorDocumentos::findOrFail($id);
        $existeArchivo = Storage::exists('gestordocumentos/'.$documento->documento);
        if($user && $documento && $existeArchivo) {
            return Storage::download('gestordocumentos/'.$documento->documento, $documento->documento, ['Content-Disposition'=>'inline; filename="'.$documento->documento.'"']);
        }else{
            return abort('403');
        }         
    }

    public function documentoAvatar(Request $request)
    {
        $user = auth()->user();
        $existeArchivo = Storage::exists('avatar/'.$request->documento);
        if($user && $existeArchivo) {
            //we return the image to show in the view
            return Storage::download('avatar/'.$request->documento, $request->documento, ['Content-Disposition'=>'inline; filename="'.$request->documento.'"']);
        }else{
            return abort('403');
        }
    }


    public function documentoSolicitudMantenimiento($id)
    {
        $user = auth()->user();
        $documento = TallerSolicitudDocumento::findOrFail($id);
        $existeArchivo = Storage::exists('taller/documentos/'.$documento->taller_solicitud_id.'/'.$documento->documento);
        if($user && $documento && $existeArchivo) {
            return Storage::download('taller/documentos/'.$documento->taller_solicitud_id.'/'.$documento->documento, $documento->documento, ['Content-Disposition'=>'inline; filename="'.$documento->documento.'"']);
        }else{
            return abort('403');
        }         
    }

    public function documentoPropuestaeconomia($id)
    {
        $user = auth()->user();
        $id = $id;
        $propuesta = LicitacionPropuestaCargaFinal::findOrFail($id);
        $documento = Licitacion::findOrFail($propuesta->licitaciones_id);

        $existeArchivo = Storage::exists('licitacion/'.$documento->folio.'/'.$propuesta->archivo_propuesta);
        if($user && $documento && $existeArchivo) {
            return Storage::download('licitacion/'.$documento->folio.'/'.$propuesta->archivo_propuesta, $propuesta->archivo_propuesta, ['Content-Disposition'=>'inline; filename="'.$propuesta->archivo_propuesta.'"']);
        }else{
            return abort('403');
        }       
    }

    public function evidenciaequipamiento(Request $request)
    {
        $user = auth()->user();
        $id = $request->id;
        $documento = UnidadEquipamiento::findOrFail($id);

        $existeArchivo = Storage::exists('unidad/'.$documento->unidad_id.'/'.$documento->fotografia_equipamiento);
        if($user && $documento && $existeArchivo) {
            return Storage::download('unidad/'.$documento->unidad_id.'/'.$documento->fotografia_equipamiento, $documento->fotografia_equipamiento, ['Content-Disposition'=>'inline; filename="'.$documento->fotografia_equipamiento.'"']);
        }else{
            return abort('403');
        }     
    }

    public function archivorequisicionequipamiento(Request $request)
    {
        $user = auth()->user();
        $id = $request->id;
        $info_requisicion = RequisicionPartidaEquipamiento::where('id', $id)->first();
        $info_licitacion = RequisicionPartida::where('id', $info_requisicion->requisicion_partida_id)->first();
        $info_licitacion_idlic = Requisicion::where('id', $info_licitacion->requisicion_id)->first();
        $info_folio= Licitacion::where('id', $info_licitacion_idlic->licitaciones_id)->first();

        $documento = RequisicionPartidaEquipamiento::findOrFail($id);
        $existeArchivo = Storage::exists('licitacion/'.$info_folio->folio.'/'.$documento->archivo_equipamiento);
        if($user && $documento && $existeArchivo) {
            return Storage::download('licitacion/'.$info_folio->folio.'/'.$documento->archivo_equipamiento, $documento->archivo_equipamiento, ['Content-Disposition'=>'inline; filename="'.$documento->archivo_equipamiento.'"']);
        }else{
            return abort('403');
        }   
    }

    public function archivorequisicionequipamientosinconcurso(Request $request)
    {
        $user = auth()->user();
        $id = $request->id;
        $info_requisicion = RequisicionPartidaEquipamiento::where('id', $id)->first();
        $info_licitacion = RequisicionPartida::where('id', $info_requisicion->requisicion_partida_id)->first();
        $info_licitacion_idlic = Requisicion::where('id', $info_licitacion->requisicion_id)->first();
        $info_folio= Licitacion::where('id', $info_licitacion_idlic->licitaciones_id)->first();

        $documento = RequisicionPartidaEquipamiento::findOrFail($id);
        $existeArchivo = Storage::exists('requiciciones/'.'/'.$documento->archivo_equipamiento);
        if($user && $documento && $existeArchivo) {
            return Storage::download('requiciciones/'.'/'.$documento->archivo_equipamiento, $documento->archivo_equipamiento, ['Content-Disposition'=>'inline; filename="'.$documento->archivo_equipamiento.'"']);
        }else{
            return abort('403');
        }         
    }

    public function archivorequisicionaseguramiento(Request $request)
    {
        $user = auth()->user();
        $id = $request->id;
        $info_requisicion = RequisicionPartidaAseguramiento::where('id', $id)->first();
        $info_licitacion = RequisicionPartida::where('id', $info_requisicion->requisicion_partida_id)->first();
        $info_licitacion_idlic = Requisicion::where('id', $info_licitacion->requisicion_id)->first();
        $info_folio= Licitacion::where('id', $info_licitacion_idlic->licitaciones_id)->first();

        $documento = RequisicionPartidaAseguramiento::findOrFail($id);
        $existeArchivo = Storage::exists('licitacion/'.$info_folio->folio.'/'.$documento->archivo_equipamiento);
        if($user && $documento && $existeArchivo) {
            return Storage::download('licitacion/'.$info_folio->folio.'/'.$documento->archivo_equipamiento, $documento->archivo_equipamiento, ['Content-Disposition'=>'inline; filename="'.$documento->archivo_equipamiento.'"']);
        }else{
            return abort('403');
        }           
    }

    public function archivorequisicionaseguramientosinconcurso(Request $request)
    {
        $user = auth()->user();
        $id = $request->id;
        $info_requisicion = RequisicionPartidaEquipamiento::where('id', $id)->first();
        $info_licitacion = RequisicionPartida::where('id', $info_requisicion->requisicion_partida_id)->first();
        $info_licitacion_idlic = Requisicion::where('id', $info_licitacion->requisicion_id)->first();
        $info_folio= Licitacion::where('id', $info_licitacion_idlic->licitaciones_id)->first();

        $documento = RequisicionPartidaAseguramiento::findOrFail($id);
        $existeArchivo = Storage::exists('requiciciones/'.'/'.$documento->archivo_equipamiento);
        if($user && $documento && $existeArchivo) {
            return Storage::download('requiciciones/'.'/'.$documento->archivo_equipamiento, $documento->archivo_equipamiento, ['Content-Disposition'=>'inline; filename="'.$documento->archivo_equipamiento.'"']);
        }else{
            return abort('403');
        }             
    }

    public function documentofianza(Request $request)
    {
        $user = auth()->user();
        $id = $request->id;

        $info_licitacion = LicitacionFianza::where('id', $id)->first();
        $info_folio= Licitacion::where('id', $info_licitacion->licitaciones_id)->first();

        $documento = LicitacionFianza::findOrFail($id);
        $existeArchivo = Storage::exists('licitacion/'.$info_folio->folio.'/'.$documento->documento);
        if($user && $documento && $existeArchivo) {
            return Storage::download('licitacion/'.$info_folio->folio.'/'.$documento->documento, $documento->documento, ['Content-Disposition'=>'inline; filename="'.$documento->documento.'"']);
        }else{
            return abort('403');
        }         
    }

    public function documentosegurorc(Request $request)
    {
        $user = auth()->user();
        $id = $request->id;

        $info_licitacion = LicitacionSeguroRC::where('id', $id)->first();
        $info_folio= Licitacion::where('id', $info_licitacion->licitaciones_id)->first();

        $documento = LicitacionSeguroRC::findOrFail($id);
        $existeArchivo = Storage::exists('licitacion/'.$info_folio->folio.'/'.$documento->documento);
        if($user && $documento && $existeArchivo) {
            return Storage::download('licitacion/'.$info_folio->folio.'/'.$documento->documento, $documento->documento, ['Content-Disposition'=>'inline; filename="'.$documento->documento.'"']);
        }else{
            return abort('403');
        }  
    }

    public function documentoPagoTenencia(Request $request)
    {
        $user = auth()->user();
        $id = $request->id;
        $id_unidad =  TramiteTenenciaDoc::where('id', $id)->first();

        $documento = TramiteTenenciaDoc::findOrFail($id);
        $existeArchivo = Storage::exists('unidad/'.$id_unidad->unidad_id.'/'.$documento->documento);
        if($user && $documento && $existeArchivo) {
            return Storage::download('unidad/'.$id_unidad->unidad_id.'/'.$documento->documento, $documento->documento, ['Content-Disposition'=>'inline; filename="'.$documento->documento.'"']);
        }else{
            return abort('403');
        } 
    }

    public function documentoPagoEmplacamiento(Request $request)
    {
        $user = auth()->user();
        $id = $request->id;
        $id_unidad =  TramiteEmplacamientoDoc::where('id', $id)->first();

        $documento = TramiteEmplacamientoDoc::findOrFail($id);
        $existeArchivo = Storage::exists('unidad/'.$id_unidad->unidad_id.'/'.$documento->documento);
        if($user && $documento && $existeArchivo) {
            return Storage::download('unidad/'.$id_unidad->unidad_id.'/'.$documento->documento, $documento->documento, ['Content-Disposition'=>'inline; filename="'.$documento->documento.'"']);
        }else{
            return abort('403');
        }         
    }

    public function documentoPagoVerificacion(Request $request)
    {
        $user = auth()->user();
        $id = $request->id;
        $id_unidad =  TramiteVerificacionDoc::where('id', $id)->first();

        $documento = TramiteVerificacionDoc::findOrFail($id);
        $existeArchivo = Storage::exists('unidad/'.$id_unidad->unidad_id.'/'.$documento->documento);
        if($user && $documento && $existeArchivo) {
            return Storage::download('unidad/'.$id_unidad->unidad_id.'/'.$documento->documento, $documento->documento, ['Content-Disposition'=>'inline; filename="'.$documento->documento.'"']);
        }else{
            return abort('403');
        }         
    }

    public function documentoPagoAseguramiento(Request $request)
    {
        $user = auth()->user();
        $id = $request->id;
        $id_unidad =  TramiteAseguramientoDoc::where('id', $id)->first();

        $documento = TramiteAseguramientoDoc::findOrFail($id);
        $existeArchivo = Storage::exists('unidad/'.$id_unidad->unidad_id.'/'.$documento->documento);
        if($user && $documento && $existeArchivo) {
            return Storage::download('unidad/'.$id_unidad->unidad_id.'/'.$documento->documento, $documento->documento, ['Content-Disposition'=>'inline; filename="'.$documento->documento.'"']);
        }else{
            return abort('403');
        }         
    }

    public function documentoPagoReemplacamiento(Request $request)
    {
        $user = auth()->user();
        $id = $request->id;
        $id_unidad =  TramiteReemplacamientoDoc::where('id', $id)->first();

        $documento = TramiteReemplacamientoDoc::findOrFail($id);
        $existeArchivo = Storage::exists('unidad/'.$id_unidad->unidad_id.'/'.$documento->documento);
        if($user && $documento && $existeArchivo) {
            return Storage::download('unidad/'.$id_unidad->unidad_id.'/'.$documento->documento, $documento->documento, ['Content-Disposition'=>'inline; filename="'.$documento->documento.'"']);
        }else{
            return abort('403');
        }         
    }

    public function documentoPagoBvSiniestro(Request $request)
    {
        $user = auth()->user();
        $id = $request->id;
        $id_unidad =  TramiteBajavehiculoSiniestroDoc::where('id', $id)->first();

        $documento = TramiteBajavehiculoSiniestroDoc::findOrFail($id);
        $existeArchivo = Storage::exists('unidad/'.$id_unidad->unidad_id.'/'.$documento->documento);
        if($user && $documento && $existeArchivo) {
            return Storage::download('unidad/'.$id_unidad->unidad_id.'/'.$documento->documento, $documento->documento, ['Content-Disposition'=>'inline; filename="'.$documento->documento.'"']);
        }else{
            return abort('403');
        }        
    }

    public function documentoPagoBvVenta(Request $request)
    {
        $user = auth()->user();
        $id = $request->id;
        $id_unidad =  TramiteBajaVehiculoVentaDoc::where('id', $id)->first();

        $documento = TramiteBajaVehiculoVentaDoc::findOrFail($id);
        $existeArchivo = Storage::exists('unidad/'.$id_unidad->unidad_id.'/'.$documento->documento);
        if($user && $documento && $existeArchivo) {
            return Storage::download('unidad/'.$id_unidad->unidad_id.'/'.$documento->documento, $documento->documento, ['Content-Disposition'=>'inline; filename="'.$documento->documento.'"']);
        }else{
            return abort('403');
        }        
    }

    public function documentoPagoBvRobo(Request $request)
    {
        $user = auth()->user();
        $id = $request->id;
        $id_unidad =  TramiteBajaVehiculoRoboDoc::where('id', $id)->first();

        $documento = TramiteBajaVehiculoRoboDoc::findOrFail($id);
        $existeArchivo = Storage::exists('unidad/'.$id_unidad->unidad_id.'/'.$documento->documento);
        if($user && $documento && $existeArchivo) {
            return Storage::download('unidad/'.$id_unidad->unidad_id.'/'.$documento->documento, $documento->documento, ['Content-Disposition'=>'inline; filename="'.$documento->documento.'"']);
        }else{
            return abort('403');
        }        
    }

    public function documentoPagoCambioPropietario(Request $request)
    {
        $user = auth()->user();
        $id = $request->id;
        $id_unidad =  TramiteCambioPropietarioDoc::where('id', $id)->first();

        $documento = TramiteCambioPropietarioDoc::findOrFail($id);
        $existeArchivo = Storage::exists('unidad/'.$id_unidad->unidad_id.'/'.$documento->documento);
        if($user && $documento && $existeArchivo) {
            return Storage::download('unidad/'.$id_unidad->unidad_id.'/'.$documento->documento, $documento->documento, ['Content-Disposition'=>'inline; filename="'.$documento->documento.'"']);
        }else{
            return abort('403');
        }         
    }

    public function documentoTaller(Request $request)
    {
        $user = auth()->user();
        $id = $request->id;
        $documento = DocumentoTaller::findOrFail($id);
        $existeArchivo = Storage::exists('taller/'.$documento->taller_id.'/'.$documento->documento);
        if($user && $documento && $existeArchivo) {
            return Storage::download('taller/'.$documento->taller_id.'/'.$documento->documento, $documento->documento, ['Content-Disposition'=>'inline; filename="'.$documento->documento.'"']);
        }else{
            return abort('403');
        } 
    }

    public function documentoEvidenciaOrdenCompra(Request $request)
    {
        $user = auth()->user();
        $id = $request->id;
        $documento = RequisicionEvidenciaCompra::findOrFail($id);
        $existeArchivo = Storage::exists('requiciciones/'.$documento->documento);
        if($user && $documento && $existeArchivo) {
            return Storage::download('requiciciones/'.$documento->documento, $documento->documento, ['Content-Disposition'=>'inline; filename="'.$documento->documento.'"']);
        }else{
            return abort('403');
        } 
    }

    public function estimacionespago(Request $request)
    {
        
        $user = auth()->user();
        $id = $request->id;
        $documento = EstimacionesPago::findOrFail($id);
        $existeArchivo = Storage::exists('estimaciones/'.$documento->estimacion_id.'/'.$documento->documento);
        if($user && $documento && $existeArchivo) {
            return Storage::download('estimaciones/'.$documento->estimacion_id.'/'.$documento->documento, $documento->documento, ['Content-Disposition'=>'inline; filename="'.$documento->documento.'"']);
        }else{
            return abort('403');
        }
    }

    public function estimacionnotacredito(Request $request)
    {
        $user = auth()->user();
        $id = $request->id;
        $documento = EstimacionesNotaCredito::findOrFail($id);
        $existeArchivo = Storage::exists('estimaciones/'.$documento->estimacion_id.'/'.$documento->documento);
        if($user && $documento && $existeArchivo) {
            return Storage::download('estimaciones/'.$documento->estimacion_id.'/'.$documento->documento, $documento->documento, ['Content-Disposition'=>'inline; filename="'.$documento->documento.'"']);
        }else{
            return abort('403');
        }
    }

    public function evidenciamantenimiento(Request $request)
    {
        $user = auth()->user();
        $id = $request->id;
        $documento = EvidenciaTaller::findOrFail($id);
        $existeArchivo = Storage::exists('mantenimiento/'.$documento->taller_solicitud_id.'/'.$documento->documento);
        if($user && $documento && $existeArchivo) {
            return Storage::download('mantenimiento/'.$documento->taller_solicitud_id.'/'.$documento->documento, $documento->documento, ['Content-Disposition'=>'inline; filename="'.$documento->documento.'"']);
        }else{
            return abort('403');
        }       
    }

    public function cotizavionmantenimiento(Request $request)
    {
        $user = auth()->user();
        $id = $request->id;
        $documento = CotizacionTaller::findOrFail($id);
        $existeArchivo = Storage::exists('taller/documentos/'.$documento->taller_solicitud_id.'/'.$documento->documento);
        if($user && $documento && $existeArchivo) {
            return Storage::download('taller/documentos/'.$documento->taller_solicitud_id.'/'.$documento->documento, $documento->documento, ['Content-Disposition'=>'inline; filename="'.$documento->documento.'"']);
        }else{
            return abort('403');
        }        
    }

    public function documentoGestores(Request $request)
    {
        $user = auth()->user();
        $id = $request->id;
        $documento = GestorDocumento::findOrFail($id);
        $existeArchivo = Storage::exists('gestoresdocumentos/'.$documento->documento);
        if($user && $documento && $existeArchivo) {
            return Storage::download('gestoresdocumentos/'.$documento->documento, $documento->documento, ['Content-Disposition'=>'inline; filename="'.$documento->documento.'"']);
        }else{
            return abort('403');
        }         
    }

    public function requisicioncompras(Request $request)
    {
        $user = auth()->user();
        $id = $request->id;
        $documento = ComprasRequisicionPago::findOrFail($id);
        $existeArchivo = Storage::exists('Requisiciocompras/'.$documento->requisicion_compras_id.'/'.$documento->documento);
        if($user && $documento && $existeArchivo) {
            return Storage::download('Requisiciocompras/'.$documento->requisicion_compras_id.'/'.$documento->documento, $documento->documento, ['Content-Disposition'=>'inline; filename="'.$documento->documento.'"']);
        }else{
            return abort('403');
        }  
    }
    
    public function requisicionConversion(Request $request)
    {
        $user = auth()->user();
        $id = $request->id;
        $documento = RequisicionConversion::findOrFail($id);
        $existeArchivo = Storage::exists('licitacion_conversion/'.$documento->requisicion_id.'/'.$documento->documento);
        if($user && $documento && $existeArchivo) {
            return Storage::download('licitacion_conversion/'.$documento->requisicion_id.'/'.$documento->documento, $documento->documento, ['Content-Disposition'=>'inline; filename="'.$documento->documento.'"']);
        }else{
            return abort('403');
        }  
    }

    public function seminuevosDocumento(Request $request)
    {
        $user = auth()->user();
        $id = $request->id;
        $documento = SeminuevosDocumentos::findOrFail($id);
        $existeArchivo = Storage::exists('seminuevos/'.$documento->id_unidad_venta.'/'.$documento->documento);
        if($user && $documento && $existeArchivo) {
            return Storage::download('seminuevos/'.$documento->id_unidad_venta.'/'.$documento->documento, $documento->documento, ['Content-Disposition'=>'inline; filename="'.$documento->documento.'"']);
        }else{
            return abort('403');
        }
    }

    public function documentoasignacionlog(Request $request)
    {
        $user = auth()->user();
        $id = $request->id;
        $documento = AsignacionDocumento::findOrFail($id);
        $existeArchivo = Storage::exists('asignacionlog/'.$documento->asignacion_id.'/'.$documento->documento);
        if($user && $documento && $existeArchivo) {
            return Storage::download('asignacionlog/'.$documento->asignacion_id.'/'.$documento->documento, $documento->documento, ['Content-Disposition'=>'inline; filename="'.$documento->documento.'"']);
        }else{
            return abort('403');
        }          
    }

    public function documentoMantenimientoFin(Request $request)
    {
        $user = auth()->user();
        $id = $request->id;
        $documento = TallerPagoFinanzas::findOrFail($id);
        $existeArchivo = Storage::exists('mantenimiento/'.$documento->taller_solicitud_id.'/'.$documento->documento);
        if($user && $documento && $existeArchivo) {
            return Storage::download('mantenimiento/'.$documento->taller_solicitud_id.'/'.$documento->documento, $documento->documento, ['Content-Disposition'=>'inline; filename="'.$documento->documento.'"']);
        }else{
            return abort('403');
        }  
    }

    public function documentosustituto(Request $request)
    {
        $user = auth()->user();
        $id = $request->id;
        $documento = SustitutoEvidencia::findOrFail($id);
        $existeArchivo = Storage::exists('solicitud_sustituto/'.$documento->sustituto_solicitud_id.'/'.$documento->documento);
        if($user && $documento && $existeArchivo) {
            return Storage::download('solicitud_sustituto/'.$documento->sustituto_solicitud_id.'/'.$documento->documento, $documento->documento, ['Content-Disposition'=>'inline; filename="'.$documento->documento.'"']);
        }else{
            return abort('403');
        }  
    }

    public function documentoTraslado(Request $request)
    {

        $user = auth()->user();
        $id = $request->id;
        $documento = TrasladoUnidadDocumento::findOrFail($id);
        $existeArchivo = Storage::exists('Traslado/'.$documento->translados_id.'/'.$documento->documento);
        if($user && $documento && $existeArchivo) {
            return Storage::download('Traslado/'.$documento->translados_id.'/'.$documento->documento, $documento->documento, ['Content-Disposition'=>'inline; filename="'.$documento->documento.'"']);
        }else{
            return abort('403');
        } 
    }
}
