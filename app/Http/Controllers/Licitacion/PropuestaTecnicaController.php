<?php

namespace App\Http\Controllers\Licitacion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Money;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use App\Models\Licitacion\Licitacion;
use App\Models\Licitacion\ProposicionEconomica;
use App\Models\Licitacion\LicitacionSegmento;
use App\Models\Segmento\Segmento;
use App\Models\Licitacion\LicitacionInformacionLegal;
use App\Models\Licitacion\LicitacionPropuestaTecnicaLegal;
use App\Models\Licitacion\LicitacionInformacionAdministrativa;
use App\Models\Licitacion\LicitacionPropuestaTecnicaAdministrativa;
use App\Models\Licitacion\LicitacionInformacionFiscal;
use App\Models\Licitacion\LicitacionPropuestaTecnicaFiscal;
use App\Models\Licitacion\LicitacionInformacionFinanciera;
use App\Models\Licitacion\LicitacionPropuestaTecnicaFinanciera;
use App\Models\Licitacion\LicitacionPropuestaTecnicaOtro;
use App\Models\Licitacion\LicitacionGestorDocumentos;
use App\Models\Licitacion\LicitacionGestorTipoDocumento;
use App\Models\Licitacion\LicitacionPropuestaCargaPreliminar;
use App\Models\Licitacion\LicitacionPropuestaCargaFinal;

use Maatwebsite\Excel\Facades\Excel;
use App\Imports\PropuestaeconomicaImport;

use App\Models\User;
use App\Models\Rol;
use App\Models\RolPermiso;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PropuestaTecnicaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function crearPropuestaTecnica($lici)
    {

        $user = User::where('id', auth()->user()->id)->first();
        $permisos = RolPermiso::where('role_id', $user->role)->get();
        $permiso_array = array();
        foreach ($permisos as $key => $value) {
            $permiso_array[] = $value->permission_id;
        }

        $licitacion = Licitacion::select(
            'licitaciones.id',
            'licitaciones.folio',
            'licitaciones.titulo_servicio',
            'licitaciones.empresa_dependencia',
            'licitaciones.no_licitacion',
            'licitaciones.fecha_visita',
            'licitaciones.participacion_conjunta',
            'licitaciones.publicacion_licitacion',
            'licitaciones.cliente',
            'cli.razon_social',
            'licitaciones.id_licitacion_prioridad',
            'licitaciones.contratacion',
            'licitaciones.acto_fallo',
            'licitaciones.tipo_contrato'
        )
            ->leftjoin("client as cli", "cli.id_cliente", "licitaciones.cliente")
            ->where("licitaciones.id", $lici)
            ->get();

        $propuesta = LicitacionSegmento::where('licitacion_id', $lici)->first();

        //obtenemos los documentos de la licitacion para mostrarlos en la vista
        $propuesta_tecnica_legal_documentos = LicitacionPropuestaTecnicaLegal::where('licitacion_id', $lici)->get();
        $propuesta_tecnica_administrativa_documentos = LicitacionPropuestaTecnicaAdministrativa::where('licitacion_id', $lici)->get();
        $propuesta_tecnica_fiscal_documentos = LicitacionPropuestaTecnicaFiscal::where('licitacion_id', $lici)->get();
        $propuesta_tecnica_financiera_documentos = LicitacionPropuestaTecnicaFinanciera::where('licitacion_id', $lici)->get();
        $propuesta_tecnica_otro_documentos = LicitacionPropuestaTecnicaOtro::where('licitacion_id', $lici)->get();
        $gestor_documentos = LicitacionGestorDocumentos::all();

        $cadenaTipoDocGestor = "";
        $cadenaSelectSubtext = "";
        foreach ($gestor_documentos as $documento) {
            $fecha = date("d/m/Y", strtotime($documento->fecha));
            $cadenaTipoDocGestor .= '"' . $documento->id . '":"' . $fecha . ' - ' . $documento->licitacionGestorTipoDocumento->informacion . '",';
            $cadenaSelectSubtext .= '"' . $documento->id . '":"' . $documento->documento . '",';
        }
        $cadenaTipoDocGestor = '{' . rtrim($cadenaTipoDocGestor, ',') . '}';
        $cadenaSelectSubtext = '{' . rtrim($cadenaSelectSubtext, ',') . '}';


        /* Creating a JSON object with the id and the information of the documents */
        //Tipos de Docuemtno Informacion Legal
        $documentosLegal = LicitacionInformacionLegal::where('id_status_delete', 1)->get();
        $cadenaTipoDocLegal = "";
        foreach ($documentosLegal as $documento) {
            $cadenaTipoDocLegal .= '"' . $documento->id . '":"' . $documento->informacion . '",';
        }
        $cadenaTipoDocLegal = '{' . rtrim($cadenaTipoDocLegal, ',') . '}';

        //Tipos de Documento Informacion Administrativa
        $documentosAdministrativa = LicitacionInformacionAdministrativa::where('id_status_delete', 1)->get();
        $cadenaTipoDocAdministrativa = "";
        foreach ($documentosAdministrativa as $documento) {
            $cadenaTipoDocAdministrativa .= '"' . $documento->id . '":"' . $documento->informacion . '",';
        }
        $cadenaTipoDocAdministrativa = '{' . rtrim($cadenaTipoDocAdministrativa, ',') . '}';

        //Tipos de Documento Informacion Fiscal
        $documentosFiscal = LicitacionInformacionFiscal::where('id_status_delete', 1)->get();
        $cadenaTipoDocFiscal = "";
        foreach ($documentosFiscal as $documento) {
            $cadenaTipoDocFiscal .= '"' . $documento->id . '":"' . $documento->informacion . '",';
        }
        $cadenaTipoDocFiscal = '{' . rtrim($cadenaTipoDocFiscal, ',') . '}';

        //Tipos de Documento Informacion Financiera
        $documentosFinanciera = LicitacionInformacionFinanciera::where('id_status_delete', 1)->get();
        $cadenaTipoDocFinanciera = "";
        foreach ($documentosFinanciera as $documento) {
            $cadenaTipoDocFinanciera .= '"' . $documento->id . '":"' . $documento->informacion . '",';
        }
        $cadenaTipoDocFinanciera = '{' . rtrim($cadenaTipoDocFinanciera, ',') . '}';

        return view('licitaciones.propuestatecnica.crear-propuesta-tecnica', compact('licitacion', 'propuesta', 'cadenaTipoDocLegal', 'cadenaTipoDocAdministrativa', 'cadenaTipoDocFiscal', 'cadenaTipoDocFinanciera', 'propuesta_tecnica_legal_documentos', 'propuesta_tecnica_administrativa_documentos', 'propuesta_tecnica_fiscal_documentos', 'propuesta_tecnica_financiera_documentos', 'propuesta_tecnica_otro_documentos', 'cadenaTipoDocGestor', 'cadenaSelectSubtext', 'permiso_array'));
    }


    public function guardarPropuestaTecnica(Request $request)
    {
        /* Getting the information of the Licitation. */
        $licitacion_id = $request->input('licitacion_id');
        $licitacion = Licitacion::find($licitacion_id);

        //Recepcion de la informacion de Legal
        if ($request->id_documento_legal) {

            $colIdDocumento = $request->id_documento_legal;
            $archivos = $request->id_documento_legal;

            foreach ($request->id_documento_legal as $indice => $archivo) {
                $tipo_documento = $colIdDocumento[$indice];

                $data = [
                    'licitacion_id' => $licitacion_id,
                    'licitacion_gestor_documentos_id' => $tipo_documento,
                    'documento' => "",
                    'mime_type' => "",
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'iduserCreated' => auth()->user()->id,
                    'iduserUpdated' => auth()->user()->id
                ];
                LicitacionPropuestaTecnicaLegal::insert($data);
            }
        }

        //Recepcion de la informacion de Administrativa
        if ($request->id_documento_administrativa) {

            $colIdDocumentoAdministrativa = $request->id_documento_administrativa;
            $archivosAdministrativa = $request->id_documento_administrativa;

            foreach ($archivosAdministrativa as $indice => $archivo) {
                $tipo_documento = $colIdDocumentoAdministrativa[$indice];

                $data = [
                    'licitacion_id' => $licitacion_id,
                    'licitacion_gestor_documentos_id' => $tipo_documento,
                    'documento' => "",
                    'mime_type' => "",
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'iduserCreated' => auth()->user()->id,
                    'iduserUpdated' => auth()->user()->id
                ];

                LicitacionPropuestaTecnicaAdministrativa::insert($data);
            }
        }

        //Recepcion de la informacion de Fiscal
        if ($request->id_documento_fiscal) {

            $colIdDocumentoFiscal = $request->id_documento_fiscal;
            $archivosFiscal = $request->id_documento_fiscal;

            foreach ($archivosFiscal as $indice => $archivo) {
                $tipo_documento = $colIdDocumentoFiscal[$indice];

                $data = [
                    'licitacion_id' => $licitacion_id,
                    'licitacion_gestor_documentos_id' => $tipo_documento,
                    'documento' => "",
                    'mime_type' => "",
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'iduserCreated' => auth()->user()->id,
                    'iduserUpdated' => auth()->user()->id
                ];

                LicitacionPropuestaTecnicaFiscal::insert($data);
            }
        }

        //Recepcion de la informacion de Financiera
        if ($request->id_documento_financiera) {

            $colIdDocumentoFinanciera = $request->id_documento_financiera;
            $archivosFinanciera = $request->id_documento_financiera;

            foreach ($archivosFinanciera as $indice => $archivo) {
                $tipo_documento = $colIdDocumentoFinanciera[$indice];

                $data = [
                    'licitacion_id' => $licitacion_id,
                    'licitacion_gestor_documentos_id' => $tipo_documento,
                    'documento' => "",
                    'mime_type' => "",
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'iduserCreated' => auth()->user()->id,
                    'iduserUpdated' => auth()->user()->id
                ];

                LicitacionPropuestaTecnicaFinanciera::insert($data);
            }
        }

        //Recepcion de la informacion de Otros
        if ($request->hasfile('archivo_otros')) {

            /* Getting the value of the input with the name `descripcion_otros` */
            $colIdDocumentoOtros = $request->descripcion_otros;
            $archivosOtros = $request->file('archivo_otros');

            foreach ($archivosOtros as $indice => $archivo) {
                $archivoNombre = $archivo->hashName();
                Storage::putFileAs('licitacion/' . $licitacion->folio . '/propuestatecnica', $archivo, $archivoNombre);
                $tipo_documento = $colIdDocumentoOtros[$indice];

                $data = [
                    'licitacion_id' => $licitacion_id,
                    'licitacion_informacion_otro' => $tipo_documento,
                    'documento' => $archivoNombre,
                    'mime_type' => $archivo->getMimeType(),
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'iduserCreated' => auth()->user()->id,
                    'iduserUpdated' => auth()->user()->id
                ];

                LicitacionPropuestaTecnicaOtro::insert($data);
            }
        }

        session()->flash('success', 'El documento se creo correctamente');
        return redirect()->route('propuestatecnica.crearpropuestatecnica', $licitacion_id);
    }


    public function eliminarPropuestaTecnica(Request $request)
    {
        $id = $request->id;
        $tipo = $request->tipo;
        $licitacion_folio = $request->folio;
        $estatus = false;


        if ($tipo == 'legal') {

            $archivo = LicitacionPropuestaTecnicaLegal::where('id', $id)->first();
            Storage::delete('licitacion/' . $licitacion_folio . '/propuestatecnica/' . $archivo->documento);
            LicitacionPropuestaTecnicaLegal::where('id', $id)->delete();
            $estatus = true;
        } elseif ($tipo == 'administrativa') {
            $archivo = LicitacionPropuestaTecnicaAdministrativa::where('id', $id)->first();
            Storage::delete('licitacion/' . $licitacion_folio . '/propuestatecnica/' . $archivo->documento);
            LicitacionPropuestaTecnicaAdministrativa::where('id', $id)->delete();
            $estatus = true;
        } elseif ($tipo == 'fiscal') {
            $archivo = LicitacionPropuestaTecnicaFiscal::where('id', $id)->first();
            Storage::delete('licitacion/' . $licitacion_folio . '/propuestatecnica/' . $archivo->documento);
            LicitacionPropuestaTecnicaFiscal::where('id', $id)->delete();
            $estatus = true;
        } elseif ($tipo == 'financiera') {
            $archivo = LicitacionPropuestaTecnicaFinanciera::where('id', $id)->first();
            Storage::delete('licitacion/' . $licitacion_folio . '/propuestatecnica/' . $archivo->documento);
            LicitacionPropuestaTecnicaFinanciera::where('id', $id)->delete();
            $estatus = true;
        } elseif ($tipo == 'otros') {
            $archivo = LicitacionPropuestaTecnicaOtro::where('id', $id)->first();
            Storage::delete('licitacion/' . $licitacion_folio . '/propuestatecnica/' . $archivo->documento);
            LicitacionPropuestaTecnicaOtro::where('id', $id)->delete();
            $estatus = true;
        }

        return response()->json([
            'estatus' => $estatus,
        ]);
    }

    public function PropuestaTecnicadoc($licitacion)
    {
        $propuesta = LicitacionPropuestaCargaPreliminar::where('licitaciones_id', $licitacion)->orderBy("num", "asc")->get();
        $propuesta_tecnica =LicitacionPropuestaCargaFinal::where('licitaciones_id', $licitacion)->where('seccion', 1)->orderBy("num", "asc")->get(); // propuesta tecnica
        $propuesta_economica =LicitacionPropuestaCargaFinal::where('licitaciones_id', $licitacion)->where('seccion', 2)->orderBy("num", "asc")->get(); // propuesta económica
        $propuesta_administrativa =LicitacionPropuestaCargaFinal::where('licitaciones_id', $licitacion)->where('seccion', 3)->orderBy("num", "asc")->get(); // propuesta administrativa y legal
        $propuesta_otros =LicitacionPropuestaCargaFinal::where('licitaciones_id', $licitacion)->where('seccion', 4)->orderBy("num", "asc")->get(); // propuesta otros

        $propuesta_if = LicitacionPropuestaCargaPreliminar::where('licitaciones_id', $licitacion)->orderBy("num", "asc")->first();

        return view('licitaciones.propuestatecnica.propuesta-tecnica-documentacion', compact('licitacion', 'propuesta','propuesta_tecnica', 'propuesta_if', 'propuesta_economica', 'propuesta_administrativa', 'propuesta_otros'));
    }

    public function cargamasivaexcel(Request $request)
    {
        Excel::import( new PropuestaeconomicaImport($request->licitacion_id), $request->file('file_carga'));

        session()->flash('success', 'Se importó correctamente el archivo.');
        return redirect()->route('propuestatecnica.propuestatecnicadoc',$request->licitacion_id);
    }

    public function eliminardocumento(Request $request)
    {

         LicitacionPropuestaCargaPreliminar::where('id', $request->id)->delete();

        session()->flash('success', 'Se elimino correctamente el archivo.');
        return redirect()->route('propuestatecnica.propuestatecnicadoc',$request->licitacion_id);

    }

    public function cargadocumentosreal(Request $request)
    {

        $propuesta = LicitacionPropuestaCargaPreliminar::where('licitaciones_id', $request->licitacion_id)->get();

        
        for($i = 0; $i <= count($request->id); $i++){
            if (isset($request->file('file_carga')[$i])) {

                if($request->seccion[$i] == 0){
                    $seccion = 4;
                }else{
                    $seccion = $request->seccion[$i];
                }

                Storage::putFileAs('licitacion/' . "L00017",  $request->file('file_carga')[$i], $request->file('file_carga')[$i]->hashName());
                // $dato ="Existe";
                $id_preliminar = $propuesta[$i]->id;
                $data = [
                    'num' => $propuesta[$i]->num,
                    'nombre_requerimiento' => $propuesta[$i]->nombre_requerimiento,
                    'descripcion' => $propuesta[$i]->descripcion,
                    'obligatorio' => $propuesta[$i]->obligatorio,
                    'respuesta' => $propuesta[$i]->respuesta,
                    'acciones' => $propuesta[$i]->acciones,
                    'licitaciones_id' => $request->licitacion_id,
                    'seccion' => $seccion,
                    'archivo_propuesta' => $request->file('file_carga')[$i]->hashName(),
                    'iduserCreated' => auth()->user()->id,
                    'iduserUpdated' => auth()->user()->id,
                ];

                LicitacionPropuestaCargaFinal::insert($data);

                LicitacionPropuestaCargaPreliminar::where('id', $propuesta[$i]->id)->delete();

            }else{
                // $dato="No existe";
            }
        }
      
        session()->flash('success', 'Se importó correctamente el archivo.');
        return redirect()->route('propuestatecnica.propuestatecnicadoc',$request->licitacion_id);


    }


    public function eliminardocumentoreal(Request $request)
    {
        LicitacionPropuestaCargaFinal::where('id', $request->id)->delete();

        session()->flash('success', 'Se elimino correctamente el archivo.');
        return redirect()->route('propuestatecnica.propuestatecnicadoc',$request->licitacion_id);        
    }



}
