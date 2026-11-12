<?php

namespace App\Http\Controllers\Sistemas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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

use App\Models\Sistemas\InventarioComputo;
use App\Models\Sistemas\InventarioTipoComputo;
use App\Models\Sistemas\InventarioEvidenciaComputo;
use App\Models\Sistemas\InventarioTipoEvidenciaComputo;
use App\Models\Licitacion\ComprasRequisicion;


class InventarioComputoController extends Controller
{
    protected $folio;
    public function __construct(Folio $folio)
    {
        $this->middleware('auth');
        $this->folio = $folio;

    }

    public function catalogoinventario()
    {

    	$inventario = InventarioComputo::where('id_status_delete', 1)->get();
        return view('sistemas.inventario.catalogo-inv-computo', compact('inventario'));
    }

    public function agregarRegistro()
    {
    	$tipo_equipo = InventarioTipoComputo::where('id_status_delete', 1)->get();
    	$req_compras = ComprasRequisicion::where('op_estatus', 2)->get();
        $documentos = InventarioTipoEvidenciaComputo::where('id_status_delete',1)->get();

        //tipo de documentos en formato json
        $cadenaTipoDocumento = "";
        foreach($documentos as $documento){
            $cadenaTipoDocumento .= '"'.$documento->id.'":"'.$documento->tipo_evidencia.'",';
        }
        $cadenaTipoDocumento = '{'.rtrim($cadenaTipoDocumento, ',').'}';


    	return view('sistemas.inventario.agregar-reg-computo', compact('cadenaTipoDocumento', 'tipo_equipo', 'req_compras'));
    }

    public function guardarRegistro(Request $request)
    {

    	if($request->requisicion_compras_id == null){ $op_req = null; $status_req = 0; }else { $op_req = $request->requisicion_compras_id; $status_req = 1;}
    	
        $data = [
        	'no_folio'=>$this->folio->getFolioEquipoComputo(),
            'requisicion_compras_id' => $op_req,
            'tipo_equipo_id' =>  $request->tipo_equipo_id,
            'op_requisicion'=> $status_req,
            'no_serie' => $request->no_serie,
            'marca' => $request->marca,
            'modelo' => $request->modelo,
            'fecha_ingreso' =>  $request->fecha_ingreso,
            'descripcion' =>  $request->descripcion,
            'estatus_asignado' =>  0,
            'id_status_delete' => 1,
            'created_at' =>date('Y-m-d H:i:s'),
            'updated_at' =>date('Y-m-d H:i:s'),
            'iduserCreated' =>auth()->user()->id,
            'iduserUpdated' =>auth()->user()->id,
        ];
        // dd($data);
        $id_registro= InventarioComputo::insertGetId($data);

        $colIdDocumento = $request->id_documento;
        if($request->hasfile('archivo')){
            $archivos = $request->file('archivo');
            foreach($archivos as $indice => $archivo)
            {
                $archivoNombre = $archivo->hashName();
                $mimeType = $archivo->getMimeType();
                Storage::putFileAs('sistemas/equipocomputo/'.$id_registro, $archivo, $archivoNombre);
                $data = [
                    'id_inventario' => $id_registro,
                    'tipo_evidencia_id' =>$colIdDocumento[$indice],
                    'documento' => $archivoNombre,
                    'created_at' =>date('Y-m-d H:i:s'),
                    'updated_at' =>date('Y-m-d H:i:s'),
                    'iduserCreated' =>auth()->user()->id,
                    'iduserUpdated' =>auth()->user()->id
                ];
                InventarioEvidenciaComputo::insert($data);
            }
        }

        session()->flash('success', 'El registro se añadió correctamente');
        return redirect()->route('sistemas.catalogoinventario');

    }

    public function editarRegistro($id_equipo)
    {
    	$inventario = InventarioComputo::where('id', $id_equipo)->first();
    	$tipo_equipo = InventarioTipoComputo::where('id_status_delete', 1)->get();
    	$req_compras = ComprasRequisicion::where('op_estatus', 2)->get();
        $documentos = InventarioTipoEvidenciaComputo::where('id_status_delete',1)->get();

        //tipo de documentos en formato json
        $cadenaTipoDocumento = "";
        foreach($documentos as $documento){
            $cadenaTipoDocumento .= '"'.$documento->id.'":"'.$documento->tipo_evidencia.'",';
        }
        $cadenaTipoDocumento = '{'.rtrim($cadenaTipoDocumento, ',').'}';

        $evidencia = InventarioEvidenciaComputo::where('id_inventario',$id_equipo)->get();

    	return view('sistemas.inventario.editar-reg-computo', compact('cadenaTipoDocumento', 'tipo_equipo', 'req_compras', 'inventario', 'id_equipo', 'evidencia'));
    }

    public function updateRegistro(Request $request)
    {
    	if($request->requisicion_compras_id == null){ $op_req = null; $status_req = 0; }else { $op_req = $request->requisicion_compras_id; $status_req = 1;}
    	
        $data = [
            'requisicion_compras_id' => $op_req,
            'tipo_equipo_id' =>  $request->tipo_equipo_id,
            'op_requisicion'=> $status_req,
            'no_serie' => $request->no_serie,
            'marca' => $request->marca,
            'modelo' => $request->modelo,
            'fecha_ingreso' =>  $request->fecha_ingreso,
            'descripcion' =>  $request->descripcion,
            'estatus_asignado' =>  0,
            'id_status_delete' => 1,
            'created_at' =>date('Y-m-d H:i:s'),
            'updated_at' =>date('Y-m-d H:i:s'),
            'iduserCreated' =>auth()->user()->id,
            'iduserUpdated' =>auth()->user()->id,
        ];
        // dd($data);
        $id_registro= InventarioComputo::where('id', $request->id)->update($data);

        $colIdDocumento = $request->id_documento;
        if($request->hasfile('archivo')){
            $archivos = $request->file('archivo');
            foreach($archivos as $indice => $archivo)
            {
                $archivoNombre = $archivo->hashName();
                $mimeType = $archivo->getMimeType();
                Storage::putFileAs('sistemas/equipocomputo/'.$request->id, $archivo, $archivoNombre);
                $data = [
                    'id_inventario' => $request->id,
                    'tipo_evidencia_id' =>$colIdDocumento[$indice],
                    'documento' => $archivoNombre,
                    'created_at' =>date('Y-m-d H:i:s'),
                    'updated_at' =>date('Y-m-d H:i:s'),
                    'iduserCreated' =>auth()->user()->id,
                    'iduserUpdated' =>auth()->user()->id
                ];
                InventarioEvidenciaComputo::insert($data);
            }
        }

        session()->flash('success', 'El registro se añadió correctamente');
        return redirect()->route('sistemas.catalogoinventario');    	
    }


    public function eliminarevidencia(Request $request)
    {
        $doc = InventarioEvidenciaComputo::findOrFail($request->id);
        $estatus = true;
        if ($doc){
            Storage::delete('sistemas/equipocomputo/'.$doc->id_cliente.'/'.$doc->documento);
            InventarioEvidenciaComputo::where('id', $request->id)->delete();
        }else{
            $estatus = false;
        }

        return response()->json([
            'estatus' => $estatus,
        ]);   	
    }

    public function verRegistro($id_equipo)
    {
    	$inventario = InventarioComputo::where('id', $id_equipo)->first();
    	$tipo_equipo = InventarioTipoComputo::where('id_status_delete', 1)->get();
    	$req_compras = ComprasRequisicion::where('op_estatus', 2)->get();
        $documentos = InventarioTipoEvidenciaComputo::where('id_status_delete',1)->get();

        //tipo de documentos en formato json
        $cadenaTipoDocumento = "";
        foreach($documentos as $documento){
            $cadenaTipoDocumento .= '"'.$documento->id.'":"'.$documento->tipo_evidencia.'",';
        }
        $cadenaTipoDocumento = '{'.rtrim($cadenaTipoDocumento, ',').'}';

        $evidencia = InventarioEvidenciaComputo::where('id_inventario',$id_equipo)->get();

    	return view('sistemas.inventario.ver-reg-computo', compact('cadenaTipoDocumento', 'tipo_equipo', 'req_compras', 'inventario', 'id_equipo', 'evidencia'));    	
    }

    public function catalogoinventarioinactivos()
    {
        $inventario = InventarioComputo::where('id_status_delete', 2)->get();

        return view('sistemas.inventario.catalogo-inv-computo-inactivos', compact('inventario'));        
    }

    public function deleteRegistro(Request $request)
    {
        $data = [
            'id_status_delete' => 2,
            'motivo_delete' => $request->motivo,
            'updated_at' =>date('Y-m-d H:i:s')
        ];

        InventarioComputo::where('id', $request->id)->update($data);

        session()->flash('success', 'El registro se desactivo correctamente');
        return redirect()->route('sistemas.catalogoinventario');        
    }

    public function activarRegistro(Request $request)
    {
        $data = [
            'id_status_delete' => 1,
            'updated_at' =>date('Y-m-d H:i:s')
        ];

        InventarioComputo::where('id', $request->id)->update($data);

        session()->flash('success', 'El registro se desactivo correctamente');
        return redirect()->route('sistemas.catalogoinventarioinactivos');         
    }

}