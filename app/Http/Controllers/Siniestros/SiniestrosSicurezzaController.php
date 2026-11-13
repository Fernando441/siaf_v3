<?php

namespace App\Http\Controllers\Siniestros;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use App\Services\Folio;
use Maatwebsite\Excel\Facades\Excel;

use App\Models\User;
use App\Models\Rol;
use App\Models\RolPermiso;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use App\Models\Siniestros\SiniestroAgencia;
use App\Models\Siniestros\SiniestroSicurezza;
use App\Models\Siniestros\SiniestroFolioSicurezza;
use App\Models\Siniestros\SiniestroSicurezzaHistorial;
use App\Models\Siniestros\SiniestroSicurezzaHistorialRAplicada;
use App\Models\Siniestros\SiniestroTipoDocumento;
use App\Models\Siniestros\SiniestroSicurezzaEvidencia;
use App\Imports\SiniestrosSicuezzaImport;

use App\Models\Unidad\Unidad;
use App\Models\Unidad\FotoUnidad;
use App\Models\Unidad\UnidadFotografia;

class SiniestrosSicurezzaController extends Controller
{
    protected $folio;
    public function __construct(Folio $folio)
    {
        $this->middleware('auth');
        $this->folio = $folio;

    }

    public function catalogosicurezza()
    {
        $siniestro_con_deducible = SiniestroSicurezza::where('siniestros_agencia_id', 2)->where('deducibles', '!=' , "0.00")->get();
        $siniestro_con_recuperacion = SiniestroSicurezza::where('siniestros_agencia_id', 2)->where('recuperacion_aplicada', '!=' , "0.00")->get();
        $siniestro_sicurezza = SiniestroSicurezza::where('siniestros_agencia_id', 2)->get();
        $siniestro_con_ambas = SiniestroSicurezza::where('deducibles', '!=' , "0.00")->where('recuperacion_aplicada', '!=' , "0.00")->get();

        return view('siniestro.sicurezza.catalogo-sicurezza', compact('siniestro_sicurezza', 'siniestro_con_deducible', 'siniestro_con_recuperacion', 'siniestro_con_ambas'));
    }

    public function cargamasivasicuezza(Request $request)
    {
        Excel::import( new SiniestrosSicuezzaImport(), $request->file('file_carga'));

        session()->flash('success', 'Se importó correctamente el archivo.');
        return redirect()->route('siniestro.catalogosicurezza');
    } 

    public function versiniestrosic($id_siniestro)
    {
        $siniestro_sicurezza = SiniestroSicurezza::where('id', $id_siniestro)->first(); 
        $unidad = Unidad::where('no_serie', $siniestro_sicurezza->serie)->first(); 
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
        return view('siniestro.sicurezza.ver-registro-sicurezza', compact('siniestro_sicurezza', 'id_siniestro', 'unidad', 'fotografias', 'ver')); 
    }  

    public function editarsiniestrosic($id_siniestro)
    {
        $siniestro_sicurezza = SiniestroSicurezza::where('id', $id_siniestro)->first();
        $documentos = SiniestroTipoDocumento::where('id_status_delete',1)->get();
        $cadenaTipoDocumento = "";
        foreach($documentos as $documento){
            $cadenaTipoDocumento .= '"'.$documento->id.'":"'.$documento->nombre_documento.'",';
        }
        $cadenaTipoDocumento = '{'.rtrim($cadenaTipoDocumento, ',').'}';

        $historial_deducibles = SiniestroSicurezzaHistorial::where('registro_sicurezza_id', $id_siniestro)->get();
        $historial_raplicada = SiniestroSicurezzaHistorialRAplicada::where('registro_sicurezza_id', $id_siniestro)->get();
        

        return view('siniestro.sicurezza.editar-registro-sicurezza', compact('siniestro_sicurezza', 'id_siniestro', 'cadenaTipoDocumento', 'historial_deducibles', 'historial_raplicada'));  
    } 

    public function editsiniestrosic(Request $request)
    {

        $siniestro_sicurezza = SiniestroSicurezza::where('id', $request->id)->first();
        if($siniestro_sicurezza->deducibles == $request->deducibles){
            if($siniestro_sicurezza->op_deducible == 1)
            {
                $op_deducible = 1; 
            }else{
                $op_deducible = 0; 
            }
            
        }else{
            $data_deducible = [
                'registro_sicurezza_id' => $request->id,
                'deducible' => $siniestro_sicurezza->deducibles,
                'created_at' =>date('Y-m-d H:i:s'),
                'iduserCreated' =>auth()->user()->id,
            ];
            SiniestroSicurezzaHistorial::insert($data_deducible);
            $op_deducible = 1;
        }
        
        if($siniestro_sicurezza->recuperacion_aplicada == $request->recuperacion_aplicada){

            if($siniestro_sicurezza->op_recuperacion_aplicada == 1)
            {
                $op_recuperacion = 1; 
            }else{
                $op_recuperacion = 0; 
            }
        }else{
            $data_deducible = [
                'registro_sicurezza_id' => $request->id,
                'recuperacion_aplicada' => $siniestro_sicurezza->recuperacion_aplicada,
                'created_at' =>date('Y-m-d H:i:s'),
                'iduserCreated' =>auth()->user()->id,
            ];
            SiniestroSicurezzaHistorialRAplicada::insert($data_deducible);
            $op_recuperacion = 1;
        }  

        $data = [
            'siniestro_completo' => $request->siniestro_completo,
            'deducibles' => $request->deducibles,
            'recuperacion_aplicada' => $request->recuperacion_aplicada,
            'proyecto' => $request->proyecto,
            'serie' => $request->serie,
            'fecha_ocurrencia' => $request['fecha_ocurrencia'],
            'causa_enfermedad' => $request->causa_enfermedad,
            'nombre_agente' => $request->nombre_agente,
            'asegurado' => $request->asegurado,
            'modelo' => $request->modelo,
            'descripcion_auto' => $request->descripcion_auto,
            'op_deducible' => $op_deducible,
            'op_recuperacion_aplicada' => $op_recuperacion,
            'updated_at' =>date('Y-m-d H:i:s'),
            'iduserUpdated' =>auth()->user()->id,
        ];

        SiniestroSicurezza::where('id', $request->id)->update($data);

        $colIdDocumento = $request->id_documento;
        if($request->hasfile('archivo')){
            $archivos = $request->file('archivo');
            foreach($archivos as $indice => $archivo)
            {
                $archivoNombre = $archivo->hashName();
                $mimeType = $archivo->getMimeType();
                Storage::putFileAs('Siniestro sicurezza/'.$request->id, $archivo, $archivoNombre);
                $data = [
                    'siniestro_sicurezza_id' => $request->id,
                    'tipo_documento_id' =>$colIdDocumento[$indice],
                    'documento' => $archivoNombre,
                    'created_at' =>date('Y-m-d H:i:s'),
                    'updated_at' =>date('Y-m-d H:i:s'),
                    'iduserCreated' =>auth()->user()->id,
                    'iduserUpdated' =>auth()->user()->id
                ];
                SiniestroSicurezzaEvidencia::insert($data);
            }
        }

        session()->flash('success', 'El siniestro se modifico correctamente');
        return redirect()->route('siniestro.catalogosicurezza');
    }
}