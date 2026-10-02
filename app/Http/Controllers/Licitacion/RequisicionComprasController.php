<?php

namespace App\Http\Controllers\Licitacion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Money;
use App\Services\Folio;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\Requisicion\AreaPersonal;
use App\Models\Licitacion\Licitacion;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Rol;
use App\Models\RolPermiso;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use App\Models\Licitacion\ComprasRequisicion;
use App\Models\Licitacion\ComprasRequisicionDetalle;
use LDAP\Result;

class RequisicionComprasController extends Controller
{
    protected $folio;

    public function __construct(Folio $folio)
    {
        $this->middleware('auth');
        $this->folio = $folio;
    }

    public function reqcompras()
    {
    	$solicitante = auth()->user()->id;
    	$info_user = User::where('id', $solicitante)->first();
    	$data = ComprasRequisicion::where('id_status_delete', 1)->get();
    	// dd($data);

        return view('licitaciones.requisicion-compras.listado-requisiciones-compras', compact('data'));
    }

    public function creaarreqcompras()
    {
    	$solicitante = auth()->user()->id;
    	$info_user = User::where('id', $solicitante)->first();
    	$area = AreaPersonal::where('id_status_delete', 1)->get();

    	return view('licitaciones.requisicion-compras.crear-requisiciones-compras', compact('info_user', 'area'));
    }

    public function guardarreqcompras(Request $request)
    {

        $data = [
            'area_personal_id' => $request->area_personal_id,
            'titulo_requisicion' => $request->titulo_requisicion,
            'fecha_requisicion' => $request->fecha_solicitud,
            'comentario' => $request->comentario,
            'op_estatus' => 0,
            'op_rechazo' => 0,
            'id_status_delete' => 1,
            'created_at' =>date('Y-m-d H:i:s'),
            'updated_at' =>date('Y-m-d H:i:s'),
            'iduserCreated' =>auth()->user()->id,
            'iduserUpdated' =>auth()->user()->id,
        ];
        $id_requisicion = ComprasRequisicion::insertGetId($data);

        $colIdDocumento = $request->descripcion;
        $colIdCantidad = $request->cantidad;
        $colIdObservaciones = $request->observaciones;
        if($request->descripcion){

            foreach($request->descripcion as $indice => $archivo)
            {
                // $archivoNombre = $archivo->hashName();

                $data = [
                    'requisicion_compras_id' => $id_requisicion,
                    'descripcion' =>$colIdDocumento[$indice],
                    'cantidad' => $colIdCantidad[$indice],
                    'obervaciones' => $colIdObservaciones[$indice],
                    'created_at' =>date('Y-m-d H:i:s'),
                    'updated_at' =>date('Y-m-d H:i:s'),
                    'iduserCreated' =>auth()->user()->id,
                    'iduserUpdated' =>auth()->user()->id
                ];
                // dd($data);
                ComprasRequisicionDetalle::insert($data);
            }
        }

        session()->flash('success', 'La requisición se añadió correctamente');
        return redirect()->route('reqcompras.reqcompras');
    }

    public function verreqcompras($id_requisicion)
    {
    	$solicitante = auth()->user()->id;
    	$info_user = User::where('id', $solicitante)->first();
    	$area = AreaPersonal::where('id_status_delete', 1)->get();
    	$requisicion = ComprasRequisicion::where('iduserCreated', $id_requisicion)->first();
    	$detalle = ComprasRequisicionDetalle::where('requisicion_compras_id', $requisicion->id)->get();

   		return view('licitaciones.requisicion-compras.ver-requisiciones-compras', compact('info_user', 'area', 'requisicion', 'detalle'));
    }

    public function editarreqcompras($id_requisicion)
    {
    	$solicitante = auth()->user()->id;
    	$info_user = User::where('id', $solicitante)->first();
    	$area = AreaPersonal::where('id_status_delete', 1)->get();
    	$requisicion = ComprasRequisicion::where('id', $id_requisicion)->first();

    	$detalle = ComprasRequisicionDetalle::where('requisicion_compras_id', $requisicion->id)->get();

   		return view('licitaciones.requisicion-compras.editar-requisiciones-compras', compact('info_user', 'area', 'requisicion', 'detalle'));    	
    }

    public function eliminardatorequisicon(Request $request)
    {
        $doc = ComprasRequisicionDetalle::findOrFail($request->id);
        $estatus = true;
        if ($doc){
            // Storage::delete('cliente/'.$doc->id_cliente.'/'.$doc->documento);
            ComprasRequisicionDetalle::where('id', $request->id)->delete();
        }else{
            $estatus = false;
        }

        return response()->json([
            'estatus' => $estatus,
        ]);
    }

    public function updatereqcompras(Request $request)
    {
        $data = [
            'area_personal_id' => $request->area_personal_id,
            'titulo_requisicion' => $request->titulo_requisicion,
            'fecha_requisicion' => $request->fecha_solicitud,
            'comentario' => $request->comentario,
            'updated_at' =>date('Y-m-d H:i:s'),
            'iduserUpdated' =>auth()->user()->id,
        ];
        ComprasRequisicion::where('id', $request->id_requisicion)->update($data);

        $colIdDocumento = $request->descripcion;
        $colIdCantidad = $request->cantidad;
        $colIdObservaciones = $request->observaciones;
        if($request->descripcion){

            foreach($request->descripcion as $indice => $archivo)
            {
                // $archivoNombre = $archivo->hashName();

                $data = [
                    'requisicion_compras_id' => $request->id_requisicion,
                    'descripcion' =>$colIdDocumento[$indice],
                    'cantidad' => $colIdCantidad[$indice],
                    'obervaciones' => $colIdObservaciones[$indice],
                    'created_at' =>date('Y-m-d H:i:s'),
                    'updated_at' =>date('Y-m-d H:i:s'),
                    'iduserCreated' =>auth()->user()->id,
                    'iduserUpdated' =>auth()->user()->id
                ];
                // dd($data);
                ComprasRequisicionDetalle::insert($data);
            }
        }

        session()->flash('success', 'La requisición se modifico correctamente');
        return redirect()->route('reqcompras.reqcompras');
    }

    public function envrequisicionrevision(Request $request)
    {
        $requisicion = ComprasRequisicion::find($request->id);
        $requisicion->op_estatus = 1;
        $requisicion->op_rechazo = 0;
        $requisicion->iduserUpdated = Auth::user()->id;
        $requisicion->save();

        return response()->json(['success' => 'Requisición enviada correctamente']);
    }

     //------------------------------------------------------------------------------------------ Revision compras

    public function reqrevisioncompras()
    {
    	$solicitante = auth()->user()->id;
    	$info_user = User::where('id', $solicitante)->first();
    	$data = ComprasRequisicion::where('id_status_delete', 1)->where('op_estatus', 1)->get();


        return view('licitaciones.requisicion-compras.revision.listado-revision-requisiciones-compras', compact('data'));   	
    }

    public function revisioncomprasver($id_requisicion)
    {
    	$solicitante = auth()->user()->id;
    	$info_user = User::where('id', $solicitante)->first();
    	$area = AreaPersonal::where('id_status_delete', 1)->get();
    	$requisicion = ComprasRequisicion::where('id', $id_requisicion)->first();
        // dd($requisicion);
    	$detalle = ComprasRequisicionDetalle::where('requisicion_compras_id', $requisicion->id)->get();

   		return view('licitaciones.requisicion-compras.revision.revision-ver-requisiciones-compras', compact('info_user', 'area', 'requisicion', 'detalle'));
    }

    public function rechazarreqcompras(Request $request)
    {

        $data = [
            'op_estatus' => 0,
            'op_rechazo' => 1,
            'motivo_rechazo'=> $request->motivo,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  

        ComprasRequisicion::where('id', $request->id_solicitud)->update($data);

        session()->flash('success', 'La requisición fue rechazada correctamente');
    	return redirect()->route('reqcompras.reqrevisioncompras');
    }

    public function validareqcompras(Request $request)
    {
        $data = [
            'op_estatus' => 2,
            'motivo_rechazo'=> $request->motivo,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  

        ComprasRequisicion::where('id', $request->id_solicitud)->update($data);

        session()->flash('success', 'La requisición fue autorizada correctamente');
    	return redirect()->route('reqcompras.reqrevisioncompras');    	
    }

}