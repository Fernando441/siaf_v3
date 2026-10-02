<?php

namespace App\Http\Controllers\Taller;

use App\Http\Controllers\Controller;
use App\Services\Folio;
use App\Services\Money;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Unidad\Unidad;
use App\Models\Unidad\Proveedor;
use App\Models\Unidad\ProveedorDireccion;
use App\Models\Unidad\ProveedorCuentas;
use App\Models\Unidad\ProveedorContacto;
use App\Models\Unidad\ProveedorTipo;
use App\Models\Proyecto\Proyecto;
use App\Models\Licitacion\Licitacion;
use App\Models\Cliente\Cliente;
use App\Models\Taller\TallerSolicitud;
use App\Models\Taller\TallerTipoSolicitud;
use App\Models\Taller\TallerSolicitudTipoDocumento;
use App\Models\Taller\TallerSolicitudDocumento;
use App\Models\Unidad\FotoUnidad;
use App\Models\Unidad\UnidadFotografia;
use App\Models\Taller\CotizacionTaller;

class DocumentosSolicitudController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function documentosSolicitud($id)
    {
        $solicitud = TallerSolicitud::find($id);
        $unidad = Unidad::find($solicitud->unidad_id);
        $tiposDocumentos = TallerSolicitudTipoDocumento::all();

        $jsonTipoDocumentos = "";
        foreach ($tiposDocumentos as $tipoDocumento) {
            $jsonTipoDocumentos .= '"' . $tipoDocumento->id . '":"' . $tipoDocumento->tipo . '",';
        }
        $jsonTipoDocumentos = '{' . rtrim($jsonTipoDocumentos, ',') . '}';

        $fotografias = UnidadFotografia::where('unidad_id', $unidad->id)->get();
        $active = UnidadFotografia::where('unidad_id', $unidad->id)->first();

        if ($active == null) {
                $ver = 0;
        } else {
                $ver = $active->id;
        }

        $cotizacion = CotizacionTaller::where('taller_solicitud_id', $solicitud->id)->get();

        return view('taller.documentos-solicitud', compact('solicitud', 'unidad', 'jsonTipoDocumentos', 'fotografias', 'active', 'ver', 'cotizacion'));
    }

    public function guardarDocumento(Request $request)
    {
        if ($request->hasfile('archivo')) {

            $archivos = $request->file('archivo');
            $colIdDocumento = $request->id_tipo_documento;
            $pathToSave = 'taller/documentos/' . $request->taller_solicitud_id . '/';

            foreach ($archivos as $indice => $archivo) {
                $archivoNombre = $archivo->hashName();
                Storage::putFileAs($pathToSave, $archivo, $archivoNombre);
                $tipo_documento = $colIdDocumento[$indice];
                $nombre = $archivo->getClientOriginalName();

                $data = [
                    'taller_solicitud_id' => $request->taller_solicitud_id,
                    'taller_solicitud_tipo_documento_id' => $tipo_documento,
                    'nombre' => $nombre,
                    'documento' => $archivoNombre,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'id_status_delete' => 1,
                    'iduserCreated' => auth()->user()->id,
                    'iduserUpdated' => auth()->user()->id
                ];

                TallerSolicitudDocumento::insert($data);
            }
        }

        if (!$request->hasfile('archivo')) {
            return redirect()->back()->with('error', 'No se ha subido ningun archivo');
        }


        // Si es un usuario de taller
        if (Auth::user()->tipo_usuario_id === 2){
            session()->flash('success', 'El documento se creo correctamente');
            return redirect()->route('taller.garage.vermantenimientos');
        } else {
            session()->flash('success', 'El documento se creo correctamente');
            return redirect()->route('taller.documentossolicitud', $request->taller_solicitud_id);
        }
    }

    public function solicitudEliminarDocumento(Request $request)
    {
        $id = $request->id;

        $archivo = TallerSolicitudDocumento::where('id', $id)->first();
        $documento = $archivo->documento;
        Storage::delete('gestordocumentos/' . $documento);
        TallerSolicitudDocumento::where('id', $id)->delete();
        $estatus = true;


        return response()->json([
            'estatus' => $estatus,
        ]);
    }

    public function documentosDatatable(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $search_arr = $request->get('search');
        $searchValue = $search_arr['value']; // Search value

        // Total records and request id match with taller_solicitud_id
        $totalRecords = TallerSolicitudDocumento::select('count(*) as allcount')->where('taller_solicitud_id', $request->id)->where('id_status_delete', 1)->count();
        $totalRecordswithFilter = TallerSolicitudDocumento::select('count(*) as allcount')->where('taller_solicitud_id', $request->id)->where('nombre', 'like', '%' . $searchValue . '%')->where('id_status_delete', 1)->count();

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

        
        $records = TallerSolicitudDocumento::select('*')
            ->where('taller_solicitud_id', $request->id)
            ->where('id_status_delete', 1)
            ->orderBy($order_column_name, $order_column_dir)
            ->skip($start)->take($rowperpage)->get();


        foreach ($columnName_arr as $indice => $columna){
            if($columna['data']=='documento'){
                if (!empty($columna['search']['value'])){
                    $valor = trim($columna['search']['value']);
                    $records = TallerSolicitudDocumento::select('*')
                        ->where('taller_solicitud_id', $request->id)
                        ->where('id', 'like', '%' .$searchValue . '%')
                        ->where('documento', 'like', '%' .$valor . '%')
                        ->where('id_status_delete', 1)
                        ->orderBy($order_column_name, $order_column_dir)
                        ->skip($start)->take($rowperpage)->get();
                }
            }
        }



        
            $data_arr = array();
            foreach($records as $record){
    
                $data_arr[] = array(
                    "id" => $record->id,
                    "documento" => $record->documento,
                    "taller_solicitud_tipo_documento_id" => $record->tallerSolicitudTipoDocumento->tipo,
                    'acciones'=>null
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

    public function getTablaDocumentos(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $search_arr = $request->get('search');
        $searchValue = $search_arr['value']; // Search value

        // Total records and request id match with taller_solicitud_id
        $totalRecords = TallerSolicitudDocumento::select('count(*) as allcount')->where('taller_solicitud_id', $request->id)->where('id_status_delete', 1)->count();
        $totalRecordswithFilter = TallerSolicitudDocumento::select('count(*) as allcount')->where('taller_solicitud_id', $request->id)->where('nombre', 'like', '%' . $searchValue . '%')->where('id_status_delete', 1)->count();

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

        
        $records = TallerSolicitudDocumento::select('*')
            ->where('taller_solicitud_id', $request->id)
            ->where('id_status_delete', 1)
            ->orderBy($order_column_name, $order_column_dir)
            ->skip($start)->take($rowperpage)->get();


        foreach ($columnName_arr as $indice => $columna){
            if($columna['data']=='documento'){
                if (!empty($columna['search']['value'])){
                    $valor = trim($columna['search']['value']);
                    $records = TallerSolicitudDocumento::select('*')
                        ->where('taller_solicitud_id', $request->id)
                        ->where('id', 'like', '%' .$searchValue . '%')
                        ->where('documento', 'like', '%' .$valor . '%')
                        ->where('id_status_delete', 1)
                        ->orderBy($order_column_name, $order_column_dir)
                        ->skip($start)->take($rowperpage)->get();
                }
            }
        }



        
            $data_arr = array();
            foreach($records as $record){
    
                $data_arr[] = array(
                    "id" => $record->id,
                    "documento" => $record->documento,
                    "taller_solicitud_tipo_documento_id" => $record->tallerSolicitudTipoDocumento->tipo,
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

    //eliminarArchivo
    public function eliminarArchivo(Request $request)
    {
        $archivo = TallerSolicitudDocumento::find($request->id);
        $archivo->id_status_delete = 2;
        $archivo->save();
        return response()->json(['success'=>'Archivo eliminado correctamente.']);
    }



    public function guardarCotizacion(Request $request)
    {


        $colIdDocumento = $request->id_documento;
        $colIdFecha = $request->fecha;
        $pathToSave = 'taller/documentos/' . $request->taller_solicitud_id . '/';
        if($request->hasfile('archivo')){

            $archivos = $request->file('archivo');
            // dd($archivos->getClientOriginalName());
            // foreach($archivos as $indice => $archivo)
            // {
                // $archivoNombre = $archivo->hashName();
                // $mimeType = $archivo->getMimeType();
                // Storage::putFileAs($pathToSave, $archivo, $archivoNombre);
                $data = [
                    'taller_solicitud_id' => $request->taller_solicitud_id,
                    'folio' => $request->folio,
                    'estatus' => 1,
                    'fecha_cotizacion'=>$request->fecha_cotizacion,
                    'subtotal' =>  $request->importe,
                    'iva' =>  $request->iva,
                    'documento' => $archivos->getClientOriginalName(),
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'iduserCreated' => auth()->user()->id,
                    'iduserUpdated' => auth()->user()->id
                ];
                // dd($data);
                CotizacionTaller::insert($data);
            // }
        }

        session()->flash('success', 'La cotización se agrego correctamente');
         return redirect()->route('taller.documentossolicitud', $request->taller_solicitud_id);

    }
}