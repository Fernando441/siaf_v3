<?php

namespace App\Http\Controllers\Siniestros;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\Services\Folio;
use Maatwebsite\Excel\Facades\Excel;

use App\Models\User;
use App\Models\Rol;
use App\Models\RolPermiso;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use App\Models\Siniestros\SiniestroAgencia;
use App\Models\Siniestros\SiniestroDina;
use App\Models\Siniestros\SiniestroSicurezza;
use App\Models\Siniestros\SiniestroTipoDocumento;
use App\Models\Siniestros\SiniestroDinaHistorial;
use App\Models\Siniestros\SiniestroSDinaHistorialRAplicada;
use App\Models\Siniestros\SiniestroDinaEvidencia;
use App\Imports\SiniestrosDinaImport;

use App\Models\Unidad\Unidad;
use App\Models\Unidad\FotoUnidad;
use App\Models\Unidad\UnidadFotografia;


class SiniestrosDinaController extends Controller
{
    protected $folio;
    public function __construct(Folio $folio)
    {
        $this->middleware('auth');
        $this->folio = $folio;

    }

    public function catalogodina()
    {
        $siniestro_dina = SiniestroDina::where('siniestros_agencia_id', 1)->get();
        $siniestro_con_deducible = SiniestroDina::where('siniestros_agencia_id', 1)->where('deducible', '!=' , "0.00")->get();
        $siniestro_con_recuperacion = SiniestroDina::where('siniestros_agencia_id', 1)->where('recuperacion_aplicada', '!=' , "0.00")->get();
        $siniestro_con_ambas = SiniestroDina::where('deducible', '!=' , "0.00")->where('recuperacion_aplicada', '!=' , "0.00")->get();

        return view('siniestro.dina.catalogo-dina', compact('siniestro_dina', 'siniestro_con_deducible', 'siniestro_con_recuperacion', 'siniestro_con_ambas'));
    }

    public function cargamasivadina(Request $request)
    {
        Excel::import( new SiniestrosDinaImport(), $request->file('file_carga'));

        session()->flash('success', 'Se importó correctamente el archivo.');
        return redirect()->route('siniestro.catalogodina');
    }

    public function versiniestro($id_siniestro)
    {
  
        $siniestro_dina = SiniestroDina::where('id', $id_siniestro)->first();  
        $unidad = Unidad::where('no_serie', $siniestro_dina->serie)->first(); 
        if($unidad){
            $fotografias = UnidadFotografia::where('unidad_id', $unidad->id)->get();
            $active = UnidadFotografia::where('unidad_id', $unidad->id)->first();

            if ($active == null) {
                $ver = 0;
            } else {
                $ver = $active->id;
            }
        }else{
            $fotografias = 1;
            $ver = 0;
        }

        return view('siniestro.dina.ver-registro-dina', compact('siniestro_dina', 'id_siniestro', 'unidad', 'fotografias', 'ver')); 
    }

    public function editasiniestro($id_siniestro)
    {
        $siniestro_dina = SiniestroDina::where('id', $id_siniestro)->first(); 
        $documentos = SiniestroTipoDocumento::where('id_status_delete',1)->get();
        $cadenaTipoDocumento = "";
        foreach($documentos as $documento){
            $cadenaTipoDocumento .= '"'.$documento->id.'":"'.$documento->nombre_documento.'",';
        }
        $cadenaTipoDocumento = '{'.rtrim($cadenaTipoDocumento, ',').'}';

        $historial_deducibles = SiniestroDinaHistorial::where('registro_dina_id', $id_siniestro)->get();
        $historial_raplicada = SiniestroSDinaHistorialRAplicada::where('registro_dina_id', $id_siniestro)->get();
        $evidencia_siniestro = SiniestroDinaEvidencia::where('siniestros_dina_id', $id_siniestro)->get();

        return view('siniestro.dina.editar-registro-dina', compact('siniestro_dina', 'id_siniestro', 'cadenaTipoDocumento', 'historial_deducibles', 'historial_raplicada', 'evidencia_siniestro')); 
    }


    public function editsiniestrodina(Request $request)
    {
        $siniestro_dina = SiniestroDina::where('id', $request->id)->first();
        if($siniestro_dina->deducible == $request->deducible){
            if($siniestro_dina->op_deducible == 1)
            {
                $op_deducible = 1; 
            }else{
                $op_deducible = 0; 
            }
            
        }else{
            $data_deducible = [
                'registro_dina_id' => $request->id,
                'deducible' => $siniestro_dina->deducible,
                'created_at' =>date('Y-m-d H:i:s'),
                'iduserCreated' =>auth()->user()->id,
            ];
            SiniestroDinaHistorial::insert($data_deducible);
            $op_deducible = 1;
        }
        
        if($siniestro_dina->recuperacion_aplicada == $request->recuperacion_aplicada){

            if($siniestro_dina->op_recuperacion_aplicada == 1)
            {
                $op_recuperacion = 1; 
            }else{
                $op_recuperacion = 0; 
            }
        }else{
            $data_deducible = [
                'registro_dina_id' => $request->id,
                'recuperacion_aplicada' => $siniestro_dina->recuperacion_aplicada,
                'created_at' =>date('Y-m-d H:i:s'),
                'iduserCreated' =>auth()->user()->id,
            ];
            SiniestroSDinaHistorialRAplicada::insert($data_deducible);
            $op_recuperacion = 1;
        }

        $data = [
            'deducible' => $request->deducible,
            'recuperacion_aplicada' => $request->recuperacion_aplicada,
            'no_siniestro' => $request->no_siniestro,
            'serie' => $request->serie,
            'contratante' => $request->contratante,
            'proyecto_poliza' => $request->proyecto_poliza,
            'nombre_proyecto' => $request->nombre_proyecto,
            'inicio' => $request->inicio,
            'fin' => $request->fin,
            'moneda' => $request->moneda,
            'poliza' => $request->poliza,
            'fecha_ocurrencia' => $request->fecha_ocurrencia,
            'tipo_siniestro_inicial' => $request->tipo_siniestro_inicial,
            'nombre_agente' => $request->nombre_agente,
            'modelo' => $request->modelo,
            'op_deducible' => $op_deducible,
            'op_recuperacion_aplicada' => $op_recuperacion,
            'updated_at' =>date('Y-m-d H:i:s'),
            'iduserUpdated' =>auth()->user()->id,
        ];

        SiniestroDina::where('id', $request->id)->update($data);

        $colIdDocumento = $request->id_documento;
        if($request->hasfile('archivo')){
            $archivos = $request->file('archivo');
            foreach($archivos as $indice => $archivo)
            {
                $archivoNombre = $archivo->hashName();
                $mimeType = $archivo->getMimeType();
                Storage::putFileAs('Siniestrodina/'.$request->id, $archivo, $archivoNombre);
                $data = [
                    'siniestros_dina_id' => $request->id,
                    'tipo_documento_id' =>$colIdDocumento[$indice],
                    'documento' => $archivoNombre,
                    'created_at' =>date('Y-m-d H:i:s'),
                    'updated_at' =>date('Y-m-d H:i:s'),
                    'iduserCreated' =>auth()->user()->id,
                    'iduserUpdated' =>auth()->user()->id
                ];
                SiniestroDinaEvidencia::insert($data);
            }
        }

        session()->flash('success', 'El siniestro se modifico correctamente');
        return redirect()->route('siniestro.catalogodina');
    }

    public function deletedinaevidencia(Request $request)
    {
        $doc = SiniestroDinaEvidencia::findOrFail($request->id);
        $estatus = true;
        if ($doc){
            Storage::delete('Siniestrodina/'.$doc->id.'/'.$doc->documento);
            SiniestroDinaEvidencia::where('id', $request->id)->delete();
        }else{
            $estatus = false;
        }

        return response()->json([
            'estatus' => $estatus,
        ]);
    }

    public function crearsiniestro()
    {
        
        $documentos = SiniestroTipoDocumento::where('id_status_delete',1)->get();

        //tipo de documentos en formato json
        $cadenaTipoDocumento = "";
        foreach($documentos as $documento){
            $cadenaTipoDocumento .= '"'.$documento->id.'":"'.$documento->nombre_documento.'",';
        }
        $cadenaTipoDocumento = '{'.rtrim($cadenaTipoDocumento, ',').'}';

        return view('siniestro.dina.crear-registro-dina', compact('cadenaTipoDocumento'));
    }

    public function guardardina(Request $request)
    {
    
        $data = [
            'no_folio' => $this->folio->getFolioSiniestroDina(),
            'siniestros_agencia_id' => 1,
            'no_siniestro' => $request->no_siniestro,
            'contratante' => $request->contratante,
            'proyecto_poliza' => $request->proyecto_poliza,
            'nombre_proyecto' => $request->nombre_proyecto,
            'inicio' => $request->inicio,
            'fin' => $request->fin,
            'moneda' => $request->moneda,
            'poliza' => $request->poliza,
            'serie' => $request->serie,
            'fecha_ocurrencia' => $request->fecha_ocurrencia,
            'tipo_siniestro_inicial' => $request->tipo_siniestro_inicial,
            'deducible' => $request->deducible,
            'recuperacion_aplicada' => $request->recuperacion_aplicada,
            'nombre_agente' => $request->nombre_agente,
            'modelo' => $request->modelo,
            'op_modificado' => 0,
            'op_deducible' => 0,
            'op_recuperacion_aplicada' => 0,
            'iduserCreated' =>auth()->user()->id,
            'iduserUpdated' =>auth()->user()->id,
            'created_at' =>date('Y-m-d H:i:s'),
            'updated_at' =>date('Y-m-d H:i:s')
        ];

        $id_siniestro = SiniestroDina::insertGetId($data);  

        $colIdDocumento = $request->id_documento;
        if($request->hasfile('archivo')){
            $archivos = $request->file('archivo');
            foreach($archivos as $indice => $archivo)
            {
                $archivoNombre = $archivo->hashName();
                $mimeType = $archivo->getMimeType();
                Storage::putFileAs('Siniestrodina/'.$id_siniestro, $archivo, $archivoNombre);
                $data = [
                    'siniestros_dina_id' => $id_siniestro,
                    'tipo_documento_id' =>$colIdDocumento[$indice],
                    'documento' => $archivoNombre,
                    'created_at' =>date('Y-m-d H:i:s'),
                    'updated_at' =>date('Y-m-d H:i:s'),
                    'iduserCreated' =>auth()->user()->id,
                    'iduserUpdated' =>auth()->user()->id
                ];
                SiniestroDinaEvidencia::insert($data);
            }
        }

        session()->flash('success', 'El siniestro se modifico correctamente');
        return redirect()->route('siniestro.catalogodina');

    }

}